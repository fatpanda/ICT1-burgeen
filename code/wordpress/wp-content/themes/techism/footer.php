<?php
/**
 * The template for displaying the footer
 *
 * @package techism
 */
?>
	</div><!-- #main .wrapper -->
	
		<div id="footer-sidebar" class="container widget-area">
	<!--footer sidebar-->
	<div id="footer-1" class="footer-sidebar" role="complementary">
		<ul class="foo">	
				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
				<?php dynamic_sidebar( 'footer-1' ); ?>
				<?php endif; ?>
	</div><!-- #footer-sidebar 1 -->

	<div id="footer-2" class="footer-sidebar" role="complementary">
		<ul class="foo">	
				<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
				<?php dynamic_sidebar( 'footer-2' ); ?>
				<?php endif; ?>
	</div><!-- #footer-sidebar 2 -->

	<div id="footer-3" class="footer-sidebar" role="complementary">
		<ul class="foo">	
				<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
				<?php dynamic_sidebar( 'footer-3' ); ?>
				<?php endif; ?>
	</div><!-- #footer-sidebar 3 -->

	<div id="footer-4" class="footer-sidebar" role="complementary">
		<ul class="foo">	
				<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
				<?php dynamic_sidebar( 'footer-4' ); ?>
				<?php endif; ?>
	</div><!-- #footer-sidebar 4 -->
		
		</div>
		
	
	<footer id="colophon" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'techism_credits' ); ?>
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'techism' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'techism' ); ?>"><?php printf( __( 'Proudly powered by %s', 'techism' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'techism' ), 'techism','<a href="'.esc_url( 'http://setwp.com/techism-wordpress-theme/' ).'">Rajeeb Banstola</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>