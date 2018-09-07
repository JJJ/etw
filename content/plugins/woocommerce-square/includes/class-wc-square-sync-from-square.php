<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class WC_Square_Sync_From_Square
 *
 * Methods to Sync from Square to WC. Organized as "sync" methods that
 * determine if "create" or "update" actions should be taken on the entities
 * involved.
 *
 * NOTE: Existing WC Products are *not* updated with data from their
 *       corresponding Square Item due to a lack of modified timestamp
 *       on the Square API side.
 */
class WC_Square_Sync_From_Square {

	/**
	 * @var WC_Square_Connect
	 */
	protected $connect;

	/**
	 * WC_Square_Sync_From_Square constructor.
	 */
	public function __construct( WC_Square_Connect $connect ) {

		$this->connect = $connect;

	}

	/**
	 * Sync Square categories to WooCommerce.
	 *
	 * Looks for category names that don't exist in WooCommerce, and creates them.
	 */
	public function sync_categories() {

		$square_category_objects = $this->connect->get_square_categories();
		$square_categories       = array();
		$processed_categories    = array();

		foreach ( $square_category_objects as $square_category ) {
			// Square list endpoints may return dups so we must check for that
			if ( in_array( $square_category->id, $processed_categories ) ) {
				continue;
			}

			if ( is_object( $square_category ) && ! empty( $square_category->name ) && ! empty( $square_category->id ) ) {
				$square_categories[ $square_category->name ] = $square_category->id;
				$processed_categories[]                      = $square_category->id;
			}
		}

		if ( empty( $square_categories ) ) {

			WC_Square_Sync_Logger::log( '[Square -> WC] No categories found to sync.' );
			return;

		}

		$wc_category_objects = $this->connect->wc->get_product_categories();
		$wc_categories       = array();

		if ( is_wp_error( $wc_category_objects ) ) {

			WC_Square_Sync_Logger::log( '[Square -> WC] Error encountered retrieving WC Product Categories: ' . $wc_category_objects->get_error_message() );
			return;

		}

		if ( ! empty( $wc_category_objects['product_categories'] ) ) {

			foreach ( $wc_category_objects['product_categories'] as $wc_category ) {

				if ( empty( $wc_category['name'] ) || empty( $wc_category['id'] ) || ( 0 !== $wc_category['parent'] ) ) {
					continue;
				}

				$wc_categories[ $wc_category['name'] ] = $wc_category['id'];

			}
		}

		// Look for previously synced categories and update them with data from Square
		foreach ( $wc_categories as $wc_cat_name => $wc_cat_id ) {

			$wc_square_cat_id = WC_Square_Utils::get_wc_term_square_id( $wc_cat_id );

			// Make sure the associated Square ID still exists on the Square side
			if ( $wc_square_cat_id && ( $square_cat_name = array_search( $wc_square_cat_id, $square_categories ) ) ) {

				$result = $this->connect->wc->edit_product_category( $wc_cat_id, array(
					'product_category' => array(
						'name' => $square_cat_name,
					),
				) );

				if ( is_wp_error( $result ) ) {

					WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Error updating WC Product Category %d for Square ID %s: %s', $wc_cat_id, $wc_square_cat_id, $result->get_error_message() ) );
					continue;

				} elseif ( empty( $result['product_category'] ) ) {

					WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Unexpected empty result updating WC Product Category %d for Square ID %s.', $wc_cat_id, $wc_square_cat_id ) );
					continue;

				}

				// We no longer need to process this Square Category, so remove from list
				unset( $square_categories[ $square_cat_name ] );

			} else {

				WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Cannot sync Square Category ID %s, it no longer exists.', $wc_square_cat_id ) );

			}
		}

		/*
		 * Go through the remaining Square Categories and either:
		 * 1) Match them to an existing WC Category
		 * 2) Create a new WC Category
		 */
		foreach ( $square_categories as $name => $square_id ) {

			if ( empty( $wc_categories[ $name ] ) ) {

				$result = $this->connect->wc->create_product_category( array(
					'product_category' => array(
						'name' => $name,
					),
				) );

				if ( is_wp_error( $result ) ) {

					WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Error creating WC Product Category for Square ID %s: %s', $wc_square_cat_id, $result->get_error_message() ) );
					continue;

				} elseif ( empty( $result['product_category'] ) ) {

					WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Unexpected empty result creating WC Product Category for Square ID %s.', $wc_square_cat_id ) );
					continue;

				}

				$wc_term_id = $result['product_category']['id'];

			} else {

				$wc_term_id = $wc_categories[ $name ];

			}

			WC_Square_Utils::update_wc_term_square_id( $wc_term_id, $square_id );

		}

	}

	/**
	 * Sync a Square Item to WC, optionally including Categories and Inventory.
	 *
	 * @param object $square_item
	 * @param bool   $include_category
	 * @param bool   $include_inventory
	 * @param bool   $include_image
	 */
	public function sync_product( $square_item, $include_category = false, $include_inventory = false, $include_image = false ) {
		$wc_product     = WC_Square_Utils::get_wc_product_for_square_item( $square_item );
		$is_new_product = ( false === $wc_product );

		// If none of the Square item variations have sku we must skip the sync.
		if ( ! WC_Square_Utils::is_square_item_skus_set( $square_item ) ) {
			WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Skipping sync for Square item ID %s missing one or more SKU.', $square_item->id ) );

			return;
		}

		// Only create items that don't yet exist in WC
		if ( $is_new_product ) {

			$wc_product = $this->create_product( $square_item, $include_category, $include_inventory, $include_image );

			WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Creating WC product for Square Item ID %s.', $square_item->id ) );
		}

		if ( $wc_product ) {

			WC_Square_Utils::set_square_ids_on_wc_product_by_sku( $wc_product, $square_item );

			$wc_product_id = version_compare( WC_VERSION, '3.0.0', '<' ) ? $wc_product->id : $wc_product->get_id();

			if ( ! $is_new_product ) {

				$this->update_product( $wc_product, $square_item, $include_category, $include_inventory, $include_image );

				WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Updating WC product for Square Item ID %s.', $square_item->id ) );

			}

			if ( $include_inventory ) {
				if ( WC_Square_Utils::skip_product_sync( $wc_product_id ) ) {
					WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Syncing disabled for this WC Product %d for Square ID %s', $wc_product_id, $square_item->id ) );

					return;
				}

				$this->sync_inventory( $wc_product, $square_item );

				WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Syncing WC product inventory for Square Item ID %s.', $square_item->id ) );

			}
		} else {

			WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Error creating WC Product found for Square Item ID %s.', $square_item->id ) );
			return;

		}

	}

	/**
	 * Create a new WC Product using data from Square.
	 *
	 * @param object     $square_item
	 * @param bool       $include_category
	 * @param bool       $include_inventory
	 * @param bool       $include_image
	 *
	 * @return bool|WC_Product Created WC_Product on success, boolean false on failure.
	 */
	public function create_product( $square_item, $include_category = false, $include_inventory = false, $include_image = false ) {

		$product_update = WC_Square_Utils::format_square_item_for_wc_api_create( $square_item, $include_category, $include_inventory, $include_image );

		// note here that when creating variations via WC API, if the parent product
		// is in the trash and the SKU matches the variation of the parent, the variations
		// won't be created. This is because the WC API is not checking if variations are
		// published.
		$result = $this->connect->wc->create_product( array( 'product' => $product_update ) );

		if ( is_wp_error( $result ) ) {

			WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Error creating WC Product for Square ID %s: %s', $square_item->id, $result->get_error_message() ) );

		} elseif ( isset( $result['product']['id'] ) ) {

			return wc_get_product( $result['product']['id'] );

		}

		return false;

	}

	/**
	 * Update an existing WC Product using data from Square.
	 *
	 * @param WC_Product $wc_product
	 * @param object     $square_item
	 * @param bool       $include_category
	 * @param bool       $include_inventory
	 * @param bool       $include_image
	 *
	 * @return bool|WC_Product Updated WC_Product on success, boolean false on failure.
	 */
	public function update_product( WC_Product $wc_product, $square_item, $include_category = false, $include_inventory = false, $include_image = false ) {

		$wc_product_id = version_compare( WC_VERSION, '3.0.0', '<' ) ? $wc_product->id : $wc_product->get_id();

		if ( WC_Square_Utils::skip_product_sync( $wc_product_id ) ) {
			WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Syncing disabled for this WC Product %d for Square ID %s', $wc_product_id, $square_item->id ) );

			return false;
		}

		$product_update = WC_Square_Utils::format_square_item_for_wc_api_update( $square_item, $wc_product, $include_category, $include_inventory, $include_image );

		$result = $this->connect->wc->edit_product( $wc_product_id, array( 'product' => $product_update ) );

		if ( is_wp_error( $result ) ) {

			WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Error updating WC Product %d for Square ID %s: %s', $wc_product_id, $square_item->id, $result->get_error_message() ) );

		} elseif ( isset( $result['product']['id'] ) ) {

			return wc_get_product( $result['product']['id'] );

		}

		return false;

	}

	/**
	 * Sync a WC Product's inventory with data from Square
	 *
	 * @param WC_Product $wc_product
	 * @param stdClass $square_item
	 */
	public function sync_inventory( WC_Product $wc_product, $square_item ) {
		if ( ! Woocommerce_Square::instance()->is_allowed_countries()
			|| ! Woocommerce_Square::instance()->is_allowed_currencies() ) {
			WC_Square_Sync_Logger::log( '[Square -> WC] Error syncing inventory for WC Product - Country or Currency mismatch' );
			return;
		}

		$wc_variation_ids = WC_Square_Utils::get_stock_managed_wc_variation_ids( $wc_product );
		$square_inventory = $this->connect->get_square_inventory();

		foreach ( $wc_variation_ids as $wc_variation_id ) {

			$square_variation_id = WC_Square_Utils::get_wc_variation_square_id( $wc_variation_id );

			if ( ! $square_variation_id || ! isset( $square_inventory[ $square_variation_id ] ) ) {

				continue;

			}

			// check each variation stock_tracking setting and set stock if tracking is enabled
			foreach ( $square_item->variations as $variation_item  ) {

				if ( $variation_item->id == $square_variation_id && $variation_item->track_inventory ) {

					$square_stock = (int) $square_inventory[ $square_variation_id ];
					$wc_variation = wc_get_product( $wc_variation_id );

					$current_stock = $wc_variation->get_stock_quantity();

					// Do not trigger sync if setting same stock quantity
					if ( $square_stock === $current_stock ) {
						continue;
					}

					$result       = version_compare( WC_VERSION, '3.0.0', '<' ) ? $wc_variation->set_stock( $square_stock ) : wc_update_product_stock( $wc_variation, $square_stock );

				}
			}
		}
	}

	/**
	 * Sync all inventory from Square (expensive)
	 * @todo if searching for square id fails, check for SKU
	 */
	public function sync_all_inventory() {
		if ( ! Woocommerce_Square::instance()->is_allowed_countries()
			|| ! Woocommerce_Square::instance()->is_allowed_currencies() ) {
			WC_Square_Sync_Logger::log( '[Square -> WC] Error syncing all inventory - Country or Currency mismatch' );
			return;
		}

		try {
			set_time_limit( apply_filters( 'woocommerce_square_inventory_sync_timeout_limit', 200 ) );

			// refresh cache first to get the latest inventory
			$this->connect->refresh_inventory_cache();

			$square_inventory = $this->connect->get_square_inventory();

			// To prevent infinite loop when stock is updated in WC.
			set_transient( 'wc_square_polling', 'yes', 60 * MINUTE_IN_SECONDS );

			// hopefully there has been a manual sync prior so that square item id
			// has already been saved in the product/variation metas to prevent
			// unnecessary round trip requests to Square to find the SKU
			foreach ( $square_inventory as $variation_id => $stock ) {
				WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Syncing WC product inventory for Square Item ID %s.', $variation_id ) );

				$wc_variation_product = WC_Square_Utils::get_wc_product_for_square_item_variation_id( $variation_id );

				if ( ! is_object( $wc_variation_product ) ) {
					WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Syncing WC product inventory for Square Item ID %s - WC product/variation not found skipping.', $variation_id ) );
					continue;
				}

				$product_id = 0;

				// check if we need to skip
				if ( 'simple' === ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $wc_variation_product->product_type : $wc_variation_product->get_type() ) ) {
					$product_id = version_compare( WC_VERSION, '3.0.0', '<' ) ? $wc_variation_product->id : $wc_variation_product->get_id();
				} elseif ( 'variation' === ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $wc_variation_product->product_type : $wc_variation_product->get_type() ) ) {
					$product_id = version_compare( WC_VERSION, '3.0.0', '<' ) ? $wc_variation_product->parent->id : $wc_variation_product->get_parent_id();
				}

				$current_stock = $wc_variation_product->get_stock_quantity();

				// Do not trigger sync if setting same stock quantity
				if ( $stock === $current_stock ) {
					WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Syncing WC product inventory for Square Item ID %s - No change in stock quantity for product/variation, skipping.', $variation_id ) );
					continue;
				}

				if ( is_object( $wc_variation_product ) && ! WC_Square_Utils::skip_product_sync( $product_id ) ) {
					version_compare( WC_VERSION, '3.0.0', '<' ) ? $wc_variation_product->set_stock( (int) $stock ) : wc_update_product_stock( $wc_variation_product, (int) $stock );
				}
			}

			delete_transient( 'wc_square_polling' );

			return true;
		} catch ( Exception $e ) {
			delete_transient( 'wc_square_polling' );
			WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Inventory Poll: ', $e->getMessage() ) );
		}
	}
}
