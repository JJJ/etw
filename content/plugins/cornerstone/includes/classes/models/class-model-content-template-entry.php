<?php

class Cornerstone_Model_Content_Template_Entry extends Cornerstone_Plugin_Component {

  public $resources = array();
  public $name = 'content/template-entry';

  public function load_all() {

    $classic_templates = get_posts( array(
      'post_type'      => array( 'cs_user_templates' ),
      'post_status'    => array( 'tco-data', 'publish' ),
      'orderby'        => 'type',
      'posts_per_page' => 2500,
    ) );

    $templates = get_posts( array(
      'post_type' => array( 'cs_template' ),
      'post_status' => array( 'tco-data', 'publish' ),
      'orderby' => 'type',
      'posts_per_page' => 2500,
      'meta_key' => '_cs_template_type',
      'meta_value' => 'content',
    ) );

    $posts = array_merge( $classic_templates, $templates );

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

    $this->load_all();

    // Find All
    if ( empty( $params ) || ! isset( $params['query'] ) ) {
      return array(
        'data' => $this->resources
      );
    }

    $queried = array();
    $included = array();

    foreach ( $this->resources as $resource) {
      if ( $this->query_match( $resource, $params['query'] ) ) {
        $queried[] = $resource;
      } else {
        $included[] = $resource;
      }
    }

    return array(
      'data' => ( isset( $params['single'] ) ) ? $queried[0] : $queried,
      'included' => $included,
      'meta' => array( 'request_params' => $params )
    );
  }

  public function query_match( $resource, $query ) {

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


  protected function atts_from_request( $params ) {

    if ( ! isset( $params['model'] ) || ! isset( $params['model']['data'] ) || ! isset( $params['model']['data']['attributes'] ) ) {
      throw new Exception( 'Request to Classic Template model missing attributes.' );
    }

    $atts = $params['model']['data']['attributes'];

    if ( isset( $params['model']['data']['id'] ) ) {
      $atts['id'] = $params['model']['data']['id'];
    }

    return $atts;
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

    unset( $record['slug'] );
    $resource['attributes'] = $record;

    return $resource;

  }
}
