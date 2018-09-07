<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/TABS.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls: Advanced
//   02. Controls: Standard (Content)
//   03. Controls: Standard (Design - Setup)
//   04. Controls: Standard (Design - Colors)
//   05. Control Group
//   06. Values
// =============================================================================

// Controls: Advanced
// =============================================================================

function x_controls_tabs_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/tabs.php' );

  $controls = array_merge(

    array( $control_tabs_sortable ),

    $control_group_tabs_adv_setup,
    x_control_margin( $settings_tabs ),
    x_control_padding( $settings_tabs ),
    x_control_border( $settings_tabs ),
    x_control_border_radius( $settings_tabs ),
    x_control_box_shadow( $settings_tabs ),

    $control_group_tabs_adv_setup_tablist,
    x_control_margin( $settings_tabs_tablist ),
    x_control_padding( $settings_tabs_tablist ),
    x_control_border( $settings_tabs_tablist ),
    x_control_border_radius( $settings_tabs_tablist ),
    x_control_box_shadow( $settings_tabs_tablist ),

    $control_group_tabs_adv_setup_tabs,
    x_control_margin( $settings_tabs_tabs_design ),
    x_control_padding( $settings_tabs_tabs_design ),
    x_control_border( $settings_tabs_tabs_design ),
    x_control_border_radius( $settings_tabs_tabs_design ),
    x_control_box_shadow( $settings_tabs_tabs_design ),
    x_control_text_format( $settings_tabs_tabs_text ),
    x_control_text_style( $settings_tabs_tabs_text ),
    x_control_text_shadow( $settings_tabs_tabs_text ),

    $control_group_tabs_adv_setup_panels,
    x_control_margin( $settings_tabs_panels_design ),
    x_control_padding( $settings_tabs_panels_design ),
    x_control_border( $settings_tabs_panels_design ),
    x_control_border_radius( $settings_tabs_panels_design ),
    x_control_box_shadow( $settings_tabs_panels_design ),
    x_control_text_format( $settings_tabs_panels_text ),
    x_control_text_style( $settings_tabs_panels_text ),
    x_control_text_shadow( $settings_tabs_panels_text )

  );

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_tabs_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/tabs.php' );

  $controls = array( $control_tabs_sortable );

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_tabs_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/tabs.php' );

  $controls = array_merge(
    $control_group_tabs_std_design_setup,
    x_control_margin( $settings_tabs_std_design ),
    $control_group_tabs_std_design_setup_tabs
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_tabs_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/tabs.php' );

  $controls = $control_group_tabs_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_tabs( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/tabs.php' );

  $control_groups = array(

    $group                     => array( 'title' => $group_title ),
    $group_tabs_setup          => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_tabs_design         => array( 'title' => __( 'Design', '__x__' ) ),

    $group_tabs_tablist        => array( 'title' => __( 'Tab List', '__x__' ) ),
    $group_tabs_tablist_setup  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_tabs_tablist_design => array( 'title' => __( 'Design', '__x__' ) ),

    $group_tabs_tabs           => array( 'title' => __( 'Individual Tabs', '__x__' ) ),
    $group_tabs_tabs_setup     => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_tabs_tabs_design    => array( 'title' => __( 'Design', '__x__' ) ),
    $group_tabs_tabs_text      => array( 'title' => __( 'Text', '__x__' ) ),

    $group_tabs_panels         => array( 'title' => __( 'Panels', '__x__' ) ),
    $group_tabs_panels_setup   => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_tabs_panels_design  => array( 'title' => __( 'Design', '__x__' ) ),
    $group_tabs_panels_text    => array( 'title' => __( 'Text', '__x__' ) ),

  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_tabs( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/tabs.php' );


  // Values
  // ------

  $values = array(

    'tabs_base_font_size'                => x_module_value( '1em', 'style' ),
    'tabs_width'                         => x_module_value( '100%', 'style' ),
    'tabs_max_width'                     => x_module_value( 'none', 'style' ),
    'tabs_bg_color'                      => x_module_value( 'transparent', 'style:color' ),
    'tabs_margin'                        => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_padding'                       => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_border_width'                  => x_module_value( '0px', 'style' ),
    'tabs_border_style'                  => x_module_value( 'none', 'style' ),
    'tabs_border_color'                  => x_module_value( 'transparent', 'style:color' ),
    'tabs_border_radius'                 => x_module_value( '0px 0px 0px 0px', 'style' ),
    'tabs_box_shadow_dimensions'         => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_box_shadow_color'              => x_module_value( 'transparent', 'style:color' ),

    'tabs_tablist_bg_color'              => x_module_value( 'transparent', 'style:color' ),
    'tabs_tablist_margin'                => x_module_value( '0px 0px -1px 0px', 'style' ),
    'tabs_tablist_padding'               => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_tablist_border_width'          => x_module_value( '0px', 'style' ),
    'tabs_tablist_border_style'          => x_module_value( 'none', 'style' ),
    'tabs_tablist_border_color'          => x_module_value( 'transparent', 'style:color' ),
    'tabs_tablist_border_radius'         => x_module_value( '0px 0px 0px 0px', 'style' ),
    'tabs_tablist_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_tablist_box_shadow_color'      => x_module_value( 'transparent', 'style:color' ),

    'tabs_tabs_fill_space'               => x_module_value( false, 'style' ),
    'tabs_tabs_justify_content'          => x_module_value( 'flex-start', 'style' ),
    'tabs_tabs_min_width'                => x_module_value( '0px', 'style' ),
    'tabs_tabs_max_width'                => x_module_value( 'none', 'style' ),
    'tabs_tabs_bg_color'                 => x_module_value( 'transparent', 'style:color' ),
    'tabs_tabs_bg_color_alt'             => x_module_value( 'transparent', 'style:color' ),
    'tabs_tabs_margin'                   => x_module_value( '0px', 'style' ),
    'tabs_tabs_padding'                  => x_module_value( '0.75rem 1.5rem 0.75rem 1.5rem', 'style' ),
    'tabs_tabs_border_width'             => x_module_value( '0px 0px 1px 0px', 'style' ),
    'tabs_tabs_border_style'             => x_module_value( 'solid solid solid solid', 'style' ),
    'tabs_tabs_border_color'             => x_module_value( 'transparent transparent transparent transparent', 'style:color' ),
    'tabs_tabs_border_color_alt'         => x_module_value( 'transparent transparent rgba(0, 0, 0, 1) transparent', 'style:color' ),
    'tabs_tabs_border_radius'            => x_module_value( '0px 0px 0px 0px', 'style' ),
    'tabs_tabs_box_shadow_dimensions'    => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_tabs_box_shadow_color'         => x_module_value( 'transparent', 'style:color' ),
    'tabs_tabs_box_shadow_color_alt'     => x_module_value( 'transparent', 'style:color' ),
    'tabs_tabs_font_family'              => x_module_value( 'inherit', 'style:font-family' ),
    'tabs_tabs_font_weight'              => x_module_value( 'inherit:400', 'style:font-weight' ),
    'tabs_tabs_font_size'                => x_module_value( '0.75em', 'style' ),
    'tabs_tabs_letter_spacing'           => x_module_value( '0.15em', 'style' ),
    'tabs_tabs_line_height'              => x_module_value( '1', 'style' ),
    'tabs_tabs_font_style'               => x_module_value( 'normal', 'style' ),
    'tabs_tabs_text_align'               => x_module_value( 'none', 'style' ),
    'tabs_tabs_text_decoration'          => x_module_value( 'none', 'style' ),
    'tabs_tabs_text_transform'           => x_module_value( 'uppercase', 'style' ),
    'tabs_tabs_text_color'               => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'tabs_tabs_text_color_alt'           => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'tabs_tabs_text_shadow_dimensions'   => x_module_value( '0px 0px 0px', 'style' ),
    'tabs_tabs_text_shadow_color'        => x_module_value( 'transparent', 'style:color' ),
    'tabs_tabs_text_shadow_color_alt'    => x_module_value( 'transparent', 'style:color' ),

    'tabs_panels_equal_height'           => x_module_value( false, 'markup' ),
    'tabs_panels_bg_color'               => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'tabs_panels_flex_justify'           => x_module_value( 'flex-start', 'style' ),
    'tabs_panels_flex_align'             => x_module_value( 'stretch', 'style' ),
    'tabs_panels_margin'                 => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_panels_padding'                => x_module_value( '1.5rem', 'style' ),
    'tabs_panels_border_width'           => x_module_value( '1px', 'style' ),
    'tabs_panels_border_style'           => x_module_value( 'solid', 'style' ),
    'tabs_panels_border_color'           => x_module_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
    'tabs_panels_border_radius'          => x_module_value( '0px 0px 0px 0px', 'style' ),
    'tabs_panels_box_shadow_dimensions'  => x_module_value( '0em 0.25em 2em 0em', 'style' ),
    'tabs_panels_box_shadow_color'       => x_module_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
    'tabs_panels_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
    'tabs_panels_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
    'tabs_panels_font_size'              => x_module_value( '1em', 'style' ),
    'tabs_panels_letter_spacing'         => x_module_value( '0em', 'style' ),
    'tabs_panels_line_height'            => x_module_value( '1.4', 'style' ),
    'tabs_panels_font_style'             => x_module_value( 'normal', 'style' ),
    'tabs_panels_text_align'             => x_module_value( 'none', 'style' ),
    'tabs_panels_text_decoration'        => x_module_value( 'none', 'style' ),
    'tabs_panels_text_transform'         => x_module_value( 'none', 'style' ),
    'tabs_panels_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'tabs_panels_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    'tabs_panels_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),

  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
