<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/DROPDOWN.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Group
//   03. Values
// =============================================================================

// Controls
// =============================================================================

function x_controls_dropdown( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'dropdown';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();
  $inc_links = ( isset( $settings['inc_links'] ) ) ? true                   : false;

  $group_setup  = $group . ':setup';
  $group_design = $group . ':design';


  // Setup - Conditions
  // ------------------

  $conditions = x_module_conditions( $condition );


  // Setup - Options
  // ---------------

  $options_dropdown_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '16px',
    'ranges'          => array(
      'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
      'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
      'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
    ),
  );

  $options_dropdown_width = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'auto' ),
    'fallback_value'  => '250px',
    'ranges'          => array(
      'px'  => array( 'min' => 200, 'max' => 500, 'step' => 1    ),
      'em'  => array( 'min' => 15,  'max' => 35,  'step' => 0.01 ),
      'rem' => array( 'min' => 15,  'max' => 35,  'step' => 0.01 ),
    ),
  );


  // Setup - Settings
  // ----------------

  $settings_dropdown = array(
    'k_pre'      => 'dropdown',
    't_pre'      => __( 'Dropdown', '__x__' ),
    'group'      => $group_design,
    'conditions' => $conditions,
  );

  $settings_dropdown_first = array(
    'k_pre'      => 'dropdown',
    't_pre'      => __( 'First Dropdown', '__x__' ),
    'group'      => $group_design,
    'conditions' => $conditions,
  );


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
            'key'     => 'dropdown_base_font_size',
            'type'    => 'slider',
            'title'   => __( 'Font Size', '__x__' ),
            'options' => $options_dropdown_font_size,
          ),
          array(
            'key'     => 'dropdown_width',
            'type'    => 'slider',
            'title'   => __( 'Width', '__x__' ),
            'options' => $options_dropdown_width,
          ),
          array(
            'key'   => 'dropdown_bg_color',
            'type'  => 'color',
            'title' => __( 'Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_dropdown_first ),
    x_control_border( $settings_dropdown ),
    x_control_border_radius( $settings_dropdown ),
    x_control_padding( $settings_dropdown ),
    x_control_box_shadow( $settings_dropdown )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_dropdown( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group'] : 'dropdown';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Dropdown', '__x__' );

  $control_groups = array(
    $group             => array( 'title' => $group_title ),
    $group . ':setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design' => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_dropdown( $settings = array() ) {

  // Values
  // ------

  $values = array(
    'dropdown_base_font_size'        => x_module_value( '16px', 'style' ),
    'dropdown_width'                 => x_module_value( '14em', 'style' ),
    'dropdown_bg_color'              => x_module_value( '#ffffff', 'style:color' ),
    'dropdown_margin'                => x_module_value( '0em', 'style' ),
    'dropdown_padding'               => x_module_value( '0em', 'style' ),
    'dropdown_border_width'          => x_module_value( '0px', 'style' ),
    'dropdown_border_style'          => x_module_value( 'none', 'style' ),
    'dropdown_border_color'          => x_module_value( 'transparent', 'style:color' ),
    'dropdown_border_radius'         => x_module_value( '0em', 'style' ),
    'dropdown_box_shadow_dimensions' => x_module_value( '0em 0.15em 2em 0em', 'style' ),
    'dropdown_box_shadow_color'      => x_module_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
