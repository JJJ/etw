<?php

class CS_Accordion extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'accordion',
      'title'       => __( 'Accordion', 'cornerstone' ),
      'section'     => 'content',
      'description' => __( 'Accordion description.', 'cornerstone' ),
      'supports'    => array( 'class', 'style' ),
      'renderChild' => true
    );
  }

  public function controls() {

    $this->addControl(
      'elements',
      'sortable',
      __( 'Accordion Items', 'cornerstone' ),
      __( 'Add a new item to your accordion.', 'cornerstone' ),
      array(
        array( 'title' => __( 'Accordion Item 1', 'cornerstone' ), 'content' => __( 'Add some content to your accordion item here.', 'cornerstone' ), 'open' => true ),
        array( 'title' => __( 'Accordion Item 2', 'cornerstone' ), 'content' => __( 'Add some content to your accordion item here.', 'cornerstone' ) )
      ),
      array(
      	'element' => 'accordion-item',
        'newTitle' => __( 'Accordion Item %s', 'cornerstone' ),
        'floor'    => 1
      )
    );

    $this->addControl(
      'link_items',
      'toggle',
      __( 'Link Items', 'cornerstone' ),
      __( 'This will make opening one item close the others.', 'cornerstone' ),
      false
    );

    $this->addSupport( 'id',
      array( 'options' => array( 'monospace' => true ) )
    );
  }

  public function render( $atts ) {

    extract( $atts );

    $contents = '';

    foreach ( $elements as $e ) {

      $e_params = array(
        'title' => $e['title'],
        'open' => $e['open']
      );

      $contents .= cs_build_shortcode( 'x_accordion_item', $e_params, $this->extra( $e ), $e['content'], true );

    }

    $link = ( 'true' === $link_items ) ? ' link="true" ' : '';

    $shortcode = "[x_accordion{$link}{$extra}]{$contents}[/x_accordion]";

    return $shortcode;

  }

}
