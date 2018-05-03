<?php

// 1. Simpler alternative to WP_Error with Exception throwing
// 2. Use with cs_error and is_cs_error
// 3. PHP 5.2 is the worst (No custom Exception classes).

class Cornerstone_Error {

  private $data = array();
  private $message = 'Undefined Cornerstone Error';

  public function __construct( $data, $throw = false ) {
    if ( is_string( $data ) ) {
      $this->message = $data;
    } elseif ( isset( $data['message'] ) ) {
      $this->message = $data['message'];
    }
    if ( ! $this->message ) {
      $this->message;
    }
    if ( $throw ) {
      throw new Exception( $this->message );
    }
  }

  public function get_message() {
    return $this->message;
  }

  public function get_data() {
    return $this->data;
  }

}
