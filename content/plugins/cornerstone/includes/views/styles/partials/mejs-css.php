<?php

// =============================================================================
// _MEJS-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
// =============================================================================

// Setup
// =============================================================================

$selector   = ( isset( $selector ) && $selector != '' ) ? $selector : '';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';

// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?> .x-mejs .mejs-controls {
  @if $<?php echo $key_prefix; ?>mejs_type === 'video' {
    margin: $<?php echo $key_prefix; ?>mejs_controls_margin;
  }
  @unless $<?php echo $key_prefix; ?>mejs_controls_border_width?? || $<?php echo $key_prefix; ?>mejs_controls_border_style?? {
    border-width: $<?php echo $key_prefix; ?>mejs_controls_border_width;
    border-style: $<?php echo $key_prefix; ?>mejs_controls_border_style;
    border-color: $<?php echo $key_prefix; ?>mejs_controls_border_color;
  }
  @unless $<?php echo $key_prefix; ?>mejs_controls_border_radius?? {
    border-radius: $<?php echo $key_prefix; ?>mejs_controls_border_radius;
  }
  @unless $<?php echo $key_prefix; ?>mejs_controls_padding?? {
    padding: $<?php echo $key_prefix; ?>mejs_controls_padding;
  }
  background-color: $<?php echo $key_prefix; ?>mejs_controls_bg_color;
  @unless $<?php echo $key_prefix; ?>mejs_controls_box_shadow_dimensions?? {
    box-shadow: $<?php echo $key_prefix; ?>mejs_controls_box_shadow_dimensions $<?php echo $key_prefix; ?>mejs_controls_box_shadow_color;
  }
}

.$_el<?php echo $selector; ?> .x-mejs .mejs-button button {
  color: $<?php echo $key_prefix; ?>mejs_controls_button_color;
}

.$_el<?php echo $selector; ?> .x-mejs .mejs-button button:hover,
.$_el<?php echo $selector; ?> .x-mejs .mejs-button button:focus {
  color: $<?php echo $key_prefix; ?>mejs_controls_button_color_alt;
}

.$_el<?php echo $selector; ?> .x-mejs .mejs-time-total {
  @unless $<?php echo $key_prefix; ?>mejs_controls_border_radius?? {
    border-radius: $<?php echo $key_prefix; ?>mejs_controls_time_rail_border_radius;
  }
  background-color: $<?php echo $key_prefix; ?>mejs_controls_time_total_bg_color;
  @unless $<?php echo $key_prefix; ?>mejs_controls_time_rail_box_shadow_dimensions?? {
    box-shadow: $<?php echo $key_prefix; ?>mejs_controls_time_rail_box_shadow_dimensions $<?php echo $key_prefix; ?>mejs_controls_time_rail_box_shadow_color;
  }
}

.$_el<?php echo $selector; ?> .x-mejs .mejs-time-loaded {
  background-color: $<?php echo $key_prefix; ?>mejs_controls_time_loaded_bg_color;
}

.$_el<?php echo $selector; ?> .x-mejs .mejs-time-current {
  background-color: $<?php echo $key_prefix; ?>mejs_controls_time_current_bg_color;
}

.$_el<?php echo $selector; ?> .x-mejs .mejs-time {
  color: $<?php echo $key_prefix; ?>mejs_controls_color;
}
