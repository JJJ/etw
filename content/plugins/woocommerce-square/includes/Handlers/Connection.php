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

defined( 'ABSPATH' ) || exit;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;
use SquareConnect\Model\ListCustomersResponse;
use WooCommerce\Square;

/**
 * The admin connection handler.
 *
 * @since 2.0.0
 */
class Connection {


	/** @var string production connect URL */
	const CONNECT_URL_PRODUCTION = 'https://connect.woocommerce.com/login/square';

	/** @var string sandbox connect URL */
	const CONNECT_URL_SANDBOX = 'https://connect.woocommerce.com/login/squaresandbox';

	/** @var string production refresh URL */
	const REFRESH_URL_PRODUCTION = 'https://connect.woocommerce.com/renew/square';

	/** @var string sandbox refresh URL */
	const REFRESH_URL_SANDBOX = 'https://connect.woocommerce.com/renew/squaresandbox';

	/** @var Square\Plugin plugin instance */
	protected $plugin;


	/**
	 * Constructs the class.
	 *
	 * @since 2.0.0
	 *
	 * @param Square\Plugin $plugin plugin instance
	 */
	public function __construct( Square\Plugin $plugin ) {

		$this->plugin = $plugin;

		$this->add_hooks();
	}


	/**
	 * Adds the action and filter hooks.
	 *
	 * @since 2.0.0
	 */
	protected function add_hooks() {

		add_action( 'admin_action_wc_' . $this->get_plugin()->get_id() . '_connected', array( $this, 'handle_connected' ) );

		add_action( 'admin_action_wc_' . $this->get_plugin()->get_id() . '_disconnect', array( $this, 'handle_disconnect' ) );

		// refresh the connection, triggered by Action Scheduler
		add_action( 'wc_' . $this->get_plugin()->get_id() . '_refresh_connection', array( $this, 'refresh_connection' ) );

		// index customers, triggered by Action Scheduler
		add_action( 'wc_' . $this->get_plugin()->get_id() . '_index_customers', array( $this, 'index_customers' ) );
	}


	/**
	 * Handles a successful connection.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function handle_connected() {

		$nonce = isset( $_GET['_wpnonce'] ) ? wc_clean( $_GET['_wpnonce'] ) : '';

		// check the user role & nonce
		if ( ! current_user_can( 'manage_woocommerce' ) || ! wp_verify_nonce( $nonce, 'wc_' . $this->get_plugin()->get_id() . '_connected' ) ) {
			wp_die( __( 'Sorry, you do not have permission to manage the Square connection.', 'woocommerce-square' ) );
		}

		$access_token = ! empty( $_GET['square_access_token'] ) ? sanitize_text_field( urldecode( $_GET['square_access_token'] ) ) : '';

		if ( empty( $access_token ) ) {
			$this->get_plugin()->log( 'Error: No access token was received.' );
			add_action(
				'admin_notices',
				function () {
					?>
						<div class="notice notice-error is-dismissible">
							<p><?php _e( 'Square Error: We could not connect to Square. No access token was given.!', 'woocommerce-square' ); ?></p>
						</div>
					<?php
				}
			);
			return;
		}

		$this->get_plugin()->get_settings_handler()->update_access_token( $access_token );
		$this->get_plugin()->log( 'Access token successfully received.' );

		$refresh_token = ! empty( $_GET['square_refresh_token'] ) ? sanitize_text_field( urldecode( $_GET['square_refresh_token'] ) ) : '';
		if ( empty( $refresh_token ) ) {
			$this->get_plugin()->log( 'Failed to receive refresh token from connect server.' );
		} else {
			$this->get_plugin()->get_settings_handler()->update_refresh_token( $refresh_token );
			$this->get_plugin()->log( 'Refresh token successfully received.' );
		}

		$this->schedule_refresh();
		$this->schedule_customer_index();

		// on connect after upgrading to v2.0 from v1.0, initiate a catalog sync to refresh the Square item IDs
		if ( get_option( 'wc_square_updated_to_2_0_0' ) ) {

			// delete any old access token from v1, as it will be invalidated
			delete_option( 'woocommerce_square_merchant_access_token' );

			if ( $this->get_plugin()->get_settings_handler()->is_system_of_record_square() ) {
				$this->get_plugin()->get_sync_handler()->start_manual_sync();
			}
		}

		delete_option( 'wc_square_updated_to_2_0_0' );

		wp_safe_redirect( $this->get_plugin()->get_settings_url() );
		exit;
	}


	/**
	 * Handles disconnection.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function handle_disconnect() {

		// remove the refresh fail flag if previously set
		delete_option( 'wc_' . $this->get_plugin()->get_id() . '_refresh_failed' );

		$nonce = isset( $_GET['_wpnonce'] ) ? wc_clean( $_GET['_wpnonce'] ) : '';

		// check the user role & nonce
		if ( ! current_user_can( 'manage_woocommerce' ) || ! wp_verify_nonce( $nonce, 'wc_' . $this->get_plugin()->get_id() . '_disconnect' ) ) {
			wp_die( __( 'Sorry, you do not have permission to manage the Square connection.', 'woocommerce-square' ) );
		}

		// disconnect by clearing tokens, unscheduling syncs, etc...
		$this->disconnect();

		$this->get_plugin()->log( 'Manually disconnected' );

		$this->get_plugin()->get_message_handler()->add_message( __( 'Disconnected successfully', 'woocommerce-square' ) );

		wp_safe_redirect( $this->get_plugin()->get_settings_url() );
		exit;
	}


	/**
	 * Disconnects the plugin.
	 *
	 * @since 2.0.0
	 */
	public function disconnect() {

		// don't try to refresh anymore
		$this->unschedule_refresh();

		// unschedule the interval sync
		$this->get_plugin()->get_sync_handler()->unschedule_sync();

		// fully clear the access token
		$this->get_plugin()->get_settings_handler()->clear_access_tokens();
		$this->get_plugin()->get_settings_handler()->clear_refresh_tokens();

		// clear all background jobs so further API requests aren't attempted
		$this->get_plugin()->get_background_job_handler()->clear_all_jobs();
	}


	/** Refresh methods ***********************************************************************************************/


	/**
	 * Schedules the connection refresh.
	 *
	 * @since 2.0.0
	 */
	public function schedule_refresh() {

		if ( ! $this->get_plugin()->get_settings_handler()->is_connected() ) {
			return;
		}

		/**
		 * Filters the frequency with which the OAuth connection should be refreshed.
		 *
		 * @since 2.0.0
		 *
		 * @param int $interval refresh interval
		 */
		$interval = apply_filters( 'wc_' . $this->get_plugin()->get_id() . '_connection_refresh_interval', WEEK_IN_SECONDS );

		// Make sure that all refresh actions are cancelled before scheduling it.
		$this->unschedule_refresh();

		as_schedule_single_action( time() + $interval, 'wc_' . $this->get_plugin()->get_id() . '_refresh_connection', array(), $this->get_plugin()->get_id() );
	}


	/**
	 * Refreshes the access token via the Woo proxy.
	 *
	 * @since 2.0.0
	 */
	public function refresh_connection() {
		if ( $this->get_plugin()->get_settings_handler()->is_sandbox() ) {
			return;
		}

		try {

			if ( $this->get_plugin()->get_settings_handler()->is_debug_enabled() ) {
				$this->get_plugin()->log( 'Refreshing connection...' );
			}

			$refresh_token = $this->get_plugin()->get_settings_handler()->get_refresh_token();

			if ( ! $refresh_token ) {
				$this->get_plugin()->log( 'No refresh token stored, cannot refresh connection.' );
				update_option( 'wc_' . $this->get_plugin()->get_id() . '_refresh_failed', 'yes' );
				wc_square()->get_email_handler()->get_access_token_email()->trigger();
				return;
			}

			$request = array(
				'body'    => array(
					'token' => $this->get_plugin()->get_settings_handler()->get_refresh_token(),
				),
				'timeout' => 45,
			);

			// make the request
			$response = wp_remote_post( $this->get_refresh_url(), $request );

			// handle HTTP errors
			if ( is_wp_error( $response ) ) {
				throw new Framework\SV_WC_Plugin_Exception( $response->get_error_message() );
			}

			$response = new Square\API\Responses\Connection_Refresh_Response( wp_remote_retrieve_body( $response ) );

			// check for errors in the response
			if ( $response->has_error() ) {
				throw new Framework\SV_WC_Plugin_Exception( $response->get_error_message() );
			}

			// ensure an access token, just in case
			if ( ! $response->get_token() ) {
				throw new Framework\SV_WC_Plugin_Exception( 'Access token missing from the response' );
			}

			// store the new token
			$this->get_plugin()->get_settings_handler()->update_access_token( $response->get_token() );

			// In case square updates the refresh token.
			if ( $response->get_refresh_token() ) {
				$this->get_plugin()->get_settings_handler()->update_refresh_token( $response->get_refresh_token() );
				$this->get_plugin()->log( 'Connection successfully refreshed.' );
			}

			// in case this option was set
			delete_option( 'wc_' . $this->get_plugin()->get_id() . '_refresh_failed' );
		} catch ( Framework\SV_WC_Plugin_Exception $exception ) {

			$this->get_plugin()->log( 'Unable to refresh connection: ' . $exception->getMessage() );

			update_option( 'wc_' . $this->get_plugin()->get_id() . '_refresh_failed', 'yes' );

			wc_square()->get_email_handler()->get_access_token_email()->trigger();
		}

		$this->schedule_refresh();
	}


	/**
	 * Unschedules the connection refresh.
	 *
	 * @since 2.0.0
	 */
	protected function unschedule_refresh() {
		as_unschedule_all_actions( 'wc_' . $this->get_plugin()->get_id() . '_refresh_connection', array(), $this->get_plugin()->get_id() );
	}


	/** Customer index methods ****************************************************************************************/


	/**
	 * Index existing Square customers.
	 *
	 * @since 2.0.0
	 *
	 * @param string $cursor pagination cursor
	 */
	public function index_customers( $cursor = '' ) {

		try {

			$response = $this->get_plugin()->get_api()->get_customers( $cursor );

			if ( $response->get_data() instanceof ListCustomersResponse && is_array( $response->get_data()->getCustomers() ) ) {

				Square\Gateway\Customer_Helper::add_customers( $response->get_data()->getCustomers() );

				// if there are more customers to query, schedule a followup action to index the next batch of customers
				if ( $response->get_data()->getCursor() ) {
					$this->schedule_customer_index( $response->get_data()->getCursor() );
				}
			}
		} catch ( Framework\SV_WC_Plugin_Exception $exception ) {

		}
	}


	/**
	 * Schedules the customer index action.
	 *
	 * @since 2.0.0
	 *
	 * @param string $cursor pagination cursor
	 */
	protected function schedule_customer_index( $cursor = '' ) {

		if ( false === as_next_scheduled_action( 'wc_' . $this->get_plugin()->get_id() . '_index_customers', array( $cursor ), $this->get_plugin()->get_id() ) ) {
			as_schedule_single_action( time(), 'wc_' . $this->get_plugin()->get_id() . '_index_customers', array( $cursor ), $this->get_plugin()->get_id() );
		}
	}


	/** Getter methods ************************************************************************************************/


	/**
	 * Gets the Connect button HTML.
	 *
	 * @since 2.0.0
	 *
	 * @param bool $is_sandbox whether to point the button to production or sandbox
	 * @return string
	 */
	public function get_connect_button_html( $is_sandbox = false ) {

		ob_start();
		?>
		<a href="<?php echo esc_url( $this->get_connect_url( $is_sandbox ) ); ?>" class="button-primary">
			<?php esc_html_e( 'Connect with Square', 'woocommerce-square' ); ?>
		</a>
		<?php

		return ob_get_clean();
	}


	/**
	 * Gets the disconnect button HTML.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_disconnect_button_html() {

		ob_start();
		?>
		<a href="<?php echo esc_url( $this->get_disconnect_url() ); ?>" class='button-primary'>
			<?php echo esc_html__( 'Disconnect from Square', 'woocommerce-square' ); ?>
		</a>
		<?php

		return ob_get_clean();
	}


	/**
	 * Gets the connection URL.
	 *
	 * @since 2.0.0
	 *
	 * @param bool $is_sandbox whether to point to production or sandbox
	 * @return string
	 */
	public function get_connect_url( $is_sandbox = false ) {

		if ( $is_sandbox ) {
			$raw_url = self::CONNECT_URL_SANDBOX;
		} else {
			$raw_url = self::CONNECT_URL_PRODUCTION;
		}

		/**
		 * Filters the connection URL.
		 *
		 * @since 2.0.0
		 *
		 * @param string $raw_url API URL
		 */
		$url = (string) apply_filters( 'wc_' . $this->get_plugin()->get_id() . '_api_url', $raw_url );

		$action       = 'wc_' . $this->get_plugin()->get_id() . '_connected';
		$redirect_url = wp_nonce_url( add_query_arg( 'action', $action, admin_url() ), $action );

		$args = array(
			'redirect' => urlencode( urlencode( $redirect_url ) ),
			'scopes'   => implode( ',', $this->get_scopes() ),
		);

		return add_query_arg( $args, $url );
	}


	/**
	 * Gets the disconnect URL.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	protected function get_disconnect_url() {

		$action = 'wc_' . $this->get_plugin()->get_id() . '_disconnect';
		$url    = add_query_arg( 'action', $action, admin_url() );

		return wp_nonce_url( $url, $action );
	}


	/**
	 * Gets the token refresh URL.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	protected function get_refresh_url() {

		return $this->get_plugin()->get_settings_handler()->is_sandbox() ? self::REFRESH_URL_SANDBOX : self::REFRESH_URL_PRODUCTION;
	}

	/**
	 * Gets the connection scopes.
	 *
	 * @since 2.0.0
	 *
	 * @return string[]
	 */
	protected function get_scopes() {

		$scopes = array(
			'MERCHANT_PROFILE_READ',
			'PAYMENTS_READ',
			'PAYMENTS_WRITE',
			'ORDERS_READ',
			'ORDERS_WRITE',
			'CUSTOMERS_READ',
			'CUSTOMERS_WRITE',
			'SETTLEMENTS_READ',
			'ITEMS_READ',
			'ITEMS_WRITE',
			'INVENTORY_READ',
			'INVENTORY_WRITE',
		);

		return (array) apply_filters( 'wc_' . $this->get_plugin()->get_id() . '_connection_scopes', $scopes );
	}


	/**
	 * Gets the plugin instance.
	 *
	 * @since 2.0.0
	 *
	 * @return Square\Plugin
	 */
	public function get_plugin() {

		return $this->plugin;
	}


}
