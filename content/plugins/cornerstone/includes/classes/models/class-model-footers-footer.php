<?php

class Cornerstone_Model_Footers_Footer extends Cornerstone_Plugin_Component {

  public $dependencies = array( 'Regions', 'Footer_Assignments' );
  public $resources = array();
  public $name = 'footers/footer';

  public function load_all() {

    $posts = get_posts( array(
      'post_type' => 'cs_footer',
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

      }
    }

    return $this->make_response( ( isset( $params['single'] ) && isset( $queried[0] ) ) ? $queried[0] : $queried );

  }

  public function make_record( $post ) {
    if ( is_int( $post ) ) {
      $post = get_post( $post );
    }
    $footer = new Cornerstone_Footer( $post );
    $record = $footer->serialize();
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

    $footer = new Cornerstone_Footer( $atts );

    if ( isset( $atts['settings'] ) ) {
      $footer->set_settings( $this->sanitize_settings( $atts['settings'] ) );
    }

    $saved = $footer->save();
    $this->plugin->loadComponent('Regions')->reset_region_styles( 'footer', $footer );

    return $this->make_response( $this->to_resource( $saved ) );

  }

  protected function atts_from_request( $params ) {

    if ( ! isset( $params['model'] ) || ! isset( $params['model']['data'] ) || ! isset( $params['model']['data']['attributes'] ) ) {
      throw new Exception( 'Request to Footer model missing attributes.' );
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
      throw new Exception( 'Attempting to delete Footer without specifying an ID.' );
    }

    $id = (int) $atts['id'];

    $footer = new Cornerstone_Footer( $id );
    $footer->delete();

    return $this->make_response( array( 'id' => $id, 'type' => $this->name ) );
  }

  public function update( $params ) {

    $atts = $this->atts_from_request( $params );

    if ( ! $atts['id'] ) {
      throw new Exception( 'Attempting to update Footer without specifying an ID.' );
    }

    $id = (int) $atts['id'];

    $footer = new Cornerstone_Footer( $id );

    if ( isset( $atts['title'] ) ) {
      $footer->set_title( $atts['title'] );
    }

    if ( isset( $atts['regions'] ) ) {
      $footer->set_regions( $this->plugin->loadComponent('Regions')->sanitize_regions( $atts['regions'] ) );
    }

    if ( isset( $atts['settings'] ) ) {
      $footer->set_settings( $this->sanitize_settings( $atts['settings'] ) );
    }

    $saved = $footer->save();
    $this->plugin->loadComponent('Regions')->reset_region_styles( 'footer', $footer );

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
