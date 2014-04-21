<!DOCTYPE html>
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="ie8"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>

	<title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
	
	<!-- Meta
	================================================== -->
	
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="description" content="<?php bloginfo('description'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS2 Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<!-- Favicons
	================================================== -->
	
	<link rel="shortcut icon" href="<?php global $data; echo $data['custom_favicon']; ?>">
	<link rel="apple-touch-icon" href="<?php get_template_directory_uri(); ?>assets/img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php get_template_directory_uri(); ?>assets/img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php get_template_directory_uri(); ?>assets/img/apple-touch-icon-114x114.png">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!--[if IE 8]>
    <style type="text/css">
        input[type="checkbox"], input[type="radio"] {
            display: inline;
        }
        input[type="checkbox"] + label, input[type="radio"] + label{
            display: inline;
            background: none;
            margin-bottom: 15px;
        }
        .zone {
            background-color: #727272;
            filter: alpha(Opacity=70);
        }
        .black {
            background-color: #727272;
            filter: alpha(Opacity=70);
        }
    </style>
    <![endif]-->

<?php wp_head(); ?>
    
</head>

<body <?php body_class(); ?> >

<div id="header" class="header">
<div id="home"></div>
        <div class="width titul">
            <div class="reg inline">
                <?php if(function_exists('login_block')) { login_block(); } ?>
            </div>

            <div class="social inline fright">
                <ul id="social">
                <li class="bleft inline">
                    <ul style="margin-left: 10px">
                    <li><a href="<?php echo $data['text_facebook_profile']; ?>" target="_blank" title="twitter"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_header_face.png" alt=""></a></li>
                    <li><a href="<?php echo $data['text_googleplus_profile']; ?>" target="_blank" title="googleplus"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_header_g.png" alt=""></a></li>
                    <li><a href="<?php echo $data['text_twitter_profile']; ?>" title="facebook" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_header_tw.png" alt=""></a></li>
                    <li><a href="<?php echo $data['text_linkedin_profile']; ?>" target="_blank" title="linkedin"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_header_in.png" alt=""></a></li>
                    <li><a href="<?php echo $data['text_pinterest_profile']; ?>" target="_self" title="mail"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_header_p.png" alt=""></a></li>
                    <li><a href="<?php echo $data['text_dribbble_profile']; ?>" target="_self" title="mail"><img src="<?php echo get_template_directory_uri(); ?>/img/social/icon_header_ball.png" alt=""></a></li>
                    </ul>
                </li>
                    
                    <li class="bleft socialz"><a href="http://www.burgeen.com">Burgeen.com</a></li>
                    
                </ul>
            </div>
        </div>

        <div class="clear"></div>
        <div class="header-wrapper">
            <div class="navigate">
                <div class="width">
                        <div class="logo inline">
                            <?php if ($data['text_logo']) { ?>
                                <h1 class="inline fleft"><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
                            <?php } elseif ($data['custom_logo']) { ?>
                                <div id="logo"><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo $data['custom_logo']; ?>" alt="Header Logo" /></a></div>
                            <?php } ?>
                        </div>
        
                         
                        <div id="header-navigation" class="navigation inline" role="navigation">
                             <?php
                             if ( has_nav_menu( 'Front' ) ) {
                              $header_menu_args = array('menu' => 'Header', 'theme_location' => 'Front', 'container' => false,'menu_class' => 'nav inline menuleft MenuBar sf-menu', 'menu_id' => 'navigation'
                              ); wp_nav_menu($header_menu_args);
                              }
                             ?>
                        </div>
                </div>
           </div>
            <div class="clear"></div>
            <div id="header_select">
              <?php  
                      dropdown_menu( array('dropdown_title' => '-- Main Menu --', 'indent_string' => '- ', 'indent_after' => '','container' => 'div', 'container_class' =>  
                     'responsive-menu-wrapper', 'theme_location'=>'Front') );
                      
				?>
            </div>
        </div>
   </div>