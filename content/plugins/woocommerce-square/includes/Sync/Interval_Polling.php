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
use WooCommerce\Square\Handlers\Product;

defined( 'ABSPATH' ) or exit;

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

		$next_steps = [];

		if ( $this->is_system_of_record_square() ) {

			$next_steps = [
				'update_product_data',
			];
		}

		// only pull latest inventory if enabled
		if ( wc_square()->get_settings_handler()->is_inventory_sync_enabled() ) {
			$next_steps[] = 'update_inventory_counts';
		}

		$this->set_attr( 'next_steps', $next_steps );
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

		$products_updated = $this->get_attr( 'processed_product_ids', [] );
		$cursor           = $this->get_attr( 'update_product_data_cursor' );

		$response = wc_square()->get_api()->search_catalog_objects( [
			'object_types'            => [ 'ITEM' ],
			'include_deleted_objects' => true,
			'begin_time'              => $date->format( DATE_ATOM ),
			'cursor'                  => $cursor,
		] );

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

						$record = [
							'type'       => 'alert',
							'product_id' => $product->get_id(),
						];

						// if enabled, hide the product from the catalog
						if ( wc_square()->get_settings_handler()->hide_missing_square_products() ) {

							try {

								$product->set_catalog_visibility( 'hidden' );
								$product->save();

								$record['product_hidden'] = true;

							} catch ( \Exception $e ) {}
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

							Records::set_record( [
								'type'       => 'alert',
								'product_id' => $product->get_id(),
							] );
						}
					}
				}
			}
		}

		$cursor = $response->get_data()->getCursor();

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

		$args = [
			'location_ids' => [ wc_square()->get_settings_handler()->get_location_id() ],
			'cursor'       => $cursor,
		];

		$last_synced_at = $this->get_attr( 'inventory_last_synced_at' );

		if ( $last_synced_at ) {

			$date = new \DateTime();
			$date->setTimestamp( $last_synced_at );
			$date->setTimezone( new \DateTimeZone( 'UTC' ) );

			$args['updated_after'] = $date->format( DATE_ATOM );
		}

		$response = wc_square()->get_api()->batch_retrieve_inventory_counts( $args );

		// store the timestamp after the first API request was completed
		// we don't want to set it at the end, as counts may have changed in the time it takes to process the data
		// we also check that this is the first or only request to be made (no cursor) so we don't set it again if there's more data to query
		if ( ! $cursor ) {
			wc_square()->get_sync_handler()->set_inventory_last_synced_at();
		}

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

		$cursor = $response->get_data()->getCursor();

		$this->set_attr( 'update_inventory_counts_cursor', $cursor );
		$this->set_attr( 'processed_product_ids', array_unique( $products_updated ) );

		if ( ! $cursor ) {
			$this->complete_step( 'update_inventory_counts' );
		}
	}


}
