<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/QUOTE.PHP
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

function x_controls_quote_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/quote.php' );

  $controls = array_merge(

    $control_group_quote_adv_content,

    $control_group_quote_adv_setup,
    x_control_margin( $settings_quote ),
    x_control_padding( $settings_quote ),
    x_control_border( $settings_quote ),
    x_control_border_radius( $settings_quote ),
    x_control_box_shadow( $settings_quote ),

    x_control_text_format( $settings_quote_text ),
    x_control_text_style( $settings_quote_text ),
    x_control_text_shadow( $settings_quote_text ),

    $control_group_quote_adv_marks_setup,
    x_controls_graphic_adv( array_merge( $settings_quote_mark_opening, array( 'adv' => true ) ) ),
    x_controls_graphic_adv( array_merge( $settings_quote_mark_closing, array( 'adv' => true ) ) ),

    $control_group_quote_adv_cite_setup,
    x_control_flex_layout_css( $settings_quote_cite_setup ),
    x_control_margin( $settings_quote_cite_design ),
    x_control_padding( $settings_quote_cite_design ),
    x_control_border( $settings_quote_cite_design ),
    x_control_border_radius( $settings_quote_cite_design ),
    x_control_box_shadow( $settings_quote_cite_design ),

    x_control_text_format( $settings_quote_cite_text ),
    x_control_text_style( $settings_quote_cite_text ),
    x_control_text_shadow( $settings_quote_cite_text ),

    x_controls_graphic_adv( array_merge( $settings_quote_cite_graphic, array( 'adv' => true ) ) )

  );

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_quote_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/quote.php' );

  $controls = array_merge(
    $control_group_quote_std_content_setup,
    x_controls_graphic_std_content( array_merge( $settings_quote_mark_opening, array( 'group' => $group_std_content ) ) ),
    x_controls_graphic_std_content( array_merge( $settings_quote_mark_closing, array( 'group' => $group_std_content ) ) ),
    x_controls_graphic_std_content( array_merge( $settings_quote_cite_graphic, array( 'group' => $group_std_content ) ) )
  );

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_quote_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/quote.php' );

  $controls = array_merge(
    $control_group_quote_std_design_setup,
    x_control_margin( $settings_quote_std_design )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_quote_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/quote.php' );

  $controls = array_merge(
    $control_group_quote_std_design_colors_base,
    x_controls_graphic_std_design_colors( array_merge( $settings_quote_mark_opening, array( 'group' => $group_std_design ) ) ),
    x_controls_graphic_std_design_colors( array_merge( $settings_quote_mark_closing, array( 'group' => $group_std_design ) ) ),
    $control_group_quote_std_design_colors_cite,
    x_controls_graphic_std_design_colors( array_merge( $settings_quote_cite_graphic, array( 'group' => $group_std_design ) ) )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_quote( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/quote.php' );

  $control_groups = array(

    $group                     => array( 'title' => $group_title ),
    $group_quote_content       => array( 'title' => __( 'Content', '__x__' ) ),
    $group_quote_setup         => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_quote_design        => array( 'title' => __( 'Design', '__x__' ) ),
    $group_quote_text          => array( 'title' => __( 'Text', '__x__' ) ),
    $group_quote_base_marks    => array( 'title' => __( 'Marks', '__x__' ) ),

    $group_quote_marks         => array( 'title' => __( 'Marks', '__x__' ) ),
    $group_quote_marks_setup   => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_quote_marks_opening => array( 'title' => __( 'Opening', '__x__' ) ),
    $group_quote_marks_closing => array( 'title' => __( 'Closing', '__x__' ) ),

    $group_quote_cite          => array( 'title' => __( 'Citation', '__x__' ) ),
    $group_quote_cite_setup    => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_quote_cite_design   => array( 'title' => __( 'Design', '__x__' ) ),
    $group_quote_cite_text     => array( 'title' => __( 'Text', '__x__' ) ),
    $group_quote_cite_graphic  => array( 'title' => __( 'Graphic', '__x__' ) ),

  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_quote( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/quote.php' );

  $values = array_merge(
    array(

      'quote_content'                     => x_module_value( __( 'You are never too old to set another goal or to dream a new dream.', '__x__' ), 'markup:html', true ),
      'quote_cite_content'                => x_module_value( __( 'C.S. Lewis', '__x__' ), 'all:html', true ),

      'quote_base_font_size'              => x_module_value( '1em', 'style' ),
      'quote_width'                       => x_module_value( 'auto', 'style' ),
      'quote_max_width'                   => x_module_value( 'none', 'style' ),
      'quote_bg_color'                    => x_module_value( 'transparent', 'style:color' ),

      'quote_margin'                      => x_module_value( '0em 0em 0em 0em', 'style' ),
      'quote_padding'                     => x_module_value( '0em 0em 0em 0em', 'style' ),
      'quote_border_width'                => x_module_value( '0px', 'style' ),
      'quote_border_style'                => x_module_value( 'none', 'style' ),
      'quote_border_color'                => x_module_value( 'transparent', 'style:color' ),
      'quote_border_radius'               => x_module_value( '0px 0px 0px 0px', 'style' ),
      'quote_box_shadow_dimensions'       => x_module_value( '0em 0em 0em 0em', 'style' ),
      'quote_box_shadow_color'            => x_module_value( 'transparent', 'style:color' ),

      'quote_text_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
      'quote_text_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
      'quote_text_font_size'              => x_module_value( '1em', 'style' ),
      'quote_text_letter_spacing'         => x_module_value( '0em', 'style' ),
      'quote_text_line_height'            => x_module_value( '1.4', 'style' ),
      'quote_text_font_style'             => x_module_value( 'normal', 'style' ),
      'quote_text_text_align'             => x_module_value( 'center', 'style' ),
      'quote_text_text_decoration'        => x_module_value( 'none', 'style' ),
      'quote_text_text_transform'         => x_module_value( 'none', 'style' ),
      'quote_text_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
      'quote_text_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
      'quote_text_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),

      'quote_marks_graphic_direction'     => x_module_value( 'row', 'style' ),
      'quote_marks_graphic_opening_align' => x_module_value( 'start', 'style' ),
      'quote_marks_graphic_closing_align' => x_module_value( 'start', 'style' ),

    ),
    x_values_graphic( $settings_quote_mark_opening ),
    x_values_graphic( $settings_quote_mark_closing ),
    array(

      'quote_cite_position'               => x_module_value( 'after', 'style' ),
      'quote_cite_bg_color'               => x_module_value( 'transparent', 'style:color' ),

      'quote_cite_flex_direction'         => x_module_value( 'row', 'style' ),
      'quote_cite_flex_wrap'              => x_module_value( false, 'style' ),
      'quote_cite_flex_justify'           => x_module_value( 'center', 'style' ),
      'quote_cite_flex_align'             => x_module_value( 'center', 'style' ),

      'quote_cite_margin'                 => x_module_value( '0.75em 0em 0em 0em', 'style' ),
      'quote_cite_padding'                => x_module_value( '0em 0em 0em 0em', 'style' ),
      'quote_cite_border_width'           => x_module_value( '0px', 'style' ),
      'quote_cite_border_style'           => x_module_value( 'none', 'style' ),
      'quote_cite_border_color'           => x_module_value( 'transparent', 'style:color' ),
      'quote_cite_border_radius'          => x_module_value( '0px 0px 0px 0px', 'style' ),
      'quote_cite_box_shadow_dimensions'  => x_module_value( '0em 0em 0em 0em', 'style' ),
      'quote_cite_box_shadow_color'       => x_module_value( 'transparent', 'style:color' ),

      'quote_cite_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
      'quote_cite_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
      'quote_cite_font_size'              => x_module_value( '0.75em', 'style' ),
      'quote_cite_letter_spacing'         => x_module_value( '0.25em', 'style' ),
      'quote_cite_line_height'            => x_module_value( '1.3', 'style' ),
      'quote_cite_font_style'             => x_module_value( 'normal', 'style' ),
      'quote_cite_text_align'             => x_module_value( 'center', 'style' ),
      'quote_cite_text_decoration'        => x_module_value( 'none', 'style' ),
      'quote_cite_text_transform'         => x_module_value( 'uppercase', 'style' ),
      'quote_cite_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
      'quote_cite_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
      'quote_cite_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),

    ),
    x_values_graphic( $settings_quote_cite_graphic )
  );

  return x_bar_mixin_values( $values, $settings );

}
