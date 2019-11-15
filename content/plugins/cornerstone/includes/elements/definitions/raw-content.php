<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/RAW-CONTENT.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Render
//   02. Define Element
//   03. Builder Setup
//   04. Register Module
// =============================================================================

// Render
// =============================================================================

function x_element_render_raw_content( $data ) {
  if ( isset( $data['raw_content'] ) ) {
    echo do_shortcode( $data['raw_content'] );
  }
}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Raw Content', '__x__' ),
  'values' => array(
    'raw_content' => cs_value( '', 'markup:html', true )
  ),
  'builder' => 'x_element_builder_setup_raw_content',
  'render'  => 'x_element_render_raw_content',
  'icon'    => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_raw_content() {
  return cs_compose_controls(
    array(
        'controls_std_content' => array(
        array(
          'key'   => 'raw_content',
          'type'  => 'textarea',
          'label' => __( 'Content', '__x__' ),
        )
      )
    )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'raw-content', $data );
