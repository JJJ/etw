<?php
/**
 * Designer functions and definitions
 *
 * @package Designer
 */

/**
 * Set the content width based on the theme's design and stylesheet
 */
if ( ! isset( $content_width ) ) {
	$content_width = 787; /* pixels */
}

if ( ! function_exists( 'designer_setup' ) ) :
/**
 * Sets up Designer's defaults and registers support for various WordPress features
 */
function designer_setup() {

	/**
     * Add styles to post editor (editor-style.css)
     */
	add_editor_style();

	/*
	 * Make theme available for translation
	 */
	load_theme_textdomain( 'designer', get_template_directory() . '/languages' );

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
	add_image_size( 'featured-post-image', 600, 400, true ); // Featured post image
	add_image_size( 'large-image', 1200, 9999, false ); // Large post image
	add_image_size( 'blog-thumb', 250, 250, true ); // Homepage blog thumb
	add_image_size( 'portfolio-tiny', 25, 25, true ); // Portfolio tiny thumb
	add_image_size( 'portfolio-landscape', 800, 600, true ); // Portfolio landscape
	add_image_size( 'portfolio-portrait', 600, 800, true ); // Portfolio portrait
	add_image_size( 'portfolio-square', 600, 600, true ); // Portfolio square
	add_image_size( 'portfolio-tile', 800, 9999, false ); // Portfolio tile
	add_image_size( 'logo', 300, 9999, false ); // Portfolio tile

	/**
	 * Register Navigation menu
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'designer' ),
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
	add_theme_support( 'custom-background', apply_filters( 'designer_custom_background_args', array(
		'default-color' => 'f4f4f4',
		'default-image' => '',
	) ) );

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
	 * Enable Jetpack Portfolio support
	 */
	add_theme_support( 'jetpack-portfolio' );
}
endif; // designer_setup
add_action( 'after_setup_theme', 'designer_setup' );

/**
 * Register widget area
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function designer_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'designer' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears when the left sidebar is expanded.', 'designer' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'designer_widgets_init' );

/**
 * Return the Google font stylesheet URL
 */
function designer_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Lato, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$lato = _x( 'on', 'Lato font: on or off', 'designer' );

	/* Translators: If there are characters in your language that are not
	 * supported by Arimo, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$arimo = _x( 'on', 'Arimo font: on or off', 'designer' );

	if ( 'off' !== $lato || 'off' !== $arimo ) {
		$font_families = array();

		if ( 'off' !== $lato )
			$font_families[] = 'Lato:400,400i,700,700i';

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
function designer_admin_fonts( $hook_suffix ) {
	wp_enqueue_style( 'designer-fonts', designer_fonts_url(), array(), null );
}
add_action( 'admin_enqueue_scripts', 'designer_admin_fonts' );

/**
 * Enqueue scripts and styles
 */
function designer_scripts() {

	wp_enqueue_style( 'designer-style', get_stylesheet_uri() );

	/**
     * FontAwesome Icons Stylesheet
     */
	wp_enqueue_style( 'designer-font-awesome-css', get_template_directory_uri() . "/inc/fontawesome/font-awesome.css", array(), '4.1.0', 'screen' );

	/**
     * Load Designer's javascript
     */
	wp_enqueue_script( 'designer-js', get_template_directory_uri() . '/js/designer.js', array( 'jquery' ), '1.0.2', true );

	/**
     * Load Masonry if the Tiled portfolio style is selected
     */
	if ( 'tile' == get_option( 'designer_customizer_portfolio' ) || ! get_option( 'designer_customizer_portfolio' ) ) {
		wp_enqueue_script( 'masonry' );
	}

	/**
     * Load Arimo and Lato from Google
     */
	wp_enqueue_style( 'designer-fonts', designer_fonts_url(), array(), null );

	/**
     * Load the comment reply script
     */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/**
     * Pass portfolio options to javascript
     */
	wp_localize_script( 'designer-js', 'designer_portfolio_js_vars', array(
			'portfolio_style' => get_option( 'designer_customizer_portfolio' )
		)
	);

	/**
     * Pass sidebar options to javascript
     */
	if ( get_theme_mod( 'designer_show_sidebar' ) ) {
		wp_localize_script( 'designer-js', 'designer_sidebar_js_vars', array(
				'designer_show_sidebar' => get_theme_mod( 'designer_show_sidebar' )
			)
		);
	}

}
add_action( 'wp_enqueue_scripts', 'designer_scripts' );

/**
 * Custom template tags for Designer
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates
 */
require get_template_directory() . '/inc/extras.php';

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
 * Add button class to next/previous post links
 */
function designer_posts_link_attributes() {
    return 'class="button"';
}
add_filter( 'next_posts_link_attributes', 'designer_posts_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'designer_posts_link_attributes' );

/**
 * Add button class to single next/previous post links
 */
function designer_single_link_attributes( $output ) {
    if ( 'jetpack-portfolio' == get_post_type() ) {
      $classes = 'class="button"';
      return str_replace( '<a href=', '<a '.$classes.' href=', $output );
  } else {
    return $output;
  }
}
add_filter( 'next_post_link', 'designer_single_link_attributes' );
add_filter( 'previous_post_link', 'designer_single_link_attributes' );

/**
 * Changes the text of the "Older posts" button in infinite scroll
 * for portfolio related views.
 */
function designer_infinite_scroll_button_text( $js_settings ) {

	if ( is_post_type_archive( 'jetpack-portfolio' ) || is_tax( array( 'jetpack-portfolio-type', 'jetpack-portfolio-tag' ) ) ) {
		$js_settings['text'] = '<i class="fa fa-plus"></i>' . esc_js( __( 'More Projects', 'designer' ) );

	} else {
		$js_settings['text'] = '<i class="fa fa-plus"></i>' . esc_js( __( 'More Posts', 'designer' ) );
	}

		return $js_settings;
}
add_filter( 'infinite_scroll_js_settings', 'designer_infinite_scroll_button_text' );


/**
 * Replaces the excerpt ellipsis with a Read More link
 */
function designer_new_excerpt_more( $more ) {
	global $post;
	return '&hellip; <p><a class="more-link" href="'. get_permalink( $post->ID ) . '">Read More &rarr;</a></p>';
}
add_filter( 'excerpt_more', 'designer_new_excerpt_more' );

/**
 * Remove admin bar CSS in favor of our own
 */
function designer_remove_adminbar_css() {
	remove_action( 'wp_head', '_admin_bar_bump_cb' );
}
add_action( 'get_header', 'designer_remove_adminbar_css' );

/**
 * Custom comment output
 */
function designer_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class( 'clearfix' ); ?> id="li-comment-<?php comment_ID() ?>">

	<div class="comment-block" id="comment-<?php comment_ID(); ?>">

		<?php echo get_avatar( $comment->comment_author_email, 75 ); ?>

		<div class="comment-wrap">
			<div class="comment-info">
				<?php printf( __( '<cite class="comment-cite">%s</cite>', 'designer' ), get_comment_author_link() ) ?>
				<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf( __( '%1$s at %2$s', 'designer' ), get_comment_date(), get_comment_time() ) ?></a><?php edit_comment_link( __( '(Edit)', 'designer' ), '  ', '' ) ?>
			</div>

			<div class="comment-content">
				<?php comment_text() ?>
				<p class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
				</p>
			</div>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'designer' ) ?></em>
			<?php endif; ?>
		</div>
	</div>
<?php
}


/**
 * Responsive image adjustments
 */
function designer_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'logo' === $size ) {
		$attr['sizes'] = '(max-width: 320px) 320px, (max-width: 500px) 350px, (max-width: 768px) 350px';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'designer_post_thumbnail_sizes_attr', 10 , 3 );