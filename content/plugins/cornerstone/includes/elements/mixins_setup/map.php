<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/MAP.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Shared
//   02. Setup
//   03. Groups
//   04. Conditions
//   05. Options
//   06. Individual Controls
//   07. Control Lists
//   08. Control Groups (Advanced)
//   09. Control Groups (Standard)
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'map';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Map', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();



// Groups
// =============================================================================

$group_map_setup  = $group . ':setup';



// Conditions
// =============================================================================

$conditions            = x_module_conditions( $condition );
$conditions_map_embed  = array( $condition, array( 'map_type' => 'embed' ) );
$conditions_map_google = array( $condition, array( 'map_type' => 'google' ) );



// Options
// =============================================================================

$options_map_type = array(
  'choices' => array(
    array( 'value' => 'embed',  'label' => __( 'Embed', '__x__' ) ),
    array( 'value' => 'google', 'label' => __( 'Google', '__x__' ) ),
  ),
);

$options_map_embed_code = array(
  'height'    => $is_adv ? 4 : 3,
  'monospace' => true,
);

$options_map_google_controls = array(
  'list' => array(
    array( 'key' => 'drag', 'label' => __( 'Drag', '__x__' ), 'half' => true ),
    array( 'key' => 'zoom', 'label' => __( 'Zoom', '__x__' ), 'half' => true ),
  ),
);

$options_map_google_zoom_level = array(
  'unit_mode' => 'unitless',
  'min'       => 0,
  'max'       => 18,
  'step'      => 1
);

$options_google_map_styles = array(
  'monospace' => true,
);

$options_google_map_markers = array(
  'element' => 'map-marker',
);



// Individual Controls
// =============================================================================

$control_map_type = array(
  'key'     => 'map_type',
  'type'    => 'choose',
  'label'   => __( 'Map Type', '__x__' ),
  'options' => $options_map_type,
);

$control_map_embed_code = array(
  'key'        => 'map_embed_code',
  'type'       => 'textarea',
  'label'      => __( 'Embed Code', '__x__' ),
  'conditions' => $conditions_map_embed,
  'options'    => $options_map_embed_code,
);

$control_map_google_api_key = array(
  'key'        => 'map_google_api_key',
  'type'       => 'text',
  'label'      => __( 'API Key', '__x__' ),
  'conditions' => $conditions_map_google,
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
  'conditions' => $conditions_map_google,
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
  'conditions' => $conditions_map_google,
  'options'    => $options_map_google_controls,
);

$control_map_google_zoom_level = array(
  'key'        => 'map_google_zoom_level',
  'type'       => 'unit-slider',
  'label'      => __( 'Zoom Level', '__x__' ),
  'conditions' => $conditions_map_google,
  'options'    => $options_map_google_zoom_level,
);

$control_map_google_styles = array(
  'key'     => 'map_google_styles',
  'type'    => 'textarea',
  'label'   => __( 'JSON', '__x__' ) . '<a href="https://mapstyle.withgoogle.com/" target="_blank" style="display: -webkit-flex; display: flex; -webkit-justify-content: center; justify-content: center; -webkit-align-items: center; align-items: center; position: absolute; top: 50%; right: 10px; width: 2.75em; height: 1.5em; border-radius: 2px; font-size: 1em; line-height: 1; text-align: center; text-decoration: none; background-color: currentColor; transform: translate3d(0, -50%, 0);"><span style="color: #ffffff;">↪</span></a>',
  'options' => $options_google_map_styles,
);

$control_map_markers = array(
  'type'       => 'sortable',
  'title'      => __( 'Map Markers', '__x__' ),
  'group'      => $is_adv ? $group_map_setup : $group_std_content,
  'conditions' => $conditions_map_google,
  'options'    => $options_google_map_markers,
);



// Control Lists
// =============================================================================

$control_list_map_adv_setup = array(
  $control_map_type,
  $control_map_embed_code,
  $control_map_google_api_key,
  $control_map_google_lat_and_lng,
  $control_map_google_controls,
  $control_map_google_zoom_level,
);

$control_list_map_std_content_setup = array(
  $control_map_embed_code,
  $control_map_google_api_key,
  $control_map_google_lat,
  $control_map_google_lng,
);

$control_list_map_google_styles = array(
  $control_map_google_styles,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_map_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_map_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_map_adv_setup,
  ),
);

$control_group_map_adv_styles = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Google Map Styles', '__x__' ),
    'group'      => $group_map_setup,
    'conditions' => $conditions_map_google,
    'controls'   => $control_list_map_google_styles,
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_map_std_content_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Map Setup', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions,
    'controls'   => $control_list_map_std_content_setup,
  ),
);

$control_group_map_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Google Map Styles', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions_map_google,
    'controls'   => $control_list_map_google_styles,
  ),
);
