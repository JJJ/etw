<?php

// =============================================================================
// QUOTE-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
//   02. Quote
//   03. Cite
//   04. Quote Marks
// =============================================================================

// Base
// =============================================================================

?>

.$_el.x-quote {
  @if $quote_width !== 'auto' {
    width: $quote_width;
  }
  @unless $quote_max_width?? {
    max-width: $quote_max_width;
  }
  margin: $quote_margin;
  border-width: $quote_border_width;
  border-style: $quote_border_style;
  border-color: $quote_border_color;
  @unless $quote_border_radius?? {
    border-radius: $quote_border_radius;
  }
  padding: $quote_padding;
  font-size: $quote_base_font_size;
  background-color: $quote_bg_color;
  @unless $quote_box_shadow_dimensions?? {
    @if $quote_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $quote_box_shadow_color !== 'transparent' {
      box-shadow: $quote_box_shadow_dimensions $quote_box_shadow_color;
    }
  }
  font-size: $quote_base_font_size;
  background-color: $quote_bg_color;
}



<?php

// Text
// =============================================================================

?>

.$_el .x-quote-text {
  font-family: $quote_text_font_family;
  font-size: $quote_text_font_size;
  font-style: $quote_text_font_style;
  font-weight: $quote_text_font_weight;
  line-height: $quote_text_line_height;
  @unless $quote_text_letter_spacing?? {
    letter-spacing: $quote_text_letter_spacing;
  }
  @unless $quote_text_text_align?? {
    text-align: $quote_text_text_align;
  }
  @unless $quote_text_text_decoration?? {
    text-decoration: $quote_text_text_decoration;
  }
  @unless $quote_text_text_transform?? {
    text-transform: $quote_text_text_transform;
  }
  @unless $quote_text_text_shadow_dimensions?? {
    @if $quote_text_text_shadow_color === 'transparent' {
      text-shadow: none;
    }
    @if $quote_text_text_shadow_color !== 'transparent' {
      text-shadow: $quote_text_text_shadow_dimensions $quote_text_text_shadow_color;
    }
  }
  color: $quote_text_text_color;
}



<?php

// Cite
// =============================================================================

?>

@if $quote_cite_content !== '' {

  .$_el .x-quote-cite {
    -webkit-flex-direction: $quote_cite_flex_direction;
            flex-direction: $quote_cite_flex_direction;
    -webkit-justify-content: $quote_cite_flex_justify;
            justify-content: $quote_cite_flex_justify;
    -webkit-align-items: $quote_cite_flex_align;
            align-items: $quote_cite_flex_align;
    @if $quote_cite_flex_wrap === true {
      -webkit-flex-wrap: wrap;
              flex-wrap: wrap;
      -webkit-align-content: $quote_cite_flex_align;
              align-content: $quote_cite_flex_align;
    }
    margin: $quote_cite_margin;
    border-width: $quote_cite_border_width;
    border-style: $quote_cite_border_style;
    border-color: $quote_cite_border_color;
    @unless $quote_cite_border_radius?? {
      border-radius: $quote_cite_border_radius;
    }
    padding: $quote_cite_padding;
    font-family: $quote_cite_font_family;
    font-size: $quote_cite_font_size;
    font-style: $quote_cite_font_style;
    font-weight: $quote_cite_font_weight;
    line-height: $quote_cite_line_height;
    @unless $quote_cite_letter_spacing?? {
      letter-spacing: $quote_cite_letter_spacing;
    }
    @unless $quote_cite_text_align?? {
      text-align: $quote_cite_text_align;
    }
    @unless $quote_cite_text_decoration?? {
      text-decoration: $quote_cite_text_decoration;
    }
    @unless $quote_cite_text_transform?? {
      text-transform: $quote_cite_text_transform;
    }
    @unless $quote_cite_text_shadow_dimensions?? {
      @if $quote_cite_text_shadow_color === 'transparent' {
        text-shadow: none;
      }
      @if $quote_cite_text_shadow_color !== 'transparent' {
        text-shadow: $quote_cite_text_shadow_dimensions $quote_cite_text_shadow_color;
      }
    }
    color: $quote_cite_text_color;
    background-color: $quote_cite_bg_color;
    @unless $quote_cite_box_shadow_dimensions?? {
      @if $quote_cite_box_shadow_color === 'transparent' {
        box-shadow: none;
      }
      @if $quote_cite_box_shadow_color !== 'transparent' {
        box-shadow: $quote_cite_box_shadow_dimensions $quote_cite_box_shadow_color;
      }
    }
  }

  .$_el .x-quote-cite-text {
    @unless $quote_cite_letter_spacing?? {
      margin-right: calc($quote_cite_letter_spacing * -1);
    }
  }

  @if $quote_cite_graphic === true {

    <?php

    $graphic_no_base  = true;
    $graphic_selector = ' .x-quote-cite-mark';
    $graphic_k_pre    = 'quote_cite';

    include( '_graphic-css.php' );

    ?>

  }

  @if $quote_cite_position === 'before' {
    .$_el .x-quote-content {
      -webkit-flex-direction: column-reverse;
              flex-direction: column-reverse;
    }
  }

}



<?php

// Quote Marks
// =============================================================================

?>

@if $quote_marks_opening_graphic === true || $quote_marks_closing_graphic === true {
  .$_el.x-quote {
    -webkit-flex-direction: $quote_marks_graphic_direction;
            flex-direction: $quote_marks_graphic_direction;
  }
}

@if $quote_marks_opening_graphic === true {

  .$_el .x-quote-mark-opening {
    -webkit-align-self: $quote_marks_graphic_opening_align;
            align-self: $quote_marks_graphic_opening_align;
  }

  <?php

  $graphic_no_base  = true;
  $graphic_selector = ' .x-quote-mark-opening';
  $graphic_k_pre    = 'quote_marks_opening';

  include( '_graphic-css.php' );

  ?>

}

@if $quote_marks_closing_graphic === true {

  .$_el .x-quote-mark-closing {
    -webkit-align-self: $quote_marks_graphic_closing_align;
            align-self: $quote_marks_graphic_closing_align;
  }

  <?php

  $graphic_no_base  = true;
  $graphic_selector = ' .x-quote-mark-closing';
  $graphic_k_pre    = 'quote_marks_closing';

  include( '_graphic-css.php' );

  ?>

}