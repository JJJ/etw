<?php

// =============================================================================
// COUNTER-CSS.PHP
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

.$_el.x-counter {
  @if $counter_width !== 'auto' {
    width: $counter_width;
  }
  @unless $counter_max_width?? {
    max-width: $counter_max_width;
  }
  @unless $counter_margin?? {
    margin: $counter_margin;
  }
  font-size: $counter_base_font_size;
}

.$_el .x-counter-number-wrap {
  @if $counter_before_after === true {
    margin: $counter_number_margin;
  }
  font-family: $counter_number_font_family;
  font-size: $counter_number_font_size;
  font-style: $counter_number_font_style;
  font-weight: $counter_number_font_weight;
  line-height: $counter_number_line_height;
  @unless $counter_number_letter_spacing?? {
    letter-spacing: $counter_number_letter_spacing;
    margin-right: calc($counter_number_letter_spacing * -1);
  }
  @unless $counter_number_text_align?? {
    text-align: $counter_number_text_align;
  }
  @unless $counter_number_text_decoration?? {
    text-decoration: $counter_number_text_decoration;
  }
  @unless $counter_number_text_shadow_dimensions?? {
    @if $counter_number_text_shadow_color === 'transparent' {
      text-shadow: none;
    }
    @if $counter_number_text_shadow_color !== 'transparent' {
      text-shadow: $counter_number_text_shadow_dimensions $counter_number_text_shadow_color;
    }
  }
  @unless $counter_number_text_transform?? {
    text-transform: $counter_number_text_transform;
  }
  color: $counter_number_text_color;
}

@if $counter_before_after === true {
  .$_el .x-counter-before,
  .$_el .x-counter-after {
    font-family: $counter_before_after_font_family;
    font-size: $counter_before_after_font_size;
    font-style: $counter_before_after_font_style;
    font-weight: $counter_before_after_font_weight;
    line-height: $counter_before_after_line_height;
    @unless $counter_before_after_letter_spacing?? {
      letter-spacing: $counter_before_after_letter_spacing;
      margin-right: calc($counter_before_after_letter_spacing * -1);
    }
    @unless $counter_before_after_text_align?? {
      text-align: $counter_before_after_text_align;
    }
    @unless $counter_before_after_text_decoration?? {
      text-decoration: $counter_before_after_text_decoration;
    }
    @unless $counter_before_after_text_shadow_dimensions?? {
      @if $counter_before_after_text_shadow_color === 'transparent' {
        text-shadow: none;
      }
      @if $counter_before_after_text_shadow_color !== 'transparent' {
        text-shadow: $counter_before_after_text_shadow_dimensions $counter_before_after_text_shadow_color;
      }
    }
    @unless $counter_before_after_text_transform?? {
      text-transform: $counter_before_after_text_transform;
    }
    color: $counter_before_after_text_color;
  }
}