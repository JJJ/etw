<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/_FLEX-LAYOUT-ATTR.PHP
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

function x_control_flex_layout_attr( $settings = array() ) {

  // Setup
  // -----

  $t_pre     = ( isset( $settings['t_pre'] )     ) ? $settings['t_pre'] . ' ' : '';
  $k_pre     = ( isset( $settings['k_pre'] )     ) ? $settings['k_pre'] . '_' : '';
  $group     = ( isset( $settings['group'] )     ) ? $settings['group']       : 'general';
  $options   = ( isset( $settings['options'] )   ) ? $settings['options']     : array();
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition']   : array();


  // Data
  // ----

  $data = array(
    'key'        => $k_pre . 'flex_layout_attr',
    'type'       => 'flex-layout-attr',
    'title'      => __( $t_pre . 'Flex Layout', '__x__' ),
    'group'      => $group,
    'options'    => $options,
    'conditions' => x_module_conditions( $condition ),
  );


  // Returned Value
  // --------------

  $control = array( $data );

  return $control;

}
