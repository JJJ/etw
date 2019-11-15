<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/COUNTDOWN.PHP
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
    'countdown_end'                              => cs_value( 'TBD', 'markup' ),
    'countdown_base_font_size'                   => cs_value( '1em', 'style' ),
    'countdown_width'                            => cs_value( 'auto', 'style' ),
    'countdown_max_width'                        => cs_value( 'none', 'style' ),
    'countdown_bg_color'                         => cs_value( 'transparent', 'style:color' ),

    'countdown_units_display'                    => cs_value( 'd h m s', 'markup' ),
    'countdown_hide_on_end'                      => cs_value( false, 'markup' ),
    'countdown_hide_empty'                       => cs_value( false, 'markup' ),
    'countdown_leading_zeros'                    => cs_value( true, 'markup' ),
    'countdown_labels'                           => cs_value( true, 'all' ),
    'countdown_labels_output'                    => cs_value( 'compact', 'all' ),
    'countdown_aria_content'                     => cs_value( __( 'Countdown ends in {{d}} days, {{h}} hours, and {{m}} minutes.', '__x__' ), 'markup' ),

    'countdown_margin'                           => cs_value( '0em', 'style' ),
    'countdown_padding'                          => cs_value( '0em', 'style' ),
    'countdown_border_width'                     => cs_value( '0px', 'style' ),
    'countdown_border_style'                     => cs_value( 'none', 'style' ),
    'countdown_border_color'                     => cs_value( 'transparent', 'style:color' ),
    'countdown_border_radius'                    => cs_value( '0em', 'style' ),
    'countdown_box_shadow_dimensions'            => cs_value( '0em 0em 0em 0em', 'style' ),
    'countdown_box_shadow_color'                 => cs_value( 'transparent', 'style:color' ),

    'countdown_unit_width'                       => cs_value( 'auto', 'style' ),
    'countdown_unit_gap_column'                  => cs_value( '2rem', 'style' ),
    'countdown_unit_gap_row'                     => cs_value( '1rem', 'style' ),
    'countdown_unit_bg_color'                    => cs_value( 'transparent', 'style:color' ),
    'countdown_unit_padding'                     => cs_value( '0em', 'style' ),
    'countdown_unit_border_width'                => cs_value( '0px', 'style' ),
    'countdown_unit_border_style'                => cs_value( 'none', 'style' ),
    'countdown_unit_border_color'                => cs_value( 'transparent', 'style:color' ),
    'countdown_unit_border_radius'               => cs_value( '0em', 'style' ),
    'countdown_unit_box_shadow_dimensions'       => cs_value( '0em 0em 0em 0em', 'style' ),
    'countdown_unit_box_shadow_color'            => cs_value( 'transparent', 'style:color' ),

    'countdown_number_bg_color'                  => cs_value( 'transparent', 'style:color' ),
    'countdown_number_margin'                    => cs_value( '0em', 'style' ),
    'countdown_number_padding'                   => cs_value( '0em', 'style' ),
    'countdown_number_border_width'              => cs_value( '0px', 'style' ),
    'countdown_number_border_style'              => cs_value( 'none', 'style' ),
    'countdown_number_border_color'              => cs_value( 'transparent', 'style:color' ),
    'countdown_number_border_radius'             => cs_value( '0em', 'style' ),
    'countdown_number_box_shadow_dimensions'     => cs_value( '0em 0em 0em 0em', 'style' ),
    'countdown_number_box_shadow_color'          => cs_value( 'transparent', 'style:color' ),

    'countdown_digit_bg_color'                   => cs_value( 'transparent', 'style:color' ),
    'countdown_digit_margin'                     => cs_value( '0em', 'style' ),
    'countdown_digit_padding'                    => cs_value( '0em', 'style' ),
    'countdown_digit_border_width'               => cs_value( '0px', 'style' ),
    'countdown_digit_border_style'               => cs_value( 'none', 'style' ),
    'countdown_digit_border_color'               => cs_value( 'transparent', 'style:color' ),
    'countdown_digit_border_radius'              => cs_value( '0em', 'style' ),
    'countdown_digit_box_shadow_dimensions'      => cs_value( '0em 0em 0em 0em', 'style' ),
    'countdown_digit_box_shadow_color'           => cs_value( 'transparent', 'style:color' ),
    'countdown_digit_font_family'                => cs_value( 'inherit', 'style:font-family' ),
    'countdown_digit_font_weight'                => cs_value( 'inherit:700', 'style:font-weight' ),
    'countdown_digit_font_size'                  => cs_value( '3em', 'style' ),
    'countdown_digit_line_height'                => cs_value( '1', 'style' ),
    'countdown_digit_font_style'                 => cs_value( 'normal', 'style' ),
    'countdown_digit_text_align'                 => cs_value( 'center', 'style' ),
    'countdown_digit_text_decoration'            => cs_value( 'none', 'style' ),
    'countdown_digit_text_transform'             => cs_value( 'none', 'style' ),
    'countdown_digit_text_color'                 => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'countdown_digit_text_shadow_dimensions'     => cs_value( '0px 0px 0px', 'style' ),
    'countdown_digit_text_shadow_color'          => cs_value( 'transparent', 'style:color' ),

    'countdown_label_spacing'                    => cs_value( '0.1em', 'style' ),
    'countdown_label_font_family'                => cs_value( 'inherit', 'style:font-family' ),
    'countdown_label_font_weight'                => cs_value( 'inherit:400', 'style:font-weight' ),
    'countdown_label_font_size'                  => cs_value( '1.25em', 'style' ),
    'countdown_label_letter_spacing'             => cs_value( '0em', 'style' ),
    'countdown_label_line_height'                => cs_value( '1', 'style' ),
    'countdown_label_font_style'                 => cs_value( 'normal', 'style' ),
    'countdown_label_text_align'                 => cs_value( 'center', 'style' ),
    'countdown_label_text_decoration'            => cs_value( 'none', 'style' ),
    'countdown_label_text_transform'             => cs_value( 'none', 'style' ),
    'countdown_label_text_color'                 => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'countdown_label_text_shadow_dimensions'     => cs_value( '0px 0px 0px', 'style' ),
    'countdown_label_text_shadow_color'          => cs_value( 'transparent', 'style:color' ),

    'countdown_complete_content'                 => cs_value( 'Showtime!', 'markup' ),
    'countdown_complete_font_family'             => cs_value( 'inherit', 'style:font-family' ),
    'countdown_complete_font_weight'             => cs_value( 'inherit:400', 'style:font-weight' ),
    'countdown_complete_font_size'               => cs_value( '1em', 'style' ),
    'countdown_complete_letter_spacing'          => cs_value( '0em', 'style' ),
    'countdown_complete_line_height'             => cs_value( '1', 'style' ),
    'countdown_complete_font_style'              => cs_value( 'normal', 'style' ),
    'countdown_complete_text_align'              => cs_value( 'center', 'style' ),
    'countdown_complete_text_decoration'         => cs_value( 'none', 'style' ),
    'countdown_complete_text_transform'          => cs_value( 'none', 'style' ),
    'countdown_complete_text_color'              => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'countdown_complete_text_shadow_dimensions'  => cs_value( '0px 0px 0px', 'style' ),
    'countdown_complete_text_shadow_color'       => cs_value( 'transparent', 'style:color' ),

    'countdown_delimiter'                        => cs_value( false, 'style' ),
    'countdown_delimiter_content'                => cs_value( ':', 'style' ),
    'countdown_delimiter_vertical_adjustment'    => cs_value( '0em', 'style' ),
    'countdown_delimiter_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'countdown_delimiter_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'countdown_delimiter_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'countdown_delimiter_font_size'              => cs_value( '1em', 'style' ),
    'countdown_delimiter_text_shadow_dimensions' => cs_value( '0px 0px 0px', 'style' ),
    'countdown_delimiter_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ),
  'omega'
);

// Style
// =============================================================================

function x_element_style_countdown() {
  return x_get_view( 'styles/elements', 'countdown', 'css', array(), false );
}


// Render
// =============================================================================

function x_element_render_countdown( $data ) {
  return x_get_view( 'elements', 'countdown', '', $data, false );
}


// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Countdown', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_countdown',
  'style' => 'x_element_style_countdown',
  'render' => 'x_element_render_countdown',
  'icon' => 'native',
  'options' => array(
    'empty_preview_min_height' => 3
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_countdown() {

  // Individual Controls
  // -------------------

  $control_countdown_end = array(
    'key'   => 'countdown_end',
    'type'  => 'date-time',
    'label' => __( 'Countdown End', '__x__' ),
  );

  $control_countdown_base_font_size = array(
    'key'     => 'countdown_base_font_size',
    'type'    => 'unit-slider',
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

  $control_countdown_width = array(
    'key'     => 'countdown_width',
    'type'    => 'unit',
    'label'   => __( 'Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'fallback_value'  => 'auto',
      'valid_keywords'  => array( 'auto', 'calc' ),
      'ranges'          => array(
        'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
        'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
        'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
        '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
      ),
    ),
  );



  $control_countdown_max_width = array(
    'key'     => 'countdown_max_width',
    'type'    => 'unit',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'fallback_value'  => 'none',
      'valid_keywords'  => array( 'none', 'calc' ),
      'ranges'          => array(
        'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
        'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
        'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
        '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
      ),
    ),
  );

  $control_countdown_width_and_max_width = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Max Width', '__x__' ),
    'controls' => array(
      $control_countdown_width,
      $control_countdown_max_width,
    ),
  );

  $control_countdown_bg_color = array(
    'keys'  => array( 'value' => 'countdown_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_countdown_options = array(
    'keys' => array(
      'hide_on_end'   => 'countdown_hide_on_end',
      'hide_empty'    => 'countdown_hide_empty',
      'leading_zeros' => 'countdown_leading_zeros',
      'labels'        => 'countdown_labels',
    ),
    'type'    => 'checkbox-list',
    'label'   => __( 'Options', '__x__' ),
    'options' => array(
      'list' => array(
        array( 'key' => 'hide_on_end',   'label' => __( 'Hide on End', '__x__' ) ),
        array( 'key' => 'hide_empty',    'label' => __( 'Hide Empty', '__x__' ) ),
        array( 'key' => 'leading_zeros', 'label' => __( 'Leading Zero', '__x__' ) ),
        array( 'key' => 'labels',        'label' => __( 'Labels', '__x__' ) ),
      ),
    ),
  );

  $control_countdown_units_display = array(
    'key'     => 'countdown_units_display',
    'type'    => 'multi-choose',
    'label'   => __( 'Units Display', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'd', 'label' => __( 'Day', '__x__' ) ),
        array( 'value' => 'h', 'label' => __( 'Hour', '__x__' ) ),
        array( 'value' => 'm', 'label' => __( 'Min', '__x__' ) ),
        array( 'value' => 's', 'label' => __( 'Sec', '__x__' ) ),
      ),
    ),
  );

  $control_countdown_labels_output = array(
    'key'       => 'countdown_labels_output',
    'type'      => 'choose',
    'label'     => __( 'Labels Output', '__x__' ),
    'condition' => array( 'countdown_labels' => true ),
    'options'   => array(
      'choices' => array(
        array( 'value' => 'compact', 'label' => __( 'Compact', '__x__' ) ),
        array( 'value' => 'top',     'label' => __( 'Top', '__x__' ) ),
        array( 'value' => 'bottom',  'label' => __( 'Bottom', '__x__' ) ),
      ),
    ),
  );

  $control_countdown_aria_content = array(
    'key'   => 'countdown_aria_content',
    'type'  => 'text',
    'label' => __( 'ARIA Content', '__x__' ),
  );

  $control_countdown_unit_width = array(
    'key'     => 'countdown_unit_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'fallback_value'  => 'auto',
      'valid_keywords'  => array( 'auto', 'calc' ),
      'ranges'          => array(
        'px'  => array( 'min' => 100, 'max' => 250, 'step' => 1    ),
        'em'  => array( 'min' => 5,   'max' => 15,  'step' => 0.25 ),
        'rem' => array( 'min' => 5,   'max' => 15,  'step' => 0.25 ),
      ),
    ),
  );

  $control_countdown_unit_gap_column = array(
    'key'     => 'countdown_unit_gap_column',
    'type'    => 'unit-slider',
    'label'   => __( 'Column Gap', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '1rem',
      'ranges'          => array(
        'px'  => array( 'min' => 0, 'max' => 50,  'step' => 1   ),
        'em'  => array( 'min' => 0, 'max' => 2.5, 'step' => 0.1 ),
        'rem' => array( 'min' => 0, 'max' => 2.5, 'step' => 0.1 ),
        '%'   => array( 'min' => 0, 'max' => 15,  'step' => 0.5 ),
        'vw'  => array( 'min' => 0, 'max' => 15,  'step' => 0.5 ),
        'vh'  => array( 'min' => 0, 'max' => 15,  'step' => 0.5 ),
      ),
    ),
  );

  $control_countdown_unit_gap_row = array(
    'key'     => 'countdown_unit_gap_row',
    'type'    => 'unit-slider',
    'label'   => __( 'Row Gap', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '1rem',
      'ranges'          => array(
        'px'  => array( 'min' => 0, 'max' => 50,  'step' => 1   ),
        'em'  => array( 'min' => 0, 'max' => 2.5, 'step' => 0.1 ),
        'rem' => array( 'min' => 0, 'max' => 2.5, 'step' => 0.1 ),
        '%'   => array( 'min' => 0, 'max' => 15,  'step' => 0.5 ),
        'vw'  => array( 'min' => 0, 'max' => 15,  'step' => 0.5 ),
        'vh'  => array( 'min' => 0, 'max' => 15,  'step' => 0.5 ),
      ),
    ),
  );

  $control_countdown_unit_bg_color = array(
    'keys'  => array( 'value' => 'countdown_unit_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_countdown_number_bg_color = array(
    'keys'  => array( 'value' => 'countdown_number_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_countdown_digit_bg_color = array(
    'keys'  => array( 'value' => 'countdown_digit_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_countdown_label_spacing = array(
    'key'     => 'countdown_label_spacing',
    'type'    => 'unit-slider',
    'label'   => __( 'Label Spacing', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'fallback_value'  => '0.5em',
      'valid_keywords'  => array( 'calc' ),
      'ranges'          => array(
        'px'  => array( 'min' => 0, 'max' => 20, 'step' => 1   ),
        'em'  => array( 'min' => 0, 'max' => 1,  'step' => 0.1 ),
        'rem' => array( 'min' => 0, 'max' => 1,  'step' => 0.1 ),
      ),
    ),
  );

  $control_countdown_complete_content = array(
    'key'     => 'countdown_complete_content',
    'type'    => 'text-editor',
    'label'   => __( 'Content', '__x__' ),
    'options' => array(
      'height'                => 1,
      'disable_input_preview' => false,
    ),
  );

  $control_countdown_delimiter = array(
    'key'     => 'countdown_delimiter',
    'type'    => 'choose',
    'label'   => __( 'Enable', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_countdown_delimiter_content = array(
    'key'        => 'countdown_delimiter_content',
    'type'       => 'choose',
    'label'      => __( 'Delimiter', '__x__' ),
    'condition'  => array( 'countdown_delimiter' => true ),
    'options'    => array(
      'choices' => array(
        array( 'value' => ':', 'label' => ':' ),
        array( 'value' => '/', 'label' => '/' ),
        array( 'value' => '|', 'label' => '|' ),
        array( 'value' => '•', 'label' => '•' ),
      ),
    ),
  );

  $control_countdown_vertical_adjustment = array(
    'key'     => 'countdown_delimiter_vertical_adjustment',
    'type'    => 'unit-slider',
    'label'   => __( 'Vertical Adjustment', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'fallback_value'  => '0em',
      'valid_keywords'  => array( 'calc' ),
      'ranges'          => array(
        'px'  => array( 'min' => -25, 'max' => 25, 'step' => 1   ),
        'em'  => array( 'min' => -1,  'max' => 1,  'step' => 0.1 ),
        'rem' => array( 'min' => -1,  'max' => 1,  'step' => 0.1 ),
      ),
    ),
  );

  $control_countdown_delimiter_text_color = array(
    'keys'  => array( 'value' => 'countdown_delimiter_text_color' ),
    'type'  => 'color',
    'label' => __( 'Color', '__x__' ),
  );

  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'countdown:setup',
          'controls'   => array(
            $control_countdown_end,
            $control_countdown_base_font_size,
            $control_countdown_width_and_max_width,
            $control_countdown_bg_color,
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => __( 'Format', '__x__' ),
          'group'      => 'countdown:setup',
          'controls'   => array(
            $control_countdown_units_display,
            $control_countdown_options,
            $control_countdown_labels_output,
            $control_countdown_aria_content,
          ),
        ),

        cs_control( 'margin', 'countdown', array( 'group' => 'countdown:design' ) ),
        cs_control( 'padding', 'countdown', array( 'group' => 'countdown:design' ) ),
        cs_control( 'border', 'countdown', array( 'group' => 'countdown:design' ) ),
        cs_control( 'border-radius', 'countdown', array( 'group' => 'countdown:design' ) ),
        cs_control( 'box-shadow', 'countdown', array( 'group' => 'countdown:design' ) ),

        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'countdown_unit:setup',
          'controls'   => array(
            $control_countdown_unit_width,
            $control_countdown_unit_gap_column,
            $control_countdown_unit_gap_row,
            $control_countdown_unit_bg_color,
          ),
        ),

        cs_control( 'padding', 'countdown_unit', array( 'group' => 'countdown_unit:design' ) ),
        cs_control( 'border', 'countdown_unit', array( 'group' => 'countdown_unit:design' ) ),
        cs_control( 'border-radius', 'countdown_unit', array( 'group' => 'countdown_unit:design' ) ),
        cs_control( 'box-shadow', 'countdown_unit', array( 'group' => 'countdown_unit:design' ) ),

        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'countdown_number:setup',
          'controls'   => array(
            $control_countdown_number_bg_color,
          ),
        ),

        cs_control( 'margin', 'countdown_number', array( 'group' => 'countdown_number:design' ) ),
        cs_control( 'padding', 'countdown_number', array( 'group' => 'countdown_number:design' ) ),
        cs_control( 'border', 'countdown_number', array( 'group' => 'countdown_number:design' ) ),
        cs_control( 'border-radius', 'countdown_number', array( 'group' => 'countdown_number:design' ) ),
        cs_control( 'box-shadow', 'countdown_number', array( 'group' => 'countdown_number:design' ) ),

        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'countdown_digit:setup',
          'controls'   => array(
            $control_countdown_digit_bg_color,
          ),
        ),

        cs_control( 'margin', 'countdown_digit', array( 'group' => 'countdown_digit:design' ) ),
        cs_control( 'padding', 'countdown_digit', array( 'group' => 'countdown_digit:design' ) ),
        cs_control( 'border', 'countdown_digit', array( 'group' => 'countdown_digit:design' ) ),
        cs_control( 'border-radius', 'countdown_digit', array( 'group' => 'countdown_digit:design' ) ),
        cs_control( 'box-shadow', 'countdown_digit', array( 'group' => 'countdown_digit:design' ) ),
        cs_control( 'text-format', 'countdown_digit', array( 'group' => 'countdown_digit:text', 'no_letter_spacing' => true, ) ),
        cs_control( 'text-shadow', 'countdown_digit', array( 'group' => 'countdown_digit:text' ) ),

        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'countdown_label:setup',
          'controls'   => array(
            $control_countdown_label_spacing,
          ),
        ),

        cs_control( 'text-format', 'countdown_label', array( 'group' => 'countdown_label:text' ) ),
        cs_control( 'text-shadow', 'countdown_label', array( 'group' => 'countdown_label:text' ) ),

        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'countdown_complete:setup',
          'controls'   => array(
            $control_countdown_complete_content,
          ),
        ),

        cs_control( 'text-format', 'countdown_complete', array( 'group' => 'countdown_complete:text' ) ),
        cs_control( 'text-shadow', 'countdown_complete', array( 'group' => 'countdown_complete:text' ) ),

        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'countdown_delimiter:setup',
          'controls'   => array(
            $control_countdown_delimiter,
            $control_countdown_delimiter_content,
            $control_countdown_vertical_adjustment,
            $control_countdown_delimiter_text_color,
          ),
        ),

        cs_control( 'text-format', 'countdown_delimiter', array(
          'group'              => 'countdown_delimiter:text',
          'conditions'         => array( array( 'countdown_delimiter' => true ) ),
          'no_font_style'      => true,
          'no_letter_spacing'  => true,
          'no_line_height'     => true,
          'no_text_align'      => true,
          'no_text_decoration' => true,
          'no_text_transform'  => true,
        ) ),
        cs_control( 'text-shadow', 'countdown_delimiter', array(
          'group'              => 'countdown_delimiter:text',
          'conditions'         => array( array( 'countdown_delimiter' => true ) ),
        ) )
      ),
      'controls_std_content' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Content Setup', '__x__' ),
          'controls'   => array(
            $control_countdown_end,
            cs_amend_control(
              $control_countdown_complete_content,
              array( 'label' => __( 'Complete Message', '__x__' ) )
            )
          ),
        ),
      ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            $control_countdown_base_font_size,
            cs_amend_control( $control_countdown_width, array( 'type' => 'unit-slider' ) ),
            cs_amend_control( $control_countdown_max_width, array( 'type' => 'unit-slider' ) )
          ),
        ),
        cs_control( 'margin', 'countdown', array( 'label_prefix' => __( 'Countdown', '__x__' ) ) )
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Base Colors', '__x__' ),
          'controls'   => array(
            $control_countdown_bg_color
          ),
        ),
      ),
      'control_nav' => array(
        'countdown'                 => __( 'Countdown', '__x__' ),
        'countdown:setup'           => __( 'Setup', '__x__' ),
        'countdown:design'          => __( 'Design', '__x__' ),

        'countdown_unit'            => __( 'Unit', '__x__' ),
        'countdown_unit:setup'      => __( 'Setup', '__x__' ),
        'countdown_unit:design'     => __( 'Design', '__x__' ),

        'countdown_number'          => __( 'Number', '__x__' ),
        'countdown_number:setup'    => __( 'Setup', '__x__' ),
        'countdown_number:design'   => __( 'Design', '__x__' ),

        'countdown_digit'           => __( 'Digit', '__x__' ),
        'countdown_digit:setup'     => __( 'Setup', '__x__' ),
        'countdown_digit:design'    => __( 'Design', '__x__' ),
        'countdown_digit:text'      => __( 'Text', '__x__' ),

        'countdown_label'           => __( 'Label', '__x__' ),
        'countdown_label:setup'     => __( 'Setup', '__x__' ),
        'countdown_label:text'      => __( 'Text', '__x__' ),

        'countdown_complete'        => __( 'Complete', '__x__' ),
        'countdown_complete:setup'  => __( 'Setup', '__x__' ),
        'countdown_complete:text'   => __( 'Text', '__x__' ),

        'countdown_delimiter'       => __( 'Delimiter', '__x__' ),
        'countdown_delimiter:setup' => __( 'Setup', '__x__' ),
        'countdown_delimiter:text'  => __( 'Text', '__x__' ),
      )
    ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'countdown', $data );
