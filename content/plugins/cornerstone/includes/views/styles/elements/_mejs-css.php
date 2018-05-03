<?php

// =============================================================================
// _MEJS-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
// =============================================================================

// Base
// =============================================================================

?>

.$_el .x-mejs .mejs-controls {
  @if $mejs_type === 'video' {
    margin: $mejs_controls_margin;
  }
  @unless $mejs_controls_border_width?? || $mejs_controls_border_style?? {
    border-width: $mejs_controls_border_width;
    border-style: $mejs_controls_border_style;
    border-color: $mejs_controls_border_color;
  }
  @unless $mejs_controls_border_radius?? {
    border-radius: $mejs_controls_border_radius;
  }
  @unless $mejs_controls_padding?? {
    padding: $mejs_controls_padding;
  }
  background-color: $mejs_controls_bg_color;
  @unless $mejs_controls_box_shadow_dimensions?? {
    box-shadow: $mejs_controls_box_shadow_dimensions $mejs_controls_box_shadow_color;
  }
}

.$_el .x-mejs .mejs-button button {
  color: $mejs_controls_button_color;
}

.$_el .x-mejs .mejs-button button:hover,
.$_el .x-mejs .mejs-button button:focus {
  color: $mejs_controls_button_color_alt;
}

.$_el .x-mejs .mejs-time-total {
  @unless $mejs_controls_border_radius?? {
    border-radius: $mejs_controls_time_rail_border_radius;
  }
  background-color: $mejs_controls_time_total_bg_color;
  @unless $mejs_controls_time_rail_box_shadow_dimensions?? {
    box-shadow: $mejs_controls_time_rail_box_shadow_dimensions $mejs_controls_time_rail_box_shadow_color;
  }
}

.$_el .x-mejs .mejs-time-loaded {
  background-color: $mejs_controls_time_loaded_bg_color;
}

.$_el .x-mejs .mejs-time-current {
  background-color: $mejs_controls_time_current_bg_color;
}

.$_el .x-mejs .mejs-time {
  color: $mejs_controls_color;
}