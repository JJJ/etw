<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/ACCORDION-ITEM.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Groups
//   03. Values
//   04. Define Element
//   05. Builder Setup
//   06. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  array(
    'accordion_item_starts_open'    => cs_value( false, 'markup' ),
    'accordion_item_header_content' => cs_value( __( 'Accordion Item', '__x__' ), 'markup:html', true ),
    'accordion_item_content'        => cs_value( __( 'This is the accordion body content. It is typically best to keep this area short and to the point so it isn\'t too overwhelming.', '__x__' ), 'markup:html', true ),
  ),
  'omega',
  'omega:toggle-hash'
);


// Render
// =============================================================================

function x_element_render_accordion_item( $data ) {
  return x_get_view( 'elements', 'accordion-item', '', $data, false );
}


// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Accordion Item', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_accordion_item',
  'render' => 'x_element_render_accordion_item',
  'icon' => 'native',
  'options' => array(
    'library'        => false,
    'child'          => true,
    'alt_breadcrumb' => __( 'Item', '__x__' ),
    'label_key'      => 'accordion_item_header_content',
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


// Builder Setup
// =============================================================================

function x_element_builder_setup_accordion_item() {

  $control_setup = array(
    'type'     => 'group',
    'title'    => __( 'Content', '__x__' ),
    'group'    => 'accordion_item:setup',
    'controls' => array(
      array(
        'key'     => 'accordion_item_starts_open',
        'type'    => 'choose',
        'label'   => __( 'Starts Open', '__x__' ),
        'options' => cs_recall( 'options_choices_off_on_bool' ),
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
  );

  return cs_compose_controls(
    array(
      'controls' => array( $control_setup ),
      'controls_std_content' => array( $control_setup ),
      'control_nav' => array(
        'accordion_item'       => __( 'Accordion Item', '__x__' ),
        'accordion_item:setup' => __( 'Setup', '__x__' ),
      )
    ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );

}



// Register Module
// =============================================================================

cs_register_element( 'accordion-item', $data );
