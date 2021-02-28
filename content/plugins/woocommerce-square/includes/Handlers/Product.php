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
use SquareConnect\Model\CatalogObject;
use WooCommerce\Square\Utilities\Money_Utility;
use WooCommerce\Square\Sync\Records;

defined( 'ABSPATH' ) || exit;

/**
 * Product handler class.
 *
 * @since 2.0.0
 */
class Product {


	/** @var string the taxonomy name that flags whether a product is marked as 'synced' with Square */
	const SYNCED_WITH_SQUARE_TAXONOMY = 'wc_square_synced';

	const SQUARE_ID_META_KEY = '_square_item_id';

	const SQUARE_VERSION_META_KEY = '_square_item_version';

	const SQUARE_VARIATION_ID_META_KEY = '_square_item_variation_id';

	const SQUARE_VARIATION_VERSION_META_KEY = '_square_item_variation_version';

	const SQUARE_IMAGE_ID_META_KEY = '_square_item_image_id';


	/**
	 * @param \WC_Product $product
	 * @param \SquareConnect\Model\CatalogObject $catalog_object
	 */
	public static function update_product( \WC_Product $product, \SquareConnect\Model\CatalogObject $catalog_object ) {

		if ( 'ITEM' !== $catalog_object->getType() || ! $catalog_object->getItemData() ) {
			throw new \InvalidArgumentException( 'Type of $catalog_object must be an ITEM' );
		}

		$product->update_meta_data( self::SQUARE_ID_META_KEY, $catalog_object->getId() );
		$product->update_meta_data( self::SQUARE_VERSION_META_KEY, $catalog_object->getVersion() );
		$product->update_meta_data( self::SQUARE_IMAGE_ID_META_KEY, $catalog_object->getImageId() );

		$product->save();
	}


	/**
	 * @param \WC_Product $product
	 * @param \SquareConnect\Model\CatalogObject $catalog_object
	 */
	public static function update_variation( \WC_Product $product, \SquareConnect\Model\CatalogObject $catalog_object ) {

		if ( 'ITEM_VARIATION' !== $catalog_object->getType() || ! $catalog_object->getItemVariationData() ) {
			throw new \InvalidArgumentException( 'Type of $catalog_object must be an ITEM_VARIATION' );
		}

		$product->update_meta_data( self::SQUARE_VARIATION_ID_META_KEY, $catalog_object->getId() );
		$product->update_meta_data( self::SQUARE_VARIATION_VERSION_META_KEY, $catalog_object->getVersion() );

		$product->save();
	}


	/**
	 * Updates a WooCommerce product from Square data.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product $product product object
	 * @param \SquareConnect\Model\CatalogItem $catalog_item Square API catalog item data
	 * @param bool $with_inventory whether to pull the latest product inventory from Square
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	public static function update_from_square( \WC_Product $product, \SquareConnect\Model\CatalogItem $catalog_item, $with_inventory = true ) {

		$catalog_id         = null;
		$catalog_variations = $catalog_item->getVariations();

		if ( $product instanceof \WC_Product_Variable ) {

			foreach ( $catalog_variations as $catalog_variation ) {

				// sanity check to ensure the correct data structure
				if ( ! $catalog_variation->getItemVariationData() instanceof \SquareConnect\Model\CatalogItemVariation ) {
					continue;
				}

				$catalog_id = $catalog_variation->getItemVariationData()->getItemId();

				if ( $variation = wc_get_product( wc_get_product_id_by_sku( $catalog_variation->getItemVariationData()->getSku() ) ) ) {

					if ( ! $variation instanceof \WC_Product_Variation || $variation->get_parent_id() !== $product->get_id() ) {
						continue;
					}

					$variation->update_meta_data( self::SQUARE_VARIATION_ID_META_KEY, $catalog_variation->getId() );

					$variation->set_name( $catalog_variation->getItemVariationData()->getName() );

					if ( $catalog_variation->getItemVariationData()->getPriceMoney() ) {
						$variation->set_regular_price( Money_Utility::cents_to_float( $catalog_variation->getItemVariationData()->getPriceMoney()->getAmount() ) );
					}

					if ( $with_inventory && wc_square()->get_settings_handler()->is_inventory_sync_enabled() ) {
						self::update_stock_from_square( $variation, false );
					}

					$variation->save();

					/**
					 * Fires after updating a WooCommerce variation product from Square data.
					 *
					 * @since 2.0.0
					 *
					 * @param \WC_Product_Variation $variation variation object
					 * @param \SquareConnect\Model\CatalogItemVariation $catalog_variation Square API catalog variation item object
					 */
					do_action( 'wc_square_updated_product_variation_from_square', $variation, $catalog_variation );
				}
			}
		} else {

			$catalog_variation = current( $catalog_variations );

			if ( $product->get_sku() !== $catalog_variation->getItemVariationData()->getSku() ) {
				throw new Framework\SV_WC_Plugin_Exception( 'The WooCommerce SKU and Square SKU do not match' );
			}

			$catalog_id = $catalog_variation->getItemVariationData()->getItemId();

			$product->update_meta_data( self::SQUARE_VARIATION_ID_META_KEY, $catalog_variation->getId() );

			if ( $catalog_variation->getItemVariationData()->getPriceMoney() ) {
				$product->set_regular_price( Money_Utility::cents_to_float( $catalog_variation->getItemVariationData()->getPriceMoney()->getAmount() ) );
			}

			if ( $with_inventory && wc_square()->get_settings_handler()->is_inventory_sync_enabled() ) {
				self::update_stock_from_square( $product, false );
			}
		}

		$product->set_name( wc_clean( $catalog_item->getName() ) );
		$product->set_description( $catalog_item->getDescription() );

		$category_id = Category::get_category_id_by_square_id( $catalog_item->getCategoryId() );

		if ( $category_id ) {
			wp_set_object_terms( $product->get_id(), intval( $category_id ), 'product_cat' );
		} else {
			$message = sprintf(
				/* translators: Placeholder: %s category ID */
				__( 'Square category with id (%s) was not imported to your Store. Please run Import Products from Square settings.', 'woocommerce-square' ),
				$catalog_item->getCategoryId()
			);

			$records = Records::get_records();
			foreach ( $records as $record ) {
				if ( $record->get_message() === $message ) {
					$is_recorded = true;
				}
			}

			if ( ! isset( $is_recorded ) ) {
				Records::set_record(
					array(
						'type'    => 'alert',
						'message' => $message,
					)
				);
			}
		}

		if ( $catalog_id ) {
			$product->update_meta_data( self::SQUARE_ID_META_KEY, $catalog_id );
		}

		$product->save();

		/**
		 * Fires after updating a WooCommerce product from Square data.
		 *
		 * @since 2.0.0
		 *
		 * @param \WC_Product $product product object
		 * @param \SquareConnect\Model\CatalogItem $catalog_item Square API catalog item object
		 */
		do_action( 'wc_square_updated_product_from_square', $product, $catalog_item );
	}


	/**
	 * Updates a product image from a URL provided by Square (helper method).
	 *
	 * Note: does not save the product for persistence. If opening to public, consider changing this behavior.
	 *       This function handles its own exceptions and logs them.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product|int $given_product product object or product ID
	 * @param string $image_id
	 * @param bool $force_update If true, always import and update the product image from Square. If false, check if the image already exists on the given product before uploading a possible
	 * @todo Look at ussages of this function. Does it even need to return anything?
	 * @return \WC_Product|int The product id of object that was passed in.
	 */
	public static function update_image_from_square( $given_product, $image_id, $force_update = true ) {

		$product = is_numeric( $given_product ) ? wc_get_product( $given_product ) : $given_product;

		if ( ! $product instanceof \WC_Product ) {
			wc_square()->log( sprintf( 'Could not import image from Square at %1$s for attaching to product: Invalid product.', $image_url ) );
			return $given_product;
		}

		try {

			$image_response = wc_square()->get_api()->retrieve_catalog_object( $image_id );

			if ( ! $image_response->get_data() || ! $image_response->get_data()->getObject() || ! $image_response->get_data()->getObject()->getImageData() ) {
				throw new Framework\SV_WC_Plugin_Exception( 'No image data present' );
			}

			$image_url = $image_response->get_data()->getObject()->getImageData()->getUrl();

			if ( empty( $image_url ) ) {
				throw new Framework\SV_WC_Plugin_Exception( 'Square image url empty' );
			}

			if ( ! function_exists( 'media_sideload_image' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/media.php' );
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
			}

			$product_image_id = $product->get_image_id();

			// if the product has an image but doesn't have any Square image ID meta set, check we're not uploading a duplicate image src from Square
			if ( ! $force_update && $product_image_id && ! $product->get_meta( '_square_item_image_id' ) ) {
				$product_image_src = get_post_meta( $product_image_id, '_source_url', true );

				if ( empty( $product_image_src ) ) {
					throw new Framework\SV_WC_Plugin_Exception( 'Cannot compare existing product image src with new upload. Exiting to avoid uploading duplicate' );
				} elseif ( $product_image_src === $image_url ) {
					$product->update_meta_data( '_square_item_image_id', $image_id );
					throw new Framework\SV_WC_Plugin_Exception( 'This image has already been uploaded to WordPress and is now set on the product' );
				}
			}

			// grab remote image to upload into WordPress before attaching to product
			$attachment_id = media_sideload_image( $image_url, $product->get_id(), $product->get_title(), 'id' );

			if ( is_wp_error( $attachment_id ) ) {
				throw new Framework\SV_WC_Plugin_Exception( $attachment_id->get_error_message() );
			}

			// attach the newly updated image to product
			$product->set_image_id( $attachment_id );

			self::set_square_image_id( $product, $image_id );

		} catch ( Framework\SV_WC_Plugin_Exception $e ) {

			wc_square()->log( sprintf( 'Could not import image from Square at %1$s for attaching to product #%2$s. %3$s.', $image_url, $product->get_id(), $e->getMessage() ) );
		}

		$product->save();

		return $product;
	}


	/**
	 * Updates a product's stock by getting the latest values from Square.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product $product product object
	 * @param bool $save whether to save the product object
	 * @return \WC_Product
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	public static function update_stock_from_square( \WC_Product $product, $save = true ) {

		$square_id = $product->get_meta( self::SQUARE_VARIATION_ID_META_KEY );

		if ( ! $square_id ) {
			throw new Framework\SV_WC_Plugin_Exception( __( 'Product not synced with Square', 'woocommerce-square' ) );
		}

		// if saving the product, flag as syncing so updating the stock won't trigger another sync
		if ( $save && ( ! defined( 'DOING_SQUARE_SYNC' ) || false === DOING_SQUARE_SYNC ) ) {
			define( 'DOING_SQUARE_SYNC', true );
		}

		$response = wc_square()->get_api()->retrieve_inventory_count( $square_id );

		$stock = 0;

		if ( $response->get_data() && $response->get_data()->getCounts() ) {

			/* @type \SquareConnect\Model\InventoryCount $count */
			foreach ( $response->get_data()->getCounts() as $count ) {

				if ( 'IN_STOCK' === $count->getState() ) {
					$stock += (float) $count->getQuantity();
				}
			}
		}

		$product->set_manage_stock( true );
		$product->set_stock_quantity( $stock );

		if ( $save ) {
			$product->save();
		}

		return $product;
	}


	/**
	 * Initializes custom product taxonomies.
	 *
	 * @since 2.0.0
	 */
	public static function init_taxonomies() {

		register_taxonomy(
			self::SYNCED_WITH_SQUARE_TAXONOMY,
			array( 'product' ),
			array(
				'hierarchical'          => false,
				'update_count_callback' => '_update_generic_term_count',
				'show_ui'               => false,
				'show_in_nav_menus'     => false,
				'query_var'             => is_admin(),
				'rewrite'               => false,
			)
		);
	}


	/**
	 * Sets a product's synced with Square status.
	 *
	 * This function has a side effect where we also set the Product's
	 * manage stock value. We ignore external type product when setting this manage
	 * stock value.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product|int $product a valid product object or product ID
	 * @param string $synced either 'yes' (default) or 'no'
	 * @return bool
	 */
	public static function set_synced_with_square( $product, $synced = 'yes' ) {

		$product = is_numeric( $product ) ? wc_get_product( $product ) : $product;

		if ( ! $product instanceof \WC_Product || ! in_array( $synced, array( 'yes', 'no' ), true ) ) {
			return false;
		}

		// ensure only one term is associated with the product at any time
		wp_delete_object_term_relationships( $product->get_id(), array( self::SYNCED_WITH_SQUARE_TAXONOMY ) );

		// we have already set the value to "no" above by deleting the term relationship
		// so it is safe to return with true.
		if ( 'no' === $synced ) {
			return true;
		}

		$set_term = wp_set_post_terms( $product->get_id(), array( $synced ), self::SYNCED_WITH_SQUARE_TAXONOMY );
		$success  = is_array( $set_term );

		// Function side effect see phpDoc for details:
		if ( wc_square()->get_settings_handler()->is_inventory_sync_enabled()
		&& 'external' !== $product->get_type() ) {
			$product->set_manage_stock( ! $product->is_type( 'variable' ) );
			$product->save();
		}

		return $success;
	}


	/**
	 * Removes a product flag from being synced with Square.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product $product a valid product object
	 * @return bool
	 */
	public static function unset_synced_with_square( $product ) {

		return self::set_synced_with_square( $product, 'no' );
	}


	/**
	 * Determines whether a product is set to be synced with Square.
	 *
	 * @since 2.0.0
	 *
	 * @param false|\WC_Product $product a valid product object
	 * @return bool
	 */
	public static function is_synced_with_square( $product ) {

		if ( $product instanceof \WC_Product ) {

			// if this is a variation, check its parent
			if ( $parent_product = wc_get_product( $product->get_parent_id() ) ) {

				if ( $parent_product instanceof \WC_Product ) {
					$product = $parent_product;
				}
			}

			$terms = wp_get_post_terms( $product->get_id(), self::SYNCED_WITH_SQUARE_TAXONOMY, array( 'fields' => 'names' ) );
		}

		return ! empty( $terms ) && 'yes' === $terms[0];
	}


	/**
	 * Determines if a product can be synced with Square.
	 *
	 * SKUs and single-dimension attributes are required, so this helps us validate that in case a product has been
	 * marked as "Sync with Square" manually.
	 *
	 * @since 2.0.2
	 *
	 * @param \WC_Product $product product object
	 * @return bool
	 */
	public static function can_sync_with_square( \WC_Product $product ) {

		$can_sync = self::has_sku( $product );

		if ( $can_sync && $product->is_type( 'variable' ) ) {
			$can_sync = ! self::has_multiple_variation_attributes( $product );
		}

		return (bool) apply_filters( 'wc_square_product_can_sync_with_square', $can_sync, $product );
	}

	/**
	 * Return a link to the product's edit page
	 *
	 * @since 2.0.8
	 *
	 * @param \WC_Product $product product object
	 * @return string
	 */
	public static function get_product_edit_link( \WC_Product $product ) {
		return '<a href="' . esc_url( get_edit_post_link( $product->get_id() ) ) . '">' . esc_html( $product->get_formatted_name() ) . '</a>';
	}

	/**
	 * Determines if a product has a SKU set.
	 *
	 * For variable products, this checks if all of its variations have a SKU.
	 *
	 * @since 2.0.2
	 *
	 * @param \WC_Product $product product object
	 * @return bool
	 */
	public static function has_sku( \WC_Product $product ) {
		if ( $product->is_type( 'variable' ) && $product->has_child() ) {
			foreach ( $product->get_children() as $variation_id ) {
				$variation = wc_get_product( $variation_id );

				if ( $variation instanceof \WC_Product && empty( $variation->get_sku() ) ) {
					return false;
				}
			}
			return true;
		}

		return ! empty( $product->get_sku() );
	}


	/**
	 * Determines if a product has multiple variation attributes.
	 *
	 * @since 2.0.2
	 *
	 * @param \WC_Product $product product object
	 * @return bool
	 */
	public static function has_multiple_variation_attributes( \WC_Product $product ) {

		$has_attributes = false;

		if ( $product->is_type( 'variable' ) ) {

			$variation_attributes = array();

			foreach ( $product->get_attributes() as $attribute ) {

				if ( $attribute instanceof \WC_Product_Attribute && $attribute->get_variation() ) {
					$variation_attributes[] = $attribute;
				}
			}

			if ( count( $variation_attributes ) > 1 ) {
				$has_attributes = true;
			}
		}

		return $has_attributes;
	}


	/**
	 * Gets an ID list of products that have a synced with Square status set.
	 *
	 * @since 2.0.0
	 *
	 * @param string $status either 'yes' or 'no'
	 * @return int[] array of product IDs
	 */
	private static function get_products_synced_status( $status ) {

		$sync_status_term = get_term_by( 'name', 'yes', self::SYNCED_WITH_SQUARE_TAXONOMY );
		$product_ids      = array();

		if ( $sync_status_term instanceof \WP_Term && in_array( $status, array( 'yes', 'no' ), true ) ) {

			$tax_query_args = array(
				'taxonomy'         => self::SYNCED_WITH_SQUARE_TAXONOMY,
				'field'            => 'id',
				'terms'            => $sync_status_term->term_id,
				'include_children' => false,
			);

			if ( 'no' === $status ) {
				$tax_query_args['operator'] = 'NOT IN';
			}

			$product_ids = get_posts(
				array(
					'post_type'   => array( 'product', 'product_variation' ),
					'post_status' => array( 'private', 'publish' ),
					'fields'      => 'ids',
					'nopaging'    => true,
					'tax_query'   => array( $tax_query_args ),
				)
			);

		}
		return $product_ids;
	}


	/**
	 * Gets a list of products explicitly not set to be synced with Square.
	 *
	 * @since 2.0.0
	 *
	 * @return int[]
	 */
	public static function get_products_not_synced_with_square() {

		return self::get_products_synced_status( 'no' );
	}


	/**
	 * Gets a list of products that are set to be synced with Square.
	 *
	 * @since 2.0.0
	 *
	 * @return int[] array of product IDs
	 */
	public static function get_products_synced_with_square() {

		return self::get_products_synced_status( 'yes' );
	}


	/**
	 * Gets a product ID from a Square API variation ID.
	 *
	 * @since 2.0.0
	 *
	 * @param string $variation_id Square API variation item ID
	 * @return int|null
	 */
	public static function get_product_id_by_square_variation_id( $variation_id ) {
		global $wpdb;

		return $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key = %s AND meta_value = %s", self::SQUARE_VARIATION_ID_META_KEY, $variation_id ) );
	}


	/**
	 * Gets a product from a Square API variation ID.
	 *
	 * @since 2.0.0
	 *
	 * @param string $variation_id Square API variation item ID
	 * @return \WC_Product|null
	 */
	public static function get_product_by_square_variation_id( $variation_id ) {

		$product = wc_get_product( self::get_product_id_by_square_variation_id( $variation_id ) );

		if ( ! $product ) {
			$product = null;
		}

		return $product;
	}


	/**
	 * Gets a product ID from a Square API ID.
	 *
	 * @since 2.0.0
	 *
	 * @param string $square_id Square API item ID
	 * @return int|null
	 */
	public static function get_product_id_by_square_id( $square_id ) {
		global $wpdb;

		return $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key = %s AND meta_value = %s", self::SQUARE_ID_META_KEY, $square_id ) );
	}


	/**
	 * Gets a product from a Square API ID.
	 *
	 * @since 2.0.0
	 *
	 * @param string $square_id Square API item ID
	 * @return \WC_Product|null
	 */
	public static function get_product_by_square_id( $square_id ) {

		$product = wc_get_product( self::get_product_id_by_square_id( $square_id ) );

		// ensure we have a parent product
		if ( ! $product || $product instanceof \WC_Product_Variation ) {
			$product = null;
		}

		return $product;
	}


	/**
	 * Converts a WC_Product to a Square CatalogObject.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product $product
	 * @return null|\SquareConnect\Model\CatalogObject
	 */
	public static function convert_to_catalog_object( \WC_Product $product ) {

		if ( ! $product ) {
			return null;
		}

		$parent_id = $product->get_parent_id();

		if ( 0 !== $parent_id ) {
			return self::convert_to_catalog_object( wc_get_product( $parent_id ) );
		}

		$variations = array();

		if ( $product->has_child() ) {

			foreach ( $product->get_children() as $child_product_id ) {

				$child_product = wc_get_product( $child_product_id );

				if ( $child_product && $variation = self::extract_catalog_item_variation_data( $child_product ) ) {

					$variations[] = $variation;
				}
			}
		} else {

			$variation  = self::extract_catalog_item_variation_data( $product );
			$variations = $variation ? array( $variation ) : array();
		}

		if ( empty( $variations ) ) {
			return null;
		}

		$data = array(
			'type'                    => 'ITEM',
			'id'                      => self::get_square_item_id( $product ),
			'version'                 => self::get_square_version( $product ),
			'present_at_location_ids' => array( wc_square()->get_settings_handler()->get_location_id() ),
			'item_data'               => array(
				'name'       => $product->get_name(),
				'variations' => $variations,
			),
		);

		// TODO: Handle categories

		return new \SquareConnect\Model\CatalogObject( $data );
	}


	/**
	 * Extracts the data for a catalog item from a \WC_Product.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product $product the product object
	 * @param \SquareConnect\Model\CatalogItemVariation[] $variations (optional) array of variations to include
	 * @param bool $is_soft_delete whether or not this item data is for a soft-delete
	 * @return array
	 */
	public static function extract_catalog_item_data( \WC_Product $product, array $variations = array(), $is_soft_delete = false ) {

		if ( ! $product ) {
			return null;
		}

		$data = array(
			'type'                    => 'ITEM',
			'id'                      => self::get_square_item_id( $product ),
			'version'                 => self::get_square_version( $product ),
			'present_at_location_ids' => array( wc_square()->get_settings_handler()->get_location_id() ),
			'item_data'               => array(
				'name'       => $product->get_name(),
				'variations' => $variations,
			),
		);

		$square_category_id = 0;

		foreach ( $product->get_category_ids() as $category_id ) {

			$map = Category::get_mapping( $category_id );

			if ( ! empty( $map['square_id'] ) ) {
				$square_category_id = $map['square_id'];
				break;
			}
		}

		// if a category with a Square ID was found
		if ( $square_category_id ) {
			$data['item_data']['category_id'] = $square_category_id;
		}

		if ( $is_soft_delete ) {

			$data['present_at_all_locations'] = false;
			$data['present_at_location_ids']  = array();
		}

		return $data;
	}


	/**
	 * Extracts the data for a catalog item variation from a \WC_Product.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product $product the product to get the variation data for
	 * @param \WC_Product $parent_product (optional) the parent product - prevents additional calls to wc_get_product()
	 * * @param bool $is_soft_delete whether or not this item data is for a soft-delete
	 * @return array
	 */
	public static function extract_catalog_item_variation_data( \WC_Product $product, \WC_Product $parent_product = null, $is_soft_delete = false ) {

		if ( ! $product ) {
			return null;
		}

		$parent_product_id = $product->get_parent_id();

		if ( 0 === $parent_product_id ) {

			$parent_product = $product;

		} elseif ( null === $parent_product || $parent_product_id !== $parent_product->get_id() ) {

			$parent_product = wc_get_product( $parent_product_id );
		}

		if ( $parent_product instanceof \WC_Product ) {

			$item_id = self::get_square_item_id( $parent_product );

			$data = array(
				'type'                => 'ITEM_VARIATION',
				'id'                  => self::get_square_item_variation_id( $product ),
				'version'             => self::get_square_variation_version( $product ),
				'item_variation_data' => array(
					'item_id'         => $item_id,
					'name'            => $product->get_name(),
					'sku'             => $product->get_sku(),
					'pricing_type'    => 'FIXED_PRICING',
					'price_money'     => self::price_to_money( $product->get_regular_price() ),
					'track_inventory' => true,
				),
			);

			if ( $is_soft_delete ) {

				$data['present_at_all_locations'] = false;
				$data['present_at_location_ids']  = array();
			}
		}

		return $data;
	}


	/**
	 * Converts a product price to a Money object.
	 *
	 * @since 2.0.0
	 *
	 * @param int|float $price
	 * @return \SquareConnect\Model\Money
	 */
	public static function price_to_money( $price ) {

		return Money_Utility::amount_to_money( $price, get_woocommerce_currency() );
	}


	/**
	 * Returns the square item ID (if known) or generates one based on local data.
	 *
	 * @since 2.0.0
	 *
	 * @param int|\WC_Product $product_id the product ID or product object
	 * @param bool $generate_if_not_found whether a temporary ID should be returned if an ID is not found
	 * @return string
	 */
	public static function get_square_item_id( $product_id, $generate_if_not_found = true ) {

		if ( $product_id instanceof \WC_Product ) {
			$product_id = $product_id->get_id();
		}

		$square_item_id = get_post_meta( $product_id, self::SQUARE_ID_META_KEY, true ) ?: null;

		if ( ! $square_item_id && true === $generate_if_not_found ) {

			$square_item_id = '#item_' . $product_id;
		}

		return $square_item_id;
	}


	/**
	 * Sets the Square item ID for a given product.
	 *
	 * @since 2.0.0
	 *
	 * @param int|false|\WC_Product $product the product object or ID
	 * @param string $item_id the Square item ID
	 */
	public static function set_square_item_id( $product, $item_id ) {

		$product = is_numeric( $product ) ? wc_get_product( $product ) : $product;

		if ( $product instanceof \WC_Product ) {

			$product->update_meta_data( self::SQUARE_ID_META_KEY, $item_id );
			$product->save();
		}
	}


	/**
	 * Returns the square item variation ID (if known) or generates one based on local data.
	 *
	 * @since 2.0.0
	 *
	 * @param int|\WC_Product $product_id the product ID or product object
	 * @param bool $generate_if_not_found whether a temporary ID should be returned if an ID is not found
	 * @return string|null
	 */
	public static function get_square_item_variation_id( $product_id, $generate_if_not_found = true ) {

		if ( $product_id instanceof \WC_Product ) {
			$product_id = $product_id->get_id();
		}

		$square_item_variation_id = get_post_meta( $product_id, self::SQUARE_VARIATION_ID_META_KEY, true ) ?: null;

		if ( ! $square_item_variation_id && true === $generate_if_not_found ) {

			$square_item_variation_id = '#item_variation_' . $product_id;
		}

		return $square_item_variation_id;
	}


	/**
	 * Sets the Square item variation ID for a given product.
	 *
	 * @since 2.0.0
	 *
	 * @param int|false|\WC_Product $product the product object or ID
	 * @param string $item_variation_id the Square item variation ID
	 */
	public static function set_square_item_variation_id( $product, $item_variation_id ) {

		$product = is_numeric( $product ) ? wc_get_product( $product ) : $product;

		if ( $product instanceof \WC_Product ) {

			$product->update_meta_data( self::SQUARE_VARIATION_ID_META_KEY, $item_variation_id );
			$product->save();
		}
	}


	/**
	 * Returns the Square item version (if known) for the given product.
	 *
	 * @since 2.0.0
	 *
	 * @param int|\WC_Product $product_id the product ID or product object
	 * @return int
	 */
	public static function get_square_version( $product_id ) {

		if ( $product_id instanceof \WC_Product ) {
			$product_id = $product_id->get_id();
		}

		$square_version = get_post_meta( $product_id, self::SQUARE_VERSION_META_KEY, true );

		return $square_version ? (int) $square_version : 0;
	}


	/**
	 * Sets the Square item version for a given product.
	 *
	 * @since 2.0.0
	 *
	 * @param int|false|\WC_Product $product the product object or ID
	 * @param int $version the Square item version
	 */
	public static function set_square_version( $product, $version ) {

		$product = is_numeric( $product ) ? wc_get_product( $product ) : $product;

		if ( $product instanceof \WC_Product ) {

			$product->update_meta_data( self::SQUARE_VERSION_META_KEY, $version );
			$product->save();
		}
	}


	/**
	 * Returns the Square item variation version (if known) for the given product.
	 *
	 * @since 2.0.0
	 *
	 * @param int|\WC_Product $product_id the product ID or product object
	 * @return int
	 */
	public static function get_square_variation_version( $product_id ) {

		if ( $product_id instanceof \WC_Product ) {
			$product_id = $product_id->get_id();
		}

		$square_variation_version = get_post_meta( $product_id, self::SQUARE_VARIATION_VERSION_META_KEY, true );

		return $square_variation_version ? (int) $square_variation_version : 0;
	}


	/**
	 * Sets the Square item ID for a given product.
	 *
	 * @since 2.0.0
	 *
	 * @param int|false|\WC_Product $product the product object or ID
	 * @param int $variation_version the Square item variation version
	 */
	public static function set_square_variation_version( $product, $variation_version ) {

		$product = is_numeric( $product ) ? wc_get_product( $product ) : $product;

		if ( $product instanceof \WC_Product ) {

			$product->update_meta_data( self::SQUARE_VARIATION_VERSION_META_KEY, $variation_version );
			$product->save();
		}
	}


	/**
	 * Gets a product's Square image ID.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product|int $product product object or ID
	 * @return string
	 */
	public static function get_square_image_id( $product ) {

		$image_id = '';

		if ( is_numeric( $product ) ) {
			$product = wc_get_product( $product );
		}

		if ( $product instanceof \WC_Product ) {
			$image_id = $product->get_meta( self::SQUARE_IMAGE_ID_META_KEY );
		}

		return $image_id;
	}


	/**
	 * Sets a product's Square image ID.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product|int $product product object or ID
	 * @param string $image_id Square image ID
	 */
	public static function set_square_image_id( $product, $image_id ) {

		$product = is_numeric( $product ) ? wc_get_product( $product ) : $product;

		if ( $product instanceof \WC_Product ) {

			$product->update_meta_data( self::SQUARE_IMAGE_ID_META_KEY, $image_id );
			$product->save_meta_data();
		}
	}


	/**
	 * Gets all the Square meta data for the given product IDs.
	 *
	 * @see Product::get_square_meta_single()
	 *
	 * @since 2.0.0
	 *
	 * @param int[] $product_ids the product IDs to look up
	 * @param string $array_key the variable to use as the array key in the resulting array
	 * @return array associative array of arrays of data, indexed by $array_key found values (e.g. product ID or square ID, etc.)
	 */
	public static function get_square_meta( $product_ids, $array_key = 'product_id' ) {
		global $wpdb;

		$results = $square_meta = array();

		if ( ! empty( $product_ids ) ) {

			$meta_keys = array(
				'square_item_id'           => self::SQUARE_ID_META_KEY,
				'square_item_variation_id' => self::SQUARE_VARIATION_ID_META_KEY,
				'square_version'           => self::SQUARE_VERSION_META_KEY,
				'square_variation_version' => self::SQUARE_VARIATION_VERSION_META_KEY,
			);

			$array_key     = array_key_exists( $array_key, $meta_keys ) ? $array_key : 'product_id';
			$post_ids_in   = '(' . implode( ',', array_map( 'absint', array_merge( array( 0 ), $product_ids ) ) ) . ')';
			$meta_key_in   = "('" . self::SQUARE_ID_META_KEY . "','" . self::SQUARE_VARIATION_ID_META_KEY . "','" . self::SQUARE_VERSION_META_KEY . "','" . self::SQUARE_VARIATION_VERSION_META_KEY . "')";
			$products_meta = $wpdb->get_results(
				"
				SELECT post_id AS product_id, meta_key, meta_value
				FROM $wpdb->postmeta
				WHERE post_id IN $post_ids_in
				AND meta_key IN $meta_key_in
				",
				ARRAY_A
			);

			foreach ( $products_meta as $post_meta ) {

				if ( ! array_key_exists( (string) $post_meta['product_id'], $square_meta ) ) {
					$square_meta[ (string) $post_meta['product_id'] ] = array(
						'product_id'               => (int) $post_meta['product_id'],
						'square_item_id'           => false,
						'square_item_variation_id' => false,
						'square_version'           => false,
						'square_variation_version' => false,
					);
				}

				foreach ( $meta_keys as $square_meta_key => $post_meta_key ) {
					if ( isset( $post_meta['meta_key'] ) && $post_meta_key === $post_meta['meta_key'] ) {
						$square_meta[ $post_meta['product_id'] ][ $square_meta_key ] = $post_meta['meta_value'];
						break;
					}
				}
			}

			foreach ( $product_ids as $product_id ) {

				// sanity checks: cannot build index without a valid key
				if ( ! array_key_exists( $product_id, $square_meta )
					|| ! isset( $square_meta[ $product_id ][ $array_key ] )
					|| ! $square_meta[ (string) $product_id ][ $array_key ] ) {

					continue;
				}

				$results[ (string) $square_meta[ (string) $product_id ][ $array_key ] ] = $square_meta[ (string) $product_id ];
			}
		}

		return $results;
	}


	/**
	 * Gets all the Square meta data for the given single product ID.
	 *
	 * @see Product::get_square_meta() for getting meta data for all products
	 *
	 * @since 2.0.0
	 *
	 * @param int|\WC_Product $product_id the product ID or object
	 * @return array associative array
	 */
	public static function get_square_meta_single( $product_id ) {

		if ( $product_id instanceof \WC_Product ) {
			$product_id = $product_id->get_id();
		}

		return array(
			'product_id'               => $product_id,
			'square_item_id'           => self::get_square_item_id( $product_id ),
			'square_item_variation_id' => self::get_square_item_variation_id( $product_id ),
			'square_version'           => self::get_square_version( $product_id ),
		);
	}


	/**
	 * Checks if a product is mapped to a Square Item.
	 *
	 * @since 2.0.0
	 *
	 * @param int|\WC_Product $product_id the product ID or product object
	 * @return bool
	 */
	public static function is_mapped( $product_id ) {

		$item_id = self::get_square_item_id( $product_id );

		return ! empty( $item_id ) && false === strpos( $item_id, '#' );
	}


	/**
	 * Updates square meta for a given product ID.
	 *
	 * @since 2.0.0
	 *
	 * @param int|\WC_Product $product_id the product ID or the product object
	 * @param array $meta_data the meta data to update
	 *     @type string $item_id the Square Item ID
	 *     @type int $item_version the Square Item version
	 *     @type string $item_variation_id the Square Item Variation ID
	 *     @type int $item_variation_version the Square Item Variation Version
	 */
	public static function update_square_meta( $product_id, $meta_data ) {

		foreach ( $meta_data as $meta_key => $meta_value ) {

			switch ( $meta_key ) {

				case 'item_id':
					self::set_square_item_id( $product_id, $meta_value );
					break;

				case 'item_version':
					self::set_square_version( $product_id, $meta_value );
					break;

				case 'item_variation_id':
					self::set_square_item_variation_id( $product_id, $meta_value );
					break;

				case 'item_variation_version':
					self::set_square_variation_version( $product_id, $meta_value );
					break;

				case 'item_image_id':
					self::set_square_image_id( $product_id, $meta_value );
					break;
			}
		}
	}


	/**
	 * Clears the Square meta for a given product.
	 *
	 * @since 2.0.0
	 *
	 * @param int[] $product_ids array of product IDs
	 */
	public static function clear_square_meta( $product_ids ) {
		global $wpdb;

		$product_ids = is_array( $product_ids ) ? $product_ids : array( $product_ids );

		$meta_keys = array(
			self::SQUARE_ID_META_KEY,
			self::SQUARE_VERSION_META_KEY,
			self::SQUARE_VARIATION_ID_META_KEY,
			self::SQUARE_VARIATION_VERSION_META_KEY,
			self::SQUARE_IMAGE_ID_META_KEY,
		);

		$meta_key_in = '("' . implode( '","', $meta_keys ) . '")';
		$post_ids_in = '(' . implode( ',', array_map( 'absint', array_merge( array( 0 ), $product_ids ) ) ) . ')';

		$wpdb->query(
			"
			UPDATE $wpdb->postmeta
			SET meta_value = ''
			WHERE meta_key IN $meta_key_in
			AND post_id IN $post_ids_in;
			"
		);
	}


	/**
	 * Imports meta data from a remote product to the given local product ID.
	 *
	 * @since 2.0.0
	 *
	 * @param int|false|\WC_Product $product the product object or ID
	 * @param \SquareConnect\Model\CatalogObject $remote_product the remote catalog object
	 */
	public static function import_remote_meta( $product, $remote_product ) {

		$product = is_numeric( $product ) ? wc_get_product( $product ) : $product;

		if ( $product ) {

			self::update_square_meta(
				$product->get_id(),
				array(
					'item_id'       => $remote_product->getId(),
					'item_version'  => $remote_product->getVersion(),
					'item_image_id' => $remote_product->getImageId(),
				)
			);
		}
	}


	/**
	 * Gets an InventoryChange object filled with a \SquareConnect\Model\InventoryPhysicalCount object for a given product.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product $product the product object
	 * @return \SquareConnect\Model\InventoryChange|null
	 */
	public static function get_inventory_change_physical_count_type( \WC_Product $product ) {

		$inventory_change = null;

		if ( $square_variation_id = self::get_square_item_variation_id( $product->get_id(), false ) ) {

			$inventory_change = new \SquareConnect\Model\InventoryChange(
				array(
					'type'           => 'PHYSICAL_COUNT',
					'physical_count' => new \SquareConnect\Model\InventoryPhysicalCount(
						array(
							'catalog_object_id' => $square_variation_id,
							'quantity'          => '' . max( 0, $product->get_stock_quantity() ),
							'location_id'       => wc_square()->get_settings_handler()->get_location_id(),
							'state'             => 'IN_STOCK',
							'occurred_at'       => date( 'Y-m-d\TH:i:sP' ),
						)
					),
				)
			);
		}

		return $inventory_change;
	}


	/**
	 * Gets an InventoryChange object filled with a \SquareConnect\Model\InventoryAdjustment object for a given product.
	 *
	 * @since 2.0.8
	 *
	 * @param \WC_Product $product the product object
	 * @param int $adjustment Value can negative or positive.
	 *
	 * @return \SquareConnect\Model\InventoryChange|null
	 */
	public static function get_inventory_change_adjustment_type( \WC_Product $product, $adjustment ) {

		$square_variation_id = self::get_square_item_variation_id( $product->get_id(), false );

		if ( empty( $square_variation_id ) || 0 === $adjustment ) {
			return null;
		}

		if ( 0 > $adjustment ) {
			$from = 'IN_STOCK';
			$to   = 'SOLD';
		} else {
			$from = 'NONE';
			$to   = 'IN_STOCK';
		}

		$inventory_change = new \SquareConnect\Model\InventoryChange(
			array(
				'type'       => 'ADJUSTMENT',
				'adjustment' => new \SquareConnect\Model\InventoryAdjustment(
					array(
						'catalog_object_id' => $square_variation_id,
						'location_id'       => wc_square()->get_settings_handler()->get_location_id(),
						'quantity'          => '' . absint( $adjustment ),
						'from_state'        => $from,
						'to_state'          => $to,
						'occurred_at'       => date( 'Y-m-d\TH:i:sP' ),
					)
				),
			)
		);

		return $inventory_change;
	}
}
