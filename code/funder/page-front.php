<?php
/**
 * Template Name: Front Page
 *
 * This should be used in conjunction with the funder plugin.
 *
 * @package funder
 * @since funder 1.0
 */

global $wp_query;
get_header(); 		
?>

<div class="contentt">
    <div class="container-fluid line">
        
                <!--Seach bar-->
                <div class="slides">
                    <?php locate_template( array( 'searchform-campaign.php' ), true ); ?>
                </div>
                <!--/Seach bar-->
<?php  	 
        $layout = $data ['homepage_blocks']['enabled'];
        if ($layout):
		foreach ($layout as $key=>$value) {
			switch($key) {
			case 'slider_block':
	
			if ( funder_is_crowdfunding()  ) :
				$featured = new ATCF_Campaign_Query( array( 
					'posts_per_page' => 'grid' == funder_theme_mod( 'hero_style' ) ? apply_filters( 'funder_hero_campaign_grid', 24 ) : 1,
					'meta_query'     => array(
						array(
							'key'     => '_campaign_featured',
							'value'   => 1,
							'compare' => '=',
							'type'    => 'numeric'
						)
					)
				) ); 
			else :
				$featured = new WP_Query( array( 
					'posts_per_page' => 'grid' == funder_theme_mod( 'hero_style' ) ? apply_filters( 'funder_hero_campaign_grid', 24 ) : 1
				) ); 
			endif; 
		?>
               
    <div class="top_widgets black">
              <div class="search-wrapper clearfix">
                  <div class="zone clearfix">
                     <div class="searchr block">
                       <div id="advanced-search"  style="display: none;">
                          <div class="row-fluid projects font_p" id="top_slide">
                             <div id="myCarousel" class="carousel slide">
                                <div class="carousel-inner content">
                                    <div class="item active">
                                     <?php 
                                      query_posts('showposts=3');
                                      $posts = get_posts('numberposts=3&offset=0&post_type=download');
                                      foreach ($posts as $post) : 
                                      setup_postdata($post);
                                      get_template_part( 'content', funder_is_crowdfunding() ? 'slider' : 'post' );
                                      endforeach;
                                     ?>
                                    </div> 
                                    <div class="item">
                                      <?php 
                                      query_posts('showposts=3');
                                      $posts = get_posts('numberposts=3&offset=3&post_type=download');
                                      foreach ($posts as $post) : 
                                      setup_postdata($post);
                                      get_template_part( 'content', funder_is_crowdfunding() ? 'slider' : 'post' );
                                      endforeach;
                                     ?>
                                    </div>  
                                </div>
                                      <a class="left carousel-control" href="#myCarousel" data-slide="prev"></a>
                                      <a class="right carousel-control" href="#myCarousel" data-slide="next"></a>
                                </div>
                             </div>
                          </div>
                       </div>
                      <div class="advanced-search-control">
                          <a id="advanced-search-button" class="advanced-search-button fright adv_search latest expanded"></a>
                      </div>
             </div>
         </div><!--/Latest Project Slider-->
                            


             <!--Grid Slider-->
            <div class="map-wrapper">
                 <div id="map" class="map" style="position: relative; overflow: hidden; -webkit-transform: translateZ(0);height: 465px">
                    <div id="home-page-featured">
                        <?php if($data["grid_slider_msg_1"]) { ?>
                        <div id="Textus">
                            <div class="clear">
                                 <p><?php echo $data['grid_slider_msg_1']; ?></p>
                            </div>
                            <div class="clear">
                                 <p><?php echo $data['grid_slider_msg_2']; ?></p>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if ( 'grid' == funder_theme_mod( 'hero_style' ) ) : ?>
						<?php for ( $i = 0; $i < 3; $i++ ) : shuffle( $featured->posts ); ?>
                            <ul>
                                <?php while ( $featured->have_posts() ) : $featured->the_post(); ?>
                                <li><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endfor; ?>
                        <?php else : ?>
                        <?php while ( $featured->have_posts() ) : $featured->the_post(); ?>
                        <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'fullsize' ); ?>
                        <a href="<?php the_permalink(); ?>" class="home-page-featured-single"><img src="<?php echo $thumbnail[0]; ?>" /></a>
                        <?php endwhile; ?>
                        <?php endif; ?>
                        <!-- / container -->
                    </div>
                </div>
           </div>
        </div>
 <!--/Grid Slider-->
 
<?php
		break;
		case 'about_block':
		?>

<!--Project Block-->
<div id="about" class="content">
    <h1 class="decoration text-center about"><span class="nobacgr"><?php echo $data['text_about_us_title']; ?></span></h1>
    <div class="about_block">
        <p class="about_cont"><strong><?php echo $data['textarea_about_us_discription']; ?></strong></p>
        <div class="row-fluid folders">
            <div class="span4">
                <div class="folder_bordered">
                   <div class="folder"><?php if($data["step_1_img"]) { ?>
                        <a href="<?php echo $data['step_1_url']; ?>"><img src="<?php echo $data['step_1_img']; ?>" alt="" /></a>
						<?php } ?>
                     </div>
                    <div class="folder"><h3 class="nomarg text-center"><?php echo $data['step_1_heading']; ?></h3></div>
                    <div class="folder"><p class="green text-center"><strong><?php echo $data['step_1_subheading']; ?></strong></p></div>
                </div>
                <div class="folder"><img src="<?php echo get_template_directory_uri(); ?>/img/folder_n.png" alt=""></div>
            </div>
            <div class="span4">
                <div class="folder_bordered">
                    <div class="folder"><?php if($data["step_2_img"]) { ?>
                        <a href="<?php echo $data['step_2_url']; ?>"><img src="<?php echo $data['step_2_img']; ?>" alt="" /></a>
						<?php } ?>
                     </div>
                    <div class="folder"><h3 class="nomarg text-center"><?php echo $data['step_2_heading']; ?></h3></div>
                    <div class="folder"><p class="green text-center"><strong><?php echo $data['step_2_subheading']; ?></strong></p></div>
                </div>
                <div class="folder"><img src="<?php echo get_template_directory_uri(); ?>/img/folder_n.png" alt=""></div>
            </div>
            <div class="span4">
                <div class="folder_bordered">
                     <div class="folder"><?php if($data["step_3_img"]) { ?>
                        <a href="<?php echo $data['step_3_url']; ?>"><img src="<?php echo $data['step_3_img']; ?>" alt="" /></a>
						<?php } ?>
                     </div>
                    <div class="folder"><h3 class="nomarg text-center"><?php echo $data['step_3_heading']; ?></h3></div>
                    <div class="folder"><p class="green text-center"><strong><?php echo $data['step_3_subheading']; ?></strong></p></div>
                </div>
                <div class="folder"><img src="<?php echo get_template_directory_uri(); ?>/img/folder_n.png" alt=""></div>
            </div>
        </div>
    </div>
 </div>
<!--/About Block-->

<?php
		break;
		case 'project_block':
		?>
         
<!--Project Block-->
        <div id="projects" class="content">
         <div class="section" id="portfolio-list">
             <h1 class="decoration text-center proj"><span class="nobacgr"><?php echo $data['text_project_title']; ?></span></h1>
               <div class="wrapper row-fluid  projects font_p" id="contentWrapper">
                     <div class="zone-content clearfix">
                            <div class="portfolio-selection block">
                                <div class="decoration text-center" data-toggle="buttons-radio">
                                    <div class="inline nobacgr">
                                        <div class="text-center tags">
                                        <ul id="portfolio-filter">
                                        <?php 
                                        $category_lists = get_category_list('download_category');
                                        $is_first = 'active';
                                            foreach($category_lists as $category_list){
                                            $category_term = get_term_by( 'name', $category_list , 'download_category');
                                            if( !empty( $category_term ) ){
                                                $category_slug = $category_term->slug;
                                            }else{
                                                $category_slug = 'all';
                                            }
                                            echo '<li><input  type="button"  id="'.$category_slug.'" class="btn '. $is_first . '" value="' . $category_slug . '"></li>';
                                            
                                            $is_first  = '';
                                            }
                                            ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <?php
					    $project_num = $data['text_project_num']; 
						if ( funder_is_crowdfunding()  ) :
							$wp_query = new ATCF_Campaign_Query( array(
							    'posts_per_page' => $project_num,
								'paged' => ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 )
							) );
						else :
							$wp_query = new WP_Query( array(
								'posts_per_page' => $project_num,
								'paged'          => ( get_query_var('page') ? get_query_var('page') : 1 )
							) );
						endif;

						if ( $wp_query->have_posts() ) :
					   ?>
                    	<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
					    <?php get_template_part( 'content', funder_is_crowdfunding() ? 'campaign' : 'post' ); ?>
						<?php endwhile; ?>
					    <?php else : ?>
						<?php get_template_part( 'no-results', 'index' ); ?>
					<?php endif; ?>
                    
            </div>
        </div>

<?php $project_nav = $data['text_project_nav'];  if ( $project_nav == "Yes") { ?>
            <div class="btn-toolbar text-center content">
                <div class="decoration text-center proj">
                    <div class="btn-group nobacgr">
                      <?php pagination(); ?>
                    </div>
                </div>
           </div>
   <?php } ?>
</div>

<!--/Project Block-->


<?php
		break;
		case 'submission_block':
	    ?>
 
<!--Submission Block-->
<div id="register" class="content">
 <h1 class="decoration text-center proj"><span class="nobacgr"><?php _e( 'Create Your Project', 'atcf' ); ?></span></h1>
	<?php echo do_shortcode('[wpg_crowdfunding_submit]') ?>
</div>
<!--/Submission Block-->

<?php
		break;
		case 'contact_block':
		?>
        
<!--Contact Block-->
<div id="contact" class="content">
    <h1 class="decoration text-center proj"><span class="nobacgr"> <?php echo $data['text_contact_us_title']; ?></span></h1>
	<?php echo do_shortcode('[wpg_contact]') ?>
 	<div class="decoration text-center line_decor"></div>
    <div class="row-fluid contacts_row">
            <?php echo $data['contact_left_col']; ?>
        <div class="span6 clearr">
            <?php echo $data['contact_right_col']; ?>
        </div>
    </div>
</div>
<!--/Contact Block-->

 <?php
		break;
		case 'logo_block':
		?>

<!--Logo Block-->
<div id="partners" class="content">
    <div class="partner_bott">
      <div class="partners">
          <h5 class="decoration text-center"><span class="nobacgr_whit"><?php echo $data['text_client_logos_title']; ?></span></h5>
            <div class="partn_pics">
               <?php if($data["client_logo_one"]) { ?>
                    <a class="partner" href="<?php echo $data['client_logo_url_one']; ?>"><img src="<?php echo $data['client_logo_one']; ?>" alt="" /></a>
                <?php } if($data["client_logo_two"]){ ?>
                    <a class="partner" href="<?php echo $data['client_logo_url_two']; ?>"><img src="<?php echo $data['client_logo_two']; ?>" alt="" /></a>
                <?php } if($data["client_logo_three"]){ ?>
                    <a class="partner" href="<?php echo $data['client_logo_url_tree']; ?>"><img src="<?php echo $data['client_logo_three']; ?>" alt="" /></a>
                <?php } if($data["client_logo_four"]){ ?>
                    <a class="partner" href="<?php echo $data['client_logo_url_four']; ?>"><img src="<?php echo $data['client_logo_four']; ?>" alt="" /></a>
                <?php } if($data["client_logo_five"]){ ?>
                    <a class="partner" href="<?php echo $data['client_logo_url_five']; ?>"><img src="<?php echo $data['client_logo_five']; ?>" alt="" /></a>
                <?php } if($data["client_logo_six"]){ ?>
                    <a class="partner" href="<?php echo $data['client_logo_url_six']; ?>"><img src="<?php echo $data['client_logo_six']; ?>" alt="" /></a>
                <?php } if($data["client_logo_seven"]){ ?>
                    <a class="partner" href="<?php echo $data['client_logo_url_seven']; ?>"><img src="<?php echo $data['client_logo_seven']; ?>" alt="" /></a>
                <?php } ?>		
             </div>
       </div>
  </div>  
</div>                              
<!--/Logo Block-->
  
<?php break; }
		} endif; ?>

   </div><!--container-fluid line-->
</div><!--contentt-->

<?php get_footer(); ?>