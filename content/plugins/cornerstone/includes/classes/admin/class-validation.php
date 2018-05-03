<?php

class Cornerstone_Validation extends Cornerstone_Plugin_Component {

	public function setup() {

		if ( ! is_admin() ) return;

		add_action( 'admin_enqueue_scripts', array( $this, 'add_script_data' ), -100 );

	}

	public function add_script_data() {
		$this->plugin->component( 'Admin' )->add_script_data( 'cs-validation', array( $this, 'script_data' ) );
		$this->plugin->component( 'Admin' )->add_script_data( 'cs-validation-revoke', array( $this, 'script_data_revoke' ) );
	}

	public function script_data() {
		return array(
			'verifying'   => csi18n('admin.validation-verifying'),
			'error'       => csi18n('admin.validation-couldnt-verify'),
			'notices'     => array(
				'validation-complete' => csi18n('admin.validation-congrats'),
			),
			'errorButton' => csi18n('admin.validation-go-back'),
		);
	}

	public function script_data_revoke() {
		return array(
			'confirm'  => csi18n('admin.validation-revoke-confirm'),
			'accept'   => csi18n('admin.validation-revoke-accept'),
			'decline'  => csi18n('admin.validation-revoke-decline'),
			'revoking' => csi18n('admin.validation-revoking'),
			'notices'  => array(
				'validation-revoked' => sprintf( csi18n('admin.validation-revoked'), 'https://theme.co/apex/licenses/' )
			)
		);
	}

	public function ajax_validation() {

		if ( ! current_user_can( 'manage_options' ) || ! isset( $_POST['code'] ) || ! $_POST['code'] ) {
			wp_send_json_error( array( 'message' => 'No purchase code specified.' ) );
		}

		$this->code = sanitize_text_field( $_POST['code'] );
		$validator = new TCO_Validator( $this->code, 'cornerstone' );

		$validator->run();

		if ( $validator->has_connection_error() ) {
			wp_send_json_error( array( 'message' => $validator->connection_error_details() ) );
		}

		$response = $this->get_validation_response( $validator );

		if ( isset( $response['complete'] ) && $response['complete'] ) {
			$this->update_validation( $this->code );
		} else {
			$this->update_validation( false );
		}

		wp_send_json_success( $response );

	}

	public function get_validation_response( $validator ) {

		// Purchase code is not valid
		if ( ! $validator->is_valid() ) {
			return array(
				'message' => csi18n('admin.validation-msg-invalid'),
				'button'  => csi18n('admin.validation-go-back'),
				'dismiss' => true,
			);
		}

		// Valid, but the purchase code isn't associated with an account.
		if ( ! $validator->is_verified() ) {
      return array(
        'message' => csi18n('admin.validation-msg-new-code'),
        'button'  => csi18n('admin.validation-login'),
        'url'     => add_query_arg( $this->out_params(), 'https://theme.co/apex/product-validation/' )
      );
    }

    // Purchase code linked to an account, but doesn't have a site
    if ( ! $validator->has_site() ) {
      return array(
        'message' => csi18n('admin.validation-msg-cant-link'),
        'button'  => csi18n('admin.validation-manage-licenses'),
        'url'     => 'https://theme.co/apex/licenses/',
        'dismiss' => true,
        'newTab'  => true
      );
    }

    // Purchase code linked, and site exists, but doesn't match this site.
    if ( ! $validator->site_match() ) {
      return array(
        'message' => csi18n('admin.validation-msg-in-use'),
        'button'  => csi18n('admin.validation-manage-licenses'),
        'url'     => 'https://theme.co/apex/licenses/',
        'dismiss' => true,
        'newTab'  => true
      );
    }

    return array(
      'complete' => true,
      'message' => csi18n('admin.validation-congrats')
    );

  }

  public function out_params() {
    return array(
      'code'        => $this->code,
      'product'     => 'cornerstone',
      'siteurl'     => cs_tco()->get_site_url(),
      'return-url'  => esc_url( admin_url( 'admin.php?page=cornerstone-home' ) )
    );
  }

  public function ajax_revoke() {

  	if ( ! current_user_can( 'manage_options' ) ) {
  		wp_send_json_error();
  	}

    $this->update_validation( false );
    wp_send_json_success();

  }

  public function update_validation( $code ) {

    if ( $code ) {
      update_option( 'cs_product_validation_key', $code );
    } else {
      delete_option( 'cs_product_validation_key' );
    }

    cs_tco()->updates()->refresh();

  }

  public function preload_key() {
    $key = '';
    if ( isset( $_REQUEST['tco-key'] ) ) {
      $key = esc_html( $_REQUEST['tco-key'] );
    }
    return $key;
  }

}
