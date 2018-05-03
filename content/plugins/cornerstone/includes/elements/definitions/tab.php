<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TAB.PHP
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
  'title'  => __( 'Tab', '__x__' ),
  'values' => array_merge(
    array(
      'tab_label'   => x_module_value( __( 'Tab', '__x__' ), 'markup:html', true ),
      'tab_content' => x_module_value( __( 'This is the tab body content. It is typically best to keep this area short and to the point so it isn\'t too overwhelming.', '__x__' ), 'markup:html', true ),
    ),
    x_values_omega()
  ),
  'options' => array(
    'shadow' => true,
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_tab() {
  return array(
    'control_groups' => array_merge(
      array(
        'tab'       => array( 'title' => __( 'Tab', '__x__' )   ),
        'tab:setup' => array( 'title' => __( 'Setup', '__x__' ) ),
      ),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      array(
        array(
          'type'     => 'group',
          'title'    => __( 'Content', '__x__' ),
          'group'    => 'tab:setup',
          'controls' => array(
            array(
              'key'     => 'tab_label',
              'type'    => 'text-editor',
              'label'   => __( 'Label', '__x__' ),
              'options' => array(
                'height' => 1,
              ),
            ),
            array(
              'key'     => 'tab_content',
              'type'    => 'text-editor',
              'label'   => __( 'Content', '__x__' ),
              'options' => array(
                'height' => 4,
              ),
            ),
          ),
        )
      ),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'tab', x_element_base( $data ) );
