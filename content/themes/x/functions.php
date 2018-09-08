<?php

// =============================================================================
// FUNCTIONS.PHP
// -----------------------------------------------------------------------------
// Theme functions for X.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Boot Registry
//   02. Bootstrap Class
//   03. Content Width
//   04. Localization
// =============================================================================

// Boot Registry
// =============================================================================

function x_boot_registry() {
  return array(
    'preinit' => array(
      'functions/helpers',
      'functions/thumbnails',
      'functions/setup',

      'tco/tco',
      'legacy/setup',
      'functions/fonts',
      'functions/custom-sidebars',

      'functions/portfolio',
      'functions/plugins/setup',
      'functions/updates/class-theme-updater',
      'functions/updates/class-plugin-updater'
    ),

    'init' => array(),

    'front_end' => array(
      'functions/frontend/view-routing',
      'functions/frontend/styles',
      'functions/frontend/scripts',
      'functions/frontend/content',
      'functions/frontend/classes',
      'functions/frontend/meta',
      'functions/frontend/integrity',
      'functions/frontend/renew',
      'functions/frontend/icon',
      'functions/frontend/ethos',
      'functions/frontend/social',
      'functions/frontend/breadcrumbs',
      'functions/frontend/pagination',
      'functions/frontend/featured',
      'functions/frontend/conditionals',
    ),

    'logged_in' => array(

    ),

    'admin' => array(
      'functions/admin/class-validation',
      'functions/admin/class-validation-updates',
      'functions/admin/class-validation-theme-options-manager',
      'functions/admin/class-validation-extensions',
      'functions/admin/setup',
      'functions/admin/customizer',
      'functions/admin/meta-boxes',
      'functions/admin/meta-entries',
      'functions/admin/taxonomies'
    ),

    'app_init' => array(
      'functions/theme-options',
    ),

    'ajax' => array()

  );
}



// Bootstrap Class
// =============================================================================

class X_Bootstrap {

  private static $instance;
  protected $registry = array();
  protected $theme_option_defaults = array();

  public function boot() {

    // Define Path / URL Constants
    // ---------------------------

    define( 'X_TEMPLATE_PATH', get_template_directory() );
    define( 'X_TEMPLATE_URL', get_template_directory_uri() );

    // Preboot
    // -------

    $x_boot_files = glob( X_TEMPLATE_PATH . '/framework/load/*.php' );

    sort( $x_boot_files );

    foreach ( $x_boot_files as $filename ) {
      $file = basename( $filename, '.php' );
      if ( file_exists( $filename ) && apply_filters( "x_pre_boot_$file", '__return_true' ) ) {
        require_once( $filename );
      }
    }


    // Set Asset Revision Constant (For Cache Busting)
    // -----------------------------------------------

    define( 'X_ASSET_REV', X_VERSION );

    // Preinit
    // --------

    $this->registry = x_boot_registry();
    $this->boot_context('preinit');

    // Theme Option Defaults
    // ---------------------
    $this->theme_option_defaults = include X_TEMPLATE_PATH . '/framework/data/option-defaults.php';

    if ( is_admin() ) {
      $this->boot_context('admin');
    }

    add_action( 'init',                               array( $this, 'init' ) );
    add_action( 'admin_init',                         array( $this, 'ajax_init' ) );
    add_action( 'cornerstone_before_boot_app',        array( $this, 'app_init' ) );
    add_action( 'cornerstone_before_custom_endpoint', array( $this, 'app_init' ) );
    add_action( 'cornerstone_before_admin_ajax',      array( $this, 'app_init' ) );
    add_action( 'cornerstone_before_admin_ajax',      array( $this, 'ajax_init' ) );
    add_action( 'cornerstone_before_custom_endpoint', array( $this, 'ajax_init' ) );



  }

  public function init() {

    $this->boot_context('init');

    if ( ! is_admin() ) {
      $this->boot_context('front_end');
    }

    if ( is_user_logged_in() ) {
      $this->boot_context('logged_in');
    }

  }

  public function admin_init() {
    $this->boot_context('admin_init');
  }

  public function app_init() {
    $this->boot_context('app_init');
  }

  public function ajax_init() {
    if ( defined( 'DOING_AJAX' ) ) {
      $this->boot_context('ajax');
    }
  }

  public function boot_context( $context ) {

    if ( ! isset( $this->registry[$context] ) ) {
      return;
    }

    foreach ( $this->registry[$context] as $file ) {
      require_once( X_TEMPLATE_PATH . "/framework/$file.php" );
    }

    do_action( 'x_boot_' . $context );

  }

  public static function instance() {
    if ( ! isset( self::$instance ) ) {
      self::$instance = new X_Bootstrap();
    }
    return self::$instance;
  }

  public function get_theme_option_defaults() {
    return $this->theme_option_defaults;
  }

  public function get_theme_option_default( $key ) {
    return isset( $this->theme_option_defaults[$key]) ? $this->theme_option_defaults[$key] : false;
  }

}

function x_bootstrap() {
  return X_Bootstrap::instance();
}

x_bootstrap()->boot();



// Content Width
// =============================================================================

if ( ! isset( $content_width ) ) :

  $stack = x_get_stack();

  switch ( $stack ) {
    case 'integrity' :
      $content_width = x_post_thumbnail_width() - 120;
      break;
    case 'renew' :
      $content_width = x_post_thumbnail_width();
      break;
    case 'icon' :
      $content_width = x_post_thumbnail_width();
      break;
    case 'ethos' :
      $content_width = x_post_thumbnail_width();
      break;
  }

endif;



// Localization
// =============================================================================

load_theme_textdomain( '__x__', X_TEMPLATE_PATH . '/framework/lang' );
