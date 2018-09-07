<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/ROW.PHP
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

$group       = ( isset( $settings['group'] )       ) ? $settings['group']     : 'row';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Row', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition'] : array();



// Groups
// =============================================================================

$group_row_setup  = $group . ':setup';
$group_row_design = $group . ':design';



// Conditions
// =============================================================================

$conditions                    = x_module_conditions( $condition );
$condition_row_inner_container = array( 'row_inner_container' => false );
$conditions_row_border_color   = array( $condition, array( 'key' => 'row_border_width', 'op' => 'NOT EMPTY' ), array( 'key' => 'row_border_width', 'op' => 'NOT EMPTY' ) );



// Options
// =============================================================================

$options_row_base_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '16px',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
    'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
  ),
);

$options_row_z_index = array(
  'unit_mode'      => 'unitless',
  'fallback_value' => '9999',
);

$options_row_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
  'valid_keywords'  => array( 'calc', 'auto' ),
  'fallback_value'  => 'auto',
  'ranges'          => array(
    'px'  => array( 'min' => 0, 'max' => 1500, 'step' => 10  ),
    'em'  => array( 'min' => 0, 'max' => 40,   'step' => 0.5 ),
    'rem' => array( 'min' => 0, 'max' => 40,   'step' => 0.5 ),
    '%'   => array( 'min' => 0, 'max' => 100,  'step' => 1   ),
    'vw'  => array( 'min' => 0, 'max' => 100,  'step' => 1   ),
    'vh'  => array( 'min' => 0, 'max' => 100,  'step' => 1   ),
  ),
);

$options_row_max_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
  'valid_keywords'  => array( 'calc', 'none' ),
  'fallback_value'  => 'none',
  'ranges'          => array(
    'px'  => array( 'min' => 0, 'max' => 1500, 'step' => 10  ),
    'em'  => array( 'min' => 0, 'max' => 40,  'step' => 0.5  ),
    'rem' => array( 'min' => 0, 'max' => 40,  'step' => 0.5  ),
    '%'   => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
    'vw'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
    'vh'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
  ),
);



// Settings
// =============================================================================

$settings_row_bg = array(
  'group'     => $group_row_design,
  'condition' => array( 'row_bg_advanced' => true ),
);

$settings_row_design = array(
  'k_pre' => 'row',
  'group' => $group_row_design
);

$settings_row_design_margin = array(
  'k_pre'   => 'row',
  'group'   => $group_row_design,
  'options' => array(
    'left'  => array( 'disabled' => true, 'fallback_value' => 'auto' ),
    'right' => array( 'disabled' => true, 'fallback_value' => 'auto' ),
  ),
);

$settings_row_std_design = array(
  'k_pre' => 'row',
  'group' => $group_std_design,
);

$settings_row_std_design_margin = array(
  'k_pre' => 'row',
  'group' => $group_std_design,
  'options' => array(
    'left'  => array( 'disabled' => true, 'fallback_value' => 'auto' ),
    'right' => array( 'disabled' => true, 'fallback_value' => 'auto' ),
  ),
);



// Individual Controls
// =============================================================================

$control_row_base_font_size = array(
  'key'     => 'row_base_font_size',
  'type'    => 'unit',
  'label'   => __( 'Base Font Size', '__x__' ),
  'options' => $options_row_base_font_size,
);

$control_row_z_index = array(
  'key'     => 'row_z_index',
  'type'    => 'unit',
  'label'   => __( 'Z-Index', '__x__' ),
  'options' => $options_row_z_index,
);

$control_row_font_size_and_z_index =array(
  'type'     => 'group',
  'title'    => __( 'Font Size &amp; Z-Index', '__x__' ),
  'controls' => array(
    $control_row_base_font_size,
    $control_row_z_index,
  ),
);

$control_row_inner_container = array(
  'key'     => 'row_inner_container',
  'type'    => 'choose',
  'label'   => __( 'Inner Container', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_row_width = array(
  'key'       => 'row_width',
  'type'      => 'unit',
  'options'   => $options_row_width,
  'condition' => $condition_row_inner_container,
);

$control_row_max_width = array(
  'key'       => 'row_max_width',
  'type'      => 'unit',
  'options'   => $options_row_max_width,
  'condition' => $condition_row_inner_container,
);

$control_row_width_and_max_width = array(
  'type'      => 'group',
  'title'     => __( 'Width &amp; Max Width', '__x__' ),
  'condition' => $condition_row_inner_container,
  'controls'  => array(
    $control_row_width,
    $control_row_max_width,
  ),
);

$control_row_marginless_columns = array(
  'key'     => 'row_marginless_columns',
  'type'    => 'choose',
  'label'   => __( 'Marginless Columns', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_row_bg_color = array(
  'keys'    => array( 'value' => 'row_bg_color' ),
  'type'    => 'color',
  'label'   => __( 'Background', '__x__' ),
  'options' => $is_adv ? array( 'label' => __( 'Select', '__x__' ) ) : array(),
);

$control_row_bg_advanced = array(
  'keys' => array(
    'bg_advanced' => 'row_bg_advanced',
  ),
  'type'    => 'checkbox-list',
  'options' => array(
    'list' => array(
      array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
    ),
  ),
);

$control_row_background = array(
  'type'     => 'group',
  'title'    => __( 'Background', '__x__' ),
  'controls' => array(
    $control_row_bg_color,
    $control_row_bg_advanced
  ),
);

$control_row_text_align = array(
  'key'   => 'row_text_align',
  'type'  => 'text-align',
  'label' => __( 'Text Align', '__x__' ),
);



// Control Lists
// =============================================================================

// Advanced
// --------

$control_list_row_adv_setup = array(
  $control_row_font_size_and_z_index,
  $control_row_inner_container,
  $control_row_width_and_max_width,
  $control_row_marginless_columns,
  $control_row_background
);


// Standard
// --------

$control_list_row_std_design_setup = array(
  $control_row_font_size_and_z_index,
  $control_row_inner_container,
  $control_row_width_and_max_width,
  $control_row_marginless_columns,
  $control_row_text_align,
);

$control_list_row_std_design_colors_base = array(
  array(
    'keys'      => array( 'value' => 'row_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'row_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_row_bg_color
);



// Control Groups (Advanced)
// =============================================================================

$control_group_row_adv_setup = array(
  array(
    'type'     => 'group',
    'title'    => __( 'Setup', '__x__' ),
    'group'    => $group_row_setup,
    'controls' => $control_list_row_adv_setup,
  ),
);

$control_group_row_adv_formatting = array(
  array(
    'type'     => 'group',
    'title'    => __( 'Formatting', '__x__' ),
    'group'    => $group_row_design,
    'controls' => array(
      $control_row_text_align
    ),
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_row_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_row_std_design_setup,
  ),
);

$control_group_row_std_design_colors = array_merge(
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Base Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_row_std_design_colors_base,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_row_std_design,
      array(
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'row_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'row_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  )
);
