<?php

class CS_Google_Map_Marker extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'google-map-marker',
      'title'       => __( 'Google Map Marker', 'cornerstone' ),
      'section'     => '_media',
      'description' => __( 'Google Map Marker description.', 'cornerstone' ),
      'render'      => false,
      'delegate'    => true,
      'protected_keys' => array( 'title', 'lat', 'lng', 'info', 'image' )
    );
  }

  public function controls() {

    $this->addControl(
      'title',
      'title',
      NULL,
      NULL,
      ''
    );

    $this->addControl(
      'lat',
      'text',
      __( 'Latitude', 'cornerstone' ),
      __( 'Enter the latitude for your map marker.', 'cornerstone' ),
      '40.7056308'
    );

    $this->addControl(
      'lng',
      'text',
      __( 'Longitude', 'cornerstone' ),
      __( 'Enter the longitude for your map marker.', 'cornerstone' ),
      '-73.9780035'
    );

    $this->addControl(
      'info',
      'text',
      __( 'Text', 'cornerstone' ),
      __( 'Enter in optional text to appear if your map marker is hovered over.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'start_open',
      'toggle',
      __( 'Start Open', 'cornerstone' ),
      __( 'Toggle if the marker info should be open by default.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'image',
      'image',
      __( 'Image', 'cornerstone' ),
      __( 'Upload an optional alternate image to use in place of the standard map marker.', 'cornerstone' ),
      ''
    );

  }

  // public function render( $atts ) {

  //   extract( $atts );

  //   $extra = $this->extra( array(
  //     'id'    => $id,
  //     'class' => $class,
  //     'style' => $style
  //   ) );

  //   $shortcode = "[x_google_map_marker lat=\"{$lat}\" lng=\"{$lng}\" info=\"{$info}\" image=\"{$image}\"]";

  //   return $shortcode;

  // }

}
