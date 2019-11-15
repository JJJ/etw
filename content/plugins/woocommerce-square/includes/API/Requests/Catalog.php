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
use SquareConnect\Api\CatalogApi;
use WooCommerce\Square\API\Request;

defined( 'ABSPATH' ) or exit;

/**
 * WooCommerce Square Catalog API Request class.
 *
 * @since 2.0.0
 */
class Catalog extends Request {


	/**
	 * Initializes a new Catalog request.
	 *
	 * @since 2.0.0
	 *
	 * @param \SquareConnect\ApiClient $api_client the API client
	 */
	public function __construct( $api_client ) {

		$this->square_api = new CatalogApi( $api_client );
	}


	/**
	 * Sets the data for a batchDeleteCatalogObjects request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-catalog-batchdeletecatalogobjects
	 * @see \SquareConnect\Api\CatalogApi::batchDeleteCatalogObjects()
	 *
	 * @since 2.0.0
	 *
	 * @param string[] $object_ids the square catalog object IDs to delete
	 */
	public function set_batch_delete_catalog_objects_data( array $object_ids ) {

		$this->square_api_method = 'batchDeleteCatalogObjects';
		$this->square_api_args   = [ new SquareModel\BatchDeleteCatalogObjectsRequest( [ 'object_ids' => $object_ids ] ) ];
	}


	/**
	 * Sets the data for a batchRetrieveCatalogObjects request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-catalog-batchretrievecatalogobjects
	 * @see \SquareConnect\Api\CatalogApi::batchRetrieveCatalogObjects()
	 *
	 * @since 2.0.0
	 *
	 * @param string[] $object_ids the square catalog object IDs to delete
	 * @param bool $include_related_objects whether or not to include related objects in the response
	 */
	public function set_batch_retrieve_catalog_objects_data( array $object_ids, $include_related_objects = false ) {

		$this->square_api_method = 'batchRetrieveCatalogObjects';
		$this->square_api_args   = [ new SquareModel\BatchRetrieveCatalogObjectsRequest( [
			'object_ids'              => $object_ids,
			'include_related_objects' => (bool) $include_related_objects
		] ) ];
	}


	/**
	 * Sets the data for a batchUpsertCatalogObjects request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-catalog-batchupsertcatalogobjects
	 * @see \SquareConnect\Api\CatalogApi::batchUpsertCatalogObjects()
	 *
	 * @since 2.0.0
	 *
	 * @param string $idempotency_key the UUID for this request
	 * @param SquareModel\CatalogObjectBatch[] $batches array of catalog object batches
	 */
	public function set_batch_upsert_catalog_objects_data( $idempotency_key, array $batches ) {

		$this->square_api_method = 'batchUpsertCatalogObjects';
		$this->square_api_args   = [ new SquareModel\BatchUpsertCatalogObjectsRequest( [
			'idempotency_key' => $idempotency_key,
			'batches'         => $batches,
		] ) ];
	}


	/**
	 * Sets the data for a catalogInfo request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-catalog-cataloginfo
	 * @see \SquareConnect\Api\CatalogApi::catalogInfo()
	 *
	 * @since 2.0.0
	 *
	 * @param string $cursor
	 * @param array $types
	 */
	public function set_catalog_info_data( $cursor = '', $types = [] ) {

		$this->square_api_method = 'catalogInfo';
	}


	/**
	 * Sets the data for a deleteCatalogObject request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-catalog-deletecatalogobject
	 * @see \SquareConnect\Api\CatalogApi::deleteCatalogObject()
	 *
	 * @since 2.0.0
	 *
	 * @param string $object_id the Square catalog object ID to delete
	 */
	public function set_delete_catalog_object_data( $object_id ) {

		$this->square_api_method = 'deleteCatalogObject';
		$this->square_api_args   = [ $object_id ];
	}


	/**
	 * Sets the data for a listCatalog request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-catalog-listcatalog
	 * @see \SquareConnect\Api\CatalogApi::listCatalog()
	 *
	 * @since 2.0.0
	 *
	 * @param string $cursor (optional) the pagination cursor
	 * @param array $types (optional) the catalog item types to filter by
	 */
	public function set_list_catalog_data( $cursor = '', $types = [] ) {

		$this->square_api_method = 'listCatalog';
		$this->square_api_args   = [
			'cursor' => $cursor,
			'types'  => is_array( $types ) ? implode( ',', array_map( 'strtoupper', $types ) ) : ''
		];
	}


	/**
	 * Sets the data for a retrieveCatalogObject request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-catalog-retrievecatalogobject
	 * @see \SquareConnect\Api\CatalogApi::retrieveCatalogObject()
	 *
	 * @since 2.0.0
	 *
	 * @param string $object_id the Square catalog object ID to retrieve
	 * @param bool whether or not to include related objects (such as categories)
	 */
	public function set_retrieve_catalog_object_data( $object_id, $include_related_objects = false ) {

		$this->square_api_method = 'retrieveCatalogObject';
		$this->square_api_args   = [ $object_id, (bool) $include_related_objects ];
	}


	/**
	 * Sets the data for a searchCatalogObjects request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-catalog-searchcatalogobjects
	 * @see \SquareConnect\Api\CatalogApi::searchCatalogObjects()
	 *
	 * @since 2.0.0
	 *
	 * @param array $args see Square documentation for full list of args allowed
	 */
	public function set_search_catalog_objects_data( array $args = [] ) {

		// convert object types to array
		if ( isset( $args['object_types'] ) && ! is_array( $args['object_types'] ) ) {
			$args['object_types'] = [ $args['object_types'] ];
		}

		$defaults = [
			'cursor'                  => null,
			'object_types'            => null,
			'include_deleted_objects' => null,
			'include_related_objects' => null,
			'begin_time'              => null,
			'query'                   => null,
			'limit'                   => null,
		];

		// apply defaults and remove any keys that aren't recognized
		$args = array_intersect_key( wp_parse_args( $args, $defaults ), $defaults );

		$this->square_api_method = 'searchCatalogObjects';
		$this->square_api_args   = [ new SquareModel\SearchCatalogObjectsRequest( $args ) ];
	}


	/**
	 * Sets the data for a updateItemModifierLists request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-catalog-updateitemmodifierlists
	 * @see \SquareConnect\Api\CatalogApi::updateItemModifierLists()
	 *
	 * @since 2.0.0
	 *
	 * @param string[] $item_ids array of item IDs to update
	 * @param string[] $modifier_lists_to_enable array of list IDs to enable
	 * @param string[] $modifier_lists_to_disable array of list IDs to disable
	 */
	public function set_update_item_modifier_lists_data( array $item_ids, array $modifier_lists_to_enable = [], array $modifier_lists_to_disable = [] ) {

		$this->square_api_method = 'updateItemModifierLists';
		$this->square_api_args   = [ new SquareModel\UpdateItemModifierListsRequest( [
			'item_ids'                  => $item_ids,
			'modifier_lists_to_enable'  => $modifier_lists_to_enable,
			'modifier_lists_to_disable' => $modifier_lists_to_disable,
		] ) ];
	}


	/**
	 * Sets the data for an updateItemTaxes request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-catalog-updateitemtaxes
	 * @see \SquareConnect\Api\CatalogApi::updateItemTaxes()
	 *
	 * @since 2.0.0
	 *
	 * @param string[] $item_ids array of item IDs to update
	 * @param string[] $taxes_to_enable array of catalog tax IDs to enable
	 * @param string[] $taxes_to_disable array of catalog tax IDs to disable
	 */
	public function set_update_item_taxes_data( array $item_ids, array $taxes_to_enable = [], array $taxes_to_disable = [] ) {

		$this->square_api_method = 'updateItemTaxes';
		$this->square_api_args   = [ new SquareModel\UpdateItemTaxesRequest( [
			'item_ids'         => $item_ids,
			'taxes_to_enable'  => $taxes_to_enable,
			'taxes_to_disable' => $taxes_to_disable,
		] ) ];
	}


	/**
	 * Sets the data for an upsertCatalogObject request.
	 *
	 * @see https://docs.connect.squareup.com/api/connect/v2#endpoint-catalog-upsertcatalogobject
	 * @see \SquareConnect\Api\CatalogApi::upsertCatalogObject()
	 *
	 * @since 2.0.0
	 *
	 * @param string $idempotency_key a UUID for this request
	 * @param SquareModel\CatalogObject $object the object to update
	 */
	public function set_upsert_catalog_object_data( $idempotency_key, $object ) {

		$this->square_api_method = 'upsertCatalogObject';
		$this->square_api_args   = [ new SquareModel\UpsertCatalogObjectRequest( [
			'idempotency_key' => $idempotency_key,
			'object'          => $object,
		] ) ];
	}


}
