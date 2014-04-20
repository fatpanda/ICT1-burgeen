<?php
/**
 *
 * Description: 404 Page Template.
 *
 */

get_header(); ?>
<div class="contentt">
  <div class="container-fluid line"> 
        <div class="content error">
                      <h1 class="error-title"><?php _e('404', 'funder'); ?></h2></h1>
                      <h2 class="post-title"><?php _e('<span>Woops! It seems a page is missing.</span>', 'funder'); ?></h2>
					  <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Please try using one of the navigation links above.', 'funder'); ?></p>
					  <p><a class="btn" href="<?php echo home_url(); ?>"><?php _e('Go to the Homepage', 'funder'); ?></a></p>
       </div><!--/Content-->
    </div> <!--/container-fluid line-->
</div><!--/contentt-->
<?php get_footer(); ?>