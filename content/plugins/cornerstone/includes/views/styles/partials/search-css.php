<?php

// =============================================================================
// _SEARCH-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Input
//   04. Buttons
// =============================================================================

// Setup
// =============================================================================

$selector   = ( isset( $selector ) && $selector != '' ) ? $selector : '';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';

// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?>.x-search {
  width: $<?php echo $key_prefix; ?>search_width;
  max-width: $<?php echo $key_prefix; ?>search_max_width;
  height: $<?php echo $key_prefix; ?>search_height;
  @unless $<?php echo $key_prefix; ?>search_margin?? {
    margin: $<?php echo $key_prefix; ?>search_margin;
  }
  @unless $<?php echo $key_prefix; ?>search_border_width?? || $<?php echo $key_prefix; ?>search_border_style?? {
    border-width: $<?php echo $key_prefix; ?>search_border_width;
    border-style: $<?php echo $key_prefix; ?>search_border_style;
    border-color: $<?php echo $key_prefix; ?>search_border_color;
  }
  @unless $<?php echo $key_prefix; ?>search_border_radius?? {
    border-radius: $<?php echo $key_prefix; ?>search_border_radius;
  }
  font-size: $<?php echo $key_prefix; ?>search_base_font_size;
  @unless $<?php echo $key_prefix; ?>search_bg_color === 'transparent' {
    background-color: $<?php echo $key_prefix; ?>search_bg_color;
  }
  @unless $<?php echo $key_prefix; ?>search_box_shadow_dimensions?? {
    @if $<?php echo $key_prefix; ?>search_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $<?php echo $key_prefix; ?>search_box_shadow_color !== 'transparent' {
      box-shadow: $<?php echo $key_prefix; ?>search_box_shadow_dimensions $<?php echo $key_prefix; ?>search_box_shadow_color;
    }
  }
}

.$_el<?php echo $selector; ?>.x-search.x-search-focused {
  @unless $<?php echo $key_prefix; ?>search_border_width?? || $<?php echo $key_prefix; ?>search_border_style?? {
    border-color: $<?php echo $key_prefix; ?>search_border_color_alt;
  }
  @unless $<?php echo $key_prefix; ?>search_bg_color_alt === 'transparent' {
    background-color: $<?php echo $key_prefix; ?>search_bg_color_alt;
  }
  @unless $<?php echo $key_prefix; ?>search_box_shadow_dimensions?? {
    @if $<?php echo $key_prefix; ?>search_box_shadow_color_alt === 'transparent' {
      box-shadow: none;
    }
    @if $<?php echo $key_prefix; ?>search_box_shadow_color_alt !== 'transparent' {
      box-shadow: $<?php echo $key_prefix; ?>search_box_shadow_dimensions $<?php echo $key_prefix; ?>search_box_shadow_color_alt;
    }
  }
}



<?php

// Input
// =============================================================================

?>

.$_el<?php echo $selector; ?>.x-search .x-search-input {
  order: $<?php echo $key_prefix; ?>search_order_input;
  margin: $<?php echo $key_prefix; ?>search_input_margin;
  font-family: $<?php echo $key_prefix; ?>search_input_font_family;
  font-size: $<?php echo $key_prefix; ?>search_input_font_size;
  font-style: $<?php echo $key_prefix; ?>search_input_font_style;
  font-weight: $<?php echo $key_prefix; ?>search_input_font_weight;
  line-height: $<?php echo $key_prefix; ?>search_input_line_height;
  @unless $<?php echo $key_prefix; ?>search_input_letter_spacing?? {
    letter-spacing: $<?php echo $key_prefix; ?>search_input_letter_spacing;
  }
  @unless $<?php echo $key_prefix; ?>search_input_text_align?? {
    text-align: $<?php echo $key_prefix; ?>search_input_text_align;
  }
  @unless $<?php echo $key_prefix; ?>search_input_text_decoration?? {
    text-decoration: $<?php echo $key_prefix; ?>search_input_text_decoration;
  }
  @unless $<?php echo $key_prefix; ?>search_input_text_transform?? {
    text-transform: $<?php echo $key_prefix; ?>search_input_text_transform;
  }
  color: $<?php echo $key_prefix; ?>search_input_text_color;
}

.$_el<?php echo $selector; ?>.x-search.x-search-has-content .x-search-input {
  color: $<?php echo $key_prefix; ?>search_input_text_color_alt;
}



<?php

// Buttons
// =============================================================================

?>

.$_el<?php echo $selector; ?>.x-search .x-search-btn-submit {
  order: $<?php echo $key_prefix; ?>search_order_submit;
  width: $<?php echo $key_prefix; ?>search_submit_width;
  height: $<?php echo $key_prefix; ?>search_submit_height;
  @unless $<?php echo $key_prefix; ?>search_submit_margin?? {
    margin: $<?php echo $key_prefix; ?>search_submit_margin;
  }
  @unless $<?php echo $key_prefix; ?>search_submit_border_style?? || $<?php echo $key_prefix; ?>search_submit_border_width?? {
    border-style: $<?php echo $key_prefix; ?>search_submit_border_style;
    border-width: $<?php echo $key_prefix; ?>search_submit_border_width;
    border-color: $<?php echo $key_prefix; ?>search_submit_border_color;
  }
  @unless $<?php echo $key_prefix; ?>search_submit_border_radius?? {
    border-radius: $<?php echo $key_prefix; ?>search_submit_border_radius;
  }
  font-size: $<?php echo $key_prefix; ?>search_submit_font_size;
  color: $<?php echo $key_prefix; ?>search_submit_color;
  background-color: $<?php echo $key_prefix; ?>search_submit_bg_color;
  @unless $<?php echo $key_prefix; ?>search_submit_box_shadow_dimensions?? {
    @if $<?php echo $key_prefix; ?>search_submit_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $<?php echo $key_prefix; ?>search_submit_box_shadow_color !== 'transparent' {
      box-shadow: $<?php echo $key_prefix; ?>search_submit_box_shadow_dimensions $<?php echo $key_prefix; ?>search_submit_box_shadow_color;
    }
  }
}

.$_el<?php echo $selector; ?>.x-search .x-search-btn-submit:hover,
.$_el<?php echo $selector; ?>.x-search .x-search-btn-submit:focus {
  color: $<?php echo $key_prefix; ?>search_submit_color_alt;
  @unless $<?php echo $key_prefix; ?>search_submit_border_style?? || $<?php echo $key_prefix; ?>search_submit_border_width?? {
    border-color: $<?php echo $key_prefix; ?>search_submit_border_color_alt;
  }
  background-color: $<?php echo $key_prefix; ?>search_submit_bg_color_alt;
  @unless $<?php echo $key_prefix; ?>search_submit_box_shadow_dimensions?? {
    @if $<?php echo $key_prefix; ?>search_submit_box_shadow_color_alt === 'transparent' {
      box-shadow: none;
    }
    @if $<?php echo $key_prefix; ?>search_submit_box_shadow_color_alt !== 'transparent' {
      box-shadow: $<?php echo $key_prefix; ?>search_submit_box_shadow_dimensions $<?php echo $key_prefix; ?>search_submit_box_shadow_color_alt;
    }
  }
}

.$_el<?php echo $selector; ?>.x-search .x-search-btn-clear {
  order: $<?php echo $key_prefix; ?>search_order_clear;
  width: $<?php echo $key_prefix; ?>search_clear_width;
  height: $<?php echo $key_prefix; ?>search_clear_height;
  @unless $<?php echo $key_prefix; ?>search_clear_margin?? {
    margin: $<?php echo $key_prefix; ?>search_clear_margin;
  }
  @unless $<?php echo $key_prefix; ?>search_clear_border_style?? || $<?php echo $key_prefix; ?>search_clear_border_width?? {
    border-style: $<?php echo $key_prefix; ?>search_clear_border_style;
    border-width: $<?php echo $key_prefix; ?>search_clear_border_width;
    border-color: $<?php echo $key_prefix; ?>search_clear_border_color;
  }
  @unless $<?php echo $key_prefix; ?>search_clear_border_radius?? {
    border-radius: $<?php echo $key_prefix; ?>search_clear_border_radius;
  }
  font-size: $<?php echo $key_prefix; ?>search_clear_font_size;
  color: $<?php echo $key_prefix; ?>search_clear_color;
  background-color: $<?php echo $key_prefix; ?>search_clear_bg_color;
  @unless $<?php echo $key_prefix; ?>search_clear_box_shadow_dimensions?? {
    @if $<?php echo $key_prefix; ?>search_clear_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $<?php echo $key_prefix; ?>search_clear_box_shadow_color !== 'transparent' {
      box-shadow: $<?php echo $key_prefix; ?>search_clear_box_shadow_dimensions $<?php echo $key_prefix; ?>search_clear_box_shadow_color;
    }
  }
}

.$_el<?php echo $selector; ?>.x-search .x-search-btn-clear:hover,
.$_el<?php echo $selector; ?>.x-search .x-search-btn-clear:focus {
  color: $<?php echo $key_prefix; ?>search_clear_color_alt;
  @unless $<?php echo $key_prefix; ?>search_clear_border_style?? || $<?php echo $key_prefix; ?>search_clear_border_width?? {
    border-color: $<?php echo $key_prefix; ?>search_clear_border_color_alt;
  }
  background-color: $<?php echo $key_prefix; ?>search_clear_bg_color_alt;
  @unless $<?php echo $key_prefix; ?>search_clear_box_shadow_dimensions?? {
    @if $<?php echo $key_prefix; ?>search_clear_box_shadow_color_alt === 'transparent' {
      box-shadow: none;
    }
    @if $<?php echo $key_prefix; ?>search_clear_box_shadow_color_alt !== 'transparent' {
      box-shadow: $<?php echo $key_prefix; ?>search_clear_box_shadow_dimensions $<?php echo $key_prefix; ?>search_clear_box_shadow_color_alt;
    }
  }
}
