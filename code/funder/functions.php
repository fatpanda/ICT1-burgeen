<?php

/**
 * funder functions and definitions
 * Author Name: Nasir Hayat
 * Author URl: http://WpGrace.com
 * @package funder
 * @since funder 1.0
 */


/*-----------------------------------------------------------------------------------*/
/* Declaring the content width based on the theme's design and stylesheet
/*-----------------------------------------------------------------------------------*/

if ( !isset( $content_width ) )
  $content_width = 960; /* pixels */

/*-----------------------------------------------------------------------------------*/
/* Declaring the theme language domain (for language translations)
/*-----------------------------------------------------------------------------------*/

load_theme_textdomain('funder', get_template_directory().'/lang');

/*-----------------------------------------------------------------------------------*/
/* Register & Enqueue JS and CSS
/*-----------------------------------------------------------------------------------*/

function gt_queue_assets() {
	$data = get_option("funder_options");
	
/*	$body_font = ucwords($data['body_font']['face']);
	$headings_font = ucwords($data['headings_font']['face']);
	$logo_font = ucwords($data['logo_font']['face']);
*/  	
  	if ( !is_admin() ) {
  	
  	wp_enqueue_script('jquery');
  	
   //Register Scripts (Places all jQuery dependant scripts into Footer)
  	wp_register_script('jquery-easing', get_template_directory_uri() .'/js/jquery.easing.js', 'jquery', '1.3', true);
  	wp_register_script('fancybox', get_template_directory_uri() .'/js/jquery.fancybox.min.js', 'jquery', '2.1', true);
  	wp_register_script('isotope', get_template_directory_uri() .'/js/jquery.isotope.min.js', 'jquery', '1.5', true);
  	wp_register_script('mobile-menu', get_template_directory_uri() .'/js/jquery.mobilemenu.js', 'jquery', '1.0', true);
	
  	wp_register_script('jquery.selectbox.min', get_template_directory_uri() .'/js/jquery.selectbox.min.js', 'jquery', '1.0', true);
	wp_register_script('jquery', get_template_directory_uri() .'/js/jquery.js');
	wp_register_script('bootstrap', get_template_directory_uri() .'/js/bootstrap.js', 'jquery', '1.0', true);
	wp_register_script('jquery-uii', get_template_directory_uri() .'/js/jquery-uii.js', 'jquery', '1.0', true);
	wp_register_script('contact', get_template_directory_uri() .'/js/contact.js', 'jquery', '1.0', true);
	wp_register_script('jquery.colorbox', get_template_directory_uri() .'/js/jquery.colorbox.js', 'jquery', '1.0', true);
	wp_register_script('jquery.placeholder', get_template_directory_uri() .'/js/jquery.placeholder.js', 'jquery', '1.0', true);
	wp_register_script('jquery.nav', get_template_directory_uri() .'/js/jquery.nav.js', 'jquery', '1.0', true);
	
  // Register Styles
  
  	wp_register_style('style-default', get_stylesheet_directory_uri() .'/css/style.css');

	if(is_multisite()) {
		$uploads = wp_upload_dir();
		wp_register_style('options', trailingslashit($uploads['baseurl']) .'options.css', 'style');
	} else {
		wp_register_style('options', get_template_directory_uri() .'/assets/css/dynamic-css/options.css', 'style');
	}
  
    // Funder Main Css files 
	
	wp_register_style('bootstrap', get_template_directory_uri().'/css/bootstrap.css');
    wp_register_style('jquery-ui', get_template_directory_uri().'/css/jquery-ui.css');
    wp_register_style('resp', get_template_directory_uri().'/css/resp.css');
    wp_register_style('colorbox', get_template_directory_uri().'/css/colorbox.css');
	wp_register_style('font-awesome', get_template_directory_uri().'/assets/css/font-awesome.css');
	
	//wp_enqueue_style('style');
	wp_enqueue_style('style-default');	
  	wp_enqueue_style('jquery-ui');
    wp_enqueue_style('colorbox');
	wp_enqueue_style('bootstrap');	
	wp_enqueue_style("resp");
	wp_enqueue_style("font-awesome");
	
	
	// Enqueue Scripts (Global)
  	wp_enqueue_script('jquery-easing');
	wp_enqueue_script('jquery.colorbox');
  	wp_enqueue_script('fancybox');
  	wp_enqueue_script('isotope');
  	wp_enqueue_script('mobile-menu');
    wp_enqueue_script('jquery.selectbox.min');
	wp_enqueue_script('jquery');
	wp_enqueue_script('bootstrap');
	wp_enqueue_script('jquery-uii');
	wp_enqueue_script('jquery.placeholder');
	
	if (is_front_page()) {
	   wp_enqueue_script('jquery.nav');
	}
	
   /////////////////////////////////////
   
  	} 
}
add_action("wp_enqueue_scripts", "gt_queue_assets");


function funder_scripts() {
	global $edd_options;

	wp_enqueue_style( 'Patua-fonts', is_ssl() ? 'https' : 'http' . '://fonts.googleapis.com/css?family=Patua+One|Lato:400,700' );
	wp_enqueue_style( 'Roboto-fonts', is_ssl() ? 'https' : 'http' . '://fonts.googleapis.com/css?family=Roboto+Slab|Lato:400,700,300,100' );
	wp_enqueue_style( 'Titillium-fonts', is_ssl() ? 'https' : 'http' . '://fonts.googleapis.com/css?family=Titillium+Web|Lato:400,700,200,300' );
	    
	wp_enqueue_script( 'magnific', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '2.1.4', true );
	wp_enqueue_script( 'funder-scripts', get_template_directory_uri() . '/js/funder.js', array( 'magnific', 'jquery-masonry' ), 20130522, true );

	$funder_settings= array(
		'is_front_page' => is_front_page()
	);

	wp_localize_script( 'crowdfunding-scripts', 'funderSettings', $funder_settings );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'funder_scripts' );


// Load Admin assets 
function gt_admin_scripts() {
	wp_register_script('gt-admin-js', get_template_directory_uri() . '/assets/js/jquery.custom.admin.js');
    wp_enqueue_script('gt-admin-js');
    wp_register_style('gt-admin-css', get_template_directory_uri() . '/assets/css/custom-admin.css');
    wp_enqueue_style('gt-admin-css');
}
/*add_action('admin_enqueue_scripts', 'gt_admin_scripts');*/

/*-----------------------------------------------------------------------------------*/
/* Register Custom Menu
/*-----------------------------------------------------------------------------------*/

if ( function_exists('register_nav_menus') ) :
	register_nav_menus( array(
		  'Front' => __('Front Navigation Menu', 'wpg'),
		/*  'Inner' => __('Inner Navigation Menu', 'wpg')*/
		) );
endif;

/*-----------------------------------------------------------------------------------*/
/* Register Automatic Feed Links
/*-----------------------------------------------------------------------------------*/

add_theme_support('automatic-feed-links');

/*-----------------------------------------------------------------------------------*/
/* Shortcodes
/*-----------------------------------------------------------------------------------*/

require_once(get_template_directory() . '/functions/shortcodes.php');

/*-----------------------------------------------------------------------------------*/
/* Custom Theme Pagination
/*-----------------------------------------------------------------------------------*/

require_once(get_template_directory() . '/functions/pagination.php');

/*-----------------------------------------------------------------------------------*/
/* Custom Theme Functions
/*-----------------------------------------------------------------------------------*/

require_once(get_template_directory() . '/functions/theme-functions.php');

/*-----------------------------------------------------------------------------------*/
/* Dropdown Menu
/*-----------------------------------------------------------------------------------*/

require_once(get_template_directory() . '/functions/dropdown-menus.php');

/*-----------------------------------------------------------------------------------*/
/* Theme Login from
/*-----------------------------------------------------------------------------------*/

require_once(get_template_directory() . '/functions/theme-login.php');

/*-----------------------------------------------------------------------------------*/
/* Slightly Modified Options Framework (SMOF)
/*-----------------------------------------------------------------------------------*/

require_once(get_template_directory() . '/admin/index.php');

/*-----------------------------------------------------------------------------------*/
/* crowdfunding options
/*-----------------------------------------------------------------------------------*/

require( get_template_directory() . '/inc/crowdfunding.php' );

/*-----------------------------------------------------------------------------------*/
/* Custom Tags 
/*-----------------------------------------------------------------------------------*/

require( get_template_directory() . '/inc/template-tags.php' );

/*-----------------------------------------------------------------------------------*/
/* Custom functions that act independently of the theme templates
/*-----------------------------------------------------------------------------------*/

require( get_template_directory() . '/inc/extras.php' );

/*-----------------------------------------------------------------------------------*/
/* Customizer additions
/*-----------------------------------------------------------------------------------*/

require( get_template_directory() . '/inc/customizer.php' );

/*-----------------------------------------------------------------------------------*/
/* Submission form
/*-----------------------------------------------------------------------------------*/

require( get_template_directory() . '/campaign/submit.php' );

/*-----------------------------------------------------------------------------------*/
/* Contact form
/*-----------------------------------------------------------------------------------*/

require( get_template_directory() . '/campaign/contact.php' );

if ( ! isset( $content_width ) )
	$content_width = 745; /* pixels */

if ( ! function_exists( 'funder_setup' ) ) :
 
function funder_setup() {
	 
	load_theme_textdomain( 'funder', get_template_directory() . '/languages' );
	/**
	 * This theme supports AppThemer Crowdfunding Plugin
	 */
	add_theme_support( 'appthemer-crowdfunding', array(
		'campaign-edit'           => true,
		'campaign-featured-image' => true,
		'campaign-video'          => true,
		'campaign-widget'         => true,
		'campaign-categories'     => true,
		'campaign-regions'        => true
	) );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Custom Background
	 */
	 
	add_theme_support( 'custom-background' );
	 
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff',
		'default-image' => get_template_directory_uri() . '/img/background.png'
	) );

	/**
	 * Enable support for Post Thumbnails
	 */
	
/*-----------------------------------------------------------------------------------*/
/* Add support, and configure Thumbnails (for WordPress 2.9+)
/*-----------------------------------------------------------------------------------*/

	if ( function_exists('add_theme_support') ) {
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(200, 200, true); // Normal post thumbnails
	add_image_size('large', 632, 290, true); // Large thumbnails
	add_image_size('small', 125, '', true); // Small thumbnails
	add_image_size('project-thumb', 454, 454, true); // Project Thumbnail (appears on the homepage)
	add_image_size('single-post', 980, 523, true); // Large Post Thumbnail (appears on single post)
	add_image_size('archive-post', 980, 523, true); // Large Post Thumbnail (appears on archive pages)
	add_image_size( 'catlog', 300, 180, true );
	add_image_size( 'campaign', 253, 99999 );
	}

}
endif; // funder_setup
add_action( 'after_setup_theme', 'funder_setup' );


/*-----------------------------------------------------------------------------------*/
/* Register Sidebars/Widget Areas
/*-----------------------------------------------------------------------------------*/

function gt_widgets_init() {
  
  register_sidebar( array(
    'name' => 'Page Sidebar',
    'id' => 'sidebar-page',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => "</div>",
    'before_title' => '<h3 class="decoration text-center"><span class="nobacgr_desc">',
    'after_title' => '</span></h3>',
  ));
  
  register_sidebar( array(
    'name' => 'Blog Sidebar',
    'id' => 'sidebar-blog',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => "</div>",
    'before_title' => '<h3 class="decoration text-center"><span class="nobacgr_desc">',
	'after_title' => '</span></h3>',
  ));
  
   register_sidebar( array(
    'name' => 'Footer Widget 1',
    'id' => 'footer-1',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => "</div>",
    'before_title' => '<h4 class="widget-title">',
    'after_title' => '</h4>',
  ));
   register_sidebar( array(
    'name' => 'Footer Widget 2',
    'id' => 'footer-2',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => "</div>",
    'before_title' => '<h4 class="widget-title">',
    'after_title' => '</h4>',
  ));
   register_sidebar( array(
    'name' => 'Footer Widget 3',
    'id' => 'footer-3',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => "</div>",
    'before_title' => '<h4 class="widget-title">',
    'after_title' => '</h4>',
  ));
   register_sidebar( array(
    'name' => 'Footer Widget 4',
    'id' => 'footer-4',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => "</div>",
    'before_title' => '<h4 class="widget-title">',
    'after_title' => '</h4>',
  ));

}

add_action( 'init', 'gt_widgets_init' );


function funder_inline_modals() {
	global $edd_options;

	/*if ( isset ( $edd_options[ 'login_page' ] ) && isset ( $edd_options[ 'register_page' ] ) ) {
		get_template_part( 'modal', 'login' );
		get_template_part( 'modal', 'register' );
	}*/

	if ( is_singular( 'download' ) && funder_is_crowdfunding() )
		get_template_part( 'modal', 'contribute' );
}
add_action( 'wp_footer', 'funder_inline_modals' );

// return the array of category
	function get_category_list( $category_name, $parent='' ){
		
		if( empty($parent) ){ 
		
			$get_category = get_categories( array( 'taxonomy' => $category_name	));
			$category_list = array( '0' =>'All');
			foreach( $get_category as $category ){
				$category_list[] = $category->cat_name;
			}
			return $category_list;
			
		}else{
			
			$parent_id = get_term_by('name', $parent, $category_name);
			$get_category = get_categories( array( 'taxonomy' => $category_name, 'child_of' => $parent_id->term_id	));
			$category_list = array( '0' => $parent );
			foreach( $get_category as $category ){
				$category_list[] = $category->cat_name;
			}
			return $category_list;		
		
		}
	}
	
   
   function sticky_nav() {
	if( is_user_logged_in() )  { 
	echo '<style> .header-wrapper {top:28px !important;} </style>';
	}
}
add_action( 'wp_head', 'sticky_nav' );