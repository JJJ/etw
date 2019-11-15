<?php

class Cornerstone_Offload_S3 extends Cornerstone_Plugin_Component {

  public function setup() {

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
