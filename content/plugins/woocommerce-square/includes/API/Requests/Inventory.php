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

namespace WooCommerce\Square\API\Requests;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;
use SquareConnect\Model as SquareModel;
use SquareConnect\Api\InventoryApi;
use WooCommerce\Square\API\Request;

defined( 'ABSPATH' ) or exit;

/**
 * WooCommerce Square Inventory API Request class
 *
 * @since 2.0.0
 */
class Inventory extends Request {


	/**
	 * Initializes a new Inventory request.
	 *
	 * @since 2.0.0
	 *
	 * @param \SquareConnect\ApiClient $api_client the API client
	 */
	public function __construct( $api_client ) {

		$this->square_api = new InventoryApi( $api_client );
	}


	/**
	 * Sets the data for a batchChangeInventory request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-inventory-batchchangeinventory
	 * @see InventoryApi::batchChangeInventory()
	 *
	 * @since 2.0.0
	 *
	 * @param string $idempotency_key a UUID for this request
	 * @param SquareModel\InventoryChange[] $changes array of inventory changes to be made
	 * @param bool $ignore_unchanged_counts whether the current physical count should be ignored if the quantity is unchanged since the last physical count
	 */
	public function set_batch_change_inventory_data( $idempotency_key, $changes, $ignore_unchanged_counts = true ) {

		$this->square_api_method = 'batchChangeInventory';
		$this->square_api_args   = [ new SquareModel\BatchChangeInventoryRequest( [
			'idempotency_key'         => $idempotency_key,
			'changes'                 => $changes,
			'ignore_unchanged_counts' => (bool) $ignore_unchanged_counts
		] ) ];
	}


	/**
	 * Sets the data for a batchRetrieveInventoryChanges request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-inventory-batchretrieveinventorychanges
	 * @see InventoryApi::batchRetrieveInventoryChanges()
	 *
	 * @since 2.0.0
	 *
	 * @param array $args
	 *     @type string[] $catalog_object_ids filters results by CatalogObject ID
	 *     @type string[] $location_ids filters results by Location ID
	 *     @type string[] $types filters results by InventoryChangeType
	 *     @type string[] $states filters ADJUSTMENT query results by InventoryState
	 *     @type string $updated_after filters any changes updated after this time
	 *     @type string $updated_before filters any changes updated before this time
	 *     @type string $cursor pagination cursor
	 */
	public function set_batch_retrieve_inventory_changes_data( $args = [] ) {

		$defaults = [
			'catalog_object_ids' => null,
			'location_ids'       => null,
			'types'              => null,
			'states'             => null,
			'updated_after'      => null,
			'updated_before'     => null,
			'cursor'             => null,
		];

		// apply defaults and remove any keys that aren't recognized
		$args = array_intersect_key( wp_parse_args( $args, $defaults ), $defaults );

		$this->square_api_method = 'batchRetrieveInventoryChanges';
		$this->square_api_args   = [ new SquareModel\BatchRetrieveInventoryChangesRequest( $args ) ];
	}


	/**
	 * Sets the data for a batchRetrieveInventoryCounts request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-inventory-batchretrieveinventorycounts
	 * @see InventoryApi::batchRetrieveInventoryCounts()
	 *
	 * @since 2.0.0
	 *
	 * @param array $args
	 *     @type string[] $catalog_object_ids filters results by CatalogObject ID
	 *     @type string[] $location_ids filters results by Location ID
	 *     @type string $updated_after filters any changes updated after this time
	 *     @type string $cursor pagination cursor
	 */
	public function set_batch_retrieve_inventory_counts_data( $args = [] ) {

		$defaults = [
			'catalog_object_ids' => null,
			'location_ids'       => null,
			'updated_after'      => null,
			'cursor'             => null,
		];

		// apply defaults and remove any keys that aren't recognized
		$args = array_intersect_key( wp_parse_args( $args, $defaults ), $defaults );

		$this->square_api_method = 'batchRetrieveInventoryCounts';
		$this->square_api_args   = [ new SquareModel\BatchRetrieveInventoryCountsRequest( $args ) ];
	}


	/**
	 * Sets the data for a retrieveInventoryAdjustment request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-inventory-retrieveinventoryadjustment
	 * @see InventoryApi::retrieveInventoryAdjustment()
	 *
	 * @since 2.0.0
	 *
	 * @param string $adjustment_id the InventoryAdjustment ID to retrieve
	 */
	public function set_retrieve_inventory_adjustment_data( $adjustment_id ) {

		$this->square_api_method = 'retrieveInventoryAdjustment';
		$this->square_api_args   = [ $adjustment_id ];
	}


	/**
	 * Sets the data for a retrieveInventoryChanges request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-inventory-retrieveinventorychanges
	 * @see InventoryApi::retrieveInventoryChanges()
	 *
	 * @since 2.0.0
	 *
	 * @param string $catalog_object_id the CatalogObject ID to retrieve
	 */
	public function set_retrieve_inventory_changes_data( $catalog_object_id ) {

		$this->square_api_method = 'retrieveInventoryChanges';
		$this->square_api_args   = [ $catalog_object_id ];
	}


	/**
	 * Sets the data for a retrieveInventoryCount request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-inventory-retrieveinventorycount
	 * @see InventoryApi::retrieveInventoryCount()
	 *
	 * @since 2.0.0
	 *
	 * @param string $catalog_object_id the CatalogObject ID to retrieve
	 * @param string[] $location_ids location IDs
	 */
	public function set_retrieve_inventory_count_data( $catalog_object_id, array $location_ids = [] ) {

		$this->square_api_method = 'retrieveInventoryCount';
		$this->square_api_args   = [ $catalog_object_id, $location_ids ];
	}


	/**
	 * Sets the data for a retrieveInventoryPhysicalCount request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-inventory-retrieveinventoryphysicalcount
	 * @see InventoryApi::retrieveInventoryPhysicalCount()
	 *
	 * @since 2.0.0
	 *
	 * @param string $physical_count_id the InventoryPhysicalCount ID to retrieve
	 */
	public function set_retrieve_inventory_physical_count_data( $physical_count_id ) {

		$this->square_api_method = 'retrieveInventoryPhysicalCount';
		$this->square_api_args   = [ $physical_count_id ];
	}


}
