<?php

class Cornerstone_Controller_Adapter extends Cornerstone_Plugin_Component {

  public function __call( $name, $arguments ) {

    $request = $arguments[0];

    $component_name = 'Model_' . cs_to_component_name( $name );

    try {
      $this->plugin->loadComponents( str_replace('_', '/', strtolower( $component_name ) ) );
      $model = $this->plugin->component( $component_name );
    } catch( Exception $e  ) {
      throw $e;
    }

    if ( ! $model ) {
      throw new Exception( "Requested model '$component_name' does not exist." );
    }

    if ( ! isset( $request['action'] ) ) {
      throw new Exception( 'No action specified in request with params: ' . json_encode( $request ) );
    }


    $action = $request['action'];
    $method = array( $model, $action );

    if ( ! is_callable( $method ) ) {
      throw new Exception( "Action '$action' not present on model: $component_name" );
    }

    $params = ( isset( $request['params'] ) && is_array( $request['params'] ) ) ? array( $request['params'] ) : array();
    return call_user_func_array( $method, $params );

  }

}
