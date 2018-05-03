<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/STATBAR.PHP
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

function x_controls_statbar( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'statbar';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();

  $group_setup        = $group . ':setup';
  $group_design       = $group . ':design';

  $group_bar_setup    = $group . '_bar:setup';
  $group_bar_design   = $group . '_bar:design';

  $group_label_setup  = $group . '_label:setup';
  $group_label_design = $group . '_label:design';
  $group_label_text   = $group . '_label:text';


  // Setup - Conditions
  // ------------------

  $conditions                = x_module_conditions( $condition );
  $conditions_statbar_row    = array( $condition, array( 'key' => 'statbar_direction', 'op' => 'NOT IN', 'value' => array( 'column', 'column-reverse' ) ) );
  $conditions_statbar_column = array( $condition, array( 'key' => 'statbar_direction', 'op' => 'NOT IN', 'value' => array( 'row', 'row-reverse' ) ) );
  $conditions_label          = array( $condition, array( 'statbar_label' => true ) );
  $conditions_label_custom   = array( $condition, array( 'statbar_label' => true ), array( 'statbar_label_custom_text' => true ) );


  // Setup - Settings
  // ----------------

  $settings_statbar_design = array(
    'k_pre'     => 'statbar',
    'group'     => $group_design,
    'condition' => $conditions,
  );

  $settings_statbar_bar_design = array(
    'k_pre'     => 'statbar_bar',
    'group'     => $group_bar_design,
    'condition' => $conditions,
  );

  $settings_statbar_label_design = array(
    'k_pre'     => 'statbar_label',
    'group'     => $group_label_design,
    'condition' => $conditions_label,
  );

  $settings_statbar_label_text = array(
    'k_pre'     => 'statbar_label',
    'group'     => $group_label_text,
    'condition' => $conditions_label,
  );


  // Setup - Options
  // ---------------

  $options_statbar_base_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
      'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
      'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
    ),
  );

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

  $options_statbar_offset_trigger = array(
    'available_units' => array( '%' ),
    'fallback_value'  => '75%',
    'ranges'          => array(
      '%' => array( 'min' => 0, 'max' => 100, 'step' => 1 ),
    ),
  );

  $options_statbar_bar_width = array(
    'available_units' => array( '%' ),
    'fallback_value'  => '90%',
    'ranges'          => array(
      '%' => array( 'min' => 0, 'max' => 100, 'step' => 1 ),
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


  // Returned Value
  // --------------

  $controls = array_merge(
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Setup', '__x__' ),
        'group'      => $group_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'type'     => 'group',
            'label'    => __( 'Font Size &amp; Direction', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'statbar_base_font_size',
                'type'    => 'unit',
                'label'   => __( 'Font Size', '__x__' ),
                'options' => $options_statbar_base_font_size,
              ),
              array(
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
              ),
            ),
          ),
          array(
            'type'       => 'group',
            'label'      => __( 'Width &amp; Height', '__x__' ),
            'conditions' => $conditions_statbar_row,
            'controls'   => array(
              array(
                'key'     => 'statbar_width_row',
                'type'    => 'unit',
                'label'   => __( 'Width', '__x__' ),
                'options' => $options_statbar_width_and_height,
              ),
              array(
                'key'     => 'statbar_height_row',
                'type'    => 'unit',
                'label'   => __( 'Height', '__x__' ),
                'options' => $options_statbar_width_and_height,
              ),
            ),
          ),
          array(
            'type'       => 'group',
            'label'      => __( 'Max Width &amp; Height', '__x__' ),
            'conditions' => $conditions_statbar_row,
            'controls'   => array(
              array(
                'key'     => 'statbar_max_width_row',
                'type'    => 'unit',
                'label'   => __( 'Max Width', '__x__' ),
                'options' => $options_statbar_max_width_and_height,
              ),
              array(
                'key'     => 'statbar_max_height_row',
                'type'    => 'unit',
                'label'   => __( 'Max Height', '__x__' ),
                'options' => $options_statbar_max_width_and_height,
              ),
            ),
          ),
          array(
            'type'       => 'group',
            'label'      => __( 'Width &amp; Height', '__x__' ),
            'conditions' => $conditions_statbar_column,
            'controls'   => array(
              array(
                'key'     => 'statbar_width_column',
                'type'    => 'unit',
                'label'   => __( 'Width', '__x__' ),
                'options' => $options_statbar_width_and_height,
              ),
              array(
                'key'     => 'statbar_height_column',
                'type'    => 'unit',
                'label'   => __( 'Height', '__x__' ),
                'options' => $options_statbar_width_and_height,
              ),
            ),
          ),
          array(
            'type'       => 'group',
            'label'      => __( 'Max Width &amp; Height', '__x__' ),
            'conditions' => $conditions_statbar_column,
            'controls'   => array(
              array(
                'key'     => 'statbar_max_width_column',
                'type'    => 'unit',
                'label'   => __( 'Max Width', '__x__' ),
                'options' => $options_statbar_max_width_and_height,
              ),
              array(
                'key'     => 'statbar_max_height_column',
                'type'    => 'unit',
                'label'   => __( 'Max Height', '__x__' ),
                'options' => $options_statbar_max_width_and_height,
              ),
            ),
          ),
          array(
            'key'     => 'statbar_trigger_offset',
            'type'    => 'unit-slider',
            'label'   => __( 'Offset Trigger', '__x__' ),
            'options' => $options_statbar_offset_trigger,
          ),
          array(
            'key'   => 'statbar_bg_color',
            'type'  => 'color',
            'label' => __( 'Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_statbar_design ),
    x_control_padding( $settings_statbar_design ),
    x_control_border( $settings_statbar_design ),
    x_control_border_radius( $settings_statbar_design ),
    x_control_box_shadow( $settings_statbar_design ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Bar Setup', '__x__' ),
        'group'      => $group_bar_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'statbar_bar_length',
            'type'    => 'unit-slider',
            'label'   => __( 'Length', '__x__' ),
            'options' => $options_statbar_bar_width,
          ),
          array(
            'key'   => 'statbar_bar_bg_color',
            'type'  => 'color',
            'label' => __( 'Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_border_radius( $settings_statbar_bar_design ),
    x_control_box_shadow( $settings_statbar_bar_design ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Label Setup', '__x__' ),
        'group'      => $group_label_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'statbar_label',
            'type'    => 'choose',
            'label'   => __( 'Enable', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => true,  'label' => __( 'On', '__x__' ) ),
                array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
              ),
            ),
          ),
          array(
            'keys' => array(
              'label_custom_text' => 'statbar_label_custom_text',
              'label_always_show' => 'statbar_label_always_show',
            ),
            'type'    => 'checkbox-list',
            'label'   => __( 'Options', '__x__' ),
            'options' => array(
              'list' => array(
                array( 'key' => 'label_custom_text', 'label' => __( 'Custom Text', '__x__' ), 'half' => true ),
                array( 'key' => 'label_always_show', 'label' => __( 'Always Show', '__x__' ), 'half' => true ),
              ),
            ),
          ),
          array(
            'key'        => 'statbar_label_text_content',
            'type'       => 'text',
            'label'      => __( 'Content', '__x__' ),
            'conditions' => $conditions_label_custom,
          ),
          array(
            'key'        => 'statbar_label_justify',
            'type'       => 'choose',
            'label'      => __( 'Justify', '__x__' ),
            'conditions' => $conditions_label,
            'options'    => array(
              'choices' => array(
                array( 'value' => 'flex-start', 'label' => __( 'Start', '__x__' ) ),
                array( 'value' => 'center',     'label' => __( 'Center', '__x__' ) ),
                array( 'value' => 'flex-end',   'label' => __( 'End', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'        => 'statbar_label_bg_color',
            'type'       => 'color',
            'label'      => __( 'Background', '__x__' ),
            'conditions' => $conditions_label,
          ),
        ),
      ),
      array(
        'type'       => 'group',
        'title'      => __( 'Label Dimensions &amp; Position', '__x__' ),
        'group'      => $group_label_setup,
        'conditions' => $conditions_label,
        'controls'   => array(
          array(
            'key'     => 'statbar_label_width',
            'type'    => 'unit-slider',
            'label'   => __( 'Width', '__x__' ),
            'options' => $options_statbar_label_width_and_height,
          ),
          array(
            'key'     => 'statbar_label_height',
            'type'    => 'unit-slider',
            'label'   => __( 'Height', '__x__' ),
            'options' => $options_statbar_label_width_and_height,
          ),
          array(
            'key'     => 'statbar_label_translate_x',
            'type'    => 'unit-slider',
            'label'   => __( 'Translate<br>X Axis', '__x__' ),
            'options' => $options_statbar_label_translate,
          ),
          array(
            'key'     => 'statbar_label_translate_y',
            'type'    => 'unit-slider',
            'label'   => __( 'Translate<br>Y Axis', '__x__' ),
            'options' => $options_statbar_label_translate,
          ),
        ),
      ),
    ),
    x_control_padding( $settings_statbar_label_design ),
    x_control_border( $settings_statbar_label_design ),
    x_control_border_radius( $settings_statbar_label_design ),
    x_control_box_shadow( $settings_statbar_label_design ),
    x_control_text_format( $settings_statbar_label_text ),
    x_control_text_style( $settings_statbar_label_text ),
    x_control_text_shadow( $settings_statbar_label_text )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_statbar( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'statbar';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Statbar', '__x__' );

  $control_groups = array(

    $group                   => array( 'title' => $group_title ),
    $group . ':setup'        => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design'       => array( 'title' => __( 'Design', '__x__' ) ),

    $group . '_bar'          => array( 'title' => __( 'Bar', '__x__' ) ),
    $group . '_bar:setup'    => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . '_bar:design'   => array( 'title' => __( 'Design', '__x__' ) ),

    $group . '_label'        => array( 'title' => __( 'Label', '__x__' ) ),
    $group . '_label:setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . '_label:design' => array( 'title' => __( 'Design', '__x__' ) ),
    $group . '_label:text'   => array( 'title' => __( 'Text', '__x__' ) ),

  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_statbar( $settings = array() ) {

  // Values
  // ------

  $values = array(

    'statbar_base_font_size'               => x_module_value( '1em', 'style' ),
    'statbar_direction'                    => x_module_value( 'row', 'style' ),
    'statbar_width_row'                    => x_module_value( '100%', 'style' ),
    'statbar_max_width_row'                => x_module_value( 'none', 'style' ),
    'statbar_height_row'                   => x_module_value( '2em', 'style' ),
    'statbar_max_height_row'               => x_module_value( 'none', 'style' ),
    'statbar_width_column'                 => x_module_value( '2em', 'style' ),
    'statbar_max_width_column'             => x_module_value( 'none', 'style' ),
    'statbar_height_column'                => x_module_value( '18em', 'style' ),
    'statbar_max_height_column'            => x_module_value( 'none', 'style' ),
    'statbar_bg_color'                     => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'statbar_trigger_offset'               => x_module_value( '50%', 'style' ),
    'statbar_margin'                       => x_module_value( '0em 0em 0em 0em', 'style' ),
    'statbar_padding'                      => x_module_value( '0em 0em 0em 0em', 'style' ),
    'statbar_border_width'                 => x_module_value( '0px', 'style' ),
    'statbar_border_style'                 => x_module_value( 'none', 'style' ),
    'statbar_border_color'                 => x_module_value( 'transparent', 'style:color' ),
    'statbar_border_radius'                => x_module_value( '3px 3px 3px 3px', 'style' ),
    'statbar_box_shadow_dimensions'        => x_module_value( '0em 0em 0em 0em', 'style' ),
    'statbar_box_shadow_color'             => x_module_value( 'transparent', 'style:color' ),

    'statbar_bar_length'                   => x_module_value( '92%', 'all', true ),
    'statbar_bar_bg_color'                 => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'statbar_bar_border_radius'            => x_module_value( '3px 3px 3px 3px', 'style' ),
    'statbar_bar_box_shadow_dimensions'    => x_module_value( '0em 0em 0em 0em', 'style' ),
    'statbar_bar_box_shadow_color'         => x_module_value( 'transparent', 'style:color' ),

    'statbar_label'                        => x_module_value( true, 'all' ),
    'statbar_label_custom_text'            => x_module_value( false, 'markup' ),
    'statbar_label_always_show'            => x_module_value( false, 'markup' ),
    'statbar_label_text_content'           => x_module_value( __( 'HTML &amp; CSS', '__x__' ), 'markup', true ),
    'statbar_label_justify'                => x_module_value( 'flex-end', 'all' ),
    'statbar_label_bg_color'               => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'statbar_label_width'                  => x_module_value( 'auto', 'style' ),
    'statbar_label_height'                 => x_module_value( 'auto', 'style' ),
    'statbar_label_translate_x'            => x_module_value( '-0.5em', 'style' ),
    'statbar_label_translate_y'            => x_module_value( '0em', 'style' ),
    'statbar_label_padding'                => x_module_value( '0.35em 0.5em 0.35em 0.5em', 'style' ),
    'statbar_label_border_width'           => x_module_value( '0px', 'style' ),
    'statbar_label_border_style'           => x_module_value( 'none', 'style' ),
    'statbar_label_border_color'           => x_module_value( 'transparent', 'style:color' ),
    'statbar_label_border_radius'          => x_module_value( '2px 2px 2px 2px', 'style' ),
    'statbar_label_box_shadow_dimensions'  => x_module_value( '0em 0em 0em 0em', 'style' ),
    'statbar_label_box_shadow_color'       => x_module_value( 'transparent', 'style:color' ),
    'statbar_label_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
    'statbar_label_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
    'statbar_label_font_size'              => x_module_value( '0.75em', 'style' ),
    'statbar_label_letter_spacing'         => x_module_value( '0em', 'style' ),
    'statbar_label_line_height'            => x_module_value( '1', 'style' ),
    'statbar_label_font_style'             => x_module_value( 'normal', 'style' ),
    'statbar_label_text_align'             => x_module_value( 'none', 'style' ),
    'statbar_label_text_decoration'        => x_module_value( 'none', 'style' ),
    'statbar_label_text_transform'         => x_module_value( 'none', 'style' ),
    'statbar_label_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'statbar_label_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    'statbar_label_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),

  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
