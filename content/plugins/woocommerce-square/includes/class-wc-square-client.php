<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class WC_Square_Client
 *
 * Makes actual HTTP requests to the Square API.
 * Handles:
 * - Authentication
 * - Endpoint selection (API version, Merchant ID in path)
 * - Request retries
 * - Paginated results
 * - Content-Type negotiation (JSON)
 */
class WC_Square_Client {

	/**
	 * @var
	 */
	protected $access_token;

	/**
	 * @var
	 */
	protected $merchant_id;

	/**
	 * @var string
	 */
	protected $api_version = 'v1';

	/**
	 * @return mixed
	 */
	public function get_access_token() {

		return $this->access_token;

	}

	/**
	 * @param $token
	 */
	public function set_access_token( $token ) {

		$this->access_token = $token;

	}

	/**
	 * @return mixed
	 */
	public function get_merchant_id() {

		return $this->merchant_id;

	}

	/**
	 * @param $merchant_id
	 */
	public function set_merchant_id( $merchant_id ) {

		$this->merchant_id = $merchant_id;

	}

	/**
	 * @return string
	 */
	public function get_api_version() {

		return $this->api_version;

	}

	/**
	 * @param $version
	 */
	public function set_api_version( $version ) {

		$this->api_version = $version;

	}

	/**
	 * @return int|mixed|void
	 */
	public function get_api_url_base() {
		if ( WC_SQUARE_ENABLE_STAGING ) {
			return apply_filters( 'woocommerce_square_api_url',  'https://connect.squareupstaging.com/' );
		}

		return apply_filters( 'woocommerce_square_api_url', 'https://connect.squareup.com/' );
	}

	/**
	 * @return string
	 */
	public function get_api_url() {

		$url  = trailingslashit( $this->get_api_url_base() );
		$url .= trailingslashit( $this->get_api_version() );

		return $url;

	}

	/**
	 * Initializes the header arguments.
	 *
	 * @since 1.0.0
	 * @version 1.0.14
	 * @return int|mixed|void
	 */
	public function get_request_args() {

		$args = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . sanitize_text_field( $this->get_access_token() ),
				'Accept'        => 'application/json',
				'Content-Type'  => 'application/json',
			),
			'user-agent'  => 'WooCommerceSquare/' . WC_SQUARE_VERSION . '; ' . get_bloginfo( 'url' ),
			'timeout'     => 45,
			'httpversion' => '1.1',
		);

		return apply_filters( 'woocommerce_square_request_args', $args );
	}

	/**
	 * @param $path
	 *
	 * @return string
	 */
	protected function get_request_url( $path ) {

		$api_url_base = trailingslashit( $this->get_api_url() );
		$merchant_id  = '';

		// Add merchant ID to the request URL if we aren't hitting /me/*
		if ( strpos( trim( $path, '/' ), 'me' ) !== 0 ) {

			$merchant_id = trailingslashit( $this->get_merchant_id() );

		}

		$request_path = ltrim( $path, '/' );
		$request_url  = trailingslashit( $api_url_base . $merchant_id . $request_path );

		return $request_url;

	}

	/**
	 * Gets the number of retries per request
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @param int $count
	 * @return int
	 */
	public function request_retries( $count = 5 ) {

		return apply_filters( 'woocommerce_square_request_retries', $count );

	}

	/**
	 * Wrapper around http_request() that handles pagination for List endpoints.
	 *
	 * @since 1.0.25 Switch to use WP native remote requests.
	 * @param string $debug_label Description of the request, for logging.
	 * @param string $path        API endpoint path to hit. E.g. /items/
	 * @param string $method      HTTP method to use. Defaults to 'GET'.
	 * @param mixed  $body        Optional. Request payload - will be JSON encoded if non-scalar.
	 *
	 * @return bool|object|WP_Error
	 */
	public function request( $debug_label, $path, $method = 'GET', $body = null ) {
		// we need to check for cURL
		if ( ! function_exists( 'curl_init' ) ) {
			WC_Square_Sync_Logger::log( 'cURL is not available. Sync aborted. Please contact your host to install cURL.' );

			return false;
		}

		// The access token is required for all requests
		$access_token = $this->get_access_token();

		if ( empty( $access_token ) ) {

			return false;

		}

		$request_url = $this->get_request_url( $path );
		$return_data = array();
		$page_label  = '';
		$page_count  = 1;

		while ( true ) {

			$response = $this->http_request( $debug_label . $page_label, $request_url, $method, $body );

			if ( ! $response ) {

				return $response;

			}

			$response_data = json_decode( wp_remote_retrieve_body( $response ) );

			// A paged list result will be an array, so let's merge if we're already returning an array
			if ( ( 'GET' === $method ) && is_array( $return_data ) && is_array( $response_data ) ) {

				$return_data = array_merge( $return_data, $response_data );

			} else {

				$return_data = $response_data;

			}

			$link_header = wp_remote_retrieve_header( $response, 'Link' );

			// Look for the next page, if specified
			if ( ! preg_match( '/<(.+)>;rel=("|\')next("|\')/i', $link_header ) ) {
				return $return_data;
			}

			$rel_link_matches = array();

			// Set up the next page URL for the following loop
			if ( ( 'GET' === $method ) && preg_match( '/<(.+)>;rel=("|\')next("|\')/i', $link_header, $rel_link_matches ) ) {

				// Check if we're at the end of pagination.
				if ( $request_url === $rel_link_matches[1] ) {
					return $return_data;
				}

				$request_url = $rel_link_matches[1];
				$body        = null;
				$page_count++;
				$page_label  = sprintf( ' - Fetching page %d', $page_count );

			} else {

				return $return_data;

			}
		}
	}

	/**
	 * Helper method to make HTTP requests to the Square API, with retries.
	 *
	 * @since 1.0.25 Switch to use WP native remote requests.
	 * @param string $debug_label Description of the request, for logging.
	 * @param string $request_url URL to request.
	 * @param string $method      HTTP method to use. Defaults to 'GET'.
	 * @param mixed  $body        Optional. Request payload - will be JSON encoded if non-scalar.
	 *
	 * @return bool|object|WP_Error
	 */
	private function http_request( $debug_label, $request_url, $method = 'GET', $body = null ) {
		$request_args = $this->get_request_args();

		if ( ! is_null( $body ) ) {
			if ( ! empty( $request_args['headers']['Content-Type'] ) && ( 'application/json' === $request_args['headers']['Content-Type'] ) ) {
				$request_args['body'] = json_encode( $body );
			} else {
				$request_args['body'] = $body;
			}
		}

		$request_args['method'] = $method;

		// Make actual request in a retry loop
		$try_count   = 1;
		$max_retries = $this->request_retries();

		while ( true ) {
			$start_time = current_time( 'timestamp' );
			$response   = wp_remote_request( untrailingslashit( $request_url ), $request_args );
			$end_time   = current_time( 'timestamp' );

			WC_Square_Sync_Logger::log( sprintf( '%s', $debug_label ), $start_time, $end_time );

			$decoded_response = json_decode( wp_remote_retrieve_body( $response ) );

			if ( is_object( $decoded_response ) && ! empty( $decoded_response->type ) ) {
				if ( preg_match( '/bad_request/', $decoded_response->type ) || preg_match( '/not_found/', $decoded_response->type ) ) {
					WC_Square_Sync_Logger::log( sprintf( '%s - %s', $decoded_response->type, $decoded_response->message ), $start_time, $end_time );

					return false;
				}
			}

			// handle expired tokens
			if ( is_object( $decoded_response ) &&
				( ! empty( $decoded_response->type ) && 'oauth.expired' === $decoded_response->type ) ||
				( ! empty( $decoded_response->errors ) && 'ACCESS_TOKEN_EXPIRED' === $decoded_response->errors[0]->code ) ) {

				$oauth_connect_url = 'https://connect.woocommerce.com/renew/square';

				if ( WC_SQUARE_ENABLE_STAGING ) {
					$oauth_connect_url = 'https://connect.woocommerce.com/renew/squaresandbox';
				}

				$args = array(
					'body' => array(
						'token' => $this->access_token,
					),
					'timeout' => 45,
				);

				$start_time     = current_time( 'timestamp' );
				$oauth_response = wp_remote_post( $oauth_connect_url, $args );
				$end_time       = current_time( 'timestamp' );

				$decoded_oauth_response = json_decode( wp_remote_retrieve_body( $oauth_response ) );

				if ( is_wp_error( $oauth_response ) ) {

					WC_Square_Sync_Logger::log( sprintf( 'Renewing expired token error - %s', $parsed_oauth_response['curl_error'] ), $start_time, $end_time );

					return false;

				} elseif ( is_object( $decoded_oauth_response ) && ! empty( $decoded_oauth_response->error ) ) {

					WC_Square_Sync_Logger::log( sprintf( 'Renewing expired token error - %s', $decoded_oauth_response->type ), $start_time, $end_time );

					return false;

				} elseif ( is_object( $decoded_oauth_response ) && ! empty( $decoded_oauth_response->access_token ) ) {
					update_option( 'woocommerce_square_merchant_access_token', sanitize_text_field( urldecode( $decoded_oauth_response->access_token ) ) );

					// let's set the token instance again so settings option is refreshed
					$this->set_access_token( sanitize_text_field( urldecode( $decoded_oauth_response->access_token ) ) );
					$request_args['headers']['Authorization'] = 'Bearer ' . sanitize_text_field( $this->get_access_token() );

					WC_Square_Sync_Logger::log( sprintf( 'Retrying with new refreshed token' ), $start_time, $end_time );

					// start at the beginning again
					continue;
				} else {
					WC_Square_Sync_Logger::log( sprintf( 'Renewing expired token error - Unknown Error' ), $start_time, $end_time );

					return false;
				}
			}

			// handle revoked tokens
			if ( is_object( $decoded_response ) && ! empty( $decoded_response->type ) && 'oauth.revoked' === $decoded_response->type ) {
				WC_Square_Sync_Logger::log( sprintf( 'Token is revoked!' ), $start_time, $end_time );

				return false;
			}

			if ( is_wp_error( $response ) ) {

				WC_Square_Sync_Logger::log( sprintf( '(%s) Try #%d - %s', $debug_label, $try_count, $response->get_error_message() ), $start_time, $end_time );

			} else {

				return $response;

			}

			$try_count++;

			if ( $try_count > $max_retries ) {
				break;
			}

			sleep( 1 );

		}

		return false;

	}
}
