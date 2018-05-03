<?php

class Cornerstone_Wpml extends Cornerstone_Plugin_Component {

  protected $previous_lang;


  public function setup() {

    if ( ! $this->is_active() ) {
      return;
    }

    add_action('cs_before_preview_frame', array( $this, 'before_preview_frame' ) );
    add_filter('cs_locate_wpml_language', array( $this, 'locate_wpml_language'), 10, 2);

    add_filter( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
    add_filter( 'the_title', array( $this, 'filter_title' ), 99, 2 );
    add_filter( 'the_permalink', array( $this, 'filter_permalink' ) );

    // global $sitepress;
    // $wpml_post_types = $sitepress->get_setting('custom_posts_sync_option');
    //
    // $wpml_post_types['cs_header'] = 1;
    // $wpml_post_types['cs_footer'] = 1;
    //
    // $sitepress->set_setting('custom_posts_sync_option', $wpml_post_types);

  }

  public function is_active() {
    return class_exists( 'SitePress' );
  }

  public function locate_wpml_language( $lang, $post ) {
    global $sitepress;
    $language_details = $sitepress->get_element_language_details( $post->ID, 'post_' . $post->post_type );
    if ($language_details) {
      $lang = $language_details->language_code;
    }
    return $lang;
  }

  public function before_preview_frame( $state ) {

    if ( isset( $state['lang']) && ! isset( $_REQUEST['lang']) ) {
      $_REQUEST['lang'] = $state['lang'];
    }

    if ( isset( $_REQUEST['lang'] ) &&
      ( '3' === wpml_get_setting_filter(false, 'language_negotiation_type')
      || isset( $state['lang'] ) )
    ) {
      add_action('wp_loaded', array( $this, 'set_preview_lang' ), 11 );
    }

  }

  public function set_preview_lang() {
    global $sitepress;
    $sitepress->switch_lang($_REQUEST['lang']);
  }


  public function switch_lang( $lang = 'all' ) {

    if ( ! $this->is_active() ) {
      return;
    }

    global $sitepress;
    $this->previous_lang = $sitepress->get_current_language();

    $sitepress->switch_lang($lang);

  }

  public function switch_back() {

    if ( ! $this->is_active() ) {
      return;
    }

    $sitepress->switch_lang( $this->previous_lang );

  }

  public function get_previous_lang() {
    return $this->previous_lang;
  }


  public function pre_get_posts( $query ) {

    global $sitepress;

    if ( ! is_callable( array( $sitepress, 'switch_lang' ) ) || ! is_callable( array( $sitepress, 'get_current_language' ) ) ) {
      return $query;
    }

    if ( isset( $query->query_vars['cs_all_wpml'] ) && $query->query_vars['cs_all_wpml'] ) {
      return $query;
    }

    $sitepress->switch_lang( $sitepress->get_current_language() ); //Make sure that even custom query gets the current language

    $query->query_vars['suppress_filters'] = false;

    return $query;

  }

  //WPML Post object usable by multiple filters
  private function wpml_post() {

    global $post, $sitepress;

    if ( ! $post || ! function_exists( 'icl_object_id' ) || ! is_callable( array( $sitepress, 'get_current_language' ) ) ) {
      return;
    }

    return get_post( icl_object_id( $post->ID, 'post', false, $sitepress->get_current_language() ) );
  }

  public function filter_title( $title, $id = null ) {

    $wpml_post = $this->wpml_post();

    return ( ! is_a( $wpml_post, 'WP_Post' ) || $wpml_post->ID !== $id ) ? $title :
      // Let's apply the_title filters (apply_filters causes loop)
      trim( convert_chars( wptexturize( esc_html( $wpml_post->post_title ) ) ) );
  }

  public function filter_permalink( $permalink ) {

    $wpml_post = $this->wpml_post();

    if ( is_a( $wpml_post, 'WP_Post' ) ) {
      $permalink = get_permalink( $wpml_post->ID );
    }

    return $permalink;

  }

  public function get_language_data_from_post( $post, $all = false ) {
    if ( is_int( $post ) ) {
      $post = get_post( $post );
    }
    return $this->get_language_data( $post->ID, $post->post_type, $all );
  }

  public function get_language_data( $original_id, $object_type = 'post', $all = false ) {

    if ( ! $this->is_active() ) {
      return array();
    }

    $languages = $this->get_languages();

    global $sitepress;
    $details = $sitepress->get_element_language_details( $original_id );

    if ( ! $details ) {

      $default_language = $sitepress->get_default_language();

      $output = array(
        'code' => $default_language,
        'source' => $original_id,
        'fallback' => array_values( array_diff( array_keys( $languages ), array( $default_language ) ) )
      );

      if ( $all ) {
        $output['missing'] = $output['fallback'];
        $output['translations'] = array( $default_language => $original_id );
      }

      return $output;

    }

    $translations = (array) $sitepress->get_element_translations( $details->trid, $object_type );

    $available = array();
    $is_source = false;
    $source = null;

    foreach ($translations as $translation ) {
      $available[$translation->language_code] = (int) $translation->element_id;
      if ( $translation->original ) {
        if( (int) $original_id === (int) $translation->element_id ) {
          $is_source = true;
        } else {
          $source = (int) $translation->element_id;
        }
      }
    }

    $output = array(
      'code' => $details->language_code,
      'source' => $source,
      'fallback' => array()
    );

    if ( $all ) {
      $output['missing'] = array();
      $output['translations'] = $available;
    }

    foreach ( $languages as $code => $language ) {
      if ( ! isset( $available[$code] ) ) {
        if ( $is_source ) {
          $output['fallback'][] = $code;
        }
        if ( $all ) {
          $output['missing'][] = $code;
        }
      }
    }


    return $output;

  }


  public function get_languages() {
    if ( ! $this->is_active() ) {
      return array();
    }
    return apply_filters('wpml_active_languages', array() );
  }

  public function get_default_language() {
    global $sitepress;
    return $this->is_active() ? $sitepress->get_default_language() : null;
  }

  public function get_translateable_post_types() {

    $output = array( 'page', 'post' );

    if ( $this->is_active() ) {

      global $sitepress;
      $types = $sitepress->get_setting('custom_posts_sync_option');

      foreach ($types as $key => $value) {
        if ( $value ) {
          $output[] = $key;
        }
      }

    }

    return $output;
  }

  public function get_element_language_details( $post_id ) {

    if ( ! $this->is_active() ) {
      return null;
    }

    global $sitepress;
    return (array) $sitepress->get_element_language_details( $post_id );

  }

  public function get_language_label( $code ) {
    $languages = $this->get_languages();
    foreach ($languages as $lang_code => $value) {
      if ( $code === $lang_code ) {
        return isset( $value['translated_name'] ) ? $value['translated_name'] : '';
      }
    }
    return '';
  }

  public function before_get_permalink() {

    if ( ! $this->is_active() ) {
      return;
    }

    global $wpml_url_filters;

    $wpml_url_filters->remove_global_hooks();
    if ( $wpml_url_filters->frontend_uses_root() === true ) {
    	remove_filter( 'page_link', array( $wpml_url_filters, 'page_link_filter_root' ), 1, 2 );
    } else {
    	remove_filter( 'page_link', array( $wpml_url_filters, 'page_link_filter' ), 1, 2 );
    }

  }

  public function after_get_permalink() {

    if ( ! $this->is_active() ) {
      return;
    }

    global $wpml_url_filters;

    $wpml_url_filters->add_global_hooks();

    if ( $wpml_url_filters->frontend_uses_root() === true ) {
    	add_filter( 'page_link', array( $wpml_url_filters, 'page_link_filter_root' ), 1, 2 );
    } else {
    	add_filter( 'page_link', array( $wpml_url_filters, 'page_link_filter' ), 1, 2 );
    }

  }

  public function get_source_id_for_post( $post_id, $post_type = false ) {

    if ( ! $this->is_active() ) {
      return $post_id;
    }

    if ( ! $post_type ) {
      $post = get_post( $post_id );
      $post_type = $post->post_type;
    }

    global $sitepress;
    $details = (array) $sitepress->get_element_language_details( $post_id );

    if ( ! $details || ! isset( $details['source_language_code'] ) ) {
      return $post_id;
    }

    return apply_filters( 'wpml_object_id', $post_id, $post_type, true, $details['source_language_code'] );

  }
}
