<?php

// Section
// =============================================================================

function x_shortcode_section( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'id'                           => '',
    'class'                        => '',
    'style'                        => '',
    'bg_color'                     => '',
    'bg_pattern'                   => '',
    'bg_image'                     => '',
    'bg_video'                     => '',
    'bg_video_poster'              => '',
    'parallax'                     => '',
    'separator_top_type'           => 'none',
    'separator_top_height'         => '',
    'separator_top_angle_point'    => '',
    'separator_bottom_type'        => 'none',
    'separator_bottom_height'      => '',
    'separator_bottom_angle_point' => '',
  ), $atts, 'x_section' ) );

  static $count = 0; $count++;

  $id                           = ( $id                           != ''     ) ? $id : 'x-section-' . $count;
  $class                        = ( $class                        != ''     ) ? 'x-section ' . $class : 'x-section';
  $style                        = ( $style                        != ''     ) ? $style : '';
  $bg_color                     = ( $bg_color                     != ''     ) ? cornerstone_post_process_color( $bg_color ) : 'transparent';
  $bg_pattern                   = ( $bg_pattern                   != ''     ) ? $bg_pattern : '';
  $bg_image                     = ( $bg_image                     != ''     ) ? $bg_image : '';
  $bg_video                     = ( $bg_video                     != ''     ) ? $bg_video : '';
  $bg_video_poster              = ( $bg_video_poster              != ''     ) ? $bg_video_poster : '';
  $parallax                     = ( $parallax                     == 'true' ) ? $parallax : '';
  $parallax_class               = ( $parallax                     == 'true' ) ? ' parallax' : '';
  $separator_top_type           = ( $separator_top_type           != 'none' ) ? $separator_top_type : 'none';
  $separator_top_height         = ( $separator_top_height         != ''     ) ? $separator_top_height : '50px';
  $separator_top_angle_point    = ( $separator_top_angle_point    != ''     ) ? $separator_top_angle_point : '50';
  $separator_bottom_type        = ( $separator_bottom_type        != 'none' ) ? $separator_bottom_type : 'none';
  $separator_bottom_height      = ( $separator_bottom_height      != ''     ) ? $separator_bottom_height : '50px';
  $separator_bottom_angle_point = ( $separator_bottom_angle_point != ''     ) ? $separator_bottom_angle_point : '50';


  // Backgrounds
  // -----------

  if ( $bg_video != '' ) {

    $data     = cs_generate_data_attributes( 'section', array( 'type' => 'video' ) );
    $before   = cs_bg_video( $bg_video, $bg_video_poster );
    $bg_style = 'background-color: ' . $bg_color . ';';
    $bg_class = ' bg-video';

  } elseif ( $bg_image != '' ) {

    $data     = cs_generate_data_attributes( 'section', array( 'type' => 'image', 'parallax' => ( $parallax == 'true' ) ) );
    $before   = '';
    $bg_style = 'background-image: url(' . $bg_image . '); background-color: ' . $bg_color . ';';
    $bg_class = ' bg-image' . $parallax_class;

  } elseif ( $bg_pattern != '' ) {

    $data     = cs_generate_data_attributes( 'section', array( 'type' => 'pattern', 'parallax' => ( $parallax == 'true' ) ) );
    $before   = '';
    $bg_style = 'background-image: url(' . $bg_pattern . '); background-color: ' . $bg_color . ';';
    $bg_class = ' bg-pattern' . $parallax_class;

  } else {

    $data     = '';
    $before   = '';
    $bg_style = 'background-color: ' . $bg_color . ';';
    $bg_class = '';

  }


  // Separator - Top
  // ---------------

  $separator_top = '';

  if ( $separator_top_type != 'none' ) {

    switch ( $separator_top_type ) {
      case 'angle-out' :
        $separator_top_content = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" class="angle-top-out" style="fill: ' . $bg_color . ';"><polygon points="' . $separator_top_angle_point . ',0 100,100 0,100"/></svg>';
        break;
      case 'angle-in' :
        $separator_top_content = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" class="angle-top-in" style="fill: ' . $bg_color . ';"><polygon points="0,100 ' . $separator_top_angle_point . ',100 0,0"/><polygon points="' . $separator_top_angle_point . ',100 100,100 100,0"/></svg>';
        break;
      case 'curve-out' :
        $separator_top_content = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 50" preserveAspectRatio="none" class="curve-top-out" style="fill: ' . $bg_color . ';"><path d="M0,50C0,50,22.4,0,50,0s50,50,50,50"/></svg>';
        break;
      case 'curve-in' :
        $separator_top_content = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 50" preserveAspectRatio="none" class="curve-top-in" style="fill: ' . $bg_color . ';"><path d="M0,0v50h50C22.4,50,0,0,0,0z"/><path d="M50,50h50V0C100,0,77.6,50,50,50z"/></svg>';
        break;
      default :
        $separator_top_content = '';
        break;
    }

    $separator_top = '<div class="x-section-separator x-section-separator-top x-section-separator-' . $separator_top_type . '" style="height: ' . $separator_top_height . ';">' . $separator_top_content . '</div>';

  }


  // Separator - Bottom
  // ------------------

  $separator_bottom = '';

  if ( $separator_bottom_type != 'none' ) {

    switch ( $separator_bottom_type ) {
      case 'angle-out' :
        $separator_bottom_content = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" class="angle-bottom-out" style="fill: ' . $bg_color . ';"><polygon points="' . $separator_bottom_angle_point . ',100 100,0 0,0"></svg>';
        break;
      case 'angle-in' :
        $separator_bottom_content = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" class="angle-bottom-in" style="fill: ' . $bg_color . ';"><polygon points="0,0 ' . $separator_bottom_angle_point . ',0 0,100"/><polygon points="' . $separator_bottom_angle_point . ',0 100,0 100,100"/></svg>';
        break;
      case 'curve-out' :
        $separator_bottom_content = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 50" preserveAspectRatio="none" class="curve-bottom-out" style="fill: ' . $bg_color . ';"><path d="M0,0c0,0,22.4,50,50,50s50-50,50-50"/></svg>';
        break;
      case 'curve-in' :
        $separator_bottom_content = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 50" preserveAspectRatio="none" class="curve-bottom-in" style="fill: ' . $bg_color . ';"><path d="M0,50V0h50C22.4,0,0,50,0,50z"/><path d="M50,0h50v50C100,50,77.6,0,50,0z"/></svg>';
        break;
      default :
        $separator_bottom_content = '';
        break;
    }

    $separator_bottom = '<div class="x-section-separator x-section-separator-bottom x-section-separator-' . $separator_bottom_type . '" style="height: ' . $separator_bottom_height . ';">' . $separator_bottom_content . '</div>';

  }


  // Atts
  // ----

  $atts = cs_atts( array(
    'id'    => $id,
    'class' => trim( $class . $bg_class ),
    'style' => $style . ' ' . $bg_style
  ) );


  // Output
  // ------

  $content = $separator_top . $before . do_shortcode( $content ) . $separator_bottom;
  $output  = "<div {$atts} {$data}>" . $content . '</div>';

  return $output;

}

add_shortcode( 'cs_section', 'x_shortcode_section' );
add_shortcode( 'x_section', 'x_shortcode_section' );
