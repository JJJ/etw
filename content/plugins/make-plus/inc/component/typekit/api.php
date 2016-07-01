<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_Typekit_API
 *
 * Client to load kit data from the Typekit API.
 *
 * @since 1.7.0.
 */
class MAKEPLUS_Component_Typekit_API implements MAKEPLUS_Component_Typekit_APIInterface {
	/**
	 * The ID to send to the API.
	 *
	 * @since 1.7.0.
	 *
	 * @var string
	 */
	private $kit_id = '';

	/**
	 * The base URL for the API's kits endpoint.
	 *
	 * @since 1.7.0.
	 *
	 * @var string
	 */
	private $api_base = 'https://typekit.com/api/v1/json/kits';

	/**
	 * Property to store any error messages.
	 *
	 * @since 1.7.0.
	 *
	 * @var string
	 */
	private $error = '';

	/**
	 * MAKEPLUS_Component_Typekit_API constructor.
	 *
	 * @since 1.7.0.
	 *
	 * @param $kit_id
	 */
	public function __construct( $kit_id ) {
		$this->kit_id = $kit_id;
	}

	/**
	 * Send a request to the Typekit API.
	 *
	 * @since 1.7.0.
	 *
	 * @return array|WP_Error
	 */
	private function get_response() {
		return wp_remote_get( $this->api_base . '/' . $this->kit_id . '/published' );
	}

	/**
	 * Validate a response from the Typekit API.
	 *
	 * @since 1.7.0.
	 *
	 * @param WP_HTTP_Requests_Response|array|WP_Error $response
	 *
	 * @return bool
	 */
	private function validate_response( $response ) {
		// Response is a WP_Error object
		if ( is_wp_error( $response ) ) {
			$this->error = implode( ', ', $response->get_error_messages() );
			return false;
		}

		// Response code is not success
		if ( 200 !== $code = (int) wp_remote_retrieve_response_code( $response ) ) {
			switch ( $code ) {
				case 404 :
					$this->error = __( 'Kit not found.', 'make-plus' );
					break;
				default :
					$body = json_decode( wp_remote_retrieve_body( $response ) );
					$this->error = $code . ': ' . implode( ', ', $body->errors );
					break;
			}
			return false;
		}

		// Response body is empty
		if ( ! wp_remote_retrieve_body( $response ) ) {
			$this->error = __( 'No kit data was returned.', 'make-plus' );
			return false;
		}

		// Valid!
		return true;
	}

	/**
	 * Extract the font family data from a Typekit API response.
	 *
	 * @param WP_HTTP_Requests_Response|array $response
	 *
	 * @return array
	 */
	private function parse_response_families( $response ) {
		$body = json_decode( wp_remote_retrieve_body( $response ) );

		if ( is_object( $body ) && isset( $body->kit ) && isset( $body->kit->families ) && is_array( $body->kit->families ) ) {
			return $body->kit->families;
		}

		$this->error = __( 'No font families were returned.', 'make-plus' );

		return array();
	}

	/**
	 * Wrapper function to get font data from the Typekit API.
	 *
	 * @since 1.7.0.
	 *
	 * @return array
	 */
	public function get_kit_fonts() {
		$response = $this->get_response();

		if ( true === $this->validate_response( $response ) ) {
			return $this->parse_response_families( $response );
		}

		return array();
	}

	/**
	 * Getter for the error property.
	 *
	 * @since 1.7.0.
	 *
	 * @return string
	 */
	public function get_error() {
		return $this->error;
	}
}