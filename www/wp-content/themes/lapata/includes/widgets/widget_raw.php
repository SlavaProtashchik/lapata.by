<?php
add_action( 'widgets_init', 'register_contact_widget' ); // function to load my widget
 
function register_contact_widget() {
	register_widget( 'Contact_Widget' );
}                        // function to register my widget
 
class Contact_Widget extends WP_Widget {     // The example widget class
 
	function Contact_Widget() {
		$widget_ops = array( 'classname' => 'example', 'description' => __('A widget that displays the authors name ', 'example') );
        $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'example-widget' );
        $this->WP_Widget( 'example-widget', __('Example Widget', 'example'), $widget_ops, $control_ops );
	}                     // Widget Settings
	 
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		$name = $instance['name'];
		$show_info = isset( $instance['show_info'] ) ? $instance['show_info'] : false;
	
		echo $before_widget;
		 
		// Display the widget title 
		if ( $title )
		    echo $before_title . $title . $after_title;
		 
		//Display the name 
		if ( $name )
		    printf( '<p>' . __('Hey their Sailor! My name is %1$s.', 'example') . '</p>', $name );
		 
		if ( $show_info )
		    printf( $name );
		 
		echo $after_widget;
	}                        // display the widget
	 
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
	 
	    //Strip tags from title and name to remove HTML
	    $instance['title'] = strip_tags( $new_instance['title'] );
	    $instance['name'] = strip_tags( $new_instance['name'] );
	    $instance['show_info'] = $new_instance['show_info'];
	 
	    return $instance;
	}                        // update the widget
	 
	function form() { // and of course the form for the widget options
		//Set up some default widget settings.
		$defaults = array( 'title' => __('Example', 'example'), 'name' => __('Bilal Shaheen', 'example'), 'show_info' => true );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		// Widget Title: Text Input
		<p>
		    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'example'); ?></label>
		    <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		 
		//Text Input 
		<p>
		    <label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e('Your Name:', 'example'); ?></label>
		    <input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo $instance['name']; ?>" style="width:100%;" />
		</p>
		 
		 
		// Checkbox
		<p>
		    <input class="checkbox" type="checkbox" <?php checked( $instance['show_info'], true ); ?> id="<?php echo $this->get_field_id( 'show_info' ); ?>" name="<?php echo $this->get_field_name( 'show_info' ); ?>" /> 
		    <label for="<?php echo $this->get_field_id( 'show_info' ); ?>"><?php _e('Display info publicly?', 'example'); ?></label>
		</p>
<?php
	}                          
}
?>