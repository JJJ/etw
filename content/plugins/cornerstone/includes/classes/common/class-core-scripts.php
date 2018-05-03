<?php

/**
 * Manage all the front end code for Cornerstone
 * including shortcode styling and scripts
 */

class Cornerstone_Core_Scripts extends Cornerstone_Plugin_Component {

	/**
	 * Setup hooks
	 */
	public function setup() {
		add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ), -100 );
	}

	public function register_scripts() {

		$orchestrator = $this->plugin->component( 'Element_Orchestrator' );

		// Register
		wp_register_script(
			'cs-core',
			$this->plugin->js( 'admin/core' ),
			array( 'backbone' ),
			$this->plugin->version(),
			true
		);

		$definitions = cs_memoize( '_cornerstone_element_definitions', array( $orchestrator, 'getModels' ), 15 );

		$icon_maps = wp_parse_args( array(
			'elements' => add_query_arg( array( 'v' => $this->plugin->version() ), $this->plugin->url('assets/dist-app/svg/elements.svg') ),
			'interface' => add_query_arg( array( 'v' => $this->plugin->version() ), $this->plugin->url('assets/dist-app/svg/interface.svg') ),
		), apply_filters( 'cornerstone_icon_map', array() ) );

		wp_localize_script( 'cs-core', 'csCoreData', cs_booleanize( array(
			'ajaxUrl' => $this->plugin->component( 'Router' )->get_ajax_url(),
			'fallbackAjaxUrl' => $this->plugin->component( 'Router' )->get_fallback_ajax_url(),
			'useLegacyAjax' => $this->plugin->component( 'Router' )->use_legacy_ajax(),
			'debug' => ( $this->plugin->common()->isDebug() ),
			'elementDefinitions' => $definitions,
			'isRTL' => is_rtl(),
			'strings' => array( 'test' => 'test' ),
			'_cs_nonce' => wp_create_nonce( 'cornerstone_nonce' ),
			'unfilteredHTML' => current_user_can( 'unfiltered_html' ),
			'iconMaps' => $icon_maps
		) ) );

	}
}
