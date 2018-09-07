<?php

// =============================================================================
// FUNCTIONS/GLOBAL/PLUGINS/MODERN-EVENT-CALENDAR.PHP
// -----------------------------------------------------------------------------
// Plugin setup for theme compatibility.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Filter for Removing Support Box
//   02. Filter Container Classes
// =============================================================================

// Filter For Removing Support Box
// =============================================================================

add_filter( 'mec_dashboard_box_support', '__return_false' );
add_filter( 'mec_dashboard_box_stats', '__return_false' );



// Filter Container Classes
// =============================================================================

function x_mec_container_class() {
  return 'x-container max width';
}

add_filter( 'mec_single_page_html_class', 'x_mec_container_class' );
add_filter( 'mec_archive_page_html_class', 'x_mec_container_class' );
add_filter( 'mec_category_page_html_class', 'x_mec_container_class' );
