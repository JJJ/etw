<?php

// =============================================================================
// LAYOUT-ROW-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
//   02. Responsive Styles
//   03. Columns
// =============================================================================

// Base
// =============================================================================

?>

.$_el.x-row {
  z-index: $layout_row_z_index;
  @if $layout_row_global_container === false {
    @if $layout_row_width !== 'auto' {
      width: $layout_row_width;
    }
    @unless $layout_row_max_width?? {
      max-width: $layout_row_max_width;
    }
  }
  @unless $layout_row_margin?? {
    margin: $layout_row_margin;
  }
  @unless $layout_row_border_width?? || $layout_row_border_style?? {
    border-width: $layout_row_border_width;
    border-style: $layout_row_border_style;
    border-color: $layout_row_border_color;
  }
  @unless $layout_row_border_radius?? {
    border-radius: $layout_row_border_radius;
  }
  @if $layout_row_padding?? {
    padding: 1px;
  }
  @unless $layout_row_padding?? {
    padding: $layout_row_padding;
  }
  font-size: $layout_row_base_font_size;
  @unless $layout_row_text_align?? {
    text-align: $layout_row_text_align;
  }
  @if $layout_row_bg_color !== 'transparent' {
    background-color: $layout_row_bg_color;
  }
  @unless $layout_row_box_shadow_dimensions?? {
    @if $layout_row_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $layout_row_box_shadow_color !== 'transparent' {
      box-shadow: $layout_row_box_shadow_dimensions $layout_row_box_shadow_color;
    }
  }
}

.$_el > .x-row-inner {
  @if $layout_row_reverse === false {
    flex-direction: row;
  }
  @if $layout_row_reverse === true {
    flex-direction: row-reverse;
  }
  justify-content: $layout_row_flex_justify;
  align-items: $layout_row_flex_align;
  align-content: $layout_row_flex_align;
  @if $layout_row_padding?? {
    margin: calc((($layout_row_gap_row / 2) + 1px) * -1) calc((($layout_row_gap_column / 2) + 1px) * -1);
  }
  @unless $layout_row_padding?? {
    margin: calc(($layout_row_gap_row / 2) * -1) calc(($layout_row_gap_column / 2) * -1);
  }
}



<?php

// Responsive Styles
// =============================================================================

?>

@media (min-width: 1200px) {
  @each-nth-child $size, $index in $layout_row_layout_xl {
    .$_el > .x-row-inner > *:nth-child($index) {
      flex-basis: calc($size - $layout_row_gap_column);
    }
  }
}

@media (min-width: 980px) and (max-width: 1199px) {
  @each-nth-child $size, $index in $layout_row_layout_lg {
    .$_el > .x-row-inner > *:nth-child($index) {
      flex-basis: calc($size - $layout_row_gap_column);
    }
  }
}

@media (min-width: 768px) and (max-width: 979px) {
  @each-nth-child $size, $index in $layout_row_layout_md {
    .$_el > .x-row-inner > *:nth-child($index) {
      flex-basis: calc($size - $layout_row_gap_column);
    }
  }
}

@media (min-width: 481px) and (max-width: 767px) {
  @each-nth-child $size, $index in $layout_row_layout_sm {
    .$_el > .x-row-inner > *:nth-child($index) {
      flex-basis: calc($size - $layout_row_gap_column);
    }
  }
}

@media (max-width: 480px) {
  @each-nth-child $size, $index in $layout_row_layout_xs {
    .$_el > .x-row-inner > *:nth-child($index) {
      flex-basis: calc($size - $layout_row_gap_column);
    }
  }
}



<?php

// Columns
// =============================================================================

?>

.$_el > .x-row-inner > * {
  @if $layout_row_grow === true {
    flex-grow: 1;
  }
  margin: calc($layout_row_gap_row / 2) calc($layout_row_gap_column / 2);
}
