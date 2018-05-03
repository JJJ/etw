<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/_OMEGA.PHP
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

function x_controls_omega( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'omega';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();
  $add_style = ( isset( $settings['add_style'] ) ) ? true                   : false;

  $group_setup = $group . ':setup';


  // Setup - Conditions
  // ------------------

  $conditions = x_module_conditions( $condition );


  // Data
  // ----

  $data = array(
    'type'       => 'omega',
    'group'      => $group_setup,
    'conditions' => $conditions,
  );


  // Keys
  // ----

  $keys = array(
    'id'    => 'id',
    'class' => 'class',
    'css'   => 'css',
    'bp'    => 'hide_bp',
    'login' => 'hide_login',
  );

  if ( $add_style ) {
    $keys['style'] = 'style';
  }

  $data['keys'] = $keys;


  // Returned Value
  // --------------

  $control = array( $data );

  return $control; // return array( 'type' => 'mixin::omega');

}



// Control Groups
// =============================================================================

function x_control_groups_omega( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'omega';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Customize', '__x__' );

  $control_groups = array(
    $group            => array( 'title' => $group_title ),
    $group . ':setup' => array( 'title' => __( 'Setup', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_omega( $settings = array() ) {

  $add_style = ( isset( $settings['add_style'] ) ) ? true : false;


  // Values
  // ------

  $values = array(
    'id'         => x_module_value( '', 'markup' ),
    'class'      => x_module_value( '', 'attr' ),
    'css'        => x_module_value( '', 'style' ),
    'hide_bp'    => x_module_value( '', 'markup' ),
    'hide_login' => x_module_value( '', 'markup' ),
  );

  if ( $add_style ) {
    $values['style'] = x_module_value( '', 'attr' );
  }


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
