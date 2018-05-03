<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/QUOTE.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Groups
//   03. Values
// =============================================================================

// Controls
// =============================================================================

function x_controls_quote( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'quote';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();

  $group_content       = $group . ':content';
  $group_setup         = $group . ':setup';
  $group_design        = $group . ':design';
  $group_text          = $group . ':text';
  $group_marks         = $group . ':marks';

  $group_marks_setup   = $group . '_marks:setup';
  $group_marks_opening = $group . '_marks:opening';
  $group_marks_closing = $group . '_marks:closing';

  $group_cite_setup    = $group . '_cite:setup';
  $group_cite_design   = $group . '_cite:design';
  $group_cite_text     = $group . '_cite:text';
  $group_cite_graphic  = $group . '_cite:graphic';


  // Setup - Conditions
  // ------------------

  $conditions      = x_module_conditions( $condition );
  $conditions_cite = array( $condition, array( 'key' => 'quote_cite_content', 'op' => 'NOT IN', 'value' => array( '' ) ) );


  // Setup - Settings
  // ----------------

  $settings_quote = array(
    'k_pre'     => 'quote',
    'group'     => $group_design,
    'condition' => $conditions,
  );

  $settings_quote_text = array(
    'k_pre'     => 'quote_text',
    'group'     => $group_text,
    'condition' => $conditions,
  );

  $settings_quote_mark_opening = array(
    't_pre'               => __( 'Opening', '__x__' ),
    'k_pre'               => 'quote_marks_opening',
    'group'               => $group_marks_opening,
    'has_alt'             => false,
    'has_interactions'    => false,
    'has_sourced_content' => false,
    'has_toggle'          => false,
  );

  $settings_quote_mark_closing = array(
    't_pre'               => __( 'Closing', '__x__' ),
    'k_pre'               => 'quote_marks_closing',
    'group'               => $group_marks_closing,
    'has_alt'             => false,
    'has_interactions'    => false,
    'has_sourced_content' => false,
    'has_toggle'          => false,
  );

  $settings_quote_cite_setup = array(
    'k_pre'     => 'quote_cite',
    'group'     => $group_cite_setup,
    'condition' => $conditions_cite,
  );

  $settings_quote_cite_design = array(
    'k_pre'     => 'quote_cite',
    'group'     => $group_cite_design,
    'condition' => $conditions_cite,
  );

  $settings_quote_cite_text = array(
    'k_pre'     => 'quote_cite',
    'group'     => $group_cite_text,
    'condition' => $conditions_cite,
  );

  $settings_quote_cite_graphic = array(
    'k_pre'               => 'quote_cite',
    'group'               => $group_cite_graphic,
    'condition'           => $conditions_cite,
    'has_alt'             => false,
    'has_interactions'    => false,
    'has_sourced_content' => false,
    'has_toggle'          => false,
  );


  // Setup - Options
  // ---------------

  $options_quote_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
      'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
      'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
    ),
  );

  $options_quote_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'fallback_value'  => 'auto',
    'valid_keywords'  => array( 'auto', 'calc' ),
    'ranges'          => array(
      'px'  => array( 'min' => 250, 'max' => 1000, 'step' => 25 ),
      'em'  => array( 'min' => 10,  'max' => 50,   'step' => 1  ),
      'rem' => array( 'min' => 10,  'max' => 50,   'step' => 1  ),
      '%'   => array( 'min' => 50,  'max' => 100,  'step' => 1  ),
    ),
  );

  $options_quote_max_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'fallback_value'  => 'none',
    'valid_keywords'  => array( 'none', 'calc' ),
    'ranges'          => array(
      'px'  => array( 'min' => 250, 'max' => 1000, 'step' => 25 ),
      'em'  => array( 'min' => 10,  'max' => 50,   'step' => 1  ),
      'rem' => array( 'min' => 10,  'max' => 50,   'step' => 1  ),
      '%'   => array( 'min' => 50,  'max' => 100,  'step' => 1  ),
    ),
  );


  // Returned Value
  // --------------

  $controls = array_merge(
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Content', '__x__' ),
        'group'      => $group_content,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'quote_content',
            'type'    => 'text-editor',
            'label'   => __( 'Quote', '__x__' ),
            'options' => array(
              'height' => 4,
            ),
          ),
          array(
            'key'   => 'quote_cite_content',
            'type'  => 'text',
            'label' => __( 'Citation', '__x__' ),
          ),
        ),
      ),
      array(
        'type'       => 'group',
        'title'      => __( 'Setup', '__x__' ),
        'group'      => $group_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'quote_base_font_size',
            'type'    => 'slider',
            'label'   => __( 'Base Font Size', '__x__' ),
            'options' => $options_quote_font_size,
          ),
          array(
            'key'     => 'quote_width',
            'type'    => 'slider',
            'label'   => __( 'Width', '__x__' ),
            'options' => $options_quote_width,
          ),
          array(
            'key'     => 'quote_max_width',
            'type'    => 'slider',
            'label'   => __( 'Max Width', '__x__' ),
            'options' => $options_quote_max_width,
          ),
          array(
            'key'   => 'quote_bg_color',
            'type'  => 'color',
            'title' => __( 'Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_quote ),
    x_control_padding( $settings_quote ),
    x_control_border( $settings_quote ),
    x_control_border_radius( $settings_quote ),
    x_control_box_shadow( $settings_quote ),
    x_control_text_format( $settings_quote_text ),
    x_control_text_style( $settings_quote_text ),
    x_control_text_shadow( $settings_quote_text ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Marks Setup', '__x__' ),
        'group'      => $group_marks_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'quote_marks_graphic_direction',
            'type'    => 'choose',
            'label'   => __( 'Direction', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'row',    'label' => __( 'Row', '__x__' )    ),
                array( 'value' => 'column', 'label' => __( 'Column', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'     => 'quote_marks_graphic_opening_align',
            'type'    => 'choose',
            'label'   => __( 'Opening Mark Align', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'flex-start', 'label' => __( 'Start', '__x__' )  ),
                array( 'value' => 'center',     'label' => __( 'Center', '__x__' ) ),
                array( 'value' => 'flex-end',   'label' => __( 'End', '__x__' )    ),
              ),
            ),
          ),
          array(
            'key'     => 'quote_marks_graphic_closing_align',
            'type'    => 'choose',
            'label'   => __( 'Closing Mark Align', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'flex-start', 'label' => __( 'Start', '__x__' )  ),
                array( 'value' => 'center',     'label' => __( 'Center', '__x__' ) ),
                array( 'value' => 'flex-end',   'label' => __( 'End', '__x__' )    ),
              ),
            ),
          ),
        ),
      ),
    ),
    x_controls_graphic( $settings_quote_mark_opening ),
    x_controls_graphic( $settings_quote_mark_closing ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Setup', '__x__' ),
        'group'      => $group_cite_setup,
        'conditions' => $conditions_cite,
        'controls'   => array(
          array(
            'key'     => 'quote_cite_position',
            'type'    => 'choose',
            'label'   => __( 'Citation Position', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'before', 'label' => __( 'Before', '__x__' ) ),
                array( 'value' => 'after',  'label' => __( 'After', '__x__' )  ),
              ),
            ),
          ),
          array(
            'key'   => 'quote_cite_bg_color',
            'type'  => 'color',
            'title' => __( 'Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_flex_layout_css( $settings_quote_cite_setup ),
    x_control_margin( $settings_quote_cite_design ),
    x_control_padding( $settings_quote_cite_design ),
    x_control_border( $settings_quote_cite_design ),
    x_control_border_radius( $settings_quote_cite_design ),
    x_control_box_shadow( $settings_quote_cite_design ),
    x_control_text_format( $settings_quote_cite_text ),
    x_control_text_style( $settings_quote_cite_text ),
    x_control_text_shadow( $settings_quote_cite_text ),
    x_controls_graphic( $settings_quote_cite_graphic )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_quote( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'quote';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Quote', '__x__' );

  $control_groups = array(

    $group                    => array( 'title' => $group_title ),
    $group . ':content'       => array( 'title' => __( 'Content', '__x__' ) ),
    $group . ':setup'         => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design'        => array( 'title' => __( 'Design', '__x__' ) ),
    $group . ':text'          => array( 'title' => __( 'Text', '__x__' ) ),
    $group . ':marks'         => array( 'title' => __( 'Marks', '__x__' ) ),

    $group . '_marks'         => array( 'title' => __( 'Marks', '__x__' ) ),
    $group . '_marks:setup'   => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . '_marks:opening' => array( 'title' => __( 'Opening', '__x__' ) ),
    $group . '_marks:closing' => array( 'title' => __( 'Closing', '__x__' ) ),

    $group . '_cite'          => array( 'title' => __( 'Citation', '__x__' ) ),
    $group . '_cite:setup'    => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . '_cite:design'   => array( 'title' => __( 'Design', '__x__' ) ),
    $group . '_cite:text'     => array( 'title' => __( 'Text', '__x__' ) ),
    $group . '_cite:graphic'  => array( 'title' => __( 'Graphic', '__x__' ) ),

  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_quote( $settings = array() ) {

  // Setup
  // -----

  $settings_quote_mark_opening = array(
    'k_pre'               => 'quote_marks_opening',
    'has_alt'             => false,
    'has_interactions'    => false,
    'has_sourced_content' => false,
    'has_toggle'          => false,
    'theme'               => array(
      'graphic_margin'         => x_module_value( '0em 1em 0em 0em', 'style' ),
      'graphic_icon_font_size' => x_module_value( '1em', 'style' ),
      'graphic_icon'           => x_module_value( 'quote-left', 'markup' ),
    ),
  );

  $settings_quote_mark_closing = array(
    'k_pre'               => 'quote_marks_closing',
    'has_alt'             => false,
    'has_interactions'    => false,
    'has_sourced_content' => false,
    'has_toggle'          => false,
    'theme'               => array(
      'graphic_margin'         => x_module_value( '0em 0em 0em 1em', 'style' ),
      'graphic_icon_font_size' => x_module_value( '1em', 'style' ),
      'graphic_icon'           => x_module_value( 'quote-right', 'markup' ),
    ),
  );

  $settings_quote_cite_graphic = array(
    'k_pre'               => 'quote_cite',
    'has_alt'             => false,
    'has_interactions'    => false,
    'has_sourced_content' => false,
    'has_toggle'          => false,
    'theme'               => array(
      'graphic_margin'         => x_module_value( '0em 0.5em 0em 0em', 'style' ),
      'graphic_icon_font_size' => x_module_value( '1em', 'style' ),
      'graphic_icon'           => x_module_value( 'angle-right', 'markup' ),
    ),
  );


  // Values
  // ------

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


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
