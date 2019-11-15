<?php

// =============================================================================
// CORNERSTONE/INCLUDES/VIEWS/ELEMENTS/LAYOUT-GRID.PHP
// -----------------------------------------------------------------------------
// Layout element (Grid).
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Prepare Attr Values
// -------------------

$classes = array( $mod_id, 'x-grid', $class );

if ( $layout_grid_global_container == true ) {
  $classes[] = 'x-container max width';
}


// Atts
// ----

$atts = array(
  'class' => x_attr_class( $classes ),
);

if ( isset( $style ) && ! empty( $style ) ) {
  $atts['style'] = $style;
}

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Background Partial
// ------------------

if ( $layout_grid_bg_advanced === true ) {
  $layout_grid_bg = cs_get_partial_view( 'bg', cs_extract( $_view_data, array( 'bg' => '' ) ) );
}


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php do_action( 'x_render_children', $_modules, $_view_data ); ?>
  <?php if ( isset( $layout_grid_bg ) ) { echo $layout_grid_bg; } ?>
</div>
