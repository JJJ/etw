<?php

/**
 * Directives are parent nodes that hold other directives, or declarations.
 * They represent the template structure until reduced into a single
 * declaration list
 */
class TCO_Coalescence_Template_Directive extends TCO_Coalescence_Template_Node {

  protected $operation = array();
  protected $nodes = array();

  /**
   * On setup, detect the type of operation we will be passing down to the declaration child nodes
   * @return none
   */
  protected function setup() {
    $this->operation = $this->detect_operation();
  }

  /**
   * Based on this directives content, predetermine the operation we will run
   * on child nodes
   * @return none
   */
  protected function detect_operation() {

    // Conditions
    if ( preg_match( '/(@if|@unless) (.*)/', $this->value, $match ) ) {
      return array(
        'method' => 'add_condition',
        'args' => array( new TCO_Coalescence_Condition( $match[1], $match[2] ) )
      );
    }

    // Directives (only supports media queries)
    if ( preg_match( '/@media/', $this->value ) ) {
      return array(
        'method' => 'set_directive',
        'args' => array( $this->value )
      );
    }

    // Selectors
    if ( is_string( $this->value ) ) {
      return array(
        'method' => 'update_selector',
        'args' => array( $this->value )
      );
    }

  }

  /**
   * Add a new node (could be generic or a declaration) to this node's children
   * @param object $node child node to add
   * @return object Pass the node back so it can be referenced again if needed by the invoker
   */
  public function add( $node ) {
    $this->nodes[] = $node;
    $node->set_parent( $this );
    return $node;
  }

  /**
   * Iterate over children nodes, recursively reducing them until all that's
   * left is a single list of TCO_Coalescence_Template_Declaration instances
   * @return array final list of declarations
   */
  public function reduce() {

    $nodes = array();

    foreach ( $this->nodes as $node ) {
      if ( ! is_a( $node, 'TCO_Coalescence_Template_Declaration' ) ) {
        $nodes = array_merge( $nodes, $node->reduce() );
        continue;
      }

      $nodes[] = $node;
    }

    // At this point, all childresn are Declarations.
    // We can apply this directive's operation to each, allowing the current node to dissipate
    array_walk( $nodes, array( $this, 'transform' ) );

    unset( $this->nodes );

    return $nodes;

  }

  /**
   * Apply this directives operation to a child node. Used by reduce
   * @param  object $node Node to be processed
   * @return $node Node after transformation
   */
  protected function transform( $node ) {
    $method = array( $node, $this->operation['method'] );
    if ( is_callable( $method ) ) {
      call_user_func_array( $method, $this->operation['args'] );
    }
    $node->set_parent(null);
    return $node;
  }

}
