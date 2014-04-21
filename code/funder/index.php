<?php
/**
 * Index
 * @package funder
 * @since funder 1.0
 */

global $wp_query;
get_header(); 			
?>

<div class="contentt">
  <div class="container-fluid line">
    <div class="content mt50">
      <div class="row-fluid cols">
        <div class="content-wrapper">
          <div class="post-wrapper archive">
            <?php 
					       
						  if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article <?php post_class("post-item post-excerpt"); ?>>
              <h2 class="post-title"><a href="<?php the_permalink() ?>">
                <?php the_title(); ?>
                </a></h2>
              <div class="post-meta"> <span class="meta-author">By
                <?php the_author_posts_link(); ?>
                </span> <span class="meta-category">
                <?php _e('Posted in', 'funder'); ?>
                -
                <?php the_category(' & '); ?>
                <?php _e('on', 'funder'); ?>
                <strong>
                <?php the_time('F jS, Y'); ?>
                </strong> <span class="comment-count"><a href="<?php the_permalink(); ?>#comments">
                <?php $commentscount = get_comments_number(); echo $commentscount; ?>
                </a>
                <?php _e('Comments', 'funder'); ?>
                </span></span> </div>
              <a href="<?php the_permalink() ?>">
              <?php the_post_thumbnail('archive-post'); ?>
              </a>
              <?php the_excerpt(); ?>
              <a class="view-article-btn" href="<?php the_permalink() ?>">
              <?php _e('Read More', 'funder'); ?>
              &rarr;</a>
           </article>
            <!-- end .post-excerpt -->
            
            <?php endwhile; endif; ?>
            <?php if(function_exists('pagination')) { ?>
            <?php pagination(); ?>
            <?php } else { ?>
            <div class="post-navigation">
              <p>
                <?php posts_nav_link('&#8734;','&laquo;&laquo; Previous Posts','Older Posts &raquo;&raquo;'); ?>
              </p>
            </div>
            <?php } ?>
          </div>
        </div>
        <!-- span8 content-wrapper --> 
      </div>
      <!--/row-fluid cols--> 
    </div>
    <!--/content--> 
  </div>
  <!--/container-fluid line--> 
</div>
<!--/contentt-->

<?php get_footer(); ?>
