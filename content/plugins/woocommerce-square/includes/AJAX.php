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

namespace WooCommerce\Square;

defined( 'ABSPATH' ) or exit;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;
use WooCommerce\Square\Handlers\Product;
use WooCommerce\Square\Handlers\Sync;
use WooCommerce\Square\Sync\Records;

/**
 * AJAX handler.
 *
 * @since 2.0.0
 */
class AJAX {


	/**
	 * Adds AJAX action callbacks.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		// check an individual product sync status
		add_action( 'wp_ajax_wc_square_is_product_synced_with_square', [ $this, 'is_product_synced_with_square' ] );

		// fetch product stock from Square
		add_action( 'wp_ajax_wc_square_fetch_product_stock_with_square', [ $this, 'fetch_product_stock_with_square' ] );

		add_action( 'wp_ajax_wc_square_import_products_from_square', [ $this, 'import_products_from_square' ] );

		// sync all products with Square
		add_action( 'wp_ajax_wc_square_sync_products_with_square', [ $this, 'sync_products_with_square' ] );

		// handle sync records
		add_action( 'wp_ajax_wc_square_handle_sync_records', [ $this, 'handle_sync_records' ] );

		// get the status of a sync job
		add_action( 'wp_ajax_wc_square_get_sync_with_square_status', [ $this, 'get_sync_with_square_job_status' ] );
	}


	/**
	 * Checks if a product is set to be synced with Square.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function is_product_synced_with_square() {

		check_ajax_referer( 'is-product-synced-with-square', 'security' );

		if ( isset( $_POST['product_id'] ) && ( $product = wc_get_product( $_POST['product_id'] ) ) ) {

			if ( empty( $product->get_sku() ) ) {
				wp_send_json_error( 'missing_sku' );
			} elseif ( count( $product->get_attributes() ) > 1 ) {
				wp_send_json_error( 'multiple_attributes' );
			} else {
				wp_send_json_success( Product::is_synced_with_square( $product ) ? 'yes' : 'no' );
			}
		}

		wp_send_json_error( 'invalid_product' );
	}


	/**
	 * Fetches product stock data from Square.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function fetch_product_stock_with_square() {

		check_ajax_referer( 'fetch-product-stock-with-square', 'security' );

		$fix_error = __( 'Please mark product as un-synced and save, then synced again.', 'woocommerce-square' );

		if ( isset( $_REQUEST['product_id'] ) && ( $product = wc_get_product( $_REQUEST['product_id'] ) ) ) {

			try {

				$product = Product::update_stock_from_square( $product );

				wp_send_json_success( $product->get_stock_quantity() );

			} catch ( Framework\SV_WC_Plugin_Exception $exception ) {

				/* translators: Placeholders: %1$s = error message, %2$s = help text */
				wp_send_json_error( sprintf( __( 'Unable to fetch inventory: %1$s. %2$s', 'woocommerce-square' ), $exception->getMessage(), $fix_error ) );
			}
		}

		/* translators: Placeholders: %s = help text */
		wp_send_json_error( sprintf( __( 'Error finding item in Square. %s', 'woocommerce-square' ), $fix_error ) );
	}


	/**
	 * Starts importing products from Square.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function import_products_from_square() {

		check_ajax_referer( 'import-products-from-square', 'security' );

		$started = wc_square()->get_sync_handler()->start_product_import( ! empty( $_POST['dispatch'] ) );

		if ( ! $started ) {
			wp_send_json_error( __( 'Could not start import. Please try again.', 'woocommerce-square' ) );
		}

		wp_send_json_success( __( 'Your products are being imported in the background! This may take some time to complete.', 'woocommerce-square' ) );
	}


	/**
	 * Starts syncing products with Square.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function sync_products_with_square() {

		check_ajax_referer( 'sync-products-with-square', 'security' );

		$started = wc_square()->get_sync_handler()->start_manual_sync( ! empty( $_POST['dispatch'] ) );

		if ( ! $started ) {
			wp_send_json_error();
		}

		wp_send_json_success();
	}


	/**
	 * Handles sync records actions.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function handle_sync_records() {

		check_ajax_referer( 'handle-sync-with-square-records', 'security' );

		$error = '';

		if ( isset( $_POST['id'], $_POST['handle'] ) ) {

			$id     = $_POST['id'];
			$action = $_POST['handle'];

			if ( 'all' === $id && 'delete' === $action ) {

				$outcome = Records::clean_records();
				$error   = esc_html__( 'Could not delete records.', 'woocommerce-square' );

			} elseif ( is_string( $id ) && '' !== $id ) {

				switch ( $action ) {

					case 'delete' :

						$outcome = Records::delete_record( $id );
						$error   = esc_html__( 'Could not delete record.', 'woocommerce-square' );

					break;

					case 'resolve' :

						if ( $record = Records::get_record( $id) ) {
							$record->resolve();
							$outcome = $record->save();
						}

						$error = esc_html__( 'Could not resolve record.', 'woocommerce-square' );

					break;

					case 'unsync' :

						$record = Records::get_record( $id );

						if ( $record && ( $product = $record->get_product() ) ) {
							$record->resolve();
							$outcome = Product::unset_synced_with_square( $product ) && $record->save();
						}

						$error = esc_html__( 'Could not unsync product.', 'woocommerce-square' );

					break;
				}
			}

			if ( ! empty( $outcome ) ) {
				wp_send_json_success( $outcome );
			}
		}

		/* translators: Placeholder: %s - error message */
		wp_send_json_error( sprintf( __( 'An error occurred. %s', 'woocommerce-square' ), $error ) );
	}


	/**
	 * Gets a sync job status.
	 *
	 * Also bumps the job progression (useful for when background processing isn't available).
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function get_sync_with_square_job_status() {

		check_ajax_referer( 'get-sync-with-square-status', 'security' );

		$job_id = isset( $_POST['job_id'] ) ? $_POST['job_id'] : null;

		if ( $job_id && ( $handler = wc_square()->get_background_job_handler() ) ) {

			try {

				if ( $job_in_progress = $handler->get_job( $job_id ) ) {

					$result = [
						'action'                   => $job_in_progress->action,
						'id'                       => $job_in_progress->id,
						'job_products_count'       => count( $job_in_progress->product_ids ),
						'percentage'               => ( (float) count( $job_in_progress->processed_product_ids ) / max( 1, count( $job_in_progress->product_ids ) ) ) * 100,
						'processed_products_count' => count( $job_in_progress->processed_product_ids ),
						'skipped_products_count'   => count( $job_in_progress->skipped_products ),
						'status'                   => $job_in_progress->status,
					];

					wp_send_json_success( $result );
				}

			} catch ( \Exception $e ) {

				wp_send_json_error( $e->getMessage() );
			}
		}

		/* translators: Placeholder: %s - sync job ID */
		wp_send_json_error( sprintf( esc_html__( 'No sync job in progress found %s', 'woocommerce-square' ), is_string( $job_id ) ? $job_id : null ) );
	}


}
