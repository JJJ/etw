<?php

class TCO_Coalescence_Reducer {

  public $declarations;
  public $selector_prefix = '';

  public function __construct( $template, $selector_prefix ) {
    $this->declarations = $template->get_compiled();
    $this->selector_prefix = $selector_prefix;
  }

  public function process( $items ) {

    $all_entities = array_map( array( $this, 'create_entity' ), $items );

    $results = array();
    // Reduce declarations to a list with signed items
    foreach ($this->declarations as $declaration) {

      $list = array();

      // Filter down to entities that are related to this declaration
      $entities = $declaration->filter_entities_by_required_keys( $all_entities );

      $loops = $declaration->get_loops();

      if ( empty ( $loops ) ) {
        $list = $declaration->reduce_entities( $entities );
      } else {
        foreach ( $loops as $loop ) {
          $list = array_merge( $list, $this->reduce_loop( $loop, $declaration, $entities ) );
        }
      }

      // Build a list of unique declarations
      foreach ($list as $signed) {
        $results[] = array(
          'selector'     => $this->fill_selector( $declaration->get_selector(), $signed['selectors'] ),
          'directive'    => $this->expand_variables( $declaration->get_directive(), $signed['props'] ),
          'declarations' => $this->expand_variables( $declaration->get_value(), $signed['props'] )
        );
      }
    }

    return $results;
  }

  protected function reduce_loop( $loop, $declaration, $entities ) {
    $list = array();

    $iterable_entities = $loop->start( $entities );

    while ( count( $iterable_entities ) > 0 ) {
      $loop_results = $declaration->reduce_entities( $iterable_entities );
      $list = array_merge( $list, $loop_results );
      $iterable_entities = $loop->iterate();
    }

    return $list;
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
        $selectors[] = $this->selector_prefix . $this->expand_variables( $st, $group_data );
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
