<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/NAV-DROPDOWN.PHP
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
  'menu-dropdown',
  'toggle',
  'dropdown',
  'menu-item',
  array(
    'anchor_padding'     => cs_value( '0.75em', 'style' ),
    'anchor_text_margin' => cs_value( '5px auto 5px 5px', 'style' ),
  ),
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_style_nav_dropdown() {
  return x_get_view( 'styles/elements', 'nav-dropdown', 'css', array(), false );
}




// Render
// =============================================================================

function x_element_render_nav_dropdown( $data ) {

  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'dropdown',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Dropdown Content', '__x__' ),
    ), $data['id'], $data['mod_id'] ),
    array(
      'dropdown_is_list' => true,
    )
  );

  return x_get_view( 'elements', 'nav-dropdown', '', $data, false );

}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Navigation Dropdown', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_nav_dropdown',
  'style' => 'x_element_style_nav_dropdown',
  'render' => 'x_element_render_nav_dropdown',
  'icon' => 'native'
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_dropdown() {
  return cs_compose_controls(
    cs_partial_controls( 'menu', array( 'type' => 'dropdown' ) ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'dropdown' ),
    cs_partial_controls( 'anchor', array(
      'type'             => 'menu-item',
      'group'            => 'menu_item_anchor',
      'group_title'      => __( 'Links', '__x__' ),
      'is_nested'        => true,
      'label_prefix_std' => __( 'Menu Items', '__x__' )
    ) ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'nav-dropdown', $data );
