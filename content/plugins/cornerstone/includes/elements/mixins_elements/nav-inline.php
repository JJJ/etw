<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_ELEMENTS/NAV-INLINE.PHP
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

function x_controls_element_nav_inline( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  $cond_adv              = array( 'adv' => $adv );

  $menu_adv              = x_bar_module_settings_menu( 'inline', $cond_adv );
  $links_top_adv         = x_bar_module_settings_anchor( 'menu-item-inline-top', $cond_adv );
  $links_sub_adv         = x_bar_module_settings_anchor( 'menu-item-inline-sub', $cond_adv );

  $menu_std              = x_bar_module_settings_menu( 'inline' );
  $links_top_std_content = x_bar_module_settings_anchor( 'menu-item-inline-top', array( 'inc_t_pre' => true, 'group' => $group_std_content ) );
  $links_sub_std_content = x_bar_module_settings_anchor( 'menu-item-inline-sub', array( 'inc_t_pre' => true, 'group' => $group_std_content ) );
  $links_top_std_design  = x_bar_module_settings_anchor( 'menu-item-inline-top', array( 'inc_t_pre' => true, 'group' => $group_std_design ) );
  $links_sub_std_design  = x_bar_module_settings_anchor( 'menu-item-inline-sub', array( 'inc_t_pre' => true, 'group' => $group_std_design ) );

  if ( $adv ) {

    $controls = array_merge(
      x_controls_menu_adv( $menu_adv ),
      x_controls_anchor_adv( $links_top_adv ),
      x_controls_dropdown_adv( $cond_adv ),
      x_controls_anchor_adv( $links_sub_adv ),
      x_controls_omega()
    );

  } else {

    $controls = array_merge(

      x_controls_menu_std_content( $menu_std ),
      x_controls_anchor_std_content( $links_top_std_content ),
      x_controls_anchor_std_content( $links_sub_std_content ),

      x_controls_menu_std_design_setup( $menu_std ),
      x_controls_anchor_std_design_setup( $links_top_std_design ),
      x_controls_dropdown_std_design_setup(),
      x_controls_anchor_std_design_setup( $links_sub_std_design ),

      x_controls_anchor_std_design_colors( $links_top_std_design ),
      x_controls_dropdown_std_design_colors(),
      x_controls_anchor_std_design_colors( $links_sub_std_design ),

      x_controls_omega( $settings_std_customize )

    );

  }

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_element_nav_inline( $adv = false ) {

  $menu      = x_bar_module_settings_menu( 'inline' );
  $links_top = x_bar_module_settings_anchor( 'menu-item-inline-top' );
  $links_sub = x_bar_module_settings_anchor( 'menu-item-inline-sub' );

  if ( $adv ) {

    $control_groups = array_merge(
      x_control_groups_menu( $menu ),
      x_control_groups_anchor( $links_top ),
      x_control_groups_dropdown(),
      x_control_groups_anchor( $links_sub ),
      x_control_groups_omega()
    );

  } else {

    $control_groups = x_control_groups_std( array( 'group_title' => __( 'Navigation Inline', '__x__' ) ) );

  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_element_nav_inline( $settings = array() ) {

  $menu      = x_bar_module_settings_menu( 'inline' );
  $links_top = x_bar_module_settings_anchor( 'menu-item-inline-top' );
  $links_sub = x_bar_module_settings_anchor( 'menu-item-inline-sub' );

  $values = array_merge(
    x_values_menu( $menu ),
    x_values_anchor( $links_top ),
    x_values_dropdown(),
    x_values_anchor( $links_sub ),
    x_values_omega()
  );

  return x_bar_mixin_values( $values, $settings );

}
