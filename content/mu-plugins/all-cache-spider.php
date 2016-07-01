<?php

/**
 * Plugin name: Flox - Spider Cache Helper
 * Description: Blog integration, based on work by Andy Skelton
 * Author:      John James Jacoby
 * Author URI:  http://jjj.me
 * Version:     1.0.0
 */

// WordPress or bust
defined( 'ABSPATH' ) || exit();

global $spider_cache;

// Do not load if our advanced-cache.php isn't loaded
if ( empty( $spider_cache ) || ! is_object( $spider_cache ) || ! method_exists( $wp_object_cache, 'incr' ) ) {
	return;
}

$spider_cache->configure_groups();

/**
 * Regen home and permalink on posts and pages
 *
 * @param  int $post_id
 * @return If post revision or post is not published
 */
function spider_cache_post( $post_id = 0 ) {

	// Bail on revisions or non-published posts
	if ( wp_is_post_revision( $post_id ) || ( 'publish' !== get_post_status( $post_id ) ) ) {
		return;
	}

	// Get home option
	$home = get_option( 'home' );

	// Clear caches
	spider_cache_clear_url( $home );
	spider_cache_clear_url( trailingslashit( $home ) );
	spider_cache_clear_url( get_permalink( $post_id ) );
}
add_action( 'clean_post_cache', 'spider_cache_post' );

/**
 * Used by spider_cache_post() to clean caches
 *
 * @global Spider_Cache $spider_cache
 * @param  string $url
 * @return boolean
 */
function spider_cache_clear_url( $url = '' ) {
	global $spider_cache;

	// Bail if no URL
	if ( empty( $url ) ) {
		return false;
	}

	$url_key   = md5( $url );
	$cache_key = $url_key . '_version';

	wp_cache_add( $cache_key, 0, $spider_cache->group );

	return wp_cache_incr( $cache_key, 1, $spider_cache->group );
}
