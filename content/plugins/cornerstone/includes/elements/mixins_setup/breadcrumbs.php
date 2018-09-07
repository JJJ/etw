<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/BREADCRUMBS.PHP
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

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'breadcrumbs';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Breadcrumbs', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();



// Groups
// =============================================================================

$group_breadcrumbs_setup     = $group . ':setup';
$group_breadcrumbs_design    = $group . ':design';
$group_breadcrumbs_delimiter = $group . ':delimiter';
$group_breadcrumbs_links     = $group . ':links';



// Conditions
// =============================================================================

$conditions                                = x_module_conditions( $condition );
$conditions_breadcrumbs_home_label_text    = array_merge( $condition, array( array( 'breadcrumbs_home_label_type' => 'text' ) ) );
$conditions_breadcrumbs_home_label_icon    = array_merge( $condition, array( array( 'breadcrumbs_home_label_type' => 'icon' ) ) );
$conditions_breadcrumbs_delimimter         = array_merge( $condition, array( array( 'breadcrumbs_delimiter' => true ) ) );
$conditions_breadcrumbs_delimimter_text    = array_merge( $condition, array( array( 'breadcrumbs_delimiter' => true ), array( 'breadcrumbs_delimiter_type' => 'text' ) ) );
$conditions_breadcrumbs_delimimter_icon    = array_merge( $condition, array( array( 'breadcrumbs_delimiter' => true ), array( 'breadcrumbs_delimiter_type' => 'icon' ) ) );
$conditions_breadcrumbs_border_color       = array( $condition, array( 'key' => 'breadcrumbs_border_width', 'op' => 'NOT EMPTY' ), array( 'key' => 'breadcrumbs_border_width', 'op' => 'NOT EMPTY' ) );
$conditions_breadcrumbs_links_border_color = array( $condition, array( 'key' => 'breadcrumbs_links_border_width', 'op' => 'NOT EMPTY' ), array( 'key' => 'breadcrumbs_links_border_width', 'op' => 'NOT EMPTY' ) );



// Options
// =============================================================================

$options_breadcrumbs_home_label_type = array(
  'choices' => array(
    array( 'value' => 'text', 'label' => __( 'Text', '__x__' ) ),
    array( 'value' => 'icon', 'label' => __( 'Icon', '__x__' ) ),
  ),
);

$options_breadcrumbs_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'valid_keywords'  => array( 'auto' ),
  'fallback_value'  => 'auto',
);

$options_breadcrumbs_max_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'valid_keywords'  => array( 'none' ),
  'fallback_value'  => 'none',
);

$options_breadcrumbs_flex_justify = array(
  'choices' => array(
    array( 'value' => 'flex-start', 'label' => __( 'Initial', '__x__' )  ),
    array( 'value' => 'center',     'label' => __( 'Center', '__x__' ) ),
  ),
);

$options_breadcrumbs_base_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 14,  'max' => 64, 'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 5,  'step' => 0.05 ),
    'rem' => array( 'min' => 0.5, 'max' => 5,  'step' => 0.05 ),
  ),
);

$options_breadcrumbs_delimiter_type = array(
  'choices' => array(
    array( 'value' => 'text', 'label' => __( 'Text', '__x__' ) ),
    array( 'value' => 'icon', 'label' => __( 'Icon', '__x__' ) ),
  ),
);

$options_breadcrumbs_delimiter_icon = $is_adv ? array( 'label' => __( 'Select', '__x__' ) ) : array();

$options_breadcrumbs_delimiter_spacing = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'fallback_value'  => '8px',
  'ranges'          => array(
    'px'  => array( 'min' => 0, 'max' => 20,   'step' => 1 ),
    'em'  => array( 'min' => 0, 'max' => 0.75, 'step' => 0.05 ),
    'rem' => array( 'min' => 0, 'max' => 0.75, 'step' => 0.05 ),
  ),
);

$options_breadcrumbs_links_base_font_size = array(
  'available_units' => array( 'em' ),
  'valid_keywords'  => array( 'calc' ),
  'ranges'          => array(
    'em' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.05 ),
  ),
);

$options_breadcrumbs_links_min_width = array(
  'available_units' => array( 'em' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '0em',
  'ranges'          => array(
    'em' => array( 'min' => 2.5, 'max' => 10, 'step' => 0.1 ),
  ),
);

$options_breadcrumbs_links_max_width = array(
  'available_units' => array( 'em' ),
  'valid_keywords'  => array( 'none', 'calc' ),
  'fallback_value'  => 'none',
  'ranges'          => array(
    'em' => array( 'min' => 2.5, 'max' => 10, 'step' => 0.1 ),
  ),
);

$options_breadcrumbs_links_letter_spacing = array(
  'available_units' => array( 'em' ),
  'ranges'          => array(
    'em' => array( 'min' => -0.15, 'max' => 0.5, 'step' => 0.01 ),
  ),
);

$options_breadcrumbs_links_line_height = array(
  'unit_mode' => 'unitless',
  'min'       => 1,
  'max'       => 2.5,
  'step'      => 0.1,
);



// Settings
// =============================================================================

$settings_breadcrumbs_setup = array(
  'k_pre'     => 'breadcrumbs',
  'group'     => $group_breadcrumbs_design,
  'condition' => $conditions,
);

$settings_breadcrumbs_setup_no_letter_spacing = array(
  'k_pre'             => 'breadcrumbs',
  'group'             => $group_breadcrumbs_design,
  'condition'         => $conditions,
  'no_letter_spacing' => true,
);

$settings_breadcrumbs_delimiter = array(
  'k_pre'     => 'breadcrumbs_delimiter',
  't_pre'     => __( 'Delimiter', '__x__' ),
  'group'     => $group_breadcrumbs_delimiter,
  'condition' => $conditions_breadcrumbs_delimimter
);

$settings_breadcrumbs_links = array(
  'k_pre'     => 'breadcrumbs_links',
  't_pre'     => __( 'Links', '__x__' ),
  'group'     => $group_breadcrumbs_links,
  'condition' => $conditions,
);

$settings_breadcrumbs_links_color = array(
  'k_pre'     => 'breadcrumbs_links',
  't_pre'     => __( 'Links', '__x__' ),
  'group'     => $group_breadcrumbs_links,
  'condition' => $conditions,
  'alt_color' => true,
  'options'   => $options_color_base_interaction_labels,
);

$settings_breadcrumbs_std_design = array(
  'k_pre'     => 'breadcrumbs',
  'group'     => $group_std_design,
  'condition' => $conditions,
);

$settings_breadcrumbs_std_links_design = array(
  'k_pre'     => 'breadcrumbs_links',
  't_pre'     => __( 'Links', '__x__' ),
  'group'     => $group_std_design,
  'condition' => $conditions,
);



// Individual Controls
// =============================================================================

$control_breadcrumbs_home_label_type = array(
  'key'     => 'breadcrumbs_home_label_type',
  'type'    => 'choose',
  'label'   => __( 'Home Label Type', '__x__' ),
  'options' => $options_breadcrumbs_home_label_type,
);

$control_breadcrumbs_home_label_text = array(
  'key'        => 'breadcrumbs_home_label_text',
  'type'       => 'text',
  'label'      => __( 'Home Label', '__x__' ),
  'conditions' => $conditions_breadcrumbs_home_label_text,
);

$control_breadcrumbs_home_label_icon = array(
  'key'        => 'breadcrumbs_home_label_icon',
  'type'       => 'icon',
  'label'      => __( 'Home Label', '__x__' ),
  'conditions' => $conditions_breadcrumbs_home_label_icon,
);

$control_breadcrumbs_width = array(
  'key'     => 'breadcrumbs_width',
  'type'    => $is_adv ? 'unit' : 'unit-slider',
  'label'   => __( 'Width', '__x__' ),
  'options' => $options_breadcrumbs_width,
);

$control_breadcrumbs_max_width = array(
  'key'     => 'breadcrumbs_max_width',
  'type'    => $is_adv ? 'unit' : 'unit-slider',
  'label'   => __( 'Max Width', '__x__' ),
  'options' => $options_breadcrumbs_max_width,
);

$control_breadcrumbs_width_and_max_width = array(
  'type'     => 'group',
  'label'    => __( 'Width &amp; Max Width', '__x__' ),
  'controls' => array(
    $control_breadcrumbs_width,
    $control_breadcrumbs_max_width,
  ),
);

$control_breadcrumbs_flex_justify = array(
  'key'     => 'breadcrumbs_flex_justify',
  'type'    => 'select',
  'options' => $options_breadcrumbs_flex_justify,
);

$control_breadcrumbs_reverse = array(
  'keys' => array(
    'reverse' => 'breadcrumbs_reverse',
  ),
  'type'    => 'checkbox-list',
  'options' => array(
    'list' => array(
      array( 'key' => 'reverse', 'label' => __( 'Reverse', '__x__' ) ),
    ),
  ),
);

$control_breadcrumbs_justification_and_reverse = array(
  'type'     => 'group',
  'label'    => __( 'Justification &amp; Direction', '__x__' ),
  'controls' => array(
    $control_breadcrumbs_flex_justify,
    $control_breadcrumbs_reverse,
  ),
);

$control_breadcrumbs_bg_color = array(
  'keys'  => array( 'value' => 'breadcrumbs_bg_color' ),
  'type'  => 'color',
  'title' => __( 'Background', '__x__' ),
);

$control_breadcrumbs_delimiter = array(
  'key'     => 'breadcrumbs_delimiter',
  'type'    => 'choose',
  'label'   => __( 'Enable', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_breadcrumbs_delimiter_type = array(
  'key'     => 'breadcrumbs_delimiter_type',
  'type'    => 'choose',
  'label'   => __( 'Delimiter Type', '__x__' ),
  'conditions' => $conditions_breadcrumbs_delimimter,
  'options' => $options_breadcrumbs_delimiter_type,
);

$control_breadcrumbs_delimiter_ltr_text = array(
  'key'        => 'breadcrumbs_delimiter_ltr_text',
  'type'       => 'text',
  'label'      => __( 'LTR Delimiter', '__x__' ),
  'conditions' => $conditions_breadcrumbs_delimimter_text,

);

$control_breadcrumbs_delimiter_rtl_text = array(
  'key'        => 'breadcrumbs_delimiter_rtl_text',
  'type'       => 'text',
  'label'      => __( 'RTL Delimiter', '__x__' ),
  'conditions' => $conditions_breadcrumbs_delimimter_text,
);

$control_breadcrumbs_delimiter_ltr_and_rtl_text = array(
  'type'       => 'group',
  'label'      => __( 'LTR &amp; RTL Delimiter', '__x__' ),
  'conditions' => $conditions_breadcrumbs_delimimter_text,
  'controls'   => array(
    $control_breadcrumbs_delimiter_ltr_text,
    $control_breadcrumbs_delimiter_rtl_text,
  ),
);

$control_breadcrumbs_delimiter_ltr_icon = array(
  'key'        => 'breadcrumbs_delimiter_ltr_icon',
  'type'       => 'icon',
  'label'      => __( 'LTR Delimiter', '__x__' ),
  'options'    => $options_breadcrumbs_delimiter_icon,
  'conditions' => $conditions_breadcrumbs_delimimter_icon,
);

$control_breadcrumbs_delimiter_rtl_icon = array(
  'key'        => 'breadcrumbs_delimiter_rtl_icon',
  'type'       => 'icon',
  'label'      => __( 'RTL Delimiter', '__x__' ),
  'options'    => $options_breadcrumbs_delimiter_icon,
  'conditions' => $conditions_breadcrumbs_delimimter_icon,
);

$control_breadcrumbs_delimiter_ltr_and_rtl_icon = array(
  'type'       => 'group',
  'label'      => __( 'LTR &amp; RTL Delimiter', '__x__' ),
  'conditions' => $conditions_breadcrumbs_delimimter_icon,
  'controls'   => array(
    $control_breadcrumbs_delimiter_ltr_icon,
    $control_breadcrumbs_delimiter_rtl_icon,
  ),
);

$control_breadcrumbs_delimiter_spacing = array(
  'key'        => 'breadcrumbs_delimiter_spacing',
  'type'       => 'unit-slider',
  'title'      => $is_adv ? __( 'Spacing', '__x__' ) : __( 'Delimiter Spacing', '__x__' ),
  'conditions' => $conditions_breadcrumbs_delimimter,
  'options'    => $options_breadcrumbs_delimiter_spacing,
);

$control_breadcrumbs_delimiter_color = array(
  'keys'       => array( 'value' => 'breadcrumbs_delimiter_color' ),
  'type'       => 'color',
  'label'      => __( 'Color', '__x__' ),
  'conditions' => $conditions_breadcrumbs_delimimter,
);

$control_breadcrumbs_links_base_font_size = array(
  'key'     => 'breadcrumbs_links_base_font_size',
  'type'    => 'unit-slider',
  'label'   => __( 'Base Font Size', '__x__' ),
  'options' => $options_breadcrumbs_links_base_font_size,
);

$control_breadcrumbs_links_min_width = array(
  'key'     => 'breadcrumbs_links_min_width',
  'type'    => 'unit-slider',
  'label'   => __( 'Min Width', '__x__' ),
  'options' => $options_breadcrumbs_links_min_width,
);

$control_breadcrumbs_links_max_width = array(
  'key'     => 'breadcrumbs_links_max_width',
  'type'    => 'unit-slider',
  'label'   => __( 'Max Width', '__x__' ),
  'options' => $options_breadcrumbs_links_max_width,
);

$control_breadcrumbs_links_colors = array(
  'keys' => array(
    'value' => 'breadcrumbs_links_color',
    'alt'   => 'breadcrumbs_links_color_alt',
  ),
  'type'    => 'color',
  'label'   => __( 'Color', '__x__' ),
  'options' => $options_base_interaction_labels,
);

$control_breadcrumbs_links_bg_colors = array(
  'keys' => array(
    'value' => 'breadcrumbs_links_bg_color',
    'alt'   => 'breadcrumbs_links_bg_color_alt',
  ),
  'type'    => 'color',
  'label'   => __( 'Background', '__x__' ),
  'options' => $options_base_interaction_labels,
);

$control_breadcrumbs_links_font_style = array(
  'key'   => 'breadcrumbs_links_font_style',
  'type'  => 'font-style',
  'label' => __( 'Font Style', '__x__' ),
);

$control_breadcrumbs_links_text_align = array(
  'key'   => 'breadcrumbs_links_text_align',
  'type'  => 'text-align',
  'label' => __( 'Text Align', '__x__' ),
);

$control_breadcrumbs_links_text_transform = array(
  'key'   => 'breadcrumbs_links_text_transform',
  'type'  => 'text-transform',
  'label' => __( 'Text Transform', '__x__' ),
);

$control_breadcrumbs_links_letter_spacing = array(
  'key'     => 'breadcrumbs_links_letter_spacing',
  'type'    => 'unit-slider',
  'label'   => __( 'Letter Spacing', '__x__' ),
  'options' => $options_breadcrumbs_links_letter_spacing,
);

$control_breadcrumbs_links_line_height = array(
  'key'     => 'breadcrumbs_links_line_height',
  'type'    => 'unit-slider',
  'label'   => __( 'Line Height', '__x__' ),
  'options' => $options_breadcrumbs_links_line_height,
);



// Control Lists
// =============================================================================

// Advanced
// --------

$control_list_breadcrumbs_adv_setup = array(
  $control_breadcrumbs_home_label_type,
  $control_breadcrumbs_home_label_text,
  $control_breadcrumbs_home_label_icon,
  $control_breadcrumbs_width_and_max_width,
  $control_breadcrumbs_justification_and_reverse,
  $control_breadcrumbs_bg_color,
);

$control_list_breadcrumbs_adv_setup_delimiter = array(
  $control_breadcrumbs_delimiter,
  $control_breadcrumbs_delimiter_type,
  $control_breadcrumbs_delimiter_ltr_and_rtl_text,
  $control_breadcrumbs_delimiter_ltr_and_rtl_icon,
  $control_breadcrumbs_delimiter_spacing,
  $control_breadcrumbs_delimiter_color,
);

$control_list_breadcrumbs_adv_setup_links = array(
  $control_breadcrumbs_links_base_font_size,
  $control_breadcrumbs_links_min_width,
  $control_breadcrumbs_links_max_width,
  $control_breadcrumbs_links_colors,
  $control_breadcrumbs_links_bg_colors,
);

$control_list_breadcrumbs_adv_setup_links_text_style_and_format = array(
  $control_breadcrumbs_links_font_style,
  $control_breadcrumbs_links_text_align,
  $control_breadcrumbs_links_text_transform,
  $control_breadcrumbs_links_letter_spacing,
  $control_breadcrumbs_links_line_height,
);


// Standard
// --------

$control_list_breadcrumbs_std_content_setup = array(
  $control_breadcrumbs_home_label_text,
  $control_breadcrumbs_home_label_icon,
  $control_breadcrumbs_delimiter_ltr_text,
  $control_breadcrumbs_delimiter_rtl_text,
  $control_breadcrumbs_delimiter_ltr_icon,
  $control_breadcrumbs_delimiter_rtl_icon,
);

$control_list_breadcrumbs_std_design_setup = array(
  array(
    'key'     => 'breadcrumbs_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => $options_breadcrumbs_base_font_size,
  ),
  $control_breadcrumbs_width,
  $control_breadcrumbs_max_width,
  $control_breadcrumbs_delimiter_spacing,
);

$control_list_breadcrumbs_std_design_colors_base = array(
  array(
    'keys'      => array( 'value' => 'breadcrumbs_box_shadow_color' ),
    'type'      => 'color',
    'title'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'breadcrumbs_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_breadcrumbs_bg_color,
);

$control_list_breadcrumbs_std_design_colors_delimiter = array(
  array(
    'keys'  => array( 'value' => 'breadcrumbs_delimiter_color' ),
    'type'  => 'color',
    'title' => __( 'Text', '__x__' ),
  ),
  array(
    'keys'      => array( 'value' => 'breadcrumbs_delimiter_text_shadow_color' ),
    'type'      => 'color',
    'title'     => __( 'Text<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'breadcrumbs_delimiter_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
);

$control_list_breadcrumbs_std_design_colors_links = array(
  $control_breadcrumbs_links_colors,
  array(
    'keys' => array(
      'value' => 'breadcrumbs_links_text_shadow_color',
      'alt'   => 'breadcrumbs_links_text_shadow_color_alt',
    ),
    'type'      => 'color',
    'label'     => __( 'Text<br>Shadow', '__x__' ),
    'options'   => $options_base_interaction_labels,
    'condition' => array( 'key' => 'breadcrumbs_links_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  array(
    'keys' => array(
      'value' => 'breadcrumbs_links_box_shadow_color',
      'alt'   => 'breadcrumbs_links_box_shadow_color_alt',
    ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'options'   => $options_base_interaction_labels,
    'condition' => array( 'key' => 'breadcrumbs_links_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_breadcrumbs_links_bg_colors,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_breadcrumbs_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_breadcrumbs_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_breadcrumbs_adv_setup,
  ),
);

$control_group_breadcrumbs_adv_setup_delimiter = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Delimiter Setup', '__x__' ),
    'group'      => $group_breadcrumbs_delimiter,
    'conditions' => $conditions,
    'controls'   => $control_list_breadcrumbs_adv_setup_delimiter,
  ),
);

$control_group_breadcrumbs_adv_setup_links = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Links Setup', '__x__' ),
    'group'      => $group_breadcrumbs_links,
    'conditions' => $conditions,
    'controls'   => $control_list_breadcrumbs_adv_setup_links,
  ),
);

$control_group_breadcrumbs_adv_setup_links_text_style_and_format = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Links Text Style &amp; Format', '__x__' ),
    'group'      => $group_breadcrumbs_links,
    'conditions' => $conditions,
    'controls'   => $control_list_breadcrumbs_adv_setup_links_text_style_and_format,
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_breadcrumbs_std_content_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Content Setup', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions,
    'controls'   => $control_list_breadcrumbs_std_content_setup,
  ),
);

$control_group_breadcrumbs_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_breadcrumbs_std_design_setup,
  ),
);

$control_group_breadcrumbs_std_design_colors = array_merge(
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Base Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_breadcrumbs_std_design_colors_base,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_breadcrumbs_std_design,
      array(
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'breadcrumbs_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'breadcrumbs_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  ),
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Delimiter Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_breadcrumbs_std_design_colors_delimiter,
    ),
  ),
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Links Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_breadcrumbs_std_design_colors_links,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_breadcrumbs_std_links_design,
      array(
        'options'   => $options_color_base_interaction_labels_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'breadcrumbs_links_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'breadcrumbs_links_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  )
);
