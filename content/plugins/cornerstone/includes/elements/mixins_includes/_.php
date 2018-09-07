<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Control Groups Standard
// =============================================================================

// Control Groups Standard
// =============================================================================

function x_control_groups_std( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Simple', '__x__' );

  $control_groups = array(
    $group_std           => array( 'title' => $group_title               ),
    $group_std_content   => array( 'title' => __( 'Content', '__x__' )   ),
    $group_std_design    => array( 'title' => __( 'Design', '__x__' )    ),
    $group_std_customize => array( 'title' => __( 'Customize', '__x__' ) ),
  );

  if ( isset( $settings['no_content'] ) ) {
    unset( $control_groups[$group_std_content] );
  }

  if ( isset( $settings['no_design'] ) ) {
    unset( $control_groups[$group_std_design] );
  }

  if ( isset( $settings['no_customize'] ) ) {
    unset( $control_groups[$group_std_customize] );
  }

  return $control_groups;

}