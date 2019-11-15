<?php

return array(

  array(
    'key'         => 'advanced_mode',
		'type'        => 'toggle',
		'title'       => __( 'Advanced Mode', 'cornerstone' ),
		'description' => __( 'Show more design controls when inspecting an element in the builders.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.advanced_mode.user' => true ),
  ),

  array(
    'key'         => 'dynamic_content',
		'type'        => 'toggle',
		'title'       => __( 'Dynamic Content', 'cornerstone' ),
		'description' => __( 'Show controls to open Dynamic Content wherever it is supported.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.dynamic_content.user' => true ),
	),

  array(
    'key'         => 'control_nav',
		'type'        => 'select',
		'title'       => __( 'Control Navigation', 'cornerstone' ),
		'description' => __( 'Decide where to display Inspector control navigation and breadcrumbs.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.control_nav.user' => true ),
    'options'     => array(
      'choices' => array(
        array( 'value' => 'inline', 'label' => __( 'Inline', 'cornerstone' ) ),
        array( 'value' => 'top', 'label' => __( 'Top Bar', 'cornerstone' ) ),
        array( 'value' => 'bottom', 'label' => __( 'Bottom Bar', 'cornerstone' ) )
      )
    )
  ),

  array(
    'key'         => 'show_wp_toolbar',
		'type'        => 'toggle',
		'title'       => __( 'WordPress Toolbar', 'cornerstone' ),
		'description' => __( 'Allow WordPress to display the toolbar above the app. Requires a page refresh to take effect.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.show_wp_toolbar.user' => true ),
	),

  array(
    'key'         => 'help_text',
		'type'        => 'toggle',
		'title'       => __( 'Help Text', 'cornerstone' ),
		'description' => __( 'Show helpful inline messaging throughout the tool to describe various features.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.help_text.user' => true ),
  ),

  array(
    'key'         => 'rich_text_default',
    'type'        => 'toggle',
    'title'       => __( 'Rich Text Editor Default', 'cornerstone' ),
    'description' => __( 'By default, start text editors in rich text mode whenever possible.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.rich_text_default.user' => true ),
  ),

  array(
    'key'         => 'context_menu',
		'type'        => 'toggle',
		'title'       => __( 'Context Menu', 'cornerstone' ),
		'description' => __( 'Allow context menu to appear when alt-clicking in the live preview.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.help_text.user' => true ),
  ),

  array(
    'key'         => 'ui_theme',
    'type'        => 'select',
    'title'       => __( 'UI Theme', 'cornerstone' ),
    'description' => __( 'Select how you would like the application UI to appear.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.ui_theme.user' => true ),
    'options'     => array(
      'choices' => array(
        array( 'value' => 'light', 'label' => __( 'Light', 'cornerstone' ) ),
        array( 'value' => 'dark', 'label' => __( 'Dark', 'cornerstone' ) )
      )
    )
  ),

  array(
    'key'         => 'content_layout_element',
    'type'        => 'select',
    'title'       => __( 'Content Layout Element', 'cornerstone' ),
    'description' => __( 'Select which element you would like to be the default child when adding new sections.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.content_layout_element.user' => true ),
    'options'     => array(
      'choices' => array(
        array( 'value' => 'layout-row', 'label' => __( 'Row', 'cornerstone' ) ),
        array( 'value' => 'row', 'label' => __( 'Classic Row', 'cornerstone' ) )
      )
    )
  ),

);
