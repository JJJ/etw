<?php
/**
 * Typable functions and definitions
 *
 * @package Typable
 * @since Typable 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Typable 1.0
 */
if ( ! isset( $content_width ) )
  $content_width = 720; /* pixels */

if ( ! function_exists( 'typable_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 * @since Typable 1.0
 */
function typable_setup() {

	if( is_admin() ) {
		// Getting Started page and EDD update class
		require_once( get_template_directory() . '/includes/admin/updater/theme-updater.php' );

		/**
		 * TGM Activation class
		 */
		require_once( get_template_directory() . '/includes/admin/tgm/tgm-activation.php' );

		/* Add editor styles */
		add_editor_style();
	}

	/* Add Customizer settings */
	require_once( get_template_directory() . '/customizer.php' );

	/* Add default posts and comments RSS feed links to head */
	add_theme_support( 'automatic-feed-links' );

	/* Enable support for Post Thumbnails */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'featured-image', 720, 9999, false );

	/* Custom Background Support */
	add_theme_support( 'custom-background' );

	/* This theme uses wp_nav_menu() in one location. */
	register_nav_menu( 'main', __( 'Main Menu', 'typable' ) );

	/* Make theme available for translation */
	load_theme_textdomain( 'typable', get_template_directory() . '/languages' );

}
endif; // typable_setup
add_action( 'after_setup_theme', 'typable_setup' );


/**
 * Load scripts and styles
 */
function typable_scripts_styles() {

	$version = wp_get_theme()->Version;

	// Enqueue Styles

	// Main Stylesheet
	wp_enqueue_style( 'typable-style', get_stylesheet_uri() );

	// Font Awesome CSS
	wp_enqueue_style( 'typable-font-awesome-css', get_template_directory_uri() . "/includes/fonts/fontawesome/font-awesome.min.css", array(), '4.0.3', 'screen' );

	// Media Queries CSS
	wp_enqueue_style( 'typable-media-queries_css', get_template_directory_uri() . "/media-queries.css", array( 'typable-style' ), $version, 'screen' );

	// Load Arimo and Lato from Google
	wp_enqueue_style( 'typable-fonts', typable_fonts_url(), array(), null );

	// Enqueue Scripts

	// Register jQuery
	wp_enqueue_script( 'jquery' );

	// Custom JS
	wp_enqueue_script( 'typable-custom-js', get_template_directory_uri() . '/includes/js/custom/custom.js', array( 'jquery' ), $version , true );

	wp_localize_script( 'typable-custom-js', 'custom_js_vars', array(
		'toggle_ajax' => get_option( 'typable_customizer_ajax_toggle' )
	) );

	// Enqueue scripts if AJAX is enabled
	if ( get_option( 'typable_customizer_ajax_toggle' ) != 'disabled' ) {

		// Prep some strings for AJAX
		wp_localize_script( 'typable-custom-js', 'WPCONFIG', array( 'site_url' => site_url() ) );
		wp_localize_script( 'typable-custom-js', 'WPLANG', array(
			'type_your_search' => __( 'Type your search here and press enter...', 'typable' )
		));

		// Check for Disqus
		if ( function_exists( 'dsq_comments_template' ) ) {
			wp_localize_script( 'typable-custom-js', 'custom_js_vars', array( 'disqus' => 'enabled' ) );
		}

		// Enable Twitter embeds on AJAX
		wp_enqueue_script( 'typable-twitter-js', '//platform.twitter.com/widgets.js', array( 'jquery' ), $version , true );

		// Use our own jquery.history.js because of reasons
		wp_deregister_script( 'typable-history-js' );
		wp_register_script( 'typable-history-js', get_template_directory_uri() . '/includes/js/history/jquery.history.js', array( 'jquery' ), $version, true );
		wp_enqueue_script( 'typable-history-js' );
	}

	// FidVid
	wp_enqueue_script( 'typable-fitvid-js', get_template_directory_uri() . '/includes/js/fitvid/jquery.fitvids.js', array( 'jquery' ), '1.0.3' , true );

}
add_action( 'wp_enqueue_scripts', 'typable_scripts_styles' );


/**
 * Return the Google font stylesheet URL
 */
function typable_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Lato, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$lato = _x( 'on', 'Lato font: on or off', 'typable' );

	/* Translators: If there are characters in your language that are not
	 * supported by Arimo, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$arimo = _x( 'on', 'Arimo font: on or off', 'typable' );

	if ( 'off' !== $lato || 'off' !== $arimo ) {
		$font_families = array();

		if ( 'off' !== $lato )
			$font_families[] = 'Lato:300,400,700';

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


/**
 * Enqueue Google fonts style to admin for editor styles
 */
function typable_admin_fonts( $hook_suffix ) {
	wp_enqueue_style( 'typable-fonts', typable_fonts_url(), array(), null );
}
add_action( 'admin_enqueue_scripts', 'typable_admin_fonts' );


/**
 * Register Widget Drawer
 */
function typable_register_widgets() {
	register_sidebar( array(
		'name'          => __( 'Widget Drawer', 'typable' ),
		'id'            => __( 'widget-drawer', 'typable' ),
		'description'   => __( 'Widgets in this area will be shown in the header drawer.', 'typable' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	));
}
add_action( 'widgets_init', 'typable_register_widgets' );


/**
 * Add Customizer CSS To Header
 */
function typable_customizer_css() {
?>
<style type="text/css">
	a, .logo-text a:hover, .logo-text a, #cancel-comment-reply-link i, #archive-list li span, #archive-list li:hover a, .nav a:hover, #archive-list li a:hover, #archive-list li span, .ajax-loader , #widget-drawer .tagcloud a {
		color: <?php echo get_theme_mod( 'typable_customizer_accent', '#00a9e0' ); ?>;
	}

	.header, #archive-list li:hover span, #respond .respond-submit, .wpcf7-submit, .header .search-form .submit, #commentform #submit {
		background: <?php echo get_theme_mod( 'typable_customizer_accent', '#00a9e0' ); ?>;
	}

	<?php echo get_theme_mod( 'typable_customizer_css' );?>
</style>
<?php
}
add_action( 'wp_head', 'typable_customizer_css' );


/**
 * Pagination
 */
function typable_page_has_nav() {
	global $wp_query;
	return ( $wp_query->max_num_pages > 1 );
}

function typable_posts_per_page( $query ) {
  if ( is_search() ) {
	  $query->set( 'posts_per_page', -1 );
  }
  return;
}
add_action( 'pre_get_posts', 'typable_posts_per_page', 1 );


/**
 * Remove admin bar CSS in favor of our own
 */
function typable_remove_adminbar_css() {
	remove_action( 'wp_head', '_admin_bar_bump_cb' );
}
add_action( 'get_header', 'typable_remove_adminbar_css' );


/**
 * Cancel comment reply link
 */
function typable_cancel_comment_reply_button( $html, $link, $text ) {
	$style = isset( $_GET['replytocom'] ) ? '' : ' style="display:none;"';
	$button = '<div id="cancel-comment-reply-link"' . $style . '>';
	return $button . '<i class="fa fa-times"></i> </div>';
}
add_action( 'cancel_comment_reply_link', 'typable_cancel_comment_reply_button', 10, 3 );


/**
 * Javascript helper functions for AJAX
 */
if ( get_option( 'typable_customizer_ajax_toggle' ) == 'enabled' ) {

	// Output the next post link and include the post title
	// in the data-title attribute to pass to JavaScript.

	function typable_next_post_link( $text = 'Forward' ){
		$next_post = get_adjacent_post('false', '', false);
			if ( $next_post != '' ) {
			$next_post_url = get_permalink( $next_post );
			$next_post_title =  htmlspecialchars( $next_post->post_title, ENT_QUOTES );
			echo "<a href='$next_post_url' data-title='$next_post_title' rel='next'>$text</a>";
		}
	}

	// Output the prev post link with the data-title attribute
	function typable_prev_post_link( $text = 'Backward' ){
		$previous_post = get_adjacent_post( 'false', '', true );
			if ( $previous_post != '' ) {
			$previous_post_url = get_permalink( $previous_post );
			$previous_post_title =  htmlspecialchars( $previous_post->post_title, ENT_QUOTES );
			echo "<a href='$previous_post_url' data-title='$previous_post_title' rel='prev'>$text</a>";
		}
	}
}


/**
 * Sets the authordata global when viewing an author archive.
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function typable_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'typable_setup_author' );