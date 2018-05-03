<?php

// =============================================================================
// VIEWS/PARTIALS/TOGGLE.PHP
// -----------------------------------------------------------------------------
// Toggle partial.
// =============================================================================

$class = ( isset( $class ) ) ? $class : '';
$atts  = ( isset( $atts )  ) ? $atts  : array();


// Prepare Attr Data
// -----------------

$toggle_type_group         = preg_replace( '/-\d/', '', $toggle_type );
$toggle_type_deconstructed = explode( '-', $toggle_type );
$toggle_type_number        = end( $toggle_type_deconstructed );


// Prepare Attr Values
// -------------------

$classes = x_attr_class( array( 'x-toggle', 'x-toggle-' . $toggle_type_group, $class ) );


// Prepare Atts
// ------------

$atts = array_merge( array(
  'class'       => $classes,
  'aria-hidden' => "true",
), $atts );


// Output
// ------

?>

<span <?php echo x_atts( $atts ); ?>>

  <?php if ( $toggle_type_group == 'burger' ) : ?>

    <span class="x-toggle-burger-bun-t" data-x-toggle-anim="xBunT-<?php echo $toggle_type_number; ?>"></span>
    <span class="x-toggle-burger-patty" data-x-toggle-anim="xPatty-<?php echo $toggle_type_number; ?>"></span>
    <span class="x-toggle-burger-bun-b" data-x-toggle-anim="xBunB-<?php echo $toggle_type_number; ?>"></span>

  <?php elseif ( $toggle_type_group == 'grid' ) : ?>

    <span class="x-toggle-grid-center" data-x-toggle-anim="xGrid-<?php echo $toggle_type_number; ?>"></span>

  <?php elseif ( $toggle_type_group == 'more-h' || $toggle_type_group == 'more-v' ) : ?>

    <span class="x-toggle-more-1" data-x-toggle-anim="xMore1-<?php echo $toggle_type_number; ?>"></span>
    <span class="x-toggle-more-2" data-x-toggle-anim="xMore2-<?php echo $toggle_type_number; ?>"></span>
    <span class="x-toggle-more-3" data-x-toggle-anim="xMore3-<?php echo $toggle_type_number; ?>"></span>

  <?php endif; ?>

</span>