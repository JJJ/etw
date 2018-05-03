<?php

class CS_Callout extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'callout',
      'title'       => __( 'Callout', 'cornerstone' ),
      'section'     => 'marketing',
      'description' => __( 'Callout description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'autofocus' => array(
    		'heading' => '.h-callout',
				'message' => '.p-callout',
				'button_text' => '.x-btn',
    	),
      'protected_keys' => array( 'heading', 'message', 'button_text', 'button_icon', 'href', 'href_title', 'href_target' )
    );
  }

  public function controls() {

    $this->addControl(
      'heading',
      'text',
      __( 'Title &amp; Message', 'cornerstone' ),
      __( 'Enter the title and message for your Callout below.', 'cornerstone' ),
      __( 'Callout Title', 'cornerstone' )
    );

    $this->addControl(
      'message',
      'textarea',
      NULL,
      NULL,
      __( 'The message text for your Callout goes here.', 'cornerstone' ),
      array(
        'expandable' => __( 'Message', 'cornerstone' )
      )
    );

    $this->addControl(
      'button_text',
      'text',
      __( 'Button Text', 'cornerstone' ),
      __( 'Enter the text for your Callout button.', 'cornerstone' ),
      __( 'Enter Your Text', 'cornerstone' )
    );

    $this->addControl(
      'button_icon',
      'icon-choose',
      __( 'Button Icon', 'cornerstone' ),
      __( 'Optionally enter the button icon.', 'cornerstone' ),
      'lightbulb-o'
    );

    $this->addControl(
      'circle',
      'toggle',
      __( 'Marketing Circle', 'cornerstone' ),
      __( 'Select to include a marketing circle around your button.', 'cornerstone' ),
      false
    );

    $this->addSupport( 'link' );

    $this->addControl(
      'type',
      'select',
      __( 'Alignment', 'cornerstone' ),
      __( 'Select the alignment for your Callout.', 'cornerstone' ),
      'left',
      array(
        'choices' => array(
          array( 'value' => 'left',   'label' => __( 'Left', 'cornerstone' ) ),
          array( 'value' => 'center', 'label' => __( 'Center', 'cornerstone' ) ),
          array( 'value' => 'right',  'label' => __( 'Right', 'cornerstone' ) )
        )
      )
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $href_target = ( $href_target == 'true' ) ? 'blank' : '';

    $heading     = cs_clean_shortcode_att( $heading );
    $message     = cs_clean_shortcode_att( $message );
    $button_text = cs_clean_shortcode_att( $button_text );

    $shortcode = "[x_callout title=\"$heading\" message=\"$message\" type=\"$type\" button_text=\"$button_text\" circle=\"$circle\" button_icon=\"$button_icon\" href=\"$href\" href_title=\"$href_title\" target=\"$href_target\"{$extra}]";

    return $shortcode;

  }

}
