<?php

// =============================================================================
// ELEMENTS/MIXINS/ROW.PHP
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

function x_controls_row( $settings = array() ) {

  // Setup
  // -----

  $group        = 'row';
  $group_setup  = $group . ':setup';
  $group_design = $group . ':design';


  // Setup - Options
  // ---------------

  $options_row_base_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '16px',
    'ranges'          => array(
      'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
      'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
      'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
    ),
  );

  $options_row_z_index = array(
    'unit_mode'      => 'unitless',
    'fallback_value' => '9999',
  );

  $options_row_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
    'valid_keywords'  => array( 'calc', 'auto' ),
    'fallback_value'  => 'auto',
    'ranges'          => array(
      'px'  => array( 'min' => 0, 'max' => 1500, 'step' => 10  ),
      'em'  => array( 'min' => 0, 'max' => 40,   'step' => 0.5 ),
      'rem' => array( 'min' => 0, 'max' => 40,   'step' => 0.5 ),
      '%'   => array( 'min' => 0, 'max' => 100,  'step' => 1   ),
      'vw'  => array( 'min' => 0, 'max' => 100,  'step' => 1   ),
      'vh'  => array( 'min' => 0, 'max' => 100,  'step' => 1   ),
    ),
  );

  $options_row_max_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
    'valid_keywords'  => array( 'calc', 'none' ),
    'fallback_value'  => 'none',
    'ranges'          => array(
      'px'  => array( 'min' => 0, 'max' => 1500, 'step' => 10  ),
      'em'  => array( 'min' => 0, 'max' => 40,  'step' => 0.5  ),
      'rem' => array( 'min' => 0, 'max' => 40,  'step' => 0.5  ),
      '%'   => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
      'vw'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
      'vh'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
    ),
  );


  // Setup - Settings
  // ----------------

  $settings_row_bg = array(
    'group'     => $group_design,
    'condition' => array( 'row_bg_advanced' => true ),
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
                'key'     => 'row_base_font_size',
                'type'    => 'unit',
                'options' => $options_row_base_font_size,
              ),
              array(
                'key'     => 'row_z_index',
                'type'    => 'unit',
                'options' => $options_row_z_index,
              ),
            ),
          ),
          array(
            'key'     => 'row_inner_container',
            'type'    => 'choose',
            'label'   => __( 'Inner Container', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
                array( 'value' => true,  'label' => __( 'On', '__x__' ) ),
              ),
            ),
          ),
          array(
            'type'      => 'group',
            'title'     => __( 'Width &amp; Max Width', '__x__' ),
            'condition' => array( 'row_inner_container' => false ),
            'controls'  => array(
              array(
                'key'     => 'row_width',
                'type'    => 'unit',
                'options' => $options_row_width,
              ),
              array(
                'key'     => 'row_max_width',
                'type'    => 'unit',
                'options' => $options_row_max_width,
              ),
            ),
          ),
          array(
            'key'     => 'row_marginless_columns',
            'type'    => 'choose',
            'label'   => __( 'Marginless Columns', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
                array( 'value' => true,  'label' => __( 'On', '__x__' ) ),
              ),
            ),
          ),
          array(
            'type'     => 'group',
            'title'    => __( 'Background', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'row_bg_color',
                'type'    => 'color',
                'options' => array(
                  'label' => __( 'Select', '__x__' ),
                ),
              ),
              array(
                'keys' => array(
                  'bg_advanced' => 'row_bg_advanced',
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
    x_controls_bg( $settings_row_bg ),
    array(
      array(
        'type'     => 'group',
        'title'    => __( 'Formatting', '__x__' ),
        'group'    => $group_design,
        'controls' => array(
          array(
            'key'   => 'row_text_align',
            'type'  => 'text-align',
            'label' => __( 'Text Align', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_margin( array( 'k_pre' => 'row', 'group' => $group_design, 'options' => array( 'left' => array( 'disabled' => true, 'fallback_value' => 'auto' ), 'right' => array( 'disabled' => true, 'fallback_value' => 'auto' ) ) ) ),
    x_control_padding( array( 'k_pre' => 'row', 'group' => $group_design ) ),
    x_control_border( array( 'k_pre' => 'row', 'group' => $group_design ) ),
    x_control_border_radius( array( 'k_pre' => 'row', 'group' => $group_design ) ),
    x_control_box_shadow( array( 'k_pre' => 'row', 'group' => $group_design ) )
  );


  // Returned Value
  // --------------

  $controls = $data;

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_row( $settings = array() ) {

  $group = 'row';

  $control_groups = array(
    $group             => array( 'title' => __( 'Row', '__x__' ) ),
    $group . ':setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design' => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_row( $settings = array() ) {

  // Values
  // ------

  $values = array_merge(
    array(
      'row_base_font_size'     => x_module_value( '1em', 'style' ),
      'row_z_index'            => x_module_value( '1', 'style' ),
      'row_width'              => x_module_value( 'auto', 'style' ),
      'row_max_width'          => x_module_value( 'none', 'style' ),
      'row_inner_container'    => x_module_value( true, 'markup' ),
      'row_marginless_columns' => x_module_value( false, 'markup' ),
      'row_bg_color'           => x_module_value( 'transparent', 'style:color' ),
      'row_bg_advanced'        => x_module_value( false, 'all' ),
    ),
    x_values_bg(),
    array(
      'row_text_align'              => x_module_value( 'none', 'style' ),
      'row_margin'                  => x_module_value( '0em auto 0em auto', 'style' ),
      'row_padding'                 => x_module_value( '0em', 'style' ),
      'row_border_width'            => x_module_value( '0px', 'style' ),
      'row_border_style'            => x_module_value( 'none', 'style' ),
      'row_border_color'            => x_module_value( 'transparent', 'style:color' ),
      'row_border_radius'           => x_module_value( '0px', 'style' ),
      'row_box_shadow_dimensions'   => x_module_value( '0em 0em 0em 0em', 'style' ),
      'row_box_shadow_color'        => x_module_value( 'transparent', 'style:color' ),
    )
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
