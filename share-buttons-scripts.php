<?php

class ButtonsScripts {

//Help method for Description

    function descr_excerpt($args=''){  
        global $post;  
        parse_str($args, $i);  
        $maxchar     = isset($i['maxchar']) ?  (int)trim($i['maxchar'])     : 350;  
        $text        = isset($i['text']) ?          trim($i['text'])        : '';  
        $save_format = isset($i['save_format']) ?   false                   : true;  
       	$echo        = isset($i['echo']) ?          true                   : false;  
  
		if (!$text) {  
            $out = $post->post_excerpt ? $post->post_excerpt : $post->post_content;  
            $out = preg_replace ("!\[/?.*\]!U", '', $out );  
  
            if( !$post->post_excerpt && strpos($post->post_content, '<!--more-->') ) {  
                preg_match ('/(.*)<!--more-->/s', $out, $match);  
                $out = str_replace("\r", '', trim($match[1]));  
                $out = preg_replace( "!\n\n+!s", "</p><p>", $out );  
                $out = str_replace ( "\n", "<br />", $out );
                if ($echo)  
                    return print $out;  
                return $out;  
            }  
        }  
  
        $out = $text.$out;  
    
        if (!$post->post_excerpt) $out = strip_tags($out);  
  
        if ( iconv_strlen($out,'utf-8') > $maxchar ) {  
            $out = iconv_substr( $out, 0, $maxchar, 'utf-8' );  
            $words = split(' ', $out ); $maxwords = count($words) - 1;  
            $out = join( ' ', array_slice($words, 0, $maxwords) ).' ...';  
        }  

        if($save_format) {  
            $out = str_replace( "\r", '', trim($out) );  
            $out = preg_replace( "!\n\n+!s", "</p><p>", $out );  
            $out = str_replace ( "\n", "<br />", $out );
        }  
  
        if ($echo) return print $out;  
            return $out;  
    }  

//Loading JS and CSS files all social share buttons
    function add_head()	{
        if (!is_admin()) {
            echo '<link rel="stylesheet" href="'.$this->plugin_url.'share-buttons-user.css" type="text/css" />';
            echo "\r\n";               
            global $post;
            $thumb = get_post_meta($post->ID, 'Thumbnail', $single = true);
            $your_logo = $this->plugin_url.'upload/uploads/logo.png';
            $absolute_path_logo = dirname(__FILE__).'/upload/uploads/logo.png';
            if($thumb!='') {
                echo '<link rel="image_src" href="'.$thumb.'" />';
                echo "\r\n";
            } else if($thumb=='' && file_exists($absolute_path_logo)) {
                echo '<link rel="image_src" href="'.$your_logo.'" />';
                echo "\r\n";
            }

            if (is_single() && $this->show_on_post || is_page() && $this->show_on_page) { 
                $descr = $this->descr_excerpt("text=$post->post_content&maxchar=300");
                $title = $post->post_title;
            }

            echo '<meta name="description" content="'.$descr.'" />';
            echo "\r\n";
            wp_enqueue_script('new_window_api_script', $this->plugin_url.'share-buttons.js');

            
            //Vkontakte.ru
            if(get_option('vkontakte_button_show')==1) {
                wp_enqueue_script('vk_share_button_api_script', 'http://vkontakte.ru/js/api/share.js?10');
            }
            if(get_option('vkontakte_like_button_show')==1) {
                wp_enqueue_script('vk_like_button_api_script', 'http://userapi.com/js/api/openapi.js?14');
            }
            //Odnoklassniki.ru
            if(get_option('odnoklassniki_button_show')==1) {
                echo '<link href="http://stg.odnoklassniki.ru/share/odkl_share.css" rel="stylesheet">';
                echo "\r\n";
                wp_enqueue_script('odkl_share_button_api_script', 'http://stg.odnoklassniki.ru/share/odkl_share.js');
            }
            //Mail.ru
            if(get_option('mailru_button_show')==1) {
                wp_enqueue_script('mailru_share_button_api_script', 'http://cdn.connect.mail.ru/js/share/2/share.js');
            } 
            //Facebook.com
            if(get_option('facebook_share_button_show')==1) {
                echo '<meta property="og:title" content="'.$title.'" /> ';
                echo "\r\n";
                echo '<meta property="og:description" content="'.$descr.'" />';
                echo "\r\n";
                if($thumb!='') {                
                    echo '<meta property="og:image" content="'.$thumb.'" />';
                    echo "\r\n";
                } else if($thumb=='' && file_exists($absolute_path_logo)) {
                    echo '<meta property="og:image" content="'.$your_logo.'" />';
                    echo "\r\n";
                }                
                wp_enqueue_script('facebook_share_button_api_script', 'http://static.ak.fbcdn.net/connect.php/js/FB.Share');
            }
            //Twitter.com
            if(get_option('twitter_button_show')==1) {
                wp_enqueue_script('twitter_button_api_script', 'http://platform.twitter.com/widgets.js');
            }               
        }
    }
        
//Including all social share buttons
    function the_button() {
    
		$mofile = dirname(__FILE__) . '/lang/' . $this->plugin_domain . '-' . get_locale() . '.mo';
		
		load_textdomain($this->plugin_domain, $mofile);        
        $button_code = "<!--Start Share Buttons-->\r\n";
            
        //Including Script Share Button Vkontakte.ru
        if(get_option('vkontakte_button_show')==1)
            include('vkontakte/vkontakte_script.php');
                          		              
        if(get_option('mailru_button_show')==1)
            include('mailru/mailru_script.php');

        if(get_option('facebook_share_button_show')==1)
            include('facebook/share/facebook_share_script.php');

        if(get_option('twitter_button_show')==1)
            include('twitter/twitter_script.php');

        if(get_option('odnoklassniki_button_show')==1)
            include('odkl/odkl_script.php');
                                                                		  
        $button_code .= "<!--End Share Buttons-->\r\n";
            
        return $button_code;
    }
    
    function the_like_button() {
		$mofile = dirname(__FILE__) . '/lang/' . $this->plugin_domain . '-' . get_locale() . '.mo';
		
		load_textdomain($this->plugin_domain, $mofile);        
     
        if(get_option('facebook_like_button_show')==1)
            include('facebook/like/facebook_like_script.php');

        if(get_option('vkontakte_like_button_show')==1)
            include('vkontakte/like/vkontakte_like_script.php');
        return $button_code;                      
    }
        
}

?>