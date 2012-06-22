<?php

global $wpdb;

$wp_options = get_option('kklikesettings');

?>
<div class="wrap" id="kkadmin-interface">

	<?php include 'head.php'; ?>
	
	<div id="kkadmin-menu">
		<?php include 'menu.inc.php'; ?>
		<?php include 'sidebar.php'; ?>
	</div>
	<div id="kkadmin-tresc">
		<div id="kkadmin-tresc-wew">
			<form method="post" id="kkpb-settings-form">
			<input type="hidden" name="action" value="save" />
			
			<div id="kkadmin-tresc-" class="kkadmin-tresc">
				<table class="kkadmin-option-content">
				<?php 
				foreach($options as $option) { ?>
					<?php
						foreach($option['content'] as $key => $value) { 
							kklike_admin_generate_option($wp_options, $value['type'], $key, $value);
						} 
					?>
				<?php }?>
				</table>
				<?php
				
				?>
				<input class="button-primary kk-button" style="float: right;" type="submit" name="save" value="<?php _e('Save changes','lang-kkilikeit'); ?>" />
			</div>
			</form>
		</div>
	</div>
</div>

<?php 
function kklike_admin_generate_option($wp_options, $type, $key, $value){
	
	switch($type) {

		case 'editor':
			?>
<tr class="<?php echo $value['class']; ?>">
	<td class="kk-admin-info">
		<div class="kkadmin-info kk-tooltip" title="<?php echo $value['tooltip']; ?>">
		<img src="<?php echo WP_PLUGIN_URL; ?>/kkilikeit/images/ico_info.png" alt="Info" style="vertical-align: middle;" />
	</div>
	</td>
	<td class="kk-admin-label" colspan="2">
		<label for="<?php echo $key; ?>"><?php echo $value['title']; ?></label>
		<div class="kk-admin-editor">
			<?php 
			$content = (isset($wp_options[$key]) ? stripslashes($wp_options[$key]) : (isset($value['default']) ? $value['default'] : ''));
			if(floatval(get_bloginfo('version')) >= 3.3){
				wp_editor( $content, $key, $settings = array() ); 
			}else{
			?>
				<textarea id="<?php echo $key; ?>" name="<?php echo $key; ?>"><?php echo $content; ?></textarea>
			<?php } ?>
		</div>
	</td>
</tr>
<?php 
			break;
		case 'select':		
?>

<tr class="<?php echo $value['class']; ?>">
	<td class="kk-admin-info">
		<div class="kkadmin-info kk-tooltip" title="<?php echo $value['tooltip']; ?>">
		<img src="<?php echo WP_PLUGIN_URL; ?>/kkilikeit/images/ico_info.png" alt="Info" style="vertical-align: middle;" />
	</div>
	</td>
	<td class="kk-admin-label">
		<label for="<?php echo $key; ?>"><?php echo $value['title']; ?></label>
	</td>
	<td class="kk-admin-settings-val">
		<div class="kkadmin-selectbox">
			<select name="<?php echo $key; ?>" id="<?php echo $key; ?>">
				<?php 
					$default = (isset($wp_options[$key]) ? stripslashes($wp_options[$key]) : (isset($value['default']) ? $value['default'] : ''));
					if($default == 0){
						$selected = 'selected="selected"';
					}else{
						$selected = '';
					} 
				?>
				<option value="0" <?php echo $selected; ?>><?php _e('-- wybierz --','kkadmin'); ?></option>
				<?php foreach ($value['options'] as $dane) : 
					if($default == $dane->ID){
						$selected = 'selected="selected"';
					}else{
						$selected = '';
					}
				?>
					<option value="<?php echo $dane->ID; ?>" <?php echo $selected; ?>><?php echo $dane->post_title; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</td>
</tr>

<?php 
			break;
		case 'text-short':		
?>

<tr class="<?php echo $value['class']; ?>">
	<td class="kk-admin-info">
		<div class="kkadmin-info kk-tooltip" title="<?php echo $value['tooltip']; ?>">
		<img src="<?php echo WP_PLUGIN_URL; ?>/kkilikeit/images/ico_info.png" alt="Info" style="vertical-align: middle;" />
	</div>
	</td>
	<td class="kk-admin-label">
		<label for="<?php echo $key; ?>"><?php echo $value['title']; ?></label>
	</td>
	<td class="kk-admin-settings-val">
		<div class="kk-admin-input-text">
			<input type="text" style="width: 60px !important;" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo (isset($wp_options[$key]) ? stripslashes($wp_options[$key]) : (isset($value['default']) ? $value['default'] : '')); ?>" />
		</div>
	</td>
</tr>

<?php 
			break;
			case 'color-pick':
				?>
			
			<tr class="<?php echo $value['class']; ?>">
				<td class="kk-admin-info">
					<div class="kkadmin-info kk-tooltip" title="<?php echo $value['tooltip']; ?>">
					<img src="<?php echo WP_PLUGIN_URL; ?>/kkilikeit/images/ico_info.png" alt="Info" style="vertical-align: middle;" />
				</div>
				</td>
				<td class="kk-admin-label">
					<label for="<?php echo $key; ?>"><?php echo $value['title']; ?> : </label>
				</td>
				<td class="kk-admin-settings-val">
					<div class="kk-admin-input-text">
						#<input type="text" class="kkpb-color-pick" style="width: 60px !important;" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo (isset($wp_options[$key]) ? stripslashes($wp_options[$key]) : (isset($value['default']) ? $value['default'] : '')); ?>" />
					</div>
				</td>
			</tr>
			
			<?php 
						break;
		case 'text':
?>
<tr class="<?php echo $value['class']; ?>">
	<td class="kk-admin-info">
		<div class="kkadmin-info kk-tooltip" title="<?php echo $value['tooltip']; ?>">
		<img src="<?php echo WP_PLUGIN_URL; ?>/kkilikeit/images/ico_info.png" alt="Info" style="vertical-align: middle;" />
	</div>
	</td>
	<td class="kk-admin-label">
		<label for="<?php echo $key; ?>"><?php echo $value['title']; ?></label>
	</td>
	<td class="kk-admin-settings-val">
		<div class="kk-admin-input">
			<input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo (isset($wp_options[$key]) ? stripslashes($wp_options[$key]) : (isset($value['default']) ? $value['default'] : '')); ?>" />
		</div>
	</td>
</tr>
<?php 
			break;
		case 'checkbox':
?>

<?php 

	if(!empty($wp_options[$key]) || $wp_options[$key] != null){ 
		$checkbox = $wp_options[$key];
	}else if(isset($value['default'])){
		$checkbox = $value['default'];
	}else{ 
		$checkbox = ''; 
	}
	
	if($checkbox == 'on' || $checkbox == 'enabled'){
		$val_yes = 'checked="checked"';
	}else{
		$val_yes = '';
	}
	
?>
<tr class="<?php echo $value['class']; ?>">
	<td class="kk-admin-info">
		<div class="kkadmin-info kk-tooltip" title="<?php echo $value['tooltip']; ?>">
		<img src="<?php echo WP_PLUGIN_URL; ?>/kkilikeit/images/ico_info.png" alt="Info" style="vertical-align: middle;" />
	</div>
	</td>
	<td class="kk-admin-label">
		<label for="<?php echo $key; ?>"><?php echo $value['title']; ?></label>
	</td>
	<td class="kk-admin-settings-val">
		<div class="kk-admin-input">
			<input type="checkbox" name="<?php echo $key; ?>" id="<?php echo $key; ?>" class="kknewcheckbox" <?php echo $val_yes; ?> />
		</div>
	</td>
</tr>

<?php
			break;
			case 'radio':
				?>
			
			<tr class="<?php echo $value['class']; ?>">
				<td class="kk-admin-info">
					<div class="kkadmin-info kk-tooltip" title="<?php echo $value['tooltip']; ?>">
					<img src="<?php echo WP_PLUGIN_URL; ?>/kkilikeit/images/ico_info.png" alt="Info" style="vertical-align: middle;" />
				</div>
				</td>
				<td class="kk-admin-label">
					<label for="<?php echo $key; ?>"><?php echo $value['title']; ?></label>
				</td>
				<td class="kk-admin-settings-val">
					<div class="kkadmin-selectbox">
						
							<?php 
								$default = (isset($wp_options[$key]) ? stripslashes($wp_options[$key]) : (isset($value['default']) ? $value['default'] : ''));
								if($default == 0){
									$selected = 'checked="checked"';
								}else{
									$selected = '';
								} 
							?>
							<?php foreach ($value['values'] as $nazwa => $class) : 
								if($default == $class){
									$selected = 'checked="checked"';
								}else{
									$selected = '';
								}
							?>
								<input type="radio" name="<?php echo $key; ?>" id="<?php echo $class; ?>" value="<?php echo $class; ?>" <?php echo $selected; ?>> <label for="<?php echo $class; ?>"><?php echo $nazwa; ?></label>
							<?php endforeach; ?>
						
					</div>
				</td>
			</tr>
			
			<?php 
			break;
			case 'radio-class':
				?>
						
			<tr class="<?php echo $value['class']; ?>">
				<td class="kk-admin-info">
					<div class="kkadmin-info kk-tooltip" title="<?php echo $value['tooltip']; ?>">
					<img src="<?php echo WP_PLUGIN_URL; ?>/kkilikeit/images/ico_info.png" alt="Info" style="vertical-align: middle;" />
				</div>
				</td>
				<td class="kk-admin-label">
					<label for="<?php echo $key; ?>"><?php echo $value['title']; ?></label>
				</td>
				<td class="kk-admin-settings-val">
					<div class="kkadmin-selectbox kkadmin-radio-prev-class">
						
							<?php 
								$default = (isset($wp_options[$key]) ? stripslashes($wp_options[$key]) : (isset($value['default']) ? $value['default'] : ''));
								if($default == 0){
									$selected = 'checked="checked"';
								}else{
									$selected = '';
								} 
							?>
							<?php foreach ($value['values'] as $nazwa => $class) : 
								if($default == $class){
									$selected = 'checked="checked"';
								}else{
									$selected = '';
								}
							?>
								<div class="kkadmin-radio-prev-box"><input type="radio" name="<?php echo $key; ?>" id="<?php echo $class; ?>" value="<?php echo $class; ?>" <?php echo $selected; ?>> <label for="<?php echo $class; ?>"><span class="<?php echo $class; ?> kkpb-radio-prev-class"></span><?php echo $nazwa; ?></label></div>
							<?php endforeach; ?>
						
					</div>
				</td>
			</tr>
			
			<?php 
			break;
			case 'radio-ui':
				?>
						
			<tr class="<?php echo $value['class']; ?>">
				<td class="kk-admin-info">
					<div class="kkadmin-info kk-tooltip" title="<?php echo $value['tooltip']; ?>">
					<img src="<?php echo WP_PLUGIN_URL; ?>/kkilikeit/images/ico_info.png" alt="Info" style="vertical-align: middle;" />
				</div>
				</td>
				<td class="kk-admin-label">
					<label for="<?php echo $key; ?>"><?php echo $value['title']; ?></label>
				</td>
				<td class="kk-admin-settings-val">
					<div class="kkadmin-selectbox kkadmin-radio-ui">
						
							<?php 
								$default = (isset($wp_options[$key]) ? stripslashes($wp_options[$key]) : (isset($value['default']) ? $value['default'] : ''));
								if($default == 0){
									$selected = 'checked="checked"';
								}else{
									$selected = '';
								} 
							?>
							<?php foreach ($value['values'] as $nazwa => $class) : 
								if($default == $class){
									$selected = 'checked="checked"';
								}else{
									$selected = '';
								}
							?>
								<input type="radio" name="<?php echo $key; ?>" id="<?php echo $class; ?>" value="<?php echo $class; ?>" <?php echo $selected; ?>> <label for="<?php echo $class; ?>"><?php echo $nazwa; ?></label>
							<?php endforeach; ?>
						
					</div>
				</td>
			</tr>
			
			<?php 
			break;
			case 'title-hr':
			?>
			<tr class="<?php echo $value['class']; ?>">
				<td colspan="3" class="kk-admin-settings-val">
					<h2><?php echo $value['default']; ?></h2>
				</td>
			</tr>
			<?php 
			break;
/* SELECT SIMPLE ============================================================================ */
		case 'simple-select':		
		?>
		<tr>
			<td class="kk-admin-info">
				<div class="kkadmin-info kk-tooltip" title="<?php echo $value['tooltip']; ?>">
				<img src="<?php echo WP_PLUGIN_URL; ?>/kkilikeit/images/ico_info.png" alt="Info" style="vertical-align: middle;" />
			</div>
			<td class="kk-admin-label">
				<label for="<?php echo $key; ?>"><?php echo $value['title']; ?> : </label>
			</td>
			<td class="kk-admin-settings-val">
				<div class="kkadmin-selectbox">
					<select name="<?php echo $key; ?>" id="<?php echo $key; ?>">
						<?php 
							$default = (isset($wp_options[$key]) ? stripslashes($wp_options[$key]) : (isset($value['default']) ? $value['default'] : ''));
							if($default == 0){
								$selected = 'selected="selected"';
							}else{
								$selected = '';
							} 
						?>
						<!-- <option value="0" <?php echo $selected; ?>><?php _e('-- wybierz --','kkadmin'); ?></option> -->
						<?php foreach ($value['options'] as $keya=>$valuea) : 
							
							if($default == $keya){
								$selected = 'selected="selected"';
							}else{
								$selected = '';
							}
						?>
							<option value="<?php echo $keya; ?>" <?php echo $selected; ?>><?php echo $valuea; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</td>
		</tr>
		<?php 
		break;
		case 'radio-demo':
				?>
			
			<tr class="<?php echo $value['class']; ?>">
				<td class="kk-admin-info">
					<div class="kkadmin-info kk-tooltip" title="<?php echo $value['tooltip']; ?>">
					<img src="<?php echo WP_PLUGIN_URL; ?>/kkilikeit/images/ico_info.png" alt="Info" style="vertical-align: middle;" />
				</div>
				</td>
				<td class="kk-admin-label">
					<label for="<?php echo $key; ?>"><?php echo $value['title']; ?></label>
				</td>
				<td class="kk-admin-settings-val">
					<div class="kkadmin-selectbox">
						
							<?php 
								$default = (isset($wp_options[$key]) ? stripslashes($wp_options[$key]) : (isset($value['default']) ? $value['default'] : ''));
								if($default == 0){
									$selected = 'checked="checked"';
								}else{
									$selected = '';
								} 
							?>
							<?php foreach ($value['values'] as $nazwa => $class) : 
								if($default == $class){
									$selected = 'checked="checked"';
								}else{
									$selected = '';
								}
							?>
								<input type="radio" style="float: left; vertical-align: middle; margin-right: 5px;" name="<?php echo $key; ?>" id="<?php echo $class; ?>" value="<?php echo $class; ?>" <?php echo $selected; ?>> 
								<div class="kklike-content <?php echo $class; ?> kk-left">
							  		<a href="#" class="kklike-box">
										<span class="kklike-ico"></span> 
										<span class="kklike-value">1000</span>
										<span class="kklike-text">I Like It!</span>
									</a>
									<div class="kkclear"></div>
								</div>
								<div class="kkclear" style="margin-bottom: 10px;"></div>
							<?php endforeach; ?>
						
					</div>
				</td>
			</tr>
			
			<?php 
			break;
	} 
}

?>
