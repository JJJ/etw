<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/GLOBAL-BLOCK.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Groups
//   03. Values
// =============================================================================

// Controls
// =============================================================================

function x_controls_global_block( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'alert';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();

  $group_setup = $group . ':setup';

  // Setup - Conditions
  // ------------------

  $conditions = x_module_conditions( $condition );


  // Returned Value
  // --------------

  $controls = array_merge(
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Setup', '__x__' ),
        'group'      => $group_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'global_block_id',
            'type'    => 'post-picker',
            'label'   => __( 'Global<br>Block', '__x__' ),
            'options' => array(
              'post_type'         => 'cs_global_block',
              'post_status'       => 'tco-data',
              'empty_placeholder' => 'No Global Blocks',
              'placeholder'       => 'Select Global Block'
            ),
          ),
        )
      )
    )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_global_block( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'alert';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Global Block', '__x__' );

  $control_groups = array(
    $group             => array( 'title' => $group_title ),
    $group . ':setup'  => array( 'title' => __( 'Setup', '__x__' ) )
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_global_block( $settings = array() ) {

  // Values
  // ------

  $values = array(
    'global_block_id' => x_module_value( '', 'all', true )
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
