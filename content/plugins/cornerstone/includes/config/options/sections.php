<?php

return array(
  'content-builder' => array(
    'title'       => __( 'Content Builder', 'cornerstone' ),
    'description' => __( 'Cornerstone attempts to follow your theme&apos;s provided styling. If suitable styling isn&apos;t found in the theme, you can use the options below to set a compatibility baseline.<br/><br/>If you notice the settings below are not making a visible difference, chances are that your theme is handling the styling in that area. Cornerstone prefers to give the theme precedence when possible.<br/><br/>Finally, changing settings here won&apos;t affect elements that you have already configured directly (buttons for example).', 'cornerstone' ),
    'sections' => array(
      'layout' => array(
        'title' => __( 'Layout', 'cornerstone' ),
        'controls' => array(
          'cs_v1_base_margin' => array(
            'type' => 'text',
            'title' => __( 'Base Margin', 'cornerstone' )
          ),
          'cs_v1_base_margin_extended' => array(
            'type' => 'toggle',
            'title' => __( 'Extended Base Margin', 'cornerstone' )
          ),
          'cs_v1_container_width' => array(
            'type' => 'text',
            'title' => __( 'Container Width', 'cornerstone' )
          ),
          'cs_v1_container_max_width' => array(
            'type' => 'text',
            'title' => __( 'Container Max Width', 'cornerstone' )
          ),
        )
      ),
      'typography' => array(
        'title' => __( 'Typography', 'cornerstone' ),
        'controls' => array(
          'cs_v1_text_color' => array(
            'type' => 'color',
            'title' => __( 'Text Color', 'cornerstone' )
          ),
          'cs_v1_link_color' => array(
            'type' => 'color',
            'title' => __( 'Link Color', 'cornerstone' )
          ),
          'cs_v1_link_color_hover' => array(
            'type' => 'color',
            'title' => __( 'Link Hover Color', 'cornerstone' )
          )
        )
      ),
      'buttons' => array(
        'title' => __( 'Buttons', 'cornerstone' ),
        'controls' => array(
          'cs_v1_button_style' => array(
            'type' => 'select',
            'title' => __( 'Button Style', 'cornerstone' ),
            'options' => array(
              'choices' => array(
                'real'        => __( '3D', 'cornerstone' ),
                'flat'        => __( 'Flat', 'cornerstone' ),
                'transparent' => __( 'Transparent', 'cornerstone' )
              )
            )
          ),
          'cs_v1_button_shape' => array(
            'type' => 'select',
            'title' => __( 'Button Shape', 'cornerstone' ),
            'options' => array(
              'choices' => array(
                'square'  => __( 'Square', 'cornerstone' ),
                'rounded' => __( 'Rounded', 'cornerstone' ),
                'pill'    => __( 'Pill', 'cornerstone' )
              )
            )
          ),
          'cs_v1_button_size' => array(
            'type' => 'select',
            'title' => __( 'Button Size', 'cornerstone' ),
            'options' => array(
              'choices' => array(
                'mini'    => __( 'Mini', 'cornerstone' ),
                'small'   => __( 'Small', 'cornerstone' ),
                'regular' => __( 'Regular', 'cornerstone' ),
                'large'   => __( 'Large', 'cornerstone' ),
                'x-large' => __( 'Extra Large', 'cornerstone' ),
                'jumbo'   => __( 'Jumbo', 'cornerstone' )
              )
            )
          ),
          'cs_v1_button_color' => array(
            'type' => 'color',
            'title' => __( 'Button Text', 'cornerstone' )
          ),
          'cs_v1_button_bg_color' => array(
            'type' => 'color',
            'title' => __( 'Button Background', 'cornerstone' ),
            'condition' => array( 'option' => 'cs_v1_button_style', 'value' => 'transparent', 'op' => '!=' )
          ),
          'cs_v1_button_border_color' => array(
            'type' => 'color',
            'title' => __( 'Button Border', 'cornerstone' )
          ),
          'cs_v1_button_bottom_color' => array(
            'type' => 'color',
            'title' => __( 'Button Bottom', 'cornerstone' ),
            'condition' => array( 'option' => 'cs_v1_button_style', 'value' => array( 'flat', 'transparent' ), 'op' => 'NOT IN' )
          ),
          'cs_v1_button_color_hover' => array(
            'type' => 'color',
            'title' => __( 'Button Text Hover', 'cornerstone' )
          ),
          'cs_v1_button_bg_color_hover' => array(
            'type' => 'color',
            'title' => __( 'Button Background Hover', 'cornerstone' ),
            'condition' => array( 'option' => 'cs_v1_button_style', 'value' => 'transparent', 'op' => '!=' )
          ),
          'cs_v1_button_border_color_hover' => array(
            'type' => 'color',
            'title' => __( 'Button Border Hover', 'cornerstone' )
          ),
          'cs_v1_button_bottom_color_hover' => array(
            'type' => 'color',
            'title' => __( 'Button Bottom Hover', 'cornerstone' ),
            'condition' => array( 'option' => 'cs_v1_button_style', 'value' => array( 'flat', 'transparent' ), 'op' => 'NOT IN' )
          )
        )
      )
    )
  )
);
