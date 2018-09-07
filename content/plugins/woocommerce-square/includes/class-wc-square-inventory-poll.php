<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WC_Square_Inventory_Poll
 *
 * Cron driven methods to poll Square's inventory at intervals.
 * This is to replace the webhook method as it is not recommended by Square.
 */
class WC_Square_Inventory_Poll {
	protected $integration;
	protected $to_wc;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 * @param object $integration
	 * @param object $to_wc
	 */
	public function __construct( WC_Square_Integration $integration, WC_Square_Sync_From_Square $to_wc ) {
		$this->integration = $integration;
		$this->to_wc = $to_wc;

		add_action( 'init', array( $this, 'run_schedule' ) );

		// the scheduled cron will trigger this event
		add_action( 'woocommerce_square_inventory_poll', array( $this, 'sync' ) );
	}

	public function run_schedule() {
		$frequency = apply_filters( 'woocommerce_square_inventory_poll_frequency', 'hourly' );

		if ( ! wp_next_scheduled( 'woocommerce_square_inventory_poll' ) ) {
			wp_schedule_event( time(), $frequency, 'woocommerce_square_inventory_poll' );
		}
	}

	public function sync() {
		$sync                   = ( 'yes' === $this->integration->get_option( 'inventory_polling' ) );
		$manual_sync_processing = get_transient( 'wc_square_manual_sync_processing' );

		if ( $sync && ! $manual_sync_processing ) {
			$this->to_wc->sync_all_inventory();
		}
	}
}
