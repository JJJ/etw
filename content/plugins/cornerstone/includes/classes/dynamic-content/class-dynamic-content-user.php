<?php

class Cornerstone_Dynamic_Content_User extends Cornerstone_Plugin_Component {

  protected $cache = array();

  public function setup() {
    add_filter( 'cs_dynamic_content_user', array( $this, 'supply_field' ), 10, 3 );
    add_action( 'cs_dynamic_content_setup', array( $this, 'register' ) );
    add_filter( 'cs_dynamic_options_usermeta', array( $this, 'populate_usermeta' ) );
  }

  public function register() {
    cornerstone_dynamic_content_register_group(array(
      'name'  => 'user',
      'label' => csi18n( 'app.dc.group-title-user' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'display_name',
      'group' => 'user',
      'label' => csi18n( 'app.dc.global.display-name' ),
      'controls' => array( 'user' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'email',
      'group' => 'user',
      'label' => csi18n( 'app.dc.global.email-address' ),
      'controls' => array( 'user' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'gravatar',
      'group' => 'user',
      'label' => csi18n( 'app.dc.global.gravatar-url' ),
      'controls' => array( 'user' ),
      'options' => array(
        'supports' => array( 'image' )
      ),
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'registration_date',
      'group' => 'user',
      'label' => csi18n( 'app.dc.global.registration-date' ),
      'controls' => array( 'date-format', 'user' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'registration_time',
      'group' => 'user',
      'label' => csi18n( 'app.dc.global.registration-time' ),
      'controls' => array( 'time-format', 'user' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'meta',
      'group' => 'user',
      'label' => csi18n( 'app.dc.global.usermeta' ),
      'controls' => array( 'user', 'usermeta' ),
      'options' => array(
        'supports' => array( 'image' ),
        'always_customize' => true
      ),
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'id',
      'group' => 'user',
      'label' => csi18n('app.dc.id'),
      'controls' => array(
        'user'
      )
    ));
  }

  public function supply_field( $result, $field, $args) {

    $user = CS()->component('Dynamic_Content')->get_user_from_args( $args );

    if (!$user) {
      return $result;
    }

    switch ( $field ) {
      case 'display_name': {
        $result = $user->data->display_name;
        break;
      }
      case 'email': {
        $result = $user->data->user_email;
        break;
      }
      case 'avatar':
      case 'gravatar': {
        $result = get_avatar_url( $user->ID, $args );
        break;
      }
      case 'registration_date': {
        $result = date( isset( $args['format'] ) ? $args['format'] : get_option('date_format'), strtotime( $user->data->user_registered ) );
        break;
      }
      case 'registration_time': {
        $result = date( isset( $args['format'] ) ? $args['format'] : get_option('time_format'), strtotime( $user->data->user_registered ) );
        break;
      }
      case 'meta': {
        if ( isset( $args['key'] ) ) {
          $result = $user->get( $args['key'] );
        }
        break;
      }
      case 'id': {
        $result = "{$user->data->ID}";
        break;
      }
    }

    return $result;

  }

  public function populate_usermeta( $options ) {
    global $wpdb;

    $results = $wpdb->get_results( "SELECT DISTINCT $wpdb->usermeta.meta_key FROM $wpdb->usermeta", ARRAY_N );
    foreach ($results as $key) {
      $options[] = array( 'label' => $key[0], 'value' => $key[0] );
    }

    return $options;
  }

}
