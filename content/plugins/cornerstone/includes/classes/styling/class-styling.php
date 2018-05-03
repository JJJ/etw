<?php

class Cornerstone_Styling extends Cornerstone_Plugin_Component {

  public $dependencies = array( 'Font_Manager', 'Color_Manager' );
  public $styles = array();
  public $minify = array();
  public $count = 0;
  public $late_styles = array();

  public function has_styles( $handle ) {
    return isset( $this->styles[$handle] ) || isset( $this->late_styles[$handle] );
  }

  public function add_styles($handle, $css, $minify = true ) {

    if ( $this->has_styles( $handle ) ) {
      return;
    }

    $this->minify[$handle] = $minify;

    do_action( 'cs_styling_add_styles', $handle, $css, $minify );

    if ( did_action( 'wp_head' ) ) {

      /**
       * To avoid FOUC we output the style tag asap by default. This results in
       * invalid markup, although most browsers render it just fine. If you need
       * strict markup you can set this constant
       *
       * define('CS_STRICT_LATE_STYLES', true );
       *
       * This will use a more robust and strict style loader. It outputs late
       * CSS as script tags (templates) and adds them t the head after page load.
       */
      if ( defined('CS_STRICT_LATE_STYLES') && CS_STRICT_LATE_STYLES ) {
        $this->late_styles[$handle] = $css;
      } else {
        $source = array();
        $source[$handle] = $css;
        $output = $this->generate_styles_from_source( $source );
        echo "<style>$output</style>";
      }

    } else {
      $this->styles[$handle] = $css;
    }

  }

  public function get_generated_styles_by_handle( $handle ) {
    $source = array();
    $source[$handle] = $this->styles[$handle];
    return $this->generate_styles_from_source( $source );
  }

  public function get_generated_styles() {
    return $this->generate_styles_from_source( $this->styles );
  }

  public function get_generated_late_styles() {
    return $this->generate_styles_from_source( $this->late_styles );
  }

  protected function generate_styles_from_source( $source ) {

    if ( ! $source ) {
      return '';
    }

    $styles = '/* ';

    $this->before_post_process();

    foreach ($source as $key => $style) {
      $styles .= ++$this->count ." start: $key*/";
      $styles .= $this->post_process( $style, $this->minify[$key] );
      $styles .= "/*end:$key|";
    }

    $styles .= '*/';
    $this->after_post_process();

    return $styles;
  }

  public function get_generated_styles_clean() {
    return $this->clean_css($this->get_generated_styles());
  }

  //
  // Custom error handler enabled before post proccessing and disabled after
  // Wraps PHP errors in CSS comments
  //

  public function error_handler( $errno, $errstr, $errfile, $errline) {

    if ( ! ( error_reporting() & $errno ) ) {
      return false;
    }

    $title = "Unknown Error ";
    switch ($errno) {
      case E_USER_WARNING:
        $title = "PHP Warning [$errno] ";
        break;

      case E_USER_NOTICE:
        $title = "PHP Notice [$errno] ";
        break;
    }

    echo '/*' . $title . str_replace('/*', '/\*', str_replace('*/', '*\/', $errstr ) ) . '*/';
    return true;
  }

  protected function before_post_process() {
    set_error_handler( array( $this, 'error_handler' ) );
  }

  protected function after_post_process() {
    restore_error_handler();
  }

  public function external_post_process( $css, $minify = false) {
    $this->before_post_process();
    $buffer = $this->post_process( $css, $minify );
    $this->after_post_process();
    return $buffer;
  }

  protected function post_process( $css, $minify = true ) {
    $output = preg_replace_callback('/%%post ([\w-:]+?)%%(.*?)%%\/post%%/', array( $this, 'post_process_replacer' ), $css );
    return ( $minify ) ? $this->clean_css( $output ) : $output;
  }

	public function post_process_replacer( $matches ) {
    return apply_filters('cornerstone_css_post_process_' . $matches[1], $matches[2]);
	}

  public function clean_css( $css ) {
    //
    // 1. Remove comments.
    // 2. Remove whitespace.
    // 3. Remove starting whitespace.
    //
    $css = preg_replace( '#/\*.*?\*/#s', '', $css );         // 1
	  $css = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $css ); // 2
	  return preg_replace( '/\s\s+(.*)/', '$1', $css );        // 3
  }

  public function get_generated_late_styles_clean() {
    return $this->clean_css( $this->get_generated_late_styles() );
  }

  public function output_late_style( $id, $style ) {
    if ( $style ) {
      $handle = esc_attr( $id );
      echo "<script type=\"text/late-css\" data-cs-late-style=\"$handle\">$style</script>";
      echo "<script>window.csGlobal.lateCSS(\"$handle\")</script>";
    }
  }

}
