<?php
/**
 *
 * Template Name: Page (Full Width)
 * Description: Template for page, with no sidebar.
 *
 */
global $wp_query;
get_header(); ?>

    <div class="contentt">
      <div class="container-fluid line">    
            <div class="content">
               
                 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                 
                        <h1 class="decoration text-center proj">
                           <span class="nobacgr"><?php the_title(); ?></span>
                        </h1>
                        
                        <section class="section content">
                           <div class="wrapper row-fluid projects font_p" id="contentWrapper">
                               <?php the_content(); ?>
                           </div>
                        </section>
        
                <?php endwhile; endif; ?>
                
           </div><!--/content-->
        </div><!--/container-fluid line-->
    </div><!--/contentt-->

<?php get_footer(); ?>
