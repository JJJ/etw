<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/ACCORDION-ITEM.PHP
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
  'title'   => __( 'Accordion Item', '__x__' ),
  'values'  => x_values_element_accordion_item(),
  'options' => array(
    'child'          => true,
    'alt_breadcrumb' => __( 'Item', '__x__' ),
  )
);


// Builder Setup
// =============================================================================

function x_element_builder_setup_accordion_item() {
  return array(
    'controls'           => x_controls_element_accordion_item(),
    'controls_adv'       => x_controls_element_accordion_item( true ),
    'control_groups'     => x_control_groups_element_accordion_item(),
    'control_groups_adv' => x_control_groups_element_accordion_item( true ),
    'options' => array(
      'inline' => array(
        'accordion_item_content' => array(
          'selector' => '.x-acc-content'
        ),
        'accordion_item_header_content' => array(
          'selector'       => '.x-acc-header',
          'editing_target' => '.x-acc-header-text'
        )
      )
    )
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'accordion-item', x_element_base( $data ) );
