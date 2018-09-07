<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_ELEMENTS/SEARCH-INLINE.PHP
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

function x_controls_element_search_inline( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  $cond_adv           = array( 'adv' => $adv );

  $search_adv         = x_bar_module_settings_search( 'inline', $cond_adv );
  $search_std_content = x_bar_module_settings_search( 'inline', array( 'group' => $group_std_content ) );
  $search_std_design  = x_bar_module_settings_search( 'inline', array( 'group' => $group_std_design ) );

  if ( $adv ) {

    $controls = array_merge(
      x_controls_search_adv( $search_adv ),
      x_controls_omega()
    );

  } else {

    $controls = array_merge(
      x_controls_search_std_content( $search_std_content ),
      x_controls_search_std_design_setup( $search_std_design ),
      x_controls_search_std_design_colors( $search_std_design ),
      x_controls_omega( $settings_std_customize )
    );

  }

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_element_search_inline( $adv = false ) {

  $search = x_bar_module_settings_search( 'inline' );

  if ( $adv ) {

    $control_groups = array_merge(
      x_control_groups_search( $search ),
      x_control_groups_omega()
    );

  } else {

    $control_groups = x_control_groups_std( array( 'group_title' => __( 'Search Inline', '__x__' ) ) );

  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_element_search_inline( $settings = array() ) {

  $search = x_bar_module_settings_search( 'inline' );

  $values = array_merge(
    x_values_search( $search ),
    x_values_omega()
  );

  return x_bar_mixin_values( $values, $settings );

}
