<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/POST.PHP
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
    'post_query'  => cs_value( 'inherit', 'markup' )
  ),
  'omega'
);


// Style
// =============================================================================

function x_element_style_post() {
  return x_get_view( 'styles/elements', 'post', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_post( $data ) {
  return x_get_view( 'elements', 'post', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Post', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_post',
  'style' => 'x_element_style_post',
  'render' => 'x_element_render_post',
  'icon' => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_post() {
  return cs_compose_controls(
    array(
      'controls'       => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'post:setup',
          'controls'   => array(
            // placeholder
          ),
        )
      ),
      'controls_std_content' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Query', '__x__' ),
          'controls'   => array(
            // placeholder
          ),
        )
      ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            // placeholder
          ),
        ),
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Base Colors', '__x__' ),
          'controls'   => array(
            // placeholder
          ),
        )
      ),
      'control_nav' => array(
        'post'        => __( 'Post', '__x__' ),
        'post:setup'  => __( 'Setup', '__x__' ),
        'post:design' => __( 'Design', '__x__' ),
      ),
    ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'post', $data );
