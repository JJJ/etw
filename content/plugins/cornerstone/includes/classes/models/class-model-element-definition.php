<?php

class Cornerstone_Model_Element_Definition extends Cornerstone_Plugin_Component {

  public $resources = array();
  public $name = 'element/definition';

  public function setup() {

    $records = $this->plugin->loadComponent( 'Element_Manager' )->get_elements();
    //$records = include('precompiled/elements.php');

    foreach ($records as $record) {
      $this->resources[] = $this->to_resource( $record );
    }
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

  public function to_resource( $record ) {

    $resource = array(
      'id' => $record['id'],
      'type' => $this->name,
      'relationships' => array()
    );

    $record['control-groups'] = array();

    if ( isset( $record['control_groups'] ) ) {
      $record['control-groups'] = $record['control_groups'];
      unset( $record['control_groups'] );
    }

    if ( isset( $record['presets'] ) ) {
      $resource['relationships']['presets'] = array( 'data' => array() );
      foreach ($record['presets'] as $preset) {
        $resource['relationships']['presets']['data'][] = array( 'type' => 'element/preset', 'id' => $preset );
      }
    }

    unset( $record['presets'] );
    unset( $record['id'] );
    $resource['attributes'] = $record;

    return $resource;

  }

}
