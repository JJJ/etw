<?php
/*
  AJAX Search Results
  Outputs search results as json to be displayed via jQuery in custom.js
*/

// Get the absolute path to wp-blog-header.php in the theme's WordPress directory
$this_directory       = dirname( __FILE__ );
$wordpress_directory  = str_replace( 'wp-content/themes/typable', '', $this_directory );
$wpblogheader         = $wordpress_directory . 'wp-blog-header.php';
$wpload               = $wordpress_directory . 'wp-load.php';
$wpconfig             = $wordpress_directory . 'wp-config.php';

// Set up WordPress
define( 'WP_USE_THEMES', false );

require $wpconfig;
$wp->init();
$wp->parse_request();
$wp->query_posts();
$wp->register_globals();

// Build an array of posts containing the search term

// Build an array of search results and output as json
$results = array();

if ( !empty( $posts ) ){
  foreach ( $posts as $post ){
	the_post();

	// Store the individual post title and url
	$result = array();
	$result["title"]  = get_title();
	$result["url"]    = get_permalink();

	// Add that post to the array of results
	array_push( $results, $result );

  }
}

// Output the results array as a json encoded string
// If $results is empty, we'll get a blank json collection.
echo json_encode( $results );
