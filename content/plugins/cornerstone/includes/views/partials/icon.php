<?php

// =============================================================================
// VIEWS/PARTIALS/ICON.PHP
// -----------------------------------------------------------------------------
// Icon partial.
// =============================================================================

// Notes
// -----
// 01. Sometimes the icon key passed down will end with "_alt", so we account
//     for and allow this if it is the value provided.

$class = ( isset( $class )    ) ? $class    : '';
$atts  = ( isset( $atts )     ) ? $atts     : array();
$icon  = ( isset( $icon_alt ) ) ? $icon_alt : $icon; // 01


// Prepare Attr Values
// -------------------

$classes = x_attr_class( array( 'x-icon', $class ) );


// Prepare Atts
// ------------

$atts = array_merge( array(
  'class'       => $classes,
  'data-x-icon' => '&#x' . fa_unicode( $icon ) . ';',
  'aria-hidden' => 'true',
), $atts );

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Output
// ------

?>

<i <?php echo x_atts( $atts ); ?>></i>