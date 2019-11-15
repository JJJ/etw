<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/FRAME.PHP
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

function x_control_partial_frame( $settings ) {

  // Setup
  // -----

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'frame';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Frame', '__x__' );
  $conditions  = ( isset( $settings['conditions'] )  ) ? $settings['conditions']   : array();



  // Groups
  // ------

  $group_frame_setup  = $group . ':setup';
  $group_frame_design = $group . ':design';



  // Conditions
  // ----------

  $conditions_frame_border_color = array_merge( $conditions, array( array( 'key' => 'frame_border_width', 'op' => 'NOT EMPTY' ), array( 'key' => 'frame_border_width', 'op' => 'NOT EMPTY' ) ) );

  // Options
  // -------

  $options_frame_content_sizing = array(
    'choices' => array(
      array( 'value' => 'aspect-ratio', 'label' => __( 'Aspect Ratio', '__x__' ) ),
      array( 'value' => 'fixed-height', 'label' => __( 'Fixed Height', '__x__' ) ),
    ),
  );

  $options_frame_base_font_size = array(
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



  // Settings
  // --------

  $settings_frame = array(
    'k_pre'        => 'frame',
    'label_prefix' => __( 'Frame', '__x__' ),
    'group'        => $group_frame_design,
    'conditions'   => $conditions,
  );

  // Individual Controls
  // -------------------

  $control_frame_content_sizing = array(
    'key'     => 'frame_content_sizing',
    'type'    => 'choose',
    'label'   => __( 'Content Sizing', '__x__' ),
    'options' => $options_frame_content_sizing,
  );

  $control_frame_base_font_size = array(
    'key'     => 'frame_base_font_size',
    'type'    => 'slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => $options_frame_base_font_size,
  );

  $control_frame_width = array(
    'key'     => 'frame_width',
    'type'    => 'unit',
    'label'   => __( 'Width', '__x__' ),
    'options' => $options_frame_width,
  );

  $control_frame_max_width = array(
    'key'     => 'frame_max_width',
    'type'    => 'unit',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => $options_frame_max_width,
  );

  $control_frame_width_and_max_width = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Max Width', '__x__' ),
    'controls' => array(
      $control_frame_width,
      $control_frame_max_width,
    ),
  );

  $control_frame_content_aspect_ratio = array(
    'keys' => array(
      'width'  => 'frame_content_aspect_ratio_width',
      'height' => 'frame_content_aspect_ratio_height',
    ),
    'type'      => 'aspect-ratio',
    'label'     => __( 'Content Aspect Ratio', '__x__' ),
    'condition' => array( 'frame_content_sizing' => 'aspect-ratio' )
  );

  $control_frame_content_height = array(
    'key'       => 'frame_content_height',
    'type'      => 'unit-slider',
    'label'     => __( 'Content Height', '__x__' ),
    'options'   => $options_frame_height,
    'condition' => array( 'frame_content_sizing' => 'fixed-height' )
  );

  $control_frame_bg_color = array(
    'key'   => 'frame_bg_color',
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );


  // Compose Controls
  // ----------------

  return array(
    'controls' => array_merge(
      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => $group_frame_setup,
          'conditions' => $conditions,
          'controls'   => array(
            $control_frame_content_sizing,
            $control_frame_base_font_size,
            $control_frame_width_and_max_width,
            $control_frame_content_aspect_ratio,
            $control_frame_content_height,
            $control_frame_bg_color,
          ),
        ),
      ),
      x_control_margin( $settings_frame ),
      x_control_border( $settings_frame ),
      x_control_border_radius( $settings_frame ),
      x_control_padding( $settings_frame ),
      x_control_box_shadow( $settings_frame )
    ),
    'controls_std_content' => array(),
    'controls_std_design_setup' => array(
      array(
        'type'       => 'group',
        'label'      => __( 'Frame Setup', '__x__' ),
        'conditions' => $conditions,
        'controls'   => array(
          $control_frame_content_sizing,
          $control_frame_base_font_size,
          cs_amend_control( $control_frame_width, array( 'type' => 'unit-slider') ),
          cs_amend_control( $control_frame_max_width, array( 'type' => 'unit-slider') ),
          $control_frame_content_aspect_ratio,
          $control_frame_content_height,
        ),
      ),
      cs_control( 'margin', 'frame', $settings_frame )
    ),
    'controls_std_design_colors' => array_merge(
      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Frame Base Colors', '__x__' ),
          'conditions' => $conditions,
          'controls'   => array(
            array(
              'keys'      => array( 'value' => 'frame_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'frame_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_frame_bg_color,
          ),
        ),
      ),
      x_control_border(
        array_merge(
          $settings_frame,
          array(
            'options'   => array( 'color_only' => true ),
            'conditions' => array_merge( $conditions, array(
              array( 'key' => 'frame_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => 'frame_border_style', 'op' => '!=', 'value' => 'none' )
            ) ),
          )
        )
      )
    ),
    'control_nav' => array(
      $group              => $group_title,
      $group_frame_setup  => __( 'Setup', '__x__' ),
      $group_frame_design => __( 'Design', '__x__' ),
    )
  );
}

cs_register_control_partial( 'frame', 'x_control_partial_frame' );
