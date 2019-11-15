<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TEXT.PHP
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
  'text-standard',
  'omega'
);


// Style
// =============================================================================

function x_element_style_text() {
  return cs_get_partial_style( 'text' );
}



// Render
// =============================================================================

function x_element_render_text( $data ) {
  return cs_get_partial_view( 'text', $data );
}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Text', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_text',
  'style' => 'x_element_style_text',
  'render' => 'x_element_render_text',
  'icon' => 'native',
  'options' => array(
    'inline' => array(
      'text_content' => array(
        'selector' => 'root'
      ),
    )
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_text() {
  return cs_compose_controls(
    cs_partial_controls( 'text', array( 'type' => 'standard' ) ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'text', $data );
