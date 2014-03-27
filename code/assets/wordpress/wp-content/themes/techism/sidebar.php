<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package techism
 */
?>

	<div id="left-sidebar" class="widget-area" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>

				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-1') ): ?>
					
				<?php endif; ?>
	</div><!-- #left-sidebar -->


	<div id="right-sidebar" class="widget-area" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>

				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-2') ): ?>

				<?php endif; ?>
	</div><!-- #right-sidebar -->