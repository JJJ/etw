<?php

// =============================================================================
// _DROPDOWN-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
// =============================================================================

// Setup
// =============================================================================

$selector   = ( isset( $selector ) && $selector != '' ) ? $selector : '';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';


// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?> .x-dropdown {
  width: $<?php echo $key_prefix; ?>dropdown_width;
  @unless $<?php echo $key_prefix; ?>dropdown_border_width?? || $<?php echo $key_prefix; ?>dropdown_border_style?? {
    border-width: $<?php echo $key_prefix; ?>dropdown_border_width;
    border-style: $<?php echo $key_prefix; ?>dropdown_border_style;
    border-color: $<?php echo $key_prefix; ?>dropdown_border_color;
  }
  @unless $<?php echo $key_prefix; ?>dropdown_border_radius?? {
    border-radius: $<?php echo $key_prefix; ?>dropdown_border_radius;
  }
  @unless $<?php echo $key_prefix; ?>dropdown_padding?? {
    padding: $<?php echo $key_prefix; ?>dropdown_padding;
  }
  font-size: $<?php echo $key_prefix; ?>dropdown_base_font_size;
  @unless $<?php echo $key_prefix; ?>dropdown_bg_color === 'transparent' {
    background-color: $<?php echo $key_prefix; ?>dropdown_bg_color;
  }
  @unless $<?php echo $key_prefix; ?>dropdown_box_shadow_dimensions?? {
    box-shadow: $<?php echo $key_prefix; ?>dropdown_box_shadow_dimensions $<?php echo $key_prefix; ?>dropdown_box_shadow_color;
  }
}

.$_el<?php echo $selector; ?> .x-dropdown[data-x-stem-top] {
  @unless $<?php echo $key_prefix; ?>dropdown_margin?? {
    margin: $<?php echo $key_prefix; ?>dropdown_margin;
  }
}
