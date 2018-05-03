<?php

class Cornerstone_Huebert {

  static $instance;

  public static function init( $register = true ) {

    self::$instance = new Cornerstone_Huebert( $register );
  }

  public static function instance( $register = true ) {
	if ( !isset( self::$instance ) ) {
      self::init( $register );
    }
    return self::$instance;
  }

  function __construct( $register = true ) {
    if ( $register ) {
      add_action( is_admin() ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts', array( $this, 'register' ) );
    }
  }

  public function register() {
    wp_register_style( 'cs-huebert-style' , CS()->css( 'admin/huebert' ), array(), CS()->version() );
    wp_register_script( 'cs-huebert', CS()->js( 'admin/huebert' ), array( 'underscore', 'jquery' ), CS()->version(), true );

    wp_localize_script( 'cs-huebert', 'csHuebert', array(
	'selectColor' => csi18n('admin.huebert-select-color')
    ) );

  }

  public static function enqueue() {
    if ( !isset( self::$instance ) ) {
      self::init();
    }
    wp_enqueue_style( 'cs-huebert-style' );
    wp_enqueue_script( 'cs-huebert' );
  }

}
