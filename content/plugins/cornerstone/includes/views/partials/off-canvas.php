<?php

// =============================================================================
// VIEWS/PARTIALS/OFF-CANVAS.PHP
// -----------------------------------------------------------------------------
// Off canvas partial.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';


// Prepare Attr Values
// -------------------

$id_slug                    = ( isset( $id ) && ! empty( $id ) ) ? $id . '-off-canvas' : $mod_id . '-off-canvas';
$classes_off_canvas         = x_attr_class( array( $mod_id, 'x-off-canvas', 'x-off-canvas-' . $off_canvas_location, $class ) );
$classes_off_canvas_close   = x_attr_class( array( 'x-off-canvas-close', 'x-off-canvas-close-' . $off_canvas_location ) );
$classes_off_canvas_content = x_attr_class( array( 'x-off-canvas-content', 'x-off-canvas-content-' . $off_canvas_location ) );


// Prepare Atts
// ------------

$atts_off_canvas = array(
  'id'                => $id_slug,
  'class'             => $classes_off_canvas,
  'role'              => 'dialog',
  'tabindex'          => '-1',
  'data-x-toggleable' => $mod_id,
  'aria-hidden'       => 'true',
  'aria-label'        => __( 'Off Canvas', 'cornerstone' ),
);

$atts_off_canvas_close = array(
  'class'               => $classes_off_canvas_close,
  'data-x-toggle-close' => true,
  'aria-label'          => __( 'Close Off Canvas Content', 'cornerstone' ),
);

$atts_off_canvas_content = array(
  'class'            => $classes_off_canvas_content,
  'data-x-scrollbar' => '{"suppressScrollX":true}',
  'role'             => 'document',
  'aria-label'       => __( 'Off Canvas Content', 'cornerstone' ),
);

// Dynamic Rendering
// -----------------

$output_off_canvas_content = cs_dynamic_content( do_shortcode( $off_canvas_content ) );

if (isset($off_canvas_content_dynamic_rendering) && $off_canvas_content_dynamic_rendering) {
  $output_off_canvas_content = apply_filters( 'cs_dynamic_rendering', $output_off_canvas_content );
  $output_off_canvas_content = "<script type=\"text/cs-toggle-template\">$output_off_canvas_content</script>";
  $atts_off_canvas_content['data-x-toggleable-content'] = $mod_id;
}

// Output
// ------

?>

<div <?php echo x_atts( $atts_off_canvas ); ?>>

  <span class="x-off-canvas-bg"></span>

  <button <?php echo x_atts( $atts_off_canvas_close ); ?>>
    <span>&times;</span>
  </button>

  <div <?php echo x_atts( $atts_off_canvas_content ); ?>>
    <?php echo $output_off_canvas_content; ?>
  </div>

</div>
