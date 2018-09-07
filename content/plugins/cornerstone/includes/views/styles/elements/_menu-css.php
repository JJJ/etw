<?php

// =============================================================================
// _MENU-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
// =============================================================================

// Base
// =============================================================================

?>

.$_el.x-menu {
  @if $menu_type === 'inline' {
    @if $_region === 'left' || $_region === 'right' {
      flex-direction: $menu_col_flex_direction;
      justify-content: $menu_col_flex_justify;
      align-items: $menu_col_flex_align;
      @if $menu_col_flex_wrap === true {
        flex-wrap: wrap;
        align-content: $menu_col_flex_align;
      }
    }
    @if $_region === 'content' || $_region === 'top' || $_region === 'bottom' || $_region === 'footer' {
      flex-direction: $menu_row_flex_direction;
      justify-content: $menu_row_flex_justify;
      align-items: $menu_row_flex_align;
      @if $menu_row_flex_wrap === true {
        flex-wrap: wrap;
        align-content: $menu_row_flex_align;
      }
    }
    align-self: $menu_align_self;
    flex: $menu_flex;
  }
  @if $menu_type !== 'dropdown' {
    margin: $menu_margin;
    font-size: $menu_base_font_size;
  }
}

.$_el.x-menu > li,
.$_el.x-menu > li > a {
  @if $menu_type === 'inline' {
    flex: $menu_items_flex;
  }
}