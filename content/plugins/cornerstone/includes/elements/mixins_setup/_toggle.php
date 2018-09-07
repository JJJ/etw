<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/_TOGGLE.PHP
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
//   06. Individual Controls
//   07. Control Lists
//   08. Control Groups (Advanced)
//   09. Control Groups (Standard)
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================

$t_pre     = ( isset( $settings['t_pre'] )     ) ? $settings['t_pre'] . ' ' : '';
$k_pre     = ( isset( $settings['k_pre'] )     ) ? $settings['k_pre'] . '_' : '';
$group     = ( isset( $settings['group'] )     ) ? $settings['group']       : 'general';
$condition = ( isset( $settings['condition'] ) ) ? $settings['condition']   : array();



// Groups
// =============================================================================
// Parent mixins will pass in group.



// Conditions
// =============================================================================

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

$options_toggle_width = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'ranges'          => array(
    'px'  => array( 'min' => 1, 'max' => 50, 'step' => 1   ),
    'em'  => array( 'min' => 1, 'max' => 20, 'step' => 0.1 ),
    'rem' => array( 'min' => 1, 'max' => 20, 'step' => 0.1 ),
  ),
);



// Individual Controls
// =============================================================================

$control_toggle_type = array(
  'key'     => $k_pre . 'toggle_type',
  'type'    => 'select',
  'label'   => __( 'Type', '__x__' ),
  'options' => $options_toggle_type,
);

$control_toggle_burger_size = array(
  'key'       => $k_pre . 'toggle_burger_size',
  'type'      => 'unit-slider',
  'title'     => __( 'Burger Size', '__x__' ),
  'options'   => $options_toggle_size,
  'condition' => $condition_toggle_burger,
);

$control_toggle_burger_spacing = array(
  'key'       => $k_pre . 'toggle_burger_spacing',
  'type'      => 'unit-slider',
  'title'     => __( 'Burger Spacing', '__x__' ),
  'options'   => $options_toggle_spacing,
  'condition' => $condition_toggle_burger,
);

$control_toggle_burger_width = array(
  'key'       => $k_pre . 'toggle_burger_width',
  'type'      => 'unit-slider',
  'title'     => __( 'Burger Width', '__x__' ),
  'options'   => $options_toggle_width,
  'condition' => $condition_toggle_burger,
);

$control_toggle_grid_size = array(
  'key'       => $k_pre . 'toggle_grid_size',
  'type'      => 'unit-slider',
  'title'     => __( 'Grid Size', '__x__' ),
  'options'   => $options_toggle_size,
  'condition' => $condition_toggle_grid,
);

$control_toggle_grid_spacing = array(
  'key'       => $k_pre . 'toggle_grid_spacing',
  'type'      => 'unit-slider',
  'title'     => __( 'Grid Spacing', '__x__' ),
  'options'   => $options_toggle_spacing,
  'condition' => $condition_toggle_grid,
);

$control_toggle_more_size = array(
  'key'       => $k_pre . 'toggle_more_size',
  'type'      => 'unit-slider',
  'title'     => __( 'More Size', '__x__' ),
  'options'   => $options_toggle_size,
  'condition' => $condition_toggle_more,
);

$control_toggle_more_spacing = array(
  'key'       => $k_pre . 'toggle_more_spacing',
  'type'      => 'unit-slider',
  'title'     => __( 'More Spacing', '__x__' ),
  'options'   => $options_toggle_spacing,
  'condition' => $condition_toggle_more,
);

$control_toggle_colors_combined = array(
  'keys' => array(
    'value' => $k_pre . 'toggle_color',
    'alt'   => $k_pre . 'toggle_color_alt',
  ),
  'type'    => 'color',
  'label'   => __( 'Color', '__x__' ),
  'options' => $options_base_interaction_labels,
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



// Control Lists
// =============================================================================

// Advanced Setup
// --------------

$control_list_toggle_adv_setup = array(
  $control_toggle_type,
  $control_toggle_burger_size,
  $control_toggle_burger_spacing,
  $control_toggle_burger_width,
  $control_toggle_grid_size,
  $control_toggle_grid_spacing,
  $control_toggle_more_size,
  $control_toggle_more_spacing,
  $control_toggle_colors_combined,
);


// Standard Design Setup
// ---------------------

$control_list_toggle_std_design_setup = array(
  $control_toggle_colors_combined
);



// Control Groups (Advanced)
// =============================================================================

$control_group_toggle_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . 'Toggle', '__x__' ),
    'group'      => $group,
    'conditions' => x_module_conditions( $condition ),
    'controls'   => $control_list_toggle_adv_setup,
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_toggle_std_design_colors = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . 'Toggle Colors', '__x__' ),
    'group'      => $group,
    'conditions' => x_module_conditions( $condition ),
    'controls'   => $control_list_toggle_std_design_setup,
  ),
);