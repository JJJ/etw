<?php

/**
 * Element Controls: Pricing Table Column
 */

return array(

	'title' => array(
		'type' => 'title',
		'context' => 'content',
		'suggest' => __( 'Standard', 'cornerstone' ),
	),

	'content' => array(
		'type' => 'editor',
		'ui'   => array(
			'title'   => __( 'Content', 'cornerstone' ),
      'tooltip' => __( 'Specify your pricing column content.', 'cornerstone' ),
		),
		'context' => 'content',
		'suggest' => __( "[cs_icon_list]\n    [cs_icon_list_item type=\"check\"]First Feature[/cs_icon_list_item]\n    [cs_icon_list_item type=\"times\"]Second Feature[/cs_icon_list_item]\n    [cs_icon_list_item type=\"times\"]Third Feature[/cs_icon_list_item]\n[/cs_icon_list]\n\n[x_button href=\"#\" size=\"large\"]Buy Now![/x_button]", 'cornerstone' ),
	),

	'featured' => array(
		'type' => 'toggle',
		'ui'   => array(
			'title'   => __( 'Featured Column', 'cornerstone' ),
      'tooltip' => __( 'Enable to specify this column as your featured item.', 'cornerstone' ),
		)
	),

	'featured_sub' => array(
		'type' => 'text',
		'ui'   => array(
			'title'   => __( 'Featured Subheading', 'cornerstone' ),
      'tooltip' => __( 'Enter text for your featured column subheading here.', 'cornerstone' ),
		),
		'condition' => array(
      'featured' => true
    )
	),

	'currency' => array(
		'type' => 'text',
		'ui'   => array(
			'title'   => __( 'Currency', 'cornerstone' ),
      'tooltip' => __( 'Enter your desired currency symbol here.', 'cornerstone' ),
		)
	),

	'price' => array(
		'type' => 'text',
		'ui'   => array(
			'title'   => __( 'Price', 'cornerstone' ),
      'tooltip' => __( 'Enter the price for this column.', 'cornerstone' ),
		),
	),

	'interval' => array(
		'type' => 'text',
		'ui'   => array(
			'title'   => __( 'Interval', 'cornerstone' ),
      'tooltip' => __( 'Enter the duration for this payment (e.g. "Weekly," "Per Year," et cetera).', 'cornerstone' ),
		)
	),

);