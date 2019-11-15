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
    $huebert_style_asset = CS()->css( 'admin/huebert' );
    $huebert_script_asset = CS()->js( 'admin/huebert' );
    wp_register_style( 'cs-huebert-style' , $huebert_style_asset['url'], array(), $huebert_style_asset['version'] );
    wp_register_script( 'cs-huebert', $huebert_script_asset['url'], array( 'underscore', 'jquery' ), $huebert_script_asset['version'], true );

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
