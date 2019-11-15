<?php

// =============================================================================
// _MENU-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
// =============================================================================

// Setup
// =============================================================================

$selector = ( isset( $selector ) && $selector != '' ) ? $selector : '';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';


// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?>.x-menu {
  @if $<?php echo $key_prefix; ?>menu_type === 'inline' {
    @if $_region === 'left' || $_region === 'right' {
      flex-direction: $<?php echo $key_prefix; ?>menu_col_flex_direction;
      justify-content: $<?php echo $key_prefix; ?>menu_col_flex_justify;
      align-items: $<?php echo $key_prefix; ?>menu_col_flex_align;
      @if $<?php echo $key_prefix; ?>menu_col_flex_wrap === true {
        flex-wrap: wrap;
        align-content: $<?php echo $key_prefix; ?>menu_col_flex_align;
      }
    }
    @if $_region === 'content' || $_region === 'top' || $_region === 'bottom' || $_region === 'footer' {
      flex-direction: $<?php echo $key_prefix; ?>menu_row_flex_direction;
      justify-content: $<?php echo $key_prefix; ?>menu_row_flex_justify;
      align-items: $<?php echo $key_prefix; ?>menu_row_flex_align;
      @if $<?php echo $key_prefix; ?>menu_row_flex_wrap === true {
        flex-wrap: wrap;
        align-content: $<?php echo $key_prefix; ?>menu_row_flex_align;
      }
    }
    align-self: $<?php echo $key_prefix; ?>menu_align_self;
    flex: $<?php echo $key_prefix; ?>menu_flex;
  }
  @if $<?php echo $key_prefix; ?>menu_type !== 'dropdown' {
    margin: $<?php echo $key_prefix; ?>menu_margin;
    font-size: $<?php echo $key_prefix; ?>menu_base_font_size;
  }
}

.$_el<?php echo $selector; ?>.x-menu > li,
.$_el<?php echo $selector; ?>.x-menu > li > a {
  @if $<?php echo $key_prefix; ?>menu_type === 'inline' {
    flex: $<?php echo $key_prefix; ?>menu_items_flex;
  }
}
