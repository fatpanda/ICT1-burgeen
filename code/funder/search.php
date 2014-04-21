<?php
/**
 *
 * Description: Search Results Page Template.
 *
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
  <div class="content">
    <h1 class="decoration text-center proj"> <span class="nobacgr">
      <?php _e('Search Results:', 'wpg'); ?>
      </span> </h1>
    <div class="section" id="portfolio-list">
      <div class="wrapper row-fluid projects font_p" id="contentWrapper">
        <?php
                                 if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php get_template_part( 'content', funder_is_crowdfunding() ? 'campaign' : 'post' ); ?>
        <?php endwhile; endif; ?>
        <?php if (!have_posts()) : ?>
        <div id="no-posts-found" class="ten columns alpha">
          <h2 class="post-title">
            <?php _e( '<span>Oh, that did not go so well!</span>', 'wpg' ); ?>
          </h2>
          <p><?php echo __( 'Sorry, but no results were found. Please try the search again.', 'wpg' ); ?></p>
        </div>
        <!-- end #no-posts-found -->
        
        <?php endif; ?>
        <div class="clear"></div>
        <?php if(function_exists('wp_pagenavi')) { ?>
        <div class="btn-toolbar text-center">
          <div class="text-center proj">
            <?php pagination(); ?>
          </div>
        </div>
        <?php } else { ?>
        <div class="post-navigation">
          <p>
            <?php posts_nav_link('&#8734;','&laquo;&laquo; Previous Posts','Older Posts &raquo;&raquo;'); ?>
          </p>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
