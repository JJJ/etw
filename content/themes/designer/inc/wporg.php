<?php
/**
 * Self-hosted functionality not to be included on WordPress.com
 *
 * @package Designer
 */


/**
 * Load the Getting Started page and Theme Update class
 */
if( is_admin() ) {
	// Load Getting Started page and initialize EDD update class
	require_once( get_template_directory() . '/inc/admin/updater/theme-updater.php' );

	// TGM Activation class
	require_once( get_template_directory() . '/inc/admin/tgm/tgm-activation.php' );
}

/**
 * Load the Portfolio widget
 */
require_once( get_template_directory() . '/inc/widgets/portfolio-widget.php' );

/**
 * Registers additional customizer controls
 */
function array_register_customizer_options( $wp_customize ) {

	// Body Text Color
	$wp_customize->add_setting( 'designer_customizer_body_text', array(
		'default'           => '#55626D',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'designer_customizer_body_text', array(
		'label'    => __( 'Body Text Color', 'designer' ),
		'section'  => 'colors',
		'settings' => 'designer_customizer_body_text',
		'priority' => 8
	) ) );

	// Accent Color
	$wp_customize->add_setting( 'designer_customizer_accent', array(
		'default'           => '#3EB6E4',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'designer_customizer_accent', array(
		'label'    => __( 'Accent Color', 'designer' ),
		'section'  => 'colors',
		'settings' => 'designer_customizer_accent',
		'priority' => 9
	) ) );

	// Toggle bar color
	$wp_customize->add_setting( 'designer_customizer_toggle', array(
		'default'           => 'light',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'designer_sanitize_toggle_select',
		'transport'         => 'postMessage'
	) );

	$wp_customize->add_control( 'designer_customizer_toggle_select', array(
		'settings' => 'designer_customizer_toggle',
		'label'    => __( 'Sidebar Toggle Bar Color', 'designer' ),
		'section'  => 'colors',
		'type'     => 'select',
		'choices'  => array(
			'light'  => __( 'Light', 'designer' ),
			'dark'   => __( 'Dark', 'designer' )
		),
		'priority'     => 10
	) );

	// Custom CSS
	$wp_customize->add_setting( 'designer_customizer_css' );

	$wp_customize->add_control(
		new Designer_Customize_Textarea_Control( $wp_customize, 'designer_customizer_css',
			array(
				'label'     => __( 'Custom CSS', 'designer' ),
				'section'   => 'colors',
				'settings'  => 'designer_customizer_css',
				'priority'  => 11
			)
		)
	);
}
add_action( 'customize_register', 'array_register_customizer_options' );

/**
 * Add infinite-scroll class if active
 */
function designer_is_class( $classes ) {
	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
		$classes[] = 'infinite-scroll';
	}

	return $classes;
}
add_filter( 'body_class', 'designer_is_class' );

/**
 * Add Customizer CSS To Header
 */
function designer_customizer_css() {
	?>
	<style type="text/css">
		body {
			color: <?php echo get_theme_mod( 'designer_customizer_body_text', '#55626D' ); ?>;
		}

		.sidebar-toggle:hover .flyout-toggle,
		.bypostauthor .comment-cite:after,
		#comments .fn:before {
			color: <?php echo get_theme_mod( 'designer_customizer_accent', '#3EB6E4' ); ?>;
		}

		.edit-link a,
		.portfolio-column.post .featured-image:hover,
		button:hover,
		input[type="button"]:hover,
		input[type="reset"]:hover,
		input[type="submit"]:hover,
		.button:hover,
		#page #infinite-handle span:hover {
			background: <?php echo get_theme_mod( 'designer_customizer_accent', '#3EB6E4' ); ?>;
		}

		#page .mejs-time-current,
		#page .mejs-horizontal-volume-current {
			background: <?php echo get_theme_mod( 'designer_customizer_accent', '#3EB6E4' ); ?> !important;
		}

		input[type="text"]:focus,
		input[type="email"]:focus,
		input[type="url"]:focus,
		input[type="password"]:focus,
		input[type="search"]:focus,
		textarea:focus,
		.entry-content p a:hover {
			border-color: <?php echo get_theme_mod( 'designer_customizer_accent', '#3EB6E4' ); ?>
		}

		<?php echo get_theme_mod( 'designer_customizer_css' ); ?>
	</style>
<?php
}
add_action( 'wp_head', 'designer_customizer_css' );
