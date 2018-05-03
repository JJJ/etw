<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/_LINK.PHP
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

function x_control_link( $settings = array() ) {

  // Setup
  // -----

  $t_pre     = ( isset( $settings['t_pre'] )     ) ? $settings['t_pre'] . ' ' : '';
  $k_pre     = ( isset( $settings['k_pre'] )     ) ? $settings['k_pre'] . '_' : '';
  $group     = ( isset( $settings['group'] )     ) ? $settings['group']       : 'general';
  $options   = ( isset( $settings['options'] )   ) ? $settings['options']     : array();
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition']   : array();
  $content   = ( isset( $settings['content'] )   ) ? true                     : false;
  $info      = ( isset( $settings['info'] )      ) ? true                     : false;
  $blank     = ( isset( $settings['blank'] )     ) ? true                     : false;
  $nofollow  = ( isset( $settings['nofollow'] )  ) ? true                     : false;


  // Data
  // ----

  $data = array(
    'type'       => 'link',
    'title'      => __( $t_pre . 'Link', '__x__' ),
    'group'      => $group,
    'options'    => $options,
    'conditions' => x_module_conditions( $condition ),
  );


  // Keys
  // ----

  $keys = array(
    'url' => $k_pre . 'href',
  );

  if ( $content == true ) {
    $keys['content'] = $k_pre . 'content';
  }

  if ( $info == true ) {
    $keys['has_info'] = $k_pre . 'info';
  }

  if ( $blank == true ) {
    $keys['new_tab'] = $k_pre . 'blank';
  }

  if ( $nofollow == true ) {
    $keys['nofollow'] = $k_pre . 'nofollow';
  }

  $data['keys'] = $keys;


  // Returned Value
  // --------------

  $control = array( $data );

  return $control;

}
