<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/FRAME.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Group
//   03. Values
// =============================================================================

// Controls
// =============================================================================

function x_controls_frame( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'frame';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();

  $group_setup  = $group . ':setup';
  $group_design = $group . ':design';


  // Setup - Conditions
  // ------------------

  $conditions = x_module_conditions( $condition );


  // Setup - Options
  // ---------------

  $options_frame_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '16px',
    'ranges'          => array(
      'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1   ),
      'em'  => array( 'min' => 0.5, 'max' => 2.5, 'step' => 0.1 ),
      'rem' => array( 'min' => 0.5, 'max' => 2.5, 'step' => 0.1 ),
    ),
  );

  $options_frame_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '100%',
    'ranges'          => array(
      'px'  => array( 'min' => 100, 'max' => 500, 'step' => 10  ),
      'em'  => array( 'min' => 5,   'max' => 40,  'step' => 0.5 ),
      'rem' => array( 'min' => 5,   'max' => 40,  'step' => 0.5 ),
      '%'   => array( 'min' => 0,   'max' => 100, 'step' => 1   ),
    ),
  );

  $options_frame_max_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'valid_keywords'  => array( 'calc', 'none' ),
    'fallback_value'  => '500px',
    'ranges'          => array(
      'px'  => array( 'min' => 100, 'max' => 500, 'step' => 10  ),
      'em'  => array( 'min' => 5,   'max' => 40,  'step' => 0.5 ),
      'rem' => array( 'min' => 5,   'max' => 40,  'step' => 0.5 ),
      '%'   => array( 'min' => 0,   'max' => 100, 'step' => 1   ),
    ),
  );

  $options_frame_height = array(
    'available_units' => array( 'px', 'em', 'rem', 'vw', 'vh' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '350px',
    'ranges'          => array(
      'px'  => array( 'min' => 100, 'max' => 500, 'step' => 10  ),
      'em'  => array( 'min' => 5,   'max' => 40,  'step' => 0.5 ),
      'rem' => array( 'min' => 5,   'max' => 40,  'step' => 0.5 ),
      'vw'  => array( 'min' => 1,   'max' => 100, 'step' => 1   ),
      'vh'  => array( 'min' => 1,   'max' => 100, 'step' => 1   ),
    ),
  );


  // Setup - Settings
  // ----------------

  $settings_frame = array(
    'k_pre'      => 'frame',
    't_pre'      => __( 'Frame', '__x__' ),
    'group'      => $group_design,
    'conditions' => $conditions,
  );


  // Returned Value
  // --------------

  $controls = array_merge(
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Setup', '__x__' ),
        'group'      => $group_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'frame_content_sizing',
            'type'    => 'choose',
            'label'   => __( 'Content Sizing', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'aspect-ratio', 'label' => __( 'Aspect Ratio', '__x__' ) ),
                array( 'value' => 'fixed-height', 'label' => __( 'Fixed Height', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'     => 'frame_base_font_size',
            'type'    => 'slider',
            'title'   => __( 'Base Font Size', '__x__' ),
            'options' => $options_frame_font_size,
          ),
          array(
            'type'     => 'group',
            'title'    => __( 'Width &amp; Max Width', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'frame_width',
                'type'    => 'unit',
                'options' => $options_frame_width,
              ),
              array(
                'key'     => 'frame_max_width',
                'type'    => 'unit',
                'options' => $options_frame_max_width,
              ),
            ),
          ),
          array(
            'keys' => array(
              'width'  => 'frame_content_aspect_ratio_width',
              'height' => 'frame_content_aspect_ratio_height',
            ),
            'type'      => 'aspect-ratio',
            'label'     => __( 'Content Aspect Ratio', '__x__' ),
            'condition' => array( 'frame_content_sizing' => 'aspect-ratio' )
          ),
          array(
            'key'       => 'frame_content_height',
            'type'      => 'unit-slider',
            'title'     => __( 'Content Height', '__x__' ),
            'options'   => $options_frame_height,
            'condition' => array( 'frame_content_sizing' => 'fixed-height' )
          ),
          array(
            'key'   => 'frame_bg_color',
            'type'  => 'color',
            'title' => __( 'Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_frame ),
    x_control_border( $settings_frame ),
    x_control_border_radius( $settings_frame ),
    x_control_padding( $settings_frame ),
    x_control_box_shadow( $settings_frame )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_frame( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group'] : 'frame';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Frame', '__x__' );

  $control_groups = array(
    $group             => array( 'title' => $group_title ),
    $group . ':setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design' => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_frame( $settings = array() ) {

  // Setup
  // -----

  $type = ( isset( $settings['type'] ) ) ? $settings['type'] : '';


  // Values
  // ------

  $values = array(
    'frame_content_type'                => x_module_value( $type, 'markup' ),
    'frame_content_sizing'              => x_module_value( 'aspect-ratio', 'style' ),
    'frame_base_font_size'              => x_module_value( '16px', 'style' ),
    'frame_width'                       => x_module_value( '100%', 'style' ),
    'frame_max_width'                   => x_module_value( 'none', 'style' ),
    'frame_content_aspect_ratio_width'  => x_module_value( '16', 'style' ),
    'frame_content_aspect_ratio_height' => x_module_value( '9', 'style' ),
    'frame_content_height'              => x_module_value( '350px', 'style' ),
    'frame_bg_color'                    => x_module_value( '#ffffff', 'style:color' ),
    'frame_margin'                      => x_module_value( '0em', 'style' ),
    'frame_padding'                     => x_module_value( '0em', 'style' ),
    'frame_border_width'                => x_module_value( '0px', 'style' ),
    'frame_border_style'                => x_module_value( 'none', 'style' ),
    'frame_border_color'                => x_module_value( 'transparent', 'style:color' ),
    'frame_border_radius'               => x_module_value( '0em', 'style' ),
    'frame_box_shadow_dimensions'       => x_module_value( '0em 0em 0em 0em', 'style' ),
    'frame_box_shadow_color'            => x_module_value( 'transparent', 'style:color' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
