<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/QUOTE.PHP
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
  'title'  => __( 'Quote', '__x__' ),
  'values' => x_values_element_quote(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_quote() {
  return array(
    'controls'           => x_controls_element_quote(),
    'controls_adv'       => x_controls_element_quote( true ),
    'control_groups'     => x_control_groups_element_quote(),
    'control_groups_adv' => x_control_groups_element_quote( true ),
    'options' => array(
      'inline' => array(
        'quote_content' => array(
          'selector' => '.x-quote-text'
        ),
        'quote_cite_content' => array(
          'selector' => '.x-quote-cite-text'
        )
      )
    )
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'quote', x_element_base( $data ) );
