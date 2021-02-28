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

namespace WooCommerce\Square\Gateway;

defined( 'ABSPATH' ) || exit;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;

class Card_Handler extends Framework\SV_WC_Payment_Gateway_Payment_Tokens_Handler {


	/**
	 * Tokenizes the current payment method and adds the standard transaction
	 * data to the order post record.
	 *
	 * @since 2.1.0
	 *
	 * @param \WC_Order $order order object
	 * @param Framework\SV_WC_Payment_Gateway_API_Create_Payment_Token_Response|null $response payment token API response, or null if the request should be made
	 * @param string $environment_id optional environment ID, defaults to the current environment
	 * @return \WC_Order order object
	 * @throws Framework\SV_WC_Plugin_Exception on transaction failure
	 */
	public function create_token( \WC_Order $order, $response = null, $environment_id = null ) {

		$order = parent::create_token( $order, $response, $environment_id );

		// remove the verification token that was used to store the card so it's not also sent in the payment request
		$order->payment->verification_token = null;

		return $order;
	}


	/**
	 * Determines if a token should be deleted locally after a failed API attempt.
	 *
	 * Checks the response code, and if Square indicates the card ID was not found then it's probably safe to delete.
	 *
	 * @since 2.0.0
	 *
	 * @param Framework\SV_WC_Payment_Gateway_Payment_Token $token
	 * @param Framework\SV_WC_Payment_Gateway_API_Response $response
	 * @return bool
	 */
	public function should_delete_token( Framework\SV_WC_Payment_Gateway_Payment_Token $token, Framework\SV_WC_Payment_Gateway_API_Response $response ) {

		return 'NOT_FOUND' === $response->get_status_code();
	}

	/**
	 * Gets the available payment tokens for a user as an associative array of
	 * payment token to SV_WC_Payment_Gateway_Payment_Token
	 *
	 * @since 2.2.0
	 * @param int $user_id WordPress user identifier, or 0 for guest
	 * @param array $args optional arguments, can include
	 *    `customer_id` - if not provided, this will be looked up based on $user_id
	 *    `environment_id` - defaults to plugin current environment
	 * @return array array of string token to SV_WC_Payment_Gateway_Payment_Token object
	 */
	public function get_tokens( $user_id, $args = array() ) {
		// default to current environment
		if ( ! isset( $args['environment_id'] ) ) {
			$args['environment_id'] = $this->get_environment_id();
		}

		if ( ! isset( $args['customer_id'] ) ) {
			$args['customer_id'] = $this->get_gateway()->get_customer_id( $user_id, array( 'environment_id' => $args['environment_id'] ) );
		}

		$environment_id = $args['environment_id'];
		$customer_id    = $args['customer_id'];
		$transient_key  = $this->get_transient_key( $user_id );

		// return tokens cached during a single request
		if ( isset( $this->tokens[ $environment_id ][ $user_id ] ) ) {
			return $this->tokens[ $environment_id ][ $user_id ];
		}

		// return tokens cached in transient
		if ( $transient_key ) {
			$this->tokens[ $environment_id ][ $user_id ] = get_transient( $transient_key );

			if ( false !== $this->tokens[ $environment_id ][ $user_id ] ) {
				return $this->tokens[ $environment_id ][ $user_id ];
			}
		}

		$this->tokens[ $environment_id ][ $user_id ] = array();
		$tokens                                      = array();

		// retrieve the datastore persisted tokens first, so we have them for
		// gateways that don't support fetching them over an API, as well as the
		// default token for those that do
		if ( $user_id ) {
			$_tokens = get_user_meta( $user_id, $this->get_user_meta_name( $environment_id ), true );

			// from database format
			if ( is_array( $_tokens ) ) {
				foreach ( $_tokens as $token => $data ) {
					$tokens[ $token ] = $this->build_token( $token, $data );
				}
			}

			$this->tokens[ $environment_id ][ $user_id ] = $tokens;
		}

		if ( $customer_id ) {
			try {
				// retrieve the payment method tokes from the remote API
				$response = $this->get_gateway()->get_api()->get_tokenized_payment_methods( $customer_id );

				// Only update local tokens when the response has no errors or the customer is not found in Square
				if ( ! $response->has_errors() || 'NOT_FOUND' === $response->get_status_code() ) {
					$this->tokens[ $environment_id ][ $user_id ] = $response->get_payment_tokens();

					// check for a default from the persisted set, if any
					$default_token = null;
					foreach ( $tokens as $default_token ) {
						if ( $default_token->is_default() ) {
							break;
						}
					}

					// mark the corresponding token from the API as the default one
					if ( $default_token && $default_token->is_default() && isset( $this->tokens[ $environment_id ][ $user_id ][ $default_token->get_id() ] ) ) {
						$this->tokens[ $environment_id ][ $user_id ][ $default_token->get_id() ]->set_default( true );
					}

					// merge local token data with remote data, sometimes local data is more robust
					$this->tokens[ $environment_id ][ $user_id ] = $this->merge_token_data( $tokens, $this->tokens[ $environment_id ][ $user_id ] );

					// persist locally after merging
					$this->update_tokens( $user_id, $this->tokens[ $environment_id ][ $user_id ], $environment_id );
				}
			} catch ( Framework\SV_WC_Plugin_Exception $e ) {

				// communication or other error
				$this->get_gateway()->add_debug_message( $e->getMessage(), 'error' );

				$this->tokens[ $environment_id ][ $user_id ] = $tokens;
			}
		}

		// set the payment type image url, if any, for convenience
		foreach ( $this->tokens[ $environment_id ][ $user_id ] as $key => $token ) {
			$this->tokens[ $environment_id ][ $user_id ][ $key ]->set_image_url( $this->get_gateway()->get_payment_method_image_url( $token->is_credit_card() ? $token->get_card_type() : 'echeck' ) );
		}

		if ( $transient_key ) {
			set_transient( $transient_key, $this->tokens[ $environment_id ][ $user_id ], HOUR_IN_SECONDS );
		}

		do_action( 'wc_payment_gateway_square_credit_card_payment_tokens_loaded', $this->tokens[ $environment_id ][ $user_id ], $this );

		return $this->tokens[ $environment_id ][ $user_id ];
	}


}
