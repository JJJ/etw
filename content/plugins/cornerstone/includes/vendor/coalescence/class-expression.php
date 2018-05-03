<?php

class TCO_Coalescence_Expression {

  protected $operand_a;
  protected $operand_b;
  protected $operator;

  /**
   * Setter for the expressions properties
   * @param string $key  'a', 'b', or 'op'
   * @param mixed $value
   */
  public function set( $key, $value ) {
    if ( 'a' === $key ) {
      $this->operand_a = $value;
    } elseif ( 'b' === $key ) {
      $this->operand_b = $value;
    } elseif ( 'op' === $key ) {
      $this->operator = $value;
    }
  }

  /**
   * Determine if a property has been set yet
   * @param  string  $key 'a', 'b', or 'op'
   * @return boolean
   */
  public function has( $key ) {
    if ( 'a' === $key ) {
      return isset( $this->operand_a );
    } elseif ( 'b' === $key ) {
      return isset( $this->operand_b );
    } elseif ( 'op' === $key ) {
      return isset( $this->operator );
    }
  }

  /**
   * Take the state of this expression and push it down one level.
   * Effectively the current expressions A leg will be its previous state
   * @return none;
   */
  public function expand() {

    $new = new self;
    $new->set('a', $this->operand_a );
    $new->set('b', $this->operand_b );
    $new->set('op', $this->operator );

    $this->set('a', $new );
    unset($this->operand_b);
    unset($this->operator);
  }

  /**
   * Used by the create function.
   * Parse a set of tokens into a single TCO_Coalescence_Expression object
   * @param  array $tokens      [description]
   * @param  array $expressions Holds expressions that will be expanded later
   * @param  array $constants   Map of references to expand detected constants
   * @return object             TCO_Coalescence_Expression object representing $tokens
   */
  protected static function parse( $tokens, $expressions, $constants ) {

    $active = new TCO_Coalescence_Expression;

    while ( count( $tokens ) > 0 ) {

      $next = array_shift( $tokens );

      //
      // Expression, Constants and Variables fill the active leg
      //

      // Expressions
      if ( 0 === strpos( $next, 'e:' ) ) {
        $exp = substr($next, 2 );

        $value = isset( $expressions[$exp] ) ? self::parse( $expressions[$exp], $expressions, $constants ) : null;

        $active->set( $active->has('op') ? 'b' : 'a', $value );

        continue;

      }

      // Variable
      if ( 0 === strpos( $next, '$' ) ) {
        $active->set( $active->has('op') ? 'b' : 'a', array( 'type' => 'variable', 'value' => substr($next, 1 ) ) );
        continue;
      }

      // Constant
      if ( 0 === strpos( $next, 'c:' ) ) {
        $key = substr($next, 2 );
        $active->set( $active->has('op') ? 'b' : 'a', isset( $constants[ $key ] ) ? $constants[ $key ] : null );
        continue;
      }

      //
      // Operators alternate the active leg
      //

      // Binary operator
      if ( 0 === strpos( $next, 'o:' ) ) {

        // Additional operator...
        if ( $active->has('b' ) ) {
          $active->expand();
        }

        if ( $active->has('a' ) ) {
          $active->set('op', substr($next, 2 ) );
        }

        continue;
      }

      // Logical operators work against the binary evaluation of the previous expression

      if ( 0 === strpos( $next, 'l:' ) ) {

        if ( ! $active->has('a' ) ) {
          continue;
        }

        // When operating on a single value, express that to boolean first
        if ( ! $active->has('b' ) ) {
          $active->set('b', true );
          $active->set('op', 'eq' );
        }

        $active->expand();
        $active->set('op', substr( $next, 2 ) );
        $active->set('b', self::parse( $tokens, $expressions, $constants ) );
        $tokens = array();

      }

    }

    if ( ! $active->has('a') ) {
      $active->set('a', false);
    }

    if ( ! $active->has('op') ) {
      $active->set('op', 'nop');
    }

    if ( ! $active->has('b') ) {
      $active->set('b', null);
    }

    return $active;


    // var_dump($constants);
  }

  /**
   * Take a string, clean it, tokenize it, send through the parse function, and
   * return a working TCO_Coalescence_Expression for the template string.
   * @param  string $content Template string
   * @return object          Final TCO_Coalescence_Expression
   */
  public static function create( $content ) {

    $content = ' ' . $content;

    $constants = array(
      'true'  => true,
      'false' => false,
      'null'  => null
    );

    foreach ( array(

      // Empty operator
      '/(%%\$\w+%%)\?\?/' => ' ( $1 %%o:empty%% null ) ',

      // Existential operator
      '/(%%\$\w+%%)\?/' => ' ( $1 %%o:exists%% null ) ',

    ) as $regex => $replacement ) {
      $content = preg_replace( $regex, $replacement, $content );
    }

    // Tokenize strings and numbers
    foreach ( array(
      '/\s([\d.]?\d)+/' => ' %%c:$1%%',
      '/\'(.*?)\'/' => '%%c:$1%%',
      '/\"(.*?)\"/' => '%%c:$1%%',
    ) as $regex => $replacement ) {

      preg_match_all( $regex, $content, $matches );

      foreach ($matches[0] as $index => $value) {

        $key = crc32( $matches[1][$index] );

        if ( ! isset( $constants[ $key ] ) ) {
          $constants[ $key ] = (string) $matches[1][$index];
        }

        $content = substr_replace($content, str_replace('$1', $key, $replacement), strpos($content, $matches[0][$index] ), strlen($matches[0][$index]) );

      }

    }

    // Expand operators
    $content = strtr( $content, array(
      ' == '  => ' %%o:eq%% ',
      ' != '  => ' %%o:not_eq%% ',
      ' === ' => ' %%o:strict_eq%% ',
      ' !== ' => ' %%o:not_strict_eq%% ',
      ' > '   => ' %%o:gt%% ',
      ' < '   => ' %%o:lt%% ',
      ' >= '  => ' %%o:gte%% ',
      ' <= '  => ' %%o:lte%% ',
      ' LIKE '  => ' %%o:like%% ',
      ' . '  => ' %%o:concat%% ',
      ' || '  => ' %%l:or%% ',
      ' && '  => ' %%l:and%% ',
    ) );

    foreach ( array(

      // Existential operator
      '/(%%\$\w+%%)\?/' => ' ( $1 %%o:exists%% null ) ',

      '/\s(true)/' => ' %%c:true%%',
      '/\s(false)/' => '%%c:false%%',
      '/\s(null)/' => '%%c:null%%',

      // normalize whitespace around operators
      '/\s*%%(.+?)%%\s*/' => ' %%$1%% ',
      '/%%(\s*)%%/' => '%% %%',
      '/\)(\s*)%%/' => ') %%',
      '/%%(\s*)\(/' => '%% (',

      // Clean out bogus symbols
      '/%%\s([^\(\)%]*?)\s%%/' => '%% %%',

    ) as $regex => $replacement ) {
      $content = preg_replace( $regex, $replacement, $content );
    }

    $expressions = array();
    while ( false !== ( $open = strrpos($content, '(' ) ) ) {
      $closed = strpos( $content, ')', $open ) + 1;
      $expressions[] = explode(' ', str_replace('%%', '', trim( substr($content, $open + 1, $closed - $open - 2 ) ) ) );
      $content = substr_replace($content, '%%e:' . ( count($expressions) - 1 ) . '%%', $open, $closed - $open );
    }

    return self::parse( explode(' ', str_replace('%%', '', trim( $content ) )  ), $expressions, $constants );

  }

  /**
   * Used by the evalate function to bring an operand to its final value before
   * running the operation. Recursively calls evaluate on child TCO_Coalescence_Expression
   * objects. Expands any detected variables using $data
   * @param  mixed $operand Content of the operand being processed
   * @param  array $data    Data used for variables
   * @return mixed          Final evaluated content of the operand
   */
  protected function evaluate_operand( $operand, $data ) {

    $evaluated = is_a( $operand, 'TCO_Coalescence_Expression' ) ? $operand->evaluate( $data ) : $operand;

    if ( is_array($evaluated) && isset( $evaluated['type'] ) && 'variable' === $evaluated['type'] ) {

      if ( 'exists' === $this->operator ) {
        return $evaluated['value'];
      }

      $evaluated = isset($data[ $evaluated['value'] ] ) ? $data[ $evaluated['value'] ] : false;

    }

    return $evaluated;
  }

  /**
   * Evaluate the contents of this expression and return the result
   * @param  array $data Data to use for expanding variables
   * @return mixed       Final result
   */
  public function evaluate( $data ) {

    $a = $this->evaluate_operand( $this->operand_a, $data );
    $b = $this->evaluate_operand( $this->operand_b, $data );

    if ( 'exists' === $this->operator ) {
      $key = preg_replace( TCO_Coalescence::$variable_pattern, '$1', $a );
      return isset( $data[ $a ] );
    }

    $method = array( $this, 'op_' . $this->operator );
    $op = is_callable( $method ) ? $method : array( $this, 'nop' );
    return call_user_func_array( $op,  array( $a, $b ) );
  }

  /**
   * Operator methods
   */

  protected function op_eq( $a, $b ) {
    return $a == $b;
  }

  protected function op_not_eq( $a, $b ) {
    return $a != $b;
  }

  protected function op_strict_eq( $a, $b ) {
    return $a === $b;
  }

  protected function op_not_strict_eq( $a, $b ) {
    return $a !== $b;
  }

  protected function op_gt( $a, $b ) {
    return $this->strip_unit( $a ) > $this->strip_unit( $b );
  }

  protected function op_lt( $a, $b ) {
    return $this->strip_unit( $a ) < $this->strip_unit( $b );
  }

  protected function op_gte( $a, $b ) {
    return $this->strip_unit( $a ) >= $this->strip_unit( $b );
  }

  protected function op_lte( $a, $b ) {
    return $this->strip_unit( $a ) <= $this->strip_unit( $b );
  }

  protected function op_or( $a, $b ) {
    return $a || $b;
  }

  protected function op_and( $a, $b ) {
    return $a && $b;
  }

  protected function op_concat( $a, $b ) {
    return $a . $b;
  }

  protected function op_nop( $a, $b ) {
    return $a;
  }

  protected function op_like( $a, $b ) {
    $wild_before = false;
    $wild_after = false;
    if ( 0 === strpos( $b, '%' ) ) {
      $wild_before = true;
      $b = substr($b, 1);
    }
    $end = strlen( $b ) - 1;
    if ( $end === strpos( $b, '%' ) ) {
      $wild_after = true;
      $b = substr($b, 0, $end );
    }

    if ( $wild_before && $wild_after ) {
      return false !== strpos( $a, $b );
    }

    if ( $wild_after ) {
      return 0 === strpos( $a, $b );
    }

    if ( $wild_before ) {
      return strlen($a) - strlen($b) === strpos( $a, $b );
    }

    return $a === $b;

  }

  protected function op_empty( $a, $b ) {

    $a = ( !$a ) ? '' : (string) $a;

    if ( '' === $a ) {
      return true;
    }

    $parts = explode(' ', trim( $a ) );

    foreach ($parts as $i => $part) {
      $parts[$i] = preg_replace('/^0[a-zA-Z%]+|0$|none$/', '', $part);
    }

    $parts = array_filter( $parts );

    return empty($parts);
  }

  public function serialize() {
    return array(
      'a'  => is_a( $this->operand_a, 'TCO_Coalescence_Expression' ) ? $this->operand_a->serialize() : $this->operand_a,
      'b'  => is_a( $this->operand_b, 'TCO_Coalescence_Expression' ) ? $this->operand_b->serialize() : $this->operand_b,
      'op' => $this->operator
    );
  }

  public function unserialize( $data ) {
    $this->operand_a = $this->unserialize_operand( $data['a'] );
    $this->operand_b = $this->unserialize_operand( $data['b'] );
    $this->operator = $data['op'];
  }

  protected function unserialize_operand( $operand ) {
    if ( isset( $operand['a'] ) && isset( $operand['b'] ) ) {
      $expression = new self;
      $expression->unserialize( $operand );
      return $expression;
    }
    return $operand;
  }
}
