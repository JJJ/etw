<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/_DROPDOWN.PHP
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
//   06. Settings
//   07. Individual Controls
//   08. Control Lists
//   09. Control Groups (Advanced)
//   10. Control Groups (Standard Design)
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'dropdown';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Dropdown', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();
$inc_links   = ( isset( $settings['inc_links'] )   ) ? true                     : false;



// Groups
// =============================================================================

$group_dropdown_setup  = $group . ':setup';
$group_dropdown_design = $group . ':design';



// Conditions
// =============================================================================

$conditions = x_module_conditions( $condition );



// Options
// =============================================================================

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



// Settings
// =============================================================================

$settings_dropdown = array(
  'k_pre'      => 'dropdown',
  't_pre'      => __( 'Dropdown', '__x__' ),
  'group'      => $group_dropdown_design,
  'conditions' => $conditions,
);

$settings_dropdown_first = array(
  'k_pre'      => 'dropdown',
  't_pre'      => __( 'First Dropdown', '__x__' ),
  'group'      => $group_dropdown_design,
  'conditions' => $conditions,
);



// Individual Controls
// =============================================================================

$control_dropdown_base_font_size = array(
  'key'     => 'dropdown_base_font_size',
  'type'    => 'unit-slider',
  'title'   => __( 'Font Size', '__x__' ),
  'options' => $options_dropdown_font_size,
);

$control_dropdown_width = array(
  'key'     => 'dropdown_width',
  'type'    => 'slider',
  'title'   => __( 'Width', '__x__' ),
  'options' => $options_dropdown_width,
);

$control_dropdown_bg_color = array(
  'key'   => 'dropdown_bg_color',
  'type'  => 'color',
  'title' => __( 'Background', '__x__' ),
);



// Control Lists
// =============================================================================

$control_list_dropdown_adv_setup = array(
  $control_dropdown_base_font_size,
  $control_dropdown_width,
  $control_dropdown_bg_color,
);

$control_list_dropdown_std_design_setup = array(
  $control_dropdown_base_font_size,
  $control_dropdown_width,
);

$control_list_dropdown_std_design_colors_base = array(
  array(
    'keys'      => array( 'value' => 'dropdown_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'dropdown_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
  ),
  $control_dropdown_bg_color,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_dropdown_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_dropdown_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_dropdown_adv_setup,
  ),
);



// Control Groups (Standard Design)
// =============================================================================

$control_group_dropdown_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Dropdown Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_dropdown_std_design_setup,
  ),
);

$control_group_dropdown_std_design_colors = array_merge(
  array(
    array(
      'type'     => 'group',
      'title'    => __( 'Dropdown Base Colors', '__x__' ),
      'group'    => $group_std_design,
      'controls' => $control_list_dropdown_std_design_colors_base,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_dropdown,
      array(
        'group'     => $group_std_design,
        'options'   => array( 'color_only' => true ),
        'condition' => array(
          $condition,
          array( 'key' => 'dropdown_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'dropdown_border_style', 'op' => '!=', 'value' => 'none' ),
        ),
      )
    )
  )
);
