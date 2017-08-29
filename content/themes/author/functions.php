<?php
/**
 * Author functions, scripts and styles.
 *
 * @package Author
 * @since Author 1.0
 */


if ( ! function_exists( 'author_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 * @since Author 1.0
 */
function author_setup() {

	/* Add custom post styles */
	require( get_template_directory() . '/includes/editor/add-styles.php' );

	/* Add Customizer settings */
	require( get_template_directory() . '/customizer.php' );

	/**
	 * TGM Activation class
	 */
	require_once( get_template_directory() . '/includes/admin/tgm/tgm-activation.php' );

	/* Admin functionality */
	if ( is_admin() ) {
		// Getting Started page and EDD update class
		require_once( get_template_directory() . '/includes/admin/updater/theme-updater.php' );
		// Video meta box
		require_once( get_template_directory() . '/includes/admin/metabox.php' );
	}

	/* Add default posts and comments RSS feed links to head */
	add_theme_support( 'automatic-feed-links' );

	/* Add editor styles */
	add_editor_style();

	/* Enable support for Post Thumbnails */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true ); // Default Thumb
	add_image_size( 'large-image', 9999, 9999, false ); // Large Post Image

	/* Custom Background Support */
	add_theme_support( 'custom-background' );

	/* Register Menu */
	register_nav_menus( array(
		'main' 		=> __( 'Main Menu', 'author' ),
		'secondary' => __( 'Secondary', 'author' ),
		'footer' 	=> __( 'Footer Menu', 'author' ),
		'custom' 	=> __( 'Custom Menu', 'author' )
	) );

	/* Make theme available for translation */
	load_theme_textdomain( 'author', get_template_directory() . '/languages' );

	/* Add gallery format and custom gallery support */
	add_theme_support( 'post-formats', array( 'gallery' ) );
	add_theme_support( 'array_themes_gallery_support' );

	// Add support for legacy widgets
	add_theme_support( 'array_toolkit_legacy_widgets' );

}
endif; // author_setup
add_action( 'after_setup_theme', 'author_setup' );


/* Enqueue scripts and styles */
function author_scripts() {

	$version = wp_get_theme()->Version;

	//Main Stylesheet
	wp_enqueue_style( 'author-style', get_stylesheet_uri() );

	//Media Queries CSS
	wp_enqueue_style( 'media-queries-css', get_template_directory_uri() . "/media-queries.css", array( 'author-style' ), $version, 'screen' );

	//Font Awesome
	wp_enqueue_style( 'author-fontawesome-css', get_template_directory_uri() . "/includes/fonts/fontawesome/font-awesome.min.css", array(), '4.0.3', 'screen' );

	//Flexslider CSS
	wp_enqueue_style( 'author-flexslider-css', get_template_directory_uri() . "/includes/js/flexslider/flexslider.css", array(), '2.2.0', 'screen' );

	//Google Font
	wp_enqueue_style( 'google-roboto', author_fonts_url(), array(), null );

	//Custom Scripts
	wp_enqueue_script( 'author-custom-js', get_template_directory_uri() . '/includes/js/custom/custom.js', array( 'jquery' ), $version, true );

	//Fitvids
	wp_enqueue_script( 'author-fitvids-js', get_template_directory_uri() . '/includes/js/fitvid/jquery.fitvids.js', array( 'jquery' ), '1.0.3', true );

	//Flexslider
	wp_enqueue_script( 'author-flexslider-js', get_template_directory_uri() . '/includes/js/flexslider/jquery.flexslider.js', array( 'jquery' ), '2.2.0', true );

	//HTML5 IE Shiv
	wp_enqueue_script( 'author-htmlshiv-js', get_template_directory_uri() . '/includes/js/html5/html5shiv.js', array(), '3.7.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'author_scripts' );


/* Set the content width */
if ( ! isset( $content_width ) )
	$content_width = 690; /* pixels */


/* Register sidebars */
function author_register_sidebars() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'author' ),
		'id'            => 'sidebar',
		'description'   => __( 'Widgets in this area will be shown on the sidebar of all pages.', 'author' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Icons', 'author' ),
		'id'            => 'footer-icons',
		'description'   => __( 'This widget area is for the social media icons widget in the footer.', 'author' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	) );
}
add_action( 'widgets_init', 'author_register_sidebars' );



/* If excerpt slider is enabled, ignore sticky posts since we feature them in the slider */
function author_ignore_sticky( $query ) {
	if ( is_home() && $query->is_main_query() && get_option( 'author_customizer_slider_disable') == 'enable' )
        $query->set('ignore_sticky_posts', true);
}
add_action( 'pre_get_posts', 'author_ignore_sticky' );


/* Pagination conditional */
function author_page_has_nav() {
	global $wp_query;
	return ($wp_query->max_num_pages > 1);
}


/* Add Customizer CSS To Header */
function author_customizer_css() {
    ?>
	<style type="text/css">
		.post-content a {
			color: <?php echo get_theme_mod( 'author_customizer_accent', '#55BEE6' ) ;?>;
		}

		.ribbon {
			border-color: <?php echo get_theme_mod( 'author_customizer_accent', '#55BEE6' ) ;?> <?php echo get_theme_mod( 'author_customizer_accent', '#55BEE6' ) ;?> white;
		}

		<?php echo get_theme_mod( 'author_customizer_css', '' ); ?>
	</style>
    <?php
}
add_action( 'wp_head', 'author_customizer_css' );


/* Custom Comment Output */
function author_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class('clearfix'); ?> id="li-comment-<?php comment_ID() ?>">

		<div class="comment-block" id="comment-<?php comment_ID(); ?>">
			<div class="comment-info">
				<div class="comment-author vcard clearfix">
					<?php echo get_avatar( $comment->comment_author_email, 75 ); ?>

					<div class="comment-meta commentmetadata">
						<?php printf(__('<cite class="fn">%s</cite>', 'author'), get_comment_author_link()) ?>
					</div>
				</div>
			</div><!-- comment info -->

			<div class="comment-text">
				<?php comment_text() ?>

				<div class="comment-bottom">
					<p class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
					</p>
					<?php edit_comment_link(__('Edit', 'author'),' ', '' ) ?>
					<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s', 'author'), get_comment_date(),  get_comment_time()) ?></a>
				</div>
			</div><!-- comment text -->

			<?php if ($comment->comment_approved == '0') : ?>
				<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'author') ?></em>
			<?php endif; ?>
		</div>
<?php
}

function author_cancel_comment_reply_button( $html, $link, $text ) {
    $style = isset($_GET['replytocom']) ? '' : ' style="display:none;"';
    $button = '<div id="cancel-comment-reply-link"' . $style . '>';
    return $button . '<i class="fa fa-times"></i> </div>';
}

add_action( 'cancel_comment_reply_link', 'author_cancel_comment_reply_button', 10, 3 );


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function author_wp_title( $title, $sep ) {
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
		$title .= " $sep " . sprintf( __( 'Page %s', 'author' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'author_wp_title', 10, 2 );


/**
 * Sets the authordata global when viewing an author archive.
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function author_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'author_setup_author' );


/**
 * Return the Google font stylesheet URL
 */
function author_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Roboto, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$roboto = _x( 'on', 'Roboto font: on or off', 'author' );

	if ( 'off' !== $roboto ) {

		$query_args = array(
			'family' => urlencode( 'Roboto:300,400' ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}