<?php

class Cornerstone_Enqueue_Extractor extends Cornerstone_Plugin_Component {

  protected $previous_scripts;
  protected $script_handles;
  protected $style_delta;
  protected $scripts;

  public function setup() {

    if ( ! $guessurl = site_url() ) {
      $guessurl = wp_guess_url();
    }

    $this->base_url = $guessurl;
    $this->content_url = defined('WP_CONTENT_URL')? WP_CONTENT_URL : '';

  }

  public function start() {

    $this->previous_scripts = wp_scripts();
    $wp_scripts = new WP_Scripts();
    $this->script_handles = array();

    $this->previous_styles = wp_styles();
    $wp_styles = new WP_Styles();
    $this->style_handles = array();

  }

  public function extract_scripts() {
    $wp_scripts = wp_scripts();
    $isolated = array_diff( $wp_scripts->queue, $this->script_handles );
    $this->script_handles = array_unique( array_merge( $isolated, $this->script_handles ) );
    return array_values( $this->resolve_script_dependencies( $wp_scripts, $isolated) );
  }

  public function extract_styles() {
    $wp_styles = wp_styles();
    $isolated = array_diff( $wp_styles->queue, $this->style_handles );
    $this->style_handles = array_unique( array_merge( $isolated, $this->style_handles ) );
    return array_values( $this->resolve_style_dependencies( $wp_styles, $isolated) );
  }

  public function resolve_script_dependencies($wp_deps, $handles) {
    $output = array();
    foreach ($handles as $handle) {
      if ( ! isset( $wp_deps->registered[ $handle ] ) ) {
        continue;
      }
      $obj = $wp_deps->registered[ $handle ];
      if (isset($obj->src) && false !== $obj->src) {
        $output[] = $handle;
      }
      if (is_array($obj->deps)) {
        $output = array_unique( array_merge( $this->resolve_script_dependencies( $wp_deps, $obj->deps), $output ) );
      }

    }
    return $output;
  }

  public function resolve_style_dependencies($wp_deps, $handles) {
    $output = array();
    foreach ($handles as $handle) {
      if ( ! isset( $wp_deps->registered[ $handle ] ) ) {
        continue;
      }
      $obj = $wp_deps->registered[ $handle ];
      if (isset($obj->src) && false !== $obj->src) {
        $output[] = $handle;
      }
      if (is_array($obj->deps)) {
        $output = array_unique( array_merge( $output, $this->resolve_style_dependencies( $wp_deps, $obj->deps) ) );
      }

    }
    return $output;
  }

  public function extract() {
    return array(
      'scripts' => $this->extract_scripts(),
      'styles' => $this->extract_styles()
    );
  }

  public function get_scripts() {

    $wp_scripts = wp_scripts();
    $this->scripts = array();
    add_filter( 'script_loader_tag', array( $this, 'catch_script_tags' ), 99, 3 );

    ob_start();
    $wp_scripts->do_items( $this->script_handles );
    ob_get_clean();

    global $wp_scripts;
    $wp_scripts = $this->previous_scripts;

    return array_values($this->scripts);

  }

  public function get_styles() {

    $wp_styles = wp_styles();
    $this->styles = array();

    // Note to reviewer: This does not remove functionality. We use this filter to detect which styles are going to be required in our live preview.
    add_filter( 'style_loader_tag', array( $this, 'catch_style_tags' ), 99, 3 );

    ob_start();
    $wp_styles->do_items( $this->style_handles );
    ob_get_clean();

    global $wp_styles;
    $wp_styles = $this->previous_styles;

    return array_values($this->styles);

  }

  public function catch_script_tags( $tag, $handle, $src ) {

    $scripts = wp_scripts();
    $obj = $scripts->registered[ $handle ];

    $before = '';
    $conditional = isset( $obj->extra['conditional'] ) ? $obj->extra['conditional'] : '';
    $has_conditional_data = $conditional && $scripts->get_data( $handle, 'data' );

    if ( $has_conditional_data ) {
      $before .= "<!--[if {$conditional}]>\n";
    }

    $extra_data = $scripts->print_extra_script( $handle, false );
    if ( $extra_data ) {
      $before .= $extra_data;
    }

    if ( $has_conditional_data ) {
      $before .= "<![endif]-->\n";
    }


    if ( ! preg_match( '|^(https?:)?//|', $src ) && ! ( $this->content_url && 0 === strpos( $src, $this->content_url ) ) ) {
      $src = $this->base_url . $src;
    }

    $new_script = array(
      'handle' => $handle,
      'tag'    => $tag,
      'src'    => $this->plugin->component('Common')->fix_script_tags( $handle, $src ),
      'obj'    => $obj,
    );

    if ( $before ) {
      $new_script['before'] = $before;
    }

    $this->scripts[] = $new_script;

    return $tag;

  }

  public function catch_style_tags( $tag, $handle, $href ) {

    $styles = wp_styles();

    $this->styles[] = array(
      'handle' => $handle,
      'tag'    => $tag,
      'href'   => $href,
      'obj'    => $styles->registered[ $handle ]
    );

    return $tag;

  }

}
