<?php

class Cornerstone_Footer_Builder extends Cornerstone_Plugin_Component {

  public function config() {
    return array(
      'assign_contexts' => $this->plugin->component( 'Footer_Assignments' )->get_assign_contexts()
    );

  }

}
