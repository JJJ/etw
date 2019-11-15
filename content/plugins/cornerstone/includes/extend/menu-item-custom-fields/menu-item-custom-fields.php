<?php

/**
 * Menu Item Custom Fields
 *
 * @package Menu_Item_Custom_Fields
 * @version 0.3.0
 * @author Dzikri Aziz <kvcrvt@gmail.com>
 *
 * Plugin name: Menu Item Custom Fields
 * Plugin URI: https://github.com/kucrut/wp-menu-item-custom-fields
 * Description: Easily add custom fields to nav menu items
 * Version: 0.3.0
 * Author: Dzikri Aziz
 * Author URI: http://kucrut.org/
 * License: GPLv2
 * Text Domain: menu-item-custom-fields
 *
 * Edits to Original
 * -----------------
 * 01. Changed filename.
 */

if ( ! class_exists( 'CS_Menu_Item_Custom_Fields' ) ) :
	/**
	* Menu Item Custom Fields Loader
	*/
	class CS_Menu_Item_Custom_Fields {

		/**
		* Add filter
		*
		* @wp_hook action wp_loaded
		*/
		public static function load() {
			add_filter( 'wp_edit_nav_menu_walker', array( __CLASS__, '_filter_walker' ), 99 );

			add_filter( 'cs_admin_app_data', array( __CLASS__, 'maybe_enqueue' ), 10, 2 );
		}

		public static function maybe_enqueue( $data, $hook ) {

			if ( false !== strpos( $hook, 'nav-menus.php' ) ) {
				$data['menu-item-custom-fields'] = array(
					'icons' => cs_fa_all()
				);
			}

			return $data;
		}


		/**
		* Replace default menu editor walker with ours
		*
		* We don't actually replace the default walker. We're still using it and
		* only injecting some HTMLs.
		*
		* @since   0.1.0
		* @access  private
		* @wp_hook filter wp_edit_nav_menu_walker
		* @param   string $walker Walker class name
		* @return  string Walker class name
		*/
		public static function _filter_walker( $walker ) {
			$walker = 'CS_Menu_Item_Custom_Fields_Walker';
			if ( ! class_exists( $walker ) ) {
				require_once dirname( __FILE__ ) . '/menu-item-custom-fields-walker.php'; // 01
			}

			return $walker;
		}
	}
	add_action( 'wp_loaded', array( 'CS_Menu_Item_Custom_Fields', 'load' ), 9 );
endif;
