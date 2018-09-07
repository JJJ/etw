<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/_TEXT.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Shared
//   02. Setup
//   03. Groups
//   04. Conditions
//   05. Options
//   06. Settings
//   07. Individual Controls
//   08. Control Lists
//   09. Controls & Control Groups for Icons/Images
//   10. Control Groups (Advanced)
//   11. Control Groups (Standard)
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================

$t_pre               = ( isset( $settings['t_pre'] )               ) ? $settings['t_pre'] . ' '         : '';
$k_pre               = ( isset( $settings['k_pre'] )               ) ? $settings['k_pre'] . '_'         : '';
$group               = ( isset( $settings['group'] )               ) ? $settings['group']               : 'general';
$condition           = ( isset( $settings['condition'] )           ) ? $settings['condition']           : array();
$has_alt             = ( isset( $settings['has_alt'] )             ) ? $settings['has_alt']             : false;
$has_interactions    = ( isset( $settings['has_interactions'] )    ) ? $settings['has_interactions']    : false;
$has_sourced_content = ( isset( $settings['has_sourced_content'] ) ) ? $settings['has_sourced_content'] : false;
$has_toggle          = ( isset( $settings['has_toggle'] )          ) ? $settings['has_toggle']          : false;



// Groups
// =============================================================================
// Parent mixins will pass in group.



// Conditions
// =============================================================================

$conditions                   = x_module_conditions( $condition );
$conditions_graphic_main      = array_merge( $conditions, array( array( $k_pre . 'graphic' => true ) ) );
$conditions_graphic_icon      = array_merge( $conditions, array( array( $k_pre . 'graphic' => true ) ), array( array( $k_pre . 'graphic_type' => 'icon' ) ) );
$conditions_graphic_icon_alt  = array_merge( $conditions, array( array( $k_pre . 'graphic' => true ) ), array( array( $k_pre . 'graphic_type' => 'icon' ) ), array( array( $k_pre . 'graphic_icon_alt_enable' => 'icon' ) ) );
$conditions_graphic_image     = array_merge( $conditions, array( array( $k_pre . 'graphic' => true ) ), array( array( $k_pre . 'graphic_type' => 'image' ) ) );
$conditions_graphic_image_alt = array_merge( $conditions, array( array( $k_pre . 'graphic' => true ) ), array( array( $k_pre . 'graphic_type' => 'image' ) ), array( array( $k_pre . 'graphic_image_alt_enable' => true ) ) );
$conditions_graphic_toggle    = array_merge( $conditions, array( array( $k_pre . 'graphic' => true ) ), array( array( $k_pre . 'graphic_type' => 'toggle' ) ) );



// Options
// =============================================================================

$options_graphic_type_choices = array(
  array( 'value' => 'icon',  'icon' => 'flag' ),
  array( 'value' => 'image', 'icon' => 'image' ),
);

if ( $has_toggle ) {
  $options_graphic_type_choices[] = array( 'value' => 'toggle', 'icon' => 'bars' );
}

$options_graphic_interaction = array(
  'choices' => array(
    array( 'value' => 'none',                'label' => __( 'None', '__x__' )       ),
    array( 'value' => 'x-anchor-scale-up',   'label' => __( 'Scale Up', '__x__' )   ),
    array( 'value' => 'x-anchor-scale-down', 'label' => __( 'Scale Down', '__x__' ) ),
    array( 'value' => 'x-anchor-flip-x',     'label' => __( 'Flip X', '__x__' )     ),
    array( 'value' => 'x-anchor-flip-y',     'label' => __( 'Flip Y', '__x__' )     ),
  )
);

$options_graphic_icon_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'fallback_value'  => '1em',
);

$options_graphic_width_and_height = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'fallback_value'  => '1em',
);

$options_graphic_image_max_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
  'valid_keywords'  => array( 'none', 'calc' ),
  'fallback_value'  => 'none',
  'ranges'          => array(
    'px'  => array( 'min' => 20, 'max' => 40,  'step' => 1    ),
    'em'  => array( 'min' => 1,  'max' => 2.5, 'step' => 0.01 ),
    'rem' => array( 'min' => 1,  'max' => 2.5, 'step' => 0.01 ),
    '%'   => array( 'min' => 1,  'max' => 100, 'step' => 1    ),
    'vw'  => array( 'min' => 1,  'max' => 100, 'step' => 1    ),
    'vh'  => array( 'min' => 1,  'max' => 100, 'step' => 1    ),
  ),
);



// Settings
// =============================================================================

$settings_graphic_margin = array(
  'k_pre'     => $k_pre . 'graphic',
  't_pre'     => __( $t_pre . ' Graphic', '__x__' ),
  'group'     => $group,
  'condition' => $conditions_graphic_main,
);

$settings_graphic_icon_border_radius = array(
  'k_pre'     => $k_pre . 'graphic_icon',
  't_pre'     => __( $t_pre . ' Graphic Icon', '__x__' ),
  'group'     => $group,
  'condition' => $conditions_graphic_icon,
);

$settings_graphic_icon_variable_alt_color = array(
  'k_pre'     => $k_pre . 'graphic_icon',
  't_pre'     => __( $t_pre . ' Graphic Icon', '__x__' ),
  'group'     => $group,
  'condition' => $conditions_graphic_icon,
);

if ( ! $is_adv ) {
  $settings_graphic_icon_variable_alt_color['options'] = $options_color_only;
}

if ( $has_alt === true ) {
  $settings_graphic_icon_variable_alt_color['alt_color'] = true;
  if ( $is_adv ) {
    $settings_graphic_icon_variable_alt_color['options'] = $options_color_base_interaction_labels;
  } else {
    $settings_graphic_icon_variable_alt_color['options'] = $options_color_base_interaction_labels_color_only;
  }
}

$settings_graphic_toggle = array(
  't_pre'     => __( $t_pre . ' Graphic', '__x__' ),
  'group'     => $group,
  'condition' => $conditions_graphic_toggle,
);



// Individual Controls
// =============================================================================

$control_graphic = array(
  'key'     => $k_pre . 'graphic',
  'type'    => 'choose',
  'label'   => __( 'Enable', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_graphic_type = array(
  'key'        => $k_pre . 'graphic_type',
  'type'       => 'choose',
  'label'      => __( 'Type', '__x__' ),
  'conditions' => $conditions_graphic_main,
  'options'    => array(
    'choices'  => $options_graphic_type_choices,
  ),
);

$control_graphic_interaction = array(
  'key'        => $k_pre . 'graphic_interaction',
  'type'       => 'select',
  'label'      => __( 'Icon &amp; Img Interaction', '__x__' ),
  'conditions' => $conditions_graphic_main,
  'options'    => $options_graphic_interaction,
);

$control_graphic_icon_first_line = array(
  'key'     => $k_pre . 'graphic_icon_font_size',
  'type'    => 'unit',
  'label'   => __( 'Font Size', '__x__' ),
  'options' => $options_graphic_icon_font_size,
);

$control_graphic_icon_width_and_height = array(
  'type'     => 'group',
  'title'    => __( 'Width &amp; Height', '__x__' ),
  'controls' => array(
    array(
      'key'     => $k_pre . 'graphic_icon_width',
      'type'    => 'unit',
      'options' => $options_graphic_width_and_height,
    ),
    array(
      'key'     => $k_pre . 'graphic_icon_height',
      'type'    => 'unit',
      'options' => $options_graphic_width_and_height,
    ),
  ),
);

$control_graphic_icon_color = array(
  'keys'  => array( 'value' => $k_pre . 'graphic_icon_color' ),
  'type'  => 'color',
  'label' => __( 'Color', '__x__' ),
);

$control_graphic_icon_bg_color = array(
  'keys'  => array( 'value' => $k_pre . 'graphic_icon_bg_color' ),
  'type'  => 'color',
  'label' => __( 'Background', '__x__' ),
);

if ( $has_alt ) {

  $control_graphic_icon_first_line = array(
    'type'     => 'group',
    'title'    => __( 'Font Size &amp; Secondary', '__x__' ),
    'controls' => array(
      array(
        'key'     => $k_pre . 'graphic_icon_font_size',
        'type'    => 'unit',
        'options' => $options_graphic_icon_font_size,
      ),
      array(
        'keys' => array(
          'icon_alt_on' => $k_pre . 'graphic_icon_alt_enable',
        ),
        'type'    => 'checkbox-list',
        'options' => array(
          'list' => array(
            array( 'key' => 'icon_alt_on', 'label' => __( 'Secondary', '__x__' ) ),
          ),
        ),
      ),
    ),
  );

  $control_graphic_icon_color['keys']['alt'] = $k_pre . 'graphic_icon_color_alt';
  $control_graphic_icon_color['options']     = $options_base_interaction_labels;

  $control_graphic_icon_bg_color['keys']['alt'] = $k_pre . 'graphic_icon_bg_color_alt';
  $control_graphic_icon_bg_color['options']     = $options_base_interaction_labels;

}

$control_graphic_image_max_width = array(
  array(
    'key'     => $k_pre . 'graphic_image_max_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => $options_graphic_image_max_width,
  ),
);

$control_graphic_local_image_secondary_enable = array(
  'keys' => array(
    'image_alt_on' => $k_pre . 'graphic_image_alt_enable',
  ),
  'type'    => 'checkbox-list',
  'label'   => __( 'Enable', '__x__' ),
  'options' => array(
    'list' => array(
      array( 'key' => 'image_alt_on', 'label' => __( 'Secondary', '__x__' ) ),
    ),
  ),
);

$control_graphic_local_image_secondary = array(
  'key'        => $k_pre . 'graphic_image_src_alt',
  'type'       => 'image-source',
  'label'      => __( 'Source', '__x__' ),
  'conditions' => $conditions_graphic_image_alt,
  'options'    => array(
    'height' => $is_adv ? 4 : 5,
  ),
);

$control_graphic_std_icon_border_color = array(
  'keys'  => array( 'value' => $k_pre . 'graphic_icon_border_color' ),
  'type'  => 'color',
  'label' => __( 'Border', '__x__' ),
);

$control_graphic_std_icon_text_shadow_color = array(
  'keys'      => array( 'value' => $k_pre . 'graphic_icon_text_shadow_color' ),
  'type'      => 'color',
  'label'     => __( 'Text<br>Shadow', '__x__' ),
  'condition' => array( 'key' => $k_pre . 'graphic_icon_text_shadow_dimensions', 'op' => 'NOT EMPTY' )
);

$control_graphic_std_icon_box_shadow_color = array(
  'keys'      => array( 'value' => $k_pre . 'graphic_icon_box_shadow_color' ),
  'type'      => 'color',
  'label'     => __( 'Box<br>Shadow', '__x__' ),
  'condition' => array( 'key' => $k_pre . 'graphic_icon_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
);

if ( $has_alt ) {

  $control_graphic_std_icon_border_color['keys']['alt'] = $k_pre . 'graphic_icon_border_color_alt';
  $control_graphic_std_icon_border_color['options']     = $options_base_interaction_labels;

  $control_graphic_std_icon_text_shadow_color['keys']['alt'] = $k_pre . 'graphic_icon_text_shadow_color_alt';
  $control_graphic_std_icon_text_shadow_color['options']     = $options_base_interaction_labels;

  $control_graphic_std_icon_box_shadow_color['keys']['alt'] = $k_pre . 'graphic_icon_box_shadow_color_alt';
  $control_graphic_std_icon_box_shadow_color['options']     = $options_base_interaction_labels;

}



// Control Lists
// =============================================================================

$control_list_local_image_secondary = array();

if ( $is_adv ) {
  $control_list_local_image_secondary[] = $control_graphic_local_image_secondary_enable;
}

$control_list_local_image_secondary[] = $control_graphic_local_image_secondary;




// Controls & Control Groups for Icons/Images
// =============================================================================
// 01. Variable controls and groups that differ depending on various
//     conditions such as having sourced content, having secondary icons or
//     images, et cetera.
// 02. Content is provided from an external source, such as the WordPress
//     menu system.
// 03. Content provided locally from within the builders, such as the
//     individual icon or image controls.

$control_graphic_local_icons                 = NULL; // 01
$control_graphic_local_icon_primary          = NULL;
$control_graphic_local_icon_secondary        = NULL; // 01
$control_graphic_local_image_primary         = NULL; // 01
$control_group_graphic_local_image_secondary = NULL; // 01
$control_group_graphic_sourced_images        = NULL; // 01

$control_list_graphic_setup = array(
  $control_graphic,
  $control_graphic_type,
);

if ( $has_interactions ) {
  $control_list_graphic_setup[] = $control_graphic_interaction;
}

if ( $has_sourced_content ) { // 02

  $control_list_graphic_sourced_images_controls = array(
    array(
      'key'     => $k_pre . 'graphic_image_retina',
      'type'    => 'choose',
      'label'   => __( 'Retina Ready', '__x__' ),
      'options' => $options_choices_off_on_bool,
    ),
  );

  if ( $has_alt ) {
    $control_list_graphic_sourced_images_controls[] = array(
      'key'     => $k_pre . 'graphic_image_alt_enable',
      'type'    => 'choose',
      'label'   => __( 'Secondary', '__x__' ),
      'options' => $options_choices_off_on_bool,
    );
  }

  $control_group_graphic_sourced_images = array(
    'type'       => 'group',
    'title'      => __( $t_pre . ' Graphic Image', '__x__' ),
    'group'      => $group,
    'conditions' => $conditions_graphic_image,
    'controls'   => $control_list_graphic_sourced_images_controls,
  );

} else { // 03

  $control_graphic_local_icon_primary = array(
    'key'        => $k_pre . 'graphic_icon',
    'type'       => 'icon',
    'group'      => $group,
    'label'      => __( 'Primary Icon', '__x__' ),
    'conditions' => $conditions_graphic_icon,
  );

  $control_graphic_local_image_primary = array(
    'keys' => array(
      'img_source' => $k_pre . 'graphic_image_src',
      'is_retina'  => $k_pre . 'graphic_image_retina',
      'width'      => $k_pre . 'graphic_image_width',
      'height'     => $k_pre . 'graphic_image_height',
    ),
    'type'       => 'image',
    'title'      => __( $t_pre . ' Primary Graphic Image', '__x__' ),
    'group'      => $group,
    'conditions' => $conditions_graphic_image,
  );

  if ( $has_alt ) {

    $control_graphic_local_icon_secondary = array(
      'key'        => $k_pre . 'graphic_icon_alt',
      'type'       => 'icon',
      'group'      => $group,
      'label'      => __( 'Secondary Icon', '__x__' ),
      'conditions' => $conditions_graphic_icon_alt,
    );

    $control_group_graphic_local_image_secondary = array(
      'type'       => 'group',
      'title'      => __( $t_pre . ' Secondary Graphic Image', '__x__' ),
      'group'      => $group,
      'conditions' => $conditions_graphic_image_alt,
      'controls'   => $control_list_local_image_secondary,
    );

  }

  if ( isset( $control_graphic_local_icon_secondary ) ) {
    $control_graphic_local_icons = array(
      'type'     => 'group',
      'title'    => __( 'Primary &amp; Secondary', '__x__' ),
      'group'    => $group,
      'controls' => array(
        array_merge( $control_graphic_local_icon_primary,   array( 'options' => array( 'label' => __( 'Select', '__x__' ) ) ) ),
        array_merge( $control_graphic_local_icon_secondary, array( 'options' => array( 'label' => __( 'Select', '__x__' ) ) ) ),
      ),
    );
  } else {
    $control_graphic_local_icons = $control_graphic_local_icon_primary;
  }

}



// Control Groups (Advanced)
// =============================================================================

$control_group_graphic_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . ' Graphic Setup', '__x__' ),
    'group'      => $group,
    'conditions' => $conditions,
    'controls'   => $control_list_graphic_setup,
  ),
);

$control_group_graphic_adv_icon = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . ' Graphic Icon', '__x__' ),
    'group'      => $group,
    'conditions' => $conditions_graphic_icon,
    'controls'   => array(
      $control_graphic_icon_first_line,
      $control_graphic_icon_width_and_height,
      $control_graphic_local_icons,
      $control_graphic_icon_color,
      $control_graphic_icon_bg_color,
    ),
  ),
);

$control_group_graphic_adv_image = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . ' Graphic Image', '__x__' ),
    'group'      => $group,
    'conditions' => $conditions_graphic_image,
    'controls'   => $control_graphic_image_max_width,
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_graphic_std_icon = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . ' Graphic Icon', '__x__' ),
    'group'      => $group,
    'conditions' => $conditions_graphic_icon,
    'controls'   => array(
      $control_graphic_local_icon_primary,
      $control_graphic_local_icon_secondary,
    ),
  ),
);

$control_group_graphic_std_icon_colors = array_merge(
  array(
    array(
      'type'       => 'group',
      'title'      => __( $t_pre . 'Graphic Icon Colors', '__x__' ),
      'group'      => $group,
      'conditions' => $conditions_graphic_icon,
      'controls'   => array(
        $control_graphic_icon_color,
        $control_graphic_std_icon_text_shadow_color,
        $control_graphic_std_icon_box_shadow_color,
        $control_graphic_icon_bg_color,
      ),
    ),
  ),
  x_control_border(
    array_merge(
      $settings_graphic_icon_variable_alt_color,
      array(
        'condition' => array_merge(
          $conditions_graphic_icon,
          array(
            array( 'key' => $k_pre . 'graphic_icon_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => $k_pre . 'graphic_icon_border_style', 'op' => '!=', 'value' => 'none' ),
          )
        ),
      )
    )
  )
);
