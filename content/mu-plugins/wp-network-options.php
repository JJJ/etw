<?php

/**
 * Plugin name: Flox - Settings Overrides (Network)
 * Description: Filter WordPress network settings
 * Author:      The Flox Team
 * Author URI:  https://flox.io
 * Version:     0.0.1
 */

/**
 * Return key => value array of default network options
 *
 * @global array $super_admins
 * @return array
 */
function flox_get_default_network_options() {

	// Get the current site
	$timestamp = 1408167226;

	// Stuttter Specific
	$network_wide_plugins['user-switching/user-switching.php']         = $timestamp;
	$network_wide_plugins['wp-term-meta/wp-term-meta.php']             = $timestamp;
	$network_wide_plugins['wp-term-order/wp-term-order.php']           = $timestamp;
	$network_wide_plugins['wp-term-colors/wp-term-colors.php']         = $timestamp;
	$network_wide_plugins['wp-user-activity/wp-user-activity.php']     = $timestamp;
	$network_wide_plugins['wp-session-manager/wp-session-manager.php'] = $timestamp;

	return array(

		// Cannot officially add new users, yet
		'add_new_users'               => 0,

		// Default plugins and themes
		'active_sitewide_plugins'     => $network_wide_plugins,
		'allowed_themes'              => array(
			'swifter' => 1,
			'make' => 1
		),
		//'can_compress_scripts'        => 1,

		// Site
		//'site_admins'                 => get_super_admins(), // Always define $super_admins global
		'siteurl'                     => network_site_url( '/' ),

		// Other
		'global_terms_enabled'        => 0,
		'menu_items'                  => array(),

		// Sign-ups
		'registrationnotification'    => '',
		'registration'                => '',
		'banned_email_domains'        => '',
		'limited_email_domains'       => '',
		'illegal_names'               => array(
			'www',
			'web',
			'app',
			'jjj',
			'flox',
			'john',
			'root',
			'admin',
			'moderator',
			'main',
			'invite',
			'administrator',
			'groups',
			'members',
			'forums',
			'blogs',
			'activity',
			'profile',
			'friends',
			'search',
			'settings',
			'notifications',
			'register',
			'activate',
			'sign-up',
			'files',
			'blog',
			'pages',
			'page',
			'post',
			'category',
			'tag',
			'network',
			'site',
			'blog',
			'wordpress',
			'buddypress',
			'bbpress'
		),

		// Welcome emails get overridden
		'welcome_email'               => '',
		'welcome_user_email'          => '',

		// Uploads
		'ms_files_rewriting'          => 0,
		'upload_filetypes'            => 'jpg jpeg png gif mp3 mov avi wmv midi mid pdf',
		'upload_space_check_disabled' => 0,
		'blog_upload_space'           => 500,
		'fileupload_maxk'             => 5000,

		// Initial content
		'first_post'                  => '',
		'first_page'                  => '',
		'first_comment'               => '',
		'first_comment_url'           => '',
		'first_comment_author'        => '',

		// Only English for now
		'WPLANG'                      => 'en_EN'
	);
}

/**
 * Pre-filter network options, and force our defaults
 *
 * @param mixed $value
 * @return mixed
 */
function flox_pre_network_option( $value = '' ) {

	// Remove the possible filter prefixes
	$filter  = current_filter();
	$option  = str_replace( 'default_site_option_',    '', $filter );
	$option  = str_replace( 'pre_update_site_option_', '', $filter );
	$option  = str_replace( 'pre_site_option_',        '', $filter );
	$options = flox_get_default_network_options();

	// Check the options global for preset value
	if ( isset( $options[ $option ] ) ) {
		$value = $options[ $option ];
	}

	// Always return a value, even if false
	return $value;
}

/**
 * Add filters to update/get site option functions, so we can force our own
 * dystopian values upon them.
 */
function flox_setup_network_option_filters() {

	// Get default network options
	$options = array_keys( flox_get_default_network_options() );

	// Filter network options
	foreach ( $options as $key ) {
		add_filter( 'default_site_option_'    . $key, 'flox_pre_network_option', 99 );
		add_filter( 'pre_update_site_option_' . $key, 'flox_pre_network_option', 2  );
		add_filter( 'pre_site_option_'        . $key, 'flox_pre_network_option', 2  );
	}
}

// Setup the network option filters (muplugins_loaded is too late)
flox_setup_network_option_filters();
