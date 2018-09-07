<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/MAP-MARKER.PHP
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
  'title'   => __( 'Map Marker', '__x__' ),
  'values'  => x_values_element_map_marker(),
  'options' => array(
    'child'          => true,
    'alt_breadcrumb' => __( 'Marker', '__x__' ),
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_map_marker() {
  return array(
    'controls'           => x_controls_element_map_marker(),
    'controls_adv'       => x_controls_element_map_marker( true ),
    'control_groups'     => x_control_groups_element_map_marker(),
    'control_groups_adv' => x_control_groups_element_map_marker( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'map-marker', x_element_base( $data ) );
