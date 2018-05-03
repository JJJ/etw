<?php

// =============================================================================
// WOOCOMMERCE/NOTICES/ERROR.PHP
// -----------------------------------------------------------------------------
// @version 3.3.0
// =============================================================================

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( ! $messages ) {
  return;
}

?>

<ul class="woocommerce-error x-alert x-alert-danger x-alert-block" role="alert">
  <?php foreach ( $messages as $message ) : ?>
    <li><?php echo wp_kses_post( $message ); ?></li>
  <?php endforeach; ?>
</ul>