<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/OMEGA.PHP
// -----------------------------------------------------------------------------
// Element Controls
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
// =============================================================================

// Controls
// =============================================================================

function x_control_partial_omega( $settings ) {

  // Setup
  // -----

  $group                 = ( isset( $settings['group'] )                 ) ? $settings['group']                 : 'omega:setup';
  $conditions            = ( isset( $settings['conditions'] )           ) ? $settings['conditions']             : array();
  $title                 = ( isset( $settings['title'] )                 ) ? $settings['title']                 : false;
  $add_style             = ( isset( $settings['add_style'] )             ) ? true                               : false;
  $add_toggle_hash       = ( isset( $settings['add_toggle_hash'] )       ) ? true                               : false;
  $toggle_hash_condition = ( isset( $settings['toggle_hash_condition'] ) ) ? $settings['toggle_hash_condition'] : false;


  // Data
  // ----

  $control = array(
    'type'       => 'omega',
    'group'      => $group,
    'conditions' => $conditions,
    'options'    => array(),
  );

  if ( ! empty( $title ) ) {
    $control['label'] = $title;
  }


  // Keys
  // ----

  $keys = array(
    'id'    => 'id',
    'class' => 'class',
    'css'   => 'css',
    'bp'    => 'hide_bp'
  );

  if ( $add_style ) {
    $keys['style'] = 'style';
  }

  if ( $add_toggle_hash ) {
    $keys['toggle_hash'] = 'toggle_hash';
  }

  if ( $toggle_hash_condition ) {
    $control['options']['toggle_hash_condition'] = $toggle_hash_condition;
  }

  $control['keys'] = $keys;

  return array(
    'controls' => array( $control ),
    'controls_std_customize' => array( $control ),
    'control_nav' => array(
      'omega'       => __( 'Customize', '__x__' ),
      'omega:setup' => __( 'Setup', '__x__' ),
    )
  );
}

cs_register_control_partial( 'omega', 'x_control_partial_omega' );
