<?php
/**
 * funder Theme Customizer
 *
 * @package funder
 * @since funder 1.0
 */

/**
 * Get Theme Mod
 *
 * Instead of options, customizations are stored/accessed via Theme Mods
 * (which are still technically settings). This wrapper provides a way to
 * check for an existing mod, or load a default in its place.
 *
 * @since funder 1.0
 *
 * @param string $key The key of the theme mod to check. Prefixed with 'funder_'
 * @return mixed The theme modification setting
 */
function funder_theme_mod( $key ) {
	$defaults = funder_get_theme_mods();
	$key      = 'funder_' . $key;
	$mod      = get_theme_mod( $key, $defaults[ $key ] );

	return apply_filters( 'funder_theme_mod_' . $key, $mod );
}

/**
 * Default theme customizations.
 *
 * @since funder 1.0
 *
 * @return $options an array of default theme options
 */
function funder_get_theme_mods() {
	$defaults = array(
		'funder_responsive'                 => true,
		'funder_header_fixed'               => true,
		'funder_header_size'                => 'normal',
		'funder_hero_slider'                => null,
		'funder_hero_style'                 => 'grid',
		'funder_hero_text'                  => "The first funder WordPress theme\nWe help you fund your campaigns using WordPress\nStart funding your campaign today",
		'funder_accent_color'               => '#04937f',
		'funder_footer_text_color'          => '#005a4d',
		'funder_footer_logo_image'          => get_template_directory_uri() . '/images/logo_f.png',
		'funder_footer_background_color'    => '#04937f',
		'funder_footer_background_image'    => get_template_directory_uri() . '/images/bg_footer.jpg',
		'funder_footer_background_repeat'   => 'repeat',
		'funder_footer_background_position' => 'top',
		'funder_contact_text'               => sprintf( "Got questions regarding %s?\nFill out the below form and we'll get in touch\nWere here to help you.", get_bloginfo( 'name' ) ),
		'funder_contact_subtitle'           => 'Where our offices are located, and how to get in touch.',
		'funder_contact_address'            => "43 Brewer Street\nLondon, W1F 9UD",
		'funder_contact_image'              => ''
	);

	return $defaults;
}

/**
 * General Customization
 *
 * @since funder 1.3
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function funder_customize_register_general( $wp_customize ) {
	$wp_customize->add_section( 'funder_general', array(
		'title'      => __( 'General', 'funder' ),
		'priority'   => 85,
	) );

	/** Responsive */
	$wp_customize->add_setting( 'funder_responsive', array(
		'default'    => funder_theme_mod( 'responsive' )
	) );

	$wp_customize->add_control( 'funder_responsive', array(
		'label'      => __( 'Enable Responsive Design', 'funder' ),
		'section'    => 'funder_general',
		'settings'   => 'funder_responsive',
		'type'       => 'checkbox',
		'priority'   => 10
	) );

	/** Fixed Header */
	$wp_customize->add_setting( 'funder_header_fixed', array(
		'default'    => funder_theme_mod( 'header_fixed' )
	) );

	$wp_customize->add_control( 'funder_header_fixed', array(
		'label'      => __( 'Enable Fixed Header', 'funder' ),
		'section'    => 'funder_general',
		'settings'   => 'funder_header_fixed',
		'type'       => 'checkbox',
		'priority'   => 20
	) );

	/** Header Size */
	$wp_customize->add_setting( 'funder_header_size', array(
		'default'    => funder_theme_mod( 'header_size' )
	) );

	$wp_customize->add_control( 'funder_header_size', array(
		'label'      => __( 'Header Size', 'funder' ),
		'section'    => 'funder_general',
		'settings'   => 'funder_header_size',
		'type'       => 'radio',
		'choices'    => array(
			'mini'   => _x( 'Mini', 'header size', 'funder' ),
			'normal' => _x( 'Normal', 'header size', 'funder' )
		),
		'priority'   => 30
	) );

	do_action( 'funder_customize_general', $wp_customize );

	return $wp_customize;
}
add_action( 'customize_register', 'funder_customize_register_general' );

/**
 * Hero Customization
 *
 * Register settings and controls for customizing the "Hero" section
 * of the theme. This includes title, description, images, colors, etc.
 *
 * @since funder 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function funder_customize_register_hero( $wp_customize ) {
	if ( ! ( get_option( 'page_on_front' ) && 'page-templates/front-page.php' == get_page_template_slug( get_option( 'page_on_front' ) ) ) )
		return false;

	$wp_customize->add_section( 'funder_hero', array(
		'title'      => __( 'Hero Unit', 'funder' ),
		'priority'   => 95,
	) );

	/** RevSlider */
	$wp_customize->add_setting( 'funder_hero_slider', array(
		'default'    => funder_theme_mod( 'hero_slider' )
	) );

	$wp_customize->add_control( 'funder_hero_slider', array(
		'label'      => __( 'Slider Shortcode', 'funder' ),
		'section'    => 'funder_hero',
		'settings'   => 'funder_hero_slider',
		'type'       => 'text',
		'priority'   => 5
	) );

	$wp_customize->add_setting( 'funder_hero_style', array(
		'default'    => funder_theme_mod( 'hero_style' )
	) );

	$wp_customize->add_control( 'funder_hero_style', array(
		'label'      => __( 'Style', 'funder' ),
		'section'    => 'funder_hero',
		'settings'   => 'funder_hero_style',
		'type'       => 'radio',
		'choices'    => array(
			'grid'   => __( 'Grid', 'funder' ),
			'single' => __( 'Single', 'funder' )
		),
		'priority'   => 10
	) );

	/** Description */
	$wp_customize->add_setting( 'funder_hero_text', array(
		'default'    => funder_theme_mod( 'hero_text' )
	) );

	$wp_customize->add_control( new funder_Customize_Textarea_Control( $wp_customize, 'funder_hero_text', array(
		'label'      => __( 'Hero Text', 'funder' ),
		'section'    => 'funder_hero',
		'settings'   => 'funder_hero_text',
		'type'       => 'textarea',
		'priority'   => 20
	) ) );

	do_action( 'funder_customize_hero', $wp_customize );

	return $wp_customize;
}
add_action( 'customize_register', 'funder_customize_register_hero' );

function funder_customize_register_colors( $wp_customize ) {
	/** Link Color */
	$wp_customize->add_setting( 'funder_accent_color', array(
		'default'    => funder_theme_mod( 'accent_color' ),
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'funder_accent_color', array(
		'label'      => __( 'Accent Color', 'funder' ),
		'section'    => 'colors',
		'settings'   => 'funder_accent_color',
		'priority'   => 30
	) ) );
}
add_action( 'customize_register', 'funder_customize_register_colors' );

function funder_customize_register_footer( $wp_customize ) {
	$wp_customize->add_section( 'funder_footer', array(
		'title'      => __( 'Footer', 'funder' ),
		'priority'   => 105,
	) );

	/** Description */
	$wp_customize->add_setting( 'funder_footer_text_color', array(
		'default'    => funder_theme_mod( 'footer_text_color' )
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'funder_footer_text_color', array(
		'label'      => __( 'Text Color', 'funder' ),
		'section'    => 'funder_footer',
		'settings'   => 'funder_footer_text_color',
		'priority'   => 20
	) ) );

	/** Footer Logo */
	$wp_customize->add_setting( 'funder_footer_logo_image', array(
		'default'        => funder_theme_mod( 'footer_logo_image' )
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'funder_footer_logo_image', array(
		'label'          => __( 'Logo Image', 'funder' ),
		'section'        => 'funder_footer',
		'settings'       => 'funder_footer_logo_image',
		'priority'       => 30
	) ) );

	/** Background Color */
	$wp_customize->add_setting( 'funder_footer_background_color', array(
		'default'    => funder_theme_mod( 'footer_background_color' ),
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'funder_footer_background_color', array(
		'label'      => __( 'Background Color', 'funder' ),
		'section'    => 'funder_footer',
		'settings'   => 'funder_footer_background_color',
		'priority'   => 40
	) ) );

	/** Background Image */
	$wp_customize->add_setting( 'funder_footer_background_image', array(
		'default'        => funder_theme_mod( 'footer_background_image' )
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'funder_footer_background_image', array(
		'label'          => __( 'Background Image', 'funder' ),
		'section'        => 'funder_footer',
		'settings'       => 'funder_footer_background_image',
		'priority'       => 50
	) ) );

	$wp_customize->add_setting( 'funder_footer_background_repeat', array(
		'default'        => funder_theme_mod( 'footer_background_repeat' )
	) );

	$wp_customize->add_control( 'funder_footer_background_repeat', array(
		'label'      => __( 'Background Repeat', 'funder' ),
		'section'    => 'funder_footer',
		'type'       => 'radio',
		'choices'    => array(
			'no-repeat'  => __( 'No Repeat', 'funder' ),
			'repeat'     => __( 'Tile', 'funder' ),
			'repeat-x'   => __( 'Tile Horizontally', 'funder' ),
			'repeat-y'   => __( 'Tile Vertically', 'funder' ),
		),
		'priority'       => 60
	) );

	$wp_customize->add_setting( 'funder_footer_background_position', array(
		'default'        => funder_theme_mod( 'footer_background_position' )
	) );

	$wp_customize->add_control( 'funder_footer_background_position', array(
		'label'      => __( 'Background Position', 'funder'  ),
		'section'    => 'funder_footer',
		'type'       => 'radio',
		'choices'    => array(
			'left'       => __( 'Left', 'funder' ),
			'center'     => __( 'Center', 'funder' ),
			'right'      => __( 'Right', 'funder' ),
		),
		'priority'       => 70
	) );
}
add_action( 'customize_register', 'funder_customize_register_footer' );

/**
 * Contact Page Cusomziation
 *
 * @since funder 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function funder_customize_register_contact( $wp_customize ) {
	$wp_customize->add_section( 'funder_contact', array(
		'title'      => __( 'Contact Page', 'funder' ),
		'priority'   => 95,
	) );

	/** Description */
	$wp_customize->add_setting( 'funder_contact_text', array(
		'default'    => funder_theme_mod( 'contact_text' )
	) );

	$wp_customize->add_control( new funder_Customize_Textarea_Control( $wp_customize, 'funder_contact_text', array(
		'label'      => __( 'Hero Text', 'funder' ),
		'section'    => 'funder_contact',
		'settings'   => 'funder_contact_text',
		'type'       => 'textarea',
		'priority'   => 20
	) ) );

	/** Subtitle */
	$wp_customize->add_setting( 'funder_contact_subtitle', array(
		'default'    => funder_theme_mod( 'contact_subtitle' )
	) );

	$wp_customize->add_control( new funder_Customize_Textarea_Control( $wp_customize, 'funder_contact_subtitle', array(
		'label'      => __( 'Page Subtitle', 'funder' ),
		'section'    => 'funder_contact',
		'settings'   => 'funder_contact_subtitle',
		'type'       => 'textarea',
		'priority'   => 25
	) ) );

	/** Address */
	$wp_customize->add_setting( 'funder_contact_address', array(
		'default'    => funder_theme_mod( 'contact_address' )
	) );

	$wp_customize->add_control( new funder_Customize_Textarea_Control( $wp_customize, 'funder_contact_address', array(
		'label'      => __( 'Contact Address', 'funder' ),
		'section'    => 'funder_contact',
		'settings'   => 'funder_contact_address',
		'type'       => 'textarea',
		'priority'   => 30
	) ) );

	/** Map Image */
	$wp_customize->add_setting( 'funder_contact_image', array(
		'default'        => funder_theme_mod( 'contact_image' )
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'funder_contact_image', array(
		'label'          => __( 'Map Image', 'funder' ),
		'section'        => 'funder_contact',
		'settings'       => 'funder_contact_image',
		'priority'       => 40
	) ) );

	do_action( 'funder_customize_contact', $wp_customize );

	return $wp_customize;
}
add_action( 'customize_register', 'funder_customize_register_contact' );

/**
 * Textarea Control
 *
 * Attach the custom textarea control to the `customize_register` action
 * so the WP_Customize_Control class is initiated.
 *
 * @since funder 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function funder_customize_textarea_control( $wp_customize ) {
	/**
	 * Textarea Control
	 *
	 * @since CLoudify 1.0
	 */
	class funder_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() {
	?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="8" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
	<?php
		}
	} 
}
add_action( 'customize_register', 'funder_customize_textarea_control', 1, 1 );

/**
 * Add postMessage support for all default fields, as well
 * as the site title and desceription for the Theme Customizer.
 *
 * @since funder 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function funder_customize_register_transport( $wp_customize ) {
	$transport = array_merge( array( 'blogname' => '', 'blogdescription' => '' ), funder_get_theme_mods() );

	if ( isset ( $transport[ 'funder_hero_style' ] ) )
		unset( $transport[ 'funder_hero_style' ] );

	foreach ( $transport as $key => $default ) {
		$setting = $wp_customize->get_setting( $key );

		if ( ! isset( $setting ) )
			continue;

		$wp_customize->get_setting( $key )->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'funder_customize_register_transport' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since funder 1.0
 */
function funder_customize_preview_js() {
	wp_enqueue_script( 'funder-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20120305.2', true );
}
add_action( 'customize_preview_init', 'funder_customize_preview_js' );

/**
 * Any CSS customizations we make need to be outputted in the document <head>
 *
 * @since funder 1.0
 *
 * @return void
 */
function funder_header_css() {
?>
<?php /*?>	<style>
		.sort-tabs .dropdown .current, 
		.sort-tabs li a:hover, 
		.sort-tabs li a.selected,
		.entry-content a,
		.edd_price_options .backer-count,
		#sidebar .widget-bio .author-bio-links li a,
		.share-link:hover:before,
		a.page-numbers:hover,
		#sidebar .widget ul li a {
			color: <?php echo funder_theme_mod( 'accent_color' ); ?>;
		}

		#home-page-featured h1 span,
		#title-image h1 span,
		.bar span,
		input[type=submit]:not(#searchsubmit),
		.btn-green,
		.entry-content .button:not(.add_media),
		.edd-add-to-cart {
			background: <?php echo funder_theme_mod( 'accent_color' ); ?>;
		}

		#home-page-featured h1 span,
		#title-image h1 span {
			box-shadow: 20px 0 0 <?php echo funder_theme_mod( 'accent_color' ); ?>, -20px 0 0 <?php echo funder_theme_mod( 'accent_color' ); ?>;
		}

		.sort-tabs li a:hover, 
		.sort-tabs li a.selected {
			border-color: <?php echo funder_theme_mod( 'accent_color' ); ?>;
		}

		#footer,
		#footer a,
		#footer h3 {
			color: <?php echo funder_theme_mod( 'footer_text_color' ); ?>;
		}

		#footer input[type=text],
		#footer input[type=email] {
			background-color: <?php echo funder_theme_mod( 'footer_text_color' ); ?>;
		}

		#footer input[type="submit"] {
			background-color: <?php echo funder_theme_mod( 'footer_text_color' ); ?>;
		}
	</style><?php */?>

	<?php /*?><style id="funder-footer-custom-background-css">
		#footer {
			background-color: <?php echo funder_theme_mod( 'footer_background_color' ); ?>;
			<?php if ( funder_theme_mod( 'footer_background_image' ) ) : ?>
			background-image: url(<?php echo esc_url( funder_theme_mod( 'footer_background_image' ) ); ?>);
			background-repeat: <?php echo funder_theme_mod( 'footer_background_repeat' ); ?>;
			background-position-x: <?php echo funder_theme_mod( 'footer_background_position' ); ?>;
			<?php endif; ?>
		}
	</style><?php */?>
<?php
}
add_action( 'wp_head', 'funder_header_css' );