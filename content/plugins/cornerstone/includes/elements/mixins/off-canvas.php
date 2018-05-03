<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/OFF-CANVAS.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Groups
//   03. Values
// =============================================================================

// Controls
// =============================================================================

function x_controls_off_canvas( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'off_canvas';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();
  $lr_only   = ( isset( $settings['lr_only'] )   ) ? $settings['lr_only']   : false;
  $tb_only   = ( isset( $settings['tb_only'] )   ) ? $settings['tb_only']   : false;
  $tbf_only  = ( isset( $settings['tbf_only'] )  ) ? $settings['tbf_only']  : false;
  $ctbf_only = ( isset( $settings['ctbf_only'] ) ) ? $settings['ctbf_only'] : false;

  $group_setup  = $group . ':setup';
  $group_design = $group . ':design';


  // Setup - Conditions
  // ------------------

  $lr_only   = ( $lr_only )   ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'left', 'right' ) )                      : array();
  $tb_only   = ( $tb_only )   ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'top', 'bottom' ) )                      : array();
  $tbf_only  = ( $tbf_only )  ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'top', 'bottom', 'footer' ) )            : array();
  $ctbf_only = ( $ctbf_only ) ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'content', 'top', 'bottom', 'footer' ) ) : array();

  $conditions = array( $condition, $lr_only, $tb_only, $tbf_only, $ctbf_only ); // x_module_conditions( $condition )


  // Setup - Options
  // ---------------

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

  $options_off_canvas_content_max_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'fallback_value'  => '400px',
    'valid_keywords'  => array( 'none' ),
    'ranges'          => array(
      'px'  => array( 'min' => 300, 'max' => 500, 'step' => 1    ),
      'em'  => array( 'min' => 30,  'max' => 50,  'step' => 0.01 ),
      'rem' => array( 'min' => 30,  'max' => 50,  'step' => 0.01 ),
      '%'   => array( 'min' => 80,  'max' => 100, 'step' => 0.01 ),
    ),
  );


  // Setup - Settings
  // ----------------

  $settings_off_canvas = array(
    'k_pre'     => 'off_canvas_content',
    't_pre'     => __( 'Content', '__x__' ),
    'group'     => $group,
    'condition' => $conditions
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
            'key'     => 'off_canvas_base_font_size',
            'type'    => 'slider',
            'title'   => __( 'Base Font Size', '__x__' ),
            'options' => $options_off_canvas_font_size,
          ),
          array(
            'key'     => 'off_canvas_location',
            'type'    => 'choose',
            'label'   => __( 'Location', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'left',  'label' => __( 'Left', '__x__' )  ),
                array( 'value' => 'right', 'label' => __( 'Right', '__x__' ) ),
              ),
            ),
          ),
          array(
            'type'     => 'group',
            'title'    => __( 'Close Size &amp; Dimensions', '__x__' ),
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
          ),
          array(
            'key'     => 'off_canvas_content_max_width',
            'type'    => 'slider',
            'title'   => __( 'Content Max Width', '__x__' ),
            'options' => $options_off_canvas_content_max_width,
          ),
        ),
      ),
      array(
        'type'       => 'group',
        'title'      => __( 'Colors', '__x__' ),
        'group'      => $group_design,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'   => 'off_canvas_bg_color',
            'type'  => 'color',
            'title' => __( 'Overlay Background', '__x__' ),
          ),
          array(
            'keys' => array(
              'value' => 'off_canvas_close_color',
              'alt'   => 'off_canvas_close_color_alt',
            ),
            'type'    => 'color',
            'title'   => __( 'Close Button', '__x__' ),
            'options' => array(
              'label'     => __( 'Base', '__x__' ),
              'alt_label' => __( 'Interaction', '__x__' ),
            ),
          ),
          array(
            'key'   => 'off_canvas_content_bg_color',
            'type'  => 'color',
            'title' => __( 'Content Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_border( $settings_off_canvas ),
    x_control_box_shadow( $settings_off_canvas )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_off_canvas( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'off_canvas';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Off Canvas', '__x__' );

  $control_groups = array(
    $group             => array( 'title' => $group_title ),
    $group . ':setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design' => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_off_canvas( $settings = array() ) {

  // Values
  // ------

  $values = array(
    'off_canvas_base_font_size'                => x_module_value( '16px', 'style' ),
    'off_canvas_location'                      => x_module_value( 'right', 'markup' ),
    'off_canvas_close_font_size'               => x_module_value( '1.5em', 'style' ),
    'off_canvas_close_dimensions'              => x_module_value( '2', 'style' ),
    'off_canvas_content_max_width'             => x_module_value( '24em', 'style' ),
    'off_canvas_close_color'                   => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'off_canvas_close_color_alt'               => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'off_canvas_content_bg_color'              => x_module_value( '#ffffff', 'style:color' ),
    'off_canvas_bg_color'                      => x_module_value( 'rgba(0, 0, 0, 0.75)', 'style:color' ),
    'off_canvas_content_border_width'          => x_module_value( '0px', 'style' ),
    'off_canvas_content_border_style'          => x_module_value( 'none', 'style' ),
    'off_canvas_content_border_color'          => x_module_value( 'transparent', 'style:color' ),
    'off_canvas_content_box_shadow_dimensions' => x_module_value( '0em 0em 2em 0em', 'style' ),
    'off_canvas_content_box_shadow_color'      => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
