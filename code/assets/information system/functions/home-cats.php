<?php 
function get_home_cats( $cat_data ){ ?>

<?php
	global $columns ;
	
	$Cat_ID = $cat_data['id'];
	$Posts_num = $cat_data['number'];
	$order = $cat_data['order'];
	$offset =  $cat_data['offset'];

	$rand = '';
	if( $order == 'rand') $rand ="&orderby=rand";

	$cat_query = new WP_Query('cat='.$Cat_ID.'&no_found_rows=1&posts_per_page='.$Posts_num.$rand.'&offset='.$offset); 
	$cat_title = get_the_category_by_ID($Cat_ID);
	$count = 0;
	$home_layout = $cat_data['style'];
	
?>
	<?php if( $home_layout == '2c'):  //************** 2C ****************************************************** ?>
		<?php $columns++; ?>
		<section class="cat-box column2 tie-cat-<?php echo $Cat_ID ?> <?php if($columns == 2) { echo 'last-column'; $columns=0; } ?>">
			<h2 class="cat-box-title"><a href="<?php echo get_category_link( $Cat_ID ); ?>"><?php echo $cat_title ; ?></a></h2>
			<div class="cat-box-content">
			
				<?php if($cat_query->have_posts()): ?>
				<ul>
				<?php while ( $cat_query->have_posts() ) : $cat_query->the_post(); $count ++ ;?>
				<?php if($count == 1) : ?>
					<li class="first-news">
						<div class="inner-content">
						<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
							<div class="post-thumbnail">
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
									<?php the_post_thumbnail( 'tie-large' ) ; ?>
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
						</div>
					</li><!-- .first-news -->
					<?php else: ?>
					<li>
						<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
							<div class="post-thumbnail">
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
									<?php the_post_thumbnail( 'tie-small' ) ; ?>
									<?php tie_get_score(); ?>
								</a>
							</div><!-- post-thumbnail /-->
						<?php endif; ?>			
						<h3 class="post-box-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
						<?php get_template_part( 'includes/boxes-meta' ); ?>
					</li>
					<?php endif; ?>
				<?php endwhile;?>
				</ul>

				<?php endif; ?>
			</div><!-- .cat-box-content /-->
		</section> <!-- Two Columns -->
		
		
	<?php elseif( $home_layout == '1c' ):  //************** 1C ******************************************************  ?>
		<section class="cat-box wide-box tie-cat-<?php echo $Cat_ID ?>">
			<h2 class="cat-box-title"><a href="<?php echo get_category_link( $Cat_ID ); ?>"><?php echo $cat_title ; ?></a></h2>
			<div class="cat-box-content">
			
				<?php $count = 0; $count2 = 0; if($cat_query->have_posts()): ?>
				<ul>
				<?php while ( $cat_query->have_posts() ) : $cat_query->the_post(); $count ++ ;?>
				<?php if($count == 1) : ?>
					<li class="first-news">
						<div class="inner-content">
						<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
							<div class="post-thumbnail">
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
									<?php the_post_thumbnail( 'tie-large' ) ; ?>
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
						</div>
					</li><!-- .first-news -->
					<?php else:  $count2 ++ ; ?>
					<li <?php if( $count2 == 2){ echo 'class="last-column"'; $count2=0;} ?>>
						<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
							<div class="post-thumbnail">
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
									<?php the_post_thumbnail( 'tie-small' ) ; ?>
									<?php tie_get_score(); ?>
								</a>
							</div><!-- post-thumbnail /-->
						<?php endif; ?>			
						<h3 class="post-box-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
						<?php get_template_part( 'includes/boxes-meta' ); ?>
					</li>
					<?php endif; ?>
				<?php endwhile;?>
				</ul>
				<div class="clear"></div>

					<?php endif; ?>
			</div><!-- .cat-box-content /-->
		</section><!-- Wide Box -->

	<?php else :   //************** list **********************************************************************************  ?>
		
		<section class="cat-box list-box tie-cat-<?php echo $Cat_ID ?>">
			<h2 class="cat-box-title"><a href="<?php echo get_category_link( $Cat_ID ); ?>"><?php echo $cat_title ; ?></a></h2>
			<div class="cat-box-content">
			
				<?php if($cat_query->have_posts()): ?>
				<ul>
				<?php while ( $cat_query->have_posts() ) : $cat_query->the_post(); $count ++ ;?>
				<?php if($count == 1) : ?>
					<li class="first-news">
						<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
							<div class="post-thumbnail">
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
									<?php the_post_thumbnail( 'tie-large' ) ; ?>
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
						</li><!-- .first-news -->
					<?php else: ?>
					<li class="other-news">
						<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
							<div class="post-thumbnail">
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
									<?php the_post_thumbnail( 'tie-small' ) ; ?>
									<?php tie_get_score(); ?>
								</a>
							</div><!-- post-thumbnail /-->
						<?php endif; ?>			
						<h3 class="post-box-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
						<?php get_template_part( 'includes/boxes-meta' ); ?>
					</li>
					<?php endif; ?>
				<?php endwhile;?>
				</ul>
				<div class="clear"></div>

					<?php endif; ?>
			</div><!-- .cat-box-content /-->
		</section><!-- List Box -->

	<?php endif; ?>
	
	
<?php } ?>