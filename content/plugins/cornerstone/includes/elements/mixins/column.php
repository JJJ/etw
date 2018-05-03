<?php

// =============================================================================
// ELEMENTS/MIXINS/COLUMN.PHP
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

function x_controls_column( $settings = array() ) {

  // Setup
  // -----

  $group        = 'column';
  $group_setup  = $group . ':setup';
  $group_design = $group . ':design';


  // Setup - Options
  // ---------------

  $options_column_base_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '16px',
    'ranges'          => array(
      'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
      'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
      'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
    ),
  );

  $options_column_z_index = array(
    'unit_mode'      => 'unitless',
    'fallback_value' => '9999',
  );


  // Setup - Settings
  // ----------------

  $settings_column_bg = array(
    'group'     => $group_design,
    'condition' => array( 'column_bg_advanced' => true ),
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
            'key'     => 'column_base_font_size',
            'type'    => 'unit',
            'label'    => __( 'Base Font Size', '__x__' ),
            'options' => $options_column_base_font_size,
          ),
          array(
            'key'     => 'column_fade',
            'type'    => 'choose',
            'label'   => __( 'Fade In Effect', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
                array( 'value' => true,  'label' => __( 'On', '__x__' ) ),
              ),
            ),
          ),
          array(
            'type'      => 'group',
            'title'     => __( 'Duration &amp; Animation', '__x__' ),
            'condition' => array( 'column_fade' => true ),
            'controls'  => array(
              array(
                'key'     => 'column_fade_duration',
                'type'    => 'unit',
                'options' => array(
                  'unit_mode'       => 'time',
                  'available_units' => array( 's', 'ms' ),
                  'fallback_value'  => '0.5s',
                  'ranges'          => array(
                    's'  => array( 'min' => 0, 'max' => 5,    'step' => 0.1 ),
                    'ms' => array( 'min' => 0, 'max' => 5000, 'step' => 100 ),
                  ),
                ),
              ),
              array(
                'key'     => 'column_fade_animation',
                'type'    => 'select',
                'options' => array(
                  'choices' => array(
                    array( 'value' => 'in',             'label' => __( 'In', '__x__' ) ),
                    array( 'value' => 'in-from-top',    'label' => __( 'In From Top', '__x__' ) ),
                    array( 'value' => 'in-from-left',   'label' => __( 'In From Left', '__x__' ) ),
                    array( 'value' => 'in-from-right',  'label' => __( 'In From Right', '__x__' ) ),
                    array( 'value' => 'in-from-bottom', 'label' => __( 'In From Bottom', '__x__' ) ),
                  ),
                ),
              ),
            ),
          ),
          array(
            'key'        => 'column_fade_animation_offset',
            'type'       => 'unit-slider',
            'label'      => __( 'Animation Offset', '__x__' ),
            'conditions' => array( array( 'column_fade' => true ), array( 'key' => 'column_fade_animation', 'op' => 'NOT IN', 'value' => 'in' ) ),
            'options'    => array(
              'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
              'fallback_value'  => '50px',
              'ranges'          => array(
                'px'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
                'em'  => array( 'min' => 0, 'max' => 15,  'step' => 0.25 ),
                'rem' => array( 'min' => 0, 'max' => 15,  'step' => 0.25 ),
                '%'   => array( 'min' => 0, 'max' => 200, 'step' => 5    ),
                'vw'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
                'vh'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
              ),
            ),
          ),
          array(
            'type'     => 'group',
            'title'    => __( 'Background', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'column_bg_color',
                'type'    => 'color',
                'options' => array(
                  'label' => __( 'Select', '__x__' ),
                ),
              ),
              array(
                'keys' => array(
                  'bg_advanced' => 'column_bg_advanced',
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
    x_controls_bg( $settings_column_bg ),
    array(
      array(
        'type'     => 'group',
        'title'    => __( 'Formatting', '__x__' ),
        'group'    => $group_design,
        'controls' => array(
          array(
            'key'   => 'column_text_align',
            'type'  => 'text-align',
            'label' => __( 'Text Align', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_padding( array( 'k_pre' => 'column', 'group' => $group_design ) ),
    x_control_border( array( 'k_pre' => 'column', 'group' => $group_design ) ),
    x_control_border_radius( array( 'k_pre' => 'column', 'group' => $group_design ) ),
    x_control_box_shadow( array( 'k_pre' => 'column', 'group' => $group_design ) )
  );


  // Returned Value
  // --------------

  $controls = $data;

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_column( $settings = array() ) {

  $group = 'column';

  $control_groups = array(
    $group             => array( 'title' => __( 'Column', '__x__' ) ),
    $group . ':setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design' => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_column( $settings = array() ) {

  // Values
  // ------

  $values = array_merge(
    array(
      '_active'                      => x_module_value( false, 'attr' ),
      'size'                         => x_module_value( '1/1', 'attr' ),
      'column_base_font_size'        => x_module_value( '1em', 'style' ),
      'column_fade'                  => x_module_value( false, 'markup' ),
      'column_fade_duration'         => x_module_value( '0.5s', 'markup' ),
      'column_fade_animation'        => x_module_value( 'in', 'markup' ),
      'column_fade_animation_offset' => x_module_value( '50px', 'markup' ),
      'column_bg_color'              => x_module_value( 'transparent', 'style:color' ),
      'column_bg_advanced'           => x_module_value( false, 'all' ),
    ),
    x_values_bg(),
    array(
      'column_text_align'            => x_module_value( 'none', 'style' ),
      'column_padding'               => x_module_value( '0em', 'style' ),
      'column_border_width'          => x_module_value( '0px', 'style' ),
      'column_border_style'          => x_module_value( 'none', 'style' ),
      'column_border_color'          => x_module_value( 'transparent', 'style:color' ),
      'column_border_radius'         => x_module_value( '0px 0px 0px 0px', 'style' ),
      'column_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
      'column_box_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
    )
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
