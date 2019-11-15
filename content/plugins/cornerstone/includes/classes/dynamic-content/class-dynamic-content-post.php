<?php

/**
 * Title
 * Excerpt
 * Publish Date
 * Publish Time
 * Modified Date
 * Modified Time
 * Comment Count
 * Permalink
 * Custom Field
 * ID
 */

class Cornerstone_Dynamic_Content_Post extends Cornerstone_Plugin_Component {

  protected $cache = array();

  public function setup() {
    add_filter( 'cs_dynamic_content_post', array( $this, 'supply_field' ), 10, 3 );
    add_action( 'cs_dynamic_content_setup', array( $this, 'register' ) );
    add_filter( 'cs_dynamic_options_postmeta', array( $this, 'populate_postmeta' ), 10, 2 );
  }

  public function register() {

    cornerstone_dynamic_content_register_group(array(
      'name'  => 'post',
      'label' => csi18n('app.dc.group-title-post')
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'title',
      'group' => 'post',
      'label' => csi18n('app.dc.title'),
      'controls' => array( 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'excerpt',
      'group' => 'post',
      'label' => 'Excerpt',
      'controls' => array( 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'featured_image',
      'group' => 'post',
      'label' => 'Featured Image',
      'controls' => array( 'post' ),
      'options' => array(
        'supports' => array( 'image' ),
      )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'publish_date',
      'group' => 'post',
      'label' => 'Publish Date',
      'controls' => array( 'date-format', 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'publish_time',
      'group' => 'post',
      'label' => 'Publish Time',
      'controls' => array( 'time-format', 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'modified_date',
      'group' => 'post',
      'label' => 'Modified Date',
      'controls' => array( 'date-format', 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'modified_time',
      'group' => 'post',
      'label' => 'Modified Time',
      'controls' => array( 'time-format', 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'comment_count',
      'group' => 'post',
      'label' => 'Comment Count',
      'controls' => array( 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'permalink',
      'group' => 'post',
      'label' => 'Permalink',
      'controls' => array( 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'meta',
      'group' => 'post',
      'label' => 'Meta (Custom Field)',
      'controls' => array( 'post', 'postmeta' ),
      'options' => array(
        'supports' => array( 'image' ),
        'always_customize' => true
      )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'id',
      'group' => 'post',
      'label' => csi18n('app.dc.id')
    ));

  }

  public function supply_field( $result, $field, $args = array() ) {

    $post = CS()->component('Dynamic_Content')->get_post_from_args( $args );
    // var_dump($post);
    if ( ! $post ) {
      return $result;
    }

    switch ($field) {
      case 'title':
        $result = get_the_title( $post );
        break;
      case 'excerpt':
        $result = get_the_excerpt( $post );
        break;
      case 'featured_image':
        $source = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'full' );
        $result = $source && isset($source[0]) ? $source[0] : '';
        break;
      case 'publish_date':
        $result = get_the_date( isset( $args['format'] ) ? $args['format'] : get_option('date_format'), $post->ID );
        break;
      case 'publish_time':
        $result = get_the_time( isset( $args['format'] ) ? $args['format'] : get_option('time_format  '), $post->ID );
        break;
      case 'modified_date':
        $result = get_the_modified_date( isset( $args['format'] ) ? $args['format'] : get_option('date_format'), $post->ID );
        break;
      case 'modified_time':
        $result = get_the_modified_time( isset( $args['format'] ) ? $args['format'] : get_option('time_format'), $post->ID );
        break;
      case 'comment_count':
        $result = (string) get_comments_number( $post->ID );
        break;
      case 'permalink':
        $result = get_permalink( $post );
        break;
      case 'meta':
      case 'custom_field':
        if ( isset( $args['key'] ) ) {
          $result = get_post_meta( $post->ID, $args['key'], true );
        }
        break;
      case 'id':
        $result = "$post->ID";
        break;
    }

    return $result;
  }

  public function populate_postmeta( $options, $args = array() ) {

    if ( isset( $args['context'] ) &&
      isset( $args['context']['mode'] ) &&
      'content' === $args['context']['mode'] &&
      isset( $args['context']['data'] ) &&
      isset( $args['context']['data']['post_id'] )
    ) {
      $meta_keys = array_diff(
        array_keys( get_post_custom( (int) $args['context']['data']['post_id'] ) ),
        array( '_cornerstone_data', '_cornerstone_version', '_cornerstone_settings' )
      );

      foreach ($meta_keys as $key) {
        $options[] = array( 'label' => $key, 'value' => $key );
      }

    } else {
      global $wpdb;

      $results = $wpdb->get_results( "SELECT DISTINCT $wpdb->postmeta.meta_key FROM $wpdb->postmeta", ARRAY_N );
      foreach ($results as $key) {
        $options[] = array( 'label' => $key[0], 'value' => $key[0] );
      }

    }

    return $options;

  }

}
