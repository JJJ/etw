<?php

// =============================================================================
// CORNERSTONE/INCLUDES/VIEWS/ELEMENTS/ROW.PHP
// -----------------------------------------------------------------------------
// Row element.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$atts   = ( isset( $atts )   ) ? $atts   : array();


// Prepare Attr Values
// -------------------

$classes = array( $mod_id, 'x-container' );

if ( $row_inner_container ) {
  $classes[] = 'max';
  $classes[] = 'width';
}

if ( $row_marginless_columns ) {
  $classes[] = 'marginless-columns';
}

$classes[] = $class;


// Atts
// ----

$atts = array_merge( array(
  'class' => x_attr_class( $classes ),
), $atts );

if ( isset( $style ) && ! empty( $style ) ) {
  $atts['style'] = $style;
}

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Background Partial
// ------------------

$row_bg = NULL;

if ( $row_bg_advanced === true ) {
  $row_bg  = cs_get_partial_view( 'bg', cs_extract( $_view_data, array( 'bg' => '' ) ) );
}


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php echo $row_bg; ?>
  <?php do_action( 'x_row', $_modules ); ?>
</div>
