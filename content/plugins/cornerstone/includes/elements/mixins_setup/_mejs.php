<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/_MEJS.PHP
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
//   05. MEJS Key and Control Prep
//   06. Options
//   07. Settings
//   08. Individual Controls
//   09. Control Lists
//   10. Control Groups (Advanced)
//   11. Control Groups (Standard Design)
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================
// 01. Available types:
//     -- 'audio'
//     -- 'video'

$t_pre     = ( isset( $settings['t_pre'] )     ) ? $settings['t_pre'] . ' ' : '';
$group     = ( isset( $settings['group'] )     ) ? $settings['group']       : 'mejs';
$condition = ( isset( $settings['condition'] ) ) ? $settings['condition']   : array();
$type      = ( isset( $settings['type'] )      ) ? $settings['type']        : 'audio'; // 01



// Groups
// =============================================================================
// Parent mixins will pass in group.



// Conditions
// =============================================================================

$conditions = x_module_conditions( $condition );



// MEJS Key and Control Prep
// =============================================================================

$keys_mejs_display_and_function = array(
  'hide_controls'     => 'mejs_hide_controls',
  'advanced_controls' => 'mejs_advanced_controls',
  'autoplay'          => 'mejs_autoplay',
  'loop'              => 'mejs_loop',
  'muted'             => 'mejs_muted',
);

$options_list_mejs_display_and_function = array(
  array( 'key' => 'hide_controls',     'label' => __( 'No Controls', '__x__' ), 'half' => true ),
  array( 'key' => 'advanced_controls', 'label' => __( 'Advanced', '__x__' ),    'half' => true ),
  array( 'key' => 'autoplay',          'label' => __( 'Autoplay', '__x__' ),    'half' => true ),
  array( 'key' => 'loop',              'label' => __( 'Loop', '__x__' ),        'half' => true ),
  array( 'key' => 'muted',             'label' => __( 'Muted', '__x__' ),       'half' => true ),
);

if ( $type === 'audio' ) {
  array_shift( $keys_mejs_display_and_function );
  array_shift( $options_list_mejs_display_and_function );
  array_pop( $keys_mejs_display_and_function );
  array_pop( $options_list_mejs_display_and_function );
}



// Options
// =============================================================================

$options_mejs_preload = array(
  'choices' => array(
    array( 'value' => 'none',     'label' => __( 'None', '__x__' )     ),
    array( 'value' => 'auto',     'label' => __( 'Auto', '__x__' )     ),
    array( 'value' => 'metadata', 'label' => __( 'Metadata', '__x__' ) ),
  ),
);

$options_mejs_display_and_function = array(
  'list' => $options_list_mejs_display_and_function,
);

$options_mejs_video_controls_margin_t = array(
  'disabled'       => true,
  'valid_keywords' => array( 'auto' ),
  'fallback_value' => 'auto',
);

$options_mejs_video_controls_margin_lrb = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'fallback_value'  => '10px',
  'valid_keywords'  => array( 'calc' ),
  'ranges'          => array(
    'px'  => array( 'min' => 0, 'max' => 20, 'step' => 1    ),
    'em'  => array( 'min' => 0, 'max' => 1,  'step' => 0.01 ),
    'rem' => array( 'min' => 0, 'max' => 1,  'step' => 0.01 ),
  ),
);



// Settings
// =============================================================================

$settings_mejs_controls = array(
  'k_pre'     => 'mejs_controls',
  't_pre'     => __( 'Controls', '__x__' ),
  'group'     => $group,
  'condition' => $conditions
);

$settings_mejs_controls_time_rail = array(
  'k_pre'     => 'mejs_controls_time_rail',
  't_pre'     => __( 'Time Rail', '__x__' ),
  'group'     => $group,
  'condition' => $conditions
);

$settings_mejs_video_controls_margin = array(
  'k_pre'     => 'mejs_controls',
  't_pre'     => __( 'Controls', '__x__' ),
  'group'     => $group,
  'condition' => $conditions,
  'options' => array(
    'top'    => $options_mejs_video_controls_margin_t,
    'left'   => $options_mejs_video_controls_margin_lrb,
    'right'  => $options_mejs_video_controls_margin_lrb,
    'bottom' => $options_mejs_video_controls_margin_lrb,
  ),
);



// Individual Controls
// =============================================================================

$control_mejs_preload = array(
  'key'     => 'mejs_preload',
  'type'    => 'select',
  'label'   => __( 'Preload Content', '__x__' ),
  'options' => $options_mejs_preload,
);

$control_mejs_display_and_function = array(
  'keys'    => $keys_mejs_display_and_function,
  'type'    => 'checkbox-list',
  'label'   => __( 'Display &amp; Function', '__x__' ),
  'options' => $options_mejs_display_and_function,
);

$control_mejs_button_color = array(
  'keys' => array(
    'value' => 'mejs_controls_button_color',
    'alt'   => 'mejs_controls_button_color_alt',
  ),
  'type'    => 'color',
  'label'   => __( 'Buttons', '__x__' ),
  'options' => $options_base_interaction_labels,
);

$control_mejs_time_total_and_loaded_bg_color = array(
  'keys' => array(
    'value' => 'mejs_controls_time_total_bg_color',
    'alt'   => 'mejs_controls_time_loaded_bg_color',
  ),
  'type'  => 'color',
  'label' => __( 'Time Progress', '__x__' ),
  'options' => array(
    'label'     => __( 'Total', '__x__' ),
    'alt_label' => __( 'Loaded', '__x__' ),
  ),
);

$control_mejs_time_current_bg_color = array(
  'keys'  => array( 'value' => 'mejs_controls_time_current_bg_color' ),
  'type'  => 'color',
  'label' => __( 'Time Current', '__x__' ),
);

$control_mejs_controls_color = array(
  'keys'  => array( 'value' => 'mejs_controls_color' ),
  'type'  => 'color',
  'label' => __( 'Text', '__x__' ),
);

$control_mejs_controls_bg_color = array(
  'keys'  => array( 'value' => 'mejs_controls_bg_color' ),
  'type'  => 'color',
  'label' => __( 'Background', '__x__' ),
);



// Control Lists
// =============================================================================

$control_list_mejs_adv_setup = array(
  $control_mejs_preload,
  $control_mejs_display_and_function,
);

$control_list_mejs_adv_controls_colors = array(
  $control_mejs_button_color,
  $control_mejs_time_total_and_loaded_bg_color,
  $control_mejs_time_current_bg_color,
  $control_mejs_controls_color,
  $control_mejs_controls_bg_color,
);

$control_list_mejs_std_design_setup = array(
  $control_mejs_preload,
  $control_mejs_display_and_function,
);

$control_list_mejs_std_design_colors_controls = array(
  $control_mejs_button_color,
  $control_mejs_time_total_and_loaded_bg_color,
  $control_mejs_time_current_bg_color,
  $control_mejs_controls_color,
  $control_mejs_controls_bg_color,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_mejs_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . ' Controls Setup', '__x__' ),
    'group'      => $group,
    'conditions' => $conditions,
    'controls'   => $control_list_mejs_adv_setup,
  ),
);

$control_group_mejs_adv_controls_colors = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . ' Controls Colors', '__x__' ),
    'group'      => $group,
    'conditions' => $conditions,
    'controls'   => $control_list_mejs_adv_controls_colors,
  ),
);



// Control Groups (Standard Design)
// =============================================================================

$control_group_mejs_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( ucfirst( $type ) . ' Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_mejs_std_design_setup,
  ),
);

$control_group_mejs_std_design_colors = array_merge(
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Base Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => array(
        array(
          'keys'      => array( 'value' => 'mejs_controls_box_shadow_color' ),
          'type'      => 'color',
          'label'     => __( 'Box<br>Shadow', '__x__' ),
          'condition' => array( 'key' => 'mejs_controls_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
        ),
        array(
          'keys'      => array( 'value' => 'mejs_controls_time_rail_box_shadow_color' ),
          'type'      => 'color',
          'label'     => __( 'Time Rail Box Shadow', '__x__' ),
          'condition' => array( 'key' => 'mejs_controls_time_rail_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
        ),
      ),
    ),
    array(
      'type'       => 'group',
      'title'      => __( 'Controls Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_mejs_std_design_colors_controls,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_mejs_controls,
      array(
        't_pre'     => __( 'Controls', '__x__' ),
        'group'     => $group_std_design,
        'options'   => $options_color_only,
        'condition' => array_merge( $condition, array(
          array( 'key' => 'mejs_controls_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'mejs_controls_border_style', 'op' => '!=', 'value' => 'none' )
        ) ),
      )
    )
  )
);
