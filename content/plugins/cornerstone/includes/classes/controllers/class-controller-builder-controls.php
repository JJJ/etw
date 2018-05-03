<?php

class Cornerstone_Controller_Builder_Controls extends Cornerstone_Plugin_Component {

  public function post_options( $data ) {

		if ( ! current_user_can('edit_posts') ) {
      return new WP_Error( 'cornerstone', 'Unauthorized' );
    }

    if ( ! isset( $data['post_type'] ) ) {
      return new WP_Error( 'cornerstone', 'post_type not set' );
    }

    $posts = get_posts( apply_filters('cs_builder_control_post_options_args', array(
      'post_type' => $data['post_type'],
      'post_status' => isset( $data['post_status'] ) ? $data['post_status'] : array( 'any', 'tco-data' ),
      'orderby' => 'type',
      'posts_per_page' => 2500
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
