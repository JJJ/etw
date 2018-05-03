<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/_SETTINGS.PHP
// -----------------------------------------------------------------------------
// Bar module settings includes.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Anchor
//   02. Menu
//   03. Image
//   04. Search
// =============================================================================

// Anchor
// =============================================================================

function x_bar_module_settings_anchor( $type = 'toggle', $args = array() ) {

  include_once( '_themes.php' );

  switch ( $type ) {
    case 'button' :
      $settings = array(
        'type'             => 'button',
        // 't_pre'            => __( 'Button', '__x__' ),
        'has_link_control' => true,
        'group'            => 'button_anchor',
        'group_title'      => __( 'Button', '__x__' ),
        'theme'            => x_module_theme_button_default()
      );
      break;
    case 'social' :
      $settings = array(
        'type'             => 'button',
        // 't_pre'            => __( 'Social', '__x__' ),
        'has_link_control' => true,
        'group'            => 'button_anchor',
        'group_title'      => __( 'Button', '__x__' ),
        'theme'            => x_module_theme_social_default()
      );
      break;
    case 'toggle' :
      $settings = array(
        'type'        => 'toggle',
        // 't_pre'       => __( 'Toggle', '__x__' ),
        'k_pre'       => 'toggle',
        'group'       => 'toggle_anchor',
        'group_title' => __( 'Toggle', '__x__' ),
        'theme'       => x_module_theme_toggle_default()
      );
      break;
    case 'menu-item-modal' :
      $settings = array(
        'type'        => 'menu-item',
        // 't_pre'       => __( 'Menu Items', '__x__' ),
        'group'       => 'menu_item_anchor',
        'group_title' => __( 'Links', '__x__' ),
        'is_nested'   => true,
        'theme'       => x_module_theme_menu_item_modal_default()
      );
      break;
    case 'menu-item-dropdown' :
      $settings = array(
        'type'        => 'menu-item',
        // 't_pre'       => __( 'Menu Items', '__x__' ),
        'group'       => 'menu_item_anchor',
        'group_title' => __( 'Links', '__x__' ),
        'is_nested'   => true,
        'theme'       => x_module_theme_menu_item_dropdown_default()
      );
      break;
    case 'menu-item-collapsed-top' :
      $settings = array(
        'type'        => 'menu-item',
        // 't_pre'       => __( 'Top Menu Items', '__x__' ),
        'group'       => 'top_menu_item_anchor',
        'group_title' => __( 'Top Links', '__x__' ),
        'is_nested'   => true,
        'theme'       => x_module_theme_menu_item_collapsed_top_default()
      );
      break;
    case 'menu-item-collapsed-sub' :
      $settings = array(
        'type'        => 'menu-item',
        // 't_pre'       => __( 'Sub Menu Items', '__x__' ),
        'k_pre'       => 'sub',
        'group'       => 'sub_menu_item_anchor',
        'group_title' => __( 'Sub Links', '__x__' ),
        'is_nested'   => true,
        'theme'       => x_module_theme_menu_item_collapsed_sub_default()
      );
      break;
    case 'menu-item-inline-top' :
      $settings = array(
        'type'        => 'menu-item',
        // 't_pre'       => __( 'Top Menu Items', '__x__' ),
        'group'       => 'top_menu_item_anchor',
        'group_title' => __( 'Top Links', '__x__' ),
        'is_nested'   => true,
        'theme'       => x_module_theme_menu_item_inline_top_default()
      );
      break;
    case 'menu-item-inline-sub' :
      $settings = array(
        'type'        => 'menu-item',
        // 't_pre'       => __( 'Sub Menu Items', '__x__' ),
        'k_pre'       => 'sub',
        'group'       => 'sub_menu_item_anchor',
        'group_title' => __( 'Sub Links', '__x__' ),
        'is_nested'   => true,
        'theme'       => x_module_theme_menu_item_inline_sub_default()
      );
      break;
    case 'cart-button' :
      $settings = array(
        'type'         => 'button',
        // 't_pre'        => __( 'Cart', '__x__' ),
        'k_pre'        => 'cart',
        'group'        => 'cart_button_anchor',
        'group_title'  => __( 'Cart Buttons', '__x__' ),
        'has_template' => false,
        'theme'        => x_module_theme_cart_button_default()
      );
      break;
    case 'cart-toggle' :
      $settings = array(
        'type'        => 'toggle',
        // 't_pre'       => __( 'Toggle', '__x__' ),
        'k_pre'       => 'toggle',
        'group'       => 'cart_toggle_anchor',
        'group_title' => __( 'Toggle', '__x__' ),
        'theme'       => x_module_theme_cart_toggle_default()
      );
      break;
  }

  if ( ! empty( $args ) ) {
    $settings = wp_parse_args( $args, $settings );
  }

  return $settings;

}



// Menu
// =============================================================================

function x_bar_module_settings_menu( $type = 'inline', $args = array() ) {

  $settings = array(
    'type' => $type
  );

  if ( ! empty( $args ) ) {
    $settings = wp_parse_args( $args, $settings );
  }

  return $settings;

}



// Image
// =============================================================================

function x_bar_module_settings_image( $args = array() ) {

  $settings = array(
    'is_retina' => true,
    'width'     => true,
    'height'    => true,
    'has_link'  => true,
    'alt_text'  => true
  );

  if ( ! empty( $args ) ) {
    $settings = wp_parse_args( $args, $settings );
  }

  return $settings;

}



// Search
// =============================================================================

function x_bar_module_settings_search( $type = 'inline', $args = array() ) {

  $settings = array(
    'type' => $type
  );

  if ( ! empty( $args ) ) {
    $settings = wp_parse_args( $args, $settings );
  }

  return $settings;

}