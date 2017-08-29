<?php
/**
 * Ampersand functions
 *
 * @package Ampersand
 * @since Ampersand 1.0
 */


if ( ! function_exists( 'ampersand_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 * @since Ampersand 1.0
 */
function ampersand_setup() {

	/* Add editor styles */
	add_editor_style( array( 'editor-style.css', ampersand_remote_fonts() ) );

	/* Add Customizer settings */
	require_once( get_template_directory() . '/inc/customizer.php' );

	/* Custom template tags for this theme */
	require_once( get_template_directory() . '/inc/template-tags.php' );

	/* Functionality for self-hosted sites only. */
	if( file_exists( get_template_directory() . '/inc/wporg.php' ) ) {
		require_once( get_template_directory() . '/inc/wporg.php' );
	}

	// TGM Activation class
	require_once( get_template_directory() . '/inc/admin/tgm/tgm-activation.php' );

	/* Add default posts and comments RSS feed links to head */
	add_theme_support( 'automatic-feed-links' );

	/* Enable support for Post Thumbnails */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true ); // Default Thumb
	add_image_size( 'portfolio-thumb', 700, 525, true ); // Portfolio Image
	add_image_size( 'blog-thumb', 650 ); // Blog Image
	add_image_size( 'post-image', 9999, 9999, false ); // Full Size Image

	/* Title Output */
	add_theme_support( 'title-tag' );

	/* Custom Background Support */
	add_theme_support( 'custom-background' );

	/* Custom Header Support */
	require get_template_directory() . '/inc/custom-header.php';

	/* Register Menu */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'ampersand' )
	) );

	/* Make theme available for translation */
	load_theme_textdomain( 'ampersand', get_template_directory() . '/languages' );

	/* Add excerpt to pages */
	add_post_type_support( 'page', 'excerpt' );

}
endif; // ampersand_setup
add_action( 'after_setup_theme', 'ampersand_setup' );


/**
 * Set the content width
 */
if ( ! isset( $content_width ) )
	$content_width = 770; /* pixels */


/**
 * Adjust the content width for full-width page template.
 */
function ampersand_set_content_width() {
	global $content_width;

	if ( is_page_template( 'full-width.php' ) )
		$content_width = 1050;
}
add_action( 'template_redirect', 'ampersand_set_content_width' );


/**
 * Pagination conditional
 */
function ampersand_page_has_nav() {
	global $wp_query;
	return ( $wp_query->max_num_pages > 1 );
}


/**
 * Enqueue scripts and styles
 */
function ampersand_scripts() {

	// Main Stylesheet
	wp_enqueue_style( 'ampersand-style', get_stylesheet_uri() );

	// Register the Roboto font
	wp_register_style( 'ampersand-roboto', ampersand_remote_fonts(), array() );

	// Enqueue the Roboto font
	wp_enqueue_style( 'ampersand-roboto' );

	// Font Awesome
	wp_enqueue_style( 'ampersand-fontawesome-css', get_template_directory_uri() . "/inc/fonts/fontawesome/font-awesome.css", array( 'ampersand-style' ), '4.1.0' );

	// Enqueue jQuery
	wp_enqueue_script( 'jquery' );

	// Custom Scripts
	wp_enqueue_script( 'ampersand-custom-js', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '2.2.1', true );

	// Localize Scripts
	wp_localize_script( 'ampersand-custom-js', 'ampersand_header_js_vars', array(
			'header_bg' => get_option( 'ampersand_customizer_bg_disable', 'enable' )
		)
	);

	// HoverIntent JS
	wp_enqueue_script( 'hoverIntent' );

	// Flexslider
	if ( is_page_template( 'homepage.php' ) ) {
		// Flexslider CSS
		wp_enqueue_style( 'ampersand-flexslider-css', get_template_directory_uri() . "/inc/styles/flexslider.css", array( 'ampersand-style' ), '2.2' );

		// Flexslider JS
		wp_enqueue_script( 'ampersand-flexslider-js', get_template_directory_uri() . '/js/jquery.flexslider.js', array(), '2.2', true );

		// Conditionally load JS
		wp_localize_script('ampersand-flexslider-js', 'ampersand_flexslider_js_vars', array(
				'load_flexslider' => 'true'
			)
		);
	}

	// Fitvids
	wp_enqueue_script( 'ampersand-fitvids-js', get_template_directory_uri() . '/js/jquery.fitvids.js', array(), '1.0.3', true );

	// Backstretch
	if ( get_option( 'ampersand_customizer_bg_disable' ) !== 'disable' ) {
		wp_enqueue_script( 'ampersand-backstretch-js', get_template_directory_uri() . '/js/jquery.backstretch.js', array(), '2.0.4', true );
	}

	// Small Menu
	wp_enqueue_script( 'ampersand-small-menu-js', get_template_directory_uri() . '/js/small-menu.js', array(), '20140813', true );

	// HTML5 IE Shiv
	wp_enqueue_script( 'ampersand-htmlshiv-js', get_template_directory_uri() . '/js/html5shiv.js', array(), '3.6.2', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20140813' );
	}
}
add_action( 'wp_enqueue_scripts', 'ampersand_scripts' );


/**
 * Registers the Google-hosted Roboto font
 */
function ampersand_remote_fonts() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Roboto, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'ampersand' ) ) {
		$font_url = add_query_arg( 'family', urlencode( 'Roboto:300,400,500,700,400italic,700italic' ), "https://fonts.googleapis.com/css" );
	}

	return $font_url;
}


/**
 * Enqueue Google fonts style to admin screen for custom header display
 */
function ampersand_admin_fonts( $hook_suffix ) {
	if ( 'appearance_page_custom-header' != $hook_suffix )
		return;

	wp_enqueue_style( 'ampersand-roboto' );
}
add_action( 'admin_enqueue_scripts', 'ampersand_admin_fonts' );


/**
 * Load Jetpack compatibility file
 */
if ( file_exists( get_template_directory() . '/inc/jetpack.php' ) )
	require( get_template_directory() . '/inc/jetpack.php' );


/**
 * Add large size attribute to portfolio gallery images
 */
function ampersand_portfolio_gallery( $out, $pairs, $atts ) {
	if ( is_page_template( 'template-portfolio-item.php' ) ) {
		$out['size'] = 'large';
	}
	return $out;
}
add_filter( 'shortcode_atts_gallery', 'ampersand_portfolio_gallery', 10, 3 );


/**
 * Add specific CSS class by filter
 */
function ampersand_post_class( $classes ) {
	if ( is_page_template( 'template-portfolio.php' ) ) {
		$classes[] = 'portfolio-column clearfix';
		return $classes;
	} else {
		$classes[] = 'post index-post';
		return $classes;
	}
}
add_filter( 'post_class', 'ampersand_post_class' );


/**
 * Register widgetized area and update sidebar with default widgets
 */
function ampersand_widgets_init() {
	register_sidebar( array(
		'name' 			=> __( 'Sidebar', 'ampersand' ),
		'id' 			=> 'sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</aside>',
		'before_title' 	=> '<h2 class="widget-title">',
		'after_title' 	=> '</h2>',
	) );

	register_sidebar( array(
		'name' 			=> __( 'Footer Left', 'ampersand' ),
		'id' 			=> 'footer-left',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</aside>',
		'before_title' 	=> '<h2 class="widget-title">',
		'after_title' 	=> '</h2>',
	) );

	register_sidebar( array(
		'name' 			=> __( 'Footer Center', 'ampersand' ),
		'id' 			=> 'footer-center',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</aside>',
		'before_title' 	=> '<h2 class="widget-title">',
		'after_title' 	=> '</h2>',
	) );

	register_sidebar( array(
		'name' 			=> __( 'Footer Right', 'ampersand' ),
		'id' 			=> 'footer-right',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</aside>',
		'before_title' 	=> '<h2 class="widget-title">',
		'after_title' 	=> '</h2>',
	) );
}
add_action( 'widgets_init', 'ampersand_widgets_init' );


if ( ! function_exists( 'ampersand_featured_image_url' ) ) :
/**
 * Retrieve featured image URL for header background
 */
function ampersand_featured_image_url() {
	global $post;

	if ( is_home() || is_archive() ) {
		/* If it's the static blog page, get the page ID instead of post ID to retreive featured image */
		if ( ! defined( 'get_the_ID' ) ) {
			$blog_id = get_the_id();
		}
		$page_id = ( 'page' == get_option( 'show_on_front' ) ? get_option( 'page_for_posts' ) : $blog_id );
		$get_bg_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $page_id ), 'full', false, '');
		$bg_image_url = esc_url( $get_bg_image_url[0] );
		if ( empty( $bg_image_url ) ) {
			$bg_image_url = get_header_image();
		}
	} elseif ( '' != get_the_post_thumbnail() ) {
		/* If there is a featured image, use it. */
		$get_bg_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full', false, '');
		$bg_image_url = esc_url( $get_bg_image_url[0] );
	} else {
		/* If there is no featured image, use the custom header */
		$bg_image_url = get_header_image();
	}

	/* If there is an image, prepare it for use in custom.js */
	if ( ! empty( $bg_image_url ) ) {
		wp_localize_script( 'ampersand-custom-js', 'ampersand_custom_js_vars', array(
				'bg_image_url' => $bg_image_url,
			)
		);
	} else {
		wp_localize_script( 'ampersand-custom-js', 'ampersand_custom_js_vars', array(
				'bg_image_url' => false,
			)
		);
	}

}
add_action( 'wp_enqueue_scripts', 'ampersand_featured_image_url' );
endif;


/**
 * Custom comment output
 */
function ampersand_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

		<div class="comment-block" id="comment-<?php comment_ID(); ?>">

			<div class="comment-info">
				<div class="comment-author vcard">
					<div class="vcard-wrap">
						<?php echo get_avatar( $comment->comment_author_email, 100 ); ?>
					</div>
				</div>

				<div class="comment-text">
					<div class="comment-meta commentmetadata">
						<?php printf( __( '<cite class="fn">%s</cite>', 'ampersand' ), get_comment_author_link() ); ?>

						<div class="comment-time">
							<?php
								printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'ampersand' ), get_comment_date(), get_comment_time() )
								);
							?>
							<?php edit_comment_link( '<i class="icon-edit"></i>', '' ); ?>
						</div>
					</div>
					<?php comment_text(); ?>

					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div>
			</div>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'ampersand' ); ?></em>
			<?php endif; ?>
		</div>
<?php
}


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function ampersand_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'ampersand' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'ampersand_wp_title', 10, 2 );


/**
 * Show full-width images on attachment pages
 *
 * @since  2.1.8
 */
function ampersand_prepend_attachment( $p ) {
	if ( is_attachment() ) {
		return '<p class="attachment">' . wp_get_attachment_link( 0, 'post-image', false ) . '</p>';
	}
}
add_filter( 'prepend_attachment', 'ampersand_prepend_attachment');


/**
 * Site title and logo
 */
function ampersand_title_logo() { ?>

	<div class="site-title-wrap">

		<?php if ( get_theme_mod( 'ampersand_customizer_logo' ) ) { ?>

			<?php if ( is_front_page() ) { ?>
				<h1 class="logo-image">
					<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
						<img src="<?php echo esc_url( get_theme_mod( 'ampersand_customizer_logo' ) );?>" alt="<?php the_title_attribute(); ?>" />
					</a>
				</h1>
 			<?php } else { ?>
				<p class="logo-image">
					<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
						<img src="<?php echo esc_url( get_theme_mod( 'ampersand_customizer_logo' ) );?>" alt="<?php the_title_attribute(); ?>" />
					</a>
				</p>
 			<?php } ?>

		<?php } else { ?>

			<?php if ( is_front_page() ) { ?>
				<h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</h1>
 			<?php } else { ?>
				<p class="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</h1>
 			<?php } ?>

			<?php if ( ! get_theme_mod( 'ampersand_hide_tagline', true ) ) { ?>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			<?php } ?>

		<?php } ?>
	</div><!-- .site-title-wrap -->
<?php }
