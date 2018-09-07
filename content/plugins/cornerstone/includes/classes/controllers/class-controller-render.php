<?php

class Cornerstone_Controller_Render extends Cornerstone_Plugin_Component {

  public function elements( $data ) {

    if ( ! isset( $data['batch'] ) ) {
      return array();
    }

    $renderer = $this->plugin->component( 'Element_Renderer' );
    $renderer->start( isset($data['context']) ? $data['context'] : array() );
    $this->plugin->component('Font_Manager')->set_previewing();
    $batch = array();
    $cached = array();

    foreach ($data['batch'] as $index => $value) {

      $hash = $value['data']['hash'];

      if ( ! isset( $cached[$hash] ) ) {
        $cached[$hash] = $renderer->render_element( $value['data']['model'] );
      }

      $batch[] = array(
        'response' => $cached[$hash],
        'hash'     => $hash,
        'ts'       => $value['data']['ts'],
        'type'     => isset($value['data']['model']['_type']) ? $value['data']['model']['_type'] : null,
        'jobID'    => $value['jobID']
      );

    }

    $extractions = $renderer->get_extractions();
    $renderer->end();

    return array(
      'batch' => $batch,
      'extractions' => $extractions,
      'debug' => $renderer->enqueue_extractor->counter
    );
  }

}
