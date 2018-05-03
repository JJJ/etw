<?php

// =============================================================================
// VIEWS/PARTIALS/FRAME.PHP
// -----------------------------------------------------------------------------
// Frame partial.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$atts   = ( isset( $atts )   ) ? $atts   : array();


// Prepare Attr Values
// -------------------

$classes = array( $mod_id, 'x-frame', $class );

if ( isset( $frame_content_type ) && ! empty( $frame_content_type ) ) {
  $classes[] = 'x-frame-' . $frame_content_type;
}


// Prepare Atts
// ------------

$atts = array_merge( array(
  'class' => x_attr_class( $classes ),
), $atts );

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <div class="x-frame-inner">
    <?php echo do_shortcode( $frame_content ); ?>
  </div>
</div>
