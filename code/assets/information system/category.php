<?php get_header(); ?>
<div class="content-wrap">
	<div class="content">
	<?php tie_breadcrumbs() ?>
		<?php $category_id = get_query_var('cat') ; ?>
		<div class="page-head">
			<h1 class="page-title">
				<?php echo single_cat_title( '', false ) ?>
			</h1>
			<?php if( tie_get_option( 'category_rss' ) ): ?>
			<a class="rss-cat-icon ttip" title="<?php _e( 'Feed Subscription', 'tie' ); ?>" href="<?php echo get_category_feed_link($category_id) ?>"></a>
			<?php endif; ?>
			<div class="stripe-line"></div>

			<?php
			if( tie_get_option( 'category_desc' ) ):	
				$category_description = category_description();
				if ( ! empty( $category_description ) )
				echo '<div class="clear"></div><div class="archive-meta">' . $category_description . '</div>';
			endif;
			?>
		</div>
		<?php get_template_part( 'includes/slider-category' ) ?>
		<?php get_template_part( 'loop', 'category' );	?>
		<?php if ($wp_query->max_num_pages > 1) tie_pagenavi(); ?>
		
	</div> <!-- .content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>