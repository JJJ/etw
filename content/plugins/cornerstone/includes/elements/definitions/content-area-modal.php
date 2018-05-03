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
  'values' => array_merge(
    array(
      'modal_content' => x_module_value( __( '<div style="padding: 25px; line-height: 1.4; text-align: center;">Add any HTML or custom content here.</div>', '__x__' ), 'markup:html', true ),
    ),
    x_values_anchor( x_bar_module_settings_anchor( 'toggle' ) ),
    x_values_modal(),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_content_area_modal() {
  return array(
    'control_groups' => array_merge(
      array(
        'content'       => array( 'title' => __( 'Content', '__x__' ) ),
        'content:setup' => array( 'title' => __( 'Setup', '__x__' ) ),
      ),
      x_control_groups_anchor( x_bar_module_settings_anchor( 'toggle' ) ),
      x_control_groups_modal(),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      array(
        array(
          'key'     => 'modal_content',
          'type'    => 'text-editor',
          'title'   => __( 'Modal Content', '__x__' ),
          'group'   => 'content:setup',
          'options' => array(
            'mode'   => 'html',
            'height' => 5,
          ),
        ),
      ),
      x_controls_anchor( x_bar_module_settings_anchor( 'toggle' ) ),
      x_controls_modal(),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'content-area-modal', x_element_base( $data ) );
