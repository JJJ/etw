<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class WC_Square_Integration
 *
 * Settings CRUD for the extension.
 */
class WC_Square_Integration extends WC_Integration {
	private $oauth_connect_url;
	private $merchant_access_token;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->id                    = 'squareconnect';
		$this->method_title          = __( 'Square', 'woocommerce-square' );
		$this->method_description    = __( 'Connect with Square to start syncing your products and inventory and also accept credit card and debit card payments in your checkout.', 'woocommerce-square' );
		$this->merchant_access_token = get_option( 'woocommerce_square_merchant_access_token' );

		$this->maybe_save_token();
		$this->maybe_delete_token();

		$this->init_form_fields();
		$this->init_settings();

		$this->oauth_connect_url = 'https://connect.woocommerce.com/login/square';

		if ( WC_SQUARE_ENABLE_STAGING ) {
			$this->oauth_connect_url = 'https://connect.woocommerce.com/login/squaresandbox';
		}

		add_action( 'woocommerce_update_options_integration_' . $this->id, array( $this, 'process_admin_options' ) );
		add_filter( 'woocommerce_settings_api_form_fields_' . $this->id, array( $this, 'maybe_render_locations' ) );
	}

	/**
	 * Adds the form fields for the settings
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @return bool
	 */
	public function init_form_fields() {
		$application_dashboard_url = 'https://connect.squareup.com/apps';

		$form_fields = array(
			'location' => array(
				'title'       => __( 'Business Location', 'woocommerce-square' ),
				'type'        => 'select',
				'description' => __( 'Select the location you wish to link to this site. You must have <a href="https://squareup.com/dashboard/locations" target="_blank">locations</a> set in Square and approved.', 'woocommerce-square' ),
				'desc_tip'    => false,
				'options'     => array( '' => __( 'Select a Location', 'woocommerce-square' ) ),
				'disabled'    => true,
			),
			'sync_email' => array(
				'title'       => __( 'Notification Email', 'woocommerce-square' ),
				'type'        => 'text',
				'description' => __( 'Enter the email(s) to be notified when a sync has ended.  Separate each email with a comma.', 'woocommerce-square' ),
				'desc_tip'    => false,
				'default'     => '',
				'placeholder' => get_option( 'admin_email' ),
			),
			'logging' => array(
				'title'       => __( 'Logging', 'woocommerce-square' ),
				'label'       => __( 'Log debug messages', 'woocommerce-square' ),
				'type'        => 'checkbox',
				'description' => __( 'Save debug messages to the WooCommerce System Status log.', 'woocommerce-square' ),
				'default'     => 'no',
			),
			'sync_title' => array(
				'title'       => __( 'Synchronization', 'woocommerce-square' ),
				'type'        => 'title',
				'description' => __( 'Determine which aspects of your product catalog to synchronize between WooCommerce and Square. Products need to have SKUs set for each variation.', 'woocommerce-square' ),
			),
			'sync_products' => array(
				'title'       => __( 'Enabled', 'woocommerce-square' ),
				'type'        => 'checkbox',
				'label'       => __( 'Products', 'woocommerce-square' ),
				'description' => __( 'Basic Product information will be synced, excluding Categories and Inventory.', 'woocommerce-square' ),
				'default'     => 'yes',
			),
			'sync_categories' => array(
				'title'       => __( 'Include Categories', 'woocommerce-square' ),
				'type'        => 'checkbox',
				'label'       => __( 'Sync Categories', 'woocommerce-square' ),
				'description' => __( 'Categories will sync on creation or update, and Products will have their Categories synced.', 'woocommerce-square' ),
				'default'     => 'yes',
			),
			'sync_inventory' => array(
				'title'       => __( 'Include Inventory', 'woocommerce-square' ),
				'type'        => 'checkbox',
				'label'       => __( 'Sync Inventory', 'woocommerce-square' ),
				'description' => __( 'Inventory will sync on manual update or after a Product is ordered.', 'woocommerce-square' ),
				'default'     => 'yes',
			),
			'sync_images' => array(
				'title'       => __( 'Include Images', 'woocommerce-square' ),
				'type'        => 'checkbox',
				'label'       => __( 'Sync Images', 'woocommerce-square' ),
				'description' => __( 'Product Image will be synced.', 'woocommerce-square' ),
				'default'     => 'yes',
			),
			'inventory_polling' => array(
				'title'       => __( 'Square Inventory Sync', 'woocommerce-square' ),
				'type'        => 'checkbox',
				'label'       => __( 'Enable', 'woocommerce-square' ),
				'description' => __( 'For automatic inventory syncing from Square to WooCommerce, this needs to be enabled. It will poll the inventory from Square on an hourly basis.', 'woocommerce-square' ),
				'default'     => 'no',
			),
		);

		$this->form_fields = apply_filters( 'woocommerce_square_integration_settings_args', $form_fields );

		return true;
	}

	/**
	 * Add in our own custom options
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @return bool
	 */
	public function admin_options() {
		$current_user = wp_get_current_user();

		$redirect_url = add_query_arg(
			array(
				'page'    => 'wc-settings',
				'tab'     => 'integration',
				'section' => $this->id,
			),
			admin_url( 'admin.php' )
		);

		$redirect_url = wp_nonce_url( $redirect_url, 'connect_square', 'wc_square_token_nonce' );

		$query_args = array(
			'redirect' => urlencode( urlencode( $redirect_url ) ),
			'scopes'   => 'MERCHANT_PROFILE_READ,PAYMENTS_READ,PAYMENTS_WRITE,CUSTOMERS_READ,CUSTOMERS_WRITE,SETTLEMENTS_READ,ITEMS_READ,ITEMS_WRITE',
		);

		$production_connect_url = add_query_arg( $query_args, $this->oauth_connect_url );

		$disconnect_url = add_query_arg(
			array(
				'page'              => 'wc-settings',
				'tab'               => 'integration',
				'section'           => $this->id,
				'disconnect_square' => 1,
			),
			admin_url( 'admin.php' )
		);

		$disconnect_url = wp_nonce_url( $disconnect_url, 'disconnect_square', 'wc_square_token_nonce' );

		echo '<h2>' . esc_html( $this->get_method_title() ) . '</h2>';
		echo wp_kses_post( wpautop( $this->get_method_description() ) );
		echo '<div><input type="hidden" name="section" value="' . esc_attr( $this->id ) . '" /></div>';
		?>

			<table class="form-table">
				<tbody>
					<tr>
						<th>
							<?php esc_html_e( 'Connect/Disconnect', 'woocommerce-square' ); ?>
						</th>
						<td>
							<?php if ( ! empty( $this->merchant_access_token ) ) { ?>
								<a href="<?php echo esc_attr( $disconnect_url ); ?>" class='button-primary'>
									<?php echo esc_html__( 'Disconnect from Square', 'woocommerce-square' ); ?>
								</a>
							<?php } else { ?>
								<a href="<?php echo esc_attr( $production_connect_url ); ?>" class="wc-square-connect-button">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44" width="30" height="30">
									  <path fill="#FFFFFF" d="M36.65 0h-29.296c-4.061 0-7.354 3.292-7.354 7.354v29.296c0 4.062 3.293 7.354 7.354 7.354h29.296c4.062 0 7.354-3.292 7.354-7.354v-29.296c.001-4.062-3.291-7.354-7.354-7.354zm-.646 33.685c0 1.282-1.039 2.32-2.32 2.32h-23.359c-1.282 0-2.321-1.038-2.321-2.32v-23.36c0-1.282 1.039-2.321 2.321-2.321h23.359c1.281 0 2.32 1.039 2.32 2.321v23.36z" />
									  <path fill="#FFFFFF" d="M17.333 28.003c-.736 0-1.332-.6-1.332-1.339v-9.324c0-.739.596-1.339 1.332-1.339h9.338c.738 0 1.332.6 1.332 1.339v9.324c0 .739-.594 1.339-1.332 1.339h-9.338z" />
									</svg>
									<span><?php esc_html_e( 'Connect with Square', 'woocommerce-square' ); ?></span>
								</a>
							<?php } ?>
						</td>
					</tr>
				</tbody>
			</table>

			<?php
			if ( ! empty( $this->merchant_access_token ) ) { ?>
					<?php echo '<table class="form-table">' . $this->generate_settings_html( $this->get_form_fields(), false ) . '</table>'; ?>
				<?php

				// only show rest of the settings if a location is selected
				if ( $this->get_option( 'location' ) ) :
				?>
				<h3 class="wc-settings-sub-title"><?php esc_html_e( 'Initiate a Manual Sync', 'woocommerce-square' ); ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row" class="titledesc">
							<label for="wc-to-square"><?php esc_html_e( 'WC &rarr; Square Sync', 'woocommerce-square' ); ?></label>
							<?php echo wc_help_tip( __( 'Click button to perform a one time sync from WooCommerce to Square.', 'woocommerce-square' ) ); ?>
						</th>
						<td class="forminp">
							<a href="#" id="wc-to-square" class="button button-secondary"><?php esc_html_e( 'WC &rarr; Square', 'woocommerce-square' ); ?></a>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" class="titledesc">
							<label for="square-to-wc"><?php esc_html_e( 'Square &rarr; WC Sync', 'woocommerce-square' ); ?></label>
							<?php echo wc_help_tip( __( 'Click button to perform a one time sync from Square to WooCommerce.', 'woocommerce-square' ) ); ?>
						</th>
						<td class="forminp">
							<a href="#" id="square-to-wc" class="button button-secondary"><?php esc_html_e( 'Square &rarr; WC', 'woocommerce-square' ); ?></a>
						</td>
					</tr>
				</table>
				<?php endif;

				do_action( 'woocommerce_square_integration_custom_settings' );
			}
	}

	/**
	 * Maybe save the token from authentication.
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @return bool
	 */
	public function maybe_save_token() {
		if ( empty( $_GET['square_access_token'] ) ) {
			return false;
		}

		if ( function_exists( 'wp_verify_nonce' ) && ! wp_verify_nonce( $_GET['wc_square_token_nonce'], 'connect_square' ) ) {
			wp_die( __( 'Cheatin&#8217; huh?', 'woocommerce-square' ) );
		}

		$existing_token = get_option( 'woocommerce_square_merchant_access_token' );

		// if token already exists, don't continue
		if ( ! empty( $existing_token ) ) {
			return false;
		}

		update_option( 'woocommerce_square_merchant_access_token', sanitize_text_field( urldecode( $_GET['square_access_token'] ) ) );

		// let's set the token instance again so settings option is refreshed
		$this->merchant_access_token = get_option( 'woocommerce_square_merchant_access_token' );

		delete_transient( WC_Square_Connect::LOCATIONS_CACHE_KEY );

		return true;
	}

	/**
	 * Maybe delete the token for merchant.
	 *
	 * @todo perhaps we should also revoke the token fromm connect.woocommerce.com??
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @return bool
	 */
	public function maybe_delete_token() {
		if ( empty( $_GET['disconnect_square'] ) ) {
			return false;
		}

		if ( function_exists( 'wp_verify_nonce' ) && ! wp_verify_nonce( $_GET['wc_square_token_nonce'], 'disconnect_square' ) ) {
			wp_die( __( 'Cheatin&#8217; huh?', 'woocommerce-square' ) );
		}

		$existing_token = get_option( 'woocommerce_square_merchant_access_token' );

		// if token does not exist, don't continue
		if ( empty( $existing_token ) ) {
			return false;
		}

		delete_option( 'woocommerce_square_merchant_access_token' );

		// let's set the token instance again so settings option is refreshed
		$this->merchant_access_token = get_option( 'woocommerce_square_merchant_access_token' );

		delete_transient( WC_Square_Connect::LOCATIONS_CACHE_KEY );

		return true;
	}

	/**
	 * Validates location field.
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 * @return bool
	 */
	public function validate_location_field( $key ) {
		$field = $this->get_field_key( $key );
		$value = ! empty( $_POST[ $field ] ) ? $_POST[ $field ] : '';

		$token = $this->get_option( 'token' );
		if ( empty( $token ) && empty( $value ) ) {
			delete_transient( WC_Square_Connect::LOCATIONS_CACHE_KEY );
		}

		return $this->validate_select_field( $key, $value );
	}

	/**
	 * Maybe render list of locations.
	 *
	 * @param array $form_fields Form fields
	 *
	 * @return array Form fields
	 */
	public function maybe_render_locations( $form_fields ) {
		$locations = Woocommerce_Square::instance()->square_connect->get_square_business_locations();
		if ( ! empty( $locations ) && ! empty( $form_fields ) ) {
			$form_fields['location']['options']  = array_merge( $form_fields['location']['options'], $locations );
			$form_fields['location']['disabled'] = false;
		}

		return $form_fields;
	}
}
