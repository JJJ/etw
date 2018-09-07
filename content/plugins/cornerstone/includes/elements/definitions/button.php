<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/BUTTON.PHP
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
  'title'  => __( 'Button', '__x__' ),
  'values' => x_values_element_button(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_button() {
  return array(
    'controls'           => x_controls_element_button(),
    'controls_adv'       => x_controls_element_button( true ),
    'control_groups'     => x_control_groups_element_button(),
    'control_groups_adv' => x_control_groups_element_button( true ),
    'options' => array(
      'inline' => array(
        'anchor_text_primary_content' => array(
          'selector' => '.x-anchor-text-primary'
        )
      )
    )
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'button', x_element_base( $data ) );
