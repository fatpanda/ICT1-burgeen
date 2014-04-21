<?php
/** Author Biography Section
 *
 */

global $post, $campaign;

$author = get_user_by( 'id', $post->post_author );
?>

<div id="author_review">
  <h3 class="decoration text-center"><span class="nobacgr">
    <?php _e( 'Author', 'funder' ); ?>
    </span></h3>
  <div id="face_social_text">
    <div class="left_face_social_text span4">
      <div class="face_big span9">
        <div class="pix_author"><?php echo get_avatar( $author->user_email, 149 ); ?></div>
      </div>
      <div class="social_link_author">
        <?php
			$methods = _wp_get_user_contactmethods();
		
			foreach ( $methods as $key => $method ) :
				if ( '' == $author->$key )
					continue;
		?>
        <div class="social_bord"><a href="<?php echo make_clickable( $author->$key ); ?>"><img class="social_decc" src="<?php echo get_template_directory_uri(); ?>/img/description/<?php echo $key; ?>_author_icon.png" alt=""></a></div>
        <?php endforeach; ?>
        <div class="social_bord_last"> <a href="#"><img class="social_decc" alt="" src="<?php echo get_template_directory_uri(); ?>/img/description/google_author_icon.png"></a> </div>
      </div>
    </div>
    <div class="right_face_social_text span8">
          <div class="name_surname">
            <?php 
                if ( $campaign->author() ) :
                    echo esc_attr( $campaign->author() );
                else :
                    echo esc_attr( $author->display_name );
                endif; 
             ?>
          </div>
      <?php 
			$count = funder_count_user_campaigns( $author->ID );
			printf( _nx( 'Created %1$d Campaign', 'Created %1$d Campaigns', $count, '1: Number of Campaigns 2: EDD Object', 'funder' ), $count ); 
	   ?>
      &bull; <a href="<?php echo get_author_posts_url( $author->ID ); ?>">
      <?php _e( 'View Profile', 'funder' ); ?>
      </a></small>
      <div class="text_author_right"><?php echo wpautop( $author->user_description ); ?></div>
      <?php if ( '' != $campaign->contact_email() ) : ?>
      <div class="author-contact">
        <p><a href="mailto:<?php echo $campaign->contact_email(); ?>" class="">
          <?php _e( 'Ask Question', 'funder' ); ?>
          </a></p>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
