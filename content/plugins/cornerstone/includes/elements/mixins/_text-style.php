<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/_TEXT-STYLE.PHP
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

function x_control_text_style( $settings = array() ) {

  // Setup
  // -----

  $t_pre              = ( isset( $settings['t_pre'] )              ) ? $settings['t_pre'] . ' ' : '';
  $k_pre              = ( isset( $settings['k_pre'] )              ) ? $settings['k_pre'] . '_' : '';
  $group              = ( isset( $settings['group'] )              ) ? $settings['group']       : 'general';
  $options            = ( isset( $settings['options'] )            ) ? $settings['options']     : array();
  $condition          = ( isset( $settings['condition'] )          ) ? $settings['condition']   : array();
  $alt_color          = ( isset( $settings['alt_color'] )          ) ? true                     : false;
  $no_font_style      = ( isset( $settings['no_font_style'] )      ) ? true                     : false;
  $no_text_align      = ( isset( $settings['no_text_align'] )      ) ? true                     : false;
  $no_text_decoration = ( isset( $settings['no_text_decoration'] ) ) ? true                     : false;
  $no_text_transform  = ( isset( $settings['no_text_transform'] )  ) ? true                     : false;
  $no_text_color      = ( isset( $settings['no_text_color'] )      ) ? true                     : false;


  // Data
  // ----

  $data = array(
    'type'       => 'text-style',
    'title'      => __( $t_pre . 'Text Style', '__x__' ),
    'group'      => $group,
    'options'    => $options,
    'conditions' => x_module_conditions( $condition ),
  );


  // Keys
  // ----

  $keys = array(
    'font_style'      => $k_pre . 'font_style',
    'text_align'      => $k_pre . 'text_align',
    'text_decoration' => $k_pre . 'text_decoration',
    'text_transform'  => $k_pre . 'text_transform',
    'text_color'      => $k_pre . 'text_color',
  );

  if ( $alt_color == true )          { $keys['alt_color'] = $k_pre . 'text_color_alt'; }
  if ( $no_font_style == true )      { unset( $keys['font_style'] );                   }
  if ( $no_text_align == true )      { unset( $keys['text_align'] );                   }
  if ( $no_text_decoration == true ) { unset( $keys['text_decoration'] );              }
  if ( $no_text_transform == true )  { unset( $keys['text_transform'] );               }
  if ( $no_text_color == true )      { unset( $keys['text_color'] );                   }

  $data['keys'] = $keys;


  // Returned Value
  // --------------

  $control = array( $data );

  return $control;

}
