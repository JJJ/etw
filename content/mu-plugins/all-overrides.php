<?php

/**
 * Plugin name: Flox - Simple Overrides
 * Description: Little Tweaks for Lots of Things
 * Author:      John James Jacoby
 * Author URI:  http://jjj.me
 * Version:     1.0.0
 */

// WordPress or bust
defined( 'ABSPATH' ) || exit();

// Activity Humility
add_filter( 'wp_user_activity_menu_humility', '__return_true' );

// Themes
add_action( 'init', function() {
	remove_action( 'barletta_footer', 'barletta_footer_credits' );
} );

/**
 * Footer credits
 */
function etw_footer_credits() {
        ?>
        <div class="site-info">
        <?php if (get_theme_mod('barletta_footer_text') == '') { ?>
        &copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?><?php esc_html_e('. All rights reserved.', 'barletta'); ?>
        <?php } else { echo esc_html( get_theme_mod( 'barletta_footer_text', 'barletta' ) ); } ?>
        </div><!-- .site-info -->

        <?php
}
add_action( 'barletta_footer', 'etw_footer_credits' );

/**
 * Map `unfiltered_html` capability
 *
 * @param array  $caps
 * @param string $cap
 */
function etw_map_meta_cap( $caps = array(), $cap = '' ) {

	// Map to 'manage_options'
	if ( 'unfiltered_html' === $cap ) {
		$caps = array( 'manage_options' );
	}

	// Return maybe-mapped caps
	return $caps;
}
add_filter( 'map_meta_cap', 'etw_map_meta_cap', 10, 2 );
