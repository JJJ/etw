<?php

// =============================================================================
// FUNCTIONS/FRONT-END/SETUP.PHP
// -----------------------------------------------------------------------------
// Generated scripts and styles.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Enqueue Site Styles
//   02. Generate Styles
//   03. Output Generated Styles
//   04. Caching
// =============================================================================

// Enqueue Site Styles
// =============================================================================

function x_enqueue_site_styles() {

  // Stack Data
  // ----------

  $stack  = x_get_stack();
  $design = x_get_option( 'x_integrity_design' );

  if ( $stack == 'integrity' && $design == 'light' ) {
    $ext = '-light';
  } elseif ( $stack == 'integrity' && $design == 'dark' ) {
    $ext = '-dark';
  } else {
    $ext = '';
  }


  // Enqueue Styles
  // --------------

  wp_enqueue_style( 'x-stack', X_TEMPLATE_URL . '/framework/dist/css/site/stacks/' . $stack . $ext . '.css', NULL, X_ASSET_REV, 'all' );

  do_action( 'x_enqueue_styles', $stack, $ext );

  if ( is_child_theme() && apply_filters( 'x_enqueue_parent_stylesheet', false ) ) {
    $rev = ( defined( 'X_CHILD_ASSET_REV' ) ) ? X_CHILD_ASSET_REV : X_ASSET_REV;
    wp_enqueue_style( 'x-child', get_stylesheet_directory_uri() . '/style.css', array(), $rev, 'all' );
  }

  if ( is_rtl() ) {
    wp_enqueue_style( 'x-rtl', X_TEMPLATE_URL . '/framework/dist/css/site/rtl/' . $stack . '.css', NULL, X_ASSET_REV, 'all' );
  }

}

add_action( 'wp_enqueue_scripts', 'x_enqueue_site_styles' );



// Generate Styles
// =============================================================================

function x_get_generated_css() {

  $outp_path = X_TEMPLATE_PATH . '/framework/functions/frontend/generated-css';

  include( $outp_path . '/variables.php' );

  ob_start();

    include( $outp_path . '/' . $x_stack . '.php' );
    include( $outp_path . '/base.php' );
    include( $outp_path . '/buttons.php' );
    include( $outp_path . '/widgets.php' );
    include( $outp_path . '/bbpress.php' );
    include( $outp_path . '/buddypress.php' );
    include( $outp_path . '/woocommerce.php' );
    include( $outp_path . '/gravity-forms.php' );

  $css = ob_get_clean();

  if ( function_exists('cornerstone_post_process_css' ) ) {
    $css = cornerstone_post_process_css( $css );
  }

  return x_get_clean_css( $css );

}

function x_output_css() {
  echo x_get_generated_css();
}



// Output Generated Styles
// =============================================================================

function x_output_generated_styles() {

  do_action('x_before_head_css');

  echo '<style id="x-generated-css">';
  do_action( 'x_head_css' );
  echo '</style>';

  do_action('x_after_head_css');

}

add_action( 'wp_head', 'x_output_generated_styles', 9998, 0 );
add_action( 'x_head_css', 'x_output_css' );

function x_register_custom_styles() {

  if ( ! function_exists( 'cornerstone_register_styles' ) ) {
    return;
  }

  $custom_css = x_get_option( 'x_custom_styles' );

  if ( $custom_css ) {
    cornerstone_register_styles( 'x-custom', $custom_css );
  }

}

add_action( 'x_before_head_css', 'x_register_custom_styles' );



// // Caching
// // =============================================================================

// //
// // Cache Customizer CSS.
// //

// function x_customizer_cache_css() {

//   $cached_css = get_option( 'x_cache_customizer_css', false );

//   if ( $cached_css == false ) {

//     $cached_css = x_get_generated_css();

//     update_option( 'x_cache_customizer_css', $cached_css );

//   }

//   return $cached_css;

// }


// //
// // Cache bust.
// //

// function x_customizer_bust_css_cache() {

//   delete_option( 'x_cache_customizer_css' );

// }

// add_action( 'customize_save_after', 'x_customizer_bust_css_cache' );


// //
// // Bust Customizer CSS cache when certain plugins are activated.
// //

// function x_customizer_bust_css_cache_on_plugin_change( $plugin, $network_activation ) {

//   $plugins = array(
//     'bbpress/bbpress.php',
//     'buddypress/bp-loader.php',
//     'woocommerce/woocommerce.php',
//     'gravityforms/gravityforms.php'
//   );

//   if ( in_array( $plugin, $plugins ) ) {
//     x_customizer_bust_css_cache();
//   }

// }

// add_action( 'activated_plugin', 'x_customizer_bust_css_cache_on_plugin_change', 10, 2 );
// add_action( 'deactivated_plugin', 'x_customizer_bust_css_cache_on_plugin_change', 10, 2 );
