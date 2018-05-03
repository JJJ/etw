<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/_BOX-SHADOW.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Control
// =============================================================================

// Control
// =============================================================================

function x_control_box_shadow( $settings = array() ) {

  // Setup
  // -----

  $t_pre     = ( isset( $settings['t_pre'] )     ) ? $settings['t_pre'] . ' ' : '';
  $k_pre     = ( isset( $settings['k_pre'] )     ) ? $settings['k_pre'] . '_' : '';
  $group     = ( isset( $settings['group'] )     ) ? $settings['group']       : 'general';
  $options   = ( isset( $settings['options'] )   ) ? $settings['options']     : array();
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition']   : array();
  $alt_color = ( isset( $settings['alt_color'] ) ) ? true                     : false;


  // Data
  // ----

  $data = array(
    'type'       => 'box-shadow',
    'title'      => __( $t_pre . 'Box Shadow', '__x__' ),
    'group'      => $group,
    'options'    => $options,
    'conditions' => x_module_conditions( $condition ),
  );


  // Keys
  // ----

  $keys = array(
    'dimensions' => $k_pre . 'box_shadow_dimensions',
    'color'      => $k_pre . 'box_shadow_color',
  );

  if ( $alt_color == true ) {
    $keys['alt_color'] = $k_pre . 'box_shadow_color_alt';
  }

  $data['keys'] = $keys;


  // Returned Value
  // --------------

  $control = array( $data );

  return $control;

}