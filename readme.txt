=== Social Share Buttons for WordPress ===
Contributors: Loskutnikov Artem (artlosk)
Donate link: http://sbuttons.ru/donate-ru/ and http://sbuttons.ru/donate-en/
Tags: social, network, jquery, share buttons, social buttons, facebook, googlebuzz, livejournal, mailru, odnoklassniki, twitter, vkontakte, yandex,
Requires at least: 2.8
Tested up to: 3.2
Stable tag: 2.6

The Share buttons, it is plugin for social networks. The plugin supports 9 social networking.

== Description ==

The Share buttons, it is plugin for social networks. The plugin supports 9 social networking. 
There are Vkontakte, Odnoklassniki.ru, Mail.ru, LiveJournal, Yandex russian social buttons and there are Facebook, Twitter, Google-Buzz, Google-Plus english social buttons. 
Settings include show/hide buttons, sort buttons, position buttons and e.t.c.
This plugin is written using AJAX and Jquery. The plugin supports 2 languages: English and Russian

[FAQ]
-RUS (http://sbuttons.ru/tutorial-ru/installation-ru/)
-ENG (http://sbuttons.ru/tutorial-en/installation-en/) 

== Languages ==

* English - default
* Russina(ru_RU)

== Installation ==

1. Unzip the file
2. Upload it to wp-content/plugins
3. Activate it from the plugins section
4. Go to the FTP "wp-content/plugins/share_buttons/upload/ and change chmod folder "/UPLOADS/". Your logo will store in this folder.
NOTE:
or upload via FTP manually

== Screenshots ==

1. Upload picture for site-logo
2. Sort Buttons, Choose style, Enable/Disabled buttons
3. Margins top and bottom
4. Header text before social buttons
5. Position Share Buttons
6. Twitter via "@"
7. Like button - Vkontakte
8. Like button - Facebook
9. Like button - Mailru
== Changelog ==

[2.6]

- Add Yandex button
- Add Google Plus button (test mode)
- Optimize code and database (add options 'buttons_sort' and 'buttons_show' instead of twitter_show, facebook_show and e.t.c)
- Delete Original and Original Count styles (I think they are not needed)
- Add Mini style
- Fix problem library mb_string
- Fix buttons border
- Change sort for social buttons
- Fix display buttons in Page, Post, Home
- Add display buttons in Category, in Tags, in Archive
- Fix <nofollow> and <noindex>
- Add Margins top and bottom for block social buttons

[2.5]

- Add Livejournal button
- Add Google-Buzz button
- Create Site for this plugin http://sbuttons.ru
- Update russian language
- Add text before social buttons
- Change Sort
and e.t.c (few changes)

[2.2]

Fixed output "Like button for Vkontakte" when displayed in loop of posts. 
Now the button's container with a unique ID, for example &lt;div&gt; id='vk_like_$post->ID'>&lt;/div&gt;

[2.1]

Fixed URL for page

[2.0]

- Fixed upload file "logo.png"
- Fixed output description and title
- Fixed Facebook button with count
- Optimized plugin
- Change interface
- Change structure folder, files and php code
- Add fieldset "Sorting buttons"
- Add 6 pack icons
- Add Mail.ru button "Like"
- Add Share Buttons for Frontend(Home page)

[1.2.2]

Fixed get url for twitter, mailru buttons.
"$url = get_permalink($post->ID);"

[1.2.1]
Fixed output <meta>. Output without html.

if upload logo is failed, please, change chmod folder "uploads" and chmod file "logo.png" to upload logo for stie
or upload via FTP manually (this script while in the process)

[1.2]
 - Previously, the plugin inscribe title and description, which was introduced Platinum SEO Pack plugin and like it. Now the plugin takes from post and cuts 300 characters to description. <meta name="description" content="$description" />
 - Optimized scripts social networking.

[1.1]
Fixed upload logo

[1.0]
Plugin release.

== Feature ==
- Add many share buttons
- Create special site for this plugin