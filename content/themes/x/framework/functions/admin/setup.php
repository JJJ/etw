<?php

// =============================================================================
// FUNCTIONS/ADMIN/SETUP.PHP
// -----------------------------------------------------------------------------
// Sets up theme defaults and registers various WordPress features.
// =============================================================================


// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Helpers
//   02. Validation Setup
//   01. Enqueue Admin Styles
//   02. Enqueue Admin Scripts
//   03. Activation Redirect
//   04. Validation Notice
//   05. Portfolio Thumbnail Column
//   06. Bust Caches
// =============================================================================

// Helpers
// =============================================================================

function x_validation() {
  return X_Validation::instance();
}

function x_addons_page_home() {
  include X_TEMPLATE_PATH . '/framework/functions/admin/markup/page-home.php';
}



// Validation Setup
// =============================================================================

x_validation();
X_Validation_Updates::instance();
X_Validation_Theme_Options_Manager::instance();
X_Validation_Extensions::instance();



// Setup Menu
// =============================================================================

function x_addons_add_menu() {
  add_menu_page( 'Validation', X_TITLE, 'manage_options', 'x-addons-home', 'x_addons_page_home', 'dashicons-arrow-right-alt2', 3 );
  add_submenu_page( 'x-addons-home', 'Validation', 'Validation', 'manage_options', 'x-addons-home', 'x_addons_page_home' );
}

add_action( 'admin_menu', 'x_addons_add_menu', 5 );



// Enqueue Admin Styles
// =============================================================================

if ( ! function_exists( 'x_enqueue_admin_styles' ) ) :
  function x_enqueue_admin_styles( $hook ) {

    wp_enqueue_style( x_tco()->handle( 'admin-css' ) );
    wp_enqueue_style( 'x-base', X_TEMPLATE_URL . '/framework/dist/css/admin/base.css', NULL, X_ASSET_REV, 'all' );
    wp_enqueue_style( 'wp-color-picker' );

    if ( strpos( $hook, 'x-extensions' ) != false ) {
      wp_enqueue_style( 'x-datepicker', X_TEMPLATE_URL . '/framework/dist/css/admin/datepicker.css', NULL, X_ASSET_REV, 'all' );
    }

    if ( X_VISUAL_COMOPSER_IS_ACTIVE ) {
      wp_enqueue_style( 'x-visual-composer', X_TEMPLATE_URL . '/framework/dist/css/admin/visual-composer.css', NULL, X_ASSET_REV, 'all' );
    }

  }
endif;

add_action( 'admin_enqueue_scripts', 'x_enqueue_admin_styles' );



// Enqueue Admin Scripts
// =============================================================================

if ( ! function_exists( 'x_enqueue_post_meta_scripts' ) ) :
  function x_enqueue_post_meta_scripts( $hook ) {

    GLOBAL $post;
    GLOBAL $wp_customize;

    if ( isset( $wp_customize ) ) {
      return;
    }

    wp_enqueue_script( 'wp-color-picker' );

    if ( $hook == 'nav-menus.php' ) {
      wp_enqueue_script( 'x-menus-js', X_TEMPLATE_URL . '/framework/dist/js/admin/x-menus.js', array( 'jquery' ), X_ASSET_REV, true );
    }

    if ( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'edit-tags.php' ) {
      wp_enqueue_script( 'x-meta-js', X_TEMPLATE_URL . '/framework/dist/js/admin/x-meta.js', array( 'jquery', 'media-upload', 'thickbox' ), X_ASSET_REV, true );
    }

    if ( $hook == 'post.php' || $hook == 'post-new.php' || strpos( $hook, 'x-extensions' ) != false ) {
      wp_enqueue_script( 'jquery-ui-datepicker' );
    }

  }
  add_action( 'admin_enqueue_scripts', 'x_enqueue_post_meta_scripts' );
endif;



// Activation Redirect
// =============================================================================

function x_theme_activation_redirect() {

  if ( isset( $_GET['activated'] ) ) {
    wp_redirect( x_addons_get_link_home() );
  }

}

add_action( 'admin_init', 'x_theme_activation_redirect' );



// Validation Notice
// =============================================================================

function x_validation_notice() {

  if ( false === get_option( 'x_dismiss_validation_notice', false ) && ! x_is_validated() && ! in_array( get_current_screen()->parent_base, apply_filters( 'x_validation_notice_blocked_screens', array( 'x-addons-home' ) ) ) ) {

    x_tco()->admin_notice( array(
      'message' => sprintf( x_i18n('overview', 'validation-notice'), x_addons_get_link_home() ),
      'dismissible' => true,
      'ajax_dismiss' => 'x_dismiss_validation_notice'
    ) );

  }

}

add_action( 'admin_notices', 'x_validation_notice' );




// Portfolio Thumbnail Column
// =============================================================================

function x_add_thumbnail_column( $columns ) {
  $thumb   = array( 'thumb' => __( 'Thumbnail', '__x__' ) );
  $columns = array_slice( $columns, 0, 2 ) + $thumb + array_slice( $columns, 1 );
  return $columns;
}

function x_add_thumbnail_column_content( $column ) {
  if ( $column == 'thumb' ) {
    echo '<a href="' . get_edit_post_link() . '">' . get_the_post_thumbnail( get_the_ID(), array( 200, 200 ) ) . '</a>';
  }
}

add_filter( 'manage_x-portfolio_posts_columns', 'x_add_thumbnail_column', 10, 1 );
add_action( 'manage_x-portfolio_posts_custom_column', 'x_add_thumbnail_column_content', 10, 1 );



// Bust Caches
// =============================================================================

if ( ! function_exists( 'x_bust_caches' ) ) :
  function x_bust_caches() {
    if ( isset( $_GET['x-bust-caches'] ) ) {
      x_bust_google_fonts_cache();
    }
  }
  add_action( 'admin_init', 'x_bust_caches' );
endif;
