<?php
/**
 * Verb functions
 *
 * @package Verb
 * @since Verb 1.0
 */

/* Set the content width */
if ( ! isset( $content_width ) )
	$content_width = 670; /* pixels */

if ( ! function_exists( 'verb_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 * @since Verb 1.0
 */
function verb_setup() {

	if( is_admin() ) {

		// Getting Started page and theme updater
		require_once( get_template_directory() . '/includes/admin/updater/theme-updater.php' );

		// Meta box
		require_once( get_template_directory() . '/includes/admin/metabox/metabox.php' );

		// Add custom post styles
		require( get_template_directory() . '/includes/editor/add-styles.php' );
		add_editor_style();

		// TGM Activation class
		require_once( get_template_directory() . '/includes/admin/tgm/tgm-activation.php' );

	}

	/* Add Customizer settings */
	require( get_template_directory() . '/customizer.php' );

	/* Add default posts and comments RSS feed links to head */
	add_theme_support( 'automatic-feed-links' );

	/* Enable support for Post Thumbnails */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'large-image', 9999, 9999, false ); // Large Post Image
	add_image_size( 'home-image', 790, 790, true ); // Home Thumb Image

	// Portfolio and Gallery support
	add_theme_support( 'array_themes_portfolio_support' );
	add_theme_support( 'array_themes_gallery_support' );

	// Add support for legacy widgets
	add_theme_support( 'array_toolkit_legacy_widgets' );

	/* Custom Background Support */
	add_theme_support( 'custom-background' );

	/* Register Menu */
	register_nav_menus( array(
		'main'   => __( 'Main Menu', 'verb' ),
		'custom' => __( 'Custom Menu', 'verb' )
	) );

	/* Make theme available for translation */
	load_theme_textdomain( 'verb', get_template_directory() . '/languages' );

	/* Add gallery support */
	add_theme_support( 'post-formats', array( 'gallery') );

}
endif; // verb_setup
add_action( 'after_setup_theme', 'verb_setup' );

/* Load Scripts and Styles */
function verb_scripts_styles() {

	//Enqueue Styles

	//Main Stylesheet
	wp_enqueue_style( 'style', get_stylesheet_uri() );

	//Font Awesome CSS
	wp_enqueue_style( 'font_awesome_css', get_template_directory_uri() . "/includes/fonts/fontawesome/font-awesome.min.css", array(), '4.0.3', 'screen' );

	//Media Queries CSS
	wp_enqueue_style( 'media_queries_css', get_template_directory_uri() . "/media-queries.css", array(), '0.1', 'screen' );

	// Load Raleway and Open Sans fonts from Google
	wp_enqueue_style( 'verb-fonts', verb_fonts_url(), array(), null );

	//Enqueue Scripts

	//Register jQuery
	wp_enqueue_script( 'jquery' );

	//Custom JS
	wp_enqueue_script( 'custom_js', get_template_directory_uri() . '/includes/js/custom/custom.js', false, false , true );

	//Mobile JS
	wp_enqueue_script( 'mobile_menu_js', get_template_directory_uri() . '/includes/js/menu/jquery.mobilemenu.js', false, false , true );

	//FidVid
	wp_enqueue_script( 'fitvid_js', get_template_directory_uri() . '/includes/js/fitvid/jquery.fitvids.js', false, false , true );

	//View.js
	wp_enqueue_script( 'view_js', get_template_directory_uri() . '/includes/js/view/view.min.js?auto', false, false , true );

	// Comment reply script
	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'verb_scripts_styles' );

/* Add Customizer CSS To Header */
function customizer_css() {
	?>
	<style type="text/css">
		a, #cancel-comment-reply i, #content .meta a, .entry-title a:hover, .post-navigation a:hover, .post-navigation li:hover i, .logo-text:hover i, .pull-quote {
			color: <?php echo get_theme_mod( 'verb_customizer_accent', '#f74f4f' ); ?>;
		}

		.next-prev a, #commentform #submit, .wpcf7-submit, .header .search-form .submit, .search-form .submit, .hero h3 {
			background: <?php echo get_theme_mod( 'verb_customizer_accent', '#f74f4f' ); ?>;
		}

		<?php echo get_theme_mod( 'verb_customizer_css', '' ); ?>
	</style>
	<?php
}
add_action('wp_head', 'customizer_css');

/**
 * Displays post pagination links
 *
 * @since 4.0
 */
function verb_page_nav( $query = false ) {

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
		<?php if( get_previous_posts_link() ) : ?>
			<div class="post-nav-right"><?php previous_posts_link(__('Newer Posts', 'verb')) ?></div>
		<?php endif; ?>
		<?php if( get_next_posts_link() ) : ?>
			<div class="post-nav-left"><?php next_posts_link(__('Older Posts', 'verb')) ?></div>
		<?php endif; ?>
		</div>
	</div>
	<?php
	if( isset( $temp_query ) ) {
		$wp_query = $temp_query;
	}
}

/* Add CPT To Archives */
function verb_cpt_getarchives_where( $where ) {
	return str_replace( "WHERE post_type = 'post'", "WHERE post_type IN ('post', 'array-portfolio')", $where );
}
add_filter( 'getarchives_where', 'verb_cpt_getarchives_where' );


/* Add Lightbox To WP Galleries */
function verb_gallery_lightbox ($content) {
	return str_replace("<a", "<a rel='lightbox' class='view'", $content);
}
add_filter( 'wp_get_attachment_link', 'verb_gallery_lightbox');

/* Excerpt Read More Link */
function new_excerpt_more( $more ) {
	return ' ... ';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

/* Register Widget Areas */
function verb_register_sidebars() {
	register_sidebar(array(
		'name'          => __( 'Sidebar Widgets', 'verb' ),
		'id'            => 'sidebar',
		'description'   => __( 'Widgets in this area will be shown in the sidebar.', 'verb' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	));
}
add_action( 'widgets_init', 'verb_register_sidebars' );

/**
 * Remove admin bar CSS in favor of our own
 */
function verb_remove_adminbar_css() {
	remove_action( 'wp_head', '_admin_bar_bump_cb' );
}
add_action( 'get_header', 'verb_remove_adminbar_css' );

/* Custom Comment Output */
function verb_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class('clearfix'); ?> id="li-comment-<?php comment_ID() ?>">

		<div class="comment-block" id="comment-<?php comment_ID(); ?>">
			<div class="comment-info">
				<div class="comment-author vcard clearfix">
					<?php echo get_avatar( $comment->comment_author_email, 75 ); ?>

					<div class="comment-meta commentmetadata">
						<?php printf(__('<cite class="fn">%s</cite>', 'verb'), get_comment_author_link()) ?>
						<div style="clear:both;"></div>
						<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s', 'verb'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)', 'verb'),'  ','') ?>
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
				<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'verb') ?></em>
			<?php endif; ?>
		</div>
<?php
}

function verb_cancel_comment_reply_button( $html, $link, $text ) {
	$style = isset($_GET['replytocom']) ? '' : ' style="display:none;"';
	$button = '<div id="cancel-comment-reply-link"' . $style . '>';
	return $button . '<i class="fa fa-times"></i> </div>';
}

add_action( 'cancel_comment_reply_link', 'verb_cancel_comment_reply_button', 10, 3 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function verb_wp_title( $title, $sep ) {
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
		$title .= " $sep " . sprintf( __( 'Page %s', 'verb' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'verb_wp_title', 10, 2 );


/**
 * Return the Google font stylesheet URL
 */
function verb_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Raleway, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$raleway = _x( 'on', 'Raleway font: on or off', 'verb' );

	/* Translators: If there are characters in your language that are not
	 * supported by Open Sans, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$opensans = _x( 'on', 'Open Sans font: on or off', 'verb' );

	if ( 'off' !== $raleway || 'off' !== $opensans ) {
		$font_families = array();

		if ( 'off' !== $raleway )
			$font_families[] = 'Raleway:200,300,400,500';

		if ( 'off' !== $opensans )
			$font_families[] = 'Open Sans:400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}


/**
 * Responsive image adjustments
 */
function verb_adjust_image_sizes_attr( $sizes, $size ) {
	if ( 'array-portfolio' === get_post_type() ) {
		$sizes = '(max-width: 500px) 100vw, (max-width: 700px) 100vw, (max-width: 768px) 350px, (max-width: 1450px) 450px';
	}
	if ( is_singular( 'array-portfolio' ) ) {
		$sizes = '(max-width: 500px) 400px, (max-width: 768px) 800px, (max-width: 1450px) 850px';
	}
	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'verb_adjust_image_sizes_attr', 10 , 2 );
