<?php
/**
 * site-title
 * site-tagline
 * site-url
 */

class Cornerstone_Dynamic_Content_Global extends Cornerstone_Plugin_Component {

  protected $cache = array();

  public function setup() {
    add_filter('cs_dynamic_content_global', array( $this, 'supply_field' ), 10, 3 );
    add_action('cs_dynamic_content_setup', array( $this, 'register' ) );
  }

  public function register() {
    cornerstone_dynamic_content_register_group(array(
      'name'  => 'global',
      'label' => csi18n('app.dc.group-title-global')
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'site_title',
      'group' => 'global',
      'label' => csi18n( 'app.dc.global.site-title' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'site_tagline',
      'group' => 'global',
      'label' => csi18n( 'app.dc.global.site-tagline' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'home_url',
      'group' => 'global',
      'label' => csi18n( 'app.dc.global.home-url' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'admin_url',
      'group' => 'global',
      'label' => csi18n( 'app.dc.global.admin-url' )
    ));


    cornerstone_dynamic_content_register_field(array(
      'name'  => 'date',
      'group' => 'global',
      'label' => csi18n( 'app.dc.global.current-date' ),
      'controls' => array( 'date-format' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'time',
      'group' => 'global',
      'label' => csi18n( 'app.dc.global.current-time' ),
      'controls' => array( 'time-format' )
    ));

  }

  public function supply_field( $result, $field, $args) {

    switch ($field) {
      case 'site_title':
        $result = get_bloginfo( 'name' );
        break;
      case 'site_tagline':
        $result = get_bloginfo( 'description' );
        break;
      case 'home_url':
        $result = home_url();
        break;
      case 'admin_url':
        $result = admin_url();
        break;
      case 'date':
        $date_args = wp_parse_args( $args, array(
          'time' => time() + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ),
          'format' => get_option('date_format')
        ));
        $result = date( $date_args['format'], $date_args['time'] );
        break;
      case 'time':
        $time_args = wp_parse_args( $args, array(
          'time' => time() + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ),
          'format' => get_option('time_format')
        ));
        $result = date( $time_args['format'], $time_args['time'] );
        break;
    }

    return $result;
  }

}
