<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WC_Square_Bulk_Sync_Handler
 *
 * Facilitates Bulk syncing to/from Square/WC. Handles AJAX initiation of
 * sync, progress updates, actual sync method calls, and sync completion emails.
 */
class WC_Square_Bulk_Sync_Handler {

	public $connect;
	public $wc_to_square;
	public $square_to_wc;

	public function __construct( WC_Square_Connect $connect, WC_Square_Sync_To_Square $to_square, WC_Square_Sync_From_Square $from_square ) {

		$this->connect      = $connect;
		$this->wc_to_square = $to_square;
		$this->square_to_wc = $from_square;

		add_action( 'wp_ajax_square_to_wc', array( $this, 'square_to_wc_ajax' ) );
		add_action( 'wp_ajax_wc_to_square', array( $this, 'wc_to_square_ajax' ) );
	}

	/**
	 * Sets manual sync processing flag to prevent
	 * other processes from running such as inventory
	 * polling.
	 *
	 * @since 1.0.27
	 */
	public function sync_processing() {
		$cache_age = apply_filters( 'woocommerce_square_manual_sync_processing_cache', 2 * HOUR_IN_SECONDS );
		set_transient( 'wc_square_manual_sync_processing', 'yes', $cache_age );
	}

	/**
	 * Process Square to WC ajax
	 *
	 * @since 1.0.0
	 * @version 1.0.14
	 * @return bool
	 */
	public function square_to_wc_ajax() {
		check_ajax_referer( 'square-sync', 'security' );

		$this->sync_processing();

		/**
		 * Fires if a valid bulk Square to WC sync is being processed.
		 *
		 * @since 1.0.0
		 */
		do_action( 'woocommerce_square_bulk_syncing_square_to_wc' );

		$settings = get_option( 'woocommerce_squareconnect_settings' );
		$emails = ! empty( $settings['sync_email'] ) ? explode( ',', str_replace( ' ', '', $settings['sync_email'] ) ) : '';

		$sync_products   = ( 'yes' === $settings['sync_products'] );
		$sync_categories = ( 'yes' === $settings['sync_categories'] );
		$sync_inventory  = ( 'yes' === $settings['sync_inventory'] );
		$sync_images     = ( 'yes' === $settings['sync_images'] );
		$cache_age       = apply_filters( 'woocommerce_square_syncing_square_ids_cache', DAY_IN_SECONDS );
		$message         = '';

		if ( ! $sync_products ) {
			wp_send_json( array( 'process' => 'done', 'percentage' => 100, 'type' => 'square-to-wc', 'message' => __( 'Product Sync is disabled. Sync aborted.', 'woocommerce-square' ) ) );
		}

		// we need to check for cURL
		if ( ! function_exists( 'curl_init' ) ) {
			wp_send_json( array( 'process' => 'done', 'percentage' => 100, 'type' => 'square-to-wc', 'message' => __( 'cURL is not available. Sync aborted. Please contact your host to install cURL.', 'woocommerce-square' ) ) );
		}

		// if a WC to Square process still needs to be completed reset the caches
		// as the two processes ( WC -> Square and Square -> WC ) use the same cache
		if ( 'wc_to_square' === get_transient( 'sq_wc_sync_current_process' ) ) {
			WC_Square_Utils::delete_transients();
		}

		// set Square->WC as the current active process
		set_transient( 'sq_wc_sync_current_process', 'square_to_wc', $cache_age );

		// index for the current item in the process
		$process = $this->get_process_index();

		// only sync categories on the first pass
		if ( ( 0 === $process ) && $sync_categories ) {

			$this->square_to_wc->sync_categories();

		}

		if ( ( 0 === $process ) && $sync_inventory ) {
			// ensure this manual update gets the freshest item counts
			delete_transient( 'wc_square_inventory' );

			$this->connect->get_square_inventory();

		}

		// products
		// get all product ids
		$square_item_ids = $this->get_processing_ids();

		// run this only on first process
		if ( $process === 0 ) {
			$square_items    = $this->connect->get_square_products();
			$square_item_ids = ! empty( $square_items ) ? array_unique( wp_list_pluck( (array) $square_items, 'id' ) ) : array();

			// cache it
			set_transient( 'wc_square_processing_total_count', count( $square_item_ids ), $cache_age );
			set_transient( 'wc_square_processing_ids', $square_item_ids, $cache_age );

		}

		if ( $square_item_ids && $sync_products ) {

			$square_item_id = array_pop( $square_item_ids );
			$square_item    = $this->connect->get_square_product( $square_item_id );

			if ( $square_item ) {

				$this->square_to_wc->sync_product( $square_item, $sync_categories, $sync_inventory, $sync_images );

			} else {

				WC_Square_Sync_Logger::log( sprintf( '[Square -> WC] Bulk Sync: Error retrieving Square Item with ID %s.', $square_item_id ) );

			}

			$process++;

			$percentage = $this->get_process_percentage( $process );

			$this->delete_processed_id( $square_item_id );

			$remaining_ids = $this->get_processing_ids();

			// run this only on last process
			if ( empty( $remaining_ids ) ) {
				$process = 'done';

				$percentage = 100;

				// send sync email
				$this->send_sync_email( $emails, __( 'Sync Completed', 'woocommerce-square' ) );

				// reset the processed ids
				WC_Square_Utils::delete_transients();

				$message = __( 'Sync completed', 'woocommerce-square' );
			}

			wp_send_json( array( 'process' => $process, 'percentage' => $percentage, 'type' => 'square-to-wc', 'message' => $message ) );
		}
	}

	/**
	 * Process WC to Square ajax
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 * @return bool
	 */
	public function wc_to_square_ajax() {
		check_ajax_referer( 'square-sync', 'security' );

		$this->sync_processing();

		$settings = get_option( 'woocommerce_squareconnect_settings' );
		$emails = ! empty( $settings['sync_email'] ) ? $settings['sync_email'] : '';

		$sync_products   = ( 'yes' === $settings['sync_products'] );
		$sync_categories = ( 'yes' === $settings['sync_categories'] );
		$sync_inventory  = ( 'yes' === $settings['sync_inventory'] );
		$sync_images     = ( 'yes' === $settings['sync_images'] );
		$cache_age       = apply_filters( 'woocommerce_square_syncing_wc_product_ids_cache', DAY_IN_SECONDS );
		$message         = '';

		if ( ! $sync_products ) {
			wp_send_json( array( 'process' => 'done', 'percentage' => 100, 'type' => 'wc-to-square', 'message' => __( 'Product Sync is disabled. Sync aborted.', 'woocommerce-square' ) ) );
		}

		// we need to check for cURL
		if ( ! function_exists( 'curl_init' ) ) {
			wp_send_json( array( 'process' => 'done', 'percentage' => 100, 'type' => 'wc-to-square', 'message' => __( 'cURL is not available. Sync aborted. Please contact your host to install cURL.', 'woocommerce-square' ) ) );
		}

		// if a Square to WC process still needs to be completed reset the caches
		// as the two processes ( WC -> Square and Square -> WC ) use the same cache
		if ( 'square_to_wc' === get_transient( 'sq_wc_sync_current_process' ) ) {
			WC_Square_Utils::delete_transients();
		}

		// set WC->Square as the current active process
		set_transient( 'sq_wc_sync_current_process', 'wc_to_square', $cache_age );

		$process = $this->get_process_index();

		// only sync categories on the first pass
		if ( ( 0 === $process ) && $sync_categories ) {

			$this->wc_to_square->sync_categories();

		}
		
		// products
		// get all product ids
		$wc_product_ids = $this->get_processing_ids();

		// run the following only on first process and cache it
		if ( ( 0 === $process ) && $sync_products ) {

			$wc_product_ids = $this->get_all_product_ids();

			// cache it
			set_transient( 'wc_square_processing_total_count', count( $wc_product_ids ), $cache_age );
			set_transient( 'wc_square_processing_ids', $wc_product_ids, $cache_age );
		}

		if ( $sync_products && ! empty( $wc_product_ids ) ) {

			$wc_product_id = array_pop( $wc_product_ids );

			$wc_product = wc_get_product( $wc_product_id );

			if ( is_object( $wc_product ) && is_a( $wc_product, 'WC_Product' ) ) {
				$this->wc_to_square->sync_product( $wc_product, $sync_categories, $sync_inventory, $sync_images );
			}

			$process++;

			$percentage = $this->get_process_percentage( $process );

			if ( is_object( $wc_product ) ) {
				$this->delete_processed_id( version_compare( WC_VERSION, '3.0.0', '<' ) ? $wc_product->id : $wc_product->get_id() );
			} else {
				$this->delete_processed_id( $wc_product_id );
			}

			$remaining_ids = $this->get_processing_ids();

			// run this only on last process
			if ( empty( $remaining_ids ) ) {
				$process = 'done';

				$percentage = 100;

				// send sync email
				$this->send_sync_email( $emails, __( 'Sync Completed', 'woocommerce-square' ) );

				// reset the processed ids
				WC_Square_Utils::delete_transients();

				$message = __( 'Sync completed', 'woocommerce-square' );
			}

			wp_send_json( array( 'process' => $process, 'percentage' => $percentage, 'type' => 'wc-to-square', 'message' => $message ) );

		}

		wp_send_json( array( 'process' => 'done', 'percentage' => 100, 'type' => 'wc-to-square', 'message' => __( 'No Products to Sync.', 'woocommerce-square' ) ) );
	}

	/**
	 * Figure out at which product index we are
	 * at using the total count and the remaining item.
	 * The index stats at 0 .
	 *
	 * @since 1.0.0
	 *
	 * @return int $process_index
	 */
	public function get_process_index() {

		$total_items = (int) get_transient( 'wc_square_processing_total_count' );
		$remaining_ids_count = count( $this->get_processing_ids() );
		$process_index = $total_items - $remaining_ids_count;
		
		if ( empty( $process_index ) ) {
			$process_index = 0;
		}

		return $process_index;
	}

	/**
	 * Gets all product ids that are sync-eligible (they have SKUs).
	 *
	 * This looks for products as well as variations, if a variant has a SKU, the
	 * parent product will be included in the result set.
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.14
	 * @return array $ids
	 */
	public function get_all_product_ids() {

		$args = apply_filters( 'woocommerce_square_get_all_product_ids_args', array(
			'posts_per_page' => -1,
			'post_type'      => array( 'product', 'product_variation' ),
			'post_status'    => 'publish',
			'fields'         => 'id=>parent',
			'meta_query'     => array(
				array(
					'key'     => '_sku',
					'compare' => '!=',
					'value'   => ''
				)
			)
		) );

		$products_with_skus = get_posts( $args );
		$product_ids        = array();

		/*
		 * Our result set contains products and variations. We're only concerned with
		 * returning top-level products, so favor the parent ID if present (denotes a variation)
		 */
		foreach ( $products_with_skus as $product_id => $parent_id ) {
			$post_id = 0 == $parent_id ? $product_id : $parent_id;

			// check if product sync is disable, if so skip
			if ( WC_Square_Utils::skip_product_sync( $post_id ) ) {
				WC_Square_Sync_Logger::log( sprintf( '[WC -> Square] Syncing disabled for this WC Product %d', $post_id ) );

				continue;
			}

			// when it is a variation, we need to check its parent for publish
			// post status.
			if ( 0 == $parent_id ) {
				$product_ids[] = $product_id;
			} else {
				$post = get_post( $parent_id );

				if ( is_object( $post ) && 'publish' === $post->post_status ) {
					$product_ids[] = $parent_id;
				}
			}
		}

		/*
		 * Products can have multiple variants, so we might end up with
		 * duplicate parent product IDs in our list.
		 */
		$unique_product_ids = array_unique( $product_ids );

		return $unique_product_ids;
	}

	/**
	 * Deletes the product ID from the list so we can continue if sync is terminated early.
	 * This function can take both the WC product id or Square product ID
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @param string $product_id 
	 * @return bool
	 */
	public function delete_processed_id( $product_id = null ) {

		if ( null === $product_id ) {
			return false;
		}

		$ids = $this->get_processing_ids();

		if ( ( $key = array_search( $product_id, $ids ) ) !== false ) {
		    unset( $ids[ $key ] );
		}

		set_transient( 'wc_square_processing_ids', $ids, apply_filters( 'woocommerce_square_sync_processing_ids_cache', DAY_IN_SECONDS ) );

		return true;
	}

	/**
	 * Gets the already processed product IDs ( both Square and WC )
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @return array $ids
	 */
	public function get_processing_ids() {
		if ( $ids = get_transient( 'wc_square_processing_ids' ) ) {
			return $ids;
		}

		return array();
	}

	/**
	 * Get process percentage
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @param int $process the current process step
	 * @return string $percentage
	 */
	public function get_process_percentage( $process ) {

		$total_count = (int) get_transient( 'wc_square_processing_total_count' );
		$percentage  = 0;

		if ( $total_count > 0 ) {
			$percentage = ( $process / $total_count );
		}

		if ( 0 === $process ) {
			// 10% is added to offset the category process
			$percentage = $percentage + 0.10;
		}

		return round( $percentage, 2 ) * 100;
	}

	/**
	 * Sends the sync notification email when operation ends
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.14
	 * @param string $emails
	 * @param string $message
	 * @return bool
	 */
	public function send_sync_email( $emails, $message = '' ) {
		// default to admin's email
		if ( empty( $emails ) ) {
			$emails = array();
			$emails[] = get_option( 'admin_email' );
		}

		$subject = sprintf( __( '%s - WooCommerce Square Sync Operation', 'woocommerce-square' ), wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) );

		$headers = array();

		foreach ( $emails as $email ) {
			$headers[] = sprintf( __( '%s', 'woocommerce-square' ) . ' ' . wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) . ' <' . $email . '>', 'From:' ) . PHP_EOL;

			wp_mail( $email, $subject, $message, $headers );
		}

		return true;
	}

}
