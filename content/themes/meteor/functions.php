<?php
/**
 * Meteor functions and definitions
 *
 * @package Meteor
 */


if ( ! function_exists( 'meteor_setup' ) ) :
/**
 * Sets up Meteor's defaults and registers support for various WordPress features
 */
function meteor_setup() {

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
	add_editor_style( array( 'editor-style.css', meteor_fonts_url() ) );

	/*
	 * Make theme available for translation
	 */
	load_theme_textdomain( 'meteor', get_template_directory() . '/languages' );

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
	 * Custom Background support
	 */
	$defaults = array(
		'default-color' => 'ebeff4'
	);
	add_theme_support( 'custom-background', $defaults );

	/**
	 * Selective Refresh for Customizer
	 */
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add excerpt support to pages and portfolio items
	add_post_type_support( 'jetpack-portfolio', 'excerpt' );
	add_post_type_support( 'page', 'excerpt' );

	// Featured image
	add_image_size( 'meteor-featured-image', 800 );

	// Featured image on centered layout
	add_image_size( 'meteor-featured-image-center', 1200 );

	// Portfolio featured image
	add_image_size( 'meteor-featured-image-portfolio', 1600 );

	// Portfolio Square
	add_image_size( 'meteor-portfolio-square', 400, 400, true );

	// Portfolio Rectangle
	add_image_size( 'meteor-portfolio', 600, 450, true );

	// Portfolio Rectangle
	add_image_size( 'meteor-portfolio-blocks', 800, 600, true );

	// Portfolio Square
	add_image_size( 'meteor-portfolio-masonry', 600, 9999 );

	// Portfolio Carousel
	add_image_size( 'meteor-portfolio-carousel', 800, 600, true );

	// Logo size
	add_image_size( 'meteor-logo', 300 );

	/**
	 * Register Navigation menu
	 */
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'meteor' ),
		'social'  => esc_html__( 'Social Icon Menu', 'meteor' ),
	) );

	/**
	 * Add Site Logo feature
	 */
	add_theme_support( 'custom-logo', array(
		'header-text' => array( 'titles-wrap' ),
		'size'        => 'meteor-logo',
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
}
endif; // meteor_setup
add_action( 'after_setup_theme', 'meteor_setup' );


/**
 * Add Carousel image size to gallery select
 */
function meteor_carousel_image_sizes( $sizes ) {
	$addsizes = array(
		"meteor-portfolio-carousel" => esc_html__( 'Carousel', 'meteor' ),
	);
	$newsizes = array_merge( $sizes, $addsizes );
	return $newsizes;
}
add_filter( 'image_size_names_choose', 'meteor_carousel_image_sizes' );



/**
 * Set the content width based on the theme's design and stylesheet
 */
function meteor_content_width() {
	if ( has_post_format( 'gallery' ) ) {
		$GLOBALS['content_width'] = apply_filters( 'meteor_content_width', 1400 );
	} else {
		$GLOBALS['content_width'] = apply_filters( 'meteor_content_width', 905 );
	}
}
add_action( 'after_setup_theme', 'meteor_content_width', 0 );


/**
 * Gets the gallery shortcode data from post content.
 */
function meteor_gallery_data() {
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
 * Disply the featured image, gallery or video associated with the post
 *
 * @since meteor 1.0
 */
function meteor_post_media() {
	global $post, $wp_embed;

	// Get the post content
	$content = apply_filters( 'the_content', $post->post_content );

	// Check for video post format content
	$media = get_media_embedded_in_content( $content );

	// If it's a video format, get the first video embed from the post to replace the featured image
	if ( has_post_format( 'video' ) && ! empty( $media ) ) {

		echo '<div class="featured-video">';
			echo $media[0];
		echo '</div>';

	}
	// If it's a gallery format, get the first gallery from the post to replace the featured image
	else if ( has_post_format( 'gallery' ) ) {

		echo '<div class="featured-image featured-gallery">';
			echo get_post_gallery();
		echo '</div>';

	} else if ( has_post_thumbnail() ) {

		// Otherwise get the featured image
		echo '<div class="featured-image">';
			if( is_page_template( 'templates/template-portfolio-center.php' ) ) {
				the_post_thumbnail( 'meteor-featured-image-center' );
			} else {
				if ( is_single() ) {
					the_post_thumbnail( 'meteor-featured-image' );
				} else { ?>
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'meteor-featured-image' ); ?></a>
				<?php }
			}
		echo '</div>';

	} wp_reset_postdata(); ?>

<?php }


/**
 * If the post has a carousel gallery, remove the first gallery from the post
 *
 * @since meteor 1.0
 */
function meteor_filtered_content() {

	global $post, $wp_embed;

	$content = get_the_content( esc_html__( 'Read More', 'meteor' ) );

	if ( has_post_format( 'gallery' ) ) {

		$gallery_data = meteor_gallery_data();

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
function meteor_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'meteor' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Widgets added here will appear on the right side of posts and pages', 'meteor' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer - Column 1', 'meteor' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Widgets added here will appear in the left column of the footer.', 'meteor' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer - Column 2', 'meteor' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Widgets added here will appear in the center column of the footer.', 'meteor' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer - Column 3', 'meteor' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Widgets added here will appear in the right column of the footer.', 'meteor' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'meteor_widgets_init' );


/**
 * Return the Google font stylesheet URL
 */
if ( ! function_exists( 'meteor_fonts_url' ) ) :
function meteor_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by these fonts, translate this to 'off'. Do not translate
	 * into your own language.
	 */

	$poppins = esc_html_x( 'on', 'Poppins font: on or off', 'meteor' );
	$nunito_sans = esc_html_x( 'on', 'Nunito Sans font: on or off', 'meteor' );

	if ( 'off' !== $nunito_sans || 'off' !== $poppins ) {
		$font_families = array();

		if ( 'off' !== $poppins )
			$font_families[] = 'Poppins:400,500,600,700';

		if ( 'off' !== $nunito_sans )
			$font_families[] = 'Nunito Sans:400,400i,600,700';

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
function meteor_scripts() {

	wp_enqueue_style( 'meteor-style', get_stylesheet_uri() );

	/**
	* Load fonts from Google
	*/
	wp_enqueue_style( 'meteor-fonts', meteor_fonts_url(), array(), null );

	/**
	 * FontAwesome Icons stylesheet
	 */
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . "/inc/fontawesome/css/font-awesome.css", array(), '4.4.0', 'screen' );

	/**
	 * Load Meteor's javascript
	 */
	wp_enqueue_script( 'meteor-js', get_template_directory_uri() . '/js/meteor.js', array( 'jquery' ), '1.0', true );

	/**
	 * Load fitvids javascript
	 */
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array(), '1.1', true );

	/**
	 * Masonry
	 */
	wp_enqueue_script( 'masonry' );

	/**
	 * Load Slick slider
	 */
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/inc/slick/slick.js', array(), '1.6.0', true );
	wp_enqueue_style( 'meteor-slick-css', get_template_directory_uri() . "/inc/slick/slick.css", array(), '1.6.0', 'screen' );
	wp_enqueue_style( 'meteor-slick-theme-css', get_template_directory_uri() . "/inc/slick/slick-theme.css", array(), '1.6.0', 'screen' );

	/**
	 * Load Meteor's javascript
	 */
	wp_enqueue_script( 'meteor-modernizr', get_template_directory_uri() . '/js/modernizr-custom.js', array( 'jquery' ), '1.0', true );

	/**
	 * Localizes the meteor-js file
	 */
	wp_localize_script( 'meteor-js', 'meteor_js_vars', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	) );

	/**
	 * Load the comment reply script
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'meteor_scripts' );


/**
 * Custom template tags for Meteor
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
function meteor_posts_link_attributes() {
	return 'class="button"';
}
add_filter( 'next_posts_link_attributes', 'meteor_posts_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'meteor_posts_link_attributes' );


/**
 * Add layout style class to body
 */
function meteor_layout_class( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if( is_single() && has_post_thumbnail() || is_page() && has_post_thumbnail() ) {
		$classes[] = 'has-featured-image';
	}

	// Portfolio Columns
	$masonry_columns = get_theme_mod( 'meteor_portfolio_masonry_columns', '2' );
	$grid_columns    = get_theme_mod( 'meteor_portfolio_grid_columns', '3' );

	if ( $masonry_columns == 2 ) {
		$classes[] = 'two-column-masonry';
	} elseif ( $masonry_columns == 3 ) {
		$classes[] = 'three-column-masonry';
	}

	if ( $grid_columns == 2 ) {
		$classes[] = 'two-column-grid';
	} elseif ( $grid_columns == 3 ) {
		$classes[] = 'three-column-grid';
	}

	return $classes;
}
add_filter( 'body_class', 'meteor_layout_class' );


/**
 * Add featured image class to posts
 */
function meteor_featured_image_class( $classes ) {
	$classes[] = 'post';

	// Check for featured image
	$classes[] = has_post_thumbnail() ? 'with-featured-image' : 'without-featured-image';

	return $classes;
}
add_filter( 'post_class', 'meteor_featured_image_class' );


/**
 * Adjust the grid excerpt length for portfolio items
 */
function meteor_portfolio_excerpt_length() {
	return 40;
}


/**
 * Adjust the grid excerpt length for portfolio items
 */
function meteor_portfolio_block_excerpt_length() {
	return 80;
}

/**
 * Adjust the grid excerpt length for portfolio items
 */
function meteor_service_excerpt_length() {
	return 40;
}


/**
 * Adjust the grid excerpt length for portfolio items
 */
function meteor_search_excerpt_length() {
	return 40;
}


/**
 * Add an ellipsis read more link
 */
function meteor_excerpt_more( $more ) {
	return ' &hellip;';
}
add_filter( 'excerpt_more', 'meteor_excerpt_more' );


/**
 * Full size image on attachment pages
 */
function meteor_attachment_size( $p ) {
	if ( is_attachment() ) {
		return '<p>' . wp_get_attachment_link( 0, 'full-size', false ) . '</p>';
	}
}
add_filter( 'prepend_attachment', 'meteor_attachment_size' );


/**
 * Add a js class
 */
function meteor_html_js_class () {
    echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>'. "\n";
}
add_action( 'wp_head', 'meteor_html_js_class', 1 );
