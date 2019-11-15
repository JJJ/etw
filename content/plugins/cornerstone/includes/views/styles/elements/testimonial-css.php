<?php

// =============================================================================
// TESTIMONIAL-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
//   02. Content
//   03. Text
//   04. Cite
//   05. Graphic
//   06. Rating
// =============================================================================

// Base
// =============================================================================

?>

.$_el.x-testimonial {
  flex-direction: $testimonial_graphic_flex_direction;
  align-items: $testimonial_graphic_flex_align;
  @if $testimonial_width !== 'auto' {
    width: $testimonial_width;
  }
  @unless $testimonial_max_width?? {
    max-width: $testimonial_max_width;
  }
  margin: $testimonial_margin;
  border-width: $testimonial_border_width;
  border-style: $testimonial_border_style;
  border-color: $testimonial_border_color;
  @unless $testimonial_border_radius?? {
    border-radius: $testimonial_border_radius;
  }
  padding: $testimonial_padding;
  font-size: $testimonial_base_font_size;
  background-color: $testimonial_bg_color;
  @unless $testimonial_box_shadow_dimensions?? {
    @if $testimonial_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $testimonial_box_shadow_color !== 'transparent' {
      box-shadow: $testimonial_box_shadow_dimensions $testimonial_box_shadow_color;
    }
  }
  font-size: $testimonial_base_font_size;
  background-color: $testimonial_bg_color;
}



<?php

// Content
// =============================================================================

?>

.$_el .x-testimonial-content {
  margin: $testimonial_content_margin;
  border-width: $testimonial_content_border_width;
  border-style: $testimonial_content_border_style;
  border-color: $testimonial_content_border_color;
  @unless $testimonial_content_border_radius?? {
    border-radius: $testimonial_content_border_radius;
  }
  padding: $testimonial_content_padding;
  background-color: $testimonial_content_bg_color;
  @unless $testimonial_content_box_shadow_dimensions?? {
    @if $testimonial_content_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $testimonial_content_box_shadow_color !== 'transparent' {
      box-shadow: $testimonial_content_box_shadow_dimensions $testimonial_content_box_shadow_color;
    }
  }
}



<?php

// Text
// =============================================================================

?>

.$_el .x-testimonial-text {
  font-family: $testimonial_text_font_family;
  font-size: $testimonial_text_font_size;
  font-style: $testimonial_text_font_style;
  font-weight: $testimonial_text_font_weight;
  line-height: $testimonial_text_line_height;
  @unless $testimonial_text_letter_spacing?? {
    letter-spacing: $testimonial_text_letter_spacing;
  }
  @unless $testimonial_text_text_align?? {
    text-align: $testimonial_text_text_align;
  }
  @unless $testimonial_text_text_decoration?? {
    text-decoration: $testimonial_text_text_decoration;
  }
  @unless $testimonial_text_text_transform?? {
    text-transform: $testimonial_text_text_transform;
  }
  @unless $testimonial_text_text_shadow_dimensions?? {
    @if $testimonial_text_text_shadow_color === 'transparent' {
      text-shadow: none;
    }
    @if $testimonial_text_text_shadow_color !== 'transparent' {
      text-shadow: $testimonial_text_text_shadow_dimensions $testimonial_text_text_shadow_color;
    }
  }
  color: $testimonial_text_text_color;
}



<?php

// Cite
// =============================================================================

?>

@if $testimonial_cite_content !== '' || $testimonial_graphic === true || $testimonial_rating === true {

  .$_el .x-testimonial-cite {
    flex-direction: $testimonial_graphic_flex_direction;
    align-items: $testimonial_graphic_flex_align;
    align-self: $testimonial_cite_align_self;
    @if $testimonial_cite_position === 'before' {
      margin-bottom: $testimonial_cite_spacing;
    }
    @if $testimonial_cite_position === 'after' {
      margin-top: $testimonial_cite_spacing;
    }
    border-width: $testimonial_cite_border_width;
    border-style: $testimonial_cite_border_style;
    border-color: $testimonial_cite_border_color;
    @unless $testimonial_cite_border_radius?? {
      border-radius: $testimonial_cite_border_radius;
    }
    padding: $testimonial_cite_padding;
    font-family: $testimonial_cite_font_family;
    font-size: $testimonial_cite_font_size;
    font-style: $testimonial_cite_font_style;
    font-weight: $testimonial_cite_font_weight;
    line-height: $testimonial_cite_line_height;
    @unless $testimonial_cite_letter_spacing?? {
      letter-spacing: $testimonial_cite_letter_spacing;
    }
    @unless $testimonial_cite_text_align?? {
      text-align: $testimonial_cite_text_align;
    }
    @unless $testimonial_cite_text_decoration?? {
      text-decoration: $testimonial_cite_text_decoration;
    }
    @unless $testimonial_cite_text_transform?? {
      text-transform: $testimonial_cite_text_transform;
    }
    @unless $testimonial_cite_text_shadow_dimensions?? {
      @if $testimonial_cite_text_shadow_color === 'transparent' {
        text-shadow: none;
      }
      @if $testimonial_cite_text_shadow_color !== 'transparent' {
        text-shadow: $testimonial_cite_text_shadow_dimensions $testimonial_cite_text_shadow_color;
      }
    }
    color: $testimonial_cite_text_color;
    background-color: $testimonial_cite_bg_color;
    @unless $testimonial_cite_box_shadow_dimensions?? {
      @if $testimonial_cite_box_shadow_color === 'transparent' {
        box-shadow: none;
      }
      @if $testimonial_cite_box_shadow_color !== 'transparent' {
        box-shadow: $testimonial_cite_box_shadow_dimensions $testimonial_cite_box_shadow_color;
      }
    }
  }

  .$_el .x-testimonial-cite-text {
    @unless $testimonial_cite_letter_spacing?? {
      margin-right: calc($testimonial_cite_letter_spacing * -1);
    }
  }

  @if $testimonial_cite_position === 'before' {
    .$_el .x-testimonial-content {
      flex-direction: column-reverse;
    }
  }

}



<?php

// Graphic
// =============================================================================

?>

@if $testimonial_graphic === true {

  <?php

  echo cs_get_partial_style( 'graphic', array(
    'no_base'    => true,
    'selector'   => ' .x-graphic',
    'key_prefix' => 'testimonial',
  ) );

  ?>

}



<?php

// Rating
// =============================================================================

?>

@if $testimonial_rating === true {

  <?php

  echo cs_get_partial_style( 'rating', array(
    'selector'   => ' .x-rating',
    'key_prefix' => 'testimonial',
    'as_partial' => true,
  ) );

  ?>

}
