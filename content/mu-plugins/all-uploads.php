<?php

/**
 * Plugin name: Flox - NFS Uploads
 * Description: Point uploads to the NFS server
 * Author:      John James Jacoby
 * Author URI:  http://jjj.me
 * Version:     1.0.0
 */

// WordPress or bust
defined( 'ABSPATH' ) || exit();

/**
 * This function uses WordPress' `upload_dir` filter to point both the upload
 * path and URL to its remote NFS mount, located at files.flox.io.
 *
 * Note that array items do not contain trailing spaces, should you need to
 * change this later. Also note we use month & date based directory storage in
 * an attempt to avoid filename collisions.
 *
 * @author jjj
 * @param  array $attr
 * @return array
 */
function flox_nfs_uploads( $attr = array() ) {

	$blog_id = get_current_blog_id();

	// Root site?
	$multisite_dir = ( is_multisite() && ! ( is_main_network() && is_main_site() && defined( 'MULTISITE' ) ) )
		? '/sites/' . $blog_id
		: '';

	$site_url = get_blog_option( $blog_id, 'siteurl' );

	// Multisite is stupid
	return array(
		'path'    => '/srv/www/easttroyweb/public/content/uploads' . $multisite_dir . $attr['subdir'],
		'url'     => $site_url . '/content/uploads' . $multisite_dir . $attr['subdir'],
		'subdir'  => $attr['subdir'],
		'basedir' => '/srv/www/easttroyweb/public/content/uploads' . $multisite_dir,
		'baseurl' => $site_url . '/content/uploads' . $multisite_dir,
		'error'   => false
	);
}
add_filter( 'upload_dir', 'flox_nfs_uploads' );
