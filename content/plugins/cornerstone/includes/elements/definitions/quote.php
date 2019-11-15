<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/QUOTE.PHP
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
    'quote_content'                     => cs_value( __( 'You are never too old to set another goal or to dream a new dream.', '__x__' ), 'markup:html', true ),
    'quote_cite_content'                => cs_value( __( 'C.S. Lewis', '__x__' ), 'all:html', true ),

    'quote_base_font_size'              => cs_value( '1em', 'style' ),
    'quote_width'                       => cs_value( 'auto', 'style' ),
    'quote_max_width'                   => cs_value( 'none', 'style' ),
    'quote_bg_color'                    => cs_value( 'transparent', 'style:color' ),

    'quote_margin'                      => cs_value( '0em 0em 0em 0em', 'style' ),
    'quote_padding'                     => cs_value( '0em 0em 0em 0em', 'style' ),
    'quote_border_width'                => cs_value( '0px', 'style' ),
    'quote_border_style'                => cs_value( 'none', 'style' ),
    'quote_border_color'                => cs_value( 'transparent', 'style:color' ),
    'quote_border_radius'               => cs_value( '0px 0px 0px 0px', 'style' ),
    'quote_box_shadow_dimensions'       => cs_value( '0em 0em 0em 0em', 'style' ),
    'quote_box_shadow_color'            => cs_value( 'transparent', 'style:color' ),

    'quote_text_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'quote_text_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'quote_text_font_size'              => cs_value( '1em', 'style' ),
    'quote_text_letter_spacing'         => cs_value( '0em', 'style' ),
    'quote_text_line_height'            => cs_value( '1.4', 'style' ),
    'quote_text_font_style'             => cs_value( 'normal', 'style' ),
    'quote_text_text_align'             => cs_value( 'center', 'style' ),
    'quote_text_text_decoration'        => cs_value( 'none', 'style' ),
    'quote_text_text_transform'         => cs_value( 'none', 'style' ),
    'quote_text_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'quote_text_text_shadow_dimensions' => cs_value( '0px 0px 0px', 'style' ),
    'quote_text_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),

    'quote_marks_graphic_direction'     => cs_value( 'row', 'style' ),
    'quote_marks_graphic_opening_align' => cs_value( 'start', 'style' ),
    'quote_marks_graphic_closing_align' => cs_value( 'start', 'style' ),

  ),
  cs_values( 'graphic', 'quote_marks_opening' ),
  cs_values( array(
    'graphic_margin'         => cs_value( '0em 1em 0em 0em', 'style' ),
    'graphic_icon_font_size' => cs_value( '1em', 'style' ),
    'graphic_icon'           => cs_value( 'quote-left', 'markup' ),
  ), 'quote_marks_opening' ),
  cs_values( 'graphic', 'quote_marks_closing' ),
  cs_values( array(
    'graphic_margin'         => cs_value( '0em 0em 0em 1em', 'style' ),
    'graphic_icon_font_size' => cs_value( '1em', 'style' ),
    'graphic_icon'           => cs_value( 'quote-right', 'markup' ),
  ), 'quote_marks_closing'),
  array(

    'quote_cite_position'               => cs_value( 'after', 'style' ),
    'quote_cite_bg_color'               => cs_value( 'transparent', 'style:color' ),

    'quote_cite_flex_direction'         => cs_value( 'row', 'style' ),
    'quote_cite_flex_wrap'              => cs_value( false, 'style' ),
    'quote_cite_flex_justify'           => cs_value( 'center', 'style' ),
    'quote_cite_flex_align'             => cs_value( 'center', 'style' ),

    'quote_cite_margin'                 => cs_value( '0.75em 0em 0em 0em', 'style' ),
    'quote_cite_padding'                => cs_value( '0em 0em 0em 0em', 'style' ),
    'quote_cite_border_width'           => cs_value( '0px', 'style' ),
    'quote_cite_border_style'           => cs_value( 'none', 'style' ),
    'quote_cite_border_color'           => cs_value( 'transparent', 'style:color' ),
    'quote_cite_border_radius'          => cs_value( '0px 0px 0px 0px', 'style' ),
    'quote_cite_box_shadow_dimensions'  => cs_value( '0em 0em 0em 0em', 'style' ),
    'quote_cite_box_shadow_color'       => cs_value( 'transparent', 'style:color' ),

    'quote_cite_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'quote_cite_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'quote_cite_font_size'              => cs_value( '0.75em', 'style' ),
    'quote_cite_letter_spacing'         => cs_value( '0.25em', 'style' ),
    'quote_cite_line_height'            => cs_value( '1.3', 'style' ),
    'quote_cite_font_style'             => cs_value( 'normal', 'style' ),
    'quote_cite_text_align'             => cs_value( 'center', 'style' ),
    'quote_cite_text_decoration'        => cs_value( 'none', 'style' ),
    'quote_cite_text_transform'         => cs_value( 'uppercase', 'style' ),
    'quote_cite_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'quote_cite_text_shadow_dimensions' => cs_value( '0px 0px 0px', 'style' ),
    'quote_cite_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),

  ),
  cs_values( 'graphic', 'quote_cite' ),
  cs_values( array(
    'graphic_margin'         => cs_value( '0em 0.5em 0em 0em', 'style' ),
    'graphic_icon_font_size' => cs_value( '1em', 'style' ),
    'graphic_icon'           => cs_value( 'angle-right', 'markup' ),
  ), 'quote_cite' ),
  'omega'
);


// Style
// =============================================================================

function x_element_style_quote() {
  return x_get_view( 'styles/elements', 'quote', 'css', array(), false );
}




// Render
// =============================================================================

function x_element_render_quote( $data ) {
  return x_get_view( 'elements', 'quote', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Quote', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_quote',
  'style' => 'x_element_style_quote',
  'render' => 'x_element_render_quote',
  'icon' => 'native',
  'options' => array(
    'inline' => array(
      'quote_content' => array(
        'selector' => '.x-quote-text'
      ),
      'quote_cite_content' => array(
        'selector' => '.x-quote-cite-text'
      )
    )
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_quote() {


  // Conditions
  // ----------

  $condition_cite = array( 'key' => 'quote_cite_content', 'op' => 'NOT IN', 'value' => array( '' ) );


  // Options
  // -------

  $options_quote_marks_graphic_align = array(
    'choices' => array(
      array( 'value' => 'flex-start', 'label' => __( 'Start', '__x__' )  ),
      array( 'value' => 'center',     'label' => __( 'Center', '__x__' ) ),
      array( 'value' => 'flex-end',   'label' => __( 'End', '__x__' )    ),
    ),
  );



  // Settings
  // --------

  $settings_quote_mark_opening = array(
    'label_prefix'               => __( 'Opening', '__x__' ),
    'k_pre'               => 'quote_marks_opening',
    'has_alt'             => false,
    'has_interactions'    => false,
    'has_sourced_content' => false,
    'has_toggle'          => false,
    'group'               => 'quote_marks:opening'
  );

  $settings_quote_mark_closing = array(
    'label_prefix'               => __( 'Closing', '__x__' ),
    'k_pre'               => 'quote_marks_closing',
    'has_alt'             => false,
    'has_interactions'    => false,
    'has_sourced_content' => false,
    'has_toggle'          => false,
    'group'               => 'quote_marks:closing',
  );

  $settings_quote_cite_design = array(
    'group'     => 'quote_cite:design',
    'conditions' => array( $condition_cite ),
  );

  $settings_quote_cite_text = array(
    'group'     => 'quote_cite:text',
    'conditions' => array( $condition_cite ),
  );

  $settings_quote_cite_graphic = array(
    'k_pre'               => 'quote_cite',
    'has_alt'             => false,
    'has_interactions'    => false,
    'has_sourced_content' => false,
    'has_toggle'          => false,
    'conditions'          => array( $condition_cite ),
    'group'               => 'quote_cite:graphic',
  );

  $settings_quote_cite_graphic_std = array_merge(
    $settings_quote_cite_graphic,
    array( 'label_prefix' => __( 'Citation', '__x__' ) )
  );

  $settings_quote_std_cite_design = array(
    'k_pre'     => 'quote_cite',
    'conditions' => array( $condition_cite ),
  );



  // Individual Controls
  // =============================================================================

  $control_quote_content = array(
    'key'     => 'quote_content',
    'type'    => 'text-editor',
    'label'   => __( 'Quote', '__x__' ),
    'options' => array(
      'height' => 4,
    ),
  );

  $control_quote_cite_content = array(
    'key'   => 'quote_cite_content',
    'type'  => 'text',
    'label' => __( 'Citation', '__x__' ),
  );

  $control_quote_base_font_size = array(
    'key'     => 'quote_base_font_size',
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

  $control_quote_width = array(
    'key'     => 'quote_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'fallback_value'  => 'auto',
      'valid_keywords'  => array( 'auto', 'calc' ),
      'ranges'          => array(
        'px'  => array( 'min' => 250, 'max' => 1000, 'step' => 25 ),
        'em'  => array( 'min' => 10,  'max' => 50,   'step' => 1  ),
        'rem' => array( 'min' => 10,  'max' => 50,   'step' => 1  ),
        '%'   => array( 'min' => 50,  'max' => 100,  'step' => 1  ),
      ),
    ),
  );

  $control_quote_max_width = array(
    'key'     => 'quote_max_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'fallback_value'  => 'none',
      'valid_keywords'  => array( 'none', 'calc' ),
      'ranges'          => array(
        'px'  => array( 'min' => 250, 'max' => 1000, 'step' => 25 ),
        'em'  => array( 'min' => 10,  'max' => 50,   'step' => 1  ),
        'rem' => array( 'min' => 10,  'max' => 50,   'step' => 1  ),
        '%'   => array( 'min' => 50,  'max' => 100,  'step' => 1  ),
      ),
    ),
  );

  $control_quote_bg_color = array(
    'keys'  => array( 'value' => 'quote_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_quote_marks_graphic_direction = array(
    'key'     => 'quote_marks_graphic_direction',
    'type'    => 'choose',
    'label'   => __( 'Direction', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'row',    'label' => __( 'Row', '__x__' )    ),
        array( 'value' => 'column', 'label' => __( 'Column', '__x__' ) ),
      ),
    ),
  );

  $control_quote_marks_graphic_opening_align = array(
    'key'     => 'quote_marks_graphic_opening_align',
    'type'    => 'choose',
    'label'   => __( 'Opening Mark Align', '__x__' ),
    'options' => $options_quote_marks_graphic_align,
  );

  $control_quote_marks_graphic_closing_align = array(
    'key'     => 'quote_marks_graphic_closing_align',
    'type'    => 'choose',
    'label'   => __( 'Closing Mark Align', '__x__' ),
    'options' => $options_quote_marks_graphic_align,
  );

  $control_quote_cite_position = array(
    'key'     => 'quote_cite_position',
    'type'    => 'choose',
    'label'   => __( 'Citation Position', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'before', 'label' => __( 'Before', '__x__' ) ),
        array( 'value' => 'after',  'label' => __( 'After', '__x__' )  ),
      ),
    ),
  );

  $control_quote_cite_bg_color = array(
    'keys'  => array( 'value' => 'quote_cite_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Content', '__x__' ),
          'group'      => 'quote:content',
          'controls'   => array(
            $control_quote_content,
            $control_quote_cite_content,
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'quote:setup',
          'controls'   => array(
            $control_quote_base_font_size,
            $control_quote_width,
            $control_quote_max_width,
            $control_quote_bg_color,
          ),
        ),

        cs_control( 'margin', 'quote', array( 'group' => 'quote:design' ) ),
        cs_control( 'padding', 'quote', array( 'group' => 'quote:design' ) ),
        cs_control( 'border', 'quote', array( 'group' => 'quote:design' ) ),
        cs_control( 'border-radius', 'quote', array( 'group' => 'quote:design' ) ),
        cs_control( 'box-shadow', 'quote', array( 'group' => 'quote:design' ) ),

        cs_control( 'text-format', 'quote_text', array( 'group' => 'quote:text' ) ),
        cs_control( 'text-shadow', 'quote_text', array( 'group' => 'quote:text' ) ),

        array(
          'type'       => 'group',
          'label'      => __( 'Marks Setup', '__x__' ),
          'group'      => 'quote_marks:setup',
          'controls'   => array(
            $control_quote_marks_graphic_direction,
            $control_quote_marks_graphic_opening_align,
            $control_quote_marks_graphic_closing_align,
          ),
        )
      ),
      'controls_std_content' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Content Setup', '__x__' ),
          'controls'   => array(
            $control_quote_content,
            $control_quote_cite_content,
          ),
        ),
      ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            $control_quote_base_font_size,
            $control_quote_width,
            $control_quote_max_width,
            array(
              'key'   => 'quote_text_text_align',
              'type'  => 'text-align',
              'label' => __( 'Quote Text Align', '__x__' ),
            ),
            array(
              'key'       => 'quote_cite_text_align',
              'type'      => 'text-align',
              'label'     => __( 'Citation Text Align', '__x__' ),
              'condition' => $condition_cite,
            ),
          ),
        ),
        cs_control( 'margin', 'quote' )
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Colors Base', '__x__' ),
          'controls'   => array(
            array(
              'keys'  => array( 'value' => 'quote_text_text_color' ),
              'type'  => 'color',
              'label' => __( 'Text', '__x__' ),
            ),
            array(
              'keys'      => array( 'value' => 'quote_text_text_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'quote_text_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            array(
              'keys'      => array( 'value' => 'quote_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'quote_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_quote_bg_color,
          ),
        ),

        cs_control( 'border', 'quote', array(
          'label_prefix'     => __( 'Quote', '__x__' ),
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'quote_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'quote_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) )

      ),
      'control_nav' => array(

        'quote'               => __( 'Quote', '__x__' ),
        'quote:content'       => __( 'Content', '__x__' ),
        'quote:setup'         => __( 'Setup', '__x__' ),
        'quote:design'        => __( 'Design', '__x__' ),
        'quote:text'          => __( 'Text', '__x__' ),

        'quote_marks'         => __( 'Marks', '__x__' ),
        'quote_marks:setup'   => __( 'Setup', '__x__' ),
        'quote_marks:opening' => __( 'Opening', '__x__' ),
        'quote_marks:closing' => __( 'Closing', '__x__' ),

        'quote_cite'          => __( 'Citation', '__x__' ),
        'quote_cite:setup'    => __( 'Setup', '__x__' ),
        'quote_cite:design'   => __( 'Design', '__x__' ),
        'quote_cite:text'     => __( 'Text', '__x__' ),
        'quote_cite:graphic'  => __( 'Graphic', '__x__' ),
      )
    ),
    cs_partial_controls( 'graphic', $settings_quote_mark_opening ),
    cs_partial_controls( 'graphic', $settings_quote_mark_closing ),
    array(
      'controls' => array(

        array(
          'type'      => 'group',
          'label'     => __( 'Setup', '__x__' ),
          'group'     => 'quote_cite:setup',
          'condition' => $condition_cite,
          'controls'  => array(
            $control_quote_cite_position,
            $control_quote_cite_bg_color,
          ),
        ),

        cs_control( 'flexbox', 'quote_cite', array(
          'k_pre'     => 'quote_cite',
          'group'     => 'quote_cite:setup',
          'conditions' => array( $condition_cite ),
          'no_self' => true
        ) ),

        cs_control( 'margin', 'quote_cite', $settings_quote_cite_design ),
        cs_control( 'padding', 'quote_cite', $settings_quote_cite_design ),
        cs_control( 'border', 'quote_cite', $settings_quote_cite_design ),
        cs_control( 'border-radius', 'quote_cite', $settings_quote_cite_design ),
        cs_control( 'box-shadow', 'quote_cite', $settings_quote_cite_design ),

        cs_control( 'text-format', 'quote_cite', $settings_quote_cite_text ),
        cs_control( 'text-shadow', 'quote_cite', $settings_quote_cite_text )

      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Colors Citation', '__x__' ),
          'condition' => $condition_cite,
          'controls'   => array(
            array(
              'keys'  => array( 'value' => 'quote_cite_text_color' ),
              'type'  => 'color',
              'label' => __( 'Text', '__x__' ),
            ),
            array(
              'keys'      => array( 'value' => 'quote_cite_text_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'quote_cite_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            array(
              'keys'      => array( 'value' => 'quote_cite_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'quote_cite_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_quote_cite_bg_color,
          ),
        ),
        cs_control( 'border', 'quote_cite', array(
          'label_prefix'     => __( 'Citation', '__x__' ),
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            $condition_cite,
            array( 'key' => 'quote_cite_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'quote_cite_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) )
      )
    ),
    cs_partial_controls( 'graphic', $settings_quote_cite_graphic ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'quote', $data );
