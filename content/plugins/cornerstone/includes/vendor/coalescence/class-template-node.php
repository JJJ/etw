<?php

/**
 * Common properties and methods for our template nodes
 */
class TCO_Coalescence_Template_Node {

  protected $value;
  protected $parent;

  /**
   * Create a new node, optionally assigning the value.
   * @param string $value node contents
   */
  public function __construct( $value = null ) {
    if ( is_string( $value ) ) {
      $this->set_value( $value );
    }
    $this->setup();
  }

  /**
   * Override for additional instantiation logic
   * @return none
   */
  protected function setup() {

  }

  /**
   * Get current value
   * @return string node contents
   */
  public function get_value() {
    return $this->value;
  }

  /**
   * Assign this node's value
   * @param string $value node contents
   */
  public function set_value( $value ) {
    $this->value = $value;
  }

  /**
   * Get this node's parent
   * @return object $parent TCO_Coalescence_Template_Node
   */
  public function get_parent() {
    return $this->parent;
  }

  /**
   * Assign this node's parent
   * @param object $parent TCO_Coalescence_Template_Node
   */
  public function set_parent( $parent ) {
    $this->parent = $parent;
  }

}
