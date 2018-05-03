<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/BG.PHP
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

function x_controls_bg( $settings = array() ) {

  // Setup
  // -----

  $t_pre     = ( isset( $settings['t_pre'] )     ) ? $settings['t_pre'] . ' ' : '';
  $k_pre     = ( isset( $settings['k_pre'] )     ) ? $settings['k_pre'] . '_' : '';
  $group     = ( isset( $settings['group'] )     ) ? $settings['group']       : 'bg';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition']   : array();

  $conditions = x_module_conditions( $condition );

  $options_bg_parallax_size = array(
    'available_units' => array( '%' ),
    'fallback_value'  => '150%',
    'ranges'          => array(
      '%' => array( 'min' => 100, 'max' => 250, 'step' => 5 ),
    ),
  );

  $settings_border_radius = array(
    'k_pre'     => 'bg',
    't_pre'     => __( 'Background', '__x__' ),
    'group'     => $group,
    'condition' => $condition,
  );


  // Data
  // ----

  $data = array_merge(
    array(
      array(
        'type'       => 'group',
        'title'      => __( $t_pre . ' Background Lower Layer', '__x__' ),
        'group'      => $group,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => $k_pre . 'bg_lower_type',
            'type'    => 'choose',
            'label'   => __( 'Select Type', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'none',  'icon' => 'ban'        ),
                array( 'value' => 'color', 'icon' => 'eyedropper' ),
                array( 'value' => 'image', 'icon' => 'picture-o'  ),
                array( 'value' => 'video', 'icon' => 'film'       ),
              )
            ),
          ),
          array(
            'key'       => $k_pre . 'bg_lower_color',
            'type'      => 'color',
            'label'     => __( 'Color', '__x__' ),
            'condition' => array( $k_pre . 'bg_lower_type' => 'color' ),
          ),
          array(
            'keys' => array(
              'img_source' => $k_pre . 'bg_lower_image',
            ),
            'type'      => 'image',
            'label'     => __( 'Image', '__x__' ),
            'condition' => array( $k_pre . 'bg_lower_type' => 'image' ),
            'options'   => array(
              'height' => 2,
            ),
          ),
          array(
            'key'       => $k_pre . 'bg_lower_image_repeat',
            'type'      => 'choose',
            'label'     => __( 'Repeat', '__x__' ),
            'condition' => array( $k_pre . 'bg_lower_type' => 'image' ),
            'options'   => array(
              'choices' => array(
                array( 'value' => 'no-repeat', 'label' => __( 'None', '__x__' )   ),
                array( 'value' => 'repeat-x',  'label' => __( 'X Axis', '__x__' ) ),
                array( 'value' => 'repeat-y',  'label' => __( 'Y Axis', '__x__' ) ),
                array( 'value' => 'repeat',    'label' => __( 'Both', '__x__' )   ),
              )
            ),
          ),
          array(
            'type'      => 'group',
            'title'     => __( 'Size &amp; Position', '__x__' ),
            'condition' => array( $k_pre . 'bg_lower_type' => 'image' ),
            'controls'  => array(
              array(
                'key'  => $k_pre . 'bg_lower_image_size',
                'type' => 'text',
              ),
              array(
                'key'  => $k_pre . 'bg_lower_image_position',
                'type' => 'text',
              ),
            ),
          ),
          array(
            'key'       => $k_pre . 'bg_lower_video',
            'type'      => 'text',
            'label'     => __( 'Video Source', '__x__' ),
            'condition' => array( $k_pre . 'bg_lower_type' => 'video' ),
            'options'   => array(
              'placeholder' => 'http://example.com/a.mp4'
            ),
          ),
          array(
            'keys' => array(
              'img_source' => $k_pre . 'bg_lower_video_poster',
            ),
            'type'      => 'image',
            'label'     => __( 'Poster Image', '__x__' ),
            'condition' => array( $k_pre . 'bg_lower_type' => 'video' ),
            'options'   => array(
              'height' => 3,
            ),
          ),
        ),
      ),
      array(
        'type'       => 'group',
        'title'      => __( $t_pre . ' Background Upper Layer', '__x__' ),
        'group'      => $group,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => $k_pre . 'bg_upper_type',
            'type'    => 'choose',
            'label'   => __( 'Select Type', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'none',  'icon' => 'ban'        ),
                array( 'value' => 'color', 'icon' => 'eyedropper' ),
                array( 'value' => 'image', 'icon' => 'picture-o'  ),
                array( 'value' => 'video', 'icon' => 'film'       ),
              )
            ),
          ),
          array(
            'key'       => $k_pre . 'bg_upper_color',
            'type'      => 'color',
            'label'     => __( 'Color', '__x__' ),
            'condition' => array( $k_pre . 'bg_upper_type' => 'color' ),
          ),
          array(
            'keys' => array(
              'img_source' => $k_pre . 'bg_upper_image',
            ),
            'type'      => 'image',
            'label'     => __( 'Image', '__x__' ),
            'condition' => array( $k_pre . 'bg_upper_type' => 'image' ),
            'options'   => array(
              'height' => 2,
            ),
          ),
          array(
            'key'       => $k_pre . 'bg_upper_image_repeat',
            'type'      => 'choose',
            'label'     => __( 'Repeat', '__x__' ),
            'condition' => array( $k_pre . 'bg_upper_type' => 'image' ),
            'options'   => array(
              'choices' => array(
                array( 'value' => 'no-repeat', 'label' => __( 'None', '__x__' )   ),
                array( 'value' => 'repeat-x',  'label' => __( 'X Axis', '__x__' ) ),
                array( 'value' => 'repeat-y',  'label' => __( 'Y Axis', '__x__' ) ),
                array( 'value' => 'repeat',    'label' => __( 'Both', '__x__' )   ),
              )
            ),
          ),
          array(
            'type'      => 'group',
            'title'     => __( 'Size &amp; Position', '__x__' ),
            'condition' => array( $k_pre . 'bg_upper_type' => 'image' ),
            'controls'  => array(
              array(
                'key'  => $k_pre . 'bg_upper_image_size',
                'type' => 'text',
              ),
              array(
                'key'  => $k_pre . 'bg_upper_image_position',
                'type' => 'text',
              ),
            ),
          ),
          array(
            'key'       => $k_pre . 'bg_upper_video',
            'type'      => 'text',
            'label'     => __( 'Video Source', '__x__' ),
            'condition' => array( $k_pre . 'bg_upper_type' => 'video' ),
            'options'   => array(
              'placeholder' => 'http://example.com/a.mp4'
            ),
          ),
          array(
            'keys' => array(
              'img_source' => $k_pre . 'bg_upper_video_poster',
            ),
            'type'      => 'image',
            'label'     => __( 'Poster Image', '__x__' ),
            'condition' => array( $k_pre . 'bg_upper_type' => 'video' ),
            'options'   => array(
              'height' => 3,
            ),
          ),
        ),
      ),
      array(
        'type'       => 'group',
        'title'      => __( $t_pre . ' Background Parallax', '__x__' ),
        'group'      => $group,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'keys' => array(
              'lower_parallax' => $k_pre . 'bg_lower_parallax',
              'upper_parallax' => $k_pre . 'bg_upper_parallax',
            ),
            'type'    => 'checkbox-list',
            'label'   => __( 'Enable', '__x__' ),
            'options' => array(
              'list' => array(
                array( 'key' => 'lower_parallax', 'label' => __( 'Lower Layer', '__x__' ), 'half' => true ),
                array( 'key' => 'upper_parallax', 'label' => __( 'Upper Layer', '__x__' ), 'half' => true ),
              ),
            ),
          ),
          array(
            'key'       => $k_pre . 'bg_lower_parallax_size',
            'type'      => 'slider',
            'label'     => __( 'Lower Layer Size', '__x__' ),
            'options'   => $options_bg_parallax_size,
            'condition' => array( $k_pre . 'bg_lower_parallax' => true ),
          ),
          array(
            'type'      => 'group',
            'title'     => __( 'Lower Layer Direction', '__x__' ),
            'condition' => array( $k_pre . 'bg_lower_parallax' => true ),
            'controls'  => array(
              array(
                'key'       => $k_pre . 'bg_lower_parallax_direction',
                'type'      => 'choose',
                'condition' => array( $k_pre . 'bg_lower_parallax' => true ),
                'options'   => array(
                  'choices' => array(
                    array( 'value' => 'v', 'icon' => 'arrows-v' ),
                    array( 'value' => 'h', 'icon' => 'arrows-h' ),
                  )
                ),
              ), 
              array(
                'keys' => array(
                  'lower_parallax_reverse' => $k_pre . 'bg_lower_parallax_reverse',
                ),
                'type'    => 'checkbox-list',
                'options' => array(
                  'list' => array(
                    array( 'key' => 'lower_parallax_reverse', 'label' => __( 'Reverse', '__x__' ) ),
                  ),
                ),
              ),
            ),
          ),
          array(
            'key'       => $k_pre . 'bg_upper_parallax_size',
            'type'      => 'slider',
            'label'     => __( 'Upper Layer Size', '__x__' ),
            'options'   => $options_bg_parallax_size,
            'condition' => array( $k_pre . 'bg_upper_parallax' => true ),
          ),
          array(
            'type'      => 'group',
            'title'     => __( 'Upper Layer Direction', '__x__' ),
            'condition' => array( $k_pre . 'bg_upper_parallax' => true ),
            'controls'  => array(
              array(
                'key'       => $k_pre . 'bg_upper_parallax_direction',
                'type'      => 'choose',
                'condition' => array( $k_pre . 'bg_upper_parallax' => true ),
                'options'   => array(
                  'choices' => array(
                    array( 'value' => 'v', 'icon' => 'arrows-v' ),
                    array( 'value' => 'h', 'icon' => 'arrows-h' ),
                  )
                ),
              ),
              array(
                'keys' => array(
                  'upper_parallax_reverse' => $k_pre . 'bg_upper_parallax_reverse',
                ),
                'type'    => 'checkbox-list',
                'options' => array(
                  'list' => array(
                    array( 'key' => 'upper_parallax_reverse', 'label' => __( 'Reverse', '__x__' ) ),
                  ),
                ),
              ),
            ),
          ),
        ),
      ),
    ),
    x_control_border_radius( $settings_border_radius )
  );


  // Returned Value
  // --------------

  $controls = $data;

  return $controls;

}



// Values
// =============================================================================

function x_values_bg( $settings = array() ) {

  // Setup
  // -----
  // Requires some extra steps as the bg is a 2nd level mixin to be used in
  // other 1st level mixins, such as the bar.

  if ( isset( $settings['k_pre'] ) && ! empty( $settings['k_pre'] ) ) {

    $ends_with_underscore = substr( $settings['k_pre'], -1 ) == '_';

    $k_pre = ( $ends_with_underscore ) ? $settings['k_pre'] : $settings['k_pre'] . '_';

  } else {

    $k_pre = '';

  }


  // Values
  // ------

  $values = array(

    $k_pre . 'bg_lower_type'               => x_module_value( 'none', 'markup' ),
    $k_pre . 'bg_lower_color'              => x_module_value( 'rgba(255, 255, 255, 0.5)', 'attr' ),
    $k_pre . 'bg_lower_image'              => x_module_value( '', 'attr', true ),
    $k_pre . 'bg_lower_image_repeat'       => x_module_value( 'no-repeat', 'attr', true ),
    $k_pre . 'bg_lower_image_size'         => x_module_value( 'cover', 'attr', true ),
    $k_pre . 'bg_lower_image_position'     => x_module_value( 'center', 'attr', true ),
    $k_pre . 'bg_lower_video'              => x_module_value( '', 'markup', true ),
    $k_pre . 'bg_lower_video_poster'       => x_module_value( '', 'markup', true ),

    $k_pre . 'bg_upper_type'               => x_module_value( 'none', 'markup' ),
    $k_pre . 'bg_upper_color'              => x_module_value( 'rgba(255, 255, 255, 0.5)', 'attr' ),
    $k_pre . 'bg_upper_image'              => x_module_value( '', 'attr', true ),
    $k_pre . 'bg_upper_image_repeat'       => x_module_value( 'no-repeat', 'attr', true ),
    $k_pre . 'bg_upper_image_size'         => x_module_value( 'cover', 'attr', true ),
    $k_pre . 'bg_upper_image_position'     => x_module_value( 'center', 'attr', true ),
    $k_pre . 'bg_upper_video'              => x_module_value( '', 'markup', true ),
    $k_pre . 'bg_upper_video_poster'       => x_module_value( '', 'markup', true ),

    $k_pre . 'bg_lower_parallax'           => x_module_value( false, 'markup' ),
    $k_pre . 'bg_lower_parallax_size'      => x_module_value( '150%', 'markup' ),
    $k_pre . 'bg_lower_parallax_direction' => x_module_value( 'v', 'markup' ),
    $k_pre . 'bg_lower_parallax_reverse'   => x_module_value( false, 'markup' ),

    $k_pre . 'bg_upper_parallax'           => x_module_value( false, 'markup' ),
    $k_pre . 'bg_upper_parallax_size'      => x_module_value( '150%', 'markup' ),
    $k_pre . 'bg_upper_parallax_direction' => x_module_value( 'v', 'markup' ),
    $k_pre . 'bg_upper_parallax_reverse'   => x_module_value( false, 'markup' ),

    $k_pre . 'bg_border_radius'            => x_module_value( 'inherit', 'attr' ),

  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}