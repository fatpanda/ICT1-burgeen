<?php
/**
 * Page
 *
 * @package funder
 * @since funder 1.0
 */

get_header(); 
global $wp_query;
 
?>

    <div class="contentt">
      <div class="container-fluid line">    
            <div class="content mt30">
                 <div class="row-fluid">
                    <div class="span8">
						 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                         
                                <h1 class="decoration text-center pgtitle">
                                   <span class="nobacgr"><?php the_title(); ?></span>
                                </h1>
                                
                                <section class="section">
                                   <div class="wrapper row-fluid projects font_p" id="contentWrapper">
                                       <?php the_content(); ?>
                                   </div>
                                </section>
                
                        <?php endwhile; endif; ?>
                     </div>
                <?php get_sidebar(); ?>
              </div> 
           </div><!--/content-->
        </div><!--/container-fluid line-->
    </div><!--/contentt-->

<?php get_footer(); ?>
