<?php

// =============================================================================
// _TOGGLE-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Type: Burger
//   04. Type: Grid
//   05. Type: More
// =============================================================================

// Setup
// =============================================================================

$selector   = ( isset( $selector ) && $selector != '' ) ? $selector : '';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';

// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?> .x-toggle {
  color: $<?php echo $key_prefix; ?>toggle_color;
}

.$_el<?php echo $selector; ?>[class*="active"] .x-toggle,
.$_el<?php echo $selector; ?> .x-toggle[class*="active"] {
  color: $<?php echo $key_prefix; ?>toggle_color_alt;
}



<?php

// Type: Burger
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>toggle_type LIKE 'burger%' {
  .$_el<?php echo $selector; ?> .x-toggle-burger {
    width: $<?php echo $key_prefix; ?>toggle_burger_width;
    margin: $<?php echo $key_prefix; ?>toggle_burger_spacing 0;
    font-size: $<?php echo $key_prefix; ?>toggle_burger_size;
  }

  .$_el<?php echo $selector; ?> .x-toggle-burger-bun-t { transform: translate3d(0, -$<?php echo $key_prefix; ?>toggle_burger_spacing, 0); }
  .$_el<?php echo $selector; ?> .x-toggle-burger-bun-b { transform: translate3d(0, $<?php echo $key_prefix; ?>toggle_burger_spacing, 0);  }
}



<?php

// Type: Grid
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>toggle_type LIKE 'grid%' {
  .$_el<?php echo $selector; ?> .x-toggle-grid {
    margin: $<?php echo $key_prefix; ?>toggle_grid_spacing;
    font-size: $<?php echo $key_prefix; ?>toggle_grid_size;
  }

  .$_el<?php echo $selector; ?> .x-toggle-grid-center {
    box-shadow: -$<?php echo $key_prefix; ?>toggle_grid_spacing -$<?php echo $key_prefix; ?>toggle_grid_spacing, 0 -$<?php echo $key_prefix; ?>toggle_grid_spacing, $<?php echo $key_prefix; ?>toggle_grid_spacing -$<?php echo $key_prefix; ?>toggle_grid_spacing, -$<?php echo $key_prefix; ?>toggle_grid_spacing 0, $<?php echo $key_prefix; ?>toggle_grid_spacing 0, -$<?php echo $key_prefix; ?>toggle_grid_spacing $<?php echo $key_prefix; ?>toggle_grid_spacing, 0 $<?php echo $key_prefix; ?>toggle_grid_spacing, $<?php echo $key_prefix; ?>toggle_grid_spacing $<?php echo $key_prefix; ?>toggle_grid_spacing;
  }
}



<?php

// Type: More
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>toggle_type LIKE 'more%' {
  .$_el<?php echo $selector; ?> .x-toggle-more-h,
  .$_el<?php echo $selector; ?> .x-toggle-more-v {
    margin: $<?php echo $key_prefix; ?>toggle_more_spacing;
    font-size: $<?php echo $key_prefix; ?>toggle_more_size;
  }

  .$_el<?php echo $selector; ?> .x-toggle-more-1 { transform: translate3d(-$<?php echo $key_prefix; ?>toggle_more_spacing, 0, 0); }
  .$_el<?php echo $selector; ?> .x-toggle-more-3 { transform: translate3d($<?php echo $key_prefix; ?>toggle_more_spacing, 0, 0);  }
}
