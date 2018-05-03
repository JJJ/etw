<?php

class CS_Social_Sharing extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'social-sharing',
      'title'       => __('Social Sharing', 'cornerstone' ),
      'section'     => 'social',
      'description' => __( 'Social Sharing description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'protected_keys' => array( 'title', 'content' ),
      'protected_keys' => array( 'heading', 'share_title', 'email_subject' )
    );
  }

  public function controls() {

    $this->addControl(
      'heading',
      'text',
      __( 'Title', 'cornerstone' ),
      __( 'Enter in a title for your social links.', 'cornerstone' ),
      __( 'Share this Post', 'cornerstone' )
    );

    $this->addControl(
      'share_title',
      'text',
      __( 'Share Title', 'cornerstone' ),
      __( 'Enter in the title that displays when you share the page. The default is the Page title.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'facebook',
      'toggle',
      __( 'Facebook', 'cornerstone' ),
      __( 'Select to activate the Facebook sharing link.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'twitter',
      'toggle',
      __( 'Twitter', 'cornerstone' ),
      __( 'Select to activate the Twitter sharing link.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'google_plus',
      'toggle',
      __( 'Google Plus', 'cornerstone' ),
      __( 'Select to activate the Google Plus sharing link.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'linkedin',
      'toggle',
      __( 'LinkedIn', 'cornerstone' ),
      __( 'Select to activate the LinkedIn sharing link.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'pinterest',
      'toggle',
      __( 'Pinterest', 'cornerstone' ),
      __( 'Select to activate the Pinterest sharing link.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'reddit',
      'toggle',
      __( 'Reddit', 'cornerstone' ),
      __( 'Select to activate the Reddit sharing link.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'email',
      'toggle',
      __( 'Email', 'cornerstone' ),
      __( 'Select to activate the email sharing link.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'email_subject',
      'text',
      __( 'Email Subject', 'cornerstone' ),
      __( 'Enter the email subject when sharing the link.', 'cornerstone' ),
      __( 'Hey, thought you might enjoy this! Check it out when you have a chance:', 'cornerstone' ),
      array(
        'condition' => array(
          'email' => true
        )
      )
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $email_subject = cs_clean_shortcode_att( $email_subject );

    $shortcode = "[x_share title=\"$heading\" share_title=\"$share_title\" facebook=\"$facebook\" twitter=\"$twitter\" google_plus=\"$google_plus\" linkedin=\"$linkedin\" pinterest=\"$pinterest\" reddit=\"$reddit\" email=\"$email\" email_subject=\"$email_subject\"{$extra}]";

    return $shortcode;

  }

}
