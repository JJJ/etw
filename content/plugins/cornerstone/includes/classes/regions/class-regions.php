<?php

class Cornerstone_Regions extends Cornerstone_Plugin_Component {

  public $header_styles = '';
  public $dependencies = array( 'Styling' );
  public $modules = array();
  public $modules_registered = false;
  public $counters = array();

  public function setup() {
    $this->register_post_types();
  }

  public function get_content_elements( $id ) {
    $this->plugin->loadComponent( 'Element_Manager' );
    $elements = cs_get_serialized_post_meta( $id, '_cornerstone_data', true );

    if ( ! $elements ) {
      return null;
    }

    return $this->populate_modules( $id, $elements, 'content' );
  }

  public function reset_region_styles( $mode, $entity ) {
    delete_post_meta( $entity->get_id(), '_cs_generated_styles');
  }

  public function load_element_style( $type ) {
    return $this->plugin->loadComponent('Element_Manager')->get_element( $type )->get_style_template();
  }

  public function get_fallback_header_data() {
    return apply_filters( 'cornerstone_fallback_header_data', array(
      'modules' => array(),
      'settings' => array(),
    ) );
  }

  public function get_fallback_footer_data() {
    return apply_filters( 'cornerstone_fallback_footer_data', array(
      'modules' => array(),
      'settings' => array(),
    ) );
  }

  public function get_active_header_data( $fallback = false ) {

    $assignment = has_filter('cornerstone_header_preview_data') ?
                  apply_filters('cornerstone_header_preview_data', array() ) :
                  $this->plugin->loadComponent('Header_Assignments')->locate_assignment( $fallback );

    if ( is_null( $assignment ) && ! $fallback ) {
      return null;
    }

    try {
      $header = new Cornerstone_Header( $assignment );
    } catch( Exception $e ) {
      $header = new Cornerstone_Header( $this->get_fallback_header_data() );
    }

    $this->active_header = $header;

    return $this->prepare_region_data( $header );
  }

  public function get_last_active_header() {
    return isset( $this->active_header ) ? $this->active_header : null;
  }

  public function get_last_active_footer() {
    return isset( $this->active_footer ) ? $this->active_footer : null;
  }

  public function prepare_region_data( $entity ) {

    $modules = array();
    $regions = $entity->get_regions();

    // Manually reset the counter
    $id = $entity->get_id();
    $this->counters[ 'p' . $id ] = 0;

    foreach ($regions as $name => $region ) {

      $new = array(
        '_type' => 'region',
        '_region' => $name,
        '_modules' => $this->populate_modules( $id, $region, $name, true, false )
      );

      $modules[] = $new;
    }

    return array(
      'id'       => $entity->get_id(),
      'modules'  => $this->flatten_regions( $modules ),
      'settings' => $entity->get_settings(),
    );
  }

  public function get_active_footer_data( $fallback = false ) {

    $assignment = has_filter('cornerstone_footer_preview_data') ?
                  apply_filters('cornerstone_footer_preview_data', array() ) :
                  $this->plugin->loadComponent('Footer_Assignments')->locate_assignment( $fallback);

    if ( is_null( $assignment ) && ! $fallback ) {
      return null;
    }

    try {
      $footer = new Cornerstone_Footer( $assignment );
    } catch( Exception $e ) {
      $footer = new Cornerstone_Footer( $this->get_fallback_footer_data() );
    }

    $this->active_footer = $footer;

    return $this->prepare_region_data( $footer );

  }

  public function flatten_regions( $regions ) {
    $modules = array();

    foreach ( $regions as $region ) {
      foreach ( $region['_modules'] as $module ) {
        $modules[] = $module;
      }
    }

    return $modules;
  }

  public function flatten_elements( $elements ) {
    $this->flatten_elements_buffer = array();
    foreach ($elements as $element ) {

      $this->flatten_element($element);
    }

    $buffer = $this->flatten_elements_buffer;
    $this->flatten_elements_buffer = array();
    return $buffer;

  }

  public function flatten_element( $element ) {

    if ( isset( $element['_modules']) ) {
      foreach ($element['_modules'] as $child ) {
        $this->flatten_element($child);
      }
    }

    if ( isset($element['_id']) ) {
      unset($element['_modules']);
      $this->flatten_elements_buffer['el' . $element['_id']] = $element;
    }

  }

  public function sanitize_regions( $regions ) {

    $element_manager = $this->plugin->loadComponent('Element_Manager');
    $sanitized = array();

    foreach ($regions as $region_name => $bars) {
      if ( is_array( $bars ) ) {
        $sanitized[$region_name] = $element_manager->sanitize_elements( $bars );
      }
    }

    return $sanitized;
  }

  public function populate_modules( $id, $modules, $region, $set_page_context = false, $_reset_counter = true ) {

    if ( $_reset_counter || ! isset( $this->counters[ 'p' . $id ] ) ) {
      $this->counters[ 'p' . $id ] = 0;
    }

    foreach ( $modules as $index => $module ) {

      $modules[$index]['_id'] = ++$this->counters[ 'p' . $id ];
      if ( $set_page_context ) {
        $modules[$index]['_p'] = $id;
      }
      $modules[$index]['_region'] = $region;

      if ( isset( $module['_modules'] ) ) {
        $modules[$index]['_modules'] = $this->populate_modules( $id, $module['_modules'], $region, $set_page_context, false );
      }

    }

    return $modules;

  }

  public function register_post_types() {

    register_post_type( 'cs_header', array(
      'public'          => false,
      'capability_type' => 'page',
      'supports'        => false,
      'labels'          => array(
        'name'          => __( 'Pro Headers', '__x__' ),
        'singular_name' => __( 'Pro Header', '__x__' ),
      )
    ) );

    register_post_type( 'cs_footer', array(
      'public'          => false,
      'capability_type' => 'page',
      'supports'        => false,
      'labels'          => array(
        'name'          => __( 'Pro Footers', '__x__' ),
        'singular_name' => __( 'Pro Footer', '__x__' ),
      )
    ) );

  }

}
