<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/ICON.PHP
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
  'icon',
  'omega'
);



// Style
// =============================================================================

function x_element_style_icon() {
  return cs_get_partial_style( 'icon' );
}

// Render
// =============================================================================

function x_element_render_icon( $data ) {
  return cs_get_partial_view( 'icon', $data );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Icon', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_icon',
  'style'   => 'x_element_style_icon',
  'render'  => 'x_element_render_icon',
  'icon'    => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_icon() {
  return cs_compose_controls(
    cs_partial_controls( 'icon' ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'icon', $data );
