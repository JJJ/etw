<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/TEXT.PHP
// -----------------------------------------------------------------------------
// Element Controls
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
// =============================================================================

// Controls
// =============================================================================

function x_control_partial_text( $settings ) {


  // Setup
  // -----

  // 01. Available types:
  //     -- 'standard'
  //     -- 'headline'

  $label_prefix      = ( isset( $settings['label_prefix'] )     ) ? $settings['label_prefix'] : '';
  $label_prefix_std  = ( isset( $settings['label_prefix_std'] ) ) ? $settings['label_prefix_std']    : $label_prefix;
  $k_pre             = ( isset( $settings['k_pre'] )            ) ? $settings['k_pre'] . '_'  : '';
  $group             = ( isset( $settings['group'] )            ) ? $settings['group']        : 'text';
  $group_title       = ( isset( $settings['group_title'] )      ) ? $settings['group_title']  : __( 'Text', '__x__' );
  $conditions        = ( isset( $settings['conditions'] )       ) ? $settings['conditions']   : array();
  $type              = ( isset( $settings['type'] )             ) ? $settings['type']         : 'standard'; // 01



  // Groups
  // ------

  $group_text_setup   = $group . ':setup';
  $group_text_design  = $group . ':design';
  $group_text_graphic = $group . ':graphic';
  $group_text_text    = $group . ':text';



  // Conditions
  // ----------

  $conditions_text_columns     = array_merge( $conditions, array( array( $k_pre . 'text_type' => 'standard' ), array( $k_pre . 'text_columns' => true ) ) );
  $conditions_text_typing_on   = array_merge( $conditions, array( array( $k_pre . 'text_type' => 'headline' ), array( $k_pre . 'text_typing' => true ) ) );
  $conditions_text_typing_off  = array_merge( $conditions, array( array( $k_pre . 'text_type' => 'headline' ), array( $k_pre . 'text_typing' => false ) ) );
  $conditions_text_subheadline = array_merge( $conditions, array( array( $k_pre . 'text_type' => 'headline' ), array( $k_pre . 'text_subheadline' => true ) ) );


  // Settings
  // --------

  $settings_text_design = array(
    'k_pre'     => $k_pre . 'text',
    'group'     => $group_text_design,
    'conditions' => $conditions,
  );

  $settings_text_text = array(
    'k_pre'     => $k_pre . 'text',
    'group'     => $group_text_text,
    'conditions' => $conditions,
  );

  $settings_text_flexbox = array(
    'k_pre'     => $k_pre . 'text',
    'label_prefix' => sprintf( __( '%s Text Content', '__x__' ), $label_prefix ),
    'group'     => $group_text_design,
    'conditions' => $conditions,
    'no_self'   => true
  );

  $settings_text_content_margin = array(
    'k_pre'     => $k_pre . 'text_content',
    'label_prefix' => sprintf( __( '%s Text Content', '__x__' ), $label_prefix ),
    'group'     => $group_text_text,
    'conditions' => $conditions,
  );

  $settings_text_subheadline_text = array(
    'k_pre'     => $k_pre . 'text_subheadline',
    'label_prefix' => sprintf( __( '%s Subheadline', '__x__' ), $label_prefix ),
    'group'     => $group_text_text,
    'conditions' => $conditions_text_subheadline,
  );

  // Options
  // -------

  $options_text_tags = array(
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
  );

  $options_typing_effect_time_controls = array(
    'unit_mode'       => 'time',
    'available_units' => array( 's', 'ms' ),
    'fallback_value'  => '0ms',
    'ranges'          => array(
      's'  => array( 'min' => 0, 'max' => 5,    'step' => 0.1 ),
      'ms' => array( 'min' => 0, 'max' => 5000, 'step' => 100 ),
    ),
  );


  // Individual Controls
  // -------------------

  $control_text_content_standard = array(
    'key'     => $k_pre . 'text_content',
    'type'    => 'text-editor',
    'label'   => __( 'Text', '__x__' ),
    'options' => array(
      'height'                => 1,
      'disable_input_preview' => true
    ),
  );

  $control_text_content_headline = array(
    'key'        => $k_pre . 'text_content',
    'type'       => 'text-editor',
    'label'      => __( 'Text', '__x__' ),
    'conditions' => $conditions_text_typing_off,
    'options'    => array(
      'height'                => 1,
      'mode'                  => 'html',
      'disable_input_preview' => true,
    ),
  );

  $control_text_font_size = array(
    'key'     => $k_pre . 'text_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '1em',
      'ranges'          => array(
        'px'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
        'em'  => array( 'min' => 0, 'max' => 5,   'step' => 0.05 ),
        'rem' => array( 'min' => 0, 'max' => 5,   'step' => 0.05 ),
      ),
    ),
  );

  $control_text_base_font_size = array(
    'key'     => $k_pre . 'text_base_font_size',
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
  );

  $control_text_tag = array(
    'key'     => $k_pre . 'text_tag',
    'type'    => 'select',
    'label'   => __( 'Tag', '__x__' ),
    'options' => $options_text_tags,
  );

  $control_text_overflow_and_text_typing = array(
    'keys' => array(
      'text_overflow' => $k_pre . 'text_overflow',
      'text_typing'   => $k_pre . 'text_typing',
    ),
    'type'    => 'checkbox-list',
    'label'   => __( 'Enable', '__x__' ),
    'options' => array(
      'list' => array(
        array( 'key' => 'text_overflow', 'label' => __( 'Overflow', '__x__' ) ),
        array( 'key' => 'text_typing',   'label' => __( 'Typing', '__x__' ) ),
      ),
    ),
  );

  $control_text_width = array(
    'key'     => $k_pre . 'text_width',
    'type'    => 'unit',
    'label'   => __( 'Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'valid_keywords'  => array( 'auto' ),
      'fallback_value'  => 'auto',
      'ranges'          => array(
        'px'  => array( 'min' => 250, 'max' => 1000, 'step' => 10  ),
        'em'  => array( 'min' => 10,  'max' => 50,   'step' => 0.5 ),
        'rem' => array( 'min' => 10,  'max' => 50,   'step' => 0.5 ),
        '%'   => array( 'min' => 50,  'max' => 100,  'step' => 1   ),
      ),
    ),
  );

  $control_text_max_width = array(
    'key'     => $k_pre . 'text_max_width',
    'type'    => 'unit',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'valid_keywords'  => array( 'none' ),
      'fallback_value'  => 'none',
      'ranges'          => array(
        'px'  => array( 'min' => 250, 'max' => 1000, 'step' => 10  ),
        'em'  => array( 'min' => 10,  'max' => 50,   'step' => 0.5 ),
        'rem' => array( 'min' => 10,  'max' => 50,   'step' => 0.5 ),
        '%'   => array( 'min' => 50,  'max' => 100,  'step' => 1   ),
      ),
    ),
  );

  $control_text_width_and_max_width = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Max Width', '__x__' ),
    'controls' => array(
      $control_text_width,
      $control_text_max_width,
    ),
  );

  $control_text_columns = array(
    'keys' => array(
      'columns' => $k_pre . 'text_columns',
    ),
    'type'    => 'checkbox-list',
    'label'   => __( 'Text Columns', '__x__' ),
    'options' => array(
      'list' => array(
        array( 'key' => 'columns', 'label' => __( 'Enable', '__x__' ) ),
      ),
    ),
  );

  $control_text_bg_color = array(
    'key'   => $k_pre . 'text_bg_color',
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_text_typing_prefix = array(
    'key'        => $k_pre . 'text_typing_prefix',
    'type'       => 'text',
    'label'      => __( 'Prefix', '__x__' ),
    'conditions' => $conditions_text_typing_on,
  );

  $control_text_typing_content = array(
    'key'        => $k_pre . 'text_typing_content',
    'type'       => 'textarea',
    'label'      => __( 'Typed Text<br>(1 Per Line)', '__x__' ),
    'conditions' => $conditions_text_typing_on,
    'options'    => array(
      'height' => 3,
      'mode'   => 'html',
    ),
  );

  $control_text_typing_suffix = array(
    'key'        => $k_pre . 'text_typing_suffix',
    'type'       => 'text',
    'label'      => __( 'Suffix', '__x__' ),
    'conditions' => $conditions_text_typing_on,
  );

  $control_text_subheadline = array(
    'key'     => $k_pre . 'text_subheadline',
    'type'    => 'choose',
    'label'   => __( 'Enable', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_text_subheadline_content = array(
    'key'       => $k_pre . 'text_subheadline_content',
    'type'      => 'text-editor',
    'label'     => __( 'Text', '__x__' ),
    'condition' => array( $k_pre . 'text_subheadline' => true ),
    'options'   => array(
      'mode'   => 'html',
      'height' => 2,
    ),
  );

  $control_text_subheadline_tag = array(
    'key'       => $k_pre . 'text_subheadline_tag',
    'type'      => 'select',
    'label'     => __( 'Tag', '__x__' ),
    'condition' => array( $k_pre . 'text_subheadline' => true ),
    'options'   => $options_text_tags,
  );

  $control_text_subheadline_spacing_and_reverse = array(
    'type'      => 'group',
    'label'     => __( 'Spacing &amp; Order', '__x__' ),
    'condition' => array( $k_pre . 'text_subheadline' => true ),
    'controls'  => array(
      array(
        'key'     => $k_pre . 'text_subheadline_spacing',
        'type'    => 'unit',
        'label'   => __( 'Spacing', '__x__' ),
        'options' => array(
          'available_units' => array( 'px', 'em', 'rem' ),
          'fallback_value'  => '5px',
        ),
      ),
      array(
        'keys' => array(
          'text_reverse' => $k_pre . 'text_subheadline_reverse',
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
  );


  // Control Lists
  // =============================================================================

  // Advanced Setup
  // --------------

  $control_list_text_adv_setup = array();

  if ( $type === 'standard' ) {
    $control_list_text_adv_setup[] = $control_text_content_standard;
  }

  if ( $type === 'headline' ) {
    $control_list_text_adv_setup[] = array(
      'type'     => 'group',
      'label'    => __( 'Base Font Size &amp; Tag', '__x__' ),
      'controls' => array(
        $control_text_base_font_size,
        $control_text_tag,
      ),
    );
    $control_list_text_adv_setup[] = $control_text_overflow_and_text_typing;
    $control_list_text_adv_setup[] = $control_text_content_headline;
  }

  $control_list_text_adv_setup[] = $control_text_width_and_max_width;

  if ( $type === 'standard' ) {
    $control_list_text_adv_setup[] = $control_text_columns;
  }

  $control_list_text_adv_setup[] = $control_text_bg_color;


  // Advanced Text Columns
  // ---------------------

  $control_list_text_adv_text_columns = array(
    array(
      'key'     => $k_pre . 'text_columns_break_inside',
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
      'key'     => $k_pre . 'text_columns_count',
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
          'key'     => $k_pre . 'text_columns_width',
          'type'    => 'unit',
          'options' => array(
            'available_units' => array( 'px', 'em', 'rem' ),
            'valid_keywords'  => array( 'calc' ),
            'fallback_value'  => '250px',
          ),
        ),
        array(
          'key'     => $k_pre . 'text_columns_gap',
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
          'key'     => $k_pre . 'text_columns_rule_style',
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
          'key'     => $k_pre . 'text_columns_rule_width',
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
      'key'   => $k_pre . 'text_columns_rule_color',
      'type'  => 'color',
      'label' => __( 'Rule Color', '__x__' ),
    ),
  );


  // Advanced Typing Setup
  // ---------------------

  $control_list_text_adv_typing_setup = array(
    $control_text_typing_prefix,
    $control_text_typing_content,
    $control_text_typing_suffix,
    array(
      'type'     => 'group',
      'label'    => __( 'Speed &amp; Back Speed', '__x__' ),
      'controls' => array(
        array(
          'key'     => $k_pre . 'text_typing_speed',
          'type'    => 'unit',
          'label'   => __( 'Speed', '__x__' ),
          'options' => $options_typing_effect_time_controls,
        ),
        array(
          'key'     => $k_pre . 'text_typing_back_speed',
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
          'key'     => $k_pre . 'text_typing_delay',
          'type'    => 'unit',
          'label'   => __( 'Delay', '__x__' ),
          'options' => $options_typing_effect_time_controls,
        ),
        array(
          'key'     => $k_pre . 'text_typing_back_delay',
          'type'    => 'unit',
          'label'   => __( 'Back Delay', '__x__' ),
          'options' => $options_typing_effect_time_controls,
        ),
      ),
    ),
    array(
      'keys' => array(
        'text_typing_loop'   => $k_pre . 'text_typing_loop',
        'text_typing_cursor' => $k_pre . 'text_typing_cursor',
      ),
      'type'    => 'checkbox-list',
      'label'   => __( 'Enable', '__x__' ),
      'options' => array(
        'list' => array(
          array( 'key' => 'text_typing_loop',   'label' => __( 'Loop Typing', '__x__' ) ),
          array( 'key' => 'text_typing_cursor', 'label' => __( 'Show Cursor', '__x__' ) ),
        ),
      ),
    ),
    array(
      'key'       => $k_pre . 'text_typing_cursor_content',
      'type'      => 'text',
      'label'     => __( 'Cursor', '__x__' ),
      'condition' => array( $k_pre . 'text_typing_cursor' => true ),
    ),
    array(
      'type'     => 'group',
      'label'    => __( 'Color', '__x__' ),
      'controls' => array(
        array(
          'keys'    => array( 'value' => $k_pre . 'text_typing_color' ),
          'type'    => 'color',
          'label'   => __( 'Text', '__x__' ),
          'options' => array( 'label' => __( 'Text', '__x__' ) ),
        ),
        array(
          'keys'      => array( 'value' => $k_pre . 'text_typing_cursor_color' ),
          'type'      => 'color',
          'label'     => __( 'Cursor', '__x__' ),
          'options'   => array( 'label' => __( 'Cursor', '__x__' ) ),
          'condition' => array( $k_pre . 'text_typing_cursor' => true ),
        ),
      ),
    ),
  );


  // Standard Design Setup
  // ---------------------

  $control_list_text_std_design_setup = array();

  if ( $type === 'standard' ) {
    $control_list_text_std_design_setup[] = $control_text_font_size;
  }

  if ( $type === 'headline' ) {
    $control_list_text_std_design_setup[] = cs_amend_control( $control_text_base_font_size, array( 'type' => 'unit-slider' ) );
  }


  $control_list_text_std_design_setup[] = cs_amend_control( $control_text_width, array( 'type' => 'unit-slider' ) );
  $control_list_text_std_design_setup[] = cs_amend_control( $control_text_max_width, array( 'type' => 'unit-slider' ) );
  $control_list_text_std_design_setup[] = array(
    'key'   => $k_pre . 'text_text_align',
    'type'  => 'text-align',
    'label' => ( $type === 'standard' ) ? __( 'Text Align', '__x__' ) : __( 'Primary Text Align', '__x__' ),
  );

  if ( $type === 'headline' ) {
    $control_list_text_std_design_setup[] = array(
      'key'        => $k_pre . 'text_subheadline_text_align',
      'type'       => 'text-align',
      'label'      => __( 'Subheadline Text Align', '__x__' ),
      'conditions' => $conditions_text_subheadline,
    );
  }

  // Compose Controls
  // ----------------

  $controls = array();

  $controls = array(
    array(
      'type'       => 'group',
      'label'      => __( '{{prefix}} Setup', '__x__' ),
      'label_vars' => array( 'prefix' => $label_prefix ),
      'group'      => $group_text_setup,
      'controls'   => $control_list_text_adv_setup,
      'conditions' => $conditions,
    ),
  );

  if ( $type === 'standard' ) {
    $controls = array_merge(
      $controls,
      array(
        array(
          'type'       => 'group',
          'label'      => __( '{{prefix}} Text Column Setup', '__x__' ),
          'label_vars' => array( 'prefix' => $label_prefix ),
          'group'      => $group_text_setup,
          'conditions' => $conditions_text_columns,
          'controls'   => $control_list_text_adv_text_columns,
        ),
      )
    );
  }

  if ( $type === 'headline' ) {
    $controls = array_merge(
      $controls,
      array(
        array(
          'type'       => 'group',
          'label'      => __( '{{prefix}} Typing Setup', '__x__' ),
          'label_vars' => array( 'prefix' => $label_prefix ),
          'group'      => $group_text_setup,
          'conditions' => $conditions_text_typing_on,
          'controls'   => $control_list_text_adv_typing_setup,
        ),
      ),
      x_control_flexbox( $settings_text_flexbox )
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
      x_control_margin( $settings_text_content_margin )
    );
  }

  $controls = array_merge(
    $controls,
    x_control_text_format( $settings_text_text ),
    x_control_text_shadow( $settings_text_text )
  );

  if ( $type === 'headline' ) {
    $controls = array_merge(
      $controls,
      array(
        array(
          'type'       => 'group',
          'label'      => __( '{{prefix}} Subheadline Setup', '__x__' ),
          'label_vars' => array( 'prefix' => $label_prefix ),
          'group'      => $group_text_text,
          'conditions' => $conditions,
          'controls'   => array(
            $control_text_subheadline,
            $control_text_subheadline_content,
            $control_text_subheadline_tag,
            $control_text_subheadline_spacing_and_reverse
          ),
        ),
      ),
      x_control_text_format( $settings_text_subheadline_text ),
      x_control_text_shadow( $settings_text_subheadline_text )
    );
  }


  $controls_std_content = array();

  if ( $type === 'standard' ) {
    $controls_std_content = array(
      array(
        'type'       => 'group',
        'label'      => __( '{{prefix}} Content', '__x__' ),
        'label_vars' => array( 'prefix' => $label_prefix_std ),
        'conditions' => $conditions,
        'controls'   => array(
          cs_amend_control( $control_text_content_standard, array(
            'options' => array(
              'height' => 5,
              'disable_input_preview' => false
            )
          ) ),
        ),
      ),
    );
  }

  if ( $type === 'headline' ) {
    $controls_std_content = array(
      array(
        'type'       => 'group',
        'label'      => __( '{{prefix}} Primary Text', '__x__' ),
        'label_vars' => array( 'prefix' => $label_prefix_std ),
        'conditions' => $conditions,
        'controls'   => array(
          cs_amend_control( $control_text_content_headline, array(
            'options' => array(
              'height' => 4,
              'disable_input_preview' => false
            )
          ) ),
          $control_text_typing_prefix,
          cs_amend_control( $control_text_typing_content, array(
            'options' => array(
              'height' => 2,
            )
          ) ),
          $control_text_typing_suffix,
          $control_text_tag,
        ),
      ),
      array(
        'type'       => 'group',
        'label'      => __( '{{prefix}} Subheadline', '__x__' ),
        'label_vars' => array( 'prefix' => $label_prefix_std ),
        'conditions' => $conditions_text_subheadline,
        'controls'   => array(
          cs_amend_control( $control_text_subheadline_content, array(
            'options' => array(
              'height' => 4,
            )
          ) ),
          $control_text_subheadline_tag,
        ),
      ),
    );
  }

  $text_controls = array(
    'controls' => $controls,
    'controls_std_content' => $controls_std_content,
    'controls_std_design_setup' => array(
      array(
        array(
          'type'     => 'group',
          'label'      => __( '{{prefix}} Design Setup', '__x__' ),
          'label_vars' => array( 'prefix' => $label_prefix_std ),
          'controls' => $control_list_text_std_design_setup,
        ),
      ),
      cs_control( 'margin', $k_pre . 'text', array(
        'label_prefix' => $label_prefix_std,
        'conditions'    => $conditions,
      ) )
    ),
    'controls_std_design_colors' => array_merge(
      array(
        array(
          'type'     => 'group',
          'label'      => __( '{{prefix}} Base Colors', '__x__' ),
          'label_vars' => array( 'prefix' => $label_prefix_std ),
          'controls' => array(
            array(
              'keys'  => array( 'value' => $k_pre . 'text_text_color' ),
              'type'  => 'color',
              'label' => __( 'Text', '__x__' ),
            ),
            array(
              'keys'      => array( 'value' => $k_pre . 'text_text_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'condition' => array( 'key' => $k_pre . 'text_text_shadow_dimensions', 'op' => 'NOT EMPTY' )
            ),
            array(
              'keys'      => array( 'value' => $k_pre . 'text_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => $k_pre . 'text_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
            ),
            array(
              'keys'  => array( 'value' => $k_pre . 'text_bg_color' ),
              'type'  => 'color',
              'label' => __( 'Background', '__x__' ),
            ),
          ),
        ),
      ),
      x_control_border(
        array(
          'k_pre'        => $k_pre . 'text',
          'label'      => __( '{{prefix}} Base', '__x__' ),
          'label_vars' => array( 'prefix' => $label_prefix_std ),
          'options'   => array( 'color_only' => true ),
          'conditions' => array_merge( $conditions, array(
            array( 'key' => $k_pre . 'text_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => $k_pre . 'text_border_style', 'op' => '!=', 'value' => 'none' )
          ) ),
        )
      ),
      array(
        array(
          'type'       => 'group',
          'label'      => __( '{{prefix}} Text Columns Colors', '__x__' ),
          'label_vars' => array( 'prefix' => $label_prefix_std ),
          'conditions' => $conditions_text_columns,
          'controls'   => array(
            array(
              'keys'  => array( 'value' => $k_pre . 'text_columns_rule_color' ),
              'type'  => 'color',
              'label' => __( 'Columns Rule', '__x__' ),
            ),
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => __( '{{prefix}} Text Typing Colors', '__x__' ),
          'label_vars' => array( 'prefix' => $label_prefix_std ),
          'conditions' => $conditions_text_typing_on,
          'controls'   => array(
            array(
              'keys'  => array( 'value' => $k_pre . 'text_typing_color' ),
              'type'  => 'color',
              'label' => __( 'Typing Text', '__x__' ),
            ),
            array(
              'keys'  => array( 'value' => $k_pre . 'text_typing_cursor_color' ),
              'type'  => 'color',
              'label' => __( 'Typing Cursor', '__x__' ),
            ),
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => __( '{{prefix}} Subheadline Colors', '__x__' ),
          'label_vars' => array( 'prefix' => $label_prefix_std ),
          'conditions' => $conditions_text_subheadline,
          'controls'   => array(
            array(
              'keys'  => array( 'value' => $k_pre . 'text_subheadline_text_color' ),
              'type'  => 'color',
              'label' => __( 'Color', '__x__' ),
            ),
            array(
              'keys'      => array( 'value' => $k_pre . 'text_subheadline_text_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'condition' => array( 'key' => $k_pre . 'text_subheadline_text_shadow_dimensions', 'op' => 'NOT EMPTY' )
            ),
          ),
        ),
      )
    ),
    'control_nav' => array(
      $group             => $group_title,
      $group_text_setup  => __( 'Setup', '__x__' ),
      $group_text_design => __( 'Design', '__x__' ),
      $group_text_text   => __( 'Text', '__x__' )
    )
  );

  if ( $type === 'headline' ) {
    return cs_compose_controls(
      $text_controls,
      array(
        'control_nav' => array(
          $group_text_graphic => __( 'Graphic', '__x__' )
        )
      ),
      cs_partial_controls( 'graphic', array(
        'k_pre'               => $k_pre . 'text',
        'group'               => $group_text_graphic,
        'conditions'          => $conditions,
        'has_alt'             => false,
        'has_interactions'    => false,
        'has_sourced_content' => false,
        'has_toggle'          => false,
      ) )
    );
  }

  return $text_controls;
}

cs_register_control_partial( 'text', 'x_control_partial_text' );
