<?php
/**
 * Self-hosted functionality not to be included on WordPress.com
 *
 * @package Candid
 */


 if( is_admin() ) {
 	// Load Getting Started page and initialize EDD update class
 	require_once( get_template_directory() . '/inc/admin/updater/theme-updater.php' );

 	// TGM Activation class
 	require_once( get_template_directory() . '/inc/admin/tgm/tgm-activation.php' );
 }


/**
 * Load the Typekit class
 */
require_once( get_template_directory() . '/inc/typekit/typekit.php' );


/**
 * Registers additional customizer controls
 */
function array_register_customizer_options( $wp_customize ) {

	// Border Color
	$wp_customize->add_setting( 'candid_customizer_border_color', array(
		'default'           => '#3d4e59',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'candid_customizer_border_color', array(
		'label'    => esc_html__( 'Border Color', 'candid' ),
		'section'  => 'colors',
		'settings' => 'candid_customizer_border_color',
		'priority' => 15
	) ) );


	// Border Width
	$wp_customize->add_setting( 'candid_customizer_border_width', array(
		'default'           => '0',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'candid_sanitize_range',
	) );

	$wp_customize->add_control( 'candid_customizer_border_width', array(
		'type'        => 'range',
		'priority'    => 16,
		'section'     => 'colors',
		'label'       => esc_html__( 'Body Border Width', 'candid' ),
		'priority'    => 10,
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 50,
			'step'  => 1,
			'style' => 'width: 100%',
		),
	) );


	// Body Text Color
	$wp_customize->add_setting( 'candid_customizer_body_text', array(
		'default'           => '#343E47',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'candid_customizer_body_text', array(
		'label'    => esc_html__( 'Body Text Color', 'candid' ),
		'section'  => 'colors',
		'settings' => 'candid_customizer_body_text',
		'priority' => 15
	) ) );


	// Accent Color
	$wp_customize->add_setting( 'candid_customizer_accent_color', array(
		'default'           => '#6BC3F0',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'candid_customizer_accent_color', array(
		'label'    => esc_html__( 'Accent Color', 'candid' ),
		'section'  => 'colors',
		'settings' => 'candid_customizer_accent_color',
		'priority' => 20
	) ) );


	// Button Color
	$wp_customize->add_setting( 'candid_customizer_button_color', array(
		'default'           => '#424a55',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'candid_customizer_button_color', array(
		'label'    => esc_html__( 'Button Color', 'candid' ),
		'section'  => 'colors',
		'settings' => 'candid_customizer_button_color',
		'priority' => 25
	) ) );


	// Custom CSS
	$wp_customize->add_setting( 'candid_customizer_css',
		array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'candid_sanitize_textarea',
			'sanitize_js_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$wp_customize->add_control( 'candid_customizer_css_control', array(
			'label'     => esc_html__( 'Custom CSS', 'candid' ),
			'section'   => 'colors',
			'settings'  => 'candid_customizer_css',
			'type'      => 'textarea',
			'priority'  => 30
		)
	);


	// Footer tagline
	$wp_customize->add_setting( 'candid_customizer_footer_text', array(
		'sanitize_callback' => 'candid_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'candid_customizer_footer_text', array(
			'label'    => esc_html__( 'Footer Tagline', 'candid' ),
			'section'  => 'candid_customizer_basic',
			'settings' => 'candid_customizer_footer_text',
			'type'     => 'text',
			'priority' => 20
		)
	);
}
add_action( 'customize_register', 'array_register_customizer_options' );


/**
 * Add infinite-scroll class if active
 */
function candid_is_class( $classes ) {
	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
		$classes[] = 'infinite-scroll';
	}

	return $classes;
}
add_filter( 'body_class', 'candid_is_class' );


/**
 * Add Customizer CSS To Header
 */
function candid_customizer_css() {
	?>
	<style type="text/css">
		body {
			color: <?php echo get_theme_mod( 'candid_customizer_body_text', '#343E47' ); ?>;
			border-color: <?php echo get_theme_mod( 'candid_customizer_border_color', '#3d4e59' ); ?>;
			border-width: <?php echo get_theme_mod( 'candid_customizer_border_width', '0' ); ?>px;
		}

		.entry-content a {
			border-color: <?php echo get_theme_mod( 'candid_customizer_accent_color', '#6BC3F0' ); ?>;
		}

		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.button,
		.comment-navigation a {
			background: <?php echo get_theme_mod( 'candid_customizer_button_color', '#424a55' ); ?>;
		}

		<?php echo get_theme_mod( 'candid_customizer_css' ); ?>
	</style>
<?php
}
add_action( 'wp_head', 'candid_customizer_css' );


/**
 * Replaces the footer tagline text
 */
function candid_filter_footer_text() {

	// Get the footer copyright text
	$footer_copy_text = get_theme_mod( 'candid_customizer_footer_text' );

	if ( $footer_copy_text ) {
		// If we have footer text, use it
		$footer_text = $footer_copy_text;
	} else {
		// Otherwise show the fallback theme text
		$footer_text = '&copy; ' . date("Y") . sprintf( esc_html__( ' %1$s Theme by %2$s.', 'candid' ), 'Candid', '<a href="https://arraythemes.com/" rel="nofollow">Array</a>' );
	}

	return $footer_text;

}
add_filter( 'candid_footer_text', 'candid_filter_footer_text' );


/**
 * Redirect to Getting Started page on theme activation
 */
function candid_redirect_on_activation() {
	global $pagenow;

	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

		wp_redirect( admin_url( "themes.php?page=candid-license" ) );

	}
}
add_action( 'admin_init', 'candid_redirect_on_activation' );
