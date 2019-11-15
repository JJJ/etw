<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/AUDIO.PHP
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
    'audio_type'        => cs_value( 'embed', 'markup' ),
    'audio_width'       => cs_value( '100%', 'style' ),
    'audio_max_width'   => cs_value( 'none', 'style' ),
    'audio_embed_code'  => cs_value( '', 'markup:html', true ),
    'mejs_source_files' => cs_value( '', 'markup:raw', true ),
    'audio_margin'      => cs_value( '0em', 'style' ),
  ),
  'mejs',
  'omega'
);


// Style
// =============================================================================

function x_element_style_audio() {

  ob_start();

  echo cs_get_partial_style( 'mejs' );

  ?>

  .$_el.x-audio {
    width: $audio_width;
    @unless $audio_max_width?? {
      max-width: $audio_max_width;
    }
    margin: $audio_margin;
  }

  <?php

  return ob_get_clean();
}



// Render
// =============================================================================

function x_element_render_audio( $data ) {
  return cs_get_partial_view( 'audio', cs_extract( $data, array( 'audio' => '', 'mejs' => '' ) ) );
}


// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Audio', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_audio',
  'style' => 'x_element_style_audio',
  'render' => 'x_element_render_audio',
  'icon' => 'native',
  'options' => array(
    'empty_placeholder' => false
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_audio() {

  // Settings
  // --------

  $settings_audio = array(
    'k_pre'     => 'audio',
    'group'     => 'audio:setup',
  );

  $settings_audio_mejs = array(
    'group'     => 'audio:mejs',
    'conditions' => array( array( 'audio_type' => 'player' ) ),
    'type'      => 'audio',
  );

  // Individual Controls
  // -------------------

  $control_audio_type = array(
    'key'     => 'audio_type',
    'type'    => 'choose',
    'label'   => __( 'Audio Type', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'embed',  'label' => __( 'Embed', '__x__' ) ),
        array( 'value' => 'player', 'label' => __( 'Player', '__x__' ) ),
      ),
    ),
  );

  $control_audio_width = array(
    'key'     => 'audio_width',
    'type'    => 'unit',
    'label'   => __( 'Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '100%',
      'ranges'          => array(
        'px'  => array( 'min' => 100, 'max' => 500, 'step' => 10  ),
        'em'  => array( 'min' => 5,   'max' => 40,  'step' => 0.5 ),
        'rem' => array( 'min' => 5,   'max' => 40,  'step' => 0.5 ),
        '%'   => array( 'min' => 0,   'max' => 100, 'step' => 1   ),
      ),
    ),
  );

  $control_audio_max_width = array(
    'key'     => 'audio_max_width',
    'type'    => 'unit',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'valid_keywords'  => array( 'calc', 'none' ),
      'fallback_value'  => '300px',
      'ranges'          => array(
        'px'  => array( 'min' => 100, 'max' => 500, 'step' => 10  ),
        'em'  => array( 'min' => 5,   'max' => 40,  'step' => 0.5 ),
        'rem' => array( 'min' => 5,   'max' => 40,  'step' => 0.5 ),
        '%'   => array( 'min' => 0,   'max' => 100, 'step' => 1   ),
      ),
    ),
  );

  $control_audio_width_and_max_width = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Max Width', '__x__' ),
    'controls' => array(
      $control_audio_width,
      $control_audio_max_width,
    ),
  );

  $control_audio_embed_code = array(
    'key'       => 'audio_embed_code',
    'type'      => 'textarea',
    'label'     => __( 'Embed Code', '__x__' ),
    'condition' => array( 'audio_type' => 'embed' ),
    'options'   => array(
      'height'    => 3,
      'monospace' => true,
    ),
  );

  $control_audio_mejs_source_files = array(
    'key'       => 'mejs_source_files',
    'type'      => 'textarea',
    'label'     => __( 'Sources<br>(1 Per Line)', '__x__' ),
    'condition' => array( 'audio_type' => 'player' ),
    'options'   => array(
      'height'    => 3,
      'monospace' => true,
    ),
  );


  // Control Groups (Advanced)
  // -------------------------


  $control_group_audio_adv_setup = array(
    'type'       => 'group',
    'label'      => __( 'Setup', '__x__' ),
    'group'      => 'audio:setup',
    'controls'   => array(
      $control_audio_type,
      $control_audio_width_and_max_width,
      $control_audio_embed_code,
      $control_audio_mejs_source_files
    ),
  );


  // Control Groups (Standard)
  // -------------------------

  $control_group_audio_std_content_setup = array(
    array(
      'type'       => 'group',
      'label'      => __( 'Content Setup', '__x__' ),
      'controls'   => array(
        $control_audio_type,
        $control_audio_embed_code,
        $control_audio_mejs_source_files,
      ),
    ),
  );

  $control_group_audio_std_design_setup = array(
    array(
      'type'       => 'group',
      'label'      => __( 'Design Setup', '__x__' ),
      'controls'   => array(
        cs_amend_control( $control_audio_width, array( 'type' => 'unit-slider') ),
        cs_amend_control( $control_audio_max_width, array( 'type' => 'unit-slider') )
      ),
    ),
    cs_control( 'margin', 'audio' )
  );

  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        $control_group_audio_adv_setup,
        cs_control( 'margin', 'audio', array( 'group' => 'audio:setup' ) )
      ),
      'controls_std_content' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Content Setup', '__x__' ),
          'controls'   => array(
            $control_audio_type,
            $control_audio_embed_code,
            $control_audio_mejs_source_files,
          ),
        )
      ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            cs_amend_control( $control_audio_width, array( 'type' => 'unit-slider') ),
            cs_amend_control( $control_audio_max_width, array( 'type' => 'unit-slider') )
          ),
        ),
        cs_control( 'margin', 'audio' )
      ),
      'control_nav' => array(
        'audio'       => __( 'Audio', '__x__' ),
        'audio:setup' => __( 'Setup', '__x__' ),
        'audio:mejs'  => __( 'Controls', '__x__' ),
      ),
    ),
    cs_partial_controls( 'mejs', array(
      'group'     => 'audio:mejs',
      'conditions' => array( array( 'audio_type' => 'player' ) ),
      'type'      => 'audio',
    ) ),
    cs_partial_controls( 'omega' )
  );

}



// Register Module
// =============================================================================

cs_register_element( 'audio', $data );
