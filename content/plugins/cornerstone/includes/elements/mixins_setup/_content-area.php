<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/_CONTENT-AREA.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Shared
//   02. Setup
//   03. Groups
//   04. Control Groups
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================
// 01. Available types:
//     -- 'standard'
//     -- 'dropdown'
//     -- 'modal'
//     -- 'off-canvas'

$t_pre       = ( isset( $settings['t_pre'] )       ) ? $settings['t_pre'] . ' ' : '';
$k_pre       = ( isset( $settings['k_pre'] )       ) ? $settings['k_pre'] . '_' : '';
$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'content_area';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Content Area', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();
$type        = ( isset( $settings['type'] )        ) ? $settings['type']        : 'standard'; // 01



// Groups
// =============================================================================

$group_content_area_setup = $group . ':setup';



// Control Groups
// =============================================================================

$control_group_content_area_content = array(
  array(
    'key'     => $k_pre . 'content',
    'type'    => 'text-editor',
    'title'   => __( $t_pre . 'Content', '__x__' ),
    'group'   => $is_adv ? $group_content_area_setup : $group_std_content,
    'options' => array(
      'mode'   => 'html',
      'height' => 5,
    ),
  ),
);