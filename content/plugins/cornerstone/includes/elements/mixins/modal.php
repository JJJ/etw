<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/MODAL.PHP
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

function x_controls_modal( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'modal';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();

  $group_setup  = $group . ':setup';
  $group_design = $group . ':design';


  // Setup - Conditions
  // ------------------

  $conditions = x_module_conditions( $condition );


  // Setup - Options
  // ---------------

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

  $options_modal_content_max_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'fallback_value'  => '450px',
    'valid_keywords'  => array( 'none' ),
    'ranges'          => array(
      'px'  => array( 'min' => 500, 'max' => 1000, 'step' => 1    ),
      'em'  => array( 'min' => 25,  'max' => 100,  'step' => 0.1  ),
      'rem' => array( 'min' => 25,  'max' => 100,  'step' => 0.1  ),
      '%'   => array( 'min' => 80,  'max' => 100,  'step' => 0.01 ),
    ),
  );


  // Setup - Settings
  // ----------------

  $settings_modal_content = array(
    'k_pre'      => 'modal_content',
    't_pre'      => __( 'Modal Content', '__x__' ),
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
            'key'     => 'modal_base_font_size',
            'type'    => 'slider',
            'title'   => __( 'Base Font Size', '__x__' ),
            'options' => $options_modal_font_size,
          ),
          array(
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
          ),
          array(
            'type'     => 'group',
            'title'    => __( 'Close Size &amp; Dimensions', '__x__' ),
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
          ),
          array(
            'key'     => 'modal_content_max_width',
            'type'    => 'slider',
            'title'   => __( 'Content Max Width', '__x__' ),
            'options' => $options_modal_content_max_width
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
            'key'   => 'modal_bg_color',
            'type'  => 'color',
            'title' => __( 'Overlay Background', '__x__' ),
          ),
          array(
            'keys' => array(
              'value' => 'modal_close_color',
              'alt'   => 'modal_close_color_alt',
            ),
            'type'    => 'color',
            'title'   => __( 'Close Button', '__x__' ),
            'options' => array(
              'label'     => __( 'Base', '__x__' ),
              'alt_label' => __( 'Interaction', '__x__' ),
            ),
          ),
          array(
            'key'   => 'modal_content_bg_color',
            'type'  => 'color',
            'title' => __( 'Content Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_padding( $settings_modal_content ),
    x_control_border( $settings_modal_content ),
    x_control_border_radius( $settings_modal_content ),
    x_control_box_shadow( $settings_modal_content )
  );

  return $controls;


}



// Control Groups
// =============================================================================

function x_control_groups_modal( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'modal';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Modal', '__x__' );

  $control_groups = array(
    $group             => array( 'title' => $group_title ),
    $group . ':setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design' => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_modal( $settings = array() ) {

  // Values
  // ------

  $values = array(
    'modal_base_font_size'                => x_module_value( '16px', 'style' ),
    'modal_close_location'                => x_module_value( 'top-right', 'markup' ),
    'modal_close_font_size'               => x_module_value( '1.5em', 'style' ),
    'modal_close_dimensions'              => x_module_value( '1', 'style' ),
    'modal_content_max_width'             => x_module_value( '28em', 'style' ),
    'modal_bg_color'                      => x_module_value( 'rgba(0, 0, 0, 0.75)', 'style:color' ),
    'modal_close_color'                   => x_module_value( 'rgba(255, 255, 255, 0.5)', 'style:color' ),
    'modal_close_color_alt'               => x_module_value( '#ffffff', 'style:color' ),
    'modal_content_bg_color'              => x_module_value( '#ffffff', 'style:color' ),
    'modal_content_padding'               => x_module_value( '2em', 'style' ),
    'modal_content_border_width'          => x_module_value( '0px', 'style' ),
    'modal_content_border_style'          => x_module_value( 'none', 'style' ),
    'modal_content_border_color'          => x_module_value( 'transparent', 'style:color' ),
    'modal_content_border_radius'         => x_module_value( '0em', 'style' ),
    'modal_content_box_shadow_dimensions' => x_module_value( '0em 0.15em 2em 0em', 'style' ),
    'modal_content_box_shadow_color'      => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
