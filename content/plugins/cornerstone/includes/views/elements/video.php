<?php

// =============================================================================
// VIEWS/BARS/VIDEO.PHP
// -----------------------------------------------------------------------------
// Video element.
// =============================================================================

// Data: Partials
// --------------

$data_video = x_get_partial_data( $_custom_data, array( 'find_data' => array( 'video' => '', 'mejs' => '' ), 'add_in' => array( 'id' => '', 'class' => '' ) ) );
$data_frame = x_get_partial_data( $_custom_data, array( 'find_data' => array( 'frame' => '' ) ) );


// Set Frame Content
// -----------------

$frame_content = array( 'frame_content' => x_get_view( 'partials', 'video', '', $data_video, false ), 'frame_content_type' => 'video-' . $video_type );
$data_frame    = array_merge( $data_frame, $frame_content );


// Output
// ------

x_get_view( 'partials', 'frame', '', $data_frame, true );
