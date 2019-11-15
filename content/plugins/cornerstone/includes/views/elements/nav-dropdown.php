<?php

// =============================================================================
// VIEWS/BARS/NAV-DROPDOWN.PHP
// -----------------------------------------------------------------------------
// Nav (dropdown) element.
// =============================================================================

$classes = x_attr_class( array( $mod_id, 'x-mod-container', $class ) );


// Prepare Atts
// ------------

$atts = array(
  'class' => $classes
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Data: Partials
// --------------

$data_toggle = cs_extract( $_view_data, array( 'toggle_anchor' => 'anchor', 'toggle' => '' ) );
$data_menu   = cs_extract( $_view_data, array( 'menu' => '', 'anchor' => '' ) );


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php echo cs_get_partial_view( 'anchor', $data_toggle ); ?>
  <?php echo cs_get_partial_view( 'menu', $data_menu ); ?>
</div>
