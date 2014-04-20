<?php
add_action( 'widgets_init', 'author_custom_widget' );
function author_custom_widget() {
	register_widget( 'author_custom' );
}
class author_custom extends WP_Widget {

	function author_custom() {
		$widget_ops = array( 'classname' => 'author-custom'  );
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'author-custom-widget' );
		$this->WP_Widget( 'author-custom-widget',theme_name .' - Custom Author Content', $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['text_html_title'] );
		$tran_bg = $instance['tran_bg'];
		$center = $instance['center'];
		
		if ($center)
			$center = 'style="text-align:center;"';
		else
			$center = '';
			
		wp_reset_query();
		if ( get_the_author_meta( 'author_widget_content' ) && is_single() ) {
			$text_code = get_the_author_meta( 'author_widget_content' );
			if( !$tran_bg ){
				echo $before_widget;
				echo $before_title;
				echo $title ; 
				echo $after_title;
				echo '<div '.$center.'>';
				echo do_shortcode( $text_code ) .'
					</div><div class="clear"></div>';
				echo $after_widget;
			}
			else {?>
				<div class="text-html-box" <?php echo $center ?>>
				<?php echo do_shortcode( $text_code ) ?>
				</div>
			<?php
			}
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['text_html_title'] = strip_tags( $new_instance['text_html_title'] );
		$instance['tran_bg'] = strip_tags( $new_instance['tran_bg'] );
		$instance['center'] = strip_tags( $new_instance['center'] );
		return $instance;
	}

	function form( $instance ) {
		//$defaults = array( 'text_html_title' =>__('Text' , 'tie')  );
		//$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p><em style="color:red;">This Widget appears in single post only .</em></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'text_html_title' ); ?>">Title : </label>
			<input id="<?php echo $this->get_field_id( 'text_html_title' ); ?>" name="<?php echo $this->get_field_name( 'text_html_title' ); ?>" value="<?php echo $instance['text_html_title']; ?>" class="widefat" type="text" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'tran_bg' ); ?>">Transparent Background :</label>
			<input id="<?php echo $this->get_field_id( 'tran_bg' ); ?>" name="<?php echo $this->get_field_name( 'tran_bg' ); ?>" value="true" <?php if( $instance['tran_bg'] ) echo 'checked="checked"'; ?> type="checkbox" />
			<br /><small>if this active the title will disappear</small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'center' ); ?>">Center content :</label>
			<input id="<?php echo $this->get_field_id( 'center' ); ?>" name="<?php echo $this->get_field_name( 'center' ); ?>" value="true" <?php if( $instance['center'] ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>
		


	<?php
	}
}
?>