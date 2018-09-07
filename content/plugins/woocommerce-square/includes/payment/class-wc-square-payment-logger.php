<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Square payment logging class which saves important data to the log
 *
 * @since 1.0.0
 * @version 1.0.0
 */
class WC_Square_Payment_Logger {

	public static $logger;

	/**
	 * Utilize WC logger class
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function log( $message ) {
		if ( empty( self::$logger ) ) {
			self::$logger = new WC_Logger();
		}

		self::$logger->add( 'woocommerce-gateway-square', $message );
	}
}
