<?php

class Cornerstone_Template {

  protected $id = null;
  protected $title;
  protected $type;
  protected $subtype;
  protected $package_signature;
  protected $preview;
  protected $hidden;
  protected $meta = null;
  protected $manager;

  protected $legacy = false;

  public function __construct( $post ) {

    $this->manager = CS()->loadComponent('Template_Manager');

    if ( is_array( $post ) ) {
      if ( isset( $post['id'] ) ) {
        $post = $post['id'];
      } else {
        return $this->create_new( $post );
      }
    }

    $this->load_from_post( $post );

  }

  protected function create_new( $data ) {

    $this->set_title( isset( $data['title'] ) ? $data['title'] : false );
    $this->set_type( isset( $data['type'] ) ? $data['type'] : '' );
    $this->set_subtype( isset( $data['subtype'] ) ? $data['subtype'] : '' );
    $this->set_preview( isset( $data['preview'] ) ? $data['preview'] : '' );
    $this->set_hidden( isset( $data['hidden'] ) ? $data['hidden'] : false );
    $this->set_package_signature( isset( $data['package_signature'] ) ? $data['package_signature'] : null );
    $this->set_meta( isset( $data['meta'] ) ? $data['meta'] : null );


  }

  protected function load_from_post( $post ) {

    if ( is_string( $post ) ) {
      $post = (int) $post;
    }

    if ( 0 === $post ) {
      throw new Exception( 'Unable to determine template ID.' );
    }

    if ( is_int( $post ) ) {
      $post = get_post( $post );
    }

    if ( ! is_a( $post, 'WP_Post' ) ) {
      throw new Exception( 'Unable to load template from post | ' . serialize( $post ) );
    }

    if ( 'cs_user_templates' === $post->post_type ) {
      return $this->load_from_legacy_post( $post );
    }

    if ( 'cs_template' !== $post->post_type ) {
      throw new Exception( 'Attempted to load template from incorrect post_type | ' . serialize( $post ) );
    }

    $this->id = $post->ID;
    $this->title = $post->post_title ? $post->post_title : '';

    $content = cs_maybe_json_decode( $post->post_content );

    if ( is_array( $content ) ) {
      $this->type = isset( $content['type'] ) ? $content['type'] : '';
      $this->subtype = isset( $content['subtype'] ) ? $content['subtype'] : '';
      $this->preview = isset( $content['preview'] ) ? $content['preview'] : '';
      $this->package_signature = isset( $content['package_signature'] ) ? $content['package_signature'] : '';
      $this->hidden = isset( $content['hidden'] ) ? (bool) $content['hidden'] : false;
    }

  }

  public function load_from_legacy_post( $post ) {

    $this->id = $post->ID;
    $type = get_post_meta( $post->ID, 'cs_template_type', true );
    $format = ( 'block' !== $type ) ? '%s (Page)' : '%s (Block)';
    $this->title = sprintf( $format, get_post_meta( $post->ID, 'cs_template_title', true ) );
    $this->type = 'content';
    $this->preview = '';
    $this->hidden = false;

    $elements = get_post_meta( $post->ID, 'cs_template_elements', true );

    $should_migrate = true;

    foreach ($elements as $element) {
      if ( isset( $element['type'] ) && 'classic:section' === $element['type'] ) {
        $should_migrate = false;
      }
    }

    if ( $should_migrate ) {
      $elements = CS()->loadComponent( 'Element_Migrations' )->migrate_classic( $elements );
    }

    $this->meta = array( 'legacy' => true, 'elements' => $elements );

    $this->legacy = true;

  }

  public function load_meta() {
    $this->meta = cs_get_serialized_post_meta( $this->id, '_cs_template_data', true );
  }

  public function save() {

    if ( ! current_user_can( 'manage_options' ) ) {
      throw new Exception( 'Unauthorized' );
    }

    $args = array(
      'post_title'   => sanitize_text_field( $this->get_title() ),
      'post_type'    => 'cs_template',
      'post_status'  => 'tco-data',
      'post_content' => wp_slash( cs_json_encode( array(
        'type'              => sanitize_text_field( $this->get_type() ),
        'subtype'           => sanitize_text_field( $this->get_subtype() ),
        'preview'           => sanitize_text_field( $this->get_preview() ),
        'package_signature' => sanitize_text_field( $this->get_package_signature() ),
        'hidden'            => (bool) $this->is_hidden()
      ) ) )
    );

    if ( is_int( $this->id ) ) {
      $args['ID'] = $this->id;
    }

    $id = wp_insert_post( $args );

    if ( ! $id || is_wp_error( $id ) ) {
      throw new Exception( "Unable to update template: $id" );
    }

    // Index template type
    update_post_meta( $id, '_cs_template_type', $this->get_type() );

    // Index preset element
    $subtype = $this->get_subtype();
    if ( $subtype ) {
      update_post_meta( $id, '_cs_template_subtype_' . $this->get_type(), $subtype );
    }

    if ( ! is_null( $this->meta ) && ! empty( $this->meta ) ) {
      cs_update_serialized_post_meta( $id, '_cs_template_data', $this->meta );
    }

    $this->load_from_post( (int) $id );

    return $this->serialize();

  }

  public function get_id() {
    return $this->id;
  }

  public function get_title() {
    return $this->title;
  }

  public function get_type() {
    return $this->type;
  }

  public function get_subtype() {
    return $this->subtype;
  }

  public function get_preview() {
    return $this->preview;
  }

  public function get_package_signature() {
    return $this->package_signature;
  }

  public function is_hidden() {
    if ( ! isset( $this->hidden ) ) {
      return false;
    }
    return $this->hidden;
  }

  public function get_meta() {
    if ( is_null( $this->meta ) ) {
      $this->load_meta();
    }
    return $this->meta;
  }

  public function serialize() {
    return array(
      'id' => $this->id,
      'title' => $this->title,
      'type' => $this->type,
      'subtype' => $this->subtype,
      'preview' => $this->preview,
      'hidden'  => $this->hidden,
      'package-signature' => $this->package_signature,
      'meta' => $this->meta
    );
  }

  public function set_title( $title ) {
    return $this->title = sanitize_text_field( $title, sprintf( csi18n('common.untitled-entity'), csi18n('common.entity-content') ) );
  }

  public function set_type( $type ) {
    return $this->type = sanitize_title_with_dashes( $type );
  }

  public function set_subtype( $subtype ) {
    return $this->subtype = sanitize_text_field( $subtype );
  }

  public function set_preview( $preview ) {
    return $this->preview = sanitize_text_field( $preview );
  }

  public function set_hidden( $hidden ) {
    return $this->hidden = (bool) $hidden;
  }

  public function set_package_signature( $package_signature ) {
    return $this->package_signature = $package_signature;
  }

  public function set_meta( $meta ) {
    return $this->meta = $meta;
  }

  public function delete() {

    if ( ! current_user_can( 'manage_options' ) ) {
      throw new Exception( 'Unauthorized' );
    }

    do_action('cornerstone_delete_template', $this->id, $this->type );

    return wp_delete_post( $this->id, true );

  }

}
