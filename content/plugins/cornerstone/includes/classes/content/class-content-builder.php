<?php

class Cornerstone_Content_Builder extends Cornerstone_Plugin_Component {

  public function setup() {
    add_filter('cornerstone_data_fragment_content_config', array( $this, 'config') );
  }

  public function config() {

    return array(
      'i18n' => $this->plugin->i18n_group( 'content' )
    );

  }

}
