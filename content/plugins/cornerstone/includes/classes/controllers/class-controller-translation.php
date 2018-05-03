<?php

class Cornerstone_Controller_Translation extends Cornerstone_Plugin_Component {

  public function create( $data ) {

    if ( ! isset( $data['source'] ) ) {
      return new WP_Error( 'cornerstone', 'Source missing.' );
    }

    if ( ! isset( $data['lang'] ) ) {
      return new WP_Error( 'cornerstone', 'Target language missing.' );
    }

    $source_post = get_post( $data['source'] );

    if ( ! is_a( $source_post, 'WP_POST' ) ) {
      return new WP_Error( 'cornerstone', 'Source invalid.' );
    }

    $wpml = $this->plugin->loadComponent('Wpml');

    if ( ! in_array( $source_post->post_type, $wpml->get_translateable_post_types(), true ) ) {
      return new WP_Error( 'cornerstone', 'WPML does not allow this post type (' . $source_post->post_type . ') to be translated.' );
    }

    if ( ! function_exists('wpml_load_post_translation') ) {
      return new WP_Error( 'cornerstone', 'WPML not active' );
    }

    global $sitepress;

    $copy_from = isset( $data['copyFrom'] ) ? $data['copyFrom'] : null;

    if ( $copy_from ) {

      $duplicate = $sitepress->make_duplicate( $copy_from, $data['lang'] );

      if ( 0 === $duplicate ) {
        return new WP_Error( 'cornerstone', 'Unable to duplicate.' );
      }

      return array( 'id' => $duplicate );

    }


    $args = array(
      'post_type' => $source_post->post_type,
      'post_status' => $source_post->post_status,
      'post_title' => sprintf( csi18n('common.ammended-title'), $source_post->post_title, $wpml->get_language_label( $data['lang'] ) )
    );


    // Set trid
    $this->wpml_lang = $data['lang'];
    $details = $this->plugin->loadComponent('Wpml')->get_element_language_details( $source_post->ID );

    $this->wpml_trid = isset( $details['trid'] ) ? $details['trid'] : null;
    $source_language = isset( $details['source_language_code'] ) ? $details['source_language_code'] : null;

    if ( ! $this->wpml_trid ) {

      //
      // trid will not exist if the header/footer has not been saved at least once since
      // WPML was activated. If this is the case, we could trigger a save here to generate
      // the source trid before continuing
      //

      $this->wpml_trid = null; // Try to populate this
    }

    // if ( $copy_from ) {
    //
    //   // Update Args
    //
    // }

    if ( $this->wpml_trid ) {

      $id = wp_insert_post( $args, true );

      if ( is_wp_error( $id ) ) {
        return $id;
      }

      global $wpml_post_translations;

  		$sitepress->set_element_language_details (
  			$id,
  			'post_' . $source_post->post_type,
  			$this->wpml_trid,
  			$this->wpml_lang,
  			$source_language
  		);

      $settings = get_option( 'icl_sitepress_settings' );
  		$translation_sync = new WPML_Post_Synchronization( $settings, $wpml_post_translations, $sitepress );
  		$original_id      = $wpml_post_translations->get_original_element( $id );
      $new_post = (array) get_post($id);
  		$translation_sync->sync_with_translations( $original_id ? $original_id : $id, $new_post );
  		$translation_sync->sync_with_duplicates( $id );
  		if ( ! function_exists( 'icl_cache_clear' ) ) {
  			require_once WPML_PLUGIN_PATH . '/inc/cache.php';
  		}
  		icl_cache_clear( $source_post->post_type . 's_per_language', true );
  		wp_defer_term_counting( false );
  		if ( $source_post->post_type !== 'nav_menu_item' ) {
  			do_action( 'wpml_tm_save_post', $id, get_post( $id ), false );
  		}

      // Flush object cache.
  		$cache_groups = array( 'ls_languages', 'element_translations' );
      foreach ( $cache_groups as $group ) {
        $cache = new WPML_WP_Cache( $group );
        $cache->flush_group_cache();
      }

  		do_action( 'wpml_after_save_post', $id, $this->wpml_trid, $this->wpml_lang, $source_language );

      return array( 'id' => $id );

    }

    return new WP_Error( 'cornerstone', 'Could not locate a translation for the source post.' );

  }

  public function set_wpml_trid( $id ) {
    return $this->wpml_trid;
  }

  public function set_wpml_lang( $id ) {
    return $this->wpml_lang;
  }

}
