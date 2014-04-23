<?php

/*-----------------------------------------------------------------------------------*/
/* Remove Line Breaks and P tags in Shortcodes
/*-----------------------------------------------------------------------------------*/

function gt_clean_shortcodes($content){   
    $array = array (
        '<p>[' => '[', 
        ']</p>' => ']', 
        ']<br />' => ']'
    );
    $content = strtr($content, $array);
    return $content;
}
add_filter('the_content', 'gt_clean_shortcodes');

/*-----------------------------------------------------------------------------------*/
/* Custom function for the Comments
/*-----------------------------------------------------------------------------------*/

function gt_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
?>
	<li class="comment">
	
		<div>
			
		<?php echo get_avatar($comment, $size = '50'); ?>
		    
		    <div class="comment-meta">
		        <h5 class="author"><a href="<?php comment_author_url(); ?>" target="about_blank"><?php comment_author(); ?></a> - <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></h5>
		        <p class="date"><?php printf(__('%1$s at %2$s', 'wpg'), get_comment_date(),  get_comment_time()) ?></p>
		    </div>
		    
		    <div class="comment-entry">
		    <?php comment_text() ?>
		    </div>
		
		</div>
		
		<?php if ($comment->comment_approved == '0') : ?>
			<em class="comment-moderate"><?php _e('Your comment is awaiting moderation.', 'wpg') ?></em>
			<br />
		<?php endif; ?>
		
		<?php edit_comment_link(__('(Edit)', 'wpg'),'  ','') ?>
		
<?php
}

/*-----------------------------------------------------------------------------------*/
/* Custom function for the Comment Form
/*-----------------------------------------------------------------------------------*/

add_filter('comment_form_defaults', 'gt_comment_form');

function gt_comment_form($form_options) {

    // Fields Array
    $fields = array(

	    'author' =>
	    '<p class="comment-form-author">' .
	    '<input id="author" name="author" type="text" size="30" placeholder="' . __( 'Your Name (required)', 'wpg' ) . '" />' .
	    '</p>',
	
	    'email' =>
	    '<p class="comment-form-email">' .
	    '<input id="email" name="email" type="text" size="30" placeholder="' . __( 'Your Email (will not be published)', 'wpg' ) . '" />' .
	    '</p>',
	
	    'url' =>
	    '<p class="comment-form-url">'  .
	    '<input name="url" size="30" id="url" type="text" placeholder="' . __( 'Your Website (optional)', 'wpg' ) . '" />' .
	    '</p>',

    );
    global $user_identity;
    // Form Options Array
    $form_options = array(
        // Include Fields Array
        'fields' => apply_filters( 'comment_form_default_fields', $fields ),

        // Template Options
        'comment_field' =>
        '<p class="comment-form-comment">' .
        '<textarea name="comment" id="comment" aria-required="true" rows="8" cols="45" placeholder="' . __( 'Please leave your comment...', 'wpg' ) . '"></textarea>' .
        '</p>',

        'must_log_in' =>
        '<p class="must-log-in">' .
        sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'wpg' ),
            wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) .
        '</p>',

        'logged_in_as' =>
        '<p class="logged-in-as">' .
        sprintf( __( 'You are currently logged in<a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'wpg' ),
            admin_url('profile.php'), $user_identity, wp_logout_url( apply_filters('the_permalink', get_permalink()) ) ) .
        '</p>',

        'comment_notes_before' => '',

        'comment_notes_after' => '',

        // Rest of Options
        'id_form' => 'form-comment',
        'id_submit' => 'submit',
        'title_reply' => __( 'Please leave a Comment', 'wpg' ),
        'title_reply_to' => __( 'Leave a Reply to %s', 'wpg' ),
        'cancel_reply_link' => __( 'Cancel reply', 'wpg' ),
        'label_submit' => __( 'Post Comment', 'wpg' ),
    );

    return $form_options;
}

/*-----------------------------------------------------------------------------------*/
/* Custom Navigation for Single Posts
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'gt_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 */
function gt_content_nav( $nav_id ) {
	global $wp_query;

	?>

	<?php if ( is_single() ) : // navigation links for single posts ?>
<ul class="pager">
		<?php previous_post_link( '<li class="previous">%link</li>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'wpg' ) . '</span> %title' ); ?>
		<?php next_post_link( '<li class="next">%link</li>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'wpg' ) . '</span>' ); ?>
</ul>

	<?php endif; ?>

	<?php
}
endif;

/*-----------------------------------------------------------------------------------*/
/* Numbered Post Navigation (for Post Index, Archives, and Search Results)
/*-----------------------------------------------------------------------------------*/

function wp_pagenavi() {
  
  global $wp_query, $wp_rewrite;
  $pages = '';
  $max = $wp_query->max_num_pages;
  if (!$current = get_query_var('paged')) $current = 1;
  $args['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
  $args['total'] = $max;
  $args['current'] = $current;
 
  $total = 1;
  $args['mid_size'] = 3;
  $args['end_size'] = 1;
  $args['prev_text'] = '<i class="icon-arrow-left"></i>';
  $args['next_text'] = '<i class="icon-arrow-right"></i>';
 
  if ($max > 1) echo '</pre>
    <div class="pagination">';
 echo $pages . paginate_links($args);
 if ($max > 1) echo '</div>';

}

/*-----------------------------------------------------------------------------------*/
/* Custom Function for Navigation Menu
/*-----------------------------------------------------------------------------------*/

function custom_wp_nav_menu($var) {
        return is_array($var) ? array_intersect($var, array(
                //List of allowed menu classes
                'current_page_item',
                'current_page_parent',
                'current_page_ancestor',
                'first',
                'last',
                'vertical',
                'horizontal'
                )
        ) : '';
}
add_filter('nav_menu_css_class', 'custom_wp_nav_menu');
add_filter('nav_menu_item_id', 'custom_wp_nav_menu');
add_filter('page_css_class', 'custom_wp_nav_menu');
 
//Replaces "current-menu-item" with "active"
function current_to_active($text){
        $replace = array(
                //List of menu item classes that should be changed to "active"
                'current_page_item' => 'nav-item',
                'current_page_parent' => 'nav-item',
                'current_page_ancestor' => 'nav-item',
        );
        $text = str_replace(array_keys($replace), $replace, $text);
                return $text;
        }
add_filter ('wp_nav_menu','current_to_active');
 
//Deletes empty classes and removes the sub menu class
function strip_empty_classes($menu) {
    $menu = preg_replace('/ class=""| class="sub-menu"/','',$menu);
    return $menu;
}
add_filter ('wp_nav_menu','strip_empty_classes');

/*-----------------------------------------------------------------------------------*/
/* Custom function for the Excerpt
/*-----------------------------------------------------------------------------------*/

function custom_trim_excerpt($text) {
    global $post;
    if ('' == $text) {
        $text = get_the_content('');
        $text = apply_filters('the_content', $text);
        $text = str_replace('\]\]\>', ']]&gt;', $text);
        $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
        $text = strip_tags($text, '<p>,<a>,<em>,<blockquote>,<iframe>');
        $excerpt_length = 35;
        $words = explode(' ', $text, $excerpt_length + 1);
        if (count($words) > $excerpt_length) {
            array_pop($words);
            array_push($words, '...');
            $text = implode(' ', $words);
        }
    }
    return $text;
}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_trim_excerpt');

/*-----------------------------------------------------------------------------------*/
/* Custom Search Filter (Returns only Posts. Theme Specific)
/*-----------------------------------------------------------------------------------*/

function gt_search_filter($query) {
if ($query->is_search) {
$query->set('post_type', 'post');
}
return $query;
}

add_filter('pre_get_posts','gt_search_filter');

/*-----------------------------------------------------------------------------------*/
/* Font Awesome Shortcodes
/*-----------------------------------------------------------------------------------*/

class FontAwesome {
    public function __construct() {
        add_action( 'init', array( &$this, 'init' ) );
    }

    public function init() {
        add_action( 'wp_enqueue_scripts', array( $this, 'register_awesome_styles' ) );
        add_shortcode( 'icon', array( $this, 'setup_shortcode' ) );
        add_filter( 'widget_text', 'do_shortcode' );
    }

    public function register_awesome_styles() {
        global $wp_styles;
        wp_register_style('font-awesome-styles', get_template_directory_uri().'/style.css');
        wp_enqueue_style('font-awesome-styles');
    }

    public function setup_shortcode( $params ) {
        extract( shortcode_atts( array(
                    'name'  => 'icon-wrench'
                ), $params ) );
        $icon = '<i class="'.$params['name'].'"></i>';

        return $icon;
    }

}

new FontAwesome();

/*-----------------------------------------------------------------------------------*/
/* Output Image
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'gt_image' ) ) {
    function gt_image($postid, $imagesize) {
        // get the featured image for the post
        $thumbid = 0;
        if( has_post_thumbnail($postid) ) {
            $thumbid = get_post_thumbnail_id($postid);
        }

        $image_ids_raw = get_post_meta($postid, 'gt_image_ids', true);

        if( $image_ids_raw ) {
            // Using WP3.5; use post__in orderby option
            $image_ids = explode(',', $image_ids_raw);
            $temp_id = $postid;
            $postid = null;
            $orderby = 'post__in';
            $include = $image_ids;
        } else {
            $orderby = 'menu_order';
            $include = '';
        }
    
        // get first 10 attachments for the post
        $args = array(
            'include' => $include,
            'orderby' => $orderby,
            'post_type' => 'attachment',
            'post_parent' => $postid,
            'post_mime_type' => 'image',
            'post_status' => null,
            'numberposts' => 10
        );
        $attachments = get_posts($args);

        $postid = ( isset($temp_id) ) ? $temp_id : $postid;

        if( !empty($attachments) ) {
            foreach( $attachments as $attachment ) {
                // if current image is featured image reloop
                if( $attachment->ID == $thumbid ) continue; 
                $full = wp_get_attachment_image_src( $attachment->ID, 'full', false, false );  
                $large = wp_get_attachment_image_src( $attachment->ID, 'feature-image', false, false );
                $alt = ( !empty($attachment->post_content) ) ? $attachment->post_content : $attachment->post_title;
                $title = ( !empty($attachment->post_content) ) ? $attachment->post_content : $attachment->post_title;
                echo "<section class='project-thumbs'>";
                echo '<a class="fancybox" rel="gallery" href="'.$full[0].'"><img src="'.$large[0].'" alt="'.$alt.'" /></a>';
                echo "</section>";
                // got image, time to exit foreach
                break;
            }
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/* Output Slideshow
/*-----------------------------------------------------------------------------------*/

function gt_gallery($postid, $imagesize) { ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery(".slider").flexslider({
                    preload: true,
                    preloadImage: jQuery(".flexslider-<?php echo $postid; ?>").attr('data-loader')
                });
            });
        </script>
    <?php 
        $loader = 'loader.gif';
        $thumbid = 0;
    
        // get the featured image for the post
        if( has_post_thumbnail($postid) ) {
            $thumbid = get_post_thumbnail_id($postid);
        }
        echo "<!-- BEGIN #slider-$postid -->\n<div class='flexslider' data-loader='" . get_template_directory_uri() . "/assets/img/$loader'>";
        
        $image_ids_raw = get_post_meta($postid, 'gt_image_ids', true);

        if( $image_ids_raw ) {
            // Using WP3.5; use post__in orderby option
            $image_ids = explode(',', $image_ids_raw);
            $temp_id = $postid;
            $postid = null;
            $orderby = 'post__in';
            $include = $image_ids;
        } else {
            $orderby = 'menu_order';
            $include = '';
        }

        // get all of the attachments for the post
        $args = array(
            'include' => $include,
            'orderby' => $orderby,
            'post_type' => 'attachment',
            'post_parent' => $postid,
            'post_mime_type' => 'image',
            'post_status' => null,
            'numberposts' => -1
        );
        $attachments = get_posts($args);
        
        if( !empty($attachments) ) {
            echo '<ul class="slides">';
            $i = 0;
            foreach( $attachments as $attachment ) {
                if( $attachment->ID == $thumbid ) continue;
                $src = wp_get_attachment_image_src( $attachment->ID, $imagesize );
                $full = wp_get_attachment_image_src( $attachment->ID, 'full', false, false );
                $large = wp_get_attachment_image_src( $attachment->ID, 'large-slider-thumb', false, false );
                $caption = $attachment->post_excerpt;
                $caption = ($caption) ? "<div class='slider-desc'>$caption</div>" : '';
                $alt = ( !empty($attachment->post_content) ) ? $attachment->post_content : $attachment->post_title;
                echo "<li>$caption<a class='fancybox' rel='gallery' href='$full[0]'><img height='$src[2]' width='$src[1]' src='$large[0]' alt='$alt' /></a></li>";
                $i++;
            }
            echo '</ul>';
        }
        echo '</div>';
    }
    
/*-----------------------------------------------------------------------------------*/
/* Fixes WC3 Validation WordPress bug!!!!
/*-----------------------------------------------------------------------------------*/

add_filter( 'the_category', 'replace_cat_tag' );
 
function replace_cat_tag ( $text ) {
$text = str_replace('rel="category tag"', "", $text); return $text;
}