<?php
/**
 * WordPress.com-specific functions and definitions
 * This file is centrally included from `wp-content/mu-plugins/wpcom-theme-compat.php`.
 *
 * @package Publisher
 */

/**
 * Theme Colors for WordPress.com
 */
if ( ! isset( $themecolors ) ) {
	$themecolors = array(
		'bg'     => 'f7f7f7',
		'border' => 'eeeeee',
		'text'   => '5F646D',
		'link'   => '469AF6',
		'url'    => '469AF6',
	);
}


/**
 * Add wpcom class to body if we're on WordPress.com
 */
function publisher_body_class( $classes ) {
	$classes[] = 'wpcom';
	return $classes;
}
add_filter( 'body_class', 'publisher_body_class' );


/**
 * Adds the required text to the footer for WordPress.com
 */
function publisher_filter_footer_text() {

	$output = '<a href="http://wordpress.org/" title="' . esc_attr( 'A Semantic Personal Publishing Platform', 'publisher' ) .'" rel="generator">' . sprintf( __( 'Proudly powered by %s', 'publisher' ), 'WordPress' ). '</a>';
	$output .= '<span class="sep"> | </span>';
	$output .= sprintf( __( 'Theme: %1$s by %2$s.', 'publisher' ), 'publisher', '<a href="https://array.is/" rel="designer">Array</a>' );
	return $output;
}
add_filter( 'publisher_footer_text', 'publisher_filter_footer_text' );
