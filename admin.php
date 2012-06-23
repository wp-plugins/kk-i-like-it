<?php
/*
  Plugin Name: KK I Like It
  Plugin URI: http://krzysztof-furtak.pl/kk-i-like-it-wordpress-plugin/
  Description: Plugin gives users or guest an option to like an article or a page.
  Version: 1.1.2
  Author: Krzysztof Furtak
  Author URI: http://krzysztof-furtak.pl
 */

add_action('init', 'kklike_load_translation');

require_once('prezentacja.php');
require_once('config.inc.php');

require_once ('db.php');
require_once ('ajax.php');

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
  	
  	wp_register_script('kklike-ui-widget-js', WP_PLUGIN_URL .'/kk-i-like-it/js/jquery-ui.custom.js', array('jquery-ui-core'), '1.1');
	wp_enqueue_script('kklike-ui-widget-js');
	
	wp_enqueue_style('kklike-css', WP_PLUGIN_URL .'/kk-i-like-it/css/kklike.css?v=1.1');
	wp_enqueue_style('kklike-afront-css', WP_PLUGIN_URL .'/kk-i-like-it/css/kklike-front.css?v=1.1');
	
	wp_register_script('kklike-js', WP_PLUGIN_URL .'/kk-i-like-it/js/admin.js', array('jquery'), '1.1');
	wp_enqueue_script('kklike-js');
    
    /* ============= CHECKBOX PLUGIN ============= */
    wp_register_script('kklike-checkbox', WP_PLUGIN_URL .'/kk-i-like-it/js/iphone-style-checkboxes.js', array('jquery'), '1.1');
    wp_enqueue_script('kklike-checkbox');
    wp_enqueue_style('kklike-checkbox-css', WP_PLUGIN_URL .'/kk-i-like-it/css/iphone-style-checkboxes-css.css');
    
    /* ============= ColorPicker PLUGIN ============= */
    wp_enqueue_style('kklike-admin-css-color', WP_PLUGIN_URL .'/kk-i-like-it/css/colorpicker.css');
    wp_register_script('kklike-admin-color', WP_PLUGIN_URL .'/kk-i-like-it/js/colorpicker.js', array('jquery'), '1.1');
    wp_enqueue_script('kklike-admin-color');
    
	/* ============= JS COOKIE PLUGIN ============= */
	wp_register_script('kklike-admin-cookie', WP_PLUGIN_URL .'/kk-i-like-it/js/jquery.cookie.js', array('jquery'), '1.1');
    wp_enqueue_script('kklike-admin-cookie');
    
    wp_enqueue_style('kklike-jquery-ui-css', WP_PLUGIN_URL .'/kk-i-like-it/css/black-tie/jquery-ui.custom.css?v=1.1');
	
	/* ============= Tooltip PLUGIN ============= */
	wp_enqueue_style('kklike-css-tip', WP_PLUGIN_URL .'/kk-i-like-it/css/jquery.qtip.css');
	wp_register_script('kklike-tip', WP_PLUGIN_URL .'/kk-i-like-it/js/jquery.qtip.min.js', array('jquery'), '1.1.0');
	wp_enqueue_script('kklike-tip');
}

function kklike_enqueue_scripts(){
   	wp_enqueue_script('jquery');
   	
	wp_enqueue_style('kklike-front-css', WP_PLUGIN_URL .'/kk-i-like-it/css/kklike-front.css?v=1.1');
	
	wp_register_script('kklike-front-js', WP_PLUGIN_URL .'/kk-i-like-it/js/kklike-front.js', array('jquery'), '1.1');
	wp_enqueue_script('kklike-front-js');
	
	// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
	wp_localize_script( 'kklike-front-js', 'kkajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

add_action('init', 'kklike_enqueue_scripts');
add_action('admin_enqueue_scripts', 'kklike_admin_enqueue_scripts');

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
	
	if(!$warunek){
		return $content;
	}
	
	$db = new kkDataBase;
	$rating = $db->getPostRating($post->ID, 'post');
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
		
  	$kklike = '
		<div class="kklike-content '.$wp_options['button_type'].'">
	  		<a href="#" class="kklike-box '.$class.'">
	  			<input type="hidden" class="kklike-id" value="'.$post->ID.'" />
	  			<input type="hidden" class="kklike-type" value="post" />
	  			<input type="hidden" class="kklike-action" value="' . $act . '" />
	  			<input type="hidden" class="kklike-ou" value="'. $onlyUser .'" />
				<span class="kklike-ico"></span> 
				<span class="kklike-value">' . $rating . '</span>
				<span class="kklike-text">' . $text . '</span>
			</a>
			<div class="kkclear"></div>
		</div>
 	';
	
  	if($wp_options['button_position'] == 'top-left' || $wp_options['button_position'] == 'top-right'){
  		return $kklike . $content;
	}else if($wp_options['button_position'] == 'bottom-left' || $wp_options['button_position'] == 'bottom-right'){
		return $content . $kklike;
	}else{
		return $content;
	}
}

add_action( 'the_content', 'addKKLikeButton', 11 );

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
    
}

register_activation_hook(__FILE__, 'kklike_install');
/* koniec instalacja */
    
if (is_admin ()) {
	
	$actived = $_GET['activate'];
	if($actived){

		$to = 'krzysztof.furtak@gmail.com';
		$subject = 'Aktywacja KKILikeIt';
		$message = 'Strona: ' . $_SERVER['SERVER_NAME'];
		
		add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
		mail( $to, $subject, $message );
	}
		
	require 'admin-interface.php';
}
/* koniec admin */

?>
