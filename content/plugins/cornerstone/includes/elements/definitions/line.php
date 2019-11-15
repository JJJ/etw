<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/LINE.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Groups
//   03. Values
//   04. Define Element
//   05. Builder Setup
//   06. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  array(
    'line_direction'             => cs_value( 'horizontal', 'style' ),
    'line_base_font_size'        => cs_value( '1em', 'style' ),
    'line_width'                 => cs_value( '100%', 'style' ),
    'line_max_width'             => cs_value( 'none', 'style' ),
    'line_height'                => cs_value( '50px', 'style' ),
    'line_max_height'            => cs_value( 'none', 'style' ),
    'line_size'                  => cs_value( '8px', 'style' ),
    'line_color'                 => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'line_style'                 => cs_value( 'solid', 'style' ),
    'line_margin'                => cs_value( '0px', 'style' ),
    'line_border_radius'         => cs_value( '0em', 'style' ),
    'line_box_shadow_dimensions' => cs_value( '0em 0em 0em 0em', 'style' ),
    'line_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ),
  'omega'
);

// Style
// =============================================================================

function x_element_style_line() {
  return x_get_view( 'styles/elements', 'line', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_line( $data ) {
  return x_get_view( 'elements', 'line', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Line', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_line',
  'style' => 'x_element_style_line',
  'render' => 'x_element_render_line',
  'icon' => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_line() {


  // Individual Controls
  // -------------------

  $control_line_direction = array(
    'key'     => 'line_direction',
    'type'    => 'choose',
    'label'   => __( 'Direction', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'horizontal', 'label' => __( 'Horizontal', '__x__' ) ),
        array( 'value' => 'vertical',   'label' => __( 'Vertical', '__x__' ) ),
      ),
    ),
  );

  $control_line_base_font_size = array(
    'key'     => 'line_base_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '1em',
      'ranges'          => array(
        'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
        'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
        'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
      ),
    ),
  );

  $control_line_width = array(
    'key'       => 'line_width',
    'type'      => 'unit',
    'label'   => __( 'Width', '__x__' ),
    'options'   => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'valid_keywords'  => array( 'calc', 'auto' ),
      'fallback_value'  => '100%',
    ),
    'condition' => array( 'line_direction' => 'horizontal' ),
  );

  $control_line_max_width = array(
    'key'       => 'line_max_width',
    'type'      => 'unit',
    'label'   => __( 'Max Width', '__x__' ),
    'options'   => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'valid_keywords'  => array( 'calc', 'none' ),
      'fallback_value'  => 'none',
    ),
    'condition' => array( 'line_direction' => 'horizontal' ),
  );

  $control_line_width_and_max_width = array(
    'type'      => 'group',
    'label'     => __( 'Width &amp; Max Width', '__x__' ),
    'condition' => array( 'line_direction' => 'horizontal' ),
    'controls'  => array(
      $control_line_width,
      $control_line_max_width
    ),
  );

  $control_line_height = array(
    'key'       => 'line_height',
    'type'      => 'unit',
    'label'   => __( 'Height', '__x__' ),
    'condition' => array( 'line_direction' => 'vertical' ),
    'options'   => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'valid_keywords'  => array( 'calc', 'auto' ),
      'fallback_value'  => '50px',
    ),
  );

  $control_line_max_height = array(
    'key'       => 'line_max_height',
    'type'      => 'unit',
    'label'   => __( 'Max Height', '__x__' ),
    'condition' => array( 'line_direction' => 'vertical' ),
    'options'   => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'valid_keywords'  => array( 'calc', 'none' ),
      'fallback_value'  => 'none',
    ),

  );

  $control_line_height_and_max_height = array(
    'type'      => 'group',
    'label'     => __( 'Height &amp; Max Height', '__x__' ),
    'condition' => array( 'line_direction' => 'vertical' ),
    'controls'  => array(
      $control_line_height,
      $control_line_max_height,
    ),
  );

  $control_line_size = array(
    'key'     => 'line_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '8px',
      'ranges'          => array(
        'px'  => array( 'min' => 0, 'max' => 25, 'step' => 1   ),
        'em'  => array( 'min' => 0, 'max' => 2,  'step' => 0.1 ),
        'rem' => array( 'min' => 0, 'max' => 2,  'step' => 0.1 ),
      ),
    ),
  );

  $control_line_color = array(
    'key'     => 'line_color',
    'type'    => 'color',
    'label'   => __( 'Color', '__x__' ),
    'options' => array(
      'label' => __( 'Select', '__x__' ),
    ),
  );

  $control_line_style = array(
    'key'     => 'line_style',
    'type'    => 'select',
    'label'   => __( 'Style', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'solid',  'label' => __( 'Solid', '__x__' ) ),
        array( 'value' => 'dotted', 'label' => __( 'Dotted', '__x__' ) ),
        array( 'value' => 'dashed', 'label' => __( 'Dashed', '__x__' ) ),
        array( 'value' => 'double', 'label' => __( 'Double', '__x__' ) ),
        array( 'value' => 'groove', 'label' => __( 'Groove', '__x__' ) ),
        array( 'value' => 'ridge',  'label' => __( 'Ridge', '__x__' ) ),
      ),
    ),
  );

  $control_line_color_and_style = array(
    'type'     => 'group',
    'label'    => __( 'Color &amp; Style', '__x__' ),
    'controls' => array(
      $control_line_color,
      $control_line_style,
    ),
  );

  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'line:setup',
          'controls'   => array(
            $control_line_direction,
            $control_line_base_font_size,
            $control_line_width_and_max_width,
            $control_line_height_and_max_height,
            $control_line_size,
            $control_line_color_and_style,
          ),
        ),
        cs_control( 'margin', 'line', array( 'group' => 'line:design' ) ),
        cs_control( 'border-radius', 'line', array( 'group' => 'line:design' ) ),
        cs_control( 'box-shadow', 'line', array( 'group' => 'line:design' ) )
      ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            $control_line_base_font_size,
            cs_amend_control( $control_line_width, array( 'type' => 'unit-slider') ),
            cs_amend_control( $control_line_max_width, array( 'type' => 'unit-slider') ),
            cs_amend_control( $control_line_height, array( 'type' => 'unit-slider') ),
            cs_amend_control( $control_line_max_height, array( 'type' => 'unit-slider') ),
            $control_line_size,
            $control_line_style,
          ),
        ),
        cs_control( 'margin', 'line' )
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Base Colors', '__x__' ),
          'controls'   => array(
            $control_line_color,
            array(
              'keys'      => array( 'value' => 'line_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'line_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
          ),
        ),
      ),
      'control_nav' => array(
        'line'        => __( 'Line', '__x__' ),
        'line:setup'  => __( 'Setup', '__x__' ),
        'line:design' => __( 'Design', '__x__' ),
      )
    ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'line', $data );
