<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/MAP-MARKER.PHP
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
//   05. Settings
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'map_marker';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Map Marker', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();

  

// Groups
// =============================================================================

$group_map_marker_setup = $group . ':setup';



// Conditions
// =============================================================================

$condition_map_marker_has_image = array( 'key' => 'map_marker_image_src', 'op' => 'NOT IN', 'value' => array( '' ) );



// Settings
// =============================================================================

$settings_map_marker_offset_x = array(
  'available_units' => array( '%' ),
  'fallback_value'  => '0%',
  'ranges'          => array( '%' => array( 'min' => -50, 'max' => 50, 'step' => 1 ) ),
);

$settings_map_marker_offset_y = array(
  'available_units' => array( '%' ),
  'fallback_value'  => '-50%',
  'ranges'          => array( '%' => array( 'min' => -50, 'max' => 50, 'step' => 1 ) ),
);
