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

namespace WooCommerce\Square;

defined( 'ABSPATH' ) || exit;

use WooCommerce\Square\Handlers\Product;

/**
 * The base admin handler class.
 *
 * @since 2.0.0
 */
class Admin {


	/**
	 * Product handler.
	 *
	 * @var Handlers\Products
	 */
	private $products_handler;

	/**
	 * Privacy handler.
	 *
	 * @var Admin\Privacy
	 */
	private $privacy_handler;

	/**
	 * Plugin
	 *
	 * @var Plugin plugin instance
	 */
	private $plugin;


	/**
	 * Constructs the class.
	 *
	 * @since 2.0.0
	 *
	 * @param Plugin $plugin plugin instance.
	 */
	public function __construct( Plugin $plugin ) {

		$this->plugin = $plugin;

		$this->products_handler = $this->plugin->get_products_handler();

		// privacy
		if ( version_compare( WC_VERSION, '3.4', '>=' ) ) {
			$this->privacy_handler = new Admin\Privacy();
		}

		$this->add_hooks();
	}


	/**
	 * Adds the action & filter hooks.
	 *
	 * @since 2.0.0
	 */
	private function add_hooks() {

		// add the settings page.
		add_filter(
			'woocommerce_get_settings_pages',
			function ( $pages ) {

				$pages[] = new Admin\Settings_Page( $this->get_plugin()->get_settings_handler() );

				return $pages;
			}
		);

		// load admin scripts.
		add_action(
			'admin_enqueue_scripts',
			function() {
				$this->load_scripts_styles();
			}
		);
	}


	/**
	 * Loads and enqueues admin scripts and styles.
	 *
	 * @since 2.0.0
	 */
	private function load_scripts_styles() {
		global $typenow;

		if ( 'product' === $typenow ) {

			wp_enqueue_script(
				'wc-square-admin-products',
				$this->get_plugin()->get_plugin_url() . '/assets/js/admin/wc-square-admin-products.min.js',
				array( 'jquery' ),
				Plugin::VERSION,
				true
			);

			wp_localize_script(
				'wc-square-admin-products',
				'wc_square_admin_products',
				array(
					'ajax_url'                             => admin_url( 'admin-ajax.php' ),
					'settings_url'                         => esc_url( $this->get_plugin()->get_settings_url() ),
					'variable_product_types'               => $this->get_variable_product_types(),
					'synced_with_square_taxonomy'          => Product::SYNCED_WITH_SQUARE_TAXONOMY,
					'is_product_sync_enabled'              => $this->get_plugin()->get_settings_handler()->is_product_sync_enabled(),
					'is_woocommerce_sor'                   => $this->get_plugin()->get_settings_handler()->is_system_of_record_woocommerce(),
					'is_square_sor'                        => $this->get_plugin()->get_settings_handler()->is_system_of_record_square(),
					'is_inventory_sync_enabled'            => $this->get_plugin()->get_settings_handler()->is_inventory_sync_enabled(),
					'get_quick_edit_product_details_nonce' => wp_create_nonce( 'get-quick-edit-product-details' ),
					'fetch_product_stock_with_square_nonce' => wp_create_nonce( 'fetch-product-stock-with-square' ),
					'i18n'                                 => array(
						'synced_with_square'      => __( 'Synced with Square', 'woocommerce-square' ),
						'managed_by_square'       => __( 'Managed by Square', 'woocommerce-square' ),
						'fetch_stock_with_square' => __( 'Fetch stock from Square', 'woocommerce-square' ),
					),
				)
			);

		} elseif ( $this->get_plugin()->is_plugin_settings() ) {

			wp_enqueue_style(
				'wc-square-admin',
				$this->get_plugin()->get_plugin_url() . '/assets/css/admin/wc-square-admin.min.css',
				array(),
				Plugin::VERSION
			);

			wp_enqueue_script(
				'wc-square-admin-settings',
				$this->get_plugin()->get_plugin_url() . '/assets/js/admin/wc-square-admin-settings.min.js',
				array( 'jquery', 'jquery-blockui', 'backbone', 'wc-backbone-modal' ),
				Plugin::VERSION,
				true
			);

			$sync_job = $this->get_plugin()->get_sync_handler()->get_job_in_progress();

			if ( $sync_job ) {
				$existing_sync_id = $sync_job->id;
			} else {
				$existing_sync_id = false;
			}

			wp_localize_script(
				'wc-square-admin-settings',
				'wc_square_admin_settings',
				array(
					'ajax_url'                          => admin_url( 'admin-ajax.php' ),
					'is_product_sync_enabled'           => $this->get_plugin()->get_settings_handler()->is_product_sync_enabled(),
					'is_woocommerce_sor'                => $this->get_plugin()->get_settings_handler()->is_system_of_record_woocommerce(),
					'is_square_sor'                     => $this->get_plugin()->get_settings_handler()->is_system_of_record_square(),
					'is_inventory_sync_enabled'         => $this->get_plugin()->get_settings_handler()->is_inventory_sync_enabled(),
					'is_sandbox'                        => $this->get_plugin()->get_settings_handler()->is_sandbox(),
					'existing_sync_job_id'              => $existing_sync_id,
					'sync_in_background'                => $this->get_plugin()->get_sync_handler()->should_sync_in_background(),
					'import_products_from_square'       => wp_create_nonce( 'import-products-from-square' ),
					'sync_products_with_square'         => wp_create_nonce( 'sync-products-with-square' ),
					'get_sync_with_square_status_nonce' => wp_create_nonce( 'get-sync-with-square-status' ),
					'handle_sync_with_square_records'   => wp_create_nonce( 'handle-sync-with-square-records' ),
					'i18n'                              => array(
						'resolved'                   => __( 'Resolved', 'woocommerce-square' ),
						'no_records_found'           => __( 'No records found', 'woocommerce-square' ),
						'skipped'                    => __( 'Skipped', 'woocommerce-square' ),
						'updated'                    => __( 'Updated', 'woocommerce-square' ),
						'imported'                   => __( 'Imported', 'woocommerce-square' ),
						'sync_inventory_label'       => array(
							'square'      => __( 'Enable to fetch inventory changes from Square', 'woocommerce-square' ),
							'woocommerce' => __( 'Enable to push inventory changes to Square', 'woocommerce-square' ),
						),
						'sync_inventory_description' => array(
							'square'      => __( 'Inventory is fetched from Square periodically and updated in WooCommerce', 'woocommerce-square' ),
							'woocommerce' => sprintf(
								/* translators: Placeholders: %1$s - <strong> tag, %2$s - </strong> tag */
								__( 'Inventory is %1$salways fetched from Square%2$s periodically to account for sales from other channels.', 'woocommerce-square' ),
								'<strong>',
								'</strong>'
							),
						),
					),
				)
			);
		}
	}


	/**
	 * Gets a list of variable product types.
	 *
	 * @since 2.0.0
	 *
	 * @return string[]
	 */
	private function get_variable_product_types() {

		/**
		 * Filters the variable product types.
		 *
		 * @since 2.0.0
		 *
		 * @param string[] array of product types
		 */
		return (array) apply_filters( 'wc_square_variable_product_types', array( 'variable', 'variable-subscription' ) );
	}


	/**
	 * Gets the products handler.
	 *
	 * @since 2.0.0
	 *
	 * @return Admin\Products
	 */
	public function get_products_handler() {

		return $this->products_handler;
	}


	/**
	 * Gets the plugin instance.
	 *
	 * @since 2.0.0
	 *
	 * @return Plugin
	 */
	protected function get_plugin() {

		return $this->plugin;
	}


}
