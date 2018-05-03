<?php

// Google Map
// =============================================================================

function x_shortcode_google_map( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'id'           => '',
    'class'        => '',
    'style'        => '',
    'lat'          => '',
    'lng'          => '',
    'drag'         => '',
    'zoom'         => '',
    'zoom_control' => '',
    'height'       => '',
    'hue'          => '',
    'no_container' => '',
    'api_key'      => ''
  ), $atts, 'x_google_map' ) );

  static $count = 0; $count++;

  $id           = ( $id           != ''     ) ? $id : 'x-google-map-' . $count;
  $class        = ( $class        != ''     ) ? 'x-map x-google-map ' . esc_attr( $class ) : 'x-map x-google-map';
  $style        = ( $style        != ''     ) ? 'style="' . $style . '"' : '';
  $height       = ( $height       != ''     ) ? 'style="padding-bottom: ' . $height . ';"' : '';
  $no_container = ( $no_container == 'true' ) ? '' : ' with-container';

  $js_params = array(
    'lat'         => ( $lat          != ''     ) ? $lat : '40.7056308',
    'lng'         => ( $lng          != ''     ) ? $lng : '-73.9780035',
    'drag'        => ( $drag         == 'true' ),
    'zoom'        => ( $zoom         != ''     ) ? $zoom : '12',
    'zoomControl' => ( $zoom_control == 'true' ),
    'hue'         => ( $hue          != ''     ) ? $hue : '',
  );

  $data = cs_generate_data_attributes( 'google_map', $js_params );

  $script_url = 'https://maps.googleapis.com/maps/api/js?v=3';

  if ( $api_key ) {
    $api_key = esc_attr( $api_key );
    $script_url = add_query_arg( array( 'key' => $api_key ), $script_url );
  }

  wp_register_script( 'x-google-map', $script_url );
  wp_enqueue_script( 'x-google-map' );

  $output = "<div id=\"{$id}\" class=\"{$class}{$no_container}\" {$data} {$style}><div class=\"x-map-inner x-google-map-inner\" {$height}></div>" . do_shortcode( $content ) . "</div>";

  return $output;
}

add_shortcode( 'x_google_map', 'x_shortcode_google_map' );



// Google Map Marker
// =============================================================================

function x_shortcode_google_map_marker( $atts ) {
  extract( shortcode_atts( array(
    'lat'   => '',
    'lng'   => '',
    'info'  => '',
    'image' => '',
    'start_open' => 'false',
  ), $atts, 'x_google_map_marker' ) );

  $js_params = array(
    'lat'        => ( $lat   != '' ) ? $lat : '40.7056308',
    'lng'        => ( $lng   != '' ) ? $lng : '-73.9780035',
    'markerInfo' => ( $info  != '' ) ? cs_decode_shortcode_attribute( $info ) : '',
    'startOpen' => ( 'true' == $start_open )
  );

  if ( is_numeric( $image ) ) {
    $image_info         = wp_get_attachment_image_src( $image, 'full' );
    $js_params['image'] = $image_info[0];
  } else if ( $image != '' ) {
    $js_params['image'] = $image;
  }

  $data = cs_generate_data_attributes( 'google_map_marker', $js_params );

  $output = "<div class=\"x-google-map-marker\" style=\"position: absolute; visibility: hidden;\" {$data}></div>";

  return $output;
}

add_shortcode( 'x_google_map_marker', 'x_shortcode_google_map_marker' );
