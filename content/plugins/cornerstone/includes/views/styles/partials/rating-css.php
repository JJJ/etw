<?php

// =============================================================================
// _RATING-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Graphic
//   04. Text
// =============================================================================

// Setup
// =============================================================================

$selector   = ( isset( $selector ) && $selector != ''     ) ? $selector         : '.x-rating';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';



// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?> {
  flex-direction: $<?php echo $key_prefix; ?>rating_flex_direction;
  justify-content: $<?php echo $key_prefix; ?>rating_flex_justify;
  align-items: $<?php echo $key_prefix; ?>rating_flex_align;
  @if $<?php echo $key_prefix; ?>rating_flex_wrap === true {
    flex-wrap: wrap;
    align-content: $<?php echo $key_prefix; ?>rating_flex_align;
  }
  @if $<?php echo $key_prefix; ?>rating_width !== 'auto' {
    width: $<?php echo $key_prefix; ?>rating_width;
  }
  @unless $<?php echo $key_prefix; ?>rating_max_width?? {
    max-width: $<?php echo $key_prefix; ?>rating_max_width;
  }
  @unless $<?php echo $key_prefix; ?>rating_margin?? {
    margin: $<?php echo $key_prefix; ?>rating_margin;
  }
  @unless $<?php echo $key_prefix; ?>rating_border_width?? || $<?php echo $key_prefix; ?>rating_border_style?? {
    border-width: $<?php echo $key_prefix; ?>rating_border_width;
    border-style: $<?php echo $key_prefix; ?>rating_border_style;
    border-color: $<?php echo $key_prefix; ?>rating_border_color;
  }
  @unless $<?php echo $key_prefix; ?>rating_border_radius?? {
    border-radius: $<?php echo $key_prefix; ?>rating_border_radius;
  }
  @unless $<?php echo $key_prefix; ?>rating_padding?? {
    padding: $<?php echo $key_prefix; ?>rating_padding;
  }
  font-size: $<?php echo $key_prefix; ?>rating_base_font_size;
  @if $<?php echo $key_prefix; ?>rating_bg_color !== 'transparent' {
    background-color: $<?php echo $key_prefix; ?>rating_bg_color;
  }
  @unless $<?php echo $key_prefix; ?>rating_box_shadow_dimensions?? {
    @if $<?php echo $key_prefix; ?>rating_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $<?php echo $key_prefix; ?>rating_box_shadow_color !== 'transparent' {
      box-shadow: $<?php echo $key_prefix; ?>rating_box_shadow_dimensions $<?php echo $key_prefix; ?>rating_box_shadow_color;
    }
  }
}



<?php

// Graphic
// =============================================================================

?>

.$_el<?php echo $selector; ?> .x-rating-graphic > * + * {
  margin-left: $<?php echo $key_prefix; ?>rating_graphic_spacing;
}

@if $<?php echo $key_prefix; ?>rating_graphic_type === 'icon' {
  .$_el<?php echo $selector; ?> .x-icon {
    color: $<?php echo $key_prefix; ?>rating_graphic_icon_color;
  }
}

@if $<?php echo $key_prefix; ?>rating_graphic_type === 'image' {
  .$_el<?php echo $selector; ?> .x-image {
    max-width: $<?php echo $key_prefix; ?>rating_graphic_image_max_width;
  }
}



<?php

// Text
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>rating_text === true {
  .$_el<?php echo $selector; ?> .x-rating-text {
    @unless $<?php echo $key_prefix; ?>rating_text_margin?? {
      margin: $<?php echo $key_prefix; ?>rating_text_margin;
    }
    font-family: $<?php echo $key_prefix; ?>rating_font_family;
    font-size: $<?php echo $key_prefix; ?>rating_font_size;
    font-style: $<?php echo $key_prefix; ?>rating_font_style;
    font-weight: $<?php echo $key_prefix; ?>rating_font_weight;
    line-height: $<?php echo $key_prefix; ?>rating_line_height;
    @unless $<?php echo $key_prefix; ?>rating_letter_spacing?? {
      letter-spacing: $<?php echo $key_prefix; ?>rating_letter_spacing;
    }
    @unless $<?php echo $key_prefix; ?>rating_text_align?? {
      text-align: $<?php echo $key_prefix; ?>rating_text_align;
    }
    @unless $<?php echo $key_prefix; ?>rating_text_decoration?? {
      text-decoration: $<?php echo $key_prefix; ?>rating_text_decoration;
    }
    @unless $<?php echo $key_prefix; ?>rating_text_shadow_dimensions?? {
      @if $<?php echo $key_prefix; ?>rating_text_shadow_color === 'transparent' {
        text-shadow: none;
      }
      @if $<?php echo $key_prefix; ?>rating_text_shadow_color !== 'transparent' {
        text-shadow: $<?php echo $key_prefix; ?>rating_text_shadow_dimensions $<?php echo $key_prefix; ?>rating_text_shadow_color;
      }
    }
    @unless $<?php echo $key_prefix; ?>rating_text_transform?? {
      text-transform: $<?php echo $key_prefix; ?>rating_text_transform;
    }
    color: $<?php echo $key_prefix; ?>rating_text_color;
  }
}
