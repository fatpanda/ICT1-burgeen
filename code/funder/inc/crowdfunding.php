<?php
/**
 * Crowdfunding functionality for funder
 *
 * @package funder
 * @since funder 1.0
 */

/**
 * Check if the proper plugins are installed/activated so we can only use certain
 * functionality when we need to.
 *
 * @since funder 1.0
 *
 * @return boolean
 */
function funder_is_crowdfunding() {
	if ( class_exists( 'Easy_Digital_Downloads' ) && class_exists( 'ATCF_Campaign' ) )
		return true;

	return false;
}

/**
 * Plugin Notice
 *
 * Make sure they know they should install Crowdfunding by Astoundify
 *
 * @since funder 1.0
 *
 * @return void
 */
function funder_features_notice() {
	?>
	<div class="updated">
		<p><?php printf( 
					__( '<strong>Notice:</strong> To take advantage of all of the great features funder offers, please install the <a href="%s">Crowdfunding by Astoundify plugin</a>. <a href="%s" class="alignright">Hide this message.</a>', 'funder' ), 
					wp_nonce_url( network_admin_url( 'update.php?action=install-plugin&plugin=appthemer-crowdfunding' ), 'install-plugin_appthemer-crowdfunding' ), 
					wp_nonce_url( add_query_arg( array( 'action' => 'funder-hide-plugin-notice' ), admin_url( 'index.php' ) ), 'funder-hide-plugin-notice' ) 
			); ?></p>
	</div>
<?php
}
/*if ( ( ! funder_is_crowdfunding() ) && is_admin() && ! get_user_meta( get_current_user_id(), 'funder-hide-plugin-notice', true ) )
	add_action( 'admin_notices', 'funder_features_notice' );*/

/**
 * Hide plugin notice.
 *
 * @since funder 1.0
 *
 * @return void
 */
function funder_hide_plugin_notice() {
	check_admin_referer( 'funder-hide-plugin-notice' );

	$user_id = get_current_user_id();

	add_user_meta( $user_id, 'funder-hide-plugin-notice', 1 );
}
if ( is_admin() )
	add_action( 'admin_action_funder-hide-plugin-notice', 'funder_hide_plugin_notice' );

/**
 * If a user has already purchased the download (campaign), don't show them an
 * annoying message.
 *
 * @since funder 1.0
 *
 * @return void
 */
remove_action( 'edd_after_download_content', 'edd_show_has_purchased_item_message' );

/**
 * Show campaigns on author archive.
 *
 * @since funder 1.0
 *
 * @return void
 */
function funder_post_author_archive( $query ) {
	if ( $query->is_author )
		$query->set( 'post_type', 'download' );
}
add_action( 'pre_get_posts', 'funder_post_author_archive' );

/**
 * Depending on where the user has searched from (either on a campaign page)
 * or from the blog sidebar, change which post types show.
 *
 * @since funder 1.0
 *
 * @return void
 */
function funder_search_filter( $query ) {
	if ( ! $query->is_search() )
		return;

	$post_type = isset ( $_GET[ 'type' ] ) ? esc_attr( $_GET[ 'type' ] ) : null;

	if ( ! in_array( $post_type, array( 'download', 'post' ) ) )
		return;

	if ( ! $post_type )
		$post_type = 'post';

	$query->set( 'post_type', $post_type );

	return $query;
};
add_filter( 'pre_get_posts', 'funder_search_filter' );

/**
 * Expired campaign shim.
 *
 * When a campaign is inactive, we display the inactive pledge amounts,
 * but the lack of form around them messes with the styling a bit, and we
 * lose our header. This fixes that. 
 *
 * @since funder 1.3
 *
 * @param object $campaign The current campaign.
 * @return void
 */
function funder_contribute_modal_top_expired( $campaign ) {
	if ( $campaign->is_active() )
		return;
?>
	<div class="edd_download_purchase_form">
		<h2><?php printf( __( 'This %s has ended. No more pledges can be made.', 'funder' ), edd_get_label_singular() ); ?></h2>
<?php
}
add_action( 'funder_contribute_modal_top', 'funder_contribute_modal_top_expired' );

/**
 * Expired campaign shim.
 *
 * @since funder 1.3
 *
 * @param object $campaign The current campaign.
 * @return void
 */
function funder_contribute_modal_bottom_expired( $campaign ) {
	if ( $campaign->is_active() )
		return;
?>
	</div>
<?php
}
add_action( 'funder_contribute_modal_bottom', 'funder_contribute_modal_bottom_expired' );