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
				
				<h2>1. How to add a button inside a loop WP LOOP in a random place ?</h2>
				<p>In addition to that you can display the number of likes in a random place of a loop. You can do it by adding code listed below:</p>
				<code>
				if(function_exists(kkLikeButton())){<br />
				kkLikeButton();<br />
				}
				</code>
				<p>You can display anywhere in the loop, the number likes of a certain content. You can do this by adding code:</p>
				<code>
				if(function_exists(kkLikeRating())){<br />
				kkLikeRating();<br />
				}
				</code>
				<p></p>
				
				<h2>2. How to add a shortcode?</h2>
				<p>In a text editor WYSIWYG (while editing a text) paste below listed tag:</p>
				
				<code>[kklike_button]</code> -  if you'd like to display a button<br />
				or<br />
				<code>[kklike_rating]</code> -  if you'd like to display a number of likes of a certain content<br />
				<p></p>
			</div>
		</div>
		<div class="kkadmin-sidebar">
			<?php include 'menu.inc.php'; ?>
			<?php include 'sidebar.php'; ?>
		</div>
		<div class="kkclear"></div>
	</div>
	
</div>