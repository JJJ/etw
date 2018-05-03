<?php

class CS_Widget_Area extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'widget-area',
      'title'       => __( 'Widget Area', 'cornerstone' ),
      'section'     => 'content',
      'description' => __( 'Widget Area description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'empty'       => array( 'sidebar' => 'none' ),
      'protected_keys' => array( 'sidebar' )
    );
  }

  public function controls() {

    global $wp_registered_sidebars;

    $choices = array();
    $choices[] = array( 'value' => 'none', 'label' => __( 'None', 'cornerstone' ) );

    $sidebar_widgets = wp_get_sidebars_widgets();
    if ( is_array( $wp_registered_sidebars ) ) {

	    foreach ($wp_registered_sidebars as $id => $value) {

	      $choice = array( 'value' => $id, 'label' => $value['name'] );

	      $widgets = ( isset($sidebar_widgets[$id])) ? count( $sidebar_widgets[$id] ) : 0;

	      if ( $widgets < 1 ) {
	        $format = (is_rtl()) ? ' %s ' . $choice['label'] : $choice['label'] . ' %s ';
	        $choice['label'] = sprintf( $format, __('(No widgets specified.)', 'cornerstone' ) );
	        $choice['disabled'] = true;
	      }

	      $choices[] = $choice;
	    }

	  }

    $this->addControl(
      'sidebar',
      'select',
      __( 'Registered Sidebar', 'cornerstone' ),
      __( 'Sidebars with no widgets will appear disabled.', 'cornerstone' ),
      'none',
      array(
        'choices' => $choices
      )
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $shortcode = "[x_widget_area sidebar=\"{$sidebar}\" {$extra}]";

    return $shortcode;

  }

}
