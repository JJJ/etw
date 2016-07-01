<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_Admin_NoticeInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_Admin_NoticeInterface ) {
	return;
}

global $wp_version;

// Notice of unsupported WordPress version
if ( version_compare( $wp_version, TTFMAKE_MIN_WP_VERSION, '<' ) ) {
	$this->register_admin_notice(
		'make-wp-lt-min-version-' . TTFMAKE_MIN_WP_VERSION,
		sprintf(
			__( 'Make requires version %1$s of WordPress or higher. Your current version is %2$s. Please <a href="%3$s">update WordPress</a> to ensure full compatibility.', 'make' ),
			TTFMAKE_MIN_WP_VERSION,
			esc_html( $wp_version ),
			admin_url( 'update-core.php' )
		),
		array(
			'cap'     => 'update_core',
			'dismiss' => false,
			'screen'  => array( 'dashboard', 'themes', 'update-core.php' ),
			'type'    => 'error',
		)
	);
}

// Notice of upcoming drop of support for 4.2
if ( version_compare( $wp_version, '4.2', '<=' ) ) {
	$this->register_admin_notice(
		'make-wp-lte-42',
		sprintf(
			__( 'Make will soon be dropping support for WordPress version 4.2. Your current version is %1$s. Please <a href="%2$s">update WordPress</a> to ensure full compatibility.', 'make' ),
			esc_html( $wp_version ),
			admin_url( 'update-core.php' )
		),
		array(
			'cap'     => 'update_core',
			'dismiss' => true,
			'screen'  => array( 'dashboard', 'themes', 'update-core.php' ),
			'type'    => 'warning',
		)
	);
}

// Help notices
$this->register_admin_notice(
	'make-page-builder-welcome',
	sprintf(
		__( 'Welcome to the page builder. Learn to <a href="%s" target="_blank">add, edit and arrange sections</a>.', 'make' ),
		'https://thethemefoundry.com/docs/make-docs/page-builder/managing-sections/'
	),
	array(
		'cap'     => 'edit_pages',
		'dismiss' => true,
		'screen'  => array( 'page' ),
		'type'    => 'info',
	)
);
$this->register_admin_notice(
	'make-themes-child-theme-intro',
	sprintf(
		__( 'Looking to take Make even further? Learn to <a href="%1$s" target="_blank">install a child theme</a> and <a href="%2$s" target="_blank">apply custom code</a>.', 'make' ),
		'https://thethemefoundry.com/docs/make-docs/code/installing-child-theme/',
		'https://thethemefoundry.com/docs/make-docs/code/custom-css/'
	),
	array(
		'cap'     => 'switch_themes',
		'dismiss' => true,
		'screen'  => array( 'theme-editor' ),
		'type'    => 'info',
	)
);
$this->register_admin_notice(
	'make-dashboard-simple-start',
	sprintf(
		__( 'Welcome to Make. Learn all there is to getting started with our <a href="%s" target="_blank">Simple Start Handbook</a>.', 'make' ),
		'https://thethemefoundry.com/docs/make-docs/simple-start-handbook/'
	),
	array(
		'cap'     => 'edit_pages',
		'dismiss' => true,
		'screen'  => array( 'dashboard' ),
		'type'    => 'info',
	)
);
$this->register_admin_notice(
	'make-plugins-integrations',
	sprintf(
		__( 'So you’re looking for more. Did you know Make has custom integrations with <a href="%1$s" target="_blank">WooCommerce</a>, <a href="%2$s" target="_blank">Easy Digital Downloads</a>, and <a href="%3$s" target="_blank">Yoast SEO</a>?', 'make' ),
		'https://thethemefoundry.com/docs/make-docs/integrations/woocommerce/',
		'https://thethemefoundry.com/docs/make-docs/integrations/easy-digital-downloads/',
		'https://thethemefoundry.com/docs/make-docs/integrations/yoast-seo/'
	),
	array(
		'cap'     => 'install_plugins',
		'dismiss' => true,
		'screen'  => array( 'plugins' ),
		'type'    => 'info',
	)
);