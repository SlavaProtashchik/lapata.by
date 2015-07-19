<?php

add_action( 'widgets_init', 'register_delivery_widget' ); // function to load my widget
 
function register_delivery_widget() {
	register_widget( 'Delivery_Widget' );
}                        // function to register my widget
 
class Delivery_Widget extends WP_Widget {     // The example widget class
 
	function Delivery_Widget() {
		$widget_ops = array( 'classname' => '!Доставка', 'description' => __('Виджет доставки ', 'example') );
        $this->WP_Widget( 'delivery', __('!Доставка', 'example'), $widget_ops, $control_ops );
	}                     // Widget Settings
	 
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		$delivery_cutoff=$instance['delivery_cutoff'];

		echo $before_widget;
		 

		// код виждета
		?>
		
		<div class="delivery_widget">
			<div class="row-container">
				<div class="delivery-image-container">
					<img src="<?php echo get_template_directory_uri(); ?>/images/delivery.png" alt="Доставка lapata.by"/>
				</div>
				<div class="common_description">
					<p>Бесплатная доставка по Минску свыше</p>
					<p class="delivery-cutoff"><?php echo $delivery_cutoff; ?></p>
					<p class="regions"><a href="/dostavka">Доставка в регионы</a></p>
				</div>
			</div>
		</div>



		<?php
		echo $after_widget;
	}                        // display the widget
	 
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
	 
	    //Strip tags from title and name to remove HTML
	    $instance['title'] = strip_tags( $new_instance['title'] );
	    $instance['delivery_cutoff'] = strip_tags( $new_instance['delivery_cutoff'] );
	 
	    return $instance;
	}                        // update the widget
	 
	function form($instance) { // and of course the form for the widget options
		//Set up some default widget settings.
		$defaults = array( 'title' => __('Контакты', 'example'));
		//$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p>
		    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'example'); ?></label>
		    <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		 
		<p>
		    <label for="<?php echo $this->get_field_id( 'delivery_cutoff' ); ?>"><?php _e('Стоимостная отсечка', 'example'); ?></label>
		    <input id="<?php echo $this->get_field_id( 'delivery_cutoff' ); ?>" name="<?php echo $this->get_field_name( 'delivery_cutoff' ); ?>" type="text" value="<?php echo $instance['delivery_cutoff']; ?>" style="width:100%;" />
		</p>
<?php
	}                          
}
?>