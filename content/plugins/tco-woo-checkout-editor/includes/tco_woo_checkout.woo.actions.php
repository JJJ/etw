<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Tco_Woo_Actions' ) ) {


	/**
	 * TcoWooCheckout WooCommerce Actions class
     * 
	 * Holds all WordPress actions
     *
	 * @package TcoWooCheckout
	 * @since 1.0.0
	 */
	class Tco_Woo_Actions{

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

			//Load scripts and styles for the frontend
            add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts_styles'));

			//File Upload Ajax Actions
			add_action( 'wp_ajax_nopriv_tco_woo_handle_file_upload', array(&$this, 'handle_file_upload'));
			add_action( 'wp_ajax_tco_woo_handle_file_upload', array(&$this, 'handle_file_upload'));
		}


		/**
         * Load Required JavaScripts and CSS
         *
         * @since 1.0.0
         */
        function enqueue_scripts_styles(){

			//Load dialogs
			
			wp_enqueue_style('tco_woo_front_css', TCOW_PLUGIN_URL . '/assets/css/front.css', false, TCOW_VERSION);
            wp_enqueue_script('tco_woo_scripts', TCOW_PLUGIN_URL.'/assets/js/tco_woo_scripts.js', array('jquery'), '', true);
            wp_localize_script('tco_woo_scripts', 'tco_woo_js', array(
                                                                        'tco_woo_url' => get_bloginfo('url'), 
                                                                        'ajaxurl'       => admin_url('admin-ajax.php'), 
																		'uploading'     => __("Uploading", "tco_woo_checkout"),
                                                                        'processing'    => __("Processing, please wait", "tco_woo_checkout"), 
                                                                        'error'         => __("An error occured. Please try again", "tco_woo_checkout"),
																		'loading_image' => TCOW_PLUGIN_URL.'/assets/img/update.gif'
                                                                     ));
        }

		/**
         * Handle File Upload
		 *
         * @return Json response
		 *
         * @since 1.0.0
         */
		function handle_file_upload(){
			$response = array(
							 	'error'   => true, 
							 	'message' => __('An error occured','tco_woo_checkout')
							 );

			global $tco_woo_woo_checkout;

			//Look for fix. Enabling this returns -1 all the time for some reason
			//check_ajax_referer( 'tco_woo_file_upload', 'security' );

			$arr_file_type = wp_check_filetype(basename($_FILES['tco_woo_file']['name']));
			$uploaded_type = $arr_file_type['type'];

			if(in_array($uploaded_type,$tco_woo_woo_checkout->allowed_file_types)){
				$file = wp_upload_bits( $_FILES['tco_woo_file']['name'], null, @file_get_contents( $_FILES['tco_woo_file']['tmp_name'] ) );
				if ( FALSE === $file['error'] ) {
					$file_url = $file['url'];
					$file_path = $file['file'];
					

					$response = array(
							 			'error'   => false, 
							 			'message' => __('File uploaded','tco_woo_checkout'),
										'url'     => $file_url,
										'path'    => $file_path
							 		 );
				}
			}else{
				$response = array(
								  	'error'   => true, 
								  	'message' => __('Invalid file type','tco_woo_checkout')
								 );
			}

			wp_send_json($response);
		}
	}

	Tco_Woo_Actions::instance();

}
?>