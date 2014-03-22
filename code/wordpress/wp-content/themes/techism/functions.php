<?php
/**
 * techism functions and definitions
 *
 * @package techism
 */

// Set up the content width value based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 625;

function techism_setup() {
	/*
	 * Makes techism available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on techism, use a find and replace
	 * to change 'techism' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'techism', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'techism' ) );

	/*
	 * This theme supports custom background color and image,
	 * and here we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
	
/*
 * Enable support for Slider Thumbnails
 */
	
	add_image_size( 'techism-slider-image', 960, 353, true );
}
add_action( 'after_setup_theme', 'techism_setup' );

/**
 * Add support for a custom header image.
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
  * Using template-tags.php file 
  */
require( get_template_directory() . '/inc/tags.php' );  

/**
 * Return the Google font stylesheet URL if available.
 *
 */

function techism_get_font_url() {
	$font_url = '';

	/* translators: If there are characters in your language that are not supported
	 * by Open Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'techism' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language,
		 * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'techism' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400italic,700italic,400,700',
			'subset' => $subsets,
		);
		$font_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $font_url;
}

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since techism 2.0.0
 */
function techism_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'techism' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'techism_wp_title', 10, 2 );

/**
 *
 * Enqueue scripts and styles for front-end.
 */
function techism_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds slider Javascript  
	 */
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/assets/js/flexslider.min.js', array( 'jquery' ), null, true );
	
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
		
	// Adds jquery file when needed
	 if ( get_theme_mod('techism_google_font') == '0' ) {
	wp_enqueue_script(
		'custom-script',
		get_stylesheet_directory_uri() . '/assets/js/custom.js',
		array( 'jquery' )
	);
	}
	// Adds JavaScript for handling the navigation menu hide-and-show behavior.
	wp_enqueue_script( 'techism-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '1.0', true );

	// Loads our main stylesheet.
	wp_enqueue_style( 'techism-style', get_stylesheet_uri() );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'techism-ie', get_template_directory_uri() . '/assets/css/ie.css', array( 'techism-style' ), '20121010' );
	
	wp_enqueue_style( 'techism-icon-fonts', get_template_directory_uri() . '/assets/css/genericons.css' );
	$wp_styles->add_data( 'techism-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'techism_scripts_styles' );

/**
 * Register sidebars.
 */
function techism_widgets_init() {
register_sidebar( array(
    'name' => __( 'Left Sidebar', 'techism' ),
    'id' => 'sidebar-1',
    'description' => __( 'Widgets in this area will be shown on the left-hand side.', 'techism' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<hr class="widget-top-hr">'.'<h1 class="widget-title">',
    'after_title' => '<hr class="widget-below-hr">'.'</h1>',
  ) );

  register_sidebar( array(
    'name' => __( 'Right Sidebar', 'techism' ),
    'id' => 'sidebar-2',
    'description' => __( 'Widgets in this area will be shown on the right-hand side.', 'techism' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<hr class="widget-top-hr">'.'<h1 class="widget-title">',
    'after_title' => '<hr class="widget-below-hr">'.'</h1>',
  ) ); 

  /* Register footer Sidebar  */

  register_sidebar( array(
    'name' => __( 'Footer 1', 'techism' ),
    'id' => 'footer-1',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<hr class="widget-top-hr">'.'<h1 class="widget-title">',
    'after_title' => '<hr class="widget-below-hr">'.'</h1>',
  ) ); 

  register_sidebar( array(
    'name' => __( 'Footer 2', 'techism' ),
    'id' => 'footer-2',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<hr class="widget-top-hr">'.'<h1 class="widget-title">',
    'after_title' => '<hr class="widget-below-hr">'.'</h1>',
  ) ); 

  register_sidebar( array(
    'name' => __( 'Footer 3', 'techism' ),
    'id' => 'footer-3',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<hr class="widget-top-hr">'.'<h1 class="widget-title">',
    'after_title' => '<hr class="widget-below-hr">'.'</h1>',
  ) ); 

  register_sidebar( array(
    'name' => __( 'Footer 4', 'techism' ),
    'id' => 'footer-4',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<hr class="widget-top-hr">'.'<h1 class="widget-title">',
    'after_title' => '<hr class="widget-below-hr">'.'</h1>',
  ) ); 

  /* End of footer Sidebar */
}
add_action( 'widgets_init', 'techism_widgets_init' );

if ( ! function_exists( 'techism_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 */
function techism_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'techism' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'techism' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'techism' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;

if ( ! function_exists( 'techism_comment' ) ) :
/**
 * Template for comments and pingbacks.
 */
function techism_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'techism' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'techism' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'techism' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'techism' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'techism' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'techism' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'techism' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'techism_entry_meta' ) ) :
/**
 * Set up post entry meta.
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 */
function techism_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'techism' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'techism' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'techism' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'techism' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'techism' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'techism' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;

/**
 * Extend the default WordPress body classes.
 */
function techism_body_class( $classes ) {
	if (!is_active_sidebar('sidebar-1'))
		$classes[] = 'no-left';
	if (!is_active_sidebar( 'sidebar-2' ))
		$classes[] = 'no-right';
    if ( (!is_active_sidebar( 'sidebar-1' ) && !is_active_sidebar( 'sidebar-2' )) || is_page_template( 'page-templates/full-width.php' ))
		$classes[] = 'no-sidebars';
	return $classes;
}
add_filter( 'body_class', 'techism_body_class' );

/**
 * Adjust content width in certain contexts.
 */
function techism_content_width() {
	if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'techism_content_width' );
	
function techism_slider_script() {
?>

<?php if( is_front_page() && ! is_paged() ) : ?>
<script>
 jQuery(document).ready(function($){
	$('.flexslider').flexslider({
		selector          : '.slides > li',
		animation         : 'slide',
		easing            : 'swing',
		direction         : 'horizontal',
		animationLoop     : true,
		smoothHeight       : true,
		startAt           : 0,
		slideshow         : true,
		slideshowSpeed    : 7000,
		animationSpeed    : 600,
		initDelay         : 0,
		pauseOnAction     : true,
		pauseOnHover      : true,
		before: function() {
		$('.flexslider .flex-caption').hide();
		},
		after: function() {
		$('.flexslider .flex-caption').fadeIn();
		}
	});
	});
	

</script>
<?php endif;
}
add_action ('wp_head', 'techism_slider_script');

/* 
 * Load the live customizer page and welcome page if in admin mode
 */
if ( is_admin() )
	require_once( get_template_directory() . '/inc/techism-customizer.php' );

	?>