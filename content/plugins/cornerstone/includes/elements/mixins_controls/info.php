<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_CONTROLS/INFO.PHP
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

function x_control_info( $settings = array() ) {

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
    'keys' => array(
      'type'      => $k_pre . 'info_type',
      'placement' => $k_pre . 'info_placement',
      'trigger'   => $k_pre . 'info_trigger',
      'title'     => $k_pre . 'info_title',
      'content'   => $k_pre . 'info_content',
    ),
    'type'       => 'info',
    'title'      => __( $t_pre . 'Info', '__x__' ),
    'group'      => $group,
    'options'    => $options,
    'conditions' => x_module_conditions( $condition ),
  );


  // Returned Value
  // --------------

  $control = array( $data );

  return $control;

}