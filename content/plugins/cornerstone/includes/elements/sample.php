<?php

// =============================================================================
// INCLUDES/ELEMENTS/SAMPLE.PHP
// -----------------------------------------------------------------------------
// Includes element sample data
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Breadcrumbs
// =============================================================================

// Breadcrumbs
// =============================================================================

function x_bars_sample_breadcrumbs( $crumbs, $args ) {

  $crumbs = array(
    array(
      'type'  => 'sample',
      'url'   => NULL,
      'label' => $args['home_label'],
    ),
    array(
      'type'  => 'sample',
      'url'   => NULL,
      'label' => __( 'Some', 'cornerstone' ),
    ),
    array(
      'type'  => 'sample',
      'url'   => NULL,
      'label' => __( 'Sample', 'cornerstone' ),
    ),
    array(
      'type'  => 'sample',
      'url'   => NULL,
      'label' => __( 'Breadcrumbs', 'cornerstone' ),
    )
  );

  return $crumbs;

}
