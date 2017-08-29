<?php
/**
 * Camera Theme Customizer
 *
 * Customizer color options can be found in inc/wporg.php.
 *
 * @package Camera
 */

if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;

/**
 * Sanitize text
 */
function camera_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Sanitize checkbox
 */
function camera_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return '';
	}
}

/**
 * Sanitize color scheme
 */
function camera_sanitize_scheme_select( $input ) {
	$valid = array(
		'light' => __( 'Light', 'camera' ),
		'dark'  => __( 'Dark', 'camera' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function camera_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';

	/**
	 * @param WP_Customize_Manager $wp_customize
	 */

	/**
	 * Theme options. More options for self-hosted users can be found in wporg.php.
	 */

	$wp_customize->add_section( 'camera_customizer_basic', array(
		'title'    => __( 'Theme', 'camera' ),
		'priority' => 1
	) );

	// Show avatar
	$wp_customize->add_setting( 'camera_show_avatar', array(
		'default'           => '1',
		'sanitize_callback' => 'camera_sanitize_checkbox',
		'transport'         => 'postMessage'
	) );

	$wp_customize->add_control( 'camera_show_avatar', array(
		'type'        => 'checkbox',
		'label'       => __( 'Display Avatar With Site Title', 'camera' ),
		'description' => __( '(Has no effect when you have a logo enabled.)', 'camera' ),
		'section'     => 'title_tagline'
	) );

	$wp_customize->add_setting( 'camera_color_scheme', array(
		'default'           => 'light',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'camera_sanitize_scheme_select'
	));

	$wp_customize->add_control( 'camera_color_scheme_select', array(
		'settings' => 'camera_color_scheme',
		'label'    => __( 'Color Scheme', 'camera' ),
		'section'  => 'colors',
		'type'     => 'select',
		'choices'  => array(
			'light' => __( 'Light', 'camera' ),
			'dark'  => __( 'Dark', 'camera' ),
		),
	) );
}
add_action( 'customize_register', 'camera_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function camera_customize_preview_js() {
	wp_enqueue_script( 'camera_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20141020', true );
}
add_action( 'customize_preview_init', 'camera_customize_preview_js' );
