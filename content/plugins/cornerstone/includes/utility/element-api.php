<?php

/**
 * Element Registration
 */

function cs_register_element( $type, $options ) {
  CS()->component( 'Element_Manager' )->register_element( $type, $options );
}

function cs_unregister_element( $name ) {
	CS()->component( 'Element_Manager' )->unregister_element( $name );
}

function cs_get_element( $name ) {
  return CS()->component('Element_Manager')->get_element( $name );
}

/**
 * Controls
 */

function cs_control( $type, $key_prefix = '', $control = array() ) {
  return CS()->component( 'Element_Controls' )->control( $type, $key_prefix, $control );
}

function cs_amend_control( $control, $update ) {
  return CS()->component( 'Element_Controls' )->merge( $control, $update );
}

/**
 * Settings
 */

function cs_remember( $key, $value ) {
  return CS()->component( 'Element_Registry' )->remember( $key, $value );
}

function cs_recall( $key ) {
  return CS()->component( 'Element_Registry' )->recall( $key );
}

/**
 * Values
 */

function cs_value( $default = null, $designation = 'all', $protected = false ) {

  $value = array( 'default' => $default, 'designation' => $designation );

  if ( $protected ) {
    $value['protected'] = true;
  }

  return $value;

}

function cs_values( $values, $key_prefix = '' ) {
  return CS()->component( 'Element_Registry' )->values( $values, $key_prefix );
}

function cs_define_values( $key, $values ) {
  return CS()->component( 'Element_Registry' )->define_values( $key, $values );
}

function cs_compose_values() {
  return CS()->component( 'Element_Registry' )->compose_values( func_get_args() );
}

// ARIA
// =============================================================================

function cs_make_aria_atts( $key_prefix = 'anchor', $aria = array(), $id, $mod_id ) {

  $atts = array();
  $key_prefix  = ( ! empty( $key_prefix ) ) ? $key_prefix . '_' : '';

  if ( isset( $aria['controls'] ) ) {

    $the_id   = ( ! empty( $id ) ) ? $id : $mod_id;
    $the_type = '-' . $aria['controls'];

    $atts[$key_prefix . 'aria_controls'] = $the_id . $the_type;

  }

  if ( isset( $aria['expanded'] ) ) {
    $atts[$key_prefix . 'aria_expanded'] = $aria['expanded'];
  }

  if ( isset( $aria['selected'] ) ) {
    $atts[$key_prefix . 'aria_selected'] = $aria['selected'];
  }

  if ( isset( $aria['haspopup'] ) ) {
    $atts[$key_prefix . 'aria_haspopup'] = $aria['haspopup'];
  }

  if ( isset( $aria['label'] ) ) {
    $atts[$key_prefix . 'aria_label'] = $aria['label'];
  }

  if ( isset( $aria['labelledby'] ) ) {
    $atts[$key_prefix . 'aria_labelledby'] = $aria['labelledby'];
  }

  if ( isset( $aria['hidden'] ) ) {
    $atts[$key_prefix . 'aria_hidden'] = $aria['hidden'];
  }

  if ( isset( $aria['orientation'] ) ) {
    $atts[$key_prefix . 'aria_orientation'] = $aria['orientation'];
  }

  return $atts;

}

// Element CSS Partial
// =============================================================================

function cs_get_partial_style( $name, $settings = array() ) {

  $user_partial = apply_filters( 'cs_get_partial_style', null, $name, $settings );
  $user_partial = apply_filters( "cs_get_partial_style_$name", $user_partial, $settings );

  if ( $user_partial ) {
    return $user_partial;
  }

  return x_get_view( 'styles/partials', $name, 'css', $settings, false );
}

function cs_get_partial_view( $name, $data = array() ) {

  $user_partial = apply_filters( 'cs_get_partial_view', null, $name, $data );
  $user_partial = apply_filters( "cs_get_partial_view_$name", $user_partial, $data );

  if ( $user_partial ) {
    return $user_partial;
  }

  return x_get_view( 'partials', $name, '', $data, false );

}

function cs_defer_partial( $name, $data = array(), $priority = 100 ) {

  // This hook does not work the same as cs_get_partial_view
  // Returning true will abort trying to load a native view
  // but you will still need to supply your own. The best
  // way would be using the x_before_site_end action hook.
  $user_partial = apply_filters( 'cs_get_deffered_partial_view', false, $name, $data );

  if ( $user_partial ) {
    return;
  }

  x_set_view( 'x_before_site_end', 'partials', $name, '', $data, $priority );

}


function cs_compose_controls() {
  return CS()->component( 'Element_Registry' )->compose_partials( func_get_args() );
}

function cs_register_control_partial( $name, $function ) {
  return CS()->component( 'Element_Registry' )->register_control_partial( $name, $function );
}


function cs_partial_controls( $name, $settings = array() ) {
  return CS()->component( 'Element_Registry' )->apply_control_partial( $name, $settings );
}




// Partial Data
// =============================================================================

function cs_without( $data, $keys ) {
  return array_diff_key( $data, array_flip( $keys ) );
}

function cs_extract( $data, $find = array() ) {

  // Notes
  // -----
  // 01. We will pass on some common top level attributes. This is filterable
  //     with cs_get_partial_data_pass_on
  // 02. $find - (a) Returns $data with a beginning that matches
  //     the $key and (b) that $data is cleaned to reflect the $value as
  //     the new beginning so it can be passed on to the partial template.

  $pass_on = apply_filters( 'cs_get_partial_data_pass_on', array( '_region', '_id', '_type', '_transient', '_modules', 'mod_id', 'id', 'class', 'toggle_hash' ) );

  $extracted = array();

  foreach ( $pass_on as $key ) {
    if ( isset( $data[$key]) ) {
      $extracted[$key] = $data[$key]; // 01
    }
  }

  foreach ( $find as $begins_with => $update_to ) {

    foreach ( $data as $key => $value ) {
      if ( 0 === strpos( $key, $begins_with )  ) { // 02

        if ( ! empty( $update_to ) ) {
          $key = $update_to . substr( $key, strlen( $begins_with ) );
        }

        $extracted[$key] = $value;

      }
    }
  }

  return $extracted;

}


function cs_attr_class() {

  $args = func_get_args();

  $classes = array();

  foreach( $args as $arg ) {
    if (is_array($arg)) {
      $classes = array_merge( $classes, $arg );
    } else {
      $classes[] = $arg;
    }
  }

  if ( ! empty( $classes ) ) {
    return implode( ' ', array_filter( $classes ) );
  }

  return '';

}

// These functions are from an older version of the API. They are used in partials, but will be converted to direct cs_control calls.

function x_control_margin( $control = array() ) {
  return array( cs_control( 'margin', isset( $control['k_pre'] ) ? $control['k_pre'] : '', $control ) );
}

function x_control_padding( $control = array() ) {
  return array( cs_control( 'padding', isset( $control['k_pre'] ) ? $control['k_pre'] : '', $control ) );
}

function x_control_border_radius( $control = array() ) {
  return array( cs_control( 'border-radius', isset( $control['k_pre'] ) ? $control['k_pre'] : '', $control ) );
}

function x_control_border( $control = array() ) {
  return array( cs_control( 'border', isset( $control['k_pre'] ) ? $control['k_pre'] : '', $control ) );
}

function x_control_box_shadow( $control = array() ) {
  return array( cs_control( 'box-shadow', isset( $control['k_pre'] ) ? $control['k_pre'] : '', $control ) );
}

function x_control_flexbox( $control = array() ) {
  return array( cs_control( 'flexbox', isset( $control['k_pre'] ) ? $control['k_pre'] : '', $control ) );
}

function x_control_text_shadow( $control = array() ) {
  return array( cs_control( 'text-shadow', isset( $control['k_pre'] ) ? $control['k_pre'] : '', $control ) );
}

function x_control_text_format( $control = array() ) {
  return array( cs_control( 'text-format', isset( $control['k_pre'] ) ? $control['k_pre'] : '', $control ) );
}
