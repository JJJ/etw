<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WC_Square_Connect
 *
 * A layer on top of WC_Square_Client, providing convenient wrapper methods
 * to work with the Square API in terms of WC Products and Square Items.
 */
class WC_Square_Connect {

	protected $_client;
	public $wc;
	public $log;

	const MULTIPLE_LOCATION_ACCOUNT_TYPE  = 'BUSINESS';
	const SINGLE_LOCATION_ACCOUNT_TYPE    = 'LOCATION';
	const ITEM_IMAGE_MULTIPART_BOUNDARY   = 'SQUARE-ITEM-IMAGE';
	const MERCHANT_ACCOUNT_TYPE_CACHE_KEY = 'wc_square_merchant_account_type';
	const LOCATIONS_CACHE_KEY             = 'wc_square_locations';
	const INVENTORY_CACHE_KEY             = 'wc_square_inventory';
	const ITEM_SKU_MAP_CACHE_KEY          = 'square_item_sku_map';

	/**
	 * WC_Square_Connect constructor.
	 */
	public function __construct( WC_Square_Client $client ) {

		$this->_client = $client;

		add_action( 'wp_loaded', array( $this, 'init' ) );

	}

	public function init() {

		add_action( 'woocommerce_square_bulk_syncing_square_to_wc', array( $this, 'clear_item_sku_map_cache' ) );

		$this->wc = new WC_Square_WC_Products();

		// add clear transients button in WC system tools
		add_filter( 'woocommerce_debug_tools', array( $this, 'add_debug_tool' ) );
	}

	/**
	 * Add debug tool button
	 *
	 * @access public
	 * @since 1.0.5
	 * @version 1.0.17
	 * @return array $tools
	 */
	public function add_debug_tool( $tools ) {
		if ( ! empty( $_GET['action'] ) && 'wcsquare_clear_transients' === $_GET['action'] && version_compare( WC_VERSION, '3.0', '<' ) ) {
			WC_Square_Utils::delete_transients();

			echo '<div class="updated"><p>' . esc_html__( 'Square Sync Transients Cleared', 'woocommerce-square' ) . '</p></div>';
		}

		$tools['wcsquare_clear_transients'] = array(
			'name'    => __( 'Square Sync Transients', 'woocommerce-square' ),
			'button'  => __( 'Clear all transients/cache', 'woocommerce-square' ),
			'desc'    => __( 'This will clear all Square Sync related transients/caches to start fresh. Useful when sync failed halfway through.', 'woocommerce-square' ),
		);

		if ( version_compare( WC_VERSION, '3.0', '>=' ) ) {
			$tools['wcsquare_clear_transients']['callback'] = 'WC_Square_Utils::delete_transients';
		}

		return $tools;
	}

	/**
	 * Checks to see if token is valid.
	 *
	 * There is no formal way to check this other than to
	 * retrieve the merchant account details and if it comes back
	 * with a code 200, we assume it is valid.
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @return bool
	 */
	public function is_valid_token() {

		$merchant_account_type = $this->get_square_merchant_account_type();

		return ( false !== $merchant_account_type );

	}

	/**
	 * Retrieve merchant's account information, such as business name and email address.
	 *
	 * Endpoint doc: https://docs.connect.squareup.com/api/connect/v1/#navsection-merchant
	 * Return value doc: https://docs.connect.squareup.com/api/connect/v1/#datatype-merchant
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @return false|null|object False if an HTTP error or non-200 status is encountered. Null on JSON decode error. Object on success.
	 */
	public function get_square_merchant() {

		return $this->_client->request( 'Retrieving Merchant', 'me' );

	}

	/**
	 * Get the account type for the merchant.
	 *
	 * See: https://docs.connect.squareup.com/api/connect/v1/#enum-merchantaccounttype
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @return bool|string Boolean false on failure, string account type (LOCATION or BUSINESS) on success.
	 */
	public function get_square_merchant_account_type() {

		$account_type = get_transient( self::MERCHANT_ACCOUNT_TYPE_CACHE_KEY );

		if ( false === $account_type ) {

			$merchant = $this->get_square_merchant();

			if ( is_null( $merchant ) || false === $merchant ) {

				return false;

			}

			if ( isset( $merchant->account_type ) ) {

				$account_type = $merchant->account_type;

				set_transient( self::MERCHANT_ACCOUNT_TYPE_CACHE_KEY, $account_type, DAY_IN_SECONDS );

			}

		}

		return $account_type;

	}

	/**
	 * Gets the locations of the business.
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @return array $locations
	 */
	public function get_square_business_locations() {

		if ( false !== ( $locations = get_transient( self::LOCATIONS_CACHE_KEY ) ) ) {

			if ( ! empty( $locations ) ) {
				return $locations;
			}

		}

		$locations    = array();
		$account_type = $this->get_square_merchant_account_type();
		
		/*
		 * Only "BUSINESS" accounts have multiple locations that need to be
		 * retrieved from a separate endpoint
		 * See: https://docs.connect.squareup.com/api/connect/v1/#get-locations
		 */
		if ( self::MULTIPLE_LOCATION_ACCOUNT_TYPE === $account_type ) {

			$items = $this->_client->request( 'Retrieve Business Locations', 'me/locations' );

			if ( ! empty( $items ) ) {

				foreach( $items as $item ) {
					if ( is_object( $item ) ) {
						$locations[ $item->id ] = $item->name;
					}
				}
			}
		}

		/*
		 * Single location accounts have all the details under the Merchant object
		 */
		if ( self::SINGLE_LOCATION_ACCOUNT_TYPE === $account_type ) {

			$merchant = $this->get_square_merchant();

			if ( isset( $merchant->id ) ) {

				$locations[ $merchant->id ] = $merchant->name;

			}

		}

		set_transient( self::LOCATIONS_CACHE_KEY, $locations, apply_filters( 'woocommerce_square_business_location_cache', DAY_IN_SECONDS ) );

		return $locations;

	}

	/**
	 * Create a Square Item for a WC Product.
	 *
	 * See: https://docs.connect.squareup.com/api/connect/v1/#post-items
	 *
	 * @param WC_Product $wc_product
	 * @param bool       $include_category
	 * @param bool       $include_inventory
	 * @return object|bool Created Square Item object on success, boolean False on failure.
	 */
	public function create_square_product( $wc_product, $include_category = false, $include_inventory = false ) {

		// We can only handle simple products or ones with variations
		if ( ! in_array( ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $wc_product->product_type : $wc_product->get_type() ), array( 'simple', 'variable' ) ) ) {

			return false;

		}

		// TODO: Consider making this method "dumber" - remove this formatting call.
		$product = WC_Square_Utils::format_wc_product_create_for_square_api(
			$wc_product,
			$include_category,
			$include_inventory
		);

		return $this->_client->request( 'Creating Square Base Product from: ' . ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $wc_product->id : $wc_product->get_id() ), 'items', 'POST', $product );

	}

	/**
	 * Update the corresponding Square Item for a WC Product.
	 *
	 * See: https://docs.connect.squareup.com/api/connect/v1/#put-itemid
	 *
	 * @param WC_Product $wc_product
	 * @param string     $square_item_id
	 * @param bool       $include_category
	 * @param bool       $include_inventory
	 * @return object|bool Updated Square Item object on success, boolean False on failure.
	 */
	public function update_square_product( $wc_product, $square_item_id, $include_category = false, $include_inventory = false ) {

		// We can only handle simple products or ones with variations
		if ( ! in_array( ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $wc_product->product_type : $wc_product->get_type() ), array( 'simple', 'variable' ) ) ) {

			return false;

		}

		// TODO: Consider making this method "dumber" - remove this formatting call.
		$product = WC_Square_Utils::format_wc_product_update_for_square_api( $wc_product, $include_category );

		$endpoint = 'items/' . $square_item_id;

		return $this->_client->request( 'Updating a Square Base Product for: ' . $square_item_id, $endpoint, 'PUT', $product );

	}

	/**
	 * Set the HTTP request Content-Type header to multipart/form-data for uploading Item images.
	 *
	 * @param array $http_args
	 * @return array
	 */
	public function square_product_image_update_filter_http_args( $http_args ) {

		if ( empty( $http_args['headers'] ) ) {

			$http_args['headers'] = array();

		}

		$http_args['headers']['Content-Type'] = 'multipart/form-data; boundary=' . self::ITEM_IMAGE_MULTIPART_BOUNDARY;

		return $http_args;

	}

	/**
	 * Updates the master image for an Item
	 * See: https://docs.connect.squareup.com/api/connect/v1/#post-image
	 *
	 * @param string $square_item_id Square Item ID to upload image for.
	 * @param string $mime_type Mime type of the image.
	 * @param string $path_to_image Full path to image, accessible using file_get_contents().
	 * @return bool|object Response object on success, boolean false on failure.
	 */
	public function update_square_product_image( $square_item_id, $mime_type, $path_to_image ) {

		// The WP HTTP API doesn't natively support multipart form data, so we must build the body ourselves
		// See: http://lists.automattic.com/pipermail/wp-hackers/2013-January/045105.html
		$request_body = '--' . self::ITEM_IMAGE_MULTIPART_BOUNDARY . "\r\n";
		$request_body .= 'Content-Disposition: form-data; name="image_data"; filename="' . basename( $path_to_image ) . '"' . "\r\n";
		$request_body .= 'Content-Type: ' . $mime_type . "\r\n\r\n"; // requires two CRLFs
		$request_body .= file_get_contents( $path_to_image );
		$request_body .= "\r\n--" . self::ITEM_IMAGE_MULTIPART_BOUNDARY . "--\r\n\r\n"; // requires two CRLFs

		$api_path = '/items/' . $square_item_id . '/image';

		add_filter( 'woocommerce_square_request_args', array( $this, 'square_product_image_update_filter_http_args' ) );

		$result = $this->_client->request( 'Updating Square Item Image for: ' . $square_item_id, $api_path, 'POST', $request_body );

		remove_filter( 'woocommerce_square_request_args', array( $this, 'square_product_image_update_filter_http_args' ) );

		return $result;

	}

	/**
	 * Updates a product for a particular location
	 * Square API does not allow updates to a product along with variations (sucks)
	 * So a separate requests have to be made to update the variations see - update_square_variation()
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @param int $product_id id from Square
	 * @param object $wc_product
	 * @return mixed
	 */
	public function update_square_base_product( $s_product_id, $wc_product ) {

		$product  = array(
			'name'        => $wc_product->get_title(),
			'description' => version_compare( WC_VERSION, '3.0.0', '<' ) ? $wc_product->post->post_content : $wc_product->get_description(),
			'visibility'  => 'PUBLIC',
		);

		$category = wp_get_post_terms( version_compare( WC_VERSION, '3.0.0', '<' ) ? $wc_product->id : $wc_product->get_id(), 'product_cat', array( 'parent' => 0 ) );

		if ( ! empty( $category ) ) {

			$square_cat_id = get_woocommerce_term_meta( $category[0]->term_id, 'square_cat_id', true );

			$product['category_id'] = $square_cat_id;

		}

		$endpoint = 'items/' . $s_product_id;

		return $this->_client->request( 'Updating a Square Base Product for: ' . $s_product_id, $endpoint, 'PUT', $product );

	}

	/**
	 * Updates a single product variation
	 * Note that each product has at least one variation in Square
	 * Square does not allow multiple variation to be updated at the same time
	 *
	 * @param string $square_item_id id from Square
	 * @param object|array $variation_data Data to create ItemVariation with
	 * @return mixed
	 */
	public function create_square_variation( $square_item_id, $variation_data ) {
		if ( empty( $square_item_id ) ) {
			return false;
		}

		$endpoint = '/items/' . $square_item_id . '/variations';

		return $this->_client->request( 'Creating a Square Product Variation for: ' . $square_item_id, $endpoint, 'POST', $variation_data );

	}

	/**
	 * Updates a single product variation
	 * Note that each product has at least one variation in Square
	 * Square does not allow multiple variation to be updated at the same time
	 *
	 * @param string $square_item_id id from Square
	 * @param string $square_variation_id id from Square
	 * @param object|array $variation_data Data to update ItemVariation with
	 * @return mixed
	 */
	public function update_square_variation( $square_item_id, $square_variation_id, $variation_data ) {
		if ( empty( $square_item_id ) ) {
			return false;
		}

		$endpoint = '/items/' . $square_item_id . '/variations/' . $square_variation_id;

		return $this->_client->request( 'Updating a Square Product Variation for: ' . $square_variation_id, $endpoint, 'PUT', $variation_data );

	}

	/**
	 * Deletes a single product variation
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @param int $s_product_id id from Square
	 * @param int $s_variation_id id from Square
	 * @return mixed
	 */
	public function delete_square_variation( $s_product_id, $s_variation_id ) {

		$endpoint = '/items/' . $s_product_id . '/variations/' . $s_variation_id;

		return $this->_client->request( 'Deleting a Square Product Variation for: ' . $s_variation_id, $endpoint, 'DELETE' );

	}

	/**
	 * Gets the products for a particular location
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @return mixed
	 */
	public function get_square_products() {

		$response = $this->_client->request( 'Retrieving Products', 'items' );

		return $response ? $response : array();

	}

	/**
	 * Gets a product for a particular location
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @param string $s_product_id
	 * @return mixed
	 */
	public function get_square_product( $s_product_id ) {

		if ( empty( $s_product_id ) ) {

			return array();

		}

		$endpoint = 'items/' . $s_product_id;
		$response = $this->_client->request( 'Retrieving a Square Product for: ' . $s_product_id, $endpoint );

		return $response ? $response : array();

	}

	/**
	 * Clear the Square Item SKU Map Cache
	 */
	public function clear_item_sku_map_cache() {

		delete_transient( self::ITEM_SKU_MAP_CACHE_KEY );

	}

	/**
	 * Generate a mapping of Square Item IDs to their associated SKUs.
	 *
	 * @return array List of Square Item IDs and their variation SKUs.
	 */
	public function get_square_product_sku_map() {

		if ( $cached = get_transient( self::ITEM_SKU_MAP_CACHE_KEY ) ) {

			return $cached;

		}

		$square_products        = $this->get_square_products();
		$square_product_sku_map = array();
		$processed_ids          = array();

		foreach ( $square_products as $s_product ) {
			// Square may return dups so make sure we check for that
			if ( in_array( $s_product->id, $processed_ids ) ) {
				continue;
			}

			$square_product_sku_map[ $s_product->id ] = array();

			foreach ( $s_product->variations as $s_variation ) {

				if ( ! empty( $s_variation->sku ) ) {

					$square_product_sku_map[ $s_product->id ][] = $s_variation->sku;

				}
			}

			$processed_ids[] = $s_product;
		}

		set_transient( self::ITEM_SKU_MAP_CACHE_KEY, $square_product_sku_map, apply_filters( 'woocommerce_square_item_sku_cache', DAY_IN_SECONDS ) );

		return $square_product_sku_map;

	}

	/**
	 * Checks if product exists on square
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @param string|array $sku_list One or more SKUs to get a product by
	 * @return false if not exists or product object
	 */
	public function square_product_exists( $sku_list ) {

		$square_item_sku_map = $this->get_square_product_sku_map();

		$sku_list = (array) $sku_list;

		foreach ( $square_item_sku_map as $square_item_id => $square_item_skus ) {

			if ( array_intersect( $sku_list, $square_item_skus ) ) {

				return $this->get_square_product( $square_item_id );

			}

		}

		return false;

	}

	/**
	 * Gets the categories for a particular location
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @return mixed
	 */
	public function get_square_categories() {

		$response = $this->_client->request( 'Retrieving Square Categories', 'categories' );

		return $response ? $response : array();

	}

	/**
	 * Create a square category
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @param string $name
	 * @return mixed
	 */
	public function create_square_category( $name ) {

		$category = array(
			'name' => sanitize_text_field( $name ),
		);

		return $this->_client->request( 'Creating Square Category for: ' . sanitize_text_field( $name ), 'categories', 'POST', $category );

	}

	/**
	 * Update a Square Category
	 *
	 * @param string $square_category_id
	 * @param string $name
	 *
	 * @return bool|object|WP_Error
	 */
	public function update_square_category( $square_category_id, $name ) {

		$endpoint = 'categories/' . $square_category_id;
		$category = array(
			'name' => sanitize_text_field( $name ),
		);

		return $this->_client->request( 'Updating Category for: ' . sanitize_text_field( $name ), $endpoint, 'PUT', $category );

	}

	/**
	 * Get square variation inventory.
	 *
	 * Note: There is no current way to get a specific product variation's inventory.
	 *
	 * @return array
	 */
	public function get_square_inventory() {
		if ( $cached = get_transient( self::INVENTORY_CACHE_KEY ) ) {

			return $cached;

		}

		$response = $this->_client->request( 'Getting All Square Inventory', 'inventory' ); // default 1000 max limit

		$square_inventory = array();

		if ( is_array( $response ) ) {

			$square_inventory_ids        = wp_list_pluck( $response, 'variation_id' );
			$square_inventory_quantities = wp_list_pluck( $response, 'quantity_on_hand' );
			$square_inventory            = array_combine( $square_inventory_ids, $square_inventory_quantities );

		}

		set_transient( self::INVENTORY_CACHE_KEY, $square_inventory, apply_filters( 'woocommerce_square_inventory_cache', DAY_IN_SECONDS ) );

		return $square_inventory;

	}

	/**
	 * Updates square variation inventory
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @param string $square_variation_id
	 * @param int $quantity_delta
	 * @param string $type the type of adjustment MANUAL_ADJUST, RECEIVE_STOCK, SALE
	 * @return bool
	 */
	public function update_square_inventory( $square_variation_id, $quantity_delta, $type = 'MANUAL_ADJUST' ) {

		$endpoint  = 'inventory/' . $square_variation_id;
		$inventory = array(
			'quantity_delta'  => $quantity_delta,
			'adjustment_type' => $type,
		);
		$response  = $this->_client->request( 'Updating Square Inventory for: ' . $square_variation_id, $endpoint, 'POST', $inventory );

		return ( false !== $response );

	}

	/**
	 * Refresh the Square Inventory cache.
	 */
	public function refresh_inventory_cache() {
		delete_transient( self::INVENTORY_CACHE_KEY );
	}
}
