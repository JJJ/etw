<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/ALERT.PHP
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
  'title'  => __( 'Alert', '__x__' ),
  'values' => x_values_element_alert(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_alert() {
  return array(
    'controls'           => x_controls_element_alert(),
    'controls_adv'       => x_controls_element_alert( true ),
    'control_groups'     => x_control_groups_element_alert(),
    'control_groups_adv' => x_control_groups_element_alert( true ),
    'options' => array(
      'inline' => array(
        'alert_content' => array(
          'selector' => '.x-alert-content'
        )
      )
    )
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'alert', x_element_base( $data ) );
