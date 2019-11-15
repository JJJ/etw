<?php

class Cornerstone_Template_Manager extends Cornerstone_Plugin_Component {

  protected $templates = array();
  protected $deleted;
  protected $hidden;

  public function setup() {

    $args = array(
      'public'              => false,
      'exclude_from_search' => false,
      'capability_type'     => 'page',
      'supports'            => false
    );

    register_post_type( 'cs_template', $args );

  }

  public function config() {
    return array(
      'hide_starter_pack' => get_option('cs_tm_hide_starter_pack')
    );
  }

  public function hide_starter_pack() {
    update_option('cs_tm_hide_starter_pack', true);
  }

  public function unhide_starter_pack() {
    delete_option('cs_tm_hide_starter_pack');
  }

}
