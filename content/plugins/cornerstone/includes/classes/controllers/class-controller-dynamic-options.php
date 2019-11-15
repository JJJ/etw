<?php

class Cornerstone_Controller_Dynamic_Options extends Cornerstone_Plugin_Component {


  public function lookup( $data ) {
    if ( ! isset( $data['type'] ) ) {
      return new WP_Error( 'cornerstone', 'type not set' );
    }
    $type = $data['type'];
    return apply_filters( "cs_dynamic_options_$type", array(), $data );
  }


  public function post_picker( $data ) {

		if ( ! current_user_can('edit_posts') ) {
      return new WP_Error( 'cornerstone', 'Unauthorized' );
    }

    if ( ! isset( $data['post_type'] ) ) {
      return new WP_Error( 'cornerstone', 'post_type not set' );
    }

    $posts = get_posts( apply_filters('cs_dynamic_content_post_picker_args', array(
      'post_type' => $data['post_type'],
      'post_status' => isset( $data['post_status'] ) ? $data['post_status'] : array( 'any', 'tco-data' ),
      'orderby' => 'type',
      'posts_per_page' => apply_filters( 'cs_query_limit', 2500 )
    ) ) );

    $options = array();

    foreach ($posts as $post) {
      $options[] = array(
        'value' => $post->ID,
        'label' => $post->post_title,
      );
    }

    return array(
      'options' => $options
    );

  }

}
