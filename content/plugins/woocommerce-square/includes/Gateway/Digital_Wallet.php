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
 */

namespace WooCommerce\Square\Gateway;

defined( 'ABSPATH' ) || exit;

use WooCommerce\Square\Plugin;

class Digital_Wallet {

	/**
	 * @var Gateway $gateway
	 */
	public $gateway = null;

	/**
	 * @var String $page - Current page
	 */
	public $page = null;

	/**
	 * @var bool $is_available - Is Apple Pay and Google Pay available
	 */
	public $is_available = null;

	/**
	 * Setup the Digital Wallet class
	 *
	 * @since 2.3
	 */
	public function __construct( $gateway ) {
		$this->gateway = $gateway;

		if ( 'yes' === $gateway->get_option( 'enabled', 'no' ) && 'yes' === $gateway->get_option( 'enable_digital_wallets', 'yes' ) && $gateway->is_digital_wallet_available() ) {
			add_action( 'wp', array( $this, 'init' ) );
			add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		}

		if ( is_admin() && ( $gateway->get_plugin()->is_gateway_settings() || $gateway->get_plugin()->is_plugin_settings() ) ) {
			add_action( 'init', array( $this, 'apple_pay_domain_registration' ) );
		}

		// WC AJAX
		add_action( 'wc_ajax_square_digital_wallet_get_payment_request', array( $this, 'ajax_get_payment_request' ) );
		add_action( 'wc_ajax_square_digital_wallet_add_to_cart', array( $this, 'ajax_add_to_cart' ) );
		add_action( 'wc_ajax_square_digital_wallet_recalculate_totals', array( $this, 'ajax_recalculate_totals' ) );
		add_action( 'wc_ajax_square_digital_wallet_process_checkout', array( $this, 'ajax_process_checkout' ) );

		// Calculate the value of option `wc_square_apple_pay_enabled` which is not stored in the DB for WC Admin inbox notifications
		add_filter( 'pre_option_wc_square_apple_pay_enabled', array( $this, 'get_option_is_apple_pay_enabled' ), 10, 1 );
	}

	/**
	 * Initialize the digital wallet class
	 *
	 * @since 2.3
	 */
	public function init() {
		$available_pages = $this->get_available_pages();

		if ( in_array( 'product', $available_pages, true ) ) {
			add_action( 'woocommerce_after_add_to_cart_quantity', array( $this, 'render_button' ) );
		}

		if ( in_array( 'cart', $available_pages, true ) ) {
			add_action( 'woocommerce_proceed_to_checkout', array( $this, 'render_button' ) );
		}

		if ( in_array( 'checkout', $available_pages, true ) ) {
			add_action( 'woocommerce_before_checkout_form', array( $this, 'render_button' ), 15 );
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Display admin notices related to Square digital wallets
	 *
	 * @since 2.3
	 * @return void
	 */
	public function admin_notices() {

		// Apple Pay notices - Only shown when digital wallets are enabled and Apple isn't in list of hidden button options
		if ( ! in_array( 'apple', $this->gateway->get_option( 'digital_wallets_hide_button_options', array() ), true ) ) {
			$apple_pay_verification_file_location = $this->apple_pay_verification_file_location();

			// Verification file is missing
			if ( ! empty( $apple_pay_verification_file_location ) && ! file_exists( $apple_pay_verification_file_location ) ) {
				wc_square()->get_admin_notice_handler()->add_admin_notice(
					sprintf(
						/* Translators: %1$s: expected location of apple pay verification file, %2$s: opening href tag with link to Square documentation, %3$s: closing href tag */
						__( 'Apple Pay is not available with Square. We cannot confirm the Apple Pay domain verification file is at the expected location: %1$s. For more information, please read our documentation on %2$sSetting up Apple Pay%3$s.', 'woocommerce-square' ),
						'<code>' . $apple_pay_verification_file_location . '</code>',
						'<a href="https://docs.woocommerce.com/document/woocommerce-square/">',
						'</a>'
					),
					'wc-square-apple-pay-file-missing',
					array(
						'notice_class' => 'notice-warning',
					)
				);

			} elseif ( 'no' === $this->gateway->get_option( 'apple_pay_domain_registered', '' ) ) {
				// Domain failed to register
				wc_square()->get_admin_notice_handler()->add_admin_notice(
					sprintf(
						/* Translators: %1$s: opening bold tags, %2$s: closing strong/bold tags, %3$s: expected location of apple pay verification file, %4$s: opening href tag with link to Square documentation, %5$s: closing href tag */
						__( 'Apple Pay is not available with Square - there was a problem with registering your store domain with Square/Apple Pay. %1$sView the Square logs%2$s to find out what caused the registration to fail.', 'woocommerce-square' ),
						'<a href="' . esc_url( admin_url( 'admin.php?page=wc-status&tab=logs' ) ) . '">',
						'</a>'
					),
					'wc-square-apple-pay-domain-registered',
					array(
						'notice_class' => 'notice-warning',
					)
				);
			}
		}
	}

	/**
	 * Render the Digital Wallet buttons (Apple Pay) on the Product, Cart or Checkout pages
	 *
	 * @since 2.3
	 * @return void
	 */
	public function render_button() {

		$apple_pay_classes  = $google_pay_classes = array( 'wc-square-wallet-buttons' );
		$button_type        = $this->gateway->get_option( 'digital_wallets_button_type', 'buy' );
		$apple_button_style = $this->gateway->get_option( 'digital_wallets_apple_pay_button_color', 'black' );

		// set button text
		switch ( $button_type ) {
			case 'donate':
			case 'buy':
				$button_text         = ucfirst( $button_type ) . ' with';
				$apple_pay_classes[] = 'wc-square-wallet-button-with-text';
				break;

			default:
				$button_text = '';
		}

		$apple_pay_classes[]  = 'wc-square-wallet-button-' . $apple_button_style;
		$google_pay_classes[] = 'wc-square-wallet-button-' . $this->gateway->get_option( 'digital_wallets_google_pay_button_color', 'black' );

		?>
		<div id="wc-square-digital-wallet" style="display:none;">
			<div id="wc-square-apple-pay" class="apple-pay-button <?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $apple_pay_classes ) ) ); ?>" lang="<?php echo esc_attr( substr( get_locale(), 0, 2 ) ); ?>" style="-apple-pay-button-type: <?php echo esc_attr( $button_type ); ?>; -apple-pay-button-style: <?php echo esc_attr( $apple_button_style ); ?>">
				<span class="text"><?php echo esc_html( $button_text ); ?></span>
				<span class="logo"></span>
			</div>

			<div id="wc-square-google-pay" class="google-pay-button <?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $google_pay_classes ) ) ); ?>" lang="<?php echo esc_attr( substr( get_locale(), 0, 2 ) ); ?>"></div>
			<p id="wc-square-wallet-divider">&ndash; <?php esc_html_e( 'OR', 'woocommerce-square' ); ?> &ndash;</p>
		</div>
		<?php
	}

	/**
	 * Load Square wallet scripts and styles
	 *
	 * @since 2.3
	 * @return void
	 */
	public function enqueue_scripts() {
		$page = $this->get_current_page();

		if ( ! $page || ! $this->is_available() ) {
			return;
		}

		wp_enqueue_style( 'wc-square-digital-wallet', $this->gateway->get_plugin()->get_plugin_url() . '/assets/css/frontend/wc-square-digital-wallet.min.css', array(), Plugin::VERSION );
		wp_enqueue_script( 'wc-square-digital-wallet', $this->gateway->get_plugin()->get_plugin_url() . '/assets/js/frontend/wc-square-digital-wallet.min.js', array( 'jquery' ), Plugin::VERSION, true );

		try {
			$args = apply_filters(
				'wc_square_digital_wallet_js_args',
				array(
					'application_id'           => $this->gateway->get_application_id(),
					'location_id'              => wc_square()->get_settings_handler()->get_location_id(),
					'gateway_id'               => $this->gateway->get_id(),
					'gateway_id_dasherized'    => $this->gateway->get_id_dasherized(),
					'payment_request'          => $this->get_payment_request_for_context( $page ),
					'context'                  => $page,
					'general_error'            => __( 'An error occurred, please try again or try an alternate form of payment.', 'woocommerce-square' ),
					'ajax_url'                 => \WC_AJAX::get_endpoint( '%%endpoint%%' ),
					'payment_request_nonce'    => wp_create_nonce( 'wc-square-get-payment-request' ),
					'add_to_cart_nonce'        => wp_create_nonce( 'wc-square-add-to-cart' ),
					'recalculate_totals_nonce' => wp_create_nonce( 'wc-square-recalculate-totals' ),
					'process_checkout_nonce'   => wp_create_nonce( 'woocommerce-process_checkout' ),
					'logging_enabled'          => $this->gateway->debug_log(),
					'hide_button_options'      => $this->get_hidden_button_options(),
				)
			);

			wc_enqueue_js( sprintf( 'window.wc_square_digital_wallet_handler = new WC_Square_Digital_Wallet_Handler( %s );', wp_json_encode( $args ) ) );
		} catch ( \Exception $e ) {
			wp_dequeue_style( 'wc-square-digital-wallet' );
			wp_dequeue_script( 'wc-square-digital-wallet' );
		}
	}

	/**
	 * Build the payment request object for the given context (i.e. product, cart or checkout page)
	 *
	 * Payment request objects are used by the SqPaymentForm and need to be in a specific format.
	 * Reference: https://developer.squareup.com/docs/api/paymentform#paymentform-paymentrequestobjects
	 *
	 * @since 2.3
	 * @param string $context
	 * @return array
	 */
	public function get_payment_request_for_context( $context ) {
		$payment_request = array();

		switch ( $context ) {
			case 'product':
				$payment_request = $this->get_product_payment_request( get_the_ID() );
				break;

			case 'cart':
			case 'checkout':
				if ( isset( WC()->cart ) ) {
					WC()->cart->calculate_totals();
					$payment_request = $this->build_payment_request( WC()->cart->total );
				}

				break;
		}

		return $payment_request;
	}

	/**
	 * Build a payment request object to be sent to SqPaymentForm on the product page
	 *
	 * Documentation: https://developer.squareup.com/docs/api/paymentform#paymentform-paymentrequestobjects
	 *
	 * @since 2.3
	 * @param int $product_id
	 * @param bool $add_to_cart - whether or not the product needs to be added to the cart before building the payment request
	 * @return array
	 */
	public function get_product_payment_request( $product_id = 0, $quantity = 1, $attributes = array(), $add_to_cart = false ) {
		$data         = array();
		$items        = array();
		$product_id   = ! empty( $product_id ) ? $product_id : get_the_ID();
		$product      = wc_get_product( $product_id );
		$variation_id = 0;

		if ( ! is_a( $product, 'WC_Product' ) ) {
			/* translators: product ID */
			throw new \Exception( sprintf( __( 'Product with the ID (%d) cannot be found.', 'woocommerce-square' ), $product_id ) );
		}

		$quantity = $product->is_sold_individually() ? 1 : $quantity;

		if ( 'variable' === $product->get_type() && ! empty( $attributes ) ) {
			$data_store   = \WC_Data_Store::load( 'product' );
			$variation_id = $data_store->find_matching_product_variation( $product, $attributes );

			if ( ! empty( $variation_id ) ) {
				$product = wc_get_product( $variation_id );
			}
		}

		if ( ! $product->has_enough_stock( $quantity ) ) {
			/* translators: 1: product name 2: quantity in stock */
			throw new \Exception( sprintf( __( 'You cannot add that amount of "%1$s"; to the cart because there is not enough stock (%2$s remaining).', 'woocommerce-square' ), $product->get_name(), wc_format_stock_quantity_for_display( $product->get_stock_quantity(), $product ) ) );
		}

		if ( $add_to_cart ) {
			WC()->cart->empty_cart();
			WC()->cart->add_to_cart( $product->get_id(), $quantity, $variation_id, $attributes );

			WC()->cart->calculate_totals();
			return $this->build_payment_request( WC()->cart->total );
		}

		$amount         = number_format( $quantity * $product->get_price(), 2, '.', '' );
		$quantity_label = 1 < $quantity ? ' x ' . $quantity : '';

		$items[] = array(
			'label'   => $product->get_name() . $quantity_label,
			'amount'  => $amount,
			'pending' => false,
		);

		if ( wc_tax_enabled() ) {
			$items[] = array(
				'label'   => __( 'Tax', 'woocommerce-square' ),
				'amount'  => '0.00',
				'pending' => true,
			);
		}

		$data['requestShippingAddress'] = wc_shipping_enabled() && $product->needs_shipping() ? true : false;
		$data['lineItems']              = $items;

		return $this->build_payment_request( $amount, $data );
	}

	/**
	 * Build a payment request object to be sent to SqPaymentForm.
	 *
	 * Documentation: https://developer.squareup.com/docs/api/paymentform#paymentform-paymentrequestobjects
	 *
	 * @since 2.3
	 * @param string $amount - format '100.00'
	 * @param array $data
	 * @return array
	 */
	public function build_payment_request( $amount, $data = array() ) {
		$data = wp_parse_args(
			$data,
			array(
				'requestShippingAddress' => wc_shipping_enabled() && isset( WC()->cart ) && WC()->cart->needs_shipping(),
				'requestBillingInfo'     => true,
				'requestEmailAddress'    => true,
				'countryCode'            => substr( get_option( 'woocommerce_default_country' ), 0, 2 ),
				'currencyCode'           => get_woocommerce_currency(),
			)
		);

		if ( count( WC()->shipping->get_packages() ) > 1 ) {
			throw new \Exception( __( 'This payment method cannot be used for multiple shipments.', 'woocommerce-square' ) );
		}

		if ( ! isset( $data['lineItems'] ) ) {
			$data['lineItems'] = $this->build_payment_request_line_items();
		}

		if ( true === $data['requestShippingAddress'] ) {
			$data['shippingOptions'] = array(
				array(
					'id'      => '0',
					'label'   => __( 'Pending', 'woocommerce-square' ),
					'amount'  => '0.00',
					'pending' => false,
				),
			);
		}

		$data['total'] = array(
			'label'   => get_bloginfo( 'name', 'display' ) . ' (via WooCommerce)',
			'amount'  => number_format( $amount, 2, '.', '' ),
			'pending' => false,
		);

		return $data;
	}

	/**
	 * Builds an array of line items/totals to be sent back to Square in the lineItems array.
	 *
	 * @since 2.3
	 * @param array $cart_totals
	 * @return array
	 */
	public function build_payment_request_line_items( $cart_totals = array() ) {
		$cart_totals = empty( $cart_totals ) ? $this->get_cart_totals() : $cart_totals;
		$line_items  = array();

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$amount         = number_format( $cart_item['line_subtotal'], 2, '.', '' );
			$quantity_label = 1 < $cart_item['quantity'] ? ' x ' . $cart_item['quantity'] : '';

			$item = array(
				'label'   => $cart_item['data']->get_name() . $quantity_label,
				'amount'  => $amount,
				'pending' => false,
			);

			$line_items[] = $item;
		}

		if ( $cart_totals['shipping'] > 0 ) {
			$line_items[] = array(
				'label'   => __( 'Shipping', 'woocommerce-square' ),
				'amount'  => number_format( $cart_totals['shipping'], 2, '.', '' ),
				'pending' => false,
			);
		}

		if ( $cart_totals['taxes'] > 0 ) {
			$line_items[] = array(
				'label'   => __( 'Tax', 'woocommerce-square' ),
				'amount'  => number_format( $cart_totals['taxes'], 2, '.', '' ),
				'pending' => false,
			);
		}

		if ( $cart_totals['discount'] > 0 ) {
			$line_items[] = array(
				'label'   => __( 'Discount', 'woocommerce-square' ),
				'amount'  => number_format( $cart_totals['discount'], 2, '.', '' ),
				'pending' => false,
			);
		}

		if ( $cart_totals['fees'] > 0 ) {
			$line_items[] = array(
				'label'   => __( 'Fees', 'woocommerce-square' ),
				'amount'  => number_format( $cart_totals['fees'], 2, '.', '' ),
				'pending' => false,
			);
		}

		return $line_items;
	}


	/**
	 * Get the payment request object in an ajax request
	 *
	 * @since 2.3
	 * @return void
	 */
	public function ajax_get_payment_request() {
		check_ajax_referer( 'wc-square-get-payment-request', 'security' );

		$payment_request = array();
		$context         = ! empty( $_POST['context'] ) ? wc_clean( wp_unslash( $_POST['context'] ) ) : '';

		try {
			if ( 'product' === $context ) {
				$product_id      = ! empty( $_POST['product_id'] ) ? wc_clean( wp_unslash( $_POST['product_id'] ) ) : 0;
				$quantity        = ! empty( $_POST['quantity'] ) ? wc_clean( wp_unslash( $_POST['quantity'] ) ) : 1;
				$attributes      = ! empty( $_POST['attributes'] ) ? wc_clean( wp_unslash( $_POST['attributes'] ) ) : array();
				$payment_request = $this->get_product_payment_request( $product_id, $quantity, $attributes );

			} else {
				$payment_request = $this->get_payment_request_for_context( $context );
			}

			if ( empty( $payment_request ) ) {
				throw new \Exception( esc_html__( 'Invalid request. Could not fetch the payment request data to be use in the Square digital wallet.', 'woocommerce-square' ) );
			}
		} catch ( \Exception $e ) {
			wp_send_json_error( $e->getMessage() );
		}

		wp_send_json_success( wp_json_encode( $payment_request ) );
	}

	/**
	 * When the digital wallet button is pressed, add the product to cart and generate a new payment request.
	 * We need to add the product the cart to help with shipping/tax calculations.
	 *
	 * @since 2.3
	 * @return void
	 */
	public function ajax_add_to_cart() {
		check_ajax_referer( 'wc-square-add-to-cart', 'security' );

		try {
			$product_id = ! empty( $_POST['product_id'] ) ? wc_clean( wp_unslash( $_POST['product_id'] ) ) : 0;
			$quantity   = ! empty( $_POST['quantity'] ) ? wc_clean( wp_unslash( $_POST['quantity'] ) ) : 1;
			$attributes = ! empty( $_POST['attributes'] ) ? wc_clean( wp_unslash( $_POST['attributes'] ) ) : array();

			$response = array(
				'payment_request'          => $this->get_product_payment_request( $product_id, $quantity, $attributes, true ),
				// We need to generate a new set of nonces now that a WC customer session exists after a product was added to the cart
				'payment_request_nonce'    => wp_create_nonce( 'wc-square-get-payment-request' ),
				'add_to_cart_nonce'        => wp_create_nonce( 'wc-square-add-to-cart' ),
				'recalculate_totals_nonce' => wp_create_nonce( 'wc-square-recalculate-totals' ),
				'process_checkout_nonce'   => wp_create_nonce( 'woocommerce-process_checkout' ),
			);

			wp_send_json_success( wp_json_encode( $response ) );
		} catch ( \Exception $e ) {
			wp_send_json_error( $e->getMessage() );
		}
	}

	/**
	 * Updates shipping method in WC session
	 *
	 * @since 2.3
	 * @param array $shipping_methods Array of selected shipping methods ids
	 * @return void
	 */
	public function update_shipping_method( $shipping_methods ) {
		$chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );

		if ( is_array( $shipping_methods ) ) {
			foreach ( $shipping_methods as $i => $value ) {
				$chosen_shipping_methods[ $i ] = wc_clean( $value );
			}
		}

		WC()->session->set( 'chosen_shipping_methods', $chosen_shipping_methods );
	}

	/**
	 * Reset shipping and calculate the latest shipping options/package with the given address.
	 *
	 * If no address, use the store's base address as default.
	 *
	 * @since 2.3
	 * @param array $address
	 * @return void
	 */
	public function calculate_shipping( $address = array() ) {
		WC()->shipping->reset_shipping();

		if ( $address['country'] ) {
			WC()->customer->set_location( strtoupper( $address['country'] ), $address['region'], $address['postalCode'], $address['city'] );
			WC()->customer->set_shipping_location( strtoupper( $address['country'] ), $address['region'], $address['postalCode'], $address['city'] );
		} else {
			WC()->customer->set_billing_address_to_base();
			WC()->customer->set_shipping_address_to_base();
		}

		WC()->customer->set_calculated_shipping( true );
		WC()->customer->save();

		$packages                                = array();
		$packages[0]['contents']                 = WC()->cart->get_cart();
		$packages[0]['contents_cost']            = 0;
		$packages[0]['applied_coupons']          = WC()->cart->applied_coupons;
		$packages[0]['user']['ID']               = get_current_user_id();
		$packages[0]['destination']['country']   = $address['country'];
		$packages[0]['destination']['state']     = $address['region'];
		$packages[0]['destination']['postcode']  = $address['postalCode'];
		$packages[0]['destination']['city']      = $address['city'];
		$packages[0]['destination']['address']   = $address['address'];
		$packages[0]['destination']['address_2'] = $address['address_2'];

		foreach ( WC()->cart->get_cart() as $item ) {
			if ( $item['data']->needs_shipping() ) {
				if ( isset( $item['line_total'] ) ) {
					$packages[0]['contents_cost'] += $item['line_total'];
				}
			}
		}

		$packages = apply_filters( 'woocommerce_cart_shipping_packages', $packages );

		WC()->shipping->calculate_shipping( $packages );
	}

	/**
	 * Recalculate shipping methods and cart totals and send the updated information
	 * data as a square payment request json object.
	 *
	 * @since 2.3
	 * @return void
	 */
	public function ajax_recalculate_totals() {
		check_ajax_referer( 'wc-square-recalculate-totals', 'security' );

		$chosen_methods   = WC()->session->get( 'chosen_shipping_methods' );
		$shipping_address = array();
		$payment_request  = array();

		if ( ! empty( $_POST['shipping_contact'] ) ) {
			$shipping_address = wp_parse_args(
				wc_clean( wp_unslash( $_POST['shipping_contact'] ) ),
				array(
					'country'    => null,
					'region'     => null,
					'city'       => null,
					'postalCode' => null,
					'address'    => null,
					'address_2'  => null,
				)
			);

			$this->calculate_shipping( $shipping_address );

			$packages = WC()->shipping->get_packages();

			if ( ! empty( $packages ) ) {
				foreach ( $packages[0]['rates'] as $method ) {
					$payment_request['shippingOptions'][] = array(
						'id'     => $method->id,
						'label'  => $method->get_label(),
						'amount' => number_format( $method->cost, 2, '.', '' ),
					);
				}
			}

			// sort the shippingOptions so that the default/chosen shipping method is the first option so that it's displayed first in the Apple Pay/Google Pay window
			if ( isset( $payment_request['shippingOptions'][0] ) ) {
				if ( isset( $chosen_methods[0] ) ) {
					$chosen_method_id         = $chosen_methods[0];
					$compare_shipping_options = function ( $a, $b ) use ( $chosen_method_id ) {
						if ( $a['id'] === $chosen_method_id ) {
							return -1;
						}

						if ( $b['id'] === $chosen_method_id ) {
							return 1;
						}

						return 0;
					};

					usort( $payment_request['shippingOptions'], $compare_shipping_options );
				}

				$first_shipping_method_id = $payment_request['shippingOptions'][0]['id'];
				$this->update_shipping_method( array( $first_shipping_method_id ) );
			}
		} elseif ( ! empty( $_POST['shipping_option'] ) ) {
			$chosen_methods = array( wc_clean( wp_unslash( $_POST['shipping_option'] ) ) );
			$this->update_shipping_method( $chosen_methods );
		}

		WC()->cart->calculate_totals();

		$payment_request['lineItems'] = $this->build_payment_request_line_items();
		$payment_request['total']     = array(
			'label'   => get_bloginfo( 'name', 'display' ) . ' (via WooCommerce)',
			'amount'  => number_format( WC()->cart->total, 2, '.', '' ),
			'pending' => false,
		);

		wp_send_json_success( $payment_request );
	}

	/**
	 * Process the digital wallet checkout
	 *
	 * @since 2.3
	 * @return void
	 */
	public function ajax_process_checkout() {
		if ( WC()->cart->is_empty() ) {
			wp_send_json_error( __( 'Empty cart', 'woocommerce-square' ) );
		}

		if ( ! defined( 'WOOCOMMERCE_CHECKOUT' ) ) {
			define( 'WOOCOMMERCE_CHECKOUT', true );
		}

		WC()->checkout()->process_checkout();

		die( 0 );
	}


	/** Helper methods *******************************************************************************************/


	/**
	 * Helper function to return the expected location of the apple-developer verification file on the server.
	 *
	 * @since 2.3
	 * @return string
	 */
	public function apple_pay_verification_file_location() {
		return ! empty( $_SERVER['DOCUMENT_ROOT'] ) ? untrailingslashit( wc_clean( wp_unslash( $_SERVER['DOCUMENT_ROOT'] ) ) ) . '/.well-known/apple-developer-merchantid-domain-association' : '';
	}

	/**
	 * Checks for the existance of Apple Pay verification domain file at:
	 * SERVER_ROOT/.well-known/apple-developer-merchantid-domain-association
	 *
	 * If the file doesn't exist or the contents has been modified, copy the file from the plugin
	 * directory to the expected verification domain file location.
	 *
	 * @since 2.3
	 * @return bool
	 */
	public function check_apple_pay_verification_file() {
		if ( empty( $_SERVER['DOCUMENT_ROOT'] ) ) {
			return false;
		}

		$path              = untrailingslashit( wc_clean( wp_unslash( $_SERVER['DOCUMENT_ROOT'] ) ) );
		$dir               = '.well-known';
		$file              = 'apple-developer-merchantid-domain-association';
		$fullpath          = $path . '/' . $dir . '/' . $file;
		$plugin_path       = $this->gateway->get_plugin()->get_plugin_path();
		$existing_contents = @file_get_contents( $fullpath );                  // @codingStandardsIgnoreLine
		$new_contents      = @file_get_contents( $plugin_path . '/' . $file ); // @codingStandardsIgnoreLine

		if ( $existing_contents && $existing_contents === $new_contents ) {
			return true;
		}

		if ( ! file_exists( $path . '/' . $dir ) ) {
			if ( ! @mkdir( $path . '/' . $dir, 0755 ) ) { // @codingStandardsIgnoreLine
				$this->gateway->get_plugin()->log( 'Unable to create domain association folder to domain root.' );
				return false;
			}
		}

		if ( ! @copy( $plugin_path . '/' . $file, $fullpath ) ) { // @codingStandardsIgnoreLine
			$this->gateway->get_plugin()->log( 'Unable to copy domain association file to domain root.' );
			return false;
		}

		$this->gateway->get_plugin()->log( 'Apple Pay Domain association file updated.' );
		return true;
	}

	/**
	 * When loading the settings page this function, tries to register the current store domain with Square/Apple Pay.
	 *
	 * If digital wallets and Apple Pay is enabled, check that the domain verification file exist and check
	 * the gateway settings for `apple_pay_domain_registered` to confirm that this domain has been successfully registered with Square/Apple Pay.
	 *
	 * If the store has been registered, keep verifying the registration of the current connected account and domain every hour.
	 *
	 * @since 2.3
	 * @return string
	 */
	public function apple_pay_domain_registration() {
		// Only register the store url with Apple Pay if the gateway and digital wallets are enable (check POST data to account for the page load when settings are being saved).
		if ( ( 'no' === $this->gateway->get_option( 'enabled', 'no' ) && empty( $_POST['woocommerce_square_credit_card_enabled'] ) ) || ( 'no' === $this->gateway->get_option( 'enable_digital_wallets', 'yes' ) && empty( $_POST['woocommerce_square_credit_card_enable_digital_wallets'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			return;
		}

		// when settings are being saved, make sure we use the latest values from POST data to check if Apple isn't one of the hidden wallet options
		$hidden_wallet_options = ! isset( $_POST['woocommerce_square_credit_card_enable_digital_wallets'] ) ? $this->gateway->get_option( 'digital_wallets_hide_button_options', array() ) : ( ! empty( $_POST['woocommerce_square_credit_card_digital_wallets_hide_button_options'] ) ? wc_clean( wp_unslash( $_POST['woocommerce_square_credit_card_digital_wallets_hide_button_options'] ) ) : array() ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( in_array( 'apple', $hidden_wallet_options, true ) ) {
			return;
		}

		if ( ! $this->check_apple_pay_verification_file() ) {
			$this->gateway->update_option( 'apple_pay_domain_registered', 'no' );
			return;
		}

		try {
			$recently_registered = get_transient( 'wc_square_check_apple_pay_domain_registration' );

			if ( 'no' === $this->gateway->get_option( 'apple_pay_domain_registered', 'no' ) || ! $recently_registered ) {
				$this->register_apple_pay_domain();

				$this->gateway->update_option( 'apple_pay_domain_registered', 'yes' );
				$this->gateway->get_plugin()->log( 'Your domain has been verified with Apple Pay!' );

				// avoid API rate limits by limiting the request to checking every hour
				set_transient( 'wc_square_check_apple_pay_domain_registration', true, HOUR_IN_SECONDS );
			}
		} catch ( \Exception $e ) {
			$this->gateway->update_option( 'apple_pay_domain_registered', 'no' );
			$this->gateway->get_plugin()->log( 'Error: ' . $e->getMessage() );
		}
	}

	/**
	 * Sends an API request to endpoint v2/apple-pay/domains to register the store's domain with Square/Apple Pay.
	 *
	 * Reference: https://developer.squareup.com/docs/payment-form/cookbook/apple-pay-register-domains
	 *
	 * @since 2.3
	 * @throws \Exception on error
	 * @return void
	 */
	private function register_apple_pay_domain() {
		$access_token = $this->gateway->get_plugin()->get_settings_handler()->get_access_token();
		$is_sandbox   = $this->gateway->get_plugin()->get_settings_handler()->is_sandbox();
		$domain_name  = ! empty( $_SERVER['HTTP_HOST'] ) ? wc_clean( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';

		if ( empty( $domain_name ) ) {
			throw new \Exception( 'Unable to verify domain with Apple Pay - no domain found in $_SERVER[\'HTTP_HOST\'].' );
		}

		if ( empty( $access_token ) ) {
			throw new \Exception( __( 'Unable to verify domain with Apple Pay - missing access token.', 'woocommerce-square' ) );
		}

		$response = wp_remote_post(
			'https://connect.squareup' . ( $is_sandbox ? 'sandbox' : '' ) . '.com/v2/apple-pay/domains',
			array(
				'headers' => array(
					'Square-Version' => '2020-10-28',
					'Authorization'  => 'Bearer ' . $access_token,
					'Content-Type'   => 'application/json',
				),
				'body'    => wp_json_encode(
					array(
						'domain_name' => $domain_name,
					)
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			/* translators: error message */
			throw new \Exception( sprintf( 'Unable to verify domain %s - %s', $domain_name, $response->get_error_message() ) );
		}

		$parsed_response = json_decode( $response['body'], true );

		if ( 200 !== $response['response']['code'] || empty( $parsed_response['status'] ) || 'VERIFIED' !== $parsed_response['status'] ) {
			/* translators: error message */
			throw new \Exception( sprintf( 'Unable to verify domain %s - response = %s', $domain_name, print_r( $parsed_response, true ) ) ); //phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
		}
	}

	/**
	 * Returns an array of pages that digital wallets are loaded/available on.
	 * Defaults to product, cart and checkout pages.
	 *
	 * @since 2.3
	 * @return array
	 */
	public function get_available_pages() {
		return apply_filters(
			'wc_square_display_digital_wallet_on_pages',
			array(
				'product',
				'cart',
				'checkout',
			),
			$this
		);
	}

	/**
	 * Returns the current page.
	 *
	 * Stores the result in $this->page to avoid recalculating multiple times per request
	 *
	 * @since 2.3
	 * @return string
	 */
	public function get_current_page() {
		if ( null === $this->page ) {
			$is_cart    = is_cart() && ! WC()->cart->is_empty();
			$is_product = is_product() || wc_post_content_has_shortcode( 'product_page' );
			$this->page = $is_cart ? 'cart' : ( $is_product ? 'product' : ( is_checkout() ? 'checkout' : null ) );
		}

		return $this->page;
	}

	/**
	 * Returns cart totals in an array format
	 *
	 * @since 2.3
	 * @throws \Exception if no cart is found
	 * @return array
	 */
	public function get_cart_totals() {
		if ( ! isset( WC()->cart ) ) {
			throw new \Exception( 'Cart data cannot be found.' );
		}

		return array(
			'subtotal' => WC()->cart->subtotal_ex_tax,
			'discount' => WC()->cart->get_cart_discount_total(),
			'shipping' => WC()->cart->shipping_total,
			'fees'     => WC()->cart->fee_total,
			'taxes'    => WC()->cart->tax_total + WC()->cart->shipping_tax_total,
		);
	}

	/**
	 * Returns a list of hidden digital wallet options
	 *
	 * If Apple Pay domain hasn't been registered, force Apple Pay to be hidden.
	 *
	 * @since 2.3
	 * @return array
	 */
	public function get_hidden_button_options() {
		$hidden_options = $this->gateway->get_option( 'digital_wallets_hide_button_options', array() );

		if ( ( ! is_array( $hidden_options ) || ! in_array( 'apple', $hidden_options, true ) ) && 'no' === $this->gateway->get_option( 'apple_pay_domain_registered', 'no' ) ) {
			$hidden_options[] = 'apple';
		}

		return $hidden_options;
	}

	/**
	 * Returns a list the supported product types that can be used to purchase a digital wallet
	 *
	 * @since 2.3
	 * @return array
	 */
	public function supported_product_types() {
		return apply_filters(
			'wc_square_digital_wallets_supported_product_types',
			array(
				'simple',
				'variable',
				'variation',
				'subscription',
				'variable-subscription',
				'subscription_variation',
				'booking',
				'bundle',
				'composite',
				'mix-and-match',
			)
		);
	}

	/**
	 * Checks if digital wallets are allowed to be used to purchase the current product.
	 *
	 * @since 2.3
	 * @return bool
	 */
	public function allowed_for_product_page() {
		global $post;

		$product = wc_get_product( $post->ID );

		if ( ! is_object( $product ) || ! in_array( $product->get_type(), $this->supported_product_types(), true ) ) {
			return false;
		}

		// Trial subscriptions with shipping are not supported
		if ( class_exists( 'WC_Subscriptions_Order' ) && $product->needs_shipping() && \WC_Subscriptions_Product::get_trial_length( $product ) > 0 ) {
			return false;
		}

		// Pre Orders charge upon release not supported.
		if ( class_exists( 'WC_Pre_Orders_Order' ) && \WC_Pre_Orders_Product::product_is_charged_upon_release( $product ) ) {
			return false;
		}

		// File upload addon not supported
		if ( class_exists( 'WC_Product_Addons_Helper' ) ) {
			$product_addons = \WC_Product_Addons_Helper::get_product_addons( $product->get_id() );
			foreach ( $product_addons as $addon ) {
				if ( 'file_upload' === $addon['type'] ) {
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * Checks the cart to see if Square Digital Wallets is allowed to purchase all cart items.
	 *
	 * @since 2.3
	 * @return bool
	 */
	public function allowed_for_cart() {
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( ! in_array( $_product->get_type(), $this->supported_product_types(), true ) ) {
				return false;
			}

			// Trial subscriptions with shipping are not supported
			if ( class_exists( 'WC_Subscriptions_Order' ) && \WC_Subscriptions_Cart::cart_contains_subscription() && $_product->needs_shipping() && \WC_Subscriptions_Product::get_trial_length( $_product ) > 0 ) {
				return false;
			}

			// Pre Orders compatbility where we don't support charge upon release.
			if ( class_exists( 'WC_Pre_Orders_Order' ) && \WC_Pre_Orders_Cart::cart_contains_pre_order() && \WC_Pre_Orders_Product::product_is_charged_upon_release( \WC_Pre_Orders_Cart::get_pre_order_product() ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Returns if Google Pay and/or Apple Pay is available by checking the following:
	 *  - setting is enabled
	 *  - country and currency is supported
	 *  - square is connected and location is set
	 *  - current page/cart has items that can be purchased with a digital wallet
	 *
	 * Sets $this->is_available so that it's only checked once per request/page load
	 *
	 * @since 2.3
	 * @return bool
	 */
	public function is_available() {
		if ( null === $this->is_available ) {
			$available_pages = $this->get_available_pages();
			$current_page    = $this->get_current_page();

			if ( is_array( $available_pages ) && $current_page && in_array( $current_page, $available_pages, true ) ) {
				$this->is_available = ( 'yes' === $this->gateway->get_option( 'enable_digital_wallets', 'yes' ) && $this->gateway->is_digital_wallet_available() && $this->gateway->is_available() && ( 'product' === $current_page ? $this->allowed_for_product_page() : $this->allowed_for_cart() ) ) ? true : false;
			} else {
				$this->is_available = false;
			}
		}

		return $this->is_available;
	}

	/**
	 * This function calculates the value returned by get_option( 'wc_square_apple_pay_enabled', $default )
	 * and is used by WC Admin's Remote Inbox Notifications for marketing purposes.
	 *
	 * Returns either 1 or 2 if Apple Pay is enabled on the store, or $value (false) if not
	 *
	 * @since 2.3
	 * @param $value
	 * @return int|mixed
	 */
	public function get_option_is_apple_pay_enabled( $value ) {
		if ( $this->gateway->is_digital_wallet_available() && 'yes' === $this->gateway->get_option( 'enable_digital_wallets', 'yes' ) && ! in_array( 'apple', $this->gateway->get_option( 'digital_wallets_hide_button_options', array() ), true ) ) {
			$value = wp_rand( 1, 2 );
		}

		return $value;
	}
}
