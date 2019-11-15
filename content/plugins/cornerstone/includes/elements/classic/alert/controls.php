<?php

/**
 * Element Controls: Alert
 */

return array(

	'heading' => array(
		'type'    => 'text',
		'ui' => array(
			'title'   => __( 'Heading', 'cornerstone' ),
			'tooltip' => __( 'Text for your alert heading', 'cornerstone' ),
		),
		'context' => 'content',
    'suggest' => __( 'Alert Title', 'cornerstone' ),
	),

	'content' => array(
		'type'    => 'textarea',
		'ui' => array(
			'title'   => __( 'Content', 'cornerstone' ),
			'tooltip' => __( 'Text for your alert content.', 'cornerstone' ),
		),
		'context' => 'content',
		'suggest' => __( 'Click to inspect, then edit as needed.', 'cornerstone' ),
	),

	'type' => array(
		'type' => 'choose',
		'ui' => array(
			'title' => __( 'Type', 'cornerstone' ),
      'tooltip' => __( 'There are multiple alert types for different situations. Select the one that best suits your needs.', 'cornerstone' ),
		),
		'options' => array(
      'columns' => '5',
      'choices' => array(
        array( 'value' => 'muted',   'tooltip' => __( 'Muted', 'cornerstone' ),   'icon' => fa_entity( 'ban' ) ),
        array( 'value' => 'success', 'tooltip' => __( 'Success', 'cornerstone' ), 'icon' => fa_entity( 'check' ) ),
        array( 'value' => 'info',    'tooltip' => __( 'Info', 'cornerstone' ),    'icon' => fa_entity( 'info' ) ),
        array( 'value' => 'warning', 'tooltip' => __( 'Warning', 'cornerstone' ), 'icon' => fa_entity( 'exclamation-triangle' ) ),
        array( 'value' => 'danger',  'tooltip' => __( 'Danger', 'cornerstone' ),  'icon' => fa_entity( 'exclamation-circle' ) )
      )
    )
  ),

	'close' => array(
		'type' => 'toggle',
		'ui' => array(
			'title' => __( 'Close Button', 'cornerstone' ),
      'tooltip' => __( 'Enabling the close button will make the alert dismissible, allowing your users to remove it if desired.', 'cornerstone' ),
		)
	)

);
