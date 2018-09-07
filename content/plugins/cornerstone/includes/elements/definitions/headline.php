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
  'values' => x_values_element_headline(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_headline() {
  return array(
    'controls'           => x_controls_element_headline(),
    'controls_adv'       => x_controls_element_headline( true ),
    'control_groups'     => x_control_groups_element_headline(),
    'control_groups_adv' => x_control_groups_element_headline( true ),
    'options' => array(
      'inline' => array(
        'text_content' => array(
          'selector' => '.x-text-content-text-primary'
        ),
        'text_subheadline_content' => array(
          'selector' => '.x-text-content-text-subheadline'
        ),
      )
    )
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'headline', x_element_base( $data ) );
