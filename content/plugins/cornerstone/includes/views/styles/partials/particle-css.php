<?php

// =============================================================================
// _PARTICLE-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
// =============================================================================

// Setup
// =============================================================================

$selector = ( isset( $selector ) ) ? $selector : ' .x-particle';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';



// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?> {
  width: $<?php echo $key_prefix; ?>particle_width;
  height: $<?php echo $key_prefix; ?>particle_height;
  @unless $<?php echo $key_prefix; ?>particle_border_radius?? {
    border-radius: $<?php echo $key_prefix; ?>particle_border_radius;
  }
  color: $<?php echo $key_prefix; ?>particle_color;
  transform-origin: $<?php echo $key_prefix; ?>particle_transform_origin;
}

.$_el<?php echo $selector; ?>[class*="active"] {
  @unless $<?php echo $key_prefix; ?>particle_delay?? {
    transition-delay: $<?php echo $key_prefix; ?>particle_delay;
  }
}
