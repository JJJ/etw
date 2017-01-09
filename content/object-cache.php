<?php

/**
 * Plugin name: Spider-Cache
 * Plugin URI:  https://store.flox.io/plugins/spider-cache/
 * Description: A WordPress drop-in API for Memcached
 * Version:     2.0.0
 */

// WordPress or bust
defined( 'ABSPATH' ) || exit();

// Pull in required files
require_once WP_CONTENT_DIR . '/plugins/wp-spider-cache/wp-spider-cache/drop-ins/object-cache.php';
