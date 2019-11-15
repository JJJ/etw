<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/ACCORDION.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Groups
//   03. Values
//   04. Define Element
//   05. Builder Setup
//   06. Register Element
// =============================================================================


// Values
// =============================================================================

$values = cs_compose_values(
  array(
    'accordion_base_font_size'                  => cs_value( '1em', 'style' ),
    'accordion_width'                           => cs_value( '100%', 'style' ),
    'accordion_max_width'                       => cs_value( 'none', 'style' ),
    'accordion_grouped'                         => cs_value( false, 'markup' ),
    'accordion_group'                           => cs_value( '', 'markup' ),
    'accordion_bg_color'                        => cs_value( 'transparent', 'style:color' ),

    'accordion_margin'                          => cs_value( '0em 0em 0em 0em', 'style' ),
    'accordion_padding'                         => cs_value( '0em 0em 0em 0em', 'style' ),
    'accordion_border_width'                    => cs_value( '0px', 'style' ),
    'accordion_border_style'                    => cs_value( 'none', 'style' ),
    'accordion_border_color'                    => cs_value( 'transparent', 'style:color' ),
    'accordion_border_radius'                   => cs_value( '0px 0px 0px 0px', 'style' ),
    'accordion_box_shadow_dimensions'           => cs_value( '0em 0em 0em 0em', 'style' ),
    'accordion_box_shadow_color'                => cs_value( 'transparent', 'style:color' ),

    'accordion_item_overflow'                   => cs_value( true, 'style' ),
    'accordion_item_spacing'                    => cs_value( '25px', 'style' ),
    'accordion_item_bg_color'                   => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),

    'accordion_item_padding'                    => cs_value( '0em 0em 0em 0em', 'style' ),
    'accordion_item_border_width'               => cs_value( '0px', 'style' ),
    'accordion_item_border_style'               => cs_value( 'none', 'style' ),
    'accordion_item_border_color'               => cs_value( 'transparent', 'style:color' ),
    'accordion_item_border_radius'              => cs_value( '0.35em 0.35em 0.35em 0.35em', 'style' ),
    'accordion_item_box_shadow_dimensions'      => cs_value( '0em 0.15em 0.65em 0em', 'style' ),
    'accordion_item_box_shadow_color'           => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),

    'accordion_header_text_overflow'            => cs_value( false, 'style' ),
    'accordion_header_indicator'                => cs_value( true, 'all' ),
    'accordion_header_content_spacing'          => cs_value( '0.5em', 'style' ),
    'accordion_header_content_reverse'          => cs_value( false, 'all' ),
    'accordion_header_bg_color'                 => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'accordion_header_bg_color_alt'             => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),

    'accordion_header_indicator_type'           => cs_value( 'text', 'markup' ),
    'accordion_header_indicator_text'           => cs_value( '&#x25b8;', 'markup:raw' ),
    'accordion_header_indicator_icon'           => cs_value( 'caret-right', 'markup' ),
    'accordion_header_indicator_font_size'      => cs_value( '1em', 'style' ),
    'accordion_header_indicator_width'          => cs_value( 'auto', 'style' ),
    'accordion_header_indicator_height'         => cs_value( '1em', 'style' ),
    'accordion_header_indicator_rotation_start' => cs_value( '0deg', 'style' ),
    'accordion_header_indicator_rotation_end'   => cs_value( '90deg', 'style' ),
    'accordion_header_indicator_color'          => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'accordion_header_indicator_color_alt'      => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),

    'accordion_header_margin'                   => cs_value( '0em 0em 0em 0em', 'style' ),
    'accordion_header_padding'                  => cs_value( '15px 20px 15px 20px', 'style' ),
    'accordion_header_border_width'             => cs_value( '0px', 'style' ),
    'accordion_header_border_style'             => cs_value( 'none', 'style' ),
    'accordion_header_border_color'             => cs_value( 'transparent', 'style:color' ),
    'accordion_header_border_color_alt'         => cs_value( 'transparent', 'style:color' ),
    'accordion_header_border_radius'            => cs_value( '0px 0px 0px 0px', 'style' ),
    'accordion_header_box_shadow_dimensions'    => cs_value( '0em 0em 0em 0em', 'style' ),
    'accordion_header_box_shadow_color'         => cs_value( 'transparent', 'style:color' ),
    'accordion_header_box_shadow_color_alt'     => cs_value( 'transparent', 'style:color' ),

    'accordion_header_font_family'              => cs_value( 'inherit', 'style:font-family' ),
    'accordion_header_font_weight'              => cs_value( 'inherit:400', 'style:font-weight' ),
    'accordion_header_font_size'                => cs_value( '1em', 'style' ),
    'accordion_header_letter_spacing'           => cs_value( '0em', 'style' ),
    'accordion_header_line_height'              => cs_value( '1.3', 'style' ),
    'accordion_header_font_style'               => cs_value( 'normal', 'style' ),
    'accordion_header_text_align'               => cs_value( 'left', 'style' ),
    'accordion_header_text_decoration'          => cs_value( 'none', 'style' ),
    'accordion_header_text_transform'           => cs_value( 'none', 'style' ),
    'accordion_header_text_color'               => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'accordion_header_text_color_alt'           => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'accordion_header_text_shadow_dimensions'   => cs_value( '0px 0px 0px', 'style' ),
    'accordion_header_text_shadow_color'        => cs_value( 'transparent', 'style:color' ),
    'accordion_header_text_shadow_color_alt'    => cs_value( 'transparent', 'style:color' ),

    'accordion_content_bg_color'                => cs_value( 'transparent', 'style:color' ),

    'accordion_content_margin'                  => cs_value( '0em 0em 0em 0em', 'style' ),
    'accordion_content_padding'                 => cs_value( '20px 20px 20px 20px', 'style' ),
    'accordion_content_border_width'            => cs_value( '1px 0 0 0', 'style' ),
    'accordion_content_border_style'            => cs_value( 'solid', 'style' ),
    'accordion_content_border_color'            => cs_value( 'rgba(225, 225, 225, 1) transparent transparent transparent', 'style' ),
    'accordion_content_border_radius'           => cs_value( '0px 0px 0px 0px', 'style' ),
    'accordion_content_box_shadow_dimensions'   => cs_value( '0em 0em 0em 0em', 'style' ),
    'accordion_content_box_shadow_color'        => cs_value( 'transparent', 'style:color' ),

    'accordion_content_font_family'             => cs_value( 'inherit', 'style:font-family' ),
    'accordion_content_font_weight'             => cs_value( 'inherit:400', 'style:font-weight' ),
    'accordion_content_font_size'               => cs_value( '1em', 'style' ),
    'accordion_content_letter_spacing'          => cs_value( '0em', 'style' ),
    'accordion_content_line_height'             => cs_value( '1.6', 'style' ),
    'accordion_content_font_style'              => cs_value( 'normal', 'style' ),
    'accordion_content_text_align'              => cs_value( 'none', 'style' ),
    'accordion_content_text_decoration'         => cs_value( 'none', 'style' ),
    'accordion_content_text_transform'          => cs_value( 'none', 'style' ),
    'accordion_content_text_color'              => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'accordion_content_text_shadow_dimensions'  => cs_value( '0px 0px 0px', 'style' ),
    'accordion_content_text_shadow_color'       => cs_value( 'transparent', 'style:color' ),
  ),
  'omega'
);


// Style
// =============================================================================

function x_element_style_accordion() {
  return x_get_view( 'styles/elements', 'accordion', 'css', array(), false );
}


// Render
// =============================================================================

function x_element_render_accordion( $data ) {
  return x_get_view( 'elements', 'accordion', '', $data, false );
}


// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Accordion', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_accordion',
  'render' => 'x_element_render_accordion',
  'style' => 'x_element_style_accordion',
  'icon' => 'native',
  'options' => array(
    'valid_children'     => array( 'accordion-item' ),
    'default_children' => array(
      array( '_type' => 'accordion-item', 'accordion_item_header_content' => __( 'Accordion Item 1', '__x__' ) ),
      array( '_type' => 'accordion-item', 'accordion_item_header_content' => __( 'Accordion Item 2', '__x__' ) ),
    ),
    'add_new_element' => array( '_type' => 'accordion-item' )
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_accordion() {

  // Options
  // -------

  $options_accordion_header_indicator_rotation = array(
    'unit_mode'       => 'angle',
    'available_units' => array( 'deg' ),
    'fallback_value'  => '0deg',
    'ranges'          => array(
      'deg' => array( 'min' => 0, 'max' => 360, 'step' => 1 ),
    ),
  );



  // Settings
  // --------

  $settings_accordion_item_design = array(
    'label_prefix'  => __( 'Item', '__x__' ),
    'group'         => 'accordion_items:design',
  );

  $settings_accordion_header_design = array(
    'label_prefix'     => __( 'Header', '__x__' ),
    'group'     => 'accordion_item_header:design',
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_base_interaction_labels' ),
  );

  $settings_accordion_header_text = array(
    'label_prefix'     => __( 'Header', '__x__' ),
    'group'     => 'accordion_item_header:text',
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_base_interaction_labels' ),
  );

  $settings_accordion_content_design = array(
    'label_prefix'     => __( 'Content', '__x__' ),
    'group'     => 'accordion_item_content:design',
  );

  $settings_accordion_content_text = array(
    'k_pre'     => 'accordion_content',
    'label_prefix'     => __( 'Content', '__x__' ),
    'group'     => 'accordion_item_content:text',
  );



  // Individual Controls
  // -------------------

  $control_accordion_items_sortable = array(
    'type'       => 'sortable',
    'label'      => __( 'Add Items', '__x__' ),
    'group'      => 'accordion:setup'
  );

  $control_accordion_base_font_size = array(
    'key'     => 'accordion_base_font_size',
    'type'    => 'slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '1em',
      'ranges'          => array(
        'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
        'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
        'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
      ),
    ),
  );

  $control_accordion_width = array(
    'key'     => 'accordion_width',
    'type'    => 'unit',
    'label'   => __( 'Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'valid_keywords'  => array( 'auto' ),
      'fallback_value'  => 'auto',
    ),
  );

  $control_accordion_max_width = array(
    'key'     => 'accordion_max_width',
    'type'    => 'unit',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'valid_keywords'  => array( 'none' ),
      'fallback_value'  => 'none',
    ),
  );

  $control_accordion_width_and_max_width = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Max Width', '__x__' ),
    'controls' => array(
      $control_accordion_width,
      $control_accordion_max_width,
    ),
  );

  $control_accordion_grouped = array(
    'key'     => 'accordion_grouped',
    'type'    => 'choose',
    'label'   => __( 'Enable Grouping', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_accordion_group = array(
    'key'       => 'accordion_group',
    'type'      => 'text',
    'label'     => __( 'Custom Group', '__x__' ),
    'condition' => array( 'accordion_grouped' => true ),
  );

  $control_accordion_bg_color = array(
    'key'   => 'accordion_bg_color',
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_accordion_item_overflow = array(
    'key'     => 'accordion_item_overflow',
    'type'    => 'choose',
    'label'   => __( 'Overflow', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_accordion_item_spacing = array(
    'key'     => 'accordion_item_spacing',
    'type'    => 'unit-slider',
    'label'   => __( 'Spacing', '__x__' ),
    'options' => array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 0, 'max' => 25, 'step' => 1   ),
      'em'  => array( 'min' => 0, 'max' => 1,  'step' => 0.1 ),
      'rem' => array( 'min' => 0, 'max' => 1,  'step' => 0.1 ),
    ),
  ),
  );

  $control_accordion_item_bg_color = array(
    'key'   => 'accordion_item_bg_color',
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_accordion_header_text_overflow = array(
    'key'     => 'accordion_header_text_overflow',
    'type'    => 'choose',
    'label'   => __( 'Overflow', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_accordion_header_indicator = array(
    'key'     => 'accordion_header_indicator',
    'type'    => 'choose',
    'label'   => __( 'Indicator', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_accordion_header_spacing_and_direction = array(
    'type'      => 'group',
    'label'     => __( 'Spacing &amp; Direction', '__x__' ),
    'condition' => array( 'accordion_header_indicator' => true ),
    'controls'  => array(
      array(
        'key'     => 'accordion_header_content_spacing',
        'type'    => 'unit',
        'label'   => __( 'Indicator Spacing', '__x__' ),
        'options' => array(
          'available_units' => array( 'px', 'em', 'rem' ),
          'valid_keywords'  => array( 'calc' ),
          'fallback_value'  => '1em',
        ),
      ),
      array(
        'keys' => array(
          'reverse' => 'accordion_header_content_reverse',
        ),
        'type'    => 'checkbox-list',
        'label'   => __( 'Indicator Reverse', '__x__' ),
        'options' => array(
          'list' => array(
            array( 'key' => 'reverse', 'label' => __( 'Reverse', '__x__' ) ),
          ),
        ),
      ),
    ),
  );

  $control_accordion_header_bg_colors = array(
    'keys' => array(
      'value' => 'accordion_header_bg_color',
      'alt'   => 'accordion_header_bg_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' ),
    'options' => cs_recall( 'options_base_interaction_labels' ),
  );

  $control_accordion_header_indicator_type = array(
    'key'     => 'accordion_header_indicator_type',
    'type'    => 'choose',
    'label'   => __( 'Type', '__x__' ),
    'options' => array(
    'choices' => array(
      array( 'value' => 'text', 'label' => __( 'Text', '__x__' ) ),
      array( 'value' => 'icon', 'label' => __( 'Icon', '__x__' ) ),
    ),
  ),
  );

  $control_accordion_header_indicator_text = array(
    'key'       => 'accordion_header_indicator_text',
    'type'      => 'text',
    'label'     => __( 'Indicator', '__x__' ),
    'condition' => array( 'accordion_header_indicator_type' => 'text' ),
  );

  $control_accordion_header_indicator_icon = array(
    'key'       => 'accordion_header_indicator_icon',
    'type'      => 'icon',
    'label'     => __( 'Indicator', '__x__' ),
    'condition' => array( 'accordion_header_indicator_type' => 'icon' ),
    'options'   => array(
      'label' => __( 'Select', '__x__' ),
    ),
  );

  $control_accordion_header_indicator_text_and_icon_and_font_size = array(
    'type'     => 'group',
    'label'    => __( 'Indicator &amp; Font Size', '__x__' ),
    'controls' => array(
      $control_accordion_header_indicator_text,
      $control_accordion_header_indicator_icon,
      array(
        'key'     => 'accordion_header_indicator_font_size',
        'type'    => 'unit',
        'label'   => __( 'Font Size', '__x__' ),
        'options' => array(
          'available_units' => array( 'px', 'em', 'rem' ),
          'valid_keywords'  => array( 'calc' ),
          'fallback_value'  => '1em',
          'ranges'          => array(
            'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
            'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.25 ),
            'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.25 ),
          ),
        ),
      ),
    ),
  );

  $control_accordion_header_indicator_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Height', '__x__' ),
    'controls' => array(
      array(
        'key'     => 'accordion_header_indicator_width',
        'type'    => 'unit',
        'label'   => __( 'Width', '__x__' ),
        'options' => array(
          'available_units' => array( 'px', 'em', 'rem' ),
          'valid_keywords'  => array( 'auto', 'calc' ),
          'fallback_value'  => 'auto',
          'ranges'          => array(
            'px'  => array( 'min' => 10,  'max' => 40,  'step' => 1    ),
            'em'  => array( 'min' => 0.5, 'max' => 2.5, 'step' => 0.25 ),
            'rem' => array( 'min' => 0.5, 'max' => 2.5, 'step' => 0.25 ),
          ),
        ),
      ),
      array(
        'key'     => 'accordion_header_indicator_height',
        'type'    => 'unit',
        'label'   => __( 'Height', '__x__' ),
        'options' => array(
          'available_units' => array( 'px', 'em', 'rem' ),
          'valid_keywords'  => array( 'calc' ),
          'fallback_value'  => '1em',
          'ranges'          => array(
            'px'  => array( 'min' => 10,  'max' => 40,  'step' => 1    ),
            'em'  => array( 'min' => 0.5, 'max' => 2.5, 'step' => 0.25 ),
            'rem' => array( 'min' => 0.5, 'max' => 2.5, 'step' => 0.25 ),
          ),
        ),
      ),
    ),
  );

  $control_accordion_header_indicator_rotation_start = array(
    'key'     => 'accordion_header_indicator_rotation_start',
    'type'    => 'unit',
    'label'   => __( 'Start Rotation', '__x__' ),
    'options' => $options_accordion_header_indicator_rotation,
  );

  $control_accordion_header_indicator_rotation_end = array(
    'key'     => 'accordion_header_indicator_rotation_end',
    'type'    => 'unit',
    'label'   => __( 'End Rotation', '__x__' ),
    'options' => $options_accordion_header_indicator_rotation,
  );

  $control_accordion_header_indicator_start_and_end_rotation = array(
    'type'     => 'group',
    'label'    => __( 'Start &amp; End Rotation', '__x__' ),
    'controls' => array(
      $control_accordion_header_indicator_rotation_start,
      $control_accordion_header_indicator_rotation_end,
    ),
  );

  $control_accordion_header_indicator_colors = array(
    'keys' => array(
      'value' => 'accordion_header_indicator_color',
      'alt'   => 'accordion_header_indicator_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Color', '__x__' ),
    'options' => cs_recall( 'options_base_interaction_labels' ),
  );

  $control_accordion_content_bg_color = array(
    'key'   => 'accordion_content_bg_color',
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        $control_accordion_items_sortable,
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'accordion:setup',
          'controls'   => array(
            $control_accordion_base_font_size,
            $control_accordion_width_and_max_width,
            $control_accordion_grouped,
            $control_accordion_group,
            $control_accordion_bg_color,
          ),
        ),

        cs_control( 'margin', 'accordion', array( 'group' => 'accordion:design' ) ),
        cs_control( 'padding', 'accordion', array( 'group' => 'accordion:design' ) ),
        cs_control( 'border', 'accordion', array( 'group' => 'accordion:design' ) ),
        cs_control( 'border-radius', 'accordion', array( 'group' => 'accordion:design' ) ),
        cs_control( 'box-shadow', 'accordion', array( 'group' => 'accordion:design' ) ),

        array(
          'type'       => 'group',
          'label'      => __( 'Item Setup', '__x__' ),
          'group'      => 'accordion_items:setup',
          'controls'   =>array(
            $control_accordion_item_overflow,
            $control_accordion_item_spacing,
            $control_accordion_item_bg_color,
          ),
        ),

        cs_control( 'padding', 'accordion_item', $settings_accordion_item_design ),
        cs_control( 'border', 'accordion_item', $settings_accordion_item_design ),
        cs_control( 'border-radius', 'accordion_item', $settings_accordion_item_design ),
        cs_control( 'box-shadow', 'accordion_item', $settings_accordion_item_design ),

        array(
          'type'       => 'group',
          'label'      => __( 'Header Setup', '__x__' ),
          'group'      => 'accordion_item_header:setup',
          'controls'   => array(
            $control_accordion_header_text_overflow,
            $control_accordion_header_indicator,
            $control_accordion_header_spacing_and_direction,
            $control_accordion_header_bg_colors,
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => __( 'Header Indicator Setup', '__x__' ),
          'group'      => 'accordion_item_header:setup',
          'condition'  => array( 'accordion_header_indicator' => true ),
          'controls'   => array(
            $control_accordion_header_indicator_type,
            $control_accordion_header_indicator_text_and_icon_and_font_size,
            $control_accordion_header_indicator_width_and_height,
            $control_accordion_header_indicator_start_and_end_rotation,
            $control_accordion_header_indicator_colors,
          ),
        ),

        cs_control( 'margin', 'accordion_header', $settings_accordion_header_design ),
        cs_control( 'padding', 'accordion_header', $settings_accordion_header_design ),
        cs_control( 'border', 'accordion_header', $settings_accordion_header_design ),
        cs_control( 'border-radius', 'accordion_header', $settings_accordion_header_design ),
        cs_control( 'box-shadow', 'accordion_header', $settings_accordion_header_design ),

        cs_control( 'text-format', 'accordion_header', $settings_accordion_header_text ),
        cs_control( 'text-shadow', 'accordion_header', $settings_accordion_header_text ),

        array(
          'type'       => 'group',
          'label'      => __( 'Content Setup', '__x__' ),
          'group'      => 'accordion_item_content:setup',
          'controls'   => array(
            $control_accordion_content_bg_color
          ),
        ),

        cs_control( 'margin', 'accordion_content', $settings_accordion_content_design ),
        cs_control( 'padding', 'accordion_content', $settings_accordion_content_design ),
        cs_control( 'border', 'accordion_content', $settings_accordion_content_design ),
        cs_control( 'border-radius', 'accordion_content', $settings_accordion_content_design ),

        cs_control( 'box_shadow', 'accordion_content', $settings_accordion_content_text ),
        cs_control( 'text-format', 'accordion_content', $settings_accordion_content_text ),
        cs_control( 'text-shadow', 'accordion_content', $settings_accordion_content_text )

      ),
      'controls_std_content' => array( $control_accordion_items_sortable ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            $control_accordion_base_font_size,
            cs_amend_control( $control_accordion_width, array( 'type' => 'unit-slider' ) ),
            cs_amend_control( $control_accordion_max_width, array( 'type' => 'unit-slider' ) ),
            $control_accordion_header_indicator_text,
            $control_accordion_header_indicator_icon,
            $control_accordion_header_indicator_start_and_end_rotation,
          ),
        ),
        cs_control( 'margin', 'accordion' )
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Base Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'      => array( 'value' => 'accordion_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'accordion_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_accordion_bg_color,
          ),
        ),

        cs_control( 'border', 'accordion',  array(
          'k_pre'     => 'accordion',
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'accordion_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'accordion_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) ),

        array(
          'type'       => 'group',
          'label'      => __( 'Item Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'      => array( 'value' => 'accordion_item_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'accordion_item_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_accordion_item_bg_color,
          ),
        ),

        cs_control( 'border', 'accordion_item', array_merge(
          $settings_accordion_item_design,
          array(
            'options'   => array( 'color_only' => true ),
            'conditions' => array(
              array( 'key' => 'accordion_item_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => 'accordion_item_border_style', 'op' => '!=', 'value' => 'none' )
            ),
          )
        ) ),

        array(
          'type'       => 'group',
          'label'      => __( 'Header Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys' => array(
                'value' => 'accordion_header_text_color',
                'alt'   => 'accordion_header_text_color_alt',
              ),
              'type'    => 'color',
              'label'   => __( 'Text', '__x__' ),
              'options' => cs_recall( 'options_base_interaction_labels' ),
            ),
            cs_amend_control( $control_accordion_header_indicator_colors, array( 'label' => __( 'Indicator', '__x__' ) ) ),
            array(
              'keys' => array(
                'value' => 'accordion_header_text_shadow_color',
                'alt'   => 'accordion_header_text_shadow_color_alt',
              ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'options'   => cs_recall( 'options_base_interaction_labels' ),
              'condition' => array( 'key' => 'accordion_header_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            array(
              'keys' => array(
                'value' => 'accordion_header_box_shadow_color',
                'alt'   => 'accordion_header_box_shadow_color_alt',
              ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'options'   => cs_recall( 'options_base_interaction_labels' ),
              'condition' => array( 'key' => 'accordion_header_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_accordion_header_bg_colors,
          ),
        ),

        cs_control( 'border', 'accordion_header', array_merge(
          $settings_accordion_header_design,
          array(
            'options'   => cs_recall( 'options_color_base_interaction_labels_color_only' ),
            'conditions' => array(
              array( 'key' => 'accordion_header_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => 'accordion_header_border_style', 'op' => '!=', 'value' => 'none' )
            ),
          )
        ) ),

        array(
          'type'       => 'group',
          'label'      => __( 'Content Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'  => array( 'value' => 'accordion_content_text_color' ),
              'type'  => 'color',
              'label' => __( 'Text', '__x__' ),
            ),
            array(
              'keys'      => array( 'value' => 'accordion_content_text_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'accordion_content_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            array(
              'keys'      => array( 'value' => 'accordion_content_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'accordion_content_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_accordion_content_bg_color,
          ),
        ),
        cs_control( 'border', 'accordion_content', array_merge(
          $settings_accordion_content_design,
          array(
            'options'   => array( 'color_only' => true ),
            'conditions' => array(
              array( 'key' => 'accordion_content_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => 'accordion_content_border_style', 'op' => '!=', 'value' => 'none' )
            ),
          )
        ) )
      ),
      'control_nav' => array(
        'accordion'                => __( 'Accordion', '__x__' ),
        'accordion:setup'          => __( 'Setup', '__x__' ),
        'accordion:design'         => __( 'Design', '__x__' ),

        'accordion_items'          => __( 'Items', '__x__' ),
        'accordion_items:setup'    => __( 'Setup', '__x__' ),
        'accordion_items:design'   => __( 'Design', '__x__' ),

        'accordion_item_header'         => __( 'Header', '__x__' ),
        'accordion_item_header:setup'   => __( 'Setup', '__x__' ),
        'accordion_item_header:design'  => __( 'Design', '__x__' ),
        'accordion_item_header:text'    => __( 'Text', '__x__' ),

        'accordion_item_content'        => __( 'Content', '__x__' ),
        'accordion_item_content:setup'  => __( 'Setup', '__x__' ),
        'accordion_item_content:design' => __( 'Design', '__x__' ),
        'accordion_item_content:text'   => __( 'Text', '__x__' ),
      ),
    ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'accordion', $data );
