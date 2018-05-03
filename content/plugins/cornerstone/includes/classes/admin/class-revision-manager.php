<?php
/**
 * This class add revision support for cornerstone.
 */

class Cornerstone_Revision_Manager extends Cornerstone_Plugin_Component {

	public $json_post_meta = array(
		'_cornerstone_data',
		'_cornerstone_settings',
	);

  public $standard_post_meta = array(
    '_cornerstone_version'
  );

  public $post_meta_keys;

	public function setup() {

		// Disable revision through filter
		if ( apply_filters( 'cornerstone_disable_revisions', false ) ) {
			return;
		}

		// Save cornerstone revision
		add_action( 'save_post', array( $this, 'save_revision' ), 100 );

		// Restore cornerstone revision
		add_action( 'wp_restore_post_revision', array( $this, 'restore_revision' ), 10, 2 );

	}

	public function save_revision( $revision_id ) {

		$parent_id = wp_is_post_revision( $revision_id );

		if ( ! $parent_id ) {
      return;
    }

    $this->update_revision_meta_from_post( $revision_id, $parent_id );

	}

  public function update_revision_meta_from_post( $revision_id, $post_id ) {

    foreach ( $this->json_post_meta as $key ) {
			$meta = cs_get_serialized_post_meta( $post_id, $key , true );
			if ( false !== $meta ) {
        cs_update_serialized_post_meta( $revision_id, $key, $meta, '', true );
			}
		}

    foreach ( $this->standard_post_meta as $key ) {
			$meta = get_post_meta( $post_id, $key , true );
			if ( false !== $meta ) {
        update_metadata('post', $revision_id, $key, $meta );
			}
		}

  }

	public function restore_revision( $post_id, $revision_id ) {

    foreach ( $this->json_post_meta as $key ) {

			$meta = cs_get_serialized_post_meta( $revision_id, $key , true );

			if ( false !== $meta ) {
				cs_update_serialized_post_meta( $post_id, $key, $meta );
			} else {
				delete_post_meta( $post_id, $key );
			}

		}

		foreach ( $this->standard_post_meta as $key ) {

			$meta = get_post_meta( $revision_id, $key , true );

			if ( false !== $meta ) {
				update_post_meta( $post_id, $key, $meta );
			} else {
				delete_post_meta( $post_id, $key );
			}

		}

	}

}
