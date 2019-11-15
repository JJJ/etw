<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/MAP.PHP
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
    'map_type'              => cs_value( 'embed', 'markup' ),
    'map_embed_code'        => cs_value( '', 'markup:html', true ),
    'map_google_api_key'    => cs_value( '', 'markup', true ),
    'map_google_lat'        => cs_value( '40.674', 'markup', true ),
    'map_google_lng'        => cs_value( '-73.945', 'markup', true ),
    'map_google_drag'       => cs_value( true, 'markup' ),
    'map_google_zoom'       => cs_value( true, 'markup' ),
    'map_google_zoom_level' => cs_value( 12, 'markup' ),
    'map_google_styles'     => cs_value( '', 'markup:raw' ),
  ),
  'frame',
  'omega'
);

// Style
// =============================================================================

function x_element_style_map() {
  return cs_get_partial_style( 'frame' );
}



// Render
// =============================================================================

function x_element_render_map( $data ) {

  return cs_get_partial_view( 'frame', array_merge(
    cs_extract( $data, array( 'frame' => '' ) ),
    array(
      'frame_content_type' => 'map-' . $data['map_type'],
      'frame_content' => cs_get_partial_view(
        'map',
        array_merge(
          cs_extract( $data, array( 'map' => '' ) ),
          array( 'id' => '', 'class' => '' )
        )
      )
    )
  ) );

}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Map', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_map',
  'style' => 'x_element_style_map',
  'render' => 'x_element_render_map',
  'icon' => 'native',
  'options' => array(
    'cache'             => false,
    'render_children'   => true,
    'empty_placeholder' => false,
    'default_children'  => array(),
    'valid_children'    => array( 'map-marker' ),
    'add_new_element'   => array( '_type' => 'map-marker' )
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_map() {

  // Individual Controls
  // -------------------

  $control_map_type = array(
    'key'     => 'map_type',
    'type'    => 'choose',
    'label'   => __( 'Map Type', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'embed',  'label' => __( 'Embed', '__x__' ) ),
        array( 'value' => 'google', 'label' => __( 'Google', '__x__' ) ),
      ),
    ),
  );

  $control_map_embed_code = array(
    'key'        => 'map_embed_code',
    'type'       => 'textarea',
    'label'      => __( 'Embed Code', '__x__' ),
    'condition'  => array( 'map_type' => 'embed' ),
    'options'    => array(
      'height'    => 4,
      'monospace' => true,
    )
  );

  $control_map_google_api_key = array(
    'key'        => 'map_google_api_key',
    'type'       => 'text',
    'label'      => __( 'API Key', '__x__' ),
    'condition'  => array( 'map_type' => 'google' ),
  );

  $control_map_google_lat = array(
    'key'   => 'map_google_lat',
    'type'  => 'text',
    'label' => __( 'Latitude', '__x__' ),
  );

  $control_map_google_lng = array(
    'key'   => 'map_google_lng',
    'type'  => 'text',
    'label' => __( 'Longitude', '__x__' ),
  );

  $control_map_google_lat_and_lng = array(
    'type'       => 'group',
    'label'      => __( 'Latitude &amp; Longitude', '__x__' ),
    'condition'  => array( 'map_type' => 'google' ),
    'controls'   => array(
      $control_map_google_lat,
      $control_map_google_lng,
    ),
  );

  $control_map_google_controls = array(
    'keys' => array(
      'drag' => 'map_google_drag',
      'zoom' => 'map_google_zoom',
    ),
    'type'       => 'checkbox-list',
    'label'      => __( 'Enable Controls', '__x__' ),
    'condition'  => array( 'map_type' => 'google' ),
    'options'    => array(
    'list' => array(
      array( 'key' => 'drag', 'label' => __( 'Drag', '__x__' ) ),
      array( 'key' => 'zoom', 'label' => __( 'Zoom', '__x__' ) ),
    ),
  ),
  );

  $control_map_google_zoom_level = array(
    'key'        => 'map_google_zoom_level',
    'type'       => 'unit-slider',
    'label'      => __( 'Zoom Level', '__x__' ),
    'condition'  => array( 'map_type' => 'google' ),
    'options'    => array(
    'unit_mode' => 'unitless',
    'min'       => 0,
    'max'       => 18,
    'step'      => 1
  ),
  );

  $control_map_google_styles = array(
    'key'     => 'map_google_styles',
    'type'    => 'textarea',
    'label'   => __( 'JSON', '__x__' ) . '<a href="https://mapstyle.withgoogle.com/" target="_blank" style="display: -webkit-flex; display: flex; -webkit-justify-content: center; justify-content: center; -webkit-align-items: center; align-items: center; position: absolute; top: 50%; right: 10px; width: 2.75em; height: 1.5em; border-radius: 2px; font-size: 1em; line-height: 1; text-align: center; text-decoration: none; background-color: currentColor; transform: translate3d(0, -50%, 0);"><span style="color: #ffffff;">↪</span></a>',
    'options' => array(
      'monospace' => true,
    ),
  );

  $control_map_markers = array(
    'type'       => 'sortable',
    'label'      => __( 'Map Markers', '__x__' ),
    'group'      => 'map:setup',
    'condition'  => array( 'map_type' => 'google' )
  );

  // Control Groups (Advanced)
  // -------------------------

  $control_group_map_adv_setup = array(
    'type'       => 'group',
    'label'      => __( 'Setup', '__x__' ),
    'group'      => 'map:setup',
    'controls'   => array(
      $control_map_type,
      $control_map_embed_code,
      $control_map_google_api_key,
      $control_map_google_lat_and_lng,
      $control_map_google_controls,
      $control_map_google_zoom_level,
    ),
  );

  $control_group_map_google_styles = array(
    'type'       => 'group',
    'label'      => __( 'Google Map Styles', '__x__' ),
    'group'      => 'map:setup',
    'condition'  => array( 'map_type' => 'google' ),
    'controls'   => array(
      $control_map_google_styles,
    ),
  );



  // Control Groups (Standard)
  // =============================================================================

  $controls = cs_compose_controls(
    array(
      'controls' => array(
        $control_group_map_adv_setup,
        $control_map_markers,
        $control_group_map_google_styles
      ),
      'controls_std_content' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Map Setup', '__x__' ),
          'controls'   => array(
            cs_amend_control( $control_map_embed_code, array( 'options' => array( 'height' => 3 ) ) ),
            $control_map_google_api_key,
            $control_map_google_lat,
            $control_map_google_lng,
          ),
        ),
        $control_map_markers,
      ),
      'controls_std_design_setup' => array(
        $control_group_map_google_styles
      ),
      'control_nav' => array(
        'map'       => __( 'Map', '__x__' ),
        'map:setup' => __( 'Setup', '__x__' ),
      ),
    ),
    cs_partial_controls( 'frame', array( 'frame_content_type' => 'map' ) ),
    cs_partial_controls( 'omega' )
  );

  return array_merge( $controls,
    array(
      'options' => array(
        'valid_children' => array( 'map-marker' )
      )
    )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'map', $data );
