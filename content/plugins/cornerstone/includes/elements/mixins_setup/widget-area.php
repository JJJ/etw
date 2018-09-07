<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/WIDGET-AREA.PHP
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

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'widget_area';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Widget Area', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();



// Groups
// =============================================================================

$group_widget_area_setup  = $group . ':setup';
$group_widget_area_design = $group . ':design';



// Conditions
// =============================================================================

$conditions                          = x_module_conditions( $condition );
$conditions_widget_area_border_color = array( $condition, array( 'key' => 'widget_area_border_width', 'op' => 'NOT EMPTY' ), array( 'key' => 'widget_area_border_width', 'op' => 'NOT EMPTY' ) );



// Options
// =============================================================================

$options_widget_area_base_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'fallback_value'  => '14px',
  'ranges'          => array(
    'px'  => array( 'min' => '10', 'max' => '24',  'step' => '1'    ),
    'em'  => array( 'min' => '1',  'max' => '2.5', 'step' => '0.01' ),
    'rem' => array( 'min' => '1',  'max' => '2.5', 'step' => '0.01' ),
  ),
);



// Settings
// =============================================================================

$settings_widget_area = array(
  'k_pre' => 'widget_area',
  'group' => $group_widget_area_design
);

$settings_widget_std_design = array(
  'k_pre' => 'widget_area',
  'group' => $group_std_design
);



// Individual Controls
// =============================================================================

$control_widget_area_sidebar = array(
  'key'   => 'widget_area_sidebar',
  'type'  => 'sidebar',
  'label' => __( 'Sidebar', '__x__' ),
);

$control_widget_area_base_font_size = array(
  'key'     => 'widget_area_base_font_size',
  'type'    => 'slider',
  'label'   => __( 'Base Font Size', '__x__' ),
  'options' => $options_widget_area_base_font_size,
);

$control_widget_area_bg_color = array(
  'keys'  => array( 'value' => 'widget_area_bg_color' ),
  'type'  => 'color',
  'label' => __( 'Background', '__x__' ),
);



// Control Lists
// =============================================================================

// Advanced
// --------

$control_list_widget_area_adv_setup = array(
  $control_widget_area_sidebar,
  $control_widget_area_base_font_size,
  $control_widget_area_bg_color,
);


// Standard
// --------

$control_list_widget_area_std_content_setup = array(
  $control_widget_area_sidebar,
);

$control_list_widget_area_std_design_setup = array(
  $control_widget_area_base_font_size,
);

$control_list_widget_area_std_design_colors = array(
  array(
    'keys'      => array( 'value' => 'widget_area_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'widget_area_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_widget_area_bg_color,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_widget_area_adv_setup = array(
  array(
    'type'     => 'group',
    'title'    => __( 'Setup', '__x__' ),
    'group'    => $group_widget_area_setup,
    'controls' => $control_list_widget_area_adv_setup,
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_widget_area_std_content_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Content Setup', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions,
    'controls'   => $control_list_widget_area_std_content_setup,
  ),
);

$control_group_widget_area_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_widget_area_std_design_setup,
  ),
);

$control_group_widget_area_std_design_colors = array_merge(
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Base Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_widget_area_std_design_colors,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_widget_std_design,
      array(
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'widget_area_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'widget_area_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  )
);
