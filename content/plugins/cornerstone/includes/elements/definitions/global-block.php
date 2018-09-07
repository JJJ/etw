<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/GLOBAL-BLOCK.PHP
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
  'title'  => __( 'Global Block', '__x__' ),
  'values' => x_values_element_global_block(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_global_block() {
  return array(
    'controls'           => x_controls_element_global_block(),
    'controls_adv'       => x_controls_element_global_block( true ),
    'control_groups'     => x_control_groups_element_global_block(),
    'control_groups_adv' => x_control_groups_element_global_block( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'global-block', x_element_base( $data ) );
