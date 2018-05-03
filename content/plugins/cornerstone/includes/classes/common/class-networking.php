<?php

class Cornerstone_Networking extends Cornerstone_Plugin_Component {

  protected $timeout = null;

  public function set_curl_timeout_begin( $timeout ) {

    if ( ! is_null( $this->timeout ) || ! is_int( $timeout) ) {
      return;
    }

    $this->timeout = $timeout;

    add_filter('http_request_args', array( $this, 'curl_timeout_request_args' ), 1000 );
    add_action('http_api_curl', array( $this, 'curl_timeout_api_curl' ), 1000 );

  }

  public function curl_timeout_request_args( $args ) {
    if ( is_int( $this->timeout ) ) {
      $args['timeout'] = $this->timeout;
    }
    return $args;
  }

  public function curl_timeout_api_curl( $handle ) {

    if ( is_int( $this->timeout ) ) {
      curl_setopt( $handle, CURLOPT_CONNECTTIMEOUT, $this->timeout );
    	curl_setopt( $handle, CURLOPT_TIMEOUT, $this->timeout );
    }

  }

  public function set_curl_timeout_end() {
    remove_filter('http_request_args', 'curl_timeout_request_args', 1000 );
    remove_action('http_api_curl', array( $this, 'curl_timeout_api_curl' ), 1000 );
    $this->timeout = null;
  }

}
