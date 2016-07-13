<?php
/**
 * Fusion Framework
 *
 * Flexible Framework for ThemeFusion Wordpress Themes
 *
 * This file includes and loads all objects and functions necessary for the fusion framework.
 *
 * @author		ThemeFusion
 * @copyright	(c) Copyright by ThemeFusion
 * @link		http://theme-fusion.com
 * @package 	FusionFramework
 * @since		Version 1.0
 */ 
 
define( 'FUSION_FRAMEWORK_VERSION', '1'); 

if( ! function_exists( 'fusion_block_direct_access' ) ) {
	/**
	 * Blocks direct accessing of a core file
	 * @param  none
	 * @return void
	 */
	function fusion_block_direct_access() {
		if( ! defined( 'ABSPATH' ) ) {
			exit( 'Direct script access denied.' );
		}
	}
}

/**
 * Load all needed framework classes
 */
require( 'class-breadcrumbs.php' );

/**
 * Load all needed framework functions that don't belong to a separate class
 */
require( 'fusion-functions.php' );

/**
 * Avada Welcome Screen
 *
 * @since 3.8.0
 */ 
require_once ( 'avada-admin/avada.php' );

/**
 * Ajax Functions
 *
 * @since 3.8.0
 */ 
require_once ( 'ajax-functions.php' );

/**
 * On the fly image resizer. Shoestrap
 *
 * @since 3.8.0
 */ 
require_once ( 'fusion-image-resizer.php' );