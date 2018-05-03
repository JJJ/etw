<?php

class Cornerstone_Model_Headers_Header extends Cornerstone_Plugin_Component {

  public $dependencies = array( 'Regions', 'Header_Assignments' );
  public $resources = array();
  public $name = 'headers/header';

  public function load_all() {

    $posts = get_posts( array(
      'post_type' => 'cs_header',
      'post_status' => 'any',
      'orderby' => 'type',
      'posts_per_page' => 2500
    ) );

    $records = array();

    foreach ($posts as $post) {
      $records[] = $this->make_record( $post );
    }

    // Filter $records here?

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
        return $this->make_error_response( 'Header not found' );
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
    $header = new Cornerstone_Header( $post );
    $record = $header->serialize();
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

  public function create( $params ) {

    $atts = $this->atts_from_request( $params );

    if ( isset( $atts['regions'] ) ) {
      $atts['regions'] = $this->plugin->loadComponent('Regions')->sanitize_regions( $atts['regions'] );
    }

    $header = new Cornerstone_Header( $atts );

    if ( isset( $atts['settings'] ) ) {
      $header->set_settings( $this->sanitize_settings( $atts['settings'] ) );
    }

    $saved = $header->save();
    $this->plugin->loadComponent('Regions')->reset_region_styles( 'header', $header );

    return $this->make_response( $this->to_resource( $saved ) );

  }

  protected function atts_from_request( $params ) {

    if ( ! isset( $params['model'] ) || ! isset( $params['model']['data'] ) || ! isset( $params['model']['data']['attributes'] ) ) {
      throw new Exception( 'Request to Header model missing attributes.' );
    }

    $atts = $params['model']['data']['attributes'];

    if ( isset( $params['model']['data']['id'] ) ) {
      $atts['id'] = $params['model']['data']['id'];
    }

    return $atts;
  }

  public function delete( $params ) {
    $atts = $this->atts_from_request( $params );

    if ( ! $atts['id'] ) {
      throw new Exception( 'Attempting to delete Header without specifying an ID.' );
    }

    $id = (int) $atts['id'];

    $header = new Cornerstone_Header( $id );
    $header->delete();

    return $this->make_response( array( 'id' => $id, 'type' => $this->name ) );
  }

  public function update( $params ) {

    $atts = $this->atts_from_request( $params );

    if ( ! $atts['id'] ) {
      throw new Exception( 'Attempting to update Header without specifying an ID.' );
    }

    $id = (int) $atts['id'];

    $header = new Cornerstone_Header( $id );

    if ( isset( $atts['title'] ) ) {
      $header->set_title( $atts['title'] );
    }

    if ( isset( $atts['regions'] ) ) {
      $header->set_regions( $this->plugin->loadComponent('Regions')->sanitize_regions( $atts['regions'] ) );
    }

    if ( isset( $atts['settings'] ) ) {
      $header->set_settings( $this->sanitize_settings( $atts['settings'] ) );
    }

    $saved = $header->save();
    $this->plugin->loadComponent('Regions')->reset_region_styles( 'header', $header );

    return $this->make_response( $this->to_resource( $saved ) );
  }

  public function sanitize_settings( $settings ) {

    $sanitized = array();
    $html_fields = array( 'customJS', 'customCSS' );

    foreach ($settings as $key => $value) {
      $sanitized[$key] = $this->plugin->common()->sanitize_value( $value, in_array($key, $html_fields, true ) );
    }

    return $sanitized;
  }

}
