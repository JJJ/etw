<?php

// =============================================================================
// WOOCOMMERCE/NOTICES/ERROR.PHP
// -----------------------------------------------------------------------------
// @version 3.5.0
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
    <li><?php echo wc_kses_notice( $message ); ?></li>
  <?php endforeach; ?>
</ul>
