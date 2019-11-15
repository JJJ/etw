<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/HEADLINE.PHP
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
  'text-headline',
  'omega'
);

// Style
// =============================================================================

function x_element_style_headline() {
  return cs_get_partial_style( 'text' );
}

// Render
// =============================================================================

function x_element_render_headline( $data ) {
  return cs_get_partial_view( 'text', $data );
}


// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Headline', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_headline',
  'style' => 'x_element_style_headline',
  'render' => 'x_element_render_headline',
  'icon' => 'native',
  'options' => array(
    'inline' => array(
      'text_content' => array(
        'selector' => '.x-text-content-text-primary'
      ),
      'text_subheadline_content' => array(
        'selector' => '.x-text-content-text-subheadline'
      ),
    )
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_headline() {
  return cs_compose_controls(
    cs_partial_controls( 'text', array( 'type' => 'headline' ) ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'headline', $data );
