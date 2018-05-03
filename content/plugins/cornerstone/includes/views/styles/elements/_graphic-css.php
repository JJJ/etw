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

$graphic_no_base  = ( isset( $graphic_no_base ) && $graphic_no_base == true ) ? '' : ' .x-graphic';
$graphic_selector = ( isset( $graphic_selector ) && $graphic_selector != '' ) ? $graphic_selector    : '';
$graphic_k_pre    = ( isset( $graphic_k_pre    ) && $graphic_k_pre    != '' ) ? $graphic_k_pre . '_' : '';



// Base
// =============================================================================

?>

.$_el<?php echo $graphic_selector . $graphic_no_base; ?> {
  @unless $<?php echo $graphic_k_pre; ?>graphic_margin?? {
    margin: $<?php echo $graphic_k_pre; ?>graphic_margin;
  }
}



<?php

// Type: Icon
// =============================================================================

?>

@if $<?php echo $graphic_k_pre; ?>graphic_type === 'icon' {

  .$_el<?php echo $graphic_selector; ?> .x-graphic-icon {
    @if $<?php echo $graphic_k_pre; ?>graphic_icon_width !== 'auto' {
      width: $<?php echo $graphic_k_pre; ?>graphic_icon_width;
    }
    @unless $<?php echo $graphic_k_pre; ?>graphic_icon_border_width?? || $<?php echo $graphic_k_pre; ?>graphic_icon_border_style?? {
      border-width: $<?php echo $graphic_k_pre; ?>graphic_icon_border_width;
      border-style: $<?php echo $graphic_k_pre; ?>graphic_icon_border_style;
      border-color: $<?php echo $graphic_k_pre; ?>graphic_icon_border_color;
    }
    @unless $<?php echo $graphic_k_pre; ?>graphic_icon_border_radius?? {
      border-radius: $<?php echo $graphic_k_pre; ?>graphic_icon_border_radius;
    }
    @if $<?php echo $graphic_k_pre; ?>graphic_icon_height !== 'auto' {
      height: $<?php echo $graphic_k_pre; ?>graphic_icon_height;
      line-height: $<?php echo $graphic_k_pre; ?>graphic_icon_height;
    }
    font-size: $<?php echo $graphic_k_pre; ?>graphic_icon_font_size;
    @unless $<?php echo $graphic_k_pre; ?>graphic_icon_text_shadow_dimensions?? {
      @if $<?php echo $graphic_k_pre; ?>graphic_icon_text_shadow_color === 'transparent' {
        text-shadow: none;
      }
      @if $<?php echo $graphic_k_pre; ?>graphic_icon_text_shadow_color !== 'transparent' {
        text-shadow: $<?php echo $graphic_k_pre; ?>graphic_icon_text_shadow_dimensions $<?php echo $graphic_k_pre; ?>graphic_icon_text_shadow_color;
      }
    }
    color: $<?php echo $graphic_k_pre; ?>graphic_icon_color;
    @if $<?php echo $graphic_k_pre; ?>graphic_icon_bg_color !== 'transparent' {
      background-color: $<?php echo $graphic_k_pre; ?>graphic_icon_bg_color;
    }
    @unless $<?php echo $graphic_k_pre; ?>graphic_icon_box_shadow_dimensions?? {
      @if $<?php echo $graphic_k_pre; ?>graphic_icon_box_shadow_color === 'transparent' {
        box-shadow: none;
      }
      @if $<?php echo $graphic_k_pre; ?>graphic_icon_box_shadow_color !== 'transparent' {
        box-shadow: $<?php echo $graphic_k_pre; ?>graphic_icon_box_shadow_dimensions $<?php echo $graphic_k_pre; ?>graphic_icon_box_shadow_color;
      }
    }
  }

  @if $<?php echo $graphic_k_pre; ?>graphic_has_alt === true {
    .$_el<?php echo $graphic_selector; ?>[class*="active"] .x-graphic-icon {
      @unless $<?php echo $graphic_k_pre; ?>graphic_icon_text_shadow_dimensions?? {
        @if $<?php echo $graphic_k_pre; ?>graphic_icon_text_shadow_color_alt === 'transparent' {
          text-shadow: none;
        }
        @if $<?php echo $graphic_k_pre; ?>graphic_icon_text_shadow_color_alt !== 'transparent' {
          text-shadow: $<?php echo $graphic_k_pre; ?>graphic_icon_text_shadow_dimensions $<?php echo $graphic_k_pre; ?>graphic_icon_text_shadow_color_alt;
        }
      }
      color: $<?php echo $graphic_k_pre; ?>graphic_icon_color_alt;
      @unless $<?php echo $graphic_k_pre; ?>graphic_icon_border_width?? || $<?php echo $graphic_k_pre; ?>graphic_icon_border_style?? {
        border-color: $<?php echo $graphic_k_pre; ?>graphic_icon_border_color_alt;
      }
      @if $<?php echo $graphic_k_pre; ?>graphic_icon_bg_color_alt !== 'transparent' {
        background-color: $<?php echo $graphic_k_pre; ?>graphic_icon_bg_color_alt;
      }
      @unless $<?php echo $graphic_k_pre; ?>graphic_icon_box_shadow_dimensions?? {
        @if $<?php echo $graphic_k_pre; ?>graphic_icon_box_shadow_color_alt === 'transparent' {
          box-shadow: none;
        }
        @if $<?php echo $graphic_k_pre; ?>graphic_icon_box_shadow_color_alt !== 'transparent' {
          box-shadow: $<?php echo $graphic_k_pre; ?>graphic_icon_box_shadow_dimensions $<?php echo $graphic_k_pre; ?>graphic_icon_box_shadow_color_alt;
        }
      }
    }
  }

}



<?php

// Type: Image
// =============================================================================

?>

@if $<?php echo $graphic_k_pre; ?>graphic_type === 'image' {
  .$_el<?php echo $graphic_selector; ?> .x-graphic-image {
    @unless $<?php echo $graphic_k_pre; ?>graphic_image_max_width?? {
      max-width: $<?php echo $graphic_k_pre; ?>graphic_image_max_width;
    }
  }
}



<?php

// Type: Toggle
// =============================================================================

?>

@if $<?php echo $graphic_k_pre; ?>graphic_type === 'toggle' {
  <?php include( '_toggle-css.php' ); ?>
}