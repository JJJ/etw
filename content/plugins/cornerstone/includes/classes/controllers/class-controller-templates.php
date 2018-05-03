<?php

  class Cornerstone_Controller_Templates extends Cornerstone_Plugin_Component {

  public function manager_delete( $data ) {

    if ( ! isset( $data['ids'] ) ) {
      return new WP_Error( 'cornerstone', 'Ids to delete missing.' );
    }

    foreach ( $data['ids'] as $id ) {
      $template = new Cornerstone_Template( $id );
      $template->delete();
    }

    return array( 'success' => true );
  }

  public function prepare_export( $data ) {

    if ( ! current_user_can( 'manage_options' ) ) {
      return new WP_Error( 'cornerstone', 'Unauthorized' );
    }

    if ( ! isset( $data['ids'] ) ) {
      return new WP_Error( 'cornerstone', 'Ids to export missing.' );
    }

    $templates = array();

    foreach ( $data['ids'] as $id ) {

      $template = new Cornerstone_Template( $id );
      $template->get_meta();
      $serialized = $template->serialize();

      if ( 'preset' === $template->get_type() ) {
        $serialized['meta']['atts'] = is_string( $serialized['meta']['atts'] ) ? json_decode( $serialized['meta']['atts'] ) : $serialized['meta']['atts'];
      }

      $templates[] = $serialized;
    }

    return array(
      'templates' => $templates,
      'success'   => true
    );
  }

  public function prepare_global_blocks_export( $data ) {

    if ( ! isset( $data['ids'] ) ) {
      return new WP_Error( 'cornerstone', 'Ids to export missing.' );
    }

    $global_blocks = array();
    $pending = $data['ids'];
    $completed = array();

    while ( count( $pending ) > 0 ) {

      $id = array_pop($pending);

      $global_block = new Cornerstone_Content( (int) $id );
      $serialized = $global_block->serialize();

      if ( 'cs_global_block' !== $serialized['post_type'] ) {
        return new WP_Error( 'cornerstone', 'Attempting to export non global block.' );
      }

      $global_blocks[] = $serialized;
      $completed[] = $id;

      $more_ids = $this->find_more_global_blocks( $serialized['elements']['data'] );

      foreach ($more_ids as $another_id) {
        if ( ! in_array( $another_id, $completed ) ) {
          array_push($pending, $another_id);
        }
      }

    }

    return array(
      'globalBlocks' => $global_blocks,
      'success'      => true
    );

  }

  protected function find_more_global_blocks( $elements ) {

    $more = array();

    foreach( $elements as $element ) {

      if ( ! isset( $element['_type'] ) ) {
        continue;
      }

      if ( isset( $element['_modules'] ) ) {
        $more = array_merge($more, $this->find_more_global_blocks( $element['_modules']) );
      }

      if ( 'global-block' === $element['_type'] && isset( $element['global_block_id']) ) {
        array_push($more, $element['global_block_id']);
      }

    }

    return array_unique( $more );

  }


  public function upload_media( $data ) {

    if ( ! current_user_can( 'manage_options' ) ) {
      return new WP_Error( 'cornerstone', 'Unauthorized' );
    }

    if ( ! isset( $data['files'] ) ) {
      return new WP_Error( 'cornerstone', 'File reference missing.' );
    }

    $file_id = $data['files'][0]['key'];

    global $wpdb;
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_cs_attachment_tmpl_id' AND meta_value = %s", $file_id ) );

    if ( $results ) {
      $post_id = $results[0]->post_id;
    } else {

      require_once( ABSPATH . 'wp-admin/includes/image.php' );
	    require_once( ABSPATH . 'wp-admin/includes/file.php' );
	    require_once( ABSPATH . 'wp-admin/includes/media.php' );

      $post_id = media_handle_upload( '_files_' . $data['files'][0]['index'], 0 );

      if ( is_wp_error( $post_id ) ) {
        return $post_id;
      }

      update_post_meta( $post_id, '_cs_attachment_tmpl_id', $file_id );

    }

    return array(
      'attachment_id' => $post_id,
      'url' => wp_get_attachment_url( $post_id )
    );

  }

  public function import_templates( $data ) {

    if ( ! isset( $data['packageSignature'] ) ) {
      return new WP_Error( 'cornerstone', 'Package signature missing.' );
    }

    if ( ! isset( $data['files'] ) || ! $this->validate_import_files( $data['files'] ) ) {
      return new WP_Error( 'cornerstone', 'Files failed validation.' );
    }

    foreach ($data['files'] as $file) {

      if ( 'template' === $file['type'] ) {
        $template_data = $file['data'];
        $template_data['package_signature'] = $data['packageSignature'];
        $template = new Cornerstone_Template( $template_data );
        $template->save();
      }

      if ( 'global-block' === $file['type'] ) {
        $global_block = new Cornerstone_Content( (int) $file['data']['id'] );
        $global_block->set_elements( $file['data']['elements'] );

        $global_block->set_settings( $file['data']['settings'] );
        $global_block->save();
      }

    }

    return array( 'done' => true );

  }

  protected function validate_import_files( $files ) {

    foreach ($files as $file) {

      if ( ! isset( $file['type'] ) ) {
        return false;
      }

    }

    return true;

  }

  public function prepare_global_blocks_import( $data ) {

    $global_blocks = array();

    if ( ! isset( $data['globalBlockRequests'] ) ) {
      return new WP_Error( 'cornerstone', 'No global blocks' );
    }

    foreach ($data['globalBlockRequests'] as $global_block_request) {

      $global_block = new Cornerstone_Content( array(
        'post_type'   => 'cs_global_block',
        'post_status' => 'tco-data',
        'title'       => $global_block_request['title']
      ));

      $global_block->save();

      $global_blocks[$global_block_request['id']] = $global_block->get_id();

    }

    return array(
      'globalBlockIDs' => $global_blocks,
      'success'      => true
    );

  }

  public function hide_starter_pack() {

    if ( ! current_user_can( 'manage_options' ) ) {
      return new WP_Error( 'cornerstone', 'Unauthorized' );
    }

    $this->plugin->loadComponent('Template_Manager')->hide_starter_pack();

    return array( 'success' => true );

  }

  public function get_default_presets() {

    $default_presets = array();
    $results = $this->plugin->loadComponent('Template_Manager')->lookup_default_presets();

    foreach ($results as $type => $id ) {
      $default_presets[] = array(
        'id'   => $id,
        'type' => $type
      );
    }

    return array(
      'defaultPresets' => $default_presets,
      'success' => true
    );

  }

  public function update_default_presets( $data ) {

    if ( ! current_user_can( 'manage_options' ) ) {
      return new WP_Error( 'cornerstone', 'Unauthorized' );
    }

    if ( ! isset( $data['defaultPresets'] ) ) {
      return new WP_Error( 'cornerstone', 'No data' );
    }

    $current = $this->plugin->loadComponent('Template_Manager')->lookup_default_presets();

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
