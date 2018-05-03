<?php

class Cornerstone_Header_Builder extends Cornerstone_Plugin_Component {

  public function setup() {
    add_filter('cornerstone_data_fragment_header_config', array( $this, 'config') );
  }

  public function config() {
    return array(
      'i18n' => $this->plugin->i18n_group( 'headers' ),
      'assign_contexts' => $this->plugin->loadComponent( 'Header_Assignments' )->get_assign_contexts()
    );

  }

}
