<?php

class X_Validation_Cornerstone {

  public static $instance;

  public function __construct() {


    add_action( 'admin_notices', array( $this, 'maybe_show_notices' ), 0 );

    add_action( 'admin_init', array( $this, 'maybe_install_or_activate' ) );


  }

  public function maybe_install_or_activate() {


    if ( isset( $_REQUEST['_cs_install_nonce'] ) && wp_verify_nonce( $_REQUEST['_cs_install_nonce'], 'install_cornerstone' ) && ! $this->is_cornerstone_installed() && current_user_can( 'install_plugins' ) ) {
      // Install Cornerstone via TGMPA
      $this->install_error = X_TGMPA_Integration::instance()->install_plugin( 'cornerstone', true );

      $this->activate_cornerstone();

      remove_action( 'admin_notices', array( $this, 'maybe_show_notices' ), 0 );
      add_action( 'admin_notices', array( $this, 'install_notice' ), 0 );
    }

    if ( isset( $_REQUEST['_cs_activate_nonce'] ) && wp_verify_nonce( $_REQUEST['_cs_activate_nonce'], 'activate_cornerstone' ) && ! TGM_Plugin_Activation::get_instance()->is_plugin_active( 'cornerstone' ) && current_user_can( 'activate_plugins' ) ) {
      $this->activate_cornerstone();
      remove_action( 'admin_notices', array( $this, 'maybe_show_notices' ), 0 );
      add_action( 'admin_notices', array( $this, 'activate_notice' ), 0 );
    }


  }

  public function maybe_show_notices() {

    // Give users link to install Cornerstone
    if ( ! $this->is_cornerstone_installed() && current_user_can( 'install_plugins' ) ) {
      $install_url = add_query_arg( array(
        '_cs_install_nonce' => wp_create_nonce( 'install_cornerstone' )
      ), x_addons_get_link_home() );

      x_tco()->admin_notice( array(
        'message' => sprintf( __( 'You&apos;re almost ready to start using X. Please <a href="%s">click here to install and activate</a> the required <strong>Cornerstone</strong> plugin. ', '__x__' ), $install_url ),
        'dismissible' => false,
      ) );
      return;
    }

    // Give users link to activate Cornerstone if it is not installed
    if ( ! TGM_Plugin_Activation::get_instance()->is_plugin_active( 'cornerstone' ) && current_user_can( 'activate_plugins' )) {
      $activate_url = add_query_arg( array(
        '_cs_activate_nonce' => wp_create_nonce( 'activate_cornerstone' )
      ), x_addons_get_link_home() );

      x_tco()->admin_notice( array(
        'message' => sprintf( __( 'You&apos;re almost ready to start using X. Please <a href="%s">click here to activate</a> the required <strong>Cornerstone</strong> plugin. ', '__x__' ), $activate_url ),
        'dismissible' => false,
      ) );
    }

  }

  public function activate_notice() {

    x_tco()->admin_notice( array(
      'message' => __( 'Cornerstone activated!', '__x__' ),
      'dismissible' => true,
    ) );

  }

  public function install_notice() {

    if ( is_wp_error( $this->install_error ) ) {
      x_tco()->admin_notice( array(
        'message' => sprintf( __( 'Unable to install Cornerstone. %s', '__x__' ), $this->install_error->get_error_message() ),
        'dismissible' => false
      ) );
    } else {
      x_tco()->admin_notice( array(
        'message' => __( 'Cornerstone successfully installed!', '__x__' ),
        'dismissible' => true,
      ) );
    }
  }

  // Only called if user clicks link in admin notice
  public function activate_cornerstone() {

    if ( ! function_exists( 'activate_plugin' ) ) {
      include_once( ABSPATH . '/wp-admin/includes/plugin.php' );
    }

    activate_plugin( 'cornerstone/cornerstone.php' );

  }

  // Direct file check if cornerstone is installed. Faster than TGM polling the WordPress plugin list
  public function is_cornerstone_installed() {
    return file_exists( WP_PLUGIN_DIR . '/cornerstone/cornerstone.php' );
  }

  public static function instance() {
    if ( ! isset( self::$instance ) ) {
      self::$instance = new self;
    }
    return self::$instance;
  }

}
