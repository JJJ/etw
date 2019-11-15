<?php

// =============================================================================
// VIEWS/BARS/TP-WC-CART-DROPDOWN.PHP
// -----------------------------------------------------------------------------
// WooCommerce cart (dropdown) element.
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

$data_toggle   = cs_extract( $_view_data, array( 'toggle_anchor' => 'anchor', 'toggle' => '' ) );
$data_dropdown = cs_extract( $_view_data, array( 'dropdown' => '' ) );
$data_cart     = cs_extract( $_view_data, array( 'cart' => '' ) );


// Set Dropdown Content
// --------------------

$dropdown_content = array( 'dropdown_content' => cs_get_partial_view( 'mini-cart', $data_cart ) );
$data_dropdown    = array_merge( $data_dropdown, $dropdown_content );


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php echo cs_get_partial_view( 'anchor', $data_toggle ); ?>
  <?php echo cs_get_partial_view( 'dropdown', $data_dropdown ); ?>
</div>
