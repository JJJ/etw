<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/ACCORDION.PHP
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

function x_controls_accordion_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/accordion.php' );

  $controls = array_merge(

    array( $control_accordion_items_sortable ),

    $control_group_accordion_adv_setup,
    x_control_margin( $settings_accordion ),
    x_control_padding( $settings_accordion ),
    x_control_border( $settings_accordion ),
    x_control_border_radius( $settings_accordion ),
    x_control_box_shadow( $settings_accordion ),

    $control_group_accordion_adv_items_setup,
    x_control_padding( $settings_accordion_item_design ),
    x_control_border( $settings_accordion_item_design ),
    x_control_border_radius( $settings_accordion_item_design ),
    x_control_box_shadow( $settings_accordion_item_design ),

    $control_group_accordion_adv_header_setup,
    $control_group_accordion_adv_header_indicator_setup,
    x_control_margin( $settings_accordion_header_design ),
    x_control_padding( $settings_accordion_header_design ),
    x_control_border( $settings_accordion_header_design ),
    x_control_border_radius( $settings_accordion_header_design ),
    x_control_box_shadow( $settings_accordion_header_design ),
    x_control_text_format( $settings_accordion_header_text ),
    x_control_text_style( $settings_accordion_header_text ),
    x_control_text_shadow( $settings_accordion_header_text ),

    $control_group_accordion_adv_header_content_setup,
    x_control_margin( $settings_accordion_content_design ),
    x_control_padding( $settings_accordion_content_design ),
    x_control_border( $settings_accordion_content_design ),
    x_control_border_radius( $settings_accordion_content_design ),
    x_control_box_shadow( $settings_accordion_content_text ),
    x_control_text_format( $settings_accordion_content_text ),
    x_control_text_style( $settings_accordion_content_text ),
    x_control_text_shadow( $settings_accordion_content_text )

  );

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_accordion_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/accordion.php' );

  $controls = array( $control_accordion_items_sortable );

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_accordion_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/accordion.php' );

  $controls = array_merge(
    $control_group_accordion_std_design_setup,
    x_control_margin( $settings_accordion_std_design )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_accordion_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/accordion.php' );

  $controls = $control_group_accordion_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_accordion( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/accordion.php' );

  $control_groups = array(

    $group                          => array( 'title' => $group_title ),
    $group_accordion_setup          => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_accordion_design         => array( 'title' => __( 'Design', '__x__' ) ),

    $group_accordion_items          => array( 'title' => __( 'Items', '__x__' ) ),
    $group_accordion_items_setup    => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_accordion_items_design   => array( 'title' => __( 'Design', '__x__' ) ),

    $group_accordion_header         => array( 'title' => __( 'Header', '__x__' ) ),
    $group_accordion_header_setup   => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_accordion_header_design  => array( 'title' => __( 'Design', '__x__' ) ),
    $group_accordion_header_text    => array( 'title' => __( 'Text', '__x__' ) ),

    $group_accordion_content        => array( 'title' => __( 'Content', '__x__' ) ),
    $group_accordion_content_setup  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_accordion_content_design => array( 'title' => __( 'Design', '__x__' ) ),
    $group_accordion_content_text   => array( 'title' => __( 'Text', '__x__' ) ),

  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_accordion( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/accordion.php' );


  // Values
  // ------

  $values = array(

    'accordion_base_font_size'                  => x_module_value( '1em', 'style' ),
    'accordion_width'                           => x_module_value( '100%', 'style' ),
    'accordion_max_width'                       => x_module_value( 'none', 'style' ),
    'accordion_grouped'                         => x_module_value( false, 'markup' ),
    'accordion_group'                           => x_module_value( '', 'markup' ),
    'accordion_bg_color'                        => x_module_value( 'transparent', 'style:color' ),

    'accordion_margin'                          => x_module_value( '0em 0em 0em 0em', 'style' ),
    'accordion_padding'                         => x_module_value( '0em 0em 0em 0em', 'style' ),
    'accordion_border_width'                    => x_module_value( '0px', 'style' ),
    'accordion_border_style'                    => x_module_value( 'none', 'style' ),
    'accordion_border_color'                    => x_module_value( 'transparent', 'style:color' ),
    'accordion_border_radius'                   => x_module_value( '0px 0px 0px 0px', 'style' ),
    'accordion_box_shadow_dimensions'           => x_module_value( '0em 0em 0em 0em', 'style' ),
    'accordion_box_shadow_color'                => x_module_value( 'transparent', 'style:color' ),

    'accordion_item_overflow'                   => x_module_value( true, 'style' ),
    'accordion_item_spacing'                    => x_module_value( '25px', 'style' ),
    'accordion_item_bg_color'                   => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),

    'accordion_item_padding'                    => x_module_value( '0em 0em 0em 0em', 'style' ),
    'accordion_item_border_width'               => x_module_value( '0px', 'style' ),
    'accordion_item_border_style'               => x_module_value( 'none', 'style' ),
    'accordion_item_border_color'               => x_module_value( 'transparent', 'style:color' ),
    'accordion_item_border_radius'              => x_module_value( '0.35em 0.35em 0.35em 0.35em', 'style' ),
    'accordion_item_box_shadow_dimensions'      => x_module_value( '0em 0.15em 0.65em 0em', 'style' ),
    'accordion_item_box_shadow_color'           => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),

    'accordion_header_text_overflow'            => x_module_value( false, 'style' ),
    'accordion_header_indicator'                => x_module_value( true, 'all' ),
    'accordion_header_content_spacing'          => x_module_value( '0.5em', 'style' ),
    'accordion_header_content_reverse'          => x_module_value( false, 'all' ),
    'accordion_header_bg_color'                 => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'accordion_header_bg_color_alt'             => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),

    'accordion_header_indicator_type'           => x_module_value( 'text', 'markup' ),
    'accordion_header_indicator_text'           => x_module_value( '&#x25b8;', 'attr:html' ),
    'accordion_header_indicator_icon'           => x_module_value( 'caret-right', 'markup' ),
    'accordion_header_indicator_font_size'      => x_module_value( '1em', 'style' ),
    'accordion_header_indicator_width'          => x_module_value( 'auto', 'style' ),
    'accordion_header_indicator_height'         => x_module_value( '1em', 'style' ),
    'accordion_header_indicator_rotation_start' => x_module_value( '0deg', 'style' ),
    'accordion_header_indicator_rotation_end'   => x_module_value( '90deg', 'style' ),
    'accordion_header_indicator_color'          => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'accordion_header_indicator_color_alt'      => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),

    'accordion_header_margin'                   => x_module_value( '0em 0em 0em 0em', 'style' ),
    'accordion_header_padding'                  => x_module_value( '15px 20px 15px 20px', 'style' ),
    'accordion_header_border_width'             => x_module_value( '0px', 'style' ),
    'accordion_header_border_style'             => x_module_value( 'none', 'style' ),
    'accordion_header_border_color'             => x_module_value( 'transparent', 'style:color' ),
    'accordion_header_border_color_alt'         => x_module_value( 'transparent', 'style:color' ),
    'accordion_header_border_radius'            => x_module_value( '0px 0px 0px 0px', 'style' ),
    'accordion_header_box_shadow_dimensions'    => x_module_value( '0em 0em 0em 0em', 'style' ),
    'accordion_header_box_shadow_color'         => x_module_value( 'transparent', 'style:color' ),
    'accordion_header_box_shadow_color_alt'     => x_module_value( 'transparent', 'style:color' ),

    'accordion_header_font_family'              => x_module_value( 'inherit', 'style:font-family' ),
    'accordion_header_font_weight'              => x_module_value( 'inherit:400', 'style:font-weight' ),
    'accordion_header_font_size'                => x_module_value( '1em', 'style' ),
    'accordion_header_letter_spacing'           => x_module_value( '0em', 'style' ),
    'accordion_header_line_height'              => x_module_value( '1.3', 'style' ),
    'accordion_header_font_style'               => x_module_value( 'normal', 'style' ),
    'accordion_header_text_align'               => x_module_value( 'left', 'style' ),
    'accordion_header_text_decoration'          => x_module_value( 'none', 'style' ),
    'accordion_header_text_transform'           => x_module_value( 'none', 'style' ),
    'accordion_header_text_color'               => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'accordion_header_text_color_alt'           => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'accordion_header_text_shadow_dimensions'   => x_module_value( '0px 0px 0px', 'style' ),
    'accordion_header_text_shadow_color'        => x_module_value( 'transparent', 'style:color' ),
    'accordion_header_text_shadow_color_alt'    => x_module_value( 'transparent', 'style:color' ),

    'accordion_content_bg_color'                => x_module_value( 'transparent', 'style:color' ),

    'accordion_content_margin'                  => x_module_value( '0em 0em 0em 0em', 'style' ),
    'accordion_content_padding'                 => x_module_value( '20px 20px 20px 20px', 'style' ),
    'accordion_content_border_width'            => x_module_value( '1px 0 0 0', 'style' ),
    'accordion_content_border_style'            => x_module_value( 'solid', 'style' ),
    'accordion_content_border_color'            => x_module_value( 'rgba(225, 225, 225, 1) transparent transparent transparent', 'style' ),
    'accordion_content_border_radius'           => x_module_value( '0px 0px 0px 0px', 'style' ),
    'accordion_content_box_shadow_dimensions'   => x_module_value( '0em 0em 0em 0em', 'style' ),
    'accordion_content_box_shadow_color'        => x_module_value( 'transparent', 'style:color' ),

    'accordion_content_font_family'             => x_module_value( 'inherit', 'style:font-family' ),
    'accordion_content_font_weight'             => x_module_value( 'inherit:400', 'style:font-weight' ),
    'accordion_content_font_size'               => x_module_value( '1em', 'style' ),
    'accordion_content_letter_spacing'          => x_module_value( '0em', 'style' ),
    'accordion_content_line_height'             => x_module_value( '1.6', 'style' ),
    'accordion_content_font_style'              => x_module_value( 'normal', 'style' ),
    'accordion_content_text_align'              => x_module_value( 'none', 'style' ),
    'accordion_content_text_decoration'         => x_module_value( 'none', 'style' ),
    'accordion_content_text_transform'          => x_module_value( 'none', 'style' ),
    'accordion_content_text_color'              => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'accordion_content_text_shadow_dimensions'  => x_module_value( '0px 0px 0px', 'style' ),
    'accordion_content_text_shadow_color'       => x_module_value( 'transparent', 'style:color' ),

  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
