<?php

class TCO_Coalescence_Formation {

  public $formation = array();
  public $selector_prefix = '';

  public function __construct( $selector_prefix = '' ) {
    $this->selector_prefix = $selector_prefix;
  }

  public function add_items( $items ) {

    foreach ( $items as $declaration ) {
      $this->add_item( $declaration );
    }

    return $this->formation;

  }

  public function add_item( $declaration ) {

    $colon = strpos($declaration['declarations'], ":");
    if ( $colon === strrpos($declaration['declarations'], ":") && $colon === strlen($declaration['declarations']) - 1 ) {
      return;
    }

    $directive = ( $declaration['directive'] ) ? $declaration['directive'] : 'root';

    if ( ! isset( $this->formation[ $directive ] ) ) {
      $this->formation[ $directive ] = array();
    }

    if ( ! isset( $this->formation[ $directive ][ $declaration['selector'] ] ) ) {
      $this->formation[ $directive ][ $declaration['selector'] ] = array();
    }

    if ( ! in_array( $declaration['declarations'], $this->formation[ $directive ][ $declaration['selector'] ], true ) ) {
      $this->formation[ $directive ][ $declaration['selector'] ][] = $declaration['declarations'];
    }

  }

  public function write() {

    $buffer = '';

    foreach ($this->formation as $directive => $selectors ) {

      if ( 'root' !== $directive ) {
        $buffer .= $directive . ' {';
      }

      foreach ( $selectors as $selector => $declarations) {
        $buffer .= $this->selector_prefix . $selector . ' {';
        $buffer .= implode( ';', $declarations ) . ';';
        $buffer .= '}';
      }

      if ( 'root' !== $directive ) {
        $buffer .= '}';
      }

    }

    return $buffer;
  }

  public function is_empty() {
    return empty( $this->formation );
  }

}
