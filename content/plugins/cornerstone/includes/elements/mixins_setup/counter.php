<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/COUNTER.PHP
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

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'counter';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Counter', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();



// Groups
// =============================================================================

$group_counter_setup  = $group . ':setup';
$group_counter_design = $group . ':design';
$group_counter_number = $group . ':number';
$group_counter_text   = $group . ':text';



// Conditions
// =============================================================================

$conditions              = x_module_conditions( $condition );
$conditions_before_after = array( $condition, array( 'counter_before_after' => true ) );



// Options
// =============================================================================

$options_counter_base_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
    'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
  ),
);

$options_counter_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'fallback_value'  => 'auto',
  'valid_keywords'  => array( 'auto', 'calc' ),
  'ranges'          => array(
    'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
    'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
    'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
    '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
  ),
);

$options_counter_max_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'fallback_value'  => 'none',
  'valid_keywords'  => array( 'none', 'calc' ),
  'ranges'          => array(
    'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
    'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
    'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
    '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
  ),
);

$options_counter_start = array(
  'unit_mode'      => 'unitless',
  'fallback_value' => 0,
);

$options_counter_end = array(
  'unit_mode'      => 'unitless',
  'fallback_value' => 100,
);

$options_counter_duration = array(
  'unit_mode'       => 'time',
  'available_units' => array( 's', 'ms' ),
  'fallback_value'  => '0.5s',
  'ranges'          => array(
    's'  => array( 'min' => 0, 'max' => 5,    'step' => 0.1 ),
    'ms' => array( 'min' => 0, 'max' => 5000, 'step' => 100 ),
  ),
);

$options_counter_number_margin_tb = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'fallback_value'  => '10px',
  'valid_keywords'  => array( 'calc' ),
  'ranges'          => array(
    'px'  => array( 'min' => 0, 'max' => 32, 'step' => 1   ),
    'em'  => array( 'min' => 0, 'max' => 3,  'step' => 0.1 ),
    'rem' => array( 'min' => 0, 'max' => 3,  'step' => 0.1 ),
  ),
);

$options_counter_number_margin_lr = array(
  'disabled'       => true,
  'fallback_value' => '0px',
);

$options_counter_number_margin = array(
  'top'    => $options_counter_number_margin_tb,
  'left'   => $options_counter_number_margin_lr,
  'right'  => $options_counter_number_margin_lr,
  'bottom' => $options_counter_number_margin_tb,
);



// Settings
// =============================================================================

$settings_counter = array(
  'k_pre'     => 'counter',
  't_pre'     => __( 'Counter', '__x__' ),
  'group'     => $group_counter_design,
  'condition' => $conditions,
);

$settings_counter_number = array(
  'k_pre'     => 'counter_number',
  't_pre'     => __( 'Number', '__x__' ),
  'group'     => $group_counter_number,
  'condition' => $conditions,
);

$settings_counter_number_margin = array(
  'k_pre'     => 'counter_number',
  't_pre'     => __( 'Number', '__x__' ),
  'group'     => $group_counter_number,
  'options'   => $options_counter_number_margin,
  'condition' => $conditions,
);

$settings_counter_before_after = array(
  'k_pre'     => 'counter_before_after',
  't_pre'     => __( 'Before &amp; After', '__x__' ),
  'group'     => $group_counter_text,
  'condition' => $conditions_before_after,
);

$settings_counter_std_design = array(
  'k_pre'     => 'counter',
  't_pre'     => __( 'Counter', '__x__' ),
  'group'     => $group_std_design,
  'condition' => $conditions,
);

$settings_counter_std_design_number_margin = array(
  'k_pre'     => 'counter_number',
  't_pre'     => __( 'Number', '__x__' ),
  'group'     => $group_std_design,
  'options'   => $options_counter_number_margin,
  'condition' => $conditions,
);



// Individual Controls
// =============================================================================

$control_counter_base_font_size = array(
  'key'     => 'counter_base_font_size',
  'type'    => 'unit-slider',
  'label'   => __( 'Base Font Size', '__x__' ),
  'options' => $options_counter_base_font_size,
);

$control_counter_width = array(
  'key'     => 'counter_width',
  'type'    => $is_adv ? 'unit' : 'unit-slider',
  'label'   => __( 'Width', '__x__' ),
  'options' => $options_counter_width,
);

$control_counter_max_width = array(
  'key'     => 'counter_max_width',
  'type'    => $is_adv ? 'unit' : 'unit-slider',
  'label'   => __( 'Max Width', '__x__' ),
  'options' => $options_counter_max_width,
);

$control_counter_width_and_max_width = array(
  'type'     => 'group',
  'label'    => __( 'Width &amp; Max Width', '__x__' ),
  'controls' => array(
    $control_counter_width,
    $control_counter_max_width,
  ),
);

$control_counter_start = array(
  'key'     => 'counter_start',
  'type'    => 'unit',
  'options' => $options_counter_start,
);

$control_counter_end = array(
  'key'     => 'counter_end',
  'type'    => 'unit',
  'options' => $options_counter_end,
);

$control_counter_start_and_end = array(
  'type'     => 'group',
  'label'    => __( 'Number Start &amp; End', '__x__' ),
  'controls' => array(
    $control_counter_start,
    $control_counter_end,
  ),
);

$control_counter_number_prefix_content = array(
  'key'   => 'counter_number_prefix_content',
  'type'  => 'text',
  'label' => __( 'Number Prefix', '__x__' ),
);

$control_counter_number_suffix_content = array(
  'key'   => 'counter_number_suffix_content',
  'type'  => 'text',
  'label' => __( 'Number Suffix', '__x__' ),
);

$control_counter_number_prefix_and_suffix_content = array(
  'type'     => 'group',
  'label'    => __( 'Prefix &amp; Suffix', '__x__' ),
  'controls' => array(
    $control_counter_number_prefix_content,
    $control_counter_number_suffix_content,
  ),
);

$control_counter_duration = array(
  'key'     => 'counter_duration',
  'type'    => 'unit-slider',
  'label'   => __( 'Effect Duration', '__x__' ),
  'options' => $options_counter_duration,
);

$control_counter_before_after = array(
  'key'     => 'counter_before_after',
  'type'    => 'choose',
  'label'   => __( 'Above &amp; Below Text', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_counter_before_content = array(
  'key'        => 'counter_before_content',
  'type'       => 'text',
  'label'      => __( 'Text Above', '__x__' ),
  'conditions' => $conditions_before_after,
);

$control_counter_after_content = array(
  'key'        => 'counter_after_content',
  'type'       => 'text',
  'label'      => __( 'Text Below', '__x__' ),
  'conditions' => $conditions_before_after,
);



// Control Lists
// =============================================================================

// Advanced
// --------

$control_list_counter_adv_setup = array(
  $control_counter_base_font_size,
  $control_counter_width_and_max_width,
  $control_counter_start_and_end,
  $control_counter_number_prefix_and_suffix_content,
  $control_counter_duration,
);

$control_list_counter_adv_setup_above_and_below = array(
  $control_counter_before_after,
  $control_counter_before_content,
  $control_counter_after_content,
);


// Standard
// --------

$control_list_counter_std_content_setup = array(
  $control_counter_start_and_end,
  $control_counter_number_prefix_content,
  $control_counter_number_suffix_content,
  $control_counter_before_content,
  $control_counter_after_content,

);

$control_list_counter_std_design_setup = array(
  $control_counter_base_font_size,
  $control_counter_width,
  $control_counter_max_width,
  array(
    'key'   => 'counter_number_text_align',
    'type'  => 'text-align',
    'label' => __( 'Number Text Align', '__x__' ),
  ),
  array(
    'key'        => 'counter_before_after_text_align',
    'type'       => 'text-align',
    'label'      => __( 'Bookend Text Align', '__x__' ),
    'conditions' => $conditions_before_after,
  ),
);

$control_list_counter_std_design_colors_base = array(
  array(
    'keys'  => array( 'value' => 'counter_number_text_color' ),
    'type'  => 'color',
    'label' => __( 'Text', '__x__' ),
  ),
  array(
    'keys'      => array( 'value' => 'counter_number_text_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Text<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'counter_number_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
);

$control_list_counter_std_design_colors_before_and_after = array(
  array(
    'keys'  => array( 'value' => 'counter_before_after_text_color' ),
    'type'  => 'color',
    'label' => __( 'Text', '__x__' ),
  ),
  array(
    'keys'      => array( 'value' => 'counter_before_after_text_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Text<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'counter_before_after_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
);



// Control Groups (Advanced)
// =============================================================================

$control_group_counter_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_counter_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_counter_adv_setup,
  ),
);

$control_group_counter_adv_setup_above_and_below = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Text Above &amp; Below Setup', '__x__' ),
    'group'      => $group_counter_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_counter_adv_setup_above_and_below,
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_counter_std_content_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Content Setup', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions,
    'controls'   => $control_list_counter_std_content_setup,
  ),
);

$control_group_counter_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_counter_std_design_setup,
  ),
);

$control_group_counter_std_design_colors = array_merge(
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Base Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_counter_std_design_colors_base,
    ),
  ),
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Before and After Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_counter_std_design_colors_before_and_after,
    ),
  )
);
