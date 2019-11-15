<?php
return array(

	'post_title'     => array(
		'type' => 'text',
		'ui' => array( 'title' => __( 'Title', 'cornerstone' ) ),
		'options' => array(
			'trigger' => 'settings-wp-changed'
		)
	),

	'post_status' => array(
		'type' => 'select',
		'ui' => array(
			'title' => __( 'Status', 'cornerstone' )
		),
		'options' => array(
			'trigger' => 'settings-wp-changed',
			'choices' => $definition->post_status_choices()
		),
    'condition' => array(
      'user_can:{context}.publish' => true
    )
	),

	'allow_comments' => array(
		'type' => 'toggle',
		'ui' => array( 'title' => __( 'Allow Comments', 'cornerstone' ) ),
		'options' => array(
			'trigger' => 'settings-wp-changed',
		)
	),

	'manual_excerpt' => array(
		'type' => 'textarea',
		'ui' => array(
			'title' => __( 'Manual Excerpt', 'cornerstone' ),
		),
		'options' => array(
			'placeholder' => __( '(Optional) Cornerstone will derive an excerpt from any paragraphs in your content. You can override this by crafting your own excerpt here, or in the WordPress post editor.', 'cornerstone' )
		)
	),

	'post_parent' => array(
		'type' => 'wpselect',
		'ui' => array( 'title' => __( 'Parent Page', 'cornerstone' ) ),
		'options' => array(
			'trigger' => 'settings-wp-changed',
			'markup' => $definition->post_parent_markup()
		)
	),

	'page_template' => array(
		'type' => 'select',
		'ui' => array( 'title' => __( 'Page Template', 'cornerstone' ) ),
		'options' => array(
			'trigger' => 'settings-wp-changed',
			'choices' => $definition->page_template_choices()
		)
	)

);
