<?php
/*
	Plugin Name: Social Share Buttons
	Plugin URI: http://sbuttons.ru
	Description: The plugin implements the API function socials networks that adds the link share buttons.
	Donate link: http://sbuttons.ru/donate-ru/ and http://sbuttons.ru/donate-en/
	Author: Loskutnikov Artem
	Version: 2.6.1
	Author URI: http://artlosk.com/
	License: GPL2
*/

/*
	Copyright 2010 Loskutnikov Artem (artlosk) (email: artlosk at gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

*/

?>
<?php
	require_once('share-buttons-scripts.php');
	if (!class_exists('ShareButtons')) :

	class ShareButtons extends ButtonsScripts {
		var $plugin_url;
		var $plugin_path;
		var $plugin_domain = 'share_buttons';
		var $pluginVersion = '2.6.1';
		var $pluginPrefix = 'sbuttons_';

		var $exclude; // IDs of excluding pages and posts
		var $show_on_post;
		var $show_on_page;
		var $show_on_home;
		var $margin_top;
		var $margin_bottom;

		var $logo_share;

		var $customize_type;

		var $vkontakte_like_api;
		var $vkontakte_like_show;
		var $vkontakte_like_verb;
		var $vkontakte_like_type;

		var $mailru_like_faces;
		var $mailru_like_width;
		var $mailru_like_show_text;
		var $mailru_like_verb;
		var $mailru_like_show;

		var $facebook_like_show;
		var $facebook_like_layout;
		var $facebook_like_color;
		var $facebook_like_faces;
		var $facebook_like_width;
		var $facebook_like_height;
		var $facebook_like_verb;


		var $buttons_show;
		var $buttons_sort;

		var $twitter_via;
		var $parsing_images;

		var $header_text;

	function __construct() {

		define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
		define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
		$this->plugin_path = WP_PLUGIN_DIR.'/'.dirname(plugin_basename(__FILE__));
		$this->plugin_url = trailingslashit(WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)));
		// Check version
		global $wp_version;

		// Load translation only on admin pages
		if (is_admin())
			$this->load_domain();

		$exit_msg = __('Share buttons plugin requires Wordpress 2.8 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>', $this->plugin_domain);

		if (version_compare($wp_version,"2.8","<")) {
			exit ($exit_msg);
		}
		// Installation
		register_activation_hook(__FILE__, array(&$this, 'install'));
		//Deinstallation
		register_deactivation_hook( __FILE__, array(&$this, 'uninstall') );


		add_action('init', array(&$this, 'install'));
		// Register options settings
		add_action('admin_init', array(&$this, 'register_settings'));
		// Create custom plugin settings menu
		add_action('admin_menu', array(&$this, 'create_menu'));
		// add vk api scripts to head
		add_action('wp_print_scripts', array(&$this, 'add_head'));
		// Filter for processing button placing
		add_filter('the_content', array(&$this, 'place_button'));
		add_filter('the_excerpt', array(&$this, 'place_button'));
		// Shortcode
		add_shortcode('share-buttons', array(&$this, 'the_button'));

		$this->exclude = get_option('share_buttons_exclude');

		$this->show_on_post = get_option($this->pluginPrefix . 'show_on_posts');
		$this->show_on_page = get_option($this->pluginPrefix . 'show_on_pages');
		$this->show_on_home = get_option($this->pluginPrefix . 'show_on_home');
		$this->margin_top = get_option($this->pluginPrefix . 'margin_top');
		$this->margin_bottom = get_option($this->pluginPrefix . 'margin_bottom');


		$this->customize_type = get_option($this->pluginPrefix . 'opt_customize_type');


		$this->vkontakte_like_api = get_option($this->pluginPrefix . 'vkontakte_like_api');
		$this->vkontakte_like_show = get_option($this->pluginPrefix . 'vkontakte_like_button_show');
		$this->vkontakte_like_type = get_option($this->pluginPrefix . 'vkontakte_like_type');
		$this->vkontakte_like_verb = get_option($this->pluginPrefix . 'vkontakte_like_verv');


		$this->facebook_like_show = get_option($this->pluginPrefix . 'facebook_like_button_show');
		$this->facebook_like_layout = get_option($this->pluginPrefix . 'facebook_like_layout');
		$this->facebook_like_color = get_option($this->pluginPrefix . 'facebook_like_color');
		$this->facebook_like_faces = get_option($this->pluginPrefix . 'facebook_like_faces');
		$this->facebook_like_width = get_option($this->pluginPrefix . 'facebook_like_width');
		$this->facebook_like_height = get_option($this->pluginPrefix . 'facebook_like_height');
		$this->facebook_like_verb = get_option($this->pluginPrefix . 'facebook_like_verb');

		$this->mailru_like_faces = get_option($this->pluginPrefix . 'mailru_like_faces');
		$this->mailru_like_width = get_option($this->pluginPrefix . 'mailru_like_width');
		$this->mailru_like_show_text = get_option($this->pluginPrefix . 'mailru_like_show_text');
		$this->mailru_like_verb = get_option($this->pluginPrefix . 'mailru_like_verb');
		$this->mailru_like_show = get_option($this->pluginPrefix . 'mailru_like_button_show');

		$this->buttons_show = get_option($this->pluginPrefix . 'buttons_show');
		$this->buttons_sort = get_option($this->pluginPrefix . 'buttons_sort');
		$this->twitter_via = get_option($this->pluginPrefix . 'twitter_via');
		$this->parsing_images = get_option($this->pluginPrefix . 'opt_parsing_images');

		$this->logo_share = get_option($this->pluginPrefix . 'logo_share');

		$this->header_text = get_option($this->pluginPrefix . 'header_text');



	}



	function install() {
		//create options

		$this->fix_install_old_ver();

		add_option($this->pluginPrefix . 'position', 'left');
		add_option($this->pluginPrefix . 'vposition', 'bottom');

		add_option($this->pluginPrefix . 'show_on_posts', TRUE);
		add_option($this->pluginPrefix . 'show_on_pages', TRUE);
		add_option($this->pluginPrefix . 'show_on_home', TRUE);

		add_option($this->pluginPrefix . 'margin_top', '0');
		add_option($this->pluginPrefix . 'margin_bottom', '5');

		add_option($this->pluginPrefix . 'noparse', 'true');
		add_option($this->pluginPrefix . 'exclude', '');

		add_option($this->pluginPrefix . 'opt_customize_type','classic');

		add_option($this->pluginPrefix . 'vkontakte_like_api','');
		add_option($this->pluginPrefix . 'vkontakte_like_button_show', FALSE);
		add_option($this->pluginPrefix . 'vkontakte_like_type','full');
		add_option($this->pluginPrefix . 'vkontakte_like_verb', 'Мне нравится');

		add_option($this->pluginPrefix . 'mailru_like_faces', FALSE);
		add_option($this->pluginPrefix . 'mailru_like_width', 550);
		add_option($this->pluginPrefix . 'mailru_like_show_text',FALSE);
		add_option($this->pluginPrefix . 'mailru_like_verb', 'Нравится');
		add_option($this->pluginPrefix . 'mailru_like_button_show', FALSE);

		add_option($this->pluginPrefix . 'facebook_like_button_show', FALSE);
		add_option($this->pluginPrefix . 'facebook_like_layout', 'standart');
		add_option($this->pluginPrefix . 'facebook_like_color', 'light');
		add_option($this->pluginPrefix . 'facebook_like_faces', FALSE);
		add_option($this->pluginPrefix . 'facebook_like_width', 450);
		add_option($this->pluginPrefix . 'facebook_like_height', 30);
		add_option($this->pluginPrefix . 'facebook_like_verb', 'like');


		add_option($this->pluginPrefix . 'buttons_sort', 'facebook,googlebuzz,googleplus,livejournal,mailru,odnoklassniki,twitter,vkontakte,yandex');
		add_option($this->pluginPrefix . 'buttons_show', $this->social_name);


		add_option($this->pluginPrefix . 'twitter_via','');
		add_option($this->pluginPrefix . 'opt_parsing_images',TRUE);

		add_option($this->pluginPrefix . 'logo_share', 'logo.png');
		add_option($this->pluginPrefix . 'header_text','Поделиться в соц. сетях');

		add_option( $this->pluginPrefix . 'version', $this->pluginVersion, '', 'yes' ); // for backward-compatiblity checks


	}

	function fix_install_old_ver() {

		if(get_option($this->pluginPrefix. 'version')==false) {
			delete_option('share_buttons_position');
			delete_option('share_buttons_vposition');

			delete_option('share_buttons_show_on_posts');
			delete_option('share_buttons_show_on_pages');
			delete_option('share_buttons_show_on_home');

			delete_option('share_buttons_noparse');
			delete_option('share_buttons_exclude');

			delete_option('opt_customize_type');

			delete_option('vkontakte');
			delete_option('mailru');
			delete_option('facebook');
			delete_option('odnoklassniki');
			delete_option('twitter');
			delete_option('livejournal');
			delete_option('googlebuzz');

			delete_option('vkontakte_like_api');
			delete_option('vkontakte_like_button_show');
			delete_option('vkontakte_like_type');
			delete_option('vkontakte_like_verb');

			delete_option('mailru_like_faces');
			delete_option('mailru_like_width');
			delete_option('mailru_like_show_text');
			delete_option('mailru_like_verb');
			delete_option('mailru_like_button_show');

			delete_option('facebook_like_button_show');
			delete_option('facebook_like_layout');
			delete_option('facebook_like_color');
			delete_option('facebook_like_faces');
			delete_option('facebook_like_width');
			delete_option('facebook_like_height');
			delete_option('facebook_like_verb');

			delete_option('vkontakte_button_show');
			delete_option('mailru_button_show');
			delete_option('facebook_button_show');
			delete_option('odnoklassniki_button_show');
			delete_option('twitter_button_show');
			delete_option('livejournal_button_show');
			delete_option('google_button_show');


			delete_option('twitter_via');
			delete_option('opt_parsing_images');

			delete_option('logo_share');
			delete_option('header_text');

			delete_option('margin_top');
			delete_option('margin_bottom');
			delete_option('buttons_sort');
			delete_option('buttons_show');


		}
	}


	function uninstall() {

		if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') ) {
			exit();
		}


		delete_option($this->pluginPrefix . 'position');
		delete_option($this->pluginPrefix . 'vposition');

		delete_option($this->pluginPrefix . 'show_on_posts');
		delete_option($this->pluginPrefix . 'show_on_pages');
		delete_option($this->pluginPrefix . 'show_on_home');

		delete_option($this->pluginPrefix . 'margin_top');
		delete_option($this->pluginPrefix . 'margin_bottom');

		delete_option($this->pluginPrefix . 'noparse');
		delete_option($this->pluginPrefix . 'exclude');

		delete_option($this->pluginPrefix . 'opt_customize_type');

		delete_option($this->pluginPrefix . 'vkontakte_like_api');
		delete_option($this->pluginPrefix . 'vkontakte_like_button_show');
		delete_option($this->pluginPrefix . 'vkontakte_like_type');
		delete_option($this->pluginPrefix . 'vkontakte_like_verb');

		delete_option($this->pluginPrefix . 'mailru_like_faces');
		delete_option($this->pluginPrefix . 'mailru_like_width');
		delete_option($this->pluginPrefix . 'mailru_like_show_text');
		delete_option($this->pluginPrefix . 'mailru_like_verb');
		delete_option($this->pluginPrefix . 'mailru_like_button_show');

		delete_option($this->pluginPrefix . 'facebook_like_button_show');
		delete_option($this->pluginPrefix . 'facebook_like_layout');
		delete_option($this->pluginPrefix . 'facebook_like_color');
		delete_option($this->pluginPrefix . 'facebook_like_faces');
		delete_option($this->pluginPrefix . 'facebook_like_width');
		delete_option($this->pluginPrefix . 'facebook_like_height');
		delete_option($this->pluginPrefix . 'facebook_like_verb');


		delete_option($this->pluginPrefix . 'buttons_sort');
		delete_option($this->pluginPrefix . 'buttons_show');


		delete_option($this->pluginPrefix . 'twitter_via');
		delete_option($this->pluginPrefix . 'opt_parsing_images');

		delete_option($this->pluginPrefix . 'logo_share');
		delete_option($this->pluginPrefix . 'header_text');
		delete_option( $this->pluginPrefix . 'version');

	}



	function register_settings() {
		//register our settings

		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'position' );
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'vposition' );

		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'show_on_posts' );
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'show_on_pages' );
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'show_on_home' );

		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'margin_top' );
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'margin_bottom' );

		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'exclude' );

		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'opt_customize_type' );

		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'vkontakte_like_api' );
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'vkontakte_like_button_show' );
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'vkontakte_like_type');
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'vkontakte_like_verb');

		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'mailru_like_faces' );
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'mailru_like_width' );
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'mailru_like_show_text');
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'mailru_like_verb');
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'mailru_like_button_show');

		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'facebook_like_button_show' );
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'facebook_like_layout');
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'facebook_like_color');
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'facebook_like_faces');
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'facebook_like_width');
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'facebook_like_height');
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'facebook_like_verb');

		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'buttons_show');

		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'twitter_via');
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'opt_parsing_images');

		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'logo_share');
		register_setting($this->pluginPrefix . 'settings', $this->pluginPrefix . 'header_text');
	}

// Add options page
	function create_menu() 	{
		//create new menu in Settings section
		add_options_page(__('Share Buttons Plugin Settings', $this->plugin_domain), __('Share Buttons', $this->plugin_domain), 'administrator', __FILE__, array(&$this, 'settings_page'));
	}

// Settings page
	function settings_page() {
		$customize_type = get_option($this->pluginPrefix . 'opt_customize_type');

		$fb_like_layout = get_option($this->pluginPrefix . 'facebook_like_layout');
		$fb_like_color = get_option($this->pluginPrefix . 'facebook_like_color');
		$fb_like_verb = get_option($this->pluginPrefix . 'facebook_like_verb');
		$vk_like_verb = get_option($this->pluginPrefix . 'vkontakte_like_verb');
		$mr_like_verb = get_option($this->pluginPrefix . 'mailru_like_verb');
		$sb_pos = get_option($this->pluginPrefix . 'position');
		$sb_vpos = get_option($this->pluginPrefix . 'vposition');
		include('share-buttons-options.php');
	}


	function place_button($content) {
		// Here we place button on the page
		global $post;
		$exclude_ids = explode(",", $this->exclude);

		// Looking for exclusion
		foreach($exclude_ids as $id)
			if ($post->ID == $id)
				return $content;

		$get_share_buttons = $this->the_button();
		$get_like_buttons = $this->the_like_button();
		$pos = get_option($this->pluginPrefix . 'position');
		$vpos = get_option($this->pluginPrefix . 'vposition');
                print_r(get_option($this->pluginPrefix));
		$share_buttons = '<div style="clear:both;"></div>';

		$like_buttons = '<div style="clear:both;"></div>';

		if(!empty($this->header_text)) {
			$share_buttons .= '<div class="header_text"><h3>'.$this->header_text.'</h3></div>';
		}

		if ($pos == 'right') {
		// right alignment
			$share_buttons .= "<div name=\"#\" class=\"buttons_share\" style=\"float: $pos; margin-top:".$this->margin_top."px; margin-bottom:".$this->margin_bottom."px;\">\r\n$get_share_buttons\r\n</div><div style=\"clear:both;\"></div>";
		} else {		
		// left alignment
			$share_buttons .= "<div name=\"#\" class=\"buttons_share\" style=\"float: $pos; margin-top:".$this->margin_top."px; margin-bottom:".$this->margin_bottom."px;\">\r\n$get_share_buttons\r\n</div><div style=\"clear:both;\"></div>";
		}

		$like_buttons .= "<div name=\"#\" style=\"float: left;\">\r\n$get_like_buttons\r\n</div><div style=\"clear:both;\"></div>";

		if (is_single() && $this->show_on_post || is_page() && $this->show_on_page || is_home() && $this->show_on_home) {
			if ($vpos == 'top') {
			// place button before post
				return $share_buttons . $content . $like_buttons;
			} else {
			// after post
				return $content . $share_buttons . $like_buttons;
			}


		}

		return $content;

	}

// Localization support
	function load_domain() {
		$mofile = dirname(__FILE__) . '/lang/' . $this->plugin_domain . '-' . get_locale() . '.mo';
		load_textdomain($this->plugin_domain, $mofile);
	}

	}
	else :

		exit(__('Class Share Buttons already declared!', $this->plugin_domain));

	endif;

	if (class_exists('ShareButtons')) :
		$ShareButtons = new ShareButtons();
	endif;
