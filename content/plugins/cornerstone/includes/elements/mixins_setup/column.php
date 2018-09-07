<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/COLUMN.PHP
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

$group       = ( isset( $settings['group'] )       ) ? $settings['group']     : 'column';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Column', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition'] : array();



// Groups
// =============================================================================

$group_column_setup  = $group . ':setup';
$group_column_design = $group . ':design';



// Conditions
// =============================================================================

$conditions                              = x_module_conditions( $condition );
$conditions_column_fade_animation_offset = array( array( 'column_fade' => true ), array( 'key' => 'column_fade_animation', 'op' => 'NOT IN', 'value' => 'in' ) );
$conditions_column_border_color          = array( $condition, array( 'key' => 'column_border_width', 'op' => 'NOT EMPTY' ), array( 'key' => 'column_border_width', 'op' => 'NOT EMPTY' ) );



// Options
// =============================================================================

$options_column_base_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '16px',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
    'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
  ),
);

$options_column_z_index = array(
  'unit_mode'      => 'unitless',
  'fallback_value' => '9999',
);

$options_column_fade_duration = array(
  'unit_mode'       => 'time',
  'available_units' => array( 's', 'ms' ),
  'fallback_value'  => '0.5s',
  'ranges'          => array(
    's'  => array( 'min' => 0, 'max' => 5,    'step' => 0.1 ),
    'ms' => array( 'min' => 0, 'max' => 5000, 'step' => 100 ),
  ),
);

$options_column_fade_animation = array(
  'choices' => array(
    array( 'value' => 'in',             'label' => __( 'In', '__x__' ) ),
    array( 'value' => 'in-from-top',    'label' => __( 'In From Top', '__x__' ) ),
    array( 'value' => 'in-from-left',   'label' => __( 'In From Left', '__x__' ) ),
    array( 'value' => 'in-from-right',  'label' => __( 'In From Right', '__x__' ) ),
    array( 'value' => 'in-from-bottom', 'label' => __( 'In From Bottom', '__x__' ) ),
  ),
);

$options_column_fade_animation_offset = array(
  'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
  'fallback_value'  => '50px',
  'ranges'          => array(
    'px'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
    'em'  => array( 'min' => 0, 'max' => 15,  'step' => 0.25 ),
    'rem' => array( 'min' => 0, 'max' => 15,  'step' => 0.25 ),
    '%'   => array( 'min' => 0, 'max' => 200, 'step' => 5    ),
    'vw'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
    'vh'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
  ),
);



// Settings
// =============================================================================

$settings_column_bg = array(
  'group'     => $group_column_design,
  'condition' => array( 'column_bg_advanced' => true ),
);

$settings_column_design = array(
  'k_pre' => 'column',
  'group' => $group_column_design
);

$settings_column_std_design = array(
  'k_pre' => 'column',
  'group' => $group_std_design
);



// Individual Controls
// =============================================================================

$control_column_base_font_size = array(
  'key'     => 'column_base_font_size',
  'type'    => 'unit',
  'options' => $options_column_base_font_size,
);

$control_column_z_index = array(
  'key'     => 'column_z_index',
  'type'    => 'unit',
  'options' => $options_column_z_index,
);

$control_column_base_font_size_and_z_index = array(
  'type'     => 'group',
  'title'    => __( 'Font Size &amp; Z-Index', '__x__' ),
  'controls' => array(
    $control_column_base_font_size,
    $control_column_z_index
  ),
);

$control_column_fade = array(
  'key'     => 'column_fade',
  'type'    => 'choose',
  'label'   => __( 'Fade In Effect', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_column_fade_duration = array(
  'key'     => 'column_fade_duration',
  'type'    => 'unit',
  'options' => $options_column_fade_duration,
);

$control_column_fade_animation = array(
  'key'     => 'column_fade_animation',
  'type'    => 'select',
  'options' => $options_column_fade_animation,
);

$control_column_fade_duration_and_animation = array(
  'type'      => 'group',
  'title'     => __( 'Duration &amp; Animation', '__x__' ),
  'condition' => array( 'column_fade' => true ),
  'controls'  => array(
    $control_column_fade_duration,
    $control_column_fade_animation,
  ),
);

$control_column_fade_animation_offset = array(
  'key'        => 'column_fade_animation_offset',
  'type'       => 'unit-slider',
  'label'      => __( 'Animation Offset', '__x__' ),
  'conditions' => $conditions_column_fade_animation_offset,
  'options'    => $options_column_fade_animation_offset,
);

$control_column_bg_color = array(
  'key'     => 'column_bg_color',
  'type'    => 'color',
  'label'   => __( 'Background', '__x__' ),
  'options' => $is_adv ? array( 'label' => __( 'Select', '__x__' ) ) : array(),
);

$control_column_bg_advanced = array(
  'keys' => array(
    'bg_advanced' => 'column_bg_advanced',
  ),
  'type'    => 'checkbox-list',
  'options' => array(
    'list' => array(
      array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
    ),
  ),
);

$control_column_background = array(
  'type'     => 'group',
  'title'    => __( 'Background', '__x__' ),
  'controls' => array(
    $control_column_bg_color,
    $control_column_bg_advanced,
  ),
);

$control_column_text_align = array(
  'key'   => 'column_text_align',
  'type'  => 'text-align',
  'label' => __( 'Text Align', '__x__' ),
);



// Control Lists
// =============================================================================

// Advanced
// --------

$control_list_column_adv_setup = array(
  $control_column_base_font_size_and_z_index,
  $control_column_fade,
  $control_column_fade_duration_and_animation,
  $control_column_fade_animation_offset,
  $control_column_background,
);


// Standard
// --------

$control_list_column_std_design_setup = array(
  $control_column_base_font_size_and_z_index,
  $control_column_text_align,
);

$control_list_column_std_design_colors_base = array(
  array(
    'keys'      => array( 'value' => 'column_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'column_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_column_bg_color
);



// Control Groups (Advanced)
// =============================================================================

$control_group_column_adv_setup = array(
  array(
    'type'     => 'group',
    'title'    => __( 'Setup', '__x__' ),
    'group'    => $group_column_setup,
    'controls' => $control_list_column_adv_setup,
  ),
);

$control_group_column_adv_formatting = array(
  array(
    'type'     => 'group',
    'title'    => __( 'Formatting', '__x__' ),
    'group'    => $group_column_design,
    'controls' => array(
      $control_column_text_align,
    ),
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_column_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_column_std_design_setup,
  ),
);

$control_group_column_std_design_colors = array_merge(
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Base Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_column_std_design_colors_base,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_column_std_design,
      array(
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'column_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'column_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  )
);
