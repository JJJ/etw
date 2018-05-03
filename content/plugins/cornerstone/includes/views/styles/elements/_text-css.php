<?php

// =============================================================================
// _TEXT-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Standard
//   03. Headline
// =============================================================================

// Setup
// =============================================================================

$text_selector = ( isset( $text_selector ) && $text_selector != '' ) ? $text_selector : '.x-text';



// Standard
// =============================================================================

?>

@if $text_type === 'standard' {

  <?php

  // Base
  // ----

  ?>

  .$_el<?php echo $text_selector; ?> {
    @if $text_width !== 'auto' {
      width: $text_width;
    }
    @unless $text_max_width?? {
      max-width: $text_max_width;
    }
    margin: $text_margin;
    @unless $text_border_width?? || $text_border_style?? {
      border-width: $text_border_width;
      border-style: $text_border_style;
      border-color: $text_border_color;
    }
    @unless $text_border_radius?? {
      border-radius: $text_border_radius;
    }
    padding: $text_padding;
    font-family: $text_font_family;
    font-size: $text_font_size;
    font-style: $text_font_style;
    font-weight: $text_font_weight;
    line-height: $text_line_height;
    letter-spacing: $text_letter_spacing;
    @unless $text_text_align?? {
      text-align: $text_text_align;
    }
    @unless $text_text_decoration?? {
      text-decoration: $text_text_decoration;
    }
    @unless $text_text_shadow_dimensions?? {
      text-shadow: $text_text_shadow_dimensions $text_text_shadow_color;
    }
    text-transform: $text_text_transform;
    color: $text_text_color;
    @unless $text_text_bg_color === 'transparent' {
      background-color: $text_bg_color;
    }
    @unless $text_box_shadow_dimensions?? {
      box-shadow: $text_box_shadow_dimensions $text_box_shadow_color;
    }
    @if $text_columns === true {
      -webkit-columns: $text_columns_width $text_columns_count;
              columns: $text_columns_width $text_columns_count;
      -webkit-column-gap: $text_columns_gap;
              column-gap: $text_columns_gap;
      -webkit-column-rule: $text_columns_rule_width $text_columns_rule_style $text_columns_rule_color;
              column-rule: $text_columns_rule_width $text_columns_rule_style $text_columns_rule_color;
    }
  }

  .$_el<?php echo $text_selector; ?> > :first-child { margin-top: 0;    }
  .$_el<?php echo $text_selector; ?> > :last-child  { margin-bottom: 0; }


  <?php

  // Column Content Breaking
  // -----------------------
  // Prevents direct children of the text element from breaking in half when
  // using column layouts.

  ?>

  @if $text_columns === true && $text_columns_break_inside === 'avoid' {
    .$_el<?php echo $text_selector; ?> > * {
      -webkit-column-break-inside: avoid;
                page-break-inside: avoid;
                     break-inside: avoid;
    }
  }

}



<?php

// Headline
// =============================================================================

?>

@if $text_type === 'headline' {

  <?php

  // Base
  // ----

  ?>

  .$_el<?php echo $text_selector; ?> {
    @if $text_width !== 'auto' {
      width: $text_width;
    }
    @unless $text_max_width?? {
      max-width: $text_max_width;
    }
    margin: $text_margin;
    @unless $text_border_width?? || $text_border_style?? {
      border-width: $text_border_width;
      border-style: $text_border_style;
      border-color: $text_border_color;
    }
    @unless $text_border_radius?? {
      border-radius: $text_border_radius;
    }
    padding: $text_padding;
    font-size: $text_base_font_size;
    @unless $text_text_bg_color === 'transparent' {
      background-color: $text_bg_color;
    }
    @unless $text_box_shadow_dimensions?? {
      box-shadow: $text_box_shadow_dimensions $text_box_shadow_color;
    }
  }


  <?php

  // Content
  // -------
  // Contains the optional graphic as well as text content (which will always
  // have the main headline, along with an optional subheadline).

  ?>

  .$_el<?php echo $text_selector; ?> .x-text-content {
    @if $text_graphic === true {
      -webkit-flex-direction: $text_flex_direction;
              flex-direction: $text_flex_direction;
      -webkit-justify-content: $text_flex_justify;
              justify-content: $text_flex_justify;
      -webkit-align-items: $text_flex_align;
              align-items: $text_flex_align;
      @if $text_flex_wrap === true {
        -webkit-flex-wrap: wrap;
                flex-wrap: wrap;
        -webkit-align-content: $text_flex_align;
                align-content: $text_flex_align;
      }
    }
  }


  <?php

  // Text Content
  // ------------
  // The container for the headline's text content (the main text along with
  // the optional subheadline).

  ?>

  .$_el<?php echo $text_selector; ?> .x-text-content-text {
    @if $text_graphic === true && $text_overflow === true && $text_flex_direction === 'column' {
      width: 100%;
    }
    @unless $text_content_margin?? {
      margin: $text_content_margin;
    }
  }


  <?php

  // Headline Text
  // -------------
  // The primary headline text.

  ?>

  .$_el<?php echo $text_selector; ?> .x-text-content-text-primary {
    margin: 0 calc($text_letter_spacing * -1) 0 0;
    font-family: $text_font_family;
    font-size: $text_font_size;
    font-style: $text_font_style;
    font-weight: $text_font_weight;
    line-height: $text_line_height;
    letter-spacing: $text_letter_spacing;
    @unless $text_text_align?? {
      text-align: $text_text_align;
    }
    @unless $text_text_decoration?? {
      text-decoration: $text_text_decoration;
    }
    @unless $text_text_shadow_dimensions?? {
      text-shadow: $text_text_shadow_dimensions $text_text_shadow_color;
    }
    text-transform: $text_text_transform;
    color: $text_text_color;
    @if $text_overflow === true {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
  }


  <?php

  // Text Typing
  // -----------
  // The text typing effect.

  ?>

  @if $text_typing === true {
    @unless $text_typing_color === 'inherit' {
      .$_el<?php echo $text_selector; ?> .x-text-typing {
        color: $text_typing_color;
      }
    }
    @if $text_typing_cursor === true {
      @unless $text_typing_cursor_color === 'inherit' {
        .$_el<?php echo $text_selector; ?> .typed-cursor {
          color: $text_typing_cursor_color;
        }
      }
    }
  }


  <?php

  // Subheadline Text
  // ----------------
  // The subheadline headline text.

  ?>

  @if $text_subheadline === true {
    .$_el<?php echo $text_selector; ?> .x-text-content-text-subheadline {
      @if $text_subheadline_reverse === false {
        margin: $text_subheadline_spacing calc($text_subheadline_letter_spacing * -1) 0 0;
      }
      @if $text_subheadline_reverse === true {
        margin: 0 calc($text_subheadline_letter_spacing * -1) $text_subheadline_spacing 0;
      }
      font-family: $text_subheadline_font_family;
      font-size: $text_subheadline_font_size;
      font-style: $text_subheadline_font_style;
      font-weight: $text_subheadline_font_weight;
      line-height: $text_subheadline_line_height;
      letter-spacing: $text_subheadline_letter_spacing;
      @unless $text_subheadline_text_align?? {
        text-align: $text_subheadline_text_align;
      }
      @unless $text_subheadline_text_decoration?? {
        text-decoration: $text_subheadline_text_decoration;
      }
      @unless $text_subheadline_text_shadow_dimensions?? {
        text-shadow: $text_subheadline_text_shadow_dimensions $text_subheadline_text_shadow_color;
      }
      text-transform: $text_subheadline_text_transform;
      color: $text_subheadline_text_color;
      @if $text_overflow === true {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
      }
    }
  }


  <?php

  // Graphic
  // -------
  // The optional graphic output.

  ?>

  @if $text_graphic === true {

    <?php

    $graphic_no_base  = false;
    $graphic_selector = $text_selector;
    $graphic_k_pre    = 'text';

    include( '_graphic-css.php' );

    ?>

  }

}