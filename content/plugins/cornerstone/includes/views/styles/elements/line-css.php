<?php

// =============================================================================
// LINE-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
// =============================================================================

// Base
// =============================================================================

?>

.$_el.x-line {
  @if $line_direction === 'horizontal' {
    width: $line_width;
    max-width: $line_max_width;
  }
  @if $line_direction === 'vertical' {
    height: $line_height;
    max-height: $line_max_height;
  }
  @unless $line_margin?? {
    margin: $line_margin;
  }
  @if $line_direction === 'horizontal' {
    border-top-width: $line_size;
  }
  @if $line_direction === 'vertical' {
    border-left-width: $line_size;
  }
  border-style: $line_style;
  border-color: $line_color;
  @unless $line_border_radius?? {
    border-radius: $line_border_radius;
  }
  @unless $line_border_radius?? {
    border-radius: $line_border_radius;
  }
  font-size: $line_base_font_size;
  @unless $line_box_shadow_dimensions?? {
    box-shadow: $line_box_shadow_dimensions $line_box_shadow_color;
  }
}