<?php

class Cornerstone_Preview_Frame_Loader extends Cornerstone_Plugin_Component {

  protected $state = false;
  protected $zones = array();
  protected $frame = null;
  protected $prefilter_option_updates = array();
  protected $prefilter_meta_updates = array();

  public function setup() {

    if ( ! isset( $_POST['cs_preview_state'] ) || ! $_POST['cs_preview_state'] || 'off' === $_POST['cs_preview_state'] ) {
      return;
    }

    // Nonce verification
    if ( ! isset( $_POST['_cs_nonce'] ) || ! wp_verify_nonce( $_POST['_cs_nonce'], 'cornerstone_nonce' ) ) {
      echo -1;
      die();
    }

    $this->state = json_decode( base64_decode( $_POST['cs_preview_state'] ), true );

    do_action('cs_before_preview_frame', $this->state);

    add_filter( 'show_admin_bar', '__return_false' );
    add_action( 'template_redirect', array( $this, 'load' ), 0 );
    add_action( 'x_late_template_redirect', array( $this, 'load_late' ), 10000 );
    add_action( 'shutdown', array( $this, 'frame_signature' ), 1000 );
    add_filter( 'wp_die_handler', array( $this, 'remove_preview_signature' ) );

    add_filter( "get_post_metadata", array( $this, 'prefilter_meta_handler' ), 10, 4 );

    $route = ( isset( $this->state['route'] ) ) ? $this->state['route'] : 'app';
    $frame_component = cs_to_component_name( $route ) . '_Preview_Frame';
    $this->frame = $this->plugin->loadComponent( $frame_component );

    if ( ! $this->frame ) {
      throw new Exception( "Requested frame handler '$frame_component' does not exist." );
    }

    if ( isset( $this->state['noClient'] ) ) {
      return;
    }

    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
    add_action( 'wp_footer', array( $this, 'route_config' ) );

    $this->zones = $this->plugin->loadComponent('Common')->get_preview_zones();
    foreach ( $this->zones as $zone ) {
      add_action( $zone, array( $this, 'zone_output' ) );
    }

  }

  public function load() {
    nocache_headers();
    do_action( 'cs_preview_frame_load' );
  }

  public function load_late() {
    add_filter( 'x_masthead_atts',      array( $this, 'nav_overlay_header' ) );
    add_filter( 'x_colophon_atts',      array( $this, 'nav_overlay_footer' ) );
    add_filter( 'cs_content_atts',      array( $this, 'nav_overlay_content' ) );
    add_filter( 'cs_global_block_atts', array( $this, 'nav_overlay_global_block' ), 10, 2 );
  }

  public function zone_output() {
    echo '<div data-cs-zone="' . current_action() . '"></div>';
  }

  public function get_state() {
    return $this->state;
  }

  public function data() {

    if ( ! $this->state ) {
      return array( 'timestamp' => $this->state);
    }

    return array(
      'timestamp' => $this->state['timestamp']
    );

  }

  public function frame_signature() {
    echo 'CORNERSTONE_FRAME';
  }

  public function remove_preview_signature( $return = null ) {
    remove_action( 'shutdown', array( $this, 'frame_signature' ), 1000 );
    return $return;
  }

  public function enqueue() {
    $this->plugin->loadComponent( 'App' )->register_app_scripts( $this->plugin->settings(), true );
    wp_enqueue_script( 'mediaelement' );
    wp_enqueue_script( 'cs-app' );
    wp_enqueue_style( 'cs-preview', $this->plugin->css( 'preview', true ), null, $this->plugin->version() );
  }

  public function route_config() {


    if ( isset( $this->state['route'] ) ) {
      echo '<script type="application/json" data-cs-preview-route="' . $this->state['route'] . '">';
      if ( is_callable( array( $this->frame, 'config' ) ) ) {
        echo json_encode( apply_filters( 'cs_preview_frame_route_config', $this->frame->config( $this->state ), $this->state['route'] ) );
      }
      echo '</script>';
    }

  }

  public function prefilter_options( $updates ) {
    $this->prefilter_option_updates = array_merge( $this->prefilter_option_updates, $updates );
    foreach ($updates as $key => $value) {
      add_filter( "pre_option_$key", array( $this, 'prefilter_option_handler' ) );
    }
  }

  public function prefilter_option_handler($value) {

    $option_name = preg_replace( '/^pre_option_/', '', current_filter() );

    if ( isset( $this->prefilter_option_updates[ $option_name ] ) ) {
      $value = apply_filters( 'option_' . $option_name, $this->prefilter_option_updates[ $option_name ] );
    }

    return $value;
  }

  public function prefilter_meta( $id, $updates ) {

    $key = 'o' . $id;

    if ( ! isset( $this->prefilter_meta_updates[ $key ] ) ) {
      $this->prefilter_meta_updates[ $key ] = array();
    }

    $this->prefilter_meta_updates[ $key ] = array_merge( $this->prefilter_meta_updates[ $key ], $updates );

  }

  public function prefilter_meta_handler( $value, $object_id, $meta_key, $single ) {
    if ( isset( $this->prefilter_meta_updates['o' . $object_id ] ) && isset( $this->prefilter_meta_updates['o' . $object_id ][$meta_key] ) ) {
      $value = $this->prefilter_meta_updates['o' . $object_id ][$meta_key];
      if ( ! $single ) {
        $value = array( $value );
      }
    }
    return $value;
  }

  public function nav_overlay_header( $atts ) {

    $header = $this->plugin->loadComponent('Regions')->get_last_active_header();

    if ( $header ) {
      $atts['data-cs-observeable-nav'] = cs_prepare_json_att( array(
        'action' => array(
          'route'   => 'headers.header',
          'id'      => $header->get_id(),
          'context' => 'Header'
        ),
        'label' => 'Edit Header'
      ) );
    }

    return $atts;
  }

  public function nav_overlay_footer( $atts ) {

    $footer = $this->plugin->loadComponent('Regions')->get_last_active_footer();

    if ( $footer ) {
      $atts['data-cs-observeable-nav'] = cs_prepare_json_att( array(
        'action' => array(
          'route'   => 'footers.footer',
          'id'      => $footer->get_id(),
          'context' => 'Footer'
        ),
        'label' => 'Edit Footer'
      ) );
    }

    return $atts;

  }

  public function nav_overlay_content( $atts ) {

    $id = get_the_ID();

    if ( $id ) {

      $post_type = get_post_type_object( get_post_type() );

      $atts['data-cs-observeable-nav'] = cs_prepare_json_att( array(
        'action' => array(
          'route'   => 'content.builder',
          'id'      => $id,
          'context' => $post_type->labels->singular_name
        ),
        'label' => 'Edit ' . $post_type->labels->singular_name
      ) );

    }

    return $atts;

  }

  public function nav_overlay_global_block( $atts, $global_block_id ) {

    if ( $global_block_id ) {

      $post_type = get_post_type_object( 'cs_global_block' );

      $atts['data-cs-observeable-nav'] = cs_prepare_json_att( array(
        'action' => array(
          'route'   => 'global-blocks.builder',
          'id'      => $global_block_id,
          'context' => $post_type->labels->singular_name
        ),
        'label' => 'Edit ' . $post_type->labels->singular_name
      ) );

    }

    return $atts;

  }

}
