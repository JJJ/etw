<?php

// =============================================================================
// LEGACY/SETUP.PHP
// -----------------------------------------------------------------------------
// Sets up the legacy theme views, features, options, et cetera.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Require Files
//   02. Widget Areas
//   03. Fonts
// =============================================================================

// Require Files
// =============================================================================

function x_legacy_modes() {

  $lgcy_path = X_TEMPLATE_PATH . '/framework/legacy';

  $cranium_headers = apply_filters( 'x_legacy_cranium_headers', true );
  $cranium_footers = apply_filters( 'x_legacy_cranium_footers', true );
  $cranium         = $cranium_headers || $cranium_footers;

  if ( $cranium ) {
    require_once( $lgcy_path . '/cranium/setup.php' );
  }

  if ( $cranium_headers ) {
    require_once( $lgcy_path . '/cranium/headers/setup.php' );
    do_action( 'x_classic_headers' );
  }

  if ( $cranium_footers ) {
    require_once( $lgcy_path . '/cranium/footers/setup.php' );
    do_action( 'x_classic_footers' );
  }

}

add_action( 'x_late_template_redirect', 'x_legacy_modes', 25 );



// Widget Areas
// =============================================================================

if ( ! function_exists( 'x_legacy_widgets_init' ) ) :
  function x_legacy_widgets_init() {

    // Header
    // ------

    $i = 0;
    while ( $i < 4 ) : $i++;
      register_sidebar( array( // 2
        'name'          => __( 'Header ', '__x__' ) . $i,
        'id'            => 'header-' . $i,
        'description'   => __( 'Widgetized header area.', '__x__' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="h-widget">',
        'after_title'   => '</h4>',
      ) );
    endwhile;


    // Footer
    // ------

    $i = 0;
    while ( $i < 4 ) : $i++;
      register_sidebar( array( // 3
        'name'          => __( 'Footer ', '__x__' ) . $i,
        'id'            => 'footer-' . $i,
        'description'   => __( 'Widgetized footer area.', '__x__' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="h-widget">',
        'after_title'   => '</h4>',
      ) );
    endwhile;

  }
  add_action( 'widgets_init', 'x_legacy_widgets_init' );
endif;



// Fonts
// =============================================================================

// add_filter('x_disable_font_manager', '__return_false' );
//
// if ( false !== get_option('x_body_font_family') ) {
//   add_option( 'x_disable_font_manager', true );
// }
