<?php

class X_Validation_Extensions {

  public static $instance;

  public function __construct() {

    x_validation()->add_script_data( 'x-extension', array( $this, 'script_data_extensions' ) );
    add_action( 'wp_ajax_x_extensions_install', array( $this, 'ajax_tgmpa_install_plugin' ) );
    add_action( 'wp_ajax_x_extensions_activate', array( $this, 'ajax_activate_plugin' ) );
    add_action( 'wp_ajax_x_extensions_deactivate', array( $this, 'ajax_activate_plugin' ) );

  }

  public function script_data_extensions() {

    $tgmpa_integration = X_TGMPA_Integration::instance();

    return array(
      'extensions'          => $tgmpa_integration->get_extension_list(),
      'approvedPlugins'     => $tgmpa_integration->get_approved_plugin_list(),
      'pluginsURI'          => admin_url( 'plugins.php' ),
      'error'               => __( 'Error encountered.', '__x__' ),
      'activate'            => __( 'Activate', '__x__' ),
      'activated'           => __( 'Installed & Activated', '__x__' ),
      'errorBack'           => __( 'Go Back', '__x__' ),
      'installing'          => __( 'Installing&hellip;', '__x__' ),
      'activating'          => __('Activating&hellip;', '__x__' ),
      'waiting-to-install'  => __( 'Waiting to install&hellip;', '__x__' ),
      'waiting-to-activate' => __( 'Waiting to activate&hellip;', '__x__' ),
    );
  }


  public function ajax_tgmpa_install_plugin() {

    x_tco()->check_ajax_referer();

    $install = X_TGMPA_Integration::instance()->install_plugin( isset( $_POST['slug'] ) ? $_POST['slug'] : null );

    if ( is_wp_error( $install ) ) {
      return wp_send_json_error( array( 'message' => $install->get_error_message() ) );
    }

    wp_send_json_success();

  }

  public function ajax_activate_plugin() {

    x_tco()->check_ajax_referer();

    if ( ! current_user_can( 'activate_plugins' ) || ! isset( $_POST['plugin'] ) || ! $_POST['plugin'] ) {
      wp_send_json_error( array( 'message' => 'No plugin specified' ) );
    }

    $activate = activate_plugin( $_POST['plugin'] );

    if ( is_wp_error( $activate ) ) {
      wp_send_json_error( array( 'message' => $install->get_error_message() ) );
    }

    wp_send_json_success( array( 'plugin' => $_POST['plugin'] ) );

  }

  public function ajax_deactivate_plugin() {

    x_tco()->check_ajax_referer();

    if ( ! current_user_can( 'activate_plugins' ) || ! isset( $_POST['plugin'] ) || ! $_POST['plugin'] ) {
      wp_send_json_error( array( 'message' => 'No plugin specified' ) );
    }

    wp_send_json_error( array( 'message' => 'No plugin specified' ) );

    $deactivate = deactivate_plugin( $_POST['plugin'] );;

    if ( is_wp_error( $deactivate ) ) {
      wp_send_json_error( array( 'message' => $install->get_error_message() ) );
    }

    wp_send_json_success( array( 'plugin' => $_POST['plugin'] ) );

  }

  public static function instance() {
    if ( ! isset( self::$instance ) ) {
      self::$instance = new self;
    }
    return self::$instance;
  }

}
