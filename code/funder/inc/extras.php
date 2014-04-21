<?php
/**
 * 
 *
 * @package funder
 * @since funder 1.0
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since funder 1.0
 */
function funder_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'funder_page_menu_args' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since funder 1.1
 */
function funder_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'funder' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'funder_wp_title', 10, 2 );

/**
 * Post excerpt ellipses.
 *
 * @since unknown
 *
 * @return string
 */
function funder_custom_excerpt_more( $more ) {
	global $post;

	if ( 'download' != $post->post_type )
		return $more;

	return '&hellip;';
}
add_filter( 'excerpt_more', 'funder_custom_excerpt_more' );

/**
 * Random excerpt length.
 *
 * @since unknown
 *
 * @return int
 */
function funder_excerpt_length( $length ) {
	return rand(20, 40);
}
add_filter( 'excerpt_length', 'funder_excerpt_length' );

/**
 * Number of posts user has written.
 *
 * @since funder 1.3
 * @uses $wpdb WordPress database object for queries.
 *
 * @param int $userid User ID.
 * @return int Amount of posts user has written.
 */
function funder_count_user_campaigns( $userid ) {
	global $wpdb;

	$where = get_posts_by_author_sql( 'download', true, $userid);

	$count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts $where" );

	return apply_filters( 'funder_get_usernumposts', $count, $userid );
}

/**
 * If the search query is empty, still return the search page.
 *
 * @since funder 1.4
 *
 * @return object $query
 */
function funder_search_query_filter($query) {
	if ( isset( $_GET[ 's' ] ) && empty( $_GET[ 's' ] ) && $query->is_main_query() ) {
		$query->is_search = true;
		$query->set( 'post_type', isset ( $_GET[ 'type' ] ) ? $_GET[ 'type' ] : 'post' );
	}  

	return $query;
}
add_filter( 'pre_get_posts', 'funder_search_query_filter' );