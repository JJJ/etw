<?php

class Cornerstone_Controller_Content_Settings extends Cornerstone_Plugin_Component {

  public function settings_sections( $data ) {

    global $post;

		if ( ! isset( $data['post_id'] ) || ! $post = get_post( (int) $data['post_id'] ) ) {
      return new WP_Error( 'cs-settings-controller', 'post_id not set' );
    }

    setup_postdata( $post );

    $settings_manager = $this->plugin->loadComponent('Settings_Manager');

    return array(
      'data' => $this->upgrade_settings_data( $settings_manager->get_data()),
      'models' => $this->upgrade_settings_models( $settings_manager->get_models())
    );

  }

  public function upgrade_settings_data( $data ) {
    $output = array();
    foreach ($data as $section) {
      if ( isset( $section['_section'] ) ) {
        $key = $section['_section'];
        unset( $section['_section']);
        $output[$key] = $section;
      }
    }
    return $output;
  }


  public function upgrade_settings_models( $models ) {
    return $models;
  }


}
