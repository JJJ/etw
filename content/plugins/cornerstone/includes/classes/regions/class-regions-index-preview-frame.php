<?php

class Cornerstone_Regions_Index_Preview_Frame extends Cornerstone_Plugin_Component {

  protected $mode;
  protected $mode_id;

  public function setup() {

    $state = $this->plugin->component( 'Preview_Frame_Loader' )->get_state();

    if ( isset( $state['previewing'] ) ) {
      $parts = explode(':', $state['previewing']);
      $this->mode = array_shift($parts);
      $this->mode_id = implode(':', $parts);

      if ( false !== strpos($this->mode, 'header' ) ) {
        add_filter( 'cornerstone_header_preview_data', array( $this, 'get_header_preview_data' ) );
      }
      if ( false !== strpos($this->mode, 'footer' ) ) {
        add_filter( 'cornerstone_footer_preview_data', array( $this, 'get_footer_preview_data' ) );
        add_action( 'wp_footer', array( $this, 'scroll_to_footer' ) );
      }
    }

  }

  public function get_header_preview_data() {

    $post_id = (int) $this->mode_id;

    if ( 'header' === $this->mode ) {
      return $post_id;
    }

    if ( 'header-template' === $this->mode ) {
      return new Cornerstone_Template( ( $post_id > 0 ) ? $post_id : "header:{$this->mode_id}");
    }

    return null;
  }

  public function get_footer_preview_data() {

    $post_id = (int) $this->mode_id;

    if ( 'footer' === $this->mode ) {
      return (int) $this->mode_id;
    }

    if ( 'footer-template' === $this->mode ) {
      return new Cornerstone_Template(( $post_id > 0 ) ? $post_id : "footer:{$this->mode_id}");
    }

    return null;
  }

  public function get_region_preview_data( $data ) {
    return array(
      'regions'  => $this->data['regions'],
      'settings' => $this->data['settings'],
    );
  }

  public function config( $state ) {
    return array();
  }

  public function scroll_to_footer() { ?>
    <script>
      jQuery(function($){

        var top = document.body.scrollHeight;
        var $firstbar = $('.x-colophon .x-bar').first();
        if ($firstbar.length) {
          top = $firstbar.offset().top
        }

        window.scrollTo(0,top);
      });
    </script>
    <?php
  }
}
