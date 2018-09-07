<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CONTENT-AREA-MODAL.PHP
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
  'title'  => __( 'Content Area Modal', '__x__' ),
  'values' => x_values_element_content_area_modal(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_content_area_modal() {
  return array(
    'controls'           => x_controls_element_content_area_modal(),
    'controls_adv'       => x_controls_element_content_area_modal( true ),
    'control_groups'     => x_control_groups_element_content_area_modal(),
    'control_groups_adv' => x_control_groups_element_content_area_modal( true ),
    'options' => array(
      'inline' => array(
        'modal_content' => array(
          'selector' => '.x-modal-content'
        ),
      )
    )
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'content-area-modal', x_element_base( $data ) );
