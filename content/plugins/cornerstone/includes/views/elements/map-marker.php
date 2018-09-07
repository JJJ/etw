<?php

// =============================================================================
// VIEWS/BARS/MAP-MARKER.PHP
// -----------------------------------------------------------------------------
// Map marker element.
// =============================================================================

// Prepare Atts
// ------------

$atts = array(
  'style' => 'position: absolute; visibility: hidden;',
);

$data = array(
  'lat'          => floatval( $map_marker_lat ),
  'lng'          => floatval( $map_marker_lng ),
  'content'      => cs_decode_shortcode_attribute( $map_marker_content ),
  'contentStart' => $map_marker_content_start,
);

if ( $map_marker_image_src !== '' ) {
  $data = array_merge( $data, array(
    'imageSrc'     => $map_marker_image_src,
    'imageWidth'   => $map_marker_image_width,
    'imageHeight'  => $map_marker_image_height,
    'imageRetina'  => $map_marker_image_retina,
    'imageOffsetX' => floatval( $map_marker_offset_x ),
    'imageOffsetY' => floatval( $map_marker_offset_y ),
  ) );
}

$atts = array_merge( $atts, cs_element_js_atts( 'map_google_marker', $data ) );

?>

<div <?php echo x_atts( $atts ); ?>></div>
