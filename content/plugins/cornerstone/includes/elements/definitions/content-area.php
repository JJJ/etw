<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CONTENT-AREA.PHP
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
  'title'  => __( 'Content Area', '__x__' ),
  'values' => array_merge(
    array(
      'content' => x_module_value( __( '<span>This content will show up directly in its container.</span>', '__x__' ), 'markup:html', true ),
    ),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_content_area() {
  return array(
    'control_groups' => array_merge(
      array(
        'content'       => array( 'title' => __( 'Content', '__x__' ) ),
        'content:setup' => array( 'title' => __( 'Setup', '__x__' ) ),
      ),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      array(
        array(
          'key'     => 'content',
          'type'    => 'text-editor',
          'title'   => __( 'Content', '__x__' ),
          'group'   => 'content:setup',
          'options' => array(
            'mode'   => 'html',
            'height' => 5,
          ),
        ),
      ),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'content-area', x_element_base( $data ) );
