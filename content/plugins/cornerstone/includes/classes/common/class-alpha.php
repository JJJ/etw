<?php

/**
 * This component exists to allow feature flagging in Cornerstone development.
 */

class Cornerstone_Alpha extends Cornerstone_Plugin_Component {

	public function setup() {
    add_filter( '_cornerstone_alpha', '__return_true' );
		add_filter( 'cornerstone_config_builder_keybindings', array( $this, 'keybindings' ) );
		add_filter( 'cornerstone_config_data', array( $this, 'builder_config' ) );
		add_action( 'cornerstone_load_builder', array( $this, 'load_builder' ) );
	}

	public function load_builder() {
		add_filter( 'body_class', array( $this, 'builder_body_class' ) );
	}

	public function builder_body_class( $classes ) {
		$classes[] = 'cs-alpha';
	  return $classes;
	}

	public function keybindings( $bindings ) {
		return array_merge( $bindings, $this->plugin->config_group( 'alpha/keybindings' ) );
	}

	public function builder_config( $config ) {
		$config['alpha'] = true;
		return $config;
	}
}
