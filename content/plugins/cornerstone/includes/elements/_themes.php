<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/_THEMES.PHP
// -----------------------------------------------------------------------------
// Bar module themes includes.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Button: Default
//   02. Toggle: Default
//   03. Social: Default
//   04. Menu Item Modal: Default
//   05. Menu Item Dropdown: Default
//   06. Menu Item Collapsed (Top): Default
//   07. Menu Item Collapsed (Sub): Default
//   08. Menu Item Inline (Top): Default
//   09. Menu Item Inline (Sub): Default
//   10. Cart Button: Default
//   11. Cart Toggle: Default
//   12. Search Dropdown: Default
// =============================================================================

// Button: Default
// =============================================================================

function x_module_theme_button_default() {
  return array(
    'anchor_bg_color'              => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'anchor_bg_color_alt'          => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'anchor_border_radius'         => x_module_value( '0.35em', 'style' ),
    'anchor_box_shadow_dimensions' => x_module_value( '0em 0.15em 0.65em 0em', 'style' ),
    'anchor_box_shadow_color'      => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'anchor_box_shadow_color_alt'  => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
  );
}



// Toggle: Default
// =============================================================================

function x_module_theme_toggle_default() {
  return array(
    'anchor_width'                  => x_module_value( '2.75em', 'style' ),
    'anchor_height'                 => x_module_value( '2.75em', 'style' ),
    'anchor_bg_color'               => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'anchor_bg_color_alt'           => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'anchor_padding'                => x_module_value( '0em', 'style' ),
    'anchor_border_radius'          => x_module_value( '100em', 'style' ),
    'anchor_box_shadow_dimensions'  => x_module_value( '0em 0.15em 0.65em 0em', 'style' ),
    'anchor_box_shadow_color'       => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'anchor_box_shadow_color_alt'   => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'anchor_text'                   => x_module_value( false, 'all' ),
    'anchor_graphic'                => x_module_value( true, 'all' ),
    'anchor_graphic_type'           => x_module_value( 'toggle', 'all' ),
    'anchor_text_primary_content'   => x_module_value( '', 'all' ),
    'anchor_text_secondary_content' => x_module_value( '', 'all' ),
  );
}



// Social: Default
// =============================================================================

function x_module_theme_social_default() {
  return array(
    'anchor_width'                  => x_module_value( '2.75em', 'style' ),
    'anchor_height'                 => x_module_value( '2.75em', 'style' ),
    'anchor_bg_color'               => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'anchor_bg_color_alt'           => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'anchor_padding'                => x_module_value( '0em', 'style' ),
    'anchor_border_radius'          => x_module_value( '100em', 'style' ),
    'anchor_box_shadow_dimensions'  => x_module_value( '0em 0.15em 0.65em 0em', 'style' ),
    'anchor_box_shadow_color'       => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'anchor_box_shadow_color_alt'   => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'anchor_text'                   => x_module_value( false, 'all' ),
    'anchor_graphic'                => x_module_value( true, 'all' ),
    'anchor_graphic_type'           => x_module_value( 'icon', 'all' ),
    'anchor_graphic_icon_color_alt' => x_module_value( '#3b5998', 'style:color' ),
    'anchor_text_primary_content'   => x_module_value( '', 'all' ),
    'anchor_text_secondary_content' => x_module_value( '', 'all' ),
    'anchor_graphic_icon'           => x_module_value( 'facebook-official', 'markup' ),
    'anchor_graphic_icon_alt'       => x_module_value( 'facebook-official', 'markup' ),
  );
}



// Menu Item Modal: Default
// =============================================================================

function x_module_theme_menu_item_modal_default() {
  return array(
    'anchor_padding'       => x_module_value( '0.75em', 'style' ),
    'anchor_sub_indicator' => x_module_value( false, 'all' ),
  );
}



// Menu Item Dropdown: Default
// =============================================================================

function x_module_theme_menu_item_dropdown_default() {
  return array(
    'anchor_padding'     => x_module_value( '0.75em', 'style' ),
    'anchor_text_margin' => x_module_value( '5px auto 5px 5px', 'style' ),
  );
}



// Menu Item Collapsed (Top): Default
// =============================================================================

function x_module_theme_menu_item_collapsed_top_default() {
  return array(
    'anchor_padding'     => x_module_value( '0.75em', 'style' ),
    'anchor_text_margin' => x_module_value( '5px auto 5px 5px', 'style' ),
  );
}



// Menu Item Collapsed (Sub): Default
// =============================================================================

function x_module_theme_menu_item_collapsed_sub_default() {
  return array(
    'anchor_padding'     => x_module_value( '0.75em', 'style' ),
    'anchor_text_margin' => x_module_value( '5px auto 5px 5px', 'style' ),
  );
}



// Menu Item Inline (Top): Default
// =============================================================================

function x_module_theme_menu_item_inline_top_default() {
  return array(
    'anchor_padding' => x_module_value( '0.75em', 'style' ),
  );
}



// Menu Item Inline (Sub): Default
// =============================================================================

function x_module_theme_menu_item_inline_sub_default() {
  return array(
    'anchor_padding'     => x_module_value( '0.75em', 'style' ),
    'anchor_text_margin' => x_module_value( '5px auto 5px 5px', 'style' ),
  );
}



// Cart Button: Default
// =============================================================================

function x_module_theme_cart_button_default() {
  return array(

    'anchor_base_font_size'                 => x_module_value( '0.75em', 'style' ),
    'anchor_width'                          => x_module_value( '47.5%', 'style' ),
    'anchor_max_width'                      => x_module_value( 'none', 'style' ),
    'anchor_height'                         => x_module_value( 'auto', 'style' ),
    'anchor_max_height'                     => x_module_value( 'none', 'style' ),
    'anchor_bg_color'                       => x_module_value( '#f5f5f5', 'style:color' ),
    'anchor_bg_color_alt'                   => x_module_value( '#f5f5f5', 'style:color' ),

    'anchor_primary_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
    'anchor_primary_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
    'anchor_primary_font_size'              => x_module_value( '1em', 'style' ),
    'anchor_primary_letter_spacing'         => x_module_value( '0.15em', 'style' ),
    'anchor_primary_line_height'            => x_module_value( '1', 'style' ),
    'anchor_primary_font_style'             => x_module_value( 'normal', 'style' ),
    'anchor_primary_text_align'             => x_module_value( 'center', 'style' ),
    'anchor_primary_text_decoration'        => x_module_value( 'none', 'style' ),
    'anchor_primary_text_transform'         => x_module_value( 'uppercase', 'style' ),
    'anchor_primary_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_primary_text_color_alt'         => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'anchor_primary_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    'anchor_primary_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
    'anchor_primary_text_shadow_color_alt'  => x_module_value( 'transparent', 'style:color' ),

    'anchor_margin'                         => x_module_value( '0em', 'style' ),
    'anchor_padding'                        => x_module_value( '0.75em 1.25em 0.75em 1.25em', 'style' ),
    'anchor_border_width'                   => x_module_value( '1px', 'style' ),
    'anchor_border_style'                   => x_module_value( 'solid', 'style' ),
    'anchor_border_color'                   => x_module_value( 'rgba(0, 0, 0, 0.065)', 'style:color' ),
    'anchor_border_color_alt'               => x_module_value( 'rgba(0, 0, 0, 0.065)', 'style:color' ),
    'anchor_border_radius'                  => x_module_value( '0.5em', 'style' ),

    'anchor_box_shadow_dimensions'          => x_module_value( '0em 0.15em 0.5em 0em', 'style' ),
    'anchor_box_shadow_color'               => x_module_value( 'rgba(0, 0, 0, 0.05)', 'style:color' ),
    'anchor_box_shadow_color_alt'           => x_module_value( 'rgba(0, 0, 0, 0.05)', 'style:color' ),

  );
}



// Cart Toggle: Default
// =============================================================================

function x_module_theme_cart_toggle_default() {
  return array(
    'anchor_width'                   => x_module_value( '2.75em', 'style' ),
    'anchor_height'                  => x_module_value( '2.75em', 'style' ),
    'anchor_bg_color'                => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'anchor_bg_color_alt'            => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'anchor_padding'                 => x_module_value( '0em', 'style' ),
    'anchor_border_radius'           => x_module_value( '100em', 'style' ),
    'anchor_box_shadow_dimensions'   => x_module_value( '0em 0.15em 0.65em 0em', 'style' ),
    'anchor_box_shadow_color'        => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'anchor_box_shadow_color_alt'    => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'anchor_text'                    => x_module_value( false, 'all' ),
    'anchor_graphic'                 => x_module_value( true, 'all' ),
    'anchor_graphic_type'            => x_module_value( 'icon', 'all' ),
    'anchor_graphic_icon_alt_enable' => x_module_value( false, 'markup' ),
    'anchor_graphic_icon_font_size'  => x_module_value( '1em', 'style' ),
    'anchor_text_primary_content'    => x_module_value( '', 'all' ),
    'anchor_text_secondary_content'  => x_module_value( '', 'all' ),
    'anchor_graphic_icon'            => x_module_value( 'shopping-cart', 'markup' ),
    'anchor_graphic_icon_alt'        => x_module_value( 'shopping-cart', 'markup' ),
  );
}



// Dropdown Search: Default
// =============================================================================

function x_module_theme_dropdown_search_default() {
  return array(
    'search_base_font_size'        => x_module_value( '1.25em', 'style' ),
    'search_border_radius'         => x_module_value( '0em', 'style' ),
    'search_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
    'search_box_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
    'search_box_shadow_color_alt'  => x_module_value( 'transparent', 'style:color' ),
    'search_submit_margin'         => x_module_value( '0.9em 0.65em 0.9em 0.9em', 'style' ),
    'search_clear_font_size'       => x_module_value( '1em', 'style' ),
    'search_clear_width'           => x_module_value( '1em', 'style' ),
    'search_clear_height'          => x_module_value( '1em', 'style' ),
    'search_clear_color'           => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'search_clear_color_alt'       => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'search_clear_bg_color'        => x_module_value( 'transparent', 'style:color' ),
    'search_clear_bg_color_alt'    => x_module_value( 'transparent', 'style:color' ),
    'search_clear_stroke_width'    => x_module_value( '2', 'markup' ),
    'search_clear_margin'          => x_module_value( '0.9em 0.9em 0.9em 0.65em', 'style' ),
  );
}