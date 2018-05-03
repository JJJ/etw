<?php
 
// =============================================================================
// FUNCTIONS/GLOBAL/ADMIN/CUSTOMIZER/OUTPUT/BASE.PHP
// -----------------------------------------------------------------------------
// Base global CSS output.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Navbar Container width
// =============================================================================

?>

/* Navbar Container width
// ========================================================================== */

<?php if ( $x_layout_site == 'boxed' ) : ?>

  /*
  // The navbar container width property is overwritten in a responsive
  // breakpoint in the masthead.php output file.
  */

  .x-navbar.x-navbar-fixed-top.x-container.max.width {
    width: <?php echo $x_layout_site_width . '%'; ?>;
    max-width: <?php echo $x_layout_site_max_width . 'px'; ?>;
  }

<?php endif; ?>