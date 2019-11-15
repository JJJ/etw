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
use SquareConnect\Model\BatchRetrieveInventoryCountsResponse;
use SquareConnect\Model\BatchUpsertCatalogObjectsResponse;
use SquareConnect\Model\CatalogObject;
use SquareConnect\Model\CatalogObjectBatch;
use SquareConnect\Model\SearchCatalogObjectsResponse;
use SquareConnect\ObjectSerializer;
use WooCommerce\Square\Handlers\Category;
use WooCommerce\Square\Handlers\Product;

defined( 'ABSPATH' ) or exit;

/**
 * Class to represent a single synchronization job triggered manually.
 *
 * @since 2.0.0
 */
class Manual_Synchronization extends Stepped_Job {


	/** @var int the limit for how many objects can be upserted in a batch upsert request */
	const BATCH_UPSERT_OBJECT_LIMIT = 600;

	/** @var int the limit for how many inventory changes can be made in a single request */
	const BATCH_CHANGE_INVENTORY_LIMIT = 100;


	/**
	 * Validates the products attached to this job.
	 *
	 * @since 2.0.0
	 */
	protected function validate_products() {

		$product_ids = $this->get_attr( 'product_ids' );

		$products_query = [
			'include' => $product_ids,
			'limit'   => -1,
			'return'  => 'ids'
		];

		$validated_products = wc_get_products( $products_query );

		if ( 'delete' === $this->get_attr( 'action' ) ) {

			$products_query['status'] = 'trash';
			$trashed_products         = wc_get_products( $products_query );

			$validated_products = array_unique( array_merge( $validated_products, $trashed_products ), SORT_NUMERIC );
		}

		$this->set_attr( 'validated_product_ids', $validated_products );

		$this->complete_step( 'validate_products' );
	}


	/**
	 * Updates the catalog API limits.
	 *
	 * @since 2.0.0
	 */
	protected function update_limits() {

		try {

			$catalog_info = wc_square()->get_api()->catalog_info();

			if ( $catalog_info->get_data() && $catalog_info->get_data()->getLimits() ) {

				$limits = $catalog_info->get_data()->getLimits();

				$this->set_attr( 'max_objects_to_retrieve', $limits->getBatchRetrieveMaxObjectIds() );
				$this->set_attr( 'max_objects_per_batch',   $limits->getBatchUpsertMaxObjectsPerBatch() );
				$this->set_attr( 'max_objects_total',       $limits->getBatchUpsertMaxTotalObjects() );
			}

		} catch ( Framework\SV_WC_Plugin_Exception $exception ) {} // no need to handle errors here

		$this->complete_step( 'update_limits' );
	}


	/**
	 * Extracts the category IDs from the list of product IDs in this job, and saves them.
	 *
	 * @since 2.0.0
	 */
	protected function extract_category_ids() {

		$category_ids = $this->get_shared_category_ids( $this->get_attr( 'validated_product_ids' ) );

		$this->set_attr( 'category_ids', $category_ids );

		$this->complete_step( 'extract_category_ids' );
	}


	/**
	 * Refreshes mappings for categories with known Square IDs.
	 *
	 * @since 2.0.0
	 *
	 * @throws Framework\SV_WC_API_Exception
	 */
	protected function refresh_category_mappings() {

		$map                   = Category::get_map();
		$category_ids          = $this->get_attr( 'refresh_mappings_category_ids', $this->get_attr( 'category_ids' ) );
		$mapped_categories     = [];
		$unmapped_categories   = $this->get_attr( 'unmapped_categories', [] );
		$unmapped_category_ids = [];

		if ( empty( $category_ids ) ) {
			$this->complete_step( 'refresh_category_mappings' );
			return;
		}

		if ( count( $category_ids ) > $this->get_max_objects_to_retrieve() ) {

			$category_ids_batch = array_slice( $category_ids, 0, $this->get_max_objects_to_retrieve() );

			$this->set_attr( 'refresh_mappings_category_ids', array_diff( $category_ids, $category_ids_batch ) );

			$category_ids = $category_ids_batch;

		} else {

			$this->set_attr( 'refresh_mappings_category_ids', [] );
		}

		foreach ( $category_ids as $category_id ) {

			if ( isset( $map[ $category_id ] ) ) {

				$mapped_categories[ $category_id ] = $map[ $category_id ];

			} else {

				$unmapped_category_ids[] = $category_id;
			}
		}

		if ( ! empty( $mapped_categories ) ) {

			$square_ids = array_values( array_filter( array_map( function ( $mapped_category ) {
				return isset( $mapped_category['square_id'] ) ? $mapped_category['square_id'] : null;
			}, $mapped_categories ) ) );

			$response = wc_square()->get_api()->batch_retrieve_catalog_objects( $square_ids );

			// swap the square ID into the array key for quick lookup
			$mapped_category_audit = [];

			foreach ( $mapped_categories as $mapped_category_id => $mapped_category ) {
				$mapped_category_audit[ $mapped_category['square_id'] ] = $mapped_category_id;
			}

			// handle response
			if ( is_array( $response->get_data()->getObjects() ) ) {

				foreach ( $response->get_data()->getObjects() as $category ) {

					// don't check for the name, it will get overwritten by the Woo value anyway
					if ( isset( $mapped_category_audit[ $category->getId() ] ) ) {

						$category_id = $mapped_category_audit[ $category->getId() ];

						$map[ $category_id ]['version'] = $category->getVersion();
						unset( $mapped_category_audit[ $category->getId() ] );
					}
				}
			}

			// any remaining categories were not found in Square and should have their local mapping data removed
			if ( ! empty( $mapped_category_audit ) ) {

				$outdated_category_ids = array_values( $mapped_category_audit );

				foreach ( $outdated_category_ids as $outdated_category_id ) {

					unset( $map[ $outdated_category_id ], $mapped_categories[ $outdated_category_id ] );

					$unmapped_category_ids[] = $outdated_category_id;
				}

				$unmapped_category_ids = array_unique( $unmapped_category_ids );
			}

			// update unmapped list
		}

		if ( ! empty( $unmapped_category_ids ) ) {

			$unmapped_category_terms = get_terms( [
				'taxonomy' => 'product_cat',
				'include'  => $unmapped_category_ids,
			] );

			// make the 'name' attribute the array key, for more efficient searching later.
			foreach ( $unmapped_category_terms as $unmapped_category_term ) {
				$unmapped_categories[ strtolower( wp_specialchars_decode( $unmapped_category_term->name ) ) ] = $unmapped_category_term;
			}
		}

		// save category lists
		$this->set_attr( 'mapped_categories', $mapped_categories );
		$this->set_attr( 'unmapped_categories', $unmapped_categories );

		Category::update_map( $map );
	}


	/**
	 * Checks the Square API for any unmapped categories we may have.
	 *
	 * @since 2.0.0
	 *
	 * @throws Framework\SV_WC_API_Exception
	 */
	protected function query_unmapped_categories() {

		$unmapped_categories = $this->get_attr( 'unmapped_categories', [] );
		$mapped_categories   = $this->get_attr( 'mapped_categories', [] );

		if ( empty( $unmapped_categories ) ) {

			$this->complete_step( 'query_unmapped_categories' );

		} else {

			$response = wc_square()->get_api()->search_catalog_objects( [
				'object_types' => [ 'CATEGORY' ],
				'cursor'       => $this->get_attr( 'unmapped_categories_cursor' ),
			] );

			$category_map = Category::get_map();
			$categories   = $response->get_data()->getObjects();

			if ( is_array( $categories ) ) {

				foreach ( $categories as $category_object ) {

					$unmapped_category_key = strtolower( $category_object->getCategoryData()->getName() );

					if ( isset( $unmapped_categories[ $unmapped_category_key ] ) ) {

						$category_id = $unmapped_categories[ $unmapped_category_key ]['term_id'];

						$category_map[ $category_id ] = [
							'square_id'      => $category_object->getId(),
							'square_version' => $category_object->getVersion(),
						];

						$mapped_categories[] = $category_id;
						unset( $unmapped_categories[ $unmapped_category_key ] );
					}
				}
			}

			Category::update_map( $category_map );
			$this->set_attr( 'mapped_categories', $mapped_categories );
			$this->set_attr( 'unmapped_categories', $unmapped_categories );

			$cursor = $response->get_data()->getCursor();
			$this->set_attr( 'unmapped_categories_cursor', $cursor );

			if ( empty( $cursor ) ) {

				$this->complete_step( 'query_unmapped_categories' );
			}
		}
	}


	/**
	 * Upserts the categories for the selected products to Square.
	 *
	 * @since 2.0.0
	 *
	 * @throws Framework\SV_WC_API_Exception
	 */
	protected function upsert_categories() {

		$category_ids = $this->get_attr( 'category_ids' );
		$categories   = get_terms( [
			'taxonomy' => 'product_cat',
			'include'  => $category_ids,
		] );

		$batches     = [];
		$reverse_map = [];

		// For now, keep it to one category per batch. Since we can still send 1000 batches per request, it's efficient,
		// and insulates errors per category rather than a single category error breaking the entire batch it is in.
		// TODO: Performance - Consider sending larger-sized batches to reduce total requests for shops with thousands of categories.
		// This will require the ability to handle a failed batch, pulling out the error-causing category, and retrying the batch.
		foreach ( $categories as $category ) {

			$category_id    = $category->term_id;
			$square_id      = Category::get_square_id( $category_id );
			$square_version = Category::get_square_version( $category_id );

			$reverse_map[ $square_id ] = $category_id;

			$catalog_object_data = [
				'type'          => 'CATEGORY',
				'id'            => $square_id,
				'category_data' => [
					'name' => wp_specialchars_decode( $category->name ), // names are stored encoded in the database
				]
			];

			if ( 0 < $square_version ) {
				$catalog_object_data['version'] = $square_version;
			}

			$batches[] = new \SquareConnect\Model\CatalogObjectBatch( [ 'objects' => [ new \SquareConnect\Model\CatalogObject( $catalog_object_data ) ] ] );
		}

		$idempotency_key = wc_square()->get_idempotency_key( md5( serialize( $batches ) . $this->get_attr( 'id' ) ) . '_upsert_categories' );

		$result = wc_square()->get_api()->batch_upsert_catalog_objects( $idempotency_key, $batches );

		// new entries to Square will return in the ID Mapping
		if ( $id_mappings = $result->get_data()->getIdMappings() ) {

			foreach ( $id_mappings as $id_mapping ) {

				$client_object_id = $id_mapping->getClientObjectId();
				$remote_object_id = $id_mapping->getObjectId();

				if ( isset( $reverse_map[ $client_object_id ] ) ) {

					$reverse_map[ $remote_object_id ] = $reverse_map[ $client_object_id ];
					unset( $reverse_map[ $client_object_id ] );
				}
			}
		}

		foreach ( $result->get_data()->getObjects() as $upserted_category ) {

			$id      = $upserted_category->getId();
			$version = $upserted_category->getVersion();

			if ( isset( $reverse_map[ $id ] ) ) {

				Category::update_mapping( $reverse_map[ $id ], $id, $version );
				unset( $reverse_map[ $id ] );
			}
		}

		$this->complete_step( 'upsert_categories' );
	}


	/**
	 * Prepares a set of products that already have a Square ID set and are found in the catalog.
	 *
	 * @since 2.0.0
	 *
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	protected function prepare_matched_products_for_upsert() {

		$product_ids_to_prepare = $this->get_attr( 'product_ids_to_prepare', $this->get_attr( 'validated_product_ids', [] ) );
		$in_progress            = $this->get_attr( 'in_progress_prepare_matched_products_for_upsert', [] );

		if ( empty( $product_ids_to_prepare ) ) {
			$this->complete_step( 'prepare_matched_products_for_upsert' );
			return;
		}

		if ( isset( $in_progress['product_ids'] ) && ! empty( $in_progress['product_ids'] ) ) {
			$product_ids = $in_progress['product_ids'];
		} elseif ( count( $product_ids_to_prepare ) > $this->get_max_objects_to_retrieve() ) {
			$product_ids = array_slice( $product_ids_to_prepare, 0, $this->get_max_objects_to_retrieve() );
		} else {
			$product_ids = $product_ids_to_prepare;
		}

		$in_progress['product_ids'] = $product_ids;

		$products_map = Product::get_square_meta( $product_ids, 'square_item_id' );
		$square_ids   = array_keys( $products_map );

		// none of the products have square IDs - move to the next batch
		if ( empty( $square_ids ) ) {
			$this->set_attr( 'product_ids_to_prepare', array_diff( $product_ids_to_prepare, $product_ids ) );
			return;
		}

		if ( $this->is_time_exceeded() ) {
			wc_square()->log( 'Time exceeded preparing matched products for upsert' );
			$this->set_attr( 'in_progress_prepare_matched_products_for_upsert', $in_progress );
			return;
		}

		$response = null;

		// attempt to restore the response from the in-progress data
		if ( isset( $in_progress['api_response'] ) ) {

			try {

				$objects      = [];
				$api_response = json_decode( $in_progress['api_response'], true );

				if ( isset( $api_response['objects'] ) ) {
					foreach ( $api_response['objects'] as $object ) {
						$objects[] = new CatalogObject( $object );
					}
				}

				$response = new \SquareConnect\Model\BatchRetrieveCatalogObjectsResponse( [ 'objects' => $objects ] );

			} catch ( \Exception $e ) {}
		}

		if ( null === $response ) {

			$api_response = wc_square()->get_api()->batch_retrieve_catalog_objects( $square_ids );

			if ( ! $api_response->get_data() ) {
				throw new Framework\SV_WC_API_Exception( 'Response data is missing' );
			}

			$in_progress['api_response'] = json_encode( json_decode( $api_response->get_data() . '', true ) ); // convert the response to a string and un-pretty-print it
			$response                    = $api_response->get_data();
		}

		if ( $this->is_time_exceeded() ) {
			$this->set_attr( 'in_progress_prepare_matched_products_for_upsert', $in_progress );
			return;
		}

		$catalog_objects = isset( $in_progress['catalog_objects'] ) ? $in_progress['catalog_objects'] : [];

		if ( $response && $response_objects = $response->getObjects() ) {

			foreach ( $response_objects as $index => $catalog_object ) {

				if ( $this->is_time_exceeded() ) {

					$response->setObjects( $response_objects );
					$in_progress['api_response']    = json_encode( json_decode( $response . '', true ) );
					$in_progress['catalog_objects'] = $catalog_objects;

					$this->set_attr( 'in_progress_prepare_matched_products_for_upsert', $in_progress );
					return;
				}

				if ( ! empty( $products_map[ $catalog_object->getId() ]['product_id'] ) ) {

					$product_id = $products_map[ $catalog_object->getId() ]['product_id'];

					$catalog_objects[ $product_id ] = json_encode( json_decode( $catalog_object . '', true ) ); // convert the object to a string
				}

				unset( $response_objects[ $index ] );
			}
		}

		$matched_products_to_upsert = $this->get_attr( 'matched_products_to_upsert', [] );

		$this->set_attr( 'matched_products_to_upsert', $matched_products_to_upsert + $catalog_objects );
		$this->set_attr( 'product_ids_to_prepare', array_diff( $product_ids_to_prepare, $product_ids ) );
		$this->set_attr( 'in_progress_prepare_matched_products_for_upsert', [] );
	}


	/**
	 * Upserts matched products that have been updated with Woo data to Square.
	 *
	 * @since 2.0.0
	 *
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	protected function upsert_matched_products() {

		$matched_products_to_upsert = $this->get_attr( 'matched_products_to_upsert', [] );

		if ( empty( $matched_products_to_upsert ) ) {

			$this->complete_step( 'upsert_matched_products' );
			return;
		}

		// this method ends early in case of timeouts
		$result = $this->upsert_catalog_objects( $matched_products_to_upsert );

		if ( isset( $result['processed'] ) ) {

			$processed_product_ids = $this->get_attr( 'processed_product_ids', [] );

			$this->set_attr( 'processed_product_ids', array_merge( $processed_product_ids, $result['processed'] ) );

			$matched_products_to_upsert = array_diff_key( $matched_products_to_upsert, array_flip( $result['processed'] ) );
			$this->set_attr( 'matched_products_to_upsert', $matched_products_to_upsert );
		}
	}


	/**
	 * Updates a set of products that already have a Square ID set and are found in the catalog.
	 *
	 * @since 2.0.0
	 *
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	protected function update_matched_products() {

		$product_ids           = $this->get_attr( 'matched_product_ids', $this->get_attr( 'validated_product_ids', [] ) );
		$processed_product_ids = $this->get_attr( 'processed_product_ids', [] );

		// remove IDs that have already been processed
		$product_ids = array_diff( $product_ids, $processed_product_ids );

		if ( empty( $product_ids ) ) {

			$this->complete_step( 'update_matched_products' );
			return;
		}

		if ( count( $product_ids ) > $this->get_max_objects_to_retrieve() ) {

			$product_ids_batch = array_slice( $product_ids, 0, $this->get_max_objects_to_retrieve() );

			$this->set_attr( 'matched_product_ids', array_diff( $product_ids, $product_ids_batch ) );

			$product_ids = $product_ids_batch;

		} else {

			$this->set_attr( 'matched_product_ids', [] );
		}

		$products_map = Product::get_square_meta( $product_ids, 'square_item_id' );
		$square_ids   = array_keys( $products_map );

		if ( empty( $square_ids ) ) {
			return;
		}

		$response = wc_square()->get_api()->batch_retrieve_catalog_objects( $square_ids );

		if ( ! $response->get_data() ) {
			throw new Framework\SV_WC_API_Exception( 'Response data is missing' );
		}

		$catalog_objects = [];

		if ( $response->get_data()->getObjects() ) {

			foreach ( $response->get_data()->getObjects() as $catalog_object ) {

				if ( ! empty( $products_map[ $catalog_object->getId() ]['product_id'] ) ) {

					$product_id = $products_map[ $catalog_object->getId() ]['product_id'];

					$catalog_objects[ $product_id ] = $catalog_object;
				}
			}
		}

		if ( ! empty( $catalog_objects ) ) {

			$result = $this->upsert_catalog_objects( $catalog_objects );

			$this->set_attr( 'processed_product_ids', array_merge( $result['processed'], $processed_product_ids ) );

			// any products that were staged but not processed, push to the matched array to try next time
			$matched_product_ids = $this->get_attr( 'matched_product_ids', [] );
			$this->set_attr( 'matched_product_ids', array_merge( $result['unprocessed'], $matched_product_ids ) );
		}
	}


	/**
	 * Searches the full Square catalog to find matches and updates them.
	 *
	 * @since 2.0.0
	 *
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	protected function search_matched_products() {

		$product_ids           = $this->get_attr( 'search_product_ids', $this->get_attr( 'validated_product_ids', [] ) );
		$processed_product_ids = $this->get_attr( 'processed_product_ids', [] );
		$in_progress           = $this->get_attr( 'in_progress_search_matched_products', [
			'unprocessed_search_response' => null,
			'processed_remote_object_ids' => [],
			'catalog_objects_to_update'   => [],
			'upserting'                   => false,
		] );

		// remove IDs that have already been processed
		$product_ids = array_diff( $product_ids, $processed_product_ids );

		if ( empty( $product_ids ) ) {

			$this->complete_step( 'search_matched_products' );
			return;
		}

		// at this point nothing has been done, so nothing to save
		if ( $this->is_time_exceeded() ) {
			wc_square()->log( 'Time exceeded (search_matched_products)' );
			return;
		}

		$products_map = Product::get_square_meta( $product_ids, 'square_item_id' );

		if ( ! empty( $in_progress['unprocessed_search_response'] ) ) {

			$search_response = ObjectSerializer::deserialize( json_decode( $in_progress['unprocessed_search_response'], false ), SearchCatalogObjectsResponse::class );

		} else {

			$response = wc_square()->get_api()->search_catalog_objects( [
				'cursor'       => $this->get_attr( 'search_products_cursor' ),
				'object_types' => [ 'ITEM' ],
				'limit'        => $this->get_max_objects_to_retrieve(),
			] );

			$search_response = $response->get_data();

			$in_progress['unprocessed_search_response'] = json_encode( json_decode( $search_response . '', true ) );
		}

		if ( ! $search_response ) {
			throw new Framework\SV_WC_API_Exception( 'Response data is missing' );
		}

		$catalog_objects           = $search_response->getObjects() ?: [];
		$cursor                    = $search_response->getCursor();
		$catalog_objects_to_update = $in_progress['catalog_objects_to_update'];

		if ( true !== $in_progress['upserting'] ) {

			wc_square()->log( 'Searching through ' . count( $catalog_objects ) . ' catalog objects' );

			foreach ( $catalog_objects as $catalog_object ) {

				if ( $this->is_time_exceeded() ) {

					$this->set_attr( 'in_progress_search_matched_products', $in_progress );
					wc_square()->log( 'Time exceeded (search_matched_products)' );

					return;
				}

				$remote_object_id = $catalog_object->getId();

				if ( in_array( $remote_object_id, $in_progress['processed_remote_object_ids'], true ) ) {
					continue;
				}

				if ( isset( $products_map[ $remote_object_id ]['product_id'] ) ) {

					$product_id = $products_map[ $remote_object_id ]['product_id'];

					// update the product's meta
					if ( $product = wc_get_product( $product_id ) ) {
						Product\Woo_SOR::update_product( $product, $catalog_object );
					}

					foreach ( $catalog_object->getItemData()->getVariations() as $catalog_variation ) {

						if ( $variation_product_id = Product::get_product_id_by_square_variation_id( $catalog_variation->getId() ) ) {

							$variation = wc_get_product( $variation_product_id );

							if ( $variation ) {
								Product\Woo_SOR::update_variation( $variation, $catalog_variation );
							}
						}
					}

					$catalog_objects_to_update[ $product_id ] = json_encode( json_decode( $catalog_object . '', true ) );

				} else {

					// no variations? no sku
					if ( ! is_array( $catalog_object->getItemData()->getVariations() ) ) {
						continue;
					}

					$product_id     = 0;
					$matched_object = null;

					foreach ( $catalog_object->getItemData()->getVariations() as $catalog_variation ) {

						$product_id = wc_get_product_id_by_sku( $catalog_variation->getItemVariationData()->getSku() );

						$product = wc_get_product( $product_id );

						if ( ! $product ) {
							continue;
						}

						if ( $product->get_parent_id() && $parent_product = wc_get_product( $product->get_parent_id() ) ) {
							$product = $parent_product;
						}

						if ( ! in_array( $product->get_id(), $product_ids, false ) ) {
							continue;
						}

						$product_id     = $product->get_id();
						$matched_object = $catalog_object;

						break;
					}

					if ( $product_id && $matched_object ) {
						$catalog_objects_to_update[ $product_id ] = json_encode( json_decode( $matched_object . '', true ) );
					}
				}

				$in_progress['processed_remote_object_ids'][] = $remote_object_id;
				$in_progress['catalog_objects_to_update']     = $catalog_objects_to_update;
			}
		}

		$in_progress['upserting'] = true;

		$catalog_processed = ! $cursor;

		$remaining_product_ids = array_diff( $product_ids, array_keys( $catalog_objects_to_update ) );

		if ( ! empty( $catalog_objects_to_update ) ) {

			$result = $this->upsert_catalog_objects( $catalog_objects_to_update );

			$processed_product_ids = array_merge( $result['processed'], $processed_product_ids );
			$this->set_attr( 'processed_product_ids', $processed_product_ids );

			if ( ! empty( $result['unprocessed'] ) ) {

				$catalog_processed = false;
				$remaining_product_ids = array_merge( $result['unprocessed'], $remaining_product_ids );
				$in_progress['catalog_objects_to_update'] = array_diff_key( $catalog_objects_to_update, array_flip( $processed_product_ids ) );

			} else {

				$in_progress = null;
			}

			$this->set_attr( 'in_progress_search_matched_products', $in_progress );
		}

		if ( ! $catalog_processed && ! empty( $remaining_product_ids ) ) {

			$this->set_attr( 'search_products_cursor', $cursor );
			$this->set_attr( 'search_product_ids',     $remaining_product_ids );

		} else {

			Product::clear_square_meta( $remaining_product_ids );
			$this->complete_step( 'search_matched_products' );
		}
	}


	/**
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	protected function upsert_new_products() {

		$product_ids           = $this->get_attr( 'upsert_new_product_ids', $this->get_attr( 'validated_product_ids', [] ) );
		$processed_product_ids = $this->get_attr( 'processed_product_ids', [] );

		// remove IDs that have already been processed
		$product_ids = array_diff( $product_ids, $processed_product_ids );

		if ( empty( $product_ids ) ) {

			$this->complete_step( 'upsert_new_products' );
			return;
		}

		$catalog_objects = [];

		foreach ( $product_ids as $product_id ) {

			$catalog_objects[ $product_id ] = new CatalogObject( [
				'type'      => 'ITEM',
				'item_data' => new \SquareConnect\Model\CatalogItem(),
			] );
		}

		$result = $this->upsert_catalog_objects( $catalog_objects );

		// newly upserted IDs should get their inventory pushed
		$this->set_attr( 'inventory_push_product_ids', $result['processed'] );

		$processed_product_ids = array_merge( $result['processed'], $processed_product_ids );

		$this->set_attr( 'processed_product_ids', $processed_product_ids );

		if ( ! empty( $result['unprocessed'] ) ) {

			$this->set_attr( 'upsert_new_product_ids', $result['unprocessed'] );

		} else {

			// at this point, log a failure for any products that weren't processed
			foreach ( array_diff( $product_ids, $processed_product_ids ) as $product_id ) {
				Records::set_record( $product_id );
			}

			$this->complete_step( 'upsert_new_products' );
		}
	}


	/**
	 * Upserts a list of catalog objects and updates their cooresponding products.
	 *
	 * @since 2.0.0
	 *
	 * @param array $objects list of catalog objects to update, as $product_id => CatalogItem
	 * @return array
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	protected function upsert_catalog_objects( array $objects ) {

		wc_square()->log( 'Upserting ' . count( $objects ) . ' catalog objects' );

		$is_delete_action       = 'delete' === $this->get_attr( 'action' );
		$product_ids            = array_keys( $objects );
		$staged_product_ids     = [];
		$successful_product_ids = [];
		$total_object_count     = 0;
		$batches                = [];
		$result                 = [
			'processed'   => [],
			'unprocessed' => $product_ids,
		];

		$in_progress = $this->get_attr( 'in_progress_upsert_catalog_objects', [
			'batches'                           => [],
			'staged_product_ids'                => [],
			'total_object_count'                => null,
			'unprocessed_upsert_response'       => null,
			'mapped_client_item_ids'            => [],
			'processed_remote_catalog_item_ids' => []
		] );

		if ( null === $in_progress['unprocessed_upsert_response'] ) {

			// need all three items to restore from in-progress
			if ( ! empty( $in_progress['batches'] ) && ! empty( $in_progress['staged_product_ids'] ) && ! empty( $in_progress['total_object_count'] ) ) {

				$staged_product_ids = $in_progress['staged_product_ids'];
				$total_object_count = $in_progress['total_object_count'];
				$batches            = array_map( static function ( $batch_data ) {
					return ObjectSerializer::deserialize( json_decode( $batch_data, false ), CatalogObjectBatch::class );
				}, $in_progress['batches'] );
			}

			foreach ( $objects as $product_id => $object ) {

				if ( $this->is_time_exceeded() ) {

					$in_progress['staged_product_ids'] = $staged_product_ids;
					$in_progress['total_object_count'] = $total_object_count;
					$in_progress['batches']            = array_map( 'strval', $batches );

					$this->set_attr( 'in_progress_upsert_catalog_objects', $in_progress );
					wc_square()->log( 'Time exceeded (upsert_catalog_objects)' );

					return $result;
				}

				if ( in_array( $product_id, $staged_product_ids, true ) ) {
					continue;
				}

				if ( ! $object instanceof CatalogObject ) {
					$object = $this->convert_to_catalog_object( $object );
				}

				$catalog_item = new Catalog_Item( $product_id, $is_delete_action );
				$batch        = $catalog_item->get_batch( $object );
				$object_count = $catalog_item->get_batch_object_count();

				if ( $this->get_max_objects_total() >= $object_count + $total_object_count ) {
					$batches[]            = $batch;
					$total_object_count   += $object_count;
					$staged_product_ids[] = $product_id;
				} else {
					break;
				}
			}
		}

		$upsert_response = null;

		if ( null !== $in_progress['unprocessed_upsert_response'] ) {
			$upsert_response = ObjectSerializer::deserialize( json_decode( $in_progress['unprocessed_upsert_response'], false ), BatchUpsertCatalogObjectsResponse::class );
		}

		if ( ! $upsert_response instanceof BatchUpsertCatalogObjectsResponse ) {

			$start = microtime( true );

			$idempotency_key = wc_square()->get_idempotency_key( md5( serialize( $batches ) ) . '_upsert_products' );
			$response        = wc_square()->get_api()->batch_upsert_catalog_objects( $idempotency_key, $batches );
			$upsert_response = $response->get_data();

			if ( ! $upsert_response instanceof BatchUpsertCatalogObjectsResponse ) {
				throw new Framework\SV_WC_API_Exception( 'API response data is missing' );
			}

			$duration = number_format( microtime( true ) - $start, 2 );

			wc_square()->log( 'Upserted ' . count( $upsert_response->getObjects() ) . ' objects in ' . $duration . 's' );

			$in_progress['unprocessed_upsert_response'] = $response->get_data() . '';
		}

		if ( $this->is_time_exceeded() ) {

			$this->set_attr( 'in_progress_upsert_catalog_objects', $in_progress );
			wc_square()->log( 'Time exceeded (upsert_catalog_objects)' );

			return $result;
		}

		// update local square meta for newly upserted objects
		if ( ! $is_delete_action && $upsert_response instanceof BatchUpsertCatalogObjectsResponse && is_array( $upsert_response->getIdMappings() ) ) {

			wc_square()->log( 'Mapping new Square item IDs to WooCommerce product IDs' );

			$start = microtime( true );

			foreach ( $upsert_response->getIdMappings() as $id_mapping ) {

				if ( $this->is_time_exceeded() ) {

					$this->set_attr( 'in_progress_upsert_catalog_objects', $in_progress );
					wc_square()->log( 'Time exceeded (upsert_catalog_objects)' );

					return $result;
				}

				$client_item_id = $id_mapping->getClientObjectId();
				$remote_item_id = $id_mapping->getObjectId();

				if ( in_array( $client_item_id, $in_progress['mapped_client_item_ids'], true ) ) {
					continue;
				}

				if ( 0 === strpos( $client_item_id, '#item_variation_' ) ) {

					$product_id = substr( $client_item_id, strlen( '#item_variation_' ) );
					Product::set_square_item_variation_id( $product_id, $remote_item_id );

				} elseif ( 0 === strpos( $client_item_id, '#item_' ) ) {

					$product_id = substr( $client_item_id, strlen( '#item_' ) );
					Product::set_square_item_id( $product_id, $remote_item_id );
				}

				$in_progress['mapped_client_item_ids'][] = $client_item_id;
			}

			$duration = number_format( microtime( true ) - $start, 2 );

			wc_square()->log( 'Mapped ' . count( $in_progress['mapped_client_item_ids'] ) . ' Square IDs in ' . $duration . 's' );
		}

		$pull_inventory_variation_ids = $this->get_attr( 'pull_inventory_variation_ids', [] );

		wc_square()->log( 'Storing Square item data to WooCommerce products' );

		$start = microtime( true );

		// loop through all returned objects and store their IDs to Woo products
		foreach ( $upsert_response->getObjects() as $remote_catalog_item ) {

			if ( $this->is_time_exceeded() ) {

				$this->set_attr( 'in_progress_upsert_catalog_objects', $in_progress );
				wc_square()->log( 'Time exceeded (upsert_catalog_objects)' );

				return $result;
			}

			$remote_item_id = $remote_catalog_item->getId();

			if ( in_array( $remote_item_id, $in_progress['processed_remote_catalog_item_ids'], true ) ) {
				continue;
			}

			$product = Product::get_product_by_square_id( $remote_item_id );

			if ( ! $product ) {
				$in_progress['processed_remote_catalog_item_ids'][] = $remote_item_id;
				continue;
			}

			Product::update_square_meta( $product, [
				'item_id'       => $remote_item_id,
				'item_version'  => $remote_catalog_item->getVersion(),
				'item_image_id' => $remote_catalog_item->getImageId(),
			] );

			$successful_product_ids[] = $product->get_id();

			if ( is_array( $remote_catalog_item->getItemData()->getVariations() ) ) {

				foreach ( $remote_catalog_item->getItemData()->getVariations() as $catalog_item_variation ) {

					if ( $product_variation = Product::get_product_by_square_variation_id( $catalog_item_variation->getId() ) ) {

						$pull_inventory_variation_ids[] = $catalog_item_variation->getId();

						Product::update_square_meta( $product_variation, [
							'item_variation_id'      => $catalog_item_variation->getId(),
							'item_variation_version' => $catalog_item_variation->getVersion(),
						] );
					}
				}
			}

			if ( $this->is_time_exceeded() ) {

				$this->set_attr( 'in_progress_upsert_catalog_objects', $in_progress );
				wc_square()->log( 'Time exceeded (upsert_catalog_objects)' );

				return $result;
			}

			// there is no batch image endpoint
			$this->push_product_image( $product );

			$in_progress['processed_remote_catalog_item_ids'][] = $remote_item_id;

			$result['processed'][] = $product->get_id();
			$result['unprocessed'] = array_diff( $product_ids, $result['processed'] );
		}

		$this->set_attr( 'pull_inventory_variation_ids', $pull_inventory_variation_ids );

		$duration = number_format( microtime( true ) - $start, 2 );

		wc_square()->log( 'Stored Square data to ' . count( $result['processed'] ) . ' products in ' . $duration . 's' );

		// log any failed products
		foreach ( array_diff( $staged_product_ids, $successful_product_ids ) as $product_id ) {

			Records::set_record( [
				'type'       => 'alert',
				'product_id' => $product_id,
				'message'    => __( 'Product could not be updated in Square', 'woocommerce-square' ),
			] );
		}

		$this->set_attr( 'in_progress_upsert_catalog_objects', null );

		$result['processed']   = $staged_product_ids;
		$result['unprocessed'] = array_diff( $product_ids, $staged_product_ids );

		return $result;
	}


	/**
	 * Converts object data to an instance of CatalogObject.
	 *
	 * @since 2.0.0
	 *
	 * @param array|string $object_data json string or array of object data
	 * @return CatalogObject
	 */
	protected function convert_to_catalog_object( $object_data ) {

		if ( is_string( $object_data ) ) {
			$object_data = json_decode( $object_data, false );
		}

		$object = ObjectSerializer::deserialize( $object_data, CatalogObject::class );

		return $object instanceof CatalogObject ? $object : null;
	}


	/**
	 * Pushes a product's image to Square.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product|int $product product object or ID
	 */
	protected function push_product_image( $product ) {

		$product = wc_get_product( $product );

		if ( ! $product instanceof \WC_Product || ! $product->get_image_id() ) {
			return;
		}

		$local_image_id = $product->get_image_id();

		// if there is no image, or if the latest uploaded image is the same
		if ( ! $local_image_id || $local_image_id == $product->get_meta( '_square_uploaded_image_id' ) ) {
			return;
		}

		if ( $image_path = get_attached_file( $local_image_id ) ) {

			try {

				$image_id = wc_square()->get_api()->create_image( $image_path, Product::get_square_item_id( $product ), $product->get_name() );

				Product::set_square_image_id( $product, $image_id );

				// record the WC image ID that was uploaded
				$product->update_meta_data( '_square_uploaded_image_id', $local_image_id );
				$product->save_meta_data();

			} catch ( Framework\SV_WC_API_Exception $exception ) {

				if ( wc_square()->get_settings_handler()->is_debug_enabled() ) {
					wc_square()->log( 'Could not upload image for product #' . $product->get_id() . ': ' . $exception->getMessage() );
				}
			}
		}
	}


	/**
	 * Pushes WooCommerce inventory to Square for synced items.
	 *
	 * @since 2.0.0
	 *
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	protected function push_inventory() {

		$product_ids            = $this->get_attr( 'inventory_push_product_ids', [] );
		$inventory_changes      = [];
		$inventory_change_count = 0;

		foreach ( $product_ids as $key => $product_id ) {

			$product = wc_get_product( $product_id );

			if ( $product instanceof \WC_Product ) {

				$product_inventory_changes = [];

				if ( $product->is_type( 'variable' ) && $product->has_child() ) {

					foreach ( $product->get_children() as $child_id ) {

						$child = wc_get_product( $child_id );

						if ( $child instanceof \WC_Product && $inventory_change = Product::get_inventory_change( $child ) ) {

							$product_inventory_changes[] = $inventory_change;
						}
					}

				} elseif ( $square_variation_id = Product::get_square_item_variation_id( $product_id, false ) ) {

					if ( $inventory_change = Product::get_inventory_change( $product ) ) {

						$product_inventory_changes[] = $inventory_change;
					}
				}

				if ( self::BATCH_CHANGE_INVENTORY_LIMIT >= $inventory_change_count + count( $product_inventory_changes ) ) {

					$inventory_changes[]     = $product_inventory_changes;
					$inventory_change_count += count( $product_inventory_changes );
					unset( $product_ids[ $key ] );

				} else {

					break;
				}

			} else {

				unset( $product_ids[ $key ] );
			}
		}

		if ( ! empty( $inventory_changes ) ) {

			$inventory_changes = array_merge( ...$inventory_changes );
			$idempotency_key   = wc_square()->get_idempotency_key( md5( serialize( $inventory_changes ) ) . '_change_inventory' );
			$result            = wc_square()->get_api()->batch_change_inventory( $idempotency_key, $inventory_changes );
		}

		$this->set_attr( 'inventory_push_product_ids', $product_ids );

		if ( empty( $product_ids ) ) {

			$this->complete_step( 'push_inventory' );
		}
	}


	/**
	 * Performs a sync when Square is the system of record.
	 *
	 * @since 2.0.0
	 */
	protected function square_sor_sync() {

		$synced_product_ids      = $this->get_attr( 'validated_product_ids', [] );
		$processed_product_ids   = $this->get_attr( 'processed_product_ids', [] );
		$unprocessed_product_ids = array_diff( $synced_product_ids, $processed_product_ids );
		$catalog_processed       = $this->get_attr( 'catalog_processed', false );

		if ( $catalog_processed ) {

			wc_square()->log( 'Square catalog fully processed' );

			if ( ! empty( $unprocessed_product_ids ) ) {
				$this->mark_failed_products( $unprocessed_product_ids );
			}

			$this->complete_step( 'square_sor_sync' );
			return;
		}

		try {

			$response_data = $this->get_attr( 'catalog_objects_search_response_data', null );

			if ( ! $response_data ) {

				wc_square()->log( 'Generating a new catalog search request' );

				$cursor = $this->get_attr( 'square_sor_cursor' );

				$response = wc_square()->get_api()->search_catalog_objects( [
					'cursor'       => $cursor,
					'object_types' => [ 'ITEM' ],
					'limit'        => $this->get_max_objects_to_retrieve(),
				] );

				$response_data = $response->get_data();

				$this->set_attr( 'catalog_objects_search_response_data', $response_data . '' );

			} else {

				$response_data = ObjectSerializer::deserialize( json_decode( $response_data, false ), SearchCatalogObjectsResponse::class );
			}

			if ( ! $response_data instanceof SearchCatalogObjectsResponse ) {
				throw new Framework\SV_WC_API_Exception( 'API response data is missing' );
			}

			$cursor = $response_data->getCursor();
			$this->set_attr( 'square_sor_cursor', $cursor );

			$catalog_processed = ! $cursor;
			$this->set_attr( 'catalog_processed', $catalog_processed );

		// bail early and fail for any API and plugin errors
		} catch ( \Exception $exception ) {

			$this->fail( 'Product sync failed. ' . $exception->getMessage() );
			return;
		}

		$pull_inventory_variation_ids = $this->get_attr( 'pull_inventory_variation_ids', [] );

		/** @var \SquareConnect\Model\CatalogObject[] */
		$catalog_objects = $products_to_update = [];

		wc_square()->log( 'Searching for products in ' . count( $response_data->getObjects() ) . ' Square objects' );

		foreach ( $response_data->getObjects() as $object ) {

			$found_product = null;

			if ( ! $object instanceof CatalogObject ) {
				continue;
			}

			// filter out objects that aren't at our configured location
			if ( ! $object->getPresentAtAllLocations() && ( ! is_array( $object->getPresentAtLocationIds() ) || ! in_array( wc_square()->get_settings_handler()->get_location_id(), $object->getPresentAtLocationIds(), true ) ) ) {
				continue;
			}

			// even simple items have a single variation
			if ( ! is_array( $object->getItemData()->getVariations() ) ) {
				continue;
			}

			foreach ( $object->getItemData()->getVariations() as $variation ) {

				$found_product_id = wc_get_product_id_by_sku( $variation->getItemVariationData()->getSku() );

				// bail if this product has already been processed
				if ( in_array( $found_product_id, $processed_product_ids, false ) ) {
					break;
				}

				$found_product = wc_get_product( $found_product_id );

				if ( ! $found_product ) {
					continue;
				}

				if ( $found_product instanceof \WC_Product_Variation ) {

					$found_variation = $found_product;
					$found_parent_id = $found_product->get_parent_id() ?: 0;
					$found_product   = null;

					// bail if this parent product has already been processed
					if ( in_array( $found_parent_id, $processed_product_ids, false ) ) {
						break;
					}

					$found_parent = wc_get_product( $found_parent_id );

					if ( $found_parent ) {

						Product::set_square_item_variation_id( $found_variation, $variation->getId() );

						$found_product = $found_parent;
					}

					break;

				} else {

					Product::set_square_item_variation_id( $found_product, $variation->getId() );
				}
			}

			if ( $found_product && in_array( $found_product->get_id(), $synced_product_ids, false ) ) {

				Product::set_square_item_id( $found_product, $object->getId() );

				$products_to_update[] = $found_product;

				$catalog_objects[ $found_product->get_id() ] = $object;
			}
		}

		wc_square()->log( 'Found ' . count( $products_to_update ) . ' products with matching SKUs' );

		// Square SOR always gets the latest inventory
		// set this before processing so nothing is missed during processing
		wc_square()->get_sync_handler()->set_inventory_last_synced_at();

		foreach ( $products_to_update as $product ) {

			try {

				$square_object = ! empty( $catalog_objects[ $product->get_id() ] ) ? $catalog_objects[ $product->get_id() ] : null;

				// if no Square object was found, log as a failure
				if ( ! $square_object ) {
					throw new Framework\SV_WC_Plugin_Exception( 'Product does not exist in the Square catalog' );
				}

				foreach ( $square_object->getItemData()->getVariations() as $variation ) {
					$pull_inventory_variation_ids[] = $variation->getId();
				}

				Product::update_from_square( $product, $square_object->getItemData(), false );

				if ( ! $product->get_image_id() && $square_object->getImageId() ) {
					Product::update_image_from_square( $product, $square_object->getImageId() );
				}

			} catch ( Framework\SV_WC_Plugin_Exception $exception ) {

				$this->mark_failed_products( [ $product ] );
			}

			$processed_product_ids[] = $product->get_id();
		}

		$this->set_attr( 'catalog_objects_search_response_data', null );

		$this->set_attr( 'pull_inventory_variation_ids', $pull_inventory_variation_ids );

		$this->set_attr( 'processed_product_ids', $processed_product_ids );
	}


	/**
	 * Pulls the latest inventory counts for the variation IDs in `pull_inventory_variation_ids`.
	 *
	 * @since 2.0.2
	 *
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	protected function pull_inventory() {

		$processed_ids = $this->get_attr( 'processed_square_variation_ids', [] );

		$in_progress = wp_parse_args( $this->get_attr( 'in_progress_pull_inventory', [] ), [
			'response_data'           => null,
			'processed_variation_ids' => [],
		] );

		$response_data = null;

		// if a response was never cleared, we likely had a timeout
		if ( null !== $in_progress['response_data'] ) {
			$response_data = ObjectSerializer::deserialize( json_decode( $in_progress['response_data'], false ), BatchRetrieveInventoryCountsResponse::class );
		}

		// if the saved response was somehow corrupted, start over
		if ( ! $response_data instanceof BatchRetrieveInventoryCountsResponse ) {

			$square_variation_ids = $this->get_attr( 'pull_inventory_variation_ids', [] );

			// remove IDs that have already been processed
			$square_variation_ids = array_diff( $square_variation_ids, $processed_ids );

			if ( empty( $square_variation_ids ) ) {

				$this->complete_step( 'pull_inventory' );
				return;
			}

			if ( count( $square_variation_ids ) > 100 ) {

				$variation_ids_batch = array_slice( $square_variation_ids, 0, 100 );

				$this->set_attr( 'pull_inventory_variation_ids', array_diff( $square_variation_ids, $variation_ids_batch ) );

				$square_variation_ids = $variation_ids_batch;
			}

			$response = wc_square()->get_api()->batch_retrieve_inventory_counts( [
				'catalog_object_ids' => array_values( $square_variation_ids ),
				'location_ids'       => [ wc_square()->get_settings_handler()->get_location_id() ],
			] );

			if ( ! $response->get_data() instanceof BatchRetrieveInventoryCountsResponse ) {
				throw new Framework\SV_WC_Plugin_Exception( 'Response data missing or invalid' );
			}

			$response_data = $response->get_data();

			// if no counts were returned, there's nothing to process
			if ( ! is_array( $response_data->getCounts() ) ) {

				$this->set_attr( 'processed_square_variation_ids', array_merge( $processed_ids, $square_variation_ids ) );
				return;
			}

			$in_progress['response_data'] = $response_data . '';
		}

		foreach ( $response_data->getCounts() as $count ) {

			if ( in_array( $count->getCatalogObjectId(), $in_progress['processed_variation_ids'], false ) ) {
				continue;
			}

			if ( $this->is_time_exceeded() ) {

				$this->set_attr( 'in_progress_pull_inventory', $in_progress );

				wc_square()->log( 'Time exceeded (pull_inventory)' );
				return;
			}

			// Square can return multiple "types" of counts, WooCommerce only distinguishes whether a product is in stock or not
			if ( 'IN_STOCK' === $count->getState() ) {

				$product = Product::get_product_by_square_variation_id( $count->getCatalogObjectId() );

				if ( $product instanceof \WC_Product ) {
					$product->set_manage_stock( true );
					$product->set_stock_quantity( $count->getQuantity() );
					$product->save();
				}
			}

			$in_progress['processed_variation_ids'][] = $count->getCatalogObjectId();

			$this->set_attr( 'in_progress_pull_inventory', $in_progress );
		}

		$this->set_attr( 'processed_square_variation_ids', array_merge( $processed_ids, $in_progress['processed_variation_ids'] ) );

		// clear any in-progress data
		$this->set_attr( 'in_progress_pull_inventory', [] );
	}

	/**
	 * Marks a set of products as failed to sync.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product[]|int[] $products products to mark as failed
	 */
	protected function mark_failed_products( $products = [] ) {

		foreach ( $products as $product ) {

			$product = wc_get_product( $product );

			if ( ! $product instanceof \WC_Product ) {
				continue;
			}

			$record_data = [
				'type'       => 'alert',
				'product_id' => $product->get_id(),
			];

			// optionally hide unmatched products from catalog
			if ( wc_square()->get_settings_handler()->is_system_of_record_square() && wc_square()->get_settings_handler()->hide_missing_square_products() ) {

				try {

					$product->set_catalog_visibility( 'hidden' );
					$product->save();

					$record_data['product_hidden'] = true;

				} catch ( \Exception $e ) {}
			}

			Records::set_record( $record_data );
		}
	}


	/**
	 * Gets a list of unique category IDs used by a group of product IDs.
	 *
	 * @since 2.0.0
	 *
	 * @param int[] $product_ids array of product IDs
	 * @return int[]
	 */
	protected function get_shared_category_ids( $product_ids ) {
		global $wpdb;

		if ( ! empty( $product_ids ) ) {

			$term_ids     = $wpdb->get_col( " SELECT term_taxonomy_id FROM $wpdb->term_taxonomy WHERE taxonomy = 'product_cat' " );
			$term_in      = '(' . implode( ',', array_map( 'absint', array_merge( [ 0 ], $term_ids ) ) ) . ')';
			$post_in      = '(' . implode( ',', array_map( 'absint', array_merge( [ 0 ], $product_ids ) ) ) . ')';
			$category_ids = $wpdb->get_results( "
				SELECT term_taxonomy_id
				FROM $wpdb->term_relationships
				WHERE object_id IN $post_in
				AND term_taxonomy_id IN $term_in
			", ARRAY_N );
		}

		return ! empty( $category_ids ) ? array_unique( array_map( 'absint', array_merge( ...$category_ids ) ) ) : [];
	}


	/**
	 * Assigns the next steps needed for this sync job.
	 *
	 * @since 2.0.0
	 */
	protected function assign_next_steps() {

		$next_steps = [];

		if ( $this->is_system_of_record_woocommerce() ) {

			if ( 'delete' === $this->get_attr( 'action' ) ) {

				$next_steps = [
					'validate_products',
					'update_matched_products',
					'search_matched_products',
				];

			} else {

				$next_steps = [
					'validate_products',
					'extract_category_ids',
					'refresh_category_mappings',
					'query_unmapped_categories',
					'upsert_categories',
					'update_matched_products',
					'search_matched_products',
					'upsert_new_products',
				];

				// only handle product inventory if enabled
				if ( wc_square()->get_settings_handler()->is_inventory_sync_enabled() ) {
					$next_steps[] = 'push_inventory';
					$next_steps[] = 'pull_inventory';
				}
			}

		} elseif ( $this->is_system_of_record_square() ) {

			$next_steps = [
				'validate_products',
				'square_sor_sync',
			];

			// only pull product inventory if enabled
			if ( wc_square()->get_settings_handler()->is_inventory_sync_enabled() ) {
				$next_steps[] = 'pull_inventory';
			}
		}

		$this->set_attr( 'next_steps', $next_steps );
	}


	/**
	 * Gets the maximum number of objects to retrieve in a single sync job.
	 *
	 * @since 2.0.0
	 *
	 * @return int
	 */
	protected function get_max_objects_to_retrieve() {

		$max = $this->get_attr( 'max_objects_to_retrieve', 300 );

		/**
		 * Filters the maximum number of objects to retrieve in a single sync job.
		 *
		 * @since 2.0.0
		 *
		 * $param int $max
		 */
		return max( 1, (int) apply_filters( 'wc_square_sync_max_objects_to_retrieve', $max ) );
	}


	/**
	 * Gets the maximum number of objects per batch in a single sync job.
	 *
	 * @since 2.0.0
	 *
	 * @return int
	 */
	protected function get_max_objects_per_batch() {

		$max = $this->get_attr( 'max_objects_per_batch', 1000 );

		/**
		 * Filters the maximum number of objects per batch in a single sync job.
		 *
		 * @since 2.0.0
		 *
		 * $param int $max
		 */
		return max( 10, (int) apply_filters( 'wc_square_sync_max_objects_per_batch', $max ) );
	}


	/**
	 * Gets the maximum number of objects per batch upsert in a single request.
	 *
	 * @since 2.0.0
	 *
	 * @return int
	 */
	protected function get_max_objects_per_upsert() {

		$max = $this->get_attr( 'max_objects_per_upsert', 5000 );

		/**
		 * Filters the maximum number of objects per upsert in a single request.
		 *
		 * @since 2.0.0
		 *
		 * $param int $max
		 */
		return max( 1, (int) apply_filters( 'wc_square_sync_max_objects_per_upsert', $max ) );
	}


	/**
	 * Gets the maximum number of objects allowed in a single sync job.
	 *
	 * @since 2.0.0
	 *
	 * @return int
	 */
	protected function get_max_objects_total() {

		$max = $this->get_attr( 'max_objects_total', self::BATCH_UPSERT_OBJECT_LIMIT );

		/**
		 * Filters the maximum number of objects allowed in a single sync job.
		 *
		 * @since 2.0.0
		 *
		 * $param int $max
		 */
		return max( 1, (int) apply_filters( 'wc_square_sync_max_objects_total', $max ) );
	}


}
