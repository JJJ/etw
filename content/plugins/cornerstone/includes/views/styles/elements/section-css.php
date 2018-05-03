<?php

// =============================================================================
// SECTION-CSS.PHP
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

.$_el.x-section {
  margin: $section_margin;
  @unless $section_border_width?? || $section_border_style?? {
    border-width: $section_border_width;
    border-style: $section_border_style;
    border-color: $section_border_color;
  }
  padding: $section_padding;
  @unless $section_base_font_size === '1em' {
    font-size: $section_base_font_size;
  }
  @unless $section_text_align?? {
    text-align: $section_text_align;
  }
  background-color: $section_bg_color;
  @unless $section_box_shadow_dimensions?? {
    @if $section_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $section_box_shadow_color !== 'transparent' {
      box-shadow: $section_box_shadow_dimensions $section_box_shadow_color;
    }
  }
  z-index: $section_z_index;
}