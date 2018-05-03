<?php

class Cornerstone_Model_Classic_Template extends Cornerstone_Plugin_Component {

  public $resources = array();
  public $name = 'classic-template';

  public function setup() {

    $records = $this->plugin->loadComponent('Layout_Manager')->get_all();

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


  protected function atts_from_request( $params ) {

    if ( ! isset( $params['model'] ) || ! isset( $params['model']['data'] ) || ! isset( $params['model']['data']['attributes'] ) ) {
      throw new Exception( 'Request to Classic Template model missing attributes.' );
    }

    $atts = $params['model']['data']['attributes'];

    if ( isset( $params['model']['data']['id'] ) ) {
      $atts['id'] = $params['model']['data']['id'];
    }

    return $atts;
  }

  public function create( $params ) {

    $atts = $this->atts_from_request( $params );

    if ( ! current_user_can( 'edit_pages' ) ) {
      throw new Exception( 'Capability mismatch.' );
		}

    if ( ! isset( $atts['elements'] ) ) {
      throw new Exception( 'Missing element data.' );
		}

		if ( !isset( $atts['type'] ) ) {
      $atts['type'] = 'block';
    }

		if ( ! isset( $atts['title'] ) ) {
      $atts['title'] = csi18n('common.untitled');
    }

		$atts['slug'] = uniqid( sanitize_key( $atts['title'] ) . '_' );

		$title = $atts['title'];

    $duplicates = 1;

    while ( !is_null( get_page_by_title( $title, ARRAY_N, 'cs_user_templates' ) ) ) {
			$title = sprintf( csi18n('common.ammended-title'), $atts['title'], (string) $duplicates++ );
		}

    $atts['title'] = $title;

		// SAVE
		$post_id = wp_insert_post( array(
			'post_title'  => $atts['title'],
			'post_name'   => $atts['slug'],
			'post_type'   => 'cs_user_templates',
			'post_status' => 'publish'
		) );

		update_post_meta( $post_id, 'cs_template_title', $atts['title'] );
		update_post_meta( $post_id, 'cs_template_elements', $atts['elements'] );
		update_post_meta( $post_id, 'cs_template_type', $atts['type'] );
		update_post_meta( $post_id, 'cs_template_slug', $atts['slug'] );
		update_post_meta( $post_id, 'cs_template_version', $this->plugin->version() );

		$atts['section'] = ( $atts['type'] == 'page' ) ? 'user-pages' : 'user-blocks';

    return $this->make_response( $this->to_resource( array(
      'title'    => $atts['title'],
      'slug'     => $atts['slug'],
      'type'     => $atts['type'],
      'section'  => $atts['section'],
      'elements' => $atts['elements'],
    ) ) );

  }

  public function delete( $params ) {
    $atts = $this->atts_from_request( $params );

    if ( ! $atts['id'] ) {
      throw new Exception( 'Attempting to delete Classic Template without specifying a slug.' );
    }

    if ( ! current_user_can( 'edit_pages' ) ) {
      throw new Exception( 'Capability mismatch.' );
		}

		$query = new WP_Query( array(
			'post_type'  => 'cs_user_templates',
			'meta_key'   => 'cs_template_slug',
			'meta_value' => $atts['id'],
			'posts_per_page' => 999,
			'post_status' => 'any'
		) );

		if ( !$query->post || ! wp_delete_post( $query->post->ID, true ) ) {
			throw new Exception( 'Unable to delete classic template.' );
		}
    return $this->make_response( array( 'id' => $atts['id'], 'type' => $this->name ) );
  }

  public function make_response( $data ) {

    $response = array(
      'data' => $data
    );

    if ( isset( $this->included ) ) {
      $response['included'] = $this->included;
    }

    return $response;

  }

  public function to_resource( $record ) {

    $resource = array(
      'id' => $record['slug'],
      'type' => $this->name
    );

    unset( $record['slug'] );
    $resource['attributes'] = $record;

    return $resource;

  }
}
