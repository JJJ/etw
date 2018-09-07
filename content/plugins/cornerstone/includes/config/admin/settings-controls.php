<?php

return array(

  // 'allowed_post_types' => array(
	// 	'type' => 'multi-select',
	// 	'ui' => array(
	// 		'title'   => __( 'Allowed Post Types', 'cornerstone' ),
	// 		'description' => __( 'Select which post types to enable for the Content Builder.', 'cornerstone' ),
	// 	),
	// 	'options' => array(
	// 		'placeholder' => __( 'Click to select post types.', 'cornerstone' ),
	// 		'choices' => $this->component( 'Settings_Handler' )->get_post_type_choices()
	// 	)
	// ),
  //
  // 'permitted_roles' => array(
	// 	'type' => 'multi-select',
	// 	'ui' => array(
	// 		'title'       => __( 'Content Roles', 'cornerstone' ),
	// 		'description' => __( 'Allow content editing for roles other than Administrator.', 'cornerstone' ),
	// 	),
	// 	'options' => array(
	// 		'placeholder' => __( 'Click to choose additional roles.', 'cornerstone' ),
	// 		'choices' => $this->component( 'Settings_Handler' )->get_role_choices()
	// 	)
	// ),

  'custom_app_slug' => array(
    'type' => 'text',
    'ui' => array(
      'title'       => __( 'Custom Path', 'cornerstone' ),
      'description' => __( 'Change the path used to load the main interface.', 'cornerstone' ),
    ),
    'options' => array(
      'placeholder' => apply_filters( 'cornerstone_default_app_slug', 'cornerstone' )
    ),
  ),

  'hide_access_path' => array(
    'type' => 'checkbox',
    'ui' => array(
      'title'       => __( 'Hide Access Path', 'cornerstone' ),
      'description' => __( 'Logged out users trying to access the interface will see a 404 instead of a login prompt.', 'cornerstone' ),
    )
  ),

  'use_shortcode_generator' => array(
    'type' => 'checkbox',
    'ui' => array(
      'title'       => __( 'Show Legacy Shortcode Generator', 'cornerstone' ),
      'description' => __( '<em>Not reccomended</em>. The old shortcode generator does not work for new elements, and is now hidden by default. This setting will bring it back if you wish to continue using it with old elements.', 'cornerstone' ),
    )
  )

);
