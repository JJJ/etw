<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/TAB.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Group
//   03. Values
// =============================================================================

// Controls
// =============================================================================

function x_controls_tab( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/tab.php' );

  $controls = array(
    array(
      'type'     => 'group',
      'title'    => __( 'Content', '__x__' ),
      'group'    => $is_adv ? $group_tab_setup : $group_std_content,
      'controls' => array(
        array(
          'key'     => 'tab_label_content',
          'type'    => 'text-editor',
          'label'   => __( 'Label', '__x__' ),
          'options' => array(
            'height' => 1,
          ),
        ),
        array(
          'key'     => 'tab_content',
          'type'    => 'text-editor',
          'label'   => __( 'Content', '__x__' ),
          'options' => array(
            'height' => 4,
          ),
        ),
      ),
    ),
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_tab( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/tab.php' );

  $control_groups = array(
    $group           => array( 'title' => __( $group_title, '__x__' ) ),
    $group_tab_setup => array( 'title' => __( 'Setup', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_tab( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/tab.php' );


  // Values
  // ------

  $values = array(
    'tab_label_content' => x_module_value( __( 'Tab', '__x__' ), 'markup:html', true ),
    'tab_content'       => x_module_value( __( 'This is the tab body content. It is typically best to keep this area short and to the point so it isn\'t too overwhelming.', '__x__' ), 'markup:html', true ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
