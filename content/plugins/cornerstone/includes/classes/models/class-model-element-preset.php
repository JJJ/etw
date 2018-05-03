<?php

class Cornerstone_Model_Element_Preset extends Cornerstone_Plugin_Component {

  public $resources = array();
  public $name = 'element/preset';

  public function load_all() {

    $posts = get_posts( array(
      'post_type' => array( 'cs_template' ),
      'post_status' => array( 'tco-data', 'publish' ),
      'orderby' => 'type',
      'posts_per_page' => 2500,
      'meta_key' => '_cs_template_type',
      'meta_value' => 'preset',
    ) );

    foreach ($posts as $post) {
      $record = $this->make_record( $post );
      if ( $record ) {
        $this->resources[] = $this->to_resource( $record );
      }
    }

  }

  public function query( $params ) {

    // Find All
    if ( empty( $params ) || ! isset( $params['query'] ) ) {
      $this->load_all();
      return $this->make_response( $this->resources );
    }

    $queried = array();
    $this->included = array();

    if ( isset( $params['query']['id'] ) ) {
      try {
        $queried[] = $this->to_resource( $this->make_record( $params['query']['id'] ) );
      } catch( Exception $e ) {
        return $this->make_error_response( 'Preset not found' );
      }
    }

    if ( isset( $params['query']['isDefault'] ) && $params['query']['isDefault'] ) {
      try {

        global $wpdb;
        $results = $this->plugin->loadComponent('Template_Manager')->lookup_default_presets();

        foreach ($results as $key => $value) {
          $record = $this->make_record( (int) $value );
          if ( $record ) {
            $queried[] = $this->to_resource( $record );
          }
        }

      } catch( Exception $e ) {
        return $this->make_error_response( 'Preset not found' );
      }
    }

    if ( isset( $params['query']['type'] ) ) {
      try {

        global $wpdb;
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_cs_template_subtype_preset' AND meta_value = %s", $params['query']['type'] ) );

        foreach ($results as $result) {
          $record = $this->make_record( (int) $result->post_id );
          if ( $record ) {
            $queried[] = $this->to_resource( $record );
          }
        }

      } catch( Exception $e ) {
        return $this->make_error_response( 'Preset not found' );
      }
    }

    return $this->make_response( ( isset( $params['single'] ) && isset( $queried[0] ) ) ? $queried[0] : $queried );

  }

  public function make_record( $post ) {

    $preset = new Cornerstone_Template( $post );

    if ( $preset->is_hidden() ) {
      return false;
    }

    $meta = $preset->get_meta();

    return array(
      'id'      => $preset->get_id(),
      'element' => $preset->get_subtype(),
      'title'   => $preset->get_title(),
      'atts'    => $meta['atts']
    );
  }


  public function create( $params ) {

    $atts = $this->atts_from_request( $params );

    $preset = new Cornerstone_Template( array(
      'title' => $atts['title'],
      'type'  => 'preset',
      'subtype' => $atts['element'],
      'meta' => array(
        'atts' => $atts['atts']
      )
    ) );

    $saved = $preset->save();

    return $this->make_response( $this->to_resource( $saved ) );

  }

  protected function atts_from_request( $params ) {

    if ( ! isset( $params['model'] ) || ! isset( $params['model']['data'] ) || ! isset( $params['model']['data']['attributes'] ) ) {
      throw new Exception( 'Request to Preset model missing attributes.' );
    }

    $atts = $params['model']['data']['attributes'];

    if ( isset( $params['model']['data']['id'] ) ) {
      $atts['id'] = $params['model']['data']['id'];
    }

    if ( isset( $params['model']['data']['relationships'] ) &&
      isset( $params['model']['data']['relationships']['element'] ) ) {
      $atts['element'] = $params['model']['data']['relationships']['element']['data']['id'];
    }

    return $atts;
  }


  public function update( $params ) {

    $atts = $this->atts_from_request( $params );

    if ( ! $atts['id'] ) {
      throw new Exception( 'Attempting to update Preset without specifying an ID.' );
    }

    $id = (int) $atts['id'];

    $preset = new Cornerstone_Template( $id );

    if ( isset( $atts['title'] ) ) {
      $preset->set_title( $atts['title'] );
    }

    if ( isset( $atts['atts'] ) ) {
      $preset->set_meta( array( 'atts' => $atts['atts'] ) );
    }

    return $this->make_response( $this->to_resource( $preset->save() ) );

  }

  public function delete( $params ) {
    $atts = $this->atts_from_request( $params );

    if ( ! $atts['id'] ) {
      throw new Exception( 'Attempting to delete Preset without specifying an ID.' );
    }

    $id = (int) $atts['id'];

    $preset = new Cornerstone_Template( $id );
    $preset->delete();

    return $this->make_response( array( 'id' => $id, 'type' => $this->name ) );
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
      'id' => $record['id'],
      'type' => $this->name,
      'relationships' => array()
    );

    if ( isset( $record['element'] ) ) {
      $resource['relationships']['element'] = array(
        'data' => array( 'type' => 'element/definition', 'id' => $record['element'] )
      );
      unset($record['element']);
    }

    unset( $record['id'] );
    $resource['attributes'] = $record;

    return $resource;

  }

  public function make_error_response( $message, $status = 404 ) {
    return array(
      'errors' => array(
        array( 'status' => $status, 'title' => $message )
      )
    );
  }

}
