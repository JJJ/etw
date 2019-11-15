<?php

// =============================================================================
// LAYOUT-GRID-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
//   02. Responsive Styles
// =============================================================================

// Base
// =============================================================================

?>

.$_el.x-grid {
  grid-gap: $layout_grid_gap_row $layout_grid_gap_column;
  justify-content: $layout_grid_justify_content;
  align-content: $layout_grid_align_content;
  justify-items: $layout_grid_justify_items;
  align-items: $layout_grid_align_items;
  z-index: $layout_grid_z_index;
  @if $layout_grid_global_container === false {
    @if $layout_grid_width !== 'auto' {
      width: $layout_grid_width;
    }
    @unless $layout_grid_max_width?? {
      max-width: $layout_grid_max_width;
    }
  }
  @unless $layout_grid_margin?? {
    margin: $layout_grid_margin;
  }
  @unless $layout_grid_border_width?? || $layout_grid_border_style?? {
    border-width: $layout_grid_border_width;
    border-style: $layout_grid_border_style;
    border-color: $layout_grid_border_color;
  }
  @unless $layout_grid_border_radius?? {
    border-radius: $layout_grid_border_radius;
  }
  @unless $layout_grid_padding?? {
    padding: $layout_grid_padding;
  }
  font-size: $layout_grid_base_font_size;
  @if $layout_grid_bg_color !== 'transparent' {
    background-color: $layout_grid_bg_color;
  }
  @unless $layout_grid_box_shadow_dimensions?? {
    @if $layout_grid_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $layout_grid_box_shadow_color !== 'transparent' {
      box-shadow: $layout_grid_box_shadow_dimensions $layout_grid_box_shadow_color;
    }
  }
}



<?php

// Responsive Styles
// =============================================================================

?>

@media (min-width: 1200px) {
  .$_el.x-grid {
    grid-template-columns: $layout_grid_template_columns_xl;
    grid-template-rows: $layout_grid_template_rows_xl;
  }
}

@media (min-width: 980px) and (max-width: 1199px) {
  .$_el.x-grid {
    grid-template-columns: $layout_grid_template_columns_lg;
    grid-template-rows: $layout_grid_template_rows_lg;
  }
}

@media (min-width: 768px) and (max-width: 979px) {
  .$_el.x-grid {
    grid-template-columns: $layout_grid_template_columns_md;
    grid-template-rows: $layout_grid_template_rows_md;
  }
}

@media (min-width: 481px) and (max-width: 767px) {
  .$_el.x-grid {
    grid-template-columns: $layout_grid_template_columns_sm;
    grid-template-rows: $layout_grid_template_rows_sm;
  }
}

@media (max-width: 480px) {
  .$_el.x-grid {
    grid-template-columns: $layout_grid_template_columns_xs;
    grid-template-rows: $layout_grid_template_rows_xs;
  }
}
