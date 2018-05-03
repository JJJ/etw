<?php

class Cornerstone_Model_Option extends Cornerstone_Plugin_Component {

  public $name = 'option';

  public function lookup( $option ) {
    $default = apply_filters( "cornerstone_option_model_save_$option", apply_filters( "cornerstone_option_model_defaults_$option", null ) );
    return apply_filters( "cornerstone_option_model_load_$option", get_option( $option, $default ) );
  }

  public function query( $params ) {

    // Find All
    if ( empty( $params ) || ! isset( $params['query'] ) || ! isset( $params['query']['id'] ) ) {
      return false;
    }

    $this->validate( $params['query']['id'], 'access' );
    $option = $params['query']['id'];

    return array(
      'data' => array(
        'id' => $params['query']['id'],
        'type' => 'option',
        'attributes' => array(
          'value' => $this->lookup( $option )
        )
      ),
      'meta' => array( 'request_params' => $params, 'ID' => $params['query']['id'] )
    );
  }

  protected function validate( $id, $operation ) {

    $allowed = apply_filters( 'cornerstone_option_model_whitelist', array( '' ) );

    if ( ! in_array( $id, $allowed, true ) ) {
      throw new Exception( "Attempted to $operation option outside of whitelist: $id" );
    }

  }


  public function update( $params ) {

    if ( ! current_user_can( 'manage_options' ) ) {
      throw new Exception( 'Unauthorized' );
    }

    $atts = $this->atts_from_request( $params );

    if ( ! $atts['id'] ) {
      throw new Exception( 'Attempting to update option without specifying a name.' );
    }

    $option = $atts['id'];
    $this->validate( $option, 'update' );

    update_option( $option, apply_filters( "cornerstone_option_model_save_$option", $atts['value'] ) );

    return array(
      'data' => array(
        'id' => $option,
        'type' => $this->name,
        'attributes' => array(
          'value' => apply_filters( "cornerstone_option_model_load_$option", get_option( $option ) )
        )
      )
    );
  }

  public function delete( $params ) {

    if ( ! current_user_can( 'manage_options' ) ) {
      throw new Exception( 'Unauthorized' );
    }

    $atts = $this->atts_from_request( $params );

    if ( ! $atts['id'] ) {
      throw new Exception( 'Attempting to delete option without specifying a name.' );
    }

    $this->validate( $atts['id'], 'delete' );

    delete_option( $atts['id'] );

    return array(
      'data' => array(
        'id' => $atts['id'],
        'type' => $this->name
      )
    );
  }

  protected function atts_from_request( $params ) {

    if ( ! isset( $params['model'] ) || ! isset( $params['model']['data'] ) || ! isset( $params['model']['data']['attributes'] ) ) {
      throw new Exception( 'Request to Option model missing attributes.' );
    }

    $atts = $params['model']['data']['attributes'];

    if ( isset( $params['model']['data']['id'] ) ) {
      $atts['id'] = $params['model']['data']['id'];
    }

    return $atts;
  }

}
