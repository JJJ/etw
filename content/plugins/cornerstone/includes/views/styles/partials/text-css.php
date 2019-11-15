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

$selector = ( isset( $selector ) && $selector != '' ) ? $selector : '.x-text';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';



// Standard
// =============================================================================

?>

@if $text_type === 'standard' {

  <?php

  // Base
  // ----

  ?>

  .$_el<?php echo $selector; ?> {
    @if $<?php echo $key_prefix; ?>text_width !== 'auto' {
      width: $<?php echo $key_prefix; ?>text_width;
    }
    @unless $<?php echo $key_prefix; ?>text_max_width?? {
      max-width: $<?php echo $key_prefix; ?>text_max_width;
    }
    margin: $<?php echo $key_prefix; ?>text_margin;
    @unless $<?php echo $key_prefix; ?>text_border_width?? || $<?php echo $key_prefix; ?>text_border_style?? {
      border-width: $<?php echo $key_prefix; ?>text_border_width;
      border-style: $<?php echo $key_prefix; ?>text_border_style;
      border-color: $<?php echo $key_prefix; ?>text_border_color;
    }
    @unless $<?php echo $key_prefix; ?>text_border_radius?? {
      border-radius: $<?php echo $key_prefix; ?>text_border_radius;
    }
    padding: $<?php echo $key_prefix; ?>text_padding;
    font-family: $<?php echo $key_prefix; ?>text_font_family;
    font-size: $<?php echo $key_prefix; ?>text_font_size;
    font-style: $<?php echo $key_prefix; ?>text_font_style;
    font-weight: $<?php echo $key_prefix; ?>text_font_weight;
    line-height: $<?php echo $key_prefix; ?>text_line_height;
    letter-spacing: $<?php echo $key_prefix; ?>text_letter_spacing;
    @unless $<?php echo $key_prefix; ?>text_text_align?? {
      text-align: $<?php echo $key_prefix; ?>text_text_align;
    }
    @unless $<?php echo $key_prefix; ?>text_text_decoration?? {
      text-decoration: $<?php echo $key_prefix; ?>text_text_decoration;
    }
    @unless $<?php echo $key_prefix; ?>text_text_shadow_dimensions?? {
      text-shadow: $<?php echo $key_prefix; ?>text_text_shadow_dimensions $<?php echo $key_prefix; ?>text_text_shadow_color;
    }
    text-transform: $<?php echo $key_prefix; ?>text_text_transform;
    color: $<?php echo $key_prefix; ?>text_text_color;
    @unless $<?php echo $key_prefix; ?>text_text_bg_color === 'transparent' {
      background-color: $<?php echo $key_prefix; ?>text_bg_color;
    }
    @unless $<?php echo $key_prefix; ?>text_box_shadow_dimensions?? {
      box-shadow: $<?php echo $key_prefix; ?>text_box_shadow_dimensions $<?php echo $key_prefix; ?>text_box_shadow_color;
    }
    @if $<?php echo $key_prefix; ?>text_columns === true {
      -webkit-columns: $<?php echo $key_prefix; ?>text_columns_width $<?php echo $key_prefix; ?>text_columns_count;
              columns: $<?php echo $key_prefix; ?>text_columns_width $<?php echo $key_prefix; ?>text_columns_count;
      -webkit-column-gap: $<?php echo $key_prefix; ?>text_columns_gap;
              column-gap: $<?php echo $key_prefix; ?>text_columns_gap;
      -webkit-column-rule: $<?php echo $key_prefix; ?>text_columns_rule_width $<?php echo $key_prefix; ?>text_columns_rule_style $<?php echo $key_prefix; ?>text_columns_rule_color;
              column-rule: $<?php echo $key_prefix; ?>text_columns_rule_width $<?php echo $key_prefix; ?>text_columns_rule_style $<?php echo $key_prefix; ?>text_columns_rule_color;
    }
  }

  .$_el<?php echo $selector; ?> > :first-child { margin-top: 0;    }
  .$_el<?php echo $selector; ?> > :last-child  { margin-bottom: 0; }


  <?php

  // Column Content Breaking
  // -----------------------
  // Prevents direct children of the text element from breaking in half when
  // using column layouts.

  ?>

  @if $<?php echo $key_prefix; ?>text_columns === true && $<?php echo $key_prefix; ?>text_columns_break_inside === 'avoid' {
    .$_el<?php echo $selector; ?> > * {
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

@if $<?php echo $key_prefix; ?>text_type === 'headline' {

  <?php

  // Base
  // ----

  ?>

  .$_el<?php echo $selector; ?> {
    @if $<?php echo $key_prefix; ?>text_width !== 'auto' {
      width: $<?php echo $key_prefix; ?>text_width;
    }
    @unless $<?php echo $key_prefix; ?>text_max_width?? {
      max-width: $<?php echo $key_prefix; ?>text_max_width;
    }
    margin: $<?php echo $key_prefix; ?>text_margin;
    @unless $<?php echo $key_prefix; ?>text_border_width?? || $<?php echo $key_prefix; ?>text_border_style?? {
      border-width: $<?php echo $key_prefix; ?>text_border_width;
      border-style: $<?php echo $key_prefix; ?>text_border_style;
      border-color: $<?php echo $key_prefix; ?>text_border_color;
    }
    @unless $<?php echo $key_prefix; ?>text_border_radius?? {
      border-radius: $<?php echo $key_prefix; ?>text_border_radius;
    }
    padding: $<?php echo $key_prefix; ?>text_padding;
    font-size: $<?php echo $key_prefix; ?>text_base_font_size;
    @unless $<?php echo $key_prefix; ?>text_text_bg_color === 'transparent' {
      background-color: $<?php echo $key_prefix; ?>text_bg_color;
    }
    @unless $<?php echo $key_prefix; ?>text_box_shadow_dimensions?? {
      box-shadow: $<?php echo $key_prefix; ?>text_box_shadow_dimensions $<?php echo $key_prefix; ?>text_box_shadow_color;
    }
  }


  <?php

  // Content
  // -------
  // Contains the optional graphic as well as text content (which will always
  // have the main headline, along with an optional subheadline).

  ?>

  .$_el<?php echo $selector; ?> .x-text-content {
    @if $<?php echo $key_prefix; ?>text_graphic === true {
      flex-direction: $<?php echo $key_prefix; ?>text_flex_direction;
      justify-content: $<?php echo $key_prefix; ?>text_flex_justify;
      align-items: $<?php echo $key_prefix; ?>text_flex_align;
      @if $<?php echo $key_prefix; ?>text_flex_wrap === true {
        flex-wrap: wrap;
        align-content: $<?php echo $key_prefix; ?>text_flex_align;
      }
    }
  }


  <?php

  // Text Content
  // ------------
  // The container for the headline's text content (the main text along with
  // the optional subheadline).

  ?>

  .$_el<?php echo $selector; ?> .x-text-content-text {
    @if $<?php echo $key_prefix; ?>text_graphic === true && $<?php echo $key_prefix; ?>text_overflow === true && $<?php echo $key_prefix; ?>text_flex_direction === 'column' {
      width: 100%;
    }
    @unless $<?php echo $key_prefix; ?>text_content_margin?? {
      margin: $<?php echo $key_prefix; ?>text_content_margin;
    }
  }


  <?php

  // Headline Text
  // -------------
  // The primary headline text.

  ?>

  .$_el<?php echo $selector; ?> .x-text-content-text-primary {
    margin: 0 calc($<?php echo $key_prefix; ?>text_letter_spacing * -1) 0 0;
    font-family: $<?php echo $key_prefix; ?>text_font_family;
    font-size: $<?php echo $key_prefix; ?>text_font_size;
    font-style: $<?php echo $key_prefix; ?>text_font_style;
    font-weight: $<?php echo $key_prefix; ?>text_font_weight;
    line-height: $<?php echo $key_prefix; ?>text_line_height;
    letter-spacing: $<?php echo $key_prefix; ?>text_letter_spacing;
    @unless $<?php echo $key_prefix; ?>text_text_align?? {
      text-align: $<?php echo $key_prefix; ?>text_text_align;
    }
    @unless $<?php echo $key_prefix; ?>text_text_decoration?? {
      text-decoration: $<?php echo $key_prefix; ?>text_text_decoration;
    }
    @unless $<?php echo $key_prefix; ?>text_text_shadow_dimensions?? {
      text-shadow: $<?php echo $key_prefix; ?>text_text_shadow_dimensions $<?php echo $key_prefix; ?>text_text_shadow_color;
    }
    text-transform: $<?php echo $key_prefix; ?>text_text_transform;
    color: $<?php echo $key_prefix; ?>text_text_color;
    @if $<?php echo $key_prefix; ?>text_overflow === true {
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

  @if $<?php echo $key_prefix; ?>text_typing === true {
    @unless $<?php echo $key_prefix; ?>text_typing_color === 'inherit' {
      .$_el<?php echo $selector; ?> .x-text-typing {
        color: $<?php echo $key_prefix; ?>text_typing_color;
      }
    }
    @if $<?php echo $key_prefix; ?>text_typing_cursor === true {
      @unless $<?php echo $key_prefix; ?>text_typing_cursor_color === 'inherit' {
        .$_el<?php echo $selector; ?> .typed-cursor {
          color: $<?php echo $key_prefix; ?>text_typing_cursor_color;
        }
      }
    }
  }


  <?php

  // Subheadline Text
  // ----------------
  // The subheadline headline text.

  ?>

  @if $<?php echo $key_prefix; ?>text_subheadline === true {
    .$_el<?php echo $selector; ?> .x-text-content-text-subheadline {
      @if $<?php echo $key_prefix; ?>text_subheadline_reverse === false {
        margin: $<?php echo $key_prefix; ?>text_subheadline_spacing calc($<?php echo $key_prefix; ?>text_subheadline_letter_spacing * -1) 0 0;
      }
      @if $<?php echo $key_prefix; ?>text_subheadline_reverse === true {
        margin: 0 calc($<?php echo $key_prefix; ?>text_subheadline_letter_spacing * -1) $<?php echo $key_prefix; ?>text_subheadline_spacing 0;
      }
      font-family: $<?php echo $key_prefix; ?>text_subheadline_font_family;
      font-size: $<?php echo $key_prefix; ?>text_subheadline_font_size;
      font-style: $<?php echo $key_prefix; ?>text_subheadline_font_style;
      font-weight: $<?php echo $key_prefix; ?>text_subheadline_font_weight;
      line-height: $<?php echo $key_prefix; ?>text_subheadline_line_height;
      letter-spacing: $<?php echo $key_prefix; ?>text_subheadline_letter_spacing;
      @unless $<?php echo $key_prefix; ?>text_subheadline_text_align?? {
        text-align: $<?php echo $key_prefix; ?>text_subheadline_text_align;
      }
      @unless $<?php echo $key_prefix; ?>text_subheadline_text_decoration?? {
        text-decoration: $<?php echo $key_prefix; ?>text_subheadline_text_decoration;
      }
      @unless $<?php echo $key_prefix; ?>text_subheadline_text_shadow_dimensions?? {
        text-shadow: $<?php echo $key_prefix; ?>text_subheadline_text_shadow_dimensions $<?php echo $key_prefix; ?>text_subheadline_text_shadow_color;
      }
      text-transform: $<?php echo $key_prefix; ?>text_subheadline_text_transform;
      color: $<?php echo $key_prefix; ?>text_subheadline_text_color;
      @if $<?php echo $key_prefix; ?>text_overflow === true {
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

  @if $<?php echo $key_prefix; ?>text_graphic === true {

    <?php

    echo cs_get_partial_style( 'graphic', array(
      'no_base' => false,
      'selector' => $selector,
      'key_prefix' => $key_prefix . 'text'
    ) );

    ?>

  }

}
