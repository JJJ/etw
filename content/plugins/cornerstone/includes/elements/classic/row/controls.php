<?php

/**
 * Element Controls: Row
 */

return array(

	'common' => array( 'padding', 'border', 'text_align', 'visibility' ),

	'columns' => array(
		'type' => '_columns',
		'ui' => array(
			'title' => __( 'Columns', 'cornerstone' ),
			'tooltip' => ''
		)
	),

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
	)

);
