<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/GAP.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Shared
//   02. Setup
//   03. Groups
//   04. Conditions
//   05. Options
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================

$group       = ( isset( $settings['group'] )       ) ? $settings['group']     : 'gap';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Gap', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition'] : array();



// Groups
// =============================================================================

$group_gap_setup = $group . ':setup';



// Conditions
// =============================================================================

$conditions = x_module_conditions( $condition );



// Options
// =============================================================================

$options_gap_direction = array(
  'choices' => array(
    array( 'value' => 'horizontal', 'label' => __( 'Horizontal', '__x__' ) ),
    array( 'value' => 'vertical',   'label' => __( 'Vertical', '__x__' ) ),
  ),
);

$options_gap_base_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
    'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
  ),
);

$options_gap_size = array(
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
);
