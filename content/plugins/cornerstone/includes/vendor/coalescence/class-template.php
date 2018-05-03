<?php

/**
 * Takes a string and parses it into a list of declarations that can later
 * be used to write CSS for any number of items.
 */
class TCO_Coalescence_Template {

  public $template;
  public $declarations;
  public $offset = 0;

  /**
   * Instantiate a new Template, optionally providing the template string
   * @param string $template String to parse into this template's declarations
   */
  public function __construct( $template = null ) {
    $this->set_template( is_string( $template ) ? $template : '' );
  }

  /**
   * Set this templates contents, then clean and parse into declarations.
   * @param string $template String to parse into this template's declarations
   */
  public function set_template( $template ) {
    $this->declarations = array();
    $this->template = $template;
    if ( $this->template ) {
      $this->clean();
      $this->parse();
    }
  }

  /**
   * Clean the incoming template string into something more predictable
   * @return none
   */
  public function clean() {

    foreach ( array(

      // Strip comments
      '#/\*.*?\*/#s' => '',

      // Preserve variables by converting $var or ${var} into %%$var%%
      '/\$(\w+)/'   => '%%$$1%%',
      '/\${(\w+)}/' => '%%$$1%%',

      // Remove whitespace
      '/\s*([{}:;,])\s+/' => '$1',
      '/\s\s+(.*)/' => '$1'

    ) as $regex => $replacement ) {
      $this->template = preg_replace( $regex, $replacement, $this->template );
    }

  }

  /**
   * Consume the template, creating nodes for every declaration
   * @return none
   */
  public function parse() {

    // Start with a generic root node
    $active_node = new TCO_Coalescence_Template_Directive;

    $parsed = false;

    while ( ! $parsed ) {

      // Match declarations: property:$value;
      // Add Declaration nodes to the active node (which should be a selector at this point)
      if ( $this->consume( '/^([^{}]+?(?:\${\w+})*[^{}]*?);/' ) ) {
        $active_node->add( new TCO_Coalescence_Template_Declaration( $this->match ) );
        continue;
      }

      // Open: [selector/condition/directive] {
      // Consume what comes before an opening bracket, creating a generic node for a selector, condition, or directive.
      // This new node is set as active so future consumptions are stored inside it.
      if ( $this->consume( '/^([^;{}]+?(?:\${\w+}.+?)*?){/' ) ) {
        $active_node = $active_node->add( new TCO_Coalescence_Template_Directive( $this->match ) );
        continue;
      }

      // Close  }
      // When the closing bracket is reached, return to working with the parent node.
      if ( $this->consume( '/^.*?(})/' ) ) {
        $active_node = $active_node->get_parent();
        continue;
      }

      // No more nodes to add. Exit the parse loop
      $parsed = true;

    }

    // Flatten our node tree into a list of declarations
    // Non declaration nodes will be added to declarations as selectors, conditions, or media queries.
    $this->declarations = $active_node->reduce();

    // Reset the consume offset when complete
    $this->offset = 0;
  }

  /**
   * From the current offset, look for a match.
   * Return false if a match is not found, allowing the parse loop to check for something else
   * If a match is found
   *   Store the first capture group in $this->match
   *   Advance the offset pointer by the length of the full match
   *   Return true, letting the parse loop know it should proceed with the contents of $this->match
   *
   * @param  string $regex Regex to match
   * @return bool   Whether or not a match was found
   */
  public function consume( $regex ) {
    $offset = preg_match( $regex, substr( $this->template, $this->offset ), $matches );
    if ( empty( $matches ) ) {
      return false;
    }
    $this->offset += strlen( $matches[0] );
    $this->match = $matches[1];
    return true;
  }

  /**
   * Accessor to get this nodes list of declarations
   * @return array This should be a list of TCO_Coalescence_Template_Declaration instances
   */
  public function get_compiled() {
    return $this->declarations;
  }

  public function serialize() {

    $declarations = array();

    foreach ($this->declarations as $declaration) {
      $declarations[] = $declaration->serialize();
    }

    return json_encode( $declarations );

  }

  public function unserialize( $json ) {

    $decoded = json_decode($json, true);

    if ( ! is_array( $decoded ) ) {
      return;
    }

    foreach ($decoded as $declaration) {
      $node = new TCO_Coalescence_Template_Declaration( null );
      $node->unserialize( $declaration );
      $this->declarations[] = $node;
    }

  }

}
