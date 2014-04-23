<?php
function get_home_scroll( $cat_data ){ ?>
	
<?php
    wp_enqueue_script( 'tie-cycle' );

	$Cat_ID = $cat_data['id'];
	$Posts_num = $cat_data['number'];
	$Box_Title = $cat_data['title'];
	$offset =  $cat_data['offset'];

	$cat_query = new WP_Query('cat='.$Cat_ID.'&no_found_rows=1&posts_per_page='.$Posts_num.'&offset='.$offset); 
?>
		<section class="cat-box scroll-box tie-cat-<?php echo $Cat_ID ?>">
			<h2 class="cat-box-title"><a href="<?php echo get_category_link( $Cat_ID ); ?>"><?php if( function_exists('icl_t') ) echo icl_t( theme_name , $cat_data['boxid'] , $Box_Title); else echo $Box_Title ; ?></a></h2>

			<div class="cat-box-content">
				<?php if($cat_query->have_posts()): ?>
				<div class="group_items-box" id="slideshow<?php echo $Cat_ID ?>">
				<?php while ( $cat_query->have_posts() ) : $cat_query->the_post()?>
					<div class="scroll-item">
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
				<?php endwhile;?>
				<div class="clear"></div>
				</div>
				<div class="scroll-nav"><a id="next<?php echo $Cat_ID ?>" href="#"><i class="tieicon-right-open"></i></a><a class="prev-scroll" id="prev<?php echo $Cat_ID ?>" href="#"><i class="tieicon-left-open"></i></a></div>


					<?php endif; ?>
			</div><!-- .cat-box-content /-->
		</section>
		<div class="clear"></div>


<script type="text/javascript">
	jQuery(document).ready(function() {
		var vids = jQuery("#slideshow<?php echo $Cat_ID ?> .scroll-item");
		for(var i = 0; i < vids.length; i+=3) {
		  vids.slice(i, i+3).wrapAll('<div class="group_items"></div>');
		}
		jQuery(function() {
			jQuery('#slideshow<?php echo $Cat_ID ?>').cycle({
				fx:     'scrollHorz',
				timeout: 3000,
				//pager:  '#nav<?php echo $Cat_ID ?>',
				slideExpr: '.group_items',
				prev:   '#prev<?php echo $Cat_ID ?>', 
				next:   '#next<?php echo $Cat_ID ?>',
				speed: 300,
				pause: true
			});
		});
  });
</script>
	
<?php } ?>