<?php

class Cornerstone_Footer_Builder extends Cornerstone_Plugin_Component {

  public function setup() {
    add_filter('cornerstone_data_fragment_footer_config', array( $this, 'config') );
  }

  public function config() {
    return array(
      'i18n' => $this->plugin->i18n_group( 'footers' ),
      'assign_contexts' => $this->plugin->loadComponent( 'Footer_Assignments' )->get_assign_contexts()
    );

  }

}
