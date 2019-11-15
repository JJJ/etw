<?php

class CS_Prompt extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'prompt',
      'title'       => __( 'Prompt', 'cornerstone' ),
      'section'     => 'marketing',
      'description' => __( 'Prompt description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'autofocus' => array(
    		'heading' => '.h-prompt',
    		'message' => '.p-prompt',
    		'button_text' => '.x-btn',
    	),
      'protected_keys' => array( 'heading', 'message', 'button_text', 'button_icon', 'href', 'href_title', 'href_target' )
    );
  }

  public function controls() {

    $this->addControl(
      'heading',
      'text',
      __( 'Title ', 'cornerstone' ),
      __( 'Enter the title for your Prompt.', 'cornerstone' ),
      __( 'Prompt Title', 'cornerstone' )
    );

    $this->addControl(
      'message',
      'textarea',
      __( 'Content', 'cornerstone' ),
      __( 'Enter the content for your Prompt.', 'cornerstone' ),
      __( 'This is where the main content for your Prompt can go.', 'cornerstone' ),
      array(
        'expandable' => __( 'Content', 'cornerstone' )
      )
    );

    $this->addControl(
      'button_text',
      'text',
      __( 'Button Text', 'cornerstone' ),
      __( 'Enter the text for your Prompt button.', 'cornerstone' ),
      __( 'Click Me!', 'cornerstone' )
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
      __( 'Select to include a marketing circle around your button', 'cornerstone' ),
      false
    );

    $this->addSupport( 'link' );

    $this->addControl(
      'align',
      'choose',
      __( 'Alignment', 'cornerstone' ),
      __( 'Select the alignment of your Prompt.', 'cornerstone' ),
      'left',
      array(
        'columns' => '2',
        'choices' => array(
          array( 'value' => 'left',  'label' => __( 'Left', 'cornerstone' ),  'icon' => fa_entity( 'align-left' ) ),
          array( 'value' => 'right', 'label' => __( 'Right', 'cornerstone' ), 'icon' => fa_entity( 'align-right' ) )
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
    $href       = cs_clean_shortcode_att( $href );
    $href_title = cs_clean_shortcode_att( $href_title );

    $shortcode = "[x_prompt type=\"$align\" title=\"$heading\" message=\"$message\" button_text=\"$button_text\" button_icon=\"$button_icon\" circle=\"$circle\" href=\"$href\" href_title=\"$href_title\" target=\"$href_target\"{$extra}]";

    return $shortcode;

  }

}
