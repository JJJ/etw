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

namespace WooCommerce\Square\Sync;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;
use SquareConnect\Model\SearchCatalogObjectsResponse;
use SquareConnect\Model\BatchRetrieveInventoryCountsResponse;
use WooCommerce\Square\Handlers\Product;
use WooCommerce\Square\Handlers\Category;

defined( 'ABSPATH' ) || exit;

/**
 * Class to represent a synchronization job to poll latest product updates at intervals.
 *
 * @since 2.0.0
 */
class Interval_Polling extends Stepped_Job {


	/**
	 * Assigns the next steps needed for this sync job.
	 *
	 * Adds the next steps to the 'next_steps' attribute.
	 *
	 * @since 2.0.0
	 */
	protected function assign_next_steps() {

		$next_steps = array();

		if ( $this->is_system_of_record_square() ) {

			$next_steps = array(
				'update_category_data',
				'update_product_data',
			);
		}

		// only pull latest inventory if enabled
		if ( wc_square()->get_settings_handler()->is_inventory_sync_enabled() ) {
			$next_steps[] = 'update_inventory_counts';
		}

		$this->set_attr( 'next_steps', $next_steps );
	}

	/**
	 * Updates categories from Square.
	 *
	 * @since 2.0.8
	 *
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	protected function update_category_data() {
		$date = new \DateTime();
		$date->setTimestamp( $this->get_attr( 'catalog_last_synced_at', (int) wc_square()->get_sync_handler()->get_last_synced_at() ) );
		$date->setTimezone( new \DateTimeZone( 'UTC' ) );

		$response = wc_square()->get_api()->search_catalog_objects(
			array(
				'object_types' => array( 'CATEGORY' ),
				'begin_time'   => $date->format( DATE_ATOM ),
			)
		);

		if ( $response->get_data() instanceof SearchCatalogObjectsResponse ) {
			$categories = $response->get_data()->getObjects();

			if ( $categories && is_array( $categories ) ) {
				foreach ( $categories as $category ) {
					Category::import_or_update( $category );
				}

				Records::set_record(
					array(
						'type'    => 'info',
						'message' => sprintf(
							/* translator: Placeholder %d number of categories */
							_n( 'Updated data for %d category.', 'Updated data for %d categories.', count( $categories ), 'woocommerce-square' ),
							count( $categories )
						),
					)
				);
			}
		} else {
			Records::set_record(
				array(
					'type'    => 'alert',
					'message' => esc_html__( 'Product category data could not be updated from Square. Invalid API response.', 'woocommerce-square' ),
				)
			);
		}

		$this->complete_step( 'update_category_data' );
	}

	/**
	 * Updates products from Square.
	 *
	 * @since 2.0.0
	 *
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	protected function update_product_data() {

		$date = new \DateTime();
		$date->setTimestamp( $this->get_attr( 'catalog_last_synced_at', (int) wc_square()->get_sync_handler()->get_last_synced_at() ) );
		$date->setTimezone( new \DateTimeZone( 'UTC' ) );

		$products_updated = $this->get_attr( 'processed_product_ids', array() );
		$cursor           = $this->get_attr( 'update_product_data_cursor' );

		$response = wc_square()->get_api()->search_catalog_objects(
			array(
				'object_types'            => array( 'ITEM' ),
				'include_deleted_objects' => true,
				'begin_time'              => $date->format( DATE_ATOM ),
				'cursor'                  => $cursor,
			)
		);

		// store the timestamp after this API request was completed
		// we don't want to set it at the end, as counts may have changed in the time it takes to process the data
		if ( ! $cursor ) {
			wc_square()->get_sync_handler()->set_last_synced_at();
		}

		if ( $response->get_data() instanceof SearchCatalogObjectsResponse && is_array( $response->get_data()->getObjects() ) ) {

			foreach ( $response->get_data()->getObjects() as $object ) {

				// filter out objects that aren't at our configured location
				if ( ! $object->getPresentAtAllLocations() && ( ! is_array( $object->getPresentAtLocationIds() ) || ! in_array( wc_square()->get_settings_handler()->get_location_id(), $object->getPresentAtLocationIds(), true ) ) ) {
					continue;
				}

				$product = Product::get_product_by_square_id( $object->getId() );

				if ( $product instanceof \WC_Product ) {

					// deleted items won't have any data to set, so don't try and update the product
					if ( $object->getIsDeleted() ) {

						$record = array(
							'type'       => 'alert',
							'product_id' => $product->get_id(),
						);

						// if enabled, hide the product from the catalog
						if ( wc_square()->get_settings_handler()->hide_missing_square_products() ) {

							try {

								$product->set_catalog_visibility( 'hidden' );
								$product->save();

								$record['product_hidden'] = true;

							} catch ( \Exception $e ) {
							}
						}

						Records::set_record( $record );

					} else {

						try {

							Product::update_from_square( $product, $object->getItemData(), false );

							if ( ! $product->get_image_id() && $object->getImageId() ) {
								Product::update_image_from_square( $product, $object->getImageId() );
							}

							$products_updated[] = $product->get_id();

						} catch ( \Exception $exception ) {

							Records::set_record(
								array(
									'type'       => 'alert',
									'product_id' => $product->get_id(),
								)
							);
						}
					}
				}
			}
		}

		$cursor = $response->get_data() instanceof SearchCatalogObjectsResponse ? $response->get_data()->getCursor() : null;

		$this->set_attr( 'update_product_data_cursor', $cursor );
		$this->set_attr( 'processed_product_ids', array_unique( $products_updated ) );

		if ( ! $cursor ) {
			$this->complete_step( 'update_product_data' );
		}
	}


	/**
	 * Updates the inventory counts from the latest in Square.
	 *
	 * Helper method, do not open to public.
	 *
	 * @since 2.0.0
	 *
	 * @throws Framework\SV_WC_API_Exception
	 */
	protected function update_inventory_counts() {

		$products_updated = $this->get_attr( 'processed_product_ids' );
		$cursor           = $this->get_attr( 'update_inventory_counts_cursor' );

		$args = array(
			'location_ids' => array( wc_square()->get_settings_handler()->get_location_id() ),
			'cursor'       => $cursor,
		);

		$last_synced_at = $this->get_attr( 'inventory_last_synced_at' );

		if ( $last_synced_at ) {

			$date = new \DateTime();
			$date->setTimestamp( $last_synced_at );
			$date->setTimezone( new \DateTimeZone( 'UTC' ) );

			$args['updated_after'] = $date->format( DATE_ATOM );
		}

		$response = wc_square()->get_api()->batch_retrieve_inventory_counts( $args );
		$cursor = $response->get_data() instanceof BatchRetrieveInventoryCountsResponse ? $response->get_data()->getCursor() : null;

		// store the start timestamp after the first API request was completed but do not save it now
		// if cursor is present, then it is not the last page. So, use the inventory_last_synced_at time
		// else use the current time
		$last_sync_timestamp = $cursor ? $last_synced_at : current_time( 'timestamp', true );

		foreach ( $response->get_counts() as $count ) {

			// Square can return multiple "types" of counts, WooCommerce only distinguishes whether a product is in stock or not
			if ( 'IN_STOCK' === $count->getState() ) {

				$product = Product::get_product_by_square_variation_id( $count->getCatalogObjectId() );

				if ( $product instanceof \WC_Product ) {

					$product->set_stock_quantity( $count->getQuantity() );
					$product->save();

					$products_updated[] = $product->get_id();
				}
			}
		}

		$this->set_attr( 'update_inventory_counts_cursor', $cursor );
		$this->set_attr( 'processed_product_ids', array_unique( $products_updated ) );

		if ( ! $cursor ) {
			// When all the inventory counts are synced then set the last sync time to the start time that was stored
			wc_square()->get_sync_handler()->set_inventory_last_synced_at( $last_sync_timestamp );
			$this->complete_step( 'update_inventory_counts' );
		}
	}


}
