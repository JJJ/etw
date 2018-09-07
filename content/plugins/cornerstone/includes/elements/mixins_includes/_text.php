<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_DROPDOWN.PHP
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
//   05. Control Groups
//   06. Values
// =============================================================================

// Controls: Advanced
// =============================================================================

function x_controls_text_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_text.php' );

  $controls = $control_group_text_adv_setup;

  if ( $type === 'standard' ) {
    $controls = array_merge(
      $controls,
      $control_group_text_adv_columns
    );
  }

  if ( $type === 'headline' ) {
    $controls = array_merge(
      $controls,
      $control_group_text_adv_typing_content,
      $control_group_text_adv_typing_setup,
      x_control_flex_layout_css( $settings_text_flex_layout )
    );
  }

  $controls = array_merge(
    $controls,
    x_control_margin( $settings_text_design ),
    x_control_padding( $settings_text_design ),
    x_control_border( $settings_text_design ),
    x_control_border_radius( $settings_text_design ),
    x_control_box_shadow( $settings_text_design )
  );

  if ( $type === 'headline' ) {
    $controls = array_merge(
      $controls,
      x_control_margin( $settings_text_content_margin )
    );
  }

  $controls = array_merge(
    $controls,
    x_control_text_format( $settings_text_text ),
    x_control_text_style( $settings_text_text ),
    x_control_text_shadow( $settings_text_text )
  );

  if ( $type === 'headline' ) {
    $controls = array_merge(
      $controls,
      $control_group_text_adv_subheadline_setup,
      x_control_text_format( $settings_text_subheadline_text ),
      x_control_text_style( $settings_text_subheadline_text ),
      x_control_text_shadow( $settings_text_subheadline_text ),
      $controls_text_graphic_adv
    );
  }

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_text_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_text.php' );

  $controls = array();

  if ( $type === 'standard' ) {
    $controls = array_merge(
      $controls,
      $control_group_text_std_content_standard
    );
  }

  if ( $type === 'headline' ) {
    $controls = array_merge(
      $controls,
      $control_group_text_std_content_headline,
      $control_group_text_std_content_subheadline,
      $controls_text_graphic_std_content
    );
  }

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_text_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_text.php' );

  $controls = array_merge(
    $control_group_text_std_design_setup,
    x_control_margin( $settings_text_std_design )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_text_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_text.php' );

  $controls = array_merge(
    $control_group_text_std_design_colors,
    $controls_text_graphic_std_design_colors
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_text( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_text.php' );

  $control_groups = array(
    $group             => array( 'title' => $group_title ),
    $group_text_setup  => array( 'title' => __( 'Setup', '__x__' )  ),
    $group_text_design => array( 'title' => __( 'Design', '__x__' ) ),
    $group_text_text   => array( 'title' => __( 'Text', '__x__' )   ),
  );

  if ( $type === 'headline' ) {
    $control_groups[$group_text_graphic] = array( 'title' => __( 'Graphic', '__x__' ) );
  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_text( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_text.php' );

  $text_content = ( $type === 'standard' ) ? __( 'Input your text here! The text element is intended for longform copy that could potentially include multiple paragraphs.', '__x__' ) : __( 'Short and Sweet Headlines are Best!', '__x__' );


  // Values
  // ------

  $values = array(
    'text_type'                   => x_module_value( $type, 'all:readonly' ),
    'text_content'                => x_module_value( $text_content, 'markup:html', true ),
    'text_width'                  => x_module_value( 'auto', 'style' ),
    'text_max_width'              => x_module_value( 'none', 'style' ),
    'text_bg_color'               => x_module_value( 'transparent', 'style:color' ),
    'text_margin'                 => x_module_value( '0em', 'style' ),
    'text_padding'                => x_module_value( '0em', 'style' ),
    'text_border_width'           => x_module_value( '0px', 'style' ),
    'text_border_style'           => x_module_value( 'none', 'style' ),
    'text_border_color'           => x_module_value( 'transparent', 'style:color' ),
    'text_border_radius'          => x_module_value( '0em', 'style' ),
    'text_box_shadow_dimensions'  => x_module_value( '0em 0em 0em 0em', 'style' ),
    'text_box_shadow_color'       => x_module_value( 'transparent', 'style:color' ),
    'text_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
    'text_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
    'text_font_size'              => x_module_value( '1em', 'style' ),
    'text_line_height'            => x_module_value( '1.4', 'style' ),
    'text_letter_spacing'         => x_module_value( '0em', 'style' ),
    'text_font_style'             => x_module_value( 'normal', 'style' ),
    'text_text_align'             => x_module_value( 'none', 'style' ),
    'text_text_decoration'        => x_module_value( 'none', 'style' ),
    'text_text_transform'         => x_module_value( 'none', 'style' ),
    'text_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'text_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    'text_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
  );

  if ( $type === 'standard' ) {
    $values = array_merge(
      $values,
      array(
        'text_columns_break_inside' => x_module_value( 'auto', 'style' ),
        'text_columns'              => x_module_value( false, 'style' ),
        'text_columns_count'        => x_module_value( 2, 'style' ),
        'text_columns_width'        => x_module_value( '250px', 'style' ),
        'text_columns_gap'          => x_module_value( '25px', 'style' ),
        'text_columns_rule_style'   => x_module_value( 'none', 'style' ),
        'text_columns_rule_width'   => x_module_value( '0px', 'style' ),
        'text_columns_rule_color'   => x_module_value( 'transparent', 'style:color' ),
      )
    );
  }

  if ( $type === 'headline' ) {
    $values = array_merge(
      $values,
      array(
        'text_base_font_size'                     => x_module_value( '1em', 'style' ),
        'text_tag'                                => x_module_value( 'h1', 'markup', true ),
        'text_overflow'                           => x_module_value( false, 'style' ),
        'text_typing'                             => x_module_value( false, 'markup' ),
        'text_typing_prefix'                      => x_module_value( 'Short and ', 'markup:raw', true ),
        'text_typing_content'                     => x_module_value( "Sweet\nClever\nImpactful", 'markup:raw', true ),
        'text_typing_suffix'                      => x_module_value( ' Headlines are Best!', 'markup:raw', true ),
        'text_typing_speed'                       => x_module_value( '50ms', 'markup' ),
        'text_typing_back_speed'                  => x_module_value( '50ms', 'markup' ),
        'text_typing_delay'                       => x_module_value( '0ms', 'markup' ),
        'text_typing_back_delay'                  => x_module_value( '1000ms', 'markup' ),
        'text_typing_loop'                        => x_module_value( true, 'markup' ),
        'text_typing_cursor'                      => x_module_value( true, 'markup' ),
        'text_typing_cursor_content'              => x_module_value( '|', 'markup' ),
        'text_typing_color'                       => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
        'text_typing_cursor_color'                => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
        'text_flex_direction'                     => x_module_value( 'row', 'style' ),
        'text_flex_wrap'                          => x_module_value( false, 'style' ),
        'text_flex_justify'                       => x_module_value( 'center', 'style' ),
        'text_flex_align'                         => x_module_value( 'center', 'style' ),
        'text_content_margin'                     => x_module_value( '0px', 'style' ),
        'text_subheadline'                        => x_module_value( false, 'all' ),
        'text_subheadline_content'                => x_module_value( __( 'Subheadline space', '__x__' ), 'markup:html', true ),
        'text_subheadline_tag'                    => x_module_value( 'span', 'markup', true ),
        'text_subheadline_spacing'                => x_module_value( '0.35em', 'style' ),
        'text_subheadline_reverse'                => x_module_value( false, 'all' ),
        'text_subheadline_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
        'text_subheadline_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
        'text_subheadline_font_size'              => x_module_value( '1em', 'style' ),
        'text_subheadline_line_height'            => x_module_value( '1.4', 'style' ),
        'text_subheadline_letter_spacing'         => x_module_value( '0em', 'style' ),
        'text_subheadline_font_style'             => x_module_value( 'normal', 'style' ),
        'text_subheadline_text_align'             => x_module_value( 'none', 'style' ),
        'text_subheadline_text_decoration'        => x_module_value( 'none', 'style' ),
        'text_subheadline_text_transform'         => x_module_value( 'none', 'style' ),
        'text_subheadline_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
        'text_subheadline_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
        'text_subheadline_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
      ),
      x_values_graphic( array(
        'k_pre'               => 'text',
        'has_alt'             => false,
        'has_interactions'    => false,
        'has_sourced_content' => false,
        'has_toggle'          => false,
        'theme'               => array(
          'graphic_margin' => x_module_value( '0em 0.5em 0em 0em', 'style' ),
        ),
      ) )
    );
  }


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
