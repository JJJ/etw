<?php

class Cornerstone_Controller_App_Boot extends Cornerstone_Plugin_Component {

  public function boot_data( $data ) {

    $result = $this->get_preload_data();

    if ( isset( $data['state'] ) ) {
      foreach ( $data['state'] as $key => $value ) {
        $parts = explode(':', $key);
        $group = $parts[0];
        $id = $parts[1];
        if (isset($result[$group]) &&
          isset($result[$group][$id]) &&
          $result[$group][$id][0] === $value) {
            $result[$group][$id] = array( $value ); // don't send values that didn't change
        }
      }
    }

    return $result;
  }

  public function get_preload_data() {

    $this->plugin->component('Font_Manager');
    $this->plugin->component('Color_Manager');

    $font_data = apply_filters( 'cs_font_data', $this->plugin->config_group( 'common/font-data' ) );

    return array(
      'common' => array(
        'font_awesome' => $this->sign_preload( $this->plugin->common()->getFontIconsData() ),
        'font_data'    => $this->sign_preload( $font_data ),
      ),
      'models' => array(
        'elements'    => $this->sign_preload( $this->plugin->component('Model_Element_Definition')->query(array())),
        'preferences' => $this->sign_preload( $this->plugin->component('Model_Preference')->query( array('query' => array( 'id' => get_current_user_id() ) ) ) ),
        'fontItems'   => $this->sign_preload( $this->plugin->component('Model_Option')->query( array('query' => array( 'id' => 'cornerstone_font_items' ) ) ) ),
        'fontConfig'  => $this->sign_preload( $this->plugin->component('Model_Option')->query( array('query' => array( 'id' => 'cornerstone_font_config' ) ) ) ),
        'colorItems'  => $this->sign_preload( $this->plugin->component('Model_Option')->query( array('query' => array( 'id' => 'cornerstone_color_items' ) ) ) )
      )
    );
  }

  public function sign_preload( $data ) {

    $content = json_encode( $data );

    if ( function_exists('gzcompress') ) {
      $content = base64_encode( gzcompress( $content, 9 ) );
    }

    return array( md5($content), $content );
  }

}
