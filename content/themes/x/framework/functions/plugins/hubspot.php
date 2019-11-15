<?php

// =============================================================================
// FUNCTIONS/GLOBAL/PLUGINS/HUBSPOT.PHP
// -----------------------------------------------------------------------------
// Plugin setup for theme compatibility.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Update Attribution
// =============================================================================

// Update Attribution
// =============================================================================

function x_set_hubspot_attribution_code( $attribution_code ) {

  // This is appended to HubSpot's tracking in their signup iframe.
  $tc_attribution_code = 'utm_medium=wordpress&utm_source=themeco';
  return $tc_attribution_code;

}

add_filter( 'pre_option_hubspot_acquisition_attribution', 'x_set_hubspot_attribution_code' );
