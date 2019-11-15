<?php

class CS_Author extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'author',
      'title'       => __( 'Author', 'cornerstone' ),
      'section'     => 'social',
      'description' => __( 'Author description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'autofocus' => array(
    		'heading' => '.x-author-box',
    	),
      'protected_keys' => array( 'heading', 'author_id' )
    );
  }

  public function controls() {

    $this->addControl(
      'heading',
      'text',
      __( 'Title', 'cornerstone' ),
      __( 'Enter in a title for your author information.', 'cornerstone' ),
      __( 'About the Author', 'cornerstone' )
    );

    $this->addControl(
      'author_id',
      'text',
      __( 'Author ID', 'cornerstone' ),
      __( 'By default the author of the post or page will be output by leaving this input blank. If you would like to output the information of another author, enter in their user ID here.', 'cornerstone' ),
      ''
    );

  }

  public function render( $atts ) {

    extract( $atts );

    return cs_build_shortcode('x_author', array(
      'title' => $heading,
      'author_id' => $author_id,
    ), $extra );

  }

}
