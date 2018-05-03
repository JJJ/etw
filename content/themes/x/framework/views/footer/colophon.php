<?php

// =============================================================================
// VIEWS/FOOTER/COLOPHON.PHP
// -----------------------------------------------------------------------------
// Colophon markup.
// =============================================================================

$atts = x_atts( apply_filters( 'x_colophon_atts', array(
  'class' => 'x-colophon',
  'role'  => 'contentinfo'
) ) );

?>

<?php do_action( 'x_before_colophon_begin' ); ?>

  <footer <?php echo $atts; ?>>

    <?php do_action( 'x_after_colophon_begin' ); ?>

    <?php do_action( 'x_colophon' ); ?>

    <?php do_action( 'x_before_colophon_end' ) ?>

  </footer>

<?php do_action( 'x_after_colophon_end' ); ?>
