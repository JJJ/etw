<?php

// Callout
// =============================================================================

function x_shortcode_callout( $atts ) {
  extract( shortcode_atts( array(
    'id'          => '',
    'class'       => '',
    'style'       => '',
    'type'        => '',
    'title'       => '',
    'message'     => '',
    'button_text' => '',
    'button_icon' => '',
    'circle'      => '',
    'href'        => '',
    'href_title'  => '',
    'target'      => ''
  ), $atts, 'x_callout' ) );

  $id    = ( $id    != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class = ( $class != '' ) ? 'x-callout ' . esc_attr( $class ) : 'x-callout';
  $style = ( $style != '' ) ? 'style="' . $style . '"' : '';
  switch ( $type ) {
    case 'center' :
      $type = ' center-text';
      break;
    case 'right' :
      $type = ' right-text';
      break;
    default :
      $type = ' left-text';
  }

  $title       = ( $title       != ''      ) ? cs_decode_shortcode_attribute( $title ) : __( 'Enter Your Text', 'cornerstone' );
  $message     = ( $message     != ''      ) ? cs_decode_shortcode_attribute( $message ) : __( 'Don&apos;t forget to enter in your text.', 'cornerstone' );
  $button_text = ( $button_text != ''      ) ? cs_decode_shortcode_attribute( $button_text ) : __( 'Enter Your Text', 'cornerstone' );
  $button_icon = ( $button_icon != ''      ) ? $button_icon : '';
  $href        = ( $href        != ''      ) ? $href : '#';
  $href_title  = ( $href_title  != ''      ) ? $href_title : $button_text;
  $target      = ( $target      == 'blank' ) ? cs_output_target_blank( false ) : '';

  if ( $button_icon != '' ) {
    $icon_attr     = fa_data_icon( $button_icon );
    $button_icon = '<i class="x-icon-' . $button_icon . ' mvn mln mrs" ' . $icon_attr . '></i>';
  }

  if ( $circle == 'true' ) {
    $button = "<div class=\"x-btn-circle-wrap mbn\"><a href=\"{$href}\" class=\"x-btn x-btn-x-large\" title=\"{$href_title}\" {$target}>{$button_icon}{$button_text}</a></div>";
  } else {
    $button = "<a href=\"{$href}\" class=\"x-btn\" title=\"{$href_title}\" {$target}>{$button_icon}{$button_text}</a>";
  }

  $output = "<div {$id} class=\"{$class}{$type}\" {$style}>"
            . "<h2 class=\"h-callout\">{$title}</h2>"
            . "<p class=\"p-callout\">{$message}</p>"
            . $button
          . '</div>';

  return $output;
}

add_shortcode( 'x_callout', 'x_shortcode_callout' );
