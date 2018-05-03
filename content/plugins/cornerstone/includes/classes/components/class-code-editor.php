<?php

class Cornerstone_Code_Editor {

  static $instance;
  public $localized = false;

  public static function init( $register = true ) {

    self::$instance = new Cornerstone_Code_Editor( $register );
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
    wp_register_style( 'cs-code-editor-style' , CS()->css( 'admin/code-editor' ), array(), CS()->version() );

    wp_register_script( 'cs-code-editor', CS()->js( 'admin/code-editor' ), array( 'jquery' ), CS()->version(), true );
    wp_localize_script( 'cs-code-editor', 'csCodeEditor', array() );

  }

  public static function enqueue() {
    if ( !isset( self::$instance ) ) {
      self::init();
    }
    wp_enqueue_style( 'cs-code-editor-style' );
    wp_enqueue_script( 'cs-code-editor' );
  }

}
