<?php

// =============================================================================
// COLUMN-CSS.PHP
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

.$_el.x-column {
  @unless $column_border_width?? || $column_border_style?? {
    border-width: $column_border_width;
    border-style: $column_border_style;
    border-color: $column_border_color;
  }
  @unless $column_border_radius?? {
    border-radius: $column_border_radius;
  }
  @unless $column_padding?? {
    padding: $column_padding;
  }
  @unless $column_base_font_size === '1em' {
    font-size: $column_base_font_size;
  }
  @unless $column_text_align?? {
    text-align: $column_text_align;
  }
  background-color: $column_bg_color;
  @unless $column_box_shadow_dimensions?? {
    @if $column_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $column_box_shadow_color !== 'transparent' {
      box-shadow: $column_box_shadow_dimensions $column_box_shadow_color;
    }
  }
}