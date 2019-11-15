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

namespace WooCommerce\Square\API;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;

defined( 'ABSPATH' ) or exit;

/**
 * Base WooCommerce Square API response object.
 *
 * @since 2.0.0
 */
class Response implements Framework\SV_WC_API_Response {


	/** @var mixed raw response data */
	protected $raw_response_data;


	/**
	 * Constructs the response object.
	 *
	 * @since 2.0.0
	 *
	 * @param Object|array $raw_response_data
	 */
	public function __construct( $raw_response_data ) {

		$this->raw_response_data = $raw_response_data;
	}


	/**
	 * Gets the response data.
	 *
	 * @since 2.0.0
	 *
	 * @return Object
	 */
	public function get_data() {

		return $this->raw_response_data ?: null;
	}


	/**
	 * Gets errors returned by the Square API.
	 *
	 * @since 2.0.0
	 *
	 * @return \stdClass[]
	 */
	public function get_errors() {

		return ! empty( $this->raw_response_data->errors ) && is_array( $this->raw_response_data->errors ) ? $this->raw_response_data->errors : [];
	}


	/**
	 * Determines if the API response contains errors.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function has_errors() {

		return ! empty( $this->get_errors() );
	}


	/**
	 * Gets the response data as a string.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function to_string() {

		return is_callable( [ $this->get_data(), '__toString' ] ) ? $this->get_data() : '';
	}


	/**
	 * Gets the response data a string with all sensitive information masked.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function to_string_safe() {

		return $this->to_string();
	}


}
