<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SEARCH-DROPDOWN.PHP
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
  'toggle',
  'dropdown',
  cs_values( array(
    'dropdown_width' => cs_value( '300px', 'style' )
  ) ),
  'search-dropdown',
  'omega',
  'omega:toggle-hash'
);


// Style
// =============================================================================

function x_element_style_search_dropdown() {

  $style = cs_get_partial_style( 'anchor', array(
    'selector' => '.x-anchor-toggle',
    'key_prefix'    => 'toggle'
  ) );

  $style .= cs_get_partial_style( 'dropdown' );
  $style .= cs_get_partial_style( 'search' );

  return $style;

}



// Render
// =============================================================================

function x_element_render_search_dropdown( $data ) {

  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'dropdown',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Dropdown Content', '__x__' ),
    ), $data['id'], $data['mod_id'] )
  );

  return x_get_view( 'elements', 'search-dropdown', '', $data, false );

}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Search Dropdown', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_search_dropdown',
  'style' => 'x_element_style_search_dropdown',
  'render' => 'x_element_render_search_dropdown',
  'icon' => 'native'
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_search_dropdown() {
  return cs_compose_controls(
    cs_partial_controls( 'anchor',  cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'dropdown' ),
    cs_partial_controls( 'search', array( 'type' => 'dropdown', 'label_prefix' => __( 'Search', '__x__' ) ) ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'search-dropdown', $data );
