<?php

/**
 * Element Controls: Pricing Table
 */

return array(

	'elements' => array(
		'type' => 'sortable',
		'ui' => array(
			'title' => __( 'Pricing Table Columns', 'cornerstone' ),
      'tooltip' =>__( 'Add your pricing table columns here.', 'cornerstone' ),
    ),
		'options' => array(
			'element' => 'pricing-table-column',
			'newTitle' => __( 'Column %s', 'cornerstone' ),
			'floor'   => 1,
      'capacity' => 5
		),
		'context' => 'content',
		'suggest' => array(
	    array( 'title' => __( 'Basic', 'cornerstone' ),    'price' => '19', 'featured' => false, 'content' => __( "[cs_icon_list]\n    [cs_icon_list_item type=\"check\"]First Feature[/cs_icon_list_item]\n    [cs_icon_list_item type=\"times\"]Second Feature[/cs_icon_list_item]\n    [cs_icon_list_item type=\"times\"]Third Feature[/cs_icon_list_item]\n[/cs_icon_list]\n\n[x_button href=\"#\" size=\"large\"]Buy Now![/x_button]", 'cornerstone' ) ),
      array( 'title' => __( 'Standard', 'cornerstone' ), 'price' => '29', 'featured' => true,  'content' => __( "[cs_icon_list]\n    [cs_icon_list_item type=\"check\"]First Feature[/cs_icon_list_item]\n    [cs_icon_list_item type=\"check\"]Second Feature[/cs_icon_list_item]\n    [cs_icon_list_item type=\"times\"]Third Feature[/cs_icon_list_item]\n[/cs_icon_list]\n\n[x_button href=\"#\" size=\"large\"]Buy Now![/x_button]", 'cornerstone' ), 'featured_sub' => 'Most Popular!' ),
      array( 'title' => __( 'Pro', 'cornerstone' ),      'price' => '39', 'featured' => false, 'content' => __( "[cs_icon_list]\n    [cs_icon_list_item type=\"check\"]First Feature[/cs_icon_list_item]\n    [cs_icon_list_item type=\"check\"]Second Feature[/cs_icon_list_item]\n    [cs_icon_list_item type=\"check\"]Third Feature[/cs_icon_list_item]\n[/cs_icon_list]\n\n[x_button href=\"#\" size=\"large\"]Buy Now![/x_button]", 'cornerstone' ) )
	  )

	),

);