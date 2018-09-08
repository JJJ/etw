<?php

// =============================================================================
// VIEWS/ELEMENTS/BAR-SPACE.PHP
// -----------------------------------------------------------------------------
// Bar space element.
// =============================================================================

// Prepare Classes
// ---------------

$classes = array( $mod_id, 'x-bar-space', 'x-bar-space-' . $_region );

if ( isset( $class ) ) {
  $classes[] = $class;
}

if ( $_region === 'top' || $_region === 'bottom' || $_region === 'footer' ) {
  $classes[] = 'x-bar-space-h';
}

if ( $_region === 'left' || $_region === 'right' ) {
  $classes[] = 'x-bar-space-v';
}


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( $classes )
);

if ( $_region === 'top' ) {
  $atts['style'] = 'display: none;';
}


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>></div>
