<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_CONTENT-AREA.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Groups
//   03. Values
// =============================================================================

// Controls
// =============================================================================

function x_controls_content_area( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_content-area.php' );

  $controls = $control_group_content_area_content;

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_content_area( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_content-area.php' );

  $control_groups = array(
    $group                    => array( 'title' => $group_title           ),
    $group_content_area_setup => array( 'title' => __( 'Setup', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_content_area( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_content-area.php' );


  // Values
  // ------

  if ( $type === 'standard' ) {
    $values[$k_pre . 'content'] = x_module_value( __( '<span>This content will show up directly in its container.</span>', '__x__' ), 'markup:html', true );
  } else {
    $values[$k_pre . 'content'] = x_module_value( __( '<div style="padding: 25px; line-height: 1.4; text-align: center;">Add any HTML or custom content here.</div>', '__x__' ), 'markup:html', true );
  }


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
