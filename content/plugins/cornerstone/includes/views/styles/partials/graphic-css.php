<?php

// =============================================================================
// _TOGGLE-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Type: Icon
//   04. Type: Toggle
// =============================================================================

// Setup
// =============================================================================

$no_base    = ( isset( $no_base ) && $no_base == true     ) ? ''                : ' .x-graphic';
$selector   = ( isset( $selector ) && $selector != ''     ) ? $selector         : '';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';



// Base
// =============================================================================

?>

.$_el<?php echo $selector . $no_base; ?> {
  @unless $<?php echo $key_prefix; ?>graphic_margin?? {
    margin: $<?php echo $key_prefix; ?>graphic_margin;
  }
}



<?php

// Type: Icon
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>graphic_type === 'icon' {

  .$_el<?php echo $selector; ?> .x-graphic-icon {
    width: $<?php echo $key_prefix; ?>graphic_icon_width;
    @unless $<?php echo $key_prefix; ?>graphic_icon_border_width?? || $<?php echo $key_prefix; ?>graphic_icon_border_style?? {
      border-width: $<?php echo $key_prefix; ?>graphic_icon_border_width;
      border-style: $<?php echo $key_prefix; ?>graphic_icon_border_style;
      border-color: $<?php echo $key_prefix; ?>graphic_icon_border_color;
    }
    @unless $<?php echo $key_prefix; ?>graphic_icon_border_radius?? {
      border-radius: $<?php echo $key_prefix; ?>graphic_icon_border_radius;
    }
    @if $<?php echo $key_prefix; ?>graphic_icon_height !== 'auto' {
      height: $<?php echo $key_prefix; ?>graphic_icon_height;
      line-height: $<?php echo $key_prefix; ?>graphic_icon_height;
    }
    font-size: $<?php echo $key_prefix; ?>graphic_icon_font_size;
    @unless $<?php echo $key_prefix; ?>graphic_icon_text_shadow_dimensions?? {
      @if $<?php echo $key_prefix; ?>graphic_icon_text_shadow_color === 'transparent' {
        text-shadow: none;
      }
      @if $<?php echo $key_prefix; ?>graphic_icon_text_shadow_color !== 'transparent' {
        text-shadow: $<?php echo $key_prefix; ?>graphic_icon_text_shadow_dimensions $<?php echo $key_prefix; ?>graphic_icon_text_shadow_color;
      }
    }
    color: $<?php echo $key_prefix; ?>graphic_icon_color;
    @if $<?php echo $key_prefix; ?>graphic_icon_bg_color !== 'transparent' {
      background-color: $<?php echo $key_prefix; ?>graphic_icon_bg_color;
    }
    @unless $<?php echo $key_prefix; ?>graphic_icon_box_shadow_dimensions?? {
      @if $<?php echo $key_prefix; ?>graphic_icon_box_shadow_color === 'transparent' {
        box-shadow: none;
      }
      @if $<?php echo $key_prefix; ?>graphic_icon_box_shadow_color !== 'transparent' {
        box-shadow: $<?php echo $key_prefix; ?>graphic_icon_box_shadow_dimensions $<?php echo $key_prefix; ?>graphic_icon_box_shadow_color;
      }
    }
  }

  @if $<?php echo $key_prefix; ?>graphic_has_alt === true {
    .$_el<?php echo $selector; ?> .x-graphic-icon[class*="active"] {
      @unless $<?php echo $key_prefix; ?>graphic_icon_text_shadow_dimensions?? {
        @if $<?php echo $key_prefix; ?>graphic_icon_text_shadow_color_alt === 'transparent' {
          text-shadow: none;
        }
        @if $<?php echo $key_prefix; ?>graphic_icon_text_shadow_color_alt !== 'transparent' {
          text-shadow: $<?php echo $key_prefix; ?>graphic_icon_text_shadow_dimensions $<?php echo $key_prefix; ?>graphic_icon_text_shadow_color_alt;
        }
      }
      color: $<?php echo $key_prefix; ?>graphic_icon_color_alt;
      @unless $<?php echo $key_prefix; ?>graphic_icon_border_width?? || $<?php echo $key_prefix; ?>graphic_icon_border_style?? {
        border-color: $<?php echo $key_prefix; ?>graphic_icon_border_color_alt;
      }
      @if $<?php echo $key_prefix; ?>graphic_icon_bg_color_alt !== 'transparent' {
        background-color: $<?php echo $key_prefix; ?>graphic_icon_bg_color_alt;
      }
      @unless $<?php echo $key_prefix; ?>graphic_icon_box_shadow_dimensions?? {
        @if $<?php echo $key_prefix; ?>graphic_icon_box_shadow_color_alt === 'transparent' {
          box-shadow: none;
        }
        @if $<?php echo $key_prefix; ?>graphic_icon_box_shadow_color_alt !== 'transparent' {
          box-shadow: $<?php echo $key_prefix; ?>graphic_icon_box_shadow_dimensions $<?php echo $key_prefix; ?>graphic_icon_box_shadow_color_alt;
        }
      }
    }
  }

}



<?php

// Type: Image
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>graphic_type === 'image' {
  .$_el<?php echo $selector; ?> .x-graphic-image {
    @unless $<?php echo $key_prefix; ?>graphic_image_max_width?? {
      max-width: $<?php echo $key_prefix; ?>graphic_image_max_width;
    }
  }
}



<?php

// Type: Toggle
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>graphic_type === 'toggle' {
  <?php echo cs_get_partial_style( 'toggle' ); ?>
}
