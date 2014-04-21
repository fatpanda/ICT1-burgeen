<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories = array();  
		$of_categories_obj = get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp = array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages = array();
		$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp = array_unshift($of_pages, "Select a page:");       
	
		$of_options_select = array("one","two","three","four","five"); 
		$of_options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		$of_options_slider_select = array("2","3","4","5","6","7","8","9","10");
		$of_options_latest_work_select = array("3","6","9","12");
		$of_options_quotes_select = array("2","3","4","5","6","7","8","9","10");
		$of_options_services_select = array("3","6","9","12");
		$of_options_meet_team_select = array("3","6","9","12");
		$of_options_latest_project_select = array("3","6","9","12");
		$of_options_latest_project_col = array("2","3","4");
		$of_options_project_nav = array("Yes","No"); 
	    
		
		//Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"enabled" => array (
				"placebo" => "placebo", //REQUIRED!
				"slider_block" => "Slider",
			    "about_block" => "About",
				"project_block" => "Projects",
				"submission_block" => "Project (Form)",
				"contact_block" => "Contact",
				"logo_block" => "Client Logos",
			),
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				/*"wpg_map" => "Map",*/
			),
		);

		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}


		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/assets/img/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/assets/img/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		 $wpg_site_url = get_template_directory_uri();
		 
		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr = wp_upload_dir();
		$all_uploads_path = $uploads_arr['path'];
		$all_uploads = get_option('of_uploads');
		$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();

$of_options[] = array( "name" => __('Home Settings', 'wpg'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Homepage Layout Manager', 'wpg'),
					"desc" => __('Organize how you want the layout to appear on the homepage.<br /><br />You can choose to enable/disable sections via drag & drop, or re-order their stacking order on the homepage.<br /><br />NB; Once you have re-ordered or disabled, do not forget to adjust your Menu (Navigation) in the same way.', 'wpg'),
					"id" => "homepage_blocks",
					"std" => $of_options_homepage_blocks,
					"type" => "sorter");
$of_options[] = array( "name" => __('General Settings', 'wpg'),
                    "type" => "heading");
					
$of_options[] = array( "name" => __('Custom Favicon', 'wpg'),
					"desc" => __('Upload a 32px x 32px PNG/GIF image that will represent your website favicon.', 'wpg'),
					"id" => "custom_favicon",
					"std" => "",
					"mod" => "min",
					"type" => "upload");
					
$of_options[] = array( "name" => __('Footer Text', 'wpg'),
					"desc" => __('Please enter the text to appear at the bottom of your Footer (eg; All rights reserved. Designed by WpgraceThemes.)', 'wpg'),
					"id" => "textarea_footer_text",
					"std" => "",
					"type" => "textarea");
                
$of_options[] = array( "name" => __('Google Analytics Tracking Code', 'wpg'),
					"desc" => __('Paste your Google Analytics tracking code here (Remember you need to paste all the Javascript code, not just your ID). This will be added into the footer template of your theme.<br /><br />Do not have Google Analytics? Unsure what to paste in this box? Visit this <a href="http://www.google.com/analytics">link</a> to find out more.', 'wpg'),
					"id" => "google_analytics",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "name" => __('Header Settings', 'wpg'),
					"type" => "heading");

$of_options[] = array( "name" => __('Custom Logo', 'wpg'),
					"desc" => __('Upload your own logo to use on the site.', 'wpg'),
					"id" => "custom_logo",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => __('Text Logo', 'wpg'),
					"desc" => __('If you do not have a logo you can choose to use a plain text logo instead.', 'wpg'),
					"id" => "text_logo",
					"std" => true,
					"type" => "checkbox");
/*$of_options[] = array( "name" => __('Styling Options', 'wpg'),
					"type" => "heading");                                                    

$of_options[] = array( "name" => __('Text Logo Styling', 'wpg'),
					"desc" => __('Specify the text logo font properties (if you chose this option on the previous page).', 'wpg'),
					"id" => "logo_font",
					"std" => array('size' => '39px','face' => 'pacifico','style' => 'normal','color' => '#333333'),
					"type" => "typography");
					
$of_options[] = array( "name" => __('Body Font Styling', 'wpg'),
					"desc" => __('Specify the body font properties.', 'wpg'),
					"id" => "body_font",
					"std" => array('size' => '14px','face' => 'cabin','style' => 'normal','color' => '#333333'),
					"type" => "typography");
					
$of_options[] = array( "name" => __('Headings Styling', 'wpg'),
					"desc" => __('Specify the h1, h2, h3, h4, h5 font properties.', 'wpg'),
					"id" => "headings_font",
					"std" => array('face' => 'oswald','style' => 'normal','color' => '#333333'),
					"type" => "typography");

$of_options[] = array( "name" =>  __('Accent Color', 'wpg'),
					"desc" => __('Pick an accent color for the theme. (This will affect Header Navigation, Project Filter, Quotes, Blockquotes, Pricing Tables, Tabs, Project Navigation & Social Icons).', 'wpg'),
					"id" => "accent_color",
					"std" => "#e47c14",
					"type" => "color");
					
$of_options[] = array( "name" =>  __('Button Color', 'wpg'),
					"desc" => __('Pick an accent color for the buttons.', 'wpg'),
					"id" => "accent_color_button",
					"std" => "#e47c14",
					"type" => "color");
					
$of_options[] = array( "name" =>  __('Body Link Color', 'wpg'),
					"desc" => __('Pick an accent color for the main body links.', 'wpg'),
					"id" => "body_link_color",
					"std" => "#e47c14",
					"type" => "color");
					
$of_options[] = array( "name" =>  __('Footer Link Color', 'wpg'),
					"desc" => __('Pick an accent color for the footer text links.', 'wpg'),
					"id" => "footer_link_color",
					"std" => "#e47c14",
					"type" => "color");
					
$of_options[] = array( "name" =>  __('Service Icons Color', 'wpg'),
					"desc" => __('Pick an accent color for the service icons.', 'wpg'),
					"id" => "accent_color_service_icons",
					"std" => "#e47c14",
					"type" => "color");
					
$of_options[] = array( "name" =>  __('Team Member Social Icons Color', 'wpg'),
					"desc" => __('Pick an accent color for the team member social icons.', 'wpg'),
					"id" => "accent_color_team_icons",
					"std" => "#e47c14",
					"type" => "color");
					
$of_options[] = array( "name" => __('Custom CSS', 'wpg'),
                    "desc" => __('Quickly add some CSS to your theme by adding it to this block.', 'wpg'),
                    "id" => "custom_css",
                    "std" => "",
                    "type" => "textarea");
                    
$of_options[] = array( "name" => __('Background Settings', 'wpg'),
					"type" => "heading");  
                    
$of_options[] = array( "name" => __('Background Image', 'wpg'),
					"desc" => __('Upload a background image to use', 'wpg'),
					"id" => "upload_logos_background",
					"std" => "",
					"type" => "media");*/
										
$of_options[] = array( "name" => __('Slider Settings', 'wpg'),
					"type" => "heading");
$of_options[] = array( "name" => __('Welcome Message Line 1', 'wpg'),
					"desc" => __('Please Enter Welcome Message Line 1', 'wpg'),
					"id" => "grid_slider_msg_1",
					"std" => "WELCOME TO funder",
					"type" => "text");
$of_options[] = array( "name" => __('Welcome Message Line 2', 'wpg'),
					"desc" => __('Please Enter Welcome Message Line 2', 'wpg'),
					"id" => "grid_slider_msg_2",
					"std" => "AMAZING CROWDFUNDING SITE",
					"type" => "text");
										
									
$of_options[] = array( "name" => __('About Us Settings', 'wpg'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'wpg'),
					"desc" => __('Please enter a title for the About Us section. (eg; We are an award winning digital agency. And truly awesome too.)', 'wpg'),
					"id" => "text_about_us_title",
					"std" => "About",
					"type" => "text");
					
$of_options[] = array( "name" => __('Discription', 'wpg'),
					"desc" => __('You can add a short Discription to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'wpg'),
					"id" => "textarea_about_us_discription",
					"std" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate egestas sem, eu cursus ligula ullamcorper non. Curabitur tristique velit eu mauris venenatis egestas. Phasellus bibendum placerat metus, sed molestie magna semper eget. Sed sit amet dui felis, tempus porttitor justo.",
					"type" => "textarea");

					
$of_options[] = array( "name" => __('Step 1 (Image)', 'wpg'),
					"desc" => __('Upload your Image for step 1', 'wpg'),
					"id" => "step_1_img",
					"std" => $wpg_site_url. '/img/folder1.png',
					"mod" => "min",
					"type" => "media");					
$of_options[] = array( "name" => __('Step 1 (Url)', 'wpg'),
					"desc" => __('Please enter of you want to link', 'wpg'),
					"id" => "step_1_url",
					"std" => "",
					"type" => "text");
$of_options[] = array( "name" => __('Step 1 (Heading)', 'wpg'),
					"desc" => __('Please enter heading text', 'wpg'),
					"id" => "step_1_heading",
					"std" => "Step 1:",
					"type" => "text");
$of_options[] = array( "name" => __('Step 1 (Sub-heading)', 'wpg'),
					"desc" => __('Please enter sub-heading text', 'wpg'),
					"id" => "step_1_subheading",
					"std" => "Choose a project",
					"type" => "text");
// Step 2
$of_options[] = array( "name" => __('Step 2 (Image)', 'wpg'),
					"desc" => __('Upload your Image for step 1', 'wpg'),
					"id" => "step_2_img",
					"std" => $wpg_site_url. '/img/folder2.png',
					"mod" => "min",
					"type" => "media");					
$of_options[] = array( "name" => __('Step 2 (Url)', 'wpg'),
					"desc" => __('Please enter of you want to link', 'wpg'),
					"id" => "step_2_url",
					"std" => "",
					"type" => "text");
$of_options[] = array( "name" => __('Step 2 (Heading)', 'wpg'),
					"desc" => __('Please enter heading text', 'wpg'),
					"id" => "step_2_heading",
					"std" => "Step 2:",
					"type" => "text");
$of_options[] = array( "name" => __('Step 2 (Sub-heading)', 'wpg'),
					"desc" => __('Please enter sub-heading text', 'wpg'),
					"id" => "step_2_subheading",
					"std" => "Back a project",
					"type" => "text");
// Step 3
$of_options[] = array( "name" => __('Step 3 (Image)', 'wpg'),
					"desc" => __('Upload your Image for step 1', 'wpg'),
					"id" => "step_3_img",
					"std" => $wpg_site_url. '/img/folder3.png',
					"mod" => "min",
					"type" => "media");
									
$of_options[] = array( "name" => __('Step 3 (Url)', 'wpg'),
					"desc" => __('Please enter of you want to link', 'wpg'),
					"id" => "step_3_url",
					"std" => "",
					"type" => "text");
$of_options[] = array( "name" => __('Step 3 (Heading)', 'wpg'),
					"desc" => __('Please enter heading text', 'wpg'),
					"id" => "step_3_heading",
					"std" => "Step 3:",
					"type" => "text");
$of_options[] = array( "name" => __('Step 3 (Sub-heading)', 'wpg'),
					"desc" => __('Please enter sub-heading text', 'wpg'),
					"id" => "step_3_subheading",
					"std" => "Receive a gift",
					"type" => "text");
																				
																									
					
$of_options[] = array( "name" => __('Project Settings', 'wpg'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'wpg'),
					"desc" => __('Please enter a title for the Project section. (eg; Our work says a lot about us. Passionate about all we do.)', 'wpg'),
					"id" => "text_project_title",
					"std" => "Projects",
					"type" => "text");
$of_options[] = array( "name" => __('Numbers of Col', 'wpg'),
					"desc" => __('Please select how many items you would like show.', 'wpg'),
					"id" => "text_project_col",
					"std" => "3",
					"type" => "select",
					"class" => "tiny",
					"options" => $of_options_latest_project_col);
$of_options[] = array( "name" => __('Numbers of Item', 'wpg'),
					"desc" => __('Please select how many items you would like show.', 'wpg'),
					"id" => "text_project_num",
					"std" => "9",
					"type" => "select",
					"class" => "tiny",
					"options" => $of_options_latest_project_select);					
$of_options[] = array( "name" => __('Show Navigation', 'wpg'),
					"desc" => __('Please select you would like to show navigation', 'wpg'),
					"id" => "text_project_nav",
					"std" => "9",
					"type" => "select",
					"class" => "tiny",
					"options" => $of_options_project_nav);	
					
/*$of_options[] = array( "name" => __('Service Settings', 'wpg'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'wpg'),
					"desc" => __('Please enter a title for the Services section. (eg; We provide a multitude of services. Everything is covered.)', 'wpg'),
					"id" => "text_services_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Icon', 'wpg'),
					"desc" => __('Please add an icon to appear above your title. (eg; [icon name=icon-cog])<br/><br />All list of available icons can be found <a href="http://fortawesome.github.com/Font-Awesome/" target="_blank">here</a>.', 'wpg'),
					"id" => "icon_services",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Overview', 'wpg'),
					"desc" => __('You can add a short overview to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'wpg'),
					"id" => "textarea_services_overview",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "desc" => __('Please select how many items you would like to show in the services section.', 'wpg'),
					"id" => "select_services",
					"std" => "6",
					"type" => "select",
					"class" => "tiny",
					"options" => $of_options_services_select);
					
$of_options[] = array( "name" => __('Team Settings', 'wpg'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'wpg'),
					"desc" => __('Please enter a title for the Meet the Team section. (eg; We have a team of truly awesome folk. You will love them.)', 'wpg'),
					"id" => "text_team_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Icon', 'wpg'),
					"desc" => __('Please add an icon to appear above your title. (eg; [icon name=icon-user])<br/><br />All list of available icons can be found <a href="http://fortawesome.github.com/Font-Awesome/" target="_blank">here</a>.', 'wpg'),
					"id" => "icon_team",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Overview', 'wpg'),
					"desc" => __('You can add a short overview to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'wpg'),
					"id" => "textarea_team_overview",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "desc" => __('Please select how many items you would like to show in the meet the team section.', 'wpg'),
					"id" => "select_team",
					"std" => "3",
					"type" => "select",
					"class" => "tiny",
					"options" => $of_options_meet_team_select);

$of_options[] = array( "name" => __('News Settings', 'wpg'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'wpg'),
					"desc" => __('Please enter a title for the Latest News section. (eg; Hear what we have to say. It is all good.)', 'wpg'),
					"id" => "text_news_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Icon', 'wpg'),
					"desc" => __('Please add an icon to appear above your title. (eg; [icon name=icon-book])<br/><br />All list of available icons can be found <a href="http://fortawesome.github.com/Font-Awesome/" target="_blank">here</a>.', 'wpg'),
					"id" => "icon_news",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Overview', 'wpg'),
					"desc" => __('You can add a short overview to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'wpg'),
					"id" => "textarea_news_overview",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "desc" => __('Please select how many items you would like to show in the latest news section.', 'wpg'),
					"id" => "select_news",
					"std" => "3",
					"type" => "select",
					"class" => "tiny",
					"options" => $of_options_latest_project_select);			*/
					
$of_options[] = array( "name" => __('Contact Settings', 'wpg'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'wpg'),
					"desc" => __('Please enter a title for the Contact section. (eg; Contact Us)', 'wpg'),
					"id" => "text_contact_us_title",
					"std" => "Contact Us",
					"type" => "text");
					
$of_options[] = array( "name" => __('Contact Email', 'wpg'),
					"desc" => __('Please enter your company email address (eg; davesmith@guuthemes.com.), Contact From will send email to this address.', 'wpg'),
					"id" => "text_contact_email",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Column Right', 'wpg'),
					"desc" => __('You can add a short overview to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'wpg'),
					"id" => "contact_right_col",
					"std" => ' <div class="paddin_map"><div class="map">
                <iframe width="100%" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=ru&amp;geocode=&amp;q=Ottawa,+ON,+Canada&amp;sll=45.421438,-75.693569&amp;sspn=0.017531,0.042272&amp;ie=UTF8&amp;hq=&amp;hnear=%D0%9E%D1%82%D1%82%D0%B0%D0%B2%D0%B0,+%D0%9E%D1%82%D1%82%D0%B0%D0%B2%D0%B0+%D0%94%D0%B8%D0%B2%D0%B8%D0%B6%D0%B5%D0%BD,+%D0%9E%D0%BD%D1%82%D0%B0%D1%80%D0%B8%D0%BE,+%D0%9A%D0%B0%D0%BD%D0%B0%D0%B4%D0%B0&amp;t=m&amp;ll=45.421528,-75.697603&amp;spn=0.012049,0.034332&amp;z=14&amp;output=embed"></iframe><br />
        </div>
        </div>',
					"type" => "textarea");
					
$of_options[] = array( "name" => __('Column Left', 'wpg'),
					"desc" => __('You can add a short overview to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'wpg'),
					"id" => "contact_left_col",
					"std" => '<div class="span3">
					<h4>Address Details:</h4>
					<div class="cont">
						<div class="inline-table "><i class="icon-map-marker"></i></div>
						<div class="inline-table mleft10">
							<span>1234 Street </span>
							<p>Lorem Ipsum, CA 91919</p>
						</div>
						<div class="clear clrbot"></div>
						<div class="inline-table"><i class="icon-phone-sign"></i></div>
						<div class="inline-table mleft10">
							<span>Phone: +1 123 123-123-123</span>
							<p>Fax: +1 123-123-123</p>
						</div>
						<div class="clear clrbot"></div>
						<div class="inline-table"><i class="icon-envelope"></i></div>
						<div class="inline-table mleft10">
							<span>E-mail: <span class="green">email@email.by</span></span>
							<p>Website: <span class="green">www.example.com</span></p>
						</div>
					</div>
				</div>
				<div class="span3">
					<h4>Opening Hours:</h4>
					<div class="cont contp">
						<div class="inline">
							<p><strong>Monday-Friday:</strong></p>
							<p><strong>Saturday:</strong></p>
							<p><strong>Sunday:</strong></p>
						</div>
						<div class="inline mleft10">
							<p>9am - 5pm</p>
							<p>10am - 3pm</p>
							<p>Closed</p>
						</div>
					</div>
    </div>',
					"type" => "textarea");				
					
$of_options[] = array( "name" => __('Client Settings', 'wpg'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Client Logos Title', 'wpg'),
					"desc" => __('Please enter a title for the Client Logos section. (eg; Folks we have worked with)', 'wpg'),
					"id" => "text_client_logos_title",
					"std" => "OUR PARTNERS",
					"type" => "text");
														
$of_options[] = array( "name" => __('Client Logo One', 'wpg'),
					"desc" => __('Upload client logos to appear in the client logo section. Choose an image around 100px wide to achieve the best layout.', 'wpg'),
					"id" => "client_logo_one",
					"std" => $wpg_site_url. '/img/partn_1.png',
					"mod" => "min",
					"type" => "media");
$of_options[] = array( "name" => __('Client Logo URL One', 'wpg'),
					"desc" => __('Enter your URL of your client', 'wpg'),
					"id" => "client_logo_url_one",
					"std" => "",
					"type" => "text");
										
$of_options[] = array( "name" => __('Client Logo Two', 'wpg'),
					"id" => "client_logo_two",
					"std" => $wpg_site_url. '/img/partn_2.png',
					"mod" => "min",
					"type" => "media");
$of_options[] = array( "name" => __('Client Logo URL Two', 'wpg'),
					"desc" => __('Enter your URL of your client', 'wpg'),
					"id" => "client_logo_url_two",
					"std" => "",
					"type" => "text");					
$of_options[] = array( "name" => __('Client Logo Three', 'wpg'),
					"id" => "client_logo_three",
					"std" => $wpg_site_url. '/img/partn_3.png',
					"mod" => "min",
					"type" => "media");
$of_options[] = array( "name" => __('Client Logo URL Tree', 'wpg'),
					"desc" => __('Enter your URL of your client', 'wpg'),
					"id" => "client_logo_url_tree",
					"std" => "",
					"type" => "text");					
$of_options[] = array( "name" => __('Client Logo Four', 'wpg'),
					"id" => "client_logo_four",
					"std" => $wpg_site_url. '/img/partn_4.png',
					"mod" => "min",
					"type" => "media");
$of_options[] = array( "name" => __('Client Logo URL Four', 'wpg'),
					"desc" => __('Enter your URL of your client', 'wpg'),
					"id" => "client_logo_url_four",
					"std" => "",
					"type" => "text");					
$of_options[] = array( "name" => __('Client Logo Five', 'wpg'),
					"id" => "client_logo_five",
					"std" => $wpg_site_url. '/img/partn_5.png',
					"mod" => "min",
					"type" => "media");
$of_options[] = array( "name" => __('Client Logo URL Five', 'wpg'),
					"desc" => __('Enter your URL of your client', 'wpg'),
					"id" => "client_logo_url_five",
					"std" => "",
					"type" => "text");					
$of_options[] = array( "name" => __('Client Logo Six', 'wpg'),
					"id" => "client_logo_six",
					"std" => $wpg_site_url. '/img/partn_6.png',
					"mod" => "min",
					"type" => "media");
$of_options[] = array( "name" => __('Client Logo URL Six', 'wpg'),
					"desc" => __('Enter your URL of your client', 'wpg'),
					"id" => "client_logo_url_six",
					"std" => "",
					"type" => "text");					
$of_options[] = array( "name" => __('Client Logo Seven', 'wpg'),
					"id" => "client_logo_seven",
					"std" => $wpg_site_url. '/img/partn_7.png',
					"mod" => "min",
					"type" => "media");
$of_options[] = array( "name" => __('Client Logo URL Seven', 'wpg'),
					"desc" => __('Enter your URL of your client', 'wpg'),
					"id" => "client_logo_url_seven",
					"std" => "",
					"type" => "text");					
$of_options[] = array( "name" => __('Social Profiles', 'wpg'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Twitter Username', 'wpg'),
					"desc" => __('Enter your Twitter Username <br />(ie; guuthemes). This enables you to show your latest tweet in the theme', 'wpg'),
					"id" => "text_twitter_username",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Twitter', 'wpg'),
					"desc" => __('Enter your Twitter Profile URL <br />(ie; http://twitter.com/guuthemes)', 'wpg'),
					"id" => "text_twitter_profile",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => __('Facebook', 'wpg'),
					"desc" => __('Enter your Facebook Profile URL <br />(ie; http://facebook.com/guuthemes)', 'wpg'),
					"id" => "text_facebook_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Dribbble', 'wpg'),
					"desc" => __('Enter your Dribbble Profile URL <br />(ie; http://dribbble.com/guuthemes)', 'wpg'),
					"id" => "text_dribbble_profile",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => __('Linkedin', 'wpg'),
					"desc" => __('Enter your Linkedin Profile URL <br />(ie; http://linkedin.com/in/guuthemes)', 'wpg'),
					"id" => "text_linkedin_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Pinterest', 'wpg'),
					"desc" => __('Enter your Pinterest Profile URL <br />(ie; http://pinterest.com/guuthemes)', 'wpg'),
					"id" => "text_pinterest_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Google +', 'wpg'),
					"desc" => __('Enter your Google + Profile URL <br />(ie; http://plus.google.com/1030594445)', 'wpg'),
					"id" => "text_googleplus_profile",
					"std" => "",
					"type" => "text");
					



// Backup Options
/*$of_options[] = array( "name" => __('Backup Options', 'wpg'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Backup and Restore Options', 'wpg'),
                    "id" => "of_backup",
                    "std" => "",
                    "type" => "backup",
					"desc" => __('You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', 'wpg'),
					);
					
$of_options[] = array( "name" => __('Transfer Theme Options Data', 'wpg'),
                    "id" => "of_transfer",
                    "std" => "",
                    "type" => "transfer",
					"desc" => __('You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".
						', 'wpg'),
					);*/
					
	}
}
?>