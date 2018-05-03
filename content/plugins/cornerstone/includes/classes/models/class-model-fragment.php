<?php

class Cornerstone_Model_Fragment extends Cornerstone_Plugin_Component {

  public $name = 'fragment';

  public function query( $params ) {

    // Find All
    if ( empty( $params ) || ! isset( $params['query'] ) || ! isset( $params['query']['id'] ) ) {
      return false;
    }

    return array(
      'data' => array(
        'id' => $params['query']['id'],
        'type' => 'fragment',
        'attributes' => array(
          'value' => $this->resolve_data( $params['query']['id'] )
        )
      ),
      'meta' => array( 'request_params' => $params, 'ID' => $params['query']['id'] )
    );
  }

  public function resolve_data( $id ) {

    $path = explode('::', $id);

    if ( ! isset( $path[1] ) ) {
      throw new Exception( 'No action specified in request with params: ' . json_encode( $params ) );
    }

    $component_name = cs_to_component_name( $path[0] );

    try {
      $component = $this->plugin->loadComponent( $component_name );
    } catch( Exception $e  ) {
      throw $e;
    }

    if ( ! $component ) {
      throw new Exception( "Requested component '$component_name' does not exist." );
    }

    $action = $path[1];
    $method = array( $component, $action );

    if ( ! is_callable( $method ) ) {
      throw new Exception( "Method '$action' not present on handler: $component_name" );
    }

    return call_user_func_array( $method, array() );
  }

}
