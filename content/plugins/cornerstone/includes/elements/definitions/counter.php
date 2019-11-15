<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/COUNTER.PHP
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

    'counter_base_font_size'                      => cs_value( '1em', 'style' ),
    'counter_width'                               => cs_value( 'auto', 'style' ),
    'counter_max_width'                           => cs_value( 'none', 'style' ),
    'counter_start'                               => cs_value( '0', 'markup', true ),
    'counter_end'                                 => cs_value( '100', 'markup', true ),
    'counter_number_prefix_content'               => cs_value( '', 'markup', true ),
    'counter_number_suffix_content'               => cs_value( '', 'markup', true ),
    'counter_duration'                            => cs_value( '1.5s', 'markup' ),
    'counter_before_after'                        => cs_value( false, 'all' ),
    'counter_before_content'                      => cs_value( '', 'markup', true ),
    'counter_after_content'                       => cs_value( '', 'markup', true ),

    'counter_margin'                              => cs_value( '0em', 'style' ),

    'counter_number_margin'                       => cs_value( '0em', 'style' ),
    'counter_number_font_family'                  => cs_value( 'inherit', 'style:font-family' ),
    'counter_number_font_weight'                  => cs_value( 'inherit:400', 'style:font-weight' ),
    'counter_number_font_size'                    => cs_value( '1em', 'style' ),
    'counter_number_letter_spacing'               => cs_value( '0em', 'style' ),
    'counter_number_line_height'                  => cs_value( '1', 'style' ),
    'counter_number_font_style'                   => cs_value( 'normal', 'style' ),
    'counter_number_text_align'                   => cs_value( 'none', 'style' ),
    'counter_number_text_decoration'              => cs_value( 'none', 'style' ),
    'counter_number_text_transform'               => cs_value( 'none', 'style' ),
    'counter_number_text_color'                   => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'counter_number_text_shadow_dimensions'       => cs_value( '0px 0px 0px', 'style' ),
    'counter_number_text_shadow_color'            => cs_value( 'transparent', 'style:color' ),

    'counter_before_after_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'counter_before_after_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'counter_before_after_font_size'              => cs_value( '1em', 'style' ),
    'counter_before_after_letter_spacing'         => cs_value( '0em', 'style' ),
    'counter_before_after_line_height'            => cs_value( '1', 'style' ),
    'counter_before_after_font_style'             => cs_value( 'normal', 'style' ),
    'counter_before_after_text_align'             => cs_value( 'none', 'style' ),
    'counter_before_after_text_decoration'        => cs_value( 'none', 'style' ),
    'counter_before_after_text_transform'         => cs_value( 'none', 'style' ),
    'counter_before_after_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'counter_before_after_text_shadow_dimensions' => cs_value( '0px 0px 0px', 'style' ),
    'counter_before_after_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),

  ),
  'omega'
);

// Style
// =============================================================================

function x_element_style_counter() {
  return x_get_view( 'styles/elements', 'counter', 'css', array(), false );
}


// Render
// =============================================================================

function x_element_render_counter( $data ) {
  return x_get_view( 'elements', 'counter', '', $data, false );
}


// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Counter', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_counter',
  'style' => 'x_element_style_counter',
  'render' => 'x_element_render_counter',
  'icon' => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_counter() {

  // Options
  // -------

  $options_counter_number_margin_tb = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'fallback_value'  => '10px',
    'valid_keywords'  => array( 'calc' ),
    'ranges'          => array(
      'px'  => array( 'min' => 0, 'max' => 32, 'step' => 1   ),
      'em'  => array( 'min' => 0, 'max' => 3,  'step' => 0.1 ),
      'rem' => array( 'min' => 0, 'max' => 3,  'step' => 0.1 ),
    ),
  );

  $options_counter_number_margin_lr = array(
    'disabled'       => true,
    'fallback_value' => '0px',
  );

  $options_counter_number_margin = array(
    'top'    => $options_counter_number_margin_tb,
    'left'   => $options_counter_number_margin_lr,
    'right'  => $options_counter_number_margin_lr,
    'bottom' => $options_counter_number_margin_tb,
  );


  // Settings
  // --------

  $settings_counter = array(
    'label_prefix' => __( 'Counter', '__x__' ),
    'group'        => 'counter:design',
  );

  $settings_counter_number = array(
    'label_prefix' => __( 'Number', '__x__' ),
    'group'        => 'counter:number',
  );

  $settings_counter_before_after = array(
    'label_prefix' => __( 'Before &amp; After', '__x__' ),
    'group'        => 'counter:text',
    'conditions'   => array( array( 'counter_before_after' => true ) ),
  );


  // Individual Controls
  // =============================================================================

  $control_counter_base_font_size = array(
    'key'     => 'counter_base_font_size',
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

  $control_counter_width = array(
    'key'     => 'counter_width',
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

  $control_counter_max_width = array(
    'key'     => 'counter_max_width',
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

  $control_counter_width_and_max_width = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Max Width', '__x__' ),
    'controls' => array(
      $control_counter_width,
      $control_counter_max_width,
    ),
  );

  $control_counter_start = array(
    'key'     => 'counter_start',
    'type'    => 'unit',
    'options' => array(
      'unit_mode'      => 'unitless',
      'dynamic'        => true,
      'fallback_value' => 0,
    ),
  );

  $control_counter_end = array(
    'key'     => 'counter_end',
    'type'    => 'unit',
    'options' => array(
      'unit_mode'      => 'unitless',
      'dynamic'        => true,
      'fallback_value' => 100,
    ),
  );

  $control_counter_start_and_end = array(
    'type'     => 'group',
    'label'    => __( 'Number Start &amp; End', '__x__' ),
    'controls' => array(
      $control_counter_start,
      $control_counter_end,
    ),
  );

  $control_counter_number_prefix_content = array(
    'key'   => 'counter_number_prefix_content',
    'type'  => 'text',
    'label' => __( 'Number Prefix', '__x__' ),
  );

  $control_counter_number_suffix_content = array(
    'key'   => 'counter_number_suffix_content',
    'type'  => 'text',
    'label' => __( 'Number Suffix', '__x__' ),
  );

  $control_counter_number_prefix_and_suffix_content = array(
    'type'     => 'group',
    'label'    => __( 'Prefix &amp; Suffix', '__x__' ),
    'controls' => array(
      $control_counter_number_prefix_content,
      $control_counter_number_suffix_content,
    ),
  );

  $control_counter_duration = array(
    'key'     => 'counter_duration',
    'type'    => 'unit-slider',
    'label'   => __( 'Effect Duration', '__x__' ),
    'options' => array(
      'unit_mode'       => 'time',
      'available_units' => array( 's', 'ms' ),
      'fallback_value'  => '0.5s',
      'ranges'          => array(
        's'  => array( 'min' => 0, 'max' => 5,    'step' => 0.1 ),
        'ms' => array( 'min' => 0, 'max' => 5000, 'step' => 100 ),
      ),
    ),
  );

  $control_counter_before_after = array(
    'key'     => 'counter_before_after',
    'type'    => 'choose',
    'label'   => __( 'Above &amp; Below Text', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_counter_before_content = array(
    'key'       => 'counter_before_content',
    'type'      => 'text',
    'label'     => __( 'Text Above', '__x__' ),
    'condition' => array( 'counter_before_after' => true ),
  );

  $control_counter_after_content = array(
    'key'       => 'counter_after_content',
    'type'      => 'text',
    'label'     => __( 'Text Below', '__x__' ),
    'condition' => array( 'counter_before_after' => true ),
  );


  // Compose Controls
  // ----------------
  return cs_compose_controls(
    array(
      'controls'       => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'counter:setup',
          'controls'   => array(
            $control_counter_base_font_size,
            $control_counter_width_and_max_width,
            $control_counter_start_and_end,
            $control_counter_number_prefix_and_suffix_content,
            $control_counter_duration,
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => __( 'Text Above &amp; Below Setup', '__x__' ),
          'group'      => 'counter:setup',
          'controls'   => array(
            $control_counter_before_after,
            $control_counter_before_content,
            $control_counter_after_content,
          ),
        ),

        cs_control( 'margin', 'counter', $settings_counter ),
        cs_control( 'margin', 'counter_number', array(
          'k_pre'        => 'counter_number',
          'label_prefix' => __( 'Number', '__x__' ),
          'group'        => 'counter:number',
          'options'      => $options_counter_number_margin,
        ) ),

        cs_control( 'text-format', 'counter_number', $settings_counter_number ),
        cs_control( 'text-shadow', 'counter_number', $settings_counter_number ),
        cs_control( 'text-format', 'counter_before_after', $settings_counter_before_after ),
        cs_control( 'text-shadow', 'counter_before_after', $settings_counter_before_after )

      ),
      'controls_std_content' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Content Setup', '__x__' ),
          'controls'   => array(
            $control_counter_start_and_end,
            $control_counter_number_prefix_content,
            $control_counter_number_suffix_content,
            $control_counter_before_content,
            $control_counter_after_content,
          ),
        ),
      ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            $control_counter_base_font_size,
            cs_amend_control( $control_counter_width, array( 'type' => 'unit-slider' ) ),
            cs_amend_control( $control_counter_max_width, array( 'type' => 'unit-slider' ) ),
            array(
              'key'   => 'counter_number_text_align',
              'type'  => 'text-align',
              'label' => __( 'Number Text Align', '__x__' ),
            ),
            array(
              'key'       => 'counter_before_after_text_align',
              'type'      => 'text-align',
              'label'     => __( 'Bookend Text Align', '__x__' ),
              'condition' => array( 'counter_before_after' => true ),
            ),
          ),
        ),
        cs_control( 'margin', 'counter', array( 'label_prefix' => __( 'Counter', '__x__' ) ) ),
        cs_control( 'margin', 'counter_number', array(
          'label_prefix' => __( 'Number', '__x__' ),
          'options'      => $options_counter_number_margin,
        ) )
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Base Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'  => array( 'value' => 'counter_number_text_color' ),
              'type'  => 'color',
              'label' => __( 'Text', '__x__' ),
            ),
            array(
              'keys'      => array( 'value' => 'counter_number_text_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'counter_number_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => __( 'Before and After Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'  => array( 'value' => 'counter_before_after_text_color' ),
              'type'  => 'color',
              'label' => __( 'Text', '__x__' ),
            ),
            array(
              'keys'      => array( 'value' => 'counter_before_after_text_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'counter_before_after_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
          ),
        ),
      ),
      'control_nav' => array(
        'counter'        => __( 'Counter', '__x__' ),
        'counter:setup'  => __( 'Setup', '__x__' ),
        'counter:design' => __( 'Design', '__x__' ),
        'counter:number' => __( 'Number', '__x__' ),
        'counter:text'   => __( 'Text', '__x__' ),
      ),
    ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'counter', $data );
