<?php

// =============================================================================
// FUNCTIONS/SETUP.PHP
// -----------------------------------------------------------------------------
// Sets up theme defaults and registers various WordPress features.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Theme Setup
//   03. Register Nav Menus
//   04. Register Widget Areas
//   05. Excerpt Length
//   06. Excerpt More String
//   07. Content More String
//   08. Removals
//   09. Dashboard Link
//   10. TCO Setup
// =============================================================================

// Theme Setup
// =============================================================================

function x_setup_theme() {

  // Automatic Feed Links
  // --------------------
  // Adds RSS feed links to <head> for posts and comments.

  add_theme_support( 'automatic-feed-links' );


  // Post Formats
  // ------------
  // Adds support for a variety of post formats.

  add_theme_support( 'post-formats', array( 'link', 'gallery', 'quote', 'image', 'video', 'audio' ) );

  // WooCommerce
  // -----------
  // Theme support for the WooCommerce plugin.

  add_theme_support( 'woocommerce' );
  add_theme_support( 'wc-product-gallery-zoom' );
  add_theme_support( 'wc-product-gallery-lightbox' );
  add_theme_support( 'wc-product-gallery-slider' );


  // Allow Shortcodes in Widgets
  // ---------------------------

  add_filter( 'widget_text', 'do_shortcode' );


  // Disable Gallery Style
  // --------------------

  add_filter( 'use_default_gallery_style', '__return_false' );


  // Disable WordPress 4.4 Responsive Images
  // ---------------------------------------

  add_filter( 'wp_calculate_image_srcset', '__return_false' );


  // Remove Unnecessary Stuff
  // ------------------------
  // 1. Version number (for security).
  // 2. Really simple discovery.
  // 3. Windows live writer.
  // 4. Post relational links.

  if ( apply_filters('x_cleanup_wp_head', '__return_true' ) ) {
    remove_action( 'wp_head', 'wp_generator' );                    // 1
    remove_action( 'wp_head', 'rsd_link' );                        // 2
    remove_action( 'wp_head', 'wlwmanifest_link' );                // 3
    remove_action( 'wp_head', 'start_post_rel_link' );             // 4
    remove_action( 'wp_head', 'index_rel_link' );                  // 4
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' ); // 4
  }

}
add_action( 'after_setup_theme', 'x_setup_theme' );



// Register Nav Menus
// =============================================================================

function x_register_nav_menus() {

  register_nav_menus( array(
    'primary' => __( 'Primary Menu', '__x__' ),
    'footer'  => __( 'Footer Menu', '__x__' )
  ) );

}

add_action( 'init', 'x_register_nav_menus' );



// Register Widget Areas
// =============================================================================

if ( ! function_exists( 'x_widgets_init' ) ) :
  function x_widgets_init() {

    register_sidebar( array(
      'name'          => __( 'Main Sidebar', '__x__' ),
      'id'            => 'sidebar-main',
      'description'   => __( 'Appears on posts and pages that include the sidebar.', '__x__' ),
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<h4 class="h-widget">',
      'after_title'   => '</h4>',
    ) );

  }
  add_action( 'widgets_init', 'x_widgets_init' );
endif;



// Excerpt Length
// =============================================================================

if ( ! function_exists( 'x_excerpt_length' ) ) :
  function x_excerpt_length( $length ) {

    return x_get_option( 'x_blog_excerpt_length' );

  }
  add_filter( 'excerpt_length', 'x_excerpt_length' );
endif;



// Excerpt More String
// =============================================================================

if ( ! function_exists( 'x_excerpt_string' ) ) :
  function x_excerpt_string( $more ) {

    $stack = x_get_stack();

    if ( $stack == 'integrity' ) {
      return ' ... <div><a href="' . get_permalink() . '" class="more-link">' . __( 'Read More', '__x__' ) . '</a></div>';
    } else if ( $stack == 'renew' ) {
      return ' ... <a href="' . get_permalink() . '" class="more-link">' . __( 'Read More', '__x__' ) . '</a>';
    } else if ( $stack == 'icon' ) {
      return ' ...';
    } else if ( $stack == 'ethos' ) {
      return ' ...';
    }

  }
  add_filter( 'excerpt_more', 'x_excerpt_string' );
endif;



// Content More String
// =============================================================================

if ( ! function_exists( 'x_content_string' ) ) :
  function x_content_string( $more ) {

    return '<a href="' . get_permalink() . '" class="more-link">' . __( 'Read More', '__x__' ) . '</a>';

  }
  add_filter( 'the_content_more_link', 'x_content_string' );
endif;



// Removals
// =============================================================================

//
// Remove Tag Cloud Inline Style
//

if ( ! function_exists( 'x_remove_tag_cloud_inline_style' ) ) :
  function x_remove_tag_cloud_inline_style( $tag_string ) {
    return preg_replace( "/style='font-size:.+pt;'/", '', $tag_string );
  }
  add_filter( 'wp_generate_tag_cloud', 'x_remove_tag_cloud_inline_style' );
endif;


//
// Remove Recent Comments Style
//

if ( ! function_exists( 'x_remove_recent_comments_style' ) ) :
  function x_remove_recent_comments_style() {
    GLOBAL $wp_widget_factory;
    remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
  }
  add_action( 'widgets_init', 'x_remove_recent_comments_style' );
endif;


//
// Remove Gallery <br> Tags
//

if ( ! function_exists( 'x_remove_gallery_br_tags' ) ) :
  function x_remove_gallery_br_tags( $output ) {
    return preg_replace( '/<br style=(.*?)>/mi', '', $output );
  }
  add_filter( 'the_content', 'x_remove_gallery_br_tags', 11, 2 );
endif;



// Dashboard Link
// =============================================================================

function x_addons_get_link_home() {
  return admin_url( 'admin.php?page=x-addons-home' );
}



// TCO Setup
// =============================================================================

//
// Accessor
//

function x_tco() {
  return TCO_1_0::instance();
}

function x_tco_product_logo( $product, $class = '', $style = '' ) {

  $tco = x_tco();

  if ( is_callable( array( $tco, 'product_logo') ) ) {
    return x_tco()->product_logo( $product, $class, $style );
  }

  return x_tco()->x_logo( $class, $style );

}


//
// Initialization
//

function x_tco_init() {

  // Init
  // ----

  $tco = x_tco();

  $tco->init( array(
    'url' => X_TEMPLATE_URL . '/framework/tco/'
  ) );


  // Attach Localization Filters
  // ---------------------------

  add_filter( 'tco_localize_' . $tco->handle( 'admin-js' ), 'x_tco_localize_admin_js' );
  add_filter( 'tco_localize_' . $tco->handle( 'updates' ), 'x_tco_localize_updates' );

}

add_action( 'init', 'x_tco_init' );
add_action( 'admin_init', 'x_tco_init' );


//
// Localization
//

function x_tco_localize_admin_js( $strings ) {

  $strings = array_merge( $strings, array(
    'details' => __( 'Details', '__x__' ),
    'back'    => __( 'Back', '__x__' ),
    'yep'     => __( 'Yep', '__x__' ),
    'nope'    => __( 'Nope', '__x__' )
  ) );

  return $strings;

}

function x_tco_localize_updates( $strings ) {

  $strings = array_merge( $strings, array(
    'connection-error' => __( 'Could not establish connection. For assistance, please start by reviewing our article on troubleshooting <a href="https://theme.co/apex/kb/connection-issues/">connection issues.</a>', '__x__' )
  ) );

  return $strings;

}
