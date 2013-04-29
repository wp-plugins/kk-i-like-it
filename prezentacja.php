<?php
global $kkLikeSettings;
$kkLikeSettings = get_option('kklikesettings');

/* ================================ */
/* ========   WIDGETY   =========== */
/* ================================ */

add_action('widgets_init', create_function('', 'return register_widget("kklikeMostLiked");'));
class kklikeMostLiked extends WP_Widget {

	function __construct() {
		// widget actual processes
		parent::WP_Widget('kklikeMostLiked', 'KK I Like It - most liked');
	}

	function form($instance) {
		// outputs the options form on admin

		$title = esc_attr($instance['title']);
		$items = esc_attr($instance['items']);
		$type = esc_attr($instance['type']);
		
		$args=array();
		$output = 'objects'; // names or objects
		$post_types=get_post_types($args,$output); 
		
		$selekt = '<select name="'. $this->get_field_name('type') .'"><option value="all_post_types">-- ALL --</option>';
		  foreach ($post_types  as $post_type ) {
		  	if($post_type->name != 'attachment' && $post_type->name != 'revision' && $post_type->name != 'nav_menu_item'){
		  		if($type == $post_type->name){
		  			$selected = 'selected="selected"';
		  		}else{
		  			$selected = '';		  			
		  		}
		    	$selekt .= '<option '. $selected .' value="'. $post_type->name .'">' . $post_type->labels->name . '</option>';
			}
		  }
		$selekt .= '<select>';
		?>
        <div>
        	<label for="<?php echo $this->get_field_id('title'); ?>">
        		<div class="kkwidget-option-title"><?php _e('Title:'); ?> </div>
        		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        	</label>
        </div>
        <div>
        	<div class="kkwidget-option-title"><?php echo __('How many items should be displayed','lang-kklike'); ?>?</div>
        	<input type="text" id="<?php  echo $this->get_field_id('items') ?>" name="<?php echo  $this->get_field_name('items'); ?>" value="<?php echo $items; ?>" /><label class="kkwidget-option-label" for="<?php  echo $this->get_field_id('items') ?>"><?php echo __(' items.','lang-kklike'); ?></label>
        </div>
        <div>
        	<div class="kkwidget-option-title"><?php echo __('What post type should be displayed','lang-kklike'); ?>?</div>
        	<?php
        		echo $selekt; 
        	?>
        </div>

<?php
    }

    function update($new_instance, $old_instance) {
        // processes widget options to be saved
        $instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['items'] = $new_instance['items'];
		$instance['type'] = $new_instance['type'];

		return $instance;
    }

    function widget($args, $instance) {
        // outputs the content of the widget
    	global $kkLikeSettings;

        $i = 1;
        extract($args);
		
        $title = apply_filters('widget_title', $instance['title']);
		$items = esc_attr($instance['items']);
        $type = esc_attr($instance['type']);
		
		if($type == 'all_post_types'){
			$type = FALSE;
		}
		
        $like = new kkDataBase;
		$posts = $like->getTopPosts($items, $type);
        
        echo $before_widget;
        echo $before_title;
        echo $title;
        echo $after_title;

		echo '<ul class="kklike-widget kklike-most-liked">';
        foreach($posts as $post){
        	
        	// if($i == '1'){
        		// $cls = 'kklike-big-heart';
        	// }else if($i == '2' || $i == '3'){
        		// $cls = 'kklike-small-heart';
        	// }else{
        		// $cls = 'kklike-big-heart';
        	// }
			
			$cls = 'kklike-big-heart';
        ?>
        	<li>
        		<span class="<?php echo $cls; ?>"></span>
        		<span class="kklike-wg-text">
        			<span class="kklike-wg-title"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></span>
        			<span class="kklike-wg-rating"><?php echo __('Liked:','lang-kklike'); ?> <?php echo $post->meta_value; ?></span>
        			<span class="kklike-wg-date"><?php echo __('Date:','lang-kklike'); ?> <?php echo date('d-m-Y', strtotime($post->post_date)); ?></span>
        		</span>
        		<span class="kkclear"></span>
        	</li>
        <?php
        	$i++;
        }
		echo '</ul>';
		
        echo $after_widget;
    }

}


add_action('widgets_init', create_function('', 'return register_widget("kklikeLastLiked");'));
class kklikeLastLiked extends WP_Widget {

	function __construct() {
		// widget actual processes
		parent::WP_Widget('kklikeLastLiked', 'KK I Like It - recently liked');
	}

	function form($instance) {
		// outputs the options form on admin

		$title = esc_attr($instance['title']);
		$items = esc_attr($instance['items']);
		$type = esc_attr($instance['type']);
		
		$args=array();
		$output = 'objects'; // names or objects
		$post_types=get_post_types($args,$output); 
		
		$selekt = '<select name="'. $this->get_field_name('type') .'"><option value="all_post_types">-- ALL --</option>';
		  foreach ($post_types  as $post_type ) {
		  	if($post_type->name != 'attachment' && $post_type->name != 'revision' && $post_type->name != 'nav_menu_item'){
		  		if($type == $post_type->name){
		  			$selected = 'selected="selected"';
		  		}else{
		  			$selected = '';		  			
		  		}
		    	$selekt .= '<option '. $selected .' value="'. $post_type->name .'">' . $post_type->labels->name . '</option>';
			}
		  }
		$selekt .= '<select>';
		
		?>
        <div>
        	<label for="<?php echo $this->get_field_id('title'); ?>">
        		<div class="kkwidget-option-title"><?php _e('Title:'); ?> </div>
        		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        	</label>
        </div>
        <div>
        	<div class="kkwidget-option-title"><?php echo __('How many items should be displayed','lang-kklike'); ?>?</div>
        	<input type="text" id="<?php  echo $this->get_field_id('items') ?>" name="<?php echo  $this->get_field_name('items'); ?>" value="<?php echo $items; ?>" /><label class="kkwidget-option-label" for="<?php  echo $this->get_field_id('items') ?>"><?php echo __(' items.','lang-kklike'); ?></label>
        </div>
        <div>
        	<div class="kkwidget-option-title"><?php echo __('What post type should be displayed','lang-kklike'); ?>?</div>
        	<?php
        		echo $selekt; 
        	?>
        </div>

<?php
    }

    function update($new_instance, $old_instance) {
        // processes widget options to be saved
        $instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['items'] = $new_instance['items'];
		$instance['type'] = $new_instance['type'];

		return $instance;
    }

    function widget($args, $instance) {
        // outputs the content of the widget
    	global $kkLikeSettings;

        $i = 1;
        extract($args);
		
        $title = apply_filters('widget_title', $instance['title']);
		$items = esc_attr($instance['items']);
		$type = esc_attr($instance['type']);
		
		if($type == 'all_post_types'){
			$type = FALSE;
		}
        
        $like = new kkDataBase;
		$posts = $like->getRandomLikes($items, $type);
		
        
        echo $before_widget;
        echo $before_title;
        echo $title;
        echo $after_title;
		
		echo '<ul class="kklike-widget kklike-most-liked">';
        foreach($posts as $post){
        	// if($i == '1'){
        		// $cls = 'kklike-big-heart';
        	// }else if($i == '2' || $i == '3'){
        		// $cls = 'kklike-small-heart';
        	// }else{
        		// $cls = 'kklike-big-heart';
        	// }
			
			$cls = 'kklike-big-heart';
        ?>
        	<li>
        		<span class="<?php echo $cls; ?>"></span>
        		<span class="kklike-wg-text">
        			<span class="kklike-wg-title"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></span>
        			<span class="kklike-wg-rating"><?php echo __('Liked:','lang-kklike'); ?> <?php echo $post->meta_value; ?></span>
        			<span class="kklike-wg-date"><?php echo __('Date:','lang-kklike'); ?> <?php echo date('d-m-Y', strtotime($post->date)); ?></span>
        		</span>
        		<span class="kkclear"></span>
        	</li>
        <?php
        	$i++;
        }
		echo '</ul>';
		
        echo $after_widget;
    }

}


add_action('widgets_init', create_function('', 'return register_widget("kklikeUserLiked");'));
class kklikeUserLiked extends WP_Widget {

	function __construct() {
		// widget actual processes
		parent::WP_Widget('kklikeUserLiked', 'KK I Like It - user liked');
	}

	function form($instance) {
		// outputs the options form on admin

		$title = esc_attr($instance['title']);
		//$items = esc_attr($instance['items']);
		
		?>
        <div>
        	<label for="<?php echo $this->get_field_id('title'); ?>">
        		<div class="kkwidget-option-title"><?php _e('Title:'); ?> </div>
        		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        	</label>
        </div>
        <!--
        <div>
        	<div class="kkwidget-option-title"><?php echo __('How many items should be displayed','lang-kklike'); ?>?</div>
        	<input type="text" id="<?php  echo $this->get_field_id('items') ?>" name="<?php echo  $this->get_field_name('items'); ?>" value="<?php echo $items; ?>" /><label class="kkwidget-option-label" for="<?php  echo $this->get_field_id('items') ?>"><?php echo __(' items.','lang-kklike'); ?></label>
        </div>
        -->

<?php
    }

    function update($new_instance, $old_instance) {
        // processes widget options to be saved
        $instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		//$instance['items'] = $new_instance['items'];

		return $instance;
    }

    function widget($args, $instance) {
        // outputs the content of the widget
        if ( is_user_logged_in() ) {
        	
	    	global $kkLikeSettings;
			
			$current_user = wp_get_current_user();
	
	        $i = 1;
	        extract($args);
			
	        $title = apply_filters('widget_title', $instance['title']);
			// $items = esc_attr($instance['items']);
	        
	        $like = new kkDataBase;
			$posts = $like->getInformation('100',$current_user->ID);
	        
	        echo $before_widget;
	        echo $before_title;
	        echo $title;
	        echo $after_title;
			if($posts){
				echo '<ul class="kklike-widget kklike-most-liked">';
		        foreach($posts as $post){
		        	
		        	// if($i == '1'){
		        		// $cls = 'kklike-big-heart';
		        	// }else if($i == '2' || $i == '3'){
		        		// $cls = 'kklike-small-heart';
		        	// }else{
		        		// $cls = 'kklike-big-heart';
		        	// }
					
					$cls = 'kklike-big-heart';
		        ?>
		        	<li>
		        		<span class="<?php echo $cls; ?>"></span>
		        		<span class="kklike-wg-text">
		        			<span class="kklike-wg-title"><a href="<?php echo get_permalink($post['ID']); ?>"><?php echo $post['post_name']; ?></a></span>
		        			<span class="kklike-wg-rating"><?php echo __('Liked:','lang-kklike'); ?> <?php echo $post['liked']; ?></span>
		        			<span class="kklike-wg-date"><?php echo __('Date:','lang-kklike'); ?> <?php echo date('d-m-Y', strtotime($post['date'])); ?></span>
		        		</span>
		        		<span class="kkclear"></span>
		        	</li>
		        <?php
		        	$i++;
		        }
				echo '</ul>';
			}else{
				echo '<div class="kklike-empty-list">' . __('Do not have favorite items.','lang-kklike') . '</div>';
			}
			
	        echo $after_widget;
		
        }
    }

}

/* ================================ */
/* ========   SHORTCODE   ========= */
/* ================================ */

function kklike_button_shortcode($atts) {
    extract(shortcode_atts(array(
                'id' 	=> false
                    ), $atts));

	$html = kkLikeButton(TRUE);
    
	return $html;
}

add_shortcode('kklike_button', 'kklike_button_shortcode');

function kklike_rating_shortcode($atts) {
    extract(shortcode_atts(array(
                'id' 	=> false
                    ), $atts));

	$html = kkLikeRating(TRUE);
    
	return $html;
}

add_shortcode('kklike_rating', 'kklike_rating_shortcode');

?>