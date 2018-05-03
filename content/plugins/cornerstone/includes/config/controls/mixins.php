<?php

return array(

	//
	// ID
	//

	'id' => array(
		'type' => 'text',
		'ui' => array(
			'title' => __( 'ID', 'cornerstone' ),
			'tooltip' => __( 'Add an ID to this element so you can target it with your own customizations.', 'cornerstone' ),
		),
		'options' => array( 'monospace' => true )
	),

	//
	// Class
	//

	'class' => array(
		'type' => 'text',
		'ui' => array(
			'title' => __( 'Class', 'cornerstone' ),
			'tooltip' => __( 'Add custom classes to this element. Multiple classes should be seperated by spaces. They will be added at the root level element.', 'cornerstone' ),
		),
		'options' => array( 'monospace' => true )
	),

  //
  // Style
  //

	'style' => array(
		'type' => 'text',
		'ui' => array(
			'title' => __( 'Style', 'cornerstone' ),
			'tooltip' => __( 'Add an inline style to this element. This only contain valid CSS rules with no selectors or braces.', 'cornerstone' ),
		),
		'options' => array( 'monospace' => true )
	),

  //
  // Padding
  //

	'margin' => array(
		'type' => 'dimensions',
		'ui' => array(
			'title' => __( 'Margin', 'cornerstone' ),
			'tooltip' =>__( 'Specify a custom margin for each side of this element. Can accept CSS units like px, ems, and % (default unit is px).', 'cornerstone' ),
		)
	),

  //
  // Padding
  //

	'padding' => array(
		'type' => 'dimensions',
		'ui' => array(
			'title' => __( 'Padding', 'cornerstone' ),
			'tooltip' =>__( 'Specify a custom padding for each side of this element. Can accept CSS units like px, ems, and % (default unit is px).', 'cornerstone' ),
		)
	),

	//
	// Text Align
	//

	'text_align' => array(
		'type' => 'choose',
		'ui' => array(
			'title' => __( 'Text Align', 'cornerstone' ),
			'tooltip' =>__( 'Set a text alignment, or deselect to inherit from parent elements.', 'cornerstone' ),
		),
		'options' => array(
			'columns' => '4',
			'offValue' => '',
			'choices' => array(
				array( 'value' => 'l', 'icon' => fa_entity( 'align-left' ),    'tooltip' => __( 'Left', 'cornerstone' ) ),
				array( 'value' => 'c', 'icon' => fa_entity( 'align-center' ),  'tooltip' => __( 'Center', 'cornerstone' ) ),
				array( 'value' => 'r', 'icon' => fa_entity( 'align-right' ),   'tooltip' => __( 'Right', 'cornerstone' ) ),
				array( 'value' => 'j', 'icon' => fa_entity( 'align-justify' ), 'tooltip' => __( 'Justify', 'cornerstone' ) )
			)
		)
	),

	//
	// Visibility
	//

	'visibility' => array(
		'type' => 'multi-choose',
		'ui' => array(
			'title' => __( 'Hide based on screen width', 'cornerstone' ),
			'toolip' => __( 'Hide this element at different screen widths. Keep in mind that the &ldquo;Extra Large&rdquo; toggle is 1200px+, so you may not see your element disappear if your preview window is not large enough.', 'cornerstone' )
		),
		'options' => array(
			'columns' => '5',
			'choices' => array(
				array( 'value' => 'xl', 'icon' => fa_entity( 'desktop' ), 'tooltip' => __( 'XL', 'cornerstone' ) ),
				array( 'value' => 'lg', 'icon' => fa_entity( 'laptop' ),  'tooltip' => __( 'LG', 'cornerstone' ) ),
				array( 'value' => 'md', 'icon' => fa_entity( 'tablet' ),  'tooltip' => __( 'MD', 'cornerstone' ) ),
				array( 'value' => 'sm', 'icon' => fa_entity( 'tablet' ),  'tooltip' => __( 'SM', 'cornerstone' ) ),
				array( 'value' => 'xs', 'icon' => fa_entity( 'mobile' ),  'tooltip' => __( 'XS', 'cornerstone' ) ),
			)
		)
	),

	//
	// Border Group
	//

	'border' => array(

		'group' => true,

		//
		// Border.Style
		//

		'style' => array(
			'type' => 'select',
			'ui' => array(
				'title' => __( 'Border', 'cornerstone' ),
				'tooltip' => __( 'Specify a custom border for this element by selecting a style, choosing a color, and inputting your dimensions.', 'cornerstone' ),
			),
			'options' => array(
				'choices' => array(
					array( 'value' => 'none',   'label' => __( 'None', 'cornerstone' ) ),
					array( 'value' => 'solid',  'label' => __( 'Solid', 'cornerstone' ) ),
					array( 'value' => 'dotted', 'label' => __( 'Dotted', 'cornerstone' ) ),
					array( 'value' => 'dashed', 'label' => __( 'Dashed', 'cornerstone' ) ),
					array( 'value' => 'double', 'label' => __( 'Double', 'cornerstone' ) ),
					array( 'value' => 'groove', 'label' => __( 'Groove', 'cornerstone' ) ),
					array( 'value' => 'ridge',  'label' => __( 'Ridge', 'cornerstone' ) ),
					array( 'value' => 'inset',  'label' => __( 'Inset', 'cornerstone' ) ),
					array( 'value' => 'outset', 'label' => __( 'Outset', 'cornerstone' ) )
				)
			)
		),

		//
		// Border.Color
		//

		'color' => array(
			'type' => 'color',
			'condition' => array(
				'group::style:not' => 'none', // ~ indicates relative to the control group. Should be expanded at runtime
			)
		),

		//
		// Border.Width
		//

		'width' => array(
			'type' => 'dimensions',
			'condition' => array(
				'group::style:not' => 'none', // ~ indicates relative to the control group. Should be expanded at runtime
			)
		)
	),

	//
	// Link Group
	//

	'link' => array(

		'group' => true,

			//
			// Link.URL
			//

		'url' => array(
			'type' => 'text',
			'ui' => array(
				'title' => __( 'URL', 'cornerstone' ),
				'tooltip' => __( 'Enter a destination URL for when this is clicked.', 'cornerstone' ),
			),
		),

		//
		// Link.Title
		//

		'title' => array(
			'type' => 'text',
			'ui' => array(
				'title' => __( 'Link Title Attribute', 'cornerstone' ),
				'tooltip' => __( 'Enter in the title attribute you want for your link. This often appears in a browser tooltip when hovering.', 'cornerstone' ),
			),
		),

		//
		// Link.NewTab
		//

		'new_tab' => array(
			'type' => 'toggle',
			'ui' => array(
				'title' => __( 'Open Link in New Tab', 'cornerstone' ),
				'tooltip' => __( 'Select to open your link in a new tab, or a new window in older browsers.', 'cornerstone' ),
			),
		)
	),

	//
	// Animation Group
	//
	'animation' => array(

		'group' => true,

		//
		// Animation.Flavor
		//

		'flavor' => array(
			'type' => 'select',
			'ui' => array(
				'title' => __( 'Animation', 'cornerstone' ),
				'tooltip' => __( 'Optionally add animation to your element as users scroll down the page.', 'cornerstone' ),
			),
			'options' => array(
				'choices' => CS()->config_group( 'controls/animation-choices' )
			)
		),

		//
		// Animation.Offset
		//

		'offset' => array(
			'type' => 'text',
			'ui' => array(
				'title' => __( 'Animation Offset (%)', 'cornerstone' ),
				'tooltip' => __( 'Specify a percentage value where the element should appear on screen for the animation to take place.', 'cornerstone' ),
			),
			'condition' => array(
				'group::flavor:not' => 'none'
			)
		),

		//
		// Animation.Delay
		//

		'delay' => array(
			'type' => 'text',
			'ui' => array(
				'title' => __( 'Animation Delay (ms)', 'cornerstone' ),
				'tooltip' => __( 'Specify an amount of time before the graphic animation starts in milliseconds.', 'cornerstone' ),
			),
			'condition' => array(
				'group::flavor:not' => 'none'
			)
		)
	),

	//
	// Background Color
	//

	'background_color' => array(
		'type' => 'color',
		'ui' => array(
			'title' => __( 'Background Color', 'cornerstone' ),
      'tooltip' => __( 'Select the background color for this element.', 'cornerstone' ),
		)
	),

);