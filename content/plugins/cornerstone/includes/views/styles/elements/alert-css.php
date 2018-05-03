<?php

// =============================================================================
// ALERT-CSS.PHP
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

.$_el.x-alert {
  @if $alert_width !== 'auto' {
    width: $alert_width;
  }
  @unless $alert_max_width?? {
    max-width: $alert_max_width;
  }
  margin: $alert_margin;
  border-width: $alert_border_width;
  border-style: $alert_border_style;
  border-color: $alert_border_color;
  border-radius: $alert_border_radius;
  padding: $alert_padding;
  font-family: $alert_font_family;
  font-size: $alert_font_size;
  font-style: $alert_font_style;
  font-weight: $alert_font_weight;
  line-height: $alert_line_height;
  letter-spacing: $alert_letter_spacing;
  @unless $alert_text_align?? {
    text-align: $alert_text_align;
  }
  @unless $alert_text_decoration?? {
    text-decoration: $alert_text_decoration;
  }
  text-shadow: $alert_text_shadow_dimensions $alert_text_shadow_color;
  text-transform: $alert_text_transform;
  color: $alert_text_color;
  background-color: $alert_bg_color;
  box-shadow: $alert_box_shadow_dimensions $alert_box_shadow_color;
}

@if $alert_close === true {
  .$_el .close {
    position: absolute;
    top: $alert_close_offset_top;
    @if $alert_close_location === 'left' {
      left: $alert_close_offset_side;
      right: auto;
    }
    @if $alert_close_location === 'right' {
      left: auto;
      right: $alert_close_offset_side;
    }
    bottom: auto;
    width: 1em;
    height: 1em;
    font-size: $alert_close_font_size;
    text-shadow: none;
    color: $alert_close_color;
    opacity: 1;
  }

  .$_el .close:hover,
  .$_el .close:focus {
    color: $alert_close_color_alt;
    opacity: 1;
  }
}