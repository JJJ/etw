<?php

class CS_Google_Map extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'google-map',
      'title'       => __( 'Google Map', 'cornerstone' ),
      'section'     => 'media',
      'description' => __( 'Google Map description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'renderChild' => true,
      'protected_keys' => array( 'api_key', 'lat', 'lng' )
    );
  }

  public function controls() {

    $this->addControl(
      'elements',
      'sortable',
      __( 'Map Markers', 'cornerstone' ),
      __( 'Optionally include markers to your map to specify certain locations.', 'cornerstone' ),
      NULL,
      array(
      	'element'   => 'google-map-marker',
        'newTitle' => __( 'Map Marker %s', 'cornerstone' )
      )
    );

    $this->addControl(
      'api_key',
      'text',
      __( 'Google API Key', 'cornerstone' ),
      __( 'Optionally provide a Browser key from your Google developer console.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'lat',
      'text',
      __( 'Latitude', 'cornerstone' ),
      __( 'Enter the latitude for the center of your map.', 'cornerstone' ),
      '40.7056308'
    );

    $this->addControl(
      'lng',
      'text',
      __( 'Longitude', 'cornerstone' ),
      __( 'Enter the longitude for the center of your map.', 'cornerstone' ),
      '-73.9780035'
    );

    $this->addControl(
      'zoom',
      'number',
      __( 'Zoom', 'cornerstone' ),
      __( 'Specify a number between 1 and 18 for the zoom level of your map.', 'cornerstone' ),
      '12'
    );

    $this->addControl(
      'zoom_control',
      'toggle',
      __( 'Zoom Control', 'cornerstone' ),
      __( 'Enable to display the zoom controls for your map.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'drag',
      'toggle',
      __( 'Draggable', 'cornerstone' ),
      __( 'Enable to make your map draggable.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'height',
      'text',
      __( 'Height', 'cornerstone' ),
      __( 'Specify a custom height for your map if desired. You may use pixels, ems, or percentages.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'hue',
      'color',
      __( 'Map Hue', 'cornerstone' ),
      __( 'Specifying a hexadecimal map hue will give your map a different color palette.', 'cornerstone' ),
      false,
      array(
        'output_format' => 'hex'
      )
    );

    $this->addControl(
      'no_container',
      'toggle',
      __( 'No Container', 'cornerstone' ),
      __( 'Select to remove the container around the map.', 'cornerstone' ),
      false
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $elements = ( isset( $elements ) ) ? $elements : array();
    $contents = '';

    foreach ( $elements as $e ) {

      $contents .= '[x_google_map_marker lat="' . $e['lat'] . '" lng="' . $e['lng'] . '" start_open="' . $e['start_open'] .'" info="' . cs_clean_shortcode_att( $e['info'] ) . '" image="' . $e['image'] . '"]';

    }

    $shortcode = "[x_google_map api_key=\"$api_key\" lat=\"{$lat}\" lng=\"{$lng}\" zoom=\"{$zoom}\" zoom_control=\"{$zoom_control}\" drag=\"{$drag}\" height=\"{$height}\" hue=\"{$hue}\" no_container=\"{$no_container}\" {$extra}]{$contents}[/x_google_map]";

    return $shortcode;

  }

}
