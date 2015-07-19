<?php

function format_phone($phone) {
	$arr_phone=explode("|",$phone);
	$result='<span class="prefix">'.$arr_phone[0].'</span>'.$arr_phone[1];
	return $result;
}

add_action( 'widgets_init', 'register_contact_delivery_widget' ); // function to load my widget
 
function register_contact_delivery_widget() {
	register_widget( 'Contact_Delivery_Widget' );
}                        // function to register my widget
 
class Contact_Delivery_Widget extends WP_Widget {     // The example widget class
 
	function Contact_Delivery_Widget() {
		$widget_ops = array( 'classname' => '!Контакты и доставка', 'description' => __('Виджет контактов и доставки', 'example') );
        $this->WP_Widget( 'contacts_delivery', __('!Контакты и доставка', 'example'), $widget_ops, $control_ops );
	}                     // Widget Settings
	 
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		$work_hours=$instance['work_hours'];
		$work_days=$instance['work_days'];
		$delivery_hours=$instance['delivery_hours'];
		$delivery_days=$instance['delivery_days'];
		$contacts['p_velcom']=$instance['p_velcom'];
		$contacts['p_mts']=$instance['p_mts'];
		$contacts['p_life']=$instance['p_life'];
		$contacts['p_home']=$instance['p_home'];
		$contacts['skype']=$instance['skype'];
		$contacts['mail']=$instance['mail'];
		$delivery_cutoff=$instance['delivery_cutoff'];
		$delivery_region=$instance['delivery_region'];

		echo $before_widget;
		 

		// код виждета
		?>
		
		<div class="contact_delivery_widget" itemscope itemtype="http://schema.org/LocalBusiness">
			<div class="row-container">
				<div class="phones">
					<h2>Контакты:</h2>
					<?php
					if ($contacts['p_mts'])  printf('<p class="mts" itemprop="telephone">'.format_phone($contacts['p_mts']).'</p>');
					if ($contacts['p_velcom'])  printf('<p class="velcom" itemprop="telephone">'.format_phone($contacts['p_velcom']).'</p>');
					if ($contacts['p_life'])  printf('<p class="life" itemprop="telephone">'.format_phone($contacts['p_life']).'</p>');
					if ($contacts['p_home'])  printf('<p class="home" itemprop="telephone">'.format_phone($contacts['p_home']).'</p>');
					?>
				</div>
				<div class="work_hours">
				<?php
					if ($work_hours) {
						printf( '<h2>Время работы:</h2><p class="hours">'.$work_hours.'</p>');
						printf( '<p class="days">'.$work_days.'</p>');
						printf('<br>');
						printf( '<h2>Время доставки:</h2><p class="hours">'.$delivery_hours.'</p>');
						printf( '<p class="days">'.$delivery_days.'</p>');
					}
				?>
				</div>
				<div class="consult">
					<h3>Консультация:</h3>
					<?php
					if ($contacts['skype'])  printf('<p class="skype"><span class="prefix"></span>'.$contacts['skype'].'</p>');
					if ($contacts['mail'])  printf('<p class="mail" itemprop="email"><span class="prefix"></span>'.$contacts['mail'].'</p>');
					?>
				</div>
				<div class="delivery">
					<div class="delivery-image-container hidden-md hidden-sm">
						<img src="<?php echo get_template_directory_uri(); ?>/images/delivery.png" alt="Доставка lapata.by"/>
					</div>
					<div class="common_description">
						<p>Бесплатная доставка по Минску свыше</p>
						<p class="delivery-cutoff"><?php echo $delivery_cutoff; ?></p>
						<p class="regions"><a href="/dostavka">Доставка в регионы</a></p>
						<p class="delivery-cutoff"><?php echo $delivery_region; ?></p>
					</div>					
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
	    $instance['work_hours'] = strip_tags( $new_instance['work_hours'] );
	    $instance['work_days'] = strip_tags( $new_instance['work_days'] );
	    $instance['delivery_hours'] = strip_tags( $new_instance['delivery_hours'] );
	    $instance['delivery_days'] = strip_tags( $new_instance['delivery_days'] );
	    $instance['p_velcom'] = strip_tags( $new_instance['p_velcom'] );
	    $instance['p_mts'] = strip_tags( $new_instance['p_mts'] );
	    $instance['p_life'] = strip_tags( $new_instance['p_life'] );
	    $instance['p_home'] = strip_tags( $new_instance['p_home'] );
	    $instance['skype'] = strip_tags( $new_instance['skype'] );
	    $instance['mail'] = strip_tags( $new_instance['mail'] );
	    $instance['delivery_cutoff'] = strip_tags( $new_instance['delivery_cutoff'] );
	    $instance['delivery_region'] = strip_tags( $new_instance['delivery_region'] );
	 
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
		    <label for="<?php echo $this->get_field_id( 'work_hours' ); ?>"><?php _e('Часы работы', 'example'); ?></label>
		    <input id="<?php echo $this->get_field_id( 'work_hours' ); ?>" name="<?php echo $this->get_field_name( 'work_hours' ); ?>" type="text" value="<?php echo $instance['work_hours']; ?>" style="width:100%;" />
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id( 'work_days' ); ?>"><?php _e('Дни работы', 'example'); ?></label>
		    <input id="<?php echo $this->get_field_id( 'work_days' ); ?>" name="<?php echo $this->get_field_name( 'work_days' ); ?>" type="text" value="<?php echo $instance['work_days']; ?>" style="width:100%;" />
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id( 'delivery_hours' ); ?>"><?php _e('Часы доставки', 'example'); ?></label>
		    <input id="<?php echo $this->get_field_id( 'delivery_hours' ); ?>" name="<?php echo $this->get_field_name( 'delivery_hours' ); ?>" type="text" value="<?php echo $instance['delivery_hours']; ?>" style="width:100%;" />
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id( 'delivery_days' ); ?>"><?php _e('Дни доставки', 'example'); ?></label>
		    <input id="<?php echo $this->get_field_id( 'delivery_days' ); ?>" name="<?php echo $this->get_field_name( 'delivery_days' ); ?>" type="text" value="<?php echo $instance['delivery_days']; ?>" style="width:100%;" />
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id( 'p_velcom' ); ?>"><?php _e('Velcom', 'example'); ?></label>
		    <input id="<?php echo $this->get_field_id( 'p_velcom' ); ?>" name="<?php echo $this->get_field_name( 'p_velcom' ); ?>" type="text" value="<?php echo $instance['p_velcom']; ?>" style="width:100%;" />
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id( 'p_mts' ); ?>"><?php _e('MTS', 'example'); ?></label>
		    <input id="<?php echo $this->get_field_id( 'p_mts' ); ?>" name="<?php echo $this->get_field_name( 'p_mts' ); ?>" type="text" value="<?php echo $instance['p_mts']; ?>" style="width:100%;" />
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id( 'p_life' ); ?>"><?php _e('Life', 'example'); ?></label>
		    <input id="<?php echo $this->get_field_id( 'p_life' ); ?>" name="<?php echo $this->get_field_name( 'p_life' ); ?>" type="text" value="<?php echo $instance['p_life']; ?>" style="width:100%;" />
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id( 'p_home' ); ?>"><?php _e('Домашний', 'example'); ?></label>
		    <input id="<?php echo $this->get_field_id( 'p_home' ); ?>" name="<?php echo $this->get_field_name( 'p_home' ); ?>" type="text" value="<?php echo $instance['p_home']; ?>" style="width:100%;" />
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id( 'skype' ); ?>"><?php _e('Skype', 'example'); ?></label>
		    <input id="<?php echo $this->get_field_id( 'skype' ); ?>" name="<?php echo $this->get_field_name( 'skype' ); ?>" type="text" value="<?php echo $instance['skype']; ?>" style="width:100%;" />
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id( 'mail' ); ?>"><?php _e('Почта', 'example'); ?></label>
		    <input id="<?php echo $this->get_field_id( 'mail' ); ?>" name="<?php echo $this->get_field_name( 'mail' ); ?>" type="text" value="<?php echo $instance['mail']; ?>" style="width:100%;" />
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id( 'delivery_cutoff' ); ?>"><?php _e('Стоимостная отсечка', 'example'); ?></label>
		    <input id="<?php echo $this->get_field_id( 'delivery_cutoff' ); ?>" name="<?php echo $this->get_field_name( 'delivery_cutoff' ); ?>" type="text" value="<?php echo $instance['delivery_cutoff']; ?>" style="width:100%;" />
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id( 'delivery_region' ); ?>"><?php _e('Стоимость в регионы', 'example'); ?></label>
		    <input id="<?php echo $this->get_field_id( 'delivery_region' ); ?>" name="<?php echo $this->get_field_name( 'delivery_region' ); ?>" type="text" value="<?php echo $instance['delivery_region']; ?>" style="width:100%;" />
		</p>
<?php
	}                          
}
?>