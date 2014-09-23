<?php

/**
 * Plugin Name: BP Multi Network
 * Plugin URI:  https://wordpress.org/plugins/bp-multi-network/
 * Description: Unique BuddyPress networks in your WordPress multi-network installation
 * Version:     0.2.0
 * Author:      The BuddyPress Community
 * Author URI:  http://buddypress.org
*/

/**
 * The main BuddyPress multi-network class
 *
 * This class adds filters to two places in BuddyPress to intercept and modify
 * database table prefixes based on the current network.
 */
class BP_Multi_Network {

	/**
	 * Array of BuddyPress user meta keys
	 *
	 * @var array
	 */
	private $user_meta_keys = array(
		'last_activity' => false,
		'bp_new_mention_count' => false,
		'bp_favorite_activities' => false,
		'bp_latest_update' => false,
		'total_friend_count' => false,
		'total_group_count' => false,
		'notification_groups_group_updated' => false,
		'notification_groups_membership_request' => false,
		'notification_membership_request_completed' => false,
		'notification_groups_admin_promotion' => false,
		'notification_groups_invite' => false,
		'notification_messages_new_message' => false,
		'notification_messages_new_notice' => false,
		'closed_notices' => false,
		'profile_last_updated' => false,
		'notification_activity_new_mention' => false,
		'notification_activity_new_reply' => false
	);

	/** Filters ***************************************************************/

	/**
	 * Setup some table filters
	 */
	public function __construct() {
		add_filter( 'bp_core_get_table_prefix', array( $this, 'filter_table_prefix'  ) );
		add_filter( 'bp_get_user_meta_key',     array( $this, 'filter_user_meta_key' ) );
	}

	/**
	 * Filter the table prefix and maybe add a network ID
	 *
	 * @param string $prefix
	 * @return string
	 */
	public function filter_table_prefix( $prefix = '' ) {

		// Override prefix if not main network and there is a prefix match
		if ( ! $this->is_main_network() && ( true === $this->is_base_prefix( $prefix ) ) ) {
			$prefix = $this->get_network_prefix();
		}

		// Use this network's prefix
		return $prefix;
	}

	/**
	 * Filter the appropriate BuddyPress user meta keys and prefix them with the
	 * ID of the network they belong to.
	 *
	 * @param string $key
	 * @return string
	 */
	public function filter_user_meta_key( $key = '' ) {

		// Bail if key is not BuddyPress user meta
		if ( ! isset( $this->user_meta_keys[ $key ] ) ) {
			return $key;
		}

		// Bail if on the main network
		if ( $this->is_main_network() ) {
			return $key;
		}

		// Set the user meta key to the new prefix
		if ( false === $this->user_meta_keys[ $key ] ) {
			$this->user_meta_keys[ $key ] = $this->get_network_prefix() . $key;
		}

		// Return the modified user meta key
		return $this->user_meta_keys[ $key ];
	}

	/** Helpers ***************************************************************/

	/**
	 * Whether or not the current query is from in the main network.
	 *
	 * The main network is typically ID 1, and does not have a modified prefix.
	 *
	 * @global object $wpdb
	 * @return boolean
	 */
	private function is_main_network() {
		global $wpdb;
		return (bool) ( $wpdb->siteid === 1 );
	}

	/**
	 * Compare a given prefix with the base prefix.
	 *
	 * @global object $wpdb
	 * @param string $prefix
	 * @return string
	 */
	private function is_base_prefix( $prefix = '' ) {
		global $wpdb;
		return (bool) ( $prefix === $wpdb->base_prefix );
	}

	/**
	 * Return the prefix for the current network
	 *
	 * @global object $wpdb
	 * @return string
	 */
	private function get_network_prefix() {
		global $wpdb;
		return $wpdb->get_blog_prefix( get_current_site()->blog_id );
	}
}
new BP_Multi_Network();
