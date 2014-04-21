<?php

add_filter('widget_text', 'do_shortcode');
add_filter('get_the_excerpt', 'do_shortcode');

/*-----------------------------------------------------------------------------------*/
/*	Blockquotes
/*-----------------------------------------------------------------------------------*/

function blockquotes($atts, $content = null) {
    extract(shortcode_atts(array(
        'cite' => ''
    ), $atts));
    $blockquotes = '<blockquote';
    $blockquotes .= '><p>' . $content . '</p>';
    if ($cite) {
        $blockquotes .= '<cite>' . $cite . '</cite>';
    }
    $blockquotes .= '</blockquote>';
    return $blockquotes;
}

add_shortcode('blockquote', 'blockquotes');

/*-----------------------------------------------------------------------------------*/
/*	Accordion
/*-----------------------------------------------------------------------------------*/

function accordion_shortcode($atts, $content = null ) {
   return '<div id="accordion-container">' . do_shortcode($content) . '</div>';
}

add_shortcode( 'accordion', 'accordion_shortcode' );

function accordion_section_shortcode( $atts, $content = null  ) {
	
	extract( shortcode_atts( array(
      'title' => 'Title',
	), $atts ) );
	  
   return '<h2 class="accordion-header">'. $title .'</a></h2><div class="accordion-content">' . do_shortcode($content) . '</div>';
}

add_shortcode( 'accordion_section', 'accordion_section_shortcode' );

/*-----------------------------------------------------------------------------------*/
/*	Tabs
/*-----------------------------------------------------------------------------------*/

add_shortcode( 'tabgroup', 'st_tabgroup' );

function st_tabgroup( $atts, $content ){
	
$GLOBALS['tab_count'] = 0;
do_shortcode( $content );

if( is_array( $GLOBALS['tabs'] ) ){
	
foreach( $GLOBALS['tabs'] as $tab ){
$tabs[] = '<li><a href="#'.$tab['id'].'">'.$tab['title'].'</a></li>';
$panes[] = '<li id="'.$tab['id'].'Tab">'.$tab['content'].'</li>';
}
$return = "\n".'<!-- the tabs --><ul class="tabs">'.implode( "\n", $tabs ).'</ul>'."\n".'<!-- tab "panes" --><ul class="tabs-content">'.implode( "\n", $panes ).'</ul>'."\n";
}
return $return;

}

add_shortcode( 'tab', 'st_tab' );
function st_tab( $atts, $content ){
extract(shortcode_atts(array(
	'title' => '%d',
	'id' => '%d'
), $atts));

$x = $GLOBALS['tab_count'];
$GLOBALS['tabs'][$x] = array(
	'title' => sprintf( $title, $GLOBALS['tab_count'] ),
	'content' =>  do_shortcode($content),
	'id' =>  $id );

$GLOBALS['tab_count']++;
}

/*-----------------------------------------------------------------------------------*/
/*	Toggle
/*-----------------------------------------------------------------------------------*/

function toggle( $atts, $content = null ) {
	extract(shortcode_atts(array(
		 'title' => '',
		 'style' => 'list'
    ), $atts));
	$toggle = '<div class="'.$style.'"><p class="trigger"><a href="#">' .$title. '</a></p><div class="toggle_container"><div class="block">'.$content.'</div></div></div>';
	return $toggle;
}
add_shortcode('toggle', 'toggle');

/*-----------------------------------------------------------------------------------*/
/*	YouTube Video
/*-----------------------------------------------------------------------------------*/

function youtube_video($atts, $content = null)
{
    extract(shortcode_atts(array(
        'id' => ''
    ), $atts));
    $return = $content;
    if ($content)
        $return .= "<br /><br />";
    $youtube_video = '<div class="video-frame"><iframe src="http://www.youtube.com/embed/' . $id . '" frameborder="0" allowfullscreen></iframe></div>';
    return $youtube_video;
}
add_shortcode('youtube', 'youtube_video');

/*-----------------------------------------------------------------------------------*/
/*	Vimeo Video
/*-----------------------------------------------------------------------------------*/

function vimeo_video($atts, $content = null)
{
    extract(shortcode_atts(array(
        'id' => ''
    ), $atts));
    $return = $content;
    if ($content)
        $return .= "<br /><br />";
    $vimeo_video = '<div class="video-frame"><iframe src="http://player.vimeo.com/video/' . $id . '" frameborder="0" allowfullscreen></iframe></div>';
    return $vimeo_video;
}
add_shortcode('vimeo', 'vimeo_video');

/*-----------------------------------------------------------------------------------*/
/*	Buttons
/*-----------------------------------------------------------------------------------*/

function button( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'link' => '',
		'size' => 'medium',
		'color' => '',
		'target' => '_self',
		'align' => 'right'
	), $atts));
	$button = '<div class="custom-button '.$size.' '.$align.'"><a target="'.$target.'" class="button '.$color.'" href="'.$link.'">'.$content.'</a></div>';
	return $button;
}
add_shortcode('button', 'button');

/*-----------------------------------------------------------------------------------*/
/*	Alerts
/*-----------------------------------------------------------------------------------*/

function alert_shortcode( $atts, $content = null )
{
	extract( shortcode_atts( array(
      'color' => '',
      ), $atts ) );

      return '<div class="alert-' . $color . '">' . $content . '</div>';

}
add_shortcode('alert', 'alert_shortcode');

/*-----------------------------------------------------------------------------------*/
/*	Columns
/*-----------------------------------------------------------------------------------*/

function one_half_first( $atts, $content = null ) {
   return '<div class="one_half first"><p>' . do_shortcode($content) . '</p></div>';
}
add_shortcode('one_half_first', 'one_half_first'); 

function one_half_last( $atts, $content = null ) {
   return '<div class="one_half last"><p>' . do_shortcode($content) . '</p></div><div class="clear"></div>';
}
add_shortcode('one_half_last', 'one_half_last');

function one_third_first( $atts, $content = null ) {
   return '<div class="one_third first"><p>' . do_shortcode($content) . '</p></div>';
}
add_shortcode('one_third_first', 'one_third_first');

function one_third( $atts, $content = null ) {
   return '<div class="one_third"><p>' . do_shortcode($content) . '</p></div>';
}
add_shortcode('one_third', 'one_third');

function one_third_last( $atts, $content = null ) {
   return '<div class="one_third last"><p>' . do_shortcode($content) . '</p></div><div class="clear"></div>';
}
add_shortcode('one_third_last', 'one_third_last');

function one_fourth_first( $atts, $content = null ) {
   return '<div class="one_fourth first"><p>' . do_shortcode($content) . '</p></div>';
}
add_shortcode('one_fourth_first', 'one_fourth_first');

function one_fourth( $atts, $content = null ) {
   return '<div class="one_fourth"><p>' . do_shortcode($content) . '</p></div>';
}
add_shortcode('one_fourth', 'one_fourth');

function one_fourth_last( $atts, $content = null ) {
   return '<div class="one_fourth last"><p>' . do_shortcode($content) . '</p></div><div class="clear"></div>';
}
add_shortcode('one_fourth_last', 'one_fourth_last');

function one_fifth_first( $atts, $content = null ) {
   return '<div class="one_fifth first"><p>' . do_shortcode($content) . '</p></div>';
}
add_shortcode('one_fifth_first', 'one_fifth_first');

function one_fifth( $atts, $content = null ) {
   return '<div class="one_fifth"><p>' . do_shortcode($content) . '</p></div>';
}
add_shortcode('one_fifth', 'one_fifth');

function one_fifth_last( $atts, $content = null ) {
   return '<div class="one_fifth last"><p>' . do_shortcode($content) . '</p></div><div class="clear"></div>';
}
add_shortcode('one_fifth_last', 'one_fifth_last');

function one_sixth_first( $atts, $content = null ) {
   return '<div class="one_sixth first"><p>' . do_shortcode($content) . '</p></div>';
}
add_shortcode('one_sixth_first', 'one_sixth_first');

function one_sixth( $atts, $content = null ) {
   return '<div class="one_sixth"><p>' . do_shortcode($content) . '</p></div>';
}
add_shortcode('one_sixth', 'one_sixth');

function one_sixth_last( $atts, $content = null ) {
   return '<div class="one_sixth last"><p>' . do_shortcode($content) . '</p></div><div class="clear"></div>';
}
add_shortcode('one_sixth_last', 'one_sixth_last');

/*-----------------------------------------------------------------------------------*/
/*	Pricing Tables
/*-----------------------------------------------------------------------------------*/

function pricing_table_shortcode( $atts, $content = null  ) {
   return '<ul class="pricing-table clearfix">' . do_shortcode($content) . '</ul><div class="clear"></div>';
}

add_shortcode( 'pricing_table', 'pricing_table_shortcode' );

function pricing_shortcode( $atts, $content = null  ) {
	
	extract( shortcode_atts( array(
		'column' => '3',
		'title' => 'Title',
		'price' => '',
		'per' => '',
		'button_url' => '',
		'button_text' => 'Sign Up'
	), $atts ) );
	
	if($column == '3') {
		$column_size = 'third';
	}
	if($column =='4') {
		$column_size = 'fourth';
	}
	if($column =='5') {
		$column_size = 'fifth';
	}
 
	$pricing_content ='';
	$pricing_content .= '<li class="pricing pricing-'. $column_size .'">';
	$pricing_content .= '<div class="pricing-header">';
	$pricing_content .= '<div class="plan-title"><i class="icon-star"></i><br />'. $title. '</div>';
	$pricing_content .= '<div class="plan-price">'. $price .'';
	if($per !='') {
		$pricing_content .='<span>'. $per .'</span></div>';
	}
	$pricing_content .= '</div>';
	$pricing_content .= '<div class="pricing-content">';
	$pricing_content .= ''. $content. '';
	$pricing_content .= '<a class="sign-up-btn" href="'. $button_url .'">'. $button_text .'</a>';
	$pricing_content .= '</div>';
	$pricing_content .= '</li>';
	  
   return $pricing_content;
}

add_shortcode( 'pricing', 'pricing_shortcode' );

/*-----------------------------------------------------------------------------------*/
/*	Clear Floats
/*-----------------------------------------------------------------------------------*/

function float_clear( $atts, $content = null ) {
	return '<div class="clear"></div>';
}
add_shortcode('clear', 'float_clear');

/*-----------------------------------------------------------------------------------*/
/*	Dropcaps
/*-----------------------------------------------------------------------------------*/

function dropcap( $atts, $content = null ) {
	return '<span class="dropcap">' . do_shortcode($content) . '</span><p>';
}
add_shortcode('dropcap', 'dropcap');

?>