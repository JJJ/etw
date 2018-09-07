<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/BREADCRUMBS.PHP
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

function x_controls_breadcrumbs_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/breadcrumbs.php' );

  $controls = array_merge(

    $control_group_breadcrumbs_adv_setup,

    x_control_text_format( $settings_breadcrumbs_setup_no_letter_spacing ),
    x_control_margin( $settings_breadcrumbs_setup ),
    x_control_padding( $settings_breadcrumbs_setup ),
    x_control_border( $settings_breadcrumbs_setup ),
    x_control_border_radius( $settings_breadcrumbs_setup ),
    x_control_box_shadow( $settings_breadcrumbs_setup ),

    $control_group_breadcrumbs_adv_setup_delimiter,
    x_control_text_shadow( $settings_breadcrumbs_delimiter ),

    $control_group_breadcrumbs_adv_setup_links,
    $control_group_breadcrumbs_adv_setup_links_text_style_and_format,
    x_control_text_shadow( $settings_breadcrumbs_links_color ),
    x_control_margin( $settings_breadcrumbs_links ),
    x_control_padding( $settings_breadcrumbs_links ),
    x_control_border( $settings_breadcrumbs_links_color ),
    x_control_border_radius( $settings_breadcrumbs_links ),
    x_control_box_shadow( $settings_breadcrumbs_links_color )

  );

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_breadcrumbs_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/breadcrumbs.php' );

  $controls = $control_group_breadcrumbs_std_content_setup;

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_breadcrumbs_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/breadcrumbs.php' );

  $controls = array_merge(
    $control_group_breadcrumbs_std_design_setup,
    x_control_margin( $settings_breadcrumbs_std_design )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_breadcrumbs_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/breadcrumbs.php' );

  $controls = $control_group_breadcrumbs_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_breadcrumbs( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/breadcrumbs.php' );

  $control_groups = array(
    $group                       => array( 'title' => $group_title ),
    $group_breadcrumbs_setup     => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_breadcrumbs_design    => array( 'title' => __( 'Design', '__x__' ) ),
    $group_breadcrumbs_delimiter => array( 'title' => __( 'Delimiter', '__x__' ) ),
    $group_breadcrumbs_links     => array( 'title' => __( 'Links', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_breadcrumbs( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/breadcrumbs.php' );

  $values = array(

    'breadcrumbs_home_label_type'                  => x_module_value( 'text', 'markup' ),
    'breadcrumbs_home_label_text'                  => x_module_value( __( 'Home', '__x__' ), 'markup', true ),
    'breadcrumbs_home_label_icon'                  => x_module_value( 'home', 'markup', true ),
    'breadcrumbs_width'                            => x_module_value( 'auto', 'style' ),
    'breadcrumbs_max_width'                        => x_module_value( 'none', 'style' ),
    'breadcrumbs_flex_justify'                     => x_module_value( 'flex-start', 'style' ),
    'breadcrumbs_reverse'                          => x_module_value( false, 'style' ),
    'breadcrumbs_bg_color'                         => x_module_value( 'transparent', 'style:color' ),

    'breadcrumbs_font_family'                      => x_module_value( 'inherit', 'style:font-family' ),
    'breadcrumbs_font_weight'                      => x_module_value( 'inherit:400', 'style:font-weight' ),
    'breadcrumbs_font_size'                        => x_module_value( '1em', 'style' ),
    'breadcrumbs_line_height'                      => x_module_value( '1.4', 'style' ),

    'breadcrumbs_margin'                           => x_module_value( '0em', 'style' ),
    'breadcrumbs_padding'                          => x_module_value( '0em', 'style' ),
    'breadcrumbs_border_width'                     => x_module_value( '0px', 'style' ),
    'breadcrumbs_border_style'                     => x_module_value( 'none', 'style' ),
    'breadcrumbs_border_color'                     => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_border_radius'                    => x_module_value( '0em', 'style' ),
    'breadcrumbs_box_shadow_dimensions'            => x_module_value( '0em 0em 0em 0em', 'style' ),
    'breadcrumbs_box_shadow_color'                 => x_module_value( 'transparent', 'style:color' ),

    'breadcrumbs_delimiter'                        => x_module_value( true, 'all' ),
    'breadcrumbs_delimiter_type'                   => x_module_value( 'text', 'markup' ),
    'breadcrumbs_delimiter_ltr_text'               => x_module_value( '&rarr;', 'markup' ),
    'breadcrumbs_delimiter_rtl_text'               => x_module_value( '&larr;', 'markup' ),
    'breadcrumbs_delimiter_ltr_icon'               => x_module_value( 'angle-right', 'markup' ),
    'breadcrumbs_delimiter_rtl_icon'               => x_module_value( 'angle-left', 'markup' ),
    'breadcrumbs_delimiter_spacing'                => x_module_value( '8px', 'style' ),
    'breadcrumbs_delimiter_color'                  => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'breadcrumbs_delimiter_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    'breadcrumbs_delimiter_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),

    'breadcrumbs_links_base_font_size'             => x_module_value( '1em', 'style' ),
    'breadcrumbs_links_min_width'                  => x_module_value( '0em', 'style' ),
    'breadcrumbs_links_max_width'                  => x_module_value( 'none', 'style' ),
    'breadcrumbs_links_color'                      => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'breadcrumbs_links_color_alt'                  => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'breadcrumbs_links_bg_color'                   => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_bg_color_alt'               => x_module_value( 'transparent', 'style:color' ),

    'breadcrumbs_links_font_style'                 => x_module_value( 'normal', 'style' ),
    'breadcrumbs_links_text_align'                 => x_module_value( 'none', 'style' ),
    'breadcrumbs_links_text_transform'             => x_module_value( 'none', 'style' ),
    'breadcrumbs_links_letter_spacing'             => x_module_value( '0em', 'style' ),
    'breadcrumbs_links_line_height'                => x_module_value( '1.3', 'style' ),
    'breadcrumbs_links_text_shadow_dimensions'     => x_module_value( '0px 0px 0px', 'style' ),
    'breadcrumbs_links_text_shadow_color'          => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_text_shadow_color_alt'      => x_module_value( 'transparent', 'style:color' ),

    'breadcrumbs_links_margin'                     => x_module_value( '0px 0px 0px 0px', 'style' ),
    'breadcrumbs_links_padding'                    => x_module_value( '0em 0em 0em 0em', 'style' ),
    'breadcrumbs_links_border_width'               => x_module_value( '0px', 'style' ),
    'breadcrumbs_links_border_style'               => x_module_value( 'none', 'style' ),
    'breadcrumbs_links_border_color'               => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_border_color_alt'           => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_border_radius'              => x_module_value( '0em', 'style' ),
    'breadcrumbs_links_box_shadow_dimensions'      => x_module_value( '0em 0em 0em 0em', 'style' ),
    'breadcrumbs_links_box_shadow_color'           => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_box_shadow_color_alt'       => x_module_value( 'transparent', 'style:color' ),

  );

  return x_bar_mixin_values( $values, $settings );

}
