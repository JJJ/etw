<?php

// =============================================================================
// TABS-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
//   02. Tablist
// =============================================================================

// Base
// =============================================================================

?>

.$_el.x-tabs {
  @if $tabs_width !== 'auto' {
    width: $tabs_width;
  }
  @unless $tabs_max_width?? {
    max-width: $tabs_max_width;
  }
  @unless $tabs_margin?? {
    margin: $tabs_margin;
  }
  @unless $tabs_border_width?? || $tabs_border_style?? {
    border-width: $tabs_border_width;
    border-style: $tabs_border_style;
    border-color: $tabs_border_color;
  }
  @unless $tabs_border_radius?? {
    border-radius: $tabs_border_radius;
  }
  @unless $tabs_padding?? {
    padding: $tabs_padding;
  }
  font-size: $tabs_base_font_size;
  background-color: $tabs_bg_color;
  @unless $tabs_box_shadow_dimensions?? {
    @if $tabs_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $tabs_box_shadow_color !== 'transparent' {
      box-shadow: $tabs_box_shadow_dimensions $tabs_box_shadow_color;
    }
  }
}



<?php

// Tablist
// =============================================================================

?>

.$_el .x-tablist {
  @unless $tabs_tablist_margin?? {
    margin: $tabs_tablist_margin;
  }
}

.$_el .x-tablist ul {
  -webkit-justify-content: $tabs_tabs_justify_content;
          justify-content: $tabs_tabs_justify_content;
  @unless $tabs_tablist_border_width?? || $tabs_tablist_border_style?? {
    border-width: $tabs_tablist_border_width;
    border-style: $tabs_tablist_border_style;
    border-color: $tabs_tablist_border_color;
  }
  @unless $tabs_tablist_border_radius?? {
    border-radius: $tabs_tablist_border_radius;
  }
  @unless $tabs_tablist_padding?? {
    padding: $tabs_tablist_padding;
  }
  background-color: $tabs_tablist_bg_color;
  @unless $tabs_tablist_box_shadow_dimensions?? {
    @if $tabs_tablist_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $tabs_tablist_box_shadow_color !== 'transparent' {
      box-shadow: $tabs_tablist_box_shadow_dimensions $tabs_tablist_box_shadow_color;
    }
  }
}

.$_el .x-tablist li {
  @unless $tabs_tabs_min_width?? {
    min-width: $tabs_tabs_min_width;
  }
  @unless $tabs_tabs_max_width?? {
    max-width: $tabs_tabs_max_width;
  }
  @if $tabs_tabs_fill_space === true {
    -webkit-flex: 1 0 0%;
            flex: 1 0 0%;
  }
}



<?php

// Tabs
// =============================================================================

?>

.$_el .x-tablist button {
  @unless $tabs_tabs_margin?? {
    margin: $tabs_tabs_margin;
  }
  border-width: $tabs_tabs_border_width;
  border-style: $tabs_tabs_border_style;
  border-color: $tabs_tabs_border_color;
  border-radius: $tabs_tabs_border_radius;
  padding: $tabs_tabs_padding;
  font-family: $tabs_tabs_font_family;
  font-size: $tabs_tabs_font_size;
  font-style: $tabs_tabs_font_style;
  font-weight: $tabs_tabs_font_weight;
  line-height: $tabs_tabs_line_height;
  @unless $tabs_tabs_letter_spacing?? {
    letter-spacing: $tabs_tabs_letter_spacing;
  }
  @unless $tabs_tabs_text_align?? {
    text-align: $tabs_tabs_text_align;
  }
  @unless $tabs_tabs_text_decoration?? {
    text-decoration: $tabs_tabs_text_decoration;
  }
  @unless $tabs_tabs_text_shadow_dimensions?? {
    @if $tabs_tabs_text_shadow_color === 'transparent' {
      text-shadow: none;
    }
    @if $tabs_tabs_text_shadow_color !== 'transparent' {
      text-shadow: $tabs_tabs_text_shadow_dimensions $tabs_tabs_text_shadow_color;
    }
  }
  @unless $tabs_tabs_text_transform?? {
    text-transform: $tabs_tabs_text_transform;
  }
  color: $tabs_tabs_text_color;
  background-color: $tabs_tabs_bg_color;
  @unless $tabs_tabs_box_shadow_dimensions?? {
    @if $tabs_tabs_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $tabs_tabs_box_shadow_color !== 'transparent' {
      box-shadow: $tabs_tabs_box_shadow_dimensions $tabs_tabs_box_shadow_color;
    }
  }
}

.$_el .x-tablist button:hover,
.$_el .x-tablist button[class*="active"] {
  color: $tabs_tabs_text_color_alt;
  @unless $tabs_tabs_border_width?? || $tabs_tabs_border_style?? {
    border-color: $tabs_tabs_border_color_alt;
  }
  background-color: $tabs_tabs_bg_color_alt;
  @unless $tabs_tabs_text_shadow_dimensions?? {
    @if $tabs_tabs_text_shadow_color_alt === 'transparent' {
      text-shadow: none;
    }
    @if $tabs_tabs_text_shadow_color_alt !== 'transparent' {
      text-shadow: $tabs_tabs_text_shadow_dimensions $tabs_tabs_text_shadow_color_alt;
    }
  }
  @unless $tabs_tabs_box_shadow_dimensions?? {
    @if $tabs_tabs_box_shadow_color_alt === 'transparent' {
      box-shadow: none;
    }
    @if $tabs_tabs_box_shadow_color_alt !== 'transparent' {
      box-shadow: $tabs_tabs_box_shadow_dimensions $tabs_tabs_box_shadow_color_alt;
    }
  }
}



<?php

// Panels
// =============================================================================

?>

.$_el .x-tab-panel {
  @unless $tabs_panels_margin?? {
    margin: $tabs_panels_margin;
  }
  @unless $tabs_panels_border_width?? || $tabs_panels_border_style?? {
    border-width: $tabs_panels_border_width;
    border-style: $tabs_panels_border_style;
    border-color: $tabs_panels_border_color;
  }
  @unless $tabs_panels_border_radius?? {
    border-radius: $tabs_panels_border_radius;
  }
  @unless $tabs_panels_padding?? {
    padding: $tabs_panels_padding;
  }
  font-family: $tabs_panels_font_family;
  font-size: $tabs_panels_font_size;
  font-style: $tabs_panels_font_style;
  font-weight: $tabs_panels_font_weight;
  line-height: $tabs_panels_line_height;
  @unless $tabs_panels_letter_spacing?? {
    letter-spacing: $tabs_panels_letter_spacing;
  }
  @unless $tabs_panels_text_align?? {
    text-align: $tabs_panels_text_align;
  }
  @unless $tabs_panels_text_decoration?? {
    text-decoration: $tabs_panels_text_decoration;
  }
  @unless $tabs_panels_text_shadow_dimensions?? {
    @if $tabs_panels_text_shadow_color === 'transparent' {
      text-shadow: none;
    }
    @if $tabs_panels_text_shadow_color !== 'transparent' {
      text-shadow: $tabs_panels_text_shadow_dimensions $tabs_panels_text_shadow_color;
    }
  }
  @unless $tabs_panels_text_transform?? {
    text-transform: $tabs_panels_text_transform;
  }
  color: $tabs_panels_text_color;
  background-color: $tabs_panels_bg_color;
  @unless $tabs_panels_box_shadow_dimensions?? {
    @if $tabs_panels_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $tabs_panels_box_shadow_color !== 'transparent' {
      box-shadow: $tabs_panels_box_shadow_dimensions $tabs_panels_box_shadow_color;
    }
  }
}