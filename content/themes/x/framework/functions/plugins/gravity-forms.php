<?php

// =============================================================================
// FUNCTIONS/GLOBAL/PLUGINS/GRAVITY-FORMS.PHP
// -----------------------------------------------------------------------------
// Plugin setup for theme compatibility.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Styles
// =============================================================================

// Styles
// =============================================================================

function x_gravity_forms_enqueue_styles( $stack, $ext ) {
  wp_enqueue_style( 'x-gravity-forms', X_TEMPLATE_URL . '/framework/dist/css/site/gravity_forms/' . $stack . $ext . '.css', array( 'gforms_reset_css', 'gforms_formsmain_css', 'gforms_ready_class_css', 'gforms_browsers_css' ), X_ASSET_REV, 'all' );
}

add_action( 'x_enqueue_styles', 'x_gravity_forms_enqueue_styles', 10, 2 );
