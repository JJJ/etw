<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/QUOTE.PHP
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

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'quote';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Quote', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();



// Groups
// =============================================================================

$group_quote_content       = $group . ':content';
$group_quote_setup         = $group . ':setup';
$group_quote_design        = $group . ':design';
$group_quote_text          = $group . ':text';
$group_quote_base_marks    = $group . ':marks';

$group_quote_marks         = $group . '_marks';
$group_quote_marks_setup   = $group_quote_marks . ':setup';
$group_quote_marks_opening = $group_quote_marks . ':opening';
$group_quote_marks_closing = $group_quote_marks . ':closing';

$group_quote_cite          = $group . '_cite';
$group_quote_cite_setup    = $group_quote_cite . ':setup';
$group_quote_cite_design   = $group_quote_cite . ':design';
$group_quote_cite_text     = $group_quote_cite . ':text';
$group_quote_cite_graphic  = $group_quote_cite . ':graphic';



// Conditions
// =============================================================================

$conditions      = x_module_conditions( $condition );
$conditions_cite = array( $condition, array( 'key' => 'quote_cite_content', 'op' => 'NOT IN', 'value' => array( '' ) ) );



// Options
// =============================================================================

$options_quote_content = array(
  'height' => 4,
);

$options_quote_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
    'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
  ),
);

$options_quote_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'fallback_value'  => 'auto',
  'valid_keywords'  => array( 'auto', 'calc' ),
  'ranges'          => array(
    'px'  => array( 'min' => 250, 'max' => 1000, 'step' => 25 ),
    'em'  => array( 'min' => 10,  'max' => 50,   'step' => 1  ),
    'rem' => array( 'min' => 10,  'max' => 50,   'step' => 1  ),
    '%'   => array( 'min' => 50,  'max' => 100,  'step' => 1  ),
  ),
);

$options_quote_max_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'fallback_value'  => 'none',
  'valid_keywords'  => array( 'none', 'calc' ),
  'ranges'          => array(
    'px'  => array( 'min' => 250, 'max' => 1000, 'step' => 25 ),
    'em'  => array( 'min' => 10,  'max' => 50,   'step' => 1  ),
    'rem' => array( 'min' => 10,  'max' => 50,   'step' => 1  ),
    '%'   => array( 'min' => 50,  'max' => 100,  'step' => 1  ),
  ),
);

$options_quote_marks_graphic_direction = array(
  'choices' => array(
    array( 'value' => 'row',    'label' => __( 'Row', '__x__' )    ),
    array( 'value' => 'column', 'label' => __( 'Column', '__x__' ) ),
  ),
);

$options_quote_marks_graphic_align = array(
  'choices' => array(
    array( 'value' => 'flex-start', 'label' => __( 'Start', '__x__' )  ),
    array( 'value' => 'center',     'label' => __( 'Center', '__x__' ) ),
    array( 'value' => 'flex-end',   'label' => __( 'End', '__x__' )    ),
  ),
);

$options_quote_cite_position = array(
  'choices' => array(
    array( 'value' => 'before', 'label' => __( 'Before', '__x__' ) ),
    array( 'value' => 'after',  'label' => __( 'After', '__x__' )  ),
  ),
);



// Settings
// =============================================================================

$settings_quote = array(
  'k_pre'     => 'quote',
  'group'     => $group_quote_design,
  'condition' => $conditions,
);

$settings_quote_text = array(
  'k_pre'     => 'quote_text',
  'group'     => $group_quote_text,
  'condition' => $conditions,
);

$settings_quote_mark_opening = array(
  't_pre'               => __( 'Opening', '__x__' ),
  'k_pre'               => 'quote_marks_opening',
  'has_alt'             => false,
  'has_interactions'    => false,
  'has_sourced_content' => false,
  'has_toggle'          => false,
  'group'               => $group_quote_marks_opening,
  'theme'               => array(
    'graphic_margin'         => x_module_value( '0em 1em 0em 0em', 'style' ),
    'graphic_icon_font_size' => x_module_value( '1em', 'style' ),
    'graphic_icon'           => x_module_value( 'quote-left', 'markup' ),
  ),
);

$settings_quote_mark_closing = array(
  't_pre'               => __( 'Closing', '__x__' ),
  'k_pre'               => 'quote_marks_closing',
  'has_alt'             => false,
  'has_interactions'    => false,
  'has_sourced_content' => false,
  'has_toggle'          => false,
  'group'               => $group_quote_marks_closing,
  'theme'               => array(
    'graphic_margin'         => x_module_value( '0em 0em 0em 1em', 'style' ),
    'graphic_icon_font_size' => x_module_value( '1em', 'style' ),
    'graphic_icon'           => x_module_value( 'quote-right', 'markup' ),
  ),
);

$settings_quote_cite_setup = array(
  'k_pre'     => 'quote_cite',
  'group'     => $group_quote_cite_setup,
  'condition' => $conditions_cite,
);

$settings_quote_cite_design = array(
  'k_pre'     => 'quote_cite',
  'group'     => $group_quote_cite_design,
  'condition' => $conditions_cite,
);

$settings_quote_cite_text = array(
  'k_pre'     => 'quote_cite',
  'group'     => $group_quote_cite_text,
  'condition' => $conditions_cite,
);

$settings_quote_cite_graphic = array(
  't_pre'               => $is_adv ? '' : __( 'Citation', '__x__' ),
  'k_pre'               => 'quote_cite',
  'has_alt'             => false,
  'has_interactions'    => false,
  'has_sourced_content' => false,
  'has_toggle'          => false,
  'group'               => $group_quote_cite_graphic,
  'theme'               => array(
    'graphic_margin'         => x_module_value( '0em 0.5em 0em 0em', 'style' ),
    'graphic_icon_font_size' => x_module_value( '1em', 'style' ),
    'graphic_icon'           => x_module_value( 'angle-right', 'markup' ),
  ),
);

$settings_quote_std_design = array(
  'k_pre'     => 'quote',
  'group'     => $group_std_design,
  'condition' => $conditions,
);

$settings_quote_std_cite_design = array(
  'k_pre'     => 'quote_cite',
  'group'     => $group_std_design,
  'condition' => $conditions_cite,
);



// Individual Controls
// =============================================================================

$control_quote_content = array(
  'key'     => 'quote_content',
  'type'    => 'text-editor',
  'label'   => __( 'Quote', '__x__' ),
  'options' => $options_quote_content,
);

$control_quote_cite_content = array(
  'key'   => 'quote_cite_content',
  'type'  => 'text',
  'label' => __( 'Citation', '__x__' ),
);

$control_quote_base_font_size = array(
  'key'     => 'quote_base_font_size',
  'type'    => 'unit-slider',
  'label'   => __( 'Base Font Size', '__x__' ),
  'options' => $options_quote_font_size,
);

$control_quote_width = array(
  'key'     => 'quote_width',
  'type'    => 'unit-slider',
  'label'   => __( 'Width', '__x__' ),
  'options' => $options_quote_width,
);

$control_quote_max_width = array(
  'key'     => 'quote_max_width',
  'type'    => 'unit-slider',
  'label'   => __( 'Max Width', '__x__' ),
  'options' => $options_quote_max_width,
);

$control_quote_bg_color = array(
  'keys'  => array( 'value' => 'quote_bg_color' ),
  'type'  => 'color',
  'title' => __( 'Background', '__x__' ),
);

$control_quote_marks_graphic_direction = array(
  'key'     => 'quote_marks_graphic_direction',
  'type'    => 'choose',
  'label'   => __( 'Direction', '__x__' ),
  'options' => $options_quote_marks_graphic_direction,
);

$control_quote_marks_graphic_opening_align = array(
  'key'     => 'quote_marks_graphic_opening_align',
  'type'    => 'choose',
  'label'   => __( 'Opening Mark Align', '__x__' ),
  'options' => $options_quote_marks_graphic_align,
);

$control_quote_marks_graphic_closing_align = array(
  'key'     => 'quote_marks_graphic_closing_align',
  'type'    => 'choose',
  'label'   => __( 'Closing Mark Align', '__x__' ),
  'options' => $options_quote_marks_graphic_align,
);

$control_quote_cite_position = array(
  'key'     => 'quote_cite_position',
  'type'    => 'choose',
  'label'   => __( 'Citation Position', '__x__' ),
  'options' => $options_quote_cite_position,
);

$control_quote_cite_bg_color = array(
  'keys'  => array( 'value' => 'quote_cite_bg_color' ),
  'type'  => 'color',
  'title' => __( 'Background', '__x__' ),
);



// Control Lists
// =============================================================================

// Advanced
// --------

$control_list_quote_adv_content = array(
  $control_quote_content,
  $control_quote_cite_content,
);

$control_list_quote_adv_setup = array(
  $control_quote_base_font_size,
  $control_quote_width,
  $control_quote_max_width,
  $control_quote_bg_color,
);

$control_list_quote_adv_marks_setup = array(
  $control_quote_marks_graphic_direction,
  $control_quote_marks_graphic_opening_align,
  $control_quote_marks_graphic_closing_align,
);

$control_list_quote_adv_cite_setup = array(
  $control_quote_cite_position,
  $control_quote_cite_bg_color,
);


// Standard
// --------

$control_list_quote_std_content_setup = array(
  $control_quote_content,
  $control_quote_cite_content,
);

$control_list_quote_std_design_setup = array(
  $control_quote_base_font_size,
  $control_quote_width,
  $control_quote_max_width,
  array(
    'key'   => 'quote_text_text_align',
    'type'  => 'text-align',
    'label' => __( 'Quote Text Align', '__x__' ),
  ),
  array(
    'key'        => 'quote_cite_text_align',
    'type'       => 'text-align',
    'label'      => __( 'Citation Text Align', '__x__' ),
    'conditions' => $conditions_cite,
  ),
);

$control_list_quote_std_design_colors_base = array(
  array(
    'keys'  => array( 'value' => 'quote_text_text_color' ),
    'type'  => 'color',
    'title' => __( 'Text', '__x__' ),
  ),
  array(
    'keys'      => array( 'value' => 'quote_text_text_shadow_color' ),
    'type'      => 'color',
    'title'     => __( 'Text<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'quote_text_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  array(
    'keys'      => array( 'value' => 'quote_box_shadow_color' ),
    'type'      => 'color',
    'title'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'quote_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_quote_bg_color,
);

$control_list_quote_std_design_colors_cite = array(
  array(
    'keys'  => array( 'value' => 'quote_cite_text_color' ),
    'type'  => 'color',
    'title' => __( 'Text', '__x__' ),
  ),
  array(
    'keys'      => array( 'value' => 'quote_cite_text_shadow_color' ),
    'type'      => 'color',
    'title'     => __( 'Text<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'quote_cite_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  array(
    'keys'      => array( 'value' => 'quote_cite_box_shadow_color' ),
    'type'      => 'color',
    'title'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'quote_cite_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_quote_cite_bg_color,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_quote_adv_content = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Content', '__x__' ),
    'group'      => $group_quote_content,
    'conditions' => $conditions,
    'controls'   => $control_list_quote_adv_content,
  ),
);

$control_group_quote_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_quote_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_quote_adv_setup,
  ),
);

$control_group_quote_adv_marks_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Marks Setup', '__x__' ),
    'group'      => $group_quote_marks_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_quote_adv_marks_setup,
  ),
);

$control_group_quote_adv_cite_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_quote_cite_setup,
    'conditions' => $conditions_cite,
    'controls'   => $control_list_quote_adv_cite_setup,
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_quote_std_content_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Content Setup', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions,
    'controls'   => $control_list_quote_std_content_setup,
  ),
);

$control_group_quote_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_quote_std_design_setup,
  ),
);

$control_group_quote_std_design_colors_base = array_merge(
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Colors Base', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_quote_std_design_colors_base,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_quote_std_design,
      array(
        't_pre'     => __( 'Quote', '__x__' ),
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'quote_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'quote_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  )
);

$control_group_quote_std_design_colors_cite = array_merge(
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Colors Citation', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_quote_std_design_colors_cite,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_quote_std_cite_design,
      array(
        't_pre'     => __( 'Citation', '__x__' ),
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'quote_cite_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'quote_cite_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  )
);