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

namespace WooCommerce\Square\Admin;

defined( 'ABSPATH' ) or exit;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;
use WooCommerce\Square\Handlers\Product;
use WooCommerce\Square\Sync\Records;

/**
 * Products admin handler.
 *
 * @since 2.0.0
 */
class Products {


	/** @var array associative array of product error codes and messages */
	private $product_errors;

	/** @var array associative array of memoized errors being output for a product at one time */
	private $output_errors = [];

	/** @var int[] array of product IDs that have been scheduled for sync in this request */
	private $products_to_sync = [];

	/** @var int[] array of product IDs that have been scheduled for deletion in this request */
	private $products_to_delete = [];


	/**
	 * Sets up the products admin handler.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		// add common errors
		$this->product_errors = [
			'missing_sku'           => __( "Please add a SKU to sync this product with Square. The SKU must match the item's SKU in your Square account.", 'woocommerce-square' ),
			'missing_variation_sku' => __( "Please add a SKU to every variation of this variable product for syncing with Square. Each SKU must match the corresponding item's SKU in your Square account.", 'woocommerce-square' ),
			'multiple_attributes'   => __( 'Products with multiple variation attributes cannot be synced with Square.', 'woocommerce-square' ),
		];

		// add hooks
		$this->add_products_edit_screen_hooks();
		$this->add_product_edit_screen_hooks();
		$this->add_product_sync_hooks();
	}


	/**
	 * Adds hooks to the admin products edit screen.
	 *
	 * Products filtering, bulk actions, etc.
	 *
	 * @since 2.0.0
	 */
	private function add_products_edit_screen_hooks() {

		// adds an option to the "Filter by product type" dropdown
		add_action( 'restrict_manage_posts', [ $this, 'add_filter_products_synced_with_square_option' ] );
		// allow filtering products by sync status by altering results
		add_filter( 'request', [ $this, 'filter_products_synced_with_square' ] );

		// prevent copying Square data when duplicating a product automatically
		add_action( 'woocommerce_product_duplicate', [ $this, 'handle_product_duplication' ], 20, 2 );

		// handle quick/bulk edit actions in the products edit screen for setting sync status
		add_action( 'woocommerce_product_quick_edit_end',  [ $this, 'add_quick_edit_inputs' ] );
		add_action( 'woocommerce_product_bulk_edit_end',   [ $this, 'add_bulk_edit_inputs' ] );
		add_action( 'woocommerce_product_quick_edit_save', [ $this, 'set_synced_with_square' ] );
		add_action( 'woocommerce_product_bulk_edit_save',  [ $this, 'set_synced_with_square' ] );
	}


	/**
	 * Adds hooks to individual products edit screens.
	 *
	 * Product data input fields, variations, etc.
	 *
	 * @since 2.0.0
	 */
	private function add_product_edit_screen_hooks() {

		add_action( 'woocommerce_variation_options', [ $this, 'add_variation_manage_stock' ] );

		// handle individual products input fields for setting sync status
		add_action( 'woocommerce_product_options_general_product_data', [ $this, 'add_product_data_fields' ] );
		add_action( 'woocommerce_admin_process_product_object',         [ $this, 'process_product_data' ], 20 );
		add_action( 'woocommerce_before_product_object_save',           [ $this, 'maybe_adjust_square_stock'] );

		add_action( 'admin_notices', [ $this, 'add_notice_product_hidden_from_catalog' ] );
	}


	/**
	 * Adds our own hidden "manage stock" input to the variation fields.
	 *
	 * We disable the core checkbox, but this causes stock management to be disabled for the variations because the
	 * disabled field doesn't get POSTed. This overrides the checkbox value so that we can still disable it in the UI.
	 *
	 * @since 2.0.2
	 *
	 * @param int $loop currently looped variation
	 */
	public function add_variation_manage_stock( $loop ) {

		if ( ! wc_square()->get_settings_handler()->is_inventory_sync_enabled() ) {
			return;
		}

		?> <input type="hidden" id="wc_square_variation_manage_stock" name="variable_manage_stock[<?php echo esc_attr( $loop ); ?>]" value="1" /> <?php
	}


	/**
	 * Adds hooks to sync products that have been updated.
	 *
	 * @since 2.0.0
	 */
	private function add_product_sync_hooks() {

		add_action( 'woocommerce_update_product',        [ $this, 'maybe_stage_product_for_sync' ] );
		add_action( 'trashed_post',                      [ $this, 'maybe_stage_products_for_deletion' ] );
		add_action( 'shutdown',                          [ $this, 'maybe_sync_staged_products' ] );
		add_action( 'shutdown',                          [ $this, 'maybe_delete_staged_products' ] );
	}


	/**
	 * Adds an option to filter products by sync status.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 *
	 * @param string $post_type the post type context
	 */
	public function add_filter_products_synced_with_square_option( $post_type ) {

		if ( 'product' !== $post_type ) {
			return;
		}

		$label    = esc_html__( 'Synced with Square', 'woocommerce-square' );
		$selected = isset( $_GET['product_type'] ) && 'synced-with-square' === $_GET['product_type'] ? 'selected=\"selected\"' : '';

		wc_enqueue_js( "
			jQuery( document ).ready( function( $ ) {
				$( 'select#dropdown_product_type' ).append( '<option value=\"synced-with-square\" ' + '" . $selected . "' + '>' + '" . $label ."' + '</option>' );
			} );
		" );
	}


	/**
	 * Filters products in admin edit screen by sync status with Square.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 *
	 * @param array $query_vars query variables
	 * @return array
	 */
	public function filter_products_synced_with_square( $query_vars ){
		global $typenow;

		if ( 'product' === $typenow && isset( $_GET['product_type'] ) && 'synced-with-square' === $_GET['product_type'] ) {

			// not really a product type, otherwise WooCommerce will handle it as such
			unset( $query_vars['product_type'] );

			if ( ! isset( $query_vars['tax_query'] ) ) {
				$query_vars['tax_query'] = [];
			} else {
				$query_vars['tax_query']['relation'] = 'AND';
			}

			$query_vars['tax_query'][] = [
				'taxonomy' => Product::SYNCED_WITH_SQUARE_TAXONOMY,
				'field'    => 'slug',
				'terms'    => [ 'yes' ],
			];
		}

		return $query_vars;
	}


	/**
	 * Adds general product data options to a product metabox.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function add_product_data_fields() {
		global $product_object;

		if ( ! $product_object instanceof \WC_Product ) {
			return;
		}

		// don't show fields if product sync is disabled
		if ( ! wc_square()->get_settings_handler()->is_product_sync_enabled() ) {
			return;
		}

		?>
		<div class="wc-square-sync-with-square options_group show_if_simple show_if_variable">
			<?php

			$selector   = '_' . Product::SYNCED_WITH_SQUARE_TAXONOMY;
			$value      = Product::is_synced_with_square( $product_object ) ? 'yes' : 'no';
			$errors     = [];

			if ( $product_object->is_type( 'variable' ) ) {

				if ( Product::has_multiple_variation_attributes( $product_object ) ) {

					$errors[] = 'multiple_attributes';

				} else {

					foreach ( $product_object->get_children() as $child ) {

						$child = wc_get_product( $child );

						if ( $child && ! $child->get_sku() ) {
							$errors[] = 'missing_variation_sku';
						}
					}
				}

			} elseif ( ! $product_object->get_sku() ) {

				$errors[] = 'missing_sku';
			}

			$setting_label = wc_square()->get_settings_handler()->is_system_of_record_square() ? __( 'Update product data with Square data', 'woocommerce-square' ) : __( 'Send product data to Square', 'woocommerce-square' );

			woocommerce_wp_checkbox( [
				'id'                => $selector,
				'label'             => __( 'Sync with Square', 'woocommerce-square' ),
				'value'             => $value,
				'cbvalue'           => 'yes',
				'default'           => 'no',
				'description'       => $setting_label,
				'custom_attributes' => ! empty( $errors ) ? [ 'disabled' => 'disabled' ] : [],
			] );

			?>
			<p class="form-field wc-square-sync-with-square-errors">
				<?php foreach ( $this->product_errors as $error_code => $error_message ) :  ?>
					<?php $styles = ! in_array( $error_code, $errors, true ) ? 'display:none; color:#A00;' : 'display:block; color:#A00;'; ?>
					<span class="wc-square-sync-with-square-error <?php echo sanitize_html_class( $error_code ); ?>" style="<?php echo $styles; ?>"><?php echo esc_html( $error_message ); ?></span>
				<?php endforeach; ?>
			</p>

			<input type="hidden" id="<?php echo esc_attr( Product::SQUARE_VARIATION_ID_META_KEY ); ?>" value="<?php echo esc_attr( $product_object->get_meta( Product::SQUARE_VARIATION_ID_META_KEY ) ); ?>" />

		</div>
		<?php
	}


	/**
	 * Outputs HTML with a dropdown field to mark a product to be synced with Square.
	 *
	 * @since 2.0.0
	 *
	 * @param bool $bulk whether the field is meant for bulk edit
	 */
	private function output_synced_with_square_edit_field( $bulk = false ) {

		?>
		<div class="inline-edit-group wc-square-sync-with-square">
			<label>
				<span class="title"><?php esc_html_e( 'Sync with Square?', 'woocommerce-square' ); ?></span>
				<span class="input-text-wrap">
					<select class="square-synced" name="<?php echo esc_attr( Product::SYNCED_WITH_SQUARE_TAXONOMY ); ?>">
						<?php if ( true === $bulk ) : // in bulk actions there's the option to leave the value unchanged (or unset) ?>
							<option value="">&mdash; <?php esc_html_e( 'No change', 'woocommerce-square' ); ?> &mdash;</option>
						<?php endif; ?>
						<option value="no"><?php esc_html_e( 'No', 'woocommerce-square' ); ?></option>
						<option value="yes"><?php esc_html_e( 'Yes', 'woocommerce-square' ); ?></option>
					</select>
				</span>
			</label>
			<p class="form-field wc-square-sync-with-square-errors">
				<?php foreach ( $this->product_errors as $error_code => $error_message ) : ?>
					<span class="wc-square-sync-with-square-error <?php echo $error_code; ?>" style="display:none; color:#A00;"><?php echo esc_html( $error_message ); ?></span>
				<?php endforeach; ?>
			</p>
		</div>
		<?php
	}


	/**
	 * Adds quick edit fields to the products screen.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function add_quick_edit_inputs() {

		$this->output_synced_with_square_edit_field();
	}


	/**
	 * Adds bulk edit fields to the products screen.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function add_bulk_edit_inputs() {

		$this->output_synced_with_square_edit_field( true );
	}


	/**
	 * Stages a product for sync with Square on product save if Woo is the SOR and the product is set to 'synced with square'.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 *
	 * @param int $product_id the product ID
	 */
	public function maybe_stage_product_for_sync( $product_id ) {

		if ( ! defined( 'DOING_SQUARE_SYNC' ) && ! in_array( $product_id, $this->products_to_sync ) && wc_square()->get_settings_handler()->is_system_of_record_woocommerce() ) {

			$product = wc_get_product( $product_id );

			if ( $product && Product::is_synced_with_square( $product ) ) {

				// the triggering action for this method can be called multiple times in a single request - keep track
				// of product IDs that have been scheduled for sync here to avoid multiple syncs on the same request
				$this->products_to_sync[] = $product_id;
			}
		}
	}


	/**
	 * Initializes a synchronization event for any staged products in this request.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function maybe_sync_staged_products() {

		if ( ! defined( 'DOING_SQUARE_SYNC' ) && ! empty( $this->products_to_sync ) && wc_square()->get_settings_handler()->is_system_of_record_woocommerce() ) {

			wc_square()->get_sync_handler()->start_manual_sync( true, $this->products_to_sync );
		}
	}


	/**
	 * Removes a product from Square if it is deleted locally and Woo is the SOR.
	 *
	 * @since 2.0.0
	 *
	 * @param int $product_id the product ID
	 */
	public function maybe_stage_products_for_deletion( $product_id ) {

		if ( wc_square()->get_settings_handler()->is_system_of_record_woocommerce() ) {

			$product = wc_get_product( $product_id );

			if ( $product && Product::is_synced_with_square( $product ) ) {

				// the triggering action for this method can be called multiple times in a single request - keep track
				// of product IDs that have been scheduled for sync here to avoid multiple syncs on the same request
				$this->products_to_delete[] = $product_id;
			}
		}
	}


	/**
	 * Deletes any products staged for remote deletion.
	 *
	 * @since 2.0.0
	 */
	public function maybe_delete_staged_products() {

		if ( ! empty( $this->products_to_delete ) && wc_square()->get_settings_handler()->is_system_of_record_woocommerce() ) {

			wc_square()->get_sync_handler()->start_manual_deletion( $this->products_to_delete );
		}
	}


	/**
	 * Sets a product's synced with Square status for quick/bulk edit action.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product $product a product object
	 */
	public function set_synced_with_square( $product ) {

		$posted_data_key = Product::SYNCED_WITH_SQUARE_TAXONOMY;

		if ( 'woocommerce_product_bulk_edit_save' === current_action() ) {
			$default_value = null; // in bulk actions this will preserve the existing setting if nothing is specified
		} else {
			$default_value = 'no'; // in individual products context, the value should be always an explicit yes or no
		}

		$square_synced = isset( $_REQUEST[ $posted_data_key ] ) && in_array( $_REQUEST[ $posted_data_key ], [ 'yes', 'no' ], true ) ? $_REQUEST[ $posted_data_key ] : $default_value;

		if ( is_string( $square_synced ) ) {

			Product::set_synced_with_square( $product, $square_synced );
		}
	}


	/**
	 * Updates Square sync status for a product upon saving.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product $product product object
	 */
	public function process_product_data( $product ) {

		// don't process fields if product sync is disabled
		if ( ! wc_square()->get_settings_handler()->is_product_sync_enabled() ) {
			return;
		}

		// bail if no valid product found, if it's a variation, errors have already been output
		if ( ! $product || ( $product instanceof \WC_Product_Variation || $product->is_type( 'product_variation' ) ) || ! empty( $this->output_errors[ $product->get_id() ] ) ) {
			return;
		}

		$errors     = [];
		$posted_key = '_' . Product::SYNCED_WITH_SQUARE_TAXONOMY;
		$set_synced = isset( $_POST[ $posted_key ] ) && 'yes' === $_POST[ $posted_key ];
		$was_synced = Product::is_synced_with_square( $product );

		// condition has unchanged
		if ( ! $set_synced && ! $was_synced ) {
			return;
		}

		$is_variable = $product->is_type( 'variable' ) && $product->has_child();

		if ( $set_synced || $was_synced ) {

			if ( $is_variable ) {

				if ( Product::has_multiple_variation_attributes( $product ) ) {
					$errors['multiple_attributes'] = $this->product_errors['multiple_attributes'];
				}

				// if the product is variable, also its variations should have a matching SKU
				if ( isset( $this->product_errors['missing_variation_sku'] ) ) {

					foreach ( $product->get_children() as $variation_id ) {

						$variation = wc_get_product( $variation_id );

						if ( $variation && empty( $variation->get_sku() ) ) {

							$errors['missing_variation_sku'] = $this->product_errors['missing_variation_sku'];
							break;
						}
					}
				}

			} elseif ( isset( $this->product_errors['missing_sku'] ) && empty( $product->get_sku() ) ) {

				$errors['missing_sku'] = $this->product_errors['missing_sku'];
			}
		}

		if ( ! empty( $errors ) ) {

			// if the instruction is to sync the Product but there are errors, remove the link and display the errors
			Product::unset_synced_with_square( $product );

			foreach ( $errors as $error ) {
				wc_square()->get_message_handler()->add_error( $error );
			}

		} elseif ( $set_synced && $is_variable && wc_square()->get_settings_handler()->is_inventory_sync_enabled() ) {

			// if syncing inventory with Square, parent variable products don't manage stock
			$product->set_manage_stock( false );

			// if there are no errors, and the product is variable, force enable stock management for all its variations
			foreach ( $product->get_children() as $variation_id ) {

				if ( $variation = wc_get_product( $variation_id ) ) {
					$variation->set_manage_stock( true );
					$variation->save();
				}
			}
		}

		// finally, set the product sync with Square flag
		Product::set_synced_with_square( $product, $set_synced ? 'yes' : 'no' );
	}


	/**
	 * Adjusts a product's Square stock.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product $product product object
	 */
	public function maybe_adjust_square_stock( $product ) {

		// this is hooked in to general product object save, so scope to specifically saving products via the admin
		if ( ! doing_action( 'wp_ajax_woocommerce_save_variations' ) && ! doing_action( 'woocommerce_admin_process_product_object' ) ) {
			return;
		}

		// only send stock updates for Woo SOR
		if ( ! wc_square()->get_settings_handler()->is_system_of_record_woocommerce() || ! wc_square()->get_settings_handler()->is_inventory_sync_enabled() ) {
			return;
		}

		if ( ! $product instanceof \WC_Product || ! Product::is_synced_with_square( $product ) ) {
			return;
		}

		$square_id = $product->get_meta( Product::SQUARE_VARIATION_ID_META_KEY );

		// only send when the product has an associated Square ID
		if ( ! $square_id ) {
			return;
		}

		// set to manage stock if not a variable product
		$product->set_manage_stock( ! $product->is_type( 'variable' ) );

		$data    = $product->get_data();
		$changes = $product->get_changes();
		$change  = 0;

		if ( isset( $data['stock_quantity'], $changes['stock_quantity'] ) ) {
			$change = (int) $changes['stock_quantity'] - $data['stock_quantity'];
		}

		if ( $change !== 0 ) {

			try {

				if ( $change > 0 ) {
					wc_square()->get_api()->add_inventory( $square_id, $change );
				} else {
					wc_square()->get_api()->remove_inventory( $square_id, $change );
				}

			} catch ( Framework\SV_WC_Plugin_Exception $exception ) {

				wc_square()->log( 'Could not adjust Square inventory for ' . $product->get_formatted_name() . '. ' . $exception->getMessage() );

				$quantity = (float) $data['stock_quantity'];

				// if the API request fails, set the product quantity back from whence it came
				$product->set_stock_quantity( $quantity );
			}
		}
	}


	/**
	 * Prevents copying Square data when duplicating a product in admin.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Product $duplicated_product product duplicate
	 * @param \WC_Product $original_product product duplicated
	 */
	public function handle_product_duplication( $duplicated_product, $original_product ) {

		if ( Product::is_synced_with_square( $original_product ) ) {
			Product::unset_synced_with_square( $duplicated_product );
		}

		$duplicated_product->delete_meta_data( Product::SQUARE_ID_META_KEY );
		$duplicated_product->delete_meta_data( Product::SQUARE_VARIATION_ID_META_KEY  );

		if ( $duplicated_product->is_type( 'variable' ) ) {

			foreach ( $duplicated_product->get_children() as $duplicated_variation_id ) {

				if ( $duplicated_product_variation = wc_get_product( $duplicated_variation_id ) ) {

					$duplicated_product_variation->delete_meta_data( Product::SQUARE_VARIATION_ID_META_KEY );
					$duplicated_product_variation->save_meta_data();
				}
			}
		}

		$duplicated_product->save_meta_data();
	}


	/**
	 * Outputs an admin notice when a product was hidden from catalog upon a sync error.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function add_notice_product_hidden_from_catalog() {
		global $current_screen, $post;

		if ( $post && $current_screen && 'product' === $current_screen->id ) {

			$product = wc_get_product( $post );

			if ( $product && 'hidden' === $product->get_catalog_visibility() ) {

				$product_id = $product->get_id();
				$records    = Records::get_records( [ 'product' => $product_id ] );

				foreach ( $records as $record ) {

					if ( $record->was_product_hidden() && $product_id === $record->get_product_id() ) {

						wc_square()->get_message_handler()->add_warning(
							sprintf(
								/* translators: Placeholder: %1$s - date (localized), %2$s - time (localized), %3$s - opening <a> HTML link tag, %4$s closing </a> HTML link tag */
								esc_html__( 'The product catalog visibility has been set to "hidden", as a matching product could not be found in Square on %1$s at %2$s. %3$sCheck sync records%4$s.', 'woocommerce-square' ),
								date_i18n( wc_date_format(), $record->get_timestamp() ),
								date_i18n( wc_time_format(), $record->get_timestamp() ),
								'<a href="' . esc_url( add_query_arg( [ 'section' => 'update' ], wc_square()->get_settings_url() ) ) . '">', '</a>'
							)
						);

						break;
					}
				}
			}
		}
	}


}
