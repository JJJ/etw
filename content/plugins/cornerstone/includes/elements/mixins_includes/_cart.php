<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_CART.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls: Advanced
//   02. Controls: Standard (Content)
//   03. Controls: Standard (Design - Colors)
//   04. Control Groups
//   05. Values
// =============================================================================

// Controls: Advanced
// =============================================================================

function x_controls_cart_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_cart.php' );

  $controls = array_merge(

    $control_group_cart_adv_setup,

    x_control_text_format( $settings_cart_title ),
    x_control_text_style( $settings_cart_title ),
    x_control_text_shadow( $settings_cart_title ),
    x_control_margin( $settings_cart_title ),

    $control_group_cart_adv_items_setup,
    x_control_margin( $settings_cart_items ),
    x_control_padding( $settings_cart_items ),
    x_control_border( $settings_cart_items_with_color ),
    x_control_border_radius( $settings_cart_items ),
    x_control_box_shadow( $settings_cart_items_with_color ),

    $control_group_cart_adv_items_thumbnail_setup,
    x_control_border_radius( $settings_cart_thumbs ),
    x_control_box_shadow( $settings_cart_thumbs ),

    x_control_text_format( $settings_cart_links ),
    x_control_text_style( $settings_cart_links_with_color ),
    x_control_text_shadow( $settings_cart_links_with_color ),

    x_control_text_format( $settings_cart_quantity ),
    x_control_text_style( $settings_cart_quantity ),
    x_control_text_shadow( $settings_cart_quantity ),

    $control_group_cart_adv_total_setup,
    x_control_text_format( $settings_cart_total ),
    x_control_text_style( $settings_cart_total ),
    x_control_text_shadow( $settings_cart_total ),
    x_control_margin( $settings_cart_total ),
    x_control_padding( $settings_cart_total ),
    x_control_border( $settings_cart_total ),
    x_control_border_radius( $settings_cart_total ),
    x_control_box_shadow( $settings_cart_total ),

    $control_group_cart_adv_buttons_container_setup,
    x_control_margin( $settings_cart_buttons ),
    x_control_padding( $settings_cart_buttons ),
    x_control_border( $settings_cart_buttons ),
    x_control_border_radius( $settings_cart_buttons ),
    x_control_box_shadow( $settings_cart_buttons )
  );

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_cart_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_cart.php' );

  $controls = $control_group_cart_std_content_setup;

  return $controls;

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_cart_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_cart.php' );

  $controls = $control_group_cart_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_cart( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_cart.php' );

  $control_groups = array(
    $group              => array( 'title' => $group_title ),
    $group_cart_setup   => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_cart_title   => array( 'title' => __( 'Title', '__x__' ) ),
    $group_cart_items   => array( 'title' => __( 'Items', '__x__' ) ),
    $group_cart_total   => array( 'title' => __( 'Total', '__x__' ) ),
    $group_cart_buttons => array( 'title' => __( 'Buttons Container', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_cart( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_cart.php' );


  // Values
  // ------

  $values = array(

    'cart_title'                           => x_module_value( __( 'Your Items', '__x__' ), 'all', true ),
    'cart_order_items'                     => x_module_value( '1', 'style' ),
    'cart_order_total'                     => x_module_value( '2', 'style' ),
    'cart_order_buttons'                   => x_module_value( '3', 'style' ),

    'cart_title_font_family'               => x_module_value( 'inherit', 'style:font-family' ),
    'cart_title_font_weight'               => x_module_value( 'inherit:400', 'style:font-weight' ),
    'cart_title_font_size'                 => x_module_value( '2em', 'style' ),
    'cart_title_letter_spacing'            => x_module_value( '-0.035em', 'style' ),
    'cart_title_line_height'               => x_module_value( '1.1', 'style' ),
    'cart_title_font_style'                => x_module_value( 'normal', 'style' ),
    'cart_title_text_align'                => x_module_value( 'none', 'style' ),
    'cart_title_text_decoration'           => x_module_value( 'none', 'style' ),
    'cart_title_text_transform'            => x_module_value( 'none', 'style' ),
    'cart_title_text_color'                => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'cart_title_text_shadow_dimensions'    => x_module_value( '0px 0px 0px', 'style' ),
    'cart_title_text_shadow_color'         => x_module_value( 'transparent', 'style:color' ),
    'cart_title_margin'                    => x_module_value( '0px 0px 15px 0px', 'style' ),

    'cart_items_display_remove'            => x_module_value( true, 'style' ),
    'cart_items_content_spacing'           => x_module_value( '15px', 'style' ),
    'cart_items_bg'                        => x_module_value( 'transparent', 'style:color' ),
    'cart_items_bg_alt'                    => x_module_value( 'transparent', 'style:color' ),
    'cart_items_margin'                    => x_module_value( '0px', 'style' ),
    'cart_items_padding'                   => x_module_value( '15px 0px 15px 0px', 'style' ),
    'cart_items_border_width'              => x_module_value( '1px 0px 0px 0px', 'style' ),
    'cart_items_border_style'              => x_module_value( 'solid', 'style' ),
    'cart_items_border_color'              => x_module_value( 'rgba(0, 0, 0, 0.065) transparent transparent transparent', 'style:color' ),
    'cart_items_border_color_alt'          => x_module_value( 'rgba(0, 0, 0, 0.065) transparent transparent transparent', 'style:color' ),
    'cart_items_border_radius'             => x_module_value( '0px', 'style' ),
    'cart_items_box_shadow_dimensions'     => x_module_value( '0em 0em 0em 0em', 'style' ),
    'cart_items_box_shadow_color'          => x_module_value( 'transparent', 'style:color' ),
    'cart_items_box_shadow_color_alt'      => x_module_value( 'transparent', 'style:color' ),

    'cart_thumbs_width'                    => x_module_value( '70px', 'style' ),
    'cart_thumbs_border_radius'            => x_module_value( '5px', 'style' ),
    'cart_thumbs_box_shadow_dimensions'    => x_module_value( '0em 0.15em 1em 0em', 'style' ),
    'cart_thumbs_box_shadow_color'         => x_module_value( 'rgba(0, 0, 0, 0.05)', 'style:color' ),

    'cart_links_font_family'               => x_module_value( 'inherit', 'style:font-family' ),
    'cart_links_font_weight'               => x_module_value( 'inherit:400', 'style:font-weight' ),
    'cart_links_font_size'                 => x_module_value( '1em', 'style' ),
    'cart_links_letter_spacing'            => x_module_value( '0em', 'style' ),
    'cart_links_line_height'               => x_module_value( '1.4', 'style' ),
    'cart_links_font_style'                => x_module_value( 'normal', 'style' ),
    'cart_links_text_align'                => x_module_value( 'none', 'style' ),
    'cart_links_text_decoration'           => x_module_value( 'none', 'style' ),
    'cart_links_text_transform'            => x_module_value( 'none', 'style' ),
    'cart_links_text_color'                => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'cart_links_text_color_alt'            => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'cart_links_text_shadow_dimensions'    => x_module_value( '0px 0px 0px', 'style' ),
    'cart_links_text_shadow_color'         => x_module_value( 'transparent', 'style:color' ),
    'cart_links_text_shadow_color_alt'     => x_module_value( 'transparent', 'style:color' ),

    'cart_quantity_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
    'cart_quantity_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
    'cart_quantity_font_size'              => x_module_value( '0.85em', 'style' ),
    'cart_quantity_letter_spacing'         => x_module_value( '0em', 'style' ),
    'cart_quantity_line_height'            => x_module_value( '1.9', 'style' ),
    'cart_quantity_font_style'             => x_module_value( 'normal', 'style' ),
    'cart_quantity_text_align'             => x_module_value( 'none', 'style' ),
    'cart_quantity_text_decoration'        => x_module_value( 'none', 'style' ),
    'cart_quantity_text_transform'         => x_module_value( 'none', 'style' ),
    'cart_quantity_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'cart_quantity_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    'cart_quantity_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),

    'cart_total_bg'                        => x_module_value( 'transparent', 'style:color' ),
    'cart_total_font_family'               => x_module_value( 'inherit', 'style:font-family' ),
    'cart_total_font_weight'               => x_module_value( 'inherit:400', 'style:font-weight' ),
    'cart_total_font_size'                 => x_module_value( '1em', 'style' ),
    'cart_total_letter_spacing'            => x_module_value( '0em', 'style' ),
    'cart_total_line_height'               => x_module_value( '1', 'style' ),
    'cart_total_font_style'                => x_module_value( 'normal', 'style' ),
    'cart_total_text_align'                => x_module_value( 'center', 'style' ),
    'cart_total_text_decoration'           => x_module_value( 'none', 'style' ),
    'cart_total_text_transform'            => x_module_value( 'none', 'style' ),
    'cart_total_text_color'                => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'cart_total_text_shadow_dimensions'    => x_module_value( '0px 0px 0px', 'style' ),
    'cart_total_text_shadow_color'         => x_module_value( 'transparent', 'style:color' ),
    'cart_total_margin'                    => x_module_value( '0px', 'style' ),
    'cart_total_padding'                   => x_module_value( '10px 0px 10px 0px', 'style' ),
    'cart_total_border_width'              => x_module_value( '1px 0px 1px 0px', 'style' ),
    'cart_total_border_style'              => x_module_value( 'solid', 'style' ),
    'cart_total_border_color'              => x_module_value( 'rgba(0, 0, 0, 0.065) transparent rgba(0, 0, 0, 0.065) transparent', 'style:color' ),
    'cart_total_border_radius'             => x_module_value( '0px', 'style' ),
    'cart_total_box_shadow_dimensions'     => x_module_value( '0em 0em 0em 0em', 'style' ),
    'cart_total_box_shadow_color'          => x_module_value( 'transparent', 'style:color' ),

    'cart_buttons_justify_content'         => x_module_value( 'space-between', 'style' ),
    'cart_buttons_bg'                      => x_module_value( 'transparent', 'style:color' ),
    'cart_buttons_margin'                  => x_module_value( '15px 0px 0px 0px', 'style' ),
    'cart_buttons_padding'                 => x_module_value( '0px', 'style' ),
    'cart_buttons_border_width'            => x_module_value( '0px', 'style' ),
    'cart_buttons_border_style'            => x_module_value( 'solid', 'style' ),
    'cart_buttons_border_color'            => x_module_value( 'transparent', 'style:color' ),
    'cart_buttons_border_radius'           => x_module_value( '0px', 'style' ),
    'cart_buttons_box_shadow_dimensions'   => x_module_value( '0em 0em 0em 0em', 'style' ),
    'cart_buttons_box_shadow_color'        => x_module_value( 'transparent', 'style:color' ),

  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
