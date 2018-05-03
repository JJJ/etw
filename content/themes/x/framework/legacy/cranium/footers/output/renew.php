<?php

// =============================================================================
// FUNCTIONS/GLOBAL/ADMIN/CUSTOMIZER/OUTPUT/RENEW.PHP
// -----------------------------------------------------------------------------
// Renew CSS ouptut.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Colophon
// =============================================================================

$x_renew_footer_background              = x_get_option( 'x_renew_footer_background' );
$x_renew_footer_text_color              = x_post_css_value( x_get_option( 'x_renew_footer_text_color' ), 'color' );

?>



/* Colophon
// ========================================================================== */

.x-colophon.bottom {
  background-color: <?php echo $x_renew_footer_background; ?>;
}

.x-colophon.bottom,
.x-colophon.bottom a,
.x-colophon.bottom .x-social-global a {
  color: <?php echo $x_renew_footer_text_color; ?>;
}
