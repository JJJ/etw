<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/_SEARCH.PHP
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
//   06. Settings
//   07. Individual Controls
//   08. Control Lists
//   09. Control Groups (Advanced)
//   10. Control Groups (Standard)
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================
// 01. Available types:
//     -- 'inline'
//     -- 'modal'
//     -- 'dropdown'

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'search';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Search', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();
$type        = ( isset( $settings['type'] )        ) ? $settings['type']        : 'inline'; // 01



// Groups
// =============================================================================

$group_search_setup   = $group . ':setup';
$group_search_design  = $group . ':design';
$group_search_input   = $group . ':input';
$group_search_submit  = $group . ':submit';
$group_search_clear   = $group . ':clear';



// Conditions
// =============================================================================

$conditions = x_module_conditions( $condition );



// Options
// =============================================================================

$options_search_dimensions = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'fallback_value'  => '0px',
  'valid_keywords'  => array( 'auto', 'none' ),
);

$options_search_base_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 54, 'step' => 1     ),
    'em'  => array( 'min' => 0.5, 'max' => 5,  'step' => 0.001 ),
    'rem' => array( 'min' => 0.5, 'max' => 5,  'step' => 0.001 ),
  ),
);

$options_search_order = array(
  'choices' => array(
    array( 'value' => '1', 'label' => __( '1st', '__x__' ) ),
    array( 'value' => '2', 'label' => __( '2nd', '__x__' ) ),
    array( 'value' => '3', 'label' => __( '3rd', '__x__' ) ),
  ),
);



// Settings
// =============================================================================

$settings_search_design = array(
  'k_pre'      => 'search',
  'group'      => $group_search_design,
  'conditions' => $conditions,
  'alt_color'  => true,
  'options'    => $options_color_base_interaction_labels,
);

$settings_search_design_no_options = array(
  'k_pre'      => 'search',
  'group'      => $group_search_design,
  'conditions' => $conditions,
);

$settings_search_input = array(
  'k_pre'      => 'search_input',
  't_pre'      => __( 'Input', '__x__' ),
  'group'      => $group_search_input,
  'conditions' => $conditions,
  'alt_color'  => true,
  'options'    => $options_color_base_interaction_labels,
);

$settings_search_submit = array(
  'k_pre'      => 'search_submit',
  't_pre'      => __( 'Submit', '__x__' ),
  'group'      => $group_search_submit,
  'conditions' => $conditions,
  'alt_color'  => true,
  'options'    => $options_color_base_interaction_labels,
);

$settings_search_clear = array(
  'k_pre'      => 'search_clear',
  't_pre'      => __( 'Clear', '__x__' ),
  'group'      => $group_search_clear,
  'conditions' => $conditions,
  'alt_color'  => true,
  'options'    => $options_color_base_interaction_labels,
);

$options_search_icons_stroke_width = array(
  'choices' => array(
    array( 'value' => 1, 'label' => '1' ),
    array( 'value' => 2, 'label' => '2' ),
    array( 'value' => 3, 'label' => '3' ),
    array( 'value' => 4, 'label' => '4' ),
  ),
);

$options_search_button_dimensions = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'fallback_value'  => '1em',
);

$settings_search_std_design_margin = array(
  't_pre'      => __( 'Search', '__x__' ),
  'k_pre'      => 'search',
  'group'      => $group_std_design,
  'conditions' => $conditions,
);



// Individual Controls
// =============================================================================

$control_search_base_font_size = array(
  'key'     => 'search_base_font_size',
  'type'    => 'slider',
  'label'   => __( 'Base Font Size', '__x__' ),
  'options' => $options_search_base_font_size,
);

$control_search_width = array(
  'key'     => 'search_width',
  'type'    => 'unit',
  'label'   => __( 'Width', '__x__' ),
  'options' => $options_search_dimensions,
);

$control_search_height = array(
  'key'     => 'search_height',
  'type'    => 'unit',
  'label'   => __( 'Height', '__x__' ),
  'options' => $options_search_dimensions,
);

$control_search_max_width = array(
  'key'     => 'search_max_width',
  'type'    => 'unit',
  'label'   => __( 'Max Width', '__x__' ),
  'options' => $options_search_dimensions,
);

$control_search_bg_color = array(
  'keys' => array(
    'value' => 'search_bg_color',
    'alt'   => 'search_bg_color_alt',
  ),
  'type'    => 'color',
  'label'   => __( 'Background', '__x__' ),
  'options' => $options_base_interaction_labels,
);

$control_search_placeholder = array(
  'key'   => 'search_placeholder',
  'type'  => 'text',
  'label' => __( 'Placeholder', '__x__' ),
);

$control_search_order_input = array(
  'key'     => 'search_order_input',
  'type'    => 'choose',
  'label'   => __( 'Input Placement', '__x__' ),
  'options' => $options_search_order,
);

$control_search_order_submit = array(
  'key'     => 'search_order_submit',
  'type'    => 'choose',
  'label'   => __( 'Submit Placement', '__x__' ),
  'options' => $options_search_order,
);

$control_search_order_clear = array(
  'key'     => 'search_order_clear',
  'type'    => 'choose',
  'label'   => __( 'Clear Placement', '__x__' ),
  'options' => $options_search_order,
);

$control_search_submit_font_size = array(
  'key'   => 'search_submit_font_size',
  'type'  => 'unit-slider',
  'label' => __( 'Font Size', '__x__' ),
);

$control_search_submit_stroke_width = array(
  'key'     => 'search_submit_stroke_width',
  'type'    => 'choose',
  'label'   => __( 'Stroke Width', '__x__' ),
  'options' => $options_search_icons_stroke_width,
);

$control_search_submit_width = array(
  'key'     => 'search_submit_width',
  'type'    => 'unit',
  'options' => $options_search_button_dimensions,
);

$control_search_submit_height = array(
  'key'     => 'search_submit_height',
  'type'    => 'unit',
  'options' => $options_search_button_dimensions,
);

$control_search_submit_width_and_height = array(
  'type'     => 'group',
  'title'    => __( 'Width &amp; Height', '__x__' ),
  'controls' => array(
    $control_search_submit_width,
    $control_search_submit_height,
  ),
);

$control_search_submit_colors = array(
  'keys' => array(
    'value' => 'search_submit_color',
    'alt'   => 'search_submit_color_alt',
  ),
  'type'    => 'color',
  'label'   => __( 'Color', '__x__' ),
  'options' => $options_base_interaction_labels,
);

$control_search_submit_bg_colors = array(
  'keys' => array(
    'value' => 'search_submit_bg_color',
    'alt'   => 'search_submit_bg_color_alt',
  ),
  'type'    => 'color',
  'label'   => __( 'Background', '__x__' ),
  'options' => $options_base_interaction_labels,
);

$control_search_clear_font_size = array(
  'key'   => 'search_clear_font_size',
  'type'  => 'unit-slider',
  'label' => __( 'Font Size', '__x__' ),
);

$control_search_clear_stroke_width = array(
  'key'     => 'search_clear_stroke_width',
  'type'    => 'choose',
  'label'   => __( 'Stroke Width', '__x__' ),
  'options' => $options_search_icons_stroke_width,
);

$control_search_clear_width = array(
  'key'     => 'search_clear_width',
  'type'    => 'unit',
  'options' => $options_search_button_dimensions,
);

$control_search_clear_height = array(
  'key'     => 'search_clear_height',
  'type'    => 'unit',
  'options' => $options_search_button_dimensions,
);

$control_search_clear_width_and_height = array(
  'type'     => 'group',
  'title'    => __( 'Width &amp; Height', '__x__' ),
  'controls' => array(
    $control_search_clear_width,
    $control_search_clear_height,
  ),
);

$control_search_clear_colors = array(
  'keys' => array(
    'value' => 'search_clear_color',
    'alt'   => 'search_clear_color_alt',
  ),
  'type'    => 'color',
  'label'   => __( 'Color', '__x__' ),
  'options' => $options_base_interaction_labels,
);

$control_search_clear_bg_colors = array(
  'keys' => array(
    'value' => 'search_clear_bg_color',
    'alt'   => 'search_clear_bg_color_alt',
  ),
  'type'    => 'color',
  'label'   => __( 'Background', '__x__' ),
  'options' => $options_base_interaction_labels,
);



// Control Lists
// =============================================================================

// Advanced
// --------

$control_list_search_adv_setup = array(
  $control_search_base_font_size,
  $control_search_width,
  $control_search_height,
  $control_search_max_width,
  $control_search_bg_color,
);

$control_list_search_adv_content_setup = array(
  $control_search_placeholder,
  $control_search_order_input,
  $control_search_order_submit,
  $control_search_order_clear,
);

$control_list_search_adv_submit_setup = array(
  $control_search_submit_font_size,
  $control_search_submit_stroke_width,
  $control_search_submit_width_and_height,
  $control_search_submit_colors,
  $control_search_submit_bg_colors,
);

$control_list_search_adv_clear_setup = array(
  $control_search_clear_font_size,
  $control_search_clear_stroke_width,
  $control_search_clear_width_and_height,
  $control_search_clear_colors,
  $control_search_clear_bg_colors,
);


// Standard
// --------

$control_list_search_std_content_setup = array(
  $control_search_placeholder,
);

$control_list_search_std_design_setup = array(
  $control_search_base_font_size,
  $control_search_width,
  $control_search_height,
  $control_search_max_width,
);

$control_list_search_std_design_colors_base = array(
  array(
    'keys' => array(
      'value' => 'search_input_text_color',
      'alt'   => 'search_input_text_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Text', '__x__' ),
    'options' => $options_base_interaction_labels,
  ),
  array(
    'keys' => array(
      'value' => 'search_box_shadow_color',
      'alt'   => 'search_box_shadow_color_alt',
    ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'options'   => $options_base_interaction_labels,
    'condition' => array( 'key' => 'search_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
  ),
  $control_search_bg_color,
);

$control_list_search_std_design_colors_submit = array(
  $control_search_submit_colors,
  array(
    'keys' => array(
      'value' => 'search_submit_box_shadow_color',
      'alt'   => 'search_submit_box_shadow_color_alt',
    ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'options'   => $options_base_interaction_labels,
    'condition' => array( 'key' => 'search_submit_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
  ),
  $control_search_submit_bg_colors,
);

$control_list_search_std_design_colors_clear = array(
  $control_search_clear_colors,
  array(
    'keys' => array(
      'value' => 'search_clear_box_shadow_color',
      'alt'   => 'search_clear_box_shadow_color_alt',
    ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'options'   => $options_base_interaction_labels,
    'condition' => array( 'key' => 'search_clear_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
  ),
  $control_search_clear_bg_colors,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_search_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_search_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_search_adv_setup,
  ),
);

$control_group_search_adv_content_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Content', '__x__' ),
    'group'      => $group_search_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_search_adv_content_setup,
  ),
);

$control_group_search_adv_submit_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Submit Setup', '__x__' ),
    'group'      => $group_search_submit,
    'conditions' => $conditions,
    'controls'   => $control_list_search_adv_submit_setup,
  ),
);

$control_group_search_adv_clear_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Clear Setup', '__x__' ),
    'group'      => $group_search_clear,
    'conditions' => $conditions,
    'controls'   => $control_list_search_adv_clear_setup,
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_search_std_content_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Search Content', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions,
    'controls'   => $control_list_search_std_content_setup,
  ),
);

$control_group_search_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Search Design Content', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions,
    'controls'   => $control_list_search_std_design_setup,
  ),
);

$control_group_search_std_design_colors = array_merge(
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Search Base Colors', '__x__' ),
      'group'      => $group,
      'conditions' => $conditions,
      'controls'   => $control_list_search_std_design_colors_base,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_search_design,
      array(
        't_pre'     => __( 'Search', '__x__' ),
        'group'     => $group_std_design,
        'options'   => $options_color_base_interaction_labels_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'search_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'search_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  ),
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Search Submit Colors', '__x__' ),
      'group'      => $group,
      'conditions' => $conditions,
      'controls'   => $control_list_search_std_design_colors_submit,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_search_submit,
      array(
        't_pre'     => __( 'Search Submit', '__x__' ),
        'group'     => $group_std_design,
        'options'   => $options_color_base_interaction_labels_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'search_submit_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'search_submit_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  ),
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Search Clear Colors', '__x__' ),
      'group'      => $group,
      'conditions' => $conditions,
      'controls'   => $control_list_search_std_design_colors_clear,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_search_clear,
      array(
        't_pre'     => __( 'Search Clear', '__x__' ),
        'group'     => $group_std_design,
        'options'   => $options_color_base_interaction_labels_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'search_clear_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'search_clear_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  )
);
