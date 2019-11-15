<?php

class Cornerstone_App_Choices extends Cornerstone_Plugin_Component {

  public function setup() {
    add_filter('cornerstone_app_choices_menus', array( $this, '_menus' ) );
    add_filter('cornerstone_app_choices_sidebars', array( $this, '_sidebars' ) );
  }

  public function __call( $name, $args ) {
    return apply_filters("cornerstone_app_choices_$name", array() );
  }

  public function _menus() {

    $locations = get_registered_nav_menus();
    $menus = get_terms('nav_menu');
    $choices = array();

    foreach ( $menus as $menu ) {
      $choices[] = array(
        'value' => 'menu:' . $menu->term_id,
        'label' => sprintf( csi18n('app.choices.menu-named'), $menu->name )
      );
    }

    foreach ( $locations as $location => $label ) {
      $choices[] = array(
        'value' => 'location:' . $location,
        'label' => sprintf( csi18n('app.choices.menu-location'), $label )
      );
    }

    $samples = array(
      array(
        'value' => 'sample:default',
        'label' => csi18n('app.choices.menu-sample-default'),
      ),
      array(
        'value' => 'sample:default_no_dropdowns',
        'label' => csi18n('app.choices.menu-sample-no-dropdowns')
      ),
      array(
        'value' => 'sample:default_split_1',
        'label' => csi18n('app.choices.menu-sample-split-1')
      ),
      array(
        'value' => 'sample:default_split_2',
        'label' => csi18n('app.choices.menu-sample-split-2')
      ),
    );

    return apply_filters('cornerstone_menu_choices', array_merge( $choices, $samples ) );
  }

  public function _sidebars() {

    global $wp_registered_sidebars;

    $choices = array();

    foreach ($wp_registered_sidebars as $sidebar) {
      $choices[] = array(
        'label' => $sidebar['name'],
        'value' => $sidebar['id'],
      );
    }

    return $choices;
  }


}
