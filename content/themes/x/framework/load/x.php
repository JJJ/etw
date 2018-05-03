<?php

// Theme Constants
// =============================================================================

define( 'X_VERSION', '6.0.4' );
define( 'X_SLUG', 'x' );
define( 'X_TITLE', 'X' );
define( 'X_I18N_PATH', X_TEMPLATE_PATH . '/framework/functions/x/i18n');



// App Environment Data
// =============================================================================

function x_cornerstone_app_env( $env ) {
  $env['product'] = 'x';
  $env['version'] = X_VERSION;
  $env['productKey'] = esc_attr( get_option( 'x_product_validation_key', '' ) );
  return $env;
}

add_filter( '_cornerstone_app_env', 'x_cornerstone_app_env' );

// Label Replacements
// =============================================================================

function x_cornerstone_toolbar_title() {
  return __('X', '__x__');
}

add_filter( '_cornerstone_toolbar_menu_title', 'x_cornerstone_toolbar_title' );



// Version Body Class
// =============================================================================

if ( ! function_exists( 'x_body_class_version' ) ) :
  function x_body_class_version( $output ) {

    $output[] = 'x-v' . str_replace( '.', '_', X_VERSION );
    return $output;

  }
  add_filter( 'body_class', 'x_body_class_version', 10000 );
endif;



// Overview Page Modules
// =============================================================================

add_action('x_overview_init', 'x_overview_auto_install_cornerstone' );

function x_overview_auto_install_cornerstone() {

  $modules_path = X_TEMPLATE_PATH . '/framework/functions/x/overview/modules/';

  require_once( "$modules_path/class-addons-demo-content.php" );
  require_once( "$modules_path/class-addons-cornerstone.php" );

  X_Addons_Demo_Content::instance();
  X_Addons_Cornerstone::instance();

}

function x_overview_output_demo_content_module() {

  $markup_path = X_TEMPLATE_PATH . '/framework/functions/x/overview/markup/';

  $is_validated            = x_is_validated();
  $status_icon_validated   = '<div class="tco-box-status tco-box-status-validated">' . x_tco()->get_admin_icon( 'unlocked' ) . '</div>';
  $status_icon_unvalidated = '<div class="tco-box-status tco-box-status-unvalidated">' . x_tco()->get_admin_icon( 'locked' ) . '</div>';
  $status_icon_dynamic     = ( $is_validated ) ? $status_icon_validated : $status_icon_unvalidated;

  require( "$markup_path/page-home-box-demo-content.php" );

}

add_action('x_overview_main_before_theme_options_manager', 'x_overview_output_demo_content_module' );


function x_add_boot_files( $files ) {

  $files[] = X_TEMPLATE_PATH . '/framework/functions/x/migration.php';
  return $files;
}

add_filter('x_boot_files', 'x_add_boot_files' );
