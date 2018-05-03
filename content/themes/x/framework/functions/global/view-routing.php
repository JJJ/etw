<?php

// =============================================================================
// FUNCTIONS/GLOBAL/CLASS-VIEW-ROUTING.PHP
// -----------------------------------------------------------------------------
// View Routing in X.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup x_late_template_redirect hook
//   02. Get / Set View
//   03. View Router
// =============================================================================

// Setup x_late_template_redirect hook
// =============================================================================

function x_setup_x_late_template_redirect( $template ) {
  do_action('x_late_template_redirect');
  return $template;
}

add_filter('template_include', 'x_setup_x_late_template_redirect');



// Get / Set View
// =============================================================================

function x_get_view( $directory, $file_base, $file_extension = '', $custom_data = array(), $echo = true ) {

  $file_action = $directory . '_' . $file_base . ( empty( $file_extension ) ? '' : '-' . $file_extension );

  $view = array(
    'base'      => 'framework/views/' . $directory . '/' . $file_base,
    'extension' => $file_extension
  );

  $view = apply_filters( 'x_get_view', $view, $directory, $file_base, $file_extension );

  if ( '' === $view['base'] ) {
    return;
  }

  $template = apply_filters('x_locate_template', X_View_Router::locate( $view['base'], $view['extension'] ), $view, $directory, $file_base, $file_extension );

  if ( ! $template ) {
    return;
  }

  do_action( 'x_before_view_' . $file_action );

  $output = X_View_Router::render( $template, $custom_data, $echo );

  do_action( 'x_after_view_' . $file_action );

  return $output;

}


function x_set_view( $action, $directory, $file_base, $file_extension = '', $data = NULL, $priority = 10, $override = false ) {
  X_View_Router::set( $action, $directory, $file_base, $file_extension, $data, $priority, $override );
}



// View Router
// =============================================================================

class X_View_Router {

  static $instance;

  public $memory = array();


  // Route
  // -----

  public function route( $action, $directory, $file_base, $file_extension = '', $data = array(), $priority = 10, $override = false ) {

    if ( ! isset( $this->memory[$action] ) ) {
      $this->memory[$action] = array();
    }

    $key = $this->generate_key( array( $directory, $file_base, $file_extension, $priority ) );

    if ( ! $override ) {
      while ( isset( $this->memory[$action][$key] ) ) {
        $key = $this->generate_key( array( $directory, $file_base, $file_extension, $priority++ ) );
      }
    }

    $this->memory[$action][$key] = array( $directory, $file_base, $file_extension, $data );

    add_action( $action, array( $this, $key ), $priority );

  }


  // Generate Key
  // ------------

  public function generate_key( $array ) {
    return $this->sanitize( implode( '_', $array ) );
  }


  // Call
  // ----

  public function __call( $name, $args ) {

    $action = current_filter();

    if ( ! isset( $this->memory[$action] ) || ! isset( $this->memory[$action][$name] ) ) {
      return;
    }

    $recalled = $this->memory[$action][$name];


    call_user_func_array( 'x_get_view', $this->memory[$action][$name] );

  }


  // Sanitize
  // --------

  public function sanitize( $key ) {
    return preg_replace( '/[^a-z0-9_]/', '', strtolower( str_replace( '-', '_', $key ) ) );
  }


  // Set
  // ---

  public static function set( $action, $directory, $file_base, $file_extension = '', $data = array(), $priority = 10, $override = false ) {

    if ( ! isset( self::$instance ) ) {
      self::init();
    }

    return self::$instance->route( $action, $directory, $file_base, $file_extension, $data, $priority, $override );

  }


  // Render
  // ------
  // 01. Import WordPress globals.
  // 02. Load the partial with $data extracted.

  public static function render( $_template_file, $_custom_data = array(), $echo = true ) {

    global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID; // 01

    if ( is_array( $wp_query->query_vars ) ) {
        extract( $wp_query->query_vars, EXTR_SKIP );
    }

    if ( isset( $s ) ) {
      $s = esc_attr( $s );
    }

    $_extractable_data = ( is_callable( $_custom_data ) ) ? call_user_func( $_custom_data ) : $_custom_data; // 02

    if ( is_array( $_extractable_data ) ) {
      extract( $_extractable_data );
    }

    if ( $echo === false ) {
      ob_start();
      include( $_template_file );
      return ob_get_clean();
    }

    include( $_template_file );

  }


  // Locate
  // ------

  public static function locate( $slug, $name = null ) {

    $templates = array();
    $name = (string) $name;
    if ( '' !== $name )
      $templates[] = "{$slug}-{$name}.php";

    $templates[] = "{$slug}.php";

    return locate_template( $templates, false, false );

  }


  // Init
  // ----

  public static function init() {
    if ( ! isset( self::$instance ) ) {
      self::$instance = new self();
    }
  }

}
