<?php
/**
 * North functions
 *
 * @package North
 * @since North 1.0
 */

/* Set the content width */
if ( ! isset( $content_width ) )
	$content_width = 760; /* pixels */


if ( ! function_exists( 'north_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 * @since North 1.0
 */
function north_setup() {

	if( is_admin() ) {

		// Load Getting Started page and initialize EDD update class
		require_once( get_template_directory() . '/includes/admin/updater/theme-updater.php' );

		// Meta boxes
		require_once( get_template_directory() . '/includes/admin/metabox/metabox.php' );

		// TGM Activation class
		require_once( get_template_directory() . '/includes/admin/tgm/tgm-activation.php' );

		// Add editor styles
		add_editor_style();
	}

	// Add Customizer settings
	require_once( get_template_directory() . '/customizer.php' );

	// Load portfolio sidebar widget
	require_once( get_template_directory() . '/includes/widgets/recent-portfolio.php' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true ); // Default Thumb
	add_image_size( 'large-image', 9999, 800, true ); // Large Post Image
	add_image_size( 'home-image', 790, 790, true ); // Home Thumb Image
	add_image_size( 'sidebar-image', 500, 312, true ); // Sidebar Image
	add_image_size( 'blog-image', 730, 9999, false ); // Blog Image

	// Enable portfolio, gallery, slider, metabox, and widgets
	add_theme_support( 'array_themes_portfolio_support' );
	add_theme_support( 'array_themes_gallery_support' );
	add_theme_support( 'array_themes_metabox_support' );
	add_theme_support( 'array_toolkit_legacy_widgets' );
	add_theme_support( 'post-formats', array( 'gallery' ) );

	// Register Menus
	register_nav_menus( array(
		'main'   => __( 'Main Menu', 'north' ),
		'custom' => __( 'Custom Menu', 'north' )
	) );

	// Make theme available for translation
	load_theme_textdomain( 'north', get_template_directory() . '/languages' );
}
endif; // north_setup
add_action( 'after_setup_theme', 'north_setup' );



/**
 * Enqueues Scripts and Styles
 */
function north_scripts_styles() {

	$version = wp_get_theme()->Version;

	//Enqueue Styles

	//Main Stylesheet
	wp_enqueue_style( 'north-style', get_stylesheet_uri() );

	//Font Awesome CSS
	wp_enqueue_style( 'north-font-awesome-css', get_template_directory_uri() . "/includes/fonts/fontawesome/font-awesome.min.css", array(), '4.0.3', 'screen' );

	// Google Roboto Font
	wp_enqueue_style( 'north-fonts', north_fonts_url(), array(), null );

	//Media Queries CSS
	wp_enqueue_style( 'north-media-queries-css', get_template_directory_uri() . "/media-queries.css", array(), $version, 'screen' );

	//Flexslider
	wp_enqueue_style( 'north-flexslider-css', get_template_directory_uri() . "/includes/js/flexslider/flexslider.css", array(), '2.2.0', 'screen' );

	//Enqueue Scripts

	//Custom JS
	wp_enqueue_script( 'north-custom-js', get_template_directory_uri() . '/includes/js/custom/custom.js', array( 'jquery', 'north-flexslider-js', 'north-fitvid-js' ), $version, true );

	//Flexslider
	wp_enqueue_script( 'north-flexslider-js', get_template_directory_uri() . '/includes/js/flexslider/jquery.flexslider.js', array( 'jquery' ), '2.2.0', true );

	//FitVid
	wp_enqueue_script( 'north-fitvid-js', get_template_directory_uri() . '/includes/js/fitvid/jquery.fitvids.js', array( 'jquery' ), '1.0.3', true );

	//View.js
	wp_enqueue_script( 'north-view-js', get_template_directory_uri() . '/includes/js/view/view.min.js?auto', array( 'jquery' ), '3.6.2', true );


	//HTML5 IE Shiv
	wp_enqueue_script( 'north-htmlshiv-js', get_template_directory_uri() . '/includes/js/ie/html5shiv.js', array(), '20130731', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'north_scripts_styles' );



/**
 * Return the Google font stylesheet URL
 */
function north_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Roboto, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$roboto = _x( 'on', 'Roboto font: on or off', 'north' );

	if ( 'off' !== $roboto ) {
		$font_families = array();

		if ( 'off' !== $roboto )
			$font_families[] = 'Roboto:300,400,500,700,400italic,700italic';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}



/**
 * Enqueue Google fonts style to admin for editor styles
 */
function north_admin_fonts( $hook_suffix ) {
	wp_enqueue_style( 'north-fonts', north_fonts_url(), array(), null );
}
add_action( 'admin_enqueue_scripts', 'north_admin_fonts' );


/* Add Customizer CSS To Header */
function north_customizer_css() {
    ?>
	<style type="text/css">
		a,
		#cancel-comment-reply i,
		#content .meta a,
		.post-navigation a:hover,
		.post-navigation li:hover i,
		.logo-text:hover i,
		#sidebar .widget li:before {
			color: <?php echo get_theme_mod( 'north_link_color', '#48ADD8' ); ?>;
		}

		.next-prev a,
		#commentform #submit,
		.wpcf7-submit,
		.header .search-form .submit,
		.search-form .submit,
		.hero h3,
		.search-form .submit,
		.pull-quote,
		.tagcloud a {
			background: <?php echo get_theme_mod( 'north_accent_color', '#48ADD8' ); ?>;
		}

		.pull-quote:after {
			border-top-color: <?php echo get_theme_mod( 'north_accent_color', '#48ADD8' ); ?>;
		}

		.header-wrap {
			background: <?php echo get_theme_mod( 'north_header_color', '#32373b' ); ?>;
		}

		<?php echo get_theme_mod( 'north_customizer_css' ); ?>
	</style>
    <?php
}
add_action( 'wp_head', 'north_customizer_css' );



/**
 * Deprecated page navigation
 *
 * @deprecated 3.0 Replaced by north_page_nav()
 */
function north_page_has_nav() {

	_deprecated_function( __FUNCTION__, '3.0', 'north_page_nav()' );
	return false;
}



/**
 * Displays post pagination links
 *
 * @since 3.0
 */
function north_page_nav( $query = false ) {

	global $wp_query;
	if( $query ) {
		$temp_query = $wp_query;
		$wp_query = $query;
	}

	// Return early if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	} ?>
	<div class="post-nav">
		<div class="post-nav-inside">
			<div class="post-nav-left"><?php previous_posts_link(__('Newer Posts', 'north')) ?></div>
			<div class="post-nav-right"><?php next_posts_link(__('Older Posts', 'north')) ?></div>
		</div>
	</div>
	<?php
	if( isset( $temp_query ) ) {
		$wp_query = $temp_query;
	}
}


/**
 * Add layout style class to body
 */
function north_layout_class( $classes ) {

	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'carousel' ) ) {
		$classes[] = 'has-carousel';
	} else {
		$classes[] = 'has-view-carousel';
	}

	return $classes;
}
add_filter( 'body_class', 'north_layout_class' );


/* Add Lightbox To WP Galleries */
function north_gallery_lightbox( $out, $pairs, $atts ) {

	// Check for the link attribute
	if ( isset( $atts["link"] ) ) {
		if  ( $atts["link"] != "" ) {
			add_filter( 'wp_get_attachment_link', 'north_add_lightbox_class' );
		}
	}
	return $out;


}
add_filter( 'shortcode_atts_gallery', 'north_gallery_lightbox', 10, 3 );


/**
 * Add the view class on gallery items
 */
function north_add_lightbox_class ( $content ) {
	return str_replace( "<a", "<a rel='lightbox' class='view'", $content );
}


function north_register_sidebars() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'north' ),
		'id'            => 'sidebar',
		'description'   => __( 'Widgets in this area will be shown in the sidebar.', 'north' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	) );

	register_sidebar( array(
		'name'          => __( 'Footer', 'north' ),
		'id'            => 'footer',
		'description'   => __( 'Widgets in this area will be shown in the footer.', 'north' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Social Icons', 'north' ),
		'id'            => 'footer-social-icons',
		'description'   => __( 'Use the Array Social Icons widget here to show links in the footer.', 'north' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	) );
}
add_action( 'widgets_init', 'north_register_sidebars' );



/* Custom Comment Output */
function north_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class('clearfix'); ?> id="li-comment-<?php comment_ID() ?>">

		<div class="comment-block" id="comment-<?php comment_ID(); ?>">
			<div class="comment-info">
				<div class="comment-author vcard clearfix">
					<?php echo get_avatar( $comment->comment_author_email, 75 ); ?>

					<div class="comment-meta commentmetadata">
						<?php printf(__('<cite class="fn">%s</cite>', 'north'), get_comment_author_link()) ?>
						<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s', 'north'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)', 'north'),' ', '' ) ?>
					</div>
				</div>
			<div class="clearfix"></div>
			</div>

			<div class="comment-text">
				<?php comment_text() ?>
				<p class="reply">
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</p>
			</div>

			<?php if ($comment->comment_approved == '0') : ?>
				<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'north') ?></em>
			<?php endif; ?>
		</div>
<?php
}

function north_cancel_comment_reply_button( $html, $link, $text ) {
    $style = isset($_GET['replytocom']) ? '' : ' style="display:none;"';
    $button = '<div id="cancel-comment-reply-link"' . $style . '>';
    return $button . '<i class="fa fa-times"></i> </div>';
}
add_action( 'cancel_comment_reply_link', 'north_cancel_comment_reply_button', 10, 3 );



/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function north_wp_title( $title, $sep ) {
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
				$title .= " $sep " . sprintf( __( 'Page %s', 'north' ), max( $paged, $page ) );
		}

		return $title;
}
add_filter( 'wp_title', 'north_wp_title', 10, 2 );



/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function north_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'north_setup_author' );


/**
 * Responsive image adjustments
 */
function north_adjust_image_sizes_attr( $sizes, $size ) {
	if ( is_singular( 'array-portfolio' ) ) {
		$sizes = '(max-width: 500px) 500px, (max-width: 768px) 800px, (min-width: 1160px) 1160px';
	} else if ( 'array-portfolio' === get_post_type() ) {
		$sizes = '(max-width: 500px) 100vw, (max-width: 700px) 100vw, (max-width: 1450px) 450px';
	} else {
		$sizes = '(max-width: 500px) 500px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'north_adjust_image_sizes_attr', 10 , 2 );
