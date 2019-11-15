<?php

class Cornerstone_Element_Registry extends Cornerstone_Plugin_Component {
  protected $settings = array();
  protected $values = array();
  protected $initialized = false;
  protected $control_partials = array();

  public function setup() {
    $this->init(); // move to builder only
    require_once( $this->path( 'includes/elements/values.php' ) );
  }

  public function init() {
    $this->initialized = true;
    require_once( $this->path( 'includes/elements/registry-setup.php' ) );
    do_action( 'cs_registry_setup' );
  }

  public function remember( $key, $value ) {
    $this->maybe_warn();

    if ( isset( $this->settings[ $key ] ) ) {
      return;
    }

    $this->settings[ $key ] = $value;
  }

  public function recall( $key, $fallback = array() ) {
    $this->maybe_warn();
    return isset( $this->settings[ $key ] ) ? $this->settings[ $key ] : $fallback;
  }

  public function maybe_warn() {
    if ( ! $this->initialized ) {
      return trigger_error( 'cs_remember/cs_recall used outside of builder context.', E_USER_WARNING );
    }
  }

  public function define_values( $key, $values ) {

    if ( isset( $this->values[ $key ] ) ) {
      return trigger_error( "cs_define_values | $key already defined.", E_USER_WARNING );
    }

    if ( ! is_array( $values )) {
      return trigger_error( 'cs_define_values | values must be an array', E_USER_WARNING );
    }

    $this->values[ $key ] = $values;

  }

  /**
   * Take a set of values and optionally apply a key prefix
   * If you pass a string for the first parameter it will look up
   * values in the registry
   * @param string/array $values
   * @param string $key_prefix
   * @return array
   */
  public function values( $values, $key_prefix = '' ) {

    if ( is_string( $values ) ) {
      $values = isset( $this->values[ $values ] ) ? $this->values[ $values ] : array();
    }

    if ( $key_prefix ) {
      $prefixed = array();
      foreach ( $values as $key => $value ) {
        $prefixed[ $key_prefix . '_' . $key ] = $value;
      }
      return $prefixed;
    }

    return $values;

  }

  public function compose_values( $all_values ) {

    $composed = array();

    foreach( $all_values as $_values ) {
      $values = is_string( $_values ) ? $this->values( $_values ) : $_values;

      foreach ( $values as $key => $value ) {
        if ( ! $value ) {
          unset( $composed[ $key ] );
        } else {
          $composed[ $key ] = $value;
        }
      }
    }

    return $composed;

  }

  public function compose_partials( $control_sets ) {

    $result = array(
      'controls' => array(),
      'controls_std_content' => array(),
      'controls_std_design_setup' => array(),
      'controls_std_design_colors' => array(),
      'controls_std_customize' => array(),
      'control_nav' => array()
    );

    $groups = array();

    foreach ($control_sets as $control_set) {
      foreach( $result as $key => $value ) {
        if ( isset( $control_set[ $key ] ) ) {
          $result[ $key ] = array_merge( $result[ $key ], $control_set[ $key ] );
        }
      }
    }

    $result['controls_std_content'] = array_map( array( $this, 'normalize_controls_content' ), $result['controls_std_content'] );
    $result['controls_std_design_setup'] = array_map( array( $this, 'normalize_controls_design' ), $result['controls_std_design_setup'] );
    $result['controls_std_design_colors'] = array_map( array( $this, 'normalize_controls_design' ), $result['controls_std_design_colors'] );
    $result['controls_std_customize'] = array_map( array( $this, 'normalize_controls_customize' ), $result['controls_std_customize'] );

    return $result;

  }

  public function normalize_controls_content( $control ) {
    $control['group'] = 'std:content';
    return $control;
  }


  public function normalize_controls_customize( $control ) {

    $control['group'] = 'std:customize';
    $control['label'] = __( 'Customize', 'cornerstone' );

    if ( isset( $control['condition'] ) ) {
      $control['conditions'] = array( $control['condition'] );
      unset($control['condition']);
    }

    if ( ! isset( $control['conditions'] ) ) {
      $control['conditions'] = array();
    }

    $has_condition = false;

    foreach ($control['conditions'] as $condition ) {
      if ( isset( $condition['user_can:{context}.customize_controls'] ) && $condition['user_can:{context}.customize_controls'] ) {
        $has_condition = true;
      }
    }

    if ( ! $has_condition ) {
      array_push( $control['conditions'], array( 'user_can:{context}.customize_controls' => true ));
    }


    return $control;

  }

  public function normalize_controls_design( $control ) {

    $control['group'] = 'std:design';

    if ( isset( $control['condition'] ) ) {
      $control['conditions'] = array( $control['condition'] );
      unset($control['condition']);
    }

    if ( ! isset( $control['conditions'] ) ) {
      $control['conditions'] = array();
    }

    $has_condition = false;

    foreach ($control['conditions'] as $condition ) {
      if ( isset( $condition['user_can:{context}.design_controls'] ) && $condition['user_can:{context}.design_controls'] ) {
        $has_condition = true;
      }
    }

    if ( ! $has_condition ) {
      array_push( $control['conditions'], array( 'user_can:{context}.design_controls' => true ));
    }


    return $control;

  }

  public function register_control_partial( $name, $function ) {
    if ( isset( $this->control_partials[ $name ] ) ) {
      return;
    }

    if ( ! is_callable( $function ) ) {
      return trigger_error( 'cs_register_control_partial was not passed a function as the second argument.', E_USER_WARNING );
    }

    $this->control_partials[ $name ] = $function;
  }

  public function apply_control_partial( $name, $settings = array() ) {
    if ( ! isset( $this->control_partials[ $name ] ) ) {
      trigger_error( "attempting to apply non-existent control partial: $name", E_USER_WARNING );
      return array();
    }

    if ( isset( $settings['condition'] ) && ! isset( $settings['conditions'] ) ) {
      $settings['conditions'] = array( $settings['condition'] );
    }

    return call_user_func( $this->control_partials[ $name ], $settings );
  }

}
