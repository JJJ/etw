<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/BUTTON.PHP
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
  'anchor-button',
  'omega'
);



// Style
// =============================================================================

function x_element_style_button() {
  return cs_get_partial_style( 'anchor' );
}



// Render
// =============================================================================

function x_element_render_button( $data ) {
  return cs_get_partial_view( 'anchor', $data );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Button', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_button',
  'render'  => 'x_element_render_button',
  'style'   => 'x_element_style_button',
  'icon'    => 'native',
  'options' => array(
    'inline' => array(
      'anchor_text_primary_content' => array(
        'selector' => '.x-anchor-text-primary'
      ),
      'anchor_text_secondary_content' => array(
        'selector' => '.x-anchor-text-secondary'
      )
    )
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_button() {
  return cs_compose_controls(
    cs_partial_controls( 'anchor', array(
      'type'             => 'button',
      'has_link_control' => true,
      'group'            => 'button_anchor',
      'group_title'      => __( 'Button', '__x__' ),
    ) ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'button', $data );
