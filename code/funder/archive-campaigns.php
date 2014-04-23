<?php
/**
 * Campaigns
 *
 * @package funder
 * @since funder 1.0
 */

get_header(); 
global $wp_query;
 
?>
     
	<div class="contentt">
     <div class="container-fluid line">
       <div class="slides">
         <?php locate_template( array( 'searchform-campaign.php' ), true ); ?>
	   </div>
    </div>
  
<div class="clear"></div>

<!--Project Section-->
      <div class="content">
       <h1 class="decoration text-center proj">
          <span class="nobacgr">
		    <?php if ( is_post_type_archive( 'download' ) ) : ?>
				<?php printf( __( 'Discover %s', 'fundify' ), edd_get_label_plural() ); ?>
			<?php elseif ( is_tax( array( 'download_category', 'download_tag', 'campaign_region' ) ) ) : ?>
				<?php
					global $wp_query;
					$term = $wp_query->get_queried_object();
					$title = $term->name;
				?>
				<?php echo $title; ?>
			 <?php endif; ?>
            </span></h1>

    <section class="section" id="portfolio-list">
            <div class="wrapper row-fluid projects font_p" id="contentWrapper">
                        <?php if ( $wp_query->have_posts() ) : ?>
					    <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
							<?php get_template_part( 'content', funder_is_crowdfunding() ? 'campaign' : 'post' ); ?>
						<?php endwhile; ?>
					    <?php else : ?>
						<?php get_template_part( 'no-results', 'index' ); ?>
					    <?php endif; ?>
            </div><!-- end of .zone-content -->
       <!-- end of .content-wrapper -->
    </section>

<?php $project_nav = $data['text_project_nav'];  if ( $project_nav == "Yes") { ?>
            <div class="btn-toolbar text-center">
                <div class="decoration text-center proj ">
                    <div class="btn-group nobacgr">
                      <?php pagination(); ?>
                    </div>
                </div>
           </div>
   <?php } ?>
<!--/Project Section-->


      </div>
   </div>
 </div>
</div
<?php get_footer(); ?>