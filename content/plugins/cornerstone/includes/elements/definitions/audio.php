<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/AUDIO.PHP
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
  'title'  => __( 'Audio', '__x__' ),
  'values' => x_values_element_audio(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_audio() {
  return array(
    'controls'           => x_controls_element_audio(),
    'controls_adv'       => x_controls_element_audio( true ),
    'control_groups'     => x_control_groups_element_audio(),
    'control_groups_adv' => x_control_groups_element_audio( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'audio', x_element_base( $data ) );
