<?php

// Row
// =============================================================================

function x_shortcode_row( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'id'                 => '',
    'class'              => '',
    'style'              => '',
    'inner_container'    => '',
    'marginless_columns' => '',
    'bg_color'           => ''
  ), $atts, 'x_row' ) );

  $class              = ( $class              != ''     ) ? 'x-container ' . esc_attr( $class ) : 'x-container';
  $inner_container    = ( $inner_container    == 'true' ) ? ' max width' : '';
  $marginless_columns = ( $marginless_columns == 'true' ) ? ' marginless-columns' : '';
  $bg_color           = ( $bg_color           != ''     ) ? ' background-color:' . cornerstone_post_process_color( $bg_color ) . ';' : '';

  $atts = cs_atts( array(
    'id'    => $id,
    'class' => trim( $class . $inner_container . $marginless_columns ),
    'style' => $style . $bg_color
  ) );

  $output = "<div {$atts} >" . do_shortcode( $content ) . '</div>';

  return $output;
}

add_shortcode( 'cs_row', 'x_shortcode_row' );
add_shortcode( 'x_row', 'x_shortcode_row' );
