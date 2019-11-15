<?php

// =============================================================================
// VIEWS/ELEMENTS/POST-GRID.PHP
// -----------------------------------------------------------------------------
// Post Grid element.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( array( $mod_id, 'x-post', $class ) ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php do_action( 'x_render_children', $_modules, $_view_data ); ?>
</div>
