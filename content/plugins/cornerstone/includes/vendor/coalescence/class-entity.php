<?php

/**
 * Stores a set of data, allowing checksums and access by keys
 */
class TCO_Coalescence_Entity {

  protected $data;
  protected $keys;
  protected $checksums = array();

  /**
   * Create this entity assigning its data
   * @param array $data keys/values
   */
  public function __construct( $data ) {
    $this->data = $data;
    $this->keys = array_keys( $data );
  }

  /**
   * Get a subset of data by a list of keys
   * @param  array  $keys Keys to return
   * @return array        Filtered data
   */
  public function get_data( $keys = array() ) {
    return array_intersect_key( $this->data, array_flip( $keys ) );
  }

  /**
   * Returns true when this entity's $data represents all keys in $keys
   * @param  array $keys Keys to check the existence for
   * @return boolean
   */
  public function has_keys( $keys = array() ) {
    return count( array_intersect( $this->keys, $keys ) ) === count( $keys );
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
}
