<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TEXT.PHP
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
  'title'  => __( 'Text', '__x__' ),
  'values' => x_values_element_text(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_text() {
  return array(
    'controls'           => x_controls_element_text(),
    'controls_adv'       => x_controls_element_text( true ),
    'control_groups'     => x_control_groups_element_text(),
    'control_groups_adv' => x_control_groups_element_text( true ),
    'options' => array(
      'inline' => array(
        'text_content' => array(
          'selector' => 'root'
        ),
      )
    )
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'text', x_element_base( $data ) );
