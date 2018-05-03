<?php

// =============================================================================
// FUNCTIONS/GLOBAL/ADMIN/CUSTOMIZER/OUTPUT/INTEGRITY.PHP
// -----------------------------------------------------------------------------
// Integrity CSS ouptut.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Footer
// =============================================================================

$x_integrity_design                     = x_get_option( 'x_integrity_design' );
$x_integrity_footer_transparency_enable = x_get_option( 'x_integrity_footer_transparency_enable' );

?>

/* Footer
// ========================================================================== */

<?php if ( $x_integrity_design == 'light' ) : ?>

  <?php if ( $x_integrity_footer_transparency_enable == 1 ) : ?>

    .x-colophon.top,
    .x-colophon.bottom {
      border-top: 1px solid #e0e0e0;
      border-top: 1px solid rgba(0, 0, 0, 0.085);
      background-color: transparent;
      box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.8);
    }

  <?php endif; ?>

<?php else : ?>

  <?php if ( $x_integrity_footer_transparency_enable == 1 ) : ?>

    .x-colophon.top,
    .x-colophon.bottom {
      border-top: 1px solid #000;
      border-top: 1px solid rgba(0, 0, 0, 0.75);
      background-color: transparent;
      box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.075);
    }

  <?php endif; ?>

<?php endif; ?>
