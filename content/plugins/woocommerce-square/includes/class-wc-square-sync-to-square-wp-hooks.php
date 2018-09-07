<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class WC_Square_Sync_To_Square_WordPress_Hooks
 *
 * Attach WC_Square_Sync_To_Square methods to WordPress and WooCommerce core hooks.
 */
class WC_Square_Sync_To_Square_WordPress_Hooks {

	/**
	 * @var WC_Integration
	 */
	protected $integration;

	/**
	 * @var WC_Square_Sync_To_Square
	 */
	protected $square;

	/**
	 * Whether or not to sync product data to Square.
	 *
	 * @var bool
	 */
	protected $sync_products;

	/**
	 * @var bool
	 */
	protected $sync_categories;

	/**
	 * @var bool
	 */
	protected $sync_images;

	/**
	 * @var bool
	 */
	protected $sync_inventory;

	/**
	 * Whether or not hooks should fire.
	 *
	 * @var bool
	 */
	protected $enabled = true;

	/**
	 * Keep track of which products have already assigned a sync job
	 *
	 * @var array
	 */
	protected $products_synced = array(
	);

	/**
	 * WC_Square_Sync_To_Square_WordPress_Hooks constructor.
	 *
	 * @param WC_Integration           $integration
	 * @param WC_Square_Sync_To_Square $square
	 */
	public function __construct( WC_Integration $integration, WC_Square_Sync_To_Square $square ) {

		$this->integration = $integration;
		$this->square      = $square;

		$this->sync_products   = ( 'yes' === $integration->get_option( 'sync_products' ) );
		$this->sync_categories = ( 'yes' === $integration->get_option( 'sync_categories' ) );
		$this->sync_images     = ( 'yes' === $integration->get_option( 'sync_images' ) );
		$this->sync_inventory  = ( 'yes' === $integration->get_option( 'sync_inventory' ) );

		add_action( 'wc_square_loaded', array( $this, 'attach_hooks' ) );
		add_action( 'wc_square_save_post_event', array( $this, 'process_save_post_event' ), 10, 2 );
		add_action( 'wc_square_on_product_set_stock_event', array( $this, 'on_product_set_stock' ) );
		add_action( 'wc_square_on_variation_set_stock_event', array( $this, 'on_variation_set_stock' ) );
	}

	/**
	 * Dynamically enable WP/WC hook callbacks.
	 */
	public function enable() {

		$this->enabled = true;

	}

	/**
	 * Dynamically disable WP/WC hook callbacks.
	 */
	public function disable() {

		$this->enabled = false;

	}

	/**
	 * Hook into WordPress and WooCommerce core.
	 */
	public function attach_hooks() {

		if ( $this->sync_products ) {
			if ( version_compare( WC_VERSION, '3.0.0', '<' ) ) {
				add_action( 'save_post', array( $this, 'pre_wc_30_on_save_post' ), 10, 2 );
			} else {
				add_action( 'woocommerce_before_product_object_save', array( $this, 'on_save_post' ), 10, 2 );
			}
		}

		if ( $this->sync_categories ) {

			add_action( 'created_product_cat', array( $this, 'on_category_modified' ) );

			add_action( 'edited_product_cat', array( $this, 'on_category_modified' ) );

		}

		if ( $this->sync_inventory  ) {
			$param = isset( $_GET['wc-api'] ) ? $_GET['wc-api'] : '';

			if ( 'WC_Square_Integration' !== $param ) {

				// Only add the stock hooks for versions below 3.0. In versions
				// >= 3.0 the save hook will take care of stock inventory as well.
				if ( version_compare( WC_VERSION, '3.0.0', '<' ) ) {
					add_action( 'woocommerce_product_set_stock', array( $this, 'schedule_on_product_set_stock' ) );

					add_action( 'woocommerce_variation_set_stock', array( $this, 'schedule_on_variation_set_stock' ) );
				}
			}
		}

	}

	/**
	 * Sync a WC Product to Square when it is saved.
	 *
	 * @param int $post_id
	 * @param bool $sync_categories
	 * @param bool $sync_inventory
	 * @param bool $sync_images
	 */
	public function process_save_post_event( $post_id ) {
		// clear inventory cache
		delete_transient( 'wc_square_inventory' );

		$wc_product = wc_get_product( $post_id );

		if ( WC_Square_Utils::skip_product_sync( $post_id ) ) {
			return;
		}

		if ( is_object( $wc_product ) && ! empty( $wc_product ) ) {
			$this->square->sync_product( $wc_product, $this->sync_categories, $this->sync_inventory, $this->sync_images );
		}

		WC_Square_Utils::delete_transients();
	}

	/**
	 * Trigger the save post event.
	 *
	 * @since 1.0.0
	 * @version 1.0.20
	 * @param object $product
	 * @param object $data_store
	 */
	public function on_save_post( $product, $data_store ) {
		$post = get_post( $product->get_id() );

		if ( ! $this->enabled
			|| in_array( $product->get_id(), $this->products_synced )
			|| ( defined( 'WP_LOAD_IMPORTERS' ) && WP_LOAD_IMPORTERS )
			|| wp_is_post_revision( $post )
			|| wp_is_post_autosave( $post )
			|| ( 'publish' !== get_post_status( $post ) )
			|| 'product' !== $post->post_type
		) {
			return;
		}

		// Because of metaboxes, core may fire save on the product a couple of times.
		// TODO: This workaround should be resolved once we re-architecture Square to
		// use Action Scheduler (or something similar, a queue) to manage jobs.
		$this->products_synced[] = $product->get_id();

		$args = array(
			$product->get_id(),
			uniqid(), // this is needed due to WP not scheduling new events with same name and args
		);

		wp_schedule_single_event( time() + 60, 'wc_square_save_post_event', $args );
	}

	/**
	 * Trigger the save post event.
	 *
	 * @see 'save_post'
	 * @since 1.0.0
	 * @version 1.0.20
	 * @param $post_id
	 * @param $post
	 */
	public function pre_wc_30_on_save_post( $post_id, $post ) {
		if ( ! $this->enabled
			|| ( defined( 'DOING_AJAX' ) && DOING_AJAX ) // TODO: Look into removing this check.
			|| ( defined( 'WP_LOAD_IMPORTERS' ) && WP_LOAD_IMPORTERS )
			|| wp_is_post_revision( $post )
			|| wp_is_post_autosave( $post )
			|| ( 'publish' !== get_post_status( $post ) )
			|| 'product' !== $post->post_type
		) {
			return;
		}

		$args = array(
			$post_id,
			uniqid(), // this is needed due to WP not scheduling new events with same name and args
		);

		wp_schedule_single_event( time() + 60, 'wc_square_save_post_event', $args );
	}

	/**
	 * Sync categories to Square when a category is created or altered.
	 */
	public function on_category_modified() {

		if ( $this->enabled ) {

			$this->square->sync_categories();

		}

	}

	/**
	 * Schedule cron job when product stock is changed.
	 *
	 * @since 1.0.16
	 * @version 1.0.16
	 */
	public function schedule_on_product_set_stock( WC_Product $wc_product ) {
		if ( ! is_object( $wc_product ) || empty( $wc_product ) ) {
			return;
		}

		$args = array(
			$wc_product,
			uniqid(), // this is needed due to WP not scheduling new events with same name and args
		);

		$polling = get_transient( 'wc_square_polling' );

		if ( $this->enabled && ! $polling ) {
			wp_schedule_single_event( time() + 60, 'wc_square_on_product_set_stock_event', $args );
		}
	}

	/**
	 * Schedule cron job when product variation stock is changed.
	 *
	 * @since 1.0.16
	 * @version 1.0.16
	 */
	public function schedule_on_variation_set_stock( WC_Product_Variation $wc_variation ) {
		if ( ! is_object( $wc_variation ) || empty( $wc_variation ) ) {
			return;
		}

		$args = array(
			$wc_variation,
			uniqid(), // this is needed due to WP not scheduling new events with same name and args
		);

		$polling = get_transient( 'wc_square_polling' );

		if ( $this->enabled && ! $polling ) {
			wp_schedule_single_event( time() + 60, 'wc_square_on_variation_set_stock_event', $args );
		}
	}

	/**
	 * Sync inventory to Square when a product's stock is altered.
	 *
	 * @param array $wc_product
	 */
	public function on_product_set_stock( $wc_product ) {
		$this->square->sync_inventory( $wc_product );
	}

	/**
	 * Sync inventory to Square when a variation's stock is altered.
	 *
	 * @param array $wc_variation
	 */
	public function on_variation_set_stock( $wc_variation ) {
		$product = version_compare( WC_VERSION, '3.0.0', '<' ) ? $wc_variation->parent : wc_get_product( $wc_variation->get_parent_id() );
		$this->square->sync_inventory( $product );
	}
}
