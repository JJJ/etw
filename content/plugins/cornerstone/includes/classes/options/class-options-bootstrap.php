<?php

class Cornerstone_Options_Bootstrap extends Cornerstone_Plugin_Component {

  protected $defaults = array();
  protected $options = array();

  public function setup() {
    if ( apply_filters( 'cornerstone_options_use_native', true ) ) {
      $this->register_options( $this->plugin->config_group( 'options/defaults' ) );
    }
  }

  public function register_option( $name, $default_value, $options = array() ) {

    if ( isset( $this->defaults[ $name ] ) ) {
      trigger_error( "cornerstone_options_register_option | An option named '$name' has already been registered." );
      return;
    }

    $this->defaults[ $name ] = $default_value;
    $this->options[ $name ] = $options;

    // TODO: Hookup convenience filters

  }

  /**
   * Register multiple "option" entities... with the same configuration options...
   */
  public function register_options( $group, $options = array() ) {
    foreach ( $group as $name => $item ) {
      $this->register_option( $name, $item, $options );
    }
  }

  public function unregister_option( $name ) {

    unset( $this->defaults[ $name ] );

    // TODO: Unhook convenience filters

    unset( $this->options[ $name ] );

  }

  public function get_default( $name ) {

    if ( ! isset( $this->defaults[ $name ] ) ) {
      return $this->_not_registered();
    }

    return $this->defaults[ $name ];

  }

  public function get_defaults() {
    return $this->defaults;
  }

  public function get_value( $name ) {

    if ( ! isset( $this->defaults[ $name ] ) ) {
      return $this->_not_registered();
    }

    $store_as = ( isset( $this->options[ $name ]['store_as'] ) && is_string( $this->options[ $name ]['store_as'] ) ) ? $this->options[ $name ]['store_as'] : false;

    if ( 'theme_mod' === $store_as ) {
      return get_theme_mod( $name, $this->get_default( $name ) );
    }

    if ( 'option' === $store_as || ! is_string( $store_as ) ) {
      return get_option( $name, $this->get_default( $name ) );
    }

    $options = get_option( $store_as );

    if ( ! is_array( $options ) || ! isset( $options[ $name ] ) ) {
      return $this->get_default( $name );
    }

    return $options[ $name ];

  }

  public function update_value( $name, $value ) {

    if ( ! isset( $this->defaults[ $name ] ) ) {
      return $this->_not_registered();
    }

    $store_as = ( isset( $this->options[ $name ]['store_as'] ) && is_string( $this->options[ $name ]['store_as'] ) ) ? $this->options[ $name ]['store_as'] : false;

    if ( 'theme_mod' === $store_as ) {
      return set_theme_mod( $name, $value );
    }

    if ( 'option' === $store_as || ! is_string( $store_as ) ) {
      return update_option( $name, $value );
    }

    $options = get_option( $store_as );

    if ( ! is_array( $options ) ) {
      $options = array();
    }

    $options[ $name ] = $value;

    return update_option( $store_as, $options );

  }

  public function is_registered( $name ) {
    return isset( $this->defaults[ $name ] );
  }

  protected function _not_registered() {
    trigger_error( "cornerstone_options_get_default | The option '$name' was never registered." );
    return;
  }


}
