<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/ACCORDION-ITEM.PHP
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

function x_controls_accordion_item( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/accordion-item.php' );

  $controls = array(
    array(
      'type'     => 'group',
      'title'    => __( 'Content', '__x__' ),
      'group'    => $is_adv ? $group_accordion_item_setup : $group_std_content,
      'controls' => array(
        array(
          'key'     => 'accordion_item_starts_open',
          'type'    => 'choose',
          'label'   => __( 'Starts Open', '__x__' ),
          'options' => $options_choices_off_on_bool,
        ),
        array(
          'key'     => 'accordion_item_header_content',
          'type'    => 'text-editor',
          'label'   => __( 'Header', '__x__' ),
          'options' => array(
            'height' => 1,
          ),
        ),
        array(
          'key'     => 'accordion_item_content',
          'type'    => 'text-editor',
          'label'   => __( 'Content', '__x__' ),
          'options' => array(
            'height' => 3,
          ),
        ),
      ),
    ),
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_accordion_item( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/accordion-item.php' );

  $control_groups = array(
    $group                      => array( 'title' => $group_title ),
    $group_accordion_item_setup => array( 'title' => __( 'Setup', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_accordion_item( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/accordion-item.php' );


  // Values
  // ------

  $values = array(
    'accordion_item_starts_open'    => x_module_value( false, 'markup' ),
    'accordion_item_header_content' => x_module_value( __( 'Accordion Item', '__x__' ), 'markup:html', true ),
    'accordion_item_content'        => x_module_value( __( 'This is the accordion body content. It is typically best to keep this area short and to the point so it isn\'t too overwhelming.', '__x__' ), 'markup:html', true ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
