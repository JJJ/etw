<?php
/**
 * Atomic Theme Customizer
 *
 * @package Atomic
 */

add_action( 'customize_register', 'atomic_register' );

if ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX && ! is_customize_preview() ) {
	return;
}


/**
 * Sanitize range slider
 */
function atomic_sanitize_range( $input ) {
	filter_var( $input, FILTER_FLAG_ALLOW_FRACTION );
	return ( $input );
}


/**
 * Sanitize text
 */
function atomic_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}


/**
 * Sanitize checkbox
 */
function atomic_sanitize_checkbox( $input ) {
	return ( 1 == $input ) ? 1 : '';
}


/**
 * Return whether we're previewing the front page and it's a static page.
 */
function atomic_is_static_front_page() {
	return ( is_page_template( 'templates/template-homepage.php' ) || is_front_page() );
}


/**
 * Jetpack callback
 */
function atomic_jetpack_callback( $control ) {
	if ( class_exists( 'Jetpack' ) ) {
		return true;
	} else {
		return false;
	}
}


/**
 * @param WP_Customize_Manager $wp_customize
 */
function atomic_register( $wp_customize ) {

	/**
	 * Inlcude the Alpha Color Picker
	 */
	require_once( get_template_directory() . '/inc/admin/alpha-color-picker/alpha-color-picker.php' );

	/**
	 * Theme Options Panel
	 */
	$wp_customize->add_panel( 'atomic_theme_options_panel', array(
		'priority'   => 5,
		'capability' => 'edit_theme_options',
		'title'      => esc_html__( 'Theme Options', 'atomic' ),
	) );

	/**
	 * General Settings Panel
	 */
	$wp_customize->add_section( 'atomic_theme_options', array(
		'priority'   => 1,
		'capability' => 'edit_theme_options',
		'title'      => esc_html__( 'General Settings', 'atomic' ),
		'panel'      => 'atomic_theme_options_panel',
	) );

	/**
	 * Accent Color
	 */
	$wp_customize->add_setting( 'atomic_button_color', array(
		'default'           => '#1d96f3',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'atomic_button_color', array(
		'label'       => esc_html__( 'Accent Color', 'atomic' ),
		'section'     => 'colors',
		'settings'    => 'atomic_button_color',
		'description' => esc_html__( 'Change the accent color of buttons and various typographical elements.', 'atomic' ),
		'priority'    => 5
	) ) );


	/**
	 * Footer Tagline
	 */
	$wp_customize->add_setting( 'atomic_footer_text', array(
		'sanitize_callback' => 'atomic_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'atomic_footer_text', array(
			'label'       => esc_html__( 'Footer Tagline', 'atomic' ),
			'section'     => 'atomic_theme_options',
			'settings'    => 'atomic_footer_text',
			'description' => esc_html__( 'Change the text that appears in the footer tagline at the bottom of your site.', 'atomic' ),
			'type'        => 'text',
			'priority'    => 300
		)
	);

	$wp_customize->selective_refresh->add_partial( 'atomic_footer_text', array(
        'selector' => '.site-info',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'atomic_footer_text' );
        },
    ) );


	/**
	 * Homepage Header Title
	 */
	$wp_customize->add_setting( 'atomic_header_title', array(
		'sanitize_callback' => 'atomic_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'atomic_header_title', array(
			'label'       => esc_html__( 'Header Title', 'atomic' ),
			'section'     => 'atomic_theme_options',
			'settings'    => 'atomic_header_title',
			'description' => esc_html__( 'Add a title to the homepage header area.', 'atomic' ),
			'type'        => 'text',
			'priority'    => 10
		)
	);

	$wp_customize->selective_refresh->add_partial( 'atomic_header_title', array(
        'selector' => '.header-text h2',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'atomic_header_title' );
        },
    ) );


	/**
	 * Homepage Header Subtitle
	 */
	$wp_customize->add_setting( 'atomic_header_subtitle', array(
		'sanitize_callback' => 'atomic_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'atomic_header_subtitle', array(
			'label'       => esc_html__( 'Header Subtitle', 'atomic' ),
			'section'     => 'atomic_theme_options',
			'settings'    => 'atomic_header_subtitle',
			'description' => esc_html__( 'Add a subtitle to the homepage header area.', 'atomic' ),
			'type'        => 'text',
			'priority'    => 20
		)
	);

	$wp_customize->selective_refresh->add_partial( 'atomic_header_subtitle', array(
        'selector' => '.header-text p',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'atomic_header_subtitle' );
        },
    ) );


	/**
	 * Header Height
	 */
	$wp_customize->add_setting( 'atomic_header_height', array(
		'default'           => '0',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'atomic_sanitize_range',
	) );

	$wp_customize->add_control( 'atomic_header_height', array(
		'type'            => 'range',
		'priority'        => 30,
		'section'         => 'header_image',
		'label'           => esc_html__( 'Homepage Header Height', 'atomic' ),
		'description'     => esc_html__( 'Adjust the height of the homepage header title area.', 'atomic' ),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 15,
			'step'  => .25,
			'style' => 'width: 100%',
		),
	) );


	/**
	 * Header Background Opacity Range
	 */
	$wp_customize->add_setting( 'atomic_bg_opacity', array(
		'default'           => '1',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'atomic_sanitize_range',
	) );

	$wp_customize->add_control( 'atomic_bg_opacity', array(
		'type'        => 'range',
		'priority'    => 40,
		'section'     => 'header_image',
		'label'       => __( 'Header Image Opacity', 'atomic' ),
		'description' => 'Change the opacity of your header image.',
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 1,
			'step'  => .05,
			'style' => 'width: 100%',
		),
	) );


	/**
	 * Header Background Color
	 */
	$wp_customize->add_setting( 'atomic_header_bg_color', array(
		'default'           => '#27343b',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'atomic_header_bg_color', array(
		'label'       => esc_html__( 'Header Background Color', 'atomic' ),
		'section'     => 'header_image',
		'settings'    => 'atomic_header_bg_color',
		'description' => esc_html__( 'Change the background color of the header. Lower the Header Image Opacity setting to see the background color.', 'atomic' ),
		'priority'    => 50
	) ) );


	/**
	 * Front Page Panel
	 */
	$wp_customize->add_section( 'atomic_front_page', array(
		'priority'   => 5,
		'capability' => 'edit_theme_options',
		'title'      => esc_html__( 'Front Page', 'atomic' ),
		'panel'      => 'atomic_theme_options_panel',
	) );


	/**
	 * Filter number of front page sections
	 */
	$num_sections = apply_filters( 'atomic_front_page_sections', 6 );

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		$wp_customize->add_setting( 'panel_' . $i, array(
			'default'           => false,
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( 'panel_' . $i, array(
			/* translators: %d is the front page section number */
			'label'           => sprintf( __( 'Front Page Section %d Content', 'atomic' ), $i ),
			'description'     => ( 1 !== $i ? '' : __( 'Select pages to feature in each area of the Homepage template from the dropdowns below. Empty sections will not be displayed.', 'atomic' ) ),
			'section'         => 'atomic_front_page',
			'type'            => 'dropdown-pages',
			'allow_addition'  => true,
			'priority'        => 10,
		) );

		$wp_customize->selective_refresh->add_partial( 'panel_' . $i, array(
			'selector'            => '#panel' . $i,
			'render_callback'     => 'atomic_front_page_section',
			'container_inclusive' => true,
		) );
	}


	/**
	 * Homepage Portfolio Count
	 */
	$wp_customize->add_setting( 'atomic_home_portfolio_count', array(
		'default'           => '4',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control( 'atomic_home_portfolio_count_select', array(
		'settings'        => 'atomic_home_portfolio_count',
		'label'           => esc_html__( 'Number of portfolio items to show:', 'atomic' ),
		'section'         => 'atomic_front_page',
		'type'            => 'select',
		'priority'        => 20,
		'active_callback' => 'atomic_jetpack_callback',
		'choices'         => array(
			'1'  => '1',
			'2'  => '2',
			'3'  => '3',
			'4'  => '4',
			'5'  => '5',
			'6'  => '6',
			'7'  => '7',
			'8'  => '8',
			'9'  => '9',
			'10' => '10',
		),
	));


	/**
	 * Homepage Testimonial Count
	 */
	$wp_customize->add_setting( 'atomic_home_testimonial_count', array(
		'default'           => '4',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control( 'atomic_home_testimonial_count_select', array(
		'settings'        => 'atomic_home_testimonial_count',
		'label'           => esc_html__( 'Number of testimonials to show:', 'atomic' ),
		'section'         => 'atomic_front_page',
		'type'            => 'select',
		'priority'        => 30,
		'active_callback' => 'atomic_jetpack_callback',
		'choices'         => array(
			'1'  => '1',
			'2'  => '2',
			'3'  => '3',
			'4'  => '4',
			'5'  => '5',
			'6'  => '6',
			'7'  => '7',
			'8'  => '8',
			'9'  => '9',
			'10' => '10',
		),
	));


	/**
	 * Homepage Blog Count
	 */
	$wp_customize->add_setting( 'atomic_home_blog_count', array(
		'default'           => '4',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control( 'atomic_home_blog_count_select', array(
		'settings'        => 'atomic_home_blog_count',
		'label'           => esc_html__( 'Number of blog posts to show:', 'atomic' ),
		'section'         => 'atomic_front_page',
		'type'            => 'select',
		'priority'        => 40,
		'choices'         => array(
			'1'  => '1',
			'2'  => '2',
			'3'  => '3',
			'4'  => '4',
			'5'  => '5',
			'6'  => '6',
			'7'  => '7',
			'8'  => '8',
			'9'  => '9',
			'10' => '10',
		),
	));


	/**
	 * Homepage Services Count
	 */
	$wp_customize->add_setting( 'atomic_home_services_count', array(
		'default'           => '9',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control( 'atomic_home_services_count_select', array(
		'settings'        => 'atomic_home_services_count',
		'label'           => esc_html__( 'Number of services to show:', 'atomic' ),
		'section'         => 'atomic_front_page',
		'type'            => 'select',
		'priority'        => 50,
		'choices'         => array(
			'99'  => esc_html__( 'Show All', 'atomic' ),
			'1'  => '1',
			'2'  => '2',
			'3'  => '3',
			'4'  => '4',
			'5'  => '5',
			'6'  => '6',
			'7'  => '7',
			'8'  => '8',
			'9'  => '9',
			'10' => '10',
		),
	));


	/**
	 * Homepage Team Count
	 */
	$wp_customize->add_setting( 'atomic_home_team_count', array(
		'default'           => '9',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control( 'atomic_home_team_count_select', array(
		'settings'        => 'atomic_home_team_count',
		'label'           => esc_html__( 'Number of team members to show:', 'atomic' ),
		'section'         => 'atomic_front_page',
		'type'            => 'select',
		'priority'        => 60,
		'choices'         => array(
			'99'  => esc_html__( 'Show All', 'atomic' ),
			'1'  => '1',
			'2'  => '2',
			'3'  => '3',
			'4'  => '4',
			'5'  => '5',
			'6'  => '6',
			'7'  => '7',
			'8'  => '8',
			'9'  => '9',
		),
	));

}


/**
 * Adjust header height based on theme option
 */
function atomic_css_output() {
	// Theme Options
	$accent_color  = esc_html( get_theme_mod( 'atomic_button_color', '#1d96f3' ) );

	// Header settings
	$hero_height   = esc_html( get_theme_mod( 'atomic_header_height', '5' ) );
	$hero_bg_color = esc_html( get_theme_mod( 'atomic_header_bg_color', '#272c30' ) );
	$hero_opacity  = esc_html( get_theme_mod( 'atomic_hero_opacity', '.3' ) );

	// Check for styles before outputting
	if ( $accent_color || $hero_height || $hero_bg_color || $hero_opacity ) {

	wp_enqueue_style( 'atomic-style', get_stylesheet_uri() );

	$atomic_custom_css = "

	button, input[type='button'],
	input[type='reset'],
	input[type='submit'],
	.button,
	#page #infinite-handle button,
	#page #infinite-handle button:hover,
	.comment-navigation a,
	.drawer .tax-widget a,
	.su-button,
	h3.comments-title,
	.page-numbers.current,
	.page-numbers:hover,
	.woocommerce nav.woocommerce-pagination ul li span.current,
	.woocommerce nav.woocommerce-pagination ul li span:hover,
	.woocommerce nav.woocommerce-pagination ul li a:hover,
	a.added_to_cart,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
	.woocommerce button.button.alt,
	.woocommerce button.button.alt:hover,
	.woocommerce button.button,
	.woocommerce button.button:hover,
	.woocommerce a.button.atomic,
	.woocommerce-cart .wc-proceed-to-atomic a.atomic-button,
	.woocommerce-cart .wc-proceed-to-atomic a.atomic-button:hover,
	.woocommerce input.button.alt,
	.woocommerce input.button.alt:hover {
	      background-color: $accent_color;
	}

	.home .home-nav .active, .home .home-nav .active:hover {
		border-bottom-color: $accent_color;
	}

	li.is-active:before,
	li:hover:before,
	.entry-content p a:hover,
	.post-navigation a:hover .post-title {
		color: $accent_color;
	}

	.entry-content p a:hover {
		box-shadow: inset 0 -2px 0 $accent_color;
	}

	.site-header {
		background: $hero_bg_color;
	}

	.cover-image {
		opacity: $hero_opacity;
	}

	@media only screen and (min-width:1000px) {
		.header-text {
			padding-top: $hero_height%;
			padding-bottom: $hero_height%;
		}
	}

	";
	wp_add_inline_style( 'atomic-style', $atomic_custom_css );
} }
add_action( 'wp_enqueue_scripts', 'atomic_css_output' );


/**
 * Replaces the footer tagline text
 */
function atomic_filter_footer_text() {

	// Get the footer copyright text
	$footer_copy_text = get_theme_mod( 'atomic_footer_text' );

	if ( $footer_copy_text ) {
		// If we have footer text, use it
		$footer_text = $footer_copy_text;
	} else {
		// Otherwise show the fallback theme text
		$footer_text = '&copy; ' . date("Y") . sprintf( esc_html__( ' %1$s Theme by %2$s.', 'atomic' ), 'Atomic', '<a href="https://arraythemes.com/" rel="nofollow">Array</a>' );
	}

	return $footer_text;

}
add_filter( 'atomic_footer_text', 'atomic_filter_footer_text' );


/**
 * Add postMessage support and selective refresh for site title and description.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function atomic_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'header_site_title', array(
        'selector' => '.site-title a',
        'settings' => array( 'blogname' ),
        'render_callback' => function() {
            return get_bloginfo( 'name', 'display' );
        },
    ) );

	$wp_customize->selective_refresh->add_partial( 'header_site_description', array(
        'selector' => '.site-description',
        'settings' => array( 'blogdescription' ),
        'render_callback' => function() {
            return get_bloginfo( 'description', 'display' );
        },
    ) );
}
add_action( 'customize_register', 'atomic_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function atomic_customize_preview_js() {
	wp_enqueue_script( 'atomic_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20170228', true );
}
add_action( 'customize_preview_init', 'atomic_customize_preview_js' );
