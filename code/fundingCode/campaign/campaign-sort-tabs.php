<?php
/**
 * Campaign tabs.
 *
 * @package funder
 * @since funder 1.5
 */

global $campaign;
?>

<div class="sort-tabs campaign">
	<ul>
		<?php do_action( 'funder_campaign_tabs_before', $campaign ); ?>

		<li><a href="#description" class="campaign-view-descrption tabber"><?php _e( 'Overview', 'funder' ); ?></a></li>
		
		<?php if ( '' != $campaign->updates() ) : ?>
		<li><a href="#updates" class="tabber"><?php _e( 'Updates', 'funder' ); ?></a></li>
		<?php endif; ?>
		
		<li><a href="#comments" class="tabber"><?php _e( 'Comments', 'funder' ); ?></a></li>
		<li><a href="#backers" class="tabber"><?php _e( 'Backers', 'funder' ); ?></a></li>
		
		<?php if ( get_current_user_id() == $post->post_author || current_user_can( 'manage_options' ) ) : ?>
		<li><a href="<?php echo atcf_create_permalink( 'edit', get_permalink() ); ?>"><?php _e( 'Edit Campaign', 'funder' ); ?></a></li>
		<?php endif; ?>

		<?php do_action( 'funder_campaign_tabs_after', $campaign ); ?>
	</ul>
</div>