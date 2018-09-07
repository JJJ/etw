<?php

class Cornerstone_Model_Content_Content extends Cornerstone_Plugin_Component {

  public $dependencies = array( 'Regions', 'Footer_Assignments' );
  public $resources = array();
  public $name = 'content/content';

  public function load_all() {

    if ( ! $this->plugin->component('App_Permissions')->user_can('content') ) {
      return;
    }

    $posts = get_posts( array(
      'post_type' => $this->plugin->component('App_Permissions')->get_user_post_types(),
      'post_status' => 'any',
      'orderby' => 'type',
      'posts_per_page' => apply_filters( 'cs_query_limit', 2500 )
    ) );

    foreach ($posts as $post) {

      $post_type_obj = get_post_type_object( $post->post_type );
      $caps = (array) $post_type_object->cap;

      if ( ! current_user_can( $caps['edit_post'], $post->ID ) ) {
        continue;
      }

      $records[] = $this->make_record( $post );

    }

    foreach ($records as $record) {
      $this->resources[] = $this->to_resource( $record );
    }
  }

  public function query( $params ) {

    // Find All
    if ( empty( $params ) || ! isset( $params['query'] ) ) {
      $this->load_all();
      return $this->make_response( $this->resources );
    }

    $queried = array();
    $this->included = array();

    if ( isset( $params['query']['id'] ) ) {
      try {
        $queried[] = $this->to_resource( $this->make_record( (int) $params['query']['id'] ) );
      } catch( Exception $e ) {
        return $this->make_error_response( 'Content not found' );
      }
    }

    return $this->make_response( ( isset( $params['single'] ) && isset( $queried[0] ) ) ? $queried[0] : $queried );

  }

  public function make_error_response( $message, $status = 404 ) {
    return array(
      'errors' => array(
        array( 'status' => $status, 'title' => $message )
      )
    );
  }

  public function make_record( $post ) {
    if ( is_int( $post ) ) {
      $post = get_post( $post );
    }

    $post_type_obj = get_post_type_object( $post->post_type );
    $caps = (array) $post_type_obj->cap;

    $skip = array();
    $skip[] = (int) get_option( 'page_for_posts' );

    if ( function_exists('wc_get_page_id') ) {
      $skip[] = (int) wc_get_page_id( 'shop' );
    }

    if ( in_array( (int) $post->ID, $skip, true ) ) {
      throw new Exception( 'cornerstone', 'Page content inaccessible.' );
    }

    if (! current_user_can( $caps['edit_post'], $post->ID ) || ! $this->plugin->component('App_Permissions')->user_can_access_post_type($post->post_type) ) {
      throw new Exception( 'cornerstone', 'Unauthorized' );
    }

    $content = new Cornerstone_Content( $post );
    $record = $content->serialize();
    $record['post-type'] = $post->post_type;
    $record['post-type-label'] = isset( $post_type_obj->labels ) ? $post_type_obj->labels->singular_name : $post->post_type;
    $record['edit-url'] = get_edit_post_link( $post->ID, '' );
    $record['language'] = $this->plugin->component('Wpml')->get_language_data_from_post( $post, true );
    return $record;
  }


  public function make_response( $data ) {

    $response = array(
      'data' => $data
    );

    if ( isset( $this->included ) ) {
      $response['included'] = $this->included;
    }

    return $response;

  }

  public function to_resource( $record ) {

    $resource = array(
      'id' => $record['id'],
      'type' => $this->name
    );

    if ( empty( $record['settings'] ) ) {
      unset($record['settings']);
    }

    unset( $record['id'] );
    $resource['attributes'] = $record;

    return $resource;

  }

  protected function atts_from_request( $params ) {

    if ( ! isset( $params['model'] ) || ! isset( $params['model']['data'] ) || ! isset( $params['model']['data']['attributes'] ) ) {
      throw new Exception( 'Request to Content model missing attributes.' );
    }

    $atts = $params['model']['data']['attributes'];

    if ( isset( $params['model']['data']['id'] ) ) {
      $atts['id'] = $params['model']['data']['id'];
    }

    return $atts;
  }

  public function update( $params ) {

    $atts = $this->atts_from_request( $params );

    if ( ! $atts['id'] ) {
      throw new Exception( 'Attempting to update Content without specifying an ID.' );
    }

    $post = get_post( (int) $atts['id'] );

    if ( ! $this->plugin->component('App_Permissions')->user_can_access_post_type($post->post_type) ) {
      throw new Exception( 'Unauthorized');
    }

    $content = new Cornerstone_Content( $post );

    if ( isset( $atts['elements'] ) ) {
      $content->set_elements( $atts['elements'] );
    }

    if ( isset( $atts['settings'] ) ) {
      $content->set_settings( $atts['settings'] );
    }

    return $this->make_response( $this->to_resource( $content->save() ) );
  }

}
