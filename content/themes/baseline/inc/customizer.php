<?php
/**
 * Baseline Theme Customizer
 *
 * Customizer color options can be found in inc/wporg.php.
 *
 * @package Baseline
 */

add_action( 'customize_register', 'baseline_customizer_register' );

if ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX && ! is_customize_preview() ) {
	return;
}

/**
 * Sanitize range slider
 */
function baseline_sanitize_range( $input ) {
	filter_var( $input, FILTER_FLAG_ALLOW_FRACTION );
	return ( $input );
}


/**
 * Sanitize gallery select option
 */
function baseline_sanitize_layout_select( $layout ) {
	if ( ! in_array( $layout, array( 'one-column', 'two-column', 'three-column' ) ) ) {
		$layout = 'one-column';
	}
	return $layout;
}

/**
 * Sanitize font select option
 */
function baseline_sanitize_font_select( $font ) {
	if ( ! in_array( $font, array( 'serif', 'sans-serif' ) ) ) {
		$font = 'sans-serif';
	}
	return $font;
}


/**
 * Sanitize excerpt select option
 */
function baseline_sanitize_excerpt_select( $excerpt_select ) {
	if ( ! in_array( $excerpt_select, array( 'disabled', 'enabled' ) ) ) {
		$excerpt_select = 'disabled';
	}
	return $excerpt_select;
}


/**
 * Sanitize text
 */
function baseline_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}


/**
 * Sanitize checkboux
 */
function baseline_sanitize_checkbox( $input ) {
	return ( 1 == $input ) ? 1 : '';
}


function baseline_homepage_full_callback( $control ) {
    if ( $control->manager->get_setting('baseline_customizer_post_style')->value() == 'one-column' ) {
        return true;
    } else {
        return false;
    }
}


function baseline_homepage_grid_callback( $control ) {
    if ( $control->manager->get_setting('baseline_customizer_post_style')->value() == 'two-column' ) {
        return true;
    } else {
        return false;
    }
}


function baseline_excerpt_callback( $control ) {
    $excerpt_setting = $control->manager->get_setting('baseline_customizer_post_style')->value();
    $control_id = $control->id;

    if ( $control_id == 'baseline_excerpt_length'  && $excerpt_setting == 'two-column' ) return true;
    if ( $control_id == 'baseline_excerpt_length'  && $excerpt_setting == 'three-column' ) return true;

    return false;
}


function baseline_auto_excerpt_callback( $control ) {
    $excerpt_setting = $control->manager->get_setting('baseline_customizer_post_style')->value();
    $control_id = $control->id;

    if ( $excerpt_setting == 'one-column' ) return true;

    return false;
}


function baseline_drawer_callback( $control ) {
    $excerpt_setting = $control->manager->get_setting('baseline_browse_drawer')->value();
    $control_id = $control->id;

    if ( $excerpt_setting == 'enabled' ) return true;

    return false;
}

/**
 * @param WP_Customize_Manager $wp_customize
 */
function baseline_customizer_register( $wp_customize ) {

	// Theme Options
	$wp_customize->add_section( 'baseline_theme_options', array(
		'title'    => esc_html__( 'Theme Options', 'baseline' ),
		'priority' => 1
	) );


	// Logo and header text options - only show if Site Logos is not supported
	if ( ! function_exists( 'jetpack_the_site_logo' ) ) {
		$wp_customize->add_setting( 'baseline_customizer_logo', array(
			'sanitize_callback' => 'baseline_sanitize_text'
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'baseline_customizer_logo', array(
			'label'    => esc_html__( 'Logo Upload', 'baseline' ),
			'section'  => 'title_tagline',
			'settings' => 'baseline_customizer_logo',
		) ) );
	}


	/**
	 * Font style
	 */
	$wp_customize->add_setting( 'baseline_font_style', array(
		'default'           => 'sans-serif',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'baseline_sanitize_font_select',
	));

	$wp_customize->add_control( 'baseline_customizer_post_style_select', array(
		'settings'    => 'baseline_font_style',
		'label'       => esc_html__( 'Font Style', 'baseline' ),
		'section'     => 'baseline_theme_options',
		'description' => esc_html__( 'Choose the style of font for your site.', 'baseline' ),
		'type'        => 'select',
		'choices'  => array(
			'sans-serif' => esc_html__( 'Sans Serif', 'baseline' ),
			'serif'      => esc_html__( 'Serif', 'baseline' ),
		),
		'priority' => 5
	) );


	/**
	 * Button Color
	 */
	$wp_customize->add_setting( 'baseline_customizer_button_color', array(
		'default'           => '#424a55',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'baseline_customizer_button_color', array(
		'label'    => esc_html__( 'Button Color', 'baseline' ),
		'section'  => 'colors',
		'settings' => 'baseline_customizer_button_color',
		'priority' => 25
	) ) );


	/**
	 * Footer Tagline
	 */
	$wp_customize->add_setting( 'baseline_customizer_footer_text', array(
		'sanitize_callback' => 'baseline_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'baseline_customizer_footer_text', array(
			'label'       => esc_html__( 'Footer Tagline', 'baseline' ),
			'section'     => 'baseline_theme_options',
			'settings'    => 'baseline_customizer_footer_text',
			'description' => esc_html__( 'Change the text that appears in the footer tagline.', 'baseline' ),
			'type'        => 'text',
			'priority'    => 25
		)
	);


	/**
	 * Menu Label
	 */
	$wp_customize->add_setting( 'baseline_customizer_menu_label', array(
		'sanitize_callback' => 'baseline_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'baseline_customizer_menu_label', array(
			'label'           => esc_html__( 'Sidebar Menu Button Text', 'baseline' ),
			'section'         => 'baseline_theme_options',
			'settings'        => 'baseline_customizer_menu_label',
			'description'     => esc_html__( 'Change the Menu button text.', 'baseline' ),
			'type'            => 'text',
			'priority'        => 18
		)
	);


	/**
	 * Browse drawer
	 */
	$wp_customize->add_setting( 'baseline_browse_drawer', array(
		'default'           => 'enabled',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'baseline_sanitize_excerpt_select',
	));

	$wp_customize->add_control( 'baseline_browse_drawer', array(
		'settings'    => 'baseline_browse_drawer',
		'label'       => esc_html__( 'Header Category Menu', 'baseline' ),
		'description' => esc_html__( 'Enable a drop down category menu on the fixed navigation bar.', 'baseline' ),
		'section'     => 'baseline_theme_options',
		'type'        => 'select',
		'choices'  	  => array(
			'enabled'  => esc_html__( 'Enabled', 'baseline' ),
			'disabled' => esc_html__( 'Disabled', 'baseline' ),
		),
		'priority' => 20
	) );

	/**
	 * Browse Label
	 */
	$wp_customize->add_setting( 'baseline_customizer_browse_label', array(
		'sanitize_callback' => 'baseline_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'baseline_customizer_browse_label', array(
			'label'           => esc_html__( 'Header Category Button Label', 'baseline' ),
			'section'         => 'baseline_theme_options',
			'settings'        => 'baseline_customizer_browse_label',
			'description'     => esc_html__( 'Change the Category Menu button text.', 'baseline' ),
			'type'            => 'text',
			'active_callback' => 'baseline_drawer_callback',
			'priority'        => 22
		)
	);


	/**
	 * Header Background Opacity Range
	 */
	$wp_customize->add_setting( 'baseline_bg_opacity', array(
		'default'           => '1',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'baseline_sanitize_range',
	) );

	$wp_customize->add_control( 'baseline_bg_opacity', array(
		'type'        => 'range',
		'priority'    => 10,
		'section'     => 'header_image',
		'label'       => __( 'Header Image Opacity', 'baseline' ),
		'description' => 'Change the opacity of your header image.',
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 1,
			'step'  => .05,
			'style' => 'width: 100%',
		),
	) );


	// Header background color
	$wp_customize->add_setting( 'baseline_header_background_color', array(
		'default'           => '#283037',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'baseline_header_background_color', array(
		'label'    => esc_html__( 'Header Background Color', 'baseline' ),
		'section'  => 'colors',
		'settings' => 'baseline_header_background_color',
		'priority' => 20
	) ) );


	/**
	 * Header Height
	 */
	$wp_customize->add_setting( 'baseline_header_height', array(
		'default'           => '5',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'baseline_sanitize_range',
	) );

	$wp_customize->add_control( 'baseline_header_height', array(
		'type'        => 'range',
		'priority'    => 20,
		'section'  => 'header_image',
		'label'       => esc_html__( 'Header Height', 'baseline' ),
		'description' => esc_html__( 'Adjust the height of the header area.', 'baseline' ),
		'input_attrs' => array(
			'min'   => 2,
			'max'   => 30,
			'step'  => .5,
			'style' => 'width: 100%',
		),
	) );


	/**
	 * Featured content height
	 */
	$wp_customize->add_setting( 'baseline_featured_height', array(
		'default'           => '8',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'baseline_sanitize_range',
	) );

	$wp_customize->add_control( 'baseline_featured_height', array(
		'type'        => 'range',
		'priority'    => 50,
		'section'     => 'featured_content',
		'label'       => __( 'Featured Content Height', 'baseline' ),
		'description' => 'Change the height of the Featured Content section on the homepage.',
		'input_attrs' => array(
			'min'   => 2,
			'max'   => 20,
			'step'  => .5,
			'style' => 'width: 100%',
		),
	) );


	/**
	 * Featured Content excerpt length
	 */
	$wp_customize->add_setting( 'baseline_featured_excerpt_length', array(
		'default'           => '40',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'baseline_sanitize_range',
	) );

	$wp_customize->add_control( 'baseline_featured_excerpt_length', array(
		'type'        => 'number',
		'priority'    => 55,
		'section'     => 'featured_content',
		'label'       => esc_html__( 'Featured Content Excerpt Length', 'baseline' ),
		'description' => esc_html__( 'Change the size of the excerpt on featured content.', 'baseline' ),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 300,
			'step'  => 1,
		),
	) );


	// Index Post Style
	$wp_customize->add_setting( 'baseline_customizer_post_style', array(
		'default'           => 'one-column',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'baseline_sanitize_layout_select',
	));

	$wp_customize->add_control( 'baseline_customizer_layout_select', array(
		'settings'    => 'baseline_customizer_post_style',
		'label'       => esc_html__( 'Index Post Style', 'baseline' ),
		'section'     => 'baseline_theme_options',
		'description' => esc_html__( 'Choose the layout for your post index, archive and search pages.', 'baseline' ),
		'type'        => 'select',
		'choices'     => array(
			'one-column'   => esc_html__( 'One Column', 'baseline' ),
			'two-column'   => esc_html__( 'Two Column', 'baseline' ),
			'three-column' => esc_html__( 'Three Column', 'baseline' ),
		),
		'priority' => 10
	) );


	/**
	 * Grid excerpt length
	 */
	$wp_customize->add_setting( 'baseline_excerpt_length', array(
		'default'           => '40',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'baseline_sanitize_range',
	) );

	$wp_customize->add_control( 'baseline_excerpt_length', array(
		'type'        => 'number',
		'priority'    => 15,
		'section'     => 'baseline_theme_options',
		'label'       => esc_html__( 'Grid View Excerpt Length', 'baseline' ),
		'description' => esc_html__( 'Change the size of the excerpt on grid views.', 'baseline' ),
		'active_callback'   => 'baseline_excerpt_callback',
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 300,
			'step'  => 1,
		),
	) );


	/**
	 * Single column auto excerpt
	 */
	$wp_customize->add_setting( 'baseline_auto_excerpt', array(
		'default'           => 'disabled',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'baseline_sanitize_excerpt_select',
	));

	$wp_customize->add_control( 'baseline_auto_excerpt_select', array(
		'settings'    => 'baseline_auto_excerpt',
		'label'       => esc_html__( 'Auto Generate Excerpt', 'baseline' ),
		'description' => esc_html__( 'Auto generate an excerpt for blog posts on the homepage, archive and search.', 'baseline' ),
		'section'     => 'baseline_theme_options',
		'type'        => 'select',
		'active_callback'   => 'baseline_auto_excerpt_callback',
		'choices'  	  => array(
			'disabled' => esc_html__( 'Disabled', 'baseline' ),
			'enabled'  => esc_html__( 'Enabled', 'baseline' ),
		),
		'priority' => 15
	) );


	/**
	 * Add a setting to hide header text if logo is used
	 */
	$wp_customize->add_setting( 'baseline_logo_text', array(
		'default'           => 1,
		'sanitize_callback' => 'baseline_sanitize_checkbox',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'site_logo_header_text', array(
		'label'    => esc_html__( 'Display Header Text', 'baseline' ),
		'section'  => 'title_tagline',
		'settings' => 'baseline_logo_text',
		'type'     => 'checkbox',
	) ) );
}


/**
 * Adjust header height based on theme option
 */
function baseline_custom_css() {
	$header_bg_color   = esc_html( get_theme_mod( 'baseline_header_background_color', '#283037' ) );
	$header_height     = esc_html( get_theme_mod( 'baseline_header_height' ), 5 );
	$header_text_color = get_header_textcolor();
	$show_header_text  = esc_html( get_theme_mod( 'baseline_logo_text', 1 ) );
	$button_color      = esc_html( get_theme_mod( 'baseline_customizer_button_color' ) );
	$featured_height   = esc_html( get_theme_mod( 'baseline_featured_height', 8 ) );

	if ( $header_bg_color ||  $header_height || $header_text_color || $button_color || $featured_height ) {

	wp_enqueue_style( 'baseline-style', get_stylesheet_uri() );

	if ( $header_bg_color ) {
		$baseline_custom_css = "
		.site-title-wrap {
		      background-color: $header_bg_color;
		}
		";
	}

	if ( $header_height ) {
		$baseline_custom_css .= "
		.site-title-wrap {
		      padding: $header_height% 0;
		}
		";
	}

	if ( $header_text_color ) {
		$baseline_custom_css .= "
		.site-title a,
		.site-description {
			color: #$header_text_color;
		}
		";
	}

	if ( $button_color ) {
		$baseline_custom_css .= "
		button,
		input[type='button'],
		input[type='reset'],
		input[type='submit'],
		.button,
		.comment-navigation a,
		.page-numbers.current,
		.page-numbers:hover,
		.sort-list-toggle:active,
		.sort-list-toggle:focus,
		.sort-list-toggle:hover,
		#page #infinite-handle span {
			background: $button_color;
		}
		";
	}

	$baseline_custom_css .= "
	.featured-content .post {
		padding: $featured_height% 0;
	}
	";

	if ( $show_header_text == 0 ) {
		$baseline_custom_css .= "
		.titles-wrap {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
		";
	}

	wp_add_inline_style( 'baseline-style', $baseline_custom_css );

} }
add_action( 'wp_enqueue_scripts', 'baseline_custom_css' );


/**
 * Add conditional body classes
 */
function baseline_is_class( $classes ) {
	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
		$classes[] = 'infinite-scroll';
	}

	// Add a body class for the sans-serif font style
	$font_style = esc_html( get_option( 'baseline_font_style', 'serif' ) );

	if ( 'sans-serif' === $font_style ) {
		$classes[] = 'sans-serif';
	}

	return $classes;
}
add_filter( 'body_class', 'baseline_is_class' );


/**
 * Replaces the footer tagline text
 */
function baseline_filter_footer_text() {

	// Get the footer copyright text
	$footer_copy_text = get_theme_mod( 'baseline_customizer_footer_text' );

	if ( $footer_copy_text ) {
		// If we have footer text, use it
		$footer_text = $footer_copy_text;
	} else {
		// Otherwise show the fallback theme text
		$footer_text = '&copy; ' . date("Y") . sprintf( esc_html__( ' %1$s Theme by %2$s.', 'baseline' ), 'Baseline', '<a href="https://arraythemes.com/" rel="nofollow">Array</a>' );
	}

	return $footer_text;

}
add_filter( 'baseline_footer_text', 'baseline_filter_footer_text' );


/**
 * Redirect to Getting Started page on theme activation
 */
function baseline_redirect_on_activation() {
	global $pagenow;

	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

		wp_redirect( admin_url( "themes.php?page=baseline-license" ) );

	}
}
add_action( 'admin_init', 'baseline_redirect_on_activation' );


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function baseline_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
	$wp_customize->remove_control( 'display_header_text' );
}
add_action( 'customize_register', 'baseline_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function baseline_customize_preview_js() {
	wp_enqueue_script( 'baseline_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '2016034', true );
}
add_action( 'customize_preview_init', 'baseline_customize_preview_js' );
