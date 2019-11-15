<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/NAV-LAYERED.PHP
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
  'menu-layered',
  'toggle',
  'off-canvas',
  'menu-item',
  array(
    'anchor_padding'            => cs_value( '0.75em', 'style' ),
    'anchor_text_margin'        => cs_value( '5px auto 5px 5px', 'style' ),
    'anchor_sub_indicator_icon' => cs_value( 'angle-right', 'markup' ),
  ),
  'omega',
  'omega:toggle-hash'
);


// Style
// =============================================================================

function x_element_style_nav_layered() {
  return x_get_view( 'styles/elements', 'nav-layered', 'css', array(), false );
}





// Render
// =============================================================================

function x_element_render_nav_layered( $data ) {

  $data_menu = cs_extract( $data,array( 'menu' => '', 'anchor' => '', 'sub_anchor' => '' ) );


  if ( $data['_region'] === 'top' || $data['_region'] === 'bottom' || $data['_region'] === 'footer' ) {

    // Output as Off Canvas in top/bottom header bars and footer bars
    cs_defer_partial( 'off-canvas', array_merge(
      cs_extract( $data, array( 'off_canvas' => '' ) ),
      array( 'off_canvas_content' => cs_get_partial_view( 'menu', $data_menu ) )
    ) );

    return cs_get_partial_view( 'anchor', cs_extract( $data, array( 'toggle_anchor' => 'anchor', 'toggle' => '' ) ) );


  } else {

    // Output inline in content or left/right header bars
    return cs_get_partial_view( 'menu', $data_menu );

  }

}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Navigation Layered', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_nav_layered',
  'style' => 'x_element_style_nav_layered',
  'render' => 'x_element_render_nav_layered',
  'icon' => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_layered() {
  return cs_compose_controls(
    cs_partial_controls( 'menu', array( 'type' => 'layered' ) ),
    cs_partial_controls( 'anchor', array_merge(
      cs_recall( 'settings_anchor:toggle' ),
      array( 'tbf_only' => true )
    ) ),
    cs_partial_controls( 'off-canvas', array( 'tbf_only' => true ) ),
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

cs_register_element( 'nav-layered', $data );
