<?php
/**
 * Meteor Theme Customizer
 *
 * @package Meteor
 */

add_action( 'customize_register', 'meteor_register' );

if ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX && ! is_customize_preview() ) {
	return;
}

/**
 * Sanitize text
 */
function meteor_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Jetpack callback
 */
function meteor_jetpack_callback( $control ) {
	if ( class_exists( 'Jetpack' ) ) {
		return true;
	} else {
		return false;
	}
}


function meteor_blog_section_callback( $control ) {
    if ( $control->manager->get_setting( 'meteor_portfolio_blog_section' )->value() == 'enabled' ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Check for the masonry layout
 */
function meteor_is_portfolio_masonry() {
	return is_page_template( 'templates/template-portfolio-masonry.php' );
}

/**
 * Check for the grid layout
 */
function meteor_is_portfolio_grid() {
	return is_page_template( 'templates/template-portfolio-grid.php' );
}

/**
 * Check for the carousel layout
 */
function meteor_is_portfolio_carousel() {
	return is_page_template( 'templates/template-portfolio-carousel.php' );
}

/**
 * Check for the blocks layout
 */
function meteor_is_portfolio_blocks() {
	return is_page_template( 'templates/template-portfolio-block.php' );
}

/**
 * Portfolio item count array
 */
function meteor_portfolio_count() {
	return array(
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
		'99' => esc_html__( 'Show All', 'meteor' ),
	);
}


/**
 * @param WP_Customize_Manager $wp_customize
 */
function meteor_register( $wp_customize ) {

	/**
	 * Theme Options Panel
	 */
	$wp_customize->add_section( 'meteor_theme_options', array(
		'priority'   => 1,
		'capability' => 'edit_theme_options',
		'title'      => esc_html__( 'Theme Options', 'meteor' ),
	) );

	/**
	 * Accent Color
	 */
	$wp_customize->add_setting( 'meteor_button_color', array(
		'default'           => '#ac6fbf',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'meteor_button_color', array(
		'label'       => esc_html__( 'Accent Color', 'meteor' ),
		'section'     => 'colors',
		'settings'    => 'meteor_button_color',
		'description' => esc_html__( 'Change the accent color of buttons and various typographical elements.', 'meteor' ),
		'priority'    => 5
	) ) );


	/**
	 * Footer Tagline
	 */
	$wp_customize->add_setting( 'meteor_footer_text', array(
		'sanitize_callback' => 'meteor_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'meteor_footer_text', array(
			'label'       => esc_html__( 'Footer Tagline', 'meteor' ),
			'section'     => 'meteor_theme_options',
			'settings'    => 'meteor_footer_text',
			'description' => esc_html__( 'Change the text that appears in the footer tagline at the bottom of your site.', 'meteor' ),
			'type'        => 'text',
			'priority'    => 300
		)
	);

	$wp_customize->selective_refresh->add_partial( 'meteor_footer_text', array(
        'selector' => '.site-info',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'meteor_footer_text' );
        },
    ) );


	/**
	 * Masonry Portfolio Count
	 */
	$wp_customize->add_setting( 'meteor_portfolio_masonry_count', array(
		'default'           => '10',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control( 'meteor_portfolio_masonry_count_select', array(
		'settings'        => 'meteor_portfolio_masonry_count',
		'label'           => esc_html__( 'Number of portfolio items to show on the masonry grid layout:', 'meteor' ),
		'section'         => 'meteor_theme_options',
		'type'            => 'select',
		'priority'        => 20,
		'active_callback' => 'meteor_is_portfolio_masonry',
		'choices'         => meteor_portfolio_count(),
	));


	/**
	 * Portfolio Grid Count
	 */
	$wp_customize->add_setting( 'meteor_portfolio_grid_count', array(
		'default'           => '9',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control( 'meteor_portfolio_grid_count_select', array(
		'settings'        => 'meteor_portfolio_grid_count',
		'label'           => esc_html__( 'Number of portfolio items to show on the grid layout:', 'meteor' ),
		'section'         => 'meteor_theme_options',
		'type'            => 'select',
		'priority'        => 20,
		'active_callback' => 'meteor_is_portfolio_grid',
		'choices'         => meteor_portfolio_count(),
	));


	/**
	 * Portfolio Block Count
	 */
	$wp_customize->add_setting( 'meteor_portfolio_block_count', array(
		'default'           => '6',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control( 'meteor_portfolio_block_count_select', array(
		'settings'        => 'meteor_portfolio_block_count',
		'label'           => esc_html__( 'Number of portfolio items to show on the block layout:', 'meteor' ),
		'section'         => 'meteor_theme_options',
		'type'            => 'select',
		'priority'        => 20,
		'active_callback' => 'meteor_is_portfolio_blocks',
		'choices'         => meteor_portfolio_count(),
	));


	/**
	 * Portfolio Carousel Count
	 */
	$wp_customize->add_setting( 'meteor_portfolio_carousel_count', array(
		'default'           => '10',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control( 'meteor_portfolio_carousel_count_select', array(
		'settings'        => 'meteor_portfolio_carousel_count',
		'label'           => esc_html__( 'Number of portfolio items to show on the carousel layout:', 'meteor' ),
		'section'         => 'meteor_theme_options',
		'type'            => 'select',
		'priority'        => 20,
		'active_callback' => 'meteor_is_portfolio_carousel',
		'choices'         => meteor_portfolio_count(),
	));


	/**
	 * Portfolio Masonry Columns
	 */
	$wp_customize->add_setting( 'meteor_portfolio_masonry_columns', array(
		'default'           => '2',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control( 'meteor_portfolio_masonry_columns_select', array(
		'settings'        => 'meteor_portfolio_masonry_columns',
		'label'           => esc_html__( 'Number of columns on portfolio masonry grid:', 'meteor' ),
		'section'         => 'meteor_theme_options',
		'type'            => 'select',
		'priority'        => 20,
		'active_callback' => 'meteor_is_portfolio_masonry',
		'choices'         => array(
			'2'  => '2',
			'3'  => '3',
		),
	));


	/**
	 * Portfolio Grid Columns
	 */
	$wp_customize->add_setting( 'meteor_portfolio_grid_columns', array(
		'default'           => '3',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control( 'meteor_portfolio_grid_columns_select', array(
		'settings'        => 'meteor_portfolio_grid_columns',
		'label'           => esc_html__( 'Number of columns on portfolio grid:', 'meteor' ),
		'section'         => 'meteor_theme_options',
		'type'            => 'select',
		'priority'        => 20,
		'active_callback' => 'meteor_is_portfolio_grid',
		'choices'         => array(
			'2'  => '2',
			'3'  => '3',
		),
	));


	/**
	 * Portfolio Archive Style
	 */
	$wp_customize->add_setting( 'meteor_portfolio_archive_style', array(
		'default'           => 'grid',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'meteor_sanitize_text',
	));

	$wp_customize->add_control( 'meteor_portfolio_archive_style_select', array(
		'settings'        => 'meteor_portfolio_archive_style',
		'label'           => esc_html__( 'Choose the style of the portfolio archive page:', 'meteor' ),
		'section'         => 'meteor_theme_options',
		'type'            => 'select',
		'priority'        => 20,
		'active_callback' => 'meteor_jetpack_callback',
		'choices'         => array(
			'grid'    => esc_html__( 'Grid', 'meteor' ),
			'masonry' => esc_html__( 'Masonry', 'meteor' ),
			'blocks'  => esc_html__( 'Blocks', 'meteor' ),
		),
	));


	/**
	 * Blog Section on Portfolio
	 */
	$wp_customize->add_setting( 'meteor_portfolio_blog_section', array(
		'default'           => 'enabled',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'meteor_sanitize_text',
	));

	$wp_customize->add_control( 'meteor_portfolio_blog_section_select', array(
		'settings'        => 'meteor_portfolio_blog_section',
		'label'           => esc_html__( 'Blog Section on Portfolio Templates', 'meteor' ),
		'section'         => 'meteor_theme_options',
		'type'            => 'select',
		'priority'        => 25,
		//'active_callback' => 'meteor_jetpack_callback',
		'choices'         => array(
			'enabled'    => esc_html__( 'Enabled', 'meteor' ),
			'disabled' 	 => esc_html__( 'Disabled', 'meteor' ),
		),
	));


	/**
	 * Portfolio Template Blog Text
	 */
	$wp_customize->add_setting( 'meteor_portfolio_blog_text', array(
		'sanitize_callback' => 'meteor_sanitize_text',
		'transport'         => 'postMessage',
		'default'           => esc_html__( 'Latest from the blog', 'meteor' ),
	) );

	$wp_customize->add_control( 'meteor_portfolio_blog_text', array(
			'label'           => esc_html__( 'Blog Section Title', 'meteor' ),
			'section'         => 'meteor_theme_options',
			'settings'        => 'meteor_portfolio_blog_text',
			'description'     => esc_html__( 'Change the blog section title on portfolio page templates.', 'meteor' ),
			'type'            => 'text',
			'active_callback' => 'meteor_blog_section_callback',
			'priority'        => 30
		)
	);

	$wp_customize->selective_refresh->add_partial( 'meteor_portfolio_blog_text', array(
        'selector' => '.blog-section h3',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'meteor_portfolio_blog_text' );
        },
    ) );

}


/**
 * Adjust header height based on theme option
 */
function meteor_css_output() {
	// Theme Options
	$accent_color  = esc_html( get_theme_mod( 'meteor_button_color', '#ac6fbf' ) );

	// Check for styles before outputting
	if ( $accent_color ) {

	wp_enqueue_style( 'meteor-style', get_stylesheet_uri() );

	$meteor_custom_css = "

	button,
	input[type='button'],
	input[type='submit'],
	.button,
	.page-navigation .current,
	.page-numbers:hover,
	#page #infinite-handle button,
	#page #infinite-handle button:hover,
	.comment-navigation a,
	.su-button,
	.mobile-navigation,
	.toggle-active {
	      background-color: $accent_color;
	}

	.entry-content p a:hover,
	.post-navigation a:hover .post-title,
	.entry-header .entry-title a:hover,
	.section-portfolio .jetpack-portfolio h2 a:hover,
	.carousel-navs button {
		color: $accent_color;
	}

	.entry-content p a:hover {
		box-shadow: inset 0 -2px 0 $accent_color;
	}

	";
	wp_add_inline_style( 'meteor-style', $meteor_custom_css );
} }
add_action( 'wp_enqueue_scripts', 'meteor_css_output' );


/**
 * Replaces the footer tagline text
 */
function meteor_filter_footer_text() {

	// Get the footer copyright text
	$footer_copy_text = get_theme_mod( 'meteor_footer_text' );

	if ( $footer_copy_text ) {
		// If we have footer text, use it
		$footer_text = $footer_copy_text;
	} else {
		// Otherwise show the fallback theme text
		$footer_text = '&copy; ' . date("Y") . sprintf( esc_html__( ' %1$s Theme by %2$s.', 'meteor' ), 'Meteor', '<a href="https://arraythemes.com/" rel="nofollow">Array</a>' );
	}

	return $footer_text;

}
add_filter( 'meteor_footer_text', 'meteor_filter_footer_text' );


/**
 * Add postMessage support and selective refresh for site title and description.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function meteor_customize_register( $wp_customize ) {
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
add_action( 'customize_register', 'meteor_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function meteor_customize_preview_js() {
	wp_enqueue_script( 'meteor_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20170230', true );
}
add_action( 'customize_preview_init', 'meteor_customize_preview_js' );
