<?php

class Cornerstone_Integration_ACF {

  protected $do_shortcode = false;

  protected $no_expand_hooks = array( 'cs_element_update_build_shortcode_content' );

	public static function should_load() {
		return class_exists( 'acf' ) && function_exists( 'acf_shortcode' );
	}

	public function __construct() {

    // Register Shortcode
    add_shortcode( 'cs_acf', array( $this, 'shortcode_handler' ) );

    // Front End
    add_filter( 'cs_element_update_build_shortcode_content', array( $this, 'expand_fields' ) );
    add_filter( 'cs_decode_shortcode_attribute', array( $this, 'expand_fields' ) );
    add_filter( 'cs_content_late', array( $this, 'expand_fields' ) );

    // Preview
    add_filter( 'cs_render_element_template', array( $this, 'expand_fields' ) );
    add_filter( 'cs_render_element_isolate_html', array( $this, 'expand_fields' ) );
    add_filter( 'cs_render_element_zone_output', array( $this, 'expand_fields' ) );


	}

  public function expand_fields( $content ) {

    $current = current_filter();

    if ( ! in_array( $current, $this->no_expand_hooks, true ) ) {
      $this->do_shortcode = true;
    }

    $expanded = preg_replace_callback( '/{{[aA][cC][fF]:([A-Za-z0-9_-]*?)}}/', array( $this, 'expand_callback' ), $content );
    $this->do_shortcode = false;

    return $expanded;

  }

  public function expand_callback( $matches ) {

    $result = '[cs_acf field="' . $matches[1] . '"]';

    if ( $this->do_shortcode ) {
      $result = do_shortcode( $result );
    }

    return $result;

  }

  public function shortcode_handler( $atts ) {
    return acf_shortcode( $atts );
  }

}
