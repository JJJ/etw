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