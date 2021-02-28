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
use WooCommerce\Square\Plugin;
use WooCommerce\Square\Handlers\Product;

defined( 'ABSPATH' ) || exit;

/**
 * Order handler class.
 *
 * @since 2.0.0
 */
class Order {

	/**
	 * Array of previous stock values.
	 *
	 * @var array
	 */
	private $previous_stock = array();

	/**
	 * Array of product IDs that have been scheduled for sync in this request.
	 *
	 * @var array
	 */
	private $products_to_sync = array();


	/**
	 * Sets up Square order handler.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		// remove Square variation IDs from order item meta
		add_action( 'woocommerce_hidden_order_itemmeta', array( $this, 'hide_square_order_item_meta' ) );

		// ADD hooks for stock syncs based on changes from orders not from this gateway
		add_action( 'woocommerce_checkout_order_processed', array( $this, 'maybe_sync_stock_for_order_via_other_gateway' ), 10, 3 );

		// Add specific hook for paypal IPN callback
		add_action( 'valid-paypal-standard-ipn-request', array( $this, 'maybe_sync_stock_for_order_via_paypal' ), 10, 1 );

		// ADD hooks to listen to refunds on orders from other gateways.
		add_action( 'woocommerce_order_refunded', array( $this, 'maybe_sync_stock_for_refund_from_other_gateway' ), 10, 2 );
	}


	/**
	 * Ensures the Square order item meta is hidden.
	 *
	 * @since 2.0.0
	 *
	 * @param string[] $hidden the hidden order item meta
	 * @return string[] updated meta
	 */
	public function hide_square_order_item_meta( $hidden ) {

		$hidden[] = '_square_item_variation_id';

		return $hidden;
	}

	/**
	 * Add hooks to ensure PayPal IPN callbacks are added caches and considered for inventory changes
	 * when the sync happens. This also adds the shutdown hook to ensure sync happens if needed at
	 * a later stage.
	 *
	 * @since 2.1.1
	 *
	 * @param array $posted values returned from PayPal Standard IPN callback.
	 */
	public function maybe_sync_stock_for_order_via_paypal( $posted ) {
		if ( empty( $posted['custom'] ) ) {
			return;
		}

		$raw_order = json_decode( $posted['custom'] );
		if ( empty( $raw_order->order_id ) ) {
			return;
		}

		$order = wc_get_order( $raw_order->order_id );

		if ( ! $order || ! $order instanceof \WC_Order ) {
			return;
		}

		$this->sync_stock_for_order( $order );
	}

	/**
	 * Checks if we should sync stock for this order.
	 * We only sync for other gateways that Square will not be aware of.
	 *
	 * This functions sets a process in motion that gathers products that will be processed on shutdown.
	 *
	 * @since 2.0.8
	 *
	 * @param int      $order_id    Order ID number.
	 * @param array    $posted_data Submitted order data.
	 * @param WC_Order $order       Order object.
	 */
	public function maybe_sync_stock_for_order_via_other_gateway( $order_id, $posted_data, $order ) {

		// Confirm we are not processing the order through the Square gateway.
		if ( ! $order instanceof \WC_Order || Plugin::GATEWAY_ID === $order->get_payment_method() ) {
			return;
		}

		$this->sync_stock_for_order( $order );
	}

	/**
	 * For a given order sync stock if inventory sync is enabled.
	 *
	 * @since 2.1.1
	 *
	 * @param \WC_Order $order the order for which the stock must be synced.
	 */
	protected function sync_stock_for_order( $order ) {

		if ( ! wc_square()->get_settings_handler()->is_inventory_sync_enabled() ) {
			return;
		}

		$this->cache_previous_stock( $order );

		add_action( 'woocommerce_product_set_stock', array( $this, 'maybe_stage_inventory_updates_for_product' ) );
		add_action( 'woocommerce_variation_set_stock', array( $this, 'maybe_stage_inventory_updates_for_product' ) );

		add_action( 'shutdown', array( $this, 'maybe_sync_staged_inventory_updates' ) );
	}

	/**
	 * Loop through order and cached previous stock values before they are reduced.
	 *
	 * @since 2.0.8
	 *
	 * @param WC_Order $order Order object.
	 */
	private function cache_previous_stock( $order ) {

		// Loop over all items.
		foreach ( $order->get_items() as $item ) {
			if ( ! $item->is_type( 'line_item' ) ) {
				continue;
			}

			// Check to make sure it hasn't already been reduced.
			$product            = $item->get_product();
			$item_stock_reduced = $item->get_meta( '_reduced_stock', true );

			if ( $item_stock_reduced || ! $product || ! $product->managing_stock() ) {
				continue;
			}

			$this->previous_stock[ $product->get_id() ] = $product->get_stock_quantity();
		}
	}

	/**
	 * Stages a product inventory update for sync with Square when a product stock is updated.
	 *
	 * @internal The staged values will be stored in product_to_sync
	 *
	 * @since 2.0.8
	 *
	 * @param WC_Product $product the updated product with inventory updates.
	 */
	public function maybe_stage_inventory_updates_for_product( $product ) {

		// Do not add inventory changes if we are already doing a sync, or we are not syncing this product.
		if ( defined( 'DOING_SQUARE_SYNC' ) || ! $product || ! Product::is_synced_with_square( $product ) ) {
			return;
		}

		// Compare stock to get difference.
		$product_id = $product->get_id();
		$previous   = isset( $this->previous_stock[ $product_id ] ) ? $this->previous_stock[ $product_id ] : false;
		$current    = $product->get_stock_quantity();
		$adjustment = (int) $current - $previous;

		if ( false === $previous || 0 === $adjustment ) {
			return;
		}

		// Record what type of inventory action occurred.
		$this->products_to_sync[ $product_id ] = $adjustment;
	}


	/**
	 * Initializes a synchronization event for any staged inventory updates in this request.
	 *
	 * @internal
	 *
	 * @since 2.0.8
	 */
	public function maybe_sync_staged_inventory_updates() {

		$inventory_adjustments = array();

		foreach ( $this->products_to_sync as $product_id => $adjustment ) {

			$product = wc_get_product( $product_id );
			if ( ! $product instanceof \WC_Product ) {
				continue;
			}

			$inventory_adjustment = Product::get_inventory_change_adjustment_type( $product, $adjustment );

			if ( empty( $inventory_adjustment ) ) {
				continue;
			}

			$inventory_adjustments[] = $inventory_adjustment;
		}

		if ( empty( $inventory_adjustments ) ) {
			return;
		}

		wc_square()->log( 'New order from other gateway inventory syncing..' );
		$idempotency_key = wc_square()->get_idempotency_key( md5( serialize( $inventory_adjustments ) ) . '_change_inventory' );
		wc_square()->get_api()->batch_change_inventory( $idempotency_key, $inventory_adjustments );
	}

	/**
	 * Handle order refunds inventory/stock changes sync.
	 *
	 * @since 2.0.8
	 *
	 * @param in $order_id
	 * @param int $refund_id
	 */
	public function maybe_sync_stock_for_refund_from_other_gateway( $order_id, $refund_id ) {

		if ( ! wc_square()->get_settings_handler()->is_inventory_sync_enabled() ) {
			return;
		}

		// Confirm we are not processing the order through the Square gateway.
		$order = wc_get_order( $order_id );
		if ( ! $order instanceof \WC_Order || Plugin::GATEWAY_ID === $order->get_payment_method() ) {
			return;
		}

		// don't refund items if the "Restock refunded items" option is unchecked - maintains backwards compatibility if this function is called outside of the `woocommerce_order_refunded` do_action
		if ( check_ajax_referer( 'order-item', 'security', false ) && isset( $_POST['restock_refunded_items'] ) && 'false' === $_POST['restock_refunded_items'] ) {
			return;
		}

		$refund                = new \WC_Order_Refund( $refund_id );
		$inventory_adjustments = array();
		foreach ( $refund->get_items() as $item ) {

			if ( 'line_item' !== $item->get_type() ) {
				continue;
			}

			$product = $item->get_product();
			if ( ! $product instanceof \WC_Product ) {
				continue;
			}

			$adjustment           = -1 * ( $item->get_quantity() ); // we want a positive value to increase the stock and a negative number to decrease it.
			$inventory_adjustment = Product::get_inventory_change_adjustment_type( $product, $adjustment );

			if ( empty( $inventory_adjustment ) ) {
				continue;
			}

			$inventory_adjustments[] = $inventory_adjustment;
		}

		if ( empty( $inventory_adjustments ) ) {
			return;
		}

		wc_square()->log( 'Order from other gateway Refund inventory updates syncing..' );
		$idempotency_key = wc_square()->get_idempotency_key( md5( serialize( $inventory_adjustments ) ) . '_change_inventory' );
		wc_square()->get_api()->batch_change_inventory( $idempotency_key, $inventory_adjustments );
	}
}
