<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/GRAPHIC.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Control
//   02. Values
// =============================================================================

// Control
// =============================================================================

function x_controls_graphic( $settings = array() ) {

  // Setup - General
  // ---------------

  $t_pre               = ( isset( $settings['t_pre'] )               ) ? $settings['t_pre'] . ' '         : '';
  $k_pre               = ( isset( $settings['k_pre'] )               ) ? $settings['k_pre'] . '_'         : '';
  $group               = ( isset( $settings['group'] )               ) ? $settings['group']               : 'general';
  $condition           = ( isset( $settings['condition'] )           ) ? $settings['condition']           : array();
  $has_alt             = ( isset( $settings['has_alt'] )             ) ? $settings['has_alt']             : false;
  $has_interactions    = ( isset( $settings['has_interactions'] )    ) ? $settings['has_interactions']    : false;
  $has_sourced_content = ( isset( $settings['has_sourced_content'] ) ) ? $settings['has_sourced_content'] : false;
  $has_toggle          = ( isset( $settings['has_toggle'] )          ) ? $settings['has_toggle']          : false;


  // Setup - Conditions
  // ------------------

  $conditions                  = x_module_conditions( $condition );
  $conditions_graphic_main     = array_merge( $condition, array( array( $k_pre . 'graphic' => true ) ) );
  $conditions_graphic_icon     = array_merge( $condition, array( array( $k_pre . 'graphic' => true ) ), array( array( $k_pre . 'graphic_type' => 'icon' ) ) );
  $conditions_graphic_icon_alt = array_merge( $condition, array( array( $k_pre . 'graphic' => true ) ), array( array( $k_pre . 'graphic_type' => 'icon' ) ), array( array( $k_pre . 'graphic_icon_alt_enable' => 'icon' ) ) );
  $conditions_graphic_image    = array_merge( $condition, array( array( $k_pre . 'graphic' => true ) ), array( array( $k_pre . 'graphic_type' => 'image' ) ) );
  $conditions_graphic_toggle   = array_merge( $condition, array( array( $k_pre . 'graphic' => true ) ), array( array( $k_pre . 'graphic_type' => 'toggle' ) ) );


  // Setup - Options
  // ---------------

  $options_graphic_type_choices = array(
    array( 'value' => 'icon',  'icon' => 'flag' ),
    array( 'value' => 'image', 'icon' => 'picture-o' ),
  );

  if ( $has_toggle ) {
    $options_graphic_type_choices[] = array( 'value' => 'toggle', 'icon' => 'bars' );
  }

  $options_graphic_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'fallback_value'  => '1em',
  );


  // Setup - Settings (Graphic Icon)
  // -------------------------------

  $settings_graphic_icon_border_radius = array(
    'k_pre'     => $k_pre . 'graphic_icon',
    't_pre'     => __( $t_pre . ' Graphic Icon', '__x__' ),
    'group'     => $group,
    'condition' => $conditions_graphic_icon,
  );

  $settings_graphic_icon_variable_alt_color = array(
    'k_pre'     => $k_pre . 'graphic_icon',
    't_pre'     => __( $t_pre . ' Graphic Icon', '__x__' ),
    'group'     => $group,
    'condition' => $conditions_graphic_icon,
  );

  if ( $has_alt === true ) {
    $settings_graphic_icon_variable_alt_color = array_merge( $settings_graphic_icon_variable_alt_color, array(
      'alt_color' => true,
      'options'   => array(
        'color' => array(
          'label'     => __( 'Base', '__x__' ),
          'alt_label' => __( 'Interaction', '__x__' ),
        ),
      ),
    ) );
  }


  // Setup - Controls (Graphic Setup)
  // --------------------------------

  $controls_graphic_setup = array(
    array(
      'key'        => $k_pre . 'graphic',
      'type'       => 'choose',
      'label'      => __( 'Enable', '__x__' ),
      'options'    => array(
        'choices' => array(
          array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
          array( 'value' => true,  'label' => __( 'On', '__x__' ) ),
        ),
      ),
    ),
    array(
      'key'        => $k_pre . 'graphic_type',
      'type'       => 'choose',
      'label'      => __( 'Type', '__x__' ),
      'conditions' => $conditions_graphic_main,
      'options'    => array(
        'choices'  => $options_graphic_type_choices,
      ),
    ),
  );

  if ( $has_interactions ) {
    $controls_graphic_setup[] = array(
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
  }

  $control_local_image_secondary      = NULL;

  // Setup - Controls (Primary/Secondary Icons/Images)
  // -------------------------------------------------

  // Notes
  // -----
  // Content is provided from an external source, such as the WordPress
  // menu system.

  if ( $has_sourced_content ) {

    $control_local_image_primary      = NULL;
    $controls_sourced_images_controls = array(
      array(
        'key'     => $k_pre . 'graphic_image_retina',
        'type'    => 'choose',
        'label'   => __( 'Retina Ready', '__x__' ),
        'options' => array(
          'choices' => array(
            array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
            array( 'value' => true,  'label' => __( 'On', '__x__' ) ),
          ),
        ),
      ),
    );

    if ( $has_alt ) {

      $controls_sourced_images_controls[] = array(
        'key'     => $k_pre . 'graphic_image_alt_enable',
        'type'    => 'choose',
        'label'   => __( 'Secondary', '__x__' ),
        'options' => array(
          'choices' => array(
            array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
            array( 'value' => true,  'label' => __( 'On', '__x__' ) ),
          ),
        ),
      );
    }

    $controls_local_icons    = NULL;
    $controls_sourced_images = array(
      'type'       => 'group',
      'title'      => __( $t_pre . ' Graphic Image', '__x__' ),
      'group'      => $group,
      'conditions' => $conditions_graphic_image,
      'controls'   => $controls_sourced_images_controls,
    );


  // Notes
  // -----
  // Content provided locally from within the builders.

  } else {

    $control_local_icon_primary = array(
      'key'        => $k_pre . 'graphic_icon',
      'type'       => 'icon',
      'group'      => $group,
      'label'      => __( 'Primary Icon', '__x__' ),
      'conditions' => $conditions_graphic_icon,
    );

    $control_local_image_primary = array(
      'keys' => array(
        'img_source' => $k_pre . 'graphic_image_src',
        'is_retina'  => $k_pre . 'graphic_image_retina',
        'width'      => $k_pre . 'graphic_image_width',
        'height'     => $k_pre . 'graphic_image_height',
      ),
      'type'       => 'image',
      'title'      => __( $t_pre . ' Primary Graphic Image', '__x__' ),
      'group'      => $group,
      'conditions' => $conditions_graphic_image,
    );

    if ( $has_alt ) {

      $control_local_icon_secondary = array(
        'key'        => $k_pre . 'graphic_icon_alt',
        'type'       => 'icon',
        'group'      => $group,
        'label'      => __( 'Secondary Icon', '__x__' ),
        'conditions' => $conditions_graphic_icon_alt,
      );

      $control_local_image_secondary = array(
        'type'       => 'group',
        'title'      => __( $t_pre . ' Secondary Graphic Image', '__x__' ),
        'group'      => $group,
        'conditions' => $conditions_graphic_image,
        'controls'   => array(
          array(
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
          ),
          array(
            'key'       => $k_pre . 'graphic_image_src_alt',
            'type'      => 'image-source',
            'label'     => __( 'Source', '__x__' ),
            'condition' => array( $k_pre . 'graphic_image_alt_enable' => true ),
            'options'   => array(
              'height' => '4',
            ),
          ),
        ),
      );

    }

    if ( isset( $control_local_icon_secondary ) ) {
      $controls_local_icons = array(
        'type'     => 'group',
        'title'    => __( 'Primary &amp; Secondary', '__x__' ),
        'group'    => $group,
        'controls' => array(
          array_merge( $control_local_icon_primary, array( 'options' => array( 'label' => __( 'Select', '__x__' ) ) ) ),
          array_merge( $control_local_icon_secondary, array( 'options' => array( 'label' => __( 'Select', '__x__' ) ) ) ),
        ),
      );
    } else {
      $controls_local_icons = $control_local_icon_primary;
    }

    $controls_sourced_images = NULL;

  }


  // Setup - Controls Icon
  // ---------------------

  if ( $has_alt ) {
    $controls_icon_first_line = array(
      'type'     => 'group',
      'title'    => __( 'Font Size &amp; Secondary', '__x__' ),
      'controls' => array(
        array(
          'key'     => $k_pre . 'graphic_icon_font_size',
          'type'    => 'unit',
          'options' => array(
            'available_units' => array( 'px', 'em', 'rem' ),
            'fallback_value'  => '1em',
          ),
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
    $controls_icon_color = array(
      'keys' => array(
        'value' => $k_pre . 'graphic_icon_color',
        'alt'   => $k_pre . 'graphic_icon_color_alt',
      ),
      'type'      => 'color',
      'label'     => __( 'Color', '__x__' ),
      'options'   => array(
        'label'     => __( 'Base', '__x__' ),
        'alt_label' => __( 'Interaction', '__x__' ),
      ),
    );
    $controls_icon_bg_color = array(
      'keys' => array(
        'value' => $k_pre . 'graphic_icon_bg_color',
        'alt'   => $k_pre . 'graphic_icon_bg_color_alt',
      ),
      'type'      => 'color',
      'label'     => __( 'Background', '__x__' ),
      'options'   => array(
        'label'     => __( 'Base', '__x__' ),
        'alt_label' => __( 'Interaction', '__x__' ),
      ),
    );
  } else {
    $controls_icon_first_line = array(
      'key'     => $k_pre . 'graphic_icon_font_size',
      'type'    => 'unit',
      'label'   => __( 'Font Size', '__x__' ),
      'options' => array(
        'available_units' => array( 'px', 'em', 'rem' ),
        'fallback_value'  => '1em',
      ),
    );
    $controls_icon_color = array(
      'keys' => array(
        'value' => $k_pre . 'graphic_icon_color',
      ),
      'type'  => 'color',
      'label' => __( 'Color', '__x__' ),
    );
    $controls_icon_bg_color = array(
      'keys' => array(
        'value' => $k_pre . 'graphic_icon_bg_color',
      ),
      'type'  => 'color',
      'label' => __( 'Background', '__x__' ),
    );
  }


  // Data
  // ----

  $data = array_merge(

    // Setup
    // -----

    array(
      array(
        'type'       => 'group',
        'title'      => __( $t_pre . ' Graphic Setup', '__x__' ),
        'group'      => $group,
        'conditions' => $conditions,
        'controls'   => $controls_graphic_setup,
      ),
    ),
    x_control_margin( array(
      'k_pre'     => $k_pre . 'graphic',
      't_pre'     => __( $t_pre . ' Graphic', '__x__' ),
      'group'     => $group,
      'condition' => $conditions_graphic_main,
    ) ),


    // Icon
    // ----

    array(
      array(
        'type'       => 'group',
        'title'      => __( $t_pre . ' Graphic Icon', '__x__' ),
        'group'      => $group,
        'conditions' => $conditions_graphic_icon,
        'controls'   => array(
          $controls_icon_first_line,
          array(
            'type'     => 'group',
            'title'    => __( 'Width &amp; Height', '__x__' ),
            'controls' => array(
              array(
                'key'     => $k_pre . 'graphic_icon_width',
                'type'    => 'unit',
                'options' => $options_graphic_width_and_height,
              ),
              array(
                'key'     => $k_pre . 'graphic_icon_height',
                'type'    => 'unit',
                'options' => $options_graphic_width_and_height,
              ),
            ),
          ),
          $controls_local_icons,
          $controls_icon_color,
          $controls_icon_bg_color,
        ),
      ),
    ),
    x_control_border( $settings_graphic_icon_variable_alt_color ),
    x_control_border_radius( $settings_graphic_icon_border_radius ),
    x_control_box_shadow( $settings_graphic_icon_variable_alt_color ),
    x_control_text_shadow( $settings_graphic_icon_variable_alt_color ),


    // Image
    // -----

    array(
      array(
        'type'       => 'group',
        'title'      => __( $t_pre . ' Graphic Image', '__x__' ),
        'group'      => $group,
        'conditions' => $conditions_graphic_image,
        'controls'   => array(
          array(
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
          ),
        ),
      ),
      $control_local_image_primary,
      $control_local_image_secondary,
      $controls_sourced_images
    )
  );


  // Toggle
  // ------

  if ( $has_toggle ) {
    $data = array_merge(
      $data,
      x_controls_toggle( array(
        't_pre'     => __( $t_pre . ' Graphic', '__x__' ),
        'group'     => $group,
        'condition' => $conditions_graphic_toggle,
      ) )
    );
  }


  // Returned Value
  // --------------

  $controls = $data;

  return $controls;

}



// Values
// =============================================================================

function x_values_graphic( $settings = array() ) {

  // Setup
  // -----
  // Requires some extra steps as the toggle is a 2nd level mixin to be used in
  // other 1st level mixins, such as the anchor.

  if ( isset( $settings['k_pre'] ) && ! empty( $settings['k_pre'] ) ) {

    $ends_with_underscore = substr( $settings['k_pre'], -1 ) == '_';

    $k_pre = ( $ends_with_underscore ) ? $settings['k_pre'] : $settings['k_pre'] . '_';

  } else {

    $k_pre = '';

  }

  $has_alt             = ( isset( $settings['has_alt'] )             ) ? $settings['has_alt']             : false;
  $has_interactions    = ( isset( $settings['has_interactions'] )    ) ? $settings['has_interactions']    : false;
  $has_sourced_content = ( isset( $settings['has_sourced_content'] ) ) ? $settings['has_sourced_content'] : false;
  $has_toggle          = ( isset( $settings['has_toggle'] )          ) ? $settings['has_toggle']          : false;


  // Values
  // ------
  // 01. Will not change per module. Meant to be used to conditionally load
  //     output for templates and associated styles.

  $values = array(

    $k_pre . 'graphic_has_alt'                     => x_module_value( $has_alt, 'all' ),             // 01
    $k_pre . 'graphic_has_interactions'            => x_module_value( $has_interactions, 'all' ),    // 01
    $k_pre . 'graphic_has_sourced_content'         => x_module_value( $has_sourced_content, 'all' ), // 01
    $k_pre . 'graphic_has_toggle'                  => x_module_value( $has_toggle, 'all' ),          // 01

    $k_pre . 'graphic'                             => x_module_value( false, 'all' ),
    $k_pre . 'graphic_type'                        => x_module_value( 'icon', 'all', true ),

    $k_pre . 'graphic_margin'                      => x_module_value( '5px', 'style' ),

    $k_pre . 'graphic_icon_font_size'              => x_module_value( '1.25em', 'style' ),
    $k_pre . 'graphic_icon_width'                  => x_module_value( '1em', 'style' ),
    $k_pre . 'graphic_icon_height'                 => x_module_value( '1em', 'style' ),
    $k_pre . 'graphic_icon_color'                  => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    $k_pre . 'graphic_icon_bg_color'               => x_module_value( 'transparent', 'style:color' ),
    $k_pre . 'graphic_icon_border_width'           => x_module_value( '0px', 'style' ),
    $k_pre . 'graphic_icon_border_style'           => x_module_value( 'none', 'style' ),
    $k_pre . 'graphic_icon_border_color'           => x_module_value( 'transparent', 'style:color' ),
    $k_pre . 'graphic_icon_border_color_alt'       => x_module_value( 'transparent', 'style:color' ),
    $k_pre . 'graphic_icon_border_radius'          => x_module_value( '0em 0em 0em 0em', 'style' ),
    $k_pre . 'graphic_icon_box_shadow_dimensions'  => x_module_value( '0em 0em 0em 0em', 'style' ),
    $k_pre . 'graphic_icon_box_shadow_color'       => x_module_value( 'transparent', 'style:color' ),
    $k_pre . 'graphic_icon_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    $k_pre . 'graphic_icon_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),

    $k_pre . 'graphic_image_max_width'             => x_module_value( 'none', 'style' ),
    $k_pre . 'graphic_image_retina'                => x_module_value( true, 'markup', true ),

  );

  if ( $has_alt ) {
    $values = array_merge(
      $values,
      array(
        $k_pre . 'graphic_icon_alt_enable'            => x_module_value( false, 'markup' ),
        $k_pre . 'graphic_icon_color_alt'             => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
        $k_pre . 'graphic_icon_bg_color_alt'          => x_module_value( 'transparent', 'style:color' ),
        $k_pre . 'graphic_icon_box_shadow_color_alt'  => x_module_value( 'transparent', 'style:color' ),
        $k_pre . 'graphic_icon_text_shadow_color_alt' => x_module_value( 'transparent', 'style:color' ),
        $k_pre . 'graphic_image_alt_enable'           => x_module_value( false, 'markup' ),
      )
    );
  }

  if ( ! $has_sourced_content && $has_alt ) {
    $values = array_merge(
      $values,
      array(
        $k_pre . 'graphic_icon_alt'      => x_module_value( 'hand-spock-o', 'markup', true ),
        $k_pre . 'graphic_image_src_alt' => x_module_value( '', 'markup', true ),
      )
    );
  }

  if ( $has_interactions ) {
    $values = array_merge(
      $values,
      array(
        $k_pre . 'graphic_interaction' => x_module_value( 'none', 'markup' ),
      )
    );
  }

  if ( ! $has_sourced_content ) {
    $values = array_merge(
      $values,
      array(
        $k_pre . 'graphic_icon'         => x_module_value( 'hand-pointer-o', 'markup', true ),
        $k_pre . 'graphic_image_src'    => x_module_value( '', 'markup', true ),
        $k_pre . 'graphic_image_width'  => x_module_value( 48, 'markup', true ),
        $k_pre . 'graphic_image_height' => x_module_value( 48, 'markup', true ),
      )
    );
  }

  if ( $has_toggle ) {
    $values = array_merge(
      $values,
      x_values_toggle()
    );
  }


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
