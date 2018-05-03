<?php

class Cornerstone_Controller_Design_Cloud extends Cornerstone_Plugin_Component {

  public function cache_index( $data ) {

    if ( ! current_user_can( 'manage_options' ) ) {
      return new WP_Error( 'cornerstone', 'Unauthorized' );
    }

    if ( !isset( $data['index'] ) ) {
      return new WP_Error( 'cornerstone', 'Index missing.' );
    }

    set_transient( '_cs_design_cloud_index', $data['index'], 1 * HOUR_IN_SECONDS );

		return array( 'success' => true );

  }

  public function get_cached_index() {

    if ( ! current_user_can( 'manage_options' ) ) {
      return new WP_Error( 'cornerstone', 'Unauthorized' );
    }

		return array( 'cachedIndex' => get_transient( '_cs_design_cloud_index' ) );

  }

}
