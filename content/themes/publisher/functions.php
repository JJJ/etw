<?php
/**
 * Publisher functions and definitions
 *
 * @package Publisher
 * @since Publisher 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Publisher 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 770; /* pixels */


if ( ! function_exists( 'publisher_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 * @since publisher 1.0
 */
function publisher_setup() {

	/* Functionality for self-hosted sites. File is not deployed to WP.com. */
	if( file_exists( get_template_directory() . '/inc/wporg.php' ) ) {
		require_once( get_template_directory() . '/inc/wporg.php' );
	}

	/* Custom template tags for this theme */
	require( get_template_directory() . '/inc/template-tags.php' );

	/* Add Customizer settings */
	require( get_template_directory() . '/inc/customizer.php' );

	/* TGM activation class */
	require_once( get_template_directory() . '/inc/admin/tgm/tgm-activation.php' );

	/* Add default posts and comments RSS feed links to head */
	add_theme_support( 'automatic-feed-links' );

	/* Add editor styles */
	add_editor_style();

	/* Enable support for Post Thumbnails */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true ); // Default Thumb
	add_image_size( 'block-thumb', 500, 9999, false ); // Block Thumb
	add_image_size( 'post-image', 1000, 600, true ); // Headline Thumb
	add_image_size( 'image-format', 9999, 9999, false ); // Image Post Format

	/* Add support for Post Formats */
	add_theme_support( 'post-formats', array(
	    'image', 'quote'
	) );

	/* Infinite Scroll Support */
	add_theme_support( 'infinite-scroll', array(
		'container'	=> 'block-container',
		'footer'	=> 'block-container',
		'wrapper'	=> 'new-infinite-posts',
		'render'	=> 'publisher_render_infinite_posts',
	));

	/* Responsive Video */
	add_theme_support( 'jetpack-responsive-videos' );

	/* Custom Background Support */
	add_theme_support( 'custom-background' );

	/* Custom Header Support */
	require_once ( get_template_directory() . '/inc/custom-header.php' );

	/* This theme uses wp_nav_menu() in one location. */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'publisher' )
	) );

	/* Make theme available for translation */
	load_theme_textdomain( 'publisher', get_template_directory() . '/languages' );

}
endif; // publisher_setup
add_action( 'after_setup_theme', 'publisher_setup' );


/* Pagination Conditional */
function publisher_page_has_nav() {
	global $wp_query;
	return ( $wp_query->max_num_pages > 1 );
}


/* Render infinite posts by using the template-block.php template */
function publisher_render_infinite_posts() {
	while ( have_posts() ) {
		the_post();

		get_template_part( 'templates/template-block' );
	}
}


/* Retreive current user's posts */
function publisher_author_posts() {
    global $post, $authordata;

    $authors_posts = get_posts( array( 'author' => $authordata->ID, 'post__not_in' => array( $post->ID ) ) );

    $output = '<ul>';
		foreach ( $authors_posts as $post ) {
			setup_postdata( $post );
			$output .= '<li><span>' . get_the_date( 'm.d.y' ) . '</span><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></li>';
		}
		wp_reset_postdata();
	$output .= '</ul>';

	return $output;
}


/* Register widgetized area and update sidebar with default widgets */
function publisher_widgets_init() {
	register_sidebar( array(
		'name' 				=> __( 'Sidebar', 'publisher' ),
		'id' 				=> 'sidebar',
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget' 		=> '</aside>',
		'before_title' 		=> '<h2 class="widget-title">',
		'after_title' 		=> '</h2>',
	) );
}
add_action( 'widgets_init', 'publisher_widgets_init' );


/**
 * Return the Google font stylesheet URL
 */
function publisher_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Arimo, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$arimo = _x( 'on', 'Arimo font: on or off', 'publisher' );

	if ( 'off' !== $arimo ) {
		$font_families = array();

		if ( 'off' !== $arimo )
			$font_families[] = 'Arimo:400,700,400italic,700italic';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "https://fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Enqueue Google fonts style to admin for editor styles
 */
function publisher_admin_fonts( $hook_suffix ) {
	wp_enqueue_style( 'publisher-fonts', publisher_fonts_url(), array(), null );
}
add_action( 'admin_enqueue_scripts', 'publisher_admin_fonts' );


/* Enqueue scripts and styles */
function publisher_scripts() {

	//Enqueue jQuery
	wp_enqueue_script( 'jquery' );

	//Enqueue Masonry
	wp_enqueue_script( 'jquery-masonry' );

	//Custom Scripts
	wp_enqueue_script( 'publisher-custom-js', get_template_directory_uri() . '/js/custom.js', array(), '2.1.9', true );

	//Backstretch
	if ( get_option( 'publisher_customizer_bg_disable' ) == 'enable' ) {
		wp_enqueue_script( 'publisher-backstretch-js', get_template_directory_uri() . '/js/jquery.backstretch.js', array(), '2.0.4', true );
	}

	// HoverIntent
	wp_enqueue_script( 'hoverIntent' );

	//Small Menu
	wp_enqueue_script( 'publisher-small-menu-js', get_template_directory_uri() . '/js/small-menu.js', array(), '2.1.9', true );

	//HTML5 IE Shiv
	wp_enqueue_script( 'publisher-htmlshiv-js', get_template_directory_uri() . '/js/html5shiv.js', array(), '3.6.2', true );

	//Main Stylesheet
	wp_enqueue_style( 'publisher-style', get_stylesheet_uri() );

	//Font Awesome
	wp_enqueue_style( 'publisher-fontawesome-css', get_template_directory_uri() . "/inc/fonts/fontawesome/font-awesome.css", array( 'publisher-style' ), '4.0.3' );

	//Load Arimo from Google
	wp_enqueue_style( 'publisher-fonts', publisher_fonts_url(), array(), null );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '2.1.9' );
	}
}
add_action( 'wp_enqueue_scripts', 'publisher_scripts' );


/* Retrieve featured image URL for background */
function publisher_featured_image_url() {
	global $post;

	if ( !is_object( $post ) ) {
		 wp_localize_script( 'publisher-custom-js', 'publisher_bg_js_vars', array(
		 	'bg_image' => false )
		 );
	} else {
		$bg_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full', false );
		$bg_image_url_esc = esc_url( $bg_image_url[0] );

		wp_localize_script( 'publisher-custom-js', 'publisher_bg_js_vars', array(
				'bg_image' => get_option( 'publisher_customizer_bg_disable', 'disable' )
			)
		);
	}

	/* If there is an image, prepare it for use in custom.js */
	if ( ! empty( $bg_image_url ) ) {
		wp_localize_script( 'publisher-custom-js', 'publisher_custom_js_vars', array(
				'bg_image_url' => $bg_image_url_esc
			)
		);
	} else {
		wp_localize_script( 'publisher-custom-js', 'publisher_custom_js_vars', array(
				'bg_image_url' => false
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'publisher_featured_image_url' );


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function publisher_wp_title( $title, $sep ) {
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
		$title .= " $sep " . sprintf( __( 'Page %s', 'publisher' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'publisher_wp_title', 10, 2 );


/* Custom Comment Output */
function publisher_comment( $comment, $args, $depth ) {
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
						<?php printf( __( '<cite class="fn">%s</cite>', 'publisher' ), get_comment_author_link() ); ?>

						<div class="comment-time">
							<?php
								printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'publisher' ), get_comment_date(), get_comment_time() )
								);
							?>
							<?php edit_comment_link('<i class="fa fa-edit"></i>', ''); ?>
						</div>
					</div>

					<?php comment_text(); ?>

					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div>
			</div>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'publisher'); ?></em>
			<?php endif; ?>
		</div>
<?php
}
