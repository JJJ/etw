<?php

// =============================================================================
// VIEWS/BARS/LAYOUT-CELL.PHP
// -----------------------------------------------------------------------------
// Layout element (Cell).
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( array( $mod_id, 'x-cell', $class ) ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Background Partial
// ------------------

$cell_bg = NULL;

if ( $layout_cell_bg_advanced === true ) {
  $cell_bg = cs_get_partial_view( 'bg', cs_extract( $_view_data, array( 'bg' => '' ) ) );
}


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php if ( isset( $cell_bg ) ) { echo $cell_bg; } ?>
  <?php do_action( 'x_layout_cell', $_modules ); ?>
</div>
