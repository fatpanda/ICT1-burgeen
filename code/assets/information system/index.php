<?php get_header(); ?>

<?php
	if( tie_get_option('on_home') != 'boxes' ): ?>
<div class="content-wrap">
<div class="content">
<?php
	get_template_part( 'includes/slider' ); // Get Slider template 
	get_template_part( 'loop', 'index' );
	if ($wp_query->max_num_pages > 1) tie_pagenavi();
?>
</div><!-- .content /-->
<?php get_sidebar(); ?>
<?php
	else:
?>
<div class="content-wrap">
<div class="content">
<?php
	get_template_part( 'includes/slider' ); // Get Slider template 
	$cats = get_option( 'tie_home_cats1' ) ;
	if($cats)
		foreach ($cats as $cat)	tie_get_home_cats($cat);
?>
</div><!-- .content /-->

<?php
	get_sidebar('home1'); 
	$cats2 = get_option( 'tie_home_cats2' ) ;
	if($cats2)
		foreach ($cats2 as $cat2)	tie_get_wide_home_cats($cat2);
	
	$cats3 = get_option( 'tie_home_cats3' ) ;
	if($cats3): ?>
<div class="content-wrap">
<div class="content">
<?php
	foreach ($cats3 as $cat3)	tie_get_home_cats($cat3);
?>
</div><!-- .content /-->
<?php	
	get_sidebar('home2'); 
	endif; // cat3 if

	$cats4 = get_option( 'tie_home_cats4' ) ;
	if($cats4)
		foreach ($cats4 as $cat4)	tie_get_wide_home_cats($cat4);
		
	endif;
?>
	

<?php get_footer(); ?>