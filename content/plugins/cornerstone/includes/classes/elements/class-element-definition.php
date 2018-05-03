<?php

class Cornerstone_Element_Definition {

  protected $type;
  public $def = array();
  protected $style = null;
  protected $ready_for_builder = false;
  protected $sanitize_html_safe_keys;
  protected $escape_html_safe_keys;

  public function __construct( $type, $definition ) {
    $this->type = $type;
    $this->update( $definition );
  }

  public function update( $update ) {

    $defaults = array(

      'title'          => '',
      'values'         => array(),
      'options'        => array(),
      'style'          => null,

      'builder'        => null,
      'controls'       => array(),
      'control_groups' => array(),
      // 'conditions'     => array(),
      // 'supports'       => array(),
      'icon'           => null,
      'active'         => true,
      'render'         => null,

      '_upgrade_data' => array()
    );

    if ( isset( $update['options'] ) ) {
      $current_options = isset( $this->def['options'] ) ? $this->def['options'] : array();
      $update['options'] = array_merge( $current_options, $update['options'] );
    }

    $this->def = array_merge( $defaults, $this->def, array_intersect_key( $update, $defaults ) );

    if ( isset( $this->def['options']['shadow'] ) && $this->def['options']['shadow'] ) {
      $this->def['options']['private'] = true;
    }

  }

  public function get_defaults() {
    $defaults = array();

    foreach ($this->def['values'] as $key => $value) {
      $defaults[$key] = $value['default'];
    }

    return $defaults;
  }

  public function get_protected_keys() {
    $protected = array();

    foreach ($this->def['values'] as $key => $value) {
      if ( isset( $value['protected'] ) && $value['protected'] ) {
        $protected[] = $key;
      }
    }

    return $protected;
  }

  public function apply_defaults( $data ) {
    $defaults = $this->get_defaults();

    foreach ($defaults as $key => $value) {
      if ( ! isset( $data[$key] ) ) {
        $data[$key] = $value;
      }
    }

    return $data;

  }

  public function get_designations() {
    $designations = array();

    foreach ($this->def['values'] as $key => $value) {
      $designations[$key] = $value['designation'];
    }

    return $designations;
  }

  public function get_designated_keys( $type, $sub_group = null ) {

    $designations = $this->get_designations();
    $keys = array();

    foreach ($designations as $key => $value) {
      $parts = explode(':', $value);
      $designation_type = array_shift($parts);
      $designation_sub_group = implode(':', $parts);
      $sub_group_check = is_null( $sub_group ) ? true : $sub_group === $designation_sub_group;
      if ( $type === $designation_type && $sub_group_check ) {
        $keys[] = $key;
      }
    }
    return $keys;
  }

  public function get_style_template() {

    if ( is_null( $this->style ) ) {

      if ( ! isset( $this->def['style'] ) ) {
        return '';
      }

      $this->style = is_callable( $this->def['style'] ) ? call_user_func( $this->def['style'], $this->type ) : $this->def['style'];

    }

    return $this->style;
  }

  public function get_compiled_style() {
    $template = CS()->loadComponent( 'Coalescence' )->create_template( $this->get_style_template() );
    return $template->serialize();
  }

  // Redundant. Could be removed if all style template processing was done client side in the builder.
  public function preprocess_style( $data ) {

    $data = $this->apply_defaults($data);

    $unique_id = $data['_id'];

    if ( isset( $data['_p'] ) ) {
      $unique_id = $data['_p'] . '-' . $unique_id;
    }

    $data['_el'] = 'e' . $unique_id;

    $style_keys = $this->get_designations();

    $post_process_keys = array();
    foreach ($style_keys as $data_key => $style_key) {

      $pos = strpos($style_key, ':' );

      if ( false === $pos ) {
        continue;
      }

      $post_process_keys[$data_key] = substr($style_key, $pos + 1);

    }

    if ( empty( $post_process_keys ) ) {
      return $data;
    }

    // function preProcess( data ) {
    foreach ($data as $key => $value) {
      if ( isset($post_process_keys[$key])) {
        $data[$key] = '%%post ' . $post_process_keys[$key] . '%%' . $value .'%%/post%%';
      }
    }

    return $data;

  }

  public function get_title() {
    return $this->def['title'];
  }

  public function is_shadow() {
    return ( isset( $this->def['options']['shadow'] ) && $this->def['options']['shadow'] );
  }

  public function is_private() {
    return ( isset( $this->def['options']['private'] ) && $this->def['options']['private'] );
  }

  public function get_type() {
    return $this->type;
  }

  public function serialize() {

    $this->update_for_builder();

    $data = array(
      'id'             => $this->type,
      'title'          => $this->def['title'],
      'options'        => $this->def['options'],
      'values'         => $this->def['values'],
      'style'          => $this->get_compiled_style(),
      'controls'       => $this->def['controls'],
      'control_groups' => $this->def['control_groups'],
      'active'         => $this->def['active']
    );

    if ( is_string( $this->def['icon'] ) ) {
      $data['icon'] = $this->def['icon'];
    }

    return $data;
  }

  public function update_for_builder() {

    if ( $this->ready_for_builder || ! is_callable( $this->def['builder'] ) ) {
      return;
    }

    $this->update( call_user_func( $this->def['builder'], $this->type ) );
    $this->ready_for_builder = true;

  }

  public function condition_check() {
    return true;
  }

  public function sanitize( $data ) {

    $sanitized = array();
    if ( ! isset( $this->sanitize_html_safe_keys ) ) {
      $markup_keys = $this->get_designated_keys('markup', 'html' );
      $attr_keys = $this->get_designated_keys('attr', 'html' );
      $raw_keys = $this->get_designated_keys('markup', 'raw' );
      $this->sanitize_html_safe_keys = array_merge( $markup_keys, $attr_keys, $raw_keys );
    }

    $internal_keys = array( '_id', '_p', '_type', '_region', '_modules', '_transient' );

    foreach ( $data as $key => $value ) {

      // Pass through internal data
      if ( in_array($key, $internal_keys, true ) ) {
        $sanitized[ $key ] = $value;
        continue;
      }

      // Strip undesignated values
      if ( ! isset( $this->def['values'][$key] ) ) {
        continue;
      }

      $sanitized[ $key ] = CS()->common()->sanitize_value( $value, in_array($key, $this->sanitize_html_safe_keys, true ) );

    }

    return $sanitized;
  }

  public function escape( $data ) {

    $escaped = array();
    $designated_keys = array_keys( $this->def['values'] );

    if ( ! isset( $this->escape_html_safe_keys ) ) {

      $this->escape_html_safe_keys = array_merge(
        $this->get_designated_keys('markup', 'html' ),
        $this->get_designated_keys('attr', 'html' ),
        $this->get_designated_keys('markup', 'raw' )
      );

    }

    $html_safe_keys = $this->escape_html_safe_keys;

    if ( $this->is_shadow() && isset( $data['_transient'] ) && isset( $data['_transient']['parent'] ) ) {

      $parent_definition = CS()->loadComponent('Element_Manager')->get_element( $data['_transient']['parent']['_type'] );

      $html_safe_keys = array_merge( $html_safe_keys,
        $parent_definition->get_designated_keys('markup', 'html' ),
        $parent_definition->get_designated_keys('attr', 'html' ),
        $parent_definition->get_designated_keys('markup', 'raw' )
      );

      $designated_keys = array_merge( $designated_keys, array_keys( $parent_definition->get_designations() ) );

    }

    $internal_keys = array( '_id', '_p', '_type', '_region', '_modules', '_transient', 'p_mod_id' );

    foreach ( $data as $key => $value ) {

      // Pass through internal data
      if ( in_array($key, $internal_keys, true ) ) {
        $escaped[ $key ] = $value;
        continue;
      }

      // Strip undesignated values
      if ( ! in_array($key, $designated_keys, true ) ) {
        continue;
      }

      $escaped[ $key ] = CS()->common()->escape_value( $value, in_array($key, $html_safe_keys, true ) );

    }

    return $escaped;
  }

  public function save( $data, $content ) {

    $tag = "cs_element_" . str_replace('-', '_', $data['_type'] );
    $_id = $data['_id'];

    $shortcode = "[$tag _id=\"$_id\"]";

    if ( ! $content && isset( $this->def['options']['fallback_content'] ) ) {
      $content = $this->def['options']['fallback_content'];
    }

    if ( $content ) {

      $shortcode .= $content . "[/$tag]";
    }

    return $shortcode;
  }

  public function render( $data ) {
    return is_callable( $this->def['render'] ) ? call_user_func( $this->def['render'], $this->escape( $data ) ) : '';
  }

}
