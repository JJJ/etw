<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/_MODAL.PHP
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
//   10. Control Groups (Standard Design)
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'modal';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Modal', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();



// Groups
// =============================================================================

$group_modal_setup  = $group . ':setup';
$group_modal_design = $group . ':design';



// Conditions
// =============================================================================

$conditions                    = x_module_conditions( $condition );
$conditions_modal_border_color = array( $condition, array( 'key' => 'modal_content_border_width', 'op' => 'NOT EMPTY' ), array( 'key' => 'modal_content_border_width', 'op' => 'NOT EMPTY' ) );



// Options
// =============================================================================

$options_modal_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '16px',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
    'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
  ),
);

$options_modal_close_location = array(
  'choices' => array(
    array( 'value' => 'top-left',     'label' => __( 'Top Left', '__x__' )     ),
    array( 'value' => 'top-right',    'label' => __( 'Top Right', '__x__' )    ),
    array( 'value' => 'bottom-left',  'label' => __( 'Bottom Left', '__x__' )  ),
    array( 'value' => 'bottom-right', 'label' => __( 'Bottom Right', '__x__' ) ),
  ),
);

$options_modal_close_dimensions = array(
  'choices' => array(
    array( 'value' => '1',   'label' => __( 'Small', '__x__' ) ),
    array( 'value' => '1.5', 'label' => __( 'Medium', '__x__' ) ),
    array( 'value' => '2',   'label' => __( 'Large', '__x__' ) ),
  ),
);

$options_modal_content_max_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'fallback_value'  => '450px',
  'valid_keywords'  => array( 'none' ),
  'ranges'          => array(
    'px'  => array( 'min' => 500, 'max' => 1000, 'step' => 1    ),
    'em'  => array( 'min' => 25,  'max' => 100,  'step' => 0.1  ),
    'rem' => array( 'min' => 25,  'max' => 100,  'step' => 0.1  ),
    '%'   => array( 'min' => 80,  'max' => 100,  'step' => 0.01 ),
  ),
);



// Settings
// =============================================================================

$settings_modal_content = array(
  'k_pre'      => 'modal_content',
  't_pre'      => __( 'Modal Content', '__x__' ),
  'group'      => $group_modal_design,
  'conditions' => $conditions,
);



// Individual Controls
// =============================================================================

$control_modal_base_font_size = array(
  'key'     => 'modal_base_font_size',
  'type'    => 'slider',
  'title'   => __( 'Base Font Size', '__x__' ),
  'options' => $options_modal_font_size,
);

$control_modal_close_location = array(
  'key'     => 'modal_close_location',
  'type'    => 'select',
  'label'   => __( 'Close Location', '__x__' ),
  'options' => $options_modal_close_location,
);

$control_modal_close_size_and_dimensions = array(
  'type'     => 'group',
  'title'    => __( 'Close Size &amp; Dimensions', '__x__' ),
  'controls' => array(
    array(
      'key'     => 'modal_close_font_size',
      'type'    => 'unit',
      'options' => $options_modal_font_size,
    ),
    array(
      'key'     => 'modal_close_dimensions',
      'type'    => 'select',
      'options' => $options_modal_close_dimensions,
    ),
  ),
);

$control_modal_content_max_width = array(
  'key'     => 'modal_content_max_width',
  'type'    => 'slider',
  'title'   => __( 'Content Max Width', '__x__' ),
  'options' => $options_modal_content_max_width
);

$control_modal_bg_color = array(
  'key'   => 'modal_bg_color',
  'type'  => 'color',
  'title' => __( 'Overlay Background', '__x__' ),
);

$control_modal_close_colors = array(
  'keys' => array(
    'value' => 'modal_close_color',
    'alt'   => 'modal_close_color_alt',
  ),
  'type'    => 'color',
  'title'   => __( 'Close Button', '__x__' ),
  'options' => $options_base_interaction_labels,
);

$control_modal_content_bg_color = array(
  'key'   => 'modal_content_bg_color',
  'type'  => 'color',
  'title' => __( 'Content Background', '__x__' ),
);



// Control Lists
// =============================================================================

$control_list_modal_adv_setup = array(
  $control_modal_base_font_size,
  $control_modal_close_location,
  $control_modal_close_size_and_dimensions,
  $control_modal_content_max_width,
);

$control_list_modal_adv_colors = array(
  $control_modal_bg_color,
  $control_modal_close_colors,
  $control_modal_content_bg_color,
);

$control_list_modal_std_design_setup = array(
  $control_modal_base_font_size,
  $control_modal_content_max_width,
);

$control_list_modal_std_design_colors_base = array(
  $control_modal_bg_color,
  $control_modal_close_colors,
  array(
    'keys'      => array( 'value' => 'modal_content_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'modal_content_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
  ),
  $control_modal_content_bg_color,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_modal_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_modal_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_modal_adv_setup,
  ),
);

$control_group_modal_adv_colors = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Colors', '__x__' ),
    'group'      => $group_modal_design,
    'conditions' => $conditions,
    'controls'   => $control_list_modal_adv_colors,
  ),
);



// Control Groups (Standard Design)
// =============================================================================

$control_group_modal_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Modal Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_modal_std_design_setup,
  ),
);

$control_group_modal_std_design_colors = array_merge(
  array(
    array(
      'type'     => 'group',
      'title'    => __( 'Modal Base Colors', '__x__' ),
      'group'    => $group_std_design,
      'controls' => $control_list_modal_std_design_colors_base,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_modal_content,
      array(
        'group'     => $group_std_design,
        'options'   => array( 'color_only' => true ),
        'condition' => array(
          $condition,
          array( 'key' => 'modal_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'modal_border_style', 'op' => '!=', 'value' => 'none' ),
        ),
      )
    )
  )
);