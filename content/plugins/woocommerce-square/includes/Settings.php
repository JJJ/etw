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

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;

/**
 * The settings API class.
 *
 * This handles registering, getting, and storing the general plugin options.
 *
 * Note that this is separate from the gateway settings.
 *
 * @since 2.0.0
 */
class Settings extends \WC_Settings_API {


	/**
	 * Square system of record.
	 *
	 * @var string square system of record indicator
	 */
	const SYSTEM_OF_RECORD_SQUARE = 'square';

	/**
	 * Woocommerce system of record.
	 *
	 * @var string square system of record indicator
	 */
	const SYSTEM_OF_RECORD_WOOCOMMERCE = 'woocommerce';

	/**
	 * Disabled system of record.
	 *
	 * @var string system of record indicator for disabled sync
	 */
	const SYSTEM_OF_RECORD_DISABLED = 'disabled';


	/**
	 * Refresh token
	 *
	 * @var string un-encrypted refresh token
	 */
	protected $refresh_token;

	/**
	 * Access token
	 *
	 * @var string un-encrypted access token
	 */
	protected $access_token;

	/**
	 * Square business locations
	 *
	 * @var array business locations returned by the API
	 */
	protected $locations;

	/**
	 * Square plugin instance
	 *
	 * @var Plugin plugin instance
	 */
	protected $plugin;


	/**
	 * Constructs the class.
	 *
	 * @since 2.0.0
	 *
	 * @param Plugin $plugin plugin instance.
	 */
	public function __construct( Plugin $plugin ) {

		$this->plugin    = $plugin;
		$this->plugin_id = 'wc_';
		$this->id        = $plugin->get_id();

		$this->init_form_fields();

		$this->init_settings();

		// remove some of our custom fields that shouldn't be saved.
		add_action(
			'woocommerce_settings_api_sanitized_fields_' . $this->id,
			function( $fields ) {

				unset( $fields['general'], $fields['connect'], $fields['import_products'] );

				if ( $this->is_sandbox() ) {
					$this->update_access_token( $fields['sandbox_token'] );
					$this->access_token  = false; // Remove encrypted token.
					$this->refresh_token = false; // Remove encrypted token.
				}

				$this->init_form_fields(); // Reload form fields after saving token.

				return $fields;
			}
		);
	}


	/**
	 * Initializes the form fields.
	 *
	 * @since 2.0.0
	 */
	public function init_form_fields() {

		if ( $this->is_connected() ) {

			$general_description = sprintf(
				/* translators: Placeholders: %1$s - <a> tag, %2$s - </a> tag */
				__( 'Sync your products and inventory and also accept credit and debit card payments at checkout. %1$sClick here%2$s to configure payments.', 'woocommerce-square' ),
				'<a href="' . esc_url( $this->get_plugin()->get_payment_gateway_configuration_url( $this->get_plugin()->get_gateway()->get_id() ) ) . '">',
				'</a>'
			);

		} else {

			$general_description = __( 'Connect with Square to start syncing your products and inventory and also accept credit and debit card payments at checkout.', 'woocommerce-square' );
		}

		$fields = array(
			'general' => array(
				'type'        => 'title',
				'description' => $general_description,
			),
		);

		$fields['enable_sandbox'] = array(
			'title'       => __( 'Enable Sandbox Mode', 'woocommerce-square' ),
			'label'       => '<span>' . __( 'Enable to set the plugin in sandbox mode.', 'woocommerce-square' ) . '</span>',
			'type'        => 'checkbox',
			'description' => __( 'After enabling you’ll see a new Sandbox settings section with two fields; Sandbox Application ID & Sandbox Access Token.', 'woocommerce-square' ),
		);

		$fields['sandbox_settings'] = array(
			'type'        => 'title',
			'title'       => __( 'Sandbox settings', 'woocommerce-square' ),
			'id'          => 'wc_square_sandbox_settings',
			'description' => sprintf(
				// translators: Placeholders: %1$s - URL.
				__( 'Sandbox details can be created at: %s', 'woocommerce-square' ),
				sprintf( '<a href="%1$s">%1$s</a>', 'https://developer.squareup.com/apps' )
			),
		);

		$fields['sandbox_application_id'] = array(
			'type'        => 'input',
			'title'       => __( 'Sandbox Application ID', 'woocommerce-square' ),
			'class'       => 'wc_square_sandbox_settings',
			'description' => __( 'Application ID for the Sandbox Application, see the details in the My Applications section.', 'woocommerce-square' ),
		);

		$fields['sandbox_token'] = array(
			'type'        => 'input',
			'title'       => __( 'Sandbox Access Token', 'woocommerce-square' ),
			'class'       => 'wc_square_sandbox_settings',
			'description' => __( 'Access Token for the Sandbox Test Account, see the details in the Sandbox Test Account section. Make sure you use the correct Sandbox Access Token for your application. For a given Sandbox Test Account, each Authorized Application is assigned a different Access Token.', 'woocommerce-square' ),
		);

		// display these fields only if connected.
		if ( $this->is_connected() ) {

			$fields[ $this->get_environment() . '_location_id' ] = array(
				'title'       => __( 'Business location', 'woocommerce-square' ),
				'type'        => 'select',
				'class'       => 'wc-enhanced-select',
				'description' => sprintf(
					/* translators: Placeholders: %1$s - <strong> tag, %2$s - </strong> tag, %3$s - <a> tag, %4$s - </a> tag */
					__( 'Select a location to link to this site. Only %1$sactive%2$s %3$slocations%4$s that support credit card processing in Square can be linked.', 'woocommerce-square' ),
					'<strong>',
					'</strong>',
					'<a href="https://docs.woocommerce.com/document/woocommerce-square/#section-4" target="_blank">',
					'</a>'
				),
				'options'     => array(), // this is populated on display.
			);

			$fields['system_of_record'] = array(
				'title'       => __( 'Product system of record', 'woocommerce-square' ),
				'type'        => 'select',
				'class'       => 'wc-enhanced-select',
				'description' => sprintf(
					/* translators: Placeholders: %1$s - <strong> tag, %2$s - </strong> tag, %3$s - <a> tag, %4$s - </a> tag */
					__( 'Choose where you will update data for synced products. Inventory in Square is %1$salways%2$s checked for adjustments when sync is enabled. %3$sClick here%4$s to read more about choosing a system of record.', 'woocommerce-square' ),
					'<strong>',
					'</strong>',
					'<a href="' . esc_url( wc_square()->get_documentation_url() ) . '#section-7">',
					'</a>'
				),
				'options'     => array(
					self::SYSTEM_OF_RECORD_DISABLED    => __( 'Do not sync product data', 'woocommerce-square' ),
					self::SYSTEM_OF_RECORD_SQUARE      => __( 'Square', 'woocommerce-square' ),
					self::SYSTEM_OF_RECORD_WOOCOMMERCE => __( 'WooCommerce', 'woocommerce-square' ),
				),
				'default'     => 'disabled',
			);

			$fields['enable_inventory_sync'] = array(
				'title'       => __( 'Sync inventory', 'woocommerce-square' ),
				'label'       => '<span>' . __( 'Enable to sync product inventory with Square', 'woocommerce-square' ) . '</span>',
				'type'        => 'checkbox',
				'description' => __( 'Inventory is fetched from Square periodically and updated in WooCommerce', 'woocommerce-square' ),
			);

			$fields['hide_missing_products'] = array(
				'title'       => __( 'Handle missing products', 'woocommerce-square' ),
				'label'       => __( 'Hide synced products when not found in Square', 'woocommerce-square' ),
				'type'        => 'checkbox',
				'description' => __( 'Products not found in Square will be hidden in the WooCommerce product catalog.', 'woocommerce-square' ),
			);

			$fields['import_products'] = array(
				'title'    => __( 'Import Products', 'woocommerce-square' ),
				'type'     => 'import_products',
				'desc_tip' => __( 'Run an import to create new products in this WooCommerce store for each new product created in Square that has a unique SKU not existing in here. Needs to be run each time new items are created in Square.', 'woocommerce-square' ),
			);
		}

		// In sandbox mode we don't want to intially display the connect button, only disconnect.
		if ( ! ( $this->is_sandbox() && ! $this->is_connected() ) ) {
			$fields = array_merge(
				$fields,
				array(
					'connect' => array(
						'title'    => __( 'Connection', 'woocommerce-square' ),
						'type'     => 'connect',
						'desc_tip' => '',
					),
				)
			);
		}

		// Always display these fields.
		$fields = array_merge(
			$fields,
			array(
				'debug_logging_enabled' => array(
					'title' => __( 'Enable Logging', 'woocommerce-square' ),
					'type'  => 'checkbox',
					'label' => sprintf(
						/* translators: Placeholders: %1$s - <a> tag, %2$s - </a> tag */
						__( 'Log debug messages to the %1$sWooCommerce status log%2$s', 'woocommerce-square' ),
						'<a href="' . esc_url( admin_url( 'admin.php?page=wc-status&tab=logs' ) ) . '">',
						'</a>'
					),
				),
			)
		);

		$this->form_fields = $fields;
	}


	/**
	 * Gets the form fields.
	 *
	 * Overridden to populate the Location settings options on display.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	public function get_form_fields() {

		$fields = parent::get_form_fields();

		// Confirm our local enable sandbox setting matches what is sent from the front end
		// to account for changes from sandbox to production incorrectly fetching sandbox locations.
		if ( $this->settings && isset( $_POST['wc_square_environment'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing

			$environment = 'yes' === $this->settings['enable_sandbox'] ? 'sandbox' : 'production';

			if ( $environment !== $_POST['wc_square_environment'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
				return $fields;
			}
		}

		$location_id_field_key = '';
		// Get the location_id field.
		foreach ( $fields as $key => $value ) {
			if ( strpos( $key, 'location_id' ) ) {
				$location_id_field_key = $key;
				break;
			}
		}

		if ( did_action( 'wc_square_initialized' ) && $this->is_admin_settings_screen() && ! empty( $location_id_field_key ) ) {

			$locations = array(
				'' => __( 'Please choose a location', 'woocommerce-square' ),
			);

			if ( ! empty( $this->get_locations() ) ) {
				foreach ( $this->get_locations() as $location ) {
					if ( 'ACTIVE' === $location->getStatus() && in_array( 'CREDIT_CARD_PROCESSING', (array) $location->getCapabilities(), true ) ) {
						$locations[ $location->getId() ] = $location->getName();
					}
				}
			}

			$fields[ $location_id_field_key ]['options'] = $locations;
		}

		return $fields;
	}


	/**
	 * Generates the HTML for import products button.
	 *
	 * @param string $id form id.
	 * @param array  $field form fields.
	 */
	public function generate_import_products_html( $id, $field ) {

		ob_start();
		?>
		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $id ); ?>"><?php echo wp_kses_post( $field['title'] ); ?> <?php echo $this->get_tooltip_html( $field ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></label>
			</th>
			<td class="forminp">
				<a href='#' class='button js-import-square-products'>
					<?php echo esc_html__( 'Import all products from Square', 'woocommerce-square' ); ?>
				</a>
			</td>
		</tr>
		<?php

		return ob_get_clean();
	}


	/**
	 * Generates the Connection field HTML.
	 *
	 * @since 2.0.0
	 *
	 * @param string $id field ID.
	 * @param array  $field field data.
	 * @return string
	 */
	public function generate_connect_html( $id, $field ) {

		ob_start();
		?>
		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $id ); ?>"><?php echo wp_kses_post( $field['title'] ); ?> <?php echo $this->get_tooltip_html( $field ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></label>
			</th>
			<td class="forminp">
				<?php
				if ( $this->get_access_token() ) {
					echo $this->get_plugin()->get_connection_handler()->get_disconnect_button_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				} else {
					echo $this->get_plugin()->get_connection_handler()->get_connect_button_html( $this->is_sandbox() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
			</td>
		</tr>
		<?php

		return ob_get_clean();
	}


	/**
	 * Updates the stored refresh token.
	 *
	 * @since 2.0.0
	 *
	 * @param string $token refresh token.
	 */
	public function update_refresh_token( $token ) {

		$refresh_tokens = $this->get_refresh_tokens();
		$environment    = $this->get_environment();

		if ( ! empty( $token ) ) {

			$this->refresh_token = $token;

			if ( Utilities\Encryption_Utility::is_encryption_supported() ) {

				$encryption = new Utilities\Encryption_Utility();

				try {

					$token = $encryption->encrypt_data( $token );

				} catch ( Framework\SV_WC_Plugin_Exception $exception ) {

					// log the event, but don't halt the process.
					$this->get_plugin()->log( 'Could not encrypt refresh token. ' . $exception->getMessage() );
				}
			}

			$refresh_tokens[ $environment ] = $token;
		}

		update_option( 'wc_square_refresh_tokens', $refresh_tokens );
	}


	/**
	 * Updates the stored access token.
	 *
	 * @since 2.0.0
	 *
	 * @param string $token access token.
	 */
	public function update_access_token( $token ) {

		$access_tokens = $this->get_access_tokens();
		$environment   = $this->get_environment();

		if ( ! empty( $token ) ) {

			$this->access_token = $token;

			if ( Utilities\Encryption_Utility::is_encryption_supported() ) {

				$encryption = new Utilities\Encryption_Utility();

				try {

					$token = $encryption->encrypt_data( $token );

				} catch ( Framework\SV_WC_Plugin_Exception $exception ) {

					// log the event, but don't halt the process.
					$this->get_plugin()->log( 'Could not encrypt access token. ' . $exception->getMessage() );
				}
			}

			$access_tokens[ $environment ] = $token;
		} elseif ( isset( $access_tokens[ $environment ] ) ) {

			unset( $access_tokens[ $environment ] );
		}

		update_option( 'wc_square_access_tokens', $access_tokens );
	}


	/**
	 * Clears any stored refresh tokens.
	 *
	 * @since 2.0.0
	 */
	public function clear_refresh_tokens() {
		delete_option( 'wc_square_refresh_tokens' );
	}


	/**
	 * Clears any stored access tokens.
	 *
	 * @since 2.0.0
	 */
	public function clear_access_tokens() {

		delete_option( 'wc_square_access_tokens' );
	}


	/**
	 * Clears the location ID from the settings.
	 *
	 * This is helpful on disconnect / revoke so that previously set location IDs don't stick around and cause confusion.
	 *
	 * @since 2.0.0
	 */
	public function clear_location_id() {

		$settings = get_option( $this->get_option_key(), array() );

		$settings[ $this->get_environment() . '_location_id' ] = '';

		update_option( $this->get_option_key(), $settings );
	}


	/** Conditional methods *******************************************************************************************/


	/**
	 * Determines if WooCommerce is configured to be the system of record.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function is_system_of_record_woocommerce() {

		return self::SYSTEM_OF_RECORD_WOOCOMMERCE === $this->get_system_of_record();
	}


	/**
	 * Determines if Square is configured to be the system of record.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function is_system_of_record_square() {

		return self::SYSTEM_OF_RECORD_SQUARE === $this->get_system_of_record();
	}


	/**
	 * Determines if there is no system of record.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function is_system_of_record_disabled() {

		$sor = $this->get_system_of_record();

		return empty( $sor ) || self::SYSTEM_OF_RECORD_DISABLED === $sor;
	}


	/**
	 * Determines if inventory sync is enabled.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function is_inventory_sync_enabled() {

		return (bool) apply_filters( 'wc_square_inventory_sync_enabled', 'yes' === get_option( 'woocommerce_manage_stock' ) && $this->is_product_sync_enabled() && 'yes' === $this->get_option( 'enable_inventory_sync' ) );
	}


	/**
	 * Determines if product sync is enabled.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function is_product_sync_enabled() {

		return ! $this->is_system_of_record_disabled();
	}


	/**
	 * Determines whether to hide products that don't exist in square from the catalog.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function hide_missing_square_products() {

		return 'yes' === $this->get_option( 'hide_missing_products' );
	}


	/**
	 * Determines if the plugin settings are fully configured.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function is_configured() {

		return $this->get_location_id() && $this->get_system_of_record();
	}


	/**
	 * Determines if the plugin is connected to Square.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function is_connected() {

		return (bool) $this->get_access_token();
	}


	/**
	 * Determines if configured in the sandbox environment.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function is_sandbox() {

		return 'sandbox' === $this->get_environment();
	}


	/**
	 * Determines if debug logging is enabled.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function is_debug_enabled() {

		return 'yes' === $this->get_option( 'debug_logging_enabled' );
	}


	/** Getter methods ************************************************************************************************/


	/**
	 * Gets the configured location.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_location_id() {
		$location_id = $this->get_option( $this->get_environment() . '_location_id' );

		if ( empty( $location_id ) ) {
			$square_db_version = get_option( $this->get_plugin()->get_plugin_version_name() );

			// if the Square DB version is still pre-2.2.0, fetch the location ID using the previous option name
			if ( ! empty( $square_db_version ) && version_compare( $square_db_version, '2.2.0', '<' ) ) {
				$location_id = $this->get_option( 'location_id' );
			}
		}

		return $location_id;
	}


	/**
	 * Gets the available locations.
	 *
	 * @since 2.0.0
	 *
	 * @return \SquareConnect\Model\Location[]
	 */
	public function get_locations() {

		if ( is_array( $this->locations ) ) {

			return $this->locations;
		}

		// don't always need to refetch when not on Settings screen.
		if ( ! $this->is_admin_settings_screen() ) {

			$this->locations = get_transient( 'wc_square_locations' );
		}

		if ( ! is_array( $this->locations ) && did_action( 'wc_square_initialized' ) ) {

			$this->locations = array();

			try {

				// cache the locations returned so they can be used elsewhere.
				$this->locations = $this->get_plugin()->get_api( $this->get_access_token(), $this->is_sandbox() )->get_locations();
				set_transient( 'wc_square_locations', $this->locations, HOUR_IN_SECONDS );

				// check the returned IDs against what's currently configured.
				$stored_location_id = $this->get_location_id();
				$found              = ! $stored_location_id;

				foreach ( $this->locations as $location ) {

					if ( $stored_location_id && $location->getId() === $stored_location_id ) {
						$found = true;
						break;
					}
				}

				// if the currently set location ID is not present in the connected account's available locations, clear it locally.
				if ( ! $found ) {
					$this->clear_location_id();
				}
			} catch ( Framework\SV_WC_Plugin_Exception $exception ) {

				$this->get_plugin()->log( 'Could not retrieve business locations.' );
			}
		}

		return $this->locations;
	}


	/**
	 * Gets the configured system of record.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_system_of_record() {

		return $this->get_option( 'system_of_record' );
	}


	/**
	 * Gets the configured system of record name.
	 *
	 * @since 2.0.0
	 *
	 * @return string or empty string if no system of record is configured
	 */
	public function get_system_of_record_name() {

		switch ( $this->get_system_of_record() ) {

			case 'square':
				$sor = __( 'Square', 'woocommerce-square' );
				break;
			case 'woocommerce':
				$sor = __( 'WooCommerce', 'woocommerce-square' );
				break;
			default:
				$sor = '';
				break;
		}

		return $sor;
	}

	/**
	 * Gets the refresh token.
	 *
	 * @since 2.0.0
	 *
	 * @return string|null
	 */
	public function get_refresh_token() {

		if ( empty( $this->refresh_token ) ) {

			$tokens = $this->get_refresh_tokens();
			$token  = null;

			if ( ! empty( $tokens[ $this->get_environment() ] ) ) {
				$token = $tokens[ $this->get_environment() ];
			}

			if ( $token && Utilities\Encryption_Utility::is_encryption_supported() ) {

				$encryption = new Utilities\Encryption_Utility();

				try {

					$token = $encryption->decrypt_data( $token );

				} catch ( Framework\SV_WC_Plugin_Exception $exception ) {

					// log the event, but don't halt the process.
					$this->get_plugin()->log( 'Could not decrypt refresh token. ' . $exception->getMessage() );
				}
			}

			$this->refresh_token = $token;
		}

		/**
		 * Filters the configured refresh token.
		 *
		 * @since 2.0.0
		 *
		 * @param string $refresh_token
		 */
		return apply_filters( 'wc_square_refresh_token', $this->refresh_token );
	}

	/**
	 * Gets the access token.
	 *
	 * @since 2.0.0
	 *
	 * @return string|null
	 */
	public function get_access_token() {

		if ( empty( $this->access_token ) || $this->is_admin_settings_screen() ) {

			$tokens = $this->get_access_tokens();
			$token  = null;

			if ( ! empty( $tokens[ $this->get_environment() ] ) ) {
				$token = $tokens[ $this->get_environment() ];
			}

			if ( $token && Utilities\Encryption_Utility::is_encryption_supported() ) {

				$encryption = new Utilities\Encryption_Utility();

				try {

					$token = $encryption->decrypt_data( $token );

				} catch ( Framework\SV_WC_Plugin_Exception $exception ) {

					// log the event, but don't halt the process.
					$this->get_plugin()->log( 'Could not decrypt access token. ' . $exception->getMessage() );
				}
			}

			$this->access_token = $token;
		}

		/**
		 * Filters the configured access token.
		 *
		 * @since 2.0.0
		 *
		 * @param string $access_token access token
		 */
		return apply_filters( 'wc_square_access_token', $this->access_token );
	}


	/**
	 * Gets the stored access tokens.
	 *
	 * Each environment may have its own token.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	public function get_access_tokens() {
		return (array) get_option( 'wc_square_access_tokens', array() );
	}


	/**
	 * Gets the stored refresh tokens.
	 *
	 * Each environment may have its own token.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	public function get_refresh_tokens() {
		return (array) get_option( 'wc_square_refresh_tokens', array() );
	}

	/**
	 * Gets setting enabled sandbox.
	 *
	 * @since 2.1.2
	 *
	 * @return string
	 */
	public function get_enable_sandbox() {
		return $this->get_option( 'enable_sandbox' );
	}

	/**
	 * Tells is if the setting for enabling sandbox is checked.
	 *
	 * @since 2.1.2
	 *
	 * @return boolean
	 */
	public function is_sandbox_setting_enabled() {
		return 'yes' === $this->get_enable_sandbox();
	}


	/**
	 * Gets the configured environment.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_environment() {
		$sanboxed = ( defined( 'WC_SQUARE_SANDBOX' ) && WC_SQUARE_SANDBOX ) || $this->is_sandbox_setting_enabled();
		return $sanboxed ? 'sandbox' : 'production';
	}


	/**
	 * Gets the plugin instance.
	 *
	 * @since 2.0.0
	 *
	 * @return Plugin
	 */
	public function get_plugin() {

		return $this->plugin;
	}

	/**
	 * Determines if the current request is for the Square admin settings screen.
	 *
	 * @since 2.1.5
	 * @return bool True if the current request is for the Square admin settings, otherwise false.
	 */
	public function is_admin_settings_screen() {
		return isset( $_GET['page'], $_GET['tab'] ) && 'wc-settings' === $_GET['page'] && Plugin::PLUGIN_ID === $_GET['tab']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	}
}
