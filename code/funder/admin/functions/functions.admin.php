<?php
/**
 * SMOF Admin
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.4.0
 * @author      Syamil MJ
 */
 

/**
 * Head Hook
 *
 * @since 1.0.0
 */
function of_head() { do_action( 'of_head' ); }

/**
 * Add default options upon activation else DB does not exist
 *
 * @since 1.0.0
 */
function of_option_setup()	
{
	global $of_options, $options_machine;
	$options_machine = new Options_Machine($of_options);
		
	if (!get_option(OPTIONS))
	{
		update_option(OPTIONS,$options_machine->Defaults);
	}
}

/**
 * Change activation message
 *
 * @since 1.0.0
 */
function optionsframework_admin_message() { 
	
	//Tweaked the message on theme activate
	?>
    <script type="text/javascript">
    jQuery(function(){
    	
        var message = '<p>This theme comes with an <a href="<?php echo admin_url('admin.php?page=optionsframework'); ?>">options panel</a> to configure settings. This theme also supports widgets, please visit the <a href="<?php echo admin_url('widgets.php'); ?>">widgets settings page</a> to configure them.</p>';
    	jQuery('.themes-php #message2').html(message);
    
    });
    </script>
    <?php
	
}

/*-----------------------------------------------------------------------------------*/
/* Generate the dynamic options.css file                                             */
/*-----------------------------------------------------------------------------------*/

/*function generate_options_css($newdata) {

	$data = $newdata;
	$css_dir = get_template_directory() . '/assets/css/dynamic-css/'; // Shorten code, save 1 call
	ob_start(); // Capture all output (output buffering)

	require $css_dir . 'style.php'; // Generate CSS

	$css = ob_get_clean(); // Get generated CSS (output buffering)
	file_put_contents($css_dir . 'options.css', $css, LOCK_EX); //100% safe - ignore theme check nag
}
*/
/*function generate_options_css($newdata) {

	$data = $newdata; 
	$uploads = wp_upload_dir();
	$css_dir = get_template_directory() . '/assets/css/dynamic-css/'; // Shorten code, save 1 call
	
	ob_start();
	require $css_dir . 'style.php';
	$css = ob_get_clean();
	
	WP_Filesystem();
	global $wp_filesystem;
	if ( ! $wp_filesystem->put_contents( $css_dir . 'options.css', $css, 0644) ) {
	    return true;
	}
	
}*/

/**
 * Get header classes
 *
 * @since 1.0.0
 */
function of_get_header_classes_array() 
{
	global $of_options;
	
	foreach ($of_options as $value) 
	{
		if ($value['type'] == 'heading')
			$hooks[] = str_replace(' ','',strtolower($value['name']));	
	}
	
	return $hooks;
}


/**
 * For use in themes
 *
 * @since forever
 */
$data = get_option(OPTIONS);