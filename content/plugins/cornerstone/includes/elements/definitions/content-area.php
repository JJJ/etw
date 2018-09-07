<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CONTENT-AREA.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Define Element
//   02. Builder Setup
//   03. Register Element
// =============================================================================

// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Content Area', '__x__' ),
  'values' => x_values_element_content_area(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_content_area() {
  return array(
    'controls'           => x_controls_element_content_area(),
    'controls_adv'       => x_controls_element_content_area( true ),
    'control_groups'     => x_control_groups_element_content_area(),
    'control_groups_adv' => x_control_groups_element_content_area( true ),
    'options' => array(
      'inline' => array(
        'content' => array(
          'selector' => 'root'
        ),
      )
    )
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'content-area', x_element_base( $data ) );
