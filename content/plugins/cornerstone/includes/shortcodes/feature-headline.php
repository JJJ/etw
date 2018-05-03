<?php

// Feature Headline
// =============================================================================

function x_shortcode_feature_headline( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'id'            => '',
    'class'         => '',
    'style'         => '',
    'type'          => '',
    'level'         => '',
    'looks_like'    => '',
    'icon'          => '',
    'icon_color'    => '',
    'icon_bg_color' => ''
  ), $atts, 'x_feature_headline' ) );

  $id    = ( $id    != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class = ( $class != '' ) ? 'h-feature-headline ' . esc_attr( $class ) : 'h-feature-headline';
  $style = ( $style != '' ) ? 'style="' . $style . '"' : '';
  switch ( $type ) {
    case 'right' :
      $type = ' right-text';
      break;
    case 'center' :
      $type = ' center-text';
      break;
    default :
      $type = '';
  }
  $level      = ( $level      != '' ) ? $level : 'h2';
  $looks_like = ( $looks_like != '' ) ? ' ' . $looks_like : '';
  $icon       = ( $icon       != '' ) ? $icon : '';

  if ( $icon != '' ) {

    $icon_style = '';

    if ( $icon_color != '' ) {
      $icon_style .= "color: {$icon_color};";
    }

    if ( $icon_bg_color !=  '' ) {
      $icon_style .= "background-color: {$icon_bg_color}!important;";
    }

    if ( $icon_style != '' ) {
      $icon_style = " style=\"{$icon_style}\" ";
    }

    $unicode = fa_unicode( $icon );
    $icon    = "<i class=\"x-icon-{$icon}\" data-x-icon=\"&#x{$unicode};\"{$icon_style}></i>";

  }

  $output = "<{$level} {$id} class=\"{$class}{$type}{$looks_like}\" {$style}><span>{$icon}" . do_shortcode( $content ) . "</span></{$level}>";

  return $output;
}

add_shortcode( 'x_feature_headline', 'x_shortcode_feature_headline' );
