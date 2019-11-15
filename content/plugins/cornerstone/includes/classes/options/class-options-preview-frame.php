<?php

class Cornerstone_Options_Preview_Frame extends Cornerstone_Plugin_Component {

  protected $updates = array();

  public function setup() {

    do_action('cs_options_preview_setup');
    add_action('wp_head', array( $this, 'remove_custom_styles') );

    $loader = $this->plugin->component( 'Preview_Frame_Loader' );
    $state = $loader->get_state();

    if ( isset( $state['updates']) && is_array( $state['updates'] ) ) {
      $loader->prefilter_options( $state['updates'] );
    }

  }

  public function config( $state ) {
    return array(
      'canNavigate' => true
    );
  }

  public function remove_custom_styles() {
    remove_action( 'x_before_head_css', 'x_register_custom_styles' );
  }

}
