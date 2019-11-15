<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/ANCHOR.PHP
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

function x_control_partial_anchor( $settings ) {

  // Setup
  // -----

  // 01. Available types:
  //     -- 'button'
  //     -- 'menu-item'
  //     -- 'toggle'

  $label_prefix            = ( isset( $settings['label_prefix'] )            ) ? $settings['label_prefix']            : '';
  $label_prefix_std        = ( isset( $settings['label_prefix_std'] )        ) ? $settings['label_prefix_std']        : $label_prefix;
  $k_pre                   = ( isset( $settings['k_pre'] )                   ) ? $settings['k_pre'] . '_'             : '';
  $group                   = ( isset( $settings['group'] )                   ) ? $settings['group']                   : 'anchor';
  $group_title             = ( isset( $settings['group_title'] )             ) ? $settings['group_title']             : __( 'Menu Item', '__x__' );
  $conditions              = ( isset( $settings['conditions'] )              ) ? $settings['conditions']              : array();
  $type                    = ( isset( $settings['type'] )                    ) ? $settings['type']                    : 'menu-item'; // 01
  $lr_only                 = ( isset( $settings['lr_only'] )                 ) ? $settings['lr_only']                 : false;
  $tb_only                 = ( isset( $settings['tb_only'] )                 ) ? $settings['tb_only']                 : false;
  $tbf_only                = ( isset( $settings['tbf_only'] )                ) ? $settings['tbf_only']                : false;
  $ctbf_only               = ( isset( $settings['ctbf_only'] )               ) ? $settings['ctbf_only']               : false;
  $has_template            = ( isset( $settings['has_template'] )            ) ? $settings['has_template']            : true;
  $has_link_control        = ( isset( $settings['has_link_control'] )        ) ? $settings['has_link_control']        : false;
  $has_share_control       = ( isset( $settings['has_share_control'] )       ) ? $settings['has_share_control']       : false;
  $has_interactive_content = ( isset( $settings['has_interactive_content'] ) ) ? $settings['has_interactive_content'] : false;



  // Groups
  // ------

  $group_anchor_customize           = $group . ':customize';
  $group_anchor_design              = $group . ':design';
  $group_anchor_graphic             = $group . ':graphic';
  $group_anchor_particles           = $group . ':particles';
  $group_anchor_setup               = $group . ':setup';
  $group_anchor_sub_indicator       = $group . ':sub_indicator';
  $group_anchor_text                = $group . ':text';
  $group_anchor_interactive_content = $group . ':interactive_content';



  // Conditions
  // ----------

  $lr_only   = ( $lr_only )   ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'left', 'right' ) )                      : array();
  $tb_only   = ( $tb_only )   ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'top', 'bottom' ) )                      : array();
  $tbf_only  = ( $tbf_only )  ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'top', 'bottom', 'footer' ) )            : array();
  $ctbf_only = ( $ctbf_only ) ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'content', 'top', 'bottom', 'footer' ) ) : array();

  $conditions_anchor_text                                = array_merge( $conditions, array( $lr_only, $tb_only, $tbf_only, $ctbf_only, array( $k_pre . 'anchor_text' => true ) ) );

  $conditions_anchor_sub_indicator                       = array_merge( $conditions, array( $lr_only, $tb_only, $tbf_only, $ctbf_only, array( $k_pre . 'anchor_sub_indicator' => true ) ) );
  $conditions_anchor_interactive_content                 = array_merge( $conditions, array( $lr_only, $tb_only, $tbf_only, $ctbf_only, array( $k_pre . 'anchor_interactive_content' => true ) ) );
  $conditions_anchor_interactive_content                 = array_merge( $conditions, array( $lr_only, $tb_only, $tbf_only, $ctbf_only, array( $k_pre . 'anchor_interactive_content' => true ) ) );
  $conditions_anchor_interactive_content_icons           = array_merge( $conditions, array( $lr_only, $tb_only, $tbf_only, $ctbf_only, array( $k_pre . 'anchor_interactive_content' => true ), array( $k_pre . 'anchor_graphic' => true ), array( $k_pre . 'anchor_graphic_type' => 'icon' ) ) );
  $conditions_anchor_interactive_content_secondary_icon  = array_merge( $conditions, array( $lr_only, $tb_only, $tbf_only, $ctbf_only, array( $k_pre . 'anchor_interactive_content' => true ), array( $k_pre . 'anchor_graphic' => true ), array( $k_pre . 'anchor_graphic_type' => 'icon' ), array( $k_pre . 'anchor_graphic_icon_alt_enable' => true ) ) );
  $conditions_anchor_interactive_content_images          = array_merge( $conditions, array( $lr_only, $tb_only, $tbf_only, $ctbf_only, array( $k_pre . 'anchor_interactive_content' => true ), array( $k_pre . 'anchor_graphic' => true ), array( $k_pre . 'anchor_graphic_type' => 'image' ) ) );
  $conditions_anchor_interactive_content_secondary_image = array_merge( $conditions, array( $lr_only, $tb_only, $tbf_only, $ctbf_only, array( $k_pre . 'anchor_interactive_content' => true ), array( $k_pre . 'anchor_graphic' => true ), array( $k_pre . 'anchor_graphic_type' => 'image' ), array( $k_pre . 'anchor_graphic_image_alt_enable' => true ) ) );
  $conditions_anchor_std_design_border                   = array_merge( $conditions, array( array( 'key' => $k_pre . 'anchor_border_width', 'op' => 'NOT EMPTY' ), array( 'key' => $k_pre . 'anchor_border_style', 'op' => '!=', 'value' => 'none' ) ) );
  $conditions                                            = array_merge( $conditions, array( $lr_only, $tb_only, $tbf_only, $ctbf_only ) );


  if ($has_interactive_content) {
    $conditions_anchor_primary_text    = array_merge( $conditions, array( $lr_only, $tb_only, $tbf_only, $ctbf_only, array( $k_pre . 'anchor_text' => true ), array( 'key' => $k_pre . 'anchor_text_primary_content', 'op' => 'NOT IN', 'value' => array( '' ) ), array( 'key' => $k_pre . 'anchor_interactive_content_text_primary_content', 'op' => 'NOT IN', 'value' => array( '' ), 'or' => true ) ) );
    $conditions_anchor_secondary_text  = array_merge( $conditions, array( $lr_only, $tb_only, $tbf_only, $ctbf_only, array( $k_pre . 'anchor_text' => true ), array( 'key' => $k_pre . 'anchor_text_secondary_content', 'op' => 'NOT IN', 'value' => array( '' ) ), array( 'key' => $k_pre . 'anchor_interactive_content_text_secondary_content', 'op' => 'NOT IN', 'value' => array( '' ), 'or' => true ) ) );
  } else {
    $conditions_anchor_primary_text    = array_merge( $conditions, array( $lr_only, $tb_only, $tbf_only, $ctbf_only, array( $k_pre . 'anchor_text' => true ), array( 'key' => $k_pre . 'anchor_text_primary_content', 'op' => 'NOT IN', 'value' => array( '' ) ) ) );
    $conditions_anchor_secondary_text  = array_merge( $conditions, array( $lr_only, $tb_only, $tbf_only, $ctbf_only, array( $k_pre . 'anchor_text' => true ), array( 'key' => $k_pre . 'anchor_text_secondary_content', 'op' => 'NOT IN', 'value' => array( '' ) ) ) );
  }

  // Options
  // -------

  $options_anchor_text_content = array(
    'placeholder' => __( 'No Output If Empty', '__x__' )
  );

  $options_anchor_text_spacing = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'fallback_value'  => '5px',
  );

  $options_anchor_interactions = array(
    'choices' => array(
      array( 'value' => 'none',                  'label' => __( 'None', '__x__' )         ),
      array( 'value' => 'x-anchor-slide-top',    'label' => __( 'Slide Top', '__x__' )    ),
      array( 'value' => 'x-anchor-slide-left',   'label' => __( 'Slide Left', '__x__' )   ),
      array( 'value' => 'x-anchor-slide-right',  'label' => __( 'Slide Right', '__x__' )  ),
      array( 'value' => 'x-anchor-slide-bottom', 'label' => __( 'Slide Bottom', '__x__' ) ),
      array( 'value' => 'x-anchor-scale-up',     'label' => __( 'Scale Up', '__x__' )     ),
      array( 'value' => 'x-anchor-scale-down',   'label' => __( 'Scale Down', '__x__' )   ),
      array( 'value' => 'x-anchor-flip-x',       'label' => __( 'Flip X', '__x__' )       ),
      array( 'value' => 'x-anchor-flip-y',       'label' => __( 'Flip Y', '__x__' )       ),
    ),
  );

  $options_anchor_base_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
      'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
      'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
    ),
  );

  $options_anchor_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
    'fallback_value'  => 'auto',
    'valid_keywords'  => array( 'auto', 'calc' ),
    'ranges'          => array(
      'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
      'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
      'vw'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
      'vh'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    ),
  );

  $options_anchor_min_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
    'fallback_value'  => '0px',
    'valid_keywords'  => array( 'calc' ),
    'ranges'          => array(
      'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
      'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
      'vw'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
      'vh'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    ),
  );

  $options_anchor_max_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
    'fallback_value'  => 'none',
    'valid_keywords'  => array( 'none', 'calc' ),
    'ranges'          => array(
      'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
      'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
      '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
      'vw'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
      'vh'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    ),
  );

  $options_anchor_interactive_content_interactions = array(
    'choices' => array(
      array( 'value' => 'x-anchor-content-out-slide-top-in-scale-up',    'label' => __( 'Slide Top / Scale Up', '__x__' )    ),
      array( 'value' => 'x-anchor-content-out-slide-left-in-scale-up',   'label' => __( 'Slide Left / Scale Up', '__x__' )   ),
      array( 'value' => 'x-anchor-content-out-slide-right-in-scale-up',  'label' => __( 'Slide Right / Scale Up', '__x__' )  ),
      array( 'value' => 'x-anchor-content-out-slide-bottom-in-scale-up', 'label' => __( 'Slide Bottom / Scale Up', '__x__' ) ),
    ),
  );

  $options_anchor_sub_indicator_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'fallback_value'  => '1em',
  );

  $options_anchor_sub_indicator_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'fallback_value'  => '1em',
    'valid_keywords'  => array( 'auto' ),
  );



  // Settings
  // --------

  $settings_anchor_design = array(
    'label_prefix' => $label_prefix,
    'group'        => $group_anchor_design,
    'conditions'   => $conditions,
    'alt_color'    => true,
    'options'      => cs_recall( 'options_color_base_interaction_labels' ),
  );

  $settings_anchor_primary_text = array(
    'label_prefix' => sprintf( __( '%s Primary', '__x__' ), $label_prefix ),
    'group'     => $group_anchor_text,
    'conditions' => $conditions_anchor_text,
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_base_interaction_labels' ),
  );

  $settings_anchor_secondary_text = array(
    'label_prefix' => sprintf( __( '%s Secondary', '__x__' ), $label_prefix ),
    'group'     => $group_anchor_text,
    'conditions' => $conditions_anchor_secondary_text,
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_base_interaction_labels' ),
  );


  // Individual Controls - Setup
  // ---------------------------

  $control_anchor_base_font_size = array(
    'key'     => $k_pre . 'anchor_base_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => $options_anchor_base_font_size,
  );

  $control_anchor_width = array(
    'key'     => $k_pre . 'anchor_width',
    'type'    => 'unit',
    'label'   => __( 'Width', '__x__' ),
    'options' => $options_anchor_width_and_height,
  );

  $control_anchor_height = array(
    'key'     => $k_pre . 'anchor_height',
    'type'    => 'unit',
    'label'   => __( 'Height', '__x__' ),
    'options' => $options_anchor_width_and_height,
  );

  $control_anchor_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Height', '__x__' ),
    'controls' => array(
      $control_anchor_width,
      $control_anchor_height,
    ),
  );

  $control_anchor_min_width = array(
    'key'     => $k_pre . 'anchor_min_width',
    'type'    => 'unit',
    'label'   => __( 'Min Width', '__x__' ),
    'options' => $options_anchor_min_width_and_height,
  );

  $control_anchor_min_height = array(
    'key'     => $k_pre . 'anchor_min_height',
    'type'    => 'unit',
    'label'   => __( 'Min Height', '__x__' ),
    'options' => $options_anchor_min_width_and_height,
  );

  $control_anchor_min_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Min Width &amp; Height', '__x__' ),
    'controls' => array(
      $control_anchor_min_width,
      $control_anchor_min_height,
    ),
  );

  $control_anchor_max_width = array(
    'key'     => $k_pre . 'anchor_max_width',
    'type'    => 'unit',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => $options_anchor_max_width_and_height,
  );

  $control_anchor_max_height = array(
    'key'     => $k_pre . 'anchor_max_height',
    'type'    => 'unit',
    'label'   => __( 'Max Height', '__x__' ),
    'options' => $options_anchor_max_width_and_height,
  );

  $control_anchor_max_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Max Width &amp; Height', '__x__' ),
    'controls' => array(
      $control_anchor_max_width,
      $control_anchor_max_height,
    ),
  );

  $control_anchor_bg_colors = array(
    'keys' => array(
      'value' => $k_pre . 'anchor_bg_color',
      'alt'   => $k_pre . 'anchor_bg_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' ),
    'options' => cs_recall( 'options_base_interaction_labels' ),
  );

  $control_anchor_link = array(
    'keys' => array(
      'url'           => $k_pre . 'anchor_href',
      'has_info' => $k_pre . 'anchor_info',
      'new_tab' => $k_pre . 'anchor_blank',
      'nofollow' => $k_pre . 'anchor_nofollow'
    ),
    'type'       => 'link',
    'label'      => __( '{{prefix}} Link', '__x__' ),
    'label_vars' => array( 'prefix' => $label_prefix ),
    'group'      => $group_anchor_setup,
    'conditions' => $conditions,
  );

  $control_anchor_share = array(
    'keys' => array(
      'url'           => $k_pre . 'anchor_href',
      'share_enabled' => $k_pre . 'anchor_share_enabled',
      'share_type'    => $k_pre . 'anchor_share_type',
      'share_title'   => $k_pre . 'anchor_share_title',
      'has_info' => $k_pre . 'anchor_info',
      'new_tab' => $k_pre . 'anchor_blank',
      'nofollow' => $k_pre . 'anchor_nofollow'
    ),
    'type'       => 'share',
    'label'      => __( '{{prefix}} Behavior', '__x__' ),
    'label_vars' => array( 'prefix' => $label_prefix ),
    'group'      => $group_anchor_setup,
    'conditions' => $conditions,
  );


  // Controls - Text
  // ---------------

  $control_anchor_text = array(
    'key'     => $k_pre . 'anchor_text',
    'type'    => 'choose',
    'label'   => __( 'Enable', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_anchor_text_content_local_primary = array(
    'key'        => $k_pre . 'anchor_text_primary_content',
    'type'       => 'text',
    'label'      => __( 'Primary Text', '__x__' ),
    'conditions' => $conditions_anchor_text,
    'options'    => $options_anchor_text_content,
  );

  $control_anchor_text_content_local_secondary = array(
    'key'        => $k_pre . 'anchor_text_secondary_content',
    'type'       => 'text',
    'label'      => __( 'Secondary Text', '__x__' ),
    'conditions' => $conditions_anchor_text,
    'options'    => $options_anchor_text_content,
  );

  $control_anchor_text_content_sourced_primary = array(
    'key'        => $k_pre . 'anchor_text_primary_content',
    'type'       => 'choose',
    'label'      => __( 'Primary Text', '__x__' ),
    'conditions' => $conditions_anchor_text,
    'options'    => cs_recall('options_choices_off_on_string'),
  );

  $control_anchor_text_content_sourced_secondary = array(
    'key'        => $k_pre . 'anchor_text_secondary_content',
    'type'       => 'choose',
    'label'      => __( 'Secondary Text', '__x__' ),
    'conditions' => $conditions_anchor_text,
    'options'    => cs_recall('options_choices_off_on_string'),
  );

  $control_anchor_text_content_spacing_and_order = array(
    'type'       => 'group',
    'label'      => __( 'Spacing &amp; Order', '__x__' ),
    'conditions' => $conditions_anchor_secondary_text,
    'controls'   => array(
      array(
        'key'     => $k_pre . 'anchor_text_spacing',
        'type'    => 'unit',
        'label'   => __( 'Spacing', '__x__' ),
        'options' => $options_anchor_text_spacing,
      ),
      array(
        'keys' => array(
          'text_reverse' => $k_pre . 'anchor_text_reverse',
        ),
        'type'    => 'checkbox-list',
        'label'   => __( 'Order', '__x__' ),
        'options' => array(
          'list' => array(
            array( 'key' => 'text_reverse', 'label' => __( 'Reverse', '__x__' ) ),
          ),
        ),
      ),
    ),
  );

  $control_anchor_text_interaction = array(
    'key'     => $k_pre . 'anchor_text_interaction',
    'type'    => 'select',
    'options' => $options_anchor_interactions,
  );

  $control_anchor_text_overflow = array(
    'keys' => array(
      'text_overflow' => $k_pre . 'anchor_text_overflow',
    ),
    'type'    => 'checkbox-list',
    'options' => array(
      'list' => array(
        array( 'key' => 'text_overflow', 'label' => __( 'Hidden', '__x__' ) ),
      ),
    ),
  );

  $control_anchor_text_content_interaction_and_overflow = array(
    'type'       => 'group',
    'label'      => __( 'Interaction &amp; Overflow', '__x__' ),
    'conditions' => $conditions_anchor_text,
    'controls'   => array(
      $control_anchor_text_interaction,
      $control_anchor_text_overflow,
    ),
  );


  // Controls - Interactive Content
  // ------------------------------

  $control_anchor_interactive_content = array(
    'key'     => $k_pre . 'anchor_interactive_content',
    'type'    => 'choose',
    'label'   => __( 'Enable', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_anchor_interactive_content_text_primary_content = array(
    'key'        => $k_pre . 'anchor_interactive_content_text_primary_content',
    'type'       => 'text',
    'label'      => __( 'Primary Text', '__x__' ),
    'conditions' => $conditions_anchor_interactive_content,
    'options'    => $options_anchor_text_content,
  );

  $control_anchor_interactive_content_text_secondary_content = array(
    'key'        => $k_pre . 'anchor_interactive_content_text_secondary_content',
    'type'       => 'text',
    'label'      => __( 'Secondary Text', '__x__' ),
    'conditions' => $conditions_anchor_interactive_content,
    'options'    => $options_anchor_text_content,
  );

  $control_anchor_interactive_content_interaction = array(
    'key'        => $k_pre . 'anchor_interactive_content_interaction',
    'type'       => 'select',
    'label'      => __( 'Interaction', '__x__' ),
    'conditions' => $conditions_anchor_interactive_content,
    'options'    => $options_anchor_interactive_content_interactions,
  );


  // Controls - Interactive Content (Graphic Icon)
  // ---------------------------------------------

  $control_anchor_interactive_content_graphic_icon = array(
    'key'        => $k_pre . 'anchor_interactive_content_graphic_icon',
    'type'       => 'icon',
    'group'      => $group,
    'label'      => __( 'Primary Icon', '__x__' ),
    'conditions' => $conditions_anchor_interactive_content_icons,
  );

  $control_anchor_interactive_content_graphic_icon_alt = array(
    'key'        => $k_pre . 'anchor_interactive_content_graphic_icon_alt',
    'type'       => 'icon',
    'group'      => $group,
    'label'      => __( 'Secondary Icon', '__x__' ),
    'conditions' => $conditions_anchor_interactive_content_secondary_icon,
  );

  $control_anchor_interactive_content_graphic_icons = array(
    'type'       => 'group',
    'label'      => __( 'Primary &amp; Secondary', '__x__' ),
    'group'      => $group,
    'conditions' => $conditions_anchor_interactive_content_icons,
    'controls'   => array(
      array_merge( $control_anchor_interactive_content_graphic_icon,     array( 'options' => array( 'label' => __( 'Select', '__x__' ) ) ) ),
      array_merge( $control_anchor_interactive_content_graphic_icon_alt, array( 'options' => array( 'label' => __( 'Select', '__x__' ) ) ) ),
    ),
  );


  // Controls - Interactive Content (Graphic Image)
  // ----------------------------------------------

  $control_anchor_interactive_content_graphic_image = array(
    'key'     => $k_pre . 'anchor_interactive_content_graphic_image_src',
    'type'    => 'image-source',
    'label'   => __( 'Source', '__x__' ),
    'options' => array(
      'height' => 4,
    ),
  );

  $control_anchor_interactive_content_graphic_image_alt_text = array(
    'key'     => $k_pre . 'anchor_interactive_content_graphic_image_alt',
    'type'    => 'text',
    'label'   => __( 'Alt Text', '__x__' ),
    'options' => array(
      'placeholder' => __( 'Describe Your Image', '__x__' ),
    ),
  );

  $control_anchor_interactive_content_graphic_image_alt = array(
    'key'     => $k_pre . 'anchor_interactive_content_graphic_image_src_alt',
    'type'    => 'image-source',
    'label'   => __( 'Source', '__x__' ),
    'options' => array(
      'height' => 4,
    ),
  );

  $control_anchor_interactive_content_graphic_image_alt_text_alt = array(
    'key'     => $k_pre . 'anchor_interactive_content_graphic_image_alt_alt',
    'type'    => 'text',
    'label'   => __( 'Alt Text', '__x__' ),
    'options' => array(
      'placeholder' => __( 'Describe Your Image', '__x__' ),
    ),
  );


  // Controls - Sub Indicator
  // ------------------------

  $control_anchor_sub_indicator = array(
    'key'     => $k_pre . 'anchor_sub_indicator',
    'type'    => 'choose',
    'label'   => __( 'Enable', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_anchor_sub_indicator_font_size = array(
    'key'        => $k_pre . 'anchor_sub_indicator_font_size',
    'type'       => 'unit-slider',
    'label'      => __( 'Font Size', '__x__' ),
    'conditions' => $conditions_anchor_sub_indicator,
    'options'    => $options_anchor_sub_indicator_font_size,
  );

  $control_anchor_sub_indicator_width = array(
    'key'     => $k_pre . 'anchor_sub_indicator_width',
    'type'    => 'unit',
    'options' => $options_anchor_sub_indicator_width_and_height,
  );

  $control_anchor_sub_indicator_height = array(
    'key'     => $k_pre . 'anchor_sub_indicator_height',
    'type'    => 'unit',
    'options' => $options_anchor_sub_indicator_width_and_height,
  );

  $control_anchor_sub_indicator_width_and_height = array(
    'type'       => 'group',
    'label'      => __( 'Width &amp; Height', '__x__' ),
    'conditions' => $conditions_anchor_sub_indicator,
    'controls'   => array(
      $control_anchor_sub_indicator_width,
      $control_anchor_sub_indicator_height,
    ),
  );

  $control_anchor_sub_indicator_icon = array(
    'key'        => $k_pre . 'anchor_sub_indicator_icon',
    'type'       => 'icon',
    'label'      => __( 'Icon', '__x__' ),
    'conditions' => $conditions_anchor_sub_indicator,
  );

  $control_anchor_sub_indicator_colors = array(
    'keys' => array(
      'value' => $k_pre . 'anchor_sub_indicator_color',
      'alt'   => $k_pre . 'anchor_sub_indicator_color_alt',
    ),
    'type'       => 'color',
    'label'      => __( 'Color', '__x__' ),
    'conditions' => $conditions_anchor_sub_indicator,
    'options'    => cs_recall( 'options_base_interaction_labels' ),
  );


  // Advanced Text Setup
  // -------------------

  $control_list_anchor_adv_text_setup = array();

  $control_list_anchor_adv_text_setup[] = $control_anchor_text;

  if ( $type !== 'menu-item' ) {

    $control_list_anchor_adv_text_setup[] = $control_anchor_text_content_local_primary;
    $control_list_anchor_adv_text_setup[] = $control_anchor_text_content_local_secondary;

  } else if ( $type === 'menu-item' ) {

    $control_list_anchor_adv_text_setup[] = $control_anchor_text_content_sourced_primary;
    $control_list_anchor_adv_text_setup[] = $control_anchor_text_content_sourced_secondary;

  }

  $control_list_anchor_adv_text_setup[] = $control_anchor_text_content_spacing_and_order;
  $control_list_anchor_adv_text_setup[] = $control_anchor_text_content_interaction_and_overflow;


  // Standard Content Setup
  // ----------------------

  $control_list_anchor_std_content_setup = array();

  if ( $type !== 'menu-item' ) {

    $control_list_anchor_std_content_setup[] = $control_anchor_text_content_local_primary;
    $control_list_anchor_std_content_setup[] = $control_anchor_text_content_local_secondary;

  } else if ( $type === 'menu-item' ) {

    $control_list_anchor_std_content_setup[] = $control_anchor_text_content_sourced_primary;
    $control_list_anchor_std_content_setup[] = $control_anchor_text_content_sourced_secondary;

  }


  // Standard Design Setup
  // ---------------------

  $control_list_anchor_std_design_setup = array(
    $control_anchor_base_font_size,
    $control_anchor_width_and_height,
    $control_anchor_max_width_and_height,
    array(
      'key'        => $k_pre . 'anchor_primary_text_align',
      'type'       => 'text-align',
      'label'      => __( 'Primary Text Align', '__x__' ),
      'conditions' => $conditions_anchor_primary_text,
    ),
  );

  if ( $has_template ) {
    $control_list_anchor_std_design_setup[] = array(
      'key'        => $k_pre . 'anchor_secondary_text_align',
      'type'       => 'text-align',
      'label'      => __( 'Secondary Text Align', '__x__' ),
      'conditions' => $conditions_anchor_secondary_text,
    );
  }



  // Control Groups (Advanced)
  // =============================================================================

  $control_group_anchor_adv_setup = array(
    array(
      'type'       => 'group',
      'label'      => __( '{{prefix}} Setup', '__x__' ),
      'label_vars' => array( 'prefix' => $label_prefix ),
      'group'      => $group_anchor_setup,
      'conditions' => $conditions,
      'controls'   => array(
        $control_anchor_base_font_size,
        $control_anchor_width_and_height,
        $control_anchor_min_width_and_height,
        $control_anchor_max_width_and_height,
        $control_anchor_bg_colors,
      ),
    ),
  );

  $control_group_anchor_adv_text_setup = array(
    array(
      'type'       => 'group',
      'label'      => __( '{{prefix}} Text Setup', '__x__' ),
      'label_vars' => array( 'prefix' => $label_prefix ),
      'group'      => $group_anchor_text,
      'conditions' => $conditions,
      'controls'   => $control_list_anchor_adv_text_setup,
    ),
  );

  $control_group_anchor_adv_interactive_content_setup = array(
    array(
      'type'       => 'group',
      'label'      => __( '{{prefix}} Interactive Content Setup', '__x__' ),
      'label_vars' => array( 'prefix' => $label_prefix ),
      'group'      => $group_anchor_interactive_content,
      'conditions' => $conditions,
      'controls'   => array(
        $control_anchor_interactive_content,
        $control_anchor_interactive_content_text_primary_content,
        $control_anchor_interactive_content_text_secondary_content,
        $control_anchor_interactive_content_graphic_icons,
        $control_anchor_interactive_content_interaction,
      ),
    ),
    array(
      'type'       => 'group',
      'label'      => __( '{{prefix}} Interactive Primary Graphic Image', '__x__' ),
      'label_vars' => array( 'prefix' => $label_prefix ),
      'group'      => $group_anchor_interactive_content,
      'conditions' => $conditions_anchor_interactive_content_images,
      'controls'   => array(
        $control_anchor_interactive_content_graphic_image,
        $control_anchor_interactive_content_graphic_image_alt_text,
      ),
    ),
    array(
      'type'       => 'group',
      'label'      => __( '{{prefix}} Interactive Secondary Graphic Image', '__x__' ),
      'label_vars' => array( 'prefix' => $label_prefix ),
      'group'      => $group_anchor_interactive_content,
      'conditions' => $conditions_anchor_interactive_content_secondary_image,
      'controls'   => array(
        $control_anchor_interactive_content_graphic_image_alt,
        $control_anchor_interactive_content_graphic_image_alt_text_alt,
      ),
    ),
  );

  $control_group_anchor_adv_sub_indicator_setup = array(
    'type'     => 'group',
    'label'      => __( '{{prefix}} Sub Indicator Setup', '__x__' ),
    'label_vars' => array( 'prefix' => $label_prefix ),
    'group'    => $group_anchor_sub_indicator,
    'controls' => array(
      $control_anchor_sub_indicator,
      $control_anchor_sub_indicator_font_size,
      $control_anchor_sub_indicator_width_and_height,
      $control_anchor_sub_indicator_icon,
      $control_anchor_sub_indicator_colors,
    ),
  );



  // Conditional Secondary Text
  // --------------------------
  // Based on whether or not a template is used for the anchor.

  $control_group_anchor_std_design_colors_secondary_text = array();

  if ( $has_template ) {

    $control_group_anchor_std_design_colors_secondary_text = array(
      array(
        'type'       => 'group',
        'label'      => __( '{{prefix}} Secondary Text Colors', '__x__' ),
        'label_vars' => array( 'prefix' => $label_prefix_std ),
        'conditions' => $conditions_anchor_secondary_text,
        'controls'   => array(
          array(
            'keys' => array(
              'value' => $k_pre . 'anchor_secondary_text_color',
              'alt'   => $k_pre . 'anchor_secondary_text_color_alt',
            ),
            'type'    => 'color',
            'label'   => __( 'Text', '__x__' ),
            'options' => cs_recall( 'options_base_interaction_labels' ),
          ),
          array(
            'keys' => array(
              'value' => $k_pre . 'anchor_secondary_text_shadow_color',
              'alt'   => $k_pre . 'anchor_secondary_text_shadow_color_alt',
            ),
            'type'      => 'color',
            'label'     => __( 'Text Shadow', '__x__' ),
            'options'   => cs_recall( 'options_base_interaction_labels' ),
            'condition' => array( 'key' => $k_pre . 'anchor_secondary_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
          ),
        ),
      ),
    );

  }

  // Control Groups
  // --------------

  $control_nav = array(
    $group                            => $group_title,
    $group_anchor_setup               => __( 'Setup', '__x__' ),
    $group_anchor_design              => __( 'Design', '__x__' ),
    $group_anchor_text                => __( 'Text', '__x__' ),
    $group_anchor_graphic             => __( 'Graphic', '__x__' ),
    $group_anchor_interactive_content => __( 'Interactive Content', '__x__' ),
    $group_anchor_sub_indicator       => __( 'Sub Indicator', '__x__' ),
    $group_anchor_particles           => __( 'Particles', '__x__' ),
  );

  if ( ! $has_template ) {
    unset( $control_nav[$group_anchor_setup] );
    unset( $control_nav[$group_anchor_graphic] );
  }

  if ( ! $has_interactive_content ) {
    unset( $control_nav[$group_anchor_interactive_content] );
  }

  if ( $type !== 'menu-item' ) {
    unset( $control_nav[$group_anchor_sub_indicator] );
  }

  // Compose Controls
  // ----------------

  $controls_std_content = array();

  if ( $has_link_control ) {
    $controls_std_content[] = array_merge(
      $control_anchor_link,
      array( 'label_vars' => array( 'prefix' => $label_prefix_std ) )
    );
  }

  if ( $has_share_control ) {
    $controls_std_content[] = array_merge(
      $control_anchor_share,
      array( 'label_vars' => array( 'prefix' => $label_prefix_std ) )
    );
  }

  if ( $has_template ) {
    $controls_std_content[] = array(
      'type'       => 'group',
      'label'      => __( '{{prefix}} Content', '__x__' ),
      'label_vars' => array( 'prefix' => $label_prefix_std ),
      'conditions' => $conditions_anchor_text,
      'controls'   => $control_list_anchor_std_content_setup,
    );
  }

  $before_graphic_adv = $control_group_anchor_adv_setup;

  if ( $has_link_control ) {
    $before_graphic_adv[] = $control_anchor_link;
  }

  if ( $has_share_control ) {
    $before_graphic_adv[] = $control_anchor_share;
  }


  // Design
  // ------

  if ( $has_template ) {
    $before_graphic_adv[] = cs_control( 'flexbox', $k_pre . 'anchor', array(
      'label_prefix' => sprintf( __( '%s Content', '__x__' ), $label_prefix ),
      'group'        => $group_anchor_design,
      'conditions'   => $conditions,
      'no_self'      => true
    ) );
  }

  $before_graphic_adv = array_merge(
    $before_graphic_adv,
    array(
      cs_control( 'margin', $k_pre . 'anchor', array(
        'label_prefix' => $label_prefix,
        'group'        => $group_anchor_design,
        'conditions'   => $conditions,
      ) ),
      cs_control( 'padding', $k_pre . 'anchor', $settings_anchor_design ),
      cs_control( 'border', $k_pre . 'anchor', $settings_anchor_design ),
      cs_control( 'border-radius', $k_pre . 'anchor', $settings_anchor_design ),
      cs_control( 'box-shadow', $k_pre . 'anchor', $settings_anchor_design )
    )
  );


  // Text
  // ----

  if ( $has_template ) {
    $before_graphic_adv = array_merge(
      $before_graphic_adv,
      $control_group_anchor_adv_text_setup
    );
  }

  $before_graphic_adv = array_merge(
    $before_graphic_adv,
    array(
      cs_control( 'margin', $k_pre . 'anchor_text', array(
        'label_prefix' => sprintf( __( '%s Text', '__x__' ), $label_prefix ),
        'group'     => $group_anchor_text,
        'conditions' => $conditions_anchor_text,
      ) ),
      cs_control( 'text-format', $k_pre . 'anchor_primary', $settings_anchor_primary_text ),
      cs_control( 'text-shadow', $k_pre . 'anchor_primary', $settings_anchor_primary_text )
    )
  );

  if ( $has_template ) {
    $before_graphic_adv = array_merge(
      $before_graphic_adv,
      array(
        cs_control( 'text-format', $k_pre . 'anchor_secondary', $settings_anchor_secondary_text ),
        cs_control( 'text-shadow', $k_pre . 'anchor_secondary', $settings_anchor_secondary_text )
      )
    );
  }

  $before_graphic = array(
    'controls' => $before_graphic_adv,
    'controls_std_content' => $controls_std_content,
    'controls_std_design_setup' => array(
      array(
        'type'     => 'group',
        'label'      => __( '{{prefix}} Design Setup', '__x__' ),
        'label_vars' => array( 'prefix' => $label_prefix_std ),
        'controls' => $control_list_anchor_std_design_setup,
      ),
      cs_control( 'margin', $k_pre . 'anchor', array(
        'label_prefix' => $label_prefix_std,
        'conditions' => $conditions,
      ) )
    ),
    'controls_std_design_colors' => array_merge(
      array(
        array(
          'type'     => 'group',
          'label'      => __( '{{prefix}} Base Colors', '__x__' ),
          'label_vars' => array( 'prefix' => $label_prefix_std ),
          'controls' => array(
            array(
              'keys' => array(
                'value' => $k_pre . 'anchor_primary_text_color',
                'alt'   => $k_pre . 'anchor_primary_text_color_alt',
              ),
              'type'       => 'color',
              'label'      => __( 'Text', '__x__' ),
              'options'    => cs_recall( 'options_base_interaction_labels' ),
              'conditions' => $conditions_anchor_text,
            ),
            array(
              'keys' => array(
                'value' => $k_pre . 'anchor_primary_text_shadow_color',
                'alt'   => $k_pre . 'anchor_primary_text_shadow_color_alt',
              ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'options'   => cs_recall( 'options_base_interaction_labels' ),
              'conditions' => array_merge( $conditions, array(
                array( 'key' => $k_pre . 'anchor_primary_text_shadow_dimensions', 'op' => 'NOT EMPTY' )
              ) ),
            ),
            array(
              'keys' => array(
                'value' => $k_pre . 'anchor_box_shadow_color',
                'alt'   => $k_pre . 'anchor_box_shadow_color_alt',
              ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'options'   => cs_recall( 'options_base_interaction_labels' ),
              'condition' => array( 'key' => $k_pre . 'anchor_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_anchor_bg_colors,
            array(
              'type'       => 'group',
              'label'      => __( 'Particles', '__x__' ),
              'conditions' => array( array( 'key' => $k_pre . 'anchor_primary_particle', 'value' => true ), array( 'key' => $k_pre . 'anchor_secondary_particle', 'value' => true, 'or' => true ) ),
              'controls'   => array(
                array(
                  'keys'      => array( 'value' => $k_pre . 'anchor_primary_particle_color' ),
                  'type'      => 'color',
                  'label'     => __( 'Primary', '__x__' ),
                  'options'   => array( 'label' => __( 'Primary', '__x__' ) ),
                  'condition' => array( $k_pre . 'anchor_primary_particle' => true ),
                ),
                array(
                  'keys'      => array( 'value' => $k_pre . 'anchor_secondary_particle_color' ),
                  'type'      => 'color',
                  'label'     => __( 'Secondary', '__x__' ),
                  'options'   => array( 'label' => __( 'Secondary', '__x__' ) ),
                  'condition' => array( $k_pre . 'anchor_secondary_particle' => true ),
                ),
              ),
            ),
          ),
        ),
        cs_control( 'border', $k_pre . 'anchor', array(
          'label_prefix' => sprintf( __( '%sBase', '__x__' ), $label_prefix_std ),
          'conditions' => $conditions_anchor_std_design_border,
          'alt_color' => true,
          'options'   => cs_recall( 'options_color_base_interaction_labels_color_only' )
        ) ),
      ),
      $control_group_anchor_std_design_colors_secondary_text,
      array(
        array(
          'type'       => 'group',
          'label'      => __( '{{prefix}} Sub Indicator Colors', '__x__' ),
          'label_vars' => array( 'prefix' => $label_prefix_std ),
          'conditions' => $conditions_anchor_sub_indicator,
          'controls'   => array(
            array(
              'keys' => array(
                'value' => $k_pre . 'anchor_sub_indicator_color',
                'alt'   => $k_pre . 'anchor_sub_indicator_color_alt',
              ),
              'type'    => 'color',
              'label'   => __( 'Text', '__x__' ),
              'options' => cs_recall( 'options_base_interaction_labels' ),
            ),
            array(
              'keys' => array(
                'value' => $k_pre . 'anchor_sub_indicator_text_shadow_color',
                'alt'   => $k_pre . 'anchor_sub_indicator_text_shadow_color_alt',
              ),
              'type'      => 'color',
              'label'     => __( 'Text Shadow', '__x__' ),
              'options'   => cs_recall( 'options_base_interaction_labels' ),
              'condition' => array( 'key' => $k_pre . 'anchor_sub_indicator_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
          ),
        ),
      )
    ),
    'control_nav' => $control_nav
  );

  $compose_from = array( $before_graphic );

  if ( $has_template ) {

    $settings_anchor_graphic = array(
      'k_pre'               => $k_pre . 'anchor',
      'label_prefix_std'    => $label_prefix_std,
      'group'               => $group_anchor_graphic,
      'conditions'          => $conditions,
      'has_alt'             => true,
      'has_interactions'    => true,
      'has_sourced_content' => false,
      'has_toggle'          => false,
      'adv'                 => true,
    );

    if ( $type === 'menu-item' ) {
      $settings_anchor_graphic['has_sourced_content'] = true;
    }

    if ( $type === 'toggle' ) {
      $settings_anchor_graphic['has_toggle'] = true;
    }

    $compose_from[] = cs_partial_controls( 'graphic', $settings_anchor_graphic );
  }

  $after_graphic_adv = array();

  if ( $has_interactive_content ) {
    $after_graphic_adv = array_merge(
      $after_graphic_adv,
      $control_group_anchor_adv_interactive_content_setup
    );
  }


  // Sub Indicator
  // -------------

  if ( $has_template && $type === 'menu-item' ) {
    $after_graphic_adv[] = $control_group_anchor_adv_sub_indicator_setup;


    $after_graphic_adv[] = cs_control( 'margin', $k_pre . 'anchor_sub_indicator', array(
      'label_prefix' => sprintf( __( '%s Sub Indicator', '__x__' ), $label_prefix ),
      'group'     => $group_anchor_sub_indicator,
      'conditions' => $conditions_anchor_sub_indicator,
    ) );

    $after_graphic_adv[] = cs_control( 'text-shadow', $k_pre . 'anchor_sub_indicator', array(
      'label_prefix' => sprintf( __( '%s Sub Indicator', '__x__' ), $label_prefix ),
      'group'     => $group_anchor_sub_indicator,
      'conditions' => $conditions_anchor_sub_indicator,
      'alt_color' => true,
      'options'   => cs_recall( 'options_color_base_interaction_labels' ),
    ) );

  }

  if ( count( $after_graphic_adv ) > 0 ) {
    $compose_from[] = array(
      'controls' => $after_graphic_adv
    );
  }

  if ( $has_template ) {

    $compose_from[] = cs_partial_controls( 'particle', array(
      'label_prefix' => __( 'Primary', '__x__' ),
      'k_pre'     => $k_pre . 'anchor_primary',
      'group'     => $group_anchor_particles,
      'conditions' => $conditions,
    ) );

    $compose_from[] = cs_partial_controls( 'particle', array(
      'label_prefix' => __( 'Secondary', '__x__' ),
      'k_pre'     => $k_pre . 'anchor_secondary',
      'group'     => $group_anchor_particles,
      'conditions' => $conditions,
    ) );

  }


  return call_user_func_array( 'cs_compose_controls', $compose_from );
}

cs_register_control_partial( 'anchor', 'x_control_partial_anchor' );
