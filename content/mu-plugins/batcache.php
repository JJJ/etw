<?php

/**
 * Plugin name: Batcache Manager
 * Plugin URI:  http://wordpress.org/extend/plugins/batcache/
 * Description: This optional plugin improves Batcache.
 * Author:      Andy Skelton
 * Author URI:  http://andyskelton.com/
 * Version:     1.2
 */

global $batcache;

// Do not load if our advanced-cache.php isn't loaded
if ( empty( $batcache ) || ! is_object( $batcache ) || ! method_exists( $wp_object_cache, 'incr' ) ) {
	return;
}

$batcache->configure_groups();

/**
 * Regen home and permalink on posts and pages
 *
 * @param  int $post_id
 * @return If post revision or post is not published
 */
function batcache_post( $post_id = 0 ) {

	// Bail on revisions or non-published posts
	if ( wp_is_post_revision( $post_id ) || ( 'publish' !== get_post_status( $post_id ) ) ) {
		return;
	}

	// Get home option
	$home = get_option( 'home' );

	// Clear caches
	batcache_clear_url( $home );
	batcache_clear_url( trailingslashit( $home ) );
	batcache_clear_url( get_permalink( $post_id ) );
}
add_action( 'clean_post_cache', 'batcache_post' );

/**
 * Used by batcache_post() to clean caches
 *
 * @global string $batcache
 * @param  string $url
 * @return boolean
 */
function batcache_clear_url( $url = '' ) {
	global $batcache;

	// Bail if no URL
	if ( empty( $url ) ) {
		return false;
	}

	$url_key   = md5( $url );
	$cache_key = $url_key . '_version';

	wp_cache_add( $cache_key, 0, $batcache->group );

	return wp_cache_incr( $cache_key, 1, $batcache->group );
}
