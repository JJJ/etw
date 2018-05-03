<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/LINE.PHP
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

function x_controls_line( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'line';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();

  $group_setup  = $group . ':setup';
  $group_design = $group . ':design';


  // Setup - Conditions
  // ------------------

  $conditions = x_module_conditions( $condition );


  // Setup - Settings
  // ----------------

  $settings_line_design = array(
    'k_pre'     => 'line',
    'group'     => $group_design,
    'condition' => $conditions,
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
            'key'     => 'line_direction',
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
            'key'     => 'line_base_font_size',
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
            'type'      => 'group',
            'label'     => __( 'Width &amp; Max Width', '__x__' ),
            'condition' => array( 'line_direction' => 'horizontal' ),
            'controls'  => array(
              array(
                'key'     => 'line_width',
                'type'    => 'unit',
                'options' => array(
                  'available_units' => array( 'px', 'em', 'rem', '%' ),
                  'valid_keywords'  => array( 'calc', 'auto' ),
                  'fallback_value'  => '100%',
                ),
              ),
              array(
                'key'     => 'line_max_width',
                'type'    => 'unit',
                'options' => array(
                  'available_units' => array( 'px', 'em', 'rem', '%' ),
                  'valid_keywords'  => array( 'calc', 'none' ),
                  'fallback_value'  => 'none',
                ),
              ),
            ),
          ),
          array(
            'type'      => 'group',
            'label'     => __( 'Height &amp; Max Height', '__x__' ),
            'condition' => array( 'line_direction' => 'vertical' ),
            'controls'  => array(
              array(
                'key'     => 'line_height',
                'type'    => 'unit',
                'options' => array(
                  'available_units' => array( 'px', 'em', 'rem', '%' ),
                  'valid_keywords'  => array( 'calc', 'auto' ),
                  'fallback_value'  => '50px',
                ),
              ),
              array(
                'key'     => 'line_max_height',
                'type'    => 'unit',
                'options' => array(
                  'available_units' => array( 'px', 'em', 'rem', '%' ),
                  'valid_keywords'  => array( 'calc', 'none' ),
                  'fallback_value'  => 'none',
                ),
              ),
            ),
          ),
          array(
            'key'     => 'line_size',
            'type'    => 'unit-slider',
            'label'   => __( 'Size', '__x__' ),
            'options' => array(
              'available_units' => array( 'px', 'em', 'rem' ),
              'valid_keywords'  => array( 'calc' ),
              'fallback_value'  => '8px',
              'ranges'          => array(
                'px'  => array( 'min' => 0, 'max' => 25, 'step' => 1   ),
                'em'  => array( 'min' => 0, 'max' => 2,  'step' => 0.1 ),
                'rem' => array( 'min' => 0, 'max' => 2,  'step' => 0.1 ),
              ),
            ),
          ),
          array(
            'type'     => 'group',
            'label'    => __( 'Color &amp; Style', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'line_color',
                'type'    => 'color',
                'options' => array(
                  'label' => __( 'Select', '__x__' ),
                ),
              ),
              array(
                'key'     => 'line_style',
                'type'    => 'select',
                'options' => array(
                  'choices' => array(
                    array( 'value' => 'solid',  'label' => __( 'Solid', '__x__' ) ),
                    array( 'value' => 'dotted', 'label' => __( 'Dotted', '__x__' ) ),
                    array( 'value' => 'dashed', 'label' => __( 'Dashed', '__x__' ) ),
                    array( 'value' => 'double', 'label' => __( 'Double', '__x__' ) ),
                    array( 'value' => 'groove', 'label' => __( 'Groove', '__x__' ) ),
                    array( 'value' => 'ridge',  'label' => __( 'Ridge', '__x__' ) ),
                  ),
                ),
              ),
            ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_line_design ),
    x_control_border_radius( $settings_line_design ),
    x_control_box_shadow( $settings_line_design )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_line( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'line';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Line', '__x__' );

  $control_groups = array(
    $group                => array( 'title' => $group_title ),
    $group . ':setup'     => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design'    => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_line( $settings = array() ) {

  // Values
  // ------

  $values = array(
    'line_direction'             => x_module_value( 'horizontal', 'style' ),
    'line_base_font_size'        => x_module_value( '1em', 'style' ),
    'line_width'                 => x_module_value( '100%', 'style' ),
    'line_max_width'             => x_module_value( 'none', 'style' ),
    'line_height'                => x_module_value( '50px', 'style' ),
    'line_max_height'            => x_module_value( 'none', 'style' ),
    'line_size'                  => x_module_value( '8px', 'style' ),
    'line_color'                 => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'line_style'                 => x_module_value( 'solid', 'style' ),
    'line_margin'                => x_module_value( '0px', 'style' ),
    'line_border_radius'         => x_module_value( '0em', 'style' ),
    'line_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
    'line_box_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
