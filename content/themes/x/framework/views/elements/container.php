<?php

// =============================================================================
// VIEWS/ELEMENTS/CONTAINER.PHP
// -----------------------------------------------------------------------------
// Bar container element.
// =============================================================================

// Prepare Classes
// ---------------

$classes = array( $mod_id, 'x-bar-container', $class );


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( $classes ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Background Partial
// ------------------

if ( $container_bg_advanced == true ) {
  $container_bg = cs_get_partial_view( 'bg', cs_extract( $_view_data, array( 'bg' => '' ) ) );
}


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>

  <?php if ( isset( $container_bg ) ) { echo $container_bg; } ?>

  <?php do_action( 'x_bar_container', $_modules ); ?>

</div>
