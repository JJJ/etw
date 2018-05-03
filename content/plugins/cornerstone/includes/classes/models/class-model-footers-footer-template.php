<?php

class Cornerstone_Model_Footers_Footer_Template extends Cornerstone_Plugin_Component {

  public $resources = array();
  public $name = 'footers/footer/template';

  public function setup() {

    $posts = get_posts( array(
      'post_type' => array( 'cs_template' ),
      'post_status' => array( 'tco-data', 'publish' ),
      'orderby' => 'type',
      'posts_per_page' => 2500,
      'meta_key' => '_cs_template_type',
      'meta_value' => 'footer',
    ) );

    foreach ($posts as $post) {

      $record = $this->make_record( $post );
      if ( is_array( $record ) ) {
        $this->resources[] = $this->to_resource( $record );
      }

    }

  }

  public function make_record( $post ) {

    try {

      $template = new Cornerstone_Template( $post );

      if ( $template && ! $template->is_hidden() ) {
        return array(
          'id' => $template->get_id(),
          'title' => $template->get_title()
        );
      }

    } catch( Exception $e ) {

    }

    return null;

  }

  public function query( $params ) {

    // Find All
    if ( empty( $params ) || ! isset( $params['query'] ) ) {
      return $this->make_response( $this->resources );
    }

    $queried = array();
    $this->included = array();

    foreach ( $this->resources as $resource) {
      if ( $this->query_match( $resource, $params['query'] ) ) {
        $queried[] = $resource;
      } else {
        $this->included[] = $resource;
      }
    }

    return $this->make_response( ( isset( $params['single'] ) && isset( $queried[0] ) ) ? $queried[0] : $queried );

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

  public function query_match( $resource, $query ) {

    if ( isset( $query['id'] ) ) {
      $query['id'] = (int) $query['id'];
    }

    foreach ( $query as $key => $value ) {

      // Check relationships
      if ( isset( $resource['relationships'][ $key ] )  ) {

        if ( ! isset( $resource['relationships'][ $key ]['data'] ) ) {
          return false;
        }

        $data = $resource['relationships'][ $key ]['data'];

        if ( isset( $data['id'] ) && $value !== $data['id'] ) {
          return false;
        } else {
          foreach ( $data as $child ) {
            if ( isset( $data['id'] ) && $value === $data['id'] ) {
              return true;
            }
          }
          return false;
        }

      } else {
        if ( ! isset( $resource[ $key ] ) || $resource[ $key ] !== $value ) {
          return false;
        }
      }

    }

    return true;
  }

  public function create( $params ) {

    $atts = $this->atts_from_request( $params );

    if ( ! isset( $atts['title'] ) ) {
      throw new Exception( 'Footer template requires a title' );
    }

    if ( ! isset( $atts['meta'] ) || ! isset( $atts['meta']['footerId'] ) ) {
      throw new Exception( 'Saving footer template requires ID of existing footer ' );
    }

    $footer = new Cornerstone_Footer( (int) $atts['meta']['footerId'] );

    $footer_template = new Cornerstone_Template( array(
      'title' => $atts['title'],
      'type'  => 'footer',
      'meta'  => array(
        'regions' => $footer->get_regions(),
        'settings' => $footer->get_settings(),
      )
    ) );

    return $this->make_response( $this->to_resource( $footer_template->save() ) );

  }

  public function update( $params ) {

    $atts = $this->atts_from_request( $params );

    if ( ! $atts['id'] ) {
      throw new Exception( 'Attempting to update Footer Template without specifying an ID.' );
    }

    $id = (int) $atts['id'];

    $template = new Cornerstone_Template( $id );

    if ( isset( $atts['title'] ) ) {
      $template->set_title( $atts['title'] );
    }

    if ( isset( $atts['meta'] ) && isset( $atts['meta']['footerId'] ) ) {

      $footer = new Cornerstone_Footer( (int) $atts['meta']['footerId'] );

      $template->set_meta( array(
        'regions' => $footer->get_regions(),
        'settings' => $footer->get_settings(),
      ) );

    }

    return $this->make_response( $this->to_resource( $template->save() ) );

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

  public function to_resource( $record ) {

    $resource = array(
      'id' => $record['id'],
      'type' => $this->name
    );

    unset( $record['id'] );
    $resource['attributes'] = $record;

    return $resource;

  }

}
