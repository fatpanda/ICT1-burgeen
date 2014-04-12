<?php global $post; ?>
<p class="post-meta">
<?php if( tie_get_option( 'box_meta_author' ) ): ?>		
	<span class="post-meta-author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" title="<?php sprintf( esc_attr__( 'View all posts by %s', 'tie' ), get_the_author() ) ?>"><?php echo get_the_author() ?> </a></span>
<?php endif; ?>	
<?php if( tie_get_option( 'box_meta_date' ) ): ?>		
	<?php tie_get_time() ?>
<?php endif; ?>	
<?php if( tie_get_option( 'box_meta_cats' ) ): ?>
	<span class="post-cats"><?php printf('%1$s', get_the_category_list( ', ' ) ); ?></span>
<?php endif; ?>	
<?php if( tie_get_option( 'box_meta_comments' ) ): ?>
	<span class="post-comments"><?php comments_popup_link( __( 'Leave a comment', 'tie' ), __( '1 Comment', 'tie' ), __( '% Comments', 'tie' ) ); ?></span>
<?php endif; ?>
<?php if( tie_get_option( 'box_meta_views' ) ) echo tie_views(); ?>
</p>
