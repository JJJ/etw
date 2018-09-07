<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


if ( ! class_exists( 'Tco_Woo_Checkout_Admin' ) ) {

    /**
	 * TcoWooCheckout WooCommerce Checkout Admin class
     *
	 * Manage all th admin settings required for the plugin
     *
	 * @package TcoWooCheckout
	 * @since 1.0.0
	 */
    class Tco_Woo_Checkout_Admin{

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


        public function __construct() {

            //Set up the admin menu
            add_action('admin_menu', array(&$this, 'admin_menu'));
        }

        /**
         * Set up the admin menu to allow us to configure our plugin
         *
         * @since 1.0.0
         */
        public function admin_menu(){
            $page = add_submenu_page( 'woocommerce', __('Checkout Manager', 'tco_woo_checkout'), __('Checkout Manager', 'tco_woo_checkout'), 'manage_options', 'checkout-manager', array(&$this, 'admin_page'));

            //Load our required scripts and css
            add_action('admin_print_scripts-' . $page, array(&$this, 'admin_scripts'));
			add_action('admin_print_styles-' . $page, array(&$this, 'admin_css'));
        }

        public function admin_page(){

          $default_billing_fields = array('billing_first_name', 'billing_last_name', 'billing_company', 'billing_country', 'billing_address_1', 'billing_address_2', 'billing_city', 'billing_state', 'billing_postcode', 'billing_phone', 'billing_email');
          $default_shipping_fields = array('shipping_first_name', 'shipping_last_name', 'shipping_company', 'shipping_country', 'shipping_address_1', 'shipping_address_2', 'shipping_city', 'shipping_state', 'shipping_postcode', 'shipping_phone', 'shipping_email');


            ?>
            <div class="wrap woocommerce">
                <h2><?php _e("Checkout Manager","tco_woo_checkout");?></h2>
                <br class="clear">
                <ul class="subsubsub">
                    <?php
                        $section = (!empty($_GET['section'])) ? $_GET['section'] : 'billing';
                        $sections = array(
                                            'billing'  => __('Billing Fields', 'tco_woo_checkout'),
                                            'shipping' => __('Shipping Fields', 'tco_woo_checkout'),
                                            'other'    => __('Extra Fields', '  tco_woo_checkout')
                                        );
                        $section_html = array();
                        $last_tab = end($sections);
                        foreach ($sections as $stub => $title) {
                            $class = ($stub == $section) ? ' current' : '';
                            $section_html[] = '<li><a href="' . admin_url('admin.php?page=checkout-manager&amp;section=' . $stub) . '" class="'. $class . '">' . $title . '</a></li>  '.( $last_tab!= $title ? '|' : '');
                        }
                        echo implode("\n", $section_html);
                    ?>
                </ul>
                <br class="clear">
                <?php
                    if (isset($_POST['tco_woo_checkout_settings']) && check_admin_referer('tco_woo_checkout_settings', 'tco_woo_checkout_noncename')) {
                        Tco_Woo_Functions::save_checkout_fields(); //Save our fields
                        ?>
                        <div id="message" class="updated fade">
                            <h3><?php echo sprintf(__('%1$s Settings Updated','tco_woo_checkout'),ucfirst($section)); ?></h3>
                        </div>
                        <?php
                    }

					if (isset($_POST['tco_woo_checkout_settings_reset']) && check_admin_referer('tco_woo_checkout_settings', 'tco_woo_checkout_noncename')) {
                        Tco_Woo_Functions::reset_checkout_fields(); //Save our fields
                        ?>
                        <div id="message" class="updated fade">
                            <h3><?php echo sprintf(__('%1$s Settings Reset','tco_woo_checkout'),ucfirst($section)); ?></h3>
                        </div>

                        <?php
                    }
                    $checkout_fields = Tco_Woo_Functions::checkout_fields($section);
                    $default_woo_keys = Tco_Woo_Functions::default_woocommerce_checkout_keys($section);
                    $woocommerce_products = get_posts( array(
                        'post_type' => 'product',
                        'posts_per_page' => -1
                    ) );
                    switch ($section) {
                        case 'billing' :
                            ?>
                                <h2><?php _e("Billing Settings","tco_woo_checkout");?></h2>
                            <?php
                            break;

                        case 'shipping' :

                            ?>
                                <h2><?php _e("Shipping Settings","tco_woo_checkout");?></h2>
                            <?php
                            break;
                        case 'other' :

                            ?>
                                <h2><?php _e("Extra Fields","tco_woo_checkout");?></h2>
                            <?php
                            break;
                    }
                    include_once( TCOW_PLUGIN_DIR . '/templates/fields.php' );
                ?>
            </div>
            <?php
        }

        /**
         * Load all required scripts for the admin page
         *
         * @since 1.0.0
         */
        public function admin_scripts(){
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('jquery-ui-dialog');
            wp_enqueue_script('tco_woo_jquery_chosen', TCOW_PLUGIN_URL . '/assets/vendor/jquery-chosen/chosen.jquery.min.js', array('jquery'), TCOW_VERSION);
            wp_enqueue_script('tco_woo_jquery_modal', TCOW_PLUGIN_URL . '/assets/vendor/jquery-modal/jquery.modal.min.js', array('jquery'), TCOW_VERSION);
            wp_enqueue_script('tco_woo_checkout-admin', TCOW_PLUGIN_URL . '/assets/js/tco_woo_checkout.js', array('jquery'), TCOW_VERSION);
            wp_localize_script('tco_woo_checkout-admin', 'tco_woo_admin', array(
																		'update'     => __("Update Options", "tco_woo_checkout")
                                                                     ));
        }

        /**
         * Load all required css files for the admin page
         *
         * @since 1.0.0
         */
        public function admin_css(){
            wp_enqueue_style('tco_woo_css', TCOW_PLUGIN_URL . '/assets/css/admin.css', false, TCOW_VERSION);
            wp_enqueue_style('tco_woo_jquery_chosen', TCOW_PLUGIN_URL . '/assets/vendor/jquery-chosen/chosen.min.css', false, TCOW_VERSION);
            wp_enqueue_style('tco_woo_jquery_modal', TCOW_PLUGIN_URL . '/assets/vendor/jquery-modal/jquery.modal.min.css', false, TCOW_VERSION);
        }
    }

    Tco_Woo_Checkout_Admin::instance();
}

?>
