<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/GRAPHIC.PHP
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

function x_control_partial_graphic( $settings ) {


  // Setup
  // -----

  $label_prefix        = ( isset( $settings['label_prefix'] )        ) ? $settings['label_prefix']        : '';
  $label_prefix_std    = ( isset( $settings['label_prefix_std'] )    ) ? $settings['label_prefix_std']    : $label_prefix;
  $k_pre               = ( isset( $settings['k_pre'] )               ) ? $settings['k_pre'] . '_'         : '';
  $group               = ( isset( $settings['group'] )               ) ? $settings['group']               : 'general';
  $conditions          = ( isset( $settings['conditions'] )          ) ? $settings['conditions']          : array();
  $has_alt             = ( isset( $settings['has_alt'] )             ) ? $settings['has_alt']             : false;
  $has_interactions    = ( isset( $settings['has_interactions'] )    ) ? $settings['has_interactions']    : false;
  $has_sourced_content = ( isset( $settings['has_sourced_content'] ) ) ? $settings['has_sourced_content'] : false;
  $has_toggle          = ( isset( $settings['has_toggle'] )          ) ? $settings['has_toggle']          : false;
  $controls_setup      = ( isset( $settings['controls_setup'] )      ) ? $settings['controls_setup']      : array();


  // Conditions
  // ----------

  $conditions_graphic_main      = array_merge( $conditions, array( array( $k_pre . 'graphic' => true ) ) );
  $conditions_graphic_icon      = array_merge( $conditions, array( array( $k_pre . 'graphic' => true ) ), array( array( $k_pre . 'graphic_type' => 'icon' ) ) );
  $conditions_graphic_icon_alt  = array_merge( $conditions, array( array( $k_pre . 'graphic' => true ) ), array( array( $k_pre . 'graphic_type' => 'icon' ) ), array( array( $k_pre . 'graphic_icon_alt_enable' => 'icon' ) ) );
  $conditions_graphic_image     = array_merge( $conditions, array( array( $k_pre . 'graphic' => true ) ), array( array( $k_pre . 'graphic_type' => 'image' ) ) );
  $conditions_graphic_image_alt = array_merge( $conditions, array( array( $k_pre . 'graphic' => true ) ), array( array( $k_pre . 'graphic_type' => 'image' ) ), array( array( $k_pre . 'graphic_image_alt_enable' => true ) ) );
  $conditions_graphic_toggle    = array_merge( $conditions, array( array( $k_pre . 'graphic' => true ) ), array( array( $k_pre . 'graphic_type' => 'toggle' ) ) );



  // Options
  // -------

  $options_graphic_type_choices = array(
    array( 'value' => 'icon',  'icon' => 'flag' ),
    array( 'value' => 'image', 'icon' => 'image' ),
  );

  if ( $has_toggle ) {
    $options_graphic_type_choices[] = array( 'value' => 'toggle', 'icon' => 'bars' );
  }

  $options_graphic_icon_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'fallback_value'  => '1em',
  );



  // Settings
  // --------

  $settings_graphic_margin = array(
    'k_pre'        => $k_pre . 'graphic',
    'label_prefix' => sprintf( __( '%s Graphic', '__x__' ), $label_prefix ),
    'group'        => $group,
    'conditions'   => $conditions_graphic_main,
  );

  $settings_graphic_icon_border_radius = array(
    'k_pre'        => $k_pre . 'graphic_icon',
    'label_prefix' => sprintf( __( '%s Graphic Icon', '__x__' ), $label_prefix ),
    'group'        => $group,
    'conditions'   => $conditions_graphic_icon,
  );

  $settings_graphic_icon_variable_alt_color = array(
    'k_pre'            => $k_pre . 'graphic_icon',
    'label_prefix'     => sprintf( __( '%s Graphic Icon', '__x__' ), $label_prefix ),
    'label_prefix_std' => sprintf( __( '%s Graphic Icon', '__x__' ), $label_prefix_std ),
    'group'            => $group,
    'conditions'       => $conditions_graphic_icon,
    'options'          => array()
  );

  $settings_graphic_icon_variable_alt_color_std = array_merge(
    $settings_graphic_icon_variable_alt_color,
    array(
      'options' => array( 'color_only' => true )
    )
  );

  if ( $has_alt === true ) {
    $settings_graphic_icon_variable_alt_color['alt_color'] = true;
    $settings_graphic_icon_variable_alt_color_std['alt_color'] = true;

    $settings_graphic_icon_variable_alt_color['options'] = array_merge(
      $settings_graphic_icon_variable_alt_color['options'],
      cs_recall( 'options_color_base_interaction_labels' )
    );

    $settings_graphic_icon_variable_alt_color_std['options'] = array_merge(
      $settings_graphic_icon_variable_alt_color_std['options'],
      cs_recall( 'options_color_base_interaction_labels_color_only' )
    );

  }


  // Individual Controls
  // -------------------

  $control_graphic = array(
    'key'     => $k_pre . 'graphic',
    'type'    => 'choose',
    'label'   => __( 'Enable', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_graphic_type = array(
    'key'        => $k_pre . 'graphic_type',
    'type'       => 'choose',
    'label'      => __( 'Type', '__x__' ),
    'conditions' => $conditions_graphic_main,
    'options'    => array(
      'choices'  => $options_graphic_type_choices,
    ),
  );

  $control_graphic_interaction = array(
    'key'        => $k_pre . 'graphic_interaction',
    'type'       => 'select',
    'label'      => __( 'Icon &amp; Img Interaction', '__x__' ),
    'conditions' => $conditions_graphic_main,
    'options'    => array(
      'choices' => array(
        array( 'value' => 'none',                'label' => __( 'None', '__x__' )       ),
        array( 'value' => 'x-anchor-scale-up',   'label' => __( 'Scale Up', '__x__' )   ),
        array( 'value' => 'x-anchor-scale-down', 'label' => __( 'Scale Down', '__x__' ) ),
        array( 'value' => 'x-anchor-flip-x',     'label' => __( 'Flip X', '__x__' )     ),
        array( 'value' => 'x-anchor-flip-y',     'label' => __( 'Flip Y', '__x__' )     ),
      )
    ),
  );

  $control_graphic_icon_first_line = array(
    'key'     => $k_pre . 'graphic_icon_font_size',
    'type'    => 'unit',
    'label'   => __( 'Font Size', '__x__' ),
    'options' => $options_graphic_icon_font_size,
  );

  $control_graphic_icon_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Height', '__x__' ),
    'controls' => array(
      array(
        'key'     => $k_pre . 'graphic_icon_width',
        'type'    => 'unit',
        'options' => array(
          'available_units' => array( 'px', 'em', 'rem' ),
          'valid_keywords'  => array( 'auto', 'calc' ),
          'fallback_value'  => '1em',
        ),
      ),
      array(
        'key'     => $k_pre . 'graphic_icon_height',
        'type'    => 'unit',
        'options' => array(
          'available_units' => array( 'px', 'em', 'rem' ),
          'valid_keywords'  => array( 'auto', 'calc' ),
          'fallback_value'  => '1em',
        ),
      ),
    ),
  );

  $control_graphic_icon_color = array(
    'keys'  => array( 'value' => $k_pre . 'graphic_icon_color' ),
    'type'  => 'color',
    'label' => __( 'Color', '__x__' ),
  );

  $control_graphic_icon_bg_color = array(
    'keys'  => array( 'value' => $k_pre . 'graphic_icon_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  if ( $has_alt ) {

    $control_graphic_icon_first_line = array(
      'type'     => 'group',
      'label'    => __( 'Font Size &amp; Secondary', '__x__' ),
      'controls' => array(
        array(
          'key'     => $k_pre . 'graphic_icon_font_size',
          'type'    => 'unit',
          'options' => $options_graphic_icon_font_size,
        ),
        array(
          'keys' => array(
            'icon_alt_on' => $k_pre . 'graphic_icon_alt_enable',
          ),
          'type'    => 'checkbox-list',
          'options' => array(
            'list' => array(
              array( 'key' => 'icon_alt_on', 'label' => __( 'Secondary', '__x__' ) ),
            ),
          ),
        ),
      ),
    );

    $control_graphic_icon_color['keys']['alt'] = $k_pre . 'graphic_icon_color_alt';
    $control_graphic_icon_color['options']     = cs_recall( 'options_base_interaction_labels' );

    $control_graphic_icon_bg_color['keys']['alt'] = $k_pre . 'graphic_icon_bg_color_alt';
    $control_graphic_icon_bg_color['options']     = cs_recall( 'options_base_interaction_labels' );

  }

  $control_graphic_image_max_width = array(
    'key'     => $k_pre . 'graphic_image_max_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
      'valid_keywords'  => array( 'none', 'calc' ),
      'fallback_value'  => 'none',
      'ranges'          => array(
        'px'  => array( 'min' => 20, 'max' => 40,  'step' => 1    ),
        'em'  => array( 'min' => 1,  'max' => 2.5, 'step' => 0.01 ),
        'rem' => array( 'min' => 1,  'max' => 2.5, 'step' => 0.01 ),
        '%'   => array( 'min' => 1,  'max' => 100, 'step' => 1    ),
        'vw'  => array( 'min' => 1,  'max' => 100, 'step' => 1    ),
        'vh'  => array( 'min' => 1,  'max' => 100, 'step' => 1    ),
      ),
    ),
  );

  $control_graphic_local_image_secondary_enable = array(
    'keys' => array(
      'image_alt_on' => $k_pre . 'graphic_image_alt_enable',
    ),
    'type'    => 'checkbox-list',
    'label'   => __( 'Enable', '__x__' ),
    'options' => array(
      'list' => array(
        array( 'key' => 'image_alt_on', 'label' => __( 'Secondary', '__x__' ) ),
      ),
    ),
  );

  $control_graphic_local_image_secondary = array(
    'key'        => $k_pre . 'graphic_image_src_alt',
    'type'       => 'image-source',
    'label'      => __( 'Source', '__x__' ),
    'conditions' => $conditions_graphic_image_alt,
    'options'    => array(
      'height' => 3,
    ),
  );

  // cs_amend_control( $control_graphic_local_image_secondary, array( 'options' => array( 'height' => 4 ) ) )

  $control_graphic_local_image_secondary_alt_text = array(
    'key'        => $k_pre . 'graphic_image_alt_alt',
    'type'       => 'text',
    'label'      => __( 'Alt Text', '__x__' ),
    'conditions' => $conditions_graphic_image_alt,
    'options'    => array(
      'placeholder' => __( 'Describe Your Image', '__x__' ),
    ),
  );

  $control_graphic_std_icon_border_color = array(
    'keys'  => array( 'value' => $k_pre . 'graphic_icon_border_color' ),
    'type'  => 'color',
    'label' => __( 'Border', '__x__' ),
  );

  $control_graphic_std_icon_text_shadow_color = array(
    'keys'      => array( 'value' => $k_pre . 'graphic_icon_text_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Text<br>Shadow', '__x__' ),
    'condition' => array( 'key' => $k_pre . 'graphic_icon_text_shadow_dimensions', 'op' => 'NOT EMPTY' )
  );

  $control_graphic_std_icon_box_shadow_color = array(
    'keys'      => array( 'value' => $k_pre . 'graphic_icon_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => $k_pre . 'graphic_icon_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
  );

  if ( $has_alt ) {

    $control_graphic_std_icon_border_color['keys']['alt'] = $k_pre . 'graphic_icon_border_color_alt';
    $control_graphic_std_icon_border_color['options']     = cs_recall( 'options_base_interaction_labels' );

    $control_graphic_std_icon_text_shadow_color['keys']['alt'] = $k_pre . 'graphic_icon_text_shadow_color_alt';
    $control_graphic_std_icon_text_shadow_color['options']     = cs_recall( 'options_base_interaction_labels' );

    $control_graphic_std_icon_box_shadow_color['keys']['alt'] = $k_pre . 'graphic_icon_box_shadow_color_alt';
    $control_graphic_std_icon_box_shadow_color['options']     = cs_recall( 'options_base_interaction_labels' );

  }



  // Controls & Control Groups for Icons/Images
  // ------------------------------------------

  // 01. Variable controls and groups that differ depending on various
  //     conditions such as having sourced content, having secondary icons or
  //     images, et cetera.
  // 02. Content is provided from an external source, such as the WordPress
  //     menu system.
  // 03. Content provided locally from within the builders, such as the
  //     individual icon or image controls.

  $control_graphic_local_icons                     = NULL; // 01
  $control_graphic_local_icon_primary              = NULL;
  $control_graphic_local_icon_secondary            = NULL; // 01
  $control_graphic_local_image_primary             = NULL; // 01
  $control_group_graphic_local_image_secondary     = NULL; // 01
  $control_group_graphic_local_image_secondary_std = NULL; // 01
  $control_group_graphic_sourced_images            = NULL; // 01

  foreach ( $controls_setup as $i => $control ) {
    $controls_setup[$i]['conditions'] = $conditions_graphic_main;
  }

  $control_list_graphic_setup = array_merge(
    array(
      $control_graphic,
      $control_graphic_type,
    ),
    $controls_setup
  );

  if ( $has_interactions ) {
    $control_list_graphic_setup[] = $control_graphic_interaction;
  }

  if ( $has_sourced_content ) { // 02

    $control_list_graphic_sourced_images_controls = array(
      array(
        'key'     => $k_pre . 'graphic_image_retina',
        'type'    => 'choose',
        'label'   => __( 'Retina Ready', '__x__' ),
        'options' => cs_recall( 'options_choices_off_on_bool' ),
      ),
    );

    if ( $has_alt ) {
      $control_list_graphic_sourced_images_controls[] = array(
        'key'     => $k_pre . 'graphic_image_alt_enable',
        'type'    => 'choose',
        'label'   => __( 'Secondary', '__x__' ),
        'options' => cs_recall( 'options_choices_off_on_bool' ),
      );
    }

    $control_group_graphic_sourced_images = array(
      'type'       => 'group',
      'label'      => __( '{{prefix}} Graphic Image', '__x__' ),
      'label_vars' => array( 'prefix' => $label_prefix ),
      'group'      => $group,
      'conditions' => $conditions_graphic_image,
      'controls'   => $control_list_graphic_sourced_images_controls,
    );

  } else { // 03

    $control_graphic_local_icon_primary = array(
      'key'        => $k_pre . 'graphic_icon',
      'type'       => 'icon',
      'group'      => $group,
      'label'      => __( 'Primary Icon', '__x__' ),
      'conditions' => $conditions_graphic_icon,
    );

    $control_graphic_local_image_primary = array(
      'keys' => array(
        'img_source' => $k_pre . 'graphic_image_src',
        'is_retina'  => $k_pre . 'graphic_image_retina',
        'width'      => $k_pre . 'graphic_image_width',
        'height'     => $k_pre . 'graphic_image_height',
        'alt_text'   => $k_pre . 'graphic_image_alt',
      ),
      'type'       => 'image',
      'label'      => __( '{{prefix}} Primary Graphic Image', '__x__' ),
      'label_vars' => array( 'prefix' => $label_prefix ),
      'group'      => $group,
      'conditions' => $conditions_graphic_image
    );

    if ( $has_alt ) {

      $control_graphic_local_icon_secondary = array(
        'key'        => $k_pre . 'graphic_icon_alt',
        'type'       => 'icon',
        'group'      => $group,
        'label'      => __( 'Secondary Icon', '__x__' ),
        'conditions' => $conditions_graphic_icon_alt,
      );

      $control_group_graphic_local_image_secondary = array(
        'type'       => 'group',
        'label'      => __( '{{prefix}} Secondary Graphic Image', '__x__' ),
        'label_vars' => array( 'prefix' => $label_prefix ),
        'group'      => $group,
        'conditions' => $conditions_graphic_image,
        'controls'   => array(
          $control_graphic_local_image_secondary_enable,
          $control_graphic_local_image_secondary,
          $control_graphic_local_image_secondary_alt_text
        )
      );

      $control_group_graphic_local_image_secondary_std = cs_amend_control( $control_group_graphic_local_image_secondary, array(
        'label_vars' => array( 'prefix' => $label_prefix_std ),
        'controls' => array(
          $control_graphic_local_image_secondary,
          $control_graphic_local_image_secondary_alt_text
        )
      ) );

    }

    if ( isset( $control_graphic_local_icon_secondary ) ) {
      $control_graphic_local_icons = array(
        'type'     => 'group',
        'label'    => __( 'Primary &amp; Secondary', '__x__' ),
        'group'    => $group,
        'controls' => array(
          array_merge( $control_graphic_local_icon_primary,   array( 'options' => array( 'label' => __( 'Select', '__x__' ) ) ) ),
          array_merge( $control_graphic_local_icon_secondary, array( 'options' => array( 'label' => __( 'Select', '__x__' ) ) ) ),
        ),
      );
    } else {
      $control_graphic_local_icons = $control_graphic_local_icon_primary;
    }

  }

  // Compose Controls
  // ----------------

  $graphic_controls = array(
    'controls' => array_merge(
      array(
        array(
          'type'       => 'group',
          'label'      => __( '{{prefix}} Graphic Setup', '__x__' ),
          'label_vars' => array( 'prefix' => $label_prefix ),
          'group'      => $group,
          'conditions' => $conditions,
          'controls'   => $control_list_graphic_setup,
        ),
      ),
      x_control_margin( $settings_graphic_margin ),

      array(
        array(
          'type'       => 'group',
          'label'      => __( '{{prefix}} Graphic Icon', '__x__' ),
          'label_vars' => array( 'prefix' => $label_prefix ),
          'group'      => $group,
          'conditions' => $conditions_graphic_icon,
          'controls'   => array(
            $control_graphic_icon_first_line,
            $control_graphic_icon_width_and_height,
            $control_graphic_local_icons,
            $control_graphic_icon_color,
            $control_graphic_icon_bg_color,
          ),
        ),
      ),
      x_control_border( $settings_graphic_icon_variable_alt_color ),
      x_control_border_radius( $settings_graphic_icon_border_radius ),
      x_control_box_shadow( $settings_graphic_icon_variable_alt_color ),
      x_control_text_shadow( $settings_graphic_icon_variable_alt_color ),

      array(
        array(
          'type'       => 'group',
          'label'      => __( '{{prefix}} Graphic Image', '__x__' ),
          'label_vars' => array( 'prefix' => $label_prefix ),
          'group'      => $group,
          'conditions' => $conditions_graphic_image,
          'controls'   => array(
            $control_graphic_image_max_width,
          ),
        ),
        $control_graphic_local_image_primary,
        $control_group_graphic_local_image_secondary,
        $control_group_graphic_sourced_images
      )
    ),
    'controls_std_content' => array(
      array(
        'type'       => 'group',
        'label'      => __( '{{prefix}} Graphic Icon', '__x__' ),
        'label_vars' => array( 'prefix' => $label_prefix_std ),
        'group'      => $group,
        'conditions' => $conditions_graphic_icon,
        'controls'   => array(
          $control_graphic_local_icon_primary,
          $control_graphic_local_icon_secondary,
        ),
      ),
      $control_graphic_local_image_primary ? cs_amend_control( $control_graphic_local_image_primary, array( 'label_vars' => array( 'prefix' => $label_prefix_std ) ) ) : $control_graphic_local_image_primary,
      $control_group_graphic_local_image_secondary_std,
      $control_group_graphic_sourced_images ? cs_amend_control( $control_group_graphic_sourced_images, array( 'label_vars' => array( 'prefix' => $label_prefix_std ) ) ) : $control_group_graphic_sourced_images,
    ),
    'controls_std_design_colors' => array_merge(
      array(
        array(
          'type'       => 'group',
          'label'      => __( '{{prefix}} Graphic Icon Colors', '__x__' ),
          'label_vars' => array( 'prefix' => $label_prefix_std ),
          'group'      => $group,
          'conditions' => $conditions_graphic_icon,
          'controls'   => array(
            $control_graphic_icon_color,
            $control_graphic_std_icon_text_shadow_color,
            $control_graphic_std_icon_box_shadow_color,
            $control_graphic_icon_bg_color,
          ),
        ),
      ),
      x_control_border(
        array_merge(
          $settings_graphic_icon_variable_alt_color_std,
          array(
            'conditions' => array_merge( $conditions, array(
              array(
                array( 'key' => $k_pre . 'graphic_icon_border_width', 'op' => 'NOT EMPTY' ),
                array( 'key' => $k_pre . 'graphic_icon_border_style', 'op' => '!=', 'value' => 'none' ),
              )
            ) ),
          )
        )
      )
    ),
  );

  if ( $has_toggle ) {
    return cs_compose_controls(
      $graphic_controls,
      cs_partial_controls( 'toggle', array(
        'label_prefix'     => sprintf( __( '%s Graphic', '__x__' ), $label_prefix ),
        'label_prefix_std' => sprintf( __( '%s Graphic', '__x__' ), $label_prefix_std ),
        'group'            => $group,
        'conditions'       => $conditions_graphic_toggle,
      ) )
    );
  }

  return $graphic_controls;
}

cs_register_control_partial( 'graphic', 'x_control_partial_graphic' );
