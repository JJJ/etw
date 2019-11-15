<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TAB.PHP
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
    'tab_label_content' => cs_value( __( 'Tab', '__x__' ), 'markup:html', true ),
    'tab_content'       => cs_value( __( 'This is the tab body content. It is typically best to keep this area short and to the point so it isn\'t too overwhelming.', '__x__' ), 'markup:html', true ),
  ),
  'omega',
  'omega:toggle-hash'
);


// Style
// =============================================================================

function x_element_style_tab() {
  return x_get_view( 'styles/elements', 'tab', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_tab( $data ) {
  return x_get_view( 'elements', 'tab', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Tab', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_tab',
  'style' => 'x_element_style_tab',
  'render' => 'x_element_render_tab',
  'icon' => 'native',
  'options' => array(
    'library'   => false,
    'child'     => true,
    'label_key' => 'tab_label_content',
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_tab() {

  $control_setup = array(
    'type'     => 'group',
    'title'    => __( 'Content', '__x__' ),
    'group'    => 'tab:setup',
    'controls' => array(
      array(
        'key'     => 'tab_label_content',
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
  );

  return cs_compose_controls(
    array(
      'controls' => array( $control_setup ),
      'controls_std_content' => array( $control_setup ),
      'control_nav' => array(
        'tab' => __( 'Tab', '__x__' ),
        'tab:setup' => __( 'Setup', '__x__' )
      )
    ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );

}



// Register Module
// =============================================================================

cs_register_element( 'tab', $data );
