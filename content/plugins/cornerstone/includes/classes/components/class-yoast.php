<?php

class Cornerstone_Yoast extends Cornerstone_Plugin_Component {

  public function ajax_yoast_do_shortcode( $data ) {

		if ( ! current_user_can( 'manage_options' ) || ! isset($data['content']) ) {
			return cs_send_json_error();
		}

    $content = array();

    foreach ($data['content'] as $shortcodes) {
      $content[] = do_shortcode( wp_unslash( $shortcodes ) );
    }

		return cs_send_json_success( array( 'content' => $content ) );

	}

}
