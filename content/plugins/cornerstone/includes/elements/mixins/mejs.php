<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/MEJS.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Control
//   02. Values
// =============================================================================

// Control
// =============================================================================

function x_controls_mejs( $settings = array() ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'audio'
  //     -- 'video'

  $t_pre     = ( isset( $settings['t_pre'] )     ) ? $settings['t_pre'] . ' ' : '';
  $group     = ( isset( $settings['group'] )     ) ? $settings['group']       : 'mejs';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition']   : array();
  $type      = ( isset( $settings['type'] )      ) ? $settings['type']        : 'audio'; // 01

  $conditions = x_module_conditions( $condition );


  // Setup - Settings
  // ----------------

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
      'top' => array(
        'disabled'       => true,
        'valid_keywords' => array( 'auto' ),
        'fallback_value' => 'auto',
      ),
      'left' => array(
        'available_units' => array( 'px', 'em', 'rem' ),
        'fallback_value'  => '10px',
        'valid_keywords'  => array( 'calc' ),
        'ranges'          => array(
          'px'  => array( 'min' => 0, 'max' => 20, 'step' => 1    ),
          'em'  => array( 'min' => 0, 'max' => 1,  'step' => 0.01 ),
          'rem' => array( 'min' => 0, 'max' => 1,  'step' => 0.01 ),
        ),
      ),
      'right' => array(
        'available_units' => array( 'px', 'em', 'rem' ),
        'fallback_value'  => '10px',
        'valid_keywords'  => array( 'calc' ),
        'ranges'          => array(
          'px'  => array( 'min' => 0, 'max' => 20, 'step' => 1    ),
          'em'  => array( 'min' => 0, 'max' => 1,  'step' => 0.01 ),
          'rem' => array( 'min' => 0, 'max' => 1,  'step' => 0.01 ),
        ),
      ),
      'bottom' => array(
        'available_units' => array( 'px', 'em', 'rem' ),
        'fallback_value'  => '10px',
        'valid_keywords'  => array( 'calc' ),
        'ranges'          => array(
          'px'  => array( 'min' => 0, 'max' => 20, 'step' => 1    ),
          'em'  => array( 'min' => 0, 'max' => 1,  'step' => 0.01 ),
          'rem' => array( 'min' => 0, 'max' => 1,  'step' => 0.01 ),
        ),
      ),
    ),
  );


  // Setup - Controls (Setup)
  // ------------------------

  $mejs_display_and_function_keys = array(
    'hide_controls'     => 'mejs_hide_controls',
    'advanced_controls' => 'mejs_advanced_controls',
    'autoplay'          => 'mejs_autoplay',
    'loop'              => 'mejs_loop',
    'muted'             => 'mejs_muted',
  );

  $mejs_display_and_function_options_list = array(
    array( 'key' => 'hide_controls',     'label' => __( 'No Controls', '__x__' ), 'half' => true ),
    array( 'key' => 'advanced_controls', 'label' => __( 'Advanced', '__x__' ),    'half' => true ),
    array( 'key' => 'autoplay',          'label' => __( 'Autoplay', '__x__' ),    'half' => true ),
    array( 'key' => 'loop',              'label' => __( 'Loop', '__x__' ),        'half' => true ),
    array( 'key' => 'muted',             'label' => __( 'Muted', '__x__' ),       'half' => true ),
  );

  if ( $type === 'audio' ) {
    // unset( $mejs_display_and_function_keys['hide_controls'] );
    // unset( $mejs_display_and_function_keys['muted'] );
    array_shift( $mejs_display_and_function_keys );
    array_shift( $mejs_display_and_function_options_list );
    array_pop( $mejs_display_and_function_keys );
    array_pop( $mejs_display_and_function_options_list );
  }


  // Data
  // ----

  $data = array(
    array(
      'type'       => 'group',
      'title'      => __( $t_pre . ' Controls Setup', '__x__' ),
      'group'      => $group,
      'conditions' => $conditions,
      'controls'   => array(
        array(
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
        ),
        array(
          'keys' => $mejs_display_and_function_keys,
          'type'    => 'checkbox-list',
          'label'   => __( 'Display &amp; Function', '__x__' ),
          'options' => array(
            'list' => $mejs_display_and_function_options_list,
          ),
        ),
      ),
    ),
    array(
      'type'       => 'group',
      'title'      => __( $t_pre . ' Controls Colors', '__x__' ),
      'group'      => $group,
      'conditions' => $conditions,
      'controls'   => array(
        array(
          'keys' => array(
            'value' => 'mejs_controls_button_color',
            'alt'   => 'mejs_controls_button_color_alt',
          ),
          'type'    => 'color',
          'label'   => __( 'Buttons', '__x__' ),
          'options' => array(
            'label'     => __( 'Base', '__x__' ),
            'alt_label' => __( 'Interaction', '__x__' ),
          ),
        ),
        array(
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
        ),
        array(
          'keys' => array(
            'value' => 'mejs_controls_time_current_bg_color',
          ),
          'type'  => 'color',
          'label' => __( 'Time Current', '__x__' ),
        ),
        array(
          'keys' => array(
            'value' => 'mejs_controls_color',
          ),
          'type'  => 'color',
          'label' => __( 'Text', '__x__' ),
        ),
        array(
          'keys' => array(
            'value' => 'mejs_controls_bg_color',
          ),
          'type'  => 'color',
          'label' => __( 'Background', '__x__' ),
        ),
      ),
    ),
  );

  if ( $type === 'video' ) {
    $data = array_merge(
      $data,
      x_control_margin( $settings_mejs_video_controls_margin )
    );
  }

  $data = array_merge(
    $data,
    x_control_padding( $settings_mejs_controls ),
    x_control_border( $settings_mejs_controls ),
    x_control_border_radius( $settings_mejs_controls ),
    x_control_box_shadow( $settings_mejs_controls ),
    x_control_border_radius( $settings_mejs_controls_time_rail ),
    x_control_box_shadow( $settings_mejs_controls_time_rail )
  );


  // Returned Value
  // --------------

  $controls = $data;

  return $controls;

}



// Values
// =============================================================================

function x_values_mejs( $settings = array() ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'audio'
  //     -- 'video'

  $type = ( isset( $settings['type'] ) ) ? $settings['type'] : 'audio'; // 01


  // Values
  // ------

  $values = array(
    'mejs_type'                                     => x_module_value( $type, 'style' ),
    'mejs_preload'                                  => x_module_value( 'metadata', 'markup' ),
    'mejs_advanced_controls'                        => x_module_value( false, 'markup' ),
    'mejs_autoplay'                                 => x_module_value( false, 'markup' ),
    'mejs_loop'                                     => x_module_value( false, 'markup' ),
    'mejs_controls_button_color'                    => x_module_value( 'rgba(255, 255, 255, 0.5)', 'style:color' ),
    'mejs_controls_button_color_alt'                => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'mejs_controls_time_total_bg_color'             => x_module_value( 'rgba(255, 255, 255, 0.25)', 'style:color' ),
    'mejs_controls_time_loaded_bg_color'            => x_module_value( 'rgba(255, 255, 255, 0.25)', 'style:color' ),
    'mejs_controls_time_current_bg_color'           => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'mejs_controls_color'                           => x_module_value( 'rgba(255, 255, 255, 0.5)', 'style:color' ),
    'mejs_controls_bg_color'                        => x_module_value( 'rgba(0, 0, 0, 0.8)', 'style:color' ),
    'mejs_controls_padding'                         => x_module_value( '0px', 'style' ),
    'mejs_controls_border_width'                    => x_module_value( '0px', 'style' ),
    'mejs_controls_border_style'                    => x_module_value( 'none', 'style' ),
    'mejs_controls_border_color'                    => x_module_value( 'transparent', 'style' ),
    'mejs_controls_border_radius'                   => x_module_value( '3px', 'style' ),
    'mejs_controls_box_shadow_dimensions'           => x_module_value( '0em 0em 0em 0em', 'style' ),
    'mejs_controls_box_shadow_color'                => x_module_value( 'transparent', 'style' ),
    'mejs_controls_time_rail_border_radius'         => x_module_value( '2px', 'style' ),
    'mejs_controls_time_rail_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
    'mejs_controls_time_rail_box_shadow_color'      => x_module_value( 'transparent', 'style' ),
  );

  if ( $type === 'video' ) {
    $values = array_merge(
      $values,
      array(
        'mejs_hide_controls'   => x_module_value( false, 'markup' ),
        'mejs_muted'           => x_module_value( false, 'markup' ),
        'mejs_controls_margin' => x_module_value( 'auto 15px 15px 15px', 'style' ),
      )
    );
  }


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}