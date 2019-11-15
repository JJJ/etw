<?php

class Cornerstone_Controller_Presets extends Cornerstone_Plugin_Component {

  public function get_presets_for_element( $data ) {

    if ( ! isset( $data['type'] ) ) {
      return new WP_Error( 'cornerstone', 'No type specified' );
    }

    global $wpdb;
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_cs_template_subtype_preset' AND meta_value = %s", $data['type'] ) );

    $records = array();
    foreach ($results as $result) {
      $record = $this->make_record( (int) $result->post_id, true );
      if ( $record ) {
        $records[] = $record;
      }
    }

    return $records;

  }

  public function get_preset_stubs( $data ) {

    $posts = get_posts( array(
      'post_type' => array( 'cs_template' ),
      'post_status' => array( 'tco-data', 'publish' ),
      'orderby' => 'type',
      'posts_per_page' => apply_filters( 'cs_query_limit', 2500 ),
      'meta_key' => '_cs_template_type',
      'meta_value' => 'preset',
    ) );

    $records = array();
    foreach ($posts as $post) {
      $record = $this->make_record( $post, false );
      if ( $record ) {
        $records[] = $record;
      }
    }

    return $records;

  }

  public function make_record( $post, $include_atts ) {

    $preset = new Cornerstone_Template( $post );

    if ( $preset->is_hidden() ) {
      return false;
    }

    $record = array(
      'id'      => $preset->get_id(),
      'element' => $preset->get_subtype(),
      'title'   => $preset->get_title()
    );

    if ( $include_atts ) {
      $meta = $preset->get_meta();
      $record['atts'] = $meta['atts'];
    }

    return $record;

  }

  public function get_default_presets() {

    $default_presets = $this->lookup_default_presets();
    $presets = array();

    foreach ($default_presets as $id => $type) {
      $presets[] = array(
        'id'   => $id,
        'type' => $type
      );
    }

    return array(
      'defaultPresets' => $presets,
      'success' => true
    );
  }

  public function lookup_default_presets() {
    global $wpdb;
    $results = $wpdb->get_results( "SELECT pm1.post_id AS id, pm2.meta_value as preset_type FROM $wpdb->postmeta AS pm1 INNER JOIN $wpdb->postmeta AS pm2 ON pm1.post_id = pm2.post_id WHERE pm1.meta_key = '_cs_preset_is_default' AND pm2.meta_key = '_cs_template_subtype_preset'" );
    $default_presets = array();

    foreach ($results as $result) {
      $default_presets[$result->preset_type] = "$result->id";
    }

    return $default_presets;
  }

  public function update_default_presets( $data ) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('templates.manage_default_presets') ) {
      return new WP_Error( 'cornerstone', 'Unauthorized' );
    }

    if ( ! isset( $data['defaultPresets'] ) ) {
      return new WP_Error( 'cornerstone', 'No data' );
    }

    $current = $this->lookup_default_presets();

    $clear = array();
    $update = array();

    foreach ( $data['defaultPresets'] as $key => $id ) {

      if ( ( ! isset( $current[$key] ) && "none" === $id ) || ( isset( $current[$key] ) && $id === $current[$key] ) ) {
        continue;
      }

      $clear[] = $key;

      if ( "none" !== $id ) {
        $update[] = $id;
      }

    }

    $clear = array_map('esc_sql', $clear);
    $clear = implode('", "', $clear );

    global $wpdb;
    $to_delete = $wpdb->get_results( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = \"_cs_template_subtype_preset\" and meta_value IN ( \"$clear\" )" );
    $delete_ids = array();

    foreach ($to_delete as $record) {
      $delete_ids[] = esc_sql( $record->post_id );
    }

    $delete_ids = implode('", "', $delete_ids );

    $wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key = \"_cs_preset_is_default\" AND post_id IN ( \"$delete_ids\" )" );

    foreach ( $update as $id ) {
      update_post_meta( $id, '_cs_preset_is_default', true );
    }

    return array(
      'success' => true
    );

  }

}
