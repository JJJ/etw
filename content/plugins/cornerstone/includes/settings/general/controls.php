<?php
return array(

	'custom_css' => array(
		'type' => 'code-editor',
		'options' => array(
			'settings' => array(
        'label' => __( 'Custom CSS', 'cornerstone' ),
        'mode' => 'css'
      )
		)
	),

	'custom_js' => array(
		'type' => 'code-editor',
		'options' => array(
			'settings' => array(
        //'label' => __( 'Custom Javascript', 'cornerstone' ),
        'mode' => 'javascript',
        'lint' => true
      )
		)
	),

	'post_title'     => array(
		'type' => 'text',
		'ui' => array(
			'title'   => __( 'Title', 'cornerstone' ),
			'tooltip' => __( 'Shortcut for changing the title from within Cornerstone.', 'cornerstone' ),
		),
		'options' => array(
			'notLive' => 'settings-wp-changed'
		)
	),

	'post_status' => array(
		'type' => 'select',
		'ui' => array(
			'title' => __( 'Status', 'cornerstone' )
		),
		'options' => array(
			'notLive' => 'settings-wp-changed',
			'choices' => $definition->post_status_choices()
		)
	),

	'allow_comments' => array(
		'type' => 'toggle',
		'ui' => array(
			'title'   => __( 'Allow Comments', 'cornerstone' ),
			'tooltip' => __( 'Opens or closes comments. Note: The comment form may not be shown if your chosen page template doesn&apost support them.', 'cornerstone' ),
		),
		'options' => array(
			'notLive' => 'settings-wp-changed',
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
		'ui' => array(
			'title' => __( 'Parent Page', 'cornerstone' )
		),
		'options' => array(
			'notLive' => 'settings-wp-changed',
			'markup' => $definition->post_parent_markup()
		)
	),

	'page_template' => array(
		'type' => 'select',
		'ui' => array(
			'title' => __( 'Page Template', 'cornerstone' )
		),
		'options' => array(
			'notLive' => 'settings-wp-changed',
			'choices' => $definition->page_template_choices()
		)
	)

);
