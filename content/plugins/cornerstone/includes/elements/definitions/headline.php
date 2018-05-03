<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/HEADLINE.PHP
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
  'title'  => __( 'Headline', '__x__' ),
  'values' => array_merge(
    x_values_text( array( 'type' => 'headline' ) ),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_headline() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_text( array( 'type' => 'headline' ) ),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_text( array( 'type' => 'headline' ) ),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'headline', x_element_base( $data ) );
