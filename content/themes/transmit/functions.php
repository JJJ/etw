<?php
/**
 * Transmit functions, scripts and styles.
 *
 * @package Transmit
 * @since Transmit 1.0
 */


/* Set the content width */
if ( ! isset( $content_width ) )
	$content_width = 450; /* pixels */


if ( ! function_exists( 'transmit_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 * @since Transmit 1.0
 */
function transmit_setup() {

	if( is_admin() ) {
		// Getting Started page and EDD update class
		require_once( get_template_directory() . '/includes/admin/updater/theme-updater.php' );

		/**
		 * TGM Activation class
		 */
		require_once( get_template_directory() . '/includes/admin/tgm/tgm-activation.php' );

		// Add editor styles
		add_editor_style();
	}

	/* Add Customizer settings */
	require_once( get_template_directory() . '/customizer.php' );

	/* Add default posts and comments RSS feed links to head */
	add_theme_support( 'automatic-feed-links' );

	/* Enable support for Post Thumbnails */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true ); // Default Thumb
	add_image_size( 'post-image', 450, 9999, false ); // Featured Image

	/* Custom Background Support */
	add_theme_support( 'custom-background' );

	/* Register Menu */
	register_nav_menus( array(
		'main' => __( 'Main Menu', 'transmit' )
	) );

	/* Make theme available for translation */
	load_theme_textdomain( 'transmit', get_template_directory() . '/languages' );

}
endif; // transmit_setup
add_action( 'after_setup_theme', 'transmit_setup' );


/* Enqueue scripts and styles */
function transmit_scripts() {

	$version = wp_get_theme()->Version;

	//Main Stylesheet
	wp_enqueue_style( 'transmit-style', get_stylesheet_uri() );

	//Font Awesome
	wp_enqueue_style( 'transmit-fontawesome-css', get_template_directory_uri() . "/includes/fonts/fontawesome/font-awesome.min.css", array(), '4.0.3', 'screen' );

	//Load fonts from Google
	wp_enqueue_style( 'transmit-fonts', transmit_fonts_url(), array(), null );

	//Enqueue jQuery
	wp_enqueue_script( 'jquery' );

	//Custom Scripts
	wp_enqueue_script( 'transmit-custom-js', get_template_directory_uri() . '/includes/js/transmit.js', array( 'jquery' ), $version, true );

	//Backstretch
	wp_enqueue_script( 'transmit-backstretch-js', get_template_directory_uri() . '/includes/js/jquery.backstretch.min.js', array(), '2.0.4', true );

	//Fitvids
	wp_enqueue_script( 'transmit-video-js', get_template_directory_uri() . '/includes/js/jquery.fitvids.js', array(), '1.0.3', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'transmit_scripts' );


/**
 * Add Google font to post editor
 */
function transmit_add_editor_styles() {
	$editor_font_url = str_replace( ',', '%2C', transmit_fonts_url() );
    add_editor_style( $editor_font_url );
}
add_action( 'after_setup_theme', 'transmit_add_editor_styles' );


/**
 * Return the Google font stylesheet URL
 */
function transmit_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by these fonts, translate this to 'off'. Do not translate
	 * into your own language.
	 */

	$opensans = esc_html_x( 'on', 'Open Sans font: on or off', 'transmit' );

	if ( 'off' !== $opensans ) {
		$font_families = array();

		$font_families[] = 'Open Sans:300,400,400i,700,700i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}


/* Add Customizer CSS To Header */
function transmit_customizer_css() {
	?>
	<style type="text/css">
		a, .nav > .current-menu-item > a:before, .menu-toggle-active i, #logo-text a:before {
			color : <?php echo get_theme_mod( 'transmit_customizer_accent', '#EB4949' ); ?>;
		}

		input[type="submit"], .mailbag-wrap input[type="submit"],  .post-nav a {
			background : <?php echo get_theme_mod( 'transmit_customizer_accent', '#EB4949' ); ?>;
		}

		<?php echo get_theme_mod( 'transmit_customizer_css', '' ); ?>
	</style>
<?php
}
add_action( 'wp_head', 'transmit_customizer_css' );


/* Retrieve featured image URL for header background */
function transmit_bg_image_url() {
	global $post;

	$bg_image_select = get_option( 'transmit_customizer_bg' );
	$bg_image_url = get_template_directory_uri() . '/images/' . $bg_image_select;
	$bg_image_upload = get_background_image();

	/* If there is an image, prepare it for use in transmit.js */
	if ( !empty( $bg_image_select ) ) {
		wp_localize_script( 'transmit-custom-js', 'transmit_custom_js_vars', array(
				'bg_image_url' => $bg_image_url
			)
		);
	} else if ( !empty( $bg_image_upload ) ) {
		wp_localize_script( 'transmit-custom-js', 'transmit_custom_js_vars', array(
				'bg_image_url' => $bg_image_upload
			)
		);
	} else {
		wp_localize_script( 'transmit-custom-js', 'transmit_custom_js_vars', array(
				'bg_image_url' => false
			)
		);
	}

}
add_action( 'wp_enqueue_scripts', 'transmit_bg_image_url' );


/* Social Icon Shortcode */
function transmit_social_icons( $attr, $content ) {
    ob_start();
    get_template_part( 'template-icons' );
    $ret = ob_get_contents();
    ob_end_clean();
    return $ret;
}
add_shortcode( 'transmit_social_icons', 'transmit_social_icons' );


/* Register Widget Areas */
function transmit_register_sidebars() {
	register_sidebar( array(
		'name'          => __( 'Widgets', 'transmit' ),
		'description'   => __( 'Widgets will be shown on the Widgets page template.', 'transmit' ),
		'id' 			=> 'widgets',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	) );
}
add_action( 'widgets_init', 'transmit_register_sidebars' );


/* Pagination */
function transmit_page_has_nav() {
	global $wp_query;
	return ( $wp_query->max_num_pages > 1 );
}


/* Custom Comment Output */
function transmit_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class('clearfix'); ?> id="li-comment-<?php comment_ID() ?>">

		<div class="comment-block" id="comment-<?php comment_ID(); ?>">
			<div class="comment-info">
				<div class="comment-author vcard clearfix">
					<?php echo get_avatar( $comment->comment_author_email, 75 ); ?>

					<div class="comment-meta commentmetadata">
						<?php printf(__('<cite class="fn">%s</cite>', 'transmit'), get_comment_author_link()) ?>
					</div>
				</div>
			</div><!-- comment info -->

			<div class="comment-text">
				<?php comment_text() ?>

				<div class="comment-bottom">
					<p class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
					</p>
					<?php edit_comment_link( __( 'Edit', 'transmit' ),' ', '' ) ?>
					<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s', 'transmit'), get_comment_date(),  get_comment_time()) ?></a>
				</div>
			</div><!-- comment text -->

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'transmit') ?></em>
			<?php endif; ?>
		</div>
<?php
}

function transmit_cancel_comment_reply_button( $html, $link, $text ) {
    $style = isset( $_GET['replytocom'] ) ? '' : ' style="display:none;"';
    $button = '<div id="cancel-comment-reply-link"' . $style . '>';
    return $button . '<i class="fa fa-times"></i> </div>';
}

add_action( 'cancel_comment_reply_link', 'transmit_cancel_comment_reply_button', 10, 3 );



/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function transmit_wp_title( $title, $sep ) {
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
		$title .= " $sep " . sprintf( __( 'Page %s', 'transmit' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'transmit_wp_title', 10, 2 );
