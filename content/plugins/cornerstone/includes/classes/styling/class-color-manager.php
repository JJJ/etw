<?php

class Cornerstone_Color_Manager extends Cornerstone_Plugin_Component {

  public $queue = array();
  protected $color_items;
  protected $font_config;

  public function setup() {
    add_filter( 'cornerstone_option_model_whitelist', array( $this, 'whitelist_options' ) );
    add_filter( 'cornerstone_option_model_defaults_cornerstone_color_items', array( $this, 'default_color_items' ) );
    add_filter( 'cornerstone_option_model_load_cornerstone_color_items', array( $this, 'items_load_transform' ) );
    add_filter( 'cornerstone_option_model_save_cornerstone_color_items', array( $this, 'items_save_transform' ) );

    add_filter( 'cornerstone_css_post_process_color', array( $this, 'css_post_process_color') );

  }

  public function default_color_items( $data ) {
    return array(
      array(
        '_id'     => bin2hex('Brand Primary'),
        'title'   => 'Brand Primary',
        'value'   => 'transparent',
      ),
      array(
        '_id'     => bin2hex('Brand Secondary'),
        'title'   => 'Brand Secondary',
        'value'   => 'transparent',
      ),
      array(
        '_id'     => bin2hex('Link'),
        'title'   => 'Link',
        'value'   => 'transparent',
      ),
      array(
        '_id'     => bin2hex('Link Interaction'),
        'title'   => 'Link Interaction',
        'value'   => 'transparent',
      )
    );
  }

  public function whitelist_options( $keys ) {
    $keys[] = 'cornerstone_color_items';
    return $keys;
  }

  public function items_load_transform( $data ) {
    return ( is_null( $data ) ) ? array() : json_decode( wp_unslash( $data ), true );
  }

  public function items_save_transform( $data ) {
    return wp_slash( cs_json_encode( $data ) );
  }

  public function get_fallback_color() {
    return  array(
      'value'  => '#fff'
    );
  }

  public function get_color_items() {

    if ( ! $this->color_items ) {
      $this->color_items = $this->plugin->loadComponent('Model_Option')->lookup('cornerstone_color_items');
    }

    return $this->color_items;

  }

  public function locate_color( $_id ) {
    $this->get_color_items();
    foreach ($this->color_items as $color) {
      if ( isset( $color['_id'] ) && $_id === $color['_id'] ) {
        return $color;
      }
    }
    return array(
      'color' => 'transparent'
    );
  }

  public function css_post_process_color( $value ) {
    if ( -1 !== strpos( $value, 'global-color:' ) ) {
      $color = $this->locate_color( str_replace('global-color:', '', $value ) );
      if ( isset( $color['value'] ) ) {
        return $color['value'];
      }
    }
    return $value;
  }

}
