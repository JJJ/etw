<?php

// =============================================================================
// VIEWS/BARS/AUDIO.PHP
// -----------------------------------------------------------------------------
// Audio element.
// =============================================================================

// Data: Partials
// --------------

$data_audio = x_get_partial_data( $_custom_data, array( 'find_data' => array( 'audio' => '', 'mejs' => '' ) ) );


// Output
// ------

x_get_view( 'partials', 'audio', '', $data_audio, true );
