<?php

/**
 * Ogólne ustawienia:
 */

global $kkplugin, $wersja_plugin, $wpdb;

?>

<div class="kkadmin-box">
	<div class="kkadmin-top">
		<?php include 'head.php'; ?>
	</div>
	<div class="kkadmin-content">
		<div class="kkadmin-text">
			<div class="kkadmin-text-wew">
				<h2>= 1.6.1 Hotfix =</h2>
				<ul>
					<li>FIX: Show voters after post/page content</li>
				</ul>

				<h2>= 1.6 =</h2>
				<ul>
					<li>NEW: Two widgets in administration panel with statistics</li>
					<li>NEW: Lang file (lang-kklike-xx_XX.po) for people who want to help with translation</li>
					<li>CHANGE: Updated Polish translation</li>
				</ul>

				<h2>= 1.5 =</h2>
				<ul>
					<li>NEW: Button display generator</li>
					<li>NEW: Add gravatar of persons who liked the post</li>
				</ul>

				<h2>= 1.4.1 =</h2>
				<ul>
					<li>CHANGE: Some admin design changes</li>
					<li>FIX: Custom posts list - incorrect button display</li>
				</ul>
				
				<h2>= 1.4 =</h2>
				<ul>
				    <li>NEW: [Settings] Own rating position</li>
				    <li>NEW: [Settings] KKLike only for user, button hide option</li>
				    <li>NEW: [Shortcode] Display rate button</li>
				    <li>NEW: [Shortcode] Display rating score</li>
				    <li>NEW: [Widgets] Option to choose post type</li>
				    <li>NEW: New page in the admin - documentation</li>
				    <li>NEW: New page in the admin - changelog</li>
				</ul>
				
				<h2>= 1.3.1 =</h2>
				<ul>
				    <li>NEW: [Settings] New button display option - big light</li>
				   	<li>NEW: [Settings] New button display option - big dark</li>
				    <li>CHANGE: Some admin design changes</li>
				</ul>
				
				<h2>= 1.3 =</h2>
				<ul>
				    <li>NEW: [Settings] Show numer of likes (always/after hovering cursore over the button/never show)</li>
				    <li>NEW: [Widget] Your liked (only for registered users)</li>
				    <li>NEW: [Dashboard] Most liked</li>
				    <li>NEW: [Settings] Disable likes for single pages or posts</li>
				    <li>CHANGE: Some admin design changes</li>
				</ul>
				
				<h2>= 1.2 =</h2>
				<ul>
				    <li>NEW: [Widget] Recently liked</li>
				    <li>NEW: [Widget] The most liked</li>
				    <li>NEW: [Dashboard] Recently liked</li>
				    <li>CHANGE: Some admin design changes</li>
				</ul>
				
				<h2>= 1.1.2 =</h2>
				<ul>
				    <li>CHANGE: Some admin design changes</li>
				</ul>
				
				<h2>= 1.1.1 Hotfix =</h2>
				<ul>
				    <li>FIX: Bad paths to files</li>
				</ul>
				
				<h2>= 1.1 =</h2>
				<ul>
				    <li>NEW: New, fresh admin design</li>
				    <li>FIX: Incorrect display a list of recent liked information</li>
				</ul>
				
				<h2>= 1.0 BETA =</h2>
				<ul>
					<li>NEW: Beta release</li>
				</ul>
				
			</div>
		</div>
		<div class="kkadmin-sidebar">
			<?php include 'menu.inc.php'; ?>
			<?php include 'sidebar.php'; ?>
		</div>
		<div class="kkclear"></div>
	</div>
	
</div>