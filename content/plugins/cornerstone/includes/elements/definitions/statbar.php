<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/STATBAR.PHP
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
    'statbar_base_font_size'               => cs_value( '1em', 'style' ),
    'statbar_direction'                    => cs_value( 'row', 'style' ),
    'statbar_width_row'                    => cs_value( '100%', 'style' ),
    'statbar_max_width_row'                => cs_value( 'none', 'style' ),
    'statbar_height_row'                   => cs_value( '2em', 'style' ),
    'statbar_max_height_row'               => cs_value( 'none', 'style' ),
    'statbar_width_column'                 => cs_value( '2em', 'style' ),
    'statbar_max_width_column'             => cs_value( 'none', 'style' ),
    'statbar_height_column'                => cs_value( '18em', 'style' ),
    'statbar_max_height_column'            => cs_value( 'none', 'style' ),
    'statbar_bg_color'                     => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'statbar_trigger_offset'               => cs_value( '50%', 'style' ),

    'statbar_margin'                       => cs_value( '0em 0em 0em 0em', 'style' ),
    'statbar_padding'                      => cs_value( '0em 0em 0em 0em', 'style' ),
    'statbar_border_width'                 => cs_value( '0px', 'style' ),
    'statbar_border_style'                 => cs_value( 'none', 'style' ),
    'statbar_border_color'                 => cs_value( 'transparent', 'style:color' ),
    'statbar_border_radius'                => cs_value( '3px 3px 3px 3px', 'style' ),
    'statbar_box_shadow_dimensions'        => cs_value( '0em 0em 0em 0em', 'style' ),
    'statbar_box_shadow_color'             => cs_value( 'transparent', 'style:color' ),

    'statbar_bar_length'                   => cs_value( '92%', 'all', true ),
    'statbar_bar_bg_color'                 => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'statbar_bar_border_radius'            => cs_value( '3px 3px 3px 3px', 'style' ),
    'statbar_bar_box_shadow_dimensions'    => cs_value( '0em 0em 0em 0em', 'style' ),
    'statbar_bar_box_shadow_color'         => cs_value( 'transparent', 'style:color' ),

    'statbar_label'                        => cs_value( true, 'all' ),
    'statbar_label_custom_text'            => cs_value( false, 'markup' ),
    'statbar_label_always_show'            => cs_value( false, 'markup' ),
    'statbar_label_text_content'           => cs_value( __( 'HTML &amp; CSS', '__x__' ), 'markup', true ),
    'statbar_label_justify'                => cs_value( 'flex-end', 'all' ),
    'statbar_label_bg_color'               => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'statbar_label_width'                  => cs_value( 'auto', 'style' ),
    'statbar_label_height'                 => cs_value( 'auto', 'style' ),
    'statbar_label_translate_x'            => cs_value( '-0.5em', 'style' ),
    'statbar_label_translate_y'            => cs_value( '0em', 'style' ),

    'statbar_label_padding'                => cs_value( '0.35em 0.5em 0.35em 0.5em', 'style' ),
    'statbar_label_border_width'           => cs_value( '0px', 'style' ),
    'statbar_label_border_style'           => cs_value( 'none', 'style' ),
    'statbar_label_border_color'           => cs_value( 'transparent', 'style:color' ),
    'statbar_label_border_radius'          => cs_value( '2px 2px 2px 2px', 'style' ),
    'statbar_label_box_shadow_dimensions'  => cs_value( '0em 0em 0em 0em', 'style' ),
    'statbar_label_box_shadow_color'       => cs_value( 'transparent', 'style:color' ),

    'statbar_label_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'statbar_label_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'statbar_label_font_size'              => cs_value( '0.75em', 'style' ),
    'statbar_label_letter_spacing'         => cs_value( '0em', 'style' ),
    'statbar_label_line_height'            => cs_value( '1', 'style' ),
    'statbar_label_font_style'             => cs_value( 'normal', 'style' ),
    'statbar_label_text_align'             => cs_value( 'none', 'style' ),
    'statbar_label_text_decoration'        => cs_value( 'none', 'style' ),
    'statbar_label_text_transform'         => cs_value( 'none', 'style' ),
    'statbar_label_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'statbar_label_text_shadow_dimensions' => cs_value( '0px 0px 0px', 'style' ),
    'statbar_label_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),

  ),
  'omega'
);


// Style
// =============================================================================

function x_element_style_statbar() {
  return x_get_view( 'styles/elements', 'statbar', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_statbar( $data ) {
  return x_get_view( 'elements', 'statbar', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Statbar', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_statbar',
  'style' => 'x_element_style_statbar',
  'render' => 'x_element_render_statbar',
  'icon' => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_statbar() {


  // Options
  // -------

  $options_statbar_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
    'fallback_value'  => 'auto',
    'valid_keywords'  => array( 'auto', 'calc' ),
    'ranges'          => array(
      'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
      'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
      'vw'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
      'vh'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    ),
  );

  $options_statbar_max_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
    'fallback_value'  => 'none',
    'valid_keywords'  => array( 'none', 'calc' ),
    'ranges'          => array(
      'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
      'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
      'vw'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
      'vh'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    ),
  );


  $options_statbar_label_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'auto', 'calc' ),
    'fallback_value'  => 'auto',
    'ranges'          => array(
      'px'  => array( 'min' => 25,  'max' => 50, 'step' => 1    ),
      'em'  => array( 'min' => 1.5, 'max' => 5,  'step' => 0.25 ),
      'rem' => array( 'min' => 1.5, 'max' => 5,  'step' => 0.25 ),
    ),
  );

  $options_statbar_label_translate = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '0px',
    'ranges'          => array(
      'px'  => array( 'min' => -50,  'max' => 50,  'step' => 1    ),
      'em'  => array( 'min' => -2.5, 'max' => 2.5, 'step' => 0.25 ),
      'rem' => array( 'min' => -2.5, 'max' => 2.5, 'step' => 0.25 ),
      '%'   => array( 'min' => -100, 'max' => 100, 'step' => 1    ),
    ),
  );

  // Conditions
  // ----------

  $condition_statbar_row = array( array( 'key' => 'statbar_direction', 'op' => 'NOT IN', 'value' => array( 'column', 'column-reverse' ) ) );
  $condition_statbar_column = array( array( 'key' => 'statbar_direction', 'op' => 'NOT IN', 'value' => array( 'row', 'row-reverse' ) ) );

  // Individual Controls
  // -------------------

  $control_statbar_base_font_size = array(
    'key'     => 'statbar_base_font_size',
    'type'    => 'unit',
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



  $control_statbar_direction = array(
    'key'     => 'statbar_direction',
    'type'    => 'select',
    'label'   => __( 'Direction', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'column-reverse', 'label' => __( 'Up', '__x__' )    ),
        array( 'value' => 'column',         'label' => __( 'Down', '__x__' )  ),
        array( 'value' => 'row-reverse',    'label' => __( 'Left', '__x__' )  ),
        array( 'value' => 'row',            'label' => __( 'Right', '__x__' ) ),
      ),
    ),
  );

  $control_statbar_base_font_size_and_direction = array(
    'type'     => 'group',
    'label'    => __( 'Font Size &amp; Direction', '__x__' ),
    'controls' => array(
      $control_statbar_base_font_size,
      $control_statbar_direction,
    ),
  );

  $control_statbar_width_row = array(
    'key'        => 'statbar_width_row',
    'type'       => 'unit',
    'label'      => __( 'Width', '__x__' ),
    'conditions' => $condition_statbar_row,
    'options'    => $options_statbar_width_and_height,
  );

  $control_statbar_height_row = array(
    'key'        => 'statbar_height_row',
    'type'       => 'unit',
    'label'      => __( 'Height', '__x__' ),
    'conditions' => $condition_statbar_row,
    'options'    => $options_statbar_width_and_height,
  );

  $control_statbar_width_row_and_height_row = array(
    'type'       => 'group',
    'label'      => __( 'Width &amp; Height', '__x__' ),
    'conditions' => $condition_statbar_row,
    'controls'   => array(
      $control_statbar_width_row,
      $control_statbar_height_row,
    ),
  );

  $control_statbar_max_width_row = array(
    'key'        => 'statbar_max_width_row',
    'type'       => 'unit',
    'label'      => __( 'Max Width', '__x__' ),
    'conditions' => $condition_statbar_row,
    'options'    => $options_statbar_max_width_and_height,
  );

  $control_statbar_max_height_row = array(
    'key'        => 'statbar_max_height_row',
    'type'       => 'unit',
    'label'      => __( 'Max Height', '__x__' ),
    'conditions' => $condition_statbar_row,
    'options'    => $options_statbar_max_width_and_height,
  );

  $control_statbar_max_width_row_and_max_height_row = array(
    'type'       => 'group',
    'label'      => __( 'Max Width &amp; Height', '__x__' ),
    'conditions' => $condition_statbar_row,
    'controls'   => array(
      $control_statbar_max_width_row,
      $control_statbar_max_height_row,
    ),
  );

  $control_statbar_width_column = array(
    'key'        => 'statbar_width_column',
    'type'       => 'unit',
    'label'      => __( 'Width', '__x__' ),
    'conditions' => $condition_statbar_column,
    'options'    => $options_statbar_width_and_height,
  );

  $control_statbar_height_column = array(
    'key'        => 'statbar_height_column',
    'type'       => 'unit',
    'label'      => __( 'Height', '__x__' ),
    'conditions' => $condition_statbar_column,
    'options'    => $options_statbar_width_and_height,
  );

  $control_statbar_width_column_and_height_column = array(
    'type'       => 'group',
    'label'      => __( 'Width &amp; Height', '__x__' ),
    'conditions' => $condition_statbar_column,
    'controls'   => array(
      $control_statbar_width_column,
      $control_statbar_height_column,
    ),
  );

  $control_statbar_max_width_column = array(
    'key'        => 'statbar_max_width_column',
    'type'       => 'unit',
    'label'      => __( 'Max Width', '__x__' ),
    'conditions' => $condition_statbar_column,
    'options'    => $options_statbar_max_width_and_height,
  );

  $control_statbar_max_height_column = array(
    'key'        => 'statbar_max_height_column',
    'type'       => 'unit',
    'label'      => __( 'Max Height', '__x__' ),
    'conditions' => $condition_statbar_column,
    'options'    => $options_statbar_max_width_and_height,
  );

  $control_statbar_max_width_column_and_max_height_column = array(
    'type'       => 'group',
    'label'      => __( 'Max Width &amp; Height', '__x__' ),
    'conditions' => $condition_statbar_column,
    'controls'   => array(
      $control_statbar_max_width_column,
      $control_statbar_max_height_column,
    ),
  );

  $control_statbar_trigger_offset = array(
    'key'     => 'statbar_trigger_offset',
    'type'    => 'unit-slider',
    'label'   => __( 'Offset Trigger', '__x__' ),
    'options' => array(
      'available_units' => array( '%' ),
      'fallback_value'  => '75%',
      'ranges'          => array(
        '%' => array( 'min' => 0, 'max' => 100, 'step' => 1 ),
      ),
    ),
  );

  $control_statbar_bg_color = array(
    'keys'  => array( 'value' => 'statbar_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_statbar_bar_length = array(
    'key'     => 'statbar_bar_length',
    'type'    => 'unit-slider',
    'label'   => __( 'Length', '__x__' ),
    'options' => array(
      'available_units' => array( '%' ),
      'fallback_value'  => '90%',
      'ranges'          => array(
        '%' => array( 'min' => 0, 'max' => 100, 'step' => 1 ),
      ),
    ),
  );

  $control_statbar_bar_bg_color = array(
    'keys'  => array( 'value' => 'statbar_bar_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_statbar_label = array(
    'key'     => 'statbar_label',
    'type'    => 'choose',
    'label'   => __( 'Enable', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_statbar_label_options = array(
    'keys' => array(
      'label_custom_text' => 'statbar_label_custom_text',
      'label_always_show' => 'statbar_label_always_show',
    ),
    'type'    => 'checkbox-list',
    'label'   => __( 'Options', '__x__' ),
    'options' => array(
      'list' => array(
        array( 'key' => 'label_custom_text', 'label' => __( 'Custom Text', '__x__' ) ),
        array( 'key' => 'label_always_show', 'label' => __( 'Always Show', '__x__' ) ),
      ),
    ),
  );

  $control_statbar_label_text_content = array(
    'key'        => 'statbar_label_text_content',
    'type'       => 'text',
    'label'      => __( 'Content', '__x__' ),
    'conditions' => array( array( 'statbar_label' => true ), array( 'statbar_label_custom_text' => true ) ),
  );

  $control_statbar_label_justify = array(
    'key'       => 'statbar_label_justify',
    'type'      => 'choose',
    'label'     => __( 'Justify', '__x__' ),
    'condition' => array( 'statbar_label' => true ),
    'options'   => array(
      'choices' => array(
        array( 'value' => 'flex-start', 'label' => __( 'Start', '__x__' ) ),
        array( 'value' => 'center',     'label' => __( 'Center', '__x__' ) ),
        array( 'value' => 'flex-end',   'label' => __( 'End', '__x__' ) ),
      ),
    ),
  );

  $control_statbar_label_bg_color = array(
    'key'       => 'statbar_label_bg_color',
    'type'      => 'color',
    'label'     => __( 'Background', '__x__' ),
    'condition' => array( 'statbar_label' => true )
  );

  $control_statbar_label_width = array(
    'key'     => 'statbar_label_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Width', '__x__' ),
    'options' => $options_statbar_label_width_and_height,
  );

  $control_statbar_label_height = array(
    'key'     => 'statbar_label_height',
    'type'    => 'unit-slider',
    'label'   => __( 'Height', '__x__' ),
    'options' => $options_statbar_label_width_and_height,
  );

  $control_statbar_label_translate_x = array(
    'key'     => 'statbar_label_translate_x',
    'type'    => 'unit-slider',
    'label'   => __( 'Translate<br>X Axis', '__x__' ),
    'options' => $options_statbar_label_translate,
  );

  $control_statbar_label_translate_y = array(
    'key'     => 'statbar_label_translate_y',
    'type'    => 'unit-slider',
    'label'   => __( 'Translate<br>Y Axis', '__x__' ),
    'options' => $options_statbar_label_translate,
  );

  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'statbar:setup',
          'controls'   => array(
            $control_statbar_base_font_size_and_direction,
            $control_statbar_width_row_and_height_row,
            $control_statbar_max_width_row_and_max_height_row,
            $control_statbar_width_column_and_height_column,
            $control_statbar_max_width_column_and_max_height_column,
            $control_statbar_trigger_offset,
            $control_statbar_bg_color,
          ),
        ),

        cs_control( 'margin', 'statbar', array( 'group' => 'statbar:design' ) ),
        cs_control( 'padding', 'statbar', array( 'group' => 'statbar:design' ) ),
        cs_control( 'border', 'statbar', array( 'group' => 'statbar:design' ) ),
        cs_control( 'border-radius', 'statbar', array( 'group' => 'statbar:design' ) ),
        cs_control( 'box-shadow', 'statbar', array( 'group' => 'statbar:design' ) ),

        array(
          'type'       => 'group',
          'label'      => __( 'Bar Setup', '__x__' ),
          'group'      => 'statbar_bar:setup',
          'controls'   => array(
            $control_statbar_bar_length,
            $control_statbar_bar_bg_color,
          ),
        ),

        cs_control( 'border-radius', 'statbar_bar', array( 'group' => 'statbar_bar:design' ) ),
        cs_control( 'box-shadow', 'statbar_bar', array( 'group' => 'statbar_bar:design' ) ),

        array(
          'type'       => 'group',
          'label'      => __( 'Label Setup', '__x__' ),
          'group'      => 'statbar_label:setup',
          'controls'   => array(
            $control_statbar_label,
            $control_statbar_label_options,
            $control_statbar_label_text_content,
            $control_statbar_label_justify,
            $control_statbar_label_bg_color
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => __( 'Label Dimensions &amp; Position', '__x__' ),
          'group'      => 'statbar_label:setup',
          'controls'   => array(
            $control_statbar_label_width,
            $control_statbar_label_height,
            $control_statbar_label_translate_x,
            $control_statbar_label_translate_y,
          ),
        ),

        cs_control( 'padding', 'statbar_label', array( 'group' => 'statbar_label:design', 'conditions' => array( array( 'statbar_label' => true ) ) ) ),
        cs_control( 'border', 'statbar_label', array( 'group' => 'statbar_label:design', 'conditions' => array( array( 'statbar_label' => true ) ) ) ),
        cs_control( 'border-radius', 'statbar_label', array( 'group' => 'statbar_label:design', 'conditions' => array( array( 'statbar_label' => true ) ) ) ),
        cs_control( 'box-shadow', 'statbar_label', array( 'group' => 'statbar_label:design', 'conditions' => array( array( 'statbar_label' => true ) ) ) ),

        cs_control( 'text-format', 'statbar_label', array( 'group' => 'statbar_label:text', 'conditions' => array( array( 'statbar_label' => true ) ) ) ),
        cs_control( 'text-shadow', 'statbar_label', array( 'group' => 'statbar_label:text', 'conditions' => array( array( 'statbar_label' => true ) ) ) )

      ),
      'controls_std_content' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Content Setup', '__x__' ),
          'controls'   => array(
            cs_amend_control( $control_statbar_label_options, array( 'label' => __( 'Label', '__x__' ) ) ),
            $control_statbar_label_text_content,
          ),
        )
      ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            cs_amend_control( $control_statbar_base_font_size, array( 'type' => 'unit-slider' ) ),
            $control_statbar_direction,
            $control_statbar_width_row_and_height_row,
            $control_statbar_max_width_row_and_max_height_row,
            $control_statbar_width_column_and_height_column,
            $control_statbar_max_width_column_and_max_height_column,
            $control_statbar_trigger_offset,
          ),
        ),

        cs_control( 'margin', 'statbar' ),

        array(
          'type'       => 'group',
          'label'      => __( 'Bar and Label Design Setup', '__x__' ),
          'controls'   => array(
            cs_amend_control( $control_statbar_bar_length, array( 'label' => __( 'Bar<br>Length', '__x__' ) ) ),
            array(
              'key'     => 'statbar_label_font_size',
              'type'    => 'unit-slider',
              'label'   => __( 'Label<br>Font Size', '__x__' ),
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
            ),
            array(
              'type'     => 'group',
              'label'    => __( 'Label Width &amp; Height', '__x__' ),
              'controls' => array(
                cs_amend_control( $control_statbar_label_width, array( 'type'  => 'unit', 'label' => __( 'Label<br>Width', '__x__' ) ) ),
                cs_amend_control( $control_statbar_label_height, array( 'type'  => 'unit', 'label' => __( 'Label<br>Height', '__x__' ) ) ),
              ),
            ),
            cs_amend_control( $control_statbar_label_translate_x, array( 'label' => __( 'Label X Axis<br>Translate', '__x__' ) ) ),
            cs_amend_control( $control_statbar_label_translate_y, array( 'label' => __( 'Label Y Axis<br>Translate', '__x__' ) ) )
          ),
        )
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Base Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'      => array( 'value' => 'statbar_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'statbar_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_statbar_bg_color,
          ),
        ),

        cs_control( 'border', 'statbar', array(
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'statbar_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'statbar_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) ),

        array(
          'type'       => 'group',
          'label'      => __( 'Bar Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'      => array( 'value' => 'statbar_bar_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'statbar_bar_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_statbar_bar_bg_color,
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => __( 'Label Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'  => array( 'value' => 'statbar_label_text_color' ),
              'type'  => 'color',
              'label' => __( 'Text', '__x__' ),
            ),
            array(
              'keys'      => array( 'value' => 'statbar_label_text_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'statbar_label_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            array(
              'keys'      => array( 'value' => 'statbar_label_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'statbar_label_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_statbar_label_bg_color,
          ),
        ),

        cs_control( 'border', 'statbar_label', array(
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'statbar_label_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'statbar_label_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) )
      ),
      'control_nav' => array(

        'statbar'              => __( 'Statbar', '__x__' ),
        'statbar:setup'        => __( 'Setup', '__x__' ),
        'statbar:design'       => __( 'Design', '__x__' ),

        'statbar_bar'          => __( 'Bar', '__x__' ),
        'statbar_bar:setup'    => __( 'Setup', '__x__' ),
        'statbar_bar:design'   => __( 'Design', '__x__' ),

        'statbar_label'        => __( 'Label', '__x__' ),
        'statbar_label:setup'  => __( 'Setup', '__x__' ),
        'statbar_label:design' => __( 'Design', '__x__' ),
        'statbar_label:text'   => __( 'Text', '__x__' ),

      )
    ),
    cs_partial_controls( 'omega' )
  );

}



// Register Module
// =============================================================================

cs_register_element( 'statbar', $data );
