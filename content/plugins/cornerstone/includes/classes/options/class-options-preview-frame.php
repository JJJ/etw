<?php

class Cornerstone_Options_Preview_Frame extends Cornerstone_Plugin_Component {

  protected $updates = array();

  public function setup() {

    do_action('cs_options_preview_setup');

    $loader = $this->plugin->component( 'Preview_Frame_Loader' );
    $state = $loader->get_state();

    if ( isset( $state['updates']) && is_array( $state['updates'] ) ) {
      $loader->prefilter_options( $state['updates'] );
    }

  }

}
