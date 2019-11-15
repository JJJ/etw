<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TESTIMONIAL.PHP
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
//   06. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  array(
    'testimonial_content'                       => cs_value( __( 'You are never too old to set another goal or to dream a new dream.', '__x__' ), 'markup:html', true ),
    'testimonial_cite_content'                  => cs_value( __( 'C.S. Lewis', '__x__' ), 'all:html', true ),
    'testimonial_rating'                        => cs_value( false, 'all', true ),

    'testimonial_base_font_size'                => cs_value( '1em', 'style' ),
    'testimonial_width'                         => cs_value( 'auto', 'style' ),
    'testimonial_max_width'                     => cs_value( 'none', 'style' ),
    'testimonial_bg_color'                      => cs_value( 'transparent', 'style:color' ),

    'testimonial_margin'                        => cs_value( '0em 0em 0em 0em', 'style' ),
    'testimonial_padding'                       => cs_value( '0em 0em 0em 0em', 'style' ),
    'testimonial_border_width'                  => cs_value( '0px', 'style' ),
    'testimonial_border_style'                  => cs_value( 'none', 'style' ),
    'testimonial_border_color'                  => cs_value( 'transparent', 'style:color' ),
    'testimonial_border_radius'                 => cs_value( '0px 0px 0px 0px', 'style' ),
    'testimonial_box_shadow_dimensions'         => cs_value( '0em 0em 0em 0em', 'style' ),
    'testimonial_box_shadow_color'              => cs_value( 'transparent', 'style:color' ),

    'testimonial_content_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'testimonial_content_margin'                => cs_value( '0em 0em 0em 0em', 'style' ),
    'testimonial_content_padding'               => cs_value( '0em 0em 0em 0em', 'style' ),
    'testimonial_content_border_width'          => cs_value( '0px', 'style' ),
    'testimonial_content_border_style'          => cs_value( 'none', 'style' ),
    'testimonial_content_border_color'          => cs_value( 'transparent', 'style:color' ),
    'testimonial_content_border_radius'         => cs_value( '0px 0px 0px 0px', 'style' ),
    'testimonial_content_box_shadow_dimensions' => cs_value( '0em 0em 0em 0em', 'style' ),
    'testimonial_content_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),

    'testimonial_text_font_family'              => cs_value( 'inherit', 'style:font-family' ),
    'testimonial_text_font_weight'              => cs_value( 'inherit:400', 'style:font-weight' ),
    'testimonial_text_font_size'                => cs_value( '1.25em', 'style' ),
    'testimonial_text_letter_spacing'           => cs_value( '0em', 'style' ),
    'testimonial_text_line_height'              => cs_value( '1.4', 'style' ),
    'testimonial_text_font_style'               => cs_value( 'normal', 'style' ),
    'testimonial_text_text_align'               => cs_value( 'none', 'style' ),
    'testimonial_text_text_decoration'          => cs_value( 'none', 'style' ),
    'testimonial_text_text_transform'           => cs_value( 'none', 'style' ),
    'testimonial_text_text_color'               => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'testimonial_text_text_shadow_dimensions'   => cs_value( '0px 0px 0px', 'style' ),
    'testimonial_text_text_shadow_color'        => cs_value( 'transparent', 'style:color' ),

    'testimonial_cite_position'                 => cs_value( 'after', 'style' ),
    'testimonial_cite_align_self'               => cs_value( 'stretch', 'style' ),
    'testimonial_cite_spacing'                  => cs_value( '0.75em', 'style' ),
    'testimonial_cite_bg_color'                 => cs_value( 'transparent', 'style:color' ),

    'testimonial_cite_padding'                  => cs_value( '0em 0em 0em 0em', 'style' ),
    'testimonial_cite_border_width'             => cs_value( '0px', 'style' ),
    'testimonial_cite_border_style'             => cs_value( 'none', 'style' ),
    'testimonial_cite_border_color'             => cs_value( 'transparent', 'style:color' ),
    'testimonial_cite_border_radius'            => cs_value( '0px 0px 0px 0px', 'style' ),
    'testimonial_cite_box_shadow_dimensions'    => cs_value( '0em 0em 0em 0em', 'style' ),
    'testimonial_cite_box_shadow_color'         => cs_value( 'transparent', 'style:color' ),

    'testimonial_cite_font_family'              => cs_value( 'inherit', 'style:font-family' ),
    'testimonial_cite_font_weight'              => cs_value( 'inherit:400', 'style:font-weight' ),
    'testimonial_cite_font_size'                => cs_value( '0.8em', 'style' ),
    'testimonial_cite_letter_spacing'           => cs_value( '0em', 'style' ),
    'testimonial_cite_line_height'              => cs_value( '1', 'style' ),
    'testimonial_cite_font_style'               => cs_value( 'normal', 'style' ),
    'testimonial_cite_text_align'               => cs_value( 'none', 'style' ),
    'testimonial_cite_text_decoration'          => cs_value( 'none', 'style' ),
    'testimonial_cite_text_transform'           => cs_value( 'none', 'style' ),
    'testimonial_cite_text_color'               => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'testimonial_cite_text_shadow_dimensions'   => cs_value( '0px 0px 0px', 'style' ),
    'testimonial_cite_text_shadow_color'        => cs_value( 'transparent', 'style:color' ),

    'testimonial_graphic_position'              => cs_value( 'outer', 'markup' ),
    'testimonial_graphic_flex_direction'        => cs_value( 'row', 'style' ),
    'testimonial_graphic_flex_align'            => cs_value( 'flex-start', 'style' ),

    'testimonial_rating_position'               => cs_value( 'after', 'markup' ),
  ),
  cs_values( 'graphic', 'testimonial' ),
  cs_values( array(
    'graphic'                => cs_value( true, 'all' ),
    'graphic_margin'         => cs_value( '0em 0.8em 0em 0em', 'style' ),
    'graphic_icon_font_size' => cs_value( '2em', 'style' ),
    'graphic_icon'           => cs_value( 'user-circle', 'markup' ),
  ), 'testimonial' ),
  cs_values( 'rating', 'testimonial' ),
  cs_values( array(
    'rating'                 => cs_value( true, 'all' ),
    'rating_base_font_size'  => cs_value( '0.8em', 'style' ),
    'rating_graphic_spacing' => cs_value( '1px', 'style' ),
    'rating_margin'          => cs_value( '0.75em 0em 0em 0em', 'style' ),
    'rating_line_height'     => cs_value( '1', 'style' ),
  ), 'testimonial' ),
  'omega'
);



// Style
// =============================================================================

function x_element_style_testimonial() {
  return x_get_view( 'styles/elements', 'testimonial', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_testimonial( $data ) {
  return x_get_view( 'elements', 'testimonial', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Testimonial', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_testimonial',
  'style'   => 'x_element_style_testimonial',
  'render'  => 'x_element_render_testimonial',
  'icon'    => 'native',
  'options' => array(
    'inline' => array(
      'testimonial_content' => array(
        'selector' => '.x-testimonial-text'
      ),
      'testimonial_cite_content' => array(
        'selector' => '.x-testimonial-cite-text'
      )
    )
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_testimonial() {

  // Conditions
  // ----------

  // $condition_cite                     = array( 'key' => 'testimonial_cite_content', 'op' => 'NOT IN', 'value' => array( '' ) );
  $condition_cite                     = array();
  $condition_graphic_position_outer   = array( 'testimonial_graphic_position' => 'outer' );
  $condition_graphic_position_cite    = array( 'testimonial_graphic_position' => 'cite' );
  $condition_graphic_flex_direction_h = array( 'key' => 'testimonial_graphic_flex_direction', 'op' => 'IN', 'value' => array( 'row', 'row-reverse' ) );
  $condition_graphic_flex_direction_v = array( 'key' => 'testimonial_graphic_flex_direction', 'op' => 'IN', 'value' => array( 'column', 'column-reverse' ) );


  // Individual Controls
  // -------------------

  $control_testimonial_content = array(
    'key'     => 'testimonial_content',
    'type'    => 'text-editor',
    'label'   => __( 'Testimonial', '__x__' ),
    'options' => array(
      'height' => 4,
    ),
  );

  $control_testimonial_cite_content = array(
    'key'   => 'testimonial_cite_content',
    'type'  => 'text',
    'label' => __( 'Citation', '__x__' ),
  );

  $control_testimonial_base_font_size = array(
    'key'     => 'testimonial_base_font_size',
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

  $control_testimonial_width = array(
    'key'     => 'testimonial_width',
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

  $control_testimonial_max_width = array(
    'key'     => 'testimonial_max_width',
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

  $control_testimonial_bg_color = array(
    'keys'  => array( 'value' => 'testimonial_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_testimonial_content_bg_color = array(
    'keys'  => array( 'value' => 'testimonial_content_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_testimonial_cite_position = array(
    'key'     => 'testimonial_cite_position',
    'type'    => 'choose',
    'label'   => __( 'Position', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'before', 'label' => __( 'Before', '__x__' ) ),
        array( 'value' => 'after',  'label' => __( 'After', '__x__' )  ),
      ),
    ),
  );

  $control_testimonial_cite_placement = array(
    'key'     => 'testimonial_cite_align_self',
    'type'    => 'placement',
    'label'   => __( 'Align', '__x__' ),
    'options' => array( 'display' => 'flex', 'axis' => 'cross', 'context' => 'items', 'icon_direction' => 'x' ),
  );

  $control_testimonial_cite_spacing = array(
    'key'     => 'testimonial_cite_spacing',
    'type'    => 'unit-slider',
    'label'   => __( 'Spacing', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'fallback_value'  => '0.75em',
      'valid_keywords'  => array( 'calc' ),
      'ranges'          => array(
        'px'  => array( 'min' => 0, 'max' => 20, 'step' => 1    ),
        'em'  => array( 'min' => 0, 'max' => 1,  'step' => 0.05 ),
        'rem' => array( 'min' => 0, 'max' => 1,  'step' => 0.05 ),
      ),
    ),
  );

  $control_testimonial_cite_bg_color = array(
    'keys'  => array( 'value' => 'testimonial_cite_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Content', '__x__' ),
          'group'    => 'testimonial:content',
          'controls' => array(
            $control_testimonial_content,
            $control_testimonial_cite_content,
          ),
        ),


        array(
          'type'     => 'group',
          'label'    => __( 'Setup', '__x__' ),
          'group'    => 'testimonial:setup',
          'controls' => array(
            $control_testimonial_base_font_size,
            $control_testimonial_width,
            $control_testimonial_max_width,
            $control_testimonial_bg_color,
          ),
        ),
        cs_control( 'margin',        'testimonial',      array( 'group' => 'testimonial:design' ) ),
        cs_control( 'padding',       'testimonial',      array( 'group' => 'testimonial:design' ) ),
        cs_control( 'border',        'testimonial',      array( 'group' => 'testimonial:design' ) ),
        cs_control( 'border-radius', 'testimonial',      array( 'group' => 'testimonial:design' ) ),
        cs_control( 'box-shadow',    'testimonial',      array( 'group' => 'testimonial:design' ) ),
        cs_control( 'text-format',   'testimonial_text', array( 'group' => 'testimonial:text' )   ),
        cs_control( 'text-shadow',   'testimonial_text', array( 'group' => 'testimonial:text' )   ),


        array(
          'type'     => 'group',
          'label'    => __( 'Setup', '__x__' ),
          'group'    => 'testimonial_content:setup',
          'controls' => array(
            $control_testimonial_content_bg_color,
          ),
        ),
        cs_control( 'margin',        'testimonial_content', array( 'group' => 'testimonial_content:design' ) ),
        cs_control( 'padding',       'testimonial_content', array( 'group' => 'testimonial_content:design' ) ),
        cs_control( 'border',        'testimonial_content', array( 'group' => 'testimonial_content:design' ) ),
        cs_control( 'border-radius', 'testimonial_content', array( 'group' => 'testimonial_content:design' ) ),
        cs_control( 'box-shadow',    'testimonial_content', array( 'group' => 'testimonial_content:design' ) ),


        array(
          'type'      => 'group',
          'label'     => __( 'Setup', '__x__' ),
          'group'     => 'testimonial_cite:setup',
          'condition' => $condition_cite,
          'controls'  => array(
            $control_testimonial_cite_position,
            $control_testimonial_cite_placement,
            $control_testimonial_cite_spacing,
            $control_testimonial_cite_bg_color,
          ),
        ),
        cs_control( 'padding',       'testimonial_cite', array( 'group' => 'testimonial_cite:design', 'conditions' => array( $condition_cite ) ) ),
        cs_control( 'border',        'testimonial_cite', array( 'group' => 'testimonial_cite:design', 'conditions' => array( $condition_cite ) ) ),
        cs_control( 'border-radius', 'testimonial_cite', array( 'group' => 'testimonial_cite:design', 'conditions' => array( $condition_cite ) ) ),
        cs_control( 'box-shadow',    'testimonial_cite', array( 'group' => 'testimonial_cite:design', 'conditions' => array( $condition_cite ) ) ),
        cs_control( 'text-format',   'testimonial_cite', array( 'group' => 'testimonial_cite:text',   'conditions' => array( $condition_cite ) ) ),
        cs_control( 'text-shadow',   'testimonial_cite', array( 'group' => 'testimonial_cite:text',   'conditions' => array( $condition_cite ) ) )
      ),
      'controls_std_content' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Content Setup', '__x__' ),
          'controls'   => array(
            $control_testimonial_content,
            $control_testimonial_cite_content,
          ),
        ),
      ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            $control_testimonial_base_font_size,
            $control_testimonial_width,
            $control_testimonial_max_width,
            array(
              'key'   => 'testimonial_text_text_align',
              'type'  => 'text-align',
              'label' => __( 'testimonial Text Align', '__x__' ),
            ),
            array(
              'key'       => 'testimonial_cite_text_align',
              'type'      => 'text-align',
              'label'     => __( 'Citation Text Align', '__x__' ),
              'condition' => $condition_cite,
            ),
          ),
        ),
        cs_control( 'margin', 'testimonial' )
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Colors Base', '__x__' ),
          'controls'   => array(
            array(
              'keys'  => array( 'value' => 'testimonial_text_text_color' ),
              'type'  => 'color',
              'label' => __( 'Text', '__x__' ),
            ),
            array(
              'keys'      => array( 'value' => 'testimonial_text_text_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'testimonial_text_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            array(
              'keys'      => array( 'value' => 'testimonial_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'testimonial_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_testimonial_bg_color,
          ),
        ),

        cs_control( 'border', 'testimonial', array(
          'label_prefix' => __( 'testimonial', '__x__' ),
          'options'      => array( 'color_only' => true ),
          'conditions'   => array(
            array( 'key' => 'testimonial_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'testimonial_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) ),

        array(
          'type'      => 'group',
          'label'     => __( 'Colors Citation', '__x__' ),
          'condition' => $condition_cite,
          'controls'  => array(
            array(
              'keys'  => array( 'value' => 'testimonial_cite_text_color' ),
              'type'  => 'color',
              'label' => __( 'Text', '__x__' ),
            ),
            array(
              'keys'      => array( 'value' => 'testimonial_cite_text_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'testimonial_cite_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            array(
              'keys'      => array( 'value' => 'testimonial_cite_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'testimonial_cite_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_testimonial_cite_bg_color,
          ),
        ),

        cs_control( 'border', 'testimonial_cite', array(
          'condition'    => $condition_cite,
          'label_prefix' => __( 'Citation', '__x__' ),
          'options'      => array( 'color_only' => true ),
          'conditions'   => array(
            array( 'key' => 'testimonial_cite_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'testimonial_cite_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) )
      ),
      'control_nav' => array(
        'testimonial'                => __( 'Testimonial', '__x__' ),
        'testimonial:content'        => __( 'Content', '__x__' ),
        'testimonial:setup'          => __( 'Setup', '__x__' ),
        'testimonial:design'         => __( 'Design', '__x__' ),
        'testimonial:text'           => __( 'Text', '__x__' ),

        'testimonial_content'        => __( 'Content', '__x__' ),
        'testimonial_content:setup'  => __( 'Setup', '__x__' ),
        'testimonial_content:design' => __( 'Design', '__x__' ),

        'testimonial_cite'           => __( 'Citation', '__x__' ),
        'testimonial_cite:setup'     => __( 'Setup', '__x__' ),
        'testimonial_cite:design'    => __( 'Design', '__x__' ),
        'testimonial_cite:text'      => __( 'Text', '__x__' ),

        'testimonial_graphic'        => __( 'Graphic', '__x__' ),
        'testimonial_graphic:setup'  => __( 'Setup', '__x__' ),

        'testimonial_rating'         => __( 'Rating', '__x__' ),
      ),
    ),
    cs_partial_controls( 'graphic', array(
      'k_pre'               => 'testimonial',
      'has_alt'             => false,
      'has_interactions'    => false,
      'has_sourced_content' => false,
      'has_toggle'          => false,
      'group'               => 'testimonial_graphic:setup',
      'controls_setup' => array(
        array(
          'key'     => 'testimonial_graphic_position',
          'type'    => 'choose',
          'label'   => __( 'Position', '__x__' ),
          'options' => array(
            'choices' => array(
              array( 'value' => 'outer', 'label' => __( 'Outside', '__x__' )  ),
              array( 'value' => 'cite',  'label' => __( 'Citation', '__x__' ) ),
            ),
          ),
        ),
        array(
          'key'     => 'testimonial_graphic_flex_direction',
          'type'    => 'choose',
          'label'   => __( 'Placement', '__x__' ),
          'options' => array(
            'choices' => array(
              array( 'value' => 'column',         'icon' => 'long-arrow-alt-up'    ),
              array( 'value' => 'row-reverse',    'icon' => 'long-arrow-alt-right' ),
              array( 'value' => 'column-reverse', 'icon' => 'long-arrow-alt-down'  ),
              array( 'value' => 'row',            'icon' => 'long-arrow-alt-left'  ),
            ),
          ),
        ),
        array(
          'key'       => 'testimonial_graphic_flex_align',
          'type'      => 'placement',
          'label'     => __( 'Align', '__x__' ),
          'options'   => array( 'display' => 'flex', 'axis' => 'cross', 'context' => 'items', 'icon_direction' => 'x' ),
          'condition' => $condition_graphic_flex_direction_v,
        ),
        array(
          'key'       => 'testimonial_graphic_flex_align',
          'type'      => 'placement',
          'label'     => __( 'Align', '__x__' ),
          'options'   => array( 'display' => 'flex', 'axis' => 'cross', 'context' => 'items', 'icon_direction' => 'y' ),
          'condition' => $condition_graphic_flex_direction_h,
        )
      ),
    ) ),
    cs_partial_controls( 'rating', array(
      'k_pre'          => 'testimonial',
      'group'          => 'testimonial_rating',
      'allow_enable'   => true,
      'controls_setup' => array(
        array(
          'key'     => 'testimonial_rating_position',
          'type'    => 'choose',
          'label'   => __( 'Position', '__x__' ),
          'options' => array(
            'choices' => array(
              array( 'value' => 'before', 'label' => __( 'Before', '__x__' )  ),
              array( 'value' => 'after',  'label' => __( 'After', '__x__' ) ),
            ),
          ),
        )
      ),
    ) ),
    cs_partial_controls( 'omega' )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'testimonial', $data );
