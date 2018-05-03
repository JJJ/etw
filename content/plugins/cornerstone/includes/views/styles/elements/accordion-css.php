<?php

// =============================================================================
// ACCORDION-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
//   02. Item
//   03. Header
//   04. Content
// =============================================================================

// Base
// =============================================================================

?>

.$_el.x-acc {
  @if $accordion_width !== 'auto' {
    width: $accordion_width;
  }
  @unless $accordion_max_width?? {
    max-width: $accordion_max_width;
  }
  @unless $accordion_margin?? {
    margin: $accordion_margin;
  }
  @unless $accordion_border_width?? || $accordion_border_style?? {
    border-width: $accordion_border_width;
    border-style: $accordion_border_style;
    border-color: $accordion_border_color;
  }
  @unless $accordion_border_radius?? {
    border-radius: $accordion_border_radius;
  }
  @unless $accordion_padding?? {
    padding: $accordion_padding;
  }
  font-size: $accordion_base_font_size;
  background-color: $accordion_bg_color;
  @unless $accordion_box_shadow_dimensions?? {
    @if $accordion_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $accordion_box_shadow_color !== 'transparent' {
      box-shadow: $accordion_box_shadow_dimensions $accordion_box_shadow_color;
    }
  }
}



<?php

// Item
// =============================================================================

?>

.$_el.x-acc .x-acc-item {
  @if $accordion_item_overflow === true {
    overflow: hidden;
  }
  @unless $accordion_item_border_width?? || $accordion_item_border_style?? {
    border-width: $accordion_item_border_width;
    border-style: $accordion_item_border_style;
    border-color: $accordion_item_border_color;
  }
  @unless $accordion_item_border_radius?? {
    border-radius: $accordion_item_border_radius;
  }
  @unless $accordion_item_padding?? {
    padding: $accordion_item_padding;
  }
  background-color: $accordion_item_bg_color;
  @unless $accordion_item_box_shadow_dimensions?? {
    @if $accordion_item_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $accordion_item_box_shadow_color !== 'transparent' {
      box-shadow: $accordion_item_box_shadow_dimensions $accordion_item_box_shadow_color;
    }
  }
}

.$_el.x-acc .x-acc-item + .x-acc-item {
  margin-top: $accordion_item_spacing;
}



<?php

// Header
// =============================================================================
// @unless $accordion_header_border_width?? || $accordion_header_border_style?? {
// @unless $accordion_header_border_radius?? {
// @unless $accordion_header_padding?? {

?>

.$_el.x-acc .x-acc-header {
  @unless $accordion_header_margin?? {
    margin: $accordion_header_margin;
  }
  border-width: $accordion_header_border_width;
  border-style: $accordion_header_border_style;
  border-color: $accordion_header_border_color;
  border-radius: $accordion_header_border_radius;
  padding: $accordion_header_padding;
  font-family: $accordion_header_font_family;
  font-size: $accordion_header_font_size;
  font-style: $accordion_header_font_style;
  font-weight: $accordion_header_font_weight;
  line-height: $accordion_header_line_height;
  @unless $accordion_header_letter_spacing?? {
    letter-spacing: $accordion_header_letter_spacing;
  }
  @unless $accordion_header_text_align?? {
    text-align: $accordion_header_text_align;
  }
  @unless $accordion_header_text_decoration?? {
    text-decoration: $accordion_header_text_decoration;
  }
  @unless $accordion_header_text_transform?? {
    text-transform: $accordion_header_text_transform;
  }
  @unless $accordion_header_text_shadow_dimensions?? {
    @if $accordion_header_text_shadow_color === 'transparent' {
      text-shadow: none;
    }
    @if $accordion_header_text_shadow_color !== 'transparent' {
      text-shadow: $accordion_header_text_shadow_dimensions $accordion_header_text_shadow_color;
    }
  }
  color: $accordion_header_text_color;
  background-color: $accordion_header_bg_color;
  @unless $accordion_header_box_shadow_dimensions?? {
    @if $accordion_header_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $accordion_header_box_shadow_color !== 'transparent' {
      box-shadow: $accordion_header_box_shadow_dimensions $accordion_header_box_shadow_color;
    }
  }
}

.$_el.x-acc .x-acc-header:hover,
.$_el.x-acc .x-acc-header[class*="active"] {
  @unless $accordion_header_border_width?? || $accordion_header_border_style?? {
    border-color: $accordion_header_border_color_alt;
  }
  @unless $accordion_header_text_shadow_dimensions?? {
    @if $accordion_header_text_shadow_color_alt === 'transparent' {
      text-shadow: none;
    }
    @if $accordion_header_text_shadow_color_alt !== 'transparent' {
      text-shadow: $accordion_header_text_shadow_dimensions $accordion_header_text_shadow_color_alt;
    }
  }
  color: $accordion_header_text_color_alt;
  background-color: $accordion_header_bg_color_alt;
  @unless $accordion_header_box_shadow_dimensions?? {
    @if $accordion_header_box_shadow_color_alt === 'transparent' {
      box-shadow: none;
    }
    @if $accordion_header_box_shadow_color_alt !== 'transparent' {
      box-shadow: $accordion_header_box_shadow_dimensions $accordion_header_box_shadow_color_alt;
    }
  }
}


<?php

// Header Content
// --------------

?>

.$_el.x-acc .x-acc-header-content {
  @if $accordion_header_content_reverse === true {
    -webkit-flex-direction: row-reverse;
            flex-direction: row-reverse;
  }
}


<?php

// Header Indicator
// ----------------

?>

.$_el.x-acc .x-acc-header-indicator {
  @if $accordion_header_indicator === true {
    width: $accordion_header_indicator_width;
    height: $accordion_header_indicator_height;
    font-size: $accordion_header_indicator_font_size;
    color: $accordion_header_indicator_color;
    transform: translate3d(0, 0, 0) rotate($accordion_header_indicator_rotation_start);
  }
}

.$_el.x-acc .x-acc-header:hover .x-acc-header-indicator,
.$_el.x-acc .x-acc-header[class*="active"] .x-acc-header-indicator {
  @if $accordion_header_indicator === true {
    color: $accordion_header_indicator_color_alt;
  }
}

.$_el.x-acc .x-acc-header.x-active .x-acc-header-indicator {
  @if $accordion_header_indicator === true {
    transform: translate3d(0, 0, 0) rotate($accordion_header_indicator_rotation_end);
  }
}


<?php

// Header Text
// -----------

?>

.$_el.x-acc .x-acc-header-text {
  @if $accordion_header_indicator === true {
    @unless $accordion_header_content_spacing?? {
      @if $accordion_header_content_reverse === false {
        margin-left: $accordion_header_content_spacing;
      }
      @if $accordion_header_content_reverse === true {
        margin-right: $accordion_header_content_spacing;
      }
    }
  }
  @if $accordion_header_text_overflow === true {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
}



<?php

// Content Inner
// =============================================================================

?>

.$_el.x-acc .x-acc-content {
  @unless $accordion_content_margin?? {
    margin: $accordion_content_margin;
  }
  @unless $accordion_content_border_width?? || $accordion_content_border_style?? {
    border-width: $accordion_content_border_width;
    border-style: $accordion_content_border_style;
    border-color: $accordion_content_border_color;
  }
  @unless $accordion_content_border_radius?? {
    border-radius: $accordion_content_border_radius;
  }
  @unless $accordion_content_padding?? {
    padding: $accordion_content_padding;
  }
  font-family: $accordion_content_font_family;
  font-size: $accordion_content_font_size;
  font-style: $accordion_content_font_style;
  font-weight: $accordion_content_font_weight;
  line-height: $accordion_content_line_height;
  @unless $accordion_content_letter_spacing?? {
    letter-spacing: $accordion_content_letter_spacing;
  }
  @unless $accordion_content_text_align?? {
    text-align: $accordion_content_text_align;
  }
  @unless $accordion_content_text_decoration?? {
    text-decoration: $accordion_content_text_decoration;
  }
  @unless $accordion_content_text_transform?? {
    text-transform: $accordion_content_text_transform;
  }
  @unless $accordion_content_text_shadow_dimensions?? {
    @if $accordion_content_text_shadow_color === 'transparent' {
      text-shadow: none;
    }
    @if $accordion_content_text_shadow_color !== 'transparent' {
      text-shadow: $accordion_content_text_shadow_dimensions $accordion_content_text_shadow_color;
    }
  }
  color: $accordion_content_text_color;
  background-color: $accordion_content_bg_color;
  @unless $accordion_content_box_shadow_dimensions?? {
    @if $accordion_content_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $accordion_content_box_shadow_color !== 'transparent' {
      box-shadow: $accordion_content_box_shadow_dimensions $accordion_content_box_shadow_color;
    }
  }
  font-size: $accordion_content_font_size;
  background-color: $accordion_content_bg_color;
}