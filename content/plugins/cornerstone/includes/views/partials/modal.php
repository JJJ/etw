<?php

// =============================================================================
// VIEWS/PARTIALS/MODAL.PHP
// -----------------------------------------------------------------------------
// Modal partial.
// =============================================================================

$mod_id               = ( isset( $mod_id )               ) ? $mod_id : '';
$modal_close_location = ( isset( $modal_close_location ) ) ? explode( '-', $modal_close_location ) : explode( '-', 'top-right' );


// Prepare Attr Values
// -------------------

$id_slug             = ( isset( $id ) && ! empty( $id ) ) ? $id . '-modal' : $mod_id . '-modal';
$classes_modal       = x_attr_class( array( $mod_id, 'x-modal', $class ) );
$classes_modal_close = x_attr_class( array( 'x-modal-close', 'x-modal-close-' . $modal_close_location[0], 'x-modal-close-' . $modal_close_location[1] ) );


// Prepare Atts
// ------------

$atts_modal = array(
  'id'                => $id_slug,
  'class'             => $classes_modal,
  'role'              => 'dialog',
  'tabindex'          => '-1',
  'data-x-toggleable' => $mod_id,
  'data-x-scrollbar'  => '{"suppressScrollX":true}',
  'aria-hidden'       => 'true',
  'aria-label'        => __( 'Modal', 'cornerstone' ),
);

$atts_modal_close = array(
  'class'               => $classes_modal_close,
  'data-x-toggle-close' => true,
  'aria-label'          => __( 'Close Modal Content', 'cornerstone' ),
);

$atts_modal_content = array(
  'class'      => 'x-modal-content',
  'role'       => 'document',
  'aria-label' => __( 'Modal Content', 'cornerstone' ),
);

// Dynamic Rendering
// -----------------

$output_modal_content = cs_dynamic_content( do_shortcode( $modal_content ) );

if (isset($modal_content_dynamic_rendering) && $modal_content_dynamic_rendering) {
  $output_modal_content = apply_filters( 'cs_dynamic_rendering', $output_modal_content );
  $output_modal_content = "<script type=\"text/cs-toggle-template\">$output_modal_content</script>";
  $atts_modal_content['data-x-toggleable-content'] = $mod_id;
}

// Output
// ------

?>

<div <?php echo x_atts( $atts_modal ); ?>>

  <span class="x-modal-bg"></span>

  <button <?php echo x_atts( $atts_modal_close ); ?>>
    <span>&times;</span>
  </button>

  <div class="x-modal-content-outer">
    <div class="x-modal-content-inner">
      <div <?php echo x_atts( $atts_modal_content ); ?>>
        <?php echo $output_modal_content; ?>
      </div>
    </div>
  </div>

</div>
