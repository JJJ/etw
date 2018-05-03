<?php

class TCO_Coalescence_Reducer {

  public $declarations;
  public $data;
  public $index = array();

  public function __construct( $template ) {
    $this->declarations = $template->get_compiled();
  }

  public function process( $items ) {

    $this->items = array_map( array( $this, 'create_entity' ), $items );
    $this->condition_cache = array();
    $list = array();

    // Reduce declarations to a list with signed items
    foreach ($this->declarations as $declaration) {

      $keys = array_merge( array(
        'value' => array(),
        'selector' => array(),
        'condition' => array(),
      ), $declaration->get_keys() );
      $this->required_keys =  array_merge( $keys['value'], $keys['selector'] );
      $this->condition_keys = $keys['condition'];

      $items = array_filter( $this->items, array( $this, 'required_keys_filter' ) );
      $signed_items = array();

      // Filter Conditions
      $this->filter_conditions = $declaration->get_conditions();
      if ( ! empty( $this->filter_conditions ) ) {
        $items = array_filter( $items, array( $this, 'condition_filter' ) );
      }

      // Reduce items to biforcated signed groups
      foreach ($items as $item) {
        $key = $item->checksum( $keys['value'] );
        if ( ! isset( $signed_items[ $key ] ) ) {
          $signed_items[ $key ] = array(
            'data' => $item->get_data( $keys['value'] ),
            'selectors' => array()
          );
        }
        $signed_items[ $key ]['selectors'][] = $item->get_data( $keys['selector'] );
      }

      foreach ($signed_items as $signed) {
        $list[] = array( $declaration, $signed );
      }

    }

    return array_map( array( $this, 'expand_declaration' ), $list );
  }

  protected function expand_declaration( $declaration ) {
    return array(
      'selector'     => $this->fill_selector( $declaration[0]->get_selector(), $declaration[1]['selectors'] ),
      'directive'    => $this->expand_variables( $declaration[0]->get_directive(), $declaration[1]['data'] ),
      'declarations' => $this->expand_variables( $declaration[0]->get_value(), $declaration[1]['data'] )
    );
  }

  protected function required_keys_filter( $item ) {
    return $item->has_keys( $this->required_keys );
  }

  protected function condition_filter( $item ) {

    $condition_sig = $item->checksum( $this->condition_keys );

    foreach ($this->filter_conditions as $condition) {

      $cache_key = $condition_sig . '_' . $condition->get_id();

      if ( ! isset( $this->condition_cache[$cache_key] ) ) {
        $this->condition_cache[$cache_key] = $condition->evaluate( $item );
      }

      if ( false === $this->condition_cache[$cache_key] ) {
        return false;
      }

    }

    return true;
  }

  public function create_entity( $data ) {
    return new TCO_Coalescence_Entity( $data );
  }

  protected function fill_selector( $selector_template, $selector_groups ) {

    $selector_templates = explode( ',', $selector_template );
    $selector_templates = array_map( 'trim', $selector_templates );
    $selectors = array();

    foreach ( $selector_templates as $st ) {
      foreach ( $selector_groups as $group_data ) {
        $selectors[] = $this->expand_variables( $st, $group_data );
      }
    }

    return implode( ', ', $selectors );
  }

  public function expand_variables( $template, $data ) {
    $this->replace_hash = $data;
    return preg_replace_callback( '/%%\$(\w*)%%/', array( $this, 'expander' ), $template );
  }

  public function expander( $matches ) {
    $key = $matches[1];
    return ( isset( $this->replace_hash[ $key ] ) ) ? $this->replace_hash[ $key ] : '';
  }

}
