<?php

class Cornerstone_App_Boot extends Cornerstone_Plugin_Component {

  public $initial_route = false;

  public function setup() {
    add_action( 'parse_request', array( $this, 'detect_load' ) );
  }

  public function detect_load( $wp ) {

    if ( defined( 'IFRAME_REQUEST' ) || ( isset( $_REQUEST['wp_customize'] ) && 'on' == $_REQUEST['wp_customize'] ) ) {
      return;
    }

    $settings = $this->plugin->settings();

    if ( $settings['hide_access_path'] && ! is_user_logged_in() ) {
      return;
    }

    // Check if we're loading the ugly way
    $ugly = ( isset( $_GET['cs-launch'] ) && '1' === $_GET['cs-launch'] );

    // Or if we're loading the nice way
    $nice = false;
    if ( $wp->request ) {

      // If we have a request, see if it matches our app slug
      $parts = explode( '/', $wp->request );

      if ( is_array( $parts ) && $parts[0] === $this->plugin->common()->get_app_slug() ) {

        if ( 1 === count( $parts ) && '/' !== substr( $_SERVER['REQUEST_URI'], -1, 1 ) ) {
          wp_safe_redirect( $wp->request . '/' );
        }

        $nice = true;
      }

    }

    // Bail if we're not loading
    if ( !$ugly && !$nice ) {
      return;
    }

    $can_redirect = ( $ugly && !$nice && $this->plugin->component( 'Router' )->is_permalink_structure_valid() );

    // Allow an initial route to be passed if not using permalinks
    if ( isset( $_GET['cs_route'] ) ) {

      $route = esc_attr( $_GET['cs_route'] );

      if ( $route ) {

        // If we loaded ugly but we can use nice URLs, let's redirect.
        if ( $can_redirect ) {

          $redirect = add_query_arg( array(
            'cs_route' => $route
          ), trailingslashit( home_url( $this->plugin->common()->get_app_slug() ) ) );

          wp_safe_redirect( $redirect );
          exit;
        }

        $this->initial_route = $route;

      }

    } elseif ( $can_redirect ) {
      // redirect /?cs_app=1 to nice URL if supported
      wp_safe_redirect( trailingslashit( home_url( $this->plugin->common()->get_app_slug() ) ) );
      exit;
    }

    if ( ! is_user_logged_in() ) {
      auth_redirect();
    }

    do_action( 'cornerstone_boot_app' );

    // // Onwards
    // add_action('template_redirect', array( $this, 'template_redirect'), 0 );

  }

  // public function template_redirect() {
  //   do_action( 'cornerstone_boot_app' );
  // }

  public function get_initial_route() {
    return $this->initial_route;
  }

}
