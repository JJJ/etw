<?php

class TCO_Coalescence_Loop {

  protected $id = null;
  protected $loop_index = 0;
  protected $index_key = '';
  protected $iterated = '';
  protected $source = '';

  /**
   * Create a new loop.
   * @param string $statement Should be '@each' which is the only supported loop at this time
   * @param string $content   Content to parse into loop parameters
   */
  public function __construct( $statement, $content = '') {

    $this->id = uniqid();

    if (!$content) {
      return;
    }
    $var = TCO_Coalescence::$variable_pattern_inner;
    // Matches the iterated, index, and source. The index is options. e.g.
    // @each $iterated, $index in $source
    // @each $iterated in $source

    preg_match( "/^($var)(?:\s*?,\s*?($var))?(?:\s+in\s+)($var)/", $content, $matches );
    $this->iterated = $matches[2];
    $this->index_key = $matches[4];
    $this->source = $matches[6];

  }

  public function get_source() {
    return $this->source;
  }

  /**
   * ID accessor
   * @return int
   */
  public function get_id() {
    return $this->id;
  }

  public function create_scope() {
    $scope = array();
    $scope[$this->iterated] = "loop:{$this->id}";
    if ($this->index_key) {
      $scope[$this->index_key] = "loop:{$this->id}";
    }
    return $scope;
  }

  public function serialize() {
    return array(
      'iterated' => $this->iterated,
      'index'    => $this->index_key,
      'source'   => $this->source,
    );
  }

  public function unserialize( $data ) {
    $this->id = isset( $data['id'] ) ? $data['id'] : '';
    $this->iterated = isset( $data['iterated'] ) ? $data['iterated'] : '';
    $this->index_key = isset( $data['index'] ) ? $data['index'] : '';
    $this->source = isset( $data['source'] ) ? $data['source'] : '';
  }

  // Start a loop and return iterable entities
  public function start( $entities ) {
    $this->loop_index = 0;
    $this->entities = $entities;

    return $this->update_iterable_entities();
  }

  // Return entities that have a valid value
  // given our loop's source and current index
  public function update_iterable_entities() {

    $this->entities = array_filter( $this->entities, array( $this, 'filter_entities_for_index' ) );

    foreach ($this->entities as $entity) {
      $scope = array();

      $count = $entity->get_source_length( $this->source );
      $scope[ $this->iterated ] = $entity->get_value_at_index( $this->source, $this->loop_index );
      $scope[ $this->index_key ] = $count . 'n - ' . ($count - ($this->loop_index + 1));

      $entity->apply_scope( $scope );
    }


    return $this->entities;
  }

  protected function filter_entities_for_index( $entity ) {
    return ! is_null( $entity->get_value_at_index( $this->source, $this->loop_index ) );
  }

  // Increment the loop and return the next set of valid entities
  public function iterate() {
    $this->loop_index++;
    return $this->update_iterable_entities();
  }

}
