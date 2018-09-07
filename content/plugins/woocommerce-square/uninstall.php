<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// if uninstall not called from WordPress exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/*
 * Only remove ALL product and page data if WC_REMOVE_ALL_DATA constant is set to true in user's
 * wp-config.php. This is to prevent data loss when deleting the plugin from the backend
 * and to ensure only the site owner can perform this action.
 */
if ( defined( 'WC_REMOVE_ALL_DATA' ) && true === WC_REMOVE_ALL_DATA ) {
	delete_option( 'wc_square_endpoint_set' );
	delete_option( 'woocommerce_squareconnect_settings' );
	delete_option( 'wc_square_polling' );
	delete_transient( 'wc_square_polling' );
	delete_transient( 'wc_square_locations' );
	delete_transient( 'wc_square_manual_sync_processing' );
	delete_option( 'woocommerce_square_merchant_access_token' );
}
