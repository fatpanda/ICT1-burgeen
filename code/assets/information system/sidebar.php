<?php
if(tie_get_option( 'columns_num' ) != '2c'):
?>
<aside class="sidebar-narrow">
<?php
	wp_reset_query();

	if ( is_home() ){
	
		$sidebar_home = tie_get_option( 'sidebar_narrow_home' );
		if( $sidebar_home )
			dynamic_sidebar ( sanitize_title( $sidebar_home ) ); 
			
		else dynamic_sidebar( 'narrow-primary-widget-area' );
		
	}elseif ( function_exists('is_bbpress') && is_bbpress() ){
	
		if( !tie_get_option( 'bbpress_full' ) ){
			$sidebar_narrow_bbPress = tie_get_option( 'sidebar_narrow_bbPress' );
			if( $sidebar_narrow_bbPress )
				dynamic_sidebar ( sanitize_title( $sidebar_narrow_bbPress ) ); 
				
			else dynamic_sidebar( 'narrow-primary-widget-area' );
		}
		
	}elseif( is_page() || ( function_exists('bp_current_component') && bp_current_component() ) ){
		global $get_meta;
		$tie_sidebar_pos = $get_meta["tie_sidebar_pos"][0];

		if( $tie_sidebar_pos != 'full' ){
			$tie_sidebar_post = sanitize_title($get_meta["tie_sidebar_narrow_post"][0]);
			$sidebar_page = tie_get_option( 'sidebar_narrow_page' );
			if( $tie_sidebar_post )
				dynamic_sidebar($tie_sidebar_post);
				
			elseif( $sidebar_page )
				dynamic_sidebar ( sanitize_title( $sidebar_page ) ); 
			
			else dynamic_sidebar( 'narrow-primary-widget-area' );
		}

	}elseif ( is_single() ){
		global $get_meta;
		$tie_sidebar_pos = $get_meta["tie_sidebar_pos"][0];

		if( $tie_sidebar_pos != 'full' ){
			$tie_sidebar_post = sanitize_title($get_meta["tie_sidebar_narrow_post"][0]);
			$sidebar_post = tie_get_option( 'sidebar_narrow_post' );
			if( $tie_sidebar_post )
				dynamic_sidebar($tie_sidebar_post);
				
			elseif( $sidebar_post )
				dynamic_sidebar ( sanitize_title( $sidebar_post ) ); 
			
			else dynamic_sidebar( 'narrow-primary-widget-area' );
		}
		
	}elseif ( is_category() ){
		
		$category_id = get_query_var('cat') ;
		$cat_options = get_option( "tie_cat_$category_id");
		$cat_sidebar = $cat_options['cat_narrow_sidebar'] ;
		
		$sidebar_archive = tie_get_option( 'sidebar_narrow_archive' );

		if( $cat_sidebar )
			dynamic_sidebar ( sanitize_title( $cat_sidebar ) ); 
			
		elseif( $sidebar_archive )
			dynamic_sidebar ( sanitize_title( $sidebar_archive ) );
			
		else dynamic_sidebar( 'narrow-primary-widget-area' );
		
	}else{
		$sidebar_archive = tie_get_option( 'sidebar_narrow_archive' );
		if( $sidebar_archive ){
			dynamic_sidebar ( sanitize_title( $sidebar_archive ) );
		}
		else dynamic_sidebar( 'narrow-primary-widget-area' );
	}
?>
</aside>
<?php endif; ?>
</div> <!-- .content-wrap -->
<aside class="sidebar">
<?php
	wp_reset_query();
	if ( is_home() ){
	
		$sidebar_home = tie_get_option( 'sidebar_home' );
		if( $sidebar_home )
			dynamic_sidebar ( sanitize_title( $sidebar_home ) ); 
			
		else dynamic_sidebar( 'primary-widget-area' );	
		
	}elseif ( function_exists('is_bbpress') && is_bbpress() ){
	
		if( !tie_get_option( 'bbpress_full' ) ){
			$sidebar_bbpress = tie_get_option( 'sidebar_bbpress' );
			if( $sidebar_bbpress )
				dynamic_sidebar ( sanitize_title( $sidebar_bbpress ) ); 
				
			else dynamic_sidebar( 'primary-widget-area' );
		}
		
	}elseif( is_page() ){
		global $get_meta;
		$tie_sidebar_pos = $get_meta["tie_sidebar_pos"][0];

		if( $tie_sidebar_pos != 'full' ){
			$tie_sidebar_post = sanitize_title($get_meta["tie_sidebar_post"][0]);
			$sidebar_page = tie_get_option( 'sidebar_page' );
			if( $tie_sidebar_post )
				dynamic_sidebar($tie_sidebar_post);
				
			elseif( $sidebar_page )
				dynamic_sidebar ( sanitize_title( $sidebar_page ) ); 
			
			else dynamic_sidebar( 'primary-widget-area' );
		}

	}elseif ( is_single() ){
		global $get_meta;
		$tie_sidebar_pos = $get_meta["tie_sidebar_pos"][0];

		if( $tie_sidebar_pos != 'full' ){
			$tie_sidebar_post = sanitize_title($get_meta["tie_sidebar_post"][0]);
			$sidebar_post = tie_get_option( 'sidebar_post' );
			if( $tie_sidebar_post )
				dynamic_sidebar($tie_sidebar_post);
				
			elseif( $sidebar_post )
				dynamic_sidebar ( sanitize_title( $sidebar_post ) ); 
			
			else dynamic_sidebar( 'primary-widget-area' );
		}
		
	}elseif ( is_category() ){
	
		$category_id = get_query_var('cat') ;
		$cat_options = get_option( "tie_cat_$category_id");
		$cat_sidebar = $cat_options['cat_sidebar'] ;
		
		$sidebar_archive = tie_get_option( 'sidebar_archive' );

		if( $cat_sidebar )
			dynamic_sidebar ( sanitize_title( $cat_sidebar ) ); 
			
		elseif( $sidebar_archive )
			dynamic_sidebar ( sanitize_title( $sidebar_archive ) );
			
		else dynamic_sidebar( 'primary-widget-area' );
		
	}else{
		$sidebar_archive = tie_get_option( 'sidebar_archive' );
		if( $sidebar_archive ){
			dynamic_sidebar ( sanitize_title( $sidebar_archive ) );
		}
		else dynamic_sidebar( 'primary-widget-area' );
	}
?>
</aside>
<div class="clear"></div>