<?php
/**
 *
 * Description: Standard Blog (Single Article) template.
 *
 */

get_header(); ?>

<div class="contentt">
      <div class="container-fluid line"> 
                <div class="content mt30">
                     <div class="row-fluid">
                        <section class="span8 single-post first">
                        
                      		  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                <article <?php post_class("single-article"); ?>>
                                    <h1 class="post-title"><?php the_title(); ?></h1>
                                         <div class="post-meta">
                                            <span class="meta-author">By <?php the_author_posts_link(); ?></span>
                                            <span class="meta-category"><?php _e('Posted in', 'wpg'); ?> - <?php the_category(' & '); ?> <?php _e('on', 'wpg'); ?> <strong><?php the_time('F jS, Y'); ?></strong> <span class="comment-count"><a href="#comments" class="scroll"><?php $commentscount = get_comments_number(); echo $commentscount; ?></a> <?php _e('Comments', 'wpg'); ?></span></span>
                                         </div>
                                        <?php the_post_thumbnail('single-post'); ?>
                                         <div class="post-content">
                                        <?php the_content(); ?>
                                         </div>
                                         <div class="clear"></div>
                                        <span class="tags"><i class="icon-tags"></i> <?php the_tags(' ',' '); ?></span>
                                 </article><!-- end #single-article -->
                                 
                                 <?php wp_link_pages(); ?>
                                 
                               <?php endwhile; endif; ?>
                               <?php comments_template(); ?>
    
                          </section>
          
                    <?php get_sidebar(); ?>
          
          </div><!--/row-fluid-->
      </div><!--/content-->
   </div><!--/container-fluid line-->
</div><!--/contentt-->
<?php get_footer(); ?>