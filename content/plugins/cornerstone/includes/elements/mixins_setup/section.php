<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/SECTION.PHP
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

$group       = ( isset( $settings['group'] )       ) ? $settings['group']     : 'section';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Section', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition'] : array();



// Groups
// =============================================================================

$group_section_setup  = $group . ':setup';
$group_section_design = $group . ':design';



// Conditions
// =============================================================================

$conditions                      = x_module_conditions( $condition );
$conditions_section_border_color = array( $condition, array( 'key' => 'section_border_width', 'op' => 'NOT EMPTY' ), array( 'key' => 'section_border_width', 'op' => 'NOT EMPTY' ) );



// Options
// =============================================================================

$options_section_base_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
    'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
  ),
);

$options_section_z_index = array(
  'unit_mode'      => 'unitless',
  'fallback_value' => '9999',
);



// Settings
// =============================================================================

$settings_section_bg = array(
  'group'     => $group_section_design,
  'condition' => array( 'section_bg_advanced' => true ),
);

$settings_section_separator_top = array(
  't_pre'    => __( 'Section Top', '__x__' ),
  'k_pre'    => 'section_top',
  'group'    => $group_section_design,
  'location' => 'top'
);

$settings_section_separator_bottom = array(
  't_pre'    => __( 'Section Bottom', '__x__' ),
  'k_pre'    => 'section_bottom',
  'group'    => $group_section_design,
  'location' => 'bottom'
);

$settings_section_design = array(
  'k_pre' => 'section',
  'group' => $group_section_design
);

$settings_section_std_design = array(
  'k_pre' => 'section',
  'group' => $group_std_design
);



// Individual Controls
// =============================================================================

$control_section_base_font_size = array(
  'key'     => 'section_base_font_size',
  'type'    => 'unit',
  'label'   => __( 'Base Font Size', '__x__' ),
  'options' => $options_section_base_font_size,
);

$control_section_z_index = array(
  'key'     => 'section_z_index',
  'type'    => 'unit',
  'label'   => __( 'Z-Index', '__x__' ),
  'options' => $options_section_z_index,
);

$control_section_font_size_and_z_index =array(
  'type'     => 'group',
  'title'    => __( 'Font Size &amp; Z-Index', '__x__' ),
  'controls' => array(
    $control_section_base_font_size,
    $control_section_z_index,
  ),
);

$control_section_bg_color = array(
  'keys'    => array( 'value' => 'section_bg_color' ),
  'type'    => 'color',
  'label'   => __( 'Background', '__x__' ),
  'options' => $is_adv ? array( 'label' => __( 'Select', '__x__' ) ) : array(),
);

$control_section_bg_advanced = array(
  'keys' => array(
    'bg_advanced' => 'section_bg_advanced',
  ),
  'type'    => 'checkbox-list',
  'options' => array(
    'list' => array(
      array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
    ),
  ),
);

$control_section_background = array(
  'type'     => 'group',
  'title'    => __( 'Background', '__x__' ),
  'controls' => array(
    $control_section_bg_color,
    $control_section_bg_advanced
  ),
);

$control_section_text_align = array(
  'key'   => 'section_text_align',
  'type'  => 'text-align',
  'label' => __( 'Text Align', '__x__' ),
);



// Control Lists
// =============================================================================

// Advanced
// --------

$control_list_section_adv_setup = array(
  $control_section_font_size_and_z_index,
  $control_section_background,
);


// Standard
// --------

$control_list_section_std_design_setup = array(
  $control_section_font_size_and_z_index,
  $control_section_text_align,
);

$control_list_section_std_design_colors_base = array(
  array(
    'keys'      => array( 'value' => 'section_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'section_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_section_bg_color
);



// Control Groups (Advanced)
// =============================================================================

$control_group_section_adv_setup = array(
  array(
    'type'     => 'group',
    'title'    => __( 'Setup', '__x__' ),
    'group'    => $group_section_setup,
    'controls' => $control_list_section_adv_setup,
  ),
);

$control_group_section_adv_formatting = array(
  array(
    'type'     => 'group',
    'title'    => __( 'Formatting', '__x__' ),
    'group'    => $group_section_design,
    'controls' => array(
      $control_section_text_align
    ),
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_section_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_section_std_design_setup,
  ),
);

$control_group_section_std_design_colors = array_merge(
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Base Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_section_std_design_colors_base,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_section_std_design,
      array(
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'section_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'section_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  )
);
