<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/GAP.PHP
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

function x_controls_gap( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'gap';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();

  $group_setup  = $group . ':setup';
  $group_design = $group . ':design';


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
            'key'     => 'gap_direction',
            'type'    => 'choose',
            'label'   => __( 'Direction', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'horizontal', 'label' => __( 'Horizontal', '__x__' ) ),
                array( 'value' => 'vertical',   'label' => __( 'Vertical', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'     => 'gap_base_font_size',
            'type'    => 'unit-slider',
            'label'   => __( 'Base Font Size', '__x__' ),
            'options' => array(
              'available_units' => array( 'px', 'em', 'rem' ),
              'valid_keywords'  => array( 'calc' ),
              'fallback_value'  => '1em',
              'ranges'          => array(
                'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
                'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
                'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
              ),
            ),
          ),
          array(
            'key'     => 'gap_size',
            'type'    => 'unit-slider',
            'label'   => __( 'Gap Size', '__x__' ),
            'options' => array(
              'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
              'valid_keywords'  => array( 'calc' ),
              'fallback_value'  => '25px',
              'ranges'          => array(
                'px'  => array( 'min' => 0, 'max' => 100, 'step' => 1   ),
                'em'  => array( 'min' => 0, 'max' => 10,  'step' => 0.1 ),
                'rem' => array( 'min' => 0, 'max' => 10,  'step' => 0.1 ),
                '%'   => array( 'min' => 0, 'max' => 100, 'step' => 1   ),
                'vw'  => array( 'min' => 0, 'max' => 100, 'step' => 1   ),
                'vh'  => array( 'min' => 0, 'max' => 100, 'step' => 1   ),
              ),
            ),
          ),
        ),
      ),
    )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_gap( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'gap';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Gap', '__x__' );

  $control_groups = array(
    $group            => array( 'title' => $group_title ),
    $group . ':setup' => array( 'title' => __( 'Setup', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_gap( $settings = array() ) {

  // Values
  // ------

  $values = array(
    'gap_direction'      => x_module_value( 'vertical', 'style' ),
    'gap_base_font_size' => x_module_value( '1em', 'style' ),
    'gap_size'           => x_module_value( '25px', 'style' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
