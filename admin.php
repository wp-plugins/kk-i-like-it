<?php
/*
  Plugin Name: KK I Like It
  Plugin URI: http://krzysztof-furtak.pl/kk-i-like-it-wordpress-plugin/
  Description: Plugin gives users or guest an option to like an article or a page.
  Version: 1.4.1
  Author: Krzysztof Furtak
  Author URI: http://krzysztof-furtak.pl
 */

add_action('init', 'kklike_load_translation');
require_once ('db.php');

require_once('prezentacja.php');
require_once('config.inc.php');

require_once ('ajax.php');
require_once ('meta.php');

function kklike_load_translation() {
    $lang = get_locale();
    if (!empty($lang)) {
        $moFile = dirname(plugin_basename(__FILE__)) . "/lang";
        $moKat = dirname(plugin_basename(__FILE__));

        load_plugin_textdomain("lang-kklike", false, $moFile);
    }
}

global $wp_options;
$wp_options = get_option('kklikesettings');

function frontend_ajaxurl() {
global $wp_options;
?>
<script type="text/javascript">
	var likeText = '<?php echo $wp_options['like_text']; ?>';
	var unlikeText = '<?php echo $wp_options['unlike_text']; ?>';
</script>
<?php
}
add_action('wp_head','frontend_ajaxurl');

function kklike_admin_enqueue_scripts(){
	
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
  	
  	wp_register_script('kklike-ui-widget-js', WP_PLUGIN_URL .'/kk-i-like-it/js/jquery-ui.custom.js', array('jquery-ui-core'), '1.5');
	wp_enqueue_script('kklike-ui-widget-js');
	
	wp_enqueue_style('kklike-css', WP_PLUGIN_URL .'/kk-i-like-it/css/kklike.css?v=1.5');
	wp_enqueue_style('kklike-afront-css', WP_PLUGIN_URL .'/kk-i-like-it/css/kklike-front.css?v=1.5');
	
	wp_register_script('kklike-js', WP_PLUGIN_URL .'/kk-i-like-it/js/admin.js', array('jquery'), '1.5');
	wp_enqueue_script('kklike-js');
	    
    /* ============= CHECKBOX PLUGIN ============= */
    wp_register_script('kklike-checkbox', WP_PLUGIN_URL .'/kk-i-like-it/js/iphone-style-checkboxes.js', array('jquery'), '1.5');
    wp_enqueue_script('kklike-checkbox');
    wp_enqueue_style('kklike-checkbox-css', WP_PLUGIN_URL .'/kk-i-like-it/css/iphone-style-checkboxes-css.css');
    
    /* ============= ColorPicker PLUGIN ============= */
    wp_enqueue_style('kklike-admin-css-color', WP_PLUGIN_URL .'/kk-i-like-it/css/colorpicker.css');
    wp_register_script('kklike-admin-color', WP_PLUGIN_URL .'/kk-i-like-it/js/colorpicker.js', array('jquery'), '1.5');
    wp_enqueue_script('kklike-admin-color');
    
	/* ============= JS COOKIE PLUGIN ============= */
	wp_register_script('kklike-admin-cookie', WP_PLUGIN_URL .'/kk-i-like-it/js/jquery.cookie.js', array('jquery'), '1.5');
    wp_enqueue_script('kklike-admin-cookie');
    
    wp_enqueue_style('kklike-jquery-ui-css', WP_PLUGIN_URL .'/kk-i-like-it/css/black-tie/jquery-ui.custom.css?v=1.5');
	
	/* ============= Tooltip PLUGIN ============= */
	wp_enqueue_style('kklike-css-tip', WP_PLUGIN_URL .'/kk-i-like-it/css/jquery.qtip.css');
	wp_register_script('kklike-tip', WP_PLUGIN_URL .'/kk-i-like-it/js/jquery.qtip.min.js', array('jquery'), '1.5');
	wp_enqueue_script('kklike-tip');
}

function kklike_enqueue_scripts(){
   	wp_enqueue_script('jquery');
   	
	wp_enqueue_style('kklike-front-css', WP_PLUGIN_URL .'/kk-i-like-it/css/kklike-front.css?v=1.5');
	
	wp_register_script('kklike-front-js', WP_PLUGIN_URL .'/kk-i-like-it/js/kklike-front.js', array('jquery'), '1.5');
	wp_enqueue_script('kklike-front-js');
	
	// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
	wp_localize_script( 'kklike-front-js', 'kkajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

add_action('init', 'kklike_enqueue_scripts');
add_action('admin_enqueue_scripts', 'kklike_admin_enqueue_scripts');

// remove_filter('the_content', 'wpautop');
// function wpautopnobr($content) {
	// return wpautop($content, false);
// }
// add_filter('the_content', 'wpautopnobr');

function kkLikeRating($ret = false){
	global $post;
	$db = new kkDataBase;
	$rating = $db->getPostRating($post->ID);
	
	if($ret){
  		return $rating;
  	}else{
  		echo $rating;
	}
}

function kkLikeButton($ret = false) {
	global $post;
	global $wp_options;
	clean_post_cache( $post->ID );
	
	if($wp_options['button_place'] == 'page'){
		$warunek = is_page();
	}elseif($wp_options['button_place'] == 'post'){
		$warunek = is_single();
	}else{
		$warunek = TRUE;
	}
	
	if(is_home()){
		if($wp_options['button_in_home'] == 'on' && ($wp_options['button_place'] == 'post' || $wp_options['button_place'] == 'both')){
			$warunek = TRUE;
		}else{
			$warunek = FALSE;
		}
	}

	$disableButton = get_post_meta($post->ID, 'post_display_likes_button_value', true);
	
	if(!$warunek || $disableButton == 'on'){
		return $content;
	}
	
	if(!is_user_logged_in() && $wp_options['show_guest'] != 'on'){
		return FALSE;
	}
	
	
	$db = new kkDataBase;
	
	if(empty($wp_options['show_rating']) || $wp_options['show_rating'] == 'always'){
		$rating = $db->getPostRating($post->ID, 'post');
		$classRating = '';
		$boxRating = '';
	}else if($wp_options['show_rating'] == 'hover'){
		$rating = $db->getPostRating($post->ID, 'post');
		$classRating = 'kklike-rating-none';
		$boxRating = 'kklike-rating-hover';		
	}else{
		$rating = '';
		$classRating = 'kklike-rating-none';
		$boxRating = '';		
	}
	
	$isLike = $db->checkIsLike($post->ID, 'post');
	$userRate = $db->checkUserRating($isLike, get_current_user_id(), $_SERVER['REMOTE_ADDR']);
	$act = '';
	
	if($userRate == '0'){
		$act = 'like';
		$text = $wp_options['like_text'];
	}else{
		$act = 'unlike';
		$text = $wp_options['unlike_text'];
	}
	
	$class = 'kk-left';
	
	if($wp_options['only_users'] == 'on'){
		$onlyUser = '1';
	}else{
		$onlyUser = '0';
	}

	if($wp_options['own_button_type'] != 'on'){
		
	  	$kklike = '
			<div class="kklike-content '.$wp_options['button_type'].'">
		  		<a href="#" class="kklike-box '.$class.' '.$boxRating.'" rel="kklike-'. $post->ID .'">
		  			<input type="hidden" class="kklike-id" value="'.$post->ID.'" />
		  			<input type="hidden" class="kklike-type" value="post" />
		  			<input type="hidden" class="kklike-action" value="' . $act . '" />
		  			<input type="hidden" class="kklike-ou" value="'. $onlyUser .'" />
					<span class="kklike-ico"></span> 
					<span class="kklike-value '. $classRating .'">' . $rating . '</span>
					<span class="kklike-text">' . $text . '</span>
				</a>
				<div class="kkclear"></div>
			</div>
	 	';

 	}else{

 		$kklike = '
		<div class="kklike-content">
			<span style="display: none;">|||||</span>
		  		<a href="#" class="kklike-box '.$class.' '.$boxRating.'" style="border-radius: '.$wp_options['button_round_corners'].'px; font-size: '.$wp_options['button_font_size'].'px;color: #'.$wp_options['button_text_color'].'; background: #'.$wp_options['button_color'].'; border: '.$wp_options['button_border_size'].'px solid #'.$wp_options['button_border_color'].';" rel="kklike-'. $post->ID .'">
		  			<input type="hidden" class="kklike-id" value="'.$post->ID.'" />
		  			<input type="hidden" class="kklike-type" value="post" />
		  			<input type="hidden" class="kklike-action" value="' . $act . '" />
		  			<input type="hidden" class="kklike-ou" value="'. $onlyUser .'" />
					<span class="kklike-ico" style="background: transparent; width: auto; height: auto;">
						<img src="' . WP_PLUGIN_URL . '/kk-i-like-it/images/' . $wp_options['button_heart_img'] . '.png" alt="Like It" />
					</span> 
					<span class="kklike-value '. $classRating .'" style="border-right: '.$wp_options['button_border_size'].'px solid #'.$wp_options['button_border_color'].'; border-left: '.$wp_options['button_border_size'].'px solid #'.$wp_options['button_border_color'].';">' . $rating . '</span>
					<span class="kklike-text">' . $text . '</span>
				</a>
			<span style="display: none;">|||||</span>
			<div class="kkclear"></div>
		</div>
	 	';

 	}
	
  	if($ret){
  		return $kklike;
  	}else{
  		echo $kklike;
	}
	
}

function addKKLikeButton($content) {
	global $post;
	global $wp_options;
	clean_post_cache( $post->ID );
	
	if($wp_options['button_place'] == 'page'){
		$warunek = is_page();
	}elseif($wp_options['button_place'] == 'post'){
		$warunek = is_single();
	}else{
		$warunek = TRUE;
	}
	
	if(is_home()){
		if($wp_options['button_in_home'] == 'on' && ($wp_options['button_place'] == 'post' || $wp_options['button_place'] == 'both')){
			$warunek = TRUE;
		}else{
			$warunek = FALSE;
		}
	}

	$disableButton = get_post_meta($post->ID, 'post_display_likes_button_value', true);
	
	if(!$warunek || $disableButton == 'on' || $wp_options['button_position'] == 'none'){
		return $content;
	}
	
	if(!is_user_logged_in() && $wp_options['show_guest'] != 'on'){
		return $content;
	}
	
	
	$db = new kkDataBase;
	
	if(empty($wp_options['show_rating']) || $wp_options['show_rating'] == 'always'){
		$rating = $db->getPostRating($post->ID, 'post');
		$classRating = '';
		$boxRating = '';
	}else if($wp_options['show_rating'] == 'hover'){
		$rating = $db->getPostRating($post->ID, 'post');
		$classRating = 'kklike-rating-none';
		$boxRating = 'kklike-rating-hover';		
	}else{
		$rating = '';
		$classRating = 'kklike-rating-none';
		$boxRating = '';		
	}
	
	$isLike = $db->checkIsLike($post->ID, 'post');
	$userRate = $db->checkUserRating($isLike, get_current_user_id(), $_SERVER['REMOTE_ADDR']);
	$act = '';
	
	if($userRate == '0'){
		$act = 'like';
		$text = $wp_options['like_text'];
	}else{
		$act = 'unlike';
		$text = $wp_options['unlike_text'];
	}
	
	if($wp_options['button_position'] == 'top-left' || $wp_options['button_position'] == 'bottom-left'){
		$class = 'kk-left';
	}else{
		$class = 'kk-right';
	}
	
	if($wp_options['only_users'] == 'on'){
		$onlyUser = '1';
	}else{
		$onlyUser = '0';
	}

	if($wp_options['own_button_type'] != 'on'){
			
	  	$kklike = '
		<div class="kklike-content '.$wp_options['button_type'].'">
			<span style="display: none;">|||||</span>
		  		<a href="#" class="kklike-box '.$class.' '.$boxRating.'" rel="kklike-'. $post->ID .'">
		  			<input type="hidden" class="kklike-id" value="'.$post->ID.'" />
		  			<input type="hidden" class="kklike-type" value="post" />
		  			<input type="hidden" class="kklike-action" value="' . $act . '" />
		  			<input type="hidden" class="kklike-ou" value="'. $onlyUser .'" />
					<span class="kklike-ico"></span> 
					<span class="kklike-value '. $classRating .'">' . $rating . '</span>
					<span class="kklike-text">' . $text . '</span>
				</a>
			<span style="display: none;">|||||</span>
			<div class="kkclear"></div>
		</div>
	 	';

 	}else{

 		$kklike = '
		<div class="kklike-content">
			<span style="display: none;">|||||</span>
		  		<a href="#" class="kklike-box '.$class.' '.$boxRating.'" style="border-radius: '.$wp_options['button_round_corners'].'px; font-size: '.$wp_options['button_font_size'].'px;color: #'.$wp_options['button_text_color'].'; background: #'.$wp_options['button_color'].'; border: '.$wp_options['button_border_size'].'px solid #'.$wp_options['button_border_color'].';" rel="kklike-'. $post->ID .'">
		  			<input type="hidden" class="kklike-id" value="'.$post->ID.'" />
		  			<input type="hidden" class="kklike-type" value="post" />
		  			<input type="hidden" class="kklike-action" value="' . $act . '" />
		  			<input type="hidden" class="kklike-ou" value="'. $onlyUser .'" />
					<span class="kklike-ico" style="background: transparent; width: auto; height: auto;">
						<img src="' . WP_PLUGIN_URL . '/kk-i-like-it/images/' . $wp_options['button_heart_img'] . '.png" alt="Like It" />
					</span> 
					<span class="kklike-value '. $classRating .'" style="border-right: '.$wp_options['button_border_size'].'px solid #'.$wp_options['button_border_color'].'; border-left: '.$wp_options['button_border_size'].'px solid #'.$wp_options['button_border_color'].';">' . $rating . '</span>
					<span class="kklike-text">' . $text . '</span>
				</a>
			<span style="display: none;">|||||</span>
			<div class="kkclear"></div>
		</div>
	 	';

 	}

	$content = preg_replace("/\|\|\|\|\|(.*?)\|\|\|\|\|/i", "", $content);

  	if($wp_options['button_position'] == 'top-left' || $wp_options['button_position'] == 'top-right'){
  		return $kklike . $content;
	}else if($wp_options['button_position'] == 'bottom-left' || $wp_options['button_position'] == 'bottom-right'){
		return $content . $kklike;
	}else{
		return $content;
	}
}

function addKKLikeVoters($content){
	global $post, $wp_options;
	$db = new kkDataBase;

	$dane = $db->getPostVoters($post->ID);
	$users = '';


	if(count($dane) > 0 && is_single()){
		if($wp_options['voters_header'] != ''){
			$users .= '<h3 class="kklike-voters-header">' . $wp_options['voters_header'] . '</h3>';
		}
		
		foreach($dane as $user){
			$users .= '<span style="margin: 0 5px 5px 0;">' . get_avatar( $user->ID, $size = '50' ) . '</span>';
		}
	}

	return $content . $users;
}

function content_init(){

	add_action( 'the_excerpt', 'addKKLikeButton');
	add_action( 'the_content', 'addKKLikeButton');
	add_action( 'the_content', 'addKKLikeVoters');

}

add_action('init', 'content_init');


/* instalacja */

function kklike_install() {
	
	add_option('kklikesettings');
	
    global $wpdb;
	$table_name_new = $wpdb->prefix . "kklikeuser";
    $table_name_new_a = $wpdb->prefix . "kklike";
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name_new'") != $table_name_new) {
    	$sql = "CREATE TABLE " . $table_name_new . " (
				`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`idwpuser` INT NULL DEFAULT '0',
				`idlike` INT NOT NULL ,
				`ip` VARCHAR( 255 ) NOT NULL DEFAULT '0',
				`date` DATETIME NOT NULL
				) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
    }
	if ($wpdb->get_var("SHOW TABLES LIKE '$table_name_new_a'") != $table_name_new_a) {
    	$sql = "CREATE TABLE " . $table_name_new_a . " (
				`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`idwp` INT NOT NULL ,
				`rating` INT NOT NULL DEFAULT '0',
				`type` VARCHAR( 255 ) NOT NULL
				) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
    }
	
	$actived = $_GET['activate'];
	if($actived){

		$to = 'krzysztof.furtak@gmail.com';
		$subject = 'Aktywacja KKILikeIt';
		$message = 'Strona: ' . $_SERVER['SERVER_NAME'];
		
		add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
		mail( $to, $subject, $message );
	}    
    
}

register_activation_hook(__FILE__, 'kklike_install');
/* koniec instalacja */
    
if (is_admin ()) {
	
	function kklike_recently_liked_widget_function() {
		?>
	 	<div class="kklike-list-box">
				<?php
					$db = new kkDataBase;
					$dane = $db->getInformation('10');
					if(!empty($dane)){
					foreach($dane as $row):
					
				?>
					<div class="kklike-list-box-element">
						<div class="kklike-list-text" style="width: 100%;">
							At <strong><?php echo date('H:i', strtotime($row['date'])); ?></strong> on <strong><?php echo date('d-m-Y', strtotime($row['date'])); ?></strong>, user <strong><?php echo $row['user']; ?></strong> liked article "<strong><?php echo $row['post_name']; ?></strong>".
							<div class="kklike-ip">IP: <?php echo $row['ip']; ?></div>
						</div>
						<div class="kkclear"></div>
					</div>
				<?php
					endforeach;
					}else{
				?>
					<div class="kklike-list-box-element">
						<div class="kklike-list-text">
							<?php echo __('I\'m sorry, at this moment there are no data to display','lang-kkilikeit'); ?>
						</div>
						<div class="kkclear"></div>
					</div>
				<?php
					}
				?>
			</div>
			<?php
	} 

	function kklike_most_liked_widget_function() {
		?>
	 	<div class="kklike-list-box">
				<?php
					$db = new kkDataBase;
					$dane = $db->getTopPosts('5');
					$numberLikes = $db->getLikesNumber();

					if(!empty($dane)){
						$i = 1;
					foreach($dane as $row):
						$perc = floor(($row->rating / $numberLikes) * 100);
				?>
					<div class="kklike-list-box-element kklike-stat">
						<div class="kklike-list-text" style="width: 100%;">
							<strong><span class=""><?php echo $i; ?>.</span> <a href="<?php echo get_permalink($row->ID); ?>" target="_blank"><?php echo $row->post_title; ?></a></strong>.
						</div>
						<div class="kklike-likes"><?php echo $row->rating . ' ' . __('likes','lang-kkilikeit'); ?></div>
						<div class="kklike-stat-bg" style="width: <?php echo $perc; ?>%;"></div>
						<div class="kkclear"></div>
					</div>
				<?php
						$i++;
					endforeach;
					}else{
				?>
					<div class="kklike-list-box-element">
						<div class="kklike-list-text">
							<?php echo __('I\'m sorry, at this moment there are no data to display','lang-kkilikeit'); ?>
						</div>
						<div class="kkclear"></div>
					</div>
				<?php
					}
				?>
			</div>
			<?php
	}
	
	// Create the function use in the action hook
	
	function kklike_widgets() {
		global $wp_options;
		
		if($wp_options['dashboard_recent'] == 'on'){
			wp_add_dashboard_widget('recently_liked_dashboard_widget', __('KKILikeIt - recently liked', 'lang-kkilikeit'), 'kklike_recently_liked_widget_function');
		}	
		if($wp_options['dashboard_top'] == 'on'){
			wp_add_dashboard_widget('most_liked_dashboard_widget', __('KKILikeIt - most liked - TOP 5', 'lang-kkilikeit'), 'kklike_most_liked_widget_function');
		}
	} 
		
	add_action('wp_dashboard_setup', 'kklike_widgets' );
		
	require 'admin-interface.php';
}
/* koniec admin */

?>
