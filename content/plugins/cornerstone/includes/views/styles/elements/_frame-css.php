<?php

// =============================================================================
// _FRAME-CSS.PHP
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

.$_el.x-frame {
  @if $frame_width !== 'auto' {
    width: $frame_width;
  }
  @unless $frame_max_width?? {
    max-width: $frame_max_width;
  }
  @unless $frame_margin?? {
    margin: $frame_margin;
  }
  @unless $frame_border_width?? || $frame_border_style?? {
    border-width: $frame_border_width;
    border-style: $frame_border_style;
    border-color: $frame_border_color;
  }
  @unless $frame_border_radius?? {
    border-radius: $frame_border_radius;
  }
  @unless $frame_padding?? {
    padding: $frame_padding;
  }
  font-size: $frame_base_font_size;
  @if $frame_bg_color !== 'transparent' {
    background-color: $frame_bg_color;
  }
  @unless $frame_box_shadow_dimensions?? {
    @if $frame_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $frame_box_shadow_color !== 'transparent' {
      box-shadow: $frame_box_shadow_dimensions $frame_box_shadow_color;
    }
  }
}

.$_el .x-frame-inner {
  @if $frame_content_sizing === 'fixed-height' {
    padding-bottom: $frame_content_height;
  }
  @if $frame_content_sizing === 'aspect-ratio' {
    padding-bottom: calc(($frame_content_aspect_ratio_height / $frame_content_aspect_ratio_width) * 100%);
  }
}