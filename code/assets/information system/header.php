<!DOCTYPE html>
<html <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>
<?php global $is_IE ?>
<body id="top" <?php body_class(); ?>>
<?php if( tie_get_option('banner_bg_url') && tie_get_option('banner_bg') ): ?>
	<a href="<?php echo tie_get_option('banner_bg_url') ?>" target="_blank" class="background-cover"></a>
<?php else: ?>
	<div class="background-cover"></div>
<?php endif; ?>
	<div class="wrapper<?php if(tie_get_option( 'theme_layout' ) == 'full') echo ' full-site'; if(tie_get_option( 'columns_num' ) == '2c') echo ' layout-2c'; if( tie_get_option( 'lazy_load' ) && !tie_is_android() ) echo ' animated'; ?>">
		<?php if(!tie_get_option( 'top_menu' )): ?>
		<div class="top-nav fade-in animated1 <?php echo tie_get_option( 'top_left' ); ?>">
			<div class="container">
				<div class="search-block">
					<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
						<button class="search-button" type="submit" value="<?php if( !$is_IE ) _e( 'Search' , 'tie' ) ?>"></button>	
						<input type="text" id="s" name="s" value="<?php _e( 'Search...' , 'tie' ) ?>" onfocus="if (this.value == '<?php _e( 'Search...' , 'tie' ) ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'Search...' , 'tie' ) ?>';}"  />
					</form>
				</div><!-- .search-block /-->
				<?php tie_get_social( 'yes' , 'flat' , 'tooldown' , true ); ?>
				
				<?php
					if( tie_get_option( 'top_left' ) == 'head_menu' )
						wp_nav_menu( array( 'container_class' => 'top-menu', 'theme_location' => 'top-menu', 'fallback_cb' => 'tie_nav_fallback'  ) );
					elseif(tie_get_option( 'top_left' ) == 'head_brnews')
						get_template_part( 'includes/breaking-news' );
				?>
				<?php tie_language_selector_flags(); ?>

			</div>
		</div><!-- .top-menu /-->
		<?php endif; ?>		

		<div class="container">	
		<header id="theme-header">
		<div class="header-content fade-in animated1">
<?php $logo_margin =''; if( tie_get_option( 'logo_margin' )) $logo_margin = ' style="margin-top:'.tie_get_option( 'logo_margin' ).'px"';  ?>
			<div class="logo"<?php echo $logo_margin ?>>
			<?php if( !is_singular() ) echo '<h1>'; else echo '<h2>'; ?>
<?php if( tie_get_option('logo_setting') == 'title' ): ?>
				<a  href="<?php echo home_url() ?>/"><?php bloginfo('name'); ?></a>
				<span><?php bloginfo( 'description' ); ?></span>
				<?php else : ?>
				<?php if( tie_get_option( 'logo' ) ) $logo = tie_get_option( 'logo' );
						else $logo = get_stylesheet_directory_uri().'/images/logo.png';
				?>
				<a title="<?php bloginfo('name'); ?>" href="<?php echo home_url(); ?>/">
					<img src="<?php echo $logo ; ?>" alt="<?php bloginfo('name'); ?>" /><strong><?php bloginfo('name'); ?> <?php bloginfo( 'description' ); ?></strong>
				</a>
<?php endif; ?>
			<?php if( !is_singular() ) echo '</h1>'; else echo '</h2>'; ?>
			</div><!-- .logo /-->
<?php if( tie_get_option( 'logo_retina' ) && tie_get_option( 'logo_retina_width' ) && tie_get_option( 'logo_retina_height' )): ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	var retina = window.devicePixelRatio > 1 ? true : false;
	if(retina) {
       	jQuery('#theme-header .logo img').attr('src', '<?php echo tie_get_option( 'logo_retina' ); ?>');
       	jQuery('#theme-header .logo img').attr('width', '<?php echo tie_get_option( 'logo_retina_width' ); ?>');
       	jQuery('#theme-header .logo img').attr('height', '<?php echo tie_get_option( 'logo_retina_height' ); ?>');
	}
});
</script>
<?php endif; ?>
			<?php tie_banner('banner_top' , '<div class="ads-top">' , '</div>' ); ?>
			<div class="clear"></div>
		</div>	
		<?php $stick = ''; ?>
		<?php if( tie_get_option( 'stick_nav' ) ) $stick = ' fixed-enabled' ?>
		<?php
		//UberMenu Support
		$navID = 'main-nav';
		if ( class_exists( 'UberMenu' ) ){
			$uberMenus = get_option( 'wp-mega-menu-nav-locations' );
			if( !empty($uberMenus) && is_array($uberMenus) && in_array("primary", $uberMenus)) $navID = 'main-nav-uber';
		}?>
			<nav id="<?php echo $navID; ?>" class="fade-in animated2<?php echo $stick; ?>">
				<div class="container">				
				<?php $orig_post = $post; wp_nav_menu( array( 'container_class' => 'main-menu', 'theme_location' => 'primary' ,'fallback_cb' => 'tie_nav_fallback',  'walker' => new tie_mega_menu_walker()  ) ); $post = $orig_post; ?>
				</div>
			</nav><!-- .main-nav /-->
		</header><!-- #header /-->
	
<?php 
$sidebar = '';
if( tie_get_option( 'sidebar_pos' ) == 'left' || ( tie_get_option( 'columns_num' ) == '2c' && tie_get_option( 'sidebar_pos' ) == 'nright' ) ) $sidebar = ' sidebar-left';
elseif( $sidebar_pos == 'right' || ( tie_get_option( 'columns_num' ) == '2c' && tie_get_option( 'sidebar_pos' ) == 'nleft' ) ) $sidebar = ' sidebar-right';
elseif( tie_get_option( 'sidebar_pos' ) == 'nleft' ) $sidebar = ' sidebar-narrow-left';
elseif( tie_get_option( 'sidebar_pos' ) == 'nright' ) $sidebar = ' sidebar-narrow-right';

if( is_singular() || ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) ){
	$current_ID = $post->ID;
	if( function_exists( 'is_woocommerce' ) && is_woocommerce() ) $current_ID = woocommerce_get_page_id('shop');
	
	$get_meta = get_post_custom( $current_ID );
	
	if( !empty($get_meta["tie_sidebar_pos"][0]) ){
		$sidebar_pos = $get_meta["tie_sidebar_pos"][0];

		if( $sidebar_pos == 'left' || ( tie_get_option( 'columns_num' ) == '2c' && $sidebar_pos == 'nright' )) $sidebar = ' sidebar-left';
		elseif( $sidebar_pos == 'full' ) $sidebar = ' full-width';
		elseif( $sidebar_pos == 'right' || ( tie_get_option( 'columns_num' ) == '2c' && $sidebar_pos == 'nleft' )) $sidebar = ' sidebar-right';
		elseif( $sidebar_pos == 'nright' ) $sidebar = ' sidebar-narrow-right';
		elseif( $sidebar_pos == 'nleft' ) $sidebar = ' sidebar-narrow-left';
	}
}
if(  function_exists('is_bbpress') && is_bbpress() && tie_get_option( 'bbpress_full' )) $sidebar = ' full-width';

?>
	<div id="main-content" class="container fade-in animated3<?php echo $sidebar ; ?>">