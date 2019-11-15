<?php
/**
 * WooCommerce Square
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@woocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Square to newer
 * versions in the future. If you wish to customize WooCommerce Square for your
 * needs please refer to https://docs.woocommerce.com/document/woocommerce-square/
 *
 * @author    WooCommerce
 * @copyright Copyright: (c) 2019, Automattic, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

namespace WooCommerce\Square\Handlers;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;
use WooCommerce\Square\Plugin;
use WooCommerce\Square\Sync\Interval_Polling;
use WooCommerce\Square\Sync\Records;

defined( 'ABSPATH' ) or exit;

/**
 * Synchronization handler class
 *
 * @since 2.0.0
 */
class Sync {


	/** @var string key of the option that stores a timestamp when the last sync job completed */
	private $last_synced_at_option_key = 'wc_square_last_synced_at';

	/** @var string name of the Action Scheduler event name for syncing with Square */
	private $sync_scheduled_event_name;

	/** @var Plugin plugin instance */
	private $plugin;


	/**
	 * Constructs the class.
	 *
	 * @since 2.0.0
	 *
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {

		$this->plugin = $plugin;

		$this->sync_scheduled_event_name = 'wc_' . $this->get_plugin()->get_id() . '_sync';

		$this->add_hooks();
	}


	/**
	 * Adds the action & filter hooks.
	 *
	 * @since 2.0.0
	 */
	private function add_hooks() {

		// schedule the interval sync
		add_action( 'init', [ $this, 'schedule_sync' ] );

		// run the interval sync when fired by Action Scheduler
		add_action( $this->sync_scheduled_event_name, [ $this, 'start_interval_sync' ] );
	}


	/**
	 * Gets the sync schedule interval in seconds.
	 *
	 * @since 2.0.0
	 *
	 * @return int
	 */
	private function get_sync_schedule_interval() {

		/**
		 * Filters the frequency with which products should be synced.
		 *
		 * @since 2.0.0
		 *
		 * @param int $interval sync interval in seconds (defaults to one hour)
		 */
		return (int) max( MINUTE_IN_SECONDS, (int) apply_filters( 'wc_square_sync_interval', HOUR_IN_SECONDS ) );
	}


	/**
	 * Schedules the interval sync.
	 *
	 * @since 2.0.0
	 */
	public function schedule_sync() {

		// bail if product sync is not enabled or there hasn't been a previous sync
		if ( $this->is_sync_in_progress() || ! $this->get_last_synced_at() || ! $this->get_plugin()->get_settings_handler()->is_connected() || ! $this->get_plugin()->get_settings_handler()->is_product_sync_enabled() ) {
			return;
		}

		$plugin_id = $this->get_plugin()->get_id();
		$interval  = $this->get_sync_schedule_interval();

		if ( false === as_next_scheduled_action( $this->sync_scheduled_event_name, [], $plugin_id ) ) {
			as_schedule_recurring_action( time() + $interval, $interval, $this->sync_scheduled_event_name, [], $plugin_id );
		}
	}


	/**
	 * Unschedules the interval sync.
	 *
	 * @since 2.0.0
	 */
	public function unschedule_sync() {

		as_unschedule_action( $this->sync_scheduled_event_name, [], $this->get_plugin()->get_id() );
	}


	/**
	 * Performs a product import from Square.
	 *
	 * @since 2.0.0
	 *
	 * @param bool $dispatch whether the job should be immediately dispatched
	 * @return \stdClass|null
	 */
	public function start_product_import( $dispatch = true ) {

		$job = $this->get_plugin()->get_background_job_handler()->create_job( [
			'action' => 'product_import',
		] );

		if ( $job ) {

			if ( $dispatch ) {
				$this->get_plugin()->get_background_job_handler()->dispatch();
			}
		}

		return $job;
	}


	/**
	 * Performs a manual sync.
	 *
	 * @since 2.0.0
	 *
	 * @param bool $dispatch whether the job should be immediately dispatched
	 * @param int[] $product_ids (optional) array of product IDs to sync
	 * @return \stdClass|null
	 */
	public function start_manual_sync( $dispatch = true, array $product_ids = [] ) {

		$product_ids = empty( $product_ids ) ? Product::get_products_synced_with_square() : $product_ids;

		$job = $this->get_plugin()->get_background_job_handler()->create_job( [
			'action'      => 'sync',
			'manual'      => true,
			'product_ids' => $product_ids,
		] );

		if ( $job ) {

			if ( $dispatch ) {
				$this->get_plugin()->get_background_job_handler()->dispatch();
			}
		}

		return $job;
	}


	/**
	 * Performs a manual product deletion.
	 *
	 * @since 2.0.0
	 *
	 * @param int[] $product_ids array of product IDs to delete
	 * @param bool $dispatch whether the job should be immediately dispatched
	 * @return \stdClass|null
	 */
	public function start_manual_deletion( array $product_ids, $dispatch = true ) {

		$job = $this->get_plugin()->get_background_job_handler()->create_job( [
			'action'      => 'delete',
			'manual'      => true,
			'product_ids' => $product_ids,
		] );

		if ( $job ) {

			if ( $dispatch ) {
				$this->get_plugin()->get_background_job_handler()->dispatch();
			}
		}

		return $job;
	}


	/**
	 * Performs an interval sync with Square.
	 *
	 * @since 2.0.0
	 */
	public function start_interval_sync() {

		// bail if there is already a sync in progress
		if ( ! $this->is_sync_enabled() || $this->is_sync_in_progress() ) {
			return;
		}

		// use this opportunity to clear old background jobs
		$this->get_plugin()->get_background_job_handler()->clear_all_jobs();

		$job = $this->get_plugin()->get_background_job_handler()->create_job( [
			'action'                   => 'poll',
			'manual'                   => false,
			'catalog_last_synced_at'   => $this->get_last_synced_at(),
			'inventory_last_synced_at' => $this->get_inventory_last_synced_at(),
		] );

		if ( $job ) {
			$this->get_plugin()->get_background_job_handler()->dispatch();
		}
	}


	/** Conditional methods *******************************************************************************************/


	/**
	 * Determines whether a sync process should happen in background.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function should_sync_in_background() {

		/**
		 * Filters whether a sync process should happen in background.
		 *
		 * @since 2.0.0
		 *
		 * @param bool $sync_in_background defaults to whether loopback connections are supported
		 */
		return (bool) apply_filters( 'wc_square_sync_in_background', $this->get_plugin()->get_background_job_handler()->test_connection() );
	}


	/**
	 * Determines whether a sync, scheduled or manual, is in progress.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function is_sync_in_progress() {

		return ( defined( 'DOING_SQUARE_SYNC' ) && true === DOING_SQUARE_SYNC )
		       || null !== $this->get_job_in_progress();
	}


	/**
	 * Determines if sync is enabled.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function is_sync_enabled() {

		return $this->get_plugin()->get_settings_handler()->is_product_sync_enabled();
	}


	/** Setter methods ************************************************************************************************/


	/**
	 * Records a successful sync.
	 *
	 * @since 2.0.0
	 *
	 * @param int[] $product_ids IDs of products synced
	 * @param null|\stdClass $job optional sync job, may be used to set the job ID to prevent duplicates
	 */
	public function record_sync( array $product_ids, $job = null ) {

		$products = count( $product_ids );

		// only add a record of some products were synced
		if ( $products ) {

			Records::set_record( [
				'id'      => $job && isset( $job->id ) ? $job->id : null,
				'message' => sprintf(
				/* translators: Placeholder: %d number of products processed */
					_n( 'Updated data for %d product.', 'Updated data for %d products.', $products, 'woocommerce-square' ),
					$products
				),
			] );
		}

		/**
		 * Fires after a set of products are synced with square.
		 *
		 * @since 2.0.0
		 *
		 * @param int[] $product_ids IDs for products that were synced
		 */
		do_action( 'wc_square_products_synced', $product_ids );
	}


	/**
	 * Updates the time when the last sync job occurred.
	 *
	 * @since 2.0.0
	 *
	 * @param int|string|null $timestamp a valid timestamp in UTC (optional, will default to now)
	 * @return bool success
	 */
	public function set_last_synced_at( $timestamp = null ) {

		if ( null === $timestamp ) {
			$timestamp = current_time( 'timestamp', true );
		}

		return is_numeric( $timestamp ) && update_option( $this->last_synced_at_option_key, (int) $timestamp );
	}


	/** Getter methods ************************************************************************************************/


	/**
	 * Gets a job that is currently in progress.
	 *
	 * @since 2.0.0
	 *
	 * @return null|\stdClass background job object or null if not found
	 */
	public function get_job_in_progress() {

		$handler = $this->get_plugin()->get_background_job_handler();

		try {
			$job = $handler->get_job();
		} catch ( \Exception $e ) {
			$job = null;
		}

		return $job && isset( $job->status ) && in_array( $job->status, [ 'created', 'queued', 'processing' ], true ) ? $job : null;
	}


	/**
	 * Gets a date or time of a sync job (helper method).
	 *
	 * @see Sync::get_last_synced_at()
	 * @see Sync::get_next_sync_at()
	 *
	 * @since 2.0.0
	 *
	 * @param null|int $timestamp a valid timestamp (raw data)
	 * @param string $format the output type, either 'timestamp' or a valid PHP date format for a date string
	 * @param string|null|\DateTimeZone $timezone the timezone output (defaults to the site timezone)
	 * @return int|string|null a timestamp or date, or null on error or invalid timestamp
	 */
	private function get_sync_date_time( $timestamp, $format, $timezone ) {

		$output = null;

		if ( is_numeric( $timestamp ) ) {

			try {

				if ( null === $timezone ) {
					$timezone = new \DateTimeZone( wc_timezone_string() );
				} elseif ( is_string( $timezone ) ) {
					$timezone = new \DateTimeZone( $timezone );
				}

				$date      = new \DateTime( date( 'Y-m-d H:i:s', (int) $timestamp ), new \DateTimeZone( 'UTC' ) );
				$offset    = $timezone->getOffset( $date );
				$timestamp = $date->getTimestamp() + $offset;

			} catch ( \Exception $e ) {

				$timestamp = null;
			}
		}

		if ( is_numeric( $timestamp ) ) {
			if ( 'timestamp' !== $format ) {
				$output = date( $format, (int) $timestamp );
			} else {
				$output = (int) $timestamp;
			}
		}

		return $output;
	}


	/**
	 * Gets the timestamp when the next sync job should start.
	 *
	 * @since 2.0.0
	 *
	 * @return int
	 */
	public function get_next_sync_at() {

		$timestamp = null;

		if ( $scheduled = as_next_scheduled_action( $this->sync_scheduled_event_name ) ) {
			$timestamp = $scheduled;
		}

		return (int) $timestamp > 1 ? $timestamp : null;
	}


	/**
	 * Gets the timestamp for when the last sync job completed.
	 *
	 * @since 2.0.0
	 *
	 * @return int
	 */
	public function get_last_synced_at() {

		$timestamp = get_option( $this->last_synced_at_option_key, null );

		return (int) $timestamp > 1 ? $timestamp : null;
	}


	/**
	 * Sets the timestamp for when the last inventory sync job completed.
	 *
	 * @since 2.0.0
	 *
	 * @return int
	 */
	public function set_inventory_last_synced_at() {

		return update_option( $this->last_synced_at_option_key . '_inventory', current_time( 'timestamp', true ) );
	}


	/**
	 * Gets the timestamp for when the last inventory sync job completed.
	 *
	 * @since 2.0.0
	 *
	 * @return int
	 */
	public function get_inventory_last_synced_at() {

		$timestamp = get_option( $this->last_synced_at_option_key . '_inventory', null );

		return (int) $timestamp > 1 ? $timestamp : null;
	}


	/**
	 * Gets the plugin instance.
	 *
	 * @since 2.0.0
	 *
	 * @return Plugin
	 */
	private function get_plugin() {

		return $this->plugin;
	}


}
