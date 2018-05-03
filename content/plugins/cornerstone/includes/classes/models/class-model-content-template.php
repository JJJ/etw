<?php

class Cornerstone_Model_Content_Template extends Cornerstone_Plugin_Component {

  public $resources = array();
  public $name = 'content/template';

  public function query( $params ) {

    $queried = array();
    $this->included = array();

    if ( isset( $params['query']['id'] ) ) {
      try {
        $queried[] = $this->to_resource( $this->make_record( $params['query']['id'] ) );
      } catch( Exception $e ) {
        return $this->make_error_response( 'Template not found: ' . $params['query']['id'] );
      }
    }

    return $this->make_response( ( isset( $params['single'] ) && isset( $queried[0] ) ) ? $queried[0] : $queried );
  }

  public function make_record( $post ) {

    $preset = new Cornerstone_Template( $post );
    $meta = $preset->get_meta();

    return array(
      'id'       => $preset->get_id(),
      'title'    => $preset->get_title(),
      'elements' => isset( $meta['elements'] ) ? $meta['elements'] : array()
    );
  }


  public function create( $params ) {

    $atts = $this->atts_from_request( $params );

    $template = new Cornerstone_Template( array(
      'title' => $atts['title'],
      'type'  => 'content',
      'meta'  => array(
        'elements' => $atts['elements']
      )
    ) );

    return $this->make_response( $this->to_resource( $template->save() ) );

  }

  public function update( $params ) {

    $atts = $this->atts_from_request( $params );

    if ( ! $atts['id'] ) {
      throw new Exception( 'Attempting to update template without specifying an ID.' );
    }

    $id = (int) $atts['id'];

    $template = new Cornerstone_Template( $id );

    if ( isset( $atts['title'] ) ) {
      $template->set_title( $atts['title'] );
    }

    if ( isset( $atts['elements'] ) ) {
      $template->set_meta( array( 'elements' => $atts['elements'] ) );
    }

    return $this->make_response( $this->to_resource( $template->save() ) );

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

  public function make_error_response( $message, $status = 404 ) {
    return array(
      'errors' => array(
        array( 'status' => $status, 'title' => $message )
      )
    );
  }
}
