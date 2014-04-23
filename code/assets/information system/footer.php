		<div class="clear"></div>
	</div><!-- .container /-->
	
	<?php tie_banner('banner_bottom' , '<div class="ads-bottom">' , '</div>' ); ?>
	</div><!-- .container -->

	<?php get_sidebar( 'footer' ); ?>				
	<div class="clear"></div>
	<div class="footer-bottom fade-in animated4">
		<div class="container">
			<?php if( tie_get_option('footer_social') ) tie_get_social( 'yes' , 'flat' , 'ttip' , true ); ?>
			<div class="alignleft">
			<?php
				$footer_vars = array('%year%' , '%site%' , '%url%');
				$footer_val  = array( date('Y') , get_bloginfo('name') , home_url() );
				$footer_one  = str_replace( $footer_vars , $footer_val , tie_get_option( 'footer_one' ));
				echo htmlspecialchars_decode( $footer_one );
			?>
			</div>
		</div><!-- .Container -->
	</div><!-- .Footer bottom -->
	
</div><!-- .Wrapper -->
<?php if( tie_get_option('footer_top') ): ?>
	<div id="topcontrol" class="tieicon-up-open" title="<?php _e('Scroll To Top' , 'tie'); ?>"></div>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>