<?php

// =============================================================================
// LAYOUT-COLUMN-CSS.PHP
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

.$_el.x-col {
  @if $layout_column_flexbox {
    display: flex;
    flex-direction: $layout_column_flex_direction;
    justify-content: $layout_column_flex_justify;
    align-items: $layout_column_flex_align;
    @if $layout_column_flex_wrap === true {
      flex-wrap: wrap;
      align-content: $layout_column_flex_align;
    }
  }
  z-index: $layout_column_z_index;
  @unless $layout_column_min_width?? {
    min-width: $layout_column_min_width;
  }
  @unless $layout_column_max_width?? {
    max-width: $layout_column_max_width;
  }
  @unless $layout_column_min_height?? {
    min-height: $layout_column_min_height;
  }
  @unless $layout_column_max_height?? {
    max-height: $layout_column_max_height;
  }
  @unless $layout_column_border_width?? || $layout_column_border_style?? {
    border-width: $layout_column_border_width;
    border-style: $layout_column_border_style;
    border-color: $layout_column_border_color;
  }
  @unless $layout_column_border_radius?? {
    border-radius: $layout_column_border_radius;
  }
  @unless $layout_column_padding?? {
    padding: $layout_column_padding;
  }
  font-size: $layout_column_base_font_size;
  @unless $layout_column_text_align?? {
    text-align: $layout_column_text_align;
  }
  @if $layout_column_bg_color !== 'transparent' {
    background-color: $layout_column_bg_color;
  }
  @unless $layout_column_box_shadow_dimensions?? {
    @if $layout_column_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $layout_column_box_shadow_color !== 'transparent' {
      box-shadow: $layout_column_box_shadow_dimensions $layout_column_box_shadow_color;
    }
  }
}
