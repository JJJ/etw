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

defined( 'ABSPATH' ) or exit;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;
use WooCommerce\Square\Handlers\Product;

/**
 * The plugin lifecycle handler.
 *
 * @since 2.0.0
 *
 * @method Plugin get_plugin()
 */
class Lifecycle extends Framework\Plugin\Lifecycle {


	/**
	 * Lifecycle constructor.
	 *
	 * @since 2.0.0
	 *
	 * @param Plugin $plugin main instance
	 */
	public function __construct( Plugin $plugin ) {

		parent::__construct( $plugin );

		// plugin upgrade path: maps automatically each semver to upgrade_to_x_y_z() protected method
		$this->upgrade_versions = [
			'2.0.0',
			'2.0.4',
		];
	}


	/**
	 * Performs plugin installation.
	 *
	 * @since 2.0.0
	 */
	protected function install() {

		// create the db table for the customer index
		Gateway\Customer_Helper::create_table();

		/**
		 * Fires upon plugin installed.
		 *
		 * @since 2.0.0
		 *
		 * @param string $version plugin version (available from v2.0.0)
		 */
		do_action( 'wc_square_installed', Plugin::VERSION );
	}


	/**
	 * Performs upgrade tasks.
	 *
	 * @since 2.0.0
	 *
	 * @param string $installed_version semver
	 */
	protected function upgrade( $installed_version ) {

		parent::upgrade( $installed_version );

		/**
		 * Fires upon plugin upgraded (legacy hook).
		 *
		 * @since 1.0.0
		 *
		 * @param string $version version updating to (available from v2.0.0)
		 * @param string $version version updating from (available from v2.0.0)
		 */
		do_action( 'wc_square_updated', Plugin::VERSION, $installed_version );
	}


	/**
	 * Upgrades to version 2.0.0
	 *
	 * @since 2.0.0
	 */
	protected function upgrade_to_2_0_0() {

		// create the db table for the customer index
		Gateway\Customer_Helper::create_table();

		/** @see \wc_set_time_limit() */
		if (      function_exists( 'set_time_limit' )
		     && ! ini_get( 'safe_mode' )
		     &&   false === strpos( ini_get( 'disable_functions' ), 'set_time_limit' ) ) {

			@set_time_limit( 300 );
		}

		// migrate all the things!
		$syncing_products = $this->migrate_plugin_settings();

		$this->migrate_gateway_settings();
		$this->migrate_orders();

		// only set the products "sync" status if v2 is now configured to sync products
		if ( $syncing_products ) {

			$this->migrate_products();

			// assume a last sync occurred before upgrading
			$this->get_plugin()->get_sync_handler()->set_last_synced_at();
			$this->get_plugin()->get_sync_handler()->set_inventory_last_synced_at();
		}

		$this->migrate_customers();

		// mark upgrade complete
		update_option( 'wc_square_updated_to_2_0_0', true );
	}


	/**
	 * Upgrades to version 2.0.4.
	 *
	 * @since 2.0.4
	 */
	protected function upgrade_to_2_0_4() {

		$v1_settings = get_option( 'woocommerce_squareconnect_settings', [] );
		$v2_settings = get_option( 'wc_square_settings', [] );

		$v2_settings = $this->get_migrated_system_of_record( $v1_settings, $v2_settings );

		update_option( 'wc_square_settings', $v2_settings );
	}


	/**
	 * Migrates plugin settings from v1 to v2.
	 *
	 * @see Lifecycle::upgrade_to_2_0_0()
	 *
	 * @since 2.0.0
	 *
	 * @return bool whether a system of record was enabled from migration
	 */
	private function migrate_plugin_settings() {

		$this->get_plugin()->log( 'Migrating plugin settings...' );

		// get legacy and new default settings
		$new_settings    = get_option( 'wc_square_settings', [] );
		$legacy_settings = get_option( 'woocommerce_squareconnect_settings', [] );
		$email_settings  = get_option( 'woocommerce_wc_square_sync_completed_settings', [] );

		// bail if they already have v2 settings present
		if ( ! empty( $new_settings ) ) {
			return;
		}

		// handle access token first
		if ( $legacy_access_token = get_option( 'woocommerce_square_merchant_access_token' ) ) {

			// the access token was previously stored unencrypted
			if ( ! empty( $legacy_access_token ) && Utilities\Encryption_Utility::is_encryption_supported() ) {

				$encryption = new Utilities\Encryption_Utility();

				try {
					$legacy_access_token = $encryption->encrypt_data( $legacy_access_token );
				} catch ( Framework\SV_WC_Plugin_Exception $exception ) {
					// log the event, but don't halt the process
					$this->get_plugin()->log( 'Could not encrypt access token during upgrade. ' . $exception->getMessage() );
				}
			}

			// previously only 'production' environment was assumed
			$access_tokens               = get_option( 'wc_square_access_tokens', [] );
			$access_tokens['production'] = is_string( $legacy_access_token ) ? $legacy_access_token : '';

			update_option( 'wc_square_access_tokens', $access_tokens );
		}

		// migrate store location
		if ( ! empty( $legacy_settings['location'] ) ) {
			$new_settings['location_id'] = $legacy_settings['location'];
		}

		// toggle debug logging
		$new_settings['debug_logging_enabled'] = isset( $legacy_settings['logging'] ) && in_array( $legacy_settings['logging'], [ 'yes', 'no' ], true ) ? $legacy_settings['logging'] : 'no';

		// set the SOR and inventory sync values
		$new_settings = $this->get_migrated_system_of_record( $legacy_settings, $new_settings );

		// migrate email notification settings: if there's a recipient, we enable email and pass recipient(s) to email setting
		if ( isset( $legacy_settings['sync_email'] ) && is_string( $legacy_settings['sync_email'] ) && '' !== trim( $legacy_settings['sync_email'] ) ) {
			$email_settings['enabled']   = 'yes';
			$email_settings['recipient'] = $legacy_settings['sync_email'] ;
		} else {
			$email_settings['enabled']   = 'no';
			$email_settings['recipient'] = '';
		}

		// save email settings
		update_option( 'woocommerce_wc_square_sync_completed_settings', $email_settings );
		// save plugin settings
		update_option( 'wc_square_settings', $new_settings );

		$this->get_plugin()->log( 'Plugin settings migration complete.' );

		return isset( $new_settings['system_of_record'] ) && $new_settings['system_of_record'] !== Settings::SYSTEM_OF_RECORD_DISABLED;
	}


	/**
	 * Migrates gateway settings from v1 to v2.
	 *
	 * @see Lifecycle::upgrade_to_2_0_0()
	 *
	 * @since 2.0.0
	 */
	private function migrate_gateway_settings() {

		$this->get_plugin()->log( 'Migrating gateway settings...' );

		$legacy_settings = get_option( 'woocommerce_square_settings', [] );
		$new_settings    = get_option( 'woocommerce_square_credit_card_settings', [] );

		// bail if they already have v2 settings present
		if ( ! empty( $new_settings ) ) {
			return;
		}

		if ( isset( $legacy_settings['enabled'] ) ) {
			$new_settings['enabled'] = 'yes' === $legacy_settings['enabled'] ? 'yes' : 'no';
		}

		if ( isset( $legacy_settings['title'] ) && is_string( $legacy_settings['title'] ) ) {
			$new_settings['title'] = $legacy_settings['title'];
 		}

		if ( isset( $legacy_settings['description'] ) && is_string( $legacy_settings['description'] ) ) {
			$new_settings['description'] = $legacy_settings['description'];
		}

		// note: the following is not an error, the setting on v1 intends "delayed" capture, hence authorization only, if set
		if ( isset( $legacy_settings['capture'] ) ) {
			$new_settings['transaction_type'] = 'yes' === $legacy_settings['capture'] ? Gateway::TRANSACTION_TYPE_AUTHORIZATION : Gateway::TRANSACTION_TYPE_CHARGE;
		}

		// not quite the same, since tokenization is a new thing, but we could presume the intention to let customers save their payment details
		if ( isset( $legacy_settings['create_customer'] ) ) {
			$new_settings['tokenization'] = 'yes' === $legacy_settings['create_customer'] ? 'yes' : 'no';
		}

		if ( isset( $legacy_settings['logging'] ) ) {
			$new_settings['debug_mode'] = 'yes' === $legacy_settings['logging'] ? 'log' : 'off';
		}

		// there was no card types setting in v1
		$new_settings['card_types'] = [
			'VISA',
			'MC',
			'AMEX',
			'JCB',
			// purposefully omit dinersclub & discover
		];

		// save migrated settings
		update_option( 'woocommerce_square_credit_card_settings', $new_settings );

		$this->get_plugin()->log( 'Gateway settings migration complete.' );
	}


	/**
	 * Migrates order data from v1 to v2.
	 *
	 * @see Lifecycle::upgrade_to_2_0_0()
	 *
	 * @since 2.0.0
	 */
	private function migrate_orders() {
		global $wpdb;

		$this->get_plugin()->log( 'Migrating orders data...' );

		// move charge captured flag in orders to SkyVerge framework meta key
		$wpdb->update( $wpdb->postmeta, [ 'meta_key' => '_wc_square_credit_card_charge_captured' ], [ 'meta_key' => '_square_charge_captured' ] );

		// move payment ID to new gateway ID meta key value
		$wpdb->update( $wpdb->postmeta, [ 'meta_value' => 'square_credit_card' ], [ 'meta_key' => '_payment_method', 'meta_value' => 'square' ] );

		$this->get_plugin()->log( 'Orders migration complete.' );
	}


	/**
	 * Migrates product data from v1 to v2.
	 *
	 * @see Lifecycle::upgrade_to_2_0_0()
	 *
	 * @since 2.0.0
	 */
	private function migrate_products() {
		global $wpdb;

		$this->get_plugin()->log( 'Migrating products data...' );

		// the handling in v1 was reversed, so we want products where sync wasn't disabled
		$legacy_product_ids = get_posts( [
			'nopaging'    => true,
			'post_type'   => 'product',
			'post_status' => 'all',
			'fields'      => 'ids',
			'meta_query'  => [
				'relation' => 'OR',
				[
					'key'     => '_wcsquare_disable_sync',
					'value'   => 'no',
				],
				[
					'key'     => '_wcsquare_disable_sync',
					'compare' => 'NOT EXISTS',
				]
			],
		] );

		// in v2 we turn those products as flagged to be sync-enabled instead
		if ( ! empty( $legacy_product_ids ) ) {

			$failed_products = [];

			// ensure taxonomy is registered at this stage
			if ( ! taxonomy_exists( Product::SYNCED_WITH_SQUARE_TAXONOMY ) ) {
				Product::init_taxonomies();
			}

			// will not create the term if already exists
			wp_create_term( 'yes', Product::SYNCED_WITH_SQUARE_TAXONOMY );

			// set Square sync status via taxonomy term
			foreach ( $legacy_product_ids as $i => $product_id ) {

				$set_term = wp_set_object_terms( $product_id, [ 'yes' ], Product::SYNCED_WITH_SQUARE_TAXONOMY );

				if ( ! is_array( $set_term ) ) {

					unset( $legacy_product_ids[ $i ] );

					$failed_products[] = $product_id;
				}
			}

			// log any errors
			if ( ! empty( $failed_products ) ) {
				$this->get_plugin()->log( 'Could not update sync with Square status for products with ID: ' . implode( ', ', array_unique( $failed_products ) ) . '.' );
			}
		}

		$this->get_plugin()->log( 'Products migration complete.' );
	}


	/**
	 * Migrates customer data.
	 *
	 * @since 2.0.0
	 */
	private function migrate_customers() {
		global $wpdb;

		$this->get_plugin()->log( 'Migrating customer data.' );

		$rows = (int) $wpdb->update( $wpdb->usermeta, [ 'meta_key' => 'wc_square_customer_id' ], [ 'meta_key' => '_square_customer_id' ] );

		$this->get_plugin()->log( sprintf( '%d customers migrated', $rows ) );
	}


	/**
	 * Adds the system of record setting to the v2 plugin settings depending on v1 setting values.
	 *
	 * @since 2.0.2
	 *
	 * @param array $v1_settings v1 plugin settings
	 * @param array $v2_settings v2 plugin settings
	 * @return array
	 */
	private function get_migrated_system_of_record( $v1_settings, $v2_settings ) {

		$sync_products     = isset( $v1_settings['sync_products'] ) && 'yes' === $v1_settings['sync_products'];
		$sync_inventory    = $sync_products && isset( $v1_settings['sync_inventory'] ) && 'yes' === $v1_settings['sync_inventory'];
		$inventory_polling = isset( $v1_settings['inventory_polling'] ) && 'yes' === $v1_settings['inventory_polling'];

		$v2_settings['system_of_record']      = $sync_products && $inventory_polling ? Settings::SYSTEM_OF_RECORD_SQUARE : Settings::SYSTEM_OF_RECORD_DISABLED;
		$v2_settings['enable_inventory_sync'] = $inventory_polling || $sync_inventory ? 'yes' : 'no';

		return $v2_settings;
	}


}
