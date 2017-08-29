<?php
/**
 * Candid Theme Customizer
 *
 * Customizer color options can be found in inc/wporg.php.
 *
 * @package Candid
 */

add_action( 'customize_register', 'candid_customizer_register' );

if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;


/**
 * Sanitize range slider
 */
function candid_sanitize_range( $input ) {
	filter_var( $input, FILTER_FLAG_ALLOW_FRACTION );
	return ( $input );
}


/**
 * Sanitize gallery select option
 */
function candid_sanitize_gallery_select( $layout ) {

	if ( ! in_array( $layout, array( 'portfolio-grid-large', 'portfolio-grid-medium', 'portfolio-grid-small' ) ) ) {
		$layout = 'portfolio-grid-medium';
	}
	return $layout;
}


/**
 * Sanitize title select option
 */
function candid_sanitize_title_select( $title ) {

	if ( ! in_array( $title, array( 'show', 'hover' ) ) ) {
		$title = 'hover';
	}
	return $title;
}


/**
 * Sanitize text
 */
function candid_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}


/**
 * Sanitize textarea output
 */
function candid_sanitize_textarea( $text ) {
    return esc_textarea( $text );
}


/**
 * @param WP_Customize_Manager $wp_customize
 */
function candid_customizer_register( $wp_customize ) {

	// Theme Options
	$wp_customize->add_section( 'candid_customizer_basic', array(
		'title'    => esc_html__( 'Theme Options', 'candid' ),
		'priority' => 1
	) );


	// Logo and header text options - only show if Site Logos is not supported
	if ( ! function_exists( 'jetpack_the_site_logo' ) ) {
		$wp_customize->add_setting( 'candid_customizer_logo', array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'candid_sanitize_text'
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'candid_customizer_logo', array(
			'label'    => esc_html__( 'Logo Upload', 'candid' ),
			'section'  => 'title_tagline',
			'settings' => 'candid_customizer_logo',
		) ) );
	}


	// Homepage Intro Title
	$wp_customize->add_setting( 'candid_customizer_homepage_title', array(
		'sanitize_callback' => 'candid_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'candid_customizer_homepage_title', array(
			'label'    => esc_html__( 'Homepage Intro Title', 'candid' ),
			'section'  => 'candid_customizer_basic',
			'settings' => 'candid_customizer_homepage_title',
			'type'     => 'text',
			'priority' => 1
		)
	);


	// Homepage Intro Text
	$wp_customize->add_setting( 'candid_customizer_homepage_text',
		array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'candid_sanitize_textarea',
			'sanitize_js_callback' => 'wp_filter_nohtml_kses',
			'transport'            => 'postMessage',
		)
	);

	$wp_customize->add_control( 'candid_customizer_homepage_text_control', array(
			'label'     => esc_html__( 'Homepage Intro Text', 'candid' ),
			'section'   => 'candid_customizer_basic',
			'settings'  => 'candid_customizer_homepage_text',
			'type'      => 'textarea',
			'priority'  => 2
		)
	);


	// Grid Layout
	$wp_customize->add_setting( 'candid_customizer_gallery_style', array(
		'default'           => 'portfolio-grid-medium',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'candid_sanitize_gallery_select',

	));

	$wp_customize->add_control( 'candid_customizer_gallery_select', array(
		'settings' => 'candid_customizer_gallery_style',
		'label'    => esc_html__( 'Grid Layout', 'candid' ),
		'section'  => 'candid_customizer_basic',
		'type'     => 'select',
		'choices'  => array(
			'portfolio-grid-large'  => esc_html__( 'One Column', 'candid' ),
			'portfolio-grid-medium' => esc_html__( 'Two Column', 'candid' ),
			'portfolio-grid-small'  => esc_html__( 'Three Column', 'candid' ),
		),
		'priority' => 3
	) );


	// Always show titles
	$wp_customize->add_setting( 'candid_customizer_show_titles', array(
		'default'           => 'hide',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'candid_sanitize_title_select',
	));

	$wp_customize->add_control( 'candid_customizer_title_select', array(
		'settings' => 'candid_customizer_show_titles',
		'label'    => esc_html__( 'Grid Post Titles', 'candid' ),
		'section'  => 'candid_customizer_basic',
		'type'     => 'select',
		'choices'  => array(
			'hover' => esc_html__( 'Show on hover', 'candid' ),
			'show'  => esc_html__( 'Always show', 'candid' ),
		),
		'priority' => 5
	) );
}


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function candid_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'candid_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function candid_customize_preview_js() {
	wp_enqueue_script( 'candid_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20150726', true );
}
add_action( 'customize_preview_init', 'candid_customize_preview_js' );
