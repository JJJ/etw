<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/IMAGE.PHP
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
  'image',
  'image:retina',
  'image:dimensions',
  'image:link',
  'image:alt',
  'omega'
);

// Style
// =============================================================================

function x_element_style_image() {
  return x_get_view( 'styles/elements', 'image', 'css', array(), false );
}

// Render
// =============================================================================

function x_element_render_image( $data ) {
  return cs_get_partial_view( 'image', $data );
}


// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Image', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_image',
  'style' => 'x_element_style_image',
  'render' => 'x_element_render_image',
  'icon' => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_image() {
  return cs_compose_controls(
    cs_partial_controls( 'image' ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'image', $data );
