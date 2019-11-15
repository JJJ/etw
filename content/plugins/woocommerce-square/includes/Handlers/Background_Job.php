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
use WooCommerce\Square\Sync\Interval_Polling;
use WooCommerce\Square\Sync\Job;
use WooCommerce\Square\Sync\Manual_Synchronization;
use WooCommerce\Square\Sync\Product_Import;
use WooCommerce\Square\Sync\Records;

defined( 'ABSPATH' ) or exit;

/**
 * Product and Inventory Synchronization handler class.
 *
 * This class handles manual and interval synchronization jobs.
 * It is a wrapper for the framework background handler and as such it only handles loopback business to keep the queue processing.
 * See the individual job implementations:
 *
 * @see Manual_Synchronization manual jobs re-process ALL synced products
 * @see Interval_Polling interval (polling) jobs perform API requests for ONLY the latest changes and update the associated products
 *
 * @since 2.0.0
 */
class Background_Job extends Framework\SV_WP_Background_Job_Handler {


	/**
	 * Initializes the background sync handler.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		$this->prefix   = 'wc_square';
		$this->action   = 'background_sync';
		$this->data_key = 'product_ids';

		parent::__construct();

		$this->maybe_increase_time_limit();

		add_action( "{$this->identifier}_job_complete",       [ $this, 'job_complete' ] );
		add_action( "{$this->identifier}_job_failed",         [ $this, 'job_failed' ] );
		add_filter( "{$this->identifier}_default_time_limit", [ $this, 'set_default_time_limit' ] );

		// ensures the queue lock time never expires before our timeout does
		add_filter( "{$this->identifier}_queue_lock_time", function( $lock_time ) {

			return $this->set_default_time_limit( $lock_time ) + 10;

		} );
	}


	/**
	 * Creates a new job.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attrs array of job attributes
	 * @return \stdClass|null
	 */
	public function create_job( $attrs ) {

		$sor = wc_square()->get_settings_handler()->get_system_of_record();

		return parent::create_job( wp_parse_args( $attrs, [
			'action'                => '',    // job action
			'catalog_processed'     => false, // whether the Square catalog has been processed
			'cursor'                => '',    // job advancement position
			'manual'                => false, // whether it's a sync job triggered manually
			'percentage'            => 0,     // percentage completed
			'product_ids'           => [],    // products to process
			'processed_product_ids' => [],    // products processed
			'skipped_products'      => [],    // remote product IDs that were skipped
			'system_of_record'      => $sor,  // system of record used
		] ) );
	}


	/**
	 * Handles job execution.
	 *
	 * Overridden to support our multi-step job structure. There are steps that can take a long time to process, so this
	 * ensures only one step is performed for each background request.
	 *
	 * @since 2.0.0
	 */
	protected function handle() {

		$this->lock_process();

		// Get next job in the queue
		$job = $this->get_job();

		// handle PHP errors from here on out
		register_shutdown_function( array( $this, 'handle_shutdown' ), $job );

		// Start processing
		$this->process_job( $job );

		$this->unlock_process();

		// Start next job or complete process
		if ( ! $this->is_queue_empty() ) {
			$this->dispatch();
		} else {
			$this->complete();
		}

		wp_die();
	}


	/**
	 * Processes a background job.
	 *
	 * @since 2.0.0
	 *
	 * @param object|\stdClass $job
	 * @param null $items_per_batch
	 * @return false|object|\stdClass
	 */
	public function process_job( $job, $items_per_batch = null ) {

		// indicate that the job has started processing
		if ( 'processing' !== $job->status ) {

			$job->status                = 'processing';
			$job->started_processing_at = current_time( 'mysql' );
			$job                        = $this->update_job( $job );
		}

		if ( 'poll' === $job->action ) {

			$job = new Interval_Polling( $job );

		} elseif ( 'product_import' === $job->action ) {

			$job = new Product_Import( $job );

		} elseif ( ! empty( $job->manual ) ) {

			$job = new Manual_Synchronization( $job );
		}

		if ( $job instanceof Job ) {

			$job = $job->run();
		}

		return $job;
	}


	/**
	 * Handles actions after a sync job is complete.
	 *
	 * @since 2.0.0
	 *
	 * @param $job
	 */
	public function job_complete( $job ) {

		wc_square()->get_sync_handler()->set_last_synced_at();

		wc_square()->get_sync_handler()->record_sync( $job->processed_product_ids, $job );

		if ( ! empty( $job->manual ) ) {
			wc_square()->get_email_handler()->get_sync_completed_email()->trigger( $job );
		}
	}


	/**
	 * Handles actions after a sync job has failed.
	 *
	 * @since 2.0.0
	 *
	 * @param $job
	 */
	public function job_failed( $job ) {

		Records::set_record( [
			'type'    => 'alert',
			'message' => 'Sync failed. Please try again',
		] );

		if ( ! empty( $job->manual ) ) {
			wc_square()->get_email_handler()->get_sync_completed_email()->trigger( $job );
		}
	}


	/**
	 * No-op: implements framework parent abstract method.
	 *
	 * @since 2.0.0
	 *
	 * @param null $item
	 * @param \stdClass $job
	 */
	protected function process_item( $item, $job ) {}


	/**
	 * Clear all background jobs of any status.
	 *
	 * @since 2.0.0
	 */
	public function clear_all_jobs() {

		$jobs = $this->get_jobs();

		if ( is_array( $jobs ) ) {
			$this->delete_jobs( $jobs );
		}

		delete_transient( 'wc_square_background_sync_process_lock' );
	}


	/**
	 * Deletes a set of background jobs.
	 *
	 * @since 2.0.0
	 *
	 * @param object[] $jobs jobs to delete
	 */
	public function delete_jobs( $jobs ) {

		foreach ( $jobs as $job ) {
			$this->delete_job( $job );
		}
	}


	/**
	 * Attempts to increase the script execution time limit to a filtered value -- defaults to 5 minutes.
	 *
	 * @since 2.0.0
	 */
	protected function maybe_increase_time_limit() {

		/**
		 * Filters the desired time limit for Square requests. Defaults to 5 minutes.
		 *
		 * @since 2.0.0
		 *
		 * @param int time limit
		 */
		$desired_time_limit = (int) apply_filters( 'wc_square_time_limit', 300 );
		$server_time_limit  = (int) ini_get( 'max_execution_time' );

		if ( $desired_time_limit > $server_time_limit ) {

			\ActionScheduler_Compatibility::raise_time_limit( $desired_time_limit );
		}
	}


	/**
	 * Sets the default time limit to the server time limit minus a buffer,
	 * to allow us to clean up a request that has exceeded the time limit.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 *
	 * @param int $default_time_limit time limit (in seconds)
	 * @return int
	 */
	public function set_default_time_limit( $default_time_limit ) {

		$server_time_limit = (int) ini_get( 'max_execution_time' );
		$time_limit_buffer = 10;

		if ( isset( $server_time_limit ) && $time_limit_buffer < $server_time_limit ) {

			$default_time_limit = $server_time_limit - $time_limit_buffer;
		}

		return $default_time_limit;
	}


	/**
	 * Returns whether a sensible time has been exceeded for this request.
	 *
	 * Makes the internal time_exceeded() function publicly accessible.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function is_time_exceeded() {

		return $this->time_exceeded();
	}


	/**
	 * Adds some helpful debug tools.
	 *
	 * @since 2.0.0
	 *
	 * @param array $tools existing debug tools
	 * @return array
	 */
	public function add_debug_tool( $tools ) {

		$tools = parent::add_debug_tool( $tools );

		// this key is not unique to the plugin to avoid duplicate tools
		$tools['wc_square_clear_background_jobs'] = array(
			'name'     => __( 'Clear Square Sync', 'woocommerce-square' ),
			'button'   => __( 'Clear', 'woocommerce-square' ),
			'desc'     => __( 'This tool will clear any ongoing Square product syncs.', 'woocommerce-square' ),
			'callback' => [ $this, 'run_clear_background_jobs' ],
		);

		return $tools;
	}


	/**
	 * Runs the "Clear Square Sync" tool.
	 *
	 * Provides a way for merchants to clear any ongoing or stuck product syncs.
	 *
	 * @since 2.0.0
	 */
	public function run_clear_background_jobs() {

		$this->clear_all_jobs();

		$this->debug_message = esc_html__( 'Success! You can now sync your products.', 'woocommerce-square' );

		return true;
	}


}
