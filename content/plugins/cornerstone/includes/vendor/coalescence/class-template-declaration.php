<?php

class TCO_Coalescence_Template_Declaration extends TCO_Coalescence_Template_Node {

  protected $selector = null;
  protected $directive = null;
  protected $conditions = array();
  protected $keys = array();
  protected $id = null;
  protected $value = '';

  protected function setup() {
    $this->id = uniqid();
    if ( $this->value ) {
      $this->add_keys( $this->value );
    }
  }

  public function get_id() {
    return $this->id();
  }

  public function add_keys( $value, $group = 'value' ) {

    if ( ! isset( $this->keys[ $group ] ) ) {
      $this->keys[ $group ] = array();
    }

    preg_match_all( TCO_Coalescence::$variable_pattern, $value, $matches );
    $keys = array_merge( $this->keys[ $group ], array_filter( $matches[1] ) );
    $this->keys[ $group ] = array_unique( $keys );
  }

  public function set_directive( $directive ) {
    $this->directive = $directive;
    $this->add_keys( $directive );
  }

  public function add_condition( $condition ) {

    $this->conditions[] = $condition;

    $this->add_keys( $condition->get_raw() , 'condition' );
  }

  public function update_selector( $selector ) {
    $this->selector = $selector;
    $this->add_keys( $selector, 'selector' );
  }

  public function get_selector() {
    return $this->selector;
  }

  public function get_directive() {
    return $this->directive;
  }

  public function get_conditions() {
    return $this->conditions;
  }

  public function get_keys() {
    return $this->keys;
  }

  public function serialize() {

    $conditions = array();

    foreach ($this->conditions as $condition) {
      $conditions[] = $condition->serialize();
    }

    $data = array(
      'selector' => $this->selector,
      'value' => $this->value
    );

    if ( ! empty( $this->keys ) ) {
      $data['keys'] = $this->keys;
    }

    if ( ! empty( $conditions ) ) {
      $data['conditions'] = $conditions;
    }

    if ( isset( $this->directive ) ) {
      $data['directive'] = $this->directive;
    }


    return $data;

  }

  public function unserialize( $data ) {

    $this->selector = $data['selector'];
    $this->value = $data['value'];

    if ( isset( $data['keys'] ) ) {
      $this->keys = $data['keys'];
    }

    if ( isset( $data['conditions'] ) && is_array( $data['conditions'] ) ) {
      foreach( $data['conditions'] as $condition_data ) {
        $condition = new TCO_Coalescence_Condition( null );
        $condition->unserialize( $condition_data );
        $this->conditions[] = $condition;
      }
    }

    if ( isset( $data['directive'] ) ) {
      $this->directive = $data['directive'];
    }

  }

}
