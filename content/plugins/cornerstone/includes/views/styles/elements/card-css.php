<?php

// =============================================================================
// CARD-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Include Partial CSS
//   02. Base
//   03. Faces
//   04. Face: All
//   05. Face: Front
//   06. Face: Back
// =============================================================================

// Include Partial CSS
// =============================================================================

echo cs_get_partial_style( 'text', array(
  'selector'   => ' .is-front .x-text',
  'key_prefix' => 'card_front',
) );

echo cs_get_partial_style( 'text', array(
  'selector'   => ' .is-back .x-text',
  'key_prefix' => 'card_back',
) );

echo cs_get_partial_style( 'anchor', array(
  'anchor_selector' => ' .x-anchor'
) );



// Base
// =============================================================================
// 01. `perspective` must be placed on element wrapping `preserve-3d`.

?>

.$_el.x-card {
  font-size: $card_base_font_size;
  @unless $card_width?? {
    width: $card_width;
  }
  @unless $card_max_width?? {
    max-width: $card_max_width;
  }
  @unless $card_margin?? {
    margin: $card_margin;
  }
  perspective: $card_perspective;
}



<?php

// Faces
// =============================================================================
// 01. Where `transform-style: preserve-3d` is applied in static CSS.

?>

.$_el .x-card-faces {
  @unless $card_transition_duration?? {
    transition-duration: $card_transition_duration;
  }
}



<?php

// Face: All
// =============================================================================
// 01. Where `backface-visibility: hidden` is applied in static CSS.

?>

.$_el .x-card-face {
  justify-content: $card_content_justify;
  @unless $card_border_radius?? {
    border-radius: $card_border_radius;
  }
}



<?php

// Face: Front
// =============================================================================

?>

.$_el .x-card-face.is-front {
  @unless $card_front_border_width?? || $card_front_border_style?? {
    border-width: $card_front_border_width;
    border-style: $card_front_border_style;
    border-color: $card_front_border_color;
  }
  @unless $card_front_padding?? {
    padding: $card_front_padding;
  }
  background-color: $card_front_bg_color;
  @unless $card_front_box_shadow_dimensions?? {
    @if $card_front_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $card_front_box_shadow_color !== 'transparent' {
      box-shadow: $card_front_box_shadow_dimensions $card_front_box_shadow_color;
    }
  }
}



<?php

// Face: Back
// =============================================================================

?>

.$_el .x-card-face.is-back {
  @unless $card_back_border_width?? || $card_back_border_style?? {
    border-width: $card_back_border_width;
    border-style: $card_back_border_style;
    border-color: $card_back_border_color;
  }
  @unless $card_back_padding?? {
    padding: $card_back_padding;
  }
  background-color: $card_back_bg_color;
  @unless $card_back_box_shadow_dimensions?? {
    @if $card_back_box_shadow_color === 'transparent' {
      box-shadow: none;
    }
    @if $card_back_box_shadow_color !== 'transparent' {
      box-shadow: $card_back_box_shadow_dimensions $card_back_box_shadow_color;
    }
  }
}
