<?php

// =============================================================================
// _OFF-CANVAS-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Close
//   04. Content
// =============================================================================

// Setup
// =============================================================================

$selector = ( isset( $selector ) && $selector != '' ) ? $selector : '';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';

// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?>.x-off-canvas {
  font-size: $<?php echo $key_prefix; ?>off_canvas_base_font_size;
}

.$_el<?php echo $selector; ?>.x-off-canvas .x-off-canvas-bg {
  @unless $<?php echo $key_prefix; ?>off_canvas_bg_color === 'transparent' {
    background-color: $<?php echo $key_prefix; ?>off_canvas_bg_color;
  }
}



<?php

// Close
// =============================================================================

?>

.$_el<?php echo $selector; ?>.x-off-canvas .x-off-canvas-close {
  width: calc(1em * $<?php echo $key_prefix; ?>off_canvas_close_dimensions);
  height: calc(1em * $<?php echo $key_prefix; ?>off_canvas_close_dimensions);
  font-size: $<?php echo $key_prefix; ?>off_canvas_close_font_size;
  color: $<?php echo $key_prefix; ?>off_canvas_close_color;
}

.$_el<?php echo $selector; ?>.x-off-canvas .x-off-canvas-close:hover,
.$_el<?php echo $selector; ?>.x-off-canvas .x-off-canvas-close:focus {
  color: $<?php echo $key_prefix; ?>off_canvas_close_color_alt;
}



<?php

// Content
// =============================================================================

?>

.$_el<?php echo $selector; ?>.x-off-canvas .x-off-canvas-content {
  max-width: $<?php echo $key_prefix; ?>off_canvas_content_max_width;
  @unless $<?php echo $key_prefix; ?>off_canvas_content_border_width?? || $<?php echo $key_prefix; ?>off_canvas_content_border_style?? {
    border-width: $<?php echo $key_prefix; ?>off_canvas_content_border_width;
    border-style: $<?php echo $key_prefix; ?>off_canvas_content_border_style;
    border-color: $<?php echo $key_prefix; ?>off_canvas_content_border_color;
  }
  padding: calc($<?php echo $key_prefix; ?>off_canvas_close_font_size * $<?php echo $key_prefix; ?>off_canvas_close_dimensions);
  @unless $<?php echo $key_prefix; ?>off_canvas_content_bg_color === 'transparent' {
    background-color: $<?php echo $key_prefix; ?>off_canvas_content_bg_color;
  }
  @unless $<?php echo $key_prefix; ?>off_canvas_content_box_shadow_dimensions?? {
    box-shadow: $<?php echo $key_prefix; ?>off_canvas_content_box_shadow_dimensions $<?php echo $key_prefix; ?>off_canvas_content_box_shadow_color;
  }
}
