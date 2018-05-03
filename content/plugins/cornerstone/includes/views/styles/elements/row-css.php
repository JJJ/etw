<?php

// =============================================================================
// ROW-CSS.PHP
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

.$_el.x-container {
  @if $row_inner_container === false {
    @if $row_width !== 'auto' {
      width: $row_width;
    }
    @unless $row_max_width?? {
      max-width: $row_max_width;
    }
  }
  @unless $row_margin?? {
    margin: $row_margin;
  }
  @unless $row_border_width?? || $row_border_style?? {
    border-width: $row_border_width;
    border-style: $row_border_style;
    border-color: $row_border_color;
  }
  @unless $row_border_radius?? {
    border-radius: $row_border_radius;
  }
  @unless $row_padding?? {
    padding: $row_padding;
  }
  @unless $row_base_font_size === '1em' {
    font-size: $row_base_font_size;
  }
  @unless $row_text_align?? {
    text-align: $row_text_align;
  }
  background-color: $row_bg_color;
  @unless $row_box_shadow_dimensions?? {
    @if $row_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $row_box_shadow_color !== 'transparent' {
      box-shadow: $row_box_shadow_dimensions $row_box_shadow_color;
    }
  }
  z-index: $row_z_index;
}