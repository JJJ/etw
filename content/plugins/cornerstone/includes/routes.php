<?php

/**
 * Routes.php
 * Map explicit AJAX endpoints to components
 */

return array(

	// Register Cornerstone endpoint and Admin AJAX fallback
	'endpoint_save'      => array( 'Save_Handler', 'ajax_handler' ),
	'render_element'     => array( 'Builder_Renderer', 'ajax_handler' ),
	'setting_sections'   => array( 'Settings_Manager', 'ajax_handler' ),
	'templates'          => array( 'Layout_Manager', 'ajax_templates' ),
	'template_migration' => array( 'Layout_Manager', 'ajax_template_migration' ),
	'save_template'      => array( 'Layout_Manager', 'ajax_save' ),
	'delete_template'    => array( 'Layout_Manager', 'ajax_delete' ),
	'cheatsheet'         => array( 'Cheatsheet', 'ajax_handler' ),

	// Admin AJAX only
	'dashboard_save_settings'     => array( 'Settings_Handler', 'ajax_save', false ),
  'dashboard_clear_style_cache' => array( 'Cleanup', 'ajax_clean_generated_styles', false ),
	'override'                    => array( 'Admin', 'ajax_override', false ),
	'dismiss_validation_notice'   => array( 'Admin', 'ajax_dismiss_validation_notice', false ),
	'update_check'                => array( 'Updates', 'ajax_update_check', false ),
	'validation'                  => array( 'Validation', 'ajax_validation', false ),
	'validation_revoke'           => array( 'Validation', 'ajax_revoke', false ),

);
