<?php

/**
 * Element Controls: Block Grid
 */

return array(

	'elements' => array(
		'type' => 'sortable',
		'ui' => array(
			'title' => __( 'Block Grid Items', 'cornerstone' ),
      'tooltip' =>__( 'Add a new item to your Block Grid.', 'cornerstone' ),
    ),
		'options' => array(
			'element' => 'block-grid-item',
			'newTitle' => __( 'Block Grid Item %s', 'cornerstone' ),
			'floor'   => 2,
		),
		'context' => 'content',
		'suggest' => array(
	    array( 'title' => __( 'Block Grid Item 1', 'cornerstone' ) ),
      array( 'title' => __( 'Block Grid Item 2', 'cornerstone' ) )
	  )

	),

	'type' => array(
		'type' => 'select',
		'ui'   => array(
			'title'   => __( 'Columns', 'cornerstone' ),
			'tooltip' => __( 'Select how many columns of items should be displayed on larger screens. These will update responsively based on screen size.', 'cornerstone' ),
		),
		'options' => array(
			'choices' => array(
				array( 'value' => 'two-up',   'label' => __( '2', 'cornerstone' ) ),
				array( 'value' => 'three-up', 'label' => __( '3', 'cornerstone' ) ),
				array( 'value' => 'four-up',  'label' => __( '4', 'cornerstone' ) )
	    )
		)
	),

);