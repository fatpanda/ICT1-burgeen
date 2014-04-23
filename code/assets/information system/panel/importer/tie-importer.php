<?php
function tie_set_demo_data(){
	$theme_options = get_option( 'tie_options' );
		
	$cat1 = $cat2 = $cat3 = $cat4 = $cat5 = $cat6 = $cat7 = $cat8 = 1;
	$cat1 =  get_cat_ID( 'Design' );
	$cat3 =  get_cat_ID( 'Technology' );
	$cat4 =  get_cat_ID( 'Business' );
	$cat5 = $cat2 =  get_cat_ID( 'World' );
	$cat6 =  get_cat_ID( 'Android' );
	$cat7 =  get_cat_ID( 'BlackBerry' );
	$cat8 =  get_cat_ID( 'iPhone' );
	
	$home_cats1 = array(
		array(
            'title' => 'Recent Posts',
            'number' => 2,
            'display' => 'blog',
            'pagi' => 'n',
            'boxid' => 'recent_1777',
            'type' => 'recent'
		)
	);
	$home_cats2 = array(
		array(
            'title' => 'Best Reviews',
            'number' => 4,
            'order' => 'best',
            'boxid' => 'rev_11369',
            'id1' => $cat8,
            'id2' => $cat7,
            'id3' => $cat6,
            'type' => 'rev'
        )
	);
	
	$home_cats3 = array(
		array(
            'id' => $cat1,
            'order' => 'latest',
            'number' => 5,
            'style' => 'li',
            'type' => 'n'
        ),
		array(
            'id' => $cat3,
            'title' => 'Scrolling Box',
            'number' => 12,
            'boxid' => 's_11140',
            'type' => 's'
        ),
		array(
            'id' => $cat2,
            'order' => 'latest',
            'number' => 4,
            'style' => '2c',
            'type' => 'n'
        ),
		array(
            'id' => $cat4,
            'order' => 'latest',
            'number' => 4,
            'style' => '2c',
            'type' => 'n'
        ),
		array(
            'id' => $cat1,
            'title' => 'News In Picture',
            'boxid' => 'news-pic_1775',
            'type' => 'news-pic',
            'style' => 'default'
        )
	);

	$home_cats4 = array(
		array(
            'id' => $cat5,
            'title' => 'Scrolling Box',
            'number' => 8,
            'boxid' => 's_187640',
            'type' => 's'
        ),
	);

	$theme_options['social']['facebook'] = 'https://www.facebook.com/TieLabs';
	$theme_options['social']['twitter'] = 'https://twitter.com/mo3aser';
	$theme_options['social']['dribbble'] = 'http://dribbble.com/mo3aser';
	$theme_options['social']['foursquare'] = 'https://foursquare.com/mo3aser';
	$theme_options['social']['Pinterest'] = 'http://www.pinterest.com/mo3aser/';
	$theme_options['social']['instagram'] = 'http://instagram.com/imo3aser';
	
	$theme_options['on_home'] = 'boxes';
	$theme_options['footer_widgets'] = 'footer-4c';
	$theme_options['slider_type'] = 'flexi';
	$theme_options['slider_cat'] = array($cat1, $cat2, $cat3, $cat4 );
	$theme_options['banner_top'] = $theme_options['banner_bottom'] = true;
	$theme_options['banner_top_img'] = $theme_options['banner_bottom_img'] = 'http://themes.tielabs.com/jarida/wp-content/uploads/2013/03/728.jpg';
	$theme_options['banner_top_url'] = $theme_options['banner_bottom_url'] = 'http://themeforest.net/item/jarida-responsive-wordpress-news-magazine-blog/4309191?ref=TieLabs';
	
	update_option( 'tie_home_cats1' , $home_cats1 );
	update_option( 'tie_home_cats2' , $home_cats2 );
	update_option( 'tie_home_cats3' , $home_cats3 );
	update_option( 'tie_home_cats4' , $home_cats4 );
	
	update_option( 'tie_options' , $theme_options );

	//Import Menus
	$top_menu = get_term_by('name', 'top', 'nav_menu');
	$main_menu = get_term_by('name', 'main', 'nav_menu');
	set_theme_mod( 'nav_menu_locations' , array('top-menu' => $top_menu->term_id , 'primary' => $main_menu->term_id ) );
	
	
	//Import Widgets
	update_option('sidebars_widgets', '');
	
	tie_addWidgetToSidebar( 'primary-widget-area' , 'counter-widget', 0, array('facebook' => 'https://www.facebook.com/TieLabs','youtube' => 'http://www.youtube.com/user/TEAMMESAI','vimeo' => 'http://vimeo.com/channels/kidproof'));
	tie_addWidgetToSidebar( 'primary-widget-area', 'widget_tabs', 0);
	tie_addWidgetToSidebar( 'primary-widget-area' , 'facebook-widget', 0, array('title' => 'Find us on Facebook', 'page_url' => 'https://www.facebook.com/TieLabs'));
	tie_addWidgetToSidebar( 'primary-widget-area' , 'social', 0, array('title' => 'Social', 'tran_bg' => true, 'icons_size' => 32 ));
	tie_addWidgetToSidebar( 'primary-widget-area' , 'youtube-widget', 0, array('title' => 'Subscribe to our Channel', 'page_url' => 'TEAMMESAI'));
	tie_addWidgetToSidebar( 'primary-widget-area' , 'video-widget', 0, array('title' => ' Featured Video', 'youtube_video' => 'UjXi6X-moxE'));
	tie_addWidgetToSidebar( 'primary-widget-area' , 'login-widget', 0, array('title' => ' Login'));
	
	tie_addWidgetToSidebar( 'first-footer-widget-area' , 'posts-list-widget', 0, array('title' => 'Popular Posts', 'no_of_posts' => 5, 'thumb' => true , 'posts_order' => 'popular'));
	tie_addWidgetToSidebar( 'second-footer-widget-area' , 'posts-list-widget', 0, array('title' => 'Random Posts', 'no_of_posts' => 5, 'thumb' => true , 'posts_order' => 'random'));
	tie_addWidgetToSidebar( 'third-footer-widget-area' , 'posts-list-widget', 0, array('title' => 'Latest Posts', 'no_of_posts' => 5, 'thumb' => true ,  'posts_order' => 'latest'));
	tie_addWidgetToSidebar( 'fourth-footer-widget-area' , 'comments_avatar-widget', 0, array('title' => 'Recent Comments', 'thumb' => true , 'no_of_comments' => 5, 'avatar_size' => 50));

	tie_addWidgetToSidebar( 'homepage-normal-widget-area1' , 'counter-widget', 0, array('facebook' => 'https://www.facebook.com/TieLabs','youtube' => 'http://www.youtube.com/user/TEAMMESAI','vimeo' => 'http://vimeo.com/channels/kidproof'));
	tie_addWidgetToSidebar( 'homepage-normal-widget-area1' , 'widget_tabs', 0);
	tie_addWidgetToSidebar( 'homepage-normal-widget-area2' , 'facebook-widget', 0, array('title' => 'Find us on Facebook', 'page_url' => 'https://www.facebook.com/TieLabs'));
	tie_addWidgetToSidebar( 'homepage-normal-widget-area2' , 'social', 0, array('title' => 'Social', 'tran_bg' => true, 'icons_size' => 32 ));
	tie_addWidgetToSidebar( 'homepage-normal-widget-area2' , 'youtube-widget', 0, array('title' => 'Subscribe to our Channel', 'page_url' => 'TEAMMESAI'));
	tie_addWidgetToSidebar( 'homepage-normal-widget-area2' , 'video-widget', 0, array('title' => ' Featured Video', 'youtube_video' => 'UjXi6X-moxE'));
	tie_addWidgetToSidebar( 'homepage-normal-widget-area2' , 'login-widget', 0, array('title' => ' Login'));
	
	tie_addWidgetToSidebar( 'homepage-narrow-widget-area1' , 'archives', 0);
	tie_addWidgetToSidebar( 'homepage-narrow-widget-area1' , 'categories', 0);
	tie_addWidgetToSidebar( 'homepage-narrow-widget-area1' , 'meta', 0);
	tie_addWidgetToSidebar( 'homepage-narrow-widget-area2' , 'tag_cloud', 0);
	tie_addWidgetToSidebar( 'homepage-narrow-widget-area2' , 'recent-comments', 0);
	tie_addWidgetToSidebar( 'homepage-narrow-widget-area2' , 'recent-posts', 0);

	tie_addWidgetToSidebar( 'narrow-primary-widget-area' , 'archives', 0);
	tie_addWidgetToSidebar( 'narrow-primary-widget-area' , 'categories', 0);
	tie_addWidgetToSidebar( 'narrow-primary-widget-area' , 'meta', 0);
	tie_addWidgetToSidebar( 'narrow-primary-widget-area' , 'tag_cloud', 0);
	tie_addWidgetToSidebar( 'narrow-primary-widget-area' , 'recent-comments', 0);
	tie_addWidgetToSidebar( 'narrow-primary-widget-area' , 'recent-posts', 0);

	
}

function tie_addWidgetToSidebar($sidebarSlug, $widgetSlug, $countMod, $widgetSettings = array()){
	$sidebarOptions = get_option('sidebars_widgets');
	if(!isset($sidebarOptions[$sidebarSlug])){
	$sidebarOptions[$sidebarSlug] = array('_multiwidget' => 1);
	}
	$newWidget = get_option('widget_'.$widgetSlug);
	if(!is_array($newWidget))$newWidget = array();
	$count = count($newWidget)+1+$countMod;
	$sidebarOptions[$sidebarSlug][] = $widgetSlug.'-'.$count;

	$newWidget[$count] = $widgetSettings;

	update_option('sidebars_widgets', $sidebarOptions);
	update_option('widget_'.$widgetSlug, $newWidget);
}

function tie_demo_installer() { ?>  
	<div id="icon-tools" class="icon32"><br></div>
	<h2>Import Demo Data</h2>
	<div style="background-color: #F5FAFD; margin:10px 0;padding: 10px;color: #0C518F;border: 3px solid #CAE0F3; claer:both; width:90%; line-height:18px;">
		<p class="tie_message_hint">Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme. It will
		allow you to quickly edit everything instead of creating content from scratch. When you import the data following things will happen:</p>
	  
	  <ul style="padding-left: 20px;list-style-position: inside;list-style-type: square;}">
		  <li>No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified .</li>
		  <li>No WordPress settings will be modified .</li>
		  <li>About 10 posts, a few pages, 10+ images, some widgets and two menus will get imported .</li>
		  <li>Images will be downloaded from our server, these images are copyrighted and are for demo use only .</li>
		  <li>please click import only once and wait, it can take a couple of minutes</li>
	  </ul>
	 </div>
	<form method="post">
		<input type="hidden" name="demononce" value="<?php echo wp_create_nonce('tie-demo-code'); ?>" />
		<input name="reset" class="mpanel-save" type="submit" value="Import Demo Data" />
		<input type="hidden" name="action" value="demo-data" />
	</form>
	<br />
	<br />	
<?php 
	if(  'demo-data' == $_REQUEST['action'] && check_admin_referer('tie-demo-code' , 'demononce')){
		if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
			require_once ABSPATH . 'wp-admin/includes/import.php';
			$importer_error = false;
			if ( !class_exists( 'WP_Importer' ) ) {
				$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
				if ( file_exists( $class_wp_importer ) ){
					require_once($class_wp_importer);
				}
				else{
					$importer_error = true;
				}
			}
			
		if ( !class_exists( 'WP_Import' ) ) {
			$class_wp_import = get_template_directory() . '/panel/importer/wordpress-importer.php';
			if ( file_exists( $class_wp_import ) )
				require_once($class_wp_import);
			else
				$importerError = true;
		}
		if($importer_error){
			die("Error in import :(");
		}else{
			if(!is_file( get_template_directory() . '/panel/importer/sample.xml')){
				echo "The XML file containing the dummy content is not available or could not be read .. You might want to try to set the file permission to chmod 755.<br/>If this doesn't work please use the wordpress importer and import the XML file (should be located in your download .zip: Sample Content folder) manually ";
			}
			else{
				$wp_import = new WP_Import();
				$wp_import->fetch_attachments = true;
				$wp_import->import( get_template_directory() . '/panel/importer/sample.xml');
		  }
	  }
		tie_set_demo_data();
	}
}
?>