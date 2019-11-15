<?php

/**
 * Stores a set of data, allowing checksums and access by keys
 */
class TCO_Coalescence_Entity {

  protected $data;
  protected $keys;
  protected $scope = array();
  protected $checksums = array();
  protected $iteratables = array();

  /**
   * Create this entity assigning its data
   * @param array $data keys/values
   */
  public function __construct( $data ) {
    $this->data = $data;
    $this->keys = array_keys( $data );
  }

  /**
   * Set scope data that will be used for this entity temporarily
   * @param  array  $scope Keys to return
   * @return array        Filtered data
   */
  public function apply_scope( $scope ) {
    $this->scope = $scope;
  }

  public function reset_scope() {
    $this->scope = array();
  }

  /**
   * Get a subset of data by a list of keys
   * @param  array  $keys Keys to return
   * @return array        Filtered data
   */
  public function get_data( $keys = array() ) {
    $data = empty( $this->scope ) ? $this->data : array_merge( $this->data, $this->scope );
    return array_intersect_key( $data, array_flip( $keys ) );
  }

  /**
   * Returns true when this entity's $data represents all keys in $keys
   * @param  array $keys Keys to check the existence for
   * @return boolean
   */
  public function has_keys( $keys = array() ) {
    return count( array_intersect( $this->keys, $keys ) ) === count( $keys );
  }

  public function key_intersects( $keys = array() ) {
    return count( array_intersect( $this->keys, $keys ) ) > 0;
  }

  /**
   * Create a checksum to uniquely identity data from a set of keys
   * @param  array $keys Keys to consider when making the checksum
   * @return int  checksum
   */
  public function checksum( $keys = array() ) {
    $key = implode('_', $keys);
    if ( ! isset( $this->checksums[$key] ) ) {
      $this->checksums[$key] = crc32( serialize( $this->get_data( $keys ) ) );
    }
    return $this->checksums[$key];
  }


  protected function memoize_iterable( $source ) {
    if ( ! isset( $this->iteratables[ $source ] ) ) {
      $data = isset( $this->data[ $source ] ) ? $this->data[ $source ] : array();
      $this->iteratables[ $source ] = explode( ' ', $data );
    }
  }
  public function get_value_at_index( $source, $index ) {
    $this->memoize_iterable( $source );
    return isset( $this->iteratables[ $source ][ $index ] ) ? $this->iteratables[ $source ][ $index ] : null;
  }

  public function get_source_length( $source ) {
    $this->memoize_iterable( $source );
    return count( $this->iteratables[ $source ] );
  }
}
