<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/WIDGET-AREA.PHP
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
  'title'  => __( 'Widget Area', '__x__' ),
  'values' => x_values_element_widget_area(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_widget_area() {
  return array(
    'controls'           => x_controls_element_widget_area(),
    'controls_adv'       => x_controls_element_widget_area( true ),
    'control_groups'     => x_control_groups_element_widget_area(),
    'control_groups_adv' => x_control_groups_element_widget_area( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'widget-area', x_element_base( $data ) );
