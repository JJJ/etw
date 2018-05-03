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
  'title'  => __( 'Accordion Item', '__x__' ),
  'values' => array_merge(
    array(
      'accordion_item_starts_open'    => x_module_value( false, 'markup' ),
      'accordion_item_header_content' => x_module_value( __( 'Accordion Item', '__x__' ), 'markup:html', true ),
      'accordion_item_content'        => x_module_value( __( 'This is the accordion body content. It is typically best to keep this area short and to the point so it isn\'t too overwhelming.', '__x__' ), 'markup:html', true ),
    ),
    x_values_omega()
  ),
  'options' => array(
    'shadow'         => true,
    'alt_breadcrumb' => __( 'Item', '__x__' ),
  )
);


// Builder Setup
// =============================================================================

function x_element_builder_setup_accordion_item() {
  return array(
    'control_groups' => array_merge(
      array(
        'accordion_item'       => array( 'title' => __( 'Accordion Item', '__x__' ) ),
        'accordion_item:setup' => array( 'title' => __( 'Setup', '__x__' )          ),
      ),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      array(
        array(
          'type'     => 'group',
          'title'    => __( 'Content', '__x__' ),
          'group'    => 'accordion_item:setup',
          'controls' => array(
            array(
              'key'     => 'accordion_item_starts_open',
              'type'    => 'choose',
              'label'   => __( 'Starts Open', '__x__' ),
              'options' => array(
                'choices' => array(
                  array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
                  array( 'value' => true,  'label' => __( 'On', '__x__' )  ),
                ),
              ),
            ),
            array(
              'key'     => 'accordion_item_header_content',
              'type'    => 'text-editor',
              'label'   => __( 'Header', '__x__' ),
              'options' => array(
                'height' => 1,
              ),
            ),
            array(
              'key'     => 'accordion_item_content',
              'type'    => 'text-editor',
              'label'   => __( 'Content', '__x__' ),
              'options' => array(
                'height' => 3,
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

cornerstone_register_element( 'accordion-item', x_element_base( $data ) );
