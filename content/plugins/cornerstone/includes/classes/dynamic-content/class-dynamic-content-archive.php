<?php

class Cornerstone_Dynamic_Content_Archive extends Cornerstone_Plugin_Component {

  public function setup() {
    add_filter('cs_dynamic_content_archive', array( $this, 'supply_field' ), 10, 3 );
    add_action('cs_dynamic_content_setup', array( $this, 'register' ) );
  }

  public function register() {

    cornerstone_dynamic_content_register_group(array(
      'name'  => 'archive',
      'label' => csi18n('app.dc.group-title-archive')
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'title',
      'group' => 'archive',
      'label' => csi18n('app.dc.title'),
      'controls' => array( 'term' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'description',
      'group' => 'archive',
      'label' => csi18n('app.dc.description'),
      'controls' => array( 'term' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'url',
      'group' => 'archive',
      'label' => csi18n('app.dc.url'),
      'controls' => array( 'term' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'meta',
      'group' => 'archive',
      'label' => csi18n('app.dc.meta'),
      'controls' => array(
        'term',
        array(
          'key' => 'key',
          'type' => 'text',
          'label' => csi18n('app.dc.key'),
          'options' => array( 'placeholder' => csi18n('app.dc.meta-key') )
        )
      ),
      'options' => array(
        'supports' => array( 'image' ),
        'always_customize' => true
      ),
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'id',
      'group' => 'archive',
      'label' => csi18n('app.dc.id'),
      'controls' => array( 'term' )
    ));

  }

  public function supply_field( $result, $field, $args = array() ) {

    $term = CS()->component('Dynamic_Content')->get_term_from_args( $args );

    if ( ! $term ) {
      return $result;
    }

    switch ( $field ) {
      case 'title': {
        $result = $term->name;
        break;
      }
      case 'description': {
        $result = $term->description;
        break;
      }
      case 'url': {
        $result = get_term_link( $term );
        break;
      }
      case 'meta': {
        if ( isset( $args['key'] ) ) {
          $result = get_term_meta( $term->term_id, $args['key'], true );
        }
        break;
      }
      case 'id': {
        $result = "$term->term_id";
        break;
      }
    }

    return $result;
  }
}
