<?php

// =============================================================================
// VIEWS/BARS/LINE.PHP
// -----------------------------------------------------------------------------
// Line element.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( array( $mod_id, 'x-line', $class ) ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Output
// ------

?>

<hr <?php echo x_atts( $atts ); ?>>