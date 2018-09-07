<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TABS.PHP
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
  'title'  => __( 'Tabs', '__x__' ),
  'values' => x_values_element_tabs(),
  'options' => array(
    'render_children'  => true,
    'default_children' => array(
      array( '_type' => 'tab', 'tab_label_content' => __( 'Tab 1', '__x__' ) ),
      array( '_type' => 'tab', 'tab_label_content' => __( 'Tab 2', '__x__' ), 'tab_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pretium, nisi ut volutpat mollis, leo risus interdum arcu, eget facilisis quam felis id mauris. Ut convallis, lacus nec ornare volutpat, velit turpis scelerisque purus.', '__x__' ) ),
    ),
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_tabs() {
  return array(
    'controls'           => x_controls_element_tabs(),
    'controls_adv'       => x_controls_element_tabs( true ),
    'control_groups'     => x_control_groups_element_tabs(),
    'control_groups_adv' => x_control_groups_element_tabs( true ),
    'options' => array(
      'inline' => array(
        'tab_label_content' => array(
          'selector' => '.x-tabs-list button span'
        ),
        'tab_content' => array(
          'selector' => '.x-tabs-panel'
        )
      )
    )
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'tabs', x_element_base( $data ) );
