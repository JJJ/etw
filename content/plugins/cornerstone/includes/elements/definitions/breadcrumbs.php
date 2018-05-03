<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/BREADCRUMBS.PHP
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
  'title'  => __( 'Breadcrumbs', '__x__' ),
  'values' => array_merge(
    x_values_breadcrumbs(),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_breadcrumbs() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_breadcrumbs(),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_breadcrumbs(),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'breadcrumbs', x_element_base( $data ) );
