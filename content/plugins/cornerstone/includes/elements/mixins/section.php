<?php

// =============================================================================
// ELEMENTS/MIXINS/SECTION.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Control
//   02. Control Groups
//   03. Values
// =============================================================================

// Control
// =============================================================================

function x_controls_section( $settings = array() ) {

  // Setup
  // -----

  $group        = 'section';
  $group_setup  = $group . ':setup';
  $group_design = $group . ':design';


  // Setup - Options
  // ---------------

  $options_section_base_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
      'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
      'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
    ),
  );

  $options_section_z_index = array(
    'unit_mode'      => 'unitless',
    'fallback_value' => '9999',
  );


  // Setup - Settings
  // ----------------

  $settings_section_bg = array(
    'group'     => $group_design,
    'condition' => array( 'section_bg_advanced' => true ),
  );


  // Data
  // ----

  $data = array_merge(
    array(
      array(
        'type'     => 'group',
        'title'    => __( 'Setup', '__x__' ),
        'group'    => $group_setup,
        'controls' => array(
          array(
            'type'     => 'group',
            'title'    => __( 'Font Size &amp; Z-Index', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'section_base_font_size',
                'type'    => 'unit',
                'options' => $options_section_base_font_size,
              ),
              array(
                'key'     => 'section_z_index',
                'type'    => 'unit',
                'options' => $options_section_z_index,
              ),
            ),
          ),
          array(
            'type'     => 'group',
            'title'    => __( 'Background', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'section_bg_color',
                'type'    => 'color',
                'options' => array(
                  'label' => __( 'Select', '__x__' ),
                ),
              ),
              array(
                'keys' => array(
                  'bg_advanced' => 'section_bg_advanced',
                ),
                'type'    => 'checkbox-list',
                'options' => array(
                  'list' => array(
                    array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
                  ),
                ),
              ),
            ),
          ),
        ),
      ),
    ),
    x_controls_bg( $settings_section_bg ),
    x_controls_separator( array( 't_pre' => __( 'Section Top', '__x__' ), 'k_pre' => 'section_top', 'group' => $group_design, 'location' => 'top' ) ),
    x_controls_separator( array( 't_pre' => __( 'Section Bottom', '__x__' ), 'k_pre' => 'section_bottom', 'group' => $group_design, 'location' => 'bottom' ) ),
    array(
      array(
        'type'     => 'group',
        'title'    => __( 'Formatting', '__x__' ),
        'group'    => $group_design,
        'controls' => array(
          array(
            'key'   => 'section_text_align',
            'type'  => 'text-align',
            'label' => __( 'Text Align', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_margin( array( 'k_pre' => 'section', 'group' => $group_design ) ),
    x_control_padding( array( 'k_pre' => 'section', 'group' => $group_design ) ),
    x_control_border( array( 'k_pre' => 'section', 'group' => $group_design ) ),
    x_control_box_shadow( array( 'k_pre' => 'section', 'group' => $group_design ) )
  );


  // Returned Value
  // --------------

  $controls = $data;

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_section( $settings = array() ) {

  $group = 'section';

  $control_groups = array(
    $group             => array( 'title' => __( 'Section', '__x__' ) ),
    $group . ':setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design' => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_section( $settings = array() ) {

  // Values
  // ------

  $values = array_merge(
    array(
      'section_base_font_size' => x_module_value( '1em', 'style' ),
      'section_z_index'        => x_module_value( '1', 'style' ),
      'section_bg_color'       => x_module_value( 'transparent', 'style:color' ),
      'section_bg_advanced'    => x_module_value( false, 'all' ),
    ),
    x_values_bg(),
    x_values_separator( array( 'k_pre' => 'section_top', 'location' => 'top' ) ),
    x_values_separator( array( 'k_pre' => 'section_bottom', 'location' => 'bottom' ) ),
    array(
      'section_text_align'            => x_module_value( 'none', 'style' ),
      'section_margin'                => x_module_value( '0em', 'style' ),
      'section_padding'               => x_module_value( '45px 0px 45px 0px', 'style' ),
      'section_border_width'          => x_module_value( '0px', 'style' ),
      'section_border_style'          => x_module_value( 'none', 'style' ),
      'section_border_color'          => x_module_value( 'transparent', 'style:color' ),
      'section_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
      'section_box_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
    )
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
