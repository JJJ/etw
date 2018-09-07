<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CONTENT-AREA-DROPDOWN.PHP
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
  'title'  => __( 'Content Area Dropdown', '__x__' ),
  'values' => x_values_element_content_area_dropdown(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_content_area_dropdown() {
  return array(
    'controls'           => x_controls_element_content_area_dropdown(),
    'controls_adv'       => x_controls_element_content_area_dropdown( true ),
    'control_groups'     => x_control_groups_element_content_area_dropdown(),
    'control_groups_adv' => x_control_groups_element_content_area_dropdown( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'content-area-dropdown', x_element_base( $data ) );
