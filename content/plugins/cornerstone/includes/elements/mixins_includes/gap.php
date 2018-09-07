<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/GAP.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   04. Control Group
//   05. Values
// =============================================================================

// Controls
// =============================================================================

function x_controls_gap( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/gap.php' );

  $controls = array(
    array(
      'type'       => 'group',
      'title'      => __( 'Setup', '__x__' ),
      'group'      => $is_adv ? $group_gap_setup : $group_std_design,
      'conditions' => $conditions,
      'controls'   => array(
        array(
          'key'     => 'gap_direction',
          'type'    => 'choose',
          'label'   => __( 'Direction', '__x__' ),
          'options' => $options_gap_direction,
        ),
        array(
          'key'     => 'gap_base_font_size',
          'type'    => 'unit-slider',
          'label'   => __( 'Base Font Size', '__x__' ),
          'options' => $options_gap_base_font_size,
        ),
        array(
          'key'     => 'gap_size',
          'type'    => 'unit-slider',
          'label'   => __( 'Gap Size', '__x__' ),
          'options' => $options_gap_size,
        ),
      ),
    ),
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_gap( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/gap.php' );

  $control_groups = array(
    $group           => array( 'title' => $group_title ),
    $group_gap_setup => array( 'title' => __( 'Setup', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_gap( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/gap.php' );

  $values = array(
    'gap_direction'      => x_module_value( 'vertical', 'style' ),
    'gap_base_font_size' => x_module_value( '1em', 'style' ),
    'gap_size'           => x_module_value( '25px', 'style' ),
  );

  return x_bar_mixin_values( $values, $settings );

}
