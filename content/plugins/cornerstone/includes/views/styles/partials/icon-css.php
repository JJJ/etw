<?php

// =============================================================================
// _ICON-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
// =============================================================================

// Setup
// =============================================================================

$selector   = ( isset( $selector ) && $selector != '' ) ? $selector : '.x-icon';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';



// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?> {
  @if $<?php echo $key_prefix; ?>icon_width !== 'auto' {
    width: $<?php echo $key_prefix; ?>icon_width;
  }
  @unless $<?php echo $key_prefix; ?>icon_margin?? {
    margin: $<?php echo $key_prefix; ?>icon_margin;
  }
  @unless $<?php echo $key_prefix; ?>icon_border_width?? || $<?php echo $key_prefix; ?>icon_border_style?? {
    border-width: $<?php echo $key_prefix; ?>icon_border_width;
    border-style: $<?php echo $key_prefix; ?>icon_border_style;
    border-color: $<?php echo $key_prefix; ?>icon_border_color;
  }
  @unless $<?php echo $key_prefix; ?>icon_border_radius?? {
    border-radius: $<?php echo $key_prefix; ?>icon_border_radius;
  }
  @if $<?php echo $key_prefix; ?>icon_height !== 'auto' {
    height: $<?php echo $key_prefix; ?>icon_height;
    line-height: $<?php echo $key_prefix; ?>icon_height;
  }
  font-size: $<?php echo $key_prefix; ?>icon_font_size;
  @unless $<?php echo $key_prefix; ?>icon_text_shadow_dimensions?? {
    @if $<?php echo $key_prefix; ?>icon_text_shadow_color === 'transparent' {
      text-shadow: none;
    }
    @if $<?php echo $key_prefix; ?>icon_text_shadow_color !== 'transparent' {
      text-shadow: $<?php echo $key_prefix; ?>icon_text_shadow_dimensions $<?php echo $key_prefix; ?>icon_text_shadow_color;
    }
  }
  color: $<?php echo $key_prefix; ?>icon_color;
  @if $<?php echo $key_prefix; ?>icon_bg_color !== 'transparent' {
    background-color: $<?php echo $key_prefix; ?>icon_bg_color;
  }
  @unless $<?php echo $key_prefix; ?>icon_box_shadow_dimensions?? {
    @if $<?php echo $key_prefix; ?>icon_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $<?php echo $key_prefix; ?>icon_box_shadow_color !== 'transparent' {
      box-shadow: $<?php echo $key_prefix; ?>icon_box_shadow_dimensions $<?php echo $key_prefix; ?>icon_box_shadow_color;
    }
  }
}
