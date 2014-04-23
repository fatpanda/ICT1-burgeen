<?php

## Tie Widgets
function tie_widgets_init() {
	$before_widget =  '<div id="%1$s" class="widget %2$s">';
	$after_widget  =  '</div></div><!-- .widget /-->';
	$before_title  =  '<div class="widget-top"><h4>';
	$after_title   =  '</h4><div class="stripe-line"></div></div>
						<div class="widget-container">';
					
	register_sidebar( array(
		'name' =>  __( 'Primary Normal Widget Area', 'tie' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The Primary Normal widget area appears in all pages / archives', 'tie' ),
		'before_widget' => $before_widget , 'after_widget' => $after_widget , 'before_title' => $before_title , 'after_title' => $after_title ,
	) );
	
	if(tie_get_option( 'columns_num' ) != '2c'){
		register_sidebar( array(
			'name' =>  __( 'Primary Narrow Widget Area', 'tie' ),
			'id' => 'narrow-primary-widget-area',
			'description' => __( 'The Primary Narrow widget area appears in all pages / archives', 'tie' ),
			'before_widget' => $before_widget , 'after_widget' => $after_widget , 'before_title' => $before_title , 'after_title' => $after_title ,
		) );
	}
	
	register_sidebar( array(
		'name' =>  __( 'Homepage - First Normal Widget Area', 'tie' ),
		'id' => 'homepage-normal-widget-area1',
		'description' => __( 'The Primary Normal widget area appears in all pages / archives', 'tie' ),
		'before_widget' => $before_widget , 'after_widget' => $after_widget , 'before_title' => $before_title , 'after_title' => $after_title ,
	) );

	register_sidebar( array(
		'name' =>  __( 'Homepage - Second Normal Widget Area', 'tie' ),
		'id' => 'homepage-normal-widget-area2',
		'description' => __( 'The Primary Normal widget area appears in all pages / archives', 'tie' ),
		'before_widget' => $before_widget , 'after_widget' => $after_widget , 'before_title' => $before_title , 'after_title' => $after_title ,
	) );
	
	if(tie_get_option( 'columns_num' ) != '2c'){
		register_sidebar( array(
			'name' =>  __( 'Homepage - First Narrow Widget Area', 'tie' ),
			'id' => 'homepage-narrow-widget-area1',
			'description' => __( 'The Primary Narrow widget area appears in all pages / archives', 'tie' ),
			'before_widget' => $before_widget , 'after_widget' => $after_widget , 'before_title' => $before_title , 'after_title' => $after_title ,
		) );
		
		register_sidebar( array(
			'name' =>  __( 'Homepage - Second Narrow Widget Area', 'tie' ),
			'id' => 'homepage-narrow-widget-area2',
			'description' => __( 'The Primary Narrow widget area appears in all pages / archives', 'tie' ),
			'before_widget' => $before_widget , 'after_widget' => $after_widget , 'before_title' => $before_title , 'after_title' => $after_title ,
		) );
	}
	
	if (class_exists('Woocommerce')){
		register_sidebar( array(
			'name' =>  __( 'Shop - For WooCommerce Pages', 'tie' ),
			'id' => 'shop-widget-area',
			'description' => __( 'This widget area uses in the WooCommerce pages .', 'tie' ),
			'before_widget' => $before_widget , 'after_widget' => $after_widget , 'before_title' => $before_title , 'after_title' => $after_title ,
		) );
	}
		
	//Custom Sidebars
	$sidebars = tie_get_option( 'sidebars' ) ;
	if($sidebars){
		foreach ($sidebars as $sidebar) {
			register_sidebar( array(
				'name' => $sidebar,
				'id' => sanitize_title($sidebar),
				'before_widget' => $before_widget , 'after_widget' => $after_widget , 'before_title' => $before_title , 'after_title' => $after_title ,
			) );
		}
	}
	

	
## Footer Widgets ------------------------------------------------------------
	$footer_before_widget =  '<div id="%1$s" class="footer-widget %2$s">';
	$footer_after_widget  =  '</div></div><!-- .widget /-->';
	$footer_before_title  =  '<div class="footer-widget-top"><h4>';
	$footer_after_title   =  '</h4></div>
						<div class="footer-widget-container">';
						
	$footer_widgets = tie_get_option( 'footer_widgets' );
	if( $footer_widgets != 'disable' ){
	
		register_sidebar( array(
			'name' =>  __( 'First Footer Widget Area', 'tie' ),
			'id' => 'first-footer-widget-area',
			'description' => __( 'The first footer widget area', 'tie' ),
			'before_widget' => $footer_before_widget , 'after_widget' => $footer_after_widget , 'before_title' => $footer_before_title , 'after_title' => $footer_after_title ,
		) );

		if( $footer_widgets == 'footer-2c' || $footer_widgets == 'narrow-wide-2c' || $footer_widgets == 'wide-narrow-2c' || $footer_widgets == 'footer-3c' || $footer_widgets == 'wide-left-3c' || $footer_widgets == 'wide-right-3c' || $footer_widgets == 'footer-4c' ){
			register_sidebar( array(
				'name' =>  __( 'Second Footer Widget Area', 'tie' ),
				'id' => 'second-footer-widget-area',
				'description' => __( 'The Second footer widget area', 'tie' ),
				'before_widget' => $footer_before_widget , 'after_widget' => $footer_after_widget , 'before_title' => $footer_before_title , 'after_title' => $footer_after_title ,
			) );
		}
	
		if( $footer_widgets == 'footer-3c' || $footer_widgets == 'wide-left-3c' || $footer_widgets == 'wide-right-3c' || $footer_widgets == 'footer-4c' ){
			register_sidebar( array(
				'name' =>  __( 'Third Footer Widget Area', 'tie' ),
				'id' => 'third-footer-widget-area',
				'description' => __( 'The Third footer widget area', 'tie' ),
				'before_widget' => $footer_before_widget , 'after_widget' => $footer_after_widget , 'before_title' => $footer_before_title , 'after_title' => $footer_after_title ,
			) );
		}
		
		if( $footer_widgets == 'footer-4c' ){
			register_sidebar( array(
				'name' => __( 'Fourth Footer Widget Area', 'tie' ),
				'id' => 'fourth-footer-widget-area',
				'description' => __( 'The Fourth footer widget area', 'tie' ),
				'before_widget' => $footer_before_widget , 'after_widget' => $footer_after_widget , 'before_title' => $footer_before_title , 'after_title' => $footer_after_title ,
			) );
		}
	}
}
?>