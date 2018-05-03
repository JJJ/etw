<?php

class Cornerstone_Model_Options_Control extends Cornerstone_Plugin_Component {

  public $resources = array();
  public $name = 'options/control';

  public function setup() {
    $options_manager = $this->plugin->loadComponent( 'Options_Manager' );
    $options_manager->register();
    $records = $options_manager->get_controls();

    foreach ($records as $record) {
      $this->resources[] = $this->to_resource( $record, $options_manager );
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

  public function to_resource( $record, $options_manager ) {

    $resource = array(
      'id' => $record['id'],
      'type' => $this->name,
      'relationships' => array()
    );

    if ( isset( $record['section'] ) ) {
      $resource['relationships']['section'] = array(
        'data' => array( 'type' => 'options/section', 'id' => $record['section'] )
      );
    }

    $resource['relationships']['values'] = array( 'data' => array() );
    if ( $this->plugin->component( 'Options_Bootstrap' )->is_registered( $record['id'] ) ) {
      $resource['relationships']['values']['data'][] = array( 'type' => 'options/value', 'id' => $record['id'] );
    }

    unset( $record['id'] );
    unset( $record['section'] );
    $resource['attributes'] = $record;

    return $resource;

  }
}
