<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/SEARCH.PHP
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

function x_controls_search( $settings = array() ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'inline'
  //     -- 'modal'
  //     -- 'dropdown'

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'search';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();
  $type      = ( isset( $settings['type'] )      ) ? $settings['type']      : 'inline'; // 01

  $group_setup   = $group . ':setup';
  $group_design  = $group . ':design';
  $group_input   = $group . ':input';
  $group_submit  = $group . ':submit';
  $group_clear   = $group . ':clear';


  // Setup - Conditions
  // ------------------

  $conditions = x_module_conditions( $condition );


  // Setup - Options
  // ---------------

  $options_search_dimensions = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'fallback_value'  => '0px',
    'valid_keywords'  => array( 'auto', 'none' ),
  );

  $options_search_base_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'ranges'          => array(
      'px'  => array( 'min' => 10,  'max' => 54, 'step' => 1     ),
      'em'  => array( 'min' => 0.5, 'max' => 5,  'step' => 0.001 ),
      'rem' => array( 'min' => 0.5, 'max' => 5,  'step' => 0.001 ),
    ),
  );


  // Setup - Settings
  // ----------------

  $settings_search_design = array(
    'k_pre'      => 'search',
    'group'      => $group_design,
    'conditions' => $conditions,
    'alt_color'  => true,
    'options'    => array(
      'color' => array(
        'label'     => __( 'Base', '__x__' ),
        'alt_label' => __( 'Interaction', '__x__' ),
      ),
    ),
  );

  $settings_search_design_no_options = array(
    'k_pre'      => 'search',
    'group'      => $group_design,
    'conditions' => $conditions,
  );

  $settings_search_input = array(
    'k_pre'      => 'search_input',
    't_pre'      => __( 'Input', '__x__' ),
    'group'      => $group_input,
    'conditions' => $conditions,
    'alt_color'  => true,
    'options'    => array(
      'color' => array(
        'label'     => __( 'Base', '__x__' ),
        'alt_label' => __( 'Interaction', '__x__' ),
      ),
    ),
  );

  $settings_search_submit = array(
    'k_pre'      => 'search_submit',
    't_pre'      => __( 'Submit', '__x__' ),
    'group'      => $group_submit,
    'conditions' => $conditions,
    'alt_color'  => true,
    'options'    => array(
      'color' => array(
        'label'     => __( 'Base', '__x__' ),
        'alt_label' => __( 'Interaction', '__x__' ),
      ),
    ),
  );

  $settings_search_clear = array(
    'k_pre'      => 'search_clear',
    't_pre'      => __( 'Clear', '__x__' ),
    'group'      => $group_clear,
    'conditions' => $conditions,
    'alt_color'  => true,
    'options'    => array(
      'color' => array(
        'label'     => __( 'Base', '__x__' ),
        'alt_label' => __( 'Interaction', '__x__' ),
      ),
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
            'key'     => 'search_base_font_size',
            'type'    => 'slider',
            'label'   => __( 'Base Font Size', '__x__' ),
            'options' => $options_search_base_font_size,
          ),
          array(
            'key'     => 'search_width',
            'type'    => 'unit',
            'label'   => __( 'Width', '__x__' ),
            'options' => $options_search_dimensions,
          ),
          array(
            'key'     => 'search_height',
            'type'    => 'unit',
            'label'   => __( 'Height', '__x__' ),
            'options' => $options_search_dimensions,
          ),
          array(
            'key'     => 'search_max_width',
            'type'    => 'unit',
            'label'   => __( 'Max Width', '__x__' ),
            'options' => $options_search_dimensions,
          ),
          array(
            'keys' => array(
              'value' => 'search_bg_color',
              'alt'   => 'search_bg_color_alt',
            ),
            'type'    => 'color',
            'label'   => __( 'Background', '__x__' ),
            'options' => array(
              'label'     => __( 'Base', '__x__' ),
              'alt_label' => __( 'Interaction', '__x__' ),
            ),
          ),
        ),
      ),
      array(
        'type'       => 'group',
        'title'      => __( 'Content', '__x__' ),
        'group'      => $group_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'   => 'search_placeholder',
            'type'  => 'text',
            'label' => __( 'Placeholder', '__x__' ),
          ),
          array(
            'key'     => 'search_order_input',
            'type'    => 'choose',
            'label'   => __( 'Input Placement', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => '1', 'label' => __( '1st', '__x__' ) ),
                array( 'value' => '2', 'label' => __( '2nd', '__x__' ) ),
                array( 'value' => '3', 'label' => __( '3rd', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'     => 'search_order_submit',
            'type'    => 'choose',
            'label'   => __( 'Submit Placement', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => '1', 'label' => __( '1st', '__x__' ) ),
                array( 'value' => '2', 'label' => __( '2nd', '__x__' ) ),
                array( 'value' => '3', 'label' => __( '3rd', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'     => 'search_order_clear',
            'type'    => 'choose',
            'label'   => __( 'Clear Placement', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => '1', 'label' => __( '1st', '__x__' ) ),
                array( 'value' => '2', 'label' => __( '2nd', '__x__' ) ),
                array( 'value' => '3', 'label' => __( '3rd', '__x__' ) ),
              ),
            ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_search_design_no_options ),
    x_control_border( $settings_search_design ),
    x_control_border_radius( $settings_search_design_no_options ),
    x_control_box_shadow( $settings_search_design ),
    x_control_margin( $settings_search_input ),
    x_control_text_format( $settings_search_input ),
    x_control_text_style( $settings_search_input ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Submit Setup', '__x__' ),
        'group'      => $group_submit,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'   => 'search_submit_font_size',
            'type'  => 'slider',
            'label' => __( 'Font Size', '__x__' ),
          ),
          array(
            'key'     => 'search_submit_stroke_width',
            'type'    => 'choose',
            'label'   => __( 'Stroke Width', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 1, 'label' => '1' ),
                array( 'value' => 2, 'label' => '2' ),
                array( 'value' => 3, 'label' => '3' ),
                array( 'value' => 4, 'label' => '4' ),
              ),
            ),
          ),
          array(
            'type'     => 'group',
            'title'    => __( 'Width &amp; Height', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'search_submit_width',
                'type'    => 'unit',
                'options' => array(
                  'available_units' => array( 'px', 'em', 'rem' ),
                  'fallback_value'  => '1em',
                ),
              ),
              array(
                'key'     => 'search_submit_height',
                'type'    => 'unit',
                'options' => array(
                  'available_units' => array( 'px', 'em', 'rem' ),
                  'fallback_value'  => '1em',
                ),
              ),
            ),
          ),
          array(
            'keys' => array(
              'value' => 'search_submit_color',
              'alt'   => 'search_submit_color_alt',
            ),
            'type'    => 'color',
            'label'   => __( 'Color', '__x__' ),
            'options' => array(
              'label'     => __( 'Base', '__x__' ),
              'alt_label' => __( 'Interaction', '__x__' ),
            ),
          ),
          array(
            'keys' => array(
              'value' => 'search_submit_bg_color',
              'alt'   => 'search_submit_bg_color_alt',
            ),
            'type'    => 'color',
            'label'   => __( 'Background', '__x__' ),
            'options' => array(
              'label'     => __( 'Base', '__x__' ),
              'alt_label' => __( 'Interaction', '__x__' ),
            ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_search_submit ),
    x_control_border( $settings_search_submit ),
    x_control_border_radius( $settings_search_submit ),
    x_control_box_shadow( $settings_search_submit ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Clear Setup', '__x__' ),
        'group'      => $group_clear,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'   => 'search_clear_font_size',
            'type'  => 'slider',
            'label' => __( 'Font Size', '__x__' ),
          ),
          array(
            'key'     => 'search_clear_stroke_width',
            'type'    => 'choose',
            'label'   => __( 'Stroke Width', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 1, 'label' => '1' ),
                array( 'value' => 2, 'label' => '2' ),
                array( 'value' => 3, 'label' => '3' ),
                array( 'value' => 4, 'label' => '4' ),
              ),
            ),
          ),
          array(
            'type'     => 'group',
            'title'    => __( 'Width &amp; Height', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'search_clear_width',
                'type'    => 'unit',
                'options' => array(
                  'available_units' => array( 'px', 'em', 'rem' ),
                  'fallback_value'  => '1em',
                ),
              ),
              array(
                'key'     => 'search_clear_height',
                'type'    => 'unit',
                'options' => array(
                  'available_units' => array( 'px', 'em', 'rem' ),
                  'fallback_value'  => '1em',
                ),
              ),
            ),
          ),
          array(
            'keys' => array(
              'value' => 'search_clear_color',
              'alt'   => 'search_clear_color_alt',
            ),
            'type'    => 'color',
            'label'   => __( 'Color', '__x__' ),
            'options' => array(
              'label'     => __( 'Base', '__x__' ),
              'alt_label' => __( 'Interaction', '__x__' ),
            ),
          ),
          array(
            'keys' => array(
              'value' => 'search_clear_bg_color',
              'alt'   => 'search_clear_bg_color_alt',
            ),
            'type'    => 'color',
            'label'   => __( 'Background', '__x__' ),
            'options' => array(
              'label'     => __( 'Base', '__x__' ),
              'alt_label' => __( 'Interaction', '__x__' ),
            ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_search_clear ),
    x_control_border( $settings_search_clear ),
    x_control_border_radius( $settings_search_clear ),
    x_control_box_shadow( $settings_search_clear )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_search( $settings = array() ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'inline'
  //     -- 'modal'

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'search';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Search', '__x__' );
  $type        = ( isset( $settings['type'] )        ) ? $settings['type']        : 'inline'; // 01

  $control_groups = array(
    $group             => array( 'title' => $group_title ),
    $group . ':setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design' => array( 'title' => __( 'Design', '__x__' ) ),
    $group . ':input'  => array( 'title' => __( 'Input', '__x__' ) ),
    $group . ':submit' => array( 'title' => __( 'Submit', '__x__' ) ),
    $group . ':clear'  => array( 'title' => __( 'Clear', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_search( $settings = array() ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'inline'
  //     -- 'modal'
  //     -- 'dropdown'

  $type = ( isset( $settings['type'] ) ) ? $settings['type'] : 'inline'; // 01


  // Values
  // ------

  $values = array(

    'search_type'                         => x_module_value( $type, 'all' ),

    'search_placeholder'                  => x_module_value( __( 'Search', '__x__' ), 'markup', true ),
    'search_order_input'                  => x_module_value( '2', 'style' ),
    'search_order_submit'                 => x_module_value( '1', 'style' ),
    'search_order_clear'                  => x_module_value( '3', 'style' ),

    'search_base_font_size'               => x_module_value( '1em', 'style' ),
    'search_width'                        => x_module_value( '100%', 'style' ),
    'search_height'                       => x_module_value( 'auto', 'style' ),
    'search_max_width'                    => x_module_value( 'none', 'style' ),
    'search_bg_color'                     => x_module_value( '#ffffff', 'style:color' ),
    'search_bg_color_alt'                 => x_module_value( '#ffffff', 'style:color' ),

    'search_margin'                       => x_module_value( '0em', 'style' ),
    'search_border_width'                 => x_module_value( '0px', 'style' ),
    'search_border_style'                 => x_module_value( 'none', 'style' ),
    'search_border_color'                 => x_module_value( 'transparent', 'style:color' ),
    'search_border_color_alt'             => x_module_value( 'transparent', 'style:color' ),
    'search_border_radius'                => x_module_value( '100em', 'style' ),
    'search_box_shadow_dimensions'        => x_module_value( '0em 0.15em 0.5em 0em', 'style' ),
    'search_box_shadow_color'             => x_module_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
    'search_box_shadow_color_alt'         => x_module_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),

    'search_input_margin'                 => x_module_value( '0em', 'style' ),
    'search_input_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
    'search_input_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
    'search_input_font_size'              => x_module_value( '1em', 'style' ),
    'search_input_letter_spacing'         => x_module_value( '0em', 'style' ),
    'search_input_line_height'            => x_module_value( '1.3', 'style' ),
    'search_input_font_style'             => x_module_value( 'normal', 'style' ),
    'search_input_text_align'             => x_module_value( 'none', 'style' ),
    'search_input_text_decoration'        => x_module_value( 'none', 'style' ),
    'search_input_text_transform'         => x_module_value( 'none', 'style' ),
    'search_input_text_color'             => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'search_input_text_color_alt'         => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),

    'search_submit_font_size'             => x_module_value( '1em', 'style' ),
    'search_submit_stroke_width'          => x_module_value( '2', 'markup' ),
    'search_submit_width'                 => x_module_value( '1em', 'style' ),
    'search_submit_height'                => x_module_value( '1em', 'style' ),
    'search_submit_color'                 => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'search_submit_color_alt'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'search_submit_bg_color'              => x_module_value( 'transparent', 'style:color' ),
    'search_submit_bg_color_alt'          => x_module_value( 'transparent', 'style:color' ),
    'search_submit_margin'                => x_module_value( '0.5em 0.5em 0.5em 0.9em', 'style' ),
    'search_submit_border_style'          => x_module_value( 'none', 'style' ),
    'search_submit_border_width'          => x_module_value( '0px', 'style' ),
    'search_submit_border_color'          => x_module_value( 'transparent', 'style:color' ),
    'search_submit_border_color_alt'      => x_module_value( 'transparent', 'style:color' ),
    'search_submit_border_radius'         => x_module_value( '0em', 'style' ),
    'search_submit_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
    'search_submit_box_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
    'search_submit_box_shadow_color_alt'  => x_module_value( 'transparent', 'style:color' ),

    'search_clear_font_size'              => x_module_value( '0.9em', 'style' ),
    'search_clear_stroke_width'           => x_module_value( '3', 'markup' ),
    'search_clear_width'                  => x_module_value( '2em', 'style' ),
    'search_clear_height'                 => x_module_value( '2em', 'style' ),
    'search_clear_color'                  => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'search_clear_color_alt'              => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'search_clear_bg_color'               => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'search_clear_bg_color_alt'           => x_module_value( 'rgba(0, 0, 0, 0.3)', 'style:color' ),
    'search_clear_margin'                 => x_module_value( '0.5em', 'style' ),
    'search_clear_border_style'           => x_module_value( 'none', 'style' ),
    'search_clear_border_width'           => x_module_value( '0px', 'style' ),
    'search_clear_border_color'           => x_module_value( 'transparent', 'style:color' ),
    'search_clear_border_color_alt'       => x_module_value( 'transparent', 'style:color' ),
    'search_clear_border_radius'          => x_module_value( '100em', 'style' ),
    'search_clear_box_shadow_dimensions'  => x_module_value( '0em 0em 0em 0em', 'style' ),
    'search_clear_box_shadow_color'       => x_module_value( 'transparent', 'style:color' ),
    'search_clear_box_shadow_color_alt'   => x_module_value( 'transparent', 'style:color' ),

  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
