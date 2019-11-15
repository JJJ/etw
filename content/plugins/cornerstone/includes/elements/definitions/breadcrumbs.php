<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/BREADCRUMBS.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Values
//   02. Style
//   03. Render
//   04. Define Element
//   05. Builder Setup
//   06. Register Module
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  array(
    'breadcrumbs_home_label_type'                  => cs_value( 'text', 'markup' ),
    'breadcrumbs_home_label_text'                  => cs_value( __( 'Home', '__x__' ), 'markup', true ),
    'breadcrumbs_home_label_icon'                  => cs_value( 'home', 'markup', true ),
    'breadcrumbs_width'                            => cs_value( 'auto', 'style' ),
    'breadcrumbs_max_width'                        => cs_value( 'none', 'style' ),
    'breadcrumbs_flex_justify'                     => cs_value( 'flex-start', 'style' ),
    'breadcrumbs_reverse'                          => cs_value( false, 'style' ),
    'breadcrumbs_bg_color'                         => cs_value( 'transparent', 'style:color' ),

    'breadcrumbs_font_family'                      => cs_value( 'inherit', 'style:font-family' ),
    'breadcrumbs_font_weight'                      => cs_value( 'inherit:400', 'style:font-weight' ),
    'breadcrumbs_font_size'                        => cs_value( '1em', 'style' ),
    'breadcrumbs_line_height'                      => cs_value( '1.4', 'style' ),

    'breadcrumbs_margin'                           => cs_value( '0em', 'style' ),
    'breadcrumbs_padding'                          => cs_value( '0em', 'style' ),
    'breadcrumbs_border_width'                     => cs_value( '0px', 'style' ),
    'breadcrumbs_border_style'                     => cs_value( 'none', 'style' ),
    'breadcrumbs_border_color'                     => cs_value( 'transparent', 'style:color' ),
    'breadcrumbs_border_radius'                    => cs_value( '0em', 'style' ),
    'breadcrumbs_box_shadow_dimensions'            => cs_value( '0em 0em 0em 0em', 'style' ),
    'breadcrumbs_box_shadow_color'                 => cs_value( 'transparent', 'style:color' ),

    'breadcrumbs_delimiter'                        => cs_value( true, 'all' ),
    'breadcrumbs_delimiter_type'                   => cs_value( 'text', 'markup' ),
    'breadcrumbs_delimiter_ltr_text'               => cs_value( '&rarr;', 'markup' ),
    'breadcrumbs_delimiter_rtl_text'               => cs_value( '&larr;', 'markup' ),
    'breadcrumbs_delimiter_ltr_icon'               => cs_value( 'angle-right', 'markup' ),
    'breadcrumbs_delimiter_rtl_icon'               => cs_value( 'angle-left', 'markup' ),
    'breadcrumbs_delimiter_spacing'                => cs_value( '8px', 'style' ),
    'breadcrumbs_delimiter_color'                  => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'breadcrumbs_delimiter_text_shadow_dimensions' => cs_value( '0px 0px 0px', 'style' ),
    'breadcrumbs_delimiter_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),

    'breadcrumbs_links_base_font_size'             => cs_value( '1em', 'style' ),
    'breadcrumbs_links_min_width'                  => cs_value( '0em', 'style' ),
    'breadcrumbs_links_max_width'                  => cs_value( 'none', 'style' ),
    'breadcrumbs_links_color'                      => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'breadcrumbs_links_color_alt'                  => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'breadcrumbs_links_bg_color'                   => cs_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_bg_color_alt'               => cs_value( 'transparent', 'style:color' ),

    'breadcrumbs_links_font_style'                 => cs_value( 'normal', 'style' ),
    'breadcrumbs_links_text_align'                 => cs_value( 'none', 'style' ),
    'breadcrumbs_links_text_transform'             => cs_value( 'none', 'style' ),
    'breadcrumbs_links_letter_spacing'             => cs_value( '0em', 'style' ),
    'breadcrumbs_links_line_height'                => cs_value( '1.3', 'style' ),
    'breadcrumbs_links_text_shadow_dimensions'     => cs_value( '0px 0px 0px', 'style' ),
    'breadcrumbs_links_text_shadow_color'          => cs_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_text_shadow_color_alt'      => cs_value( 'transparent', 'style:color' ),

    'breadcrumbs_links_margin'                     => cs_value( '0px 0px 0px 0px', 'style' ),
    'breadcrumbs_links_padding'                    => cs_value( '0em 0em 0em 0em', 'style' ),
    'breadcrumbs_links_border_width'               => cs_value( '0px', 'style' ),
    'breadcrumbs_links_border_style'               => cs_value( 'none', 'style' ),
    'breadcrumbs_links_border_color'               => cs_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_border_color_alt'           => cs_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_border_radius'              => cs_value( '0em', 'style' ),
    'breadcrumbs_links_box_shadow_dimensions'      => cs_value( '0em 0em 0em 0em', 'style' ),
    'breadcrumbs_links_box_shadow_color'           => cs_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_box_shadow_color_alt'       => cs_value( 'transparent', 'style:color' ),

  ),
  'omega'
);



// Style
// =============================================================================

function x_element_style_breadcrumbs() {
  return x_get_view( 'styles/elements', 'breadcrumbs', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_breadcrumbs( $data ) {
  return x_get_view( 'elements', 'breadcrumbs', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Breadcrumbs', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_breadcrumbs',
  'style'   => 'x_element_style_breadcrumbs',
  'render'  => 'x_element_render_breadcrumbs',
  'icon'    => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_breadcrumbs() {

  // Groups
  // ------

  $group           = 'breadcrumbs';
  $group_setup     = $group . ':setup';
  $group_design    = $group . ':design';
  $group_delimiter = $group . ':delimiter';
  $group_links     = $group . ':links';


  // Conditions
  // ----------

  $condition_breadcrumbs_home_label_text     = array( 'breadcrumbs_home_label_type' => 'text' );
  $condition_breadcrumbs_home_label_icon     = array( 'breadcrumbs_home_label_type' => 'icon' );
  $condition_breadcrumbs_delimiter           = array( 'breadcrumbs_delimiter' => true );
  $condition_breadcrumbs_delimiter_type_text = array( 'breadcrumbs_delimiter_type' => 'text' );
  $condition_breadcrumbs_delimiter_type_icon = array( 'breadcrumbs_delimiter_type' => 'icon' );

  $conditions_breadcrumbs_delimiter_text     = array( $condition_breadcrumbs_delimiter, $condition_breadcrumbs_delimiter_type_text );
  $conditions_breadcrumbs_delimiter_icon     = array( $condition_breadcrumbs_delimiter, $condition_breadcrumbs_delimiter_type_icon );


  // Options
  // -------

  $options_breadcrumbs_home_label_type = array(
    'choices' => array(
      array( 'value' => 'text', 'label' => __( 'Text', '__x__' ) ),
      array( 'value' => 'icon', 'label' => __( 'Icon', '__x__' ) ),
    ),
  );

  $options_breadcrumbs_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'valid_keywords'  => array( 'auto' ),
    'fallback_value'  => 'auto',
  );

  $options_breadcrumbs_max_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'valid_keywords'  => array( 'none' ),
    'fallback_value'  => 'none',
  );

  $options_breadcrumbs_flex_justify = array(
    'choices' => array(
      array( 'value' => 'flex-start', 'label' => __( 'Initial', '__x__' )  ),
      array( 'value' => 'center',     'label' => __( 'Center', '__x__' ) ),
    ),
  );

  $options_breadcrumbs_delimiter_type = array(
    'choices' => array(
      array( 'value' => 'text', 'label' => __( 'Text', '__x__' ) ),
      array( 'value' => 'icon', 'label' => __( 'Icon', '__x__' ) ),
    ),
  );

  $options_breadcrumbs_delimiter_spacing = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'fallback_value'  => '8px',
    'ranges'          => array(
      'px'  => array( 'min' => 0, 'max' => 20,   'step' => 1 ),
      'em'  => array( 'min' => 0, 'max' => 0.75, 'step' => 0.05 ),
      'rem' => array( 'min' => 0, 'max' => 0.75, 'step' => 0.05 ),
    ),
  );

  $options_breadcrumbs_links_base_font_size = array(
    'available_units' => array( 'em' ),
    'valid_keywords'  => array( 'calc' ),
    'ranges'          => array(
      'em' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.05 ),
    ),
  );

  $options_breadcrumbs_links_min_width = array(
    'available_units' => array( 'em' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '0em',
    'ranges'          => array(
      'em' => array( 'min' => 2.5, 'max' => 10, 'step' => 0.1 ),
    ),
  );

  $options_breadcrumbs_links_max_width = array(
    'available_units' => array( 'em' ),
    'valid_keywords'  => array( 'none', 'calc' ),
    'fallback_value'  => 'none',
    'ranges'          => array(
      'em' => array( 'min' => 2.5, 'max' => 10, 'step' => 0.1 ),
    ),
  );

  $options_breadcrumbs_links_letter_spacing = array(
    'available_units' => array( 'em' ),
    'ranges'          => array(
      'em' => array( 'min' => -0.15, 'max' => 0.5, 'step' => 0.01 ),
    ),
  );

  $options_breadcrumbs_links_line_height = array(
    'unit_mode' => 'unitless',
    'min'       => 1,
    'max'       => 2.5,
    'step'      => 0.1,
  );


  // Settings
  // --------

  $settings_breadcrumbs_design = array(
    'k_pre' => 'breadcrumbs',
    'group' => $group_design,
  );

  $settings_breadcrumbs_links = array(
    'k_pre'        => 'breadcrumbs_links',
    'group'        => $group_links,
    'label_prefix' => __( 'Links', '__x__' ),
  );

  $settings_breadcrumbs_links_color = array(
    'group'        => $group_links,
    'alt_color'    => true,
    'label_prefix' => __( 'Links', '__x__' ),
    'options'      => cs_recall( 'options_color_base_interaction_labels' ),
  );


  // Individual Controls
  // -------------------

  $control_breadcrumbs_home_label_type = array(
    'key'     => 'breadcrumbs_home_label_type',
    'type'    => 'choose',
    'label'   => __( 'Home Label Type', '__x__' ),
    'options' => $options_breadcrumbs_home_label_type,
  );

  $control_breadcrumbs_home_label_text = array(
    'key'   => 'breadcrumbs_home_label_text',
    'type'  => 'text',
    'label' => __( 'Home Label', '__x__' ),
  );

  $control_breadcrumbs_home_label_icon = array(
    'key'   => 'breadcrumbs_home_label_icon',
    'type'  => 'icon',
    'label' => __( 'Home Label', '__x__' ),
  );

  $control_breadcrumbs_home_label_text_and_icon = array(
    'type'      => 'group',
    'label'     => __( 'Home Label &amp; Icon', '__x__' ),
    'condition' => $condition_breadcrumbs_home_label_icon,
    'controls'  => array(
      $control_breadcrumbs_home_label_text,
      $control_breadcrumbs_home_label_icon,
    ),
  );

  $control_breadcrumbs_width = array(
    'key'     => 'breadcrumbs_width',
    'type'    => 'unit',
    'label'   => __( 'Width', '__x__' ),
    'options' => $options_breadcrumbs_width,
  );

  $control_breadcrumbs_max_width = array(
    'key'     => 'breadcrumbs_max_width',
    'type'    => 'unit',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => $options_breadcrumbs_max_width,
  );


  $control_breadcrumbs_width_and_max_width = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Max Width', '__x__' ),
    'controls' => array(
      $control_breadcrumbs_width,
      $control_breadcrumbs_max_width,
    ),
  );

  $control_breadcrumbs_flex_justify = array(
    'key'     => 'breadcrumbs_flex_justify',
    'type'    => 'select',
    'options' => $options_breadcrumbs_flex_justify,
  );

  $control_breadcrumbs_reverse = array(
    'keys' => array(
      'reverse' => 'breadcrumbs_reverse',
    ),
    'type'    => 'checkbox-list',
    'options' => array(
      'list' => array(
        array( 'key' => 'reverse', 'label' => __( 'Reverse', '__x__' ) ),
      ),
    ),
  );

  $control_breadcrumbs_justification_and_reverse = array(
    'type'     => 'group',
    'label'    => __( 'Justification &amp; Direction', '__x__' ),
    'controls' => array(
      $control_breadcrumbs_flex_justify,
      $control_breadcrumbs_reverse,
    ),
  );

  $control_breadcrumbs_bg_color = array(
    'keys' => array(
      'value' => 'breadcrumbs_bg_color',
    ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_breadcrumbs_delimiter = array(
    'key'     => 'breadcrumbs_delimiter',
    'type'    => 'choose',
    'label'   => __( 'Enable', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_breadcrumbs_delimiter_type = array(
    'key'       => 'breadcrumbs_delimiter_type',
    'type'      => 'choose',
    'label'     => __( 'Delimiter Type', '__x__' ),
    'condition' => $condition_breadcrumbs_delimiter,
    'options'   => $options_breadcrumbs_delimiter_type,
  );

  $control_breadcrumbs_delimiter_ltr_text = array(
    'key'        => 'breadcrumbs_delimiter_ltr_text',
    'type'       => 'text',
    'label'      => __( 'LTR Delimiter', '__x__' ),
    'conditions' => $conditions_breadcrumbs_delimiter_text,
  );

  $control_breadcrumbs_delimiter_rtl_text = array(
    'key'        => 'breadcrumbs_delimiter_rtl_text',
    'type'       => 'text',
    'label'      => __( 'RTL Delimiter', '__x__' ),
    'conditions' => $conditions_breadcrumbs_delimiter_text,
  );

  $control_breadcrumbs_delimiter_ltr_and_rtl_text = array(
    'type'       => 'group',
    'label'      => __( 'LTR &amp; RTL Delimiter', '__x__' ),
    'conditions' => $conditions_breadcrumbs_delimiter_text,
    'controls'   => array(
      $control_breadcrumbs_delimiter_ltr_text,
      $control_breadcrumbs_delimiter_rtl_text,
    ),
  );

  $control_breadcrumbs_delimiter_ltr_icon = array(
    'key'        => 'breadcrumbs_delimiter_ltr_icon',
    'type'       => 'icon',
    'label'      => __( 'LTR Delimiter', '__x__' ),
    'conditions' => $conditions_breadcrumbs_delimiter_icon,
  );

  $control_breadcrumbs_delimiter_rtl_icon = array(
    'key'        => 'breadcrumbs_delimiter_rtl_icon',
    'type'       => 'icon',
    'label'      => __( 'RTL Delimiter', '__x__' ),
    'conditions' => $conditions_breadcrumbs_delimiter_icon,
  );

  $control_breadcrumbs_delimiter_ltr_and_rtl_icon = array(
    'type'       => 'group',
    'label'      => __( 'LTR &amp; RTL Delimiter', '__x__' ),
    'conditions' => $conditions_breadcrumbs_delimiter_icon,
    'controls'   => array(
      $control_breadcrumbs_delimiter_ltr_icon,
      $control_breadcrumbs_delimiter_rtl_icon,
    ),
  );

  $control_breadcrumbs_delimiter_spacing = array(
    'key'       => 'breadcrumbs_delimiter_spacing',
    'type'      => 'unit-slider',
    'label'     => __( 'Spacing', '__x__' ),
    'condition' => $condition_breadcrumbs_delimiter,
    'options'   => $options_breadcrumbs_delimiter_spacing,
  );

  $control_breadcrumbs_delimiter_color = array(
    'keys' => array(
      'value' => 'breadcrumbs_delimiter_color',
    ),
    'type'      => 'color',
    'label'     => __( 'Color', '__x__' ),
    'condition' => $condition_breadcrumbs_delimiter,
  );

  $control_breadcrumbs_links_base_font_size = array(
    'key'     => 'breadcrumbs_links_base_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => $options_breadcrumbs_links_base_font_size,
  );

  $control_breadcrumbs_links_min_width = array(
    'key'     => 'breadcrumbs_links_min_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Min Width', '__x__' ),
    'options' => $options_breadcrumbs_links_min_width,
  );

  $control_breadcrumbs_links_max_width = array(
    'key'     => 'breadcrumbs_links_max_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => $options_breadcrumbs_links_max_width,
  );

  $control_breadcrumbs_links_colors = array(
    'keys' => array(
      'value' => 'breadcrumbs_links_color',
      'alt'   => 'breadcrumbs_links_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Color', '__x__' ),
    'options' => cs_recall( 'options_base_interaction_labels' ),
  );

  $control_breadcrumbs_links_bg_colors = array(
    'keys' => array(
      'value' => 'breadcrumbs_links_bg_color',
      'alt'   => 'breadcrumbs_links_bg_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' ),
    'options' => cs_recall( 'options_base_interaction_labels' ),
  );

  $control_breadcrumbs_links_font_style = array(
    'key'   => 'breadcrumbs_links_font_style',
    'type'  => 'font-style',
    'label' => __( 'Font Style', '__x__' ),
  );

  $control_breadcrumbs_links_text_align = array(
    'key'   => 'breadcrumbs_links_text_align',
    'type'  => 'text-align',
    'label' => __( 'Text Align', '__x__' ),
  );

  $control_breadcrumbs_links_text_transform = array(
    'key'   => 'breadcrumbs_links_text_transform',
    'type'  => 'text-transform',
    'label' => __( 'Text Transform', '__x__' ),
  );

  $control_breadcrumbs_links_letter_spacing = array(
    'key'     => 'breadcrumbs_links_letter_spacing',
    'type'    => 'unit-slider',
    'label'   => __( 'Letter Spacing', '__x__' ),
    'options' => $options_breadcrumbs_links_letter_spacing,
  );

  $control_breadcrumbs_links_line_height = array(
    'key'     => 'breadcrumbs_links_line_height',
    'type'    => 'unit-slider',
    'label'   => __( 'Line Height', '__x__' ),
    'options' => $options_breadcrumbs_links_line_height,
  );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(

      'controls' => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Setup', '__x__' ),
          'group'    => $group_setup,
          'controls' => array(
            $control_breadcrumbs_home_label_type,
            array_merge( $control_breadcrumbs_home_label_text, array( 'condition' => $condition_breadcrumbs_home_label_text ) ),
            $control_breadcrumbs_home_label_text_and_icon,
            $control_breadcrumbs_width_and_max_width,
            $control_breadcrumbs_justification_and_reverse,
            $control_breadcrumbs_bg_color,
          ),
        ),
        cs_control( 'text-format', 'breadcrumbs', array(
          'no_letter_spacing'  => true,
          'no_font_style'      => true,
          'no_text_align'      => true,
          'no_text_decoration' => true,
          'no_text_transform'  => true,
          'no_text_color'      => true,
        ) ),
        cs_control( 'margin', 'breadcrumbs', $settings_breadcrumbs_design ),
        cs_control( 'padding', 'breadcrumbs', $settings_breadcrumbs_design ),
        cs_control( 'border', 'breadcrumbs', $settings_breadcrumbs_design ),
        cs_control( 'border-radius', 'breadcrumbs', $settings_breadcrumbs_design ),
        cs_control( 'box-shadow', 'breadcrumbs', $settings_breadcrumbs_design ),
        array(
          'type'     => 'group',
          'label'    => __( 'Delimiter Setup', '__x__' ),
          'group'    => $group_delimiter,
          'controls' => array(
            $control_breadcrumbs_delimiter,
            $control_breadcrumbs_delimiter_type,
            $control_breadcrumbs_delimiter_ltr_and_rtl_text,
            $control_breadcrumbs_delimiter_ltr_and_rtl_icon,
            $control_breadcrumbs_delimiter_spacing,
            $control_breadcrumbs_delimiter_color,
          ),
        ),
        cs_control( 'text-shadow', 'breadcrumbs_delimiter', array(
          'group'        => $group_delimiter,
          'label_prefix' => __( 'Delimiter', '__x__' ),
          'condition'    => $condition_breadcrumbs_delimiter,
        ) ),
        array(
          'type'     => 'group',
          'label'    => __( 'Links Setup', '__x__' ),
          'group'    => $group_links,
          'controls' => array(
            $control_breadcrumbs_links_base_font_size,
            $control_breadcrumbs_links_min_width,
            $control_breadcrumbs_links_max_width,
            $control_breadcrumbs_links_colors,
            $control_breadcrumbs_links_bg_colors,
          ),
        ),
        array(
          'type'     => 'group',
          'label'    => __( 'Links Text Format', '__x__' ),
          'group'    => $group_links,
          'controls' => array(
            $control_breadcrumbs_links_font_style,
            $control_breadcrumbs_links_text_align,
            $control_breadcrumbs_links_text_transform,
            $control_breadcrumbs_links_letter_spacing,
            $control_breadcrumbs_links_line_height,
          ),
        ),
        cs_control( 'text-shadow', 'breadcrumbs_links', $settings_breadcrumbs_links_color ),
        cs_control( 'margin', 'breadcrumbs_links', $settings_breadcrumbs_links ),
        cs_control( 'padding', 'breadcrumbs_links', $settings_breadcrumbs_links ),
        cs_control( 'border', 'breadcrumbs_links', $settings_breadcrumbs_links_color ),
        cs_control( 'border-radius', 'breadcrumbs_links', $settings_breadcrumbs_links ),
        cs_control( 'box-shadow', 'breadcrumbs_links', $settings_breadcrumbs_links_color )
      ),



      'controls_std_content' => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Content Setup', '__x__' ),
          'controls' => array(
            $control_breadcrumbs_home_label_text,
            $control_breadcrumbs_home_label_icon,
            $control_breadcrumbs_delimiter_ltr_text,
            $control_breadcrumbs_delimiter_rtl_text,
            $control_breadcrumbs_delimiter_ltr_icon,
            $control_breadcrumbs_delimiter_rtl_icon,
          ),
        ),
      ),



      'controls_std_design_setup' => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Design Setup', '__x__' ),
          'controls' => array(
            array(
              'key'     => 'breadcrumbs_font_size',
              'type'    => 'unit-slider',
              'label'   => __( 'Base Font Size', '__x__' ),
              'options' => array(
                'available_units' => array( 'px', 'em', 'rem' ),
                'valid_keywords'  => array( 'calc' ),
                'fallback_value'  => '1em',
                'ranges'          => array(
                  'px'  => array( 'min' => 14,  'max' => 64, 'step' => 1    ),
                  'em'  => array( 'min' => 0.5, 'max' => 5,  'step' => 0.05 ),
                  'rem' => array( 'min' => 0.5, 'max' => 5,  'step' => 0.05 ),
                ),
              ),
            ),
            cs_amend_control( $control_breadcrumbs_width, array( 'type' => 'unit-slider') ),
            cs_amend_control( $control_breadcrumbs_max_width, array( 'type' => 'unit-slider') ),
            cs_amend_control( $control_breadcrumbs_delimiter_spacing, array( 'label' => __( 'Delimiter Spacing', '__x__' ) ) ),
          ),
        ),
        cs_control( 'margin', 'breadcrumbs' )
      ),


      'controls_std_design_colors' => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Base Colors', '__x__' ),
          'controls' => array(
            array(
              'keys'      => array( 'value' => 'breadcrumbs_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'breadcrumbs_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_breadcrumbs_bg_color,
          ),
        ),
        cs_control( 'border', 'breadcrumbs', array(
          'options'    => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'breadcrumbs_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'breadcrumbs_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) ),
        array(
          'type'       => 'group',
          'label'      => __( 'Delimiter Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'  => array( 'value' => 'breadcrumbs_delimiter_color' ),
              'type'  => 'color',
              'label' => __( 'Text', '__x__' ),
            ),
            array(
              'keys'      => array( 'value' => 'breadcrumbs_delimiter_text_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'breadcrumbs_delimiter_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
          ),
        ),
        array(
          'type'     => 'group',
          'label'    => __( 'Links Colors', '__x__' ),
          'controls' => array(
            $control_breadcrumbs_links_colors,
            array(
              'keys' => array(
                'value' => 'breadcrumbs_links_text_shadow_color',
                'alt'   => 'breadcrumbs_links_text_shadow_color_alt',
              ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'options'   => cs_recall( 'options_base_interaction_labels' ),
              'condition' => array( 'key' => 'breadcrumbs_links_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            array(
              'keys' => array(
                'value' => 'breadcrumbs_links_box_shadow_color',
                'alt'   => 'breadcrumbs_links_box_shadow_color_alt',
              ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'options'   => cs_recall( 'options_base_interaction_labels' ),
              'condition' => array( 'key' => 'breadcrumbs_links_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_breadcrumbs_links_bg_colors,
          ),
        ),
        cs_control( 'border', 'breadcrumbs_links',  array(
          'label_prefix' => __( 'Links', '__x__' ),
          'options'      => cs_recall( 'options_color_base_interaction_labels_color_only' ),
          'conditions'   => array(
            array( 'key' => 'breadcrumbs_links_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'breadcrumbs_links_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) )
      ),



      'control_nav' => array(
        $group           => __( 'Breadcrumbs', '__x__' ),
        $group_setup     => __( 'Setup', '__x__' ),
        $group_design    => __( 'Design', '__x__' ),
        $group_delimiter => __( 'Delimiter', '__x__' ),
        $group_links     => __( 'Links', '__x__' ),
      ),

    ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'breadcrumbs', $data );
