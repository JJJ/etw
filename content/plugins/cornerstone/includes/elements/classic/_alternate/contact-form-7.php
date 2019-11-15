<?php

class CS_Contact_Form_7 extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'contact-form-7',
      'title'       => __( 'Contact Form 7', 'cornerstone' ),
      'section'     => 'content',
      'description' => __( 'Contact Form 7 description.', 'cornerstone' ),
      'empty'       => array( 'form_id' => 'none' ),
      'undefined_message' => __('This element can not render because Contact Form 7 is not active.', 'cornerstone' ),
      'protected_keys' => array( 'form_id' )
    );
  }

  public function controls() {

    $items = array();
    $choices = array();

    if ( $this->is_active() ) {
      $items = WPCF7_ContactForm::find();
    }

    foreach ($items as $item) {
      $choices[] = array( 'value' => $item->id(),  'label' => $item->title() );
    }

    if ( empty( $choices ) ) {
      $choices[] = array( 'value' => 'none', 'label' => __( 'No Forms available', 'cornerstone' ), 'disabled' => true );
    }

    $this->addControl(
      'form_id',
      'select',
      __( 'Select Contact Form', 'cornerstone' ),
      __( 'Select a previously created form.', 'cornerstone' ),
      $choices[0]['value'],
      array(
        'choices' => $choices,
        'placeholder' => 'Select'
      )
    );

  }

  public function is_active() {
    return class_exists( 'WPCF7_ContactForm' );
  }

  public function render( $atts ) {

    extract( $atts );
    $shortcode = '';

    // Hookup the shortcode
    if ( $this->is_active() ) {
      $items = WPCF7_ContactForm::find( array( 'p' => $form_id ) );
    }

    if ( !empty( $items ) ) {
      $item = $items[0];
      $shortcode = sprintf( '[contact-form-7 id="%1$d" title="%2$s"]', $item->id(), $item->title() );
    }

    return $shortcode;

  }

}
