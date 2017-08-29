<?php
/**
 * Atomic functions and definitions
 *
 * @package Atomic
 */


if ( ! function_exists( 'atomic_setup' ) ) :
/**
 * Sets up Atomic's defaults and registers support for various WordPress features
 */
function atomic_setup() {

	/**
	 * Load Getting Started page and initialize theme updater
	 */
	require_once( get_template_directory() . '/inc/admin/updater/theme-updater.php' );

	/**
	 * TGM activation class
	 */
	require_once get_template_directory() . '/inc/admin/tgm/tgm-activation.php';

	/**
	 * Add styles to post editor
	 */
	add_editor_style( array( 'editor-style.css', atomic_fonts_url() ) );

	/*
	 * Make theme available for translation
	 */
	load_theme_textdomain( 'atomic', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Post thumbnail support and image sizes
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Add title output
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Custom Header support
	 */
	$defaults = array(
		'flex-width'         => true,
		'width'              => 1600,
		'flex-height'        => true,
		'header-text'        => false,
		'default-text-color' => '#fff',
	);
	add_theme_support( 'custom-header', $defaults );

	/**
	 * Custom Background support
	 */
	$defaults = array(
		'default-color' => 'e1e4ea'
	);
	add_theme_support( 'custom-background', $defaults );

	/**
	 * Selective Refresh for Customizer
	 */
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Enable WooCommerce gallery
	 */
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Add excerpt support to pages and portfolio items
	add_post_type_support( 'jetpack-portfolio', 'excerpt' );
	add_post_type_support( 'page', 'excerpt' );
	add_post_type_support( 'jetpack-testimonial', 'excerpt' );

	// Index post image
	add_image_size( 'atomic-index-image', 1200, 900, true );

	// Index post image
	add_image_size( 'atomic-index-full-thumb', 1200, 900, true );

	// Featured image
	add_image_size( 'atomic-featured-image', 1600, 600, true );

	// Portfolio featured image
	add_image_size( 'atomic-featured-image-portfolio', 1600 );

	// Featured image index
	add_image_size( 'atomic-featured-image-index', 1200, 800, true );

	// Grid thumbnail
	add_image_size( 'atomic-grid-thumb', 375, 250, true );

	// Grid thumbnail tall
	add_image_size( 'atomic-grid-thumb-tall', 600, 800, true );

	// Testimonial avatar
	add_image_size( 'atomic-testimonial-avatar', 100, 100, true );

	// Portfolio Square
	add_image_size( 'atomic-portfolio-square', 400, 400, true );

	// Portfolio Rectangle
	add_image_size( 'atomic-portfolio', 600, 450, true );

	// Hero background image
	add_image_size( 'atomic-hero', 1400 );
	add_image_size( 'atomic-hero-tablet', 800 );
	add_image_size( 'atomic-hero-mobile', 600 );

	// Hero pager thumb
	add_image_size( 'atomic-hero-thumb', 50, 50, true );

	// Logo size
	add_image_size( 'atomic-logo', 300 );

	/**
	 * Register Navigation menu
	 */
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'atomic' ),
		'social'  => esc_html__( 'Social Icon Menu', 'atomic' ),
	) );

	/**
	 * Add Site Logo feature
	 */
	add_theme_support( 'custom-logo', array(
		'header-text' => array( 'titles-wrap' ),
		'size'        => 'atomic-logo',
	) );

	/**
	 * Enable HTML5 markup
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'gallery',
	) );

	/**
	 * Enable post formats
	 */
	add_theme_support( 'post-formats', array( 'video', 'gallery' ) );


	/**
	 * Include WooCommerce functions and styles
	 */
	add_theme_support( 'woocommerce' );

	if ( class_exists( 'WooCommerce' ) ) {
		require_once( get_template_directory() . '/woocommerce/woo-functions.php' );
	}
}
endif; // atomic_setup
add_action( 'after_setup_theme', 'atomic_setup' );


/**
 * Set the content width based on the theme's design and stylesheet
 */
function atomic_content_width() {
	if ( has_post_format( 'gallery' ) ) {
		$GLOBALS['content_width'] = apply_filters( 'atomic_content_width', 1400 );
	} else {
		$GLOBALS['content_width'] = apply_filters( 'atomic_content_width', 905 );
	}
}
add_action( 'after_setup_theme', 'atomic_content_width', 0 );


/**
 * Gets the gallery shortcode data from post content.
 */
function atomic_gallery_data() {
	global $post;
	$pattern = get_shortcode_regex();
	if (   preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
		&& array_key_exists( 2, $matches )
		&& in_array( 'gallery', $matches[2] ) )
	{

		return $matches;
	}
}


/**
 * If the post has a carousel gallery, remove the first gallery from the post
 *
 * @since atomic 1.0
 */
function atomic_filtered_content() {

	global $post, $wp_embed;

	$content = get_the_content( esc_html__( 'Read More', 'atomic' ) );

	if ( has_post_format( 'gallery' ) ) {

		$gallery_data = atomic_gallery_data();

		// Remove the first gallery from the post since we're using it in place of the featured image
		if ( $gallery_data && is_array( $gallery_data ) ) {
			$content = str_replace( $gallery_data[0][0], '', $content );
		}
	}

	if ( has_post_format( 'video' ) ) {

		// Remove the first video embed from the post since we're using it in place of the featured image
		if ( ! empty( $wp_embed->last_url ) ) {

			$content = str_replace( $wp_embed->last_url, '', $content );

		} else {

			$video = get_media_embedded_in_content( $content );
			$content = str_replace( $video, '', $content );
		}
	}

	echo apply_filters( 'the_content', $content );
}


/**
 * Register widget area
 */
function atomic_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Footer - Column 1', 'atomic' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Widgets added here will appear in the left column of the footer.', 'atomic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer - Column 2', 'atomic' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Widgets added here will appear in the center column of the footer.', 'atomic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer - Column 3', 'atomic' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Widgets added here will appear in the right column of the footer.', 'atomic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer - Column 4', 'atomic' ),
		'id'            => 'footer-4',
		'description'   => esc_html__( 'Widgets added here will appear in the right column of the footer.', 'atomic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'atomic_widgets_init' );


/**
 * Return the Google font stylesheet URL
 */
if ( ! function_exists( 'atomic_fonts_url' ) ) :
function atomic_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by these fonts, translate this to 'off'. Do not translate
	 * into your own language.
	 */

	$nunito_sans = esc_html_x( 'on', 'Nunito font: on or off', 'atomic' );

	if ( 'off' !== $nunito_sans ) {
		$font_families = array();

		if ( 'off' !== $nunito_sans )
			$font_families[] = 'Nunito Sans:200,300,400,400i,600';

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
 * Enqueue scripts and styles
 */
function atomic_scripts() {

	wp_enqueue_style( 'atomic-style', get_stylesheet_uri() );

	/**
	* Load fonts from Google
	*/
	wp_enqueue_style( 'atomic-fonts', atomic_fonts_url(), array(), null );

	/**
	 * FontAwesome Icons stylesheet
	 */
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . "/inc/fontawesome/css/font-awesome.css", array(), '4.4.0', 'screen' );

	/**
	 * Include WooCommerce functions and styles
	 */
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'atomic-woocommerce-style', get_template_directory_uri() . "/woocommerce/atomic-woo.css", array(), '1.0.9', 'screen' );
	}

	/**
	 * Load Atomic's javascript
	 */
	wp_enqueue_script( 'atomic-js', get_template_directory_uri() . '/js/atomic.js', array( 'jquery' ), '1.0', true );

	/**
	 * Load responsiveSlides javascript
	 */
	wp_enqueue_script( 'responsive-slides', get_template_directory_uri() . '/js/responsiveslides.js', array(), '1.54', true );

	/**
	 * Load fitvids javascript
	 */
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array(), '1.1', true );

	/**
	 * Load touchSwipe javascript
	 */
	wp_enqueue_script( 'touchSwipe', get_template_directory_uri() . '/js/jquery.touchSwipe.js', array(), '1.6.6', true );

	/**
	 * Load matchHeight javascript
	 */
	wp_enqueue_script( 'matchHeight', get_template_directory_uri() . '/js/jquery.matchHeight.js', array(), '0.5.2', true );

	/**
	 * Localizes the atomic-js file
	 */
	wp_localize_script( 'atomic-js', 'atomic_js_vars', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	) );

	/**
	 * Load the comment reply script
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'atomic_scripts' );


/**
 * Custom template tags for Atomic
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Customizer theme options
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Load Jetpack compatibility file
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Add button class to next/previous post links
 */
function atomic_posts_link_attributes() {
	return 'class="button"';
}
add_filter( 'next_posts_link_attributes', 'atomic_posts_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'atomic_posts_link_attributes' );


/**
 * Add layout style class to body
 */
function atomic_layout_class( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if( is_single() && has_post_thumbnail() || is_page() && has_post_thumbnail() ) {
		$classes[] = 'has-featured-image';
	}

	return $classes;
}
add_filter( 'body_class', 'atomic_layout_class' );


/**
 * Add featured image class to posts
 */
function atomic_featured_image_class( $classes ) {
	$classes[] = 'post';

	// Check for featured image
	$classes[] = has_post_thumbnail() ? 'with-featured-image' : 'without-featured-image';

	return $classes;
}
add_filter( 'post_class', 'atomic_featured_image_class' );


/**
 * Adjust the grid excerpt length for portfolio items
 */
function atomic_portfolio_excerpt_length() {
	return 15;
}


/**
 * Add an ellipsis read more link
 */
function atomic_excerpt_more( $more ) {
	return ' &hellip;';
}
add_filter( 'excerpt_more', 'atomic_excerpt_more' );


/**
 * Full size image on attachment pages
 */
function atomic_attachment_size($p) {
	if ( is_attachment() ) {
		return '<p>' . wp_get_attachment_link( 0, 'full-size', false ) . '</p>';
	}
}
add_filter( 'prepend_attachment', 'atomic_attachment_size' );


/**
 * Responsive Images
 */
function atomic_post_thumbnail_sizes_attr($attr, $attachment, $size) {

	// Featured image thumbnails
	if ($size === 'atomic-featured-image') {
		$attr['sizes'] = '(max-width: 1480px) 950px, (max-width: 800px) 800px, (max-width: 600px) 600px';
	}

	return $attr;
}
//add_filter( 'wp_get_attachment_image_attributes', 'atomic_post_thumbnail_sizes_attr', 10 , 3 );


/**
 * Add a js class
 */
function atomic_html_js_class () {
    echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>'. "\n";
}
add_action( 'wp_head', 'atomic_html_js_class', 1 );


/**
 * Add Video and Gallery post format support to pages
 */
function atomic_add_post_formats_to_page(){
    add_post_type_support( 'page', 'post-formats' );
    register_taxonomy_for_object_type( 'post_format', 'page' );
}
add_action( 'init', 'atomic_add_post_formats_to_page', 11 );
