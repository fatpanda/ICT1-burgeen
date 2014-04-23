<?php
if( is_admin() ){					
	if( get_option('tie_active') < 2 ){
		$categories_obj = get_categories('hide_empty=0');
		foreach ($categories_obj as $pn_cat) {
			$category_id = $pn_cat->cat_ID;
			
			$cat_sidebar = tie_get_option( 'sidebar_cat_'.$category_id );
			$cat_slider  = tie_get_option( 'slider_cat_'.$category_id  );
			$cat_bg 	 = tie_get_option( 'cat'.$category_id.'_background' );
			$cat_full_bg = tie_get_option( 'cat'.$category_id.'_background_full' );
			$cat_color   = tie_get_option( 'cat_'.$category_id.'_color' );
			
			$new_cat = array();
			$new_cat['cat_sidebar'] =  $cat_sidebar;
			$new_cat['cat_slider']  = $cat_slider;
			$new_cat['cat_color'] = $cat_color;
			$new_cat['cat_background'] = $cat_bg;
			$new_cat['cat_background_full'] = $cat_full_bg;
			
			update_option( "tie_cat_".$category_id , $new_cat );
		}

		$theme_options = get_option( 'tie_options' );
		
		$theme_options['slider_caption'] 		= true;
		$theme_options['slider_caption_length'] = 100;
		$theme_options['box_meta_date'] 		= true;
		$theme_options['box_meta_comments']		= true;
		$theme_options['box_meta_views'] 		= true;
		$theme_options['arc_meta_date'] 		= true;
		$theme_options['arc_meta_comments'] 	= true;
		$theme_options['arc_meta_views'] 		= true;

		update_option( 'tie_options' , $theme_options );

		update_option( 'tie_active' , 2 );
		echo '<script>location.reload();</script>';
		die;
	}
}
?>