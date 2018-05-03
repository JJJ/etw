<?php

// =============================================================================
// BREADCRUMBS-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
//   02. List
//   03. List Items
//   04. Links
//   05. Delimiter
// =============================================================================

// Base
// =============================================================================

?>

.$_el.x-crumbs {
  @if $breadcrumbs_width !== 'auto' {
    width: $breadcrumbs_width;
  }
  @unless $breadcrumbs_max_width?? {
    max-width: $breadcrumbs_max_width;
  }
  @unless $breadcrumbs_margin?? {
    margin: $breadcrumbs_margin;
  }
  @unless $breadcrumbs_border_width?? || $breadcrumbs_border_style?? {
    border-width: $breadcrumbs_border_width;
    border-style: $breadcrumbs_border_style;
    border-color: $breadcrumbs_border_color;
  }
  @unless $breadcrumbs_border_radius?? {
    border-radius: $breadcrumbs_border_radius;
  }
  @unless $breadcrumbs_padding?? {
    padding: $breadcrumbs_padding;
  }
  font-family: $breadcrumbs_font_family;
  font-size: $breadcrumbs_font_size;
  font-style: $breadcrumbs_font_style;
  font-weight: $breadcrumbs_font_weight;
  line-height: $breadcrumbs_line_height;
  @unless $breadcrumbs_text_bg_color === 'transparent' {
    background-color: $breadcrumbs_bg_color;
  }
  @unless $breadcrumbs_box_shadow_dimensions?? {
    box-shadow: $breadcrumbs_box_shadow_dimensions $breadcrumbs_box_shadow_color;
  }
}



<?php

// List
// =============================================================================

?>

.$_el .x-crumbs-list {
  @if $breadcrumbs_reverse === true {
    -webkit-flex-direction: row-reverse;
            flex-direction: row-reverse;
  }
  -webkit-justify-content: $breadcrumbs_flex_justify;
          justify-content: $breadcrumbs_flex_justify;
  @if $breadcrumbs_delimiter === true {
    @if $breadcrumbs_reverse === true {
      margin-right: -$breadcrumbs_delimiter_spacing !important;
    }
    @if $breadcrumbs_reverse === false {
      margin-left: -$breadcrumbs_delimiter_spacing !important;
    }
  }
}



<?php

// List Items
// =============================================================================

?>

.$_el .x-crumbs-list-item {
  @if $breadcrumbs_delimiter === true {
    @if $breadcrumbs_reverse === true {
      margin-right: $breadcrumbs_delimiter_spacing;
    }
    @if $breadcrumbs_reverse === false {
      margin-left: $breadcrumbs_delimiter_spacing;
    }
  }
}



<?php

// Links
// =============================================================================
// Removed from bottom of styles. Creating overflow issue since `text-overflow`
// is being used. Will need to look into a way to solve this.
//
// .$_el .x-crumbs-link span {
//   @unless $breadcrumbs_links_letter_spacing?? {
//     margin-right: calc($breadcrumbs_links_letter_spacing * -1);
//   }
// }

?>

.$_el .x-crumbs-link {
  @unless $breadcrumbs_links_max_width?? {
    max-width: $breadcrumbs_links_max_width;
  }
  @unless $breadcrumbs_links_min_width?? {
    min-width: $breadcrumbs_links_min_width;
  }
  @unless $breadcrumbs_links_margin?? {
    margin: $breadcrumbs_links_margin;
  }
  @unless $breadcrumbs_links_border_width?? || $breadcrumbs_links_border_style?? {
    border-width: $breadcrumbs_links_border_width;
    border-style: $breadcrumbs_links_border_style;
    border-color: $breadcrumbs_links_border_color;
  }
  @unless $breadcrumbs_links_border_radius?? {
    border-radius: $breadcrumbs_links_border_radius;
  }
  @unless $breadcrumbs_links_padding?? {
    padding: $breadcrumbs_links_padding;
  }
  @unless $breadcrumbs_letter_spacing?? {
    letter-spacing: $breadcrumbs_letter_spacing;
  }
  @unless $breadcrumbs_links_base_font_size === '1em' {
    font-size: $breadcrumbs_links_base_font_size;
  }
  font-style: $breadcrumbs_links_font_style;
  @unless $breadcrumbs_links_letter_spacing?? {
    letter-spacing: $breadcrumbs_links_letter_spacing;
  }
  line-height: $breadcrumbs_links_line_height;
  @unless $breadcrumbs_links_text_align?? {
    text-align: $breadcrumbs_links_text_align;
  }
  @unless $breadcrumbs_links_text_shadow_dimensions?? {
    @if $breadcrumbs_links_text_shadow_color === 'transparent' {
      text-shadow: none;
    }
    @if $breadcrumbs_links_text_shadow_color !== 'transparent' {
      text-shadow: $breadcrumbs_links_text_shadow_dimensions $breadcrumbs_links_text_shadow_color;
    }
  }
  @unless $breadcrumbs_links_text_transform?? {
    text-transform: $breadcrumbs_links_text_transform;
  }
  color: $breadcrumbs_links_color;
  background-color: $breadcrumbs_links_bg_color;
  @unless $breadcrumbs_links_box_shadow_dimensions?? {
    @if $breadcrumbs_links_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $breadcrumbs_links_box_shadow_color !== 'transparent' {
      box-shadow: $breadcrumbs_links_box_shadow_dimensions $breadcrumbs_links_box_shadow_color;
    }
  }
}

.$_el .x-crumbs-link:hover {
  color: $breadcrumbs_links_color_alt;
  @unless $breadcrumbs_links_border_width?? || $breadcrumbs_links_border_style?? {
    border-color: $breadcrumbs_links_border_color_alt;
  }
  background-color: $breadcrumbs_links_bg_color_alt;
  @unless $breadcrumbs_links_text_shadow_dimensions?? {
    @if $breadcrumbs_links_text_shadow_color_alt === 'transparent' {
      text-shadow: none;
    }
    @if $breadcrumbs_links_text_shadow_color_alt !== 'transparent' {
      text-shadow: $breadcrumbs_links_text_shadow_dimensions $breadcrumbs_links_text_shadow_color_alt;
    }
  }
  @unless $breadcrumbs_links_box_shadow_dimensions?? {
    @if $breadcrumbs_links_box_shadow_color_alt === 'transparent' {
      box-shadow: none;
    }
    @if $breadcrumbs_links_box_shadow_color_alt !== 'transparent' {
      box-shadow: $breadcrumbs_links_box_shadow_dimensions $breadcrumbs_links_box_shadow_color_alt;
    }
  }
}



<?php

// Delimiter
// =============================================================================

?>

@if $breadcrumbs_delimiter === true {
  .$_el .x-crumbs-delimiter {
    @if $breadcrumbs_reverse === true {
      margin-right: $breadcrumbs_delimiter_spacing;
    }
    @if $breadcrumbs_reverse === false {
      margin-left: $breadcrumbs_delimiter_spacing;
    }
    color: $breadcrumbs_delimiter_color;
    @unless $breadcrumbs_delimiter_text_shadow_dimensions?? {
      @if $breadcrumbs_delimiter_text_shadow_color === 'transparent' {
        text-shadow: none;
      }
      @if $breadcrumbs_delimiter_text_shadow_color !== 'transparent' {
        text-shadow: $breadcrumbs_delimiter_text_shadow_dimensions $breadcrumbs_delimiter_text_shadow_color;
      }
    }
  }
}