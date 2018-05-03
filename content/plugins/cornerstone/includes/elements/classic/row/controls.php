<?php

/**
 * Element Controls: Row
 */

return array(

	'common' => array( 'padding', 'border', 'text_align', 'visibility' ),

	'inner_container' => array(
		'type' => 'toggle',
		'ui' => array(
			'title' => __( 'Column Container', 'cornerstone' ),
      'tooltip' => __( 'Disabling this control will allow your columns to be as wide as the browser window.', 'cornerstone' ),
		)
	),

	'marginless_columns' => array(
		'type' => 'toggle',
		'ui' => array(
			'title' => __( 'Marginless Columns', 'cornerstone' ),
      'tooltip' => __( 'This will remove the margin around your columns, allowing their borders to be flush with one another. This is often used to create block or grid layouts.', 'cornerstone' ),
		)
	),

	'bg_color' => array(
    'mixin' => 'background_color',
    'options' => array(
      'palette' => true
    )
  ),

	'margin' => array(
		'mixin' => 'margin',
		'options' => array( 'lock' => array( 'left' => 'auto', 'right' => 'auto' ) )
	),

	// INTERNAL - Layout Controls

	'_column_layout' => array(
		'type' => 'column-layout',
		'ui' => array(
			'title' => __( 'Column Layout &ndash; %%title%%', 'cornerstone' ),
			'tooltip' => __( 'Choose from one of our predefined column layouts, or specify your own using the input below. Columns cannot be any smaller than 1/6 and must add up to a whole.', 'cornerstone' )
		),
		'context' => '_layout'
	),

	'columns' => array(
		'type' => 'column-order',
		'key'  => 'elements',
		'ui' => array(
			'title' => __( 'Column Order &ndash; %%title%%', 'cornerstone' ),
			'tooltip' => __( 'Click and drag to reorder your columns.', 'cornerstone' )
		),
		'options' => array( 'divider' => true ),
		'context' => '_layout'
	),

);
