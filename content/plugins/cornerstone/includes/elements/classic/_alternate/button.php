<?php

class CS_Button extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'button',
      'title'       => __( 'Button', 'cornerstone' ),
      'section'     => 'marketing',
      'description' => __( 'Button description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'autofocus' => array(
    		'content' => '.x-btn'
    	),
      'protected_keys' => array( 'content', 'info_content', 'href', 'href_title', 'href_target' )
    );
  }

  public function controls() {

    $this->addControl(
      'content',
      'text',
      __( 'Text', 'cornerstone' ),
      __( 'Enter your text.', 'cornerstone' ),
      __( 'Click Me!', 'cornerstone' )
    );

    $this->addSupport( 'link' );

    $this->addControl(
      'type',
      'select',
      __( 'Type', 'cornerstone' ),
      __( 'Select the button type.', 'cornerstone' ),
      'global',
      array(
        'choices' => array(
          array( 'value' => 'global',      'label' => __( 'Global Setting', 'cornerstone' ) ),
          array( 'value' => 'real',        'label' => __( 'Real', 'cornerstone' ) ),
          array( 'value' => 'flat',        'label' => __( 'Flat', 'cornerstone' ) ),
          array( 'value' => 'transparent', 'label' => __( 'Transparent', 'cornerstone' ) )
        )
      )
    );

    $this->addControl(
      'shape',
      'select',
      __( 'Shape', 'cornerstone' ),
      __( 'Select the button shape.', 'cornerstone' ),
      'global',
      array(
        'choices' => array(
          array( 'value' => 'global',  'label' => __( 'Global Setting', 'cornerstone' ) ),
          array( 'value' => 'square',  'label' => __( 'Square', 'cornerstone' ) ),
          array( 'value' => 'rounded', 'label' => __( 'Rounded', 'cornerstone' ) ),
          array( 'value' => 'pill',    'label' => __( 'Pill', 'cornerstone' ) )
        )
      )
    );

    $this->addControl(
      'button_size',
      'select',
      __( 'Size', 'cornerstone' ),
      __( 'Select the button size.', 'cornerstone' ),
      'global',
      array(
        'choices' => array(
          array( 'value' => 'global',  'label' => __( 'Global Setting', 'cornerstone' ) ),
          array( 'value' => 'mini',    'label' => __( 'Mini', 'cornerstone' ) ),
          array( 'value' => 'small',   'label' => __( 'Small', 'cornerstone' ) ),
          array( 'value' => 'regular', 'label' => __( 'Regular', 'cornerstone' ) ),
          array( 'value' => 'large',   'label' => __( 'Large', 'cornerstone' ) ),
          array( 'value' => 'x-large', 'label' => __( 'X-Large', 'cornerstone' ) ),
          array( 'value' => 'jumbo',   'label' => __( 'Jumbo', 'cornerstone' ) )
        ),
        'offState' => 'notreallyno'
      )
    );

    $this->addControl(
      'block',
      'toggle',
      __( 'Block', 'cornerstone' ),
      __( 'Select to make your button go fullwidth.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'circle',
      'toggle',
      __( 'Marketing Circle', 'cornerstone' ),
      __( 'Select to include a marketing circle around your button.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'icon_toggle',
      'toggle',
      __( 'Enable Icon', 'cornerstone' ),
      __( 'Select if you would like to add an icon to your button', 'cornerstone' ),
      false
    );

    $this->addControl(
      'icon_placement',
      'select',
      __( 'Icon Placement', 'cornerstone' ),
      __( 'Place the icon before or after the button text, or even override the button text.', 'cornerstone' ),
      'before',
      array(
        'condition' => array( 'icon_toggle' => true ),
        'choices' => array(
          array( 'value' => 'notext', 'label' => __( 'Icon Only', 'cornerstone' ) ),
          array( 'value' => 'before', 'label' => __( 'Before', 'cornerstone' ) ),
          array( 'value' => 'after',  'label' => __( 'After', 'cornerstone' ) )
        )
      )
    );

    $this->addControl(
      'icon_type',
      'icon-choose',
      __( 'Icon', 'cornerstone' ),
      __( 'Icon to be displayed inside your button.', 'cornerstone' ),
      'lightbulb-o',
      array(
        'condition' => array( 'icon_toggle' => true )
      )
    );

    $this->addControl(
      'info',
      'select',
      __( 'Info', 'cornerstone' ),
      __( 'Select whether or not you want to add a popover or tooltip to your button.', 'cornerstone' ),
      'none',
      array(
        'choices' => array(
          array( 'value' => 'none',    'label' => __( 'None', 'cornerstone' ) ),
          array( 'value' => 'popover', 'label' => __( 'Popover', 'cornerstone' ) ),
          array( 'value' => 'tooltip', 'label' => __( 'Tooltip', 'cornerstone' ) )
        )
      )
    );

    $this->addControl(
      'info_place',
      'choose',
      __( 'Info Placement', 'cornerstone' ),
      __( 'Select where you want your popover or tooltip to appear.', 'cornerstone' ),
      'top',
      array(
        'columns' => '4',
        'choices' => array(
          array( 'value' => 'top',    'icon' => fa_entity( 'arrow-up' ),    'tooltip' => __( 'Top', 'cornerstone' ) ),
          array( 'value' => 'right',  'icon' => fa_entity( 'arrow-right' ), 'tooltip' => __( 'Right', 'cornerstone' ) ),
          array( 'value' => 'bottom', 'icon' => fa_entity( 'arrow-down' ),  'tooltip' => __( 'Bottom', 'cornerstone' ) ),
          array( 'value' => 'left',   'icon' => fa_entity( 'arrow-left' ),  'tooltip' => __( 'Left', 'cornerstone' ) )
        ),
        'condition' => array(
          'info' => array( 'popover', 'tooltip' )
        )
      )
    );

    $this->addControl(
      'info_trigger',
      'select',
      __( 'Info Trigger', 'cornerstone' ),
      __( 'Select what actions you want to trigger the popover or tooltip.', 'cornerstone' ),
      'hover',
      array(
        'choices' => array(
          array( 'value' => 'hover', 'label' => __( 'Hover', 'cornerstone' ) ),
          array( 'value' => 'click', 'label' => __( 'Click', 'cornerstone' ) ),
          array( 'value' => 'focus', 'label' => __( 'Focus', 'cornerstone' ) )
        ),
        'condition' => array(
          'info' => array( 'popover', 'tooltip' )
        )
      )
    );

    $this->addControl(
      'info_content',
      'text',
      __( 'Info Content', 'cornerstone' ),
      __( 'Extra content for the popover.', 'cornerstone' ),
      '',
      array(
        'condition' => array(
          'info' => array( 'popover', 'tooltip' )
        )
      )
    );

    // $this->addControl(
    //   'lightbox_thumb',
    //   'image',
    //   __( 'Lightbox Thumbnail', 'cornerstone' ),
    //   __( 'Use this option to select a thumbnail for your lightbox thumbnail navigation or to set an image if you are linking out to a video.', 'cornerstone' ),
    //   ''
    // );

    // $this->addControl(
    //   'lightbox_video',
    //   'toggle',
    //   __( 'Lightbox Video', 'cornerstone' ),
    //   __( 'Select if you are linking to a video from this button in the lightbox.', 'cornerstone' ),
    //   false
    // );

    // $this->addControl(
    //   'lightbox_caption',
    //   'text',
    //   __( 'Lightbox Caption', 'cornerstone' ),
    //   __( 'Lightbox caption text.', 'cornerstone' ),
    //   ''
    // );

  }

  public function render( $atts ) {

    extract( $atts );

    $href_target = ( $href_target == 'true' ) ? 'blank' : '';
    $icon_only = 'false';

    if ( $icon_toggle == 'true' ) {

      $icon_placement_class = '';

      if ( $icon_placement == 'notext' ) {
        $icon_placement_class = ' class="man"';
      } elseif ( $icon_placement == 'before' ) {
        $icon_placement_class = ' class="mvn mln mrs"';
      } elseif ( $icon_placement == 'after' ) {
        $icon_placement_class = ' class="mvn mls mrn"';
      } else {
        $icon_placement_class = '';
      }

      $icon_markup = "[x_icon type=\"{$icon_type}\"{$icon_placement_class}]";

      if ( $icon_placement == 'notext' ) {
        $icon_only = 'true';
        $content = $icon_markup;
      } elseif ( $icon_placement == 'before' ) {
        $content = $icon_markup . $content;
      } elseif ( $icon_placement == 'after' ) {
        $content .= $icon_markup;
      }
    }

    $shape = ( $shape != 'global' ) ? " shape=\"$shape\"" : '';
    $type  = ( $type  != 'global' ) ? " type=\"$type\"" : '';
    $size  = ( $type  != 'global' ) ? " size=\"$button_size\"" : '';

    $shortcode = "[x_button{$type}{$shape}{$size} block=\"$block\" circle=\"$circle\" icon_only=\"$icon_only\" href=\"$href\" title=\"$href_title\" target=\"$href_target\" info=\"$info\" info_place=\"$info_place\" info_trigger=\"$info_trigger\" info_content=\"$info_content\"{$extra}]{$content}[/x_button]";

    return $shortcode;

  }

}
