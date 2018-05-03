<?php

class Cornerstone_Model_Content_Content extends Cornerstone_Plugin_Component {

  public $dependencies = array( 'Regions', 'Footer_Assignments' );
  public $resources = array();
  public $name = 'content/content';

  public function load_all() {

    $posts = get_posts( array(
      'post_type' => $this->plugin->common()->getAllowedPostTypes(),
      'post_status' => 'any',
      'orderby' => 'type',
      'posts_per_page' => 2500
    ) );

    foreach ($posts as $post) {
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
    $content = new Cornerstone_Content( $post );
    $record = $content->serialize();
    $record['post-type'] = $post->post_type;
    $record['language'] = $this->plugin->loadComponent('Wpml')->get_language_data_from_post( $post, true );
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

  // public function create( $params ) {
  //   $atts = $this->atts_from_request( $params );
  //   $content = new Cornerstone_Content( $atts );
  //   return $this->make_response( $this->to_resource( $content->save() ) );
  // }

  // public function delete( $params ) {
  //   $atts = $this->atts_from_request( $params );
  //
  //   if ( ! $atts['id'] ) {
  //     throw new Exception( 'Attempting to delete Content without specifying an ID.' );
  //   }
  //
  //   $id = (int) $atts['id'];
  //
  //   $content = new Cornerstone_Content( $id );
  //   $content->delete();
  //
  //   return $this->make_response( array( 'id' => $id, 'type' => $this->name ) );
  // }

  public function update( $params ) {

    $atts = $this->atts_from_request( $params );

    if ( ! $atts['id'] ) {
      throw new Exception( 'Attempting to update Content without specifying an ID.' );
    }

    $id = (int) $atts['id'];

    $content = new Cornerstone_Content( $id );

    if ( isset( $atts['elements'] ) ) {
      $content->set_elements( $atts['elements'] );
    }

    if ( isset( $atts['settings'] ) ) {
      $content->set_settings( $atts['settings'] );
    }

    return $this->make_response( $this->to_resource( $content->save() ) );
  }

}
