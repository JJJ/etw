<?php

class Cornerstone_Model_Footers_Entry extends Cornerstone_Plugin_Component {

  public $resources = array();
  public $name = 'footers/entry';

  public function setup() {

    global $wpdb;
    $records = array();

    $posts = $wpdb->get_results( "SELECT ID, post_title, post_name, post_modified, post_date  FROM $wpdb->posts WHERE post_type = \"cs_footer\"", ARRAY_A );

    foreach ($posts as $post) {

      $records[] = array(
        'id' => (string)$post['ID'],
        'title' => $post['post_title'],
        'modified' => date_i18n( get_option( 'date_format' ), strtotime( $post['post_modified'] ) ),
        'language' => $this->plugin->loadComponent('Wpml')->get_language_data( $post['ID'], 'cs_footer' )
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
