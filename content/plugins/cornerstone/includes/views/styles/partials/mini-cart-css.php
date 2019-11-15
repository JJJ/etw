<?php

// =============================================================================
// _MINI-CART-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Title
//   03. Items
//   04. Thumbnails
//   05. Links
//   06. Quantity
//   07. Total
//   08. Buttons
// =============================================================================

// Setup
// =============================================================================

$selector   = ( isset( $selector ) && $selector != '' ) ? $selector : '';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';


// Title
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>cart_title != '' {

  .$_el<?php echo $selector; ?> .x-mini-cart-title {
    margin: $<?php echo $key_prefix; ?>cart_title_margin;
    font-family: $<?php echo $key_prefix; ?>cart_title_font_family;
    font-size: $<?php echo $key_prefix; ?>cart_title_font_size;
    font-style: $<?php echo $key_prefix; ?>cart_title_font_style;
    font-weight: $<?php echo $key_prefix; ?>cart_title_font_weight;
    line-height: $<?php echo $key_prefix; ?>cart_title_line_height;
    @unless $<?php echo $key_prefix; ?>cart_title_letter_spacing?? {
      letter-spacing: $<?php echo $key_prefix; ?>cart_title_letter_spacing;
    }
    @unless $<?php echo $key_prefix; ?>cart_title_text_align?? {
      text-align: $<?php echo $key_prefix; ?>cart_title_text_align;
    }
    @unless $<?php echo $key_prefix; ?>cart_title_text_decoration?? {
      text-decoration: $<?php echo $key_prefix; ?>cart_title_text_decoration;
    }
    @unless $<?php echo $key_prefix; ?>cart_title_text_shadow_dimensions?? {
      text-shadow: $<?php echo $key_prefix; ?>cart_title_text_shadow_dimensions $<?php echo $key_prefix; ?>cart_title_text_shadow_color;
    }
    @unless $<?php echo $key_prefix; ?>cart_title_text_transform?? {
      text-transform: $<?php echo $key_prefix; ?>cart_title_text_transform;
    }
    color: $<?php echo $key_prefix; ?>cart_title_text_color;
  }

}

.$_el<?php echo $selector; ?> .x-mini-cart li.empty {
  line-height: $<?php echo $key_prefix; ?>cart_links_line_height;
  @unless $<?php echo $key_prefix; ?>cart_title_text_align?? {
    text-align: $<?php echo $key_prefix; ?>cart_title_text_align;
  }
  color: $<?php echo $key_prefix; ?>cart_links_text_color;
}



<?php

// Items
// =============================================================================

?>

.$_el<?php echo $selector; ?> .cart_list {
  order: $<?php echo $key_prefix; ?>cart_order_items;
}

.$_el<?php echo $selector; ?> .mini_cart_item {
  @unless $<?php echo $key_prefix; ?>cart_items_margin?? {
    margin: $<?php echo $key_prefix; ?>cart_items_margin;
  }
  @unless $<?php echo $key_prefix; ?>cart_items_border_width?? || $<?php echo $key_prefix; ?>cart_items_border_style?? {
    border-width: $<?php echo $key_prefix; ?>cart_items_border_width;
    border-style: $<?php echo $key_prefix; ?>cart_items_border_style;
    border-color: $<?php echo $key_prefix; ?>cart_items_border_color;
  }
  @unless $<?php echo $key_prefix; ?>cart_items_border_radius?? {
    border-radius: $<?php echo $key_prefix; ?>cart_items_border_radius;
  }
  @unless $<?php echo $key_prefix; ?>cart_items_padding?? {
    padding: $<?php echo $key_prefix; ?>cart_items_padding;
  }
  @unless $<?php echo $key_prefix; ?>cart_items_bg === 'transparent' {
    background-color: $<?php echo $key_prefix; ?>cart_items_bg;
  }
  @unless $<?php echo $key_prefix; ?>cart_items_box_shadow_dimensions?? {
    box-shadow: $<?php echo $key_prefix; ?>cart_items_box_shadow_dimensions $<?php echo $key_prefix; ?>cart_items_box_shadow_color;
  }
}

.$_el<?php echo $selector; ?> .mini_cart_item:hover {
  @unless $<?php echo $key_prefix; ?>cart_items_border_width?? || $<?php echo $key_prefix; ?>cart_items_border_style?? {
    border-color: $<?php echo $key_prefix; ?>cart_items_border_color_alt;
  }
  background-color: $<?php echo $key_prefix; ?>cart_items_bg_alt;
  @unless $<?php echo $key_prefix; ?>cart_items_box_shadow_dimensions?? {
    box-shadow: $<?php echo $key_prefix; ?>cart_items_box_shadow_dimensions $<?php echo $key_prefix; ?>cart_items_box_shadow_color_alt;
  }
}

@if $<?php echo $key_prefix; ?>cart_items_display_remove == false {
  .$_el<?php echo $selector; ?> .mini_cart_item .remove {
    display: none !important;
    visibility: hidden !important;
  }
}



<?php

// Thumbnails
// =============================================================================

?>

.$_el<?php echo $selector; ?> .mini_cart_item img {
  width: $<?php echo $key_prefix; ?>cart_thumbs_width;
  margin-right: $<?php echo $key_prefix; ?>cart_items_content_spacing;
  @unless $<?php echo $key_prefix; ?>cart_thumbs_border_radius?? {
    border-radius: $<?php echo $key_prefix; ?>cart_thumbs_border_radius;
  }
  @unless $<?php echo $key_prefix; ?>cart_thumbs_box_shadow_dimensions?? {
    box-shadow: $<?php echo $key_prefix; ?>cart_thumbs_box_shadow_dimensions $<?php echo $key_prefix; ?>cart_thumbs_box_shadow_color;
  }
}

.rtl .$_el<?php echo $selector; ?> .mini_cart_item img {
  margin-left: $<?php echo $key_prefix; ?>cart_items_content_spacing;
  margin-right: 0;
}



<?php

// Links
// =============================================================================

?>

.$_el<?php echo $selector; ?> .mini_cart_item a {
  font-family: $<?php echo $key_prefix; ?>cart_links_font_family;
  font-size: $<?php echo $key_prefix; ?>cart_links_font_size;
  font-style: $<?php echo $key_prefix; ?>cart_links_font_style;
  font-weight: $<?php echo $key_prefix; ?>cart_links_font_weight;
  line-height: $<?php echo $key_prefix; ?>cart_links_line_height;
  @unless $<?php echo $key_prefix; ?>cart_links_letter_spacing?? {
    letter-spacing: $<?php echo $key_prefix; ?>cart_links_letter_spacing;
  }
  @unless $<?php echo $key_prefix; ?>cart_links_text_align?? {
    text-align: $<?php echo $key_prefix; ?>cart_links_text_align;
  }
  @unless $<?php echo $key_prefix; ?>cart_links_text_decoration?? {
    text-decoration: $<?php echo $key_prefix; ?>cart_links_text_decoration;
  }
  @unless $<?php echo $key_prefix; ?>cart_links_text_shadow_dimensions?? {
    text-shadow: $<?php echo $key_prefix; ?>cart_links_text_shadow_dimensions $<?php echo $key_prefix; ?>cart_links_text_shadow_color;
  }
  @unless $<?php echo $key_prefix; ?>cart_links_text_transform?? {
    text-transform: $<?php echo $key_prefix; ?>cart_links_text_transform;
  }
  color: $<?php echo $key_prefix; ?>cart_links_text_color;
}

.$_el<?php echo $selector; ?> .mini_cart_item a:hover,
.$_el<?php echo $selector; ?> .mini_cart_item a:focus {
  color: $<?php echo $key_prefix; ?>cart_links_text_color_alt;
  @unless $<?php echo $key_prefix; ?>cart_links_text_shadow_dimensions?? {
    text-shadow: $<?php echo $key_prefix; ?>cart_links_text_shadow_dimensions $<?php echo $key_prefix; ?>cart_links_text_shadow_color_alt;
  }
}

.$_el<?php echo $selector; ?> .mini_cart_item .remove {
  width: calc(1em * $<?php echo $key_prefix; ?>cart_links_line_height);
  margin-left: $<?php echo $key_prefix; ?>cart_items_content_spacing;
}

.rtl .$_el<?php echo $selector; ?> .mini_cart_item .remove {
  margin-left: 0;
  margin-right: $<?php echo $key_prefix; ?>cart_items_content_spacing;
}



<?php

// Quantity
// =============================================================================

?>

.$_el<?php echo $selector; ?> .mini_cart_item .quantity {
  font-family: $<?php echo $key_prefix; ?>cart_quantity_font_family;
  font-size: $<?php echo $key_prefix; ?>cart_quantity_font_size;
  font-style: $<?php echo $key_prefix; ?>cart_quantity_font_style;
  font-weight: $<?php echo $key_prefix; ?>cart_quantity_font_weight;
  line-height: $<?php echo $key_prefix; ?>cart_quantity_line_height;
  @unless $<?php echo $key_prefix; ?>cart_quantity_letter_spacing?? {
    letter-spacing: $<?php echo $key_prefix; ?>cart_quantity_letter_spacing;
  }
  @unless $<?php echo $key_prefix; ?>cart_quantity_text_align?? {
    text-align: $<?php echo $key_prefix; ?>cart_quantity_text_align;
  }
  @unless $<?php echo $key_prefix; ?>cart_quantity_text_decoration?? {
    text-decoration: $<?php echo $key_prefix; ?>cart_quantity_text_decoration;
  }
  @unless $<?php echo $key_prefix; ?>cart_quantity_text_shadow_dimensions?? {
    text-shadow: $<?php echo $key_prefix; ?>cart_quantity_text_shadow_dimensions $<?php echo $key_prefix; ?>cart_quantity_text_shadow_color;
  }
  @unless $<?php echo $key_prefix; ?>cart_quantity_text_transform?? {
    text-transform: $<?php echo $key_prefix; ?>cart_quantity_text_transform;
  }
  color: $<?php echo $key_prefix; ?>cart_quantity_text_color;
}



<?php

// Total
// =============================================================================

?>

.$_el<?php echo $selector; ?> .x-mini-cart .total {
  order: $<?php echo $key_prefix; ?>cart_order_total;
  margin: $<?php echo $key_prefix; ?>cart_total_margin;
  @unless $<?php echo $key_prefix; ?>cart_total_border_width?? || $<?php echo $key_prefix; ?>cart_total_border_style?? {
    border-width: $<?php echo $key_prefix; ?>cart_total_border_width;
    border-style: $<?php echo $key_prefix; ?>cart_total_border_style;
    border-color: $<?php echo $key_prefix; ?>cart_total_border_color;
  }
  @unless $<?php echo $key_prefix; ?>cart_total_border_radius?? {
    border-radius: $<?php echo $key_prefix; ?>cart_total_border_radius;
  }
  padding: $<?php echo $key_prefix; ?>cart_total_padding;
  font-family: $<?php echo $key_prefix; ?>cart_total_font_family;
  font-size: $<?php echo $key_prefix; ?>cart_total_font_size;
  font-style: $<?php echo $key_prefix; ?>cart_total_font_style;
  font-weight: $<?php echo $key_prefix; ?>cart_total_font_weight;
  line-height: $<?php echo $key_prefix; ?>cart_total_line_height;
  @unless $<?php echo $key_prefix; ?>cart_total_letter_spacing?? {
    letter-spacing: $<?php echo $key_prefix; ?>cart_total_letter_spacing;
  }
  @unless $<?php echo $key_prefix; ?>cart_total_text_align?? {
    text-align: $<?php echo $key_prefix; ?>cart_total_text_align;
  }
  @unless $<?php echo $key_prefix; ?>cart_total_text_decoration?? {
    text-decoration: $<?php echo $key_prefix; ?>cart_total_text_decoration;
  }
  @unless $<?php echo $key_prefix; ?>cart_total_text_shadow_dimensions?? {
    text-shadow: $<?php echo $key_prefix; ?>cart_total_text_shadow_dimensions $<?php echo $key_prefix; ?>cart_total_text_shadow_color;
  }
  @unless $<?php echo $key_prefix; ?>cart_total_text_transform?? {
    text-transform: $<?php echo $key_prefix; ?>cart_total_text_transform;
  }
  color: $<?php echo $key_prefix; ?>cart_total_text_color;
  @unless $<?php echo $key_prefix; ?>cart_total_bg === 'transparent' {
    background-color: $<?php echo $key_prefix; ?>cart_total_bg;
  }
  @unless $<?php echo $key_prefix; ?>cart_total_box_shadow_dimensions?? {
    box-shadow: $<?php echo $key_prefix; ?>cart_total_box_shadow_dimensions $<?php echo $key_prefix; ?>cart_total_box_shadow_color;
  }
}



<?php

// Buttons
// =============================================================================

?>

.$_el<?php echo $selector; ?> .x-mini-cart .buttons {
  order: $<?php echo $key_prefix; ?>cart_order_buttons;
  justify-content: $<?php echo $key_prefix; ?>cart_buttons_justify_content;
  margin: $<?php echo $key_prefix; ?>cart_buttons_margin;
  @unless $<?php echo $key_prefix; ?>cart_buttons_border_width?? || $<?php echo $key_prefix; ?>cart_buttons_border_style?? {
    border-width: $<?php echo $key_prefix; ?>cart_buttons_border_width;
    border-style: $<?php echo $key_prefix; ?>cart_buttons_border_style;
    border-color: $<?php echo $key_prefix; ?>cart_buttons_border_color;
  }
  @unless $<?php echo $key_prefix; ?>cart_buttons_border_radius?? {
    border-radius: $<?php echo $key_prefix; ?>cart_buttons_border_radius;
  }
  padding: $<?php echo $key_prefix; ?>cart_buttons_padding;
  @unless $<?php echo $key_prefix; ?>cart_buttons_bg === 'transparent' {
    background-color: $<?php echo $key_prefix; ?>cart_buttons_bg;
  }
  @unless $<?php echo $key_prefix; ?>cart_buttons_box_shadow_dimensions?? {
    box-shadow: $<?php echo $key_prefix; ?>cart_buttons_box_shadow_dimensions $<?php echo $key_prefix; ?>cart_buttons_box_shadow_color;
  }
}
