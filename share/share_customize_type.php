<?php

	global $post;
	$locale = substr(get_locale(),0,2);
	$title = esc_js($post->post_title);
	$url = get_permalink($post->ID);
	$via = get_option($this->pluginPrefix . 'twitter_via');
        $vk_text = __('Share',$this->plugin_domain);
	$customize_type = get_option($this->pluginPrefix . 'opt_customize_type');
	$facebook	="";
	$twitter	="";
	$mailru		="";
	$odkl		="";
	$vkontakte	="";
	$vk_type	="";
	$livejournal	="";
	$googlebuzz	="";
	$yandex		="";

	if($via!='') { $via_new='&via='.$via; } else { $via_new = ''; }

	
	if($customize_type=='original_count') {

		$mailru .= "<div class='mailru-button'><div class='mailru-fix'>";
		$mailru .= "<noindex><a rel='nofollow' title='".__('Share to MyWorld', $this->plugin_domain)."' class='mrc__share' type='button_count' href='http://connect.mail.ru/share?share_url=$url'>".__('In My World',$this->plugin_domain)."</a></noindex>";
		$mailru .= "</div></div>";

		$odkl .= "<div class='odkl-button'><div class='odkl-fix'>";
		$odkl .= "<noindex><a rel='nofollow' class='odkl-klass-stat' href='".$url."' onclick='ODKL.Share(this);return false;' ><span>0</span></a></noindex>";
		$odkl .= "</div></div>";

		$twitter .= "<div class='twitter-button'><div class='twitter-fix'>";
		$twitter .= "<noindex><a rel='nofollow' title='".__('Share to Twitter', $this->plugin_domain)."' href='http://twitter.com/share' data-url='".$url."' data-text='".$title."' class='twitter-share-button' data-count='horizontal' data-via='".$via."'>Tweet</a></noindex>";
		$twitter .= "</div></div>";

		$facebook .= "<div class=\"facebook-button\"><div class=\"facebook-fix\">";
		$facebook .= "<noindex><a rel='nofollow' title='".__('Share to Facebook', $this->plugin_domain)."' name=\"fb_share\" type=\"button_count\" share_url='".$url."'>".__('Share to FB',$this->plugin_domain)."</a></noindex>";
		$facebook .= "</div></div>";

		$livejournal .= "<div class='livejournal-button'><div class='livejournal-fix'>";
		$livejournal .= "<noindex><a rel='nofollow' title='".__('Share to LiveJournal', $this->plugin_domain)."' href=\"http://www.livejournal.com/update.bml?event=".$url."&subject=".$title."\" target=\"_blank\" name =\"livejournal\"/>";
		$livejournal .= "<img src='".$this->plugin_url."images/social/original_count/livejournal.png' /></a></noindex></div></div>";

		$googlebuzz .= "<div class='googlebuzz-button'><div class='googlebuzz-fix'>";
		$googlebuzz .= "<noindex><a rel='nofollow' title='".__('Share to Google Buzz', $this->plugin_domain)."' class=\"google-buzz-button\" href=\"http://www.google.com/buzz/post\" data-button-style=\"small-count\" data-locale='".$locale."'></a></noindex>";
		$googlebuzz .= "</div></div>";

		$yandex .= "<div class='yandex-button'><div class='yandex-fix'>";
		$yandex .= "<noindex><a rel='nofollow' title='".__('Share to Yandex', $this->plugin_domain)."' href=\"http://share.yandex.ru/go.xml?service=yaru&url=".$url."&title=".$title."\">";
		$yandex .= "<img src='".$this->plugin_url."images/social/original_count/yandex.png' /></a></noindex></div></div>";

		$googleplus .= "<div class='googleplus-button'><div class='googleplus-fix'>";
		$googleplus .= "<noindex><g:plusone size=\"medium\"></g:plusone></noindex>";
		$googleplus .= "</div></div>";

		$vk_type .= "button";
		$vkontakte .= "<div class=\"vk-button\"><div class=\"vk-fix\">\r\n";


	} else if($customize_type=='classic') {

		/* Mail.ru */
		$mailru .= "<div class='mailru-classic'>";
		$mailru .= "<noindex><a rel='nofollow' title='".__('Share to MyWorld', $this->plugin_domain)."' href=\"#mailru\" name=\"mailru\" onclick=\"new_window('http://connect.mail.ru/share?share_url=$url');\">";
		$mailru .= "<img src='".$this->plugin_url."images/social/classic/mailru.png' alt='".__('Share to MyWorld', $this->plugin_domain)."'/></a></noindex></div>";

		/* Odnoklassniki */
                $odkl .= "<div class='odkl-classic'>";
		$odkl .= "<noindex><a rel='nofollow' title='".__('Share to Odnoklassniki', $this->plugin_domain)."' href=\"#odnoklassniki\" name=\"odnoklassniki\" onclick=\"new_window('http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=$url');\">";
		$odkl .= "<img src='".$this->plugin_url."images/social/classic/odnoklassniki.png' alt='".__('Share to Odnoklassniki', $this->plugin_domain)."'/></a></noindex></div>";

		/* Tweet */
		$twitter .= "<div class='twitter-classic'>";
		$twitter .= "<noindex><a rel='nofollow' title='".__('Share to Twitter', $this->plugin_domain)."' href=\"#twitter\" name=\"twitter\" onclick=\"new_window('http://twitter.com/share?&text=$title%20-%20&url=$url$via_new');\">";
		$twitter .= "<img src='".$this->plugin_url."images/social/classic/twitter.png' alt='".__('Share to Twitter', $this->plugin_domain)."'/></a></noindex></div>";

		/* Facebook */
		$facebook .= "<div class='facebook-classic'>";
		$facebook .= "<noindex><a rel='nofollow' title='".__('Share to Facebook', $this->plugin_domain)."' href=\"#facebook\" name=\"facebook\" onclick=\"new_window('http://www.facebook.com/sharer.php?u=$url');\">";
		$facebook .= "<img src='".$this->plugin_url."images/social/classic/facebook.png' alt='".__('Share to Facebook', $this->plugin_domain)."'/></a></noindex></div>";

		$livejournal .= "<div class='livejournal-classic'>";
		$livejournal .= "<noindex><a rel='nofollow' title='".__('Share to LiveJournal', $this->plugin_domain)."' href=\"http://www.livejournal.com/update.bml?event=".$url."&subject=".$title."\" target=\"_blank\" name =\"livejournal\"/>";
		$livejournal .= "<img src='".$this->plugin_url."images/social/classic/livejournal.png' alt='".__('Share to LiveJournal', $this->plugin_domain)."'/></a></noindex></div>";


		$googlebuzz .= "<div class='googlebuzz-classic'>";
		$googlebuzz .= "<noindex><a rel='nofollow' title='".__('Share to Google Buzz', $this->plugin_domain)."' href=\"http://www.google.com/buzz/post?message=".$title."&url=".$url."\">";
		$googlebuzz .= "<img src='".$this->plugin_url."images/social/classic/googlebuzz.png' alt='".__('Share to Google Buzz', $this->plugin_domain)."'/></a></noindex></div>";

		$yandex .= "<div class='yandex-classic'>";
		$yandex .= "<noindex><a rel='nofollow' title='".__('Share to Yandex', $this->plugin_domain)."' href=\"http://share.yandex.ru/go.xml?service=yaru&url=".$url."&title=".$title."\">";
		$yandex .= "<img src='".$this->plugin_url."images/social/classic/yandex.png' /></a></noindex></div>";

		$googleplus .= "<div class='googleplus-classic'>";
		$googleplus .= "<noindex><a rel='nofollow' title='".__('Share to Google Plus', $this->plugin_domain)."' href=\"https://m.google.com/app/plus/x/?v=compose&content=".$title." - ".$url."\" onclick=\"window.open('https://m.google.com/app/plus/x/?v=compose&content=".$title." - ".$url."','gplusshare','width=450,height=300,left='+(screen.availWidth/2-225)+',top='+(screen.availHeight/2-150)+'');return false;\">";
		$googleplus .= "<img src='".$this->plugin_url."images/social/classic/googleplus.png' alt='".__('Share to Google Plus', $this->plugin_domain)."'/></a></noindex></div>";

		/* Vkontakte */
		$vk_type .= "custom";
		$vk_text = '<img src="'.$this->plugin_url.'images/social/classic/vkontakte.png" title="'.__("Share to Vkontakte", $this->plugin_domain).'" alt="'.__("Share to Vkontakte", $this->plugin_domain).'"/>';
		$vkontakte .= "<div class='vk-classic'>";

	} else if($customize_type=='mini') {

		/* Mail.ru */
		$mailru .= "<div class='mailru-mini'>";
		$mailru .= "<noindex><a rel='nofollow' title='".__('Share to MyWorld', $this->plugin_domain)."' href=\"#mailru\" name=\"mailru\" onclick=\"new_window('http://connect.mail.ru/share?share_url=$url');\">";
		$mailru .= "<img src='".$this->plugin_url."images/social/mini/mailru.png' alt='".__('Share to MyWorld', $this->plugin_domain)."'/></a></noindex></div>";

		/* Odnoklassniki */
                $odkl .= "<div class='odkl-mini'>";
		$odkl .= "<noindex><a rel='nofollow' title='".__('Share to Odnoklassniki', $this->plugin_domain)."' href=\"#odnoklassniki\" name=\"odnoklassniki\" onclick=\"new_window('http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=$url');\">";
		$odkl .= "<img src='".$this->plugin_url."images/social/mini/odnoklassniki.png' alt='".__('Share to Odnoklassniki', $this->plugin_domain)."'/></a></noindex></div>";

		/* Tweet */
		$twitter .= "<div class='twitter-mini'>";
		$twitter .= "<noindex><a rel='nofollow' title='".__('Share to Twitter', $this->plugin_domain)."' href=\"#twitter\" name=\"twitter\" onclick=\"new_window('http://twitter.com/share?&text=$title%20-%20&url=$url$via_new');\">";
		$twitter .= "<img src='".$this->plugin_url."images/social/mini/twitter.png' alt='".__('Share to Twitter', $this->plugin_domain)."'/></a></noindex></div>";

		/* Facebook */
		$facebook .= "<div class='fb-mini'>";
		$facebook .= "<noindex><a rel='nofollow' title='".__('Share to Facebook', $this->plugin_domain)."' href=\"#facebook\" name=\"facebook\" onclick=\"new_window('http://www.facebook.com/sharer.php?u=$url');\">";
		$facebook .= "<img src='".$this->plugin_url."images/social/mini/facebook.png' alt='".__('Share to Facebook', $this->plugin_domain)."'/></a></noindex></div>";

		$livejournal .= "<div class='livejournal-mini'>";
		$livejournal .= "<noindex><a rel='nofollow' title='".__('Share to LiveJournal', $this->plugin_domain)."' href=\"http://www.livejournal.com/update.bml?event=".$url."&subject=".$title."\" target=\"_blank\" name =\"livejournal\"/>";
		$livejournal .= "<img src='".$this->plugin_url."images/social/mini/livejournal.png' alt='".__('Share to LiveJournal', $this->plugin_domain)."'/></a></noindex></div>";


		$googlebuzz .= "<div class='googlebuzz-mini'>";
		$googlebuzz .= "<noindex><a rel='nofollow' title='".__('Share to Google Buzz', $this->plugin_domain)."' href=\"http://www.google.com/buzz/post?message=".$title."&url=".$url."\">";
		$googlebuzz .= "<img src='".$this->plugin_url."images/social/mini/googlebuzz.png' alt='".__('Share to Google Buzz', $this->plugin_domain)."'/></a></noindex></div>";

		$yandex .= "<div class='yandex-mini'>";
		$yandex .= "<noindex><a rel='nofollow' title='".__('Share to Yandex', $this->plugin_domain)."' href=\"http://share.yandex.ru/go.xml?service=yaru&url=".$url."&title=".$title."\">";
		$yandex .= "<img src='".$this->plugin_url."images/social/mini/yandex.png' alt='".__('Share to Yandex', $this->plugin_domain)."'/></a></noindex></div>";

		$googleplus .= "<div class='googleplus-mini'>";
		$googleplus .= "<noindex><a rel='nofollow' title='".__('Share to Google Plus', $this->plugin_domain)."' href=\"https://m.google.com/app/plus/x/?v=compose&content=".$title." - ".$url."\" onclick=\"window.open('https://m.google.com/app/plus/x/?v=compose&content=".$title." - ".$url."','gplusshare','width=450,height=300,left='+(screen.availWidth/2-225)+',top='+(screen.availHeight/2-150)+'');return false;\">";
		$googleplus .= "<img src='".$this->plugin_url."images/social/mini/googleplus.png' alt='".__('Share to Google Plus', $this->plugin_domain)."'/></a></noindex></div>";

		/* Vkontakte */
		$vk_type .= "custom";
		$vk_text = '<img src="'.$this->plugin_url.'images/social/mini/vkontakte.png" title="'.__("Share to Vkontakte", $this->plugin_domain).'" alt="'.__("Share to Vkontakte", $this->plugin_domain).'"/>';
		$vkontakte .= "<div class='vk-mini'>";

	} else if($customize_type=='soft_rect') {

		/* Mail.ru */
		$mailru .= "<div class='mailru-classic'>";
		$mailru .= "<noindex><a rel='nofollow' title='".__('Share to MyWorld', $this->plugin_domain)."' href=\"#mailru\" name=\"mailru\" onclick=\"new_window('http://connect.mail.ru/share?share_url=$url');\">";
		$mailru .= "<img src='".$this->plugin_url."images/social/soft_rect/mailru.png' alt='".__('Share to MyWorld', $this->plugin_domain)."'/></a></noindex></div>";

		/* Odnoklassniki */
                $odkl .= "<div class='odkl-classic'>";
		$odkl .= "<noindex><a rel='nofollow' title='".__('Share to Odnoklassniki', $this->plugin_domain)."' href=\"#odnoklassniki\" name=\"odnoklassniki\" onclick=\"new_window('http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=$url');\">";
		$odkl .= "<img src='".$this->plugin_url."images/social/soft_rect/odnoklassniki.png' alt='".__('Share to Odnoklassniki', $this->plugin_domain)."'/></a></noindex></div>";

		/* Tweet */
		$twitter .= "<div class='twitter-classic'>";
		$twitter .= "<noindex><a rel='nofollow' title='".__('Share to Twitter', $this->plugin_domain)."' href=\"#twitter\" name=\"twitter\" onclick=\"new_window('http://twitter.com/share?&text=$title%20-%20&url=$url$via_new');\">";
		$twitter .= "<img src='".$this->plugin_url."images/social/soft_rect/twitter.png' alt='".__('Share to Twitter', $this->plugin_domain)."'/></a></noindex></div>";

		/* Facebook */
		$facebook .= "<div class='facebook-classic'>";
		$facebook .= "<noindex><a rel='nofollow' title='".__('Share to Facebook', $this->plugin_domain)."' href=\"#facebook\" name=\"facebook\" onclick=\"new_window('http://www.facebook.com/sharer.php?u=$url');\">";
		$facebook .= "<img src='".$this->plugin_url."images/social/soft_rect/facebook.png' alt='".__('Share to Facebook', $this->plugin_domain)."'/></a></noindex></div>";

		$livejournal .= "<div class='livejournal-classic'>";
		$livejournal .= "<noindex><a rel='nofollow' title='".__('Share to LiveJournal', $this->plugin_domain)."' href=\"http://www.livejournal.com/update.bml?event=".$url."&subject=".$title."\" target=\"_blank\" name =\"livejournal\"/>";
		$livejournal .= "<img src='".$this->plugin_url."images/social/soft_rect/livejournal.png' alt='".__('Share to LiveJournal', $this->plugin_domain)."'/></a></noindex></div>";


		$googlebuzz .= "<div class='googlebuzz-classic'>";
		$googlebuzz .= "<noindex><a rel='nofollow' title='".__('Share to Google Buzz', $this->plugin_domain)."' href=\"http://www.google.com/buzz/post?message=".$title."&url=".$url."\">";
		$googlebuzz .= "<img src='".$this->plugin_url."images/social/soft_rect/googlebuzz.png' alt='".__('Share to Google Buzz', $this->plugin_domain)."'/></a></noindex></div>";

		$yandex .= "<div class='yandex'>";
		$yandex .= "<noindex><a rel='nofollow' title='".__('Share to Yandex', $this->plugin_domain)."' href=\"http://share.yandex.ru/go.xml?service=yaru&url=".$url."&title=".$title."\">";
		$yandex .= "<img src='".$this->plugin_url."images/social/soft_rect/yandex.png' alt='".__('Share to Yandex', $this->plugin_domain)."'/></a></noindex></div>";

		$googleplus .= "<div class='googleplus-classic'>";
		$googleplus .= "<noindex><a rel='nofollow' title='".__('Share to Google Plus', $this->plugin_domain)."' href=\"https://m.google.com/app/plus/x/?v=compose&content=".$title." - ".$url."\" onclick=\"window.open('https://m.google.com/app/plus/x/?v=compose&content=".$title." - ".$url."','gplusshare','width=450,height=300,left='+(screen.availWidth/2-225)+',top='+(screen.availHeight/2-150)+'');return false;\">";
		$googleplus .= "<img src='".$this->plugin_url."images/social/soft_rect/googleplus.png' alt='".__('Share to Google Plus', $this->plugin_domain)."'/></a></noindex></div>";

		/* Vkontakte */
		$vk_type .= "custom";
		$vk_text = '<img src="'.$this->plugin_url.'images/social/soft_rect/vkontakte.png" title="'.__("Share to Vkontakte", $this->plugin_domain).'" alt="'.__("Share to Vkontakte", $this->plugin_domain).'"/>';
		$vkontakte .= "<div class='vk-classic'>";

	} else if($customize_type=='soft_round') {

		/* Mail.ru */
		$mailru .= "<div class='mailru-classic'>";
		$mailru .= "<noindex><a rel='nofollow' title='".__('Share to MyWorld', $this->plugin_domain)."' href=\"#mailru\" name=\"mailru\" onclick=\"new_window('http://connect.mail.ru/share?share_url=$url');\">";
		$mailru .= "<img src='".$this->plugin_url."images/social/soft_round/mailru.png' alt='".__('Share to MyWorld', $this->plugin_domain)."'/></a></noindex></div>";

		/* Odnoklassniki */
                $odkl .= "<div class='odkl-classic'>";
		$odkl .= "<noindex><a rel='nofollow' title='".__('Share to Odnoklassniki', $this->plugin_domain)."' href=\"#odnoklassniki\" name=\"odnoklassniki\" onclick=\"new_window('http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=$url');\">";
		$odkl .= "<img src='".$this->plugin_url."images/social/soft_round/odnoklassniki.png' alt='".__('Share to Odnoklassniki', $this->plugin_domain)."'/></a></noindex></div>";

		/* Tweet */
		$twitter .= "<div class='twitter-classic'>";
		$twitter .= "<noindex><a rel='nofollow' title='".__('Share to Twitter', $this->plugin_domain)."' href=\"#twitter\" name=\"twitter\" onclick=\"new_window('http://twitter.com/share?&text=$title%20-%20&url=$url$via_new');\">";
		$twitter .= "<img src='".$this->plugin_url."images/social/soft_round/twitter.png' alt='".__('Share to Twitter', $this->plugin_domain)."'/></a></noindex></div>";

		/* Facebook */
		$facebook .= "<div class='facebook-classic'>";
		$facebook .= "<noindex><a rel='nofollow' title='".__('Share to Facebook', $this->plugin_domain)."' href=\"#facebook\" name=\"facebook\" onclick=\"new_window('http://www.facebook.com/sharer.php?u=$url');\">";
		$facebook .= "<img src='".$this->plugin_url."images/social/soft_round/facebook.png' alt='".__('Share to Facebook', $this->plugin_domain)."'/></a></noindex></div>";

		$livejournal .= "<div class='livejournal-classic'>";
		$livejournal .= "<noindex><a rel='nofollow' title='".__('Share to LiveJournal', $this->plugin_domain)."' href=\"http://www.livejournal.com/update.bml?event=".$url."&subject=".$title."\" target=\"_blank\" name =\"livejournal\"/>";
		$livejournal .= "<img src='".$this->plugin_url."images/social/soft_round/livejournal.png' alt='".__('Share to LiveJournal', $this->plugin_domain)."'/></a></noindex></div>";


		$googlebuzz .= "<div class='googlebuzz-classic'>";
		$googlebuzz .= "<noindex><a rel='nofollow' title='".__('Share to Google Buzz', $this->plugin_domain)."' href=\"http://www.google.com/buzz/post?message=".$title."&url=".$url."\">";
		$googlebuzz .= "<img src='".$this->plugin_url."images/social/soft_round/googlebuzz.png' alt='".__('Share to Google Buzz', $this->plugin_domain)."'/></a></noindex></div>";

		$yandex .= "<div class='yandex-classic'>";
		$yandex .= "<noindex><a rel='nofollow' title='".__('Share to Yandex', $this->plugin_domain)."' href=\"http://share.yandex.ru/go.xml?service=yaru&url=".$url."&title=".$title."\">";
		$yandex .= "<img src='".$this->plugin_url."images/social/soft_round/yandex.png' alt='".__('Share to Yandex', $this->plugin_domain)."'/></a></noindex></div>";

		$googleplus .= "<div class='googleplus-classic'>";
		$googleplus .= "<noindex><a rel='nofollow' title='".__('Share to Google Plus', $this->plugin_domain)."' href=\"https://m.google.com/app/plus/x/?v=compose&content=".$title." - ".$url."\" onclick=\"window.open('https://m.google.com/app/plus/x/?v=compose&content=".$title." - ".$url."','gplusshare','width=450,height=300,left='+(screen.availWidth/2-225)+',top='+(screen.availHeight/2-150)+'');return false;\">";
		$googleplus .= "<img src='".$this->plugin_url."images/social/soft_round/googleplus.png' alt='".__('Share to Google Plus', $this->plugin_domain)."'/></a></noindex></div>";

		/* Vkontakte */
		$vk_type .= "custom";
		$vk_text = '<img src="'.$this->plugin_url.'images/social/soft_round/vkontakte.png" title="'.__("Share to Vkontakte", $this->plugin_domain).'" alt="'.__("Share to Vkontakte", $this->plugin_domain).'"/>';
		$vkontakte .= "<div class='vk-classic'>";
	}

		$vkontakte .="<script type=\"text/javascript\">\r\n<!--\r\ndocument.write(VK.Share.button(\r\n{\r\n";
		$vkontakte .= "  url: '$url',\r\n";
		$vkontakte .= "  title: '$title',\r\n";
		$vkontakte .= "  description: '$descr'";
		$vkontakte .= $noparse == 'true' ? ",\r\n  noparse: $noparse \r\n}, \r\n{\r\n" : "  \r\n}, \r\n{\r\n";
		$vkontakte .= "  type: '$vk_type',\r\n";      
		$vkontakte .= "  text: '$vk_text'\r\n}));";
		$vkontakte .= "\r\n-->\r\n</script></div>\r\n";

	if($customize_type=='original_count') {
		$vkontakte .= "</div>";
	}


	$array_buttons = array();
	$temp = array();

	$array_buttons = array('facebook'=>$facebook,'googlebuzz'=>$googlebuzz, 'googleplus'=>$googleplus, 'livejournal'=>$livejournal,'mailru'=>$mailru,'odnoklassniki'=>$odkl,'twitter'=>$twitter,'vkontakte'=>$vkontakte,'yandex'=>$yandex);

	$btnsort=0;
	$btnsort = get_option($this->pluginPrefix . 'buttons_sort');
	$btnsort = explode(',',$btnsort);

	$show = get_option($this->pluginPrefix . 'buttons_show');
	if(@array_key_exists(0, $show)==false) {
		$show = explode(',',$show);
	}

	asort($btnsort);

	$btnsort=array_flip($btnsort);

	for($i=0;$i<count($this->social_name);$i++) {

		if(!in_array($this->social_name[$i],$show)) {
			unset($array_buttons[$this->social_name[$i]]);
			unset($btnsort[$this->social_name[$i]]);
		}
	}
	$c=array_combine($btnsort,$array_buttons);
	ksort($c);

	$button_code.=implode('',$c);
?>