<?php
class Cornerstone_Save_Handler extends Cornerstone_Plugin_Component {

	public function ajax_handler( $data ) {

		if ( ! isset( $data['elements'] ) || ! is_array( $data['elements'] )  ) {
			return cs_send_json_error( array( 'message' => 'Element data invalid' ) );
		}

		if ( ! isset( $data['settings'] ) || ! is_array( $data['settings'] ) ) {
			return cs_send_json_error( array( 'message' => 'Setting data invalid' ) );
		}

		if ( ! isset( $data['id'] ) ) {
			return cs_send_json_error( array( 'message' => 'post id not set' ) );
		}

    // Do we need setup_postdata?
    global $post;
		$post = get_post( (int) $data['id'] ); // WPCS: override ok.
		setup_postdata( $post );

    if ( ! $post ) {
			return cs_send_json_error( array( 'message' => 'Invalid post' ) );
		}

		$cap = $this->plugin->common()->get_post_capability( $post, 'edit_post' );
		if ( ! current_user_can( $cap, $data['id'] ) ) {
			return cs_send_json_error( array( 'message' => sprintf( '%s capability required.', $cap ) ) );
		}

    $content = new Cornerstone_Content( $data['id'] );

    $content->set_elements( $data['elements'] );
    $content->set_settings( $data['settings'] );

    try {
      $content->save();
    } catch ( Exception $e ) {
      return cs_send_json_error( array( 'message' => $e->getMessage() ) );
    }

		return cs_send_json_success();

	}

}
