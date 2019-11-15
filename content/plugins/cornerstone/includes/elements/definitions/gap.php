<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/GAP.PHP
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
    'gap_direction'      => cs_value( 'vertical', 'style' ),
    'gap_base_font_size' => cs_value( '1em', 'style' ),
    'gap_size'           => cs_value( '25px', 'style' ),
  ),
  'omega'
);


// Style
// =============================================================================

function x_element_style_gap() {
  return x_get_view( 'styles/elements', 'gap', 'css', array(), false );
}


// Render
// =============================================================================

function x_element_render_gap( $data ) {
  return x_get_view( 'elements', 'gap', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Gap', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_gap',
  'style' => 'x_element_style_gap',
  'render' => 'x_element_render_gap',
  'icon' => 'native',
  'options' => array(
    'empty_placeholder' => false,
    '_no_server_render'  => true
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_gap() {

  // Compose Controls
  // ----------------

  $controls = array(
    array(
      'type'       => 'group',
      'title'      => __( 'Setup', '__x__' ),
      'group'      => 'gap:setup',
      'controls'   => array(
        array(
          'key'     => 'gap_direction',
          'type'    => 'choose',
          'label'   => __( 'Direction', '__x__' ),
          'options' => array(
            'choices' => array(
              array( 'value' => 'horizontal', 'label' => __( 'Horizontal', '__x__' ) ),
              array( 'value' => 'vertical',   'label' => __( 'Vertical', '__x__' ) ),
            ),
          ),
        ),
        array(
          'key'     => 'gap_base_font_size',
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
        ),
        array(
          'key'     => 'gap_size',
          'type'    => 'unit-slider',
          'label'   => __( 'Gap Size', '__x__' ),
          'options' => array(
            'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
            'valid_keywords'  => array( 'calc' ),
            'fallback_value'  => '25px',
            'ranges'          => array(
              'px'  => array( 'min' => 0, 'max' => 100, 'step' => 1   ),
              'em'  => array( 'min' => 0, 'max' => 10,  'step' => 0.1 ),
              'rem' => array( 'min' => 0, 'max' => 10,  'step' => 0.1 ),
              '%'   => array( 'min' => 0, 'max' => 100, 'step' => 1   ),
              'vw'  => array( 'min' => 0, 'max' => 100, 'step' => 1   ),
              'vh'  => array( 'min' => 0, 'max' => 100, 'step' => 1   ),
            ),
          ),
        ),
      ),
    ),
  );

  return cs_compose_controls(
    array(
      'controls'         => $controls,
      'controls_std_content' => $controls,
      'control_nav' => array(
        'gap'       => __( 'Gap', '__x__' ),
        'gap:setup' => __( 'Setup', '__x__' ),
      )
    ),
    cs_partial_controls( 'omega' )
  );

}



// Register Module
// =============================================================================

cs_register_element( 'gap', $data );
