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

);
