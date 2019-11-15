<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CONTENT-AREA-DROPDOWN.PHP
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
  cs_values( 'content-area:dynamic', 'dropdown' ),
  'toggle',
  'dropdown',
  'omega',
  'omega:toggle-hash'
);

// Style
// =============================================================================

function x_element_style_content_area_dropdown() {
  $style = cs_get_partial_style( 'anchor', array(
    'selector' => '',
    'key_prefix'    => 'toggle'
  ) );

  $style .= cs_get_partial_style( 'dropdown' );

  return $style;

}



// Render
// =============================================================================

function x_element_render_content_area_dropdown( $data ) {

  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'dropdown',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Dropdown Content', '__x__' ),
    ), $data['id'], $data['mod_id'] )
  );

  return x_get_view( 'elements', 'content-area-dropdown', '', $data, false );

}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Content Area Dropdown', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_content_area_dropdown',
  'style' => 'x_element_style_content_area_dropdown',
  'render' => 'x_element_render_content_area_dropdown',
  'icon' => 'native'
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_content_area_dropdown() {

  return cs_compose_controls(
    cs_partial_controls( 'content-area', array(
      'type' => 'dropdown',
      'k_pre' => 'dropdown',
      'label_prefix' => __( 'Dropdown', '__x__' )
    ) ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'dropdown' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );

}



// Register Module
// =============================================================================

cs_register_element( 'content-area-dropdown', $data );
