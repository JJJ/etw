<?php

class Cornerstone_Walker {

  public $child_key = '_modules';
  public $parent = null;
  public $data = array();
  public $items = array();

  public function __construct( $data, $parent = null, $child_key = null ) {

    $this->data = $data;
    $this->parent = $parent;

    if ( $parent ) {
      $this->child_key = $parent->child_key;
    } elseif ( $child_key ) {
      $this->child_key = $child_key;
    }

    $this->setup();

    if ( isset( $this->data[$this->child_key] ) ) {

      foreach ( $this->data[$this->child_key] as $item ) {
        $class = get_class($this);
        $this->items[] = new $class( $item, $parent );
      }

    }

  }

  public function setup() {

  }

  public function walk( $callable ) {

    foreach ( $this->items as $item ) {
      $item->walk( $callable );
    }

    call_user_func_array( $callable, array( $this ) );

  }

  public function data() {
    return $this->data;
  }

}
