<?php
	
class A2A_SHARE_SAVE_Widget extends WP_Widget {
	/** constructor */
    function A2A_SHARE_SAVE_Widget() {
        parent::WP_Widget('', 'AddToAny Sharing', array('description' => 'Help people share, bookmark, and email your posts & pages using any service, such as Facebook, Twitter, StumbleUpon, Digg and many more.'), array('width' => 400));	
    }
	
	/** Backwards compatibility for A2A_SHARE_SAVE_Widget::display(); usage */
	function display( $args = false ) {
		self::widget($args, NULL);
	}

    /** @see WP_Widget::widget */	
	function widget($args = array(), $instance) {
	
		global $A2A_SUBSCRIBE_plugin_url_path;
		
		$defaults = array(
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '',
			'after_title' => '',
		);
		
		$args = wp_parse_args( $args, $defaults );
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		
		echo $before_widget;
		
		if ($title) {
			echo $before_title . $title . $after_title;
		}
		
		ADDTOANY_SHARE_SAVE_KIT(array(
			"use_current_page" => TRUE
		));

		echo $after_widget;
	}
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
    }
	
	/** @see WP_Widget::form */
    function form($instance) {
    	$title = (isset($instance) && isset($instance['title'])) ? esc_attr($instance['title']) : '';
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
	    	<a href="options-general.php?page=add-to-any.php"><?php _e("Settings", "add-to-any"); ?>...</a>
		</p>
		<?php
    }
	
}

