<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/RATING.PHP
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

function x_control_partial_rating( $settings ) {

  // Setup
  // -----
  // 01. Available types (not used at the moment):
  //     -- 'reviewRating'
  //     -- 'aggregateRating'

  $label_prefix   = ( isset( $settings['label_prefix'] )   ) ? $settings['label_prefix']   : '';
  $k_pre          = ( isset( $settings['k_pre'] )          ) ? $settings['k_pre'] . '_'    : '';
  $group          = ( isset( $settings['group'] )          ) ? $settings['group']          : 'rating';
  $group_title    = ( isset( $settings['group_title'] )    ) ? $settings['group_title']    : __( 'Rating', '__x__' );
  $conditions     = ( isset( $settings['conditions'] )     ) ? $settings['conditions']     : array();
  $allow_enable   = ( isset( $settings['allow_enable'] )   ) ? $settings['allow_enable']   : array();
  $controls_setup = ( isset( $settings['controls_setup'] ) ) ? $settings['controls_setup'] : array();
  $type           = ( isset( $settings['type'] )           ) ? $settings['type']           : 'reviewRating'; // 01


  // Groups
  // ------

  $group_rating_setup   = $group . ':setup';
  $group_rating_content = $group . ':content';
  $group_rating_schema  = $group . ':schema';
  $group_rating_graphic = $group . ':graphic';
  $group_rating_design  = $group . ':design';
  $group_rating_text    = $group . ':text';


  // Individual Conditions
  // ---------------------
  // Not used on actual controls as we need to account for `allow_enable`
  // sometimes. Only setup to make condition management easier.

  $condition_rating                     = ( $allow_enable ) ? array( $k_pre . 'rating' => true ) : array();
  $condition_rating_text                = array( $k_pre . 'rating_text' => true );
  $condition_rating_graphic_type_icon   = array( $k_pre . 'rating_graphic_type' => 'icon' );
  $condition_rating_graphic_type_image  = array( $k_pre . 'rating_graphic_type' => 'image' );
  $condition_rating_schema              = array( $k_pre . 'rating_schema' => true );


  // Conditions
  // ----------

  $conditions_rating_main               = array_merge( $conditions, array( $condition_rating ) );
  $conditions_rating_text               = array_merge( $conditions, array( $condition_rating, $condition_rating_text ) );
  $conditions_rating_graphic_type_icon  = array_merge( $conditions, array( $condition_rating, $condition_rating_graphic_type_icon ) );
  $conditions_rating_graphic_type_image = array_merge( $conditions, array( $condition_rating, $condition_rating_graphic_type_image ) );
  $conditions_rating_schema             = array_merge( $conditions, array( $condition_rating, $condition_rating_schema ) );


  // Options
  // -------

  $options_rating_base_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 10, 'max' => 100, 'step' => 1   ),
      'em'  => array( 'min' => 1,  'max' => 8,   'step' => 0.5 ),
      'rem' => array( 'min' => 1,  'max' => 8,   'step' => 0.5 ),
    ),
  );

  $options_rating_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'valid_keywords'  => array( 'auto', 'calc' ),
    'fallback_value'  => 'auto',
    'ranges'          => array(
      'px'  => array( 'min' => 120, 'max' => 250, 'step' => 1    ),
      'em'  => array( 'min' => 10,  'max' => 20,  'step' => 0.25 ),
      'rem' => array( 'min' => 10,  'max' => 20,  'step' => 0.25 ),
      '%'   => array( 'min' => 50,  'max' => 100, 'step' => 1    ),
    ),
  );

  $options_rating_max_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'valid_keywords'  => array( 'none', 'calc' ),
    'fallback_value'  => 'none',
    'ranges'          => array(
      'px'  => array( 'min' => 250, 'max' => 450, 'step' => 1    ),
      'em'  => array( 'min' => 20,  'max' => 35,  'step' => 0.25 ),
      'rem' => array( 'min' => 20,  'max' => 35,  'step' => 0.25 ),
      '%'   => array( 'min' => 50,  'max' => 100, 'step' => 1    ),
    ),
  );

  $options_rating_graphic_spacing = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '10px',
    'ranges'          => array(
      'px'  => array( 'min' => 0, 'max' => 5,   'step' => 1   ),
      'em'  => array( 'min' => 0, 'max' => 0.5, 'step' => 0.1 ),
      'rem' => array( 'min' => 0, 'max' => 0.5, 'step' => 0.1 ),
    ),
  );

  $options_rating_graphic_image = array(
    'height' => 1,
  );

  $options_rating_image_max_width = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '32px',
    'ranges'          => array(
      'px'  => array( 'min' => 10,  'max' => 32, 'step' => 1   ),
      'em'  => array( 'min' => 0.5, 'max' => 2,  'step' => 0.1 ),
      'rem' => array( 'min' => 0.5, 'max' => 2,  'step' => 0.1 ),
    ),
  );

  $options_rating_schema_item_reviewed = array(
    'placeholder' => __( 'FastFoodRestaurant', '__x__' ),
  );

  $options_rating_schema_item_name_content = array(
    'placeholder' => __( 'In-N-Out', '__x__' ),
  );

  $options_rating_schema_item_telephone_content = array(
    'placeholder' => __( '(555) 555-1234', '__x__' ),
  );

  $options_rating_schema_item_address_content = array(
    'height'      => 2,
    'placeholder' => __( '123 Imaginary Drive', '__x__' ),
  );

  $options_rating_schema_item_image_src = array(
    'height' => 2,
  );

  $options_rating_schema_author_content = array(
    'placeholder' => __( 'Gordon Ramsay', '__x__' ),
  );

  $options_rating_schema_review_body_content = array(
    'height' => 2,
  );



  // Settings
  // --------

  $settings_rating_design = array(
    'k_pre'      => $k_pre . 'rating',
    'group'      => $group_rating_design,
    'conditions' => $conditions_rating_main,
  );

  $settings_rating_text_margin = array(
    'k_pre'        => $k_pre . 'rating_text',
    'group'        => $group_rating_text,
    'label_prefix' => __( 'Text', '__x__' ),
    'conditions'   => $conditions_rating_text,
  );

  $settings_rating_text = array(
    'k_pre'      => $k_pre . 'rating',
    'group'      => $group_rating_text,
    'conditions' => $conditions_rating_text,
  );


  // Individual Controls - Begin
  // ---------------------------

  $control_rating = array();

  if ( $allow_enable ) {
    $control_rating = array(
      'key'     => $k_pre . 'rating',
      'type'    => 'choose',
      'label'   => __( 'Enable', '__x__' ),
      'options' => cs_recall( 'options_choices_off_on_bool' ),
    );
  }

  $control_rating_base_font_size = array(
    'key'        => $k_pre . 'rating_base_font_size',
    'type'       => 'unit-slider',
    'label'      => __( 'Base Font Size', '__x__' ),
    'options'    => $options_rating_base_font_size,
    'conditions' => $conditions_rating_main,
  );


  // Individual Controls - Scale and Value
  // -------------------------------------

  $control_rating_scale_min_content = array(
    'key'        => $k_pre . 'rating_scale_min_content',
    'type'       => 'text',
    'label'      => __( 'Min Scale', '__x__' ),
    'conditions' => $conditions_rating_main,
  );

  $control_rating_scale_max_content = array(
    'key'        => $k_pre . 'rating_scale_max_content',
    'type'       => 'text',
    'label'      => __( 'Max Scale', '__x__' ),
    'conditions' => $conditions_rating_main,
  );

  $control_rating_scale_min_and_max_content = array(
    'type'       => 'group',
    'label'      => __( 'Min &amp; Max Scale', '__x__' ),
    'conditions' => $conditions_rating_main,
    'controls'   => array(
      $control_rating_scale_min_content,
      $control_rating_scale_max_content,
    ),
  );

  $control_rating_value_content = array(
    'key'        => $k_pre . 'rating_value_content',
    'type'       => 'text',
    'label'      => __( 'Rating', '__x__' ),
    'conditions' => $conditions_rating_main,
  );


  // Individual Controls - Setup Styling
  // -----------------------------------

  $control_rating_width = array(
    'key'        => $k_pre . 'rating_width',
    'type'       => 'unit',
    'label'      => __( 'Width', '__x__' ),
    'options'    => $options_rating_width,
    'conditions' => $conditions_rating_main,
  );

  $control_rating_max_width = array(
    'key'        => $k_pre . 'rating_max_width',
    'type'       => 'unit',
    'label'      => __( 'Max Width', '__x__' ),
    'options'    => $options_rating_max_width,
    'conditions' => $conditions_rating_main,
  );

  $control_rating_width_and_max_width = array(
    'type'       => 'group',
    'label'      => __( 'Width &amp; Max Width', '__x__' ),
    'conditions' => $conditions_rating_main,
    'controls'   => array(
      $control_rating_width,
      $control_rating_max_width,
    ),
  );

  $control_rating_bg_color = array(
    'keys'       => array( 'value' => $k_pre . 'rating_bg_color' ),
    'type'       => 'color',
    'label'      => __( 'Background', '__x__' ),
    'conditions' => $conditions_rating_main,
  );


  // Individual Controls - Options and Content
  // -----------------------------------------

  $control_rating_options = array(
    'keys' => array(
      'empty_enable'  => $k_pre . 'rating_empty',
      'round_enable'  => $k_pre . 'rating_round',
      'text_enable'   => $k_pre . 'rating_text',
      'schema_enable' => $k_pre . 'rating_schema',
    ),
    'type'       => 'checkbox-list',
    'label'      => __( 'Options', '__x__' ),
    'conditions' => $conditions_rating_main,
    'options'    => array(
      'list' => array(
        array( 'key' => 'empty_enable',  'label' => __( 'Empty Icons', '__x__' )       ),
        array( 'key' => 'round_enable',  'label' => __( 'Round Whole', '__x__' ) ),
        array( 'key' => 'text_enable',   'label' => __( 'Show Text', '__x__' )        ),
        array( 'key' => 'schema_enable', 'label' => __( 'Add Schema', '__x__' )      ),
      ),
    ),
  );

  $control_rating_text_content = array(
    'key'        => $k_pre . 'rating_text_content',
    'type'       => 'text',
    'label'      => __( 'Text', '__x__' ),
    'conditions' => $conditions_rating_text,
  );


  // Individual Controls - Schema
  // ----------------------------

  $control_rating_schema_item_reviewed_type = array(
    'key'        => $k_pre . 'rating_schema_item_reviewed_type',
    'type'       => 'text',
    'label'      => __( 'Type', '__x__' ) . '<a href="https://schema.org/Organization" target="_blank" style="display: -webkit-flex; display: flex; -webkit-justify-content: center; justify-content: center; -webkit-align-items: center; align-items: center; position: absolute; top: 50%; right: 10px; width: 2.75em; height: 1.5em; border-radius: 2px; font-size: 1em; line-height: 1; text-align: center; text-decoration: none; background-color: currentColor; transform: translate3d(0, -50%, 0);"><span style="color: #ffffff;">↪</span></a>',
    'options'    => $options_rating_schema_item_reviewed,
    'conditions' => $conditions_rating_schema,
  );

  $control_rating_schema_item_name_content = array(
    'key'        => $k_pre . 'rating_schema_item_name_content',
    'type'       => 'text',
    'label'      => __( 'Item<br/>Name', '__x__' ),
    'conditions' => $conditions_rating_schema,
    'options'    => $options_rating_schema_item_name_content,
  );

  $control_rating_schema_item_telephone_content = array(
    'key'        => $k_pre . 'rating_schema_item_telephone_content',
    'type'       => 'text',
    'label'      => __( 'Item<br/>Telephone', '__x__' ),
    'conditions' => $conditions_rating_schema,
    'options'    => $options_rating_schema_item_telephone_content,
  );

  $control_rating_schema_item_address_content = array(
    'key'        => $k_pre . 'rating_schema_item_address_content',
    'type'       => 'textarea',
    'label'      => __( 'Item<br/>Address', '__x__' ),
    'conditions' => $conditions_rating_schema,
    'options'    => $options_rating_schema_item_address_content,
  );

  $control_rating_schema_item_image_src = array(
    'key'        => $k_pre . 'rating_schema_item_image_src',
    'type'       => 'image-source',
    'label'      => __( 'Item<br/>Image', '__x__' ),
    'conditions' => $conditions_rating_schema,
    'options'    => $options_rating_schema_item_image_src,
  );

  $control_rating_schema_author_content = array(
    'key'        => $k_pre . 'rating_schema_author_content',
    'type'       => 'text',
    'label'      => __( 'Author<br/>Name', '__x__' ),
    'conditions' => $conditions_rating_schema,
    'options'    => $options_rating_schema_author_content,
  );

  $control_rating_schema_review_body_content = array(
    'key'        => $k_pre . 'rating_schema_review_body_content',
    'type'       => 'textarea',
    'label'      => __( 'Author<br/>Review', '__x__' ),
    'conditions' => $conditions_rating_schema,
    'options'    => $options_rating_schema_review_body_content,
  );


  // Individual Controls - Graphic
  // -----------------------------

  $control_rating_graphic_type = array(
    'key'     => $k_pre . 'rating_graphic_type',
    'type'    => 'choose',
    'label'   => __( 'Type', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'icon',  'icon' => 'flag' ),
        array( 'value' => 'image', 'icon' => 'image' ),
      ),
    ),
  );

  $control_rating_graphic_spacing = array(
    'key'       => $k_pre . 'rating_graphic_spacing',
    'type'      => 'unit',
    'label'     => __( 'Graphic Spacing', '__x__' ),
    'options'   => $options_rating_graphic_spacing,
  );


  // Individual Controls - Graphic (Icons)
  // -------------------------------------

  $control_rating_graphic_full_icon = array(
    'key'        => $k_pre . 'rating_graphic_full_icon',
    'type'       => 'icon',
    'label'      => __( 'Full', '__x__' ),
    'conditions' => $conditions_rating_graphic_type_icon,
  );

  $control_rating_graphic_half_icon = array(
    'key'        => $k_pre . 'rating_graphic_half_icon',
    'type'       => 'icon',
    'label'      => __( 'Half Full', '__x__' ),
    'conditions' => $conditions_rating_graphic_type_icon,
  );

  $control_rating_graphic_empty_icon = array(
    'key'        => $k_pre . 'rating_graphic_empty_icon',
    'type'       => 'icon',
    'label'      => __( 'Empty', '__x__' ),
    'conditions' => $conditions_rating_graphic_type_icon,
  );

  $control_rating_graphic_icon_color = array(
    'keys'       => array( 'value' => $k_pre . 'rating_graphic_icon_color' ),
    'type'       => 'color',
    'label'      => __( 'Graphic', '__x__' ),
    'conditions' => $conditions_rating_graphic_type_icon,
  );

  $control_rating_graphic_spacing_and_icon_color = array(
    'type'       => 'group',
    'label'      => __( 'Spacing &amp; Color', '__x__' ),
    'conditions' => $conditions_rating_graphic_type_icon,
    'controls'  => array(
      $control_rating_graphic_spacing,
      $control_rating_graphic_icon_color,
    ),
  );


  // Individual Controls - Graphic (Images)
  // --------------------------------------

  $control_rating_graphic_full_image_src = array(
    'key'        => $k_pre . 'rating_graphic_full_image_src',
    'type'       => 'image-source',
    'label'      => __( 'Full', '__x__' ),
    'conditions' => $conditions_rating_graphic_type_image,
    'options'    => $options_rating_graphic_image,
  );

  $control_rating_graphic_half_image_src = array(
    'key'        => $k_pre . 'rating_graphic_half_image_src',
    'type'       => 'image-source',
    'label'      => __( 'Half Full', '__x__' ),
    'conditions' => $conditions_rating_graphic_type_image,
    'options'    => $options_rating_graphic_image,
  );

  $control_rating_graphic_empty_image_src = array(
    'key'        => $k_pre . 'rating_graphic_empty_image_src',
    'type'       => 'image-source',
    'label'      => __( 'Empty', '__x__' ),
    'conditions' => $conditions_rating_graphic_type_image,
    'options'    => $options_rating_graphic_image,
  );

  $control_rating_graphic_image_max_width = array(
    'key'        => $k_pre . 'rating_graphic_image_max_width',
    'type'       => 'unit',
    'label'      => __( 'Max Width', '__x__' ),
    'options'    => $options_rating_image_max_width,
    'conditions' => $conditions_rating_graphic_type_image,
  );

  $control_rating_graphic_spacing_and_image_max_width = array(
    'type'       => 'group',
    'label'      => __( 'Spacing &amp; Max Width', '__x__' ),
    'conditions' => $conditions_rating_graphic_type_image,
    'controls'   => array(
      $control_rating_graphic_spacing,
      $control_rating_graphic_image_max_width,
    ),
  );


  // Control List
  // ------------

  foreach ( $controls_setup as $i => $control ) {
    $controls_setup[$i]['conditions'] = $conditions_rating_main;
  }

  $control_list_rating_setup = array_merge(
    array(
      $control_rating,
      $control_rating_base_font_size,
      $control_rating_value_content,
      $control_rating_scale_min_and_max_content,
      $control_rating_width_and_max_width,
      $control_rating_bg_color,
      $control_rating_options,
      $control_rating_text_content,
    ),
    $controls_setup
  );


  // Compose Controls
  // ----------------

  return array(
    'controls' => array_merge(
      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => $group_rating_setup,
          'conditions' => $conditions,
          'controls'   => $control_list_rating_setup,
        ),
        array(
          'type'       => 'group',
          'label'      => __( 'Schema', '__x__' ),
          'group'      => $group_rating_schema,
          'conditions' => $conditions_rating_schema,
          'controls'   => array(
            $control_rating_schema_item_reviewed_type,
            $control_rating_schema_item_name_content,
            $control_rating_schema_item_telephone_content,
            $control_rating_schema_item_address_content,
            $control_rating_schema_item_image_src,
            $control_rating_schema_author_content,
            $control_rating_schema_review_body_content,
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => __( 'Graphic', '__x__' ),
          'group'      => $group_rating_graphic,
          'conditions' => $conditions_rating_main,
          'controls'   => array(
            $control_rating_graphic_type,
            $control_rating_graphic_full_icon,
            $control_rating_graphic_half_icon,
            $control_rating_graphic_empty_icon,
            $control_rating_graphic_spacing_and_icon_color,
            $control_rating_graphic_full_image_src,
            $control_rating_graphic_half_image_src,
            $control_rating_graphic_empty_image_src,
            $control_rating_graphic_spacing_and_image_max_width,
          ),
        ),
      ),

      x_control_flexbox( $settings_rating_design ),
      x_control_margin( $settings_rating_design ),
      x_control_padding( $settings_rating_design ),
      x_control_border( $settings_rating_design ),
      x_control_border_radius( $settings_rating_design ),
      x_control_box_shadow( $settings_rating_design ),

      x_control_margin( $settings_rating_text_margin ),
      x_control_text_format( $settings_rating_text ),
      x_control_text_shadow( $settings_rating_text )
    ),
    'controls_std_content' => array(
      array(
        'type'       => 'group',
        'label'      => __( 'Content', '__x__' ),
        'conditions' => $conditions,
        'controls'   => array(
          $control_rating_value_content,
          $control_rating_scale_min_and_max_content,
          $control_rating_text_content,
          $control_rating_graphic_full_icon,
          $control_rating_graphic_half_icon,
          $control_rating_graphic_empty_icon,
          $control_rating_graphic_full_image_src,
          $control_rating_graphic_half_image_src,
          $control_rating_graphic_empty_image_src,
        ),
      ),
      array(
        'type'       => 'group',
        'label'      => __( 'Schema', '__x__' ),
        'conditions' => $conditions_rating_schema,
        'controls'   => array(
          $control_rating_schema_item_reviewed_type,
          $control_rating_schema_item_name_content,
          $control_rating_schema_item_telephone_content,
          $control_rating_schema_item_address_content,
          $control_rating_schema_item_image_src,
          $control_rating_schema_author_content,
          $control_rating_schema_review_body_content,
        ),
      ),
    ),
    'controls_std_design_setup' => array_merge(
      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'conditions' => $conditions,
          'controls'   => array(
            $control_rating_base_font_size,
            $control_rating_width_and_max_width,
          ),
        ),
      ),
      x_control_margin( $settings_rating_design )
    ),
    'controls_std_design_colors' => array(
      array(
        'type'       => 'group',
        'label'      => __( 'Base Colors', '__x__' ),
        'conditions' => $conditions,
        'controls'   => array(
          $control_rating_graphic_icon_color,
          array(
            'keys'       => array( 'value' => $k_pre . 'rating_text_color' ),
            'type'       => 'color',
            'label'      => __( 'Text', '__x__' ),
            'conditions' => $conditions_rating_text,
          ),
          array(
            'keys'       => array( 'value' => $k_pre . 'rating_text_shadow_color' ),
            'type'       => 'color',
            'label'      => __( 'Text<br>Shadow', '__x__' ),
            'conditions' => array(
              $condition_rating_text,
              array( 'key' => $k_pre . 'rating_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
          ),
          array(
            'keys'       => array( 'value' => $k_pre . 'rating_border_color' ),
            'type'       => 'color',
            'label'      => __( 'Border', '__x__' ),
            'conditions' => array(
              array( 'key' => $k_pre . 'rating_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => $k_pre . 'rating_border_style', 'op' => '!=', 'value' => 'none' ),
            ),
          ),
          array(
            'keys'      => array( 'value' => $k_pre . 'rating_box_shadow_color' ),
            'type'      => 'color',
            'label'     => __( 'Box<br>Shadow', '__x__' ),
            'condition' => array( 'key' => $k_pre . 'rating_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
          ),
          $control_rating_bg_color,
        ),
      ),
    ),
    'control_nav' => array(
      $group                => $group_title,
      $group_rating_setup   => __( 'Setup', '__x__' ) ,
      $group_rating_content => __( 'Content', '__x__' ) ,
      $group_rating_schema  => __( 'Schema', '__x__' ) ,
      $group_rating_graphic => __( 'Graphic', '__x__' ) ,
      $group_rating_design  => __( 'Design', '__x__' ),
      $group_rating_text    => __( 'Text', '__x__' ),
    )
  );
}

cs_register_control_partial( 'rating', 'x_control_partial_rating' );
