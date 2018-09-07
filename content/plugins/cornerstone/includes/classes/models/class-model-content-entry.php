<?php

class Cornerstone_Model_Content_Entry extends Cornerstone_Plugin_Component {

  public $resources = array();
  public $name = 'content/entry';

  public function setup() {

    if ( ! $this->plugin->component('App_Permissions')->user_can('content') ) {
      return;
    }

    $posts = get_posts( array(
      'post_type' => $this->plugin->component('App_Permissions')->get_user_post_types(),
      'orderby' => 'type',
      'post_status' => 'any',
      'posts_per_page' => apply_filters( 'cs_query_limit', 2500 ),
      'cs_all_wpml' => true
    ) );

    $records = array();

    $skip = array();

    $skip[] = (int) get_option( 'page_for_posts' );

    if ( function_exists('wc_get_page_id') ) {
      $skip[] = (int) wc_get_page_id( 'shop' );
    }

    foreach ($posts as $post) {

      $post_type_obj = get_post_type_object( $post->post_type );
      $caps = (array) $post_type_obj->cap;

      if ( in_array( (int) $post->ID, $skip, true ) || ! current_user_can( $caps['edit_post'], $post->ID )) {
        continue;
      }

      $records[] = array(
        'id' => "$post->ID",
        'title' => $post->post_title,
        'post-status' => $post->post_status,
        'post-type' => $post->post_type,
        'post-type-label' => isset( $post_type_obj->labels ) ? $post_type_obj->labels->singular_name : $post->post_type,
        'modified' => date_i18n( get_option( 'date_format' ), strtotime( $post->post_modified ) ),
        'permalink' => get_permalink( $post ),
        'language' => $this->plugin->component('Wpml')->get_language_data( $post->ID, $post->post_type )
      );

    }

    foreach ($records as $record) {
      $this->resources[] = $this->to_resource( $record );
    }
  }

  public function query( $params ) {

    // Find All
    if ( empty( $params ) || ! isset( $params['query'] ) ) {
      return array(
        'data' => $this->resources
      );
    }

    $queried = array();
    $included = array();

    foreach ( $this->resources as $resource) {
      if ( $this->query_match( $resource, $params['query'] ) ) {
        $queried[] = $resource;
      } else {
        $included[] = $resource;
      }
    }

    return array(
      'data' => ( isset( $params['single'] ) ) ? $queried[0] : $queried,
      'included' => $included,
      'meta' => array( 'request_params' => $params )
    );
  }

  public function query_match( $resource, $query ) {

    foreach ( $query as $key => $value ) {

      // Check relationships
      if ( isset( $resource['relationships'][ $key ] )  ) {

        if ( ! isset( $resource['relationships'][ $key ]['data'] ) ) {
          return false;
        }

        $data = $resource['relationships'][ $key ]['data'];

        if ( isset( $data['id'] ) && $value !== $data['id'] ) {
          return false;
        } else {
          foreach ( $data as $child ) {
            if ( isset( $data['id'] ) && $value === $data['id'] ) {
              return true;
            }
          }
          return false;
        }

      } else {
        if ( ! isset( $resource[ $key ] ) || $resource[ $key ] !== $value ) {
          return false;
        }
      }

    }

    return true;
  }

  public function to_resource( $record ) {

    $resource = array(
      'id' => $record['id'],
      'type' => $this->name
    );

    unset( $record['id'] );
    $resource['attributes'] = $record;

    return $resource;

  }
}
