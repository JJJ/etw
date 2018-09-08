<?php

// Theme Constants
// =============================================================================

define( 'X_VERSION', '6.2.5' );
define( 'X_SLUG', 'x' );
define( 'X_TITLE', 'X' );
define( 'X_I18N_PATH', X_TEMPLATE_PATH . '/framework/functions/x/i18n');



// App Environment Data
// =============================================================================

function x_cornerstone_app_env( $env ) {
  $env['product'] = 'x';
  $env['title'] = X_TITLE;
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

add_action('x_overview_init', 'x_validation_modules' );

function x_validation_modules() {

  require_once( X_TEMPLATE_PATH . '/framework/functions/x/demo/legacy/ajax-handler.php' );
  require_once( X_TEMPLATE_PATH . '/framework/functions/x/demo/class-x-demo-import-session.php' );
  require_once( X_TEMPLATE_PATH . '/framework/functions/x/demo/class-x-demo-import-registry.php' );
  require_once( X_TEMPLATE_PATH . '/framework/functions/x/demo/class-x-demo-import-processor.php' );

  require_once( X_TEMPLATE_PATH . '/framework/functions/x/validation/class-validation-demo-content.php' );
  require_once( X_TEMPLATE_PATH . '/framework/functions/x/validation/class-validation-cornerstone.php' );

  X_Validation_Demo_Content::instance();
  X_Validation_Cornerstone::instance();

}

function x_overview_output_demo_content_module() {

  $is_validated            = x_is_validated();
  $status_icon_validated   = '<div class="tco-box-status tco-box-status-validated">' . x_tco()->get_admin_icon( 'unlocked' ) . '</div>';
  $status_icon_unvalidated = '<div class="tco-box-status tco-box-status-unvalidated">' . x_tco()->get_admin_icon( 'locked' ) . '</div>';
  $status_icon_dynamic     = ( $is_validated ) ? $status_icon_validated : $status_icon_unvalidated;

  include( X_TEMPLATE_PATH . '/framework/functions/x/validation/markup/page-home-box-demo-content.php' );

}

add_action('x_overview_main_before_theme_options_manager', 'x_overview_output_demo_content_module' );


function x_load_preinit() {
  require_once X_TEMPLATE_PATH . '/framework/functions/x/migration.php';
}

add_action('x_boot_preinit', 'x_load_preinit' );
