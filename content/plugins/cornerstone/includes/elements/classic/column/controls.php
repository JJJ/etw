<?php

/**
 * Element Controls: Column
 */

return array(

	'common' => array( 'padding', 'border', 'text_align' ),

  'bg_color' => array(
    'mixin' => 'background_color',
    'options' => array(
      'palette' => true
    )
  ),

	'fade' => array(
		'type' => 'toggle',
		'ui' => array(
			'title' => __( 'Enable Fade Effect', 'cornerstone' ),
      'tooltip' => __( 'Activating will make this column fade into view when the user scrolls to it for the first time.', 'cornerstone' ),
		)
	),

	'fade_animation' => array(
		'type' => 'choose',
		'ui' => array(
			'title' => __( 'Fade Direction', 'cornerstone' ),
      'tooltip' => __( 'Choose a direction to fade from. "None" will allow the column to fade in without coming from a particular direction.', 'cornerstone' ),
		),
		'options' => array(
			'columns' => '5',
			'choices' => array(
				array( 'value' => 'in',             'tooltip' => __( 'None', 'cornerstone' ),   'icon' => fa_entity( 'ban' ) ),
				array( 'value' => 'in-from-bottom', 'tooltip' => __( 'Top', 'cornerstone' ),    'icon' => fa_entity( 'arrow-up' ) ),
				array( 'value' => 'in-from-left',   'tooltip' => __( 'Right', 'cornerstone' ),  'icon' => fa_entity( 'arrow-right' ) ),
				array( 'value' => 'in-from-top',    'tooltip' => __( 'Bottom', 'cornerstone' ), 'icon' => fa_entity( 'arrow-down' ) ),
				array( 'value' => 'in-from-right',  'tooltip' => __( 'Left', 'cornerstone' ),   'icon' => fa_entity( 'arrow-left' ) )
			)
		),
		'condition' => array( 'fade' => true )
	),

	'fade_animation_offset' => array(
		'type' => 'text',
		'ui' => array(
			'title' => __( 'Offset', 'cornerstone' ),
      'tooltip' => __( 'Determines how drastic the fade effect will be.', 'cornerstone' ),
		),
		'condition' => array(
			'fade' => true,
			'fade_animation' => array( 'in-from-top', 'in-from-left', 'in-from-right', 'in-from-bottom' )
		)
	),

	'fade_duration' => array(
		'type' => 'text',
		'ui' => array(
			'title' => __( 'Duration', 'cornerstone' ),
      'tooltip' => __( 'Determines how long the fade effect will be.', 'cornerstone' ),
		),
		'condition' => array( 'fade' => true )
	),

);
