<?php

// Icon List
// =============================================================================

function x_shortcode_icon_list( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'id'    => '',
    'class' => '',
    'style' => ''
  ), $atts, 'x_icon_list' ) );

  $id    = ( $id    != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class = ( $class != '' ) ? 'x-ul-icons ' . esc_attr( $class ) : 'x-ul-icons';
  $style = ( $style != '' ) ? 'style="' . $style . '"' : '';

  $output = "<ul {$id} class=\"{$class}\" {$style}>" . do_shortcode( $content ) . "</ul>";

  return $output;
}

add_shortcode( 'x_icon_list', 'x_shortcode_icon_list' );



// Icon List Item
// =============================================================================

function x_shortcode_icon_list_item( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'id'          => '',
    'class'       => '',
    'style'       => '',
    'type'        => '',
    'icon_color'  => '',
    'href'        => '',
    'href_title'  => '',
    'href_target' => ''
  ), $atts, 'x_icon_list_item' ) );

  $id          = ( $id          != ''      ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class       = ( $class       != ''      ) ? 'x-li-icon ' . esc_attr( $class ) : 'x-li-icon';
  $style       = ( $style       != ''      ) ? 'style="' . $style . '"' : '';
  $type        = ( $type        != ''      ) ? $type : '';
  $icon_color  = ( $icon_color  != ''      ) ? $icon_color : '';
  $href        = ( $href        != ''      ) ? $href : '#';
  $href_title  = ( $href_title  != ''      ) ? ' title="' . $href_title . '"' : '';
  $href_target = ( $href_target == 'blank' ) ? ' target="_blank"' : '';

  if ( $icon_color != '' ) {
    $icon_style = ' style="color: ' . $icon_color . ';"';
  } else {
    $icon_style = '';
  }

  if ( $href != '#' ) {
    $link_begin = "<a href=\"{$href}\"{$href_title}{$href_title}{$href_target}>";
    $link_end   = '</a>';
  } else {
    $link_begin = '';
    $link_end   = '';
  }

  $unicode = fa_unicode( $type );

  $output = "<li {$id} class=\"{$class}\" {$style}>"
            . "<i class=\"x-icon-{$type}\"{$icon_style} data-x-icon=\"&#x{$unicode};\" aria-hidden=\"true\"></i>"
            . $link_begin
              . do_shortcode( $content )
            . $link_end
          . "</li>";

  return $output;
}

add_shortcode( 'x_icon_list_item', 'x_shortcode_icon_list_item' );