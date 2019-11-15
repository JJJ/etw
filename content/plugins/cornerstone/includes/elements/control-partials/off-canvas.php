<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/OFF-CANVAS.PHP
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

function x_control_partial_off_canvas( $settings ) {


  // Setup
  // -----

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'off_canvas';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Off Canvas', '__x__' );
  $conditions  = ( isset( $settings['conditions'] )  ) ? $settings['conditions']  : array();
  $lr_only     = ( isset( $settings['lr_only'] )     ) ? $settings['lr_only']     : false;
  $tb_only     = ( isset( $settings['tb_only'] )     ) ? $settings['tb_only']     : false;
  $tbf_only    = ( isset( $settings['tbf_only'] )    ) ? $settings['tbf_only']    : false;
  $ctbf_only   = ( isset( $settings['ctbf_only'] )   ) ? $settings['ctbf_only']   : false;



  // Groups
  // ------

  $group_off_canvas_setup  = $group . ':setup';
  $group_off_canvas_design = $group . ':design';



  // Conditions
  // ----------

  $lr_only   = ( $lr_only )   ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'left', 'right' ) )                      : array();
  $tb_only   = ( $tb_only )   ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'top', 'bottom' ) )                      : array();
  $tbf_only  = ( $tbf_only )  ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'top', 'bottom', 'footer' ) )            : array();
  $ctbf_only = ( $ctbf_only ) ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'content', 'top', 'bottom', 'footer' ) ) : array();

  $conditions = array_merge( $conditions, array( $lr_only, $tb_only, $tbf_only, $ctbf_only ) );



  // Options
  // -------

  $options_off_canvas_font_size = array(
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

  $settings_off_canvas_content = array(
    'k_pre'     => 'off_canvas_content',
    'label_prefix'     => __( 'Content', '__x__' ),
    'group'     => $group,
    'conditions' => $conditions
  );



  // Individual Controls
  // -------------------

  $control_off_canvas_base_font_size = array(
    'key'     => 'off_canvas_base_font_size',
    'type'    => 'slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => $options_off_canvas_font_size,
  );

  $control_off_canvas_location = array(
    'key'     => 'off_canvas_location',
    'type'    => 'choose',
    'label'   => __( 'Location', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'left',  'label' => __( 'Left', '__x__' )  ),
        array( 'value' => 'right', 'label' => __( 'Right', '__x__' ) ),
      ),
    ),
  );

  $control_off_canvas_close_size_and_dimensions = array(
    'type'     => 'group',
    'label'    => __( 'Close Size &amp; Dimensions', '__x__' ),
    'controls' => array(
      array(
        'key'     => 'off_canvas_close_font_size',
        'type'    => 'unit',
        'options' => $options_off_canvas_font_size,
      ),
      array(
        'key'     => 'off_canvas_close_dimensions',
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

  $control_off_canvas_content_max_width = array(
    'key'     => 'off_canvas_content_max_width',
    'type'    => 'slider',
    'label'   => __( 'Content Max Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'fallback_value'  => '400px',
      'valid_keywords'  => array( 'none' ),
      'ranges'          => array(
        'px'  => array( 'min' => 300, 'max' => 500, 'step' => 1    ),
        'em'  => array( 'min' => 30,  'max' => 50,  'step' => 0.01 ),
        'rem' => array( 'min' => 30,  'max' => 50,  'step' => 0.01 ),
        '%'   => array( 'min' => 80,  'max' => 100, 'step' => 0.01 ),
      ),
    ),
  );

  $control_off_canvas_bg_color = array(
    'key'   => 'off_canvas_bg_color',
    'type'  => 'color',
    'label' => __( 'Overlay Background', '__x__' ),
  );

  $control_off_canvas_close_colors = array(
    'keys' => array(
      'value' => 'off_canvas_close_color',
      'alt'   => 'off_canvas_close_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Close Button', '__x__' ),
    'options' => cs_recall( 'options_base_interaction_labels' ),
  );

  $control_off_canvas_content_bg_color = array(
    'key'   => 'off_canvas_content_bg_color',
    'type'  => 'color',
    'label' => __( 'Content Background', '__x__' ),
  );


  // Control Groups (Standard Design)
  // =============================================================================

  return array(
    'controls' => array_merge(
      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => $group_off_canvas_setup,
          'conditions' => $conditions,
          'controls'   => array(
            $control_off_canvas_base_font_size,
            $control_off_canvas_location,
            $control_off_canvas_close_size_and_dimensions,
            $control_off_canvas_content_max_width,
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => __( 'Colors', '__x__' ),
          'group'      => $group_off_canvas_design,
          'conditions' => $conditions,
          'controls'   => array(
            $control_off_canvas_bg_color,
            $control_off_canvas_close_colors,
            $control_off_canvas_content_bg_color,
          ),
        ),
      ),
      x_control_border( $settings_off_canvas_content ),
      x_control_box_shadow( $settings_off_canvas_content )
    ),
    'controls_std_design_setup' => array(
      array(
        'type'       => 'group',
        'label'      => __( 'Off Canvas Design Setup', '__x__' ),
        'conditions' => $conditions,
        'controls'   => array(
          $control_off_canvas_base_font_size,
          $control_off_canvas_content_max_width,
        ),
      ),
    ),
    'controls_std_design_colors' => array_merge(
      array(
        array(
          'type'     => 'group',
          'label'    => __( 'Off Canvas Base Colors', '__x__' ),
          'controls' => array(
            $control_off_canvas_bg_color,
            $control_off_canvas_close_colors,
            array(
              'keys'      => array( 'value' => 'off_canvas_content_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'off_canvas_content_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
            ),
            $control_off_canvas_content_bg_color,
          ),
        ),
      ),
      x_control_border(
        array_merge(
          $settings_off_canvas_content,
          array(
            'options'   => array( 'color_only' => true ),
            'conditions' => array_merge( $conditions, array(
              array( 'key' => 'off_canvas_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => 'off_canvas_border_style', 'op' => '!=', 'value' => 'none' ),
            ) ),
          )
        )
      )
    ),
    'control_nav' => array(
      $group                   => $group_title,
      $group_off_canvas_setup  => __( 'Setup', '__x__' ),
      $group_off_canvas_design => __( 'Design', '__x__' ),
    )
  );
}

cs_register_control_partial( 'off-canvas', 'x_control_partial_off_canvas' );
