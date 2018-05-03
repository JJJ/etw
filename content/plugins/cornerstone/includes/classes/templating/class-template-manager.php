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
      'hide_starter_pack' => $this->should_hide_starter_pack()
    );
  }

  public function should_hide_starter_pack() {
    return get_option('cs_tm_hide_starter_pack');
  }

  public function hide_starter_pack() {
    update_option('cs_tm_hide_starter_pack', true);
  }

  public function unhide_starter_pack() {
    delete_option('cs_tm_hide_starter_pack');
  }

  public function lookup_default_presets() {

    $default_presets = array();

    global $wpdb;
    $results = $wpdb->get_results( "SELECT pm1.post_id AS id, pm2.meta_value as preset_type FROM $wpdb->postmeta AS pm1 INNER JOIN $wpdb->postmeta AS pm2 ON pm1.post_id = pm2.post_id WHERE pm1.meta_key = '_cs_preset_is_default' AND pm2.meta_key = '_cs_template_subtype_preset'" );


    foreach ($results as $result) {
      $default_presets[$result->preset_type] = "$result->id";
    }

    return $default_presets;

  }

}
