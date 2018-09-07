<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WC_Square_Deactivation {

	/**
	 * Constructor not to be instantiated
	 *
	 * @access private
	 * @since 1.0.0
	 * @version 1.0.0
	 * @return bool
	 */
	private function __construct() {}

	/**
	 * Perform deactivation tasks
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @return bool
	 */
	public static function deactivate() {
		wp_clear_scheduled_hook( 'woocommerce_square_inventory_poll' );

		return true;
	}
}
