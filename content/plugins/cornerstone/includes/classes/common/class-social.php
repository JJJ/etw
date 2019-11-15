<?php

class Cornerstone_Social extends Cornerstone_Plugin_Component {

  public $options;

  public function get_social_share_options() {
    if ( ! isset( $this->options ) ) {
      $this->options = apply_filters( 'cs_social_share_options', $this->default_options() );
    }
    return $this->options;
  }

  public function get_default_share_type() {
    $options = $this->get_social_share_options();
    return ! empty( $options ) && isset( $options[0]['value'] ) ? $options[0]['value'] : '';
  }

  public function default_options() {
    return array(
      array( 'value' => 'facebook',    'label' => 'Facebook' ),
      array( 'value' => 'twitter',     'label' => 'Twitter' ),
      array( 'value' => 'linkedin',    'label' => 'LinkedIn' ),
      array( 'value' => 'pinterest',   'label' => 'Pinterest' ),
      array( 'value' => 'reddit',      'label' => 'Reddit' ),
      array( 'value' => 'email',       'label' => __( 'Email', 'cornerstone' ) ),
    );
  }

  public function get_share_url( $type='facebook' ) {

    global $wp;

    $share_url = is_singular() ? get_permalink() : home_url( ($wp->request) ? $wp->request : '' );

    return urlencode( apply_filters('cs_social_share_url', $share_url, $type ) );

  }

  public function get_share_title() {
    return is_singular() ? get_the_title() : apply_filters( 'the_title', get_page( get_option( 'page_for_posts' ) )->post_title );
  }

  public function get_share_image() {
    $share_image_info = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
    return ( function_exists( 'x_get_featured_image_with_fallback_url' ) ) ? urlencode( x_get_featured_image_with_fallback_url() ) : urlencode( $share_image_info[0] );
  }

  public function make_popup( $name = 'popupShare', $url, $args ) {

    $args = wp_parse_args( $args, array(
      'width'      => 500,
      'height'     => 500,
      'resizable'  => 0,
      'toolbar'    => 0,
      'menubar'    => 0,
      'status'     => 0,
      'location'   => 0,
      'scrollbars' => 0
    ));

    $arg_list = array();

    foreach ($args as $arg => $value ) {
      $arg_list[] = "$arg=$value";
    }

    $arg_string = implode( ', ', $arg_list );

    return "window.open('$url', '$name', '$arg_string'); return false;";
  }

  public function setup_atts( $atts, $type, $title ) {

    $atts['href'] = '#';

    $share_url = $this->get_share_url( $type );
    $title = esc_attr( cs_dynamic_content( $title ? $title : $this->get_share_title() ) );
    $share_title = urlencode( $title );

    switch ($type) {
      case 'facebook' :
        $atts['onclick'] = $this->make_popup( 'popupFacebook', "http://www.facebook.com/sharer.php?u={$share_url}&amp;t={$share_title}", array( 'height' => 270, 'width' => 650 ) );
        break;
      case 'twitter' :
        $atts['onclick'] = $this->make_popup( 'popupTwitter', "https://twitter.com/intent/tweet?text={$share_title}&amp;url={$share_url}", array( 'height' => 370, 'width' => 500 ) );
        break;
      case 'google-plus' :
        $atts['onclick'] = $this->make_popup( 'popupGooglePlus', "https://plus.google.com/share?url={$share_url}", array( 'height' => 226, 'width' => 650 ) );
        break;
      case 'linkedin' :
        $share_content = urlencode( cs_get_raw_excerpt() );
        $share_source  = urlencode( get_bloginfo( 'name' ) );
        $atts['onclick'] = $this->make_popup( 'popupLinkedIn', "http://www.linkedin.com/shareArticle?mini=true&amp;url={$share_url}&amp;title={$share_title}&amp;summary={$share_content}&amp;source={$share_source}", array( 'height' => 480, 'width' => 610 ) );
        break;
      case 'pinterest' :
        $share_image = $this->get_share_image();
        $atts['onclick'] = $this->make_popup( 'popupPinterest', "http://pinterest.com/pin/create/button/?url={$share_url}&amp;media={$share_image}&amp;description={$share_title}", array( 'height' => 265, 'width' => 750 ) );
        break;
      case 'reddit' :
        $atts['onclick'] = $this->make_popup( 'popupReddit', "http://www.reddit.com/submit?url={$share_url}", array( 'height' => 450, 'width' => 875 ) );
        break;
      case 'email' :
        $atts['href'] = "mailto:?subject=$title&amp;body=$share_url";
        break;
    }

    return apply_filters( 'cs_social_share_atts', $atts, $type, $title );
  }



}
