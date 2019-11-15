<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/MEJS.PHP
// -----------------------------------------------------------------------------
// Element Controls
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
// =============================================================================

// Controls
// =============================================================================

function x_control_partial_mejs( $settings ) {

    // Setup
  // -----

  // 01. Available types:
  //     -- 'audio'
  //     -- 'video'

  $label_prefix = ( isset( $settings['label_prefix'] ) ) ? $settings['label_prefix'] : '';
  $group        = ( isset( $settings['group'] )        ) ? $settings['group']        : 'mejs';
  $conditions   = ( isset( $settings['conditions'] )   ) ? $settings['conditions']   : array();
  $type         = ( isset( $settings['type'] )         ) ? $settings['type']         : 'audio'; // 01

  $type_label = '';

  if ( $type === 'audio' ) {
    $type_label = __( 'Audio', '__x__' );
  } elseif ( $type === 'video' ) {
    $type_label = __( 'Video', '__x__' );
  }


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
    array( 'key' => 'hide_controls',     'label' => __( 'No Controls', '__x__' ) ),
    array( 'key' => 'advanced_controls', 'label' => __( 'Advanced', '__x__' ) ),
    array( 'key' => 'autoplay',          'label' => __( 'Autoplay', '__x__' ) ),
    array( 'key' => 'loop',              'label' => __( 'Loop', '__x__' ) ),
    array( 'key' => 'muted',             'label' => __( 'Muted', '__x__' ) ),
  );

  if ( $type === 'audio' ) {
    array_shift( $keys_mejs_display_and_function );
    array_shift( $options_list_mejs_display_and_function );
    array_pop( $keys_mejs_display_and_function );
    array_pop( $options_list_mejs_display_and_function );
  }



  // Options
  // =============================================================================

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
    'label_prefix'     => __( 'Controls', '__x__' ),
    'group'     => $group,
    'conditions' => $conditions
  );

  $settings_mejs_controls_time_rail = array(
    'k_pre'     => 'mejs_controls_time_rail',
    'label_prefix'     => __( 'Time Rail', '__x__' ),
    'group'     => $group,
    'conditions' => $conditions
  );

  $settings_mejs_video_controls_margin = array(
    'k_pre'     => 'mejs_controls',
    'label_prefix'     => __( 'Controls', '__x__' ),
    'group'     => $group,
    'conditions' => $conditions,
    'options' => array(
      'top'    => array(
        'disabled'       => true,
        'valid_keywords' => array( 'auto' ),
        'fallback_value' => 'auto',
      ),
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
    'options' => array(
      'choices' => array(
        array( 'value' => 'none',     'label' => __( 'None', '__x__' )     ),
        array( 'value' => 'auto',     'label' => __( 'Auto', '__x__' )     ),
        array( 'value' => 'metadata', 'label' => __( 'Metadata', '__x__' ) ),
      ),
    ),
  );

  $control_mejs_display_and_function = array(
    'keys'    => $keys_mejs_display_and_function,
    'type'    => 'checkbox-list',
    'label'   => __( 'Display &amp; Function', '__x__' ),
    'options' => array(
      'list' => $options_list_mejs_display_and_function,
    ),
  );

  $control_mejs_button_color = array(
    'keys' => array(
      'value' => 'mejs_controls_button_color',
      'alt'   => 'mejs_controls_button_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Buttons', '__x__' ),
    'options' => cs_recall( 'options_base_interaction_labels' ),
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
      'label'      => __( '{{prefix}} Controls Setup', '__x__' ),
      'label_vars' => array( 'prefix' => $label_prefix ),
      'group'      => $group,
      'conditions' => $conditions,
      'controls'   => $control_list_mejs_adv_setup,
    ),
  );

  $control_group_mejs_adv_controls_colors = array(
    array(
      'type'       => 'group',
      'label'      => __( '{{prefix}} Controls Colors', '__x__' ),
      'label_vars' => array( 'prefix' => $label_prefix ),
      'group'      => $group,
      'conditions' => $conditions,
      'controls'   => $control_list_mejs_adv_controls_colors,
    ),
  );

  $controls = array_merge(
    $control_group_mejs_adv_setup,
    $control_group_mejs_adv_controls_colors
  );

  if ( $type === 'video' ) {
    $controls = array_merge(
      $controls,
      x_control_margin( $settings_mejs_video_controls_margin )
    );
  }

  return array(
    'controls' => array_merge(
      $controls,
      x_control_padding( $settings_mejs_controls ),
      x_control_border( $settings_mejs_controls ),
      x_control_border_radius( $settings_mejs_controls ),
      x_control_box_shadow( $settings_mejs_controls ),
      x_control_border_radius( $settings_mejs_controls_time_rail ),
      x_control_box_shadow( $settings_mejs_controls_time_rail )
    ),
    'controls_std_content' => array(),
    'controls_std_design_setup' => array(
      array(
        'type'       => 'group',
        'label'      => __( '{{type}} Setup', '__x__' ),
        'label_vars' => array( 'type' => $type_label ),
        'conditions' => $conditions,
        'controls'   => $control_list_mejs_std_design_setup,
      ),
    ),
    'controls_std_design_colors' => array_merge( array(
      array(
        'type'       => 'group',
        'label'      => __( 'Base Colors', '__x__' ),
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
        'label'      => __( 'Controls Colors', '__x__' ),
        'conditions' => $conditions,
        'controls'   => $control_list_mejs_std_design_colors_controls,
      ),
    ), x_control_border(
      array_merge(
        $settings_mejs_controls,
        array(
          'label_prefix'     => __( 'Controls', '__x__' ),
          'options'   => array( 'color_only' => true ),
          'conditions' => array_merge( $conditions, array(
            array( 'key' => 'mejs_controls_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'mejs_controls_border_style', 'op' => '!=', 'value' => 'none' )
          ) ),
        )
      )
    ) )
  );
}

cs_register_control_partial( 'mejs', 'x_control_partial_mejs' );
