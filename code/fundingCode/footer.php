
<div id="footer">
    <div class="footer">
        <div class="row-fluid">
            <div class="span3">
            <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Widget 1') ) : else : ?>
		         <?php endif; ?>
            </div>
            <div class="span3 foot">
            <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Widget 2') ) : else : ?>
		         <?php endif; ?>
            </div>
            <div class="span3 foot">
            <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Widget 3') ) : else : ?>
		         <?php endif; ?>
            </div>
            <div class="span3 foot">
                 <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Widget 4') ) : else : ?>
		         <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="footer_bot">
        <div class="footer_bott">
              <div class="fleft">&copy; <?php echo date('Y') ?> <?php global $data; echo $data['textarea_footer_text']; ?>.</div>
              <div class="fright">
                <ul id="social_b" class="socialbott inline">
                 <?php if ($data["text_twitter_profile"]) { ?>
                    <li><a href="<?php echo $data['text_facebook_profile']; ?>" target="_blank" title="twitter"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_footer_face.png" alt=""></a></li>
                    <li><a href="<?php echo $data['text_googleplus_profile']; ?>" target="_blank" title="googleplus"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_footer_g.png" alt=""></a></li>
                    <li><a href="<?php echo $data['text_twitter_profile']; ?>" title="facebook" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_footer_tw.png" alt=""></a></li>
                    <li><a href="<?php echo $data['text_linkedin_profile']; ?>" target="_blank" title="linkedin"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_footer_in.png" alt=""></a></li>
                    <li><a href="<?php echo $data['text_pinterest_profile']; ?>" target="_self" title="mail"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_footer_p.png" alt=""></a></li>
                    <li><a href="<?php echo $data['text_dribbble_profile']; ?>" target="_self" title="mail"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_footer_ball.png" alt=""></a></li>
                   <?php } ?>
							
                </ul>
              </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

<?php echo $data['google_analytics']; ?>

<?php wp_footer(); ?>

</body>
	
</html>