<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/MODAL.PHP
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

function x_control_partial_modal( $settings ) {


  // Setup
  // -----

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'modal';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Modal', '__x__' );
  $conditions  = ( isset( $settings['conditions'] )  ) ? $settings['conditions']   : array();



  // Groups
  // ------

  $group_modal_setup  = $group . ':setup';
  $group_modal_design = $group . ':design';


  // Options
  // -------

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


  // Settings
  // --------

  $settings_modal_content = array(
    'k_pre'      => 'modal_content',
    'label_prefix'      => __( 'Modal Content', '__x__' ),
    'group'      => $group_modal_design,
    'conditions' => $conditions,
  );



  // Individual Controls
  // -------------------

  $control_modal_base_font_size = array(
    'key'     => 'modal_base_font_size',
    'type'    => 'slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => $options_modal_font_size,
  );

  $control_modal_close_location = array(
    'key'     => 'modal_close_location',
    'type'    => 'select',
    'label'   => __( 'Close Location', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'top-left',     'label' => __( 'Top Left', '__x__' )     ),
        array( 'value' => 'top-right',    'label' => __( 'Top Right', '__x__' )    ),
        array( 'value' => 'bottom-left',  'label' => __( 'Bottom Left', '__x__' )  ),
        array( 'value' => 'bottom-right', 'label' => __( 'Bottom Right', '__x__' ) ),
      ),
    ),
  );

  $control_modal_close_size_and_dimensions = array(
    'type'     => 'group',
    'label'    => __( 'Close Size &amp; Dimensions', '__x__' ),
    'controls' => array(
      array(
        'key'     => 'modal_close_font_size',
        'type'    => 'unit',
        'options' => $options_modal_font_size,
      ),
      array(
        'key'     => 'modal_close_dimensions',
        'type'    => 'select',
        'options' => array(
          'choices' => array(
            array( 'value' => '1',   'label' => __( 'Small', '__x__' ) ),
            array( 'value' => '1.5', 'label' => __( 'Medium', '__x__' ) ),
            array( 'value' => '2',   'label' => __( 'Large', '__x__' ) ),
          ),
        ),
      ),
    ),
  );

  $control_modal_content_max_width = array(
    'key'     => 'modal_content_max_width',
    'type'    => 'slider',
    'label'   => __( 'Content Max Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'fallback_value'  => '450px',
      'valid_keywords'  => array( 'none' ),
      'ranges'          => array(
        'px'  => array( 'min' => 500, 'max' => 1000, 'step' => 1    ),
        'em'  => array( 'min' => 25,  'max' => 100,  'step' => 0.1  ),
        'rem' => array( 'min' => 25,  'max' => 100,  'step' => 0.1  ),
        '%'   => array( 'min' => 80,  'max' => 100,  'step' => 0.01 ),
      ),
    )
  );

  $control_modal_bg_color = array(
    'key'   => 'modal_bg_color',
    'type'  => 'color',
    'label' => __( 'Overlay Background', '__x__' ),
  );

  $control_modal_close_colors = array(
    'keys' => array(
      'value' => 'modal_close_color',
      'alt'   => 'modal_close_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Close Button', '__x__' ),
    'options' => cs_recall( 'options_base_interaction_labels' ),
  );

  $control_modal_content_bg_color = array(
    'key'   => 'modal_content_bg_color',
    'type'  => 'color',
    'label' => __( 'Content Background', '__x__' ),
  );

  // Compose Controls
  // ----------------

  return array(
    'controls' => array_merge(
      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => $group_modal_setup,
          'conditions' => $conditions,
          'controls'   => array(
            $control_modal_base_font_size,
            $control_modal_close_location,
            $control_modal_close_size_and_dimensions,
            $control_modal_content_max_width,
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => __( 'Colors', '__x__' ),
          'group'      => $group_modal_design,
          'conditions' => $conditions,
          'controls'   => array(
            $control_modal_bg_color,
            $control_modal_close_colors,
            $control_modal_content_bg_color,
          ),
        ),
      ),
      x_control_padding( $settings_modal_content ),
      x_control_border( $settings_modal_content ),
      x_control_border_radius( $settings_modal_content ),
      x_control_box_shadow( $settings_modal_content )
    ),
    'controls_std_design_setup' => array(
      array(
        'type'       => 'group',
        'label'      => __( 'Modal Design Setup', '__x__' ),
        'conditions' => $conditions,
        'controls'   => array(
          $control_modal_base_font_size,
          $control_modal_content_max_width,
        ),
      ),
    ),
    'controls_std_design_colors' => array_merge(
      array(
        array(
          'type'     => 'group',
          'label'    => __( 'Modal Base Colors', '__x__' ),
          'controls' => array(
            $control_modal_bg_color,
            $control_modal_close_colors,
            array(
              'keys'      => array( 'value' => 'modal_content_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'modal_content_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
            ),
            $control_modal_content_bg_color,
          ),
        ),
      ),
      x_control_border(
        array_merge(
          $settings_modal_content,
          array(
            'options'   => array( 'color_only' => true ),
            'conditions' => array_merge( $conditions, array(
              array( 'key' => 'modal_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => 'modal_border_style', 'op' => '!=', 'value' => 'none' ),
            ) ),
          )
        )
      )
    ),
    'control_nav' => array(
      $group             => $group_title,
      $group . ':setup'  => __( 'Setup', '__x__' ),
      $group . ':design' => __( 'Design', '__x__' ),
    )
  );
}

cs_register_control_partial( 'modal', 'x_control_partial_modal' );
