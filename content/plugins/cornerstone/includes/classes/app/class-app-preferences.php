<?php

class Cornerstone_App_Preferences extends Cornerstone_Plugin_Component {

  protected $defaults;

  public function setup() {
    $this->defaults = apply_filters('cs_app_preference_defaults', $this->config_group( 'app/preference-defaults' ) );
  }

  public function get_user_preferences( $user_id = null ) {

    if ( ! $user_id ) {

      $user_id = get_current_user_id();

      if ( ! $user_id ) {
        return array();
      }

    }

    $user_meta = get_user_meta( $user_id, 'cs_app_preferences', true );

    if ( ! is_array( $user_meta ) ) {
      $user_meta = array();
    }

    $result = array();
    $preferences = wp_parse_args( $user_meta, $this->defaults );
    $permissions = $this->plugin->component('App_Permissions');

    foreach ($preferences as $key => $value) {
      if ( ! $permissions->user_can( "preference.$key.user") ) {
        $result[$key] = $permissions->user_can( "preference.$key");
      } else {
        $result[$key] = $value;
      }
    }

    return apply_filters('cs_app_preferences', $result );

  }

  public function update_user_preferences( $user_id = null, $values ) {

    if ( ! $values ) {
      return null;
    }

    if ( ! $user_id ) {

      $user_id = get_current_user_id();

      if ( ! $user_id ) {
        return array();
      }

    }

    $permissions = $this->plugin->component('App_Permissions');

    $update = array();
    $current = $this->get_user_preferences( $user_id );

    foreach ($current as $key => $value) {
      $update[$key] = isset( $values[$key] ) && $permissions->user_can( "preferences.$key.user", $user_id ) ? $values[$key] : $value;
    }

    return update_user_meta( $user_id, 'cs_app_preferences', $values );

  }


  public function reset_user_preferences( $user_id = null ) {

    if ( ! $user_id ) {

      $user_id = get_current_user_id();

      if ( ! $user_id ) {
        return null;
      }

    }

    return delete_user_meta( $user_id, 'cs_app_preferences' );

  }

  public function get_preference_controls() {
    return $this->config_group( 'app/preference-controls' );
  }

}
