<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/_IMAGE.PHP
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

function x_control_image( $settings = array() ) {

  // Setup
  // -----

  $t_pre     = ( isset( $settings['t_pre'] )     ) ? $settings['t_pre'] . ' ' : '';
  $k_pre     = ( isset( $settings['k_pre'] )     ) ? $settings['k_pre'] . '_' : '';
  $group     = ( isset( $settings['group'] )     ) ? $settings['group']       : 'general';
  $options   = ( isset( $settings['options'] )   ) ? $settings['options']     : array();
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition']   : array();
  $is_retina = ( isset( $settings['is_retina'] ) ) ? true                     : false;
  $width     = ( isset( $settings['width'] )     ) ? true                     : false;
  $height    = ( isset( $settings['height'] )    ) ? true                     : false;
  $has_link  = ( isset( $settings['has_link'] )  ) ? true                     : false;
  $has_info  = ( isset( $settings['has_info'] )  ) ? true                     : false;
  $alt_text  = ( isset( $settings['alt_text'] )  ) ? true                     : false;


  // Data
  // ----

  $data = array(
    'type'       => 'image',
    'title'      => __( $t_pre . 'Image', '__x__' ),
    'group'      => $group,
    'options'    => $options,
    'conditions' => x_module_conditions( $condition ),
  );


  // Keys
  // ----

  $keys = array(
    'img_source' => $k_pre . 'image_src',
  );

  if ( $is_retina === true ) {
    $keys['is_retina'] = $k_pre . 'image_retina';
  }

  if ( $width === true ) {
    $keys['width'] = $k_pre . 'image_width';
  }

  if ( $height === true ) {
    $keys['height'] = $k_pre . 'image_height';
  }

  if ( $has_link === true ) {
    $keys['has_link'] = $k_pre . 'image_link';
  }

  if ( $has_info === true ) {
    $keys['has_info'] = $k_pre . 'image_info';
  }

  if ( $alt_text === true ) {
    $keys['alt_text'] = $k_pre . 'image_alt';
  }

  $data['keys'] = $keys;


  // Returned Value
  // --------------

  $control = array( $data );

  return $control;

}