<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CONTENT-AREA-OFF-CANVAS.PHP
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
  cs_values( 'content-area:dynamic', 'off_canvas' ),
  'toggle',
  'off-canvas',
  'omega',
  'omega:toggle-hash'
);

// Style
// =============================================================================

function x_element_style_content_area_off_canvas() {

  $style = cs_get_partial_style( 'anchor', array(
    'selector' => '',
    'key_prefix'    => 'toggle'
  ) );

  $style .= cs_get_partial_style( 'off-canvas' );

  return $style;

}



// Render
// =============================================================================

function x_element_render_content_area_off_canvas( $data ) {

  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'off-canvas',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Off Canvas Content', '__x__' ),
    ), $data['id'], $data['mod_id']),
    array(
      'dropdown_is_list' => false,
    )
  );

  cs_defer_partial( 'off-canvas', cs_extract( $data, array( 'off_canvas' => '' ) ) );

  return cs_get_partial_view( 'anchor', cs_extract( $data, array( 'toggle_anchor' => 'anchor', 'toggle' => '' ) ) );

}


// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Content Area Off Canvas', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_content_area_off_canvas',
  'style' => 'x_element_style_content_area_off_canvas',
  'render' => 'x_element_render_content_area_off_canvas',
  'icon' => 'native',
  'options' => array(
    'inline' => array(
      'off_canvas_content' => array(
        'selector' => '.x-off-canvas-content'
      ),
    )
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_content_area_off_canvas() {
  return cs_compose_controls(
    cs_partial_controls( 'content-area', array(
      'type' => 'off_canvas',
      'k_pre' => 'off_canvas',
      'label_prefix' => __( 'Off Canvas', '__x__' )
    ) ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'off-canvas' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'content-area-off-canvas', $data );
