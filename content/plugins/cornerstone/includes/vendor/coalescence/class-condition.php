<?php

class TCO_Coalescence_Condition {

  protected $id = null;
  protected $negate = false;
  protected $content = '';
  protected $keys = array();
  protected $parsed = '';
  protected $expression;

  /**
   * Create a new condition.
   * @param string $statement Should be '@if' or '@unless'. Used to determine if evaluated should be inverted
   * @param string $content   Content to parse into an expression
   */
  public function __construct( $statement, $content = '') {

    if ( is_null( $statement ) ) {
      return;
    }
    // var_dump($statement);die();
    $this->content = $content;
    $this->negate = '@unless' === $statement;
    $this->id = uniqid();

    preg_match_all( TCO_Coalescence::$variable_pattern, $this->content, $matches );
    $this->keys = array_unique($matches[1]);
    $this->expression = TCO_Coalescence_Expression::create( $this->content);


  }

  /**
   * Evaluate this conditions set of expressions using data from $item
   * @param  array $item  Data to used to populate expression variables
   * @return boolean      Condition pass/fail
   */
  public function evaluate( $item ) {
    $truthy = (bool) $this->expression->evaluate( $item->get_data( $this->keys ) );
    return $this->negate ? ! $truthy : $truthy;
  }

  /**
   * Access the conditions raw template string
   * @return string
   */
  public function get_raw() {
    return $this->content;
  }

  /**
   * ID accessor
   * @return int
   */
  public function get_id() {
    return $this->id;
  }

  public function serialize() {
    return array(
      'negate' => $this->negate,
      'keys'   => $this->keys,
      'expression' => $this->expression->serialize()
    );
  }

  public function unserialize( $data ) {
    $this->negate = $data['negate'];
    //var_dump($data);
    $this->keys = $data['keys'];
    $this->expression = new TCO_Coalescence_Expression;
    $this->expression->unserialize( $data['expression'] );
  }
}
