<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/SEARCH.PHP
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

function x_control_partial_search( $settings ) {



  // Setup
  // -----

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'search';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Search', '__x__' );
  $conditions  = ( isset( $settings['conditions'] )  ) ? $settings['conditions']  : array();




  // Groups
  // ------

  $group_search_setup   = $group . ':setup';
  $group_search_design  = $group . ':design';
  $group_search_input   = $group . ':input';
  $group_search_submit  = $group . ':submit';
  $group_search_clear   = $group . ':clear';



  // Options
  // -------

  $options_search_dimensions = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'fallback_value'  => '0px',
    'valid_keywords'  => array( 'auto', 'none' ),
  );

  $options_search_order = array(
    'choices' => array(
      array( 'value' => '1', 'label' => __( '1st', '__x__' ) ),
      array( 'value' => '2', 'label' => __( '2nd', '__x__' ) ),
      array( 'value' => '3', 'label' => __( '3rd', '__x__' ) ),
    ),
  );

  $options_search_icons_stroke_width = array(
    'choices' => array(
      array( 'value' => 1, 'label' => '1' ),
      array( 'value' => 2, 'label' => '2' ),
      array( 'value' => 3, 'label' => '3' ),
      array( 'value' => 4, 'label' => '4' ),
    ),
  );

  $options_search_button_dimensions = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'fallback_value'  => '1em',
  );



  // Settings
  // --------

  $settings_search_design = array(
    'k_pre'      => 'search',
    'group'      => $group_search_design,
    'conditions' => $conditions,
    'alt_color'  => true,
    'options'    => cs_recall( 'options_color_base_interaction_labels' ),
  );

  $settings_search_design_no_options = array(
    'k_pre'      => 'search',
    'group'      => $group_search_design,
    'conditions' => $conditions,
  );

  $settings_search_input = array(
    'k_pre'      => 'search_input',
    'label_prefix'      => __( 'Input', '__x__' ),
    'group'      => $group_search_input,
    'conditions' => $conditions,
    'alt_color'  => true,
    'options'    => cs_recall( 'options_color_base_interaction_labels' ),
  );

  $settings_search_submit = array(
    'k_pre'      => 'search_submit',
    'label_prefix'      => __( 'Submit', '__x__' ),
    'group'      => $group_search_submit,
    'conditions' => $conditions,
    'alt_color'  => true,
    'options'    => cs_recall( 'options_color_base_interaction_labels' ),
  );

  $settings_search_clear = array(
    'k_pre'      => 'search_clear',
    'label_prefix'      => __( 'Clear', '__x__' ),
    'group'      => $group_search_clear,
    'conditions' => $conditions,
    'alt_color'  => true,
    'options'    => cs_recall( 'options_color_base_interaction_labels' ),
  );


  // Individual Controls
  // =============================================================================

  $control_search_base_font_size = array(
    'key'     => 'search_base_font_size',
    'type'    => 'slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'ranges'          => array(
        'px'  => array( 'min' => 10,  'max' => 54, 'step' => 1     ),
        'em'  => array( 'min' => 0.5, 'max' => 5,  'step' => 0.001 ),
        'rem' => array( 'min' => 0.5, 'max' => 5,  'step' => 0.001 ),
      ),
    ),
  );

  $control_search_width = array(
    'key'     => 'search_width',
    'type'    => 'unit',
    'label'   => __( 'Width', '__x__' ),
    'options' => $options_search_dimensions,
  );

  $control_search_height = array(
    'key'     => 'search_height',
    'type'    => 'unit',
    'label'   => __( 'Height', '__x__' ),
    'options' => $options_search_dimensions,
  );

  $control_search_max_width = array(
    'key'     => 'search_max_width',
    'type'    => 'unit',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => $options_search_dimensions,
  );

  $control_search_bg_color = array(
    'keys' => array(
      'value' => 'search_bg_color',
      'alt'   => 'search_bg_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' ),
    'options' => cs_recall( 'options_base_interaction_labels' ),
  );

  $control_search_placeholder = array(
    'key'   => 'search_placeholder',
    'type'  => 'text',
    'label' => __( 'Placeholder', '__x__' ),
  );

  $control_search_order_input = array(
    'key'     => 'search_order_input',
    'type'    => 'choose',
    'label'   => __( 'Input Placement', '__x__' ),
    'options' => $options_search_order,
  );

  $control_search_order_submit = array(
    'key'     => 'search_order_submit',
    'type'    => 'choose',
    'label'   => __( 'Submit Placement', '__x__' ),
    'options' => $options_search_order,
  );

  $control_search_order_clear = array(
    'key'     => 'search_order_clear',
    'type'    => 'choose',
    'label'   => __( 'Clear Placement', '__x__' ),
    'options' => $options_search_order,
  );

  $control_search_submit_font_size = array(
    'key'   => 'search_submit_font_size',
    'type'  => 'unit-slider',
    'label' => __( 'Font Size', '__x__' ),
  );

  $control_search_submit_stroke_width = array(
    'key'     => 'search_submit_stroke_width',
    'type'    => 'choose',
    'label'   => __( 'Stroke Width', '__x__' ),
    'options' => $options_search_icons_stroke_width,
  );

  $control_search_submit_width = array(
    'key'     => 'search_submit_width',
    'type'    => 'unit',
    'options' => $options_search_button_dimensions,
  );

  $control_search_submit_height = array(
    'key'     => 'search_submit_height',
    'type'    => 'unit',
    'options' => $options_search_button_dimensions,
  );

  $control_search_submit_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Height', '__x__' ),
    'controls' => array(
      $control_search_submit_width,
      $control_search_submit_height,
    ),
  );

  $control_search_submit_colors = array(
    'keys' => array(
      'value' => 'search_submit_color',
      'alt'   => 'search_submit_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Color', '__x__' ),
    'options' => cs_recall( 'options_base_interaction_labels' ),
  );

  $control_search_submit_bg_colors = array(
    'keys' => array(
      'value' => 'search_submit_bg_color',
      'alt'   => 'search_submit_bg_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' ),
    'options' => cs_recall( 'options_base_interaction_labels' ),
  );

  $control_search_clear_font_size = array(
    'key'   => 'search_clear_font_size',
    'type'  => 'unit-slider',
    'label' => __( 'Font Size', '__x__' ),
  );

  $control_search_clear_stroke_width = array(
    'key'     => 'search_clear_stroke_width',
    'type'    => 'choose',
    'label'   => __( 'Stroke Width', '__x__' ),
    'options' => $options_search_icons_stroke_width,
  );

  $control_search_clear_width = array(
    'key'     => 'search_clear_width',
    'type'    => 'unit',
    'options' => $options_search_button_dimensions,
  );

  $control_search_clear_height = array(
    'key'     => 'search_clear_height',
    'type'    => 'unit',
    'options' => $options_search_button_dimensions,
  );

  $control_search_clear_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Height', '__x__' ),
    'controls' => array(
      $control_search_clear_width,
      $control_search_clear_height,
    ),
  );

  $control_search_clear_colors = array(
    'keys' => array(
      'value' => 'search_clear_color',
      'alt'   => 'search_clear_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Color', '__x__' ),
    'options' => cs_recall( 'options_base_interaction_labels' ),
  );

  $control_search_clear_bg_colors = array(
    'keys' => array(
      'value' => 'search_clear_bg_color',
      'alt'   => 'search_clear_bg_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' ),
    'options' => cs_recall( 'options_base_interaction_labels' ),
  );

  // Compose Controls
  // ----------------

  return array(
    'controls' => array_merge(
      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => $group_search_setup,
          'conditions' => $conditions,
          'controls'   => array(
            $control_search_base_font_size,
            $control_search_width,
            $control_search_height,
            $control_search_max_width,
            $control_search_bg_color,
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => __( 'Content', '__x__' ),
          'group'      => $group_search_setup,
          'conditions' => $conditions,
          'controls'   => array(
            $control_search_placeholder,
            $control_search_order_input,
            $control_search_order_submit,
            $control_search_order_clear,
          ),
        ),
      ),

      x_control_margin( $settings_search_design_no_options ),
      x_control_border( $settings_search_design ),
      x_control_border_radius( $settings_search_design_no_options ),
      x_control_box_shadow( $settings_search_design ),

      x_control_margin( $settings_search_input ),
      x_control_text_format( $settings_search_input ),

      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Submit Setup', '__x__' ),
          'group'      => $group_search_submit,
          'conditions' => $conditions,
          'controls'   => array(
            $control_search_submit_font_size,
            $control_search_submit_stroke_width,
            $control_search_submit_width_and_height,
            $control_search_submit_colors,
            $control_search_submit_bg_colors,
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
          'label'      => __( 'Clear Setup', '__x__' ),
          'group'      => $group_search_clear,
          'conditions' => $conditions,
          'controls'   => array(
            $control_search_clear_font_size,
            $control_search_clear_stroke_width,
            $control_search_clear_width_and_height,
            $control_search_clear_colors,
            $control_search_clear_bg_colors,
          ),
        ),
      ),

      x_control_margin( $settings_search_clear ),
      x_control_border( $settings_search_clear ),
      x_control_border_radius( $settings_search_clear ),
      x_control_box_shadow( $settings_search_clear )

    ),
    'controls_std_content' => array(
      array(
        'type'       => 'group',
        'label'      => __( 'Search Content', '__x__' ),
        'conditions' => $conditions,
        'controls'   => array(
          $control_search_placeholder,
        ),
      ),
    ),
    'controls_std_design_setup' => array(
      array(
        'type'       => 'group',
        'label'      => __( 'Search Design Content', '__x__' ),
        'conditions' => $conditions,
        'controls'   => array(
          $control_search_base_font_size,
          $control_search_width,
          $control_search_height,
          $control_search_max_width,
        ),
      ),
      cs_control( 'margin', 'search', array(
        'label_prefix' => __( 'Search', '__x__' ),
        'conditions'   => $conditions,
      ) )
    ),
    'controls_std_design_colors' => array_merge(
      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Search Base Colors', '__x__' ),
          'group'      => $group,
          'conditions' => $conditions,
          'controls'   => array(
            array(
              'keys' => array(
                'value' => 'search_input_text_color',
                'alt'   => 'search_input_text_color_alt',
              ),
              'type'    => 'color',
              'label'   => __( 'Text', '__x__' ),
              'options' => cs_recall( 'options_base_interaction_labels' ),
            ),
            array(
              'keys' => array(
                'value' => 'search_box_shadow_color',
                'alt'   => 'search_box_shadow_color_alt',
              ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'options'   => cs_recall( 'options_base_interaction_labels' ),
              'condition' => array( 'key' => 'search_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
            ),
            $control_search_bg_color,
          ),
        ),
      ),
      x_control_border(
        array_merge(
          $settings_search_design,
          array(
            'label_prefix'     => __( 'Search', '__x__' ),
            'options'   => cs_recall( 'options_color_base_interaction_labels_color_only' ),
            'conditions' => array_merge( $conditions, array(
              array( 'key' => 'search_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => 'search_border_style', 'op' => '!=', 'value' => 'none' )
            ) ),
          )
        )
      ),
      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Search Submit Colors', '__x__' ),
          'group'      => $group,
          'conditions' => $conditions,
          'controls'   => array(
            $control_search_submit_colors,
            array(
              'keys' => array(
                'value' => 'search_submit_box_shadow_color',
                'alt'   => 'search_submit_box_shadow_color_alt',
              ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'options'   => cs_recall( 'options_base_interaction_labels' ),
              'condition' => array( 'key' => 'search_submit_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
            ),
            $control_search_submit_bg_colors,
          ),
        ),
      ),
      x_control_border(
        array_merge(
          $settings_search_submit,
          array(
            'label_prefix'     => __( 'Search Submit', '__x__' ),
            'options'   => cs_recall( 'options_color_base_interaction_labels_color_only' ),
            'conditions' => array_merge( $conditions, array(
              array( 'key' => 'search_submit_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => 'search_submit_border_style', 'op' => '!=', 'value' => 'none' )
            ) ),
          )
        )
      ),
      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Search Clear Colors', '__x__' ),
          'group'      => $group,
          'conditions' => $conditions,
          'controls'   => array(
            $control_search_clear_colors,
            array(
              'keys' => array(
                'value' => 'search_clear_box_shadow_color',
                'alt'   => 'search_clear_box_shadow_color_alt',
              ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'options'   => cs_recall( 'options_base_interaction_labels' ),
              'condition' => array( 'key' => 'search_clear_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
            ),
            $control_search_clear_bg_colors,
          ),
        ),
      ),
      x_control_border(
        array_merge(
          $settings_search_clear,
          array(
            'label_prefix'     => __( 'Search Clear', '__x__' ),
            'options'   => cs_recall( 'options_color_base_interaction_labels_color_only' ),
            'conditions' => array_merge( $conditions, array(
              array( 'key' => 'search_clear_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => 'search_clear_border_style', 'op' => '!=', 'value' => 'none' )
            ) ),
          )
        )
      )
    ),
    'control_nav' => array(
      $group               => $group_title,
      $group_search_setup  => __( 'Setup', '__x__' ),
      $group_search_design => __( 'Design', '__x__' ),
      $group_search_input  => __( 'Input', '__x__' ),
      $group_search_submit => __( 'Submit', '__x__' ),
      $group_search_clear  => __( 'Clear', '__x__' ),
    )
  );
}

cs_register_control_partial( 'search', 'x_control_partial_search' );
