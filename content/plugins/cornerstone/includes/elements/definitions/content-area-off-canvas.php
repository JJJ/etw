<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CONTENT-AREA-OFF-CANVAS.PHP
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
  'title'  => __( 'Content Area Off Canvas', '__x__' ),
  'values' => x_values_element_content_area_off_canvas(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_content_area_off_canvas() {
  return array(
    'controls'           => x_controls_element_content_area_off_canvas(),
    'controls_adv'       => x_controls_element_content_area_off_canvas( true ),
    'control_groups'     => x_control_groups_element_content_area_off_canvas(),
    'control_groups_adv' => x_control_groups_element_content_area_off_canvas( true ),
    'options' => array(
      'inline' => array(
        'off_canvas_content' => array(
          'selector' => '.x-off-canvas-content'
        ),
      )
    )
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'content-area-off-canvas', x_element_base( $data ) );
