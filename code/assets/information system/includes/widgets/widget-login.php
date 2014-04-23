<?php
add_action( 'widgets_init', 'tie_login_widget' );
function tie_login_widget() {
	register_widget( 'login_widget' );
}
class login_widget extends WP_Widget {

	function login_widget() {
		$widget_ops = array( 'classname' => 'login-widget'  );
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'login-widget' );
		$this->WP_Widget( 'login-widget',theme_name .' - Login', $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['text_html_title'] );
		$text_code = $instance['text_code'];
		$tran_bg = $instance['tran_bg'];
		$center = $instance['center'];
		
		if ($center)
			$center = 'style="text-align:center;"';
		else
			$center = '';

		
			echo $before_widget;
			echo $before_title;
			echo $title ; 
			echo $after_title;
			tie_login_form();
			
			echo $after_widget;
		
			
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['text_html_title'] = strip_tags( $new_instance['text_html_title'] );
		$instance['text_code'] = $new_instance['text_code'] ;
		$instance['tran_bg'] = strip_tags( $new_instance['tran_bg'] );
		$instance['center'] = strip_tags( $new_instance['center'] );
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'text_html_title' =>__('Login' , 'tie')  );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'text_html_title' ); ?>">Title : </label>
			<input id="<?php echo $this->get_field_id( 'text_html_title' ); ?>" name="<?php echo $this->get_field_name( 'text_html_title' ); ?>" value="<?php echo $instance['text_html_title']; ?>" class="widefat" type="text" />
		</p>



	<?php
	}
}
?>