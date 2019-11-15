<?php

class TCO_Coalescence_Template_Declaration extends TCO_Coalescence_Template_Node {

  protected $selector = null;
  protected $directive = null;
  protected $conditions = array();
  protected $loops = array();
  protected $keys = array();
  protected $value = '';

  protected function setup() {
    if ( $this->value ) {
      $this->add_keys_from_template_string( $this->value );
    }
  }

  /**
   * Extract an array of keys from a tempalte string and add them to a group
   *
   * @param string $content
   * @param string $group
   * @return void
   */
  public function add_keys_from_template_string( $content, $group = 'value') {

    preg_match_all( TCO_Coalescence::$variable_pattern, $content, $matches );
    $this->add_keys( $matches[1], $group );

  }

  /**
   * Add an array of keys to a group
   *
   * @param array $keys
   * @param string $group
   * @return void
   */
  public function add_keys( $keys, $group = 'value' ) {

    $valid = array_filter( $keys );

    if ( 0 >= count( $valid ) ) {
      return;
    }

    if ( ! isset( $this->keys[ $group ] ) ) {
      $this->keys[ $group ] = array();
    }

    $merged = array_merge( $this->keys[ $group ], $valid );
    $this->keys[ $group ] = array_unique( $merged );

  }

  public function set_directive( $directive ) {
    $this->directive = $directive;
    $this->add_keys_from_template_string( $directive );
  }

  public function add_condition( $condition ) {

    $this->conditions[] = $condition;

    $this->add_keys_from_template_string( $condition->get_raw() , 'condition' );
  }

  public function add_loop( $loop ) {
    $this->loops[$loop->get_id()] = $loop;
    $this->update_scope( $loop->create_scope() );
    $this->add_keys( array( $loop->get_source() ), 'loop' );
  }

  public function update_selector( $selector ) {
    $this->selector = $selector;
    $this->add_keys_from_template_string( $selector, 'selector' );
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

  public function get_loops() {
    return $this->loops;
  }

  public function get_keys() {
    return $this->keys;
  }

  public function get_keys_for( $key ) {
    return isset( $this->keys[ $key ] ) ? $this->keys[ $key ] : array();
  }

  public function get_required_keys() {
    if ( ! isset( $this->required_keys ) ) {
      $this->required_keys = array_merge(
        $this->get_keys_for( 'value' ),
        $this->get_keys_for( 'selector' ),
        $this->get_keys_for( 'loop' )
      );
    }
    return $this->required_keys;
  }

  public function scope_keys( $keys ) {

    $scoped_keys = array();

    foreach ($keys as $group => $group_keys ) {

      if ( ! isset( $scoped_keys[ $group ] ) ) {
        $scoped_keys[ $group ] = array();
      }

      foreach( $group_keys as $key ) {
        if ( isset( $this->scope[ $key ] ) ) {
          $scoped_keys[ $group ][] = $this->scope[ $key ] . ':' . $key;
        } else {
          $scoped_keys[ $group ][] = $key;
        }
      }

    }

    return $scoped_keys;

  }

  public function unscope_keys( $keys ) {

    $unscoped_keys = array();
    $scope = array();

    foreach( $keys as $group => $group_keys ) {

      $unscoped_keys[ $group ] = array();

      foreach ( $group_keys as $key ) {
        $parts = explode(':', $key);
        $unscoped_key = array_pop($parts);
        $unscoped_keys[ $group ][] = $unscoped_key;
        if ( ! empty( $parts ) ) {
          $scope[ $unscoped_key ] = implode( ':', $parts );
        }

      }
    }

    return array( $unscoped_keys, $scope );
  }

  public function serialize() {

    $loops = array();
    $conditions = array();

    foreach ($this->loops as $loop) {
      $loops[$loop->get_id()] = $loop->serialize();
    }

    foreach ($this->conditions as $condition) {
      $conditions[] = $condition->serialize();
    }

    $data = array(
      'selector' => $this->selector,
      'value' => $this->value
    );

    if ( ! empty( $this->keys ) ) {
      $data['keys'] = $this->scope_keys( $this->keys );
    }

    if ( ! empty( $this->loops ) ) {
      $data['loops'] = $loops;
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

      $unscoped = $this->unscope_keys( $data['keys'] );

      $this->keys = $unscoped[0];

      if ( !empty( $unscoped[1] ) ) {
        $this->scope = $unscoped[1];
      }

    }

    if ( isset( $data['loops'] ) && is_array( $data['loops'] ) ) {
      foreach( $data['loops'] as $id => $loop_data ) {
        $loop = new TCO_Coalescence_Loop( null );
        $loop->unserialize( array_merge( array( 'id' => $id ), $loop_data ) );
        $this->loops[] = $loop;
      }
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


  public function reduce_entities( $entities ) {

    // Filter out entities that don't pass the declaration's condition(s)
    $filtered_entities = $this->filter_entities_by_condition( $entities );

    $value_keys = $this->get_keys_for('value');
    $selector_keys = $this->get_keys_for('selector');

    // Reduce items to biforcated signed groups
    $signed = array();

    foreach ($filtered_entities as $entity) {
      $key = $entity->checksum( array_merge( $value_keys, $selector_keys) );
      if ( ! isset( $signed[ $key ] ) ) {
        $signed[ $key ] = array(
          'props' => $entity->get_data( $value_keys ),
          'selectors' => array()
        );
      }
      $signed[ $key ]['selectors'][] = $entity->get_data( $selector_keys );
    }

    return $signed;
  }

  // Filter entities based on a declaration

  public function filter_entities_by_required_keys( $entities ) {
    return array_filter( $entities, array( $this, 'required_keys_filter' ) );
  }

  protected function required_keys_filter( $item ) {
    return $item->key_intersects( $this->get_required_keys() );
  }

  public function filter_entities_by_condition( $entities, $scope = array() ) {
    $this->filter_conditions = $this->get_conditions();
    if ( ! empty( $this->filter_conditions ) ) {
      $this->condition_keys = $this->get_keys_for('condition');
      $this->current_scope = $scope;
      return array_filter( $entities, array( $this, 'condition_filter_callback' ) );
    }

    return $entities;
  }

  protected function condition_filter_callback( $item ) {

    foreach ($this->filter_conditions as $condition) {

      if ( false === $condition->evaluate( $item, $this->current_scope ) ) {
        return false;
      }

    }

    return true;
  }

}
