<?php

class CS_Tabs extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'tabs',
      'title'       => __( 'Tabs', 'cornerstone' ),
      'section'     => 'content',
      'description' => __( 'Tabs description.', 'cornerstone' ),
      'supports'    => array( 'class' ),
      'renderChild' => true
    );
  }

  public function controls() {

    $this->addControl(
      'elements',
      'sortable',
      __( 'Tabs', 'cornerstone' ),
      __( 'Add a new tab.', 'cornerstone' ),
      array(
        array( 'title' => __( 'Tab 1', 'cornerstone' ), 'content' => __( 'The content for your Tab goes here. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pretium, nisi ut volutpat mollis, leo risus interdum arcu, eget facilisis quam felis id mauris. Ut convallis, lacus nec ornare volutpat, velit turpis scelerisque purus, quis mollis velit purus ac massa. Fusce quis urna metus. Donec et lacus et sem lacinia cursus.', 'cornerstone' ), 'active' => true ),
        array( 'title' => __( 'Tab 2', 'cornerstone' ), 'content' => __( 'The content for your Tab goes here. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pretium, nisi ut volutpat mollis, leo risus interdum arcu, eget facilisis quam felis id mauris. Ut convallis, lacus nec ornare volutpat, velit turpis scelerisque purus, quis mollis velit purus ac massa. Fusce quis urna metus. Donec et lacus et sem lacinia cursus.', 'cornerstone' ) )
      ),
      array(
      	'element'  => 'tab',
        'newTitle' => __( 'Tab %s', 'cornerstone' ),
        'floor'    => 2,
        'capacity' => 5
      )
    );

    $this->addControl(
      'nav_position',
      'choose',
      __( 'Navigation Position', 'cornerstone' ),
      __( 'Choose the positioning of your navigation for your tabs.', 'cornerstone' ),
      'top',
      array(
        'columns' => '3',
        'choices' => array(
          array( 'value' => 'top',   'tooltip' => __( 'Top', 'cornerstone' ),   'icon' => fa_entity( 'arrow-up' ) ),
          array( 'value' => 'left',  'tooltip' => __( 'Left', 'cornerstone' ),  'icon' => fa_entity( 'arrow-left' ) ),
          array( 'value' => 'right', 'tooltip' => __( 'Right', 'cornerstone' ), 'icon' => fa_entity( 'arrow-right' ) )
        )
      )
    );

  }

  public function render( $atts ) {

    extract( $atts );

    switch ( count( $elements ) ) {
      case 2 :
        $type = 'two-up';
        break;
      case 3 :
        $type = 'three-up';
        break;
      case 4 :
        $type = 'four-up';
        break;
      case 5 :
        $type = 'five-up';
        break;
      default:
        $type = 'two-up';
        break;
    }


    //
    // Tabs nav items.
    //

    $tabs_nav_content = '';

    foreach ( $elements as $e ) {

      $tabs_nav_extra = $this->extra( array(
        'class' => $e['class']
      ) );

      $tabs_nav_content .= '[x_tab_nav_item title="' . $e['title'] . '" active="' . $e['active'] . '"' . $tabs_nav_extra . ']';

    }


    //
    // Tabs.
    //

    $tabs_content = '';

    foreach ( $elements as $e ) {

      $e_params = array(
        'active' => $e['active']
      );

      $tabs_content .= cs_build_shortcode( 'x_tab', $e_params, $this->extra( $e ), $e['content'], true );

    }


    //
    // Pieces.
    //

    $tabs_nav  = '[x_tab_nav type="' . $type . '" float="' .  $nav_position . '"' . $extra . ']' . $tabs_nav_content . '[/x_tab_nav]';
    $tabs      = '[x_tabs' . $extra . ']' . $tabs_content . '[/x_tabs]';
    $shortcode = $tabs_nav . $tabs;

    return $shortcode;

  }

}
