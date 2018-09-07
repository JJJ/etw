<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/STATBAR.PHP
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

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'statbar';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Statbar', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();



// Groups
// =============================================================================

$group_statbar_setup        = $group . ':setup';
$group_statbar_design       = $group . ':design';

$group_statbar_bar          = $group . '_bar';
$group_statbar_bar_setup    = $group_statbar_bar . ':setup';
$group_statbar_bar_design   = $group_statbar_bar . ':design';

$group_statbar_label        = $group . '_label';
$group_statbar_label_setup  = $group_statbar_label . ':setup';
$group_statbar_label_design = $group_statbar_label . ':design';
$group_statbar_label_text   = $group_statbar_label . ':text';



// Conditions
// =============================================================================

$conditions                      = x_module_conditions( $condition );
$conditions_statbar_row          = array( $condition, array( 'key' => 'statbar_direction', 'op' => 'NOT IN', 'value' => array( 'column', 'column-reverse' ) ) );
$conditions_statbar_column       = array( $condition, array( 'key' => 'statbar_direction', 'op' => 'NOT IN', 'value' => array( 'row', 'row-reverse' ) ) );
$conditions_statbar_label        = array( $condition, array( 'statbar_label' => true ) );
$conditions_statbar_label_custom = array( $condition, array( 'statbar_label' => true ), array( 'statbar_label_custom_text' => true ) );



// Options
// =============================================================================

$options_statbar_base_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
    'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
  ),
);

$options_statbar_direction = array(
  'choices' => array(
    array( 'value' => 'column-reverse', 'label' => __( 'Up', '__x__' )    ),
    array( 'value' => 'column',         'label' => __( 'Down', '__x__' )  ),
    array( 'value' => 'row-reverse',    'label' => __( 'Left', '__x__' )  ),
    array( 'value' => 'row',            'label' => __( 'Right', '__x__' ) ),
  ),
);

$options_statbar_width_and_height = array(
  'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
  'fallback_value'  => 'auto',
  'valid_keywords'  => array( 'auto', 'calc' ),
  'ranges'          => array(
    'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
    'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
    'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
    '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    'vw'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    'vh'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
  ),
);

$options_statbar_max_width_and_height = array(
  'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
  'fallback_value'  => 'none',
  'valid_keywords'  => array( 'none', 'calc' ),
  'ranges'          => array(
    'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
    'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
    'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
    '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    'vw'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    'vh'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
  ),
);

$options_statbar_offset_trigger = array(
  'available_units' => array( '%' ),
  'fallback_value'  => '75%',
  'ranges'          => array(
    '%' => array( 'min' => 0, 'max' => 100, 'step' => 1 ),
  ),
);

$options_statbar_bar_width = array(
  'available_units' => array( '%' ),
  'fallback_value'  => '90%',
  'ranges'          => array(
    '%' => array( 'min' => 0, 'max' => 100, 'step' => 1 ),
  ),
);

$options_statbar_label_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
    'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
  ),
);

$options_statbar_label_justify = array(
  'choices' => array(
    array( 'value' => 'flex-start', 'label' => __( 'Start', '__x__' ) ),
    array( 'value' => 'center',     'label' => __( 'Center', '__x__' ) ),
    array( 'value' => 'flex-end',   'label' => __( 'End', '__x__' ) ),
  ),
);

$options_statbar_label_width_and_height = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'auto', 'calc' ),
  'fallback_value'  => 'auto',
  'ranges'          => array(
    'px'  => array( 'min' => 25,  'max' => 50, 'step' => 1    ),
    'em'  => array( 'min' => 1.5, 'max' => 5,  'step' => 0.25 ),
    'rem' => array( 'min' => 1.5, 'max' => 5,  'step' => 0.25 ),
  ),
);

$options_statbar_label_translate = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '0px',
  'ranges'          => array(
    'px'  => array( 'min' => -50,  'max' => 50,  'step' => 1    ),
    'em'  => array( 'min' => -2.5, 'max' => 2.5, 'step' => 0.25 ),
    'rem' => array( 'min' => -2.5, 'max' => 2.5, 'step' => 0.25 ),
    '%'   => array( 'min' => -100, 'max' => 100, 'step' => 1    ),
  ),
);



// Settings
// =============================================================================

$settings_statbar_design = array(
  'k_pre'     => 'statbar',
  'group'     => $group_statbar_design,
  'condition' => $conditions,
);

$settings_statbar_bar_design = array(
  'k_pre'     => 'statbar_bar',
  'group'     => $group_statbar_bar_design,
  'condition' => $conditions,
);

$settings_statbar_label_design = array(
  'k_pre'     => 'statbar_label',
  'group'     => $group_statbar_label_design,
  'condition' => $conditions_statbar_label,
);

$settings_statbar_label_text = array(
  'k_pre'     => 'statbar_label',
  'group'     => $group_statbar_label_text,
  'condition' => $conditions_statbar_label,
);

$settings_statbar_std_design = array(
  'k_pre'     => 'statbar',
  'group'     => $group_std_design,
  'condition' => $conditions,
);

$settings_statbar_std_bar_design = array(
  'k_pre'     => 'statbar_bar',
  'group'     => $group_std_design,
  'condition' => $conditions,
);

$settings_statbar_std_label_design = array(
  'k_pre'     => 'statbar_label',
  'group'     => $group_std_design,
  'condition' => $conditions_statbar_label,
);



// Individual Controls
// =============================================================================

$control_statbar_base_font_size = array(
  'key'     => 'statbar_base_font_size',
  'type'    => $is_adv ? 'unit' : 'unit-slider',
  'label'   => __( 'Base Font Size', '__x__' ),
  'options' => $options_statbar_base_font_size,
);

$control_statbar_direction = array(
  'key'     => 'statbar_direction',
  'type'    => 'select',
  'label'   => __( 'Direction', '__x__' ),
  'options' => $options_statbar_direction,
);

$control_statbar_base_font_size_and_direction = array(
  'type'     => 'group',
  'label'    => __( 'Font Size &amp; Direction', '__x__' ),
  'controls' => array(
    $control_statbar_base_font_size,
    $control_statbar_direction,
  ),
);

$control_statbar_width_row = array(
  'key'        => 'statbar_width_row',
  'type'       => 'unit',
  'label'      => __( 'Width', '__x__' ),
  'options'    => $options_statbar_width_and_height,
  'conditions' => $conditions_statbar_row,
);

$control_statbar_height_row = array(
  'key'        => 'statbar_height_row',
  'type'       => 'unit',
  'label'      => __( 'Height', '__x__' ),
  'options'    => $options_statbar_width_and_height,
  'conditions' => $conditions_statbar_row,
);

$control_statbar_width_row_and_height_row = array(
  'type'       => 'group',
  'label'      => __( 'Width &amp; Height', '__x__' ),
  'conditions' => $conditions_statbar_row,
  'controls'   => array(
    $control_statbar_width_row,
    $control_statbar_height_row,
  ),
);

$control_statbar_max_width_row = array(
  'key'        => 'statbar_max_width_row',
  'type'       => 'unit',
  'label'      => __( 'Max Width', '__x__' ),
  'options'    => $options_statbar_max_width_and_height,
  'conditions' => $conditions_statbar_row,
);

$control_statbar_max_height_row = array(
  'key'        => 'statbar_max_height_row',
  'type'       => 'unit',
  'label'      => __( 'Max Height', '__x__' ),
  'options'    => $options_statbar_max_width_and_height,
  'conditions' => $conditions_statbar_row,
);

$control_statbar_max_width_row_and_max_height_row = array(
  'type'       => 'group',
  'label'      => __( 'Max Width &amp; Height', '__x__' ),
  'conditions' => $conditions_statbar_row,
  'controls'   => array(
    $control_statbar_max_width_row,
    $control_statbar_max_height_row,
  ),
);

$control_statbar_width_column = array(
  'key'        => 'statbar_width_column',
  'type'       => 'unit',
  'label'      => __( 'Width', '__x__' ),
  'options'    => $options_statbar_width_and_height,
  'conditions' => $conditions_statbar_column,
);

$control_statbar_height_column = array(
  'key'        => 'statbar_height_column',
  'type'       => 'unit',
  'label'      => __( 'Height', '__x__' ),
  'options'    => $options_statbar_width_and_height,
  'conditions' => $conditions_statbar_column,
);

$control_statbar_width_column_and_height_column = array(
  'type'       => 'group',
  'label'      => __( 'Width &amp; Height', '__x__' ),
  'conditions' => $conditions_statbar_column,
  'controls'   => array(
    $control_statbar_width_column,
    $control_statbar_height_column,
  ),
);

$control_statbar_max_width_column = array(
  'key'        => 'statbar_max_width_column',
  'type'       => 'unit',
  'label'      => __( 'Max Width', '__x__' ),
  'options'    => $options_statbar_max_width_and_height,
  'conditions' => $conditions_statbar_column,
);

$control_statbar_max_height_column = array(
  'key'        => 'statbar_max_height_column',
  'type'       => 'unit',
  'label'      => __( 'Max Height', '__x__' ),
  'options'    => $options_statbar_max_width_and_height,
  'conditions' => $conditions_statbar_column,
);

$control_statbar_max_width_column_and_max_height_column = array(
  'type'       => 'group',
  'label'      => __( 'Max Width &amp; Height', '__x__' ),
  'conditions' => $conditions_statbar_column,
  'controls'   => array(
    $control_statbar_max_width_column,
    $control_statbar_max_height_column,
  ),
);

$control_statbar_trigger_offset = array(
  'key'     => 'statbar_trigger_offset',
  'type'    => 'unit-slider',
  'label'   => __( 'Offset Trigger', '__x__' ),
  'options' => $options_statbar_offset_trigger,
);

$control_statbar_bg_color = array(
  'keys'  => array( 'value' => 'statbar_bg_color' ),
  'type'  => 'color',
  'label' => __( 'Background', '__x__' ),
);

$control_statbar_bar_length = array(
  'key'     => 'statbar_bar_length',
  'type'    => 'unit-slider',
  'label'   => $is_adv ? __( 'Length', '__x__' ) : __( 'Bar<br>Length', '__x__' ),
  'options' => $options_statbar_bar_width,
);

$control_statbar_bar_bg_color = array(
  'keys'  => array( 'value' => 'statbar_bar_bg_color' ),
  'type'  => 'color',
  'label' => __( 'Background', '__x__' ),
);

$control_statbar_label = array(
  'key'     => 'statbar_label',
  'type'    => 'choose',
  'label'   => __( 'Enable', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_statbar_label_options = array(
  'keys' => array(
    'label_custom_text' => 'statbar_label_custom_text',
    'label_always_show' => 'statbar_label_always_show',
  ),
  'type'    => 'checkbox-list',
  'label'   => $is_adv ? __( 'Options', '__x__' ) : __( 'Label', '__x__' ),
  'options' => array(
    'list' => array(
      array( 'key' => 'label_custom_text', 'label' => __( 'Custom Text', '__x__' ), 'half' => true ),
      array( 'key' => 'label_always_show', 'label' => __( 'Always Show', '__x__' ), 'half' => true ),
    ),
  ),
);

$control_statbar_label_text_content = array(
  'key'        => 'statbar_label_text_content',
  'type'       => 'text',
  'label'      => __( 'Content', '__x__' ),
  'conditions' => $conditions_statbar_label_custom,
);

$control_statbar_label_justify = array(
  'key'        => 'statbar_label_justify',
  'type'       => 'choose',
  'label'      => __( 'Justify', '__x__' ),
  'conditions' => $conditions_statbar_label,
  'options'    => $options_statbar_label_justify,
);

$control_statbar_label_bg_color = array(
  'key'        => 'statbar_label_bg_color',
  'type'       => 'color',
  'label'      => __( 'Background', '__x__' ),
  'conditions' => $conditions_statbar_label,
);

$control_statbar_label_width = array(
  'key'     => 'statbar_label_width',
  'type'    => $is_adv ? 'unit-slider' : 'unit',
  'label'   => $is_adv ? __( 'Width', '__x__' ) : __( 'Label<br>Width', '__x__' ),
  'options' => $options_statbar_label_width_and_height,
);

$control_statbar_label_height = array(
  'key'     => 'statbar_label_height',
  'type'    => $is_adv ? 'unit-slider' : 'unit',
  'label'   => $is_adv ? __( 'Height', '__x__' ) : __( 'Label<br>Height', '__x__' ),
  'options' => $options_statbar_label_width_and_height,
);

$control_statbar_label_width_and_height = array(
  'type'     => 'group',
  'label'    => __( 'Label Width &amp; Height', '__x__' ),
  'controls' => array(
    $control_statbar_label_width,
    $control_statbar_label_height,
  ),
);

$control_statbar_label_translate_x = array(
  'key'     => 'statbar_label_translate_x',
  'type'    => 'unit-slider',
  'label'   => $is_adv ? __( 'Translate<br>X Axis', '__x__' ) : __( 'Label X Axis<br>Translate', '__x__' ),
  'options' => $options_statbar_label_translate,
);

$control_statbar_label_translate_y = array(
  'key'     => 'statbar_label_translate_y',
  'type'    => 'unit-slider',
  'label'   => $is_adv ? __( 'Translate<br>Y Axis', '__x__' ) : __( 'Label Y Axis<br>Translate', '__x__' ),
  'options' => $options_statbar_label_translate,
);



// Control Lists
// =============================================================================

// Advanced
// --------

$control_list_statbar_adv_setup = array(
  $control_statbar_base_font_size_and_direction,
  $control_statbar_width_row_and_height_row,
  $control_statbar_max_width_row_and_max_height_row,
  $control_statbar_width_column_and_height_column,
  $control_statbar_max_width_column_and_max_height_column,
  $control_statbar_trigger_offset,
  $control_statbar_bg_color,
);

$control_list_statbar_adv_setup_bar = array(
  $control_statbar_bar_length,
  $control_statbar_bar_bg_color,
);

$control_list_statbar_adv_setup_label = array(
  $control_statbar_label,
  $control_statbar_label_options,
  $control_statbar_label_text_content,
  $control_statbar_label_justify,
  $control_statbar_label_bg_color
);

$control_list_statbar_adv_label_dimensions_and_position = array(
  $control_statbar_label_width,
  $control_statbar_label_height,
  $control_statbar_label_translate_x,
  $control_statbar_label_translate_y,
);


// Standard
// --------

$control_list_statbar_std_content_setup = array(
  $control_statbar_label_options,
  $control_statbar_label_text_content,
);

$control_list_statbar_std_design_setup = array(
  $control_statbar_base_font_size,
  $control_statbar_direction,
  $control_statbar_width_row_and_height_row,
  $control_statbar_max_width_row_and_max_height_row,
  $control_statbar_width_column_and_height_column,
  $control_statbar_max_width_column_and_max_height_column,
  $control_statbar_trigger_offset,
);

$control_list_statbar_std_design_setup_bar_and_label = array(
  $control_statbar_bar_length,
  array(
    'key'     => 'statbar_label_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Label<br>Font Size', '__x__' ),
    'options' => $options_statbar_label_font_size,
  ),
  $control_statbar_label_width_and_height,
  $control_statbar_label_translate_x,
  $control_statbar_label_translate_y,
);

$control_list_statbar_std_design_colors_base = array(
  array(
    'keys'      => array( 'value' => 'statbar_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'statbar_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_statbar_bg_color,
);

$control_list_statbar_std_design_colors_bar = array(
  array(
    'keys'      => array( 'value' => 'statbar_bar_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'statbar_bar_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_statbar_bar_bg_color,
);

$control_list_statbar_std_design_colors_label = array(
  array(
    'keys'  => array( 'value' => 'statbar_label_text_color' ),
    'type'  => 'color',
    'label' => __( 'Text', '__x__' ),
  ),
  array(
    'keys'      => array( 'value' => 'statbar_label_text_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Text<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'statbar_label_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  array(
    'keys'      => array( 'value' => 'statbar_label_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'statbar_label_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_statbar_label_bg_color,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_statbar_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_statbar_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_statbar_adv_setup,
  ),
);

$control_group_statbar_adv_setup_bar = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Bar Setup', '__x__' ),
    'group'      => $group_statbar_bar_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_statbar_adv_setup_bar,
  ),
);

$control_group_statbar_adv_setup_label = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Label Setup', '__x__' ),
    'group'      => $group_statbar_label_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_statbar_adv_setup_label,
  ),
);

$control_group_statbar_adv_label_dimensions_and_position = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Label Dimensions &amp; Position', '__x__' ),
    'group'      => $group_statbar_label_setup,
    'conditions' => $conditions_statbar_label,
    'controls'   => $control_list_statbar_adv_label_dimensions_and_position,
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_statbar_std_content_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Content Setup', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions,
    'controls'   => $control_list_statbar_std_content_setup,
  ),
);

$control_group_statbar_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_statbar_std_design_setup,
  ),
);

$control_group_statbar_std_design_setup_bar_and_label = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Bar and Label Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_statbar_std_design_setup_bar_and_label,
  ),
);

$control_group_statbar_std_design_colors = array_merge(
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Base Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_statbar_std_design_colors_base,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_statbar_std_design,
      array(
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'statbar_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'statbar_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  ),
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Bar Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_statbar_std_design_colors_bar,
    ),
    array(
      'type'       => 'group',
      'title'      => __( 'Label Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_statbar_std_design_colors_label,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_statbar_std_label_design,
      array(
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'statbar_label_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'statbar_label_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  )
);
