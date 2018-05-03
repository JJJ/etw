<?php

class Cornerstone_Controller_Render extends Cornerstone_Plugin_Component {

  public function elements( $data ) {

    if ( ! isset( $data['batch'] ) ) {
      return array();
    }

    $renderer = $this->plugin->loadComponent( 'Element_Renderer' );
    $renderer->start( isset($data['context']) ? $data['context'] : array() );
    $this->plugin->loadComponent('Font_Manager')->set_previewing();

    foreach ($data['batch'] as $key => $value) {
      $data['batch'][$key]['response'] = $renderer->render_element( $value['data'] );
      $data['batch'][$key]['response']['hash'] = $value['data']['hash'];
      $data['batch'][$key]['response']['timestamp'] = $value['data']['timestamp'];
    }

    $extractions = $renderer->get_extractions();
    $renderer->end();

    return array(
      'batch' => $data['batch'],
      'extractions' => $extractions,
      'debug' => $renderer->enqueue_extractor->counter
    );
  }

}
