<?php

class Cornerstone_Options_Manager extends Cornerstone_Plugin_Component {

  public $dependencies = array( 'Options_Bootstrap' );
  protected $counters = array();
  protected $sections = array();
  protected $controls = array();
  protected $registered = false;
  protected $custom_css_key = '';
  protected $custom_css_selector = '';
  protected $custom_js_key = '';

  public function setup() {

    if ( apply_filters( 'cornerstone_options_use_native', true ) ) {
      add_action( 'cornerstone_options_register', array( $this, 'register_native_options' ) );
      $this->enable_custom_css( 'cs_v1_custom_css', '#cornerstone-custom-css' );
      $this->enable_custom_js( 'cs_v1_custom_js' );
    }

  }

  public function config() {

    return array(
      'i18n' => $this->plugin->i18n_group( 'options' ),
      'customCSSKey' => $this->get_custom_css_key(),
      'customCSSSelector' => $this->get_custom_css_selector(),
      'customJSKey' => $this->get_custom_js_key(),
      'title' => apply_filters( 'cornerstone_options_theme_title', false ) ? 'theme' : 'styling',
    );

  }

  public function register_native_options() {
    $this->register_sections( $this->plugin->config_group( 'options/sections' ) );
  }

  public function get_custom_css_key() {
    return $this->custom_css_key;
  }

  public function get_custom_css_selector() {
    return $this->custom_css_selector;
  }

  public function get_custom_js_key() {
    return $this->custom_js_key;
  }

  public function register() {

    if ( $this->registered ) {
      return;
    }

    $this->sections['root'] = array(
      'title' => '',
      'description' => '',
      'order' => 0
    );

    do_action( 'cornerstone_options_register' );

    $this->registered = true;

    $sections = array();

    foreach ( $this->sections as $key => $section ) {
      $sections[] = array_merge( array( 'id' => $key ), $this->transform_section( $key, $section ) );
    }

    $this->sections = $sections;

    $controls = array();

    foreach ( $this->controls as $key => $control ) {
      $controls[] = array_merge( array( 'id' => $key ), $this->transform_control( $key, $control ) );
    }

    $this->controls = $controls;

  }

  public function enable_custom_css( $option_name, $selector = '') {
    $this->custom_css_key = $option_name;
    $this->custom_css_selector = $selector;
  }

  public function enable_custom_js( $option_name ) {
    $this->custom_js_key = $option_name;
  }

  public function register_sections( $sections = array() ) {

    if ( $this->registered ) {
      trigger_error( "Cornerstone_Options_Manger | Can not register sections after 'cornerstone_options_register' action." );
      return;
    }

    foreach ( $sections as $key => $value ) {
      $this->register_section( $key, $value );
    }

  }

  public function get_sections() {

    if ( ! $this->registered ) {
      trigger_error( "Cornerstone_Options_Manger | Can not call get_sections before 'cornerstone_options_register' action." );
      return;
    }

    return $this->sections;

  }

  public function get_controls() {

    if ( ! $this->registered ) {
      trigger_error( "Cornerstone_Options_Manger | Can not call get_controls before 'cornerstone_options_register' action." );
      return;
    }

    return $this->controls;

  }

  public function get_values() {

    $bootstrap = $this->plugin->component( 'Options_Bootstrap' );

    $values = array();
    $defaults = $bootstrap->get_defaults();

    foreach ($defaults as $key => $default) {
      $values[] = array(
        'id'      => $key,
        'value'   => $bootstrap->get_value( $key ),
        'default' => $default
      );
    }
    return $values;
  }

  public function transform_section( $name, $section ) {

    $children = array();
    $controls = array();

    foreach ( $this->sections as $section_name => $compare ) {
      if ( isset( $compare['parent'] ) && $name === $compare['parent'] ) {
        $children[] = $section_name;
      }
    }

    foreach ( $this->controls as $control_name => $compare ) {
      if ( isset( $compare['section'] ) && $name === $compare['section'] ) {
        $controls[] = $control_name;
      }
    }

    $section['children'] = $children;
    $section['controls'] = $controls;
    $section['panel'] = ( ( isset( $section['parent'] ) && 'root' === $section['parent'] ) || ! empty( $children ) );

    $conditions = $this->normalize_conditions( $section );
    unset( $section['condition'] );

    if ( ! empty( $conditions ) ) {
      $section['conditions'] = $conditions;
    }

    return $section;

  }

  public function transform_control( $name, $control ) {

    $conditions = $this->normalize_conditions( $control );
    unset( $control['condition'] );

    if ( isset( $control['options'] ) && isset( $control['options']['choices'] ) && is_array($control['options']['choices']) ) {
      $keys = array_keys($control['options']['choices']);
      if ( is_string($keys[0])) {
        $choices = array();
        foreach ($control['options']['choices'] as $value => $label) {
          $choices[] = array( 'value' => $value, 'label' => $label );
        }
        $control['options']['choices'] = $choices;
      }
    }

    if ( ! empty( $conditions ) ) {
      $control['conditions'] = $conditions;
    }

    return $control;
  }

  public function normalize_conditions( $entity ) {

    if ( isset( $entity['condition'] ) && ! isset( $entity['conditions'] ) ) {
      $entity['conditions'] = array( $entity['condition'] );
    }

    $ops = array( '=', '!=', '>', '>=', '<', '<=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN' );

    $conditions = array();

    if ( isset( $entity['conditions'] ) && is_array( $entity['conditions'] ) ) {
      foreach ( $entity['conditions'] as $condition ) {

        if ( isset( $condition['option'] ) && isset( $condition['value'] ) ) {

          $conditions[] = array(
            'option' => $condition['option'],
            'value'  => $condition['value'],
            'op'     => ( isset( $condition['op'] ) && in_array( $condition['op'], $ops, true ) ) ? $condition['op'] : '='
          );

        } else {
          // Add shorthand
          $keys = array_keys( $condition );
          $conditions[] = array(
            'option' => $keys[0],
            'value'  => $condition[ $keys[0] ],
            'op' => '='
          );
        }

      }
    }

    return $conditions;

  }

  public function register_section( $name, $value, $parent = false ) {

    if ( $this->registered ) {
      trigger_error( "Cornerstone_Options_Manger | Can not register section after 'cornerstone_options_register' action." );
      return;
    }

    if ( isset( $value['enabled'] ) && ( ! $value['enabled'] || ( is_callable( $value['enabled'] ) && call_user_func( $value['enabled'] ) ) ) ) {
      return;
    }

    if ( isset( $value['capability'] ) && ! current_user_can( $value['capability'] ) ) {
      return;
    }

    $value['parent'] = $counter_bucket = 'root';

    if ( $parent ) {
      $value['parent'] = $counter_bucket = $parent;
      $name = $parent . '-' . $name;
    }

    $value['order'] = $this->next_order( $counter_bucket, $name, ( isset( $value['order'] ) ) ? $value['order'] : false );

    $child_sections = ( isset( $value['sections'] ) && is_array( $value['sections'] ) ) ? $value['sections'] : array();
    $controls       = ( isset( $value['controls'] ) && is_array( $value['controls'] ) ) ? $value['controls'] : array();

    // Clean meta API
    unset( $value['sections'] );
    unset( $value['controls'] );
    unset( $value['enabled'] );
    unset( $value['capability'] );

    $this->sections[ $name ] = $value;

    foreach ( $child_sections as $sub_name => $sub_value ) {
      $this->register_section( $sub_name, $sub_value, $name );
    }

    foreach ( $controls as $option_name => $control ) {
      $control['section'] = $name;
      $this->register_control( $option_name, $control );
    }

  }

  public function register_control( $option_name, $control ) {

    if ( $this->registered ) {
      trigger_error( "Cornerstone_Options_Manger | Can not register control after 'cornerstone_options_register' action." );
      return;
    }

    if ( ! isset( $control['type'] ) ) {
      trigger_error( "Cornerstone_Options_Manger | Can not register control '$option_name' without a valid type." );
      return;
    }

    if ( ! isset( $control['section'] ) || ! isset( $this->sections[ $control['section'] ] ) ) {
      trigger_error( "Cornerstone_Options_Manger | Can not register control for '$option_name' without a valid section." );
      return;
    }

    $this->controls[ $option_name ] = $control;

  }

  public function unregister_section( $name ) {

    if ( $this->registered ) {
      trigger_error( "Cornerstone_Options_Manger | Can not unregister section after 'cornerstone_options_register' action." );
      return;
    }

    // Unregister child sections
    foreach ( $this->sections as $child => $section ) {
      if ( isset( $section['parent'] ) && $name === $section['parent'] ) {
        $this->unregister_section( $child );
      }
    }

    // Unregister dependant controls
    foreach ( $this->controls as $option_name => $control ) {
      if ( $name === $control['section'] ) {
        $this->unregister_control( $option_name );
      }
    }

    // Remove section
    unset( $this->sections[ $name ] );

  }

  public function unregister_control( $option_name ) {
    unset( $this->controls[ $option_name ] );
  }

  protected function next_order( $bucket, $name, $explicit ) {

    $explicit = is_int( $explicit ) ? $explicit : false;
    if ( 0 === $explicit % 10 ) {
      $explicit++;
    }

    if ( ! isset( $this->counters[ $bucket ] ) ) {
      $this->counters[ $bucket ] = array();
      $this->counters[ $bucket ][0] = 'reserved';
      $next = ( false !== $explicit ) ? $explicit : 10;
    } else {
      if ( false === $explicit ) {
        end( $this->counters[ $bucket ] );
        $next = (int) ceil( key( $this->counters[ $bucket ] ) / 10 ) * 10 + 10;
      } else {
        $next = $explicit;
      }
    }

    $inc = ( false === $explicit ) ? 10 : 1;
    while ( isset( $this->counters[ $bucket ][ $next ] ) ) {
      $next += $inc;
    }

    $this->counters[ $bucket ][ $next ] = $name;
    return $next;

  }

}
