<?php

// =============================================================================
// VIEWS/PARTIALS/BG.PHP
// -----------------------------------------------------------------------------
// Background partial.
// =============================================================================

// Prepare Atts
// ------------

$bg_atts = array(
  'class'       => 'x-bg',
  'aria-hidden' => 'true'
);

if ( isset( $bg_border_radius ) && $bg_border_radius !== 'inherit' ) {
  $bg_atts['style'] = 'border-radius: ' . $bg_border_radius . ';';
}

if ( isset( $bg_lower_type ) && $bg_lower_type != 'none' ) {

  $bg_lower_content = '';
  $bg_lower_atts    = array(
    'class' => 'x-bg-layer-lower-' . $bg_lower_type,
  );

  if ( $bg_lower_parallax && $bg_lower_type !== 'color' ) {
    $bg_lower_data = array( 'parallaxSize' => $bg_lower_parallax_size, 'parallaxDir' => $bg_lower_parallax_direction, 'parallaxRev' => $bg_lower_parallax_reverse );
    $bg_lower_atts = array_merge( $bg_lower_atts, cs_element_js_atts( 'bg_layer', $bg_lower_data ) );
  }

  switch ( $bg_lower_type ) {
    case 'color' :
      $bg_lower_atts['style'] = ' background-color: ' . cornerstone_post_process_color( $bg_lower_color ) . ';';
      break;
    case 'image' :
      $bg_lower_atts['style'] = ' background-image: url(' . $bg_lower_image . '); background-repeat: ' . $bg_lower_image_repeat . '; background-position: ' . $bg_lower_image_position . '; background-size: ' . $bg_lower_image_size . ';';
      break;
    case 'video' :
      $bg_lower_content = ( function_exists( 'cs_bg_video' ) ) ? cs_bg_video( $bg_lower_video, $bg_lower_video_poster ) : '';
      break;
  }

  $bg_lower_layer = '<div ' . x_atts( $bg_lower_atts ) . '>' . $bg_lower_content . '</div>';

}


if ( isset( $bg_upper_type ) && $bg_upper_type != 'none' ) {

  $bg_upper_content = '';
  $bg_upper_atts    = array(
    'class' => 'x-bg-layer-upper-' . $bg_upper_type,
  );

  if ( $bg_upper_parallax && $bg_upper_type !== 'color' ) {
    $bg_upper_data = array( 'parallaxSize' => $bg_upper_parallax_size, 'parallaxDir' => $bg_upper_parallax_direction, 'parallaxRev' => $bg_upper_parallax_reverse );
    $bg_upper_atts = array_merge( $bg_upper_atts, cs_element_js_atts( 'bg_layer', $bg_upper_data ) );
  }

  switch ( $bg_upper_type ) {
    case 'color' :
      $bg_upper_atts['style'] = ' background-color: ' . cornerstone_post_process_color( $bg_upper_color ) . ';';
      break;
    case 'image' :
      $bg_upper_atts['style'] = ' background-image: url(' . $bg_upper_image . '); background-repeat: ' . $bg_upper_image_repeat . '; background-position: ' . $bg_upper_image_position . '; background-size: ' . $bg_upper_image_size . ';';
      break;
    case 'video' :
      $bg_upper_content = ( function_exists( 'cs_bg_video' ) ) ? cs_bg_video( $bg_upper_video, $bg_upper_video_poster ) : '';
      break;
  }

  $bg_upper_layer = '<div ' . x_atts( $bg_upper_atts ) . '>' . $bg_upper_content . '</div>';

}


// Output
// ------

?>

<div <?php echo x_atts( $bg_atts ); ?>>
  <?php if ( isset( $bg_lower_layer ) ) { echo $bg_lower_layer; } ?>
  <?php if ( isset( $bg_upper_layer ) ) { echo $bg_upper_layer; } ?>
</div>
