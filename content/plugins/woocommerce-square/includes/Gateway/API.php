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

defined( 'ABSPATH' ) or exit;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;
use SquareConnect\Model\Order;

/**
 * The base Square gateway API class.
 *
 * @since 2.0.0
 */
class API extends \WooCommerce\Square\API {


	/** @var string location ID to use for requests */
	protected $location_id;

	/** @var \WC_Order order object associated with a request, if any */
	protected $order;


	/**
	 * Constructs the class.
	 *
	 * @since 2.0.0
	 *
	 * @param string $access_token the API access token
	 * @param string $location_id location ID to use for requests
	 */
	public function __construct( $access_token, $location_id ) {

		parent::__construct( $access_token );

		$this->location_id = $location_id;
	}


	/** Transaction methods *******************************************************************************************/


	/**
	 * Performs a credit card authorization for the given order.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 * @return \WooCommerce\Square\API\Response
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function credit_card_authorization( \WC_Order $order ) {

		$request = new API\Requests\Transactions( $this->get_location_id(), $this->client );

		$request->set_authorization_data( $order );

		$this->set_response_handler( API\Responses\Charge::class );

		return $this->perform_request( $request );
	}


	/**
	 * Performs a credit card charge for the given order.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 * @return \WooCommerce\Square\API\Response
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function credit_card_charge( \WC_Order $order ) {

		$request = new API\Requests\Transactions( $this->get_location_id(), $this->client );

		$request->set_charge_data( $order );

		$this->set_response_handler( API\Responses\Charge::class );

		return $this->perform_request( $request );
	}


	/**
	 * Performs a credit card capture for a given authorized order.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 * @return \WooCommerce\Square\API\Response
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function credit_card_capture( \WC_Order $order ) {

		$location_id = ! empty( $order->capture->location_id ) ? $order->capture->location_id : $this->get_location_id();

		$request = new API\Requests\Transactions( $location_id, $this->client );

		$request->set_capture_data( $order );

		$this->set_response_handler( API\Response::class );

		return $this->perform_request( $request );
	}


	/**
	 * Performs a refund for the given order.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 * @return \WooCommerce\Square\API\Response
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function refund( \WC_Order $order ) {

		$location_id = ! empty( $order->refund->location_id ) ? $order->refund->location_id : $this->get_location_id();

		$request = new API\Requests\Transactions( $location_id, $this->client );

		$request->set_refund_data( $order );

		$this->set_response_handler( API\Responses\Refund::class );

		return $this->perform_request( $request );
	}


	/**
	 * Performs a void for the given order.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 * @return \WooCommerce\Square\API\Response
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function void( \WC_Order $order ) {

		$location_id = ! empty( $order->refund->location_id ) ? $order->refund->location_id : $this->get_location_id();

		$request = new API\Requests\Transactions( $location_id, $this->client );

		$request->set_void_data( $order );

		$this->set_response_handler( API\Response::class );

		return $this->perform_request( $request );
	}


	/**
	 * Creates a payment token for the given order.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order the order object
	 * @return API\Responses\Create_Customer_Card|API\Responses\Create_Customer
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function tokenize_payment_method( \WC_Order $order ) {

		// a customer ID should've already been created, but just in case...
		if ( empty( $order->customer_id ) ) {

			$response = $this->create_customer( $order );

			if ( ! $response->transaction_approved() ) {
				return $response;
			}

			$order->customer_id = $response->get_customer_id();
		}

		return $this->create_customer_card( $order );
	}


	/**
	 * Creates a payment token for the given order.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order the order object
	 * @return API\Responses\Create_Customer_Card
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function create_customer_card( \WC_Order $order ) {

		$request = new API\Requests\Customers( $this->client );

		$request->set_create_card_data( $order );

		$this->set_response_handler( API\Responses\Create_Customer_Card::class );

		return $this->perform_request( $request );
	}


	/**
	 * Creates a new customer based on the given order.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 * @return API\Responses\Create_Customer
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function create_customer( \WC_Order $order ) {

		$request = new API\Requests\Customers( $this->client );

		$request->set_create_customer_data( $order );

		$this->set_response_handler( API\Responses\Create_Customer::class );

		return $this->perform_request( $request );
	}


	/**
	 * Gets all tokenized payment methods for the customer.
	 *
	 * @since 2.0.0
	 *
	 * @param string $customer_id unique customer id
	 * @return API\Responses\Get_Customer
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function get_tokenized_payment_methods( $customer_id ) {

		$request = new API\Requests\Customers( $this->client );

		$request->set_get_customer_data( $customer_id );

		$this->set_response_handler( API\Responses\Get_Customer::class );

		return $this->perform_request( $request );
	}


	/**
	 * Removes the tokenized payment method.
	 *
	 * @since 2.0.0
	 *
	 * @param string $token the payment method token
	 * @param string $customer_id unique customer id
	 * @return API\Response
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function remove_tokenized_payment_method( $token, $customer_id ) {

		$request = new API\Requests\Customers( $this->client );

		$request->set_delete_card_data( $customer_id, $token );

		$this->set_response_handler( API\Response::class );

		return $this->perform_request( $request );
	}


	/**
	 * Creates a new Square order from a WooCommerce order.
	 *
	 * @since 2.0.0
	 *
	 * @param string $location_id location ID
	 * @param \WC_Order $order
	 * @return Order
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function create_order( $location_id, \WC_Order $order ) {

		$request = new API\Requests\Orders( $this->client );

		$request->set_create_order_data( $location_id, $order );

		$this->set_response_handler( \WooCommerce\Square\API\Response::class );

		$response = $this->perform_request( $request );

		return $response->get_data()->getOrder();
	}


	/**
	 * Adjusts an existing Square order by amount.
	 *
	 * @since 2.0.4
	 *
	 * @param string $location_id location ID
	 * @param \WC_Order $order
	 * @param int $version Current 'version' value of Square order
	 * @param int $amount Amount of adjustment in smallest unit
	 * @return Order
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function adjust_order( $location_id, \WC_Order $order, $version, $amount ) {

		$request = new API\Requests\Orders( $this->client );

		if ( $amount > 0 ) {
			$request->add_line_item_order_data( $location_id, $order, $version, $amount );
		} else {
			$request->add_discount_order_data( $location_id, $order, $version, -1 * $amount );
		}
		$this->set_response_handler( \WooCommerce\Square\API\Response::class );

		$response = $this->perform_request( $request );

		return $response->get_data()->getOrder();
	}


	/**
	 * Gets an existing transaction.
	 *
	 * @since 2.0.0
	 *
	 * @param string $transaction_id transaction ID
	 * @param string $location_id location ID
	 * @return API\Responses\Charge
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function get_transaction( $transaction_id, $location_id = '' ) {

		if ( ! $location_id ) {
			$location_id = $this->get_location_id();
		}

		$request = new API\Requests\Transactions( $location_id, $this->client );

		$request->set_get_transaction_data( $transaction_id );

		$this->set_response_handler( API\Responses\Charge::class );

		return $this->perform_request( $request );
	}


	/**
	 * Validates the parsed response.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 * @throws Framework\SV_WC_API_Exception
	 */
	protected function do_post_parse_response_validation() {

		// gateway responses need to get through to check API\Response::transaction_approved()
		if ( $this->get_response() instanceof API\Response ) {
			return true;
		}

		return parent::do_post_parse_response_validation();
	}


	/** Conditional methods *******************************************************************************************/


	/**
	 * Determines if this API supports getting a customer's tokenized payment methods.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function supports_get_tokenized_payment_methods() {

		return true;
	}


	/**
	 * Determines if this API supports updating tokenized payment methods.
	 *
	 * @see SV_WC_Payment_Gateway_API::update_tokenized_payment_method()
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function supports_update_tokenized_payment_method() {

		return false;
	}


	/**
	 * Determines if this API supports removing a tokenized payment method.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function supports_remove_tokenized_payment_method() {

		return true;
	}


	/** Getter methods ************************************************************************************************/


	/**
	 * Gets the location ID to be used for requests.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	protected function get_location_id() {

		return $this->location_id;
	}


	/**
	 * Gets the object associated with the request, if any.
	 *
	 * @since 2.0.0
	 *
	 * @return \WC_Order
	 */
	public function get_order() {

		return $this->order;
	}


	/**
	 * Gets the API ID.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	protected function get_api_id() {

		return $this->get_plugin()->get_gateway()->get_id();
	}


	/** No-op methods *************************************************************************************************/


	/**
	 * The gateway API does not support check debits.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 */
	public function check_debit( \WC_Order $order ) {}


	/**
	 * Updates a tokenized payment method.
	 *
	 * Square API does not allow updating a stored card's address, and instead recommends deleting and re-adding a new
	 * card. This isn't an option for us since subscriptions would break any time an address is updated.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 */
	public function update_tokenized_payment_method( \WC_Order $order ) {}


}
