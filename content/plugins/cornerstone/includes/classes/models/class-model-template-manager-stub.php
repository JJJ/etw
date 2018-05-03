<?php

class Cornerstone_Model_Template_Manager_Stub extends Cornerstone_Plugin_Component {

  public $resources = array();
  public $name = 'template-manager/stub';

  public function load_all() {

    $posts = get_posts( array(
      'post_type' => array( 'cs_template', 'cs_user_templates' ),
      'post_status' => array( 'tco-data', 'publish' ),
      'orderby' => 'type',
      'posts_per_page' => 2500,
    ) );

    foreach ($posts as $post) {
      $record = $this->make_record( $post );
      if ( $record ) {
        $this->resources[] = $this->to_resource( $record );
      }
    }

  }

  public function make_record( $post, $load_meta = false ) {

    try {

      $template = new Cornerstone_Template( $post );

      if ( 'pro' !== csi18n('app.integration-mode') && in_array( $template->get_type(), array('header', 'footer' ) ) ) {
        return false;
      }

      if ( $load_meta ) {
        $template->load_meta();
      }

      $record = $template->serialize();

      return $record;

    } catch (Exception $e) {

    }

    return null;

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
        $queried[] = $this->to_resource( $this->make_record( (int) $params['query']['id'], true ) );
      } catch( Exception $e ) {
        return $this->make_error_response( 'Header not found' );
      }
    }

    return $this->make_response( ( isset( $params['single'] ) && isset( $queried[0] ) ) ? $queried[0] : $queried );

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

  public function update( $params ) {

    $atts = $this->atts_from_request( $params );

    if ( ! $atts['id'] ) {
      throw new Exception( 'Attempting to update template without specifying an ID.' );
    }

    $id = $atts['id'];

    $template = new Cornerstone_Template( $id );

    if ( isset( $atts['title'] ) ) {
      $template->set_title( $atts['title'] );
    }

    if ( isset( $atts['type'] ) ) {
      $template->set_type( $atts['type'] );
    }

    if ( isset( $atts['subtype'] ) ) {
      $template->set_subtype( $atts['subtype'] );
    }

    if ( isset( $atts['preview'] ) ) {
      $template->set_preview( $atts['preview'] );
    }

    if ( isset( $atts['hidden'] ) ) {
      $template->set_hidden( $atts['hidden'] );
    }

    if ( isset( $atts['meta'] ) ) {
      $template->set_meta( $atts['meta'] );
    }

    $saved = $template->save();

    return $this->make_response( $this->to_resource( $saved ) );
  }

  // public function query_match( $resource, $query ) {
  //
  //   foreach ( $query as $key => $value ) {
  //
  //     // Check relationships
  //     if ( isset( $resource['relationships'][ $key ] )  ) {
  //
  //       if ( ! isset( $resource['relationships'][ $key ]['data'] ) ) {
  //         return false;
  //       }
  //
  //       $data = $resource['relationships'][ $key ]['data'];
  //
  //       if ( isset( $data['id'] ) && $value !== $data['id'] ) {
  //         return false;
  //       } else {
  //         foreach ( $data as $child ) {
  //           if ( isset( $data['id'] ) && $value === $data['id'] ) {
  //             return true;
  //           }
  //         }
  //         return false;
  //       }
  //
  //     } else {
  //       if ( ! isset( $resource[ $key ] ) || $resource[ $key ] !== $value ) {
  //         return false;
  //       }
  //     }
  //
  //   }
  //
  //   return true;
  // }

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

    unset( $record['id'] );
    $resource['attributes'] = $record;

    return $resource;

  }

  public function make_error_response( $message, $status = 404 ) {
    return array(
      'errors' => array(
        array( 'status' => $status, 'title' => $message )
      )
    );
  }

}
