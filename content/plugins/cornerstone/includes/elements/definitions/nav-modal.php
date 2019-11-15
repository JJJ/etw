<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/NAV-MODAL.PHP
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
  'menu-modal',
  'toggle',
  'modal',
  'menu-item',
  array(
    'anchor_padding'            => cs_value( '0.75em', 'style' ),
    'anchor_sub_indicator_icon' => cs_value( 'angle-right', 'markup' ),
  ),
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_style_nav_modal() {
  return x_get_view( 'styles/elements', 'nav-modal', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_nav_modal( $data ) {

  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'modal',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Modal Content', '__x__' ),
    ), $data['id'], $data['mod_id'] )
  );

  cs_defer_partial( 'modal', array_merge(
    cs_extract( $data, array( 'modal' => '' ) ),
    array(
      'modal_content' => cs_get_partial_view(
        'menu',
        cs_extract( $data, array( 'menu' => '', 'anchor' => '', 'sub_anchor' => '' ) )
      )
    )
  ) );

  return cs_get_partial_view( 'anchor', cs_extract( $data, array( 'toggle_anchor' => 'anchor', 'toggle' => '' ) ) );

}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Navigation Modal', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_nav_modal',
  'style' => 'x_element_style_nav_modal',
  'render' => 'x_element_render_nav_modal',
  'icon' => 'native'
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_modal() {
  return cs_compose_controls(
    cs_partial_controls( 'menu', array( 'type' => 'modal' ) ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'modal' ),
    cs_partial_controls( 'anchor', array(
      'type'             => 'menu-item',
      'group'            => 'menu_item_anchor',
      'group_title'      => __( 'Links', '__x__' ),
      'is_nested'        => true,
      'label_prefix_std' => __( 'Menu Items', '__x__' )
    ) ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'nav-modal', $data );
