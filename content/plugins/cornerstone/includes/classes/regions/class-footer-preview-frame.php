<?php

class Cornerstone_Footer_Preview_Frame extends Cornerstone_Plugin_Component {

  public function setup() {
    do_action('cs_bar_preview_setup', array('mode' => 'footer'));
  }

  public function config( $state ) {
    return array( 'mode' => $state['mode'] );
  }
}
