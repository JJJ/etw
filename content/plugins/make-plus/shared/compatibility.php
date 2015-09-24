<?php
/**
 * @package Make Plus
 */

/**
 * Add notices to the Admin screens.
 *
 * @since 1.6.0.
 *
 * @return void
 */
function ttfmp_add_admin_notices() {
	global $wp_version;

	if ( version_compare( $wp_version, TTFMP_APP::MIN_WP_VERSION, '<' ) ) {
		ttfmp_register_admin_notice(
			'ttfmp-wp-lt-min-version',
			sprintf(
				// Translators: %1$s is a placeholder for the WordPress version. %2$s is a placeholder for a link to the update screen.
				__( 'Make Plus requires version %1$s of WordPress or higher. Please %2$s to ensure full compatibility.', 'make-plus' ),
				TTFMP_APP::MIN_WP_VERSION,
				sprintf(
					'<a href="%1$s">%2$s</a>',
					esc_url( admin_url( 'update-core.php' ) ),
					__( 'update WordPress', 'make-plus' )
				)
			),
			array(
				'cap'     => 'update_core',
				'dismiss' => false,
				'screen'  => array( 'dashboard', 'plugins.php', 'update-core.php' ),
				'type'    => 'error',
			)
		);
	}

	// Notice of upcoming drop of support for 4.0 and 4.1
	if ( version_compare( $wp_version, '4.2', '<' ) ) {
		ttfmp_register_admin_notice(
			'ttfmp-wp-lt-42',
			sprintf(
				__( 'Make Plus will soon be dropping support for WordPress versions 4.0 and 4.1. Please %2$s to ensure full compatibility.', 'make-plus' ),
				TTFMAKE_MIN_WP_VERSION,
				sprintf(
					'<a href="%1$s">%2$s</a>',
					admin_url( 'update-core.php' ),
					__( 'update WordPress', 'make-plus' )
				)
			),
			array(
				'cap'     => 'update_core',
				'dismiss' => true,
				'screen'  => array( 'dashboard', 'themes.php', 'update-core.php' ),
				'type'    => 'warning',
			)
		);
	}

	if ( true === ttfmp_get_app()->passive ) {
		ttfmp_register_admin_notice(
			'ttfmp-make-inactive',
			__( 'The Make Plus plugin was designed to work with the Make theme. To enjoy full use of the plugin, please install and activate Make.', 'make-plus' ),
			array(
				'cap'     => 'switch_themes',
				'dismiss' => true,
				'screen'  => array( 'dashboard', 'themes.php', 'plugins.php' ),
				'type'    => 'warning',
			)
		);
	}
}

add_action( 'admin_init', 'ttfmp_add_admin_notices' );