<?php
/**
 * WordPress.com-specific functions and definitions
 * This file is centrally included from `wp-content/mu-plugins/wpcom-theme-compat.php`.
 *
 * @package Ampersand
 */

/*
 * De-queue Google fonts if custom fonts are being used instead.
 */
function ampersand_dequeue_fonts() {
	if ( class_exists( 'TypekitData' ) && class_exists( 'CustomDesign' ) && CustomDesign::is_upgrade_active() ) {
		$customfonts = TypekitData::get( 'families' );

		if ( $customfonts['site-title']['id'] && $customfonts['headings']['id'] && $customfonts['body-text']['id'] )
			wp_dequeue_style( 'ampersand-roboto' );
	}
}
add_action( 'wp_enqueue_scripts', 'ampersand_dequeue_fonts' );

/**
 * Adds support for wp.com-specific theme functions
 */
function ampersand_add_wpcom_support() {
	global $themecolors;

	if ( ! isset( $themecolors ) ) {

		// Set a default theme color array.
		$themecolors = array(
			'bg'     => 'ffffff',
			'border' => 'ffffff',
			'text'   => '6B747A',
			'link'   => '33B26E',
			'url'    => '33B26E',
		);

	}

	// Add print stylesheet.
	add_theme_support( 'print-style' );
}
add_action( 'after_setup_theme', 'ampersand_add_wpcom_support' );

/**
 * Enqueue wp.com-specific styles
 */
function ampersand_wpcom_styles() {
	wp_enqueue_style( 'ampersand-wpcom', get_template_directory_uri() . '/inc/style-wpcom.css', '20131011' );
}
add_action( 'wp_enqueue_scripts', 'ampersand_wpcom_styles' );

/**
 * Add wpcom class to body if we're on WordPress.com
 */
function ampersand_body_class( $classes ) {
	$classes[] = 'wpcom';
	return $classes;
}
add_filter( 'body_class', 'ampersand_body_class' );

/**
 * Adds the required text to the footer for WordPress.com
 */
function ampersand_filter_footer_text() {

	$output = '<a href="http://wordpress.org/" title="' . esc_attr( 'A Semantic Personal Publishing Platform', 'ampersand' ) .'" rel="generator">' . sprintf( __( 'Proudly powered by %s', 'ampersand' ), 'WordPress' ). '</a>';
	$output .= '<span class="sep"> | </span>';
	$output .= sprintf( __( 'Theme: %1$s by %2$s.', 'ampersand' ), 'Ampersand', '<a href="https://array.is/" rel="designer">Array</a>' );
	return $output;
}
add_filter( 'ampersand_footer_text', 'ampersand_filter_footer_text' );
