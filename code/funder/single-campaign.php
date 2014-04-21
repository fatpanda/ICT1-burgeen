<?php
/**
 * The Template for displaying all single campaigns.
 *
 * @package Funder
 * @since Funder 1.0
 */

global $campaign;

get_header(); ?>

<div class="container-fluid line contentt description_page">
  <div class="content description mt30">
    <div class="row-fluid cols">
      <?php while ( have_posts() ) : the_post(); $campaign = atcf_get_campaign( $post->ID ); ?>
      <?php do_action( 'atcf_campaign_before', $campaign ); ?>
      <div class="left_content_descr span8">
        <h1 class="decoration text-center">
        	<span class="nobacgr"><?php the_title() ;?></span>
        </h1>
        <div class="single-project-thumb">
         <?php the_post_thumbnail('single-post'); ?>
        </div>
        <div class="tabbable" style="margin-bottom: 18px;">
          <div id="tabs_pages">
            <ul class=" tabs_pages_ul row-fluid">
              <li class="active span4"><a href="#tab1" data-toggle="tab"><?php _e('DESCRIPTION','funder')?></a></li>
              <li class="span4"><a href="#tab2" data-toggle="tab"><?php _e('BACKERS','funder')?></a></li>
              <li class="span4"><a href="#tab3" data-toggle="tab"><?php _e('UPDATES','funder')?></a></li>
            </ul>
          </div>
          <div class="tab-content" style="padding-bottom: 9px;">
            <div class="tab-pane active" id="tab1">
              <div id="description_content">
                <?php the_content(); ?>
                <?php locate_template( array( 'campaign/meta.php' ), true ); ?>
              </div>
            </div>
            <div class="tab-pane" id="tab2">
              <?php locate_template( array( 'campaign/backers.php' ), true ); ?>
            </div>
            <div class="tab-pane" id="tab3">
              <?php locate_template( array( 'campaign/updates.php' ), true ); ?>
            </div>
          </div>
          
        </div>
        <div id="social_uncategorized">
          <div class="social inline fright">
            <ul id="social_mid" class="bleft_social">
              <li><a href="<?php echo $data['text_facebook_profile']; ?>" target="_blank" original-title="twitter"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_header_face.png" alt=""></a></li>
                    <li><a href="<?php echo $data['text_googleplus_profile']; ?>" target="_blank" original-title="googleplus"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_header_g.png" alt=""></a></li>
                    <li><a href="<?php echo $data['text_twitter_profile']; ?>" title="facebook" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_header_tw.png" alt=""></a></li>
                    <li><a href="<?php echo $data['text_linkedin_profile']; ?>" target="_blank" original-title="linkedin"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_header_in.png" alt=""></a></li>
                    <li><a href="<?php echo $data['text_pinterest_profile']; ?>" target="_self" original-title="mail"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_header_p.png" alt=""></a></li>
                    <li><a href="<?php echo $data['text_dribbble_profile']; ?>" target="_self" original-title="mail"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_header_ball.png" alt=""></a></li>
            </ul>
          </div>
        </div>
        
          <div class="clear"></div>
           <?php locate_template( array( 'campaign/author-info.php' ), true ); ?>
          <div class="clear"></div>
           <?php comments_template(); ?>
          <div class="clear"></div>
          
      </div>
      
      <!--Sidebar-->
        <?php get_sidebar('campaign'); ?>
      <!--/Sidebar--> 
      
    </div>
    <?php endwhile; ?>
  </div>
</div>
<?php get_footer(); ?>
