<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/DROPDOWN.PHP
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

function x_controls_text( $settings = array() ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'standard'
  //     -- 'headline'

  $group       = ( isset( $settings['group'] )     ) ? $settings['group']     : 'text';
  $condition   = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();
  $type        = ( isset( $settings['type'] )      ) ? $settings['type']      : 'standard';

  $group_setup   = $group . ':setup';
  $group_design  = $group . ':design';
  $group_text    = $group . ':text';
  $group_graphic = $group . ':graphic';


  // Setup - Conditions
  // ------------------

  $conditions                  = x_module_conditions( $condition );
  $conditions_text_columns     = array( $condition, array( 'text_columns' => true ) );
  $conditions_text_typing_on   = array( $condition, array( 'text_typing' => true ) );
  $conditions_text_typing_off  = array( $condition, array( 'text_typing' => false ) );
  $conditions_text_subheadline = array( $condition, array( 'text_subheadline' => true ) );


  // Setup - Options
  // ---------------

  $options_typing_effect_time_controls = array(
    'unit_mode'       => 'time',
    'available_units' => array( 's', 'ms' ),
    'fallback_value'  => '0ms',
    'ranges'          => array(
      's'  => array( 'min' => 0, 'max' => 5,    'step' => 0.1 ),
      'ms' => array( 'min' => 0, 'max' => 5000, 'step' => 100 ),
    ),
  );


  // Setup - Settings
  // ----------------

  $settings_text_design = array(
    'k_pre'     => 'text',
    'group'     => $group_design,
    'condition' => $conditions,
  );

  $settings_text_text = array(
    'k_pre'     => 'text',
    'group'     => $group_text,
    'condition' => $conditions,
  );

  $settings_text_subheadline_text = array(
    'k_pre'     => 'text_subheadline',
    't_pre'     => __( 'Subheadline', '__x__' ),
    'group'     => $group_text,
    'condition' => $conditions_text_subheadline,
  );


  // Setup - Controls
  // ----------------

  $controls_setup = array();

  if ( $type === 'standard' ) {

    $controls_setup[] = array(
      'key'   => 'text_content',
      'type'  => 'text-editor',
      'title' => __( 'Text', '__x__' ),
    );

  }

  if ( $type === 'headline' ) {

    $controls_setup[] = array(
      'type'     => 'group',
      'label'    => __( 'Base Font Size &amp; Tag', '__x__' ),
      'controls' => array(
        array(
          'key'     => 'text_base_font_size',
          'type'    => 'unit',
          'label'   => __( 'Base Font Size', '__x__' ),
          'options' => array(
            'available_units' => array( 'px', 'em', 'rem' ),
            'valid_keywords'  => array( 'calc' ),
            'fallback_value'  => '1em',
            'ranges'          => array(
              'px'  => array( 'min' => 14,  'max' => 64, 'step' => 1    ),
              'em'  => array( 'min' => 0.5, 'max' => 5,  'step' => 0.05 ),
              'rem' => array( 'min' => 0.5, 'max' => 5,  'step' => 0.05 ),
            ),
          ),
        ),
        array(
          'key'     => 'text_tag',
          'type'    => 'select',
          'label'   => __( 'Tag', '__x__' ),
          'options' => array(
            'choices' => array(
              array( 'value' => 'p',    'label' => 'p' ),
              array( 'value' => 'h1',   'label' => 'h1' ),
              array( 'value' => 'h2',   'label' => 'h2' ),
              array( 'value' => 'h3',   'label' => 'h3' ),
              array( 'value' => 'h4',   'label' => 'h4' ),
              array( 'value' => 'h5',   'label' => 'h5' ),
              array( 'value' => 'h6',   'label' => 'h6' ),
              array( 'value' => 'div',  'label' => 'div' ),
              array( 'value' => 'span', 'label' => 'span' ),
            ),
          ),
        ),
      ),
    );

    $controls_setup[] = array(
      'keys' => array(
        'text_overflow' => 'text_overflow',
        'text_typing'   => 'text_typing',
      ),
      'type'    => 'checkbox-list',
      'label'   => __( 'Enable', '__x__' ),
      'options' => array(
        'list' => array(
          array( 'key' => 'text_overflow', 'label' => __( 'Overflow', '__x__' ),  'half' => true ),
          array( 'key' => 'text_typing',   'label' => __( 'Typing', '__x__' ),    'half' => true ),
        ),
      ),
    );

    $controls_setup[] = array(
      'key'        => 'text_content',
      'type'       => 'text-editor',
      'title'      => __( 'Text', '__x__' ),
      'conditions' => $conditions_text_typing_off,
      'options'    => array(
        'mode' => 'html',
      ),
    );

  }

  $controls_setup[] = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Max Width', '__x__' ),
    'controls' => array(
      array(
        'key'     => 'text_width',
        'type'    => 'unit',
        'options' => array(
          'available_units' => array( 'px', 'em', 'rem', '%' ),
          'valid_keywords'  => array( 'auto' ),
          'fallback_value'  => 'auto',
        ),
      ),
      array(
        'key'     => 'text_max_width',
        'type'    => 'unit',
        'options' => array(
          'available_units' => array( 'px', 'em', 'rem', '%' ),
          'valid_keywords'  => array( 'none' ),
          'fallback_value'  => 'none',
        ),
      ),
    ),
  );

  if ( $type === 'standard' ) {

    $controls_setup[] = array(
      'keys' => array(
        'columns' => 'text_columns',
      ),
      'type'    => 'checkbox-list',
      'label'   => __( 'Text Columns', '__x__' ),
      'options' => array(
        'list' => array(
          array( 'key' => 'columns', 'label' => __( 'Enable', '__x__' ) ),
        ),
      ),
    );

  }

  $controls_setup[] = array(
    'key'   => 'text_bg_color',
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );


  // Headline Content - Controls
  // ---------------------------

  $controls_text_typing = array();

  if ( $type === 'headline' ) {

    $controls_text_typing[] = array(
      'type'       => 'group',
      'title'      => __( 'Text Typing Content', '__x__' ),
      'group'      => $group_setup,
      'conditions' => $conditions_text_typing_on,
      'controls'   => array(
        array(
          'key'   => 'text_typing_prefix',
          'type'  => 'text',
          'label' => __( 'Prefix', '__x__' ),
        ),
        array(
          'key'     => 'text_typing_content',
          'type'    => 'textarea',
          'label'   => __( 'Typed Text<br>(1 Per Line)', '__x__' ),
          'options' => array(
            'height' => 3,
            'mode'   => 'html',
          ),
        ),
        array(
          'key'   => 'text_typing_suffix',
          'type'  => 'text',
          'label' => __( 'Suffix', '__x__' ),
        ),
      ),
    );

    $controls_text_typing[] = array(
      'type'       => 'group',
      'title'      => __( 'Text Typing Setup', '__x__' ),
      'group'      => $group_setup,
      'conditions' => $conditions_text_typing_on,
      'controls'   => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Speed &amp; Back Speed', '__x__' ),
          'controls' => array(
            array(
              'key'     => 'text_typing_speed',
              'type'    => 'unit',
              'label'   => __( 'Speed', '__x__' ),
              'options' => $options_typing_effect_time_controls,
            ),
            array(
              'key'     => 'text_typing_back_speed',
              'type'    => 'unit',
              'label'   => __( 'Back Speed', '__x__' ),
              'options' => $options_typing_effect_time_controls,
            ),
          ),
        ),
        array(
          'type'     => 'group',
          'label'    => __( 'Delay &amp; Back Delay', '__x__' ),
          'controls' => array(
            array(
              'key'     => 'text_typing_delay',
              'label'   => __( 'Delay', '__x__' ),
              'options' => $options_typing_effect_time_controls,
              'type'    => 'unit',
            ),
            array(
              'key'     => 'text_typing_back_delay',
              'type'    => 'unit',
              'label'   => __( 'Back Delay', '__x__' ),
              'options' => $options_typing_effect_time_controls,
            ),
          ),
        ),
        array(
          'keys' => array(
            'text_typing_loop'   => 'text_typing_loop',
            'text_typing_cursor' => 'text_typing_cursor',
          ),
          'type'    => 'checkbox-list',
          'label'   => __( 'Enable', '__x__' ),
          'options' => array(
            'list' => array(
              array( 'key' => 'text_typing_loop',   'label' => __( 'Loop Typing', '__x__' ), 'half' => true ),
              array( 'key' => 'text_typing_cursor', 'label' => __( 'Show Cursor', '__x__' ), 'half' => true ),
            ),
          ),
        ),
        array(
          'key'       => 'text_typing_cursor_content',
          'type'      => 'text',
          'label'     => __( 'Cursor', '__x__' ),
          'condition' => array( 'text_typing_cursor' => true ),
        ),
        array(
          'type'     => 'group',
          'label'    => __( 'Color', '__x__' ),
          'controls' => array(
            array(
              'keys' => array(
                'value' => 'text_typing_color',
              ),
              'type'    => 'color',
              'label'   => __( 'Text', '__x__' ),
              'options' => array(
                'label' => __( 'Text', '__x__' ),
              ),
            ),
            array(
              'keys' => array(
                'value' => 'text_typing_cursor_color',
              ),
              'type'      => 'color',
              'label'     => __( 'Cursor', '__x__' ),
              'condition' => array( 'text_typing_cursor' => true ),
              'options'   => array(
                'label' => __( 'Cursor', '__x__' ),
              ),
            ),
          ),
        ),
      ),
    );

  }


  // Returned Value
  // --------------

  $controls = array_merge(
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Setup', '__x__' ),
        'group'      => $group_setup,
        'controls'   => $controls_setup,
        'conditions' => $conditions,
      ),
    ),
    $controls_text_typing
  );

  if ( $type === 'standard' ) {
    $controls = array_merge(
      $controls,
      array(
        array(
          'type'       => 'group',
          'title'      => __( 'Text Column Setup', '__x__' ),
          'group'      => $group_setup,
          'conditions' => $conditions_text_columns,
          'controls'   => array(
            array(
              'key'     => 'text_columns_break_inside',
              'type'    => 'choose',
              'label'   => __( 'Content Break', '__x__' ),
              'options' => array(
                'choices' => array(
                  array( 'value' => 'auto',  'label' => __( 'Auto', '__x__' )  ),
                  array( 'value' => 'avoid', 'label' => __( 'Avoid', '__x__' ) ),
                ),
              ),
            ),
            array(
              'key'     => 'text_columns_count',
              'type'    => 'unit-slider',
              'label'   => __( 'Maximum Columns', '__x__' ),
              'options' => array(
                'unit_mode'      => 'unitless',
                'fallback_value' => 2,
                'min'            => 2,
                'max'            => 5,
                'step'           => 1,
              ),
            ),
            array(
              'type'     => 'group',
              'label'    => __( 'Min Width &amp; Gap Width', '__x__' ),
              'controls' => array(
                array(
                  'key'     => 'text_columns_width',
                  'type'    => 'unit',
                  'options' => array(
                    'available_units' => array( 'px', 'em', 'rem' ),
                    'valid_keywords'  => array( 'calc' ),
                    'fallback_value'  => '250px',
                  ),
                ),
                array(
                  'key'     => 'text_columns_gap',
                  'type'    => 'unit',
                  'options' => array(
                    'available_units' => array( 'px', 'em', 'rem' ),
                    'valid_keywords'  => array( 'calc' ),
                    'fallback_value'  => '25px',
                  ),
                ),
              ),
            ),
            array(
              'type'     => 'group',
              'label'    => __( 'Rule Style &amp; Rule Width', '__x__' ),
              'controls' => array(
                array(
                  'key'     => 'text_columns_rule_style',
                  'type'    => 'select',
                  'label'   => __( 'Rule Style', '__x__' ),
                  'options' => array(
                    'choices' => array(
                      array( 'value' => 'none',   'label' => __( 'None', '__x__' ) ),
                      array( 'value' => 'solid',  'label' => __( 'Solid', '__x__' ) ),
                      array( 'value' => 'dotted', 'label' => __( 'Dotted', '__x__' ) ),
                      array( 'value' => 'dashed', 'label' => __( 'Dashed', '__x__' ) ),
                      array( 'value' => 'double', 'label' => __( 'Double', '__x__' ) ),
                      array( 'value' => 'groove', 'label' => __( 'Groove', '__x__' ) ),
                      array( 'value' => 'ridge',  'label' => __( 'Ridge', '__x__' ) ),
                      array( 'value' => 'inset',  'label' => __( 'Inset', '__x__' ) ),
                      array( 'value' => 'outset', 'label' => __( 'Outset', '__x__' ) ),
                    ),
                  ),
                ),
                array(
                  'key'     => 'text_columns_rule_width',
                  'type'    => 'unit',
                  'label'   => __( 'Rule Width', '__x__' ),
                  'options' => array(
                    'available_units' => array( 'px', 'em', 'rem' ),
                    'valid_keywords'  => array( 'calc' ),
                    'fallback_value'  => '0px',
                  ),
                ),
              ),
            ),
            array(
              'key'   => 'text_columns_rule_color',
              'type'  => 'color',
              'label' => __( 'Rule Color', '__x__' ),
            ),
          ),
        ),
      )
    );
  }

  if ( $type === 'headline' ) {
    $controls = array_merge(
      $controls,
      x_control_flex_layout_css( array(
        'k_pre'     => 'text',
        't_pre'     => __( 'Text Content', '__x__' ),
        'group'     => $group_design,
        'condition' => $conditions,
      ) )
    );
  }

  $controls = array_merge(
    $controls,
    x_control_margin( $settings_text_design ),
    x_control_padding( $settings_text_design ),
    x_control_border( $settings_text_design ),
    x_control_border_radius( $settings_text_design ),
    x_control_box_shadow( $settings_text_design )
  );

  if ( $type === 'headline' ) {
    $controls = array_merge(
      $controls,
      x_control_margin( array(
        'k_pre'     => 'text_content',
        't_pre'     => __( 'Text Content', '__x__' ),
        'group'     => $group_text,
        'condition' => $conditions,
      ) )
    );
  }

  $controls = array_merge(
    $controls,
    x_control_text_format( $settings_text_text ),
    x_control_text_style( $settings_text_text ),
    x_control_text_shadow( $settings_text_text )
  );

  if ( $type === 'headline' ) {
    $controls = array_merge(
      $controls,
      array(
        array(
          'type'       => 'group',
          'title'      => __( 'Subheadline Setup', '__x__' ),
          'group'      => $group_text,
          'conditions' => $conditions,
          'controls'   => array(
            array(
              'key'     => 'text_subheadline',
              'type'    => 'choose',
              'label'   => __( 'Enable', '__x__' ),
              'options' => array(
                'choices' => array(
                  array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
                  array( 'value' => true,  'label' => __( 'On', '__x__' ) ),
                ),
              ),
            ),
            array(
              'key'       => 'text_subheadline_content',
              'type'      => 'text-editor',
              'title'     => __( 'Text', '__x__' ),
              'condition' => array( 'text_subheadline' => true ),
              'options'   => array(
                'mode'   => 'html',
                'height' => 2
              ),
            ),
            array(
              'key'       => 'text_subheadline_tag',
              'type'      => 'select',
              'label'     => __( 'Tag', '__x__' ),
              'condition' => array( 'text_subheadline' => true ),
              'options'   => array(
                'choices' => array(
                  array( 'value' => 'p',    'label' => 'p' ),
                  array( 'value' => 'h1',   'label' => 'h1' ),
                  array( 'value' => 'h2',   'label' => 'h2' ),
                  array( 'value' => 'h3',   'label' => 'h3' ),
                  array( 'value' => 'h4',   'label' => 'h4' ),
                  array( 'value' => 'h5',   'label' => 'h5' ),
                  array( 'value' => 'h6',   'label' => 'h6' ),
                  array( 'value' => 'div',  'label' => 'div' ),
                  array( 'value' => 'span', 'label' => 'span' ),
                ),
              ),
            ),
            array(
              'type'      => 'group',
              'label'     => __( 'Spacing &amp; Order', '__x__' ),
              'condition' => array( 'text_subheadline' => true ),
              'controls'  => array(
                array(
                  'key'     => 'text_subheadline_spacing',
                  'type'    => 'unit',
                  'label'   => __( 'Spacing', '__x__' ),
                  'options' => array(
                    'available_units' => array( 'px', 'em', 'rem' ),
                    'fallback_value'  => '5px',
                  ),
                ),
                array(
                  'keys' => array(
                    'text_reverse' => 'text_subheadline_reverse',
                  ),
                  'type'    => 'checkbox-list',
                  'label'   => __( 'Order', '__x__' ),
                  'options' => array(
                    'list' => array(
                      array( 'key' => 'text_reverse', 'label' => __( 'Reverse', '__x__' ) ),
                    ),
                  ),
                ),
              ),
            ),
          ),
        ),
      ),
      x_control_text_format( $settings_text_subheadline_text ),
      x_control_text_style( $settings_text_subheadline_text ),
      x_control_text_shadow( $settings_text_subheadline_text ),
      x_controls_graphic( array(
        'k_pre'               => 'text',
        'group'               => $group_graphic,
        'condition'           => $conditions,
        'has_alt'             => false,
        'has_interactions'    => false,
        'has_sourced_content' => false,
        'has_toggle'          => false,
      ) )
    );
  }

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_text( $settings = array() ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'standard'
  //     -- 'headline'

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'text';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Text', '__x__' );
  $type        = ( isset( $settings['type'] )        ) ? $settings['type']        : 'standard';

  $control_groups = array(
    $group             => array( 'title' => $group_title ),
    $group . ':setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design' => array( 'title' => __( 'Design', '__x__' ) ),
    $group . ':text'   => array( 'title' => __( 'Text', '__x__' ) ),
  );

  if ( $type === 'headline' ) {
    $control_groups[$group . ':graphic'] = array( 'title' => __( 'Graphic', '__x__' ) );
  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_text( $settings = array() ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'standard'
  //     -- 'headline'

  $type         = ( isset( $settings['type'] ) ) ? $settings['type'] : 'standard';
  $text_content = ( $type === 'standard' ) ? __( 'Input your text here! The text element is intended for longform copy that could potentially include multiple paragraphs.', '__x__' ) : __( 'Short and Sweet Headlines are Best!', '__x__' );


  // Values
  // ------

  $values = array(
    'text_type'                   => x_module_value( $type, 'markup' ),
    'text_content'                => x_module_value( $text_content, 'markup:html', true ),
    'text_width'                  => x_module_value( 'auto', 'style' ),
    'text_max_width'              => x_module_value( 'none', 'style' ),
    'text_bg_color'               => x_module_value( 'transparent', 'style:color' ),
    'text_margin'                 => x_module_value( '0em', 'style' ),
    'text_padding'                => x_module_value( '0em', 'style' ),
    'text_border_width'           => x_module_value( '0px', 'style' ),
    'text_border_style'           => x_module_value( 'none', 'style' ),
    'text_border_color'           => x_module_value( 'transparent', 'style:color' ),
    'text_border_radius'          => x_module_value( '0em', 'style' ),
    'text_box_shadow_dimensions'  => x_module_value( '0em 0em 0em 0em', 'style' ),
    'text_box_shadow_color'       => x_module_value( 'transparent', 'style:color' ),
    'text_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
    'text_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
    'text_font_size'              => x_module_value( '1em', 'style' ),
    'text_line_height'            => x_module_value( '1.4', 'style' ),
    'text_letter_spacing'         => x_module_value( '0em', 'style' ),
    'text_font_style'             => x_module_value( 'normal', 'style' ),
    'text_text_align'             => x_module_value( 'none', 'style' ),
    'text_text_decoration'        => x_module_value( 'none', 'style' ),
    'text_text_transform'         => x_module_value( 'none', 'style' ),
    'text_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'text_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    'text_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
  );

  if ( $type === 'standard' ) {
    $values = array_merge(
      $values,
      array(
        'text_columns_break_inside' => x_module_value( 'auto', 'style' ),
        'text_columns'              => x_module_value( false, 'style' ),
        'text_columns_count'        => x_module_value( 2, 'style' ),
        'text_columns_width'        => x_module_value( '250px', 'style' ),
        'text_columns_gap'          => x_module_value( '25px', 'style' ),
        'text_columns_rule_style'   => x_module_value( 'none', 'style' ),
        'text_columns_rule_width'   => x_module_value( '0px', 'style' ),
        'text_columns_rule_color'   => x_module_value( 'transparent', 'style:color' ),
      )
    );
  }

  if ( $type === 'headline' ) {
    $values = array_merge(
      $values,
      array(
        'text_base_font_size'                     => x_module_value( '1em', 'style' ),
        'text_tag'                                => x_module_value( 'h1', 'markup', true ),
        'text_overflow'                           => x_module_value( false, 'style' ),
        'text_typing'                             => x_module_value( false, 'markup' ),
        'text_typing_prefix'                      => x_module_value( 'Short and ', 'markup:raw', true ),
        'text_typing_content'                     => x_module_value( "Sweet\nClever\nImpactful", 'markup:raw', true ),
        'text_typing_suffix'                      => x_module_value( ' Headlines are Best!', 'markup:raw', true ),
        'text_typing_speed'                       => x_module_value( '50ms', 'markup' ),
        'text_typing_back_speed'                  => x_module_value( '50ms', 'markup' ),
        'text_typing_delay'                       => x_module_value( '0ms', 'markup' ),
        'text_typing_back_delay'                  => x_module_value( '1000ms', 'markup' ),
        'text_typing_loop'                        => x_module_value( true, 'markup' ),
        'text_typing_cursor'                      => x_module_value( true, 'markup' ),
        'text_typing_cursor_content'              => x_module_value( '|', 'markup' ),
        'text_typing_color'                       => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
        'text_typing_cursor_color'                => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
        'text_flex_direction'                     => x_module_value( 'row', 'style' ),
        'text_flex_wrap'                          => x_module_value( false, 'style' ),
        'text_flex_justify'                       => x_module_value( 'center', 'style' ),
        'text_flex_align'                         => x_module_value( 'center', 'style' ),
        'text_content_margin'                     => x_module_value( '0px', 'style' ),
        'text_subheadline'                        => x_module_value( false, 'all' ),
        'text_subheadline_content'                => x_module_value( __( 'Subheadline space', '__x__' ), 'markup', true ),
        'text_subheadline_tag'                    => x_module_value( 'span', 'markup', true ),
        'text_subheadline_spacing'                => x_module_value( '0.35em', 'style' ),
        'text_subheadline_reverse'                => x_module_value( false, 'all' ),
        'text_subheadline_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
        'text_subheadline_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
        'text_subheadline_font_size'              => x_module_value( '1em', 'style' ),
        'text_subheadline_line_height'            => x_module_value( '1.4', 'style' ),
        'text_subheadline_letter_spacing'         => x_module_value( '0em', 'style' ),
        'text_subheadline_font_style'             => x_module_value( 'normal', 'style' ),
        'text_subheadline_text_align'             => x_module_value( 'none', 'style' ),
        'text_subheadline_text_decoration'        => x_module_value( 'none', 'style' ),
        'text_subheadline_text_transform'         => x_module_value( 'none', 'style' ),
        'text_subheadline_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
        'text_subheadline_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
        'text_subheadline_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
      ),
      x_values_graphic( array(
        'k_pre'               => 'text',
        'has_alt'             => false,
        'has_interactions'    => false,
        'has_sourced_content' => false,
        'has_toggle'          => false,
        'theme'               => array(
          'graphic_margin' => x_module_value( '0em 0.5em 0em 0em', 'style' ),
        ),
      ) )
    );
  }


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
