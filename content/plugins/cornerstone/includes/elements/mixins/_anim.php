<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/_ANIM.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Control
// =============================================================================

// Control
// =============================================================================

function x_control_anim( $settings = array() ) {

  // Setup
  // -----

  $t_pre     = ( isset( $settings['t_pre'] )     ) ? $settings['t_pre'] . ' ' : '';
  $k_pre     = ( isset( $settings['k_pre'] )     ) ? $settings['k_pre'] . '_' : '';
  $group     = ( isset( $settings['group'] )     ) ? $settings['group']       : 'general';
  $options   = ( isset( $settings['options'] )   ) ? $settings['options']     : array();
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition']   : array();
  $no_offset = ( isset( $settings['no_offset'] ) ) ? true                     : false;


  // Controls
  // --------

  $controls = array(
    array(
      'key'     => $k_pre . 'anim_type',
      'type'    => 'select',
      'title'   => __( 'Type', '__x__' ),
      'options' => array(
        'choices' => array(
          array( 'value' => 'none',              'label' => __( 'None', '__x__' ) ),
          array( 'value' => 'jello',             'label' => __( 'Jello', '__x__' ) ),
          array( 'value' => 'pulse',             'label' => __( 'Pulse', '__x__' ) ),
          array( 'value' => 'rubberBand',        'label' => __( 'Rubber Band', '__x__' ) ),
          array( 'value' => 'swing',             'label' => __( 'Swing', '__x__' ) ),
          array( 'value' => 'tada',              'label' => __( 'Tada', '__x__' ) ),
          array( 'value' => 'wobble',            'label' => __( 'Wobble', '__x__' ) ),
          array( 'value' => 'flip',              'label' => __( 'Flip', '__x__' ) ),
          array( 'value' => 'flipInX',           'label' => __( 'Flip In &ndash; X', '__x__' ) ),
          array( 'value' => 'flipInY',           'label' => __( 'Flip In &ndash; Y', '__x__' ) ),
          array( 'value' => 'fadeIn',            'label' => __( 'Fade In', '__x__' ) ),
          array( 'value' => 'fadeInUp',          'label' => __( 'Fade In &ndash; Up', '__x__' ) ),
          array( 'value' => 'fadeInDown',        'label' => __( 'Fade In &ndash; Down', '__x__' ) ),
          array( 'value' => 'fadeInLeft',        'label' => __( 'Fade In &ndash; Left', '__x__' ) ),
          array( 'value' => 'fadeInRight',       'label' => __( 'Fade In &ndash; Right', '__x__' ) ),
          array( 'value' => 'bounceIn',          'label' => __( 'Bounce In', '__x__' ) ),
          array( 'value' => 'bounceInUp',        'label' => __( 'Bounce In &ndash; Up', '__x__' ) ),
          array( 'value' => 'bounceInDown',      'label' => __( 'Bounce In &ndash; Down', '__x__' ) ),
          array( 'value' => 'bounceInLeft',      'label' => __( 'Bounce In &ndash; Left', '__x__' ) ),
          array( 'value' => 'bounceInRight',     'label' => __( 'Bounce In &ndash; Right', '__x__' ) ),
          array( 'value' => 'rotateIn',          'label' => __( 'Rotate In', '__x__' ) ),
          array( 'value' => 'rotateInUpLeft',    'label' => __( 'Rotate In &ndash; Up Left', '__x__' ) ),
          array( 'value' => 'rotateInUpRight',   'label' => __( 'Rotate In &ndash; Up Right', '__x__' ) ),
          array( 'value' => 'rotateInDownLeft',  'label' => __( 'Rotate In &ndash; Down Left', '__x__' ) ),
          array( 'value' => 'rotateInDownRight', 'label' => __( 'Rotate In &ndash; Down Right', '__x__' ) ),
          array( 'value' => 'zoomIn',            'label' => __( 'Zoom In', '__x__' ) ),
          array( 'value' => 'zoomInUp',          'label' => __( 'Zoom In &ndash; Up', '__x__' ) ),
          array( 'value' => 'zoomInDown',        'label' => __( 'Zoom In &ndash; Down', '__x__' ) ),
          array( 'value' => 'zoomInLeft',        'label' => __( 'Zoom In &ndash; Left', '__x__' ) ),
          array( 'value' => 'zoomInRight',       'label' => __( 'Zoom In &ndash; Right', '__x__' ) ),
        ),
      ),
    ),
    array(
      'key'     => $k_pre . 'anim_delay',
      'type'    => 'slider',
      'title'   => __( 'Delay<br>(Seconds)', '__x__' ),
      'options' => array(
        'unit_mode'      => 'unitless',
        'fallback_value' => 0,
        'min'            => 0,
        'max'            => 1.5,
        'step'           => 0.01,
      ),
    ),
    array(
      'key'     => $k_pre . 'anim_offset',
      'type'    => 'slider',
      'title'   => __( 'Offset Top<br>Distance', '__x__' ),
      'options' => array(
        'available_units' => array( 'px', 'em', 'rem', '%' ),
        'fallback_value'  => '50%',
        'ranges'          => array(
          'px'  => array( 'min' => '0', 'max' => '150', 'step' => '1'    ),
          'em'  => array( 'min' => '0', 'max' => '15',  'step' => '0.01' ),
          'rem' => array( 'min' => '0', 'max' => '15',  'step' => '0.01' ),
          '%'   => array( 'min' => '0', 'max' => '100', 'step' => '1'    ),
        ),
      ),
    ),
  );

  if ( $no_offset ) {
    array_pop( $controls );
  }


  // Data
  // ----

  $data = array(
    'type'       => 'group',
    'title'      => __( $t_pre . 'Animation', '__x__' ),
    'group'      => $group,
    'options'    => $options,
    'conditions' => x_module_conditions( $condition ),
    'controls'   => $controls,
  );


  // Returned Value
  // --------------

  $control = array( $data );

  return $control;

}
