<?php

class Cornerstone_Header_Builder extends Cornerstone_Plugin_Component {

  public function config() {
    return array(
      'assign_contexts' => $this->plugin->component( 'Header_Assignments' )->get_assign_contexts()
    );

  }

}
