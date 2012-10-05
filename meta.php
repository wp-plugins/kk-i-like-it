<?php
// META BOX ====================================================

$new_meta_boxes =
array(
	"post_display_likes_button" 	=> array(
		"type" 			=> 	"checkbox",
		"name" 			=> 	"post_display_likes_button",
		"std" 			=> 	"",
		"title"			=> 	"Disable likes button?",
		"description" 	=> 	""
	),
	"kklike" 	=> array(
		"type" 			=> 	"likes",
		"name" 			=> 	"kklike",
		"std" 			=> 	"0",
		"title"			=> 	"Number of likes",
		"description" 	=> 	""
	)
);

function new_meta_boxes() {
	global $post, $new_meta_boxes;
	 
	foreach($new_meta_boxes as $meta_box) {
		$meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);
	 
		if($meta_box_value == ""){
			$meta_box_value = $meta_box['std'];
		}
		/*
		echo '<pre>';
		var_dump($meta_box['type']);
		echo '</pre>';
		*/
		switch ($meta_box['type']){
			case 'image' :
				?>
				<div class="kkrow">
					<input type="hidden" name="<?php echo $meta_box['name']; ?>_noncename" id="<?php echo $meta_box['name']; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
					<div class="kkadmin-opt-head-inline"><?php echo $meta_box['title'];?>: </div>
					<span class="kkadmin-selectbox"><input type="text" name="<?php echo $meta_box['name']; ?>_value" value="<?php echo $meta_box_value; ?>" size="100" class="upload_image" /><input type="button" value="Dodaj" class="button upload_image_button" /></span><br />
					<p><label for="<?php echo $meta_box['name']; ?>_value"><?php echo $meta_box['description']; ?></label></p>
				</div>
				<?php
				break;
				
			case 'checkbox':
				?>
				<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery('.kknewcheckbox:visible').iphoneStyle({
							 checkedLabel: 'Tak',
							 uncheckedLabel: 'Nie'
						});
					});
				</script>
				<div class="kkrow">
					<table>
					<tr><td>
						<input type="hidden" name="<?php echo $meta_box['name']; ?>_noncename" id="<?php echo $meta_box['name']; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
						<div class="kkadmin-opt-head-inline"><?php echo $meta_box['title'];?>: </div>
					</td><td style="padding: 15px 0 0 20px;">
						<?php 
							if($meta_box_value == 'on'){
								$check = 'checked="checked"';
							}else{
								$check = '';
							}
						?>
						<span class="kkadmin-selectbox"><input type="checkbox" class="kknewcheckbox" name="<?php echo $meta_box['name']; ?>_value" <?php echo $check; ?> /></span><br />
					</td></tr>
					</table>
					<p><label for="<?php echo $meta_box['name']; ?>_value"><?php echo $meta_box['description']; ?></label></p>
				</div>
				
				<?php
				break;
				case 'text':
?>
				<div class="kkrow">
					<input type="hidden" name="<?php echo $meta_box['name']; ?>_noncename" id="<?php echo $meta_box['name']; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
					<div class="kkadmin-opt-head-inline"><?php echo $meta_box['title'];?>: </div>
					<span class="kkadmin-selectbox"><input type="text" name="<?php echo $meta_box['name']; ?>_value" value="<?php echo $meta_box_value; ?>" size="100" /></span><br />
					<p><label for="<?php echo $meta_box['name']; ?>_value"><?php echo $meta_box['description']; ?></label></p>
				</div>
<?php 
			
				break;
				case 'likes':
				?>
				<div class="kkrow">
					<input type="hidden" name="<?php echo $meta_box['name']; ?>_noncename" id="<?php echo $meta_box['name']; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
					<div class="kkadmin-opt-head-inline"><?php echo $meta_box['title'];?>: </div>
					<span class="kkadmin-selectbox"><input type="text" name="<?php echo $meta_box['name']; ?>_value" value="<?php echo $meta_box_value; ?>" size="10" readonly="readonly" /></span><br />
					<p><label for="<?php echo $meta_box['name']; ?>_value"><?php echo $meta_box['description']; ?></label></p>
				</div>
				<?php
				break;
		}
		
	}
}
 
function create_meta_box() {
	global $theme_name;
		if ( function_exists('add_meta_box') ) {
		add_meta_box( 'kklike-button-display', 'Like Button', 'new_meta_boxes', 'post', 'side', 'default' );
		add_meta_box( 'kklike-button-display', 'Like Button', 'new_meta_boxes', 'page', 'side', 'default' );
	}
}
 
function save_postdata( $post_id ) {
	global $post, $new_meta_boxes;
	 
	foreach($new_meta_boxes as $meta_box) {
		// Verify
		if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {
			return $post_id;
		}
		 
		if ( 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ))
		return $post_id;
		} else {
			if ( !current_user_can( 'edit_post', $post_id ))
		return $post_id;
		}
		 
		$data = $_POST[$meta_box['name'].'_value'];
		 
		if(get_post_meta($post_id, $meta_box['name'].'_value') == "")
			add_post_meta($post_id, $meta_box['name'].'_value', $data, true);
		elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))
			update_post_meta($post_id, $meta_box['name'].'_value', $data);
		elseif($data == "")
			delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));
	}
}

add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata');