<?php

/**
 * Ogólne ustawienia:
 */
require_once 'db.php';

function kklike_admin_content(){
	global $wpdb, $options;
?>

<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/kk-i-like-it/js/excanvas.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/kk-i-like-it/js/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/kk-i-like-it/js/jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/kk-i-like-it/js/jqplot.categoryAxisRenderer.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/kk-i-like-it/js/jquery.jqplot.css" />

<div class="kkadmin-box">
	<div class="kkadmin-top">
		<?php include 'head.php'; ?>
	</div>
	<div class="kkadmin-content">
		<div class="kkadmin-text">
			<div class="kkadmin-text-wew">
				<?php 
				$wp_options = get_option('kklikesettings');
				if(empty($wp_options['dashboard_top']) || $wp_options['dashboard_top'] == null){
				?>	
					<div class="kkpb-alert kkpb-alert-error"><?php echo __('<strong>Plugin is not configured. It may not work correctly.</strong> Go to settings, make your selection and save settings.','lang-kklike'); ?></div>
				<?php } ?>
				
				<h2><?php echo __('The last ten activities', 'lang-kklike'); ?>:</h2>
				
				<div class="kklike-list-box">
					<?php
						$db = new kkDataBase;
						$dane = $db->getInformation('10');
						if(!empty($dane)){
						foreach($dane as $row):
						
					?>
						<div class="kklike-list-box-element">
							<div class="kklike-list-ico"></div>
							<div class="kklike-list-text">
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
								<?php echo __('I\'m sorry, at this moment there is no data to display','lang-kklike'); ?>
							</div>
							<div class="kkclear"></div>
						</div>
					<?php
						}
					?>
				</div>

				<div class="one-half">
					<h2><?php echo __('Likes per day', 'lang-kklike'); ?>:</h2>
					<div class="kkadmin-chart-desc">
						<?php echo __('The number of likes within last few days.', 'lang-kklike'); ?>
					</div>
					<?php require_once('number-likes.php'); ?>
				</div>
				<div class="one-half-last">
					<h2><?php echo __('Most liked', 'lang-kklike'); ?>:</h2>
					<div class="kkadmin-chart-desc">
						<?php echo __('The most often liked aticles within last few days.', 'lang-kklike'); ?>
					</div>
					<?php require_once('top-liked.php'); ?>
				</div>
				<div class="kkclear"></div>
			</div>
		</div>
		<div class="kkadmin-sidebar">
			<?php include 'menu.inc.php'; ?>
			<?php include 'sidebar.php'; ?>
		</div>
		<div class="kkclear"></div>
		<div class="kklike-msg">
			Hi, If you are interested in developing my plugin, you can help by providing me with a feedback on how it works for you. Suggestions or errors can be reported <a href="http://wordpress.org/support/plugin/kk-i-like-it" target="_blank">HERE</a>.
			I will be really grateful for any information.<br />
			
			Best regards
		</div>
	</div>
	
</div>

<?php
}

function kklike_admin_settings(){

	global $options;
	
	$position = array(
		__('Top Left','lang-kklike')		=>	'top-left',
		__('Top Right','lang-kklike')	=>	'top-right',
		__('Bottom Left','lang-kklike')	=>	'bottom-left',
		__('Bottom Right','lang-kklike')	=>	'bottom-right',
		__('Own position','lang-kklike')	=>	'none'
	);
	
	$buttonType = array(
		__('Light','lang-kklike')	=>	'kklike-button-light',
		__('Dark','lang-kklike')		=>	'kklike-button-dark',
		__('Big Dark','lang-kklike')		=>	'kklike-button-big-dark',
		__('Big Light','lang-kklike')		=>	'kklike-button-big-light'
	);
	
	$buttonPlace = array(
		__('Post','lang-kklike')		=>	'post',
		__('Page','lang-kklike')		=>	'page',
		__('Post&Page','lang-kklike')		=>	'both'
	);
	
	$showRating = array(
		__('Always','lang-kklike')								=>	'always',
		__('Never show','lang-kklike')							=>	'never',
		__('Hovering cursore over the button','lang-kklike')		=>	'hover'
	);

	$heartImages = array(
		__('Small Dark','lang-kklike')		=>	'heart-1',
		__('Small Light','lang-kklike')		=>	'heart-2',
		__('Big Light','lang-kklike')		=>	'heart-3',
		__('Big Dark','lang-kklike')			=>	'heart-4'
	);
	
	$options = array(
	// ==== GENERAL SETTINGS ====
	array(	'title'		=>	__('General Settings','lang-kklike'),
			'alias'		=>	'general-settings',
			'icon'		=>	WP_PLUGIN_URL . '/images/global.png',
		  	'content'	=>	array(
		  					'title_hr_1'	=>	array('type' => 'title-hr',
		  									'default'	=>	 __('Button settings:','lang-kklike'),
		  									'class'		=>	'kkpb-settings-title-break'
							),
							'like_text'=>array('type'		=>	'text',
										   		'default'	=>	'I Like It!',
										   		'title'		=>	__('Like text:','lang-kklike'),
									       		'tooltip'	=>	__('','lang-kklike'),
									       		'class'		=>	''
							),
							'unlike_text'=>array('type'		=>	'text',
										   		'default'	=>	'Unlike!',
										   		'title'		=>	__('Unlike text:','lang-kklike'),
									       		'tooltip'	=>	__('','lang-kklike'),
									       		'class'		=>	''
							),
							'only_users'=>array('type'		=>	'checkbox',
										   		'default'	=>	'off',
										   		'title'		=>	__('Only users can vote?','lang-kklike'),
									       		'tooltip'	=>	__('','lang-kklike'),
									       		'class'		=>	''
							),
							'show_guest'=>array('type'		=>	'checkbox',
										   		'default'	=>	'off',
										   		'title'		=>	__('Should a button be shown to guests?','lang-kklike'),
									       		'tooltip'	=>	__('','lang-kklike'),
									       		'class'		=>	''
							),
							'button_position'=>array('type'	=>	'radio-class',
										   		'default'	=>	'top-left',
										   		'title'		=>	__('Button position:','lang-kkprogressbar'),
									       		'tooltip'	=>	__('','lang-kklike'),
									       		'values'	=> $position,
												'class'		=>	''
							),
							'button_in_home'=>array('type'	=>	'checkbox',
										   		'default'	=>	'off',
										   		'title'		=>	__('Show button on post list?','lang-kklike'),
									       		'tooltip'	=>	__('','lang-kklike'),
									       		'class'		=>	''
							),
							'button_place'=>array('type'	=>	'radio-ui',
										   		'default'	=>	'both',
										   		'title'		=>	__('Where display button?','lang-kkprogressbar'),
									       		'tooltip'	=>	__('','lang-kklike'),
									       		'values'	=> $buttonPlace,
												'class'		=>	''
							),
							'show_rating'=>array('type'	=>	'radio-ui',
										   		'default'	=>	'always',
										   		'title'		=>	__('Show numer of likes','lang-kkprogressbar'),
									       		'tooltip'	=>	__('','lang-kklike'),
									       		'values'	=> $showRating,
												'class'		=>	''
							),
							
							'own_button_type'=>array('type'		=>	'checkbox',
										   		'default'	=>	'',
										   		'title'		=>	__('Own button style?','lang-kkprogressbar'),
									       		'tooltip'	=>	__('','lang-kklike'),
												'class'		=>	''
							),
							
							'button_type'=>array('type'		=>	'radio-demo',
										   		'default'	=>	'kklike-button-light',
										   		'title'		=>	__('Button type','lang-kkprogressbar'),
									       		'tooltip'	=>	__('','lang-kklike'),
									       		'values'	=> $buttonType,
												'class'		=>	'button-template'
							),
							
							'button_color'=>array('type'		=>	'color-pick',
										   		'default'	=>	'000000',
										   		'title'		=>	__('Button Color','lang-kkprogressbar'),
									       		'tooltip'	=>	__('','lang-kklike'),
												'class'		=>	'button-own'
							),
							'button_text_color'=>array('type'		=>	'color-pick',
										   		'default'	=>	'ffffff',
										   		'title'		=>	__('Button Text Color','lang-kkprogressbar'),
									       		'tooltip'	=>	__('','lang-kklike'),
												'class'		=>	'button-own'
							),
							'button_border_size'=>array('type'		=>	'text',
										   		'default'	=>	'1',
										   		'title'		=>	__('Button Border Size','lang-kkprogressbar'),
									       		'tooltip'	=>	__('','lang-kklike'),
												'class'		=>	'button-own'
							),
							'button_border_color'=>array('type'		=>	'color-pick',
										   		'default'	=>	'cccccc',
										   		'title'		=>	__('Button Border Color','lang-kkprogressbar'),
									       		'tooltip'	=>	__('','lang-kklike'),
												'class'		=>	'button-own'
							),
							'button_font_size'=>array('type'		=>	'text',
										   		'default'	=>	'10',
										   		'title'		=>	__('Button Font Size','lang-kkprogressbar'),
									       		'tooltip'	=>	__('','lang-kklike'),
												'class'		=>	'button-own'
							),
							'button_round_corners'=>array('type'		=>	'text',
										   		'default'	=>	'4',
										   		'title'		=>	__('Button Round Corners','lang-kkprogressbar'),
									       		'tooltip'	=>	__('','lang-kklike'),
												'class'		=>	'button-own'
							),
							'button_heart_img'=>array('type'		=>	'hearts-img',
										   		'default'	=>	'heart-1',
										   		'title'		=>	__('Button type','lang-kkprogressbar'),
									       		'tooltip'	=>	__('','lang-kklike'),
									       		'values'	=> $heartImages,
												'class'		=>	'button-own'
							),
							
							'title_hr_2'	=>	array('type' => 'title-hr',
		  									'default'	=>	 __('Dashboard:','lang-kklike'),
		  									'class'		=>	'kkpb-settings-title-break'
							),
							'dashboard_recent'=>array('type'	=>	'checkbox',
										   		'default'	=>	'off',
										   		'title'		=>	__('Show box Recent Liked on Dashboard?','lang-kklike'),
									       		'tooltip'	=>	__('','lang-kklike'),
									       		'class'		=>	''
							),
							'dashboard_top'=>array('type'	=>	'checkbox',
										   		'default'	=>	'off',
										   		'title'		=>	__('Show box Top Liked on Dashboard?','lang-kklike'),
									       		'tooltip'	=>	__('','lang-kklike'),
									       		'class'		=>	''
							),
							
							'title_hr_3'	=>	array('type' => 'title-hr',
		  									'default'	=>	 __('Post/Page Settings:','lang-kklike'),
		  									'class'		=>	'kkpb-settings-title-break'
							),
							'voters_header'=>array('type'	=>	'text',
										   		'default'	=>	'',
										   		'title'		=>	__('Voters Text Header:','lang-kkprogressbar'),
									       		'tooltip'	=>	__('','lang-kklike')
							),
							'show_voters'=>array('type'	=>	'checkbox',
										   		'default'	=>	'off',
										   		'title'		=>	__('Show voters after post/page content?','lang-kklike'),
									       		'tooltip'	=>	__('','lang-kklike'),
									       		'class'		=>	''
							),					
	)
	));
}

function kklike_settings(){
	
	global $options;
	
	kklike_admin_settings();
	
	if ( isset($_GET['page']) ) {
		
		if( $_GET['page'] == 'kklike-settings' ) {
			
			$options_array = array();
			if ( isset($_POST['action']) && $_POST['action'] == 'save' ) {
				
				foreach ($options as $value) {
					foreach( $value['content'] as $key => $val ) {
						if( $key != 'custom_sidebar' && $key != 'title_hr_1' && $key != 'title_hr_2' && $key != 'title_hr_3' ) {
							if($_REQUEST[$key] == ''){
								$_REQUEST[$key] = null;
							}
							$options_array[$key] = $_REQUEST[$key];
						}
					}
				}
				update_option( 'kklikesettings', $options_array );
			}
				
		}
	}
	include 'settings.php';
}

function kklike_changelog(){
	include 'changelog.php';
}

function kklike_documentation(){
	include 'documentation.php';
}

function kklike_menu() {
	
	$wp_options = get_option('kklikesettings');
	
	if(!empty($wp_options['plugin_rank'])){
		$plugin_rank = $wp_options['plugin_rank'];
	}else{
		$plugin_rank = 'administrator';
	}
	
	if(!empty($wp_options['edit_rank'])){
		$edit_rank = $wp_options['edit_rank'];
	}else{
		$edit_rank = 'administrator';
	}
	
	if(!empty($wp_options['settings_rank'])){
		$settings_rank = $wp_options['settings_rank'];
	}else{
		$settings_rank = 'administrator';
	}
	
	add_menu_page(PLUGIN_NAME, PLUGIN_NAME, $plugin_rank, 'kklike-menu', 'kklike_admin_content', WP_PLUGIN_URL.'/kk-i-like-it/images/kkpb-ico.jpg');
	add_submenu_page('kklike-menu', PLUGIN_NAME, 'Settings', $settings_rank, 'kklike-settings', 'kklike_settings');
	add_submenu_page('kklike-menu', PLUGIN_NAME, 'Documentation', $settings_rank, 'kklike-documentation', 'kklike_documentation');
	add_submenu_page('kklike-menu', PLUGIN_NAME, 'Changelog', $settings_rank, 'kklike-changelog', 'kklike_changelog');
	
}

add_action('admin_menu', 'kklike_menu', 9);
