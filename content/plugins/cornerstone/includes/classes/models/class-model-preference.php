<?php

class Cornerstone_Model_Preference extends Cornerstone_Plugin_Component {

  public function query( $params ) {

    // Find All
    if ( empty( $params ) || ! isset( $params['query'] ) || ! isset( $params['query']['id'] ) ) {
      return false;
    }

    $this->validate( $params['query']['id'], 'access' );
    $preferences = $this->plugin->component('App_Preferences')->get_user_preferences( $params['query']['id'] );

    return array(
      'data' => array(
        'id' => $params['query']['id'],
        'type' => 'preference',
        'attributes' => array( 'values' => $preferences )
      )
    );

  }

  protected function validate( $user_id, $operation ) {

    if ( ! $user_id === get_current_user_id() && ! current_user_can('manage_options') ) {
      throw new Exception( "Unauthorized attempt to $operation preferences of another user" );
    }

  }


  public function update( $params ) {

    $atts = $this->atts_from_request( $params );

    if ( ! $atts['id'] ) {
      throw new Exception( 'Attempting to update option without specifying a name.' );
    }

    $this->validate( $atts['id'], 'update' );

    $app_preferences = $this->plugin->component('App_Preferences');
    $app_preferences->update_user_preferences( $atts['id'], $atts['values'] );
    $preferences = $app_preferences->get_user_preferences( $atts['id'] );

    return array(
      'data' => array(
        'id' => $atts['id'],
        'type' => 'preference',
        'attributes' => array( 'values' => $preferences )
      )
    );
  }

  public function delete( $params ) {

    $atts = $this->atts_from_request( $params );

    if ( ! $atts['id'] ) {
      throw new Exception( 'Attempting to delete user prefences without specifying a user ID.' );
    }

    $this->validate( $atts['id'], 'delete' );

    $app_preferences = $this->plugin->component('App_Preferences');
    $app_preferences->reset_user_preferences( $atts['id'] );

    return array(
      'data' => array(
        'id' => $atts['id'],
        'type' => 'preference'
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
