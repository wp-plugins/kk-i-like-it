﻿=== KK I Like It ===
Contributors: Krzy-siek
Donate link: http://krzysztof-furtak.pl/kk-i-like-it-wordpress-plugin/
License: GNU GPL
Version: 1.7.2
Tags: like, like it, social, rating, blog, post, page, premium, free
Requires at least: 3.0
Tested up to: 3.5
Stable tag: 1.7.2

Plugin gives users or guest an option to like an article or a page.

== Description ==

**KK I Like It - PREMIUM PLUGIN FOR FREE!!!**

**This is the BETA version of the plugin so please report all problems [HERE](http://wordpress.org/support/plugin/kk-i-like-it)**

Plugin gives users or guest an option to like an article or a page.

Features:

* [Front] Option to like article/page
* [Front] Add gravatar of persons who liked the post
* [Settings] Choice of display position
* [Settings] Theme selection (2 options: dark and light)
* [Settings] Text „I like it!”
* [Settings] Text „Unlike”
* [Settings] Can only users vote?
* [Settings] Choice of content that should have the button (articles only, pages only, articles and pages)
* [Settings] Should the button display on the list of articles?
* [Settings] Show numer of likes (always/after hovering cursore over the button/never show)
* [Settings] Disable likes for single pages or posts
* [Settings] Own rating position
* [Settings] Button display generator
* [Widget] Recently liked
* [Widget] The most liked
* [Widget] Your liked (only for registered users)
* [Dashboard] Recently liked
* [Dashboard] Most liked
* [Shortcode] Display rate button
* [Shortcode] Display rating score
* [Admin] Two widgets in administration panel with statistics


More information about the plugin can be found [HERE](http://krzysztof-furtak.pl/kk-i-like-it-wordpress-plugin/) – feel free to check it out!

== Installation ==

1. Unpack files from the patch you have purchased.
2. Copy folder 'kkprogress' to a folder on your own server. To do it you might want to use programs meant for establishing connection with FTP server (personally, I would recommend FileZilla program. You can find guide on how to use it here). All the data needed for establishing connection with FTP server should go together with a purchased server.
3. Next, log in to the administrative panel of your blog.
4. Go to the tab called 'Plugins'.
5. Find plug-in called 'KKILikeIt' and click on 'Activate'
6. On the left hand side, 'KK I Like It' tab should appear. From that tab, you can manage your plug-in.

== Screenshots ==

1. Like list
2. Settings
3. Button
4. Widgets
5. Two widgets with statistics
6. Who liked this post - gavatar

== Frequently Asked Questions ==

= 1. How to add a button inside a loop WP LOOP in a random place ? =

In addition to that you can display the number of likes in a random place of a loop. You can do it by adding code listed below:
`
if(function_exists(kkLikeButton())){
kkLikeButton();
}
`
You can display anywhere in the loop, the number likes of a certain content. You can do this by adding code:
`
if(function_exists(kkLikeRating())){
kkLikeRating();
} 
`

= 2. How to add a shortcode? =

In a text editor WYSIWYG (while editing a text) paste below listed tag:

`[kklike_button]` - if you'd like to display a button
or
`[kklike_rating]` - if you'd like to display a number of likes of a certain content


== Changelog ==
= 1.7.2 =
* HOTFIX: Fatal error after activation plugin

= 1.7.1 =
* FIX: Fatal error after activation plugin
* FIX: Compatibility with other plugins
* FIX: Bugfixes for WP 3.5.x

= 1.7 = 
* NEW: [Settings] Gavatar - avatar's size adjustment option.
* NEW: [Settings] Gavatar - nick switch off ooption.
* CHANGE: Likes saving has been changed.
* CHANGE: Charts display corrected.
* FIX: Button display for certain layouts has been corrected.

= 1.6.2 =
* CHANGE: Charts library
* FIX: Translation loaded

= 1.6.1 Hotfix =
* FIX: Show voters after post content

= 1.6 =
* NEW: Two widgets in administration panel with statistics
* NEW: Lang file (lang-kklike-xx_XX.po) for people who want to help with translation
* CHANGE: Updated Polish translation

= 1.5 =
* NEW: Button display generator
* NEW: Add gravatar of persons who liked the post

= 1.4.1 =
* CHANGE: Some admin design changes
* FIX: Custom posts list - incorrect button display

= 1.4 =
* NEW: [Settings] Own rating position
* NEW: [Settings] KKLike only for user, button hide option
* NEW: [Shortcode] Display rate button
* NEW: [Shortcode] Display rating score
* NEW: [Widgets] Option to choose post type
* NEW: New page in the admin - documentation
* NEW: New page in the admin - changelog

= 1.3.1 =
* NEW: [Settings] New button display option - big light
* NEW: [Settings] New button display option - big dark
* CHANGE: Some admin design changes

= 1.3 =
* NEW: [Settings] Show numer of likes (always/after hovering cursore over the button/never show)
* NEW: [Widget] Your liked (only for registered users)
* NEW: [Dashboard] Most liked
* NEW: [Settings] Disable likes for single pages or posts
* CHANGE: Some admin design changes

= 1.2 =
* NEW: [Widget] Recently liked
* NEW: [Widget] The most liked
* NEW: [Dashboard] Recently liked
* CHANGE: Some admin design changes

= 1.1.2 =
* CHANGE: Some admin design changes

= 1.1.1 Hotfix =
* FIX: Bad paths to files

= 1.1 =
* NEW: New, fresh admin design
* FIX: Incorrect display a list of recent liked information

= 1.0 =
* NEW: Beta release


== Upgrade Notice ==

= 1.3.1 =
* NEW: [Settings] New button display option - big light
* NEW: [Settings] New button display option - big dark
* CHANGE: Some admin design changes