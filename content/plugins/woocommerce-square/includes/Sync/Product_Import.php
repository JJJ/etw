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
use WooCommerce\Square\Handlers\Category;
use WooCommerce\Square\Handlers\Product;
use WooCommerce\Square\Sync\Records\Record;
use WooCommerce\Square\Utilities\Money_Utility;

defined( 'ABSPATH' ) or exit;

/**
 * Class to represent a synchronization job to import products from Square.
 *
 * @since 2.0.0
 */
class Product_Import extends Stepped_Job {


	protected function assign_next_steps() {

		$this->set_attr( 'next_steps', [
			'import_products',
			'import_inventory',
		] );
	}


	/**
	 * Gets the limit for how many items to import per request.
	 *
	 * Square has a hard maximum for this at 1000, but 100 seems to be a sane
	 * default to allow for creating products without timing out.
	 *
	 * @since 2.0.0
	 *
	 * @return int
	 */
	protected function get_import_api_limit() {

		/**
		 * Filters the number of items to import from the Square API per request.
		 *
		 * @since 2.0.0
		 *
		 * @param int limit
		 */
		$limit = (int) apply_filters( 'wc_square_import_api_limit', 100 );

		return max( 1, min( 1000, $limit ) );
	}


	/**
	 * Performs a product import.
	 *
	 * @since 2.0.0
	 *
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	protected function import_products() {

		$products_imported = $this->get_attr( 'processed_product_ids', [] );
		$cursor            = $this->get_attr( 'fetch_products_cursor' );
		$skipped_products  = $this->get_attr( 'skipped_products', [] );

		$response = wc_square()->get_api()->search_catalog_objects( [
			'cursor'                  => $cursor,
			'object_types'            => [ 'ITEM' ],
			'include_related_objects' => true,
			'limit'                   => $this->get_import_api_limit(),
		] );

		$related_objects = $response->get_data()->getRelatedObjects();

		if ( $related_objects && is_array( $related_objects ) ) {

			// first import any related categories
			foreach ( $related_objects as $related_object ) {

				if ( 'CATEGORY' === $related_object->getType() ) {

					Category::import_or_update( $related_object );
				}
			}
		}

		$catalog_objects = $response->get_data()->getObjects();
		$time_exceeded   = false;

		foreach ( $catalog_objects as $catalog_object_index => $catalog_object ) {

			if ( $this->is_time_exceeded() ) {

				$time_exceeded = true;
				break;
			}

			$item_id = $catalog_object->getId();

			// ignore items not available at our location
			if ( ! $catalog_object->getPresentAtAllLocations() && ( ! is_array( $catalog_object->getPresentAtLocationIds() ) || ! in_array( wc_square()->get_settings_handler()->get_location_id(), $catalog_object->getPresentAtLocationIds(), true ) ) ) {

				$skipped_products[ $item_id ] = null;
				continue;
			}

			// if we have a match for this item ID, skip it - it will already be synced
			if ( $product_id = Product::get_product_id_by_square_id( $item_id ) ) {

				$skipped_products[ $item_id ] = null;
				continue;
			}

			// look in variation SKUs for a match - if so, skip the parent item, a normal sync should link it automatically
			if ( $this->item_variation_has_matching_sku( $catalog_object ) ) {
				continue;
			}

			$product_id = $this->import_product( $catalog_object );

			if ( $product_id ) {

				Product::set_synced_with_square( $product_id );

				$products_imported[] = $product_id;
			}
		}

		if ( $time_exceeded ) {

			wc_square()->log( '[Time Exceeded] Imported Products Count: ' . count( $products_imported ) );

		} else {

			wc_square()->log( 'Imported Products Count: ' . count( $products_imported ) );

			$cursor = $response->get_data()->getCursor();
			$this->set_attr( 'fetch_products_cursor', $cursor );

			if ( ! $cursor ) {

				$this->complete_step( 'import_products' );
			}
		}

		$this->set_attr( 'skipped_products', $skipped_products );
		$this->set_attr( 'processed_product_ids', $products_imported );
	}


	/**
	 * Imports inventory counts for all the tracked Square products.
	 *
	 * @since 2.0.0
	 *
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	protected function import_inventory() {

		$search_result = wc_square()->get_api()->search_catalog_objects( [
			'object_types' => [ 'ITEM_VARIATION' ],
			'limit'        => 100,
			'cursor'       => $this->get_attr( 'import_inventory_cursor', null ),
		] );

		$cursor        = $search_result->get_data()->getCursor();
		$variation_ids = array_map( static function( \SquareConnect\Model\CatalogObject $catalog_object ) {

			return $catalog_object->getId();

		}, $search_result->get_data()->getObjects() );

		$result = wc_square()->get_api()->batch_retrieve_inventory_counts( [
			'catalog_object_ids' => $variation_ids,
			'location_ids'       => [ wc_square()->get_settings_handler()->get_location_id() ],
		] );

		foreach ( $result->get_counts() as $inventory_count ) {

			// all inventory should be tied to a variation, but check here just in case
			if ( 'ITEM_VARIATION' === $inventory_count->getCatalogObjectType() ) {

				$product = Product::get_product_by_square_variation_id( $inventory_count->getCatalogObjectId() );

				if ( $product && $product instanceof \WC_Product ) {

					$product->set_stock_quantity( $inventory_count->getQuantity() );
					$product->save();
				}
			}
		}

		$this->set_attr( 'import_inventory_cursor', $cursor );

		if ( ! $cursor ) {

			$this->complete_step( 'import_inventory' );
		}
	}


	/**
	 * Determines whether a SKU within a catalog item is found in WooCommerce.
	 *
	 * @since 2.0.0
	 *
	 * @param \SquareConnect\Model\CatalogObject $catalog_object the catalog object
	 * @return bool
	 */
	private function item_variation_has_matching_sku( $catalog_object ) {

		foreach ( $catalog_object->getItemData()->getVariations() as $variation ) {

			if ( wc_get_product_id_by_sku( $variation->getItemVariationData()->getSku() ) ) {

				return true;
			}
		}

		return false;
	}


	/**
	 * Creates a product from a catalog object.
	 *
	 * @since 2.0.0
	 *
	 * @param \SquareConnect\Model\CatalogObject $catalog_object the catalog object
	 * @return int|null
	 */
	private function import_product( $catalog_object ) {

		$product_id = 0;

		try {

			// validate permissions
			if ( ! current_user_can( 'publish_products' ) ) {
				throw new Framework\SV_WC_Plugin_Exception( __( 'You do not have permission to create products', 'woocommerce-square' ) );
			}

			// sanity check for valid API data
			if ( ! $catalog_object instanceof \SquareConnect\Model\CatalogObject || ! $catalog_object->getItemData() instanceof \SquareConnect\Model\CatalogItem ) {
				throw new Framework\SV_WC_Plugin_Exception( __( 'Invalid data', 'woocommerce-square' ) );
			}

			$data = $this->extract_product_data( $catalog_object );

			/**
			 * Filters the data that is used to create a new WooCommerce product during import.
			 *
			 * @since 2.0.0
			 *
			 * @param array $data product data
			 * @param \SquareConnect\Model\CatalogObject $catalog_object the catalog object from the Square API
			 * @param Product_Import $this import class instance
			 */
			$data = apply_filters( 'woocommerce_square_create_product_data', $data, $catalog_object, $this );

			// validate title field
			if ( ! isset( $data['title'] ) ) {
				throw new Framework\SV_WC_Plugin_Exception( sprintf( __( 'Missing parameter %s', 'woocommerce-square' ), 'title' ) );
			}

			// set default type
			if ( ! isset( $data['type'] ) ) {
				$data['type'] = 'simple';
			}

			// set default catalog_visibility
			if ( ! isset( $data['catalog_visibility'] ) ) {
				$data['catalog_visibility'] = 'visible';
			}

			// validate type
			if ( ! array_key_exists( wc_clean( $data['type'] ), wc_get_product_types() ) ) {
				throw new Framework\SV_WC_Plugin_Exception( sprintf( __( 'Invalid product type - the product type must be any of these: %s', 'woocommerce-square' ), implode( ', ', array_keys( wc_get_product_types() ) ) ) );
			}

			// set description
			$post_content = isset( $data['description'] ) ? wc_clean( $data['description'] ) : '';
			if ( $post_content && isset( $data['enable_html_description'] ) && true === $data['enable_html_description'] ) {

				$post_content = $data['description'];
			}

			$new_product = [
				'post_title'   => wc_clean( $data['title'] ),
				'post_status'  => isset( $data['status'] ) ? wc_clean( $data['status'] ) : 'publish',
				'post_type'    => 'product',
				'post_content' => isset( $data['description'] ) ? $post_content : '',
				'post_author'  => get_current_user_id(),
				'menu_order'   => isset( $data['menu_order'] ) ? (int) $data['menu_order'] : 0,
			];

			if ( ! empty( $data['name'] ) ) {
				$new_product = array_merge( $new_product, [ 'post_name' => sanitize_title( $data['name'] ) ] );
			}

			// attempt to create the new product
			$product_id = wp_insert_post( $new_product, true );

			if ( is_wp_error( $product_id ) ) {
				throw new Framework\SV_WC_Plugin_Exception( $product_id->get_error_message() );
			}

			// save product meta fields
			$this->save_product_meta( $product_id, $data );

			// save the image, if included
			if ( ! empty( $data['image_id'] ) ) {
				Product::update_image_from_square( $product_id, $data['image_id'] );
			}

			// save variations
			if ( 'variable' === $data['type'] && is_array( $data['variations'] ) && isset( $data['type'], $data['variations'] ) ) {

				$this->save_variations( $product_id, $data );
			}

			/**
			 * Fired when a product is created from a square product import.
			 *
			 * @since 2.0.0
			 *
			 * @param int $product_id the product ID that was created
			 * @param array $data the data used to create the product
			 */
			do_action( 'woocommerce_square_create_product', $product_id, $data );

			// clear cache/transients
			wc_delete_product_transients( $product_id );

		} catch ( Framework\SV_WC_Plugin_Exception $e ) {

			if ( $catalog_object instanceof \SquareConnect\Model\CatalogObject && $catalog_object->getItemData() instanceof \SquareConnect\Model\CatalogItem ) {

				$message = sprintf(
					/* translators: Placeholders: %1$s - Square item name, %2$s - failure reason */
					__( 'Could not import "%1$s" from Square. %2$s', 'woocommerce-square' ),
					$catalog_object->getItemData()->getName(),
					$e->getMessage()
				);

			// use a generic alert for invalid data
			} else {

				$message = sprintf(
					/* translators: Placeholders: %s - failure reason */
					__( 'Could not import item from Square. %s', 'woocommerce-square' ),
					$e->getMessage()
				);
			}

			// alert for failed product imports
			Records::set_record( [
				'type'    => 'alert',
				'message' => $message,
			] );

			wc_square()->log( 'Error creating product during import: ' . $e->getMessage() );

			// remove the product when creation fails
			$this->clear_product( $product_id );
			$product_id = 0;
		}

		return $product_id;
	}


	/**
	 * Extracts product data from a CatalogObject to an array of data.
	 *
	 * @since 2.0.0
	 *
	 * @param \SquareConnect\Model\CatalogObject $catalog_object the catalog object
	 * @return array|null
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	protected function extract_product_data( $catalog_object ) {

		$variations = $catalog_object->getItemData()->getVariations();

		// if there are no variations, something is wrong - every catalog item has at least one
		if ( 0 >= count( $variations ) ) {
			return null;
		}

		$category_id = Category::get_category_id_by_square_id( $catalog_object->getItemData()->getCategoryId() );

		$data = [
			'title'       => $catalog_object->getItemData()->getName(),
			'type'        => 1 === count( $variations ) ? 'simple' : 'variable',
			'description' => $catalog_object->getItemData()->getDescription(),
			'image_id'    => $catalog_object->getImageId(),
			'categories'  => [ $category_id ],
			'square_meta' => [
				'item_id'      => $catalog_object->getId(),
				'item_version' => $catalog_object->getVersion(),
			],
		];

		// variable product
		if ( 1 < count( $variations ) ) {

			$data['type']       = 'variable';
			$data['variations'] = [];

			foreach ( $variations as $variation ) {

				// sanity check for valid API data
				if ( ! $variation instanceof \SquareConnect\Model\CatalogObject || ! $variation->getItemVariationData() instanceof \SquareConnect\Model\CatalogItemVariation ) {
					continue;
				}

				try {

					$data['variations'][] = $this->extract_square_item_variation_data( $variation );

				} catch ( Framework\SV_WC_Plugin_Exception $exception ) {

					// alert for failed variation imports
					Records::set_record( [
						'type'    => 'alert',
						'message' => sprintf(
							/* translators: Placeholders: %1$s - Square item name, %2$s - Square item variation name, %3$s - failure reason */
							__( 'Could not import "%1$s - %2$s" from Square. %3$s', 'woocommerce-square' ),
							$catalog_object->getItemData()->getName(),
							$variation->getItemVariationData()->getName(),
							$exception->getMessage()
						),
					] );
				}
			}

			$data['attributes'] = [ [
				'name'      => 'Attribute',
				'slug'      => 'attribute',
				'position'  => 0,
				'visible'   => true,
				'variation' => true,
				'options'   => wp_list_pluck( $data['variations'], 'name' ),
			] ];

		// simple product
		} else {

			$variation = $this->extract_square_item_variation_data( $variations[0] );

			$data['type']           = 'simple';
			$data['sku']            = $variation['sku'] ?: null;
			$data['regular_price']  = $variation['regular_price'] ?: null;
			$data['stock_quantity'] = $variation['stock_quantity'] ?: null;
			$data['managing_stock'] = $variation['managing_stock'] ?: null;

			$data['square_meta']['item_variation_id']      = $variation['square_meta']['item_variation_id'] ?: null;
			$data['square_meta']['item_variation_version'] = $variation['square_meta']['item_variation_version'] ?: null;
		}

		return $data;
	}


	/**
	 * Extracts data from a CatalogItemVariation for insertion into a WC product.
	 *
	 * @since 2.0.0
	 *
	 * @param \SquareConnect\Model\CatalogObject $variation the variation object
	 * @return array
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	protected function extract_square_item_variation_data( $variation ) {

		$variation_data = $variation->getItemVariationData();

		if ( 'VARIABLE_PRICING' === $variation_data->getPricingType() ) {
			throw new Framework\SV_WC_Plugin_Exception( __( 'Items with variable pricing cannot be imported.', 'woocommerce-square' ) );
		}

		$data = [
			'name'           => $variation_data->getName() ?: '',
			'sku'            => $variation_data->getSku() ?: '',
			'regular_price'  => $variation_data->getPriceMoney() && $variation_data->getPriceMoney()->getAmount() ? Money_Utility::cents_to_float( $variation->getItemVariationData()->getPriceMoney()->getAmount() ) : null,
			'stock_quantity' => null,
			'managing_stock' => true,
			'square_meta'    => [
				'item_variation_id'      => $variation->getId(),
				'item_variation_version' => $variation->getVersion(),
			],
			'attributes'     => [
				[
					'name'         => 'Attribute',
					'is_variation' => true,
					'option'       => $variation_data->getName() ?: '',
				],
			],
		];

		return $data;
	}


	protected function save_product_images( $product_id, $images ) {}


	protected function upload_product_image( $src ) {}


	protected function set_product_image_as_attachment( $upload, $product_id ) {}


	/**
	 * Saves product meta data for a given product.
	 *
	 * @since 2.0.0
	 *
	 * @param int $product_id the product ID
	 * @param array $data the product data
	 * @return bool
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	protected function save_product_meta( $product_id, $data ) {

		// product type
		$product_type = null;

		if ( isset( $data['type'] ) ) {

			$product_type = wc_clean( $data['type'] );

			wp_set_object_terms( $product_id, $product_type, 'product_type' );

		} else {

			$_product_type = get_the_terms( $product_id, 'product_type' );

			if ( is_array( $_product_type ) ) {

				$_product_type = current( $_product_type );
				$product_type  = $_product_type->slug;
			}
		}

		// default total sales
		add_post_meta( $product_id, 'total_sales', '0', true );

		// catalog visibility
		if ( isset( $data['catalog_visibility'] ) ) {

			update_post_meta( $product_id, '_visibility', wc_clean( $data['catalog_visibility'] ) );
		}

		// sku
		if ( isset( $data['sku'] ) ) {

			$sku     = get_post_meta( $product_id, '_sku', true );
			$new_sku = wc_clean( $data['sku'] );

			if ( '' === $new_sku ) {

				update_post_meta( $product_id, '_sku', '' );

			} elseif ( $new_sku !== $sku ) {

				if ( ! empty( $new_sku ) ) {

					$unique_sku = wc_product_has_unique_sku( $product_id, $new_sku );

					if ( $unique_sku ) {

						update_post_meta( $product_id, '_sku', $new_sku );

					} else {

						throw new Framework\SV_WC_Plugin_Exception( __( 'The SKU already exists on another product', 'woocommerce-square' ) );
					}

				} else {

					update_post_meta( $product_id, '_sku', '' );
				}
			}
		}

		// attributes
		if ( isset( $data['attributes'] ) ) {

			$attributes = [];

			foreach ( $data['attributes'] as $attribute ) {

				$is_taxonomy = 0;
				$taxonomy    = 0;

				if ( ! isset( $attribute['name'] ) ) {
					continue;
				}

				$attribute_slug = sanitize_title( $attribute['name'] );

				if ( isset( $attribute['slug'] ) ) {

					$taxonomy       = $this->get_attribute_taxonomy_by_slug( $attribute['slug'] );
					$attribute_slug = sanitize_title( $attribute['slug'] );
				}

				if ( $taxonomy ) {

					$is_taxonomy = 1;
				}

				if ( $is_taxonomy ) {

					if ( isset( $attribute['options'] ) ) {

						$options = $attribute['options'];

						if ( ! is_array( $attribute['options'] ) ) {

							// text based attributes - Posted values are term names
							$options = explode( WC_DELIMITER, $options );
						}

						$values = array_map( 'wc_sanitize_term_text_based', $options );
						$values = array_filter( $values, 'strlen' );

					} else {

						$values = [];
					}

					// update post terms
					if ( taxonomy_exists( $taxonomy ) ) {

						wp_set_object_terms( $product_id, $values, $taxonomy );
					}

					if ( ! empty( $values ) ) {

						// add attribute to array, but don't set values
						$attributes[ $taxonomy ] = [
							'name'         => $taxonomy,
							'value'        => '',
							'position'     => isset( $attribute['position'] ) ? (string) absint( $attribute['position'] ) : '0',
							'is_visible'   => ( isset( $attribute['visible'] ) && $attribute['visible'] ) ? 1 : 0,
							'is_variation' => ( isset( $attribute['variation'] ) && $attribute['variation'] ) ? 1 : 0,
							'is_taxonomy'  => $is_taxonomy,
						];
					}

				} elseif ( isset( $attribute['options'] ) ) {

					// array based
					if ( is_array( $attribute['options'] ) ) {

						$values = implode( ' ' . WC_DELIMITER . ' ', array_map( 'wc_clean', $attribute['options'] ) );

					} else {

						$values = implode( ' ' . WC_DELIMITER . ' ', array_map( 'wc_clean', explode( WC_DELIMITER, $attribute['options'] ) ) );
					}

					// custom attribute - add attribute to array and set the values
					$attributes[ $attribute_slug ] = [
						'name'         => wc_clean( $attribute['name'] ),
						'value'        => $values,
						'position'     => isset( $attribute['position'] ) ? (string) absint( $attribute['position'] ) : '0',
						'is_visible'   => ( isset( $attribute['visible'] ) && $attribute['visible'] ) ? 1 : 0,
						'is_variation' => ( isset( $attribute['variation'] ) && $attribute['variation'] ) ? 1 : 0,
						'is_taxonomy'  => $is_taxonomy,
					];
				}
			}

			uasort( $attributes, 'wc_product_attribute_uasort_comparison' );

			update_post_meta( $product_id, '_product_attributes', $attributes );
		}

		// sales and prices
		if ( in_array( $product_type, [ 'variable', 'grouped' ] ) ) {

			// variable and grouped products have no prices
			update_post_meta( $product_id, '_regular_price', '' );
			update_post_meta( $product_id, '_sale_price', '' );
			update_post_meta( $product_id, '_sale_price_dates_from', '' );
			update_post_meta( $product_id, '_sale_price_dates_to', '' );
			update_post_meta( $product_id, '_price', '' );

		} else {

			$this->wc_save_product_price( $product_id, $data['regular_price'] );
		}

		// product categories
		if ( isset( $data['categories'] ) && is_array( $data['categories'] ) ) {

			$term_ids = array_unique( array_map( 'intval', $data['categories'] ) );

			wp_set_object_terms( $product_id, $term_ids, 'product_cat' );
		}

		// square item id
		if ( isset( $data['square_meta']['item_id'] ) ) {
			Product::set_square_item_id( $product_id, $data['square_meta']['item_id'] );
		}

		// square item version
		if ( isset( $data['square_meta']['item_version'] ) ) {
			Product::set_square_version( $product_id, $data['square_meta']['item_version'] );
		}

		// square item variation id
		if ( isset( $data['square_meta']['item_variation_id'] ) ) {
			Product::set_square_item_variation_id( $product_id, $data['square_meta']['item_variation_id'] );
		}

		// square item variation version
		if ( isset( $data['square_meta']['item_variation_version'] ) ) {
			Product::set_square_variation_version( $product_id, $data['square_meta']['item_variation_version'] );
		}

		/**
		 * Fires after processing product meta for a product imported from Square.
		 *
		 * @since 2.0.0
		 *
		 * @param int $product_id the product ID
		 * @param array $data the product data
		 */
		do_action( 'woocommerce_square_process_product_meta_' . $product_type, $product_id, $data );

		return true;
	}


	/**
	 * Saves the variations for a given product.
	 *
	 * @since 2.0.0
	 *
	 * @param int $product_id the product ID
	 * @param array $data the product data, including a 'variations' key
	 * @return bool
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	protected function save_variations( $product_id, $data ) {
		global $wpdb;

		$variations = $data['variations'];
		$attributes = (array) maybe_unserialize( get_post_meta( $product_id, '_product_attributes', true ) );

		foreach ( $variations as $menu_order => $variation ) {

			$variation_id = isset( $variation['id'] ) ? absint( $variation['id'] ) : 0;

			if ( ! $variation_id && isset( $variation['sku'] ) ) {

				$variation_sku = wc_clean( $variation['sku'] );
				$variation_id  = wc_get_product_id_by_sku( $variation_sku );
			}

			$variation_post_title = sprintf( __( 'Variation #%1$s of %2$s', 'woocommerce-square' ), $variation_id, esc_html( get_the_title( $product_id ) ) );

			// update or add post
			if ( ! $variation_id ) {

				$post_status   = ( isset( $variation['visible'] ) && false === $variation['visible'] ) ? 'private' : 'publish';
				$new_variation = [
					'post_title'   => $variation_post_title,
					'post_content' => '',
					'post_status'  => $post_status,
					'post_author'  => get_current_user_id(),
					'post_parent'  => $product_id,
					'post_type'    => 'product_variation',
					'menu_order'   => $menu_order,
				];

				$variation_id = wp_insert_post( $new_variation );

				/**
				 * Fired after creating a product variation during an import from Square.
				 *
				 * @since 2.0.0
				 *
				 * @param int $variation_id the new variation ID
				 */
				do_action( 'woocommerce_square_create_product_variation', $variation_id );

			} else {

				$update_variation = [ 'post_title' => $variation_post_title, 'menu_order' => $menu_order ];

				if ( isset( $variation['visible'] ) ) {

					$post_status = ( false === $variation['visible'] ) ? 'private' : 'publish';

					$update_variation['post_status'] = $post_status;
				}

				$wpdb->update( $wpdb->posts, $update_variation, [ 'ID' => $variation_id ] );

				/**
				 * Fired after updating a product variation during an import from Square.
				 *
				 * @since 2.0.0
				 *
				 * @param int $variation_id the updated variation ID
				 */
				do_action( 'woocommerce_square_update_product_variation', $variation_id );
			}

			// stop if we don't have a variation ID
			if ( is_wp_error( $variation_id ) ) {

				throw new Framework\SV_WC_Plugin_Exception( $variation_id->get_error_message() );
			}

			// SKU
			if ( isset( $variation['sku'] ) ) {

				$sku     = get_post_meta( $variation_id, '_sku', true );
				$new_sku = wc_clean( $variation['sku'] );

				if ( '' === $new_sku ) {

					update_post_meta( $variation_id, '_sku', '' );

				} elseif ( $new_sku !== $sku ) {

					if ( ! empty( $new_sku ) ) {

						if ( wc_product_has_unique_sku( $variation_id, $new_sku ) ) {

							update_post_meta( $variation_id, '_sku', $new_sku );

						} else {

							throw new Framework\SV_WC_Plugin_Exception( __( 'The SKU already exists on another product', 'woocommerce-square' ) );
						}

					} else {

						update_post_meta( $variation_id, '_sku', '' );
					}
				}
			}

			update_post_meta( $variation_id, '_manage_stock', 'yes' );

			$this->wc_save_product_price( $variation_id, $variation['regular_price'] );

			update_post_meta( $variation_id, '_download_limit', '' );
			update_post_meta( $variation_id, '_download_expiry', '' );
			update_post_meta( $variation_id, '_downloadable_files', '' );

			// description
			if ( isset( $variation['description'] ) ) {
				update_post_meta( $variation_id, '_variation_description', wp_kses_post( $variation['description'] ) );
			}

			// update taxonomies
			if ( isset( $variation['attributes'] ) ) {

				$updated_attribute_keys = [];

				foreach ( $variation['attributes'] as $attribute_key => $attribute ) {

					if ( ! isset( $attribute['name'] ) ) {
						continue;
					}

					$taxonomy   = 0;
					$_attribute = [];

					if ( isset( $attribute['slug'] ) ) {

						$taxonomy = $this->get_attribute_taxonomy_by_slug( $attribute['slug'] );
					}

					if ( ! $taxonomy ) {

						$taxonomy = sanitize_title( $attribute['name'] );
					}

					if ( isset( $attributes[ $taxonomy ] ) ) {

						$_attribute = $attributes[ $taxonomy ];
					}

					if ( isset( $_attribute['is_variation'] ) && $_attribute['is_variation'] ) {

						$_attribute_key           = 'attribute_' . sanitize_title( $_attribute['name'] );
						$updated_attribute_keys[] = $_attribute_key;

						if ( isset( $_attribute['is_taxonomy'] ) && $_attribute['is_taxonomy'] ) {

							// Don't use wc_clean as it destroys sanitized characters
							$_attribute_value = isset( $attribute['option'] ) ? sanitize_title( stripslashes( $attribute['option'] ) ) : '';

						} else {

							$_attribute_value = isset( $attribute['option'] ) ? wc_clean( stripslashes( $attribute['option'] ) ) : '';
						}

						update_post_meta( $variation_id, $_attribute_key, $_attribute_value );
					}
				}

				// remove old taxonomies attributes so data is kept up to date - first get attribute key names
				$delete_attribute_keys = $wpdb->get_col( $wpdb->prepare( "SELECT meta_key FROM {$wpdb->postmeta} WHERE meta_key LIKE 'attribute_%%' AND meta_key NOT IN ( '" . implode( "','", $updated_attribute_keys ) . "' ) AND post_id = %d;", $variation_id ) );

				foreach ( $delete_attribute_keys as $key ) {

					delete_post_meta( $variation_id, $key );
				}
			}

			// square item variation id
			if ( isset( $variation['square_meta']['item_variation_id'] ) ) {
				Product::set_square_item_variation_id( $variation_id, $variation['square_meta']['item_variation_id'] );
			}

			// square item variation version
			if ( isset( $variation['square_meta']['item_variation_version'] ) ) {
				Product::set_square_variation_version( $variation_id, $variation['square_meta']['item_variation_version'] );
			}

			/**
			 * Fired after saving a product variation during a Square product import.
			 *
			 * @since 2.0.0
			 *
			 * @param int $variation_id the variation ID
			 * @param int $menu_order the menu order
			 * @param array $variation the variation data
			 */
			do_action( 'woocommerce_square_save_product_variation', $variation_id, $menu_order, $variation );
		}

		// update parent if variable so price sorting works and stays in sync with the cheapest child
		\WC_Product_Variable::sync( $product_id );

		// update default attributes options setting
		if ( isset( $data['default_attribute'] ) ) {

			$data['default_attributes'] = $data['default_attribute'];
		}

		if ( isset( $data['default_attributes'] ) && is_array( $data['default_attributes'] ) ) {

			$default_attributes = [];

			foreach ( $data['default_attributes'] as $default_attr_key => $default_attr ) {

				if ( ! isset( $default_attr['name'] ) ) {
					continue;
				}

				$taxonomy = sanitize_title( $default_attr['name'] );

				if ( isset( $default_attr['slug'] ) ) {
					$taxonomy = $this->get_attribute_taxonomy_by_slug( $default_attr['slug'] );
				}

				if ( isset( $attributes[ $taxonomy ] ) ) {

					$_attribute = $attributes[ $taxonomy ];

					if ( $_attribute['is_variation'] ) {

						$value = '';

						if ( isset( $default_attr['option'] ) ) {

							if ( $_attribute['is_taxonomy'] ) {

								// Don't use wc_clean as it destroys sanitized characters
								$value = sanitize_title( trim( stripslashes( $default_attr['option'] ) ) );

							} else {

								$value = wc_clean( trim( stripslashes( $default_attr['option'] ) ) );
							}
						}

						if ( $value ) {

							$default_attributes[ $taxonomy ] = $value;
						}
					}
				}
			}

			update_post_meta( $product_id, '_default_attributes', $default_attributes );
		}

		return true;
	}


	/**
	 * Gets an attribute taxonomy by its slug.
	 *
	 * @since 2.0.0
	 *
	 * @param string $slug
	 * @return string|null
	 */
	protected function get_attribute_taxonomy_by_slug( $slug ) {

		$taxonomy             = null;
		$attribute_taxonomies = wc_get_attribute_taxonomies();

		foreach ( $attribute_taxonomies as $key => $tax ) {

			if ( $slug === $tax->attribute_name ) {

				$taxonomy = 'pa_' . $tax->attribute_name;
				break;
			}
		}

		return $taxonomy;
	}


	/**
	 * Saves the product price.
	 *
	 * @since 2.0.0
	 *
	 * @param int $product_id
	 * @param float $regular_price
	 * @param float $sale_price
	 * @param string $date_from
	 * @param string $date_to
	 */
	public function wc_save_product_price( $product_id, $regular_price, $sale_price = '', $date_from = '', $date_to = '' ) {

		$product_id    = absint( $product_id );
		$regular_price = wc_format_decimal( $regular_price );
		$sale_price    = '' === $sale_price ? '' : wc_format_decimal( $sale_price );
		$date_from     = wc_clean( $date_from );
		$date_to       = wc_clean( $date_to );

		update_post_meta( $product_id, '_regular_price', $regular_price );
		update_post_meta( $product_id, '_sale_price', $sale_price );

		// Save Dates
		update_post_meta( $product_id, '_sale_price_dates_from', $date_from ? strtotime( $date_from ) : '' );
		update_post_meta( $product_id, '_sale_price_dates_to', $date_to ? strtotime( $date_to ) : '' );

		if ( $date_to && ! $date_from ) {

			$date_from = strtotime( 'NOW', current_time( 'timestamp' ) );

			update_post_meta( $product_id, '_sale_price_dates_from', $date_from );
		}

		// Update price if on sale
		if ( '' !== $sale_price && '' === $date_to && '' === $date_from ) {

			update_post_meta( $product_id, '_price', $sale_price );

		} else {

			update_post_meta( $product_id, '_price', $regular_price );
		}

		if ( '' !== $sale_price && $date_from && strtotime( $date_from ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {

			update_post_meta( $product_id, '_price', $sale_price );
		}

		if ( $date_to && strtotime( $date_to ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {

			update_post_meta( $product_id, '_price', $regular_price );
			update_post_meta( $product_id, '_sale_price_dates_from', '' );
			update_post_meta( $product_id, '_sale_price_dates_to', '' );
		}
	}


	/**
	 * Clears a product from WooCommerce - used when product creation fails partially through the creation process.
	 *
	 * @since 2.0.0
	 *
	 * @param int $product_id the product ID
	 */
	protected function clear_product( $product_id ) {

		if ( ! is_numeric( $product_id ) || 0 >= $product_id ) {
			return;
		}

		// Delete product attachments
		$attachments = get_children( [
			'post_parent' => $product_id,
			'post_status' => 'any',
			'post_type'   => 'attachment',
		] );

		foreach ( $attachments as $attachment ) {
			wp_delete_attachment( $attachment->ID, true );
		}

		// Delete product
		wp_delete_post( $product_id, true );
	}


}
