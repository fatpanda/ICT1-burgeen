<?php
// function to display number of posts.
function tie_views( $postID = '' ){
	if( !tie_get_option( 'post_views' ) ) return false;

	global $post;
	if( empty($postID) ) $postID = $post->ID ;
	
    $count_key = 'tie_views';
    $count = get_post_meta($postID, $count_key, true);
	$count = @number_format($count);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        $count = "0";
    }
    return '<span class="post-views">'.$count.' '.__( 'Views' , 'tie' ).'</span> ';
}

// function to count views.
function tie_setPostViews() {
	if( !tie_get_option( 'post_views' ) ) return false;

	global $post;
	$postID = $post->ID ;
    $count_key = 'tie_views';
    $count = get_post_meta($postID, $count_key, true);
	if( !defined('WP_CACHE') || !WP_CACHE ){
		if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}
}


### Function: Calculate Post Views With WP_CACHE Enabled
add_action('wp_enqueue_scripts', 'tie_postview_cache_count_enqueue');
function tie_postview_cache_count_enqueue() {
	global $post;
	if ( is_single() && ( defined('WP_CACHE') && WP_CACHE) && tie_get_option( 'post_views' ) ) {
		// Enqueue and localize script here
		wp_register_script( 'tie-postviews-cache', get_template_directory_uri() . '/js/postviews-cache.js', array( 'jquery' ) );
		wp_localize_script('tie-postviews-cache', 'tieViewsCacheL10n', array('admin_ajax_url' => admin_url('admin-ajax.php', (is_ssl() ? 'https' : 'http')), 'post_id' => intval($post->ID)));
		wp_enqueue_script('tie-postviews-cache');
	}
}

### Function: Increment Post Views
add_action('wp_ajax_postviews', 'tie_increment_views');
add_action('wp_ajax_nopriv_postviews', 'tie_increment_views');
function tie_increment_views() {
	global $wpdb;
	if(!empty($_GET['postviews_id']) && tie_get_option( 'post_views' ))
	{
		$post_id = intval($_GET['postviews_id']);
		if($post_id > 0 && defined('WP_CACHE') && WP_CACHE) {

			$count_key = 'tie_views';
			$count = get_post_meta($post_id, $count_key, true);
			if($count==''){
				$count = 0;
				delete_post_meta($post_id, $count_key);
				add_post_meta($post_id, $count_key, '0');
			}else{
				$count++;
				update_post_meta($post_id, $count_key, $count);
			}
			echo ($count + 1);
		}
	}
	exit();
}


// Add it to a column in WP-Admin 
add_filter('manage_posts_columns', 'tie_posts_column_views');
add_action('manage_posts_custom_column', 'tie_posts_custom_column_views',5,2);
function tie_posts_column_views($defaults){
    $defaults['tie_post_views'] = __('Views');
    return $defaults;
}
function tie_posts_custom_column_views($column_name, $id){
	if($column_name === 'tie_post_views'){
        echo tie_views(get_the_ID());
    }
}
?>