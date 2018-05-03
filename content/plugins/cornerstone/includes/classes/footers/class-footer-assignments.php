<?php

class Cornerstone_Footer_Assignments extends Cornerstone_Plugin_Component {

  protected $option_key = 'cornerstone_footer_assignments';
  protected $located;

  public function setup() {
    add_action( 'cornerstone_delete_footer', array( $this, 'assignments_deleted' ) );
    add_filter( 'cornerstone_option_model_whitelist', array( $this, 'whitelist_options' ) );
    add_filter( 'cornerstone_option_model_load_' . $this->option_key, array( $this, 'load_transform' ) );
    add_filter( 'cornerstone_option_model_save_' . $this->option_key, array( $this, 'save_transform' ) );
  }

  public function assignments_deleted( $entity_id ) {
    $data = $this->load_transform( get_option($this->option_key) );

    foreach ($data as $key => $value) {
      if ( (int) $entity_id === (int) $value ) {
        unset($data[$key]);
      }
    }

    update_option($this->option_key, $this->save_transform( $data ) );

  }

  public function whitelist_options( $keys ) {
    $keys[] = $this->option_key;
    return $keys;
  }

  public function load_transform( $data ) {

    $data = json_decode( wp_unslash( $data ), true );

    $uncompacted = array();

    if ( isset( $data['global'] ) ) {
      $uncompacted['global'] = $data['global'];
    }

    if ( isset( $data['indexes'] ) ) {
      foreach ($data['indexes'] as $key => $value) {
        $uncompacted[ 'indexes::' . $key] = $value;
      }
    }

    if ( isset( $data['post_types'] ) ) {
      foreach ($data['post_types'] as $key => $value) {
        $uncompacted[ 'post_type::' . $key] = $value;
      }
    }

    if ( isset( $data['meta'] ) && isset( $data['meta']['post_types'] ) && isset( $data['posts'] ) ) {
      foreach ($data['meta']['post_types'] as $key => $value) {
        foreach ($value as $id) {
          if ( isset( $data['posts'][ 'post-' . $id] ) ) {
            $uncompacted[ 'post_type::' . $key . '::' . $id ] = $data['posts'][ 'post-' . $id];
          }
        }
      }
    }

    ksort( $uncompacted );

    if ( empty($uncompacted)) {
      $uncompacted = new stdClass;
    }
    return $uncompacted;
  }

  public function assignment_schema() {
    return array(
      'global' => null,
      'indexes' => array(),
      'post_types' => array(),
      'posts' => array(),
      'meta' => array(
        'post_types' => array()
      )
    );
  }

  public function save_transform( $data ) {

    if ( ! is_array( $data ) ) {
      $data = array();
    }

    ksort($data);

    $compact = $this->assignment_schema();

    foreach ($data as $key => $value) {

      $address = explode( '::', $key );

      if ( 'global' === $key) {
        $compact['global'] = $value;
      } elseif ( 'indexes' === $address[0] ) {
        $compact['indexes'][ $address[1] ] = $value;
      } elseif ( 'post_type' === $address[0] ) {
        if ( ! isset( $address[2] ) ) {
          $compact['post_types'][ $address[1] ] = $value;
        } else {
          $compact['posts'][ 'post-' . $address[2] ] = $value;
          if ( ! isset( $compact['meta']['post_types'][$address[1]] )) {
            $compact['meta']['post_types'][$address[1]] = array();
          }
          $compact['meta']['post_types'][$address[1]][] = $address[2];
        }

      }

    }

    return wp_slash( json_encode( $compact ) );
  }


  public function get_assign_contexts() {

    $groups = array(
      'indexes' => array(
        'title' => false,
        'tag' => csi18n('common.assignments-indexes'),
        'items' => array(
          array(
            'value' => 'front',
            'title' => csi18n('common.assignments-front-page'),
            'url'   => home_url()
          ),
          array(
            'value' => 'home',
            'title' => csi18n('common.assignments-posts-page'),
            'url'   =>  ('page' === get_option('show_on_front')) ? get_permalink(get_option('page_for_posts')) : home_url()
          )
        )
      )
    );

    $post_types = get_post_types( array(
      'public'   => true,
      'show_ui' => true,
      'exclude_from_search' => false
    ) , 'objects' );

    unset( $post_types['attachment'] );

    $posts = get_posts( array(
      'post_type' => array_keys( $post_types ) ,
      'orderby' => 'type',
      'posts_per_page' => 2500
    ) );

    foreach ($posts as $post) {

      $post_type_obj = get_post_type_object( $post->post_type );

      $key = 'post_type::' . $post->post_type;
      $url = get_permalink( $post->ID );

      if ( ! isset( $groups[ $key ] ) ) {
        $groups[ $key ] = array(
          'title' => sprintf( csi18n('common.assignments-all'), $post_type_obj->labels->name ),
          'tag'   => $post_type_obj->labels->singular_name,
          'url'   => $url,
          'items' => array()
        );
      }

      $groups[ $key ]['items'][] = array(
        'value' => $post->ID,
        'title' => $post->post_title,
        'url'   => $url
      );

    }

    // $taxonomies = get_taxonomies( array( 'public' => true), 'objects' );
    // foreach ( $taxonomies  as $taxonomy ) {
    //   $contexts[] = array(
    //     'value' => $taxonomy->name,
    //     'label' => $taxonomy->labels->singular_name,
    //     'group' => 'Taxonomy'
    //   );
    // }

    ksort($groups);

    $contexts = array();

    foreach ($groups as $key => $group) {
      $group['name'] = $key;
      $contexts[] = $group;
    }

    return $contexts;
  }

  public function get_assignments() {
    return wp_parse_args( json_decode( wp_unslash( get_option( 'cornerstone_footer_assignments' ) ), true ), $this->assignment_schema() );
  }

  public function locate_assignment( $fallback = false ) {

    if ( ! isset( $this->located ) ) {

      $assignments = $this->get_assignments();

      // Start by using the global footer
      $match = $assignments['global'];
      $post = get_post();

      // Allow integrations to detect assignments
      $match = apply_filters( 'cs_locate_footer_assignment', $match, $assignments, $post );

      if ( is_front_page() && isset( $assignments['indexes']['front'] ) ) {
        $match = $assignments['indexes']['front'];
      } elseif ( is_home() && isset( $assignments['indexes']['home'] ) ) {
        $match = $assignments['indexes']['home'];
      } elseif ( is_a( $post, 'WP_POST' ) ) {

        if ( isset( $assignments['post_types'][ $post->post_type ] ) ) {
          $match = $assignments['post_types'][ $post->post_type ];
        }

        $source_post_id = CS()->loadComponent('Wpml')->get_source_id_for_post($post->ID, $post->post_type);
        if ( isset( $assignments['posts'][ 'post-' . $source_post_id ] ) ) {
          $match = $assignments['posts'][ 'post-' . $source_post_id ];
        }

      }

      // Allow integrations for force assigments. Unless you have a specific
      // reason, it is better to use the `cs_locate_footer_assignment` filter above
      // as that allows individual posts to take precedence.
      $match = apply_filters( 'cs_match_footer_assignment', $match, $assignments, $post );


      // Fallback to the oldest footer
      if ( $fallback && null === $match ) {
        $posts = get_posts( array(
          'post_type' => 'cs_footer',
          'post_status' => 'any',
          'order' => 'ASC',
          'posts_per_page' => 1
        ) );

        if ( ! empty( $posts) ) {
          $match = $posts[0]->ID;
        }

      }

      if ( ! is_null( $match ) ) {
        $match = (int) apply_filters( 'wpml_object_id', $match, 'cs_footer', true, apply_filters( 'wpml_current_language', null ) );
      }

      $this->located = $match;

    }

    return $this->located;

  }

}
