<?php

/**
 * Element Controls: Section
 */

return array(

  'common' => array( 'margin', 'padding', 'border', 'text_align', 'visibility' ),

  'bg_type' => array(
    'type' => 'choose',
    'ui' => array(
      'title' => __( 'Background Type', 'cornerstone' ),
      'tooltip' => __( 'Configure the background appearance for this Section.', 'cornerstone' ),
    ),
    'options' => array(
      'columns' => '4',
      'choices' => array(
        array( 'value' => 'none',  'icon' => fa_entity( 'ban' ),        'tooltip' => __( 'None', 'cornerstone' ) ),
        array( 'value' => 'color', 'icon' => fa_entity( 'eyedropper' ), 'tooltip' => __( 'Color', 'cornerstone' ) ),
        array( 'value' => 'image', 'icon' => fa_entity( 'image' ),      'tooltip' => __( 'Image', 'cornerstone' ) ),
        array( 'value' => 'video', 'icon' => fa_entity( 'film' ),       'tooltip' => __( 'Video', 'cornerstone' ) ),
      )
    )
  ),

  'bg_color' => array(
    'mixin' => 'background_color',
    'condition' => array( 'bg_type' => 'color' ),
    'options' => array(
      'palette' => true
    )
  ),

  'bg_image' => array(
    'type' => 'image',
    'ui' => array(
      'title' => __( 'Background Pattern', 'cornerstone' ),
      'tooltip' => __( 'Background patterns will tile and repeat across your Section.', 'cornerstone' ),
    ),
    'condition' => array(
      'bg_type'           => 'image',
      'bg_pattern_toggle' => true
    )
  ),

  'bg_pattern' => array(
    'type' => 'image',
    'key'  => 'bg_image', // Alias the same value for background image
    'ui' => array(
      'title' => __( 'Background Image', 'cornerstone' ),
      'tooltip' => __( 'Background images are resized to fill the entire Section, regardless of screen size. Keep this in mind when using images that are already cropped.', 'cornerstone' ),
    ),
    'condition' => array(
      'bg_type'           => 'image',
      'bg_pattern_toggle' => false
    )
  ),

  'bg_pattern_toggle' => array(
    'type' => 'toggle',
    'ui' => array(
      'title' => __( 'Pattern', 'cornerstone' ),
      'tooltip' => __( 'Switch how the image is applied to the background.', 'cornerstone' ),
    ),
    'condition' => array( 'bg_type' => 'image' )
  ),

  'parallax' => array(
    'type' => 'toggle',
    'ui' => array(
      'title' => __( 'Parallax', 'cornerstone' ),
      'tooltip' => __( 'Activates the parallax effect with background patterns and images.', 'cornerstone' ),
    ),
    'condition' => array( 'bg_type' => 'image' )
  ),

  'bg_video' => array(
    'type' => 'text',
    'ui' => array(
      'title' => __( 'Background Video URL &amp; Poster', 'cornerstone' ),
      'tooltip' => __( 'Include your video URL(s) here. If using multiple sources, separate them using the pipe character (|) and place fallbacks towards the end (i.e. .webm then .mp4 then .ogv). For performance reasons, videos are not loaded into the editor but are shown live.', 'cornerstone' ),
    ),
    'options' => array(
      'expandable' => false,
      'placeholder' => home_url( __( 'video.mp4', 'cornerstone' ) )
    ),
    'condition' => array( 'bg_type' => 'video' )
  ),

  'bg_video_poster' => array(
    'type' => 'image',
    'condition' => array( 'bg_type' => 'video' )
  ),

  'separator_top_type' => array(
    'type' => 'select',
    'ui'   => array(
      'title'   => __( 'Top Separator Type', 'cornerstone' ),
      'tooltip' => __( 'Adds a style separator to your section to create visual interest. Can only be utilized with solid color backgrounds.', 'cornerstone' ),
    ),
    'options' => array(
      'columns' => '4',
      'choices' => array(
        array( 'value' => 'none',      'label' => __( 'None', 'cornerstone' ) ),
        array( 'value' => 'angle-in',  'label' => __( 'Angle In', 'cornerstone' ) ),
        array( 'value' => 'angle-out', 'label' => __( 'Angle Out', 'cornerstone' ) ),
        array( 'value' => 'curve-in',  'label' => __( 'Curve In', 'cornerstone' ) ),
        array( 'value' => 'curve-out', 'label' => __( 'Curve Out', 'cornerstone' ) ),
      )
    )
  ),

  'separator_top_height' => array(
    'type' => 'text',
    'ui'   => array(
      'title'   => __( 'Top Separator Height', 'cornerstone' ),
      'tooltip' => __( 'Specify the height of your top separator.', 'cornerstone' ),
    ),
    'options' => array(
      'expandable' => false
    ),
    'condition' => array(
    	'separator_top_type:not' => 'none'
    )
  ),

  'separator_top_angle_point' => array(
    'type' => 'text',
    'ui'   => array(
      'title'   => __( 'Top Angle Point', 'cornerstone' ),
      'tooltip' => __( 'Specify a number between 0 and 100 to move the angle point.', 'cornerstone' ),
    ),
    'options' => array(
      'expandable' => false
    ),
    'condition' => array(
    	'separator_top_type' => array( 'angle-in', 'angle-out' )
    )
  ),

  'separator_bottom_type' => array(
    'type' => 'select',
    'ui'   => array(
      'title'   => __( 'Bottom Separator Type', 'cornerstone' ),
      'tooltip' => __( 'Adds a style separator to your section to create visual interest. Can only be utilized with solid color backgrounds.', 'cornerstone' ),
    ),
    'options' => array(
      'columns' => '4',
      'choices' => array(
        array( 'value' => 'none',      'label' => __( 'None', 'cornerstone' ) ),
        array( 'value' => 'angle-in',  'label' => __( 'Angle In', 'cornerstone' ) ),
        array( 'value' => 'angle-out', 'label' => __( 'Angle Out', 'cornerstone' ) ),
        array( 'value' => 'curve-in',  'label' => __( 'Curve In', 'cornerstone' ) ),
        array( 'value' => 'curve-out', 'label' => __( 'Curve Out', 'cornerstone' ) ),
      )
    )
  ),

  'separator_bottom_height' => array(
    'type' => 'text',
    'ui'   => array(
      'title'   => __( 'Bottom Separator Height', 'cornerstone' ),
      'tooltip' => __( 'Specify the height of your bottom separator.', 'cornerstone' ),
    ),
    'options' => array(
      'expandable' => false
    ),
    'condition' => array(
    	'separator_bottom_type:not' => 'none'
    )
  ),

  'separator_bottom_angle_point' => array(
    'type' => 'text',
    'ui'   => array(
      'title'   => __( 'Bottom Angle Point', 'cornerstone' ),
      'tooltip' => __( 'Specify a number between 0 and 100 to move the angle point.', 'cornerstone' ),
    ),
    'options' => array(
      'expandable' => false
    ),
    'condition' => array(
    	'separator_bottom_type' => array( 'angle-in', 'angle-out' )
    )
  ),

  // INTERNAL - Layout Controls

  '_help_text' => array(
    'type' => 'info-box',
    'key' => 'disabled',
    'ui' => array(
      'title' => __( 'Want to add content?', 'cornerstone' ),
      'message' => __( 'Choose a layout, click the <strong class="glue">%%icon-nav-elements-solid%% Elements</strong> icon above, then drag elements into a column.', 'cornerstone' )
    ),
    'context' => '_layout'
  ),

  'title' => array(
    'type' => 'title',
    'options' => array(
      'showInspectButton' => true,
      'divider' => true
    ),
    'context' => '_layout'
  ),

  'rows' => array(
    'type' => 'sortable-rows',
    'key'  => 'elements',
    'options' => array(
      'element' => 'row',
      'floor'   => 1,
      'divider' => true
    ),
    'context' => '_layout'
  ),

);
