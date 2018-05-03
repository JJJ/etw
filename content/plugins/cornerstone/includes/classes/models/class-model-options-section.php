<?php

class Cornerstone_Model_Options_Section extends Cornerstone_Plugin_Component {

  public $resources = array();
  public $name = 'options/section';

  public function setup() {
    $options_manager = $this->plugin->loadComponent( 'Options_Manager' );
    $options_manager->register();
    $records = $options_manager->get_sections();

    foreach ($records as $record) {
      $this->resources[] = $this->to_resource( $record );
    }
  }

  public function query( $params ) {

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
      'data' => ( isset( $params['single'] ) ) ? ( isset( $queried[0] ) ? $queried[0] : new stdClass ) : $queried,
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

  public function to_resource( $record ) {

    $resource = array(
      'id' => $record['id'],
      'type' => $this->name,
      'relationships' => array()
    );

    if ( isset( $record['parent'] ) ) {
      $resource['relationships']['parent'] = array(
        'data' => array( 'type' => $this->name, 'id' => $record['parent'] )
      );
    }

    if ( isset( $record['children'] ) ) {
      $resource['relationships']['children'] = array( 'data' => array() );
      foreach ($record['children'] as $child) {
        $resource['relationships']['children']['data'][] = array( 'type' => $this->name, 'id' => $child );
      }
    }

    if ( isset( $record['controls'] ) ) {
      $resource['relationships']['controls'] = array( 'data' => array() );
      foreach ($record['controls'] as $control) {
        $resource['relationships']['controls']['data'][] = array( 'type' => 'options/control', 'id' => $control );
      }
    }

    unset( $record['id'] );
    unset( $record['type'] );
    unset( $record['parent'] );
    unset( $record['controls'] );
    unset( $record['children'] );

    $resource['attributes'] = $record;

    return $resource;

  }
}
