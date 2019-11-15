<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CONTENT-AREA-MODAL.PHP
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
  cs_values( 'content-area:dynamic', 'modal' ),
  'toggle',
  'modal',
  'omega',
  'omega:toggle-hash'
);

// Style
// =============================================================================

function x_element_style_content_area_modal() {
  $style = cs_get_partial_style( 'anchor', array(
    'selector' => '',
    'key_prefix'    => 'toggle'
  ) );

  $style .= cs_get_partial_style( 'modal' );
  return $style;
}



// Render
// =============================================================================

function x_element_render_content_area_modal( $data ) {

  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'modal',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Modal Content', '__x__' ),
    ), $data['id'], $data['mod_id'] )
  );

  cs_defer_partial( 'modal', cs_extract( $data, array( 'modal' => '' ) ) );

  return cs_get_partial_view( 'anchor', cs_extract( $data, array( 'toggle_anchor' => 'anchor', 'toggle' => '' ) ) );

}


// Define Element
// =============================================================================

$data = array(
  'title'     => __( 'Content Area Modal', '__x__' ),
  'values'    => $values,
  'builder' => 'x_element_builder_setup_content_area_modal',
  'style' => 'x_element_style_content_area_modal',
  'render' => 'x_element_render_content_area_modal',
  'icon' => 'native',
  'options' => array(
    'inline' => array(
      'modal_content' => array(
        'selector' => '.x-modal-content'
      ),
    )
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_content_area_modal() {
  return cs_compose_controls(
    cs_partial_controls( 'content-area', array(
      'type' => 'modal',
      'k_pre' => 'modal',
      'label_prefix' => __( 'Modal', '__x__' )
    ) ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'modal' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'content-area-modal', $data );
