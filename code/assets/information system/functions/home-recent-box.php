<?php
function get_home_recent( $cat_data ){

	$exclude = $cat_data['exclude'];
	$Posts_num = $cat_data['number'];
	$Box_Title = $cat_data['title'];
	$display = $cat_data['display'];
	$pagination = $cat_data['pagi'];
	$offset =  $cat_data['offset'];
	
	$count_recent = 0;
	
	$args = array ( 'posts_per_page' => $Posts_num , 'category__not_in' => $exclude, 'offset' => $offset, 'ignore_sticky_posts' => 1  );
	if ( !empty( $pagination ) && $pagination == 'y' ) $args[ 'paged' ] = get_query_var('paged');
	else $args[ 'no_found_rows' ] = 1;
	
	$cat_query = new WP_Query( $args ); 
	
?>
		<section class="cat-box recent-box">
			<h2 class="cat-box-title"><?php if( function_exists('icl_t') ) echo icl_t( theme_name , $cat_data['boxid'] , $Box_Title); else echo $Box_Title ; ?></h2>

			<div class="cat-box-content">
			
				<?php if($cat_query->have_posts()): ?>

				<?php while ( $cat_query->have_posts() ) : $cat_query->the_post()?>
				<?php if( $display == 'blog' ): $count_recent++; ?>
					<article class="item-list recent-post<?php echo $count_recent; ?> recent-post-<?php echo $display ?>">

						<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
						<div class="post-thumbnail">
							<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
								<?php $image_id = get_post_thumbnail_id($post->ID);  
						echo $image_url = wp_get_attachment_image($image_id, array(300,160) );   ?>
								<?php tie_get_score( true ); ?>
							</a>
						</div><!-- post-thumbnail /-->
						<?php else: ?>
						<div class="empty-space"></div>
						<?php endif; ?>

						<h2 class="post-box-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<?php get_template_part( 'includes/boxes-meta' ); ?>
						<div class="entry">
							<p><?php tie_excerpt_home() ?></p>
							<a class="more-link" href="<?php the_permalink() ?>"><?php _e( 'Read More &raquo;', 'tie' ) ?></a>
						</div>
						
						<?php  if( tie_get_option( 'archives_socail' ) ) get_template_part( 'includes/post-share' ); // Get Share Button template ?>
						<div class="clear"></div>
					</article><!-- .item-list -->
				<?php else: ?>
					<div class="recent-item">
						<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
							<div class="post-thumbnail">
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
									<?php the_post_thumbnail( 'tie-large' ) ; ?>
									<?php tie_get_score( ); ?>
								</a>
							</div><!-- post-thumbnail /-->
						<?php else: ?>
						<div class="empty-space"></div>
						<?php endif; ?>

						<h3 class="post-box-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
						<p class="post-meta">
							<?php tie_get_time() ?>
						</p>
					</div>
				<?php endif; ?>
				<?php endwhile;?>
				<div class="clear"></div>

			<?php endif; ?>
			</div><!-- .cat-box-content /-->
		</section>
		<?php if ( !empty( $pagination ) && $pagination == 'y' && empty($offset) && $cat_query->max_num_pages > 1){?> <div class="recent-box-pagination"><?php tie_pagenavi($cat_query , $Posts); ?> </div> <?php } ?>
		<div class="clear"></div>
<?php
}
?>