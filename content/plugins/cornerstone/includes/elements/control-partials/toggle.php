<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/TOGGLE.PHP
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

function x_control_partial_toggle( $settings ) {


  // Shared
  // =============================================================================

  // Setup
  // -----

  $label_prefix     = ( isset( $settings['label_prefix'] )     ) ? $settings['label_prefix']     : '';
  $label_prefix_std = ( isset( $settings['label_prefix_std'] ) ) ? $settings['label_prefix_std'] : $label_prefix;
  $k_pre            = ( isset( $settings['k_pre'] )            ) ? $settings['k_pre'] . '_'      : '';
  $group            = ( isset( $settings['group'] )            ) ? $settings['group']            : 'general';
  $conditions       = ( isset( $settings['conditions'] )       ) ? $settings['conditions']       : array();


  // Conditions
  // ----------

  $condition_toggle_burger = array( 'key' => $k_pre . 'toggle_type', 'op' => 'IN', 'value' => array( 'burger-1' )             );
  $condition_toggle_grid   = array( 'key' => $k_pre . 'toggle_type', 'op' => 'IN', 'value' => array( 'grid-1' )               );
  $condition_toggle_more   = array( 'key' => $k_pre . 'toggle_type', 'op' => 'IN', 'value' => array( 'more-h-1', 'more-v-1' ) );



  // Options
  // =============================================================================

  $options_toggle_type = array(
    'choices' => array(
      array( 'value' => 'burger-1', 'label' => __( 'Burger', '__x__' )          ),
      array( 'value' => 'grid-1',   'label' => __( 'Grid', '__x__' )            ),
      array( 'value' => 'more-h-1', 'label' => __( 'More Horizontal', '__x__' ) ),
      array( 'value' => 'more-v-1', 'label' => __( 'More Vertical', '__x__' )   ),
    ),
  );

  $options_toggle_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'ranges'          => array(
      'px'  => array( 'min' => 1,   'max' => 10, 'step' => 1     ),
      'em'  => array( 'min' => 0.1, 'max' => 1,  'step' => 0.001 ),
      'rem' => array( 'min' => 0.1, 'max' => 1,  'step' => 0.001 ),
    ),
  );

  $options_toggle_spacing = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'ranges'          => array(
      'px'  => array( 'min' => 1, 'max' => 15, 'step' => 1   ),
      'em'  => array( 'min' => 1, 'max' => 10, 'step' => 0.1 ),
      'rem' => array( 'min' => 1, 'max' => 10, 'step' => 0.1 ),
    ),
  );


  // Individual Controls
  // -------------------

  $control_toggle_type = array(
    'key'     => $k_pre . 'toggle_type',
    'type'    => 'select',
    'label'   => __( 'Type', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'burger-1', 'label' => __( 'Burger', '__x__' )          ),
        array( 'value' => 'grid-1',   'label' => __( 'Grid', '__x__' )            ),
        array( 'value' => 'more-h-1', 'label' => __( 'More Horizontal', '__x__' ) ),
        array( 'value' => 'more-v-1', 'label' => __( 'More Vertical', '__x__' )   ),
      ),
    ),
  );

  $control_toggle_burger_size = array(
    'key'       => $k_pre . 'toggle_burger_size',
    'type'      => 'unit-slider',
    'label'     => __( 'Burger Size', '__x__' ),
    'condition' => $condition_toggle_burger,
    'options'   => $options_toggle_size,
  );

  $control_toggle_burger_spacing = array(
    'key'       => $k_pre . 'toggle_burger_spacing',
    'type'      => 'unit-slider',
    'label'     => __( 'Burger Spacing', '__x__' ),
    'condition' => $condition_toggle_burger,
    'options'   => $options_toggle_spacing,
  );

  $control_toggle_burger_width = array(
    'key'       => $k_pre . 'toggle_burger_width',
    'type'      => 'unit-slider',
    'label'     => __( 'Burger Width', '__x__' ),
    'options'   => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'ranges'          => array(
        'px'  => array( 'min' => 1, 'max' => 50, 'step' => 1   ),
        'em'  => array( 'min' => 1, 'max' => 20, 'step' => 0.1 ),
        'rem' => array( 'min' => 1, 'max' => 20, 'step' => 0.1 ),
      ),
    ),
    'condition' => $condition_toggle_burger,
  );

  $control_toggle_grid_size = array(
    'key'       => $k_pre . 'toggle_grid_size',
    'type'      => 'unit-slider',
    'label'     => __( 'Grid Size', '__x__' ),
    'condition' => $condition_toggle_grid,
    'options'   => $options_toggle_size,
  );

  $control_toggle_grid_spacing = array(
    'key'       => $k_pre . 'toggle_grid_spacing',
    'type'      => 'unit-slider',
    'label'     => __( 'Grid Spacing', '__x__' ),
    'condition' => $condition_toggle_grid,
    'options'   => $options_toggle_spacing,
  );

  $control_toggle_more_size = array(
    'key'       => $k_pre . 'toggle_more_size',
    'type'      => 'unit-slider',
    'label'     => __( 'More Size', '__x__' ),
    'condition' => $condition_toggle_more,
    'options'   => $options_toggle_size,
  );

  $control_toggle_more_spacing = array(
    'key'       => $k_pre . 'toggle_more_spacing',
    'type'      => 'unit-slider',
    'label'     => __( 'More Spacing', '__x__' ),
    'condition' => $condition_toggle_more,
    'options'   => $options_toggle_spacing,
  );

  $control_toggle_colors_combined = array(
    'keys' => array(
      'value' => $k_pre . 'toggle_color',
      'alt'   => $k_pre . 'toggle_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Color', '__x__' ),
    'options' => cs_recall( 'options_base_interaction_labels' ),
  );

  $control_toggle_color_base = array(
    'keys'  => array( 'value' => $k_pre . 'toggle_color' ),
    'type'  => 'color',
    'label' => __( 'Base', '__x__' ),
  );

  $control_toggle_color_interaction = array(
    'keys'  => array( 'value' => $k_pre . 'toggle_color_alt' ),
    'type'  => 'color',
    'label' => __( 'Interaction', '__x__' ),
  );

  return array(
    'controls' => array(
      array(
        'type'       => 'group',
        'label'      => __( '{{prefix}} Toggle', '__x__' ),
        'label_vars' => array( 'prefix' => $label_prefix ),
        'group'      => $group,
        'conditions' => $conditions,
        'controls'   => array(
          $control_toggle_type,
          $control_toggle_burger_size,
          $control_toggle_burger_spacing,
          $control_toggle_burger_width,
          $control_toggle_grid_size,
          $control_toggle_grid_spacing,
          $control_toggle_more_size,
          $control_toggle_more_spacing,
          $control_toggle_colors_combined,
        ),
      ),
    ),
    'controls_std_design_colors' => array(
      array(
        'type'       => 'group',
        'label'      => __( '{{prefix}} Toggle Colors', '__x__' ),
        'label_vars' => array( 'prefix' => $label_prefix_std ),
        'group'      => $group,
        'conditions' => $conditions,
        'controls'   => array(
          $control_toggle_colors_combined
        ),
      ),
    ),
  );
}

cs_register_control_partial( 'toggle', 'x_control_partial_toggle' );
