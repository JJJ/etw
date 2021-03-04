<?php
namespace AIOSEO\Plugin\Common\Api;

use AIOSEO\Plugin\Common\Integrations\Semrush;

/**
 * Route class for the API.
 *
 * @since 4.0.16
 */
class Integrations {
	/**
	 * Fetches the additional keyphrases.
	 *
	 * @since 4.0.16
	 *
	 * @param  \WP_REST_Request  $request The REST Request
	 * @return \WP_REST_Response          The response.
	 */
	public static function semrushGetKeyphrases( $request ) {
		$body       = $request->get_json_params();
		$keyphrases = Semrush::getKeyphrases( $body['keyphrase'], $body['database'] );

		return new \WP_REST_Response( [
			'success'    => true,
			'keyphrases' => $keyphrases
		], 200 );
	}

	/**
	 * Authenticates with Semrush.
	 *
	 * @since 4.0.16
	 *
	 * @param  \WP_REST_Request  $request The REST Request
	 * @return \WP_REST_Response          The response.
	 */
	public static function semrushAuthenticate( $request ) {
		$body = $request->get_json_params();

		Semrush::authenticate( $body['code'] );

		return new \WP_REST_Response( [
			'success' => true,
			'semrush' => aioseo()->internalOptions->integrations->semrush->all()
		], 200 );
	}

	/**
	 * Refreshes the API tokens.
	 *
	 * @since 4.0.16
	 *
	 * @param  \WP_REST_Request  $request The REST Request
	 * @return \WP_REST_Response          The response.
	 */
	public static function semrushRefresh() {
		Semrush::refreshTokens();

		return new \WP_REST_Response( [
			'success' => true,
			'semrush' => aioseo()->internalOptions->integrations->semrush->all()
		], 200 );
	}
}