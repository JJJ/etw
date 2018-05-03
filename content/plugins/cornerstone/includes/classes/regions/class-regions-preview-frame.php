<?php

class Cornerstone_Regions_Preview_Frame extends Cornerstone_Plugin_Component {

  public function setup() {

    $state = $this->plugin->component( 'Preview_Frame_Loader' )->get_state();

    if ( isset( $state['custom_js'] ) ) {

      $inline_scripts = $this->plugin->component('Inline_Scripts');

      foreach ($state['custom_js'] as $id => $content) {
        if ( $content ) {
          $inline_scripts->add_script_safely($id, $content);
        }
      }

    }

    do_action('cs_bar_preview_setup');
  }

  public function config( $state ) {
    return array( 'mode' => $state['mode'] );
  }

}
