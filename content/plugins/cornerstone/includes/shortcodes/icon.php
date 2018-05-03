<?php

// Icon
// =============================================================================

function x_shortcode_icon( $atts ) {
  extract( shortcode_atts( array(
    'id'               => '',
    'class'            => '',
    'style'            => '',
    'type'             => '',
    'icon_color'       => '',
    'icon_size'        => '',
    'bg_color'         => '',
    'bg_size'          => '',
    'bg_border_radius' => ''
  ), $atts, 'x_icon' ) );

  $id               = ( $id               != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class            = ( $class            != '' ) ? 'x-icon ' . esc_attr( $class ) : 'x-icon';
  $style            = ( $style            != '' ) ? $style : '';
  $type             = ( $type             != '' ) ? $type : '';
  $icon_color       = ( $icon_color       != '' ) ? 'color: ' . $icon_color . ';' : '';
  $icon_size        = ( $icon_size        != '' ) ? 'font-size: ' . $icon_size . ';' : '';
  $bg_color         = ( $bg_color         != '' ) ? 'background-color: ' . $bg_color . ';' : '';
  $bg_size          = ( $bg_size          != '' ) ? 'width: ' . $bg_size . '; height: ' . $bg_size . '; line-height: ' . $bg_size . ';' : '';
  $bg_border_radius = ( $bg_border_radius != '' ) ? 'border-radius: ' . $bg_border_radius . ';' : '';

  $styles = array( $icon_color, $icon_size, $bg_color, $bg_size, $bg_border_radius, $style );
  $check  = array_diff( $styles, array( '' ) );

  if ( ! empty( $check ) ) {

    $styles_output = 'text-align: center; ';

    foreach ( $styles as $style ) {
      $styles_output .= $style . ' ';
    }

    $style = ' style="' . trim( $styles_output ) . '"';

  }

  $unicode = fa_unicode( $type );

  $output = "<i {$id} class=\"{$class} x-icon-{$type}\"{$style} data-x-icon=\"&#x{$unicode};\" aria-hidden=\"true\"></i>";

  return $output;
}

add_shortcode( 'x_icon', 'x_shortcode_icon' );