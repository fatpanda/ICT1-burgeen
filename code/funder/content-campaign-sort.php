<div class="sort-tabs" id="filter">
				
	<h3><?php _e( 'Show', 'funder' ); ?></h3>
	<div class="dropdown">
		<div class="current">
			<?php if ( is_tax( 'download_category' ) ) : ?>
				<?php single_term_title(); ?>
			<?php else : ?>
				<?php _e( 'All', 'funder' ); ?>
			<?php endif; ?>
		</div>
		
		<ul class="option-set">
			<li><a href="<?php echo get_post_type_archive_link( 'download' ); ?>">All</a></li>
			<?php
				$categories = get_terms( funder_is_crowdfunding() ? 'download_category' : 'category', array( 'hide_empty' => 0 ) );
				foreach ( $categories as $category ) :
			?>
			<li><a href="<?php echo esc_url( get_term_link( $category, 'download_category' ) ); ?>"><?php echo $category->name; ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>

	<?php if ( funder_is_crowdfunding()  ) : ?>
	<ul class="option-set home">
		<?php if ( funder_page_template_link( 'new-this-week.php' ) ) : ?>
		<li><a href="<?php echo funder_page_template_link( 'new-this-week.php' ); ?>" data-filter=".new-this-week"><?php _e( 'New this Week', 'funder' ); ?></a></li>
		<?php endif; ?>

		<?php if ( funder_page_template_link( 'staff-picks.php' ) ) : ?>
		<li><a href="<?php echo funder_page_template_link( 'staff-picks.php' ); ?>" data-filter=".staff-pick"><?php _e( 'Staff Picks', 'funder' ); ?></a></li>
		<?php endif; ?>
	</ul>
	<?php endif; ?>
</div>