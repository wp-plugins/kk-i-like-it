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
				
				<h2>1. Jak dodać przycisk w dowolne miejsce wewnątrz pętli WP LOOP?</h2>
				<p>Otwieramy plik, w którym chcemy dodać przycisk (np. index.php). Wewnątrz pętli WP LOOP, w miejscu, gdzie powinien się wyświetlić przycisk dodajemy fragment kodu:</p>
				<code>
				if(function_exists(kkLikeButton())){<br />
				kkLikeButton();<br />
				}
				</code>
				<p>Dodatkowo możesz wyświetlić w dowolnym miescu pętli informacje o liczbie polubień danej treści. Możesz to uczynić dodając fragment kodu:</p>
				<code>
				if(function_exists(kkLikeRating())){<br />
				kkLikeRating();<br />
				}
				</code>
				<p></p>
				
				<h2>2. Jak dodać shortcode?</h2>
				<p>W edytorze tekstu WYSIWYG (podczas edycji treści) wklej tag:</p>
				
				<code>[kklike_button]</code> - jeśli chcesz wyświetlić przycisk<br />
				lub<br />
				<code>[kklike_rating]</code> - jeśli chcesz wyświetkić informację o ilości polubień danej treści<br />
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