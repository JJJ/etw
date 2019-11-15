<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/COLUMN.PHP
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
    '_active'                      => cs_value( false, 'attr' ),
    'size'                         => cs_value( '1/1', 'attr' ),
    'column_base_font_size'        => cs_value( '1em', 'style' ),
    'column_z_index'               => cs_value( '1', 'style' ),
    'column_fade'                  => cs_value( false, 'markup' ),
    'column_fade_duration'         => cs_value( '0.5s', 'markup' ),
    'column_fade_animation'        => cs_value( 'in', 'markup' ),
    'column_fade_animation_offset' => cs_value( '50px', 'markup' ),
    'column_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'column_bg_advanced'           => cs_value( false, 'all' ),
    'column_text_align'            => cs_value( 'none', 'style' ),
    'column_padding'               => cs_value( '0em', 'style' ),
    'column_border_width'          => cs_value( '0px', 'style' ),
    'column_border_style'          => cs_value( 'none', 'style' ),
    'column_border_color'          => cs_value( 'transparent', 'style:color' ),
    'column_border_radius'         => cs_value( '0px 0px 0px 0px', 'style' ),
    'column_box_shadow_dimensions' => cs_value( '0em 0em 0em 0em', 'style' ),
    'column_box_shadow_color'      => cs_value( 'transparent', 'style:color' )
  ),
  'bg',
  'omega',
  'omega:style'
);

// Style
// =============================================================================

function x_element_style_column() {
  return x_get_view( 'styles/elements', 'column', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_column( $data ) {
  return x_get_view( 'elements', 'column', '', $data, false );
}


// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Classic Column (v2)', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_column',
  'style' => 'x_element_style_column',
  'render' => 'x_element_render_column',
  'icon' => 'native',
  'options' => array(
    'valid_children'    => array( '*' ),
    'library'           => false,
    'empty_placeholder' => false,
    'fallback_content'  => '&nbsp;',
    'contrast_keys' => array(
      'bg:column_bg_advanced',
      'column_bg_color'
    )
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_column() {

    // Individual Controls
  // -------------------

  $control_column_base_font_size = array(
    'key'     => 'column_base_font_size',
    'type'    => 'unit',
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '16px',
      'ranges'          => array(
        'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
        'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
        'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
      ),
    ),
  );

  $control_column_z_index = array(
    'key'     => 'column_z_index',
    'type'    => 'unit',
    'options' => array(
      'unit_mode'      => 'unitless',
      'valid_keywords' => array( 'auto' ),
      'fallback_value' => 'auto',
    ),
  );

  $control_column_base_font_size_and_z_index = array(
    'type'     => 'group',
    'label'    => __( 'Font Size &amp; Z-Index', '__x__' ),
    'controls' => array(
      $control_column_base_font_size,
      $control_column_z_index
    ),
  );

  $control_column_fade = array(
    'key'     => 'column_fade',
    'type'    => 'choose',
    'label'   => __( 'Fade In Effect', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_column_fade_duration = array(
    'key'     => 'column_fade_duration',
    'type'    => 'unit',
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

  $control_column_fade_animation = array(
    'key'     => 'column_fade_animation',
    'type'    => 'select',
    'options' => array(
      'choices' => array(
        array( 'value' => 'in',             'label' => __( 'In', '__x__' ) ),
        array( 'value' => 'in-from-top',    'label' => __( 'In From Top', '__x__' ) ),
        array( 'value' => 'in-from-left',   'label' => __( 'In From Left', '__x__' ) ),
        array( 'value' => 'in-from-right',  'label' => __( 'In From Right', '__x__' ) ),
        array( 'value' => 'in-from-bottom', 'label' => __( 'In From Bottom', '__x__' ) ),
      ),
    ),
  );

  $control_column_fade_duration_and_animation = array(
    'type'      => 'group',
    'label'     => __( 'Duration &amp; Animation', '__x__' ),
    'condition' => array( 'column_fade' => true ),
    'controls'  => array(
      $control_column_fade_duration,
      $control_column_fade_animation,
    ),
  );

  $control_column_fade_animation_offset = array(
    'key'        => 'column_fade_animation_offset',
    'type'       => 'unit-slider',
    'label'      => __( 'Animation Offset', '__x__' ),
    'conditions' => array( array( 'column_fade' => true ), array( 'key' => 'column_fade_animation', 'op' => 'NOT IN', 'value' => 'in' ) ),
    'options'    => array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
    'fallback_value'  => '50px',
    'ranges'          => array(
      'px'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
      'em'  => array( 'min' => 0, 'max' => 15,  'step' => 0.25 ),
      'rem' => array( 'min' => 0, 'max' => 15,  'step' => 0.25 ),
      '%'   => array( 'min' => 0, 'max' => 200, 'step' => 5    ),
      'vw'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
      'vh'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
    ),
  ),
  );

  $control_column_bg_color = array(
    'key'     => 'column_bg_color',
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' )
  );

  $control_column_bg_advanced = array(
    'keys' => array(
      'bg_advanced' => 'column_bg_advanced',
    ),
    'type'    => 'checkbox-list',
    'options' => array(
      'list' => array(
        array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
      ),
    ),
  );

  $control_column_background = array(
    'type'     => 'group',
    'label'    => __( 'Background', '__x__' ),
    'controls' => array(
      $control_column_bg_color,
      $control_column_bg_advanced,
    ),
  );

  $control_column_text_align = array(
    'key'   => 'column_text_align',
    'type'  => 'text-align',
    'label' => __( 'Text Align', '__x__' ),
  );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Setup', '__x__' ),
          'group'    => 'column:setup',
          'controls' => array(
            $control_column_base_font_size_and_z_index,
            $control_column_fade,
            $control_column_fade_duration_and_animation,
            $control_column_fade_animation_offset,
            $control_column_background,
          ),
        ),
      ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            $control_column_base_font_size_and_z_index,
            $control_column_text_align,
          ),
        ),
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Base Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'      => array( 'value' => 'column_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'column_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_column_bg_color
          ),
        ),
        cs_control( 'border', 'column', array(
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'column_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'column_border_style', 'op' => '!=', 'value' => 'none' )
          )
        ) )
      ),
      'control_nav' => array(
        'column'        => __( 'Column', '__x__' ),
        'column:setup'  => __( 'Setup', '__x__' ),
        'column:design' => __( 'Design', '__x__' ),
      )
    ),
    cs_partial_controls( 'bg', array(
      'group'     => 'column:design',
      'condition' => array( 'column_bg_advanced' => true ),
    ) ),
    array(
      'controls' => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Formatting', '__x__' ),
          'group'    => 'column:design',
          'controls' => array(
            $control_column_text_align,
          ),
        ),
        cs_control( 'padding', 'column', array( 'group' => 'column:design' ) ),
        cs_control( 'border', 'column', array( 'group' => 'column:design' ) ),
        cs_control( 'border-radius', 'column', array( 'group' => 'column:design' ) ),
        cs_control( 'box-shadow', 'column', array( 'group' => 'column:design' ) )
      )
    ),
    cs_partial_controls( 'omega', array( 'add_style' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'column', $data );
