<?php
/**
 * Medium functions
 *
 * @package Medium
 * @since Medium 1.0
 */


/* Set the content width */
if ( ! isset( $content_width ) )
	$content_width = 670; /* pixels */


if ( ! function_exists( 'medium_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 * @since Medium 1.0
 */
function medium_setup() {

	// Admin functionality
	if ( is_admin() ) {
		// Add editor styles
		add_editor_style();

		// Load Getting Started page and initialize EDD update class
		require_once( get_template_directory() . '/includes/admin/getting-started/getting-started.php' );

		// Meta boxes
		require_once( get_template_directory() . '/includes/admin/metabox/metabox.php' );
	}

	// Customizer settings
	require_once( get_template_directory() . '/customizer.php' );

	// Add posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );


	// Enable support for Post Thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true ); // Default Thumb
	add_image_size( 'large-image', 9999, 9999, false ); // Large Post Image

	// Custom Background Support
	add_theme_support( 'custom-background' );

	// Add gallery support
	add_theme_support( 'array_themes_gallery_support' );

	// Add support for legacy widgets
	add_theme_support( 'array_toolkit_legacy_widgets' );

	// Register Menu
	register_nav_menus( array(
		'main'   => __( 'Main Menu', 'medium' ),
		'custom' => __( 'Custom Menu', 'medium' )
	) );

	// Make theme available for translation
	load_theme_textdomain( 'medium', get_template_directory() . '/languages' );

	// Gallery Post Format
	add_theme_support( 'post-formats', array( 'gallery') );

}
endif; // medium_setup
add_action( 'after_setup_theme', 'medium_setup' );


/* Enqueue Scripts and Styles */
function medium_scripts_styles() {

	// Get theme version
	$version = wp_get_theme()->Version;

	// Enqueue Styles

	// Main Stylesheet
	wp_enqueue_style( 'medium-style', get_stylesheet_uri() );

	// Font Awesome CSS
	wp_enqueue_style( 'font-awesome-css', get_template_directory_uri() . "/includes/fonts/fontawesome/font-awesome.min.css", array(), '4.0.3', 'screen' );

	// NanoScroller
	wp_enqueue_style( 'nanoscroller-css', get_template_directory_uri() . "/includes/js/nanoscroller/nanoscroller.css", array(), '0.1', 'screen' );

	// Media Queries CSS
	wp_enqueue_style( 'media-queries-css', get_template_directory_uri() . "/media-queries.css", array( 'medium-style' ), $version, 'screen' );

	// Flexslider
	wp_enqueue_style( 'flexslider-css', get_template_directory_uri() . "/includes/styles/flexslider.css", array(), '2.1', 'screen' );

	// Enqueue Scripts

	// Custom JS
	wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/includes/js/custom/custom.js', array( 'jquery' ), '20130731', true );
	wp_localize_script( 'custom-js', 'custom_js_vars', array(
			'infinite_scroll' 		=> get_option( 'medium_customizer_infinite' ),
			'infinite_scroll_image' => get_template_directory_uri()
		)
	);

	// FidVid
	wp_enqueue_script('fitvid-js', get_template_directory_uri() . '/includes/js/fitvid/jquery.fitvids.js', array( 'jquery' ), '1.0.3', true );

	// Flexslider
	wp_enqueue_script('flexslider-js', get_template_directory_uri() . '/includes/js/flexslider/jquery.flexslider-min.js', array(), '2.1', true );

	// Enquire
	wp_enqueue_script('enquire-js', get_template_directory_uri() . '/includes/js/enquire/enquire.min.js', array(), '1.5.3', true );

	// NanoScroller
	wp_enqueue_script('nanoscroller-js', get_template_directory_uri() . '/includes/js/nanoscroller/jquery.nanoscroller.min.js', array( 'jquery' ), $version, true );

	// Infinite Scroll
	if ( get_option( 'medium_customizer_infinite' ) == 'disabled' ) { } else {
		wp_enqueue_script( 'infinite-js', get_template_directory_uri() . '/includes/js/infinitescroll/jquery.infinitescroll.min.js', array( 'jquery' ), '2.0', true );
	}

	// Comment reply script
	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'medium_scripts_styles' );


/**
 * Registers Widget Areas
 *
 */
function medium_register_sidebars() {

	register_sidebar( array(
		'name'          => __( 'Left Sidebar', 'medium' ),
		'id'            => 'left-sidebar',
		'description'   => __( 'Widgets in this area will be shown in the sidebar.', 'medium' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle accordion-toggle">',
		'after_title'   => '</h2>'
	) );

	register_sidebar( array(
		'name'          => __( 'Right Sidebar', 'medium' ),
		'id'            => 'right-sidebar',
		'description'   => __( 'Widgets in this area will be shown in the right sidebar.', 'medium' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	) );
}
add_action( 'widgets_init', 'medium_register_sidebars' );


/**
 * Deprecated page navigation
 *
 * @deprecated 2.0 Replaced by medium_page_nav()
 */
function medium_page_has_nav() {

	_deprecated_function( __FUNCTION__, '2.0', 'medium_page_nav()' );
	return false;
}



/**
 * Displays post pagination links
 *
 * @since 2.0
 */
function medium_page_nav() {

	// Return early if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	} ?>
	<div class="post-nav <?php if ( get_option('medium_customizer_infinite') == 'enabled' ) { echo 'infinite'; } ?>">
		<div class="post-nav-inside">
			<div class="post-nav-left"><?php previous_posts_link(__('<i class="fa fa-arrow-left"></i> Newer Posts', 'medium')) ?></div>
			<div class="post-nav-right"><?php next_posts_link(__('Older Posts <i class="fa fa-arrow-right"></i>', 'medium')) ?></div>
		</div>
	</div>
	<?php
}



/**
 * Customizes the excerpt Read More link
 */
function medium_new_excerpt_more( $more ) {

	global $post;
	return ' <a class="more-link" href="'. get_permalink( $post->ID ) . '">Read More</a>';
}
add_filter( 'excerpt_more', 'medium_new_excerpt_more' );



/**
 * Adds Customizer CSS To Header
 */
function medium_customizer_css() {
    ?>
	<style type="text/css">
		.entry-text a {
			color: <?php echo get_theme_mod( 'medium_customizer_link', '#999' ) ;?> !important;
		}

		nav h2 i, .header .widget_categories:before, .header .widget_recent_comments:before, .header .widget_recent_entries:before, .header .widget_meta:before, .header .widget_links:before, .header .widget_archive:before, .widget_pages:before, .widget_calendar:before, .widget_tag_cloud:before, .widget_text:before, .widget_nav_menu:before, .widget_search:before {
			color: <?php echo get_theme_mod( 'medium_customizer_accent', '#3ac1e8' ); ?> !important;
		}

		.tagcloud a {
			background: <?php echo get_theme_mod( 'medium_customizer_accent', '#3ac1e8' ); ?> !important;
		}

		<?php echo get_theme_mod( 'medium_customizer_css', '' ); ?>
	</style>
    <?php
}
add_action( 'wp_head', 'medium_customizer_css' );


/**
 * Custom Comment Output
 */
function medium_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class('clearfix'); ?> id="li-comment-<?php comment_ID() ?>">

		<div class="comment-block" id="comment-<?php comment_ID(); ?>">
			<div class="comment-info">
				<div class="comment-author vcard clearfix">
					<?php echo get_avatar( $comment->comment_author_email, 75 ); ?>

					<div class="comment-meta commentmetadata">
						<?php printf(__('<cite class="fn">%s</cite>', 'medium'), get_comment_author_link()) ?>
						<div style="clear:both;"></div>
						<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s - %2$s', 'medium'), get_comment_date('m/d/Y'),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)', 'medium'),'  ','') ?>
					</div>
				</div>
			<div class="clearfix"></div>
			</div>

			<div class="comment-text">
				<?php comment_text() ?>
				<p class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
				</p>
			</div>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'medium') ?></em>
			<?php endif; ?>
		</div>
<?php
}

function medium_cancel_comment_reply_button( $html, $link, $text ) {
    $style = isset($_GET['replytocom']) ? '' : ' style="display:none;"';
    $button = '<div id="cancel-comment-reply-link"' . $style . '>';
    return $button . '<i class="fa fa-times"></i> </div>';
}
add_action( 'cancel_comment_reply_link', 'medium_cancel_comment_reply_button', 10, 3 );



/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function medium_wp_title( $title, $sep ) {
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
		$title .= " $sep " . sprintf( __( 'Page %s', 'medium' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'medium_wp_title', 10, 2 );



/**
 * Sets the authordata global when viewing an author archive.
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function medium_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'medium_setup_author' );
