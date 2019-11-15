<?php

class Cornerstone_Coalescence extends Cornerstone_Plugin_Component {

  public function setup() {

    require_once( $this->path( 'includes/classes/coalescence/class-coalescence.php' ) );
    require_once( $this->path( 'includes/classes/coalescence/class-loop.php' ) );
    require_once( $this->path( 'includes/classes/coalescence/class-condition.php' ) );
    require_once( $this->path( 'includes/classes/coalescence/class-entity.php' ) );
    require_once( $this->path( 'includes/classes/coalescence/class-expression.php' ) );
    require_once( $this->path( 'includes/classes/coalescence/class-formation.php' ) );
    require_once( $this->path( 'includes/classes/coalescence/class-reducer.php' ) );
    require_once( $this->path( 'includes/classes/coalescence/class-template.php' ) );
    require_once( $this->path( 'includes/classes/coalescence/class-template-node.php' ) );
    require_once( $this->path( 'includes/classes/coalescence/class-template-declaration.php' ) );
    require_once( $this->path( 'includes/classes/coalescence/class-template-directive.php' ) );

  }

  public function start() {
    $coalescence = new TCO_Coalescence( apply_filters('cs_coalescence_selector_prefix', '#cs-content ') );
    return $coalescence;
  }

  public function create_template( $template_string ) {
    $template = new TCO_Coalescence_Template( $template_string );
    return $template;
  }

}
