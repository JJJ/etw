<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/_MARGIN.PHP
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

function x_control_margin( $settings = array() ) {

  // Setup
  // -----

  $t_pre     = ( isset( $settings['t_pre'] )     ) ? $settings['t_pre'] . ' ' : '';
  $k_pre     = ( isset( $settings['k_pre'] )     ) ? $settings['k_pre'] . '_' : '';
  $group     = ( isset( $settings['group'] )     ) ? $settings['group']       : 'general';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition']   : array();
  $options   = ( isset( $settings['options'] )   ) ? $settings['options']     : array();


  // Data
  // ----

  $data = array(
    'key'        => $k_pre . 'margin',
    'type'       => 'margin',
    'title'      => __( $t_pre . 'Margin', '__x__' ),
    'group'      => $group,
    'conditions' => x_module_conditions( $condition ),
    'options'    => $options,
  );


  // Returned Value
  // --------------

  $control = array( $data );

  return $control;

}