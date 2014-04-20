<?php
/**
 *
 * Description: Post Archives Page Template.
 *
 */

get_header(); ?>

   <div class="contentt">
      <div class="container-fluid line">    
            <div class="content mt30">
               <div class="row-fluid cols">
                 <div class="span8 content-wrapper">
                     <h1 class="decoration text-center proj">
                           <span class="nobacgr">    
								<?php if (is_category()) { ?>
                                    <?php _e('Posts in the Category:', 'funder'); ?> <?php single_cat_title(); ?>
                                <?php } elseif (is_tag()) { ?> 
                                    <?php _e('Posts Tagged with:', 'funder'); ?> <?php single_tag_title(); ?>
                                <?php } elseif (is_author()) { ?>
                                    <?php _e('Posts By:', 'funder'); ?> <?php $curauth = get_userdata( get_query_var('author') );  ?><?php echo $curauth->display_name; ?>
                                <?php } elseif (is_day()) { ?>
                                    <?php _e('Daily Archives:', 'funder'); ?> <?php the_time('F jS, Y'); ?>
                                <?php } elseif (is_month()) { ?>
                                    <?php _e('Monthly Archives:', 'funder'); ?> <?php the_time('F, Y'); ?>
                                <?php } elseif (is_year()) { ?>
                                    <?php _e('Yearly Archives:', 'funder'); ?> <?php the_time('Y'); ?>
                                <?php } ?>
                         </span>
                    </h1>
                    
					<div class="post-wrapper archive">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						
                            <article <?php post_class("post-item post-excerpt"); ?>>
                                <h2 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                                 <div class="post-meta">
                                    <span class="meta-author">By <?php the_author_posts_link(); ?></span>
                                    <span class="meta-category"><?php _e('Posted in', 'funder'); ?> - <?php the_category(' & '); ?> <?php _e('on', 'funder'); ?> <strong><?php the_time('F jS, Y'); ?></strong> <span class="comment-count"><a href="<?php the_permalink(); ?>#comments"><?php $commentscount = get_comments_number(); echo $commentscount; ?></a> <?php _e('Comments', 'funder'); ?></span></span> 
                                 </div>
                                <a href="<?php the_permalink() ?>">
                                <?php the_post_thumbnail('archive-post'); ?>
                                </a>
                                <?php the_excerpt(); ?>
                                <a class="view-article-btn" href="<?php the_permalink() ?>"><?php _e('Read More', 'funder'); ?> &rarr;</a>
                            </article><!-- end .post-excerpt -->
						
							<?php endwhile; endif; ?>
                                
                            <?php if(function_exists('wp_pagenavi')) { ?>
                            <?php wp_pagenavi(); ?>   
                            <?php } else { ?>      
                              <div class="post-navigation"><p><?php posts_nav_link('&#8734;','&laquo;&laquo; Previous Posts','Older Posts &raquo;&raquo;'); ?></p></div>
                            <?php } ?>
					       </div>
					      </div><!-- span8 content-wrapper -->
	
					 <?php get_sidebar(); ?>
				           
                  </section>
               </div><!--/row-fluid cols-->
           </div><!--/content-->
        </div><!--/container-fluid line-->
    </div><!--/contentt-->

<?php get_footer(); ?>