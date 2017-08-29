<?php
/**
 * Candid functions and definitions
 *
 * @package Candid
 */

/**
 * Set the content width based on the theme's design and stylesheet
 */
if ( ! isset( $content_width ) ) {
	$content_width = 900; /* pixels */
}

/**
 * Set the content width for the full-width template
 */
function candid_full_width_content( $embed_size ){
	if ( is_page_template( 'full-width.php' ) ) {
		global $content_width;
		$content_width = 1300;
	}
}
add_filter( 'template_redirect', 'candid_full_width_content' );


if ( ! function_exists( 'candid_setup' ) ) :
/**
 * Sets up Candid's defaults and registers support for various WordPress features
 */
function candid_setup() {

	/**
	 * Add styles to post editor (editor-style.css)
	 */
	add_editor_style();

	/*
	 * Make theme available for translation
	 */
	load_theme_textdomain( 'candid', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Post thumbnail support and image sizes
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Add video metabox
	 */
	add_theme_support( 'array_themes_video_support' );

	/*
	 * Add title output
	 */
	add_theme_support( 'title-tag' );

	// Large post image
	add_image_size( 'candid-full-width', 1200 );

	// Gallery thumb - small
	add_image_size( 'candid-portfolio-grid-small', 425 );

	// Gallery thumb - medium
	add_image_size( 'candid-portfolio-grid-medium', 650 );

	// Gallery thumb - large
	add_image_size( 'candid-portfolio-grid-large', 1300 );

	// Logo size
	add_image_size( 'candid-logo', 300 );

	/**
	 * Register Navigation menu
	 */
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'candid' ),
		'footer'  => esc_html__( 'Social Icon Menu', 'candid' ),
	) );

	/**
	 * Add Site Logo feature
	 */
	add_theme_support( 'site-logo', array(
		'header-text' => array(
			'titles-wrap',
		),
		'size' => 'candid-logo',
	) );

	/**
	 * Custom background feature
	 */
	add_theme_support( 'custom-background', apply_filters( 'candid_custom_background_args', array(
		'default-color' => 'fff',
	) ) );

	/**
	 * Enable HTML5 markup
	 */
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
	) );
}
endif; // candid_setup
add_action( 'after_setup_theme', 'candid_setup' );


/**
 * Register widget area
 */
function candid_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'candid' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Widgets added here will appear on the sidebar of posts and pages.', 'candid' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'candid_widgets_init' );


/**
 * Return the Google font stylesheet URL
 */
if ( ! function_exists( 'candid_fonts_url' ) ) :
function candid_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Lato, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$lora = _x( 'on', 'Lora font: on or off', 'candid' );

	/* Translators: If there are characters in your language that are not
	 * supported by Arimo, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$arimo = _x( 'on', 'Arimo font: on or off', 'candid' );

	if ( 'off' !== $lora || 'off' !== $arimo ) {
		$font_families = array();

		if ( 'off' !== $lora )
			$font_families[] = 'Lora:400,700,400italic,700italic';

		if ( 'off' !== $arimo )
			$font_families[] = 'Arimo:400,700,400italic,700italic';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}
endif;

/**
 * Enqueue Google fonts style to admin for editor styles
 */
function candid_admin_fonts( $hook_suffix ) {
	wp_enqueue_style( 'candid-fonts', candid_fonts_url(), array(), null );
}
add_action( 'admin_enqueue_scripts', 'candid_admin_fonts' );
add_action( 'admin_print_styles-appearance_page_custom-header', 'candid_admin_fonts' );


/**
 * Enqueue scripts and styles
 */
function candid_scripts() {

	wp_enqueue_style( 'candid-style', get_stylesheet_uri() );

	/**
	 * FontAwesome Icons stylesheet
	 */
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . "/inc/fontawesome/css/font-awesome.css", array(), '4.3.0', 'screen' );

	/**
	 * Masonry
	 */
	wp_enqueue_script( 'masonry' );

	/**
	 * Load Candid's javascript
	 */
	wp_enqueue_script( 'candid-js', get_template_directory_uri() . '/js/candid.js', array( 'jquery' ), '1.0', true );

	/**
	 * Load fitvids
	 */
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.1', true );

	/**
	* Load Arimo and Roboto from Google
	*/
	wp_enqueue_style( 'candid-fonts', candid_fonts_url(), array(), null );

	/**
	 * Load the comment reply script
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'candid_scripts' );


/**
 * Custom template tags for Candid
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Custom functions that act independently of the theme templates
 */
require get_template_directory() . '/inc/extras.php';


/**
 * Customizer theme options
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Self-hosted functionality
 */
require get_template_directory() . '/inc/wporg.php';


/**
 * Load Jetpack compatibility file
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Add button class to next/previous post links
 */
function candid_posts_link_attributes() {
	return 'class="button"';
}
add_filter( 'next_posts_link_attributes', 'candid_posts_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'candid_posts_link_attributes' );


/**
 * Add layout style class to body
 */
function candid_layout_class( $classes ) {

	// Gallery column width class
	$classes[] = get_option( 'candid_customizer_gallery_style', 'portfolio-grid-medium' );

	// Add a sidebar class
	$classes[] = ( is_active_sidebar( 'sidebar' ) ) ? 'has-sidebar' : 'no-sidebar';

	return $classes;
}
add_filter( 'body_class', 'candid_layout_class' );
