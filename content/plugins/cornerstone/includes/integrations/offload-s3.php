<?php

class Cornerstone_Integration_Offload_S3 {

	public static function should_load() {
		return function_exists( 'as3cf_init' );
	}

	public function __construct() {

    add_filter('cs_footer_load_content', array( $this, 'local_to_s3' ) );
    add_filter('cs_footer_update_content', array( $this, 's3_to_local' ) );

    add_filter('cs_header_load_content', array( $this, 'local_to_s3' ) );
    add_filter('cs_header_update_content', array( $this, 's3_to_local' ) );

    add_filter('cs_content_load_serialized_content', array( $this, 'local_to_s3' ) );
    add_filter('cs_content_update_serialized_content', array( $this, 's3_to_local' ) );

	}

  public function s3_to_local( $content ) {
    return apply_filters( 'as3cf_filter_post_s3_to_local', $content );
  }

  public function local_to_s3( $content ) {
    return apply_filters( 'as3cf_filter_post_local_to_s3', $content );
  }


}
