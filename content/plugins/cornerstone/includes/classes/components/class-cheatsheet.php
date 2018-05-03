<?php

class Cornerstone_Cheatsheet extends Cornerstone_Plugin_Component {

	protected $config;

	public function ajax_handler( $data ) {
		wp_send_json_success( array(
			'sheets' => $this->get_sheets( $data )
		) );
	}

	public function get_sheets( $data ) {

		if ( ! isset( $this->sheets ) ) {

			$this->config = apply_filters( 'cornerstone_cheatsheet', $this->plugin->config_group( 'builder/cheatsheet' ) );
			$this->sheets = array();

			foreach ( $this->config as $key => $value) {

				if ( ! isset( $value['title'] ) ) {
					continue;
				}

				$sheet = array(
					'id'      => $key,
					'title'   => $value['title'],
					'content' => ''
				);

				if ( isset( $value['view'] ) ) {

					$data = array( 'cheatsheat' => $this );
					$sheet['content'] = $this->view( $value['view'], false, $data, true );

				} elseif ( isset( $value['handler'] ) && is_callable( $value['handler'] ) ) {

					$sheet['content'] = call_user_func( $value['handler'], $data );

				}

				$this->sheets[] = $sheet;

			}

		}

		return $this->sheets;

	}

}
