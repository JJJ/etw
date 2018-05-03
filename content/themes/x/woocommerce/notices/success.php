<?php

// =============================================================================
// WOOCOMMERCE/NOTICES/SUCCESS.PHP
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

<?php foreach ( $messages as $message ) : ?>
  <div class="woocommerce-message x-alert x-alert-info x-alert-block" role="alert">
    <?php echo wp_kses_post( $message ); ?>
  </div>
<?php endforeach; ?>