<?php

/**
 * Main class that should be instantiated by a project
 */
class TCO_Coalescence {

  public static $variable_pattern = '/%%\$(\w+)%%/';
  public $templates;
  public $reductions;
  public $items;
  public $formation;

  /**
   * Reset when instantiating
   */
  public function __construct() {
    $this->reset();
  }

  /**
   * Reset coalescence, allowing reuse
   * @return none
   */
  public function reset() {
    $this->formation = new TCO_Coalescence_Formation;
    $this->templates = array();
    $this->reductions = array();
    $this->items = array();
  }

  /**
   * Add a string CSS template for a given type
   * @param string $type
   * @param string $template
   */
  public function add_template( $type, $template ) {
    $this->templates[$type] = new TCO_Coalescence_Template( $template );
  }

  /**
   * Add a JSON encoded precompiled template for a given type
   * @param string $type
   * @param string $template
   */
  public function add_precompiled_template( $type, $template ) {
    $precompiled = new TCO_Coalescence_Template( null );
    $precompiled->unserialize( $template );
    $this->templates[$type] = $precompiled;
  }

  /**
   * Serialize a template, returning a string representation
   * @param string $type
   * @return string
   */
  public function serialize_template( $type ) {
    return $this->templates[$type]->serialize();
  }

  /**
   * Add data items to be processed through the template of the same type
   * @param string $type
   * @param array $items
   */
  public function add_items( $type, $items ) {

    if ( ! isset( $this->items[ $type ] ) ) {
      $this->items[ $type ] = array();
    }

    $this->items[ $type ] = array_merge( $this->items[ $type ], $items );

  }

  /**
   * Specifying a type, reduce the items of that type through the corresponding template
   * then add them to our CSS formation.
   * @param  string $type
   * @return none
   */
  public function reduce_template( $type ) {

    $reducer = $this->reductions[ $type ] = new TCO_Coalescence_Reducer( $this->templates[ $type ] );

    if ( isset( $this->items[ $type ] ) && is_array( $this->items[ $type ] ) ) {
      $items = $reducer->process( $this->items[ $type ] );
      $this->formation->add_items( $items );
    }

  }

  /**
   * Shorthand to fully reduce all registered templates
   * @return none
   */
  public function reduce() {
    $types = array_keys( $this->templates );
    foreach ( $types as $type) {
      $this->reduce_template( $type );
    }
  }

  /**
   * Process all items through their registered templates and return the output CSS
   * @return string
   */
  public function run() {

    if ( $this->formation->is_empty() ) {
      $this->reduce();
    }

    return $this->formation->write();
  }

}
