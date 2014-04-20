<?php
## widget_tabs
add_action( 'widgets_init', 'widget_tabs_box' );
function widget_tabs_box(){
	register_widget( 'widget_tabs' );
}
class widget_tabs extends WP_Widget {
	function widget_tabs() {
		$widget_ops = array( 'description' => 'Most Popular, Recent, Comments, Tags'  );
		$this->WP_Widget( 'widget_tabs',theme_name .'- Tabbed  ', $widget_ops );
	}
	function widget( $args, $instance ) {
		extract( $args );
		$posts_order = $instance['posts_order'];
		if( empty($instance['posts_number']) || $instance['posts_number'] == ' ' || !is_numeric($instance['posts_number']))	$posts_number = 5;
		else $posts_number = $instance['posts_number'];
	?>
	<div class="widget" id="tabbed-widget">
		<div class="widget-container">
			<div class="widget-top">
				<ul class="tabs posts-taps">
					<li class="tabs"><a href="#tab1"><?php _e( 'Popular' , 'tie' ) ?></a></li>
					<li class="tabs"><a href="#tab2"><?php _e( 'Recent' , 'tie' ) ?></a></li>
					<li class="tabs" style="margin-left:0; "><a href="#tab3"><?php _e( 'Comments' , 'tie' ) ?></a></li>
				</ul>
			</div>
			<div id="tab1" class="tabs-wrap">
				<ul>
					<?php if( $posts_order == 'viewed' ) tie_most_viewed_posts( $posts_number  );
						else tie_popular_posts( $posts_number  );
					?>	
				</ul>
			</div>
			<div id="tab2" class="tabs-wrap">
				<ul>
					<?php tie_last_posts( $posts_number  )?>	
				</ul>
			</div>
			<div id="tab3" class="tabs-wrap">
				<ul>
					<?php tie_most_commented( $posts_number  );?>
				</ul>
			</div>
		</div>
	</div><!-- .widget /-->
<?php
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['posts_order'] = strip_tags( $new_instance['posts_order'] );
		$instance['posts_number'] = strip_tags( $new_instance['posts_number'] );
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'posts_order' => 'popular', 'posts_number' => 5 );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'posts_number' ); ?>">Number of items to show : </label>
			<input id="<?php echo $this->get_field_id( 'posts_number' ); ?>" name="<?php echo $this->get_field_name( 'posts_number' ); ?>" value="<?php echo $instance['posts_number']; ?>" size="3" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'posts_order' ); ?>">Popular order : </label>
			<select id="<?php echo $this->get_field_id( 'posts_order' ); ?>" name="<?php echo $this->get_field_name( 'posts_order' ); ?>" >
				<option value="popular" <?php if( $instance['posts_order'] == 'popular' ) echo "selected=\"selected\""; else echo ""; ?>>Most Commented</option>
				<option value="viewed" <?php if( $instance['posts_order'] == 'viewed' ) echo "selected=\"selected\""; else echo ""; ?>>Most Viewed</option>
			</select>
		</p>
	<?php
	}
}
?>
