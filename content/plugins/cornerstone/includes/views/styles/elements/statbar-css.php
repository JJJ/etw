<?php

// =============================================================================
// STATBAR-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
//   02. Bar
//   03. Label
// =============================================================================

// Base
// =============================================================================

?>

.$_el.x-statbar {
  @unless $statbar_direction === 'row' {
    -webkit-flex-direction: $statbar_direction;
            flex-direction: $statbar_direction;
  }
  @if $statbar_direction === 'row' || $statbar_direction === 'row-reverse' {
    @if $statbar_width_row !== 'auto' {
      width: $statbar_width_row;
    }
    @unless $statbar_max_width_row?? {
      max-width: $statbar_max_width_row;
    }
    @if $statbar_height_row !== 'auto' {
      height: $statbar_height_row;
    }
    @unless $statbar_max_height_row?? {
      max-height: $statbar_max_height_row;
    }
  }
  @if $statbar_direction === 'column' || $statbar_direction === 'column-reverse' {
    @if $statbar_width_column !== 'auto' {
      width: $statbar_width_column;
    }
    @unless $statbar_max_width_column?? {
      max-width: $statbar_max_width_column;
    }
    @if $statbar_height_column !== 'auto' {
      height: $statbar_height_column;
    }
    @unless $statbar_max_height_column?? {
      max-height: $statbar_max_height_column;
    }
  }
  @unless $statbar_margin?? {
    margin: $statbar_margin;
  }
  @unless $statbar_border_width?? || $statbar_border_style?? {
    border-width: $statbar_border_width;
    border-style: $statbar_border_style;
    border-color: $statbar_border_color;
  }
  @unless $statbar_border_radius?? {
    border-radius: $statbar_border_radius;
  }
  @unless $statbar_padding?? {
    padding: $statbar_padding;
  }
  @unless $statbar_box_shadow_dimensions?? {
    box-shadow: $statbar_box_shadow_dimensions $statbar_box_shadow_color;
  }
  font-size: $statbar_base_font_size;
  @unless $statbar_bg_color === 'transparent' {
    background-color: $statbar_bg_color;
  }
}



<?php

// Bar
// =============================================================================

?>

.$_el.x-statbar .x-statbar-bar {
  @if $statbar_label === true {
    -webkit-justify-content: $statbar_label_justify;
            justify-content: $statbar_label_justify;
  }
  @unless $statbar_bar_border_radius?? {
    border-radius: $statbar_bar_border_radius;
  }
  @unless $statbar_bar_box_shadow_dimensions?? {
    box-shadow: $statbar_bar_box_shadow_dimensions $statbar_bar_box_shadow_color;
  }
  @unless $statbar_bar_bg_color === 'transparent' {
    background-color: $statbar_bar_bg_color;
  }
}

@if $statbar_direction === 'row' || $statbar_direction === 'row-reverse' {
  .$_el.x-statbar .x-statbar-bar {
    width: 0;
  }

  .$_el.x-statbar .x-statbar-bar.x-active {
    width: $statbar_bar_length;
    height: 100%;
  }
}

@if $statbar_direction === 'column' || $statbar_direction === 'column-reverse' {
  .$_el.x-statbar .x-statbar-bar {
    height: 0;
  }

  .$_el.x-statbar .x-statbar-bar.x-active {
    width: 100%;
    height: $statbar_bar_length;
  }
}



<?php

// Label
// =============================================================================
// margin-right: calc($statbar_label_letter_spacing * -1);

?>

@if $statbar_label === true {

  .$_el.x-statbar .x-statbar-label {
    @if $statbar_label_width !== 'auto' {
      width: $statbar_label_width;
      min-width: $statbar_label_width;
    }
    @if $statbar_label_height !== 'auto' {
      height: $statbar_label_height;
      min-height: $statbar_label_height;
    }
    @unless $statbar_label_margin?? {
      margin: $statbar_label_margin;
    }  
    @unless $statbar_label_border_width?? || $statbar_label_border_style?? {
      border-width: $statbar_label_border_width;
      border-style: $statbar_label_border_style;
      border-color: $statbar_label_border_color;
    }
    @unless $statbar_label_border_radius?? {
      border-radius: $statbar_label_border_radius;
    }
    @unless $statbar_label_padding?? {
      padding: $statbar_label_padding;
    }
    font-family: $statbar_label_font_family;
    font-size: $statbar_label_font_size;
    font-style: $statbar_label_font_style;
    font-weight: $statbar_label_font_weight;
    line-height: $statbar_label_line_height;
    @unless $statbar_label_letter_spacing?? {
      letter-spacing: $statbar_label_letter_spacing;
    }
    @unless $statbar_label_text_align?? {
      text-align: $statbar_label_text_align;
    }
    @unless $statbar_label_text_decoration?? {
      text-decoration: $statbar_label_text_decoration;
    }
    @unless $statbar_label_text_shadow_dimensions?? {
      text-shadow: $statbar_label_text_shadow_dimensions $statbar_label_text_shadow_color;
    }
    @unless $statbar_label_text_transform?? {
      text-transform: $statbar_label_text_transform;
    }
    color: $statbar_label_text_color;
    @unless $statbar_label_bg_color === 'transparent' {
      background-color: $statbar_label_bg_color;
    }
    @unless $statbar_label_box_shadow_dimensions?? {
      box-shadow: $statbar_label_box_shadow_dimensions $statbar_label_box_shadow_color;
    }
    transform: translate3d($statbar_label_translate_x, $statbar_label_translate_y, 0);
  }

  .$_el.x-statbar .x-statbar-label span {
    @unless $statbar_label_letter_spacing?? {
      margin-right: calc($statbar_label_letter_spacing * -1);
    }
  }

}