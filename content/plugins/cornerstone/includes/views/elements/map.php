<?php

// =============================================================================
// VIEWS/BARS/MAP.PHP
// -----------------------------------------------------------------------------
// Map element.
// =============================================================================

// Data: Partials
// --------------

$data_map   = x_get_partial_data( $_custom_data, array( 'find_data' => array( 'map' => '' ), 'add_in' => array( 'id' => '', 'class' => '' ) ) );
$data_frame = x_get_partial_data( $_custom_data, array( 'find_data' => array( 'frame' => '' ) ) );


// Set Frame Content
// -----------------

$frame_content = array( 'frame_content' => x_get_view( 'partials', 'map', '', $data_map, false ), 'frame_content_type' => 'map-' . $map_type );
$data_frame    = array_merge( $data_frame, $frame_content );


// Output
// ------

x_get_view( 'partials', 'frame', '', $data_frame, true );
