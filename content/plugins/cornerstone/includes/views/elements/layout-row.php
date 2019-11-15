<?php

// =============================================================================
// CORNERSTONE/INCLUDES/VIEWS/ELEMENTS/LAYOUT-ROW.PHP
// -----------------------------------------------------------------------------
// Layout element (Row).
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Prepare Attr Values
// -------------------

$classes = array( $mod_id, 'x-row', $class );

if ( $layout_row_global_container == true ) {
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

if ( $layout_row_bg_advanced === true ) {
  $layout_row_bg = cs_get_partial_view( 'bg', cs_extract( $_view_data, array( 'bg' => '' ) ) );
}


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <div class="x-row-inner">
    <?php do_action( 'x_layout_row', $_modules ); ?>
  </div>
  <?php if ( isset( $layout_row_bg ) ) { echo $layout_row_bg; } ?>
</div>
