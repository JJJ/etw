<?php

/*
Plugin Name:         Woo Checkout Editor
Plugin URI:          #
Description:         Manage your WooCommerce checkout fields
Version:             2.0.1
Author:              Themeco
Author URI:
Text Domain:         tco_woo_checkout
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Tco_Woo_Checkout' ) ) :

    /**
	 * Tco Woo Checkout Manager plugin setup class.
	 *
	 * @package TcoWooCheckout
	 * @since 1.0.0
	 */
    class Tco_Woo_Checkout{

        /**
         * Current plugin version.
         *
         * @since 1.0.0
         * @var string
         */
        public $version = '2.0.1';


        /**
         * The single instance of the class
         *
         * @since 1.0.0
         */
        protected static $_instance = null;


        /**
         * Get the instance
         *
         * @since 1.0.0
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Main plugin constructor
         *
         */
        public function __construct() {

            //Define our plugin constants
            $this->define_constants();

            //Load required classes
            $this->load_includes();

            //localize the plugin
		    add_action( 'plugins_loaded', array( &$this, 'localization' ), 9 );

            //Check if WooCommerce is installed
            add_action( 'plugins_loaded', array( &$this, 'activation_check' ), 11 );
        }


        /**
         * Define Plugin constants
         *
         * @since 1.0.0
         */
        private function define_constants(){
            $this->define( 'TCOW_PLUGIN_FILE', __FILE__ );
            $this->define( 'TCOW_VERSION', $this->version );
            $this->define( 'TCOW_PLUGIN_DIR', WP_PLUGIN_DIR.'/'.dirname(plugin_basename(__FILE__)) );
            $this->define( 'TCOW_PLUGIN_URL', plugin_dir_url(__FILE__));
            $this->define( 'X_WOO_CHECKOUT_MANAGER_VERSION', '1.0.0' );

        }

        /**
         * Load files from the includes directory
         *
         * @since 1.0.0
         */
        private function load_includes(){
            include_once( TCOW_PLUGIN_DIR . '/includes/tco_woo_checkout.data.php' );
            include_once( TCOW_PLUGIN_DIR . '/includes/tco_woo_checkout.woo.checkout.admin.php' );
            include_once( TCOW_PLUGIN_DIR . '/includes/tco_woo_checkout.woo.hooks.php' );
            include_once( TCOW_PLUGIN_DIR . '/includes/tco_woo_checkout.woo.functions.php' );
            include_once( TCOW_PLUGIN_DIR . '/includes/tco_woo_checkout.woo.actions.php' );
        }


        /**
         * Define constant if not already set
         *
         * @param  string $name
         * @param  string|bool $value
         *
         * @since 1.0.0
         */
        private function define( $name, $value ) {
  		    if ( ! defined( $name ) ) {
  			   define( $name, $value );
  		    }
  	    }

        /**
         * Plugin Text Domains
         * Localize the plugin
         *
         * @since 1.0.0
         */
        function localization(){
            $lang_dir    = TCOW_PLUGIN_DIR. '/languages';
            $custom_path = WP_LANG_DIR . '/tco_woo_checkout-' . get_locale() . '.mo';
            if ( file_exists( $custom_path ) ) {
                load_textdomain( 'tco_woo_checkout', $custom_path );
            } else {
                load_plugin_textdomain( 'tco_woo_checkout', false, $lang_dir );
            }
        }

        /**
         * Check if required plugins are installed
         *
         * @since 1.0.0
         */
        function activation_check(){

            //Check if WooCommerce is installed and is active
            if ( ! function_exists( 'WC' ) ) {
                add_action( 'admin_notices', array( &$this, 'woocommerce_admin_notice' ) );
            }
        }

        /**
         * WooCommerce Admin notice
         * Error message shown to admin that WooCommerce is required
         *
         * @since 1.0.0
         */
        function woocommerce_admin_notice(){
            ?>
	        <div class="error">
		        <p><?php _e( 'X Woo Checkout Manager requires WooCommerce in order to work.', 'tco_woo_checkout' ); ?></p>
	        </div>
            <?php
        }
    }

    //initialise our class
    $tco_woo_woo_checkout = Tco_Woo_Checkout::instance();
else:

    /**
	 * Show a warning that another plugin with the same name exists
	 *
	 * @package TcoWooCheckout
	 * @since 1.0.0
	 */
    function tco_woo_checkout_error_notice(){
        $message = __("Another plugin already using the class name Tco_Woo_Checkout exists. The Tco Woo Checkout Manager plugin will not work as expected","tco_woo_checkout");
        echo"<div class='error'> <p>$message</p></div>";
    }

    add_action( 'admin_notices', 'tco_woo_checkout_error_notice' );

endif;
?>
