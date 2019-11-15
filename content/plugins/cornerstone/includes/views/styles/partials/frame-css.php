<?php

// =============================================================================
// _FRAME-CSS.PHP
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

$selector   = ( isset( $selector ) && $selector != '' ) ? $selector    : '';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != ''       ) ? $key_prefix . '_' : '';


// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?>.x-frame {
  @if $<?php echo $key_prefix; ?>frame_width !== 'auto' {
    width: $<?php echo $key_prefix; ?>frame_width;
  }
  @unless $<?php echo $key_prefix; ?>frame_max_width?? {
    max-width: $<?php echo $key_prefix; ?>frame_max_width;
  }
  @unless $<?php echo $key_prefix; ?>frame_margin?? {
    margin: $<?php echo $key_prefix; ?>frame_margin;
  }
  @unless $<?php echo $key_prefix; ?>frame_border_width?? || $<?php echo $key_prefix; ?>frame_border_style?? {
    border-width: $<?php echo $key_prefix; ?>frame_border_width;
    border-style: $<?php echo $key_prefix; ?>frame_border_style;
    border-color: $<?php echo $key_prefix; ?>frame_border_color;
  }
  @unless $<?php echo $key_prefix; ?>frame_border_radius?? {
    border-radius: $<?php echo $key_prefix; ?>frame_border_radius;
  }
  @unless $<?php echo $key_prefix; ?>frame_padding?? {
    padding: $<?php echo $key_prefix; ?>frame_padding;
  }
  font-size: $<?php echo $key_prefix; ?>frame_base_font_size;
  @if $<?php echo $key_prefix; ?>frame_bg_color !== 'transparent' {
    background-color: $<?php echo $key_prefix; ?>frame_bg_color;
  }
  @unless $<?php echo $key_prefix; ?>frame_box_shadow_dimensions?? {
    @if $<?php echo $key_prefix; ?>frame_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $<?php echo $key_prefix; ?>frame_box_shadow_color !== 'transparent' {
      box-shadow: $<?php echo $key_prefix; ?>frame_box_shadow_dimensions $<?php echo $key_prefix; ?>frame_box_shadow_color;
    }
  }
}

.$_el<?php echo $selector; ?> .x-frame-inner {
  @if $<?php echo $key_prefix; ?>frame_content_sizing === 'fixed-height' {
    padding-bottom: $frame_content_height;
  }
  @if $<?php echo $key_prefix; ?>frame_content_sizing === 'aspect-ratio' {
    padding-bottom: calc(($<?php echo $key_prefix; ?>frame_content_aspect_ratio_height / $<?php echo $key_prefix; ?>frame_content_aspect_ratio_width) * 100%);
  }
}
