<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_ELEMENTS/SEARCH-DROPDOWN.PHP
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

function x_controls_element_search_dropdown( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  $cond_adv           = array( 'adv' => $adv );
  $dropdown_theme     = array( 'theme' => array( 'dropdown_width' => x_module_value( '300px', 'style' ) ) );
  $search_args        = array( 't_pre' => __( 'Search', '__x__' ), 'theme' => x_module_theme_dropdown_search_default() );

  $toggle_adv         = x_bar_module_settings_anchor( 'toggle', $cond_adv );
  $dropdown_adv       = array_merge( $dropdown_theme, $cond_adv );
  $search_adv         = x_bar_module_settings_search( 'dropdown', array_merge( $search_args, $cond_adv ) );

  $toggle_std_content = x_bar_module_settings_anchor( 'toggle', array( 'inc_t_pre' => true, 'group' => $group_std_content ) );
  $toggle_std_design  = x_bar_module_settings_anchor( 'toggle', array( 'inc_t_pre' => true, 'group' => $group_std_design ) );
  $dropdown_std       = $dropdown_theme;
  $search_std_content = x_bar_module_settings_search( 'dropdown', array( 'inc_t_pre' => true, 'group' => $group_std_content ) );
  $search_std_design  = x_bar_module_settings_search( 'dropdown', array( 'inc_t_pre' => true, 'group' => $group_std_design ) );

  if ( $adv ) {

    $controls = array_merge(
      x_controls_anchor_adv( $toggle_adv ),
      x_controls_dropdown_adv( $dropdown_adv ),
      x_controls_search_adv( $search_adv ),
      x_controls_omega()
    );

  } else {

    $controls = array_merge(

      x_controls_anchor_std_content( $toggle_std_content ),
      x_controls_search_std_content( $search_std_content ),

      x_controls_anchor_std_design_setup( $toggle_std_design ),
      x_controls_dropdown_std_design_setup( $dropdown_std ),
      x_controls_search_std_design_setup( $search_std_design ),

      x_controls_anchor_std_design_colors( $toggle_std_design ),
      x_controls_dropdown_std_design_colors( $dropdown_std ),
      x_controls_search_std_design_colors( $search_std_design ),

      x_controls_omega( $settings_std_customize )

    );

  }

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_element_search_dropdown( $adv = false ) {

  $toggle   = x_bar_module_settings_anchor( 'toggle' );
  $dropdown = array( 'theme' => array( 'dropdown_width' => x_module_value( '300px', 'style' ) ) );
  $search   = x_bar_module_settings_search( 'dropdown', array( 't_pre' => __( 'Search', '__x__' ), 'theme' => x_module_theme_dropdown_search_default() ) );

  if ( $adv ) {

    $control_groups = array_merge(
      x_control_groups_anchor( $toggle ),
      x_control_groups_dropdown( $dropdown ),
      x_control_groups_search( $search ),
      x_control_groups_omega()
    );

  } else {

    $control_groups = x_control_groups_std( array( 'group_title' => __( 'Search Dropdown', '__x__' ) ) );

  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_element_search_dropdown( $settings = array() ) {

  $toggle   = x_bar_module_settings_anchor( 'toggle' );
  $dropdown = array( 'theme' => array( 'dropdown_width' => x_module_value( '300px', 'style' ) ) );
  $search   = x_bar_module_settings_search( 'dropdown', array( 't_pre' => __( 'Search', '__x__' ), 'theme' => x_module_theme_dropdown_search_default() ) );

  $values = array_merge(
    x_values_anchor( $toggle ),
    x_values_dropdown( $dropdown ),
    x_values_search( $search ),
    x_values_omega()
  );

  return x_bar_mixin_values( $values, $settings );

}
