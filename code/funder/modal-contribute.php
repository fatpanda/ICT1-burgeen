<?php
/**
 * Contribute
 *
 * @package Fundify
 * @since Fundify 1.3
 */

global $post;

wp_reset_query();

$campaign = atcf_get_campaign( $post );
?>

<div id="contribute-modal-wrap" class="modal">
	<?php 
		do_action( 'fundify_contribute_modal_top', $campaign );

		if ( $campaign->is_active() ) :
			echo edd_get_purchase_link( array( 
				'download_id' => $campaign->ID,
				'class'       => '',
				'price'       => false
			) ); 
		else : // Inactive, just show options with no button
			atcf_campaign_contribute_options( edd_get_variable_prices( $campaign->ID ), 'checkbox', $campaign->ID );
		endif;
	
		do_action( 'fundify_contribute_modal_bottom', $campaign ); 
	?>
</div>