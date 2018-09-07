<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/ALERT.PHP
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

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'alert';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Alert', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();



// Groups
// =============================================================================

$group_alert_setup  = $group . ':setup';
$group_alert_close  = $group . ':close';
$group_alert_design = $group . ':design';
$group_alert_text   = $group . ':text';



// Conditions
// =============================================================================

$conditions             = x_module_conditions( $condition );
$conditions_alert_close = array( $condition, array( 'alert_close' => true ) );



// Options
// =============================================================================

$options_alert_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
    'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
  ),
);

$options_alert_width = array(
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

$options_alert_max_width = array(
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

$options_alert_close_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 20, 'step' => 1   ),
    'em'  => array( 'min' => 0.5, 'max' => 2,  'step' => 0.1 ),
    'rem' => array( 'min' => 0.5, 'max' => 2,  'step' => 0.1 ),
  ),
);

$options_alert_close_location = array(
  'choices' => array(
    array( 'value' => 'left',  'label' => __( 'Left', '__x__' ) ),
    array( 'value' => 'right', 'label' => __( 'Right', '__x__' ) ),
  ),
);

$options_alert_close_offset = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 0, 'max' => 50, 'step' => 1   ),
    'em'  => array( 'min' => 0, 'max' => 5,  'step' => 0.1 ),
    'rem' => array( 'min' => 0, 'max' => 5,  'step' => 0.1 ),
  ),
);



// Settings
// =============================================================================

$settings_alert_design = array(
  'k_pre'     => 'alert',
  'group'     => $group_alert_design,
  'condition' => $conditions,
);

$settings_alert_text = array(
  'k_pre'     => 'alert',
  'group'     => $group_alert_text,
  'condition' => $conditions,
);

$settings_alert_std_design = array(
  'k_pre'     => 'alert',
  'group'     => $group_std_design,
  'condition' => $conditions,
);



// Individual Controls
// =============================================================================

$control_alert_close = array(
  'key'     => 'alert_close',
  'type'    => 'choose',
  'label'   => __( 'Close', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_alert_width = array(
  'key'     => 'alert_width',
  'type'    => $is_adv ? 'unit' : 'unit-slider',
  'label'   => __( 'Width', '__x__' ),
  'options' => $options_alert_width,
);

$control_alert_max_width = array(
  'key'     => 'alert_max_width',
  'type'    => $is_adv ? 'unit' : 'unit-slider',
  'label'   => __( 'Max Width', '__x__' ),
  'options' => $options_alert_max_width,
);

$control_alert_width_and_max_width = array(
  'type'     => 'group',
  'label'    => __( 'Width &amp; Max Width', '__x__' ),
  'controls' => array(
    $control_alert_width,
    $control_alert_max_width
  ),
);

$control_alert_content = array(
  'key'     => 'alert_content',
  'type'    => 'text-editor',
  'label'   => __( 'Content', '__x__' ),
  'options' => array(
    'mode'   => 'html',
    'height' => $is_adv ? 2 : 5,
  ),
);

$control_alert_bg_color = array(
  'keys'  => array( 'value' => 'alert_bg_color' ),
  'type'  => 'color',
  'label' => __( 'Background', '__x__' ),
);

$control_alert_close_font_size = array(
  'key'     => 'alert_close_font_size',
  'type'    => 'unit-slider',
  'label'   => __( 'Font Size', '__x__' ),
  'options' => $options_alert_close_font_size,
);

$control_alert_close_location = array(
  'key'     => 'alert_close_location',
  'type'    => 'choose',
  'label'   => __( 'Location', '__x__' ),
  'options' => $options_alert_close_location,
);

$control_alert_close_offset_top = array(
  'key'     => 'alert_close_offset_top',
  'type'    => 'unit-slider',
  'label'   => __( 'Offset Top', '__x__' ),
  'options' => $options_alert_close_offset,
);

$control_alert_close_offset_side = array(
  'key'     => 'alert_close_offset_side',
  'type'    => 'unit-slider',
  'label'   => __( 'Offset Side', '__x__' ),
  'options' => $options_alert_close_offset,
);

$control_alert_close_colors = array(
  'keys' => array(
    'value' => 'alert_close_color',
    'alt'   => 'alert_close_color_alt',
  ),
  'type'       => 'color',
  'label'      => $is_adv ? __( 'Color', '__x__' ) : __( 'Close', '__x__' ),
  'options'    => $options_base_interaction_labels,
  'conditions' => $conditions_alert_close,
);



// Control Lists
// =============================================================================

// Advanced
// --------

$control_list_alert_adv_setup = array(
  $control_alert_close,
  $control_alert_width_and_max_width,
  $control_alert_content,
  $control_alert_bg_color
);

$control_list_alert_adv_close_setup = array(
  $control_alert_close_font_size,
  $control_alert_close_location,
  $control_alert_close_offset_top,
  $control_alert_close_offset_side,
  $control_alert_close_colors,
);


// Standard
// --------

$control_list_alert_std_content_setup = array(
  $control_alert_content,
);

$control_list_alert_std_design_setup = array(
  array(
    'key'     => 'alert_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Font Size', '__x__' ),
    'options' => $options_alert_font_size,
  ),
  $control_alert_width,
  $control_alert_max_width,
  array(
    'key'   => 'alert_text_align',
    'type'  => 'text-align',
    'label' => __( 'Text Align', '__x__' ),
  ),
);

$control_list_alert_std_design_colors_base = array(
  array(
    'keys'  => array( 'value' => 'alert_text_color' ),
    'type'  => 'color',
    'label' => __( 'Text', '__x__' ),
  ),
  array(
    'keys'      => array( 'value' => 'alert_text_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Text<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'alert_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  array(
    'keys'      => array( 'value' => 'alert_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'alert_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_alert_close_colors,
  $control_alert_bg_color,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_alert_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_alert_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_alert_adv_setup,
  ),
);

$control_group_alert_adv_close_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Close Setup', '__x__' ),
    'group'      => $group_alert_close,
    'conditions' => $conditions_alert_close,
    'controls'   => $control_list_alert_adv_close_setup,
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_alert_std_content_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Content Setup', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions,
    'controls'   => $control_list_alert_std_content_setup,
  ),
);

$control_group_alert_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_alert_std_design_setup,
  ),
);

$control_group_alert_std_design_colors = array_merge(
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Base Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_alert_std_design_colors_base,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_alert_std_design,
      array(
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'alert_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'alert_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  )
);
