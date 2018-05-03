<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/ALERT.PHP
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

function x_controls_alert( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'alert';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();

  $group_setup  = $group . ':setup';
  $group_close  = $group . ':close';
  $group_design = $group . ':design';
  $group_text   = $group . ':text';


  // Setup - Conditions
  // ------------------

  $conditions       = x_module_conditions( $condition );
  $conditions_close = array( $condition, array( 'alert_close' => true ) );


  // Setup - Options
  // ---------------

  $options_alert_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'fallback_value'  => 'auto',
    'valid_keywords'  => array( 'auto', 'calc' ),
    'ranges'          => array(
      'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
      'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    ),
  );

  $options_alert_max_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'fallback_value'  => 'none',
    'valid_keywords'  => array( 'none', 'calc' ),
    'ranges'          => array(
      'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
      'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    ),
  );

  $options_alert_close_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 10,  'max' => 20, 'step' => 1   ),
      'em'  => array( 'min' => 0.5, 'max' => 2,  'step' => 0.1 ),
      'rem' => array( 'min' => 0.5, 'max' => 2,  'step' => 0.1 ),
    ),
  );

  $options_alert_close_offset_top = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 0, 'max' => 50, 'step' => 1   ),
      'em'  => array( 'min' => 0, 'max' => 5,  'step' => 0.1 ),
      'rem' => array( 'min' => 0, 'max' => 5,  'step' => 0.1 ),
    ),
  );

  $options_alert_close_offset_side = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 0, 'max' => 50, 'step' => 1   ),
      'em'  => array( 'min' => 0, 'max' => 5,  'step' => 0.1 ),
      'rem' => array( 'min' => 0, 'max' => 5,  'step' => 0.1 ),
    ),
  );


  // Setup - Settings
  // ----------------

  $settings_alert_design = array(
    'k_pre'     => 'alert',
    't_pre'     => __( 'Alert', '__x__' ),
    'group'     => $group_design,
    'condition' => $conditions,
  );

  $settings_alert_text = array(
    'k_pre'     => 'alert',
    't_pre'     => __( 'Alert', '__x__' ),
    'group'     => $group_text,
    'condition' => $conditions,
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
            'key'     => 'alert_close',
            'type'    => 'choose',
            'label'   => __( 'Close', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
                array( 'value' => true,  'label' => __( 'On', '__x__' ) ),
              ),
            ),
          ),
          array(
            'type'     => 'group',
            'label'    => __( 'Width &amp; Max Width', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'alert_width',
                'type'    => 'unit',
                'options' => $options_alert_width,
              ),
              array(
                'key'     => 'alert_max_width',
                'type'    => 'unit',
                'options' => $options_alert_max_width,
              ),
            ),
          ),
          array(
            'key'     => 'alert_content',
            'type'    => 'text-editor',
            'label'   => __( 'Content', '__x__' ),
            'options' => array(
              'mode'   => 'html',
              'height' => 2,
            ),
          ),
          array(
            'keys' => array(
              'value' => 'alert_bg_color',
            ),
            'type'    => 'color',
            'label'   => __( 'Background', '__x__' ),
          ),
        ),
      ),
      array(
        'type'       => 'group',
        'title'      => __( 'Close Setup', '__x__' ),
        'group'      => $group_close,
        'conditions' => $conditions_close,
        'controls'   => array(
          array(
            'key'     => 'alert_close_font_size',
            'type'    => 'unit-slider',
            'label'   => __( 'Font Size', '__x__' ),
            'options' => $options_alert_close_font_size,
          ),
          array(
            'key'     => 'alert_close_location',
            'type'    => 'choose',
            'label'   => __( 'Location', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'left',  'label' => __( 'Left', '__x__' ) ),
                array( 'value' => 'right', 'label' => __( 'Right', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'     => 'alert_close_offset_top',
            'type'    => 'unit-slider',
            'label'   => __( 'Offset Top', '__x__' ),
            'options' => $options_alert_close_offset_top,
          ),
          array(
            'key'     => 'alert_close_offset_side',
            'type'    => 'unit-slider',
            'label'   => __( 'Offset Side', '__x__' ),
            'options' => $options_alert_close_offset_side,
          ),
          array(
            'keys' => array(
              'value' => 'alert_close_color',
              'alt'   => 'alert_close_color_alt',
            ),
            'type'    => 'color',
            'label'   => __( 'Color', '__x__' ),
            'options' => array(
              'label'     => __( 'Base', '__x__' ),
              'alt_label' => __( 'Interaction', '__x__' ),
            ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_alert_design ),
    x_control_padding( $settings_alert_design ),
    x_control_border( $settings_alert_design ),
    x_control_border_radius( $settings_alert_design ),
    x_control_box_shadow( $settings_alert_design ),
    x_control_text_format( $settings_alert_text ),
    x_control_text_style( $settings_alert_text ),
    x_control_text_shadow( $settings_alert_text )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_alert( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'alert';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Alert', '__x__' );

  $control_groups = array(
    $group             => array( 'title' => $group_title ),
    $group . ':setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':close'  => array( 'title' => __( 'Close', '__x__' ) ),
    $group . ':design' => array( 'title' => __( 'Design', '__x__' ) ),
    $group . ':text'   => array( 'title' => __( 'Text', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_alert( $settings = array() ) {

  // Values
  // ------

  $values = array(
    'alert_close'                  => x_module_value( true, 'all' ),
    'alert_width'                  => x_module_value( 'auto', 'style' ),
    'alert_max_width'              => x_module_value( 'none', 'style' ),
    'alert_content'                => x_module_value( __( 'This is where the content for your alert goes. Best to keep it short and sweet!', '__x__' ), 'markup:html', true ),
    'alert_bg_color'               => x_module_value( 'transparent', 'style:color' ),
    'alert_close_font_size'        => x_module_value( '1em', 'style' ),
    'alert_close_location'         => x_module_value( 'right', 'style' ),
    'alert_close_offset_top'       => x_module_value( '1.25em', 'style' ),
    'alert_close_offset_side'      => x_module_value( '1em', 'style' ),
    'alert_close_color'            => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'alert_close_color_alt'        => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'alert_margin'                 => x_module_value( '0em', 'style' ),
    'alert_padding'                => x_module_value( '1em 2.75em 1em 1.15em', 'style' ),
    'alert_border_width'           => x_module_value( '1px', 'style' ),
    'alert_border_style'           => x_module_value( 'solid', 'style' ),
    'alert_border_color'           => x_module_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
    'alert_border_radius'          => x_module_value( '3px', 'style' ),
    'alert_box_shadow_dimensions'  => x_module_value( '0em 0.15em 0.25em 0em', 'style' ),
    'alert_box_shadow_color'       => x_module_value( 'rgba(0, 0, 0, 0.05)', 'style:color' ),
    'alert_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
    'alert_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
    'alert_font_size'              => x_module_value( '1em', 'style' ),
    'alert_line_height'            => x_module_value( '1.5', 'style' ),
    'alert_letter_spacing'         => x_module_value( '0em', 'style' ),
    'alert_font_style'             => x_module_value( 'normal', 'style' ),
    'alert_text_align'             => x_module_value( 'none', 'style' ),
    'alert_text_decoration'        => x_module_value( 'none', 'style' ),
    'alert_text_transform'         => x_module_value( 'none', 'style' ),
    'alert_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'alert_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    'alert_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
