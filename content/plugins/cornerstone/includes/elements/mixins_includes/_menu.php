<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_MENU.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls: Advanced
//   02. Controls: Standard (Content)
//   03. Controls: Standard (Design - Setup)
//   04. Control Groups
//   05. Values
// =============================================================================

// Controls: Advanced
// =============================================================================

function x_controls_menu_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_menu.php' );

  $controls = array_merge(
    $control_group_menu_adv_setup,
    $control_group_menu_adv_active_links_setup
  );

  if ( $type !== 'dropdown' ) {
    $controls = array_merge(
      $controls,
      x_control_margin( $settings_menu_margin )
    );
  }

  if ( $type === 'inline' ) {
    $controls = array_merge(
      $controls,
      x_control_flex( $settings_menu_self_flex ),
      x_control_flex_layout_css( $settings_menu_flex_css_row ),
      x_control_flex_layout_css( $settings_menu_flex_css_col ),
      x_control_flex( $settings_menu_items_flex )
    );
  }

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_menu_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_menu.php' );

  $controls = $control_group_menu_std_content_setup;

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_menu_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_menu.php' );

  $controls = array();

  if ( $type !== 'dropdown' ) {
    $controls = array_merge(
      $controls,
      x_control_margin( $settings_menu_margin )
    );
  }

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_menu( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_menu.php' );

  $control_groups = array(
    $group            => array( 'title' => $group_title ),
    $group_menu_setup => array( 'title' => __( 'Setup', '__x__' ) ),
  );

  if ( $type !== 'dropdown' ) {
    $control_groups[$group_menu_design] = array( 'title' => __( 'Design', '__x__' ) );
  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_menu( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_menu.php' );


  // Values
  // ------
  // 01. Will not change per module. Meant to be used to conditionally load
  //     output for templates and associated styles.

  $values = array(
    'menu_type'                                 => x_module_value( $type, 'all' ), // 01
    'menu'                                      => x_module_value( 'sample:default', 'all', true ),
    'menu_active_links_highlight_current'       => x_module_value( true, 'all' ),
    'menu_active_links_highlight_ancestors'     => x_module_value( true, 'all' ),
    'menu_active_links_show_graphic'            => x_module_value( false, 'all' ),
    'menu_active_links_show_primary_particle'   => x_module_value( false, 'all' ),
    'menu_active_links_show_secondary_particle' => x_module_value( false, 'all' ),
  );

  if ( $type === 'collapsed' || $type === 'modal' || $type === 'layered' ) {
    $values = array_merge(
      $values,
      array(
        'menu_sub_menu_trigger_location' => x_module_value( 'anchor', 'attr' ),
      )
    );
  }

  if ( $type === 'modal' || $type === 'layered' ) {
    $values = array_merge(
      $values,
      array(
        'menu_layered_back_label' => x_module_value( __( '← Back', '__x__' ), 'markup:html' ),
      )
    );
  }

  if ( $type !== 'dropdown' ) {
    $values = array_merge(
      $values,
      array(
        'menu_base_font_size' => x_module_value( '1em', 'style' ),
        'menu_margin'         => x_module_value( '0px', 'style' ),
      )
    );
  }

  if ( $type === 'inline' ) {
    $values = array_merge(
      $values,
      array(
        'menu_align_self'         => x_module_value( 'stretch', 'style' ),
        'menu_flex'               => x_module_value( '0 0 auto', 'style' ),
        'menu_row_flex_direction' => x_module_value( 'row', 'style' ),
        'menu_row_flex_wrap'      => x_module_value( false, 'style' ),
        'menu_row_flex_justify'   => x_module_value( 'space-around', 'style' ),
        'menu_row_flex_align'     => x_module_value( 'stretch', 'style' ),
        'menu_col_flex_direction' => x_module_value( 'column', 'style' ),
        'menu_col_flex_wrap'      => x_module_value( false, 'style' ),
        'menu_col_flex_justify'   => x_module_value( 'space-around', 'style' ),
        'menu_col_flex_align'     => x_module_value( 'stretch', 'style' ),
        'menu_items_flex'         => x_module_value( '0 1 auto', 'style' ),
      )
    );
  }


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
