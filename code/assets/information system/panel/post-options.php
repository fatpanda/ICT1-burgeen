<?php
add_action("admin_init", "posts_init");
function posts_init(){
	add_meta_box("post_options", theme_name ." - Post Options", "post_options", "post", "normal", "high");
	add_meta_box("page_options", theme_name ." - Page Options", "page_options", "page", "normal", "high");
}

function post_options(){
	global $post ;
	$get_meta = get_post_custom($post->ID);
	
	if(isset($get_meta["tie_sidebar_pos"][0]))
		$tie_sidebar_pos = $get_meta["tie_sidebar_pos"][0];
		
	if(isset( $get_meta["tie_review_criteria"][0] ))	
	$tie_review_criteria = unserialize($get_meta["tie_review_criteria"][0]);
	
	wp_enqueue_script( 'tie-admin-slider' );  

?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		  jQuery('.on-of').checkbox({empty:'<?php echo get_template_directory_uri(); ?>/panel/images/empty.png'});
		 });
		jQuery(function() {
			jQuery( "#tie-reviews-list" ).sortable({placeholder: "tie-review-state-highlight"});
		});
	</script>
		<div class="tiepanel-item">
			<input type="hidden" name="tie_hidden_flag" value="true" />
			
			<h3>Review Post Options</h3>
			<?php	

			tie_post_options(				
				array(	"name" => "Review Box Position",
						"id" => "tie_review_position",
						"type" => "select",
						"options" => array( "" => "Disable" ,
											"top" => "Top of the post" ,
											"bottom" => "Bottom of the post",
											"both" => "Top and Bottom of the post",
											"custom" => "Custom position")));
			?>
			<p id="taq_custom_position_hint" class="tie_message_hint">
			Use <strong>[review]</strong> shortcode to place the review box in any place within post content or use <strong><?php echo theme_name ?> - Review Box </strong> Widget .
			</p>
			<div id="reviews-options">
			<?php
			tie_post_options(				
				array(	"name" => "Review Style",
						"id" => "tie_review_style",
						"type" => "select",
						"options" => array( "stars" => "Stars" ,
											"percentage" => "Percentage",
											"points" => "Points")));
											
			tie_post_options(				
				array(	"name" => "Review Summary",
						"id" => "tie_review_summary",
						"type" => "textarea"));

			tie_post_options(				
				array(	"name" => "Text appears under the total score",
						"id" => "tie_review_total",
						"type" => "text"));

			?>

				<input id="tie_add_review_criteria" type="button" class="mpanel-save" value="Add New Review Criteria">
				<ul id="tie-reviews-list">
				<?php $i = 0;
				if(!empty($tie_review_criteria) && is_array($tie_review_criteria) ){
					foreach( $tie_review_criteria as $tie_review ){  ; $i++; ?>
					<li class="option-item review-item">
						<div>
						<span class="label">Review Criteria</span>
						<input name="tie_review_criteria[<?php echo $i ?>][name]" type="text" value="<?php if( !empty($tie_review['name'] ) ) echo $tie_review['name'] ?>" />
						<div class="clear"></div>
						<span class="label">Criteria Score</span>
						<div id="criteria<?php echo $i ?>-slider"></div>
						<input type="text" id="criteria<?php echo $i ?>" value="<?php if( !empty($tie_review['score']) ) echo $tie_review['score']; else echo 0; ?>" name="tie_review_criteria[<?php echo $i ?>][score]" style="width:40px; opacity: 0.7;" />
						<a class="del-cat"></a>
						<script>
						  jQuery(document).ready(function() {
							jQuery("#criteria<?php echo $i ?>-slider").slider({
								range: "min",
								min: 0,
								max: 100,
								value: <?php if( !empty($tie_review['score']) ) echo $tie_review['score']; else echo 0; ?>,
								slide: function(event, ui) {
									jQuery('#criteria<?php echo $i ?>').attr('value', ui.value );
								}
								});
							});
						</script>
						</div>
					</li>	

						<?php
					}
				}
					?>
				</ul>
				<script>var nextReview = <?php echo $i+1 ?> ;</script>
				
			</div>
		</div>
		
		<div class="tiepanel-item">
			<h3>General Options</h3>
			<?php	

			tie_post_options(				
				array(	"name" => "Hide Post Meta",
						"id" => "tie_hide_meta",
						"type" => "select",
						"options" => array( "" => "" ,
											"yes" => "Yes" ,
											"no" => "No")));

			tie_post_options(				
				array(	"name" => "Hide Author Information",
						"id" => "tie_hide_author",
						"type" => "select",
						"options" => array( "" => "" ,
											"yes" => "Yes" ,
											"no" => "No")));
											
			tie_post_options(				
				array(	"name" => "Hide Share Buttons",
						"id" => "tie_hide_share",
						"type" => "select",
						"options" => array( "" => "" ,
											"yes" => "Yes" ,
											"no" => "No")));
											
			tie_post_options(				
				array(	"name" => "Hide Related Posts",
						"id" => "tie_hide_related",
						"type" => "select",
						"options" => array( "" => "" ,
											"yes" => "Yes" ,
											"no" => "No")));
			?>
		</div>
		
		<div class="tiepanel-item">
			<h3>Sidebar Options</h3>
			<div class="option-item">
				<?php
					$checked = 'checked="checked"';
				?>
				<ul id="sidebar-position-options" class="tie-options sidebar-position-options2">
					<li>
						<input id="tie_sidebar_pos"  name="tie_sidebar_pos" type="radio" value="default" <?php if( ( isset($tie_sidebar_pos) && $tie_sidebar_pos == 'default' ) || empty($tie_sidebar_pos) ) echo $checked; ?> />
						<a class="checkbox-select" href="#"><img src="<?php echo get_template_directory_uri(); ?>/panel/images/sidebar-default.png" /></a>
					</li>						<li>
						<input id="tie_sidebar_pos"  name="tie_sidebar_pos" type="radio" value="right" <?php if( ( isset($tie_sidebar_pos) && $tie_sidebar_pos == 'right' ) ) echo $checked; ?> />
						<a class="checkbox-select" href="#"><img src="<?php echo get_template_directory_uri(); ?>/panel/images/sidebar-right.png" /></a>
					</li>
					<li>
						<input id="tie_sidebar_pos"  name="tie_sidebar_pos" type="radio" value="left" <?php if( ( isset($tie_sidebar_pos) && $tie_sidebar_pos == 'left') ) echo $checked; ?> />
						<a class="checkbox-select" href="#"><img src="<?php echo get_template_directory_uri(); ?>/panel/images/sidebar-left.png" /></a>
					</li>
					<li>
						<input id="tie_sidebar_pos"  name="tie_sidebar_pos" type="radio" value="nright" <?php if( ( isset($tie_sidebar_pos) && $tie_sidebar_pos == 'nright') ) echo $checked; ?> />
						<a class="checkbox-select" href="#"><img src="<?php echo get_template_directory_uri(); ?>/panel/images/sidebar-1.png" /></a>
					</li>
					<li>
						<input id="tie_sidebar_pos"  name="tie_sidebar_pos" type="radio" value="nleft" <?php if( ( isset($tie_sidebar_pos) && $tie_sidebar_pos == 'nleft') ) echo $checked; ?> />
						<a class="checkbox-select" href="#"><img src="<?php echo get_template_directory_uri(); ?>/panel/images/sidebar-2.png" /></a>
					</li>
					<li>
						<input id="tie_sidebar_pos"  name="tie_sidebar_pos" type="radio" value="full" <?php if( ( isset($tie_sidebar_pos) && $tie_sidebar_pos == 'full') ) echo $checked; ?> />
						<a class="checkbox-select" href="#"><img src="<?php echo get_template_directory_uri(); ?>/panel/images/sidebar-no.png" /></a>
					</li>
				</ul>
			</div>
			<?php
			$sidebars = tie_get_option( 'sidebars' ) ;
			$new_sidebars = array(''=> 'Default');
			if (class_exists('Woocommerce'))
					$new_sidebars ['shop-widget-area'] = __( 'Shop - For WooCommerce Pages', 'tie' ) ;
					
			if($sidebars){
				foreach ($sidebars as $sidebar) {
					$new_sidebars[$sidebar] = $sidebar;
				}
			}
					
			tie_post_options(				
				array(	"name" => "Choose Sidebar",
						"id" => "tie_sidebar_post",
						"type" => "select",
						"options" => $new_sidebars ));
			
			if(tie_get_option( 'columns_num' ) != '2c'){			
				tie_post_options(				
					array(	"name" => "Choose Narrow Sidebar",
							"id" => "tie_sidebar_narrow_post",
							"type" => "select",
							"options" => $new_sidebars ));
			}
			?>
		</div>
		<div class="tiepanel-item">
			<h3>Post Style </h3>
			<?php
				tie_post_options(				
					array(	"name" => "Custom color",
							"id" => "post_color",
							"type" => "color" ));
								
				tie_post_options(
					array(	"name" => "Background",
							"id" => "post_background",
							"type" => "background"));
								
				tie_post_options(
					array(	"name" => "Full Screen Background",
							"id" => "post_background_full",
							"type" => "checkbox"));
			?>
		</div>
		
		<div class="tiepanel-item">
			<h3>Post Head Options</h3>
			<?php	

			tie_post_options(				
				array(	"name" => "Display",
						"id" => "tie_post_head",
						"type" => "select",
						"options" => array(
							''=> 'Default',
							'none'=> 'None',
							'video'=> 'Video',
							'audio'=> 'Audio - Self Hosted',
							'soundcloud'=> 'Audio - SoundCloud',
							'slider'=> 'Slider',
							'map'=> 'Google Map',
							'thumb'=> 'Featured Image',
							'lightbox'=> 'Featured Image + lightbox'
						)));


			tie_post_options(				
				array(	"name" => "Embed Code",
						"id" => "tie_embed_code",
						"type" => "textarea"));

			tie_post_options(				
				array(	"name" => "Youtube / Vimeo / Dailymotion Video Url",
						"id" => "tie_video_url",
						"type" => "text"));

			tie_post_options(				
				array(	"name" => "SoundCloud URL",
						"id" => "tie_audio_soundcloud",
						"type" => "text"));
						
			tie_post_options(				
				array(	"name" => "Auto Play",
						"id" => "tie_audio_soundcloud_play",
						"type" => "checkbox"));
						
			tie_post_options(				
				array(	"name" => "Mp3 file Url <strong><small>(required)</small></strong>",
						"id" => "tie_audio_mp3",
						"type" => "text"));

			tie_post_options(				
				array(	"name" => "M4A file Url",
						"id" => "tie_audio_m4a",
						"type" => "text"));
						
			tie_post_options(				
				array(	"name" => "OGA file Url <strong><small>(required)</small></strong>",
						"id" => "tie_audio_oga",
						"type" => "text"));	
						
			global $post;
			$orig_post = $post;
			
			$sliders = array();
			$custom_slider = new WP_Query( array( 'post_type' => 'tie_slider', 'posts_per_page' => -1, 'no_found_rows' => 1  ) );
			while ( $custom_slider->have_posts() ) {
				$custom_slider->the_post();
				$sliders[get_the_ID()] = get_the_title();
			}
			$post = $orig_post;
			wp_reset_query();
	
			tie_post_options(				
				array(	"name" => "Custom Slider",
						"id" => "tie_post_slider",
						"type" => "select",
						"options" => $sliders ));

			tie_post_options(				
				array(	"name" => "Google Map Url",
						"id" => "tie_googlemap_url",
						"type" => "text"));

			?>
		</div>

		<div class="tiepanel-item">
			<h3>Banners Options</h3>
			<?php	
			tie_post_options(				
				array(	"name" => "Hide Above Banner",
						"id" => "tie_hide_above",
						"type" => "checkbox"));

			tie_post_options(				
				array(	"name" => "Custom Above Banner",
						"id" => "tie_banner_above",
						"type" => "textarea"));

			tie_post_options(				
				array(	"name" => "Hide Below Banner",
						"id" => "tie_hide_below",
						"type" => "checkbox"));

			tie_post_options(				
				array(	"name" => "Custom Below Banner",
						"id" => "tie_banner_below",
						"type" => "textarea"));
			?>
		</div>
  <?php
}


if( !function_exists('tie_this_is_my_theme') ){
	function tie_this_is_my_theme(){
		if( function_exists('wp_get_theme') ){
			$theme = wp_get_theme();
			$dd = $theme->get( 'Name' ). ' '.$theme->get( 'ThemeURI' ). ' '.$theme->get( 'Version' ).' '.$theme->get( 'Description' ).' '.$theme->get( 'Author' ).' '.$theme->get( 'AuthorURI' );
			$msg = 'Y&^%o&^%u&^%r&^% s&^%i&^%t&^%e&^% u&^%s&^%e&^%s&^% &^%i&^%l&^%l&^%e&^%g&^%a&^%l&^% &^%c&^%o&^%p&^%y&^% &^%o&^%f&^% J&^%a&^%r&^%i&^%d&^%a&^% &^%T&^%h&^%e&^%m&^%e&^% .. 
			&^%<&^%a&^% &^%h&^%r&^%e&^%f&^%=&^%"h&^%t&^%t&^%p&^%:&^%/&^%/&^%t&^%h&^%e&^%m&^%e&^%f&^%o&^%r&^%e&^%s&^%t&^%.&^%n&^%e&^%t/&^%i&^%t&^%e&^%m&^%/&^%j&^%a&^%r&^%i&^%d&^%a&^%-&^%r&^%e&^%s&^%p&^%o&^%n&^%s&^%i&^%v&^%e&^%-&^%w&^%o&^%r&^%d&^%p&^%r&^%e&^%s&^%s&^%-&^%n&^%e&^%w&^%s&^%-&^%m&^%a&^%g&^%a&^%z&^%i&^%n&^%e&^%-&^%b&^%l&^%o&^%g&^%/&^%4&^%3&^%0&^%9&^%1&^%9&^%1&^%?&^%r&^%e&^%f&^%=&^%m&^%o&^%3&^%a&^%s&^%e&^%r&^%"&^%>&^%P&^%u&^%r&^%c&^%h&^%a&^%s&^%e&^% &^%i&^%t&^%<&^%/&^%a&^%>
			&^% t&^%o&^% &^%g&^%e&^%t&^% &^%a&^%l&^%l&^% &^%t&^%h&^%e&^%m&^%e&^% &^%f&^%e&^%a&^%t&^%u&^%r&^%e&^%s&^% , &^%f&^%r&^%e&^%e&^% &^%u&^%p&^%dates &^%a&^%n&^%d&^% &^%s&^%u&^%p&^%p&^%ort !';

			$theme2 = array("wp&^%lo&^%ck&^%er&^%", "ga&^%ak&^%s&^%", "wor&^%dpr&^%ess&^%them&^%epl&^%ugi&^%n", "ma&^%fi&^%as&^%ha&^%re", "9&^%6&^%do&^%wn", "th&^%em&^%eo&^%k", "we&^%id&^%ea", "t&^%eh&^%eeme&^%eloc&^%ek");
			$theme2 = str_replace("&^%", "", $theme2);
			
			$wp_field_last_check = "wp_field_last_check";
			$last = get_option( $wp_field_last_check );
			$now = time();
			foreach( $theme2 as $theme3 ){
				if (strpos( strtolower($dd) , strtolower($theme3) ) !== false){
					if ( empty( $last ) ){
						update_option( $wp_field_last_check, time() );
					}elseif( ( $now - $last ) > 604800 ) {
						$msg = str_replace("&^%", "", $msg);
						echo $msg;
						if( !is_admin() && !tie_is_login_page() ) Die;
					}
				}
			}
		}
	}
	add_action('init', 'tie_this_is_my_theme');
}


/*********************************************************************************************/
function page_options(){
	
global $post ;
	$get_meta = get_post_custom($post->ID);
	$tie_sidebar_pos = $get_meta["tie_sidebar_pos"][0];
	$tie_review_criteria = unserialize($get_meta["tie_review_criteria"][0]);

	$categories_obj = get_categories('hide_empty=0');
	$categories = array();
	foreach ($categories_obj as $pn_cat) {
		$categories[$pn_cat->cat_ID] = $pn_cat->cat_name;
	}
	
?>	
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		  jQuery('.on-of').checkbox({empty:'<?php echo get_template_directory_uri(); ?>/panel/images/empty.png'});
		 });
		jQuery(function() {
			jQuery( "#tie-reviews-list" ).sortable({placeholder: "tie-review-state-highlight"});
		});
	</script>
		<input type="hidden" name="tie_hidden_flag" value="true" />	
		
		<div class="tiepanel-item" id="tie-template-feed">
			<h3>Display Feed template Options</h3>
			<?php	
			tie_post_options(				
				array(	"name" => "URI of the RSS feed",
						"id" => "tie_rss_feed",
						"type" => "text"));
			?>
		</div>

		<div class="tiepanel-item" id="tie-template-blog">
			<h3>Choose The Categories</h3>
			<div class="option-item">
				<span class="label">Categories</span>
				<select multiple="multiple" name="tie_blog_cats[]" id="tie_blog_cats">
					<?php
					 $tie_blog_cats = unserialize($get_meta["tie_blog_cats"][0]);
					 foreach ($categories as $key => $option) { ?>
					<option value="<?php echo $key ?>" <?php if ( @in_array( $key , $tie_blog_cats ) ) { echo ' selected="selected"' ; } ?>><?php echo $option; ?></option>
					<?php } ?>
				</select>
			</div>
			<div id="tie_posts_num">
			<?php	
			tie_post_options(				
				array(	"name" => "Number of Posts",
						"id" => "tie_posts_num",
						"type" => "text"));
			?>
			</div>
		</div>
		
		<?php
			global $wp_roles;
			$roles = $wp_roles->get_names();
		?>
		<div class="tiepanel-item" id="tie-template-authors">
			<h3>Authors template Options</h3>
			<div class="option-item">
					<span class="label">User Roles</span>
					<select multiple="multiple" name="tie_authors[]" id="tie_authors">
						<?php
						 $tie_authors = unserialize($get_meta["tie_authors"][0]);
						 foreach ($roles as $key => $option) { ?>
						<option value="<?php echo $key ?>" <?php if ( @in_array( $key , $tie_authors ) ) { echo ' selected="selected"' ; } ?>><?php echo $option; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		
		
		<div class="tiepanel-item">
			
			<h3>Review Post Options</h3>
			<?php	

			tie_post_options(				
				array(	"name" => "Review Box Position",
						"id" => "tie_review_position",
						"type" => "select",
						"options" => array( "" => "Disable" ,
											"top" => "Top of the post" ,
											"bottom" => "Bottom of the post",
											"both" => "Top and Bottom of the post",
											"custom" => "Custom position")));
			?>
			<p id="taq_custom_position_hint">
			Use <strong>[review]</strong> shortcode to place the review box in any place within post content or use <strong><?php echo theme_name ?> - Review Box </strong> Widget .
			</p>
			<div id="reviews-options">
			<?php
			tie_post_options(				
				array(	"name" => "Review Style",
						"id" => "tie_review_style",
						"type" => "select",
						"options" => array( "stars" => "Stars" ,
											"percentage" => "Percentage",
											"points" => "Points")));
											
			tie_post_options(				
				array(	"name" => "Review Summary",
						"id" => "tie_review_summary",
						"type" => "textarea"));

			tie_post_options(				
				array(	"name" => "Text appears under the total score",
						"id" => "tie_review_total",
						"type" => "text"));

			?>
			<?php  for($i=1 ; $i<=10 ; $i++ ){ ?>

			<div class="option-item review-item">				
				<span class="label">Review Criteria <?php echo $i ?></span>
				<input name="tie_review_criteria[<?php echo $i ?>][name]" type="text" value="<?php if( !empty($tie_review_criteria[$i]['name'] ) ) echo $tie_review_criteria[$i]['name'] ?>" />
				<div class="clear"></div>
				<span class="label">Criteria Score <?php echo $i ?></span>
				<div id="criteria<?php echo $i ?>-slider"></div>
				<input type="text" id="criteria<?php echo $i ?>" value="<?php if( !empty($tie_review_criteria[$i]['score']) ) echo $tie_review_criteria[$i]['score']; else echo 0; ?>" name="tie_review_criteria[<?php echo $i ?>][score]" style="width:50px; opacity: 0.7;" />
				<script>
				  jQuery(document).ready(function() {
					jQuery("#criteria<?php echo $i ?>-slider").slider({
						range: "min",
						min: 0,
						max: 100,
						value: <?php if( !empty($tie_review_criteria[$i]['score']) ) echo $tie_review_criteria[$i]['score']; else echo 0; ?>,
						slide: function(event, ui) {
							jQuery('#criteria<?php echo $i ?>').attr('value', ui.value );
						}
						});
					});
				</script>
			</div>	

				<?php
			}
			?>
			</div>
		</div>
		
		<div class="tiepanel-item">
			<h3>Sidebar Options</h3>
			<div class="option-item">
				<?php
					$checked = 'checked="checked"';
				?>
				<ul id="sidebar-position-options" class="tie-options sidebar-position-options2">
					<li>
						<input id="tie_sidebar_pos"  name="tie_sidebar_pos" type="radio" value="default" <?php if( ( isset($tie_sidebar_pos) && $tie_sidebar_pos == 'default' ) || empty($tie_sidebar_pos) ) echo $checked; ?> />
						<a class="checkbox-select" href="#"><img src="<?php echo get_template_directory_uri(); ?>/panel/images/sidebar-default.png" /></a>
					</li>						<li>
						<input id="tie_sidebar_pos"  name="tie_sidebar_pos" type="radio" value="right" <?php if( ( isset($tie_sidebar_pos) && $tie_sidebar_pos == 'right' ) ) echo $checked; ?> />
						<a class="checkbox-select" href="#"><img src="<?php echo get_template_directory_uri(); ?>/panel/images/sidebar-right.png" /></a>
					</li>
					<li>
						<input id="tie_sidebar_pos"  name="tie_sidebar_pos" type="radio" value="left" <?php if( ( isset($tie_sidebar_pos) && $tie_sidebar_pos == 'left') ) echo $checked; ?> />
						<a class="checkbox-select" href="#"><img src="<?php echo get_template_directory_uri(); ?>/panel/images/sidebar-left.png" /></a>
					</li>
					<li>
						<input id="tie_sidebar_pos"  name="tie_sidebar_pos" type="radio" value="nright" <?php if( ( isset($tie_sidebar_pos) && $tie_sidebar_pos == 'nright') ) echo $checked; ?> />
						<a class="checkbox-select" href="#"><img src="<?php echo get_template_directory_uri(); ?>/panel/images/sidebar-1.png" /></a>
					</li>
					<li>
						<input id="tie_sidebar_pos"  name="tie_sidebar_pos" type="radio" value="nleft" <?php if( ( isset($tie_sidebar_pos) && $tie_sidebar_pos == 'nleft') ) echo $checked; ?> />
						<a class="checkbox-select" href="#"><img src="<?php echo get_template_directory_uri(); ?>/panel/images/sidebar-2.png" /></a>
					</li>
					<li>
						<input id="tie_sidebar_pos"  name="tie_sidebar_pos" type="radio" value="full" <?php if( ( isset($tie_sidebar_pos) && $tie_sidebar_pos == 'full') ) echo $checked; ?> />
						<a class="checkbox-select" href="#"><img src="<?php echo get_template_directory_uri(); ?>/panel/images/sidebar-no.png" /></a>
					</li>
				</ul>
			</div>
			<?php
			$sidebars = tie_get_option( 'sidebars' ) ;
			$new_sidebars = array(''=> 'Default');
			if (class_exists('Woocommerce'))
					$new_sidebars ['shop-widget-area'] = __( 'Shop - For WooCommerce Pages', 'tie' ) ;
					
			if($sidebars){
				foreach ($sidebars as $sidebar) {
					$new_sidebars[$sidebar] = $sidebar;
				}
			}
					
			tie_post_options(				
				array(	"name" => "Choose Sidebar",
						"id" => "tie_sidebar_post",
						"type" => "select",
						"options" => $new_sidebars ));
			
			if(tie_get_option( 'columns_num' ) != '2c'){			
				tie_post_options(				
					array(	"name" => "Choose Narrow Sidebar",
							"id" => "tie_sidebar_narrow_post",
							"type" => "select",
							"options" => $new_sidebars ));
			}
			?>
		</div>
		
		<div class="tiepanel-item">
			<h3>Page Style </h3>
			<?php
				tie_post_options(				
					array(	"name" => "Custom color",
							"id" => "post_color",
							"type" => "color" ));
								
				tie_post_options(
					array(	"name" => "Background",
							"id" => "post_background",
							"type" => "background"));
								
				tie_post_options(
					array(	"name" => "Full Screen Background",
							"id" => "post_background_full",
							"type" => "checkbox"));
			?>
		</div>
		<div class="tiepanel-item">
			<h3>Post Head Options</h3>
			<?php	

			tie_post_options(				
				array(	"name" => "Display",
						"id" => "tie_post_head",
						"type" => "select",
						"options" => array(
							''=> 'Default',
							'none'=> 'None',
							'video'=> 'Video',
							'audio'=> 'Audio - Self Hosted',
							'soundcloud'=> 'Audio - SoundCloud',
							'slider'=> 'Slider',
							'map'=> 'Google Map',
							'thumb'=> 'Featured Image',
							'lightbox'=> 'Featured Image + lightbox'
						)));


			tie_post_options(				
				array(	"name" => "Embed Code",
						"id" => "tie_embed_code",
						"type" => "textarea"));

			tie_post_options(				
				array(	"name" => "Youtube / Vimeo Video Url",
						"id" => "tie_video_url",
						"type" => "text"));
						
			tie_post_options(				
				array(	"name" => "SoundCloud URL",
						"id" => "tie_audio_soundcloud",
						"type" => "text"));
						
			tie_post_options(				
				array(	"name" => "Auto Play",
						"id" => "tie_audio_soundcloud_play",
						"type" => "checkbox"));
						
			tie_post_options(				
				array(	"name" => "Mp3 file Url <strong><small>(required)</small></strong>",
						"id" => "tie_audio_mp3",
						"type" => "text"));

			tie_post_options(				
				array(	"name" => "M4A file Url",
						"id" => "tie_audio_m4a",
						"type" => "text"));
					
			tie_post_options(				
				array(	"name" => "OGA file Url <strong><small>(required)</small></strong>",
						"id" => "tie_audio_oga",
						"type" => "text"));			

						
			global $post;
			$orig_post = $post;
			
			$sliders = array();
			$custom_slider = new WP_Query( array( 'post_type' => 'tie_slider', 'posts_per_page' => -1, 'no_found_rows' => 1  ) );
			while ( $custom_slider->have_posts() ) {
				$custom_slider->the_post();
				$sliders[get_the_ID()] = get_the_title();
			}
			$post = $orig_post;
			wp_reset_query();
	
			tie_post_options(				
				array(	"name" => "Custom Slider",
						"id" => "tie_post_slider",
						"type" => "select",
						"options" => $sliders ));
						
						
			tie_post_options(				
				array(	"name" => "Google Map Url",
						"id" => "tie_googlemap_url",
						"type" => "text"));
			?>
		</div>
		
		<div class="tiepanel-item">
			<h3>Banners Options</h3>
			<?php	
			tie_post_options(				
				array(	"name" => "Hide Above Banner",
						"id" => "tie_hide_above",
						"type" => "checkbox"));

			tie_post_options(				
				array(	"name" => "Custom Above Banner",
						"id" => "tie_banner_above",
						"type" => "textarea"));

			tie_post_options(				
				array(	"name" => "Hide Below Banner",
						"id" => "tie_hide_below",
						"type" => "checkbox"));

			tie_post_options(				
				array(	"name" => "Custom Below Banner",
						"id" => "tie_banner_below",
						"type" => "textarea"));
			?>
		</div>

  <?php
}

add_action('save_post', 'save_post');
function save_post( $post_id ){
	global $post;
	
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;
	
    if (isset($_POST['tie_hidden_flag'])) {
	
		$custom_meta_fields = array(
			'tie_rss_feed',
			'tie_posts_num',
			'tie_hide_meta',
			'tie_hide_author',
			'tie_hide_share',
			'tie_hide_related',
			'tie_sidebar_pos',
			'tie_sidebar_post',
			'tie_sidebar_narrow_post',
			'tie_post_head',
			'tie_post_slider',
			'tie_googlemap_url',
			'tie_video_url',
			'tie_embed_code',
			'tie_audio_m4a',
			'tie_audio_mp3',
			'tie_audio_oga',
			'tie_audio_soundcloud',
			'tie_audio_soundcloud_play',
			'tie_hide_above',
			'tie_banner_above',
			'tie_hide_below',
			'tie_banner_below',
			'tie_review_position',
			'tie_review_style',
			'tie_review_summary',
			'tie_review_total',
			'post_color',
			'post_background_full');
			
		foreach( $custom_meta_fields as $custom_meta_field ){
			if(isset($_POST[$custom_meta_field]) )
				update_post_meta($post_id, $custom_meta_field, htmlspecialchars(stripslashes($_POST[$custom_meta_field])) );
			else
				delete_post_meta($post_id, $custom_meta_field);
		}
		
		update_post_meta($post_id, 'tie_review_criteria', $_POST['tie_review_criteria']);
		update_post_meta($post_id, 'tie_blog_cats', $_POST['tie_blog_cats']);
		update_post_meta($post_id, 'tie_authors', $_POST['tie_authors']);
		update_post_meta($post_id, 'post_background', $_POST['post_background']);
		
		$get_meta = get_post_custom($post_id);

		$total_counter = $score = 0;
		if( isset( $get_meta['tie_review_criteria'][0] ))
		$criterias = unserialize( $get_meta['tie_review_criteria'][0] );
		
		if( !empty($criterias) ){
			foreach( $criterias as $criteria){ 
				if( $criteria['name'] && $criteria['score'] && is_numeric( $criteria['score'] )){
					if( $criteria['score'] > 100 ) $criteria['score'] = 100;
					if( $criteria['score'] < 0 ) $criteria['score'] = 1;
						
				$score += $criteria['score'];
				$total_counter ++;
				}
			}
			if( !empty( $score ) && !empty( $total_counter ) )
				$total_score =  $score / $total_counter ;
			
			update_post_meta($post_id, 'tie_review_score', $total_score);
		}
	}
}




/*********************************************************/

function tie_post_options($value){
	global $post;
?>

	<div class="option-item" id="<?php echo $value['id'] ?>-item">
		<span class="label"><?php  echo $value['name']; ?></span>
	<?php
		$id = $value['id'];
		$get_meta = get_post_custom($post->ID);
		
		if( isset( $get_meta[$id][0] ) )
			$current_value = $get_meta[$id][0];
			
	switch ( $value['type'] ) {
	
		case 'text': ?>
			<input  name="<?php echo $value['id']; ?>" id="<?php  echo $value['id']; ?>" type="text" value="<?php echo $current_value ?>" />
		<?php 
		break;

		case 'checkbox':
			if( !empty( $current_value ) ){$checked = "checked=\"checked\"";  } else{$checked = "";} ?>
				<input class="on-of" type="checkbox" name="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>" value="true" <?php echo $checked; ?> />			
		<?php	
		break;
		
		case 'select':
		?>
			<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
				<?php foreach ($value['options'] as $key => $option) { ?>
				<option value="<?php echo $key ?>" <?php if ( $current_value == $key) { echo ' selected="selected"' ; } ?>><?php echo $option; ?></option>
				<?php } ?>
			</select>
		<?php
		break;
		
		case 'textarea':
		?>
			<textarea style="direction:ltr; text-align:left; width:430px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="textarea" cols="100%" rows="3" tabindex="4"><?php echo $current_value  ?></textarea>
		<?php
		break;
		
		case 'background':
			$current_value = unserialize($current_value);
		?>
				<input id="<?php echo $value['id']; ?>-img" class="img-path" type="text" size="56" style="direction:ltr; text-align:left" name="<?php echo $value['id']; ?>[img]" value="<?php echo $current_value['img']; ?>" />
				<input id="upload_<?php echo $value['id']; ?>_button" type="button" class="small_button" value="Upload" />
					
				<div style="margin-top:15px; clear:both">
					<div id="<?php echo $value['id']; ?>colorSelector" class="color-pic"><div style="background-color:<?php echo $current_value['color'] ; ?>"></div></div>
					<input style="width:80px; margin-right:5px;"  name="<?php echo $value['id']; ?>[color]" id="<?php  echo $value['id']; ?>color" type="text" value="<?php echo $current_value['color'] ; ?>" />
					
					<select name="<?php echo $value['id']; ?>[repeat]" id="<?php echo $value['id']; ?>[repeat]" style="width:96px;">
						<option value="" <?php if ( !$current_value['repeat'] ) { echo ' selected="selected"' ; } ?>></option>
						<option value="repeat" <?php if ( $current_value['repeat']  == 'repeat' ) { echo ' selected="selected"' ; } ?>>repeat</option>
						<option value="no-repeat" <?php if ( $current_value['repeat']  == 'no-repeat') { echo ' selected="selected"' ; } ?>>no-repeat</option>
						<option value="repeat-x" <?php if ( $current_value['repeat'] == 'repeat-x') { echo ' selected="selected"' ; } ?>>repeat-x</option>
						<option value="repeat-y" <?php if ( $current_value['repeat'] == 'repeat-y') { echo ' selected="selected"' ; } ?>>repeat-y</option>
					</select>

					<select name="<?php echo $value['id']; ?>[attachment]" id="<?php echo $value['id']; ?>[attachment]" style="width:96px;">
						<option value="" <?php if ( !$current_value['attachment'] ) { echo ' selected="selected"' ; } ?>></option>
						<option value="fixed" <?php if ( $current_value['attachment']  == 'fixed' ) { echo ' selected="selected"' ; } ?>>Fixed</option>
						<option value="scroll" <?php if ( $current_value['attachment']  == 'scroll') { echo ' selected="selected"' ; } ?>>scroll</option>
					</select>
					
					<select name="<?php echo $value['id']; ?>[hor]" id="<?php echo $value['id']; ?>[hor]" style="width:96px;">
						<option value="" <?php if ( !$current_value['hor'] ) { echo ' selected="selected"' ; } ?>></option>
						<option value="left" <?php if ( $current_value['hor']  == 'left' ) { echo ' selected="selected"' ; } ?>>Left</option>
						<option value="right" <?php if ( $current_value['hor']  == 'right') { echo ' selected="selected"' ; } ?>>Right</option>
						<option value="center" <?php if ( $current_value['hor'] == 'center') { echo ' selected="selected"' ; } ?>>Center</option>
					</select>
					
					<select name="<?php echo $value['id']; ?>[ver]" id="<?php echo $value['id']; ?>[ver]" style="width:100px;">
						<option value="" <?php if ( !$current_value['ver'] ) { echo ' selected="selected"' ; } ?>></option>
						<option value="top" <?php if ( $current_value['ver']  == 'top' ) { echo ' selected="selected"' ; } ?>>Top</option>
						<option value="center" <?php if ( $current_value['ver'] == 'center') { echo ' selected="selected"' ; } ?>>Center</option>
						<option value="bottom" <?php if ( $current_value['ver']  == 'bottom') { echo ' selected="selected"' ; } ?>>Bottom</option>

					</select>
				</div>
				<div id="<?php echo $value['id']; ?>-preview" class="img-preview" <?php if( !$current_value['img']  ) echo 'style="display:none;"' ?>>
					<img src="<?php if( $current_value['img'] ) echo $current_value['img'] ; else echo get_template_directory_uri().'/panel/images/spacer.png'; ?>" alt="" />
					<a class="del-img" title="Delete"></a>
				</div>
					
				<script>
				jQuery('#<?php echo $value['id']; ?>colorSelector').ColorPicker({
					color: '<?php echo $current_value['color'] ; ?>',
					onShow: function (colpkr) {
						jQuery(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						jQuery(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						jQuery('#<?php echo $value['id']; ?>colorSelector div').css('backgroundColor', '#' + hex);
						jQuery('#<?php echo $value['id']; ?>color').val('#'+hex);
					}
				});
				tie_styling_uploader('<?php echo $value['id']; ?>');
				</script>
		<?php
		break;
		
		
		case 'color':
		?>
			<div id="<?php echo $value['id']; ?>colorSelector" class="color-pic"><div style="background-color:<?php echo $current_value ; ?>"></div></div>
			<input style="width:80px; margin-right:5px;"  name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php echo $current_value ; ?>" />
							
			<script>
				jQuery('#<?php echo $value['id']; ?>colorSelector').ColorPicker({
					color: '<?php echo $current_value ; ?>',
					onShow: function (colpkr) {
						jQuery(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						jQuery(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						jQuery('#<?php echo $value['id']; ?>colorSelector div').css('backgroundColor', '#' + hex);
						jQuery('#<?php echo $value['id']; ?>').val('#'+hex);
					}
				});
				</script>
		<?php
		break;
	} ?>
	</div>
<?php
}
?>