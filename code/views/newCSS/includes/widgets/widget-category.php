<?php
add_action( 'widgets_init', 'categort_posts_widget' );
function categort_posts_widget() {
	register_widget( 'categort_posts' );
}
class categort_posts extends WP_Widget {

	function categort_posts() {
		$widget_ops = array( 'classname' => 'categort-posts' );
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'categort-posts-widget' );
		$this->WP_Widget( 'categort-posts-widget',theme_name .' - Category Posts', $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['cat_posts_title'] );
		$no_of_posts = $instance['no_of_posts'];
		$cats_id = $instance['cats_id'];
		$thumb = $instance['thumb'];

		echo $before_widget;
			echo $before_title;
			echo $title ; ?>
		<?php echo $after_title; ?>
				<ul>
					<?php tie_last_posts_cat($no_of_posts , $thumb , $cats_id)?>	
				</ul>
		<div class="clear"></div>
	<?php 
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['cat_posts_title'] = strip_tags( $new_instance['cat_posts_title'] );
		$instance['no_of_posts'] = strip_tags( $new_instance['no_of_posts'] );
		
		$instance['cats_id'] = implode(',' , $new_instance['cats_id']  );

		$instance['thumb'] = strip_tags( $new_instance['thumb'] );
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'cat_posts_title' =>__( 'Category Posts' , 'tie'), 'no_of_posts' => '5' , 'cats_id' => '1' , 'thumb' => 'true' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$categories_obj = get_categories('hide_empty=0');
		$categories = array();

		foreach ($categories_obj as $pn_cat) {
			$categories[$pn_cat->cat_ID] = $pn_cat->cat_name;
		}
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'cat_posts_title' ); ?>">Title : </label>
			<input id="<?php echo $this->get_field_id( 'cat_posts_title' ); ?>" name="<?php echo $this->get_field_name( 'cat_posts_title' ); ?>" value="<?php echo $instance['cat_posts_title']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'no_of_posts' ); ?>">Number of posts to show: </label>
			<input id="<?php echo $this->get_field_id( 'no_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'no_of_posts' ); ?>" value="<?php echo $instance['no_of_posts']; ?>" type="text" size="3" />
		</p>
		<p>
			<?php $cats_id = explode ( ',' , $instance['cats_id'] ) ; ?>
			<label for="<?php echo $this->get_field_id( 'cats_id' ); ?>">Category : </label>
			<select multiple="multiple" id="<?php echo $this->get_field_id( 'cats_id' ); ?>[]" name="<?php echo $this->get_field_name( 'cats_id' ); ?>[]">
				<?php foreach ($categories as $key => $option) { ?>
				<option value="<?php echo $key ?>" <?php if ( in_array( $key , $cats_id ) ) { echo ' selected="selected"' ; } ?>><?php echo $option; ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'thumb' ); ?>">Display Thumbinals : </label>
			<input id="<?php echo $this->get_field_id( 'thumb' ); ?>" name="<?php echo $this->get_field_name( 'thumb' ); ?>" value="true" <?php if( $instance['thumb'] ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>

	<?php
	}
}
?>