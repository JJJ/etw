<?php

// =============================================================================
// COUNTDOWN-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
//   02. Units
//   03. Number
//   04. Digit
//   05. Label
//   06. Complete
//   07. Delimiter
// =============================================================================

// Base
// =============================================================================

?>

.$_el.x-countdown {
  @if $countdown_width !== 'auto' {
    width: $countdown_width;
  }
  @unless $countdown_max_width?? {
    max-width: $countdown_max_width;
  }
  @unless $countdown_margin?? {
    margin: $countdown_margin;
  }
  @unless $countdown_border_width?? || $countdown_border_style?? {
    border-width: $countdown_border_width;
    border-style: $countdown_border_style;
    border-color: $countdown_border_color;
  }
  @unless $countdown_border_radius?? {
    border-radius: $countdown_border_radius;
  }
  @if $countdown_padding?? {
    padding: 1px;
  }
  @unless $countdown_padding?? {
    padding: $countdown_padding;
  }
  font-size: $countdown_base_font_size;
  @if $countdown_bg_color !== 'transparent' {
    background-color: $countdown_bg_color;
  }
  @unless $countdown_box_shadow_dimensions?? {
    @if $countdown_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $countdown_box_shadow_color !== 'transparent' {
      box-shadow: $countdown_box_shadow_dimensions $countdown_box_shadow_color;
    }
  }
}



<?php

// Units
// =============================================================================

?>

.$_el .x-countdown-units {
  @if $countdown_padding?? {
    margin: calc((($countdown_unit_gap_row / 2) + 1px) * -1) calc((($countdown_unit_gap_column / 2) + 1px) * -1);
  }
  @unless $countdown_padding?? {    
    margin: calc(($countdown_unit_gap_row / 2) * -1) calc(($countdown_unit_gap_column / 2) * -1);
  }
}

.$_el .x-countdown-unit-content {
  @if $countdown_unit_width !== 'auto' {
    width: $countdown_unit_width;
  }
  margin: calc($countdown_unit_gap_row / 2) calc($countdown_unit_gap_column / 2);
  @unless $countdown_unit_border_width?? || $countdown_unit_border_style?? {
    border-width: $countdown_unit_border_width;
    border-style: $countdown_unit_border_style;
    border-color: $countdown_unit_border_color;
  }
  @unless $countdown_unit_border_radius?? {
    border-radius: $countdown_unit_border_radius;
  }
  @unless $countdown_unit_padding?? {
    padding: $countdown_unit_padding;
  }
  @if $countdown_unit_bg_color !== 'transparent' {
    background-color: $countdown_unit_bg_color;
  }
  @unless $countdown_unit_box_shadow_dimensions?? {
    @if $countdown_unit_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $countdown_unit_box_shadow_color !== 'transparent' {
      box-shadow: $countdown_unit_box_shadow_dimensions $countdown_unit_box_shadow_color;
    }
  }
}



<?php

// Number
// =============================================================================

?>

.$_el .x-countdown-number {
  @unless $countdown_number_margin?? {
    margin: $countdown_number_margin;
  }
  @unless $countdown_number_border_width?? || $countdown_number_border_style?? {
    border-width: $countdown_number_border_width;
    border-style: $countdown_number_border_style;
    border-color: $countdown_number_border_color;
  }
  @unless $countdown_number_border_radius?? {
    border-radius: $countdown_number_border_radius;
  }
  @unless $countdown_number_padding?? {
    padding: $countdown_number_padding;
  }
  @if $countdown_number_bg_color !== 'transparent' {
    background-color: $countdown_number_bg_color;
  }
  @unless $countdown_number_box_shadow_dimensions?? {
    @if $countdown_number_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $countdown_number_box_shadow_color !== 'transparent' {
      box-shadow: $countdown_number_box_shadow_dimensions $countdown_number_box_shadow_color;
    }
  }
}



<?php

// Digit
// =============================================================================

?>

.$_el .x-countdown-digit {
  @unless $countdown_digit_margin?? {
    margin: $countdown_digit_margin;
  }
  @unless $countdown_digit_border_width?? || $countdown_digit_border_style?? {
    border-width: $countdown_digit_border_width;
    border-style: $countdown_digit_border_style;
    border-color: $countdown_digit_border_color;
  }
  @unless $countdown_digit_border_radius?? {
    border-radius: $countdown_digit_border_radius;
  }
  @unless $countdown_digit_padding?? {
    padding: $countdown_digit_padding;
  }
  font-family: $countdown_digit_font_family;
  font-size: $countdown_digit_font_size;
  font-style: $countdown_digit_font_style;
  font-weight: $countdown_digit_font_weight;
  line-height: $countdown_digit_line_height;
  @unless $countdown_digit_text_align?? {
    text-align: $countdown_digit_text_align;
  }
  @unless $countdown_digit_text_decoration?? {
    text-decoration: $countdown_digit_text_decoration;
  }
  @unless $countdown_digit_text_shadow_dimensions?? {
    @if $countdown_digit_text_shadow_color === 'transparent' {
      text-shadow: none;
    }
    @if $countdown_digit_text_shadow_color !== 'transparent' {
      text-shadow: $countdown_digit_text_shadow_dimensions $countdown_digit_text_shadow_color;
    }
  }
  @unless $countdown_digit_text_transform?? {
    text-transform: $countdown_digit_text_transform;
  }
  color: $countdown_digit_text_color;
  @if $countdown_digit_bg_color !== 'transparent' {
    background-color: $countdown_digit_bg_color;
  }
  @unless $countdown_digit_box_shadow_dimensions?? {
    @if $countdown_digit_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $countdown_digit_box_shadow_color !== 'transparent' {
      box-shadow: $countdown_digit_box_shadow_dimensions $countdown_digit_box_shadow_color;
    }
  }
}



<?php

// Label
// =============================================================================

?>

.$_el .x-countdown-label {
  @unless $countdown_label_spacing?? {
    @if $countdown_labels_output === 'compact' {
      margin-left: $countdown_label_spacing;
    }
    @if $countdown_labels_output === 'top' {
      margin-bottom: $countdown_label_spacing;
    }
    @if $countdown_labels_output === 'bottom' {
      margin-top: $countdown_label_spacing;
    }
  }
  font-family: $countdown_label_font_family;
  font-size: $countdown_label_font_size;
  font-style: $countdown_label_font_style;
  font-weight: $countdown_label_font_weight;
  @unless $countdown_label_letter_spacing?? {
    letter-spacing: $countdown_label_letter_spacing;
    margin-right: calc($countdown_label_letter_spacing * -1);
  }
  line-height: $countdown_label_line_height;
  @unless $countdown_label_text_align?? {
    text-align: $countdown_label_text_align;
  }
  @unless $countdown_label_text_decoration?? {
    text-decoration: $countdown_label_text_decoration;
  }
  @unless $countdown_label_text_shadow_dimensions?? {
    @if $countdown_label_text_shadow_color === 'transparent' {
      text-shadow: none;
    }
    @if $countdown_label_text_shadow_color !== 'transparent' {
      text-shadow: $countdown_label_text_shadow_dimensions $countdown_label_text_shadow_color;
    }
  }
  @unless $countdown_label_text_transform?? {
    text-transform: $countdown_label_text_transform;
  }
  color: $countdown_label_text_color;
}



<?php

// Complete
// =============================================================================

?>

.$_el .x-countdown-complete {
  font-family: $countdown_complete_font_family;
  font-size: $countdown_complete_font_size;
  font-style: $countdown_complete_font_style;
  font-weight: $countdown_complete_font_weight;
  @unless $countdown_complete_letter_spacing?? {
    letter-spacing: $countdown_complete_letter_spacing;
    margin-right: calc($countdown_complete_letter_spacing * -1);
  }
  line-height: $countdown_complete_line_height;
  @unless $countdown_complete_text_align?? {
    text-align: $countdown_complete_text_align;
  }
  @unless $countdown_complete_text_decoration?? {
    text-decoration: $countdown_complete_text_decoration;
  }
  @unless $countdown_complete_text_shadow_dimensions?? {
    @if $countdown_complete_text_shadow_color === 'transparent' {
      text-shadow: none;
    }
    @if $countdown_complete_text_shadow_color !== 'transparent' {
      text-shadow: $countdown_complete_text_shadow_dimensions $countdown_complete_text_shadow_color;
    }
  }
  @unless $countdown_complete_text_transform?? {
    text-transform: $countdown_complete_text_transform;
  }
  color: $countdown_complete_text_color;
}



<?php

// Delimiter
// =============================================================================

?>

@if $countdown_delimiter === true {
  .$_el .x-countdown-unit:not(:last-child):after {
    content: "$countdown_delimiter_content";
    margin-top: $countdown_delimiter_vertical_adjustment;
    font-family: $countdown_delimiter_font_family;
    font-size: $countdown_delimiter_font_size;
    font-weight: $countdown_delimiter_font_weight;
    @unless $countdown_delimiter_text_shadow_dimensions?? {
      @if $countdown_delimiter_text_shadow_color === 'transparent' {
        text-shadow: none;
      }
      @if $countdown_delimiter_text_shadow_color !== 'transparent' {
        text-shadow: $countdown_delimiter_text_shadow_dimensions $countdown_delimiter_text_shadow_color;
      }
    }
    color: $countdown_delimiter_text_color;
  }
}
