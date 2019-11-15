<?php

// =============================================================================
// LAYOUT-CELL-CSS.PHP
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

.$_el.x-cell {
  @if $layout_cell_flexbox {
    display: flex;
    flex-direction: $layout_cell_flex_direction;
    justify-content: $layout_cell_flex_justify;
    align-items: $layout_cell_flex_align;
    @if $layout_cell_flex_wrap === true {
      flex-wrap: wrap;
      align-content: $layout_cell_flex_align;
    }
  }
  z-index: $layout_cell_z_index;
  @unless $layout_cell_min_width?? {
    min-width: $layout_cell_min_width;
  }
  @unless $layout_cell_max_width?? {
    max-width: $layout_cell_max_width;
  }
  @unless $layout_cell_min_height?? {
    min-height: $layout_cell_min_height;
  }
  @unless $layout_cell_max_height?? {
    max-height: $layout_cell_max_height;
  }
  @unless $layout_cell_border_width?? || $layout_cell_border_style?? {
    border-width: $layout_cell_border_width;
    border-style: $layout_cell_border_style;
    border-color: $layout_cell_border_color;
  }
  @unless $layout_cell_border_radius?? {
    border-radius: $layout_cell_border_radius;
  }
  @unless $layout_cell_padding?? {
    padding: $layout_cell_padding;
  }
  font-size: $layout_cell_base_font_size;
  @if $layout_cell_bg_color !== 'transparent' {
    background-color: $layout_cell_bg_color;
  }
  @unless $layout_cell_box_shadow_dimensions?? {
    @if $layout_cell_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $layout_cell_box_shadow_color !== 'transparent' {
      box-shadow: $layout_cell_box_shadow_dimensions $layout_cell_box_shadow_color;
    }
  }
}



<?php

// Responsive Styles
// =============================================================================

?>

@media (min-width: 1200px) {
  .$_el.x-cell {
    @if $layout_cell_column_start_xl !== ''     { grid-column-start: $layout_cell_column_start_xl; }
    @if $layout_cell_column_end_xl   !== ''     { grid-column-end:   $layout_cell_column_end_xl;   }
    @if $layout_cell_row_start_xl    !== ''     { grid-row-start:    $layout_cell_row_start_xl;    }
    @if $layout_cell_row_end_xl      !== ''     { grid-row-end:      $layout_cell_row_end_xl;      }
    @if $layout_cell_justify_self_xl !== 'auto' { justify-self:      $layout_cell_justify_self_xl; }
    @if $layout_cell_align_self_xl   !== 'auto' { align-self:        $layout_cell_align_self_xl;   }
  }
}

@media (min-width: 980px) and (max-width: 1199px) {
  .$_el.x-cell {
    @if $layout_cell_column_start_lg !== ''     { grid-column-start: $layout_cell_column_start_lg; }
    @if $layout_cell_column_end_lg   !== ''     { grid-column-end:   $layout_cell_column_end_lg;   }
    @if $layout_cell_row_start_lg    !== ''     { grid-row-start:    $layout_cell_row_start_lg;    }
    @if $layout_cell_row_end_lg      !== ''     { grid-row-end:      $layout_cell_row_end_lg;      }
    @if $layout_cell_justify_self_lg !== 'auto' { justify-self:      $layout_cell_justify_self_lg; }
    @if $layout_cell_align_self_lg   !== 'auto' { align-self:        $layout_cell_align_self_lg;   }
  }
}

@media (min-width: 768px) and (max-width: 979px) {
  .$_el.x-cell {
    @if $layout_cell_column_start_md !== ''     { grid-column-start: $layout_cell_column_start_md; }
    @if $layout_cell_column_end_md   !== ''     { grid-column-end:   $layout_cell_column_end_md;   }
    @if $layout_cell_row_start_md    !== ''     { grid-row-start:    $layout_cell_row_start_md;    }
    @if $layout_cell_row_end_md      !== ''     { grid-row-end:      $layout_cell_row_end_md;      }
    @if $layout_cell_justify_self_md !== 'auto' { justify-self:      $layout_cell_justify_self_md; }
    @if $layout_cell_align_self_md   !== 'auto' { align-self:        $layout_cell_align_self_md;   }
  }
}

@media (min-width: 481px) and (max-width: 767px) {
  .$_el.x-cell {
    @if $layout_cell_column_start_sm !== ''     { grid-column-start: $layout_cell_column_start_sm; }
    @if $layout_cell_column_end_sm   !== ''     { grid-column-end:   $layout_cell_column_end_sm;   }
    @if $layout_cell_row_start_sm    !== ''     { grid-row-start:    $layout_cell_row_start_sm;    }
    @if $layout_cell_row_end_sm      !== ''     { grid-row-end:      $layout_cell_row_end_sm;      }
    @if $layout_cell_justify_self_sm !== 'auto' { justify-self:      $layout_cell_justify_self_sm; }
    @if $layout_cell_align_self_sm   !== 'auto' { align-self:        $layout_cell_align_self_sm;   }
  }
}

@media (max-width: 480px) {
  .$_el.x-cell {
    @if $layout_cell_column_start_xs !== ''     { grid-column-start: $layout_cell_column_start_xs; }
    @if $layout_cell_column_end_xs   !== ''     { grid-column-end:   $layout_cell_column_end_xs;   }
    @if $layout_cell_row_start_xs    !== ''     { grid-row-start:    $layout_cell_row_start_xs;    }
    @if $layout_cell_row_end_xs      !== ''     { grid-row-end:      $layout_cell_row_end_xs;      }
    @if $layout_cell_justify_self_xs !== 'auto' { justify-self:      $layout_cell_justify_self_xs; }
    @if $layout_cell_align_self_xs   !== 'auto' { align-self:        $layout_cell_align_self_xs;   }
  }
}
