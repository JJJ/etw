<?php

class Cornerstone_Inline_Scripts extends Cornerstone_Plugin_Component {

  public $scripts = array();
  public $count = 0;

  public function add_script($id, $content, $type = 'text/javascript', $no_check = false ) {
    if ( $no_check || ! $this->script_is_empty( $content ) ) {
      $this->scripts[ $id ] = array( $content, $type );
    }
  }

  public function add_script_safely($id, $content, $type = 'text/javascript' ) {
    if ( ! $this->script_is_empty( $content ) ) {
      $this->add_script( $id, $this->protect_script( $content, $id ), $type, true );
    }
  }

  public function remove_script( $id ) {
    unset($this->scripts[ $id ]);
  }

  public function get_scripts() {

    $output = '';
    foreach ($this->scripts as $id => $script) {
      $type = $script[1];
      $output .= sprintf('<script id="%s" type="%s">%s</script>', $id, $script[1], $script[0] );
    }

    return $output;

  }

  public function output_scripts() {
    echo $this->get_scripts();
  }

  public function script_is_empty( $content ) {
    $pattern = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/';
    $output = preg_replace($pattern, '', $content);
    return ! trim( $output );
  }

  public function output_script( $content, $safe = false, $type = 'text/javascript' ) {

    if ( ! $this->script_is_empty( $content ) ) {
      if ( $safe ) {
        $content = $this->protect_script( $content );
      }
      printf('<script type="%s">%s</script>', $type, $content );
    }

  }

  public function protect_script( $content, $handle = '' ) {
    return "try { (function() { $content })() } catch( e ) { console.warn('Inline script $handle failed to run', e) }";
  }

}
