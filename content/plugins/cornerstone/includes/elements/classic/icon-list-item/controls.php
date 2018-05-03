<?php

/**
 * Element Controls: Icon List Item
 */

return array(

	'title' => array(
		'type' => 'title',
		'context' => 'content',
		'suggest' => __( 'New Item', 'cornerstone' ),
	),

	'type' => array(
		'type' => 'icon-choose',
		'ui'   => array(
			'title'   => __( 'Icon', 'cornerstone' ),
			'tooltip' => __( 'Specify the icon you would like to use as the bullet for your Icon List Item.', 'cornerstone' ),
		)
	),

	'icon_color' => array(
		'type' => 'color',
		'ui' => array(
			'title'   => __( 'Icon Color', 'cornerstone' ),
			'tooltip' =>__( 'Choose a custom color for your Icon List Item\'s icon.', 'cornerstone' ),
		)
	),


	'link' => array(

		'mixin' => 'link',

		'enabled' => array(
			'type' => 'toggle',
			'ui'   => array(
				'title'   => __( 'Link', 'cornerstone' ),
				'tooltip' => __( 'Add a link to the text for this item.', 'cornerstone' ),
			)
		),

		'url' => array(
			'condition' => array(
				'group::enabled' => true
			)
		),

		'title' => array(
			'condition' => array(
				'group::enabled' => true
			)
		),

		'new_tab' => array(
			'condition' => array(
				'group::enabled' => true
			)
		)

	),

);