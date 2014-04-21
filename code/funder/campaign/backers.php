<?php
/**
 * Campaign sharing.
 *
 * @package funder
 * @since funder 1.5
 */

global $campaign;

$backers = $campaign->backers();

?>

<div id="backers_content">
<div class="row-fluid">
  <div class=" span6">
    <?php if ( empty( $backers ) ) : ?>
    <p>
      <?php _e( 'No backers yet. Be the first!', 'funder' ); ?>
    </p>
    <?php else : ?>
    <?php foreach ( $backers as $backer ) : ?>
    <?php
				$payment_id = get_post_meta( $backer->ID, '_edd_log_payment_id', true );
				if ( ! get_post( $payment_id ) )
					continue;
				$user_info  = edd_get_payment_meta_user_info( $payment_id );
			?>
    <div class="backers_block_text">
      <div class="image_face_backers_content">
        <div class="face_backers_content"> <?php echo get_avatar( $user_info[ 'email' ], 40 ); ?> </div>
      </div>
      <div class="text_backers_content">
        <div class="backer_name"><?php echo $user_info[ 'first_name' ]; ?> <?php echo $user_info[ 'last_name' ]; ?></div>
        <br />
        <div class="backer_date"><?php echo edd_payment_amount( $payment_id ); ?></div>
        <div class="number_project">
          <?php do_action( 'funder_campaign_backer_after', $campaign, $payment_id ); ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
</div>
<?php /*?><div class="row-fluid">
                    <div class="span12">
                        <div class="btn-toolbar text-center">
                            <div class="decoration text-center proj">
                                <div class="btn-group nobacgr">
                                    <button class="btn"><span class="gray">1</span></button>
                                    <button class="btn mleft10">2</button>
                                    <button class="btn mleft10">3</button>
                                    <button class="btn mleft10">4</button>
                                    <button class="btn mleft10">5</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><?php */?>
