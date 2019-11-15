<?php

// =============================================================================
// WOOCOMMERCE/NOTICES/NOTICE.PHP
// -----------------------------------------------------------------------------
// @version 3.5.0
// =============================================================================

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

if ( ! $messages ) return;

?>

<?php foreach ( $messages as $message ) : ?>
  <div class="woocommerce-info x-alert x-alert-info x-alert-block">
    <?php echo wc_kses_notice( $message ); ?>
  </div>
<?php endforeach; ?>
