<?php

// =============================================================================
// VIEWS/BARS/LAYOUT-COLUMN.PHP
// -----------------------------------------------------------------------------
// Layout element (Column).
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( array( $mod_id, 'x-col', $class ) ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Background Partial
// ------------------

$column_bg = NULL;

if ( $layout_column_bg_advanced === true ) {
  $column_bg = cs_get_partial_view( 'bg', cs_extract( $_view_data, array( 'bg' => '' ) ) );
}



// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php if ( isset( $column_bg ) ) { echo $column_bg; } ?>
  <?php do_action( 'x_layout_column', $_modules ); ?>
</div>
