<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

include_once( dirname( __FILE__ ) . '/class-wc-square-payments-connect.php' );

class WC_Square_Payments {
	protected $connect;
	public $logging;

	/**
	 * Constructor
	 */
	public function __construct( WC_Square_Payments_Connect $connect ) {
		$this->init();
		$this->connect = $connect;

		add_filter( 'woocommerce_payment_gateways', array( $this, 'register_gateway' ) );

		add_action( 'woocommerce_order_status_on-hold_to_processing', array( $this, 'capture_payment' ) );
		add_action( 'woocommerce_order_status_on-hold_to_completed', array( $this, 'capture_payment' ) );
		add_action( 'woocommerce_order_status_on-hold_to_cancelled', array( $this, 'cancel_payment' ) );
		add_action( 'woocommerce_order_status_on-hold_to_refunded', array( $this, 'cancel_payment' ) );

		if ( is_admin() ) {
			add_filter( 'woocommerce_order_actions', array( $this, 'add_capture_charge_order_action' ) );
			add_action( 'woocommerce_order_action_square_capture_charge', array( $this, 'maybe_capture_charge' ) );
		}

		$gateway_settings = get_option( 'woocommerce_square_settings' );

		$this->logging = ! empty( $gateway_settings['logging'] ) ? true : false;

		return true;
	}

	/**
	 * Init
	 */
	public function init() {
		if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
			return;
		}

		// live/production app id from Square account
		if ( ! defined( 'SQUARE_APPLICATION_ID' ) ) {
			define( 'SQUARE_APPLICATION_ID', 'sq0idp-wGVapF8sNt9PLrdj5znuKA' );
		}

		// Includes
		include_once( dirname( __FILE__ ) . '/class-wc-square-gateway.php' );

		return true;
	}

	/**
	 * Register the gateway for use
	 */
	public function register_gateway( $methods ) {
		$methods[] = 'WC_Square_Gateway';

		return $methods;
	}

	public function add_capture_charge_order_action( $actions ) {
		if ( ! isset( $_REQUEST['post'] ) ) {
			return $actions;
		}

		$order = wc_get_order( absint( $_REQUEST['post'] ) );

		// Bail if order is not found.
		if ( empty( $order ) ) {
			return $actions;
		}

		// bail if the order wasn't paid for with this gateway
		if ( 'square' !== ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $order->payment_method : $order->get_payment_method() ) ) {
			return $actions;
		}

		// bail if charge was already captured
		if ( 'yes' === get_post_meta( version_compare( WC_VERSION, '3.0.0', '<' ) ? $order->id : $order->get_id(), '_square_charge_captured', true ) ) {
			return $actions;
		}

		$actions['square_capture_charge'] = esc_html__( 'Capture Charge', 'woocommerce-square' );

		return $actions;
	}

	public function maybe_capture_charge( $order ) {
		if ( ! is_object( $order ) ) {
			$order = wc_get_order( $order );
		}

		$this->capture_payment( version_compare( WC_VERSION, '3.0.0', '<' ) ? $order->id : $order->get_id() );

		return true;
	}

	/**
	 * Capture payment when the order is changed from on-hold to complete or processing
	 *
	 * @param int $order_id
	 */
	public function capture_payment( $order_id ) {
		$order = wc_get_order( $order_id );

		if ( 'square' === ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $order->payment_method : $order->get_payment_method() ) ) {
			try {
				$this->log( "Info: Begin capture for order {$order_id}" );

				$trans_id = get_post_meta( $order_id, '_transaction_id', true );
				$captured = get_post_meta( $order_id, '_square_charge_captured', true );
				$location = Woocommerce_Square::instance()->integration->get_option( 'location' );
				$token    = get_option( 'woocommerce_square_merchant_access_token' );

				$this->connect->set_access_token( $token );

				$transaction_status = $this->connect->get_transaction_status( $location, $trans_id );

				if ( 'AUTHORIZED' === $transaction_status ) {
					$result = $this->connect->capture_transaction( $location, $trans_id ); // returns empty object
					
					if ( is_wp_error( $result ) ) {
						$order->add_order_note( __( 'Unable to capture charge!', 'woocommerce-square' ) . ' ' . $result->get_error_message() );

						throw new Exception( $result->get_error_message() );
					} elseif ( ! empty( $result->errors ) ) {
						$order->add_order_note( __( 'Unable to capture charge!', 'woocommerce-square' ) . ' ' . print_r( $result->errors, true ) );

						throw new Exception( print_r( $result->errors, true ) );
					} else {
						$order->add_order_note( sprintf( __( 'Square charge complete (Charge ID: %s)', 'woocommerce-square' ), $trans_id ) );
						update_post_meta( $order_id, '_square_charge_captured', 'yes' );
						$this->log( "Info: Capture successful for {$order_id}" );
					}
				}
			} catch ( Exception $e ) {
				$this->log( sprintf( __( 'Error unable to capture charge: %s', 'woocommerce-square' ), $e->getMessage() ) );
			}
		}
	}

	/**
	 * Cancel authorization
	 *
	 * @param  int $order_id
	 */
	public function cancel_payment( $order_id ) {
		$order = wc_get_order( $order_id );

		if ( 'square' === ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $order->payment_method : $order->get_payment_method() ) ) {
			try {
				$this->log( "Info: Cancel payment for order {$order_id}" );

				$trans_id = get_post_meta( $order_id, '_transaction_id', true );
				$captured = get_post_meta( $order_id, '_square_charge_captured', true );
				$location = Woocommerce_Square::instance()->integration->get_option( 'location' );
				$token    = get_option( 'woocommerce_square_merchant_access_token' );

				$this->connect->set_access_token( $token );
				
				$transaction_status = $this->connect->get_transaction_status( $location, $trans_id );

				if ( 'AUTHORIZED' === $transaction_status ) {
					$result = $this->connect->void_transaction( $location, $trans_id ); // returns empty object
					
					if ( is_wp_error( $result ) ) {
						$order->add_order_note( __( 'Unable to void charge!', 'woocommerce-square' ) . ' ' . $result->get_error_message() );
						throw new Exception( $result->get_error_message() );
					} elseif ( ! empty( $result->errors ) ) {
						$order->add_order_note( __( 'Unable to void charge!', 'woocommerce-square' ) . ' ' . print_r( $result->errors, true ) );

						throw new Exception( print_r( $result->errors, true ) );
					} else {
						$order->add_order_note( sprintf( __( 'Square charge voided! (Charge ID: %s)', 'woocommerce-square' ), $trans_id ) );
						delete_post_meta( $order_id, '_square_charge_captured' );
						delete_post_meta( $order_id, '_transaction_id' );
					}
				}
			} catch ( Exception $e ) {
				$this->log( sprintf( __( 'Unable to void charge!: %s', 'woocommerce-square' ), $e->getMessage() ) );
			}
		}
	}

	/**
	 * Logs
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param string $message
	 */
	public function log( $message ) {
		if ( $this->logging ) {
			WC_Square_Payment_Logger::log( $message );
		}
	}
}

new WC_Square_Payments( new WC_Square_Payments_Connect() );
