<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SEARCH-DROPDOWN.PHP
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
  'title'  => __( 'Search Dropdown', '__x__' ),
  'values' => x_values_element_search_dropdown(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_search_dropdown() {
  return array(
    'controls'           => x_controls_element_search_dropdown(),
    'controls_adv'       => x_controls_element_search_dropdown( true ),
    'control_groups'     => x_control_groups_element_search_dropdown(),
    'control_groups_adv' => x_control_groups_element_search_dropdown( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'search-dropdown', x_element_base( $data ) );
