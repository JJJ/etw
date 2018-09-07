<?php

// =============================================================================
// VIEWS/PARTIALS/MENU.PHP
// -----------------------------------------------------------------------------
// Menu partial.
// =============================================================================

$mod_id           = ( isset( $mod_id )       ) ? $mod_id       : '';
$menu_type        = ( isset( $menu_type )    ) ? $menu_type    : 'inline';
$menu_data_walker = ( isset( $_custom_data ) ) ? $_custom_data : array();

$menu_is_collapsed = $menu_type === 'collapsed';
$menu_is_dropdown  = $menu_type === 'dropdown';
$menu_is_inline    = $menu_type === 'inline';
$menu_is_modal     = $menu_type === 'modal';
$menu_is_layered   = $menu_type === 'layered';

$menu_is_collapsed_tbf     = $menu_is_collapsed && ( $_region === 'top' || $_region === 'bottom' || $_region === 'footer' );
$menu_is_collapsed_not_tbf = $menu_is_collapsed && ! ( $_region === 'top' || $_region === 'bottom' || $_region === 'footer' );
$menu_is_layered_tbf       = $menu_is_layered && ( $_region === 'top' || $_region === 'bottom' || $_region === 'footer' );
$menu_is_layered_not_tbf   = $menu_is_layered && ! ( $_region === 'top' || $_region === 'bottom' || $_region === 'footer' );


// Atts
// ----

$atts = array();

if ( isset( $id ) && ! empty( $id ) ) {
  if ( $menu_is_collapsed_not_tbf || $menu_is_layered_not_tbf || $menu_is_inline ) {
    $atts['id'] = $id;
  } else if ( $menu_is_dropdown ) {
    $atts['id'] = $id . '-dropdown';
  }
} else {
  if ( $menu_is_dropdown ) {
    $atts['id'] = $mod_id . '-dropdown';
  }
}

$atts['class'] = '%2$s';

if ( $menu_is_dropdown ) {
  $atts['aria-hidden'] = 'true';
}


// Notes: "data-x-stem-top" Attribute
// ----------------------------------
// This "data-x-stem-top" logic is implemented in the bars helper.php
// file for "inline" navigation and in the menu partial for "dropdown"
// navigation as their first dropdown is contextually different (e.g.
// the first dropdown for "inline" navigation is at $depth === 0 in the
// helper walker, but the first dropdown for "dropdown" navigation is the
// menu partial itself (these notes duplicated in both spots).
//
// "r" to reverse direction
// "h" to begin flowing horizontally

if ( $menu_is_dropdown ) {
  $atts['class']            .= ' x-dropdown';
  $atts['data-x-stem']       = NULL;
  $atts['data-x-stem-top']   = NULL;
  $atts['data-x-toggleable'] = $mod_id;

  if ( $_region === 'left' ) {
    $atts['data-x-stem-top'] = 'h';
  }

  if ( $_region === 'right' ) {
    $atts['data-x-stem-top'] = 'rh';
  }
}


// Notes: "data-x-toggle-layered-root" Attribute
// -------------------------------------------------
// Defines the root level element for `data-x-toggle="layered"` elements so
// that their toggling mechanism can work properly.

if ( $menu_is_modal || $menu_is_layered ) {
  $atts['data-x-toggle-layered-root'] = true;
}


// Prepare Arg Values
// ------------------

if ( $menu_is_collapsed_tbf || $menu_is_layered_tbf || $menu_is_modal ) {
  $class = '';
}

$classes = array( $mod_id, 'x-menu', 'x-menu-' . $menu_type, $class );

if ( $menu_is_modal ) {
  $classes[] = 'x-menu-layered';
}

if ( $menu_is_modal || $menu_is_layered ) {
  $classes[] = 'x-current-layer';
}

$classes    = x_attr_class( $classes );
$items_wrap = '<ul ' . x_atts( $atts ) . '>%3$s</ul>';
$walker     = new X_Walker_Nav_Menu( $menu_data_walker );


// Args
// ----

$args = array(
  'menu_class'  => $classes,
  'container'   => false,
  'items_wrap'  => $items_wrap,
  'walker'      => $walker,
  'fallback_cb' => 'cs_wp_nav_menu_fallback'
);

if ( 0 === strpos( $menu, 'sample:' ) ) {
  $args['sample_menu'] = str_replace( 'sample:', '', $menu );
}

if ( 0 === strpos( $menu, 'menu:' ) ) {
  $args['menu'] = str_replace( 'menu:', '', $menu );
}

if ( 0 === strpos( $menu, 'location:' ) ) {
  $args['theme_location'] = str_replace( 'location:', '', $menu );
}


// Output
// ------

wp_nav_menu( $args );
