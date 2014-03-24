<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package techism
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'techism' ); ?>
		</div>
		<?php endif; ?>
		
		<header class="entry-header">
			
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'techism' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			
		<?php if ( 'post' == get_post_type() ) : ?>	
		<div class="entry-meta">
			<?php techism_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
		
		</header><!-- .entry-header -->
		
		<div class="entry-thumbnail">
			<?php if( has_post_thumbnail() ) {
			the_post_thumbnail('thumbnail');
			}
			?>
		</div>
	<div class="entry-content">
	<?php if(is_home() && get_theme_mod( 'techism_home_content' ) == '0') : ?>
		<?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'techism' ) ); ?> 
		<?php echo '<a class="readmore more-link" href="' . get_permalink() . '" title="'.the_title( '', '', false ).'">'.__( 'Read more', 'techism' ).'</a>'; ?>
		<?php else: ?>
		<?php the_content(); ?>
        <?php endif; ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'techism' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'techism' ) );
				if ( $categories_list && techism_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'techism' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="sep"> | </span>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'techism' ), __( '1 Comment', 'techism' ), __( '% Comments', 'techism' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'techism' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
	</article><!-- #post -->
