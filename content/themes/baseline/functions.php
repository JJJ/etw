<?php
/**
 * Baseline functions and definitions
 *
 * @package Baseline
 */

/**
 * Set the content width based on the theme's design and stylesheet
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1200; /* pixels */
}


if ( ! function_exists( 'baseline_setup' ) ) :
/**
 * Sets up Baseline's defaults and registers support for various WordPress features
 */
function baseline_setup() {

	/**
	 * Load Getting Started page and initialize theme updater
	 */
	require_once( get_template_directory() . '/inc/admin/updater/theme-updater.php' );

	/**
	 * TGM activation class
	 */
	require_once get_template_directory() . '/inc/admin/tgm/tgm-activation.php';

	/**
	 * Add styles to post editor (editor-style.css)
	 */
	add_editor_style();

	/*
	 * Make theme available for translation
	 */
	load_theme_textdomain( 'baseline', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Post thumbnail support and image sizes
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Add video metabox
	 */
	add_theme_support( 'array_themes_video_support' );

	/*
	 * Add title output
	 */
	add_theme_support( 'title-tag' );

	// Large post image
	add_image_size( 'baseline-full-width', 1500 );

	// Gallery thumb - small
	add_image_size( 'baseline-three-column', 425 );

	// Gallery thumb - medium
	add_image_size( 'baseline-two-column', 650 );

	// Gallery thumb - large
	add_image_size( 'baseline-one-column', 1400 );

	// Featured post thumb
	add_image_size( 'baseline-mini-grid-thumb', 600, 410, true );

	// Logo
	add_image_size( 'baseline-logo' );

	/**
	 * Register Navigation menu
	 */
	register_nav_menus( array(
		'primary'         => esc_html__( 'Primary Menu', 'baseline' ),
		'category-header' => esc_html__( 'Header Category Menu', 'baseline' ),
		'category-footer' => esc_html__( 'Footer Category Menu', 'baseline' ),
		'social'          => esc_html__( 'Social Icon Menu', 'baseline' ),
		'footer'          => esc_html__( 'Footer Menu', 'baseline' ),
	) );

	/**
	 * Add Site Logo feature
	 */
	add_theme_support( 'site-logo', array(
		'header-text' => array( 'titles-wrap' ),
		'size'        => 'baseline-logo',
	) );

	/**
	 * Custom Header support
	 */
	$defaults = array(
		'default-image'      => '',
		'flex-width'         => true,
		'width'              => 1400,
		'flex-height'        => true,
		'header-text'        => true,
		'default-text-color' => '#fff',
	);
	add_theme_support( 'custom-header', $defaults );

	/**
	 * Enable HTML5 markup
	 */
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
	) );
}
endif; // baseline_setup
add_action( 'after_setup_theme', 'baseline_setup' );


/**
 * Register widget area
 */
function baseline_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'baseline' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Widgets added here will appear on the sidebar of posts and pages.', 'baseline' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'baseline_widgets_init' );


/**
 * Return the Google font stylesheet URL
 */
function baseline_fonts_url() {

	// Get the font style from the customizer
	$font_style = get_option( 'baseline_font_style', 'sans-serif' );

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by these fonts, translate this to 'off'. Do not translate
	 * into your own language.
	 */

	// Serif fonts
	$playfair_display = _x( 'on', 'Playfair Display font: on or off', 'baseline' );
	$noto_serif       = _x( 'on', 'Noto Serif font: on or off', 'baseline' );

	// Sans-serif fonts
	$work_sans  = _x( 'on', 'Work Sans font: on or off', 'baseline' );
	$noto_sans = _x( 'on', 'Noto Serif font: on or off', 'baseline' );

	if (
		'off' !== $playfair_display && 'serif' === $font_style ||
		'off' !== $noto_serif && 'serif' === $font_style ||
		'off' !== $work_sans && 'sans-serif' === $font_style ||
		'off' !== $noto_sans && 'sans-serif' === $font_style ) {

		$font_families = array();

		if ( 'off' !== $playfair_display && 'serif' === $font_style )
			$font_families[] = 'Playfair Display:400,700,400italic,700italic';

		if ( 'off' !== $noto_serif && 'serif' === $font_style )
			$font_families[] = 'Noto Serif:400,700,400italic,700italic';

		if ( 'off' !== $work_sans && 'sans-serif' === $font_style )
			$font_families[] = 'Work Sans:400,600,500';

		if ( 'off' !== $noto_sans && 'sans-serif' === $font_style )
			$font_families[] = 'Noto Sans:400,700,400italic,700italic';

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
function baseline_admin_fonts( $hook_suffix ) {
	wp_enqueue_style( 'baseline-fonts', baseline_fonts_url(), array(), null );
}
add_action( 'admin_enqueue_scripts', 'baseline_admin_fonts' );
add_action( 'admin_print_styles-appearance_page_custom-header', 'baseline_admin_fonts' );


/**
 * Enqueue scripts and styles
 */
function baseline_scripts() {

	wp_enqueue_style( 'baseline-style', get_stylesheet_uri() );

	/**
	 * FontAwesome Icons stylesheet
	 */
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . "/inc/fontawesome/css/font-awesome.css", array(), '4.3.0', 'screen' );

	/**
	 * Masonry
	 */
	wp_enqueue_script( 'masonry' );

	/**
	 * Load Baseline's javascript
	 */
	wp_enqueue_script( 'baseline-js', get_template_directory_uri() . '/js/baseline.js', array( 'jquery' ), '1.0', true );

	/**
	 * Localizes the baseline-js file
	 */
	wp_localize_script( 'baseline-js', 'baseline_js_vars', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	) );

	/**
	 * Load Headroom
	 */
	wp_enqueue_script( 'headroom', get_template_directory_uri() . '/js/headroom.js', array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'headroom-jquery', get_template_directory_uri() . '/js/jQuery.headroom.js', array( 'headroom' ), '0.7.0', true );

	/**
	 * Load ResponsiveSlides
	 */
	wp_enqueue_script( 'responsive-slides', get_template_directory_uri() . '/js/responsiveslides.js', array( 'jquery' ), '1.54', true );

	/**
	 * Load FitVids
	 */
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.1', true );

	/**
	* Load Google fonts
	*/
	wp_enqueue_style( 'baseline-fonts', baseline_fonts_url(), array(), null );

	/**
	 * Load the comment reply script
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'baseline_scripts' );


/**
 * Custom template tags for Baseline
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Customizer theme options
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Load Jetpack compatibility file
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Add button class to next/previous post links
 */
function baseline_posts_link_attributes() {
	return 'class="button"';
}
add_filter( 'next_posts_link_attributes', 'baseline_posts_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'baseline_posts_link_attributes' );


/**
 * Add layout style class to body
 */
function baseline_layout_class( $classes ) {

	// Gallery column width class
	$classes[] = get_option( 'baseline_customizer_post_style', 'one-column' );

	// Add sidebar class
	if ( is_active_sidebar( 'sidebar' ) ) {
		$classes[] = 'has-widgets';
	} else {
		$classes[] = 'has-no-widgets';
	}

	return $classes;
}
add_filter( 'body_class', 'baseline_layout_class' );


/**
 * Add featured image class to posts
 */
function baseline_post_class( $classes ) {

	// Check for a featured image
	$classes[] = has_post_thumbnail() ? 'with-featured-image' : 'without-featured-image';

	return $classes;
}
add_filter( 'post_class', 'baseline_post_class' );


/**
 * Adjust excerpt length based on customizer setting
 */
function baseline_extend_excerpt_length( $length ) {
	return get_theme_mod( 'baseline_excerpt_length', '40' );
}
add_filter( 'excerpt_length', 'baseline_extend_excerpt_length', 999 );


/**
 * Auto generate excerpt on single column layout
 */
function baseline_auto_excerpt( $content = false ) {

	global $post;
	$content = $post->post_excerpt;

	// If an excerpt is set in the Excerpt box
	if( $content ) {

		$content = apply_filters( 'the_excerpt', $content );

	} else {
		// No excerpt, get the first 55 words from post content
		$content = wpautop( wp_trim_words( $post->post_content, 55 ) );

	}

	// Read more link
	return $content . '<p class="more-bg"><a class="more-link" href="' . get_permalink() . '">' . esc_html__( 'Read More', 'baseline' ) . '</a></p>';

}

/**
 * Auto generate excerpt if option is selected
 */
function baseline_excerpt_check() {
	// If is the home page, an archive, or search results
	if ( 'enabled' === get_theme_mod( 'baseline_auto_excerpt', 'disabled' ) && ( is_home() || is_archive() || is_search() ) ) {
		add_filter( 'the_content', 'baseline_auto_excerpt' );
	}
}
add_action( 'template_redirect', 'baseline_excerpt_check' );


/**
 * Adds a data-object-id attribute to nav links for category mega menu
 *
 * @return array $atts The HTML attributes applied to the menu item's <a> element
 */
function baseline_nav_menu_link_attributes( $atts, $item, $args, $depth ) {

	if ( 'category' === $item->object ) {
		$atts['data-object-id'] = $item->object_id;
	}

	return $atts;
}


/**
 * Filters the current menu item to add another class.
 * Used to restore the active state when using the mega menu.
 */
function baseline_nav_menu_css_class( $item, $args, $depth ) {
	if ( in_array( 'current-menu-item', $item ) ) {
		$item[] = 'current-menu-item-original';
	}
	return $item;
}


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function baseline_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'baseline_page_menu_args' );


/**
 * Fetches the posts for the mega menu posts
 */
function baseline_menu_category_query() {

	$term_html = '';
	$output    = '';
	$id        = ( ! empty( $_REQUEST['id' ] ) ) ? $_REQUEST['id'] : '';

	if ( ! empty( $id ) ) {
		$term = get_term( (int) $id, 'category' );
	}

	if ( ! empty( $term ) && ! is_wp_error( $term ) ) {

		$args = array(
			'posts_per_page' => '5',
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'tax_query'      => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => (int) $id
				)
			)
		);

		$posts = new WP_Query( $args );

		if ( $posts->have_posts() ) {
			ob_start();
			while( $posts->have_posts() ) {
				$posts->the_post();
				include( 'template-parts/content-mini-grid-item.php' );
			}
			$output = ob_get_clean();

			// Get category title and link
			$term_html = sprintf( esc_html__( 'Category: %s', 'baseline' ), $term->name ) . sprintf( wp_kses( __( '<a class="view-all" href="%s">View All</a>', 'baseline' ), array( 'a' => array( 'href' => array(), 'class' => 'view-all' ) ) ), esc_url( get_term_link( $term->term_id, 'category' ) ) );
		} else {
			$term_html = esc_html__( 'No articles were found.', 'baseline' );
		}
	}

	wp_send_json( array(
		'html'      => $output,
		'term_html' => $term_html
	) );

}
add_action( 'wp_ajax_baseline_category', 'baseline_menu_category_query' );
add_action( 'wp_ajax_nopriv_baseline_category', 'baseline_menu_category_query' );

/**
 * Adds the menu item filters
 */
function baseline_mega_menu_check() {
	add_filter( 'nav_menu_css_class', 'baseline_nav_menu_css_class', 10, 3 );
	add_filter( 'nav_menu_link_attributes', 'baseline_nav_menu_link_attributes', 10, 4 );
}
add_action( 'template_redirect', 'baseline_mega_menu_check' );


/**
 * Mega menu fallback
 */
function baseline_fallback_category_menu() {
	$args = array(
		'orderby'    => 'count',
		'order'      => 'DESC',
		'hide_empty' => 'true'
	);
	$categories = get_categories( $args );
	$count=0;
	echo "<ul id='category-menu' class='sort-list'>";
	foreach( $categories as $category ) {
		$count++;
		echo '<li class="menu-item menu-item-' . esc_attr( $category->term_id ) . '"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . sprintf( esc_html__( "View all posts in %s", 'baseline' ), $category->name ) . '" ' . ' data-object-id=" ' . esc_attr( $category->term_id ) . ' ">' . esc_html( $category->name ) . '</a></li>';
		if( $count > 8 ) break;
	}
	echo "</ul>";
}


if ( ! function_exists( 'baseline_header_style' ) ) :
/**
 * Styles the header text displayed on the site
 */
function baseline_header_style() {
	// If the header text option is untouched, let's bail.
	if ( display_header_text() ) {
		return;

	// If the header text has been hidden.
	} else {
	?>
		<style type="text/css" id="baseline-header-css">
			.titles-wrap {
				clip: rect(1px, 1px, 1px, 1px);
				position: absolute;
			}
		</style>
	<?php
	}
}
endif; // baseline_header_style


/**
 * Responsive images
 */
function baseline_mini_grid_image( $attr, $attachment, $size ) {
    if ( $size === 'baseline-mini-grid-thumb' ) {
        $attr['sizes'] = '(max-width: 768px) 600px, (max-width: 1000px) 160px, 300px';
    }
    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'baseline_mini_grid_image', 10 , 3 );


/**
 * Replaces the Browse drawer button text
 */
function baseline_browse_button_text() {
	// Get the custom browse button text
	$custom_browse_text = get_theme_mod( 'baseline_customizer_browse_label' );

	if ( $custom_browse_text ) {
		// If we have custom text, use it
		$browse_text = $custom_browse_text;
	} else {
		// Otherwise show the fallback theme text
		$browse_text = esc_html_e( 'Browse', 'baseline' );
	}

	return $browse_text;
}
add_filter( 'baseline_browse_text', 'baseline_browse_button_text' );


/**
 * Replaces the Menu button text
 */
function baseline_menu_button_text() {
	// Get the custom menu button text
	$custom_menu_text = get_theme_mod( 'baseline_customizer_menu_label' );

	if ( $custom_menu_text ) {
		// If we have custom text, use it
		$menu_text = $custom_menu_text;
	} else {
		// Otherwise show the fallback theme text
		$menu_text = esc_html_e( 'Sidebar', 'baseline' );
	}

	return $menu_text;
}
add_filter( 'baseline_menu_text', 'baseline_menu_button_text' );
