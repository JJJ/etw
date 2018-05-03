<?php

/**
 * This class manages loading and delegating both
 * offically supported and 3rd party integrations.
 */

class Cornerstone_Integration_Manager extends Cornerstone_Plugin_Component {

	private $registry;
	private $instances;
	private $themes;

	/**
	 * Defer until plugins are loaded
	 */
	public function setup() {

		$this->register_native_integrations();

		if ( did_action('plugins_loaded') ) {
			$this->load();
		} else {
			add_action( 'plugins_loaded', array( $this, 'load' ) );
		}

		add_action( 'after_setup_theme', array( $this, 'load_theme' ) );

	}

	/**
	 * Load all integrations
	 */
	public function load() {

		/*
		 * Allow integrations to be registered in plugins.
		 */
		do_action( 'cornerstone_integrations' );

		/**
		 * Process the registry. Instantiate any integrations whose shouldLoad method passes.
		 */
		foreach ($this->registry as $handle => $class_name) {

			if ( is_callable( array( $class_name, 'stylesheet' ) ) ) {
				$this->themes[ $handle ] = $class_name;
				continue;
			}

			$should_load = array( $class_name, 'should_load' );

			if ( is_callable( $should_load ) && ! call_user_func( $should_load )) {
				continue;
			}

			$this->instances[ $handle ] = new $class_name;

		}

	}

	/**
	 * Directly add a class for theme integration by its stylesheet
	 */
	public function load_theme() {

		foreach ($this->registry as $handle => $class_name) {

			$stylesheet = array( $class_name, 'stylesheet' );

			if ( ! class_exists( $class_name ) || ! is_callable( $stylesheet ) ) {
				continue;
			}

			$current_theme = get_stylesheet();
			if ( is_child_theme() ) {
				$child_theme = wp_get_theme();
				$current_theme = $child_theme->Template;
			}

      $valid_stylesheets = call_user_func( $stylesheet );
      if ( ! is_array( $valid_stylesheets ) ) {
        $valid_stylesheets = array( $valid_stylesheets );
      }

      foreach ($valid_stylesheets as $valid_stylesheet ) {
        if ( $valid_stylesheet === $current_theme ) {
  				$this->instances[ $handle ] = new $class_name;
          $theme_setup = array( $this->instances[ $handle ], 'theme_setup' );
          if ( is_callable( $theme_setup ) ) {
            call_user_func($theme_setup, $valid_stylesheet);
          }
  				break;
  			}
      }

		}

	}

	/**
	 * Register integrations included with Cornerstone
	 * @return none
	 */
	public function register_native_integrations() {

		$this->registry = array();
		$this->themes = array();

		$path = $this->path( 'includes/integrations/' );

		foreach ( glob( "$path*.php" ) as $filename ) {

			if ( ! file_exists( $filename ) ) {
				continue;
			}

			require_once( $filename );
			$handle = str_replace( '.php', '', basename( $filename ) );

			$words = explode( '-', $handle );
			foreach ( $words as $key => $value) {
				$words[ $key ] = ucfirst( $value );
			}

			$this->registry[ $handle ] = 'Cornerstone_Integration_' . implode( '_', $words );

			$pre_init = array( $this->registry[ $handle ], 'pre_init' );

			if ( is_callable( $pre_init ) ) {
				call_user_func( $pre_init );
			}

		}

	}

	/**
	 * Register an Integration. This will store an object reference in our registry
	 * @param string $name       Unique handle to store the item under
	 * @param string $class_name Class being used
	 */
	public function register( $name, $class_name ) {
		$this->registry[ $name ] = $class_name;
	}

	/**
	 * Register an Integration. This will store an object reference in our registry
	 * @param string $name       Unique handle to store the item under
	 * @param string $class_name Class being used
	 */
	public function unregister( $name ) {
		if ( isset( $this->registry[ $name ] ) ) {
			unset( $this->registry[ $name ] );
		}
	}

	/**
	 * Get a specific integration instance, or all of them
	 * Defaults to returning all, unless an id is provided
	 * @param  string $id
	 * @return obj|array
	 */
	public function get( $id = '' ) {
		if ( isset( $this->instances[ $id ] ) ) {
			return $this->instances[ $id ];
		}
		return $this->instances;
	}

	/**
	 * Setup theme integration filters. See includes/utility/api.php
	 * @param  array $args A list of flags specifying if they should be disabled.
	 * @return none
	 */
	public function theme_integration( $args ) {

		$args = cs_define_defaults( $args, array(
			'remove_global_validation_notice' => false,
			'remove_themeco_offers'           => false,
			'remove_purchase_link'            => false,
			'remove_support_box'              => false,
		) );

		foreach ( $args as $key => $value ) {
			if ( $value ) {
				add_filter( "_cornerstone_integration_$key", '__return_true' );
			}
		}

	}

}
