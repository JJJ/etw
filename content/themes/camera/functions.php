<?php
/**
 * Camera functions and definitions
 *
 * @package Camera
 */

/**
 * Set the content width
 */
if ( ! isset( $content_width ) ) {
	$content_width = 638; /* pixels */
}

/**
 * Adjust the content width for Gallery post formats
 */
function camera_set_content_width() {
	global $content_width;

	if ( has_post_format( 'gallery' ) )
		$content_width = 1100;
}
add_action( 'template_redirect', 'camera_set_content_width' );

/**
 * Sets up Camera's defaults and registers support for various WordPress features
 */
if ( ! function_exists( 'camera_setup' ) ) :

function camera_setup() {

	/**
     * Add styles to post editor (editor-style.css)
     */
	add_editor_style();

	/*
	 * Make theme available for translation
	 */
	load_theme_textdomain( 'camera', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true ); // Default Thumb
	add_image_size( 'large-image', 1400, 9999, false ); // Large post image
	add_image_size( 'logo', 300, 9999, false ); // Logo size
	add_image_size( 'author-posts-thumb', 100, 100, true ); // Author posts featured image
	add_image_size( 'author-bio-avatar', 60, 60, true ); // Author posts avatar

	/**
	 * Add video metabox
	 */
	add_theme_support( 'array_themes_video_support' );

	/**
	 * Register Navigation menu
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'camera' ),
		'footer'  => __( 'Footer Menu', 'camera' )
	) );

	/**
	 * Add Site Logo feature
	 */
	add_theme_support( 'site-logo', array(
		'header-text' => array(
			'site-title-wrap',
		),
		'size' => 'logo',
	) );

	/**
	 * Custom background feature
	 */
	add_theme_support( 'custom-background', apply_filters( 'camera_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => ''
	) ) );

	/**
	 * Gallery post format
	 */
	add_theme_support( 'post-formats', array( 'gallery' ) );

	/**
	 * Enable HTML5 markup
	 */
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
	) );

	/**
	 * Add excerpt to pages (used as page subtitles)
	 */
	add_post_type_support( 'page', 'excerpt' );

	/**
	 * Add support for title tag
	 */
	add_theme_support( 'title-tag' );
}
endif; // camera_setup
add_action( 'after_setup_theme', 'camera_setup' );

/**
 * Register widget area
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function camera_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'camera' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears when the right sidebar is expanded.', 'camera' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'camera_widgets_init' );

/**
 * Return the Google font stylesheet URL
 */
function camera_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Noto Sans, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$noto = _x( 'on', 'Noto Sans font: on or off', 'camera' );

	if ( 'off' !== $noto ) {
		$font_families = array();

		if ( 'off' !== $noto )
			$font_families[] = 'Noto Sans:400,700,400italic,700italic';

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
function camera_admin_fonts( $hook_suffix ) {
	wp_enqueue_style( 'camera-fonts', camera_fonts_url(), array(), null );
}
add_action( 'admin_enqueue_scripts', 'camera_admin_fonts' );

/**
 * Enqueue scripts and styles
 */
function camera_scripts() {

	wp_enqueue_style( 'camera-style', get_stylesheet_uri() );

	/**
     * FontAwesome Icons Stylesheet
     */
	wp_enqueue_style( 'camera-font-awesome-css', get_template_directory_uri() . "/inc/fontawesome/font-awesome.css", array(), '4.1.0', 'screen' );

	/**
     * Load Camera's javascript
     */
	wp_enqueue_script( 'camera-js', get_template_directory_uri() . '/js/camera.js', array( 'jquery' ), '1.0.2', true );

	/**
     * Load Slick Slider
     */
	wp_enqueue_script( 'camera-slick-js', get_template_directory_uri() . '/js/slick/slick.js', array( 'jquery' ), '1.3.3', true );

	wp_enqueue_style( 'camera-slick-css', get_template_directory_uri() . "/js/slick/slick.css", array(), '4.1.0', 'screen' );

	/**
     * HoverIntent
     */
	wp_enqueue_script( 'hoverIntent' );

	/**
     * Load Noto Sans from Google
     */
	wp_enqueue_style( 'camera-fonts', camera_fonts_url(), array(), null );

	/**
     * Load the comment reply script
     */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'camera_scripts' );

/**
 * Custom template tags for Camera
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer theme options
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Self-hosted functionality
 */
if( file_exists( get_template_directory() . '/inc/wporg.php' ) ) {
	require get_template_directory() . '/inc/wporg.php';
}

/**
 * Load Jetpack compatibility file
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Add large size attribute to Gallery format images
 */
function camera_carousel_gallery( $out, $pairs, $atts ) {
	global $post;

	if ( has_post_format( 'gallery' ) ) {
		$out['size'] = 'large';
	}
	return $out;
}
add_filter( 'shortcode_atts_gallery', 'camera_carousel_gallery', 10, 3 );

/* Add dark color scheme class to body */
function camera_body_class( $classes ) {

	if( get_option( 'camera_color_scheme' ) == 'dark' ) {
		$classes[] = 'dark';
	}
	return $classes;
}
add_filter( 'body_class', 'camera_body_class' );

/**
 * Replaces the excerpt ellipsis with a Read More link
 */
function camera_new_excerpt_more( $more ) {
	global $post;
	return '&hellip; <p><a class="more-link" href="'. get_permalink( $post->ID ) . '">Read More &rarr;</a></p>';
}
add_filter( 'excerpt_more', 'camera_new_excerpt_more' );

/**
 * Add class to pagination links
 */
function camera_posts_link_attributes() {
    return ' class="prev-right" ';
}
add_filter( 'previous_posts_link_attributes', 'camera_posts_link_attributes' );

/**
 * Changes the text of the "Older posts" button in infinite scroll
 * for portfolio related views.
 */
function camera_infinite_scroll_button_text( $js_settings ) {

	$js_settings['text'] = '<i class="fa fa-plus"></i>' . esc_js( __( 'More Posts', 'camera' ) );

	return $js_settings;

}
add_filter( 'infinite_scroll_js_settings', 'camera_infinite_scroll_button_text' );

/**
 * Get post author's posts
 */
function camera_author_posts() {
    global $post, $authordata;

    $authors_posts = get_posts( array(
		'author'         => $authordata->ID,
		'post__not_in'   => array( $post->ID ),
		'posts_per_page' => 3 )
    );

	foreach ( $authors_posts as $post ) {

		setup_postdata( $post );

		$feat_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'author-posts-thumb' );?>

		<li>
			<?php if ( $feat_image ) { ?>
				<a href="<?php the_permalink(); ?>"><img class="author-posts-thumb" alt="<?php the_title_attribute(); ?>" src="<?php echo esc_url( $feat_image ); ?>" /></a>
			<?php } ?>

			<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
			<div class="author-posts-date"><?php echo get_the_date(); ?></div>
		</li>

		<?php
	}
	wp_reset_postdata();
}


/**
 * Custom comment output
 */
function camera_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>

	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

		<div class="comment-block" id="comment-<?php comment_ID(); ?>">

			<?php echo get_avatar( $comment->comment_author_email, 75 ); ?>
			<div class="comment-info">
				<?php printf( __( '<cite class="comment-cite">%s</cite>', 'camera' ), get_comment_author_link() ) ?>
				<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf( __( '%1$s at %2$s', 'camera' ), get_comment_date(), get_comment_time() ) ?></a><?php edit_comment_link( __( '(Edit)', 'camera' ), '  ', '' ) ?>
			</div>

			<div class="comment-content">
				<?php comment_text() ?>
				<p class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
				</p>
			</div>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'camera' ) ?></em>
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
if ( ! function_exists( '_wp_render_title_tag' ) ) :
	function camera_wp_title( $title, $sep ) {
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
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'camera' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'camera_wp_title', 10, 2 );
endif;

/**
 * Title shiv for blogs older than WordPress 4.1
 */
if ( ! function_exists( '_wp_render_title_tag' ) ) :
	function camera_render_title() {
		echo '<title>' . wp_title( '|', false, 'right' ) . "</title>\n";
	}
	add_action( 'wp_head', 'camera_render_title' );
endif;


/**
 * Gets the gallery shortcode data from post content.
 */
function camera_gallery_data() {
	global $post;
	$pattern = get_shortcode_regex();
	if (   preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
		&& array_key_exists( 2, $matches )
		&& in_array( 'gallery', $matches[2] ) )
	{

		return $matches;
	}
}