<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/_TEXT.PHP
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
//   05. Settings
//   06. Options
//   07. Individual Controls
//   08. Control Lists
//   09. Control Groups (Advanced)
//   10. Control Groups (Standard Content)
//   11. Control Groups (Standard Design)
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================
// 01. Available types:
//     -- 'standard'
//     -- 'headline'

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'text';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Text', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();
$type        = ( isset( $settings['type'] )        ) ? $settings['type']        : 'standard'; // 01



// Groups
// =============================================================================

$group_text_setup   = $group . ':setup';
$group_text_design  = $group . ':design';
$group_text_graphic = $group . ':graphic';
$group_text_text    = $group . ':text';



// Conditions
// =============================================================================

$conditions                  = x_module_conditions( $condition );
$conditions_text_columns     = array( $condition, array( 'text_type' => 'standard' ), array( 'text_columns' => true ) );
$conditions_text_typing_on   = array( $condition, array( 'text_type' => 'headline' ), array( 'text_typing' => true ) );
$conditions_text_typing_off  = array( $condition, array( 'text_type' => 'headline' ), array( 'text_typing' => false ) );
$conditions_text_subheadline = array( $condition, array( 'text_type' => 'headline' ), array( 'text_subheadline' => true ) );


// Settings
// =============================================================================

$settings_text_design = array(
  'k_pre'     => 'text',
  'group'     => $group_text_design,
  'condition' => $conditions,
);

$settings_text_text = array(
  'k_pre'     => 'text',
  'group'     => $group_text_text,
  'condition' => $conditions,
);

$settings_text_flex_layout = array(
  'k_pre'     => 'text',
  't_pre'     => __( 'Text Content', '__x__' ),
  'group'     => $group_text_design,
  'condition' => $conditions,
);

$settings_text_content_margin = array(
  'k_pre'     => 'text_content',
  't_pre'     => __( 'Text Content', '__x__' ),
  'group'     => $group_text_text,
  'condition' => $conditions,
);

$settings_text_subheadline_text = array(
  'k_pre'     => 'text_subheadline',
  't_pre'     => __( 'Subheadline', '__x__' ),
  'group'     => $group_text_text,
  'condition' => $conditions_text_subheadline,
);

$settings_text_std_design = array(
  'k_pre'     => 'text',
  'group'     => $group_std_design,
  'condition' => $conditions,
);

$settings_text_graphic_adv = array(
  'k_pre'               => 'text',
  'group'               => $group_text_graphic,
  'condition'           => $conditions,
  'has_alt'             => false,
  'has_interactions'    => false,
  'has_sourced_content' => false,
  'has_toggle'          => false,
  'adv'                 => $is_adv
);

$settings_text_graphic_std_content = array(
  'k_pre'               => 'text',
  'group'               => $group_std_content,
  'condition'           => $conditions,
  'has_alt'             => false,
  'has_interactions'    => false,
  'has_sourced_content' => false,
  'has_toggle'          => false,
);

$settings_text_graphic_std_design = array(
  'k_pre'               => 'text',
  'group'               => $group_std_design,
  'condition'           => $conditions,
  'has_alt'             => false,
  'has_interactions'    => false,
  'has_sourced_content' => false,
  'has_toggle'          => false,
);



// Options
// =============================================================================

$options_text_tags = array(
  'choices' => array(
    array( 'value' => 'p',    'label' => 'p' ),
    array( 'value' => 'h1',   'label' => 'h1' ),
    array( 'value' => 'h2',   'label' => 'h2' ),
    array( 'value' => 'h3',   'label' => 'h3' ),
    array( 'value' => 'h4',   'label' => 'h4' ),
    array( 'value' => 'h5',   'label' => 'h5' ),
    array( 'value' => 'h6',   'label' => 'h6' ),
    array( 'value' => 'div',  'label' => 'div' ),
    array( 'value' => 'span', 'label' => 'span' ),
  ),
);

$options_text_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
    'em'  => array( 'min' => 0, 'max' => 5,   'step' => 0.05 ),
    'rem' => array( 'min' => 0, 'max' => 5,   'step' => 0.05 ),
  ),
);

$options_text_base_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 14,  'max' => 64, 'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 5,  'step' => 0.05 ),
    'rem' => array( 'min' => 0.5, 'max' => 5,  'step' => 0.05 ),
  ),
);

$options_text_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'valid_keywords'  => array( 'auto' ),
  'fallback_value'  => 'auto',
  'ranges'          => array(
    'px'  => array( 'min' => 250, 'max' => 1000, 'step' => 10  ),
    'em'  => array( 'min' => 10,  'max' => 50,   'step' => 0.5 ),
    'rem' => array( 'min' => 10,  'max' => 50,   'step' => 0.5 ),
    '%'   => array( 'min' => 50,  'max' => 100,  'step' => 1   ),
  ),
);

$options_text_max_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'valid_keywords'  => array( 'none' ),
  'fallback_value'  => 'none',
  'ranges'          => array(
    'px'  => array( 'min' => 250, 'max' => 1000, 'step' => 10  ),
    'em'  => array( 'min' => 10,  'max' => 50,   'step' => 0.5 ),
    'rem' => array( 'min' => 10,  'max' => 50,   'step' => 0.5 ),
    '%'   => array( 'min' => 50,  'max' => 100,  'step' => 1   ),
  ),
);

$options_typing_effect_time_controls = array(
  'unit_mode'       => 'time',
  'available_units' => array( 's', 'ms' ),
  'fallback_value'  => '0ms',
  'ranges'          => array(
    's'  => array( 'min' => 0, 'max' => 5,    'step' => 0.1 ),
    'ms' => array( 'min' => 0, 'max' => 5000, 'step' => 100 ),
  ),
);

$options_text_columns_break_inside = array(
  'choices' => array(
    array( 'value' => 'auto',  'label' => __( 'Auto', '__x__' )  ),
    array( 'value' => 'avoid', 'label' => __( 'Avoid', '__x__' ) ),
  ),
);

$options_text_columns_count = array(
  'unit_mode'      => 'unitless',
  'fallback_value' => 2,
  'min'            => 2,
  'max'            => 5,
  'step'           => 1,
);

$options_text_columns_width = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '250px',
);

$options_text_columns_gap = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '25px',
);

$options_text_columns_rule_style = array(
  'choices' => array(
    array( 'value' => 'none',   'label' => __( 'None', '__x__' ) ),
    array( 'value' => 'solid',  'label' => __( 'Solid', '__x__' ) ),
    array( 'value' => 'dotted', 'label' => __( 'Dotted', '__x__' ) ),
    array( 'value' => 'dashed', 'label' => __( 'Dashed', '__x__' ) ),
    array( 'value' => 'double', 'label' => __( 'Double', '__x__' ) ),
    array( 'value' => 'groove', 'label' => __( 'Groove', '__x__' ) ),
    array( 'value' => 'ridge',  'label' => __( 'Ridge', '__x__' ) ),
    array( 'value' => 'inset',  'label' => __( 'Inset', '__x__' ) ),
    array( 'value' => 'outset', 'label' => __( 'Outset', '__x__' ) ),
  ),
);

$options_text_columns_rule_width = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '0px',
);

$options_text_subheadline_spacing = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'fallback_value'  => '5px',
);



// Individual Controls
// =============================================================================

$control_text_content_standard = array(
  'key'     => 'text_content',
  'type'    => 'text-editor',
  'title'   => __( 'Text', '__x__' ),
  'options' => array(
    'height' => 1,//$is_adv ? 1 : 5,
    'disable_input_preview' => true
  ),
);

$control_text_content_headline = array(
  'key'        => 'text_content',
  'type'       => 'text-editor',
  'title'      => __( 'Text', '__x__' ),
  'conditions' => $conditions_text_typing_off,
  'options'    => array(
    'height' => 1,//$is_adv ? 1 : 4,
    'mode'   => 'html',
    'disable_input_preview' => true
  ),
);

$control_text_font_size = array(
  'key'     => 'text_font_size',
  'type'    => 'unit-slider',
  'label'   => __( 'Font Size', '__x__' ),
  'options' => $options_text_font_size,
);

$control_text_base_font_size = array(
  'key'     => 'text_base_font_size',
  'type'    => $is_adv ? 'unit' : 'unit-slider',
  'label'   => __( 'Base Font Size', '__x__' ),
  'options' => $options_text_base_font_size,
);

$control_text_tag = array(
  'key'     => 'text_tag',
  'type'    => 'select',
  'label'   => __( 'Tag', '__x__' ),
  'options' => $options_text_tags,
);

$control_text_overflow_and_text_typing = array(
  'keys' => array(
    'text_overflow' => 'text_overflow',
    'text_typing'   => 'text_typing',
  ),
  'type'    => 'checkbox-list',
  'label'   => __( 'Enable', '__x__' ),
  'options' => array(
    'list' => array(
      array( 'key' => 'text_overflow', 'label' => __( 'Overflow', '__x__' ), 'half' => true ),
      array( 'key' => 'text_typing',   'label' => __( 'Typing', '__x__' ),   'half' => true ),
    ),
  ),
);

$control_text_width = array(
  'key'     => 'text_width',
  'type'    => $is_adv ? 'unit' : 'unit-slider',
  'label'   => __( 'Width', '__x__' ),
  'options' => $options_text_width,
);

$control_text_max_width = array(
  'key'     => 'text_max_width',
  'type'    => $is_adv ? 'unit' : 'unit-slider',
  'label'   => __( 'Max Width', '__x__' ),
  'options' => $options_text_max_width,
);

$control_text_width_and_max_width = array(
  'type'     => 'group',
  'label'    => __( 'Width &amp; Max Width', '__x__' ),
  'controls' => array(
    $control_text_width,
    $control_text_max_width,
  ),
);

$control_text_columns = array(
  'keys' => array(
    'columns' => 'text_columns',
  ),
  'type'    => 'checkbox-list',
  'label'   => __( 'Text Columns', '__x__' ),
  'options' => array(
    'list' => array(
      array( 'key' => 'columns', 'label' => __( 'Enable', '__x__' ) ),
    ),
  ),
);

$control_text_bg_color = array(
  'key'   => 'text_bg_color',
  'type'  => 'color',
  'label' => __( 'Background', '__x__' ),
);

$control_text_typing_prefix = array(
  'key'        => 'text_typing_prefix',
  'type'       => 'text',
  'label'      => __( 'Prefix', '__x__' ),
  'conditions' => $conditions_text_typing_on,
);

$control_text_typing_content = array(
  'key'        => 'text_typing_content',
  'type'       => 'textarea',
  'label'      => __( 'Typed Text<br>(1 Per Line)', '__x__' ),
  'conditions' => $conditions_text_typing_on,
  'options'    => array(
    'height' => $is_adv ? 3 : 2,
    'mode'   => 'html',
  ),
);

$control_text_typing_suffix = array(
  'key'        => 'text_typing_suffix',
  'type'       => 'text',
  'label'      => __( 'Suffix', '__x__' ),
  'conditions' => $conditions_text_typing_on,
);

$control_text_subheadline = array(
  'key'     => 'text_subheadline',
  'type'    => 'choose',
  'label'   => __( 'Enable', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_text_subheadline_content = array(
  'key'       => 'text_subheadline_content',
  'type'      => 'text-editor',
  'title'     => __( 'Text', '__x__' ),
  'condition' => array( 'text_subheadline' => true ),
  'options'   => array(
    'mode'   => 'html',
    'height' => $is_adv ? 2 : 4,
  ),
);

$control_text_subheadline_tag = array(
  'key'       => 'text_subheadline_tag',
  'type'      => 'select',
  'label'     => __( 'Tag', '__x__' ),
  'condition' => array( 'text_subheadline' => true ),
  'options'   => $options_text_tags,
);

$control_text_subheadline_spacing_and_reverse = array(
  'type'      => 'group',
  'label'     => __( 'Spacing &amp; Order', '__x__' ),
  'condition' => array( 'text_subheadline' => true ),
  'controls'  => array(
    array(
      'key'     => 'text_subheadline_spacing',
      'type'    => 'unit',
      'label'   => __( 'Spacing', '__x__' ),
      'options' => $options_text_subheadline_spacing,
    ),
    array(
      'keys' => array(
        'text_reverse' => 'text_subheadline_reverse',
      ),
      'type'    => 'checkbox-list',
      'label'   => __( 'Order', '__x__' ),
      'options' => array(
        'list' => array(
          array( 'key' => 'text_reverse', 'label' => __( 'Reverse', '__x__' ) ),
        ),
      ),
    ),
  ),
);

$controls_text_graphic_adv               = x_controls_graphic_adv( $settings_text_graphic_adv );
$controls_text_graphic_std_content       = x_controls_graphic_std_content( $settings_text_graphic_std_content );
$controls_text_graphic_std_design_colors = x_controls_graphic_std_design_colors( $settings_text_graphic_std_design );



// Control Lists
// =============================================================================

// Advanced Setup
// --------------

$control_list_text_adv_setup = array();

if ( $type === 'standard' ) {
  $control_list_text_adv_setup[] = $control_text_content_standard;
}

if ( $type === 'headline' ) {
  $control_list_text_adv_setup[] = array(
    'type'     => 'group',
    'label'    => __( 'Base Font Size &amp; Tag', '__x__' ),
    'controls' => array(
      $control_text_base_font_size,
      $control_text_tag,
    ),
  );
  $control_list_text_adv_setup[] = $control_text_overflow_and_text_typing;
  $control_list_text_adv_setup[] = $control_text_content_headline;
}

$control_list_text_adv_setup[] = $control_text_width_and_max_width;

if ( $type === 'standard' ) {
  $control_list_text_adv_setup[] = $control_text_columns;
}

$control_list_text_adv_setup[] = $control_text_bg_color;


// Advanced Text Columns
// ---------------------

$control_list_text_adv_text_columns = array(
  array(
    'key'     => 'text_columns_break_inside',
    'type'    => 'choose',
    'label'   => __( 'Content Break', '__x__' ),
    'options' => $options_text_columns_break_inside,
  ),
  array(
    'key'     => 'text_columns_count',
    'type'    => 'unit-slider',
    'label'   => __( 'Maximum Columns', '__x__' ),
    'options' => $options_text_columns_count,
  ),
  array(
    'type'     => 'group',
    'label'    => __( 'Min Width &amp; Gap Width', '__x__' ),
    'controls' => array(
      array(
        'key'     => 'text_columns_width',
        'type'    => 'unit',
        'options' => $options_text_columns_width,
      ),
      array(
        'key'     => 'text_columns_gap',
        'type'    => 'unit',
        'options' => $options_text_columns_gap,
      ),
    ),
  ),
  array(
    'type'     => 'group',
    'label'    => __( 'Rule Style &amp; Rule Width', '__x__' ),
    'controls' => array(
      array(
        'key'     => 'text_columns_rule_style',
        'type'    => 'select',
        'label'   => __( 'Rule Style', '__x__' ),
        'options' => $options_text_columns_rule_style,
      ),
      array(
        'key'     => 'text_columns_rule_width',
        'type'    => 'unit',
        'label'   => __( 'Rule Width', '__x__' ),
        'options' => $options_text_columns_rule_width,
      ),
    ),
  ),
  array(
    'key'   => 'text_columns_rule_color',
    'type'  => 'color',
    'label' => __( 'Rule Color', '__x__' ),
  ),
);


// Advanced Text Typing Content
// ----------------------------

$control_list_text_adv_text_typing_content = array(
  $control_text_typing_prefix,
  $control_text_typing_content,
  $control_text_typing_suffix,
);


// Advanced Text Typing Setup
// --------------------------

$control_list_text_adv_text_typing_setup = array(
  array(
    'type'     => 'group',
    'label'    => __( 'Speed &amp; Back Speed', '__x__' ),
    'controls' => array(
      array(
        'key'     => 'text_typing_speed',
        'type'    => 'unit',
        'label'   => __( 'Speed', '__x__' ),
        'options' => $options_typing_effect_time_controls,
      ),
      array(
        'key'     => 'text_typing_back_speed',
        'type'    => 'unit',
        'label'   => __( 'Back Speed', '__x__' ),
        'options' => $options_typing_effect_time_controls,
      ),
    ),
  ),
  array(
    'type'     => 'group',
    'label'    => __( 'Delay &amp; Back Delay', '__x__' ),
    'controls' => array(
      array(
        'key'     => 'text_typing_delay',
        'type'    => 'unit',
        'label'   => __( 'Delay', '__x__' ),
        'options' => $options_typing_effect_time_controls,
      ),
      array(
        'key'     => 'text_typing_back_delay',
        'type'    => 'unit',
        'label'   => __( 'Back Delay', '__x__' ),
        'options' => $options_typing_effect_time_controls,
      ),
    ),
  ),
  array(
    'keys' => array(
      'text_typing_loop'   => 'text_typing_loop',
      'text_typing_cursor' => 'text_typing_cursor',
    ),
    'type'    => 'checkbox-list',
    'label'   => __( 'Enable', '__x__' ),
    'options' => array(
      'list' => array(
        array( 'key' => 'text_typing_loop',   'label' => __( 'Loop Typing', '__x__' ), 'half' => true ),
        array( 'key' => 'text_typing_cursor', 'label' => __( 'Show Cursor', '__x__' ), 'half' => true ),
      ),
    ),
  ),
  array(
    'key'       => 'text_typing_cursor_content',
    'type'      => 'text',
    'label'     => __( 'Cursor', '__x__' ),
    'condition' => array( 'text_typing_cursor' => true ),
  ),
  array(
    'type'     => 'group',
    'label'    => __( 'Color', '__x__' ),
    'controls' => array(
      array(
        'keys'    => array( 'value' => 'text_typing_color' ),
        'type'    => 'color',
        'label'   => __( 'Text', '__x__' ),
        'options' => array( 'label' => __( 'Text', '__x__' ) ),
      ),
      array(
        'keys'      => array( 'value' => 'text_typing_cursor_color' ),
        'type'      => 'color',
        'label'     => __( 'Cursor', '__x__' ),
        'options'   => array( 'label' => __( 'Cursor', '__x__' ) ),
        'condition' => array( 'text_typing_cursor' => true ),
      ),
    ),
  ),
);


// Advanced Subheadline Setup
// --------------------------

$control_list_text_adv_subheadline_setup = array(
  $control_text_subheadline,
  $control_text_subheadline_content,
  $control_text_subheadline_tag,
  $control_text_subheadline_spacing_and_reverse
);


// Standard Content Primary Text
// -----------------------------

$control_list_text_std_content_primary_text = array(
  $control_text_content_headline,
  $control_text_typing_prefix,
  $control_text_typing_content,
  $control_text_typing_suffix,
  $control_text_tag,
);


// Standard Content Subheadline
// ----------------------------

$control_list_text_std_content_subheadline = array(
  $control_text_subheadline_content,
  $control_text_subheadline_tag,
);


// Standard Design Setup
// ---------------------

$control_list_text_std_design_setup = array();

if ( $type === 'standard' ) {
  $control_list_text_std_design_setup[] = $control_text_font_size;
}

if ( $type === 'headline' ) {
  $control_list_text_std_design_setup[] = $control_text_base_font_size;
}

$control_list_text_std_design_setup[] = $control_text_width;
$control_list_text_std_design_setup[] = $control_text_max_width;
$control_list_text_std_design_setup[] = array(
  'key'   => 'text_text_align',
  'type'  => 'text-align',
  'label' => ( $type === 'standard' ) ? __( 'Text Align', '__x__' ) : __( 'Primary Text Align', '__x__' ),
);

if ( $type === 'headline' ) {
  $control_list_text_std_design_setup[] = array(
    'key'        => 'text_subheadline_text_align',
    'type'       => 'text-align',
    'label'      => __( 'Subheadline Text Align', '__x__' ),
    'conditions' => $conditions_text_subheadline,
  );
}


// Standard Design Colors (Base)
// -----------------------------

$control_list_text_std_design_colors_base = array(
  array(
    'keys'  => array( 'value' => 'text_text_color' ),
    'type'  => 'color',
    'label' => __( 'Text', '__x__' ),
  ),
  array(
    'keys'      => array( 'value' => 'text_text_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Text<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'text_text_shadow_dimensions', 'op' => 'NOT EMPTY' )
  ),
  array(
    'keys'      => array( 'value' => 'text_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'text_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
  ),
  array(
    'keys'  => array( 'value' => 'text_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  ),
);


// Standard Design Colors (Text Typing)
// ------------------------------------

$control_list_text_std_design_colors_text_typing = array(
  array(
    'keys'  => array( 'value' => 'text_typing_color' ),
    'type'  => 'color',
    'label' => __( 'Typing Text', '__x__' ),
  ),
  array(
    'keys'  => array( 'value' => 'text_typing_cursor_color' ),
    'type'  => 'color',
    'label' => __( 'Typing Cursor', '__x__' ),
  ),
);


// Standard Design Colors (Subheadline)
// ------------------------------------

$control_list_text_std_design_colors_subheadline = array(
  array(
    'keys'  => array( 'value' => 'text_subheadline_text_color' ),
    'type'  => 'color',
    'label' => __( 'Color', '__x__' ),
  ),
  array(
    'keys'      => array( 'value' => 'text_subheadline_text_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Text<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'text_subheadline_text_shadow_dimensions', 'op' => 'NOT EMPTY' )
  ),
);



// Control Groups (Advanced)
// =============================================================================

$control_group_text_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_text_setup,
    'controls'   => $control_list_text_adv_setup,
    'conditions' => $conditions,
  ),
);

$control_group_text_adv_columns = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Text Column Setup', '__x__' ),
    'group'      => $group_text_setup,
    'conditions' => $conditions_text_columns,
    'controls'   => $control_list_text_adv_text_columns,
  ),
);

$control_group_text_adv_typing_content = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Text Typing Content', '__x__' ),
    'group'      => $is_adv ? $group_text_setup : $group_std_content,
    'conditions' => $conditions_text_typing_on,
    'controls'   => $control_list_text_adv_text_typing_content,
  ),
);

$control_group_text_adv_typing_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Text Typing Setup', '__x__' ),
    'group'      => $group_text_setup,
    'conditions' => $conditions_text_typing_on,
    'controls'   => $control_list_text_adv_text_typing_setup,
  ),
);

$control_group_text_adv_subheadline_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Subheadline Setup', '__x__' ),
    'group'      => $group_text_text,
    'conditions' => $conditions,
    'controls'   => $control_list_text_adv_subheadline_setup,
  ),
);



// Control Groups (Standard Content)
// =============================================================================

$control_group_text_std_content_standard = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Content', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions,
    'controls'   => array(
      $control_text_content_standard,
    ),
  ),
);

$control_group_text_std_content_headline = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Primary Text', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions,
    'controls'   => $control_list_text_std_content_primary_text,
  ),
);

$control_group_text_std_content_subheadline = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Subheadline', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions_text_subheadline,
    'controls'   => $control_list_text_std_content_subheadline,
  ),
);



// Control Groups (Standard Design)
// =============================================================================

$control_group_text_std_design_setup = array(
  array(
    'type'     => 'group',
    'title'    => __( 'Design Setup', '__x__' ),
    'group'    => $group_std_design,
    'controls' => $control_list_text_std_design_setup,
  ),
);

$control_group_text_std_design_colors = array_merge(
  array(
    array(
      'type'     => 'group',
      'title'    => __( 'Base Colors', '__x__' ),
      'group'    => $group_std_design,
      'controls' => $control_list_text_std_design_colors_base,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_text_std_design,
      array(
        't_pre'     => __( 'Base', '__x__' ),
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'text_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'text_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  ),
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Text Columns Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions_text_columns,
      'controls'   => array(
        array(
          'keys'  => array( 'value' => 'text_columns_rule_color' ),
          'type'  => 'color',
          'label' => __( 'Columns Rule', '__x__' ),
        ),
      ),
    ),
    array(
      'type'       => 'group',
      'title'      => __( 'Text Typing Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions_text_typing_on,
      'controls'   => $control_list_text_std_design_colors_text_typing,
    ),
    array(
      'type'       => 'group',
      'title'      => __( 'Subheadline Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions_text_subheadline,
      'controls'   => $control_list_text_std_design_colors_subheadline,
    ),
  )
);
