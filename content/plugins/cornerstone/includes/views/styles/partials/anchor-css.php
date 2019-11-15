<?php

// =============================================================================
// _ANCHOR-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Text
//   04. Graphic
//   05. Sub Indicator
//   06. Particles
// =============================================================================

// Setup
// =============================================================================

$selector   = ( isset( $selector ) && $selector != '' ) ? $selector : '.x-anchor';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';



// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?> {
  @if $<?php echo $key_prefix; ?>anchor_width !== 'auto' {
    width: $<?php echo $key_prefix; ?>anchor_width;
  }
  @unless $<?php echo $key_prefix; ?>anchor_min_width?? {
    min-width: $<?php echo $key_prefix; ?>anchor_min_width;
  }
  @unless $<?php echo $key_prefix; ?>anchor_max_width?? {
    max-width: $<?php echo $key_prefix; ?>anchor_max_width;
  }
  @if $<?php echo $key_prefix; ?>anchor_height !== 'auto' {
    height: $<?php echo $key_prefix; ?>anchor_height;
  }
  @unless $<?php echo $key_prefix; ?>anchor_min_height?? {
    min-height: $<?php echo $key_prefix; ?>anchor_min_height;
  }
  @unless $<?php echo $key_prefix; ?>anchor_max_height?? {
    max-height: $<?php echo $key_prefix; ?>anchor_max_height;
  }
  @unless $<?php echo $key_prefix; ?>anchor_margin?? {
    margin: $<?php echo $key_prefix; ?>anchor_margin;
  }
  @unless $<?php echo $key_prefix; ?>anchor_border_width?? || $<?php echo $key_prefix; ?>anchor_border_style?? {
    border-width: $<?php echo $key_prefix; ?>anchor_border_width;
    border-style: $<?php echo $key_prefix; ?>anchor_border_style;
    border-color: $<?php echo $key_prefix; ?>anchor_border_color;
  }
  @unless $<?php echo $key_prefix; ?>anchor_border_radius?? {
    border-radius: $<?php echo $key_prefix; ?>anchor_border_radius;
  }
  font-size: $<?php echo $key_prefix; ?>anchor_base_font_size;
  background-color: $<?php echo $key_prefix; ?>anchor_bg_color;
  @unless $<?php echo $key_prefix; ?>anchor_box_shadow_dimensions?? {
    @if $<?php echo $key_prefix; ?>anchor_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $<?php echo $key_prefix; ?>anchor_box_shadow_color !== 'transparent' {
      box-shadow: $<?php echo $key_prefix; ?>anchor_box_shadow_dimensions $<?php echo $key_prefix; ?>anchor_box_shadow_color;
    }
  }
}


.$_el<?php echo $selector; ?> .x-anchor-content {
  flex-direction: $<?php echo $key_prefix; ?>anchor_flex_direction;
  justify-content: $<?php echo $key_prefix; ?>anchor_flex_justify;
  align-items: $<?php echo $key_prefix; ?>anchor_flex_align;
  @if $<?php echo $key_prefix; ?>anchor_flex_wrap === true {
    flex-wrap: wrap;
    align-content: $<?php echo $key_prefix; ?>anchor_flex_align;
  }
  @unless $<?php echo $key_prefix; ?>anchor_padding?? {
    padding: $<?php echo $key_prefix; ?>anchor_padding;
  }
}


.$_el<?php echo $selector; ?>[class*="active"] {
  @unless $<?php echo $key_prefix; ?>anchor_border_width?? || $<?php echo $key_prefix; ?>anchor_border_style?? {
    border-color: $<?php echo $key_prefix; ?>anchor_border_color_alt;
  }
  background-color: $<?php echo $key_prefix; ?>anchor_bg_color_alt;
  @unless $<?php echo $key_prefix; ?>anchor_box_shadow_dimensions?? {
    @if $<?php echo $key_prefix; ?>anchor_box_shadow_color_alt === 'transparent' {
      box-shadow: none;
    }
    @if $<?php echo $key_prefix; ?>anchor_box_shadow_color_alt !== 'transparent' {
      box-shadow: $<?php echo $key_prefix; ?>anchor_box_shadow_dimensions $<?php echo $key_prefix; ?>anchor_box_shadow_color_alt;
    }
  }
}



<?php

// Text
// =============================================================================

?>

@unless $<?php echo $key_prefix; ?>anchor_text === false {

  .$_el<?php echo $selector; ?> .x-anchor-text {
    @if $<?php echo $key_prefix; ?>anchor_text_overflow === true && $<?php echo $key_prefix; ?>anchor_flex_direction === 'column' {
      width: 100%;
    }
    @unless $<?php echo $key_prefix; ?>anchor_text_margin?? {
      margin: $<?php echo $key_prefix; ?>anchor_text_margin;
    }
  }

  @if $<?php echo $key_prefix; ?>anchor_text_overflow === true {
    .$_el<?php echo $selector; ?> .x-anchor-text-primary,
    .$_el<?php echo $selector; ?> .x-anchor-text-secondary {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
  }

  .$_el<?php echo $selector; ?> .x-anchor-text-primary {
    font-family: $<?php echo $key_prefix; ?>anchor_primary_font_family;
    font-size: $<?php echo $key_prefix; ?>anchor_primary_font_size;
    font-style: $<?php echo $key_prefix; ?>anchor_primary_font_style;
    font-weight: $<?php echo $key_prefix; ?>anchor_primary_font_weight;
    line-height: $<?php echo $key_prefix; ?>anchor_primary_line_height;
    @unless $<?php echo $key_prefix; ?>anchor_primary_letter_spacing?? {
      letter-spacing: $<?php echo $key_prefix; ?>anchor_primary_letter_spacing;
      margin-right: calc($<?php echo $key_prefix; ?>anchor_primary_letter_spacing * -1);
    }
    @unless $<?php echo $key_prefix; ?>anchor_primary_text_align?? {
      text-align: $<?php echo $key_prefix; ?>anchor_primary_text_align;
    }
    @unless $<?php echo $key_prefix; ?>anchor_primary_text_decoration?? {
      text-decoration: $<?php echo $key_prefix; ?>anchor_primary_text_decoration;
    }
    @unless $<?php echo $key_prefix; ?>anchor_primary_text_shadow_dimensions?? {
      @if $<?php echo $key_prefix; ?>anchor_primary_text_shadow_color === 'transparent' {
        text-shadow: none;
      }
      @if $<?php echo $key_prefix; ?>anchor_primary_text_shadow_color !== 'transparent' {
        text-shadow: $<?php echo $key_prefix; ?>anchor_primary_text_shadow_dimensions $<?php echo $key_prefix; ?>anchor_primary_text_shadow_color;
      }
    }
    @unless $<?php echo $key_prefix; ?>anchor_primary_text_transform?? {
      text-transform: $<?php echo $key_prefix; ?>anchor_primary_text_transform;
    }
    color: $<?php echo $key_prefix; ?>anchor_primary_text_color;
  }

  .$_el<?php echo $selector; ?>[class*="active"] .x-anchor-text-primary {
    @unless $<?php echo $key_prefix; ?>anchor_primary_text_shadow_dimensions?? {
      @if $<?php echo $key_prefix; ?>anchor_primary_text_shadow_color_alt === 'transparent' {
        text-shadow: none;
      }
      @if $<?php echo $key_prefix; ?>anchor_primary_text_shadow_color_alt !== 'transparent' {
        text-shadow: $<?php echo $key_prefix; ?>anchor_primary_text_shadow_dimensions $<?php echo $key_prefix; ?>anchor_primary_text_shadow_color_alt;
      }
    }
    color: $<?php echo $key_prefix; ?>anchor_primary_text_color_alt;
  }

  @if $<?php echo $key_prefix; ?>anchor_has_template === true {

    @if $<?php echo $key_prefix; ?>anchor_text_secondary_content !== '' || $<?php echo $key_prefix; ?>anchor_interactive_content_text_secondary_content !== '' {

      .$_el<?php echo $selector; ?> .x-anchor-text-secondary {
        @if $<?php echo $key_prefix; ?>anchor_text_reverse === true {
          margin-bottom: $<?php echo $key_prefix; ?>anchor_text_spacing;
        }
        @if $<?php echo $key_prefix; ?>anchor_text_reverse === false {
          margin-top: $<?php echo $key_prefix; ?>anchor_text_spacing;
        }
        font-family: $<?php echo $key_prefix; ?>anchor_secondary_font_family;
        font-size: $<?php echo $key_prefix; ?>anchor_secondary_font_size;
        font-style: $<?php echo $key_prefix; ?>anchor_secondary_font_style;
        font-weight: $<?php echo $key_prefix; ?>anchor_secondary_font_weight;
        line-height: $<?php echo $key_prefix; ?>anchor_secondary_line_height;
        @unless $<?php echo $key_prefix; ?>anchor_secondary_letter_spacing?? {
          letter-spacing: $<?php echo $key_prefix; ?>anchor_secondary_letter_spacing;
          margin-right: calc($<?php echo $key_prefix; ?>anchor_secondary_letter_spacing * -1);
        }
        @unless $<?php echo $key_prefix; ?>anchor_secondary_text_align?? {
          text-align: $<?php echo $key_prefix; ?>anchor_secondary_text_align;
        }
        @unless $<?php echo $key_prefix; ?>anchor_secondary_text_decoration?? {
          text-decoration: $<?php echo $key_prefix; ?>anchor_secondary_text_decoration;
        }
        @unless $<?php echo $key_prefix; ?>anchor_secondary_text_shadow_dimensions?? {
          @if $<?php echo $key_prefix; ?>anchor_secondary_text_shadow_color === 'transparent' {
            text-shadow: none;
          }
          @if $<?php echo $key_prefix; ?>anchor_secondary_text_shadow_color !== 'transparent' {
            text-shadow: $<?php echo $key_prefix; ?>anchor_secondary_text_shadow_dimensions $<?php echo $key_prefix; ?>anchor_secondary_text_shadow_color;
          }
        }
        @unless $<?php echo $key_prefix; ?>anchor_secondary_text_transform?? {
          text-transform: $<?php echo $key_prefix; ?>anchor_secondary_text_transform;
        }
        color: $<?php echo $key_prefix; ?>anchor_secondary_text_color;
      }

      .$_el<?php echo $selector; ?>[class*="active"] .x-anchor-text-secondary {
        @unless $<?php echo $key_prefix; ?>anchor_secondary_text_shadow_dimensions?? {
          @if $<?php echo $key_prefix; ?>anchor_secondary_text_shadow_color_alt === 'transparent' {
            text-shadow: none;
          }
          @if $<?php echo $key_prefix; ?>anchor_secondary_text_shadow_color_alt !== 'transparent' {
            text-shadow: $<?php echo $key_prefix; ?>anchor_secondary_text_shadow_dimensions $<?php echo $key_prefix; ?>anchor_secondary_text_shadow_color_alt;
          }
        }
        color: $<?php echo $key_prefix; ?>anchor_secondary_text_color_alt;
      }

    }

  }

}



<?php

// Graphic
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>anchor_has_template === true && $<?php echo $key_prefix; ?>anchor_graphic === true {

  <?php

  echo cs_get_partial_style( 'graphic', array(
    'no_base' => false,
    'selector' => $selector,
    'key_prefix' => $key_prefix . 'anchor'
  ) );

  ?>

}



<?php

// Sub Indicator
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>anchor_has_template === true && $<?php echo $key_prefix; ?>anchor_type === 'menu-item' && $<?php echo $key_prefix; ?>anchor_sub_indicator === true {

  .$_el<?php echo $selector; ?> .x-anchor-sub-indicator {
    @if $<?php echo $key_prefix; ?>anchor_sub_indicator_width !== 'auto' {
      width: $<?php echo $key_prefix; ?>anchor_sub_indicator_width;
    }
    @if $<?php echo $key_prefix; ?>anchor_sub_indicator_height !== 'auto' {
      height: $<?php echo $key_prefix; ?>anchor_sub_indicator_height;
      line-height: $<?php echo $key_prefix; ?>anchor_sub_indicator_height;
    }
    @unless $<?php echo $key_prefix; ?>anchor_sub_indicator_margin?? {
      margin: $<?php echo $key_prefix; ?>anchor_sub_indicator_margin;
    }
    font-size: $<?php echo $key_prefix; ?>anchor_sub_indicator_font_size;
    @unless $<?php echo $key_prefix; ?>anchor_sub_indicator_text_shadow_dimensions?? {
      @if $<?php echo $key_prefix; ?>anchor_sub_indicator_text_shadow_color === 'transparent' {
        text-shadow: none;
      }
      @if $<?php echo $key_prefix; ?>anchor_sub_indicator_text_shadow_color !== 'transparent' {
        text-shadow: $<?php echo $key_prefix; ?>anchor_sub_indicator_text_shadow_dimensions $<?php echo $key_prefix; ?>anchor_sub_indicator_text_shadow_color;
      }
    }
    color: $<?php echo $key_prefix; ?>anchor_sub_indicator_color;
  }

  .$_el<?php echo $selector; ?>[class*="active"] .x-anchor-sub-indicator {
    @unless $<?php echo $key_prefix; ?>anchor_sub_indicator_text_shadow_dimensions?? {
      @if $<?php echo $key_prefix; ?>anchor_sub_indicator_text_shadow_color_alt === 'transparent' {
        text-shadow: none;
      }
      @if $<?php echo $key_prefix; ?>anchor_sub_indicator_text_shadow_color_alt !== 'transparent' {
        text-shadow: $<?php echo $key_prefix; ?>anchor_sub_indicator_text_shadow_dimensions $<?php echo $key_prefix; ?>anchor_sub_indicator_text_shadow_color_alt;
      }
    }
    color: $<?php echo $key_prefix; ?>anchor_sub_indicator_color_alt;
  }

}



<?php

// Particles
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>anchor_primary_particle === true {

  <?php

    echo cs_get_partial_style( 'particle', array(
      'selector' => $selector . ' .x-anchor-particle-primary',
      'key_prefix' => $key_prefix . 'anchor_primary'
    ) );

  ?>

}

@if $<?php echo $key_prefix; ?>anchor_secondary_particle === true {

  <?php

    echo cs_get_partial_style( 'particle', array(
      'selector' => $selector . ' .x-anchor-particle-secondary',
      'key_prefix' => $key_prefix . 'anchor_secondary'
    ) );

  ?>

}
