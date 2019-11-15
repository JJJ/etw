<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/PARTICLE.PHP
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

function x_control_partial_particle( $settings ) {

  // Setup
  // -----

  $label_prefix     = ( isset( $settings['label_prefix'] )     ) ? $settings['label_prefix']      : '';
  $k_pre            = ( isset( $settings['k_pre'] )            ) ? $settings['k_pre'] . '_'      : '';
  $group            = ( isset( $settings['group'] )            ) ? $settings['group']            : 'general';
  $conditions       = ( isset( $settings['conditions'] )       ) ? $settings['conditions']        : array();
  $has_interactions = ( isset( $settings['has_interactions'] ) ) ? $settings['has_interactions'] : false;


  // Options
  // -------

  $options_particle_delay = array(
    'unit_mode' => 'time',
  );

  $options_particle_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'valid_keywords'  => array( 'calc' ),
  );

  $options_particle_height = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'valid_keywords'  => array( 'calc' ),
  );

  $options_particle_border_radius = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'valid_keywords'  => array( 'calc' ),
  );


  // Controls
  // --------

  return array(
    'controls' => array(
      array(
        'type'       => 'group',
        'label'      => __( '{{prefix}} Particle Setup', '__x__' ),
        'label_vars' => array( 'prefix' => $label_prefix ),
        'group'      => $group,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => $k_pre . 'particle',
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
            'key'       => $k_pre . 'particle_location',
            'type'      => 'select',
            'label'     => __( 'Location', '__x__' ),
            'condition' => array( $k_pre . 'particle' => true ),
            'options'   => array(
              'choices' => array(
                array( 'value' => 'c_c', 'label' => __( 'Center', '__x__' )       ),
                array( 'value' => 't_c', 'label' => __( 'Top', '__x__' )          ),
                array( 'value' => 'c_l', 'label' => __( 'Left', '__x__' )         ),
                array( 'value' => 'c_r', 'label' => __( 'Right', '__x__' )        ),
                array( 'value' => 'b_c', 'label' => __( 'Bottom', '__x__' )       ),
                array( 'value' => 't_l', 'label' => __( 'Top Left', '__x__' )     ),
                array( 'value' => 't_r', 'label' => __( 'Top Right', '__x__' )    ),
                array( 'value' => 'b_l', 'label' => __( 'Bottom Left', '__x__' )  ),
                array( 'value' => 'b_r', 'label' => __( 'Bottom Right', '__x__' ) ),
              )
            ),
          ),
          array(
            'key'       => $k_pre . 'particle_placement',
            'type'      => 'select',
            'label'     => __( 'Placement', '__x__' ),
            'condition' => array( $k_pre . 'particle' => true ),
            'options'   => array(
              'choices' => array(
                array( 'value' => 'inside',  'label' => __( 'Inside', '__x__' ) ),
                array( 'value' => 'overlap', 'label' => __( 'Overlap', '__x__' ) ),
              )
            ),
          ),
          array(
            'type'      => 'group',
            'title'     => __( 'Scale &amp; Delay', '__x__' ),
            'condition' => array( $k_pre . 'particle' => true ),
            'controls'  => array(
              array(
                'key'     => $k_pre . 'particle_scale',
                'type'    => 'select',
                'options' => array(
                  'choices' => array(
                    array( 'value' => 'none',      'label' => __( 'None', '__x__' ) ),
                    array( 'value' => 'scale-x_y', 'label' => __( 'Scale All', '__x__' ) ),
                    array( 'value' => 'scale-x',   'label' => __( 'Scale X', '__x__' )   ),
                    array( 'value' => 'scale-y',   'label' => __( 'Scale Y', '__x__' )   ),
                  )
                ),
              ),
              array(
                'key'     => $k_pre . 'particle_delay',
                'type'    => 'unit',
                'options' => $options_particle_delay,
              ),
            ),
          ),
          array(
            'key'       => $k_pre . 'particle_transform_origin',
            'type'      => 'select',
            'label'     => __( 'Transform Starts From', '__x__' ),
            'condition' => array( $k_pre . 'particle' => true ),
            'options'   => array(
              'choices' => array(
                array( 'value' => '50% 50%',   'label' => __( 'Center', '__x__' )       ),
                array( 'value' => '50% 0%',    'label' => __( 'Top', '__x__' )          ),
                array( 'value' => '0% 50%',    'label' => __( 'Left', '__x__' )         ),
                array( 'value' => '100% 50%',  'label' => __( 'Right', '__x__' )        ),
                array( 'value' => '50% 100%',  'label' => __( 'Bottom', '__x__' )       ),
                array( 'value' => '0% 0%',     'label' => __( 'Top Left', '__x__' )     ),
                array( 'value' => '100% 0%',   'label' => __( 'Top Right', '__x__' )    ),
                array( 'value' => '0% 100%',   'label' => __( 'Bottom Left', '__x__' )  ),
                array( 'value' => '100% 100%', 'label' => __( 'Bottom Right', '__x__' ) ),
              )
            ),
          ),
        ),
      ),
      array(
        'type'       => 'group',
        'label'      => __( '{{prefix}} Particle Style', '__x__' ),
        'label_vars' => array( 'prefix' => $label_prefix ),
        'group'      => $group,
        'conditions' => array_merge( $conditions, array( array( $k_pre . 'particle' => true ) ) ),
        'controls'   => array(
          array(
            'type'     => 'group',
            'title'    => __( 'Width &amp; Height', '__x__' ),
            'controls' => array(
              array(
                'key'     => $k_pre . 'particle_width',
                'type'    => 'unit',
                'label'   => __( 'Width', '__x__' ),
                'options' => $options_particle_width,
              ),
              array(
                'key'     => $k_pre . 'particle_height',
                'type'    => 'unit',
                'label'   => __( 'Height', '__x__' ),
                'options' => $options_particle_height,
              ),
            ),
          ),
          array(
            'type'     => 'group',
            'title'    => __( 'Radius &amp; Color', '__x__' ),
            'controls' => array(
              array(
                'key'     => $k_pre . 'particle_border_radius',
                'type'    => 'unit',
                'label'   => __( 'Border Radius', '__x__' ),
                'options' => $options_particle_border_radius,
              ),
              array(
                'keys' => array(
                  'value' => $k_pre . 'particle_color',
                ),
                'type'    => 'color',
                'label'   => __( 'Background', '__x__' ),
                'options' => array(
                  'label' => __( 'Select', '__x__' ),
                ),
              ),
            ),
          ),
          array(
            'key'     => $k_pre . 'particle_style',
            'type'    => 'textarea',
            'label'   => __( 'Inline CSS', '__x__' ),
            'options' => array(
              'height' => '3',
            ),
          ),
        ),
      ),
    )
  );
}

cs_register_control_partial( 'particle', 'x_control_partial_particle' );
