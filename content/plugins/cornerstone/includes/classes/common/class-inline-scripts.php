<?php

class Cornerstone_Inline_Scripts extends Cornerstone_Plugin_Component {

  public $scripts = array();
  public $count = 0;

  public function add_script($id, $content, $type = 'text/javascript' ) {
    $this->scripts[ $id ] = array( $content, $type );
  }

  public function add_script_safely($id, $content, $type = 'text/javascript' ) {
    $content = "try { (function() { $content })() } catch( e ) { console.warn('Inline script $id failed to run', e) }";
    $this->add_script( $id, $content, $type );
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

}
