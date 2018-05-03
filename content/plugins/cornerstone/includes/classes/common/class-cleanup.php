<?php

class Cornerstone_Cleanup extends Cornerstone_Plugin_Component {

  public function clean_generated_styles() {
    global $wpdb;
    $wpdb->delete( $wpdb->postmeta, array( 'meta_key' => '_cs_generated_styles' ) );
  }

  public function ajax_clean_generated_styles( $data ) {

		if ( ! current_user_can( 'manage_options' ) ) {
			return cs_send_json_error();
		}

    $this->clean_generated_styles();

		return cs_send_json_success();

	}

}
