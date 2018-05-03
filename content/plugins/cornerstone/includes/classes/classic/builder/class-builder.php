<?php
/**
 * Deprecated. This class only exists now to handle redirecting the old
 * editing URLs to the new application.
 */
class Cornerstone_Builder extends Cornerstone_Plugin_Component {

  public function setup() {
    add_action( 'template_redirect', array( $this, 'load' ), 0 );
  }

  /**
   * Load the editor. This restructures the hooks for wp_head and
   * adds a hook to replace the main template with our own.
   */
  public function load() {

    $is_editing = ( ( isset($_REQUEST['cornerstone']) && $_REQUEST['cornerstone'] == 1 )
     && is_singular() && $this->plugin->common()->isPostTypeAllowed() );

    if ( ! $is_editing || defined( 'IFRAME_REQUEST' ) || ( ( isset( $_REQUEST['wp_customize'] ) && 'on' == $_REQUEST['wp_customize'] ) ) ) {
      return;
    }

    $post = $this->plugin->common()->locatePost();

    if ( ! $post ) {
      return;
    }

    wp_safe_redirect( $this->plugin->common()->get_app_route_url( 'content', $post->ID, 'builder' ) );
    exit;

  }

}
