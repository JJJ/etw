<?php

// =============================================================================
// VIEWS/ELEMENTS/POST.PHP
// -----------------------------------------------------------------------------
// Post element.
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

</div>
