<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/ACCORDION.PHP
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

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'accordion';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Accordion', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();



// Groups
// =============================================================================

$group_accordion_setup          = $group . ':setup';
$group_accordion_design         = $group . ':design';

$group_accordion_items          = $group . '_items';
$group_accordion_items_setup    = $group . '_items:setup';
$group_accordion_items_design   = $group . '_items:design';

$group_accordion_header         = $group . '_item_header';
$group_accordion_header_setup   = $group . '_item_header:setup';
$group_accordion_header_design  = $group . '_item_header:design';
$group_accordion_header_text    = $group . '_item_header:text';

$group_accordion_content        = $group . '_item_content';
$group_accordion_content_setup  = $group . '_item_content:setup';
$group_accordion_content_design = $group . '_item_content:design';
$group_accordion_content_text   = $group . '_item_content:text';



// Conditions
// =============================================================================

$conditions                            = x_module_conditions( $condition );
$conditions_accordion_header_indicator = array( $condition, array( 'accordion_header_indicator' => true ) );



// Options
// =============================================================================

$options_accordion_items_sortable = array(
  'element'   => 'accordion-item',
  'label_key' => 'accordion_item_header_content'
);

$options_accordion_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
    'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
  ),
);

$options_accordion_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'valid_keywords'  => array( 'auto' ),
  'fallback_value'  => 'auto',
);

$options_accordion_max_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'valid_keywords'  => array( 'none' ),
  'fallback_value'  => 'none',
);

$options_accordion_item_spacing = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 0, 'max' => 25, 'step' => 1   ),
    'em'  => array( 'min' => 0, 'max' => 1,  'step' => 0.1 ),
    'rem' => array( 'min' => 0, 'max' => 1,  'step' => 0.1 ),
  ),
);

$options_accordion_header_content_spacing = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
);

$options_accordion_header_indicator_type = array(
  'choices' => array(
    array( 'value' => 'text', 'label' => __( 'Text', '__x__' ) ),
    array( 'value' => 'icon', 'label' => __( 'Icon', '__x__' ) ),
  ),
);

$options_accordion_header_indicator_icon = array(
  'label' => __( 'Select', '__x__' ),
);

$options_accordion_header_indicator_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.25 ),
    'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.25 ),
  ),
);

$options_accordion_header_indicator_width = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'auto', 'calc' ),
  'fallback_value'  => 'auto',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 40,  'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 2.5, 'step' => 0.25 ),
    'rem' => array( 'min' => 0.5, 'max' => 2.5, 'step' => 0.25 ),
  ),
);

$options_accordion_header_indicator_height = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 40,  'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 2.5, 'step' => 0.25 ),
    'rem' => array( 'min' => 0.5, 'max' => 2.5, 'step' => 0.25 ),
  ),
);

$options_accordion_header_indicator_rotation = array(
  'unit_mode'       => 'angle',
  'available_units' => array( 'deg' ),
  'fallback_value'  => '0deg',
  'ranges'          => array(
    'deg' => array( 'min' => 0, 'max' => 360, 'step' => 1 ),
  ),
);



// Settings
// =============================================================================

$settings_accordion = array(
  'k_pre'     => 'accordion',
  'group'     => $group_accordion_design,
  'condition' => $conditions,
);

$settings_accordion_item_design = array(
  'k_pre'     => 'accordion_item',
  't_pre'     => __( 'Item', '__x__' ),
  'group'     => $group_accordion_items_design,
  'condition' => $conditions,
);

$settings_accordion_header_design = array(
  'k_pre'     => 'accordion_header',
  't_pre'     => __( 'Header', '__x__' ),
  'group'     => $group_accordion_header_design,
  'condition' => $conditions,
  'alt_color' => true,
  'options'   => $options_color_base_interaction_labels,
);

$settings_accordion_header_text = array(
  'k_pre'     => 'accordion_header',
  't_pre'     => __( 'Header', '__x__' ),
  'group'     => $group_accordion_header_text,
  'condition' => $conditions,
  'alt_color' => true,
  'options'   => $options_color_base_interaction_labels,
);

$settings_accordion_content_design = array(
  'k_pre'     => 'accordion_content',
  't_pre'     => __( 'Content', '__x__' ),
  'group'     => $group_accordion_content_design,
  'condition' => $conditions,
);

$settings_accordion_content_text = array(
  'k_pre'     => 'accordion_content',
  't_pre'     => __( 'Content', '__x__' ),
  'group'     => $group_accordion_content_text,
  'condition' => $conditions,
);

$settings_accordion_std_design = array(
  'k_pre'     => 'accordion',
  'group'     => $group_std_design,
  'condition' => $conditions,
);



// Individual Controls
// =============================================================================

$control_accordion_items_sortable = array(
  'type'       => 'sortable',
  'title'      => __( 'Add Items', '__x__' ),
  'group'      => $is_adv ? $group_accordion_setup : $group_std_content,
  'conditions' => $conditions,
  'options'    => $options_accordion_items_sortable,
);

$control_accordion_base_font_size = array(
  'key'     => 'accordion_base_font_size',
  'type'    => 'slider',
  'label'   => __( 'Base Font Size', '__x__' ),
  'options' => $options_accordion_font_size,
);

$control_accordion_width = array(
  'key'     => 'accordion_width',
  'type'    => $is_adv ? 'unit' : 'unit-slider',
  'label'   => __( 'Width', '__x__' ),
  'options' => $options_accordion_width,
);

$control_accordion_max_width = array(
  'key'     => 'accordion_max_width',
  'type'    => $is_adv ? 'unit' : 'unit-slider',
  'label'   => __( 'Max Width', '__x__' ),
  'options' => $options_accordion_max_width,
);

$control_accordion_width_and_max_width = array(
  'type'     => 'group',
  'label'    => __( 'Width &amp; Max Width', '__x__' ),
  'controls' => array(
    $control_accordion_width,
    $control_accordion_max_width,
  ),
);

$control_accordion_grouped = array(
  'key'     => 'accordion_grouped',
  'type'    => 'choose',
  'label'   => __( 'Enable Grouping', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_accordion_group = array(
  'key'       => 'accordion_group',
  'type'      => 'text',
  'label'     => __( 'Custom Group', '__x__' ),
  'condition' => array( 'accordion_grouped' => true ),
);

$control_accordion_bg_color = array(
  'key'   => 'accordion_bg_color',
  'type'  => 'color',
  'title' => __( 'Background', '__x__' ),
);

$control_accordion_item_overflow = array(
  'key'     => 'accordion_item_overflow',
  'type'    => 'choose',
  'label'   => __( 'Overflow', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_accordion_item_spacing = array(
  'key'     => 'accordion_item_spacing',
  'type'    => 'unit-slider',
  'label'   => __( 'Spacing', '__x__' ),
  'options' => $options_accordion_item_spacing,
);

$control_accordion_item_bg_color = array(
  'key'   => 'accordion_item_bg_color',
  'type'  => 'color',
  'title' => __( 'Background', '__x__' ),
);

$control_accordion_header_text_overflow = array(
  'key'     => 'accordion_header_text_overflow',
  'type'    => 'choose',
  'label'   => __( 'Overflow', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_accordion_header_indicator = array(
  'key'     => 'accordion_header_indicator',
  'type'    => 'choose',
  'label'   => __( 'Indicator', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_accordion_header_spacing_and_direction = array(
  'type'      => 'group',
  'label'     => __( 'Spacing &amp; Direction', '__x__' ),
  'condition' => array( 'accordion_header_indicator' => true ),
  'controls'  => array(
    array(
      'key'     => 'accordion_header_content_spacing',
      'type'    => 'unit',
      'label'   => __( 'Indicator Spacing', '__x__' ),
      'options' => $options_accordion_header_content_spacing,
    ),
    array(
      'keys' => array(
        'reverse' => 'accordion_header_content_reverse',
      ),
      'type'    => 'checkbox-list',
      'label'   => __( 'Indicator Reverse', '__x__' ),
      'options' => array(
        'list' => array(
          array( 'key' => 'reverse', 'label' => __( 'Reverse', '__x__' ) ),
        ),
      ),
    ),
  ),
);

$control_accordion_header_bg_colors = array(
  'keys' => array(
    'value' => 'accordion_header_bg_color',
    'alt'   => 'accordion_header_bg_color_alt',
  ),
  'type'    => 'color',
  'title'   => __( 'Background', '__x__' ),
  'options' => $options_base_interaction_labels,
);

$control_accordion_header_indicator_type = array(
  'key'     => 'accordion_header_indicator_type',
  'type'    => 'choose',
  'label'   => __( 'Type', '__x__' ),
  'options' => $options_accordion_header_indicator_type,
);

$control_accordion_header_indicator_text = array(
  'key'       => 'accordion_header_indicator_text',
  'type'      => 'text',
  'label'     => __( 'Indicator', '__x__' ),
  'condition' => array( 'accordion_header_indicator_type' => 'text' ),
);

$control_accordion_header_indicator_icon = array(
  'key'       => 'accordion_header_indicator_icon',
  'type'      => 'icon',
  'label'     => __( 'Indicator', '__x__' ),
  'condition' => array( 'accordion_header_indicator_type' => 'icon' ),
  'options'   => $options_accordion_header_indicator_icon,
);

$control_accordion_header_indicator_text_and_icon_and_font_size = array(
  'type'     => 'group',
  'label'    => __( 'Indicator &amp; Font Size', '__x__' ),
  'controls' => array(
    $control_accordion_header_indicator_text,
    $control_accordion_header_indicator_icon,
    array(
      'key'     => 'accordion_header_indicator_font_size',
      'type'    => 'unit',
      'label'   => __( 'Font Size', '__x__' ),
      'options' => $options_accordion_header_indicator_font_size,
    ),
  ),
);

$control_accordion_header_indicator_width_and_height = array(
  'type'     => 'group',
  'label'    => __( 'Width &amp; Height', '__x__' ),
  'controls' => array(
    array(
      'key'     => 'accordion_header_indicator_width',
      'type'    => 'unit',
      'label'   => __( 'Width', '__x__' ),
      'options' => $options_accordion_header_indicator_width,
    ),
    array(
      'key'     => 'accordion_header_indicator_height',
      'type'    => 'unit',
      'label'   => __( 'Height', '__x__' ),
      'options' => $options_accordion_header_indicator_height,
    ),
  ),
);

$control_accordion_header_indicator_rotation_start = array(
  'key'     => 'accordion_header_indicator_rotation_start',
  'type'    => 'unit',
  'label'   => __( 'Start Rotation', '__x__' ),
  'options' => $options_accordion_header_indicator_rotation,
);

$control_accordion_header_indicator_rotation_end = array(
  'key'     => 'accordion_header_indicator_rotation_end',
  'type'    => 'unit',
  'label'   => __( 'End Rotation', '__x__' ),
  'options' => $options_accordion_header_indicator_rotation,
);

$control_accordion_header_indicator_start_and_end_rotation = array(
  'type'     => 'group',
  'label'    => __( 'Start &amp; End Rotation', '__x__' ),
  'controls' => array(
    $control_accordion_header_indicator_rotation_start,
    $control_accordion_header_indicator_rotation_end,
  ),
);

$control_accordion_header_indicator_colors = array(
  'keys' => array(
    'value' => 'accordion_header_indicator_color',
    'alt'   => 'accordion_header_indicator_color_alt',
  ),
  'type'    => 'color',
  'title'   => $is_adv ? __( 'Color', '__x__' ) : __( 'Indicator', '__x__' ),
  'options' => $options_base_interaction_labels,
);

$control_accordion_content_bg_color = array(
  'key'   => 'accordion_content_bg_color',
  'type'  => 'color',
  'title' => __( 'Background', '__x__' ),
);



// Control Lists
// =============================================================================

// Advanced
// --------

$control_list_accordion_adv_setup = array(
  $control_accordion_base_font_size,
  $control_accordion_width_and_max_width,
  $control_accordion_grouped,
  $control_accordion_group,
  $control_accordion_bg_color,
);

$control_list_accordion_adv_items_setup = array(
  $control_accordion_item_overflow,
  $control_accordion_item_spacing,
  $control_accordion_item_bg_color,
);

$control_list_accordion_adv_header_setup = array(
  $control_accordion_header_text_overflow,
  $control_accordion_header_indicator,
  $control_accordion_header_spacing_and_direction,
  $control_accordion_header_bg_colors,
);

$control_list_accordion_adv_header_indicator_setup = array(
  $control_accordion_header_indicator_type,
  $control_accordion_header_indicator_text_and_icon_and_font_size,
  $control_accordion_header_indicator_width_and_height,
  $control_accordion_header_indicator_start_and_end_rotation,
  $control_accordion_header_indicator_colors,
);

$control_list_accordion_adv_header_content_setup = array(
  $control_accordion_content_bg_color
);


// Standard
// --------

$control_list_accordion_std_design_setup = array(
  $control_accordion_base_font_size,
  $control_accordion_width,
  $control_accordion_max_width,
  $control_accordion_header_indicator_text,
  $control_accordion_header_indicator_icon,
  $control_accordion_header_indicator_start_and_end_rotation,
);

$control_list_accordion_std_design_colors_base = array(
  array(
    'keys'      => array( 'value' => 'accordion_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'accordion_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_accordion_bg_color,
);

$control_list_accordion_std_design_colors_item = array(
  array(
    'keys'      => array( 'value' => 'accordion_item_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'accordion_item_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_accordion_item_bg_color,
);

$control_list_accordion_std_design_colors_header = array(
  array(
    'keys' => array(
      'value' => 'accordion_header_text_color',
      'alt'   => 'accordion_header_text_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Text', '__x__' ),
    'options' => $options_base_interaction_labels,
  ),
  $control_accordion_header_indicator_colors,
  array(
    'keys' => array(
      'value' => 'accordion_header_text_shadow_color',
      'alt'   => 'accordion_header_text_shadow_color_alt',
    ),
    'type'      => 'color',
    'label'     => __( 'Text<br>Shadow', '__x__' ),
    'options'   => $options_base_interaction_labels,
    'condition' => array( 'key' => 'accordion_header_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  array(
    'keys' => array(
      'value' => 'accordion_header_box_shadow_color',
      'alt'   => 'accordion_header_box_shadow_color_alt',
    ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'options'   => $options_base_interaction_labels,
    'condition' => array( 'key' => 'accordion_header_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_accordion_header_bg_colors,
);

$control_list_accordion_std_design_colors_content = array(
  array(
    'keys'  => array( 'value' => 'accordion_content_text_color' ),
    'type'  => 'color',
    'label' => __( 'Text', '__x__' ),
  ),
  array(
    'keys'      => array( 'value' => 'accordion_content_text_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Text<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'accordion_content_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  array(
    'keys'      => array( 'value' => 'accordion_content_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'accordion_content_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_accordion_content_bg_color,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_accordion_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_accordion_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_accordion_adv_setup,
  ),
);

$control_group_accordion_adv_items_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Item Setup', '__x__' ),
    'group'      => $group_accordion_items_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_accordion_adv_items_setup,
  ),
);

$control_group_accordion_adv_header_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Header Setup', '__x__' ),
    'group'      => $group_accordion_header_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_accordion_adv_header_setup,
  ),
);

$control_group_accordion_adv_header_indicator_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Header Indicator Setup', '__x__' ),
    'group'      => $group_accordion_header_setup,
    'conditions' => $conditions_accordion_header_indicator,
    'controls'   => $control_list_accordion_adv_header_indicator_setup,
  ),
);

$control_group_accordion_adv_header_content_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Content Setup', '__x__' ),
    'group'      => $group_accordion_content_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_accordion_adv_header_content_setup,
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_accordion_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_accordion_std_design_setup,
  ),
);

$control_group_accordion_std_design_colors = array_merge(
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Base Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_accordion_std_design_colors_base,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_accordion,
      array(
        'group'     => $group_std_design,
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'accordion_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'accordion_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  ),
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Item Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_accordion_std_design_colors_item,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_accordion_item_design,
      array(
        'group'     => $group_std_design,
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'accordion_item_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'accordion_item_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  ),
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Header Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_accordion_std_design_colors_header,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_accordion_header_design,
      array(
        'group'     => $group_std_design,
        'options'   => $options_color_base_interaction_labels_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'accordion_header_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'accordion_header_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  ),
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Content Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_accordion_std_design_colors_content,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_accordion_content_design,
      array(
        'group'     => $group_std_design,
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'accordion_content_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'accordion_content_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  )
);
