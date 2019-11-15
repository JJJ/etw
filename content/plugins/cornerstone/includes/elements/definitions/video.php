<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/VIDEO.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Groups
//   03. Values
//   04. Define Element
//   05. Builder Setup
//   06. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  array(
    'video_type'        => cs_value( 'embed', 'markup' ),
    'video_embed_code'  => cs_value( '', 'markup:html', true ),
    'mejs_source_files' => cs_value( '', 'markup:raw', true ),
    'mejs_poster'       => cs_value( '', 'markup', true )
  ),
  'mejs',
  'mejs:video',
  'frame',
  'omega'
);


// Style
// =============================================================================

function x_element_style_video() {

  $style = cs_get_partial_style( 'frame' );
  $style .= cs_get_partial_style( 'mejs' );

  return $style;

}



// Render
// =============================================================================

function x_element_render_video( $data ) {

  $frame_content = cs_get_partial_view(
    'video',
    array_merge(
      cs_extract( $data, array( 'video' => '', 'mejs' => '' ) ),
      array( 'id' => '', 'class' => '' )
    )
  );

  return cs_get_partial_view(
    'frame',
    array_merge(
      cs_extract( $data, array( 'frame' => '' ) ),
      array(
        'frame_content' => $frame_content,
        'frame_content_type' => 'video-' . $data['video_type']
      )
    )
  );


}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Video', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_video',
  'style' => 'x_element_style_video',
  'render' => 'x_element_render_video',
  'icon' => 'native',
  'options' => array(
    'empty_placeholder' => false
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_video() {

  // Individual Controls
  // -------------------

  $control_video_type = array(
    'key'     => 'video_type',
    'type'    => 'choose',
    'label'   => __( 'Video Type', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'embed',  'label' => __( 'Embed', '__x__' ) ),
        array( 'value' => 'player', 'label' => __( 'Player', '__x__' ) ),
      ),
    ),
  );

  $control_video_embed_code = array(
    'key'       => 'video_embed_code',
    'type'      => 'textarea',
    'label'     => __( 'Embed Code', '__x__' ),
    'condition' => array( 'video_type' => 'embed' ),
    'options'   => array(
      'height'    => 4,
      'monospace' => true,
    ),
  );

  $control_video_mejs_source_files = array(
    'key'       => 'mejs_source_files',
    'type'      => 'textarea',
    'label'     => __( 'Sources<br>(1 Per Line)', '__x__' ),
    'condition' => array( 'video_type' => 'player' ),
    'options'   => array(
      'height'    => 2,
      'monospace' => true,
    ),
  );

  $control_video_mejs_poster = array(
    'key'       => 'mejs_poster',
    'type'      => 'image-source',
    'label'     => __( 'Poster', '__x__' ),
    'condition' => array( 'video_type' => 'player' ),
    'options'   => array(
      'height' => 2,
    ),
  );

  $control_video_setup = array(
    'type'       => 'group',
    'label'      => __( 'Setup', '__x__' ),
    'group'      => 'video:setup',
    'controls'   => array(
      $control_video_type,
      $control_video_embed_code,
      $control_video_mejs_source_files,
      $control_video_mejs_poster,
    ),
  );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array( $control_video_setup ),
      'controls_std_content' => array(
        cs_amend_control( $control_video_setup, array( 'label' => __( 'Content Setup', '__x__' ) ) )
      ),
      'control_nav' => array(
        'video'       => __( 'Video', '__x__' ),
        'video:setup' => __( 'Setup', '__x__' ),
        'video:mejs'  => __( 'Controls', '__x__' ),
      ),
    ),
    cs_partial_controls( 'mejs', array(
      'group'     => 'video:mejs',
      'conditions' => array( array( 'video_type' => 'player' ) ),
      'type'      => 'video',
    ) ),
    cs_partial_controls( 'frame', array( 'frame_content_type' => 'video' ) ),
    cs_partial_controls( 'omega' )
  );

}



// Register Module
// =============================================================================

cs_register_element( 'video', $data );
