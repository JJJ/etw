<?php

// =============================================================================
// VIEWS/PARTIALS/MAP.PHP
// -----------------------------------------------------------------------------
// Map partial.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';


// Prepare Attr Values
// -------------------

$classes = array( $mod_id, 'x-map', 'x-map-' . $map_type, $class );


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( $classes ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Content
// -------

$map_content = '';

switch ( $map_type ) {

  // Embed
  // -----

  case 'embed' :
    $map_content = ( ! empty( $map_embed_code ) ) ? $map_embed_code : '<img style="object-fit: cover; width: 100%; height: 100%;" src="' . cornerstone_make_placeholder_image_uri( 1, 1, 'rgba(0, 0, 0, 0.35)' ) . '" width="1" height="1" alt="Placeholder">';
    break;


  // Google
  // ------
  // 01. Setup and enqueue Google Maps API script.
  // 02. Populate Google Map API data attributes.

  case 'google' :

    $map_google_api_script = 'https://maps.googleapis.com/maps/api/js?v=3'; // 01

    if ( $map_google_api_key ) {
      $map_google_api_script = add_query_arg( array( 'key' => esc_attr( $map_google_api_key ) ), $map_google_api_script );
    }

    wp_enqueue_script( 'x-google-map', $map_google_api_script );

    $map_google_data = array(
      'lat'       => $map_google_lat,
      'lng'       => $map_google_lng,
      'drag'      => $map_google_drag,
      'zoom'      => $map_google_zoom,
      'zoomLevel' => $map_google_zoom_level,
      'styles'    => $map_google_styles
    );

    $atts = array_merge( $atts, cs_element_js_atts( 'map_google', $map_google_data ) ); // 02

    break;

}


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php echo do_shortcode( $map_content ); ?>
</div>
