<?php

class Cornerstone_Controller_Options extends Cornerstone_Plugin_Component {

  public function save( $data ) {

    $options = $this->plugin->component( 'Options_Bootstrap' );
    $permissions = $this->plugin->component( 'App_Permissions' );
    $response = array( 'updates' => array() );

    if ( current_user_can( 'manage_options' ) || $permissions->user_can('theme_options') ) {

      do_action('cs_theme_options_before_save');

      if ( isset( $data['updates'] ) ) {
        foreach ($data['updates'] as $key => $value) {
          $response['updates'][ $key ] = $value;
          $options->update_value( $key, $value );
        }
      }

      do_action('cs_theme_options_after_save');

    }

    return $response;
  }

}
