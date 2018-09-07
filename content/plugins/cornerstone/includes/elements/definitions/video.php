<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/VIDEO.PHP
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
  'title'  => __( 'Video', '__x__' ),
  'values' => x_values_element_video(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_video() {
  return array(
    'controls'           => x_controls_element_video(),
    'controls_adv'       => x_controls_element_video( true ),
    'control_groups'     => x_control_groups_element_video(),
    'control_groups_adv' => x_control_groups_element_video( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'video', x_element_base( $data ) );
