<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/COUNTER.PHP
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

function x_controls_counter( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'counter';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();

  $group_setup  = $group . ':setup';
  $group_design = $group . ':design';
  $group_number = $group . ':number';
  $group_text   = $group . ':text';


  // Setup - Conditions
  // ------------------

  $conditions              = x_module_conditions( $condition );
  $conditions_before_after = array( $condition, array( 'counter_before_after' => true ) );


  // Setup - Options
  // ---------------

  $options_counter_base_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
      'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
      'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
    ),
  );

  $options_counter_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'fallback_value'  => 'auto',
    'valid_keywords'  => array( 'auto', 'calc' ),
    'ranges'          => array(
      'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
      'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    ),
  );

  $options_counter_max_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'fallback_value'  => 'none',
    'valid_keywords'  => array( 'none', 'calc' ),
    'ranges'          => array(
      'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
      'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    ),
  );


  // Setup - Settings
  // ----------------

  $settings_counter = array(
    'k_pre'     => 'counter',
    't_pre'     => __( 'Counter', '__x__' ),
    'group'     => $group_design,
    'condition' => $conditions,
  );

  $settings_counter_number = array(
    'k_pre'     => 'counter_number',
    't_pre'     => __( 'Number', '__x__' ),
    'group'     => $group_number,
    'condition' => $conditions,
  );

  $settings_counter_number_margin = array(
    'k_pre'     => 'counter_number',
    't_pre'     => __( 'Number', '__x__' ),
    'group'     => $group_number,
    'condition' => $conditions,
    'options'   => array(
      'top' => array(
        'available_units' => array( 'px', 'em', 'rem' ),
        'fallback_value'  => '10px',
        'valid_keywords'  => array( 'calc' ),
        'ranges'          => array(
          'px'  => array( 'min' => 0, 'max' => 32, 'step' => 1   ),
          'em'  => array( 'min' => 0, 'max' => 3,  'step' => 0.1 ),
          'rem' => array( 'min' => 0, 'max' => 3,  'step' => 0.1 ),
        ),
      ),
      'left' => array(
        'disabled'       => true,
        'fallback_value' => '0px',
      ),
      'right' => array(
        'disabled'       => true,
        'fallback_value' => '0px',
      ),
      'bottom' => array(
        'available_units' => array( 'px', 'em', 'rem' ),
        'fallback_value'  => '10px',
        'valid_keywords'  => array( 'calc' ),
        'ranges'          => array(
          'px'  => array( 'min' => 0, 'max' => 32, 'step' => 1   ),
          'em'  => array( 'min' => 0, 'max' => 3,  'step' => 0.1 ),
          'rem' => array( 'min' => 0, 'max' => 3,  'step' => 0.1 ),
        ),
      ),
    ),
  );

  $settings_counter_before_after = array(
    'k_pre'     => 'counter_before_after',
    't_pre'     => __( 'Before &amp; After', '__x__' ),
    'group'     => $group_text,
    'condition' => $conditions_before_after,
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
            'key'     => 'counter_base_font_size',
            'type'    => 'unit-slider',
            'label'   => __( 'Base Font Size', '__x__' ),
            'options' => $options_counter_base_font_size,
          ),
          array(
            'type'     => 'group',
            'label'    => __( 'Width &amp; Max Width', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'counter_width',
                'type'    => 'unit',
                'label'   => __( 'Width', '__x__' ),
                'options' => $options_counter_width,
              ),
              array(
                'key'     => 'counter_max_width',
                'type'    => 'unit',
                'label'   => __( 'Max Width', '__x__' ),
                'options' => $options_counter_max_width,
              ),
            ),
          ),
          array(
            'type'     => 'group',
            'label'    => __( 'Number Start &amp; End', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'counter_start',
                'type'    => 'unit',
                'options' => array(
                  'unit_mode'      => 'unitless',
                  'fallback_value' => 0,
                ),
              ),
              array(
                'key'     => 'counter_end',
                'type'    => 'unit',
                'options' => array(
                  'unit_mode'      => 'unitless',
                  'fallback_value' => 100,
                ),
              ),
            ),
          ),
          array(
            'type'     => 'group',
            'label'    => __( 'Prefix &amp; Suffix', '__x__' ),
            'controls' => array(
              array(
                'key'  => 'counter_number_prefix_content',
                'type' => 'text',
              ),
              array(
                'key'  => 'counter_number_suffix_content',
                'type' => 'text',
              ),
            ),
          ),
          array(
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
          ),
        ),
      ),
      array(
        'type'       => 'group',
        'title'      => __( 'Text Above &amp; Below Setup', '__x__' ),
        'group'      => $group_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'counter_before_after',
            'type'    => 'choose',
            'label'   => __( 'Above &amp; Below Text', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
                array( 'value' => true,  'label' => __( 'On', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'        => 'counter_before_content',
            'type'       => 'text',
            'label'      => __( 'Text Above', '__x__' ),
            'conditions' => $conditions_before_after,
          ),
          array(
            'key'        => 'counter_after_content',
            'type'       => 'text',
            'label'      => __( 'Text Below', '__x__' ),
            'conditions' => $conditions_before_after,
          ),
        ),
      ),
    ),
    x_control_margin( $settings_counter ),
    x_control_margin( $settings_counter_number_margin ),
    x_control_text_format( $settings_counter_number ),
    x_control_text_style( $settings_counter_number ),
    x_control_text_shadow( $settings_counter_number ),
    x_control_text_format( $settings_counter_before_after ),
    x_control_text_style( $settings_counter_before_after ),
    x_control_text_shadow( $settings_counter_before_after )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_counter( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'counter';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Counter', '__x__' );

  $control_groups = array(
    $group             => array( 'title' => $group_title ),
    $group . ':setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design' => array( 'title' => __( 'Design', '__x__' ) ),
    $group . ':number' => array( 'title' => __( 'Number', '__x__' ) ),
    $group . ':text'   => array( 'title' => __( 'Text', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_counter( $settings = array() ) {

  // Values
  // ------

  $values = array(
    'counter_base_font_size'                      => x_module_value( '1em', 'style' ),
    'counter_width'                               => x_module_value( 'auto', 'style' ),
    'counter_max_width'                           => x_module_value( 'none', 'style' ),
    'counter_start'                               => x_module_value( '0', 'markup', true ),
    'counter_end'                                 => x_module_value( '100', 'markup', true ),
    'counter_number_prefix_content'               => x_module_value( '', 'markup', true ),
    'counter_number_suffix_content'               => x_module_value( '', 'markup', true ),
    'counter_duration'                            => x_module_value( '1.5s', 'markup' ),
    'counter_before_after'                        => x_module_value( false, 'all' ),
    'counter_before_content'                      => x_module_value( '', 'markup', true ),
    'counter_after_content'                       => x_module_value( '', 'markup', true ),
    'counter_margin'                              => x_module_value( '0em', 'style' ),
    'counter_number_margin'                       => x_module_value( '0em', 'style' ),
    'counter_number_font_family'                  => x_module_value( 'inherit', 'style:font-family' ),
    'counter_number_font_weight'                  => x_module_value( 'inherit:400', 'style:font-weight' ),
    'counter_number_font_size'                    => x_module_value( '1em', 'style' ),
    'counter_number_letter_spacing'               => x_module_value( '0em', 'style' ),
    'counter_number_line_height'                  => x_module_value( '1', 'style' ),
    'counter_number_font_style'                   => x_module_value( 'normal', 'style' ),
    'counter_number_text_align'                   => x_module_value( 'none', 'style' ),
    'counter_number_text_decoration'              => x_module_value( 'none', 'style' ),
    'counter_number_text_transform'               => x_module_value( 'none', 'style' ),
    'counter_number_text_color'                   => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'counter_number_text_shadow_dimensions'       => x_module_value( '0px 0px 0px', 'style' ),
    'counter_number_text_shadow_color'            => x_module_value( 'transparent', 'style:color' ),
    'counter_before_after_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
    'counter_before_after_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
    'counter_before_after_font_size'              => x_module_value( '1em', 'style' ),
    'counter_before_after_letter_spacing'         => x_module_value( '0em', 'style' ),
    'counter_before_after_line_height'            => x_module_value( '1', 'style' ),
    'counter_before_after_font_style'             => x_module_value( 'normal', 'style' ),
    'counter_before_after_text_align'             => x_module_value( 'none', 'style' ),
    'counter_before_after_text_decoration'        => x_module_value( 'none', 'style' ),
    'counter_before_after_text_transform'         => x_module_value( 'none', 'style' ),
    'counter_before_after_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'counter_before_after_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    'counter_before_after_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
