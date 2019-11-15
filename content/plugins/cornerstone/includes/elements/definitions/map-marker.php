<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/MAP-MARKER.PHP
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
    'map_marker_lat'           => cs_value( '40.674', 'markup', true ),
    'map_marker_lng'           => cs_value( '-73.945', 'markup', true ),
    'map_marker_content_start' => cs_value( 'closed', 'markup', true ),
    'map_marker_content'       => cs_value( '', 'markup:html', true ),
    'map_marker_image_src'     => cs_value( '', 'markup', true ),
    'map_marker_image_retina'  => cs_value( true, 'markup', true ),
    'map_marker_image_width'   => cs_value( 48, 'markup', true ),
    'map_marker_image_height'  => cs_value( 48, 'markup', true ),
    'map_marker_offset_x'      => cs_value( '0%', 'markup', true ),
    'map_marker_offset_y'      => cs_value( '-50%', 'markup', true ),
  )
);



// Style
// =============================================================================

function x_element_style_map_marker() {
  return x_get_view( 'styles/elements', 'map-marker', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_map_marker( $data ) {
  return x_get_view( 'elements', 'map-marker', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Map Marker', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_map_marker',
  'style' => 'x_element_style_map_marker',
  'render' => 'x_element_render_map_marker',
  'icon' => 'native',
  'options' => array(
    'library'        => false,
    'child'          => true,
    'alt_breadcrumb' => __( 'Marker', '__x__' ),
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_map_marker() {

  $control_setup = array(
    'type'     => 'group',
    'title'    => __( 'Setup', '__x__' ),
    'group'    => 'map_marker:setup',
    'controls' => array(
      array(
        'type'     => 'group',
        'title'    => __( 'Latitude &amp; Longitude', '__x__' ),
        'controls' => array(
          array(
            'key'  => 'map_marker_lat',
            'type' => 'text',
          ),
          array(
            'key'  => 'map_marker_lng',
            'type' => 'text',
          ),
        ),
      ),
      array(
        'key'     => 'map_marker_content_start',
        'type'    => 'choose',
        'label'   => __( 'Content Start', '__x__' ),
        'options' => array(
          'choices' => array(
            array( 'value' => 'open',   'label' => __( 'Open', '__x__' )   ),
            array( 'value' => 'closed', 'label' => __( 'Closed', '__x__' ) ),
          ),
        ),
      ),
      array(
        'key'     => 'map_marker_content',
        'type'    => 'textarea',
        'label'   => __( 'Content', '__x__' ),
        'options' => array(
          'height' => 3,
        ),
      ),
    ),
  );

  $control_custom_image =  array(
    'keys' => array(
      'img_source' => 'map_marker_image_src',
      'is_retina'  => 'map_marker_image_retina',
      'width'      => 'map_marker_image_width',
      'height'     => 'map_marker_image_height',
    ),
    'type'  => 'image',
    'title' => __( 'Custom Image', '__x__' ),
    'group' => 'map_marker:setup',
  );

  $control_image_offset = array(
    'type'      => 'group',
    'title'     => __( 'Image Offset', '__x__' ),
    'group'     => 'map_marker:setup',
    'condition' => array( 'key' => 'map_marker_image_src', 'op' => 'NOT IN', 'value' => array( '' ) ),
    'controls'  => array(
      array(
        'key'     => 'map_marker_offset_x',
        'type'    => 'unit-slider',
        'label'   => __( 'Offset X', '__x__' ),
        'options' => array(
          'available_units' => array( '%' ),
          'fallback_value'  => '0%',
          'ranges'          => array( '%' => array( 'min' => -50, 'max' => 50, 'step' => 1 ) ),
        ),
      ),
      array(
        'key'     => 'map_marker_offset_y',
        'type'    => 'unit-slider',
        'label'   => __( 'Offset Y', '__x__' ),
        'options' => array(
          'available_units' => array( '%' ),
          'fallback_value'  => '-50%',
          'ranges'          => array( '%' => array( 'min' => -50, 'max' => 50, 'step' => 1 ) ),
        ),
      ),
    ),
  );

  return cs_compose_controls(
    array(
      'controls_std_content' => array(
        $control_setup
      ),
      'controls_std_design_setup' => array(
        $control_custom_image,
        $control_image_offset
      ),
      'controls' => array(
        $control_setup,
        $control_custom_image,
        $control_image_offset,
      ),
      'control_nav' => array(
        'map_marker'       => __( 'Map Marker', '__x__' ),
        'map_marker:setup' => __( 'Setup', '__x__' ),
      ),
    )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'map-marker', $data );
