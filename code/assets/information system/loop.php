<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post not-found post-listing">
		<h2 class="post-title"><?php _e( 'Not Found', 'tie' ); ?></h2>
		<div class="entry">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'tie' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</div>

<?php else : $count = 0;?>
<div class="post-listing <?php if( tie_get_option( 'blog_display' ) == '2col' ) echo"archives_2col" ?>">
<?php while ( have_posts() ) : the_post(); $count++; ?>
<?php if( tie_get_option( 'blog_display' ) != 'full_thumb' ): ?>
	<article class="item-list <?php echo'item_'.$count; ?>">
		<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php get_template_part( 'includes/archives-meta' ); ?>						
		<?php if( tie_get_option( 'blog_display' ) == 'content' ): ?>
		<div class="entry">
			<?php the_content( __( 'Read More &raquo;', 'tie' ) ); ?>
		</div>
		<?php else: ?>
			<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
				<?php the_post_thumbnail( 'tie-large' ); ?>
				<?php tie_get_score( true ); ?>
			</a>
		</div><!-- post-thumbnail /-->
			<?php endif; ?>
		<div class="entry">
			<p><?php tie_excerpt() ?></p>
			<a class="more-link" href="<?php the_permalink() ?>"><?php _e( 'Read More &raquo;', 'tie' ) ?></a>
		</div>
		<?php endif; ?>

		<?php if( tie_get_option( 'archives_socail' ) ) get_template_part( 'includes/post-share' );  // Get Share Button template ?>
		<div class="clear"></div>
	</article><!-- .item-list -->
	<?php if( $count == 2 &&  tie_get_option( 'blog_display' ) == '2col' ): $count = 0; ?>
		<div class="sep"></div>
	<?php endif; ?>
<?php else: ?>
	<article class="item-list">
		<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
		<div class="post-thumbnail single-post-thumb archive-wide-thumb">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'slider' ); ?><?php tie_get_score( true ); ?></a>
		</div>
		<?php endif; ?>
		<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php get_template_part( 'includes/archives-meta' ); ?>					
		<div class="entry">
			<p><?php tie_excerpt() ?></p>
			<a class="more-link" href="<?php the_permalink() ?>"><?php _e( 'Read More &raquo;', 'tie' ) ?></a>
		</div>
		<?php if( tie_get_option( 'archives_socail' ) ) get_template_part( 'includes/post-share' );  // Get Share Button template ?>
		<div class="clear"></div>
	</article><!-- .item-list -->
<?php endif; ?>
	
<?php endwhile;?>
</div>
<?php endif; ?>