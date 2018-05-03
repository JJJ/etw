<?php

/**
 * Access to Cornerstone data
 */
class Cornerstone_Data_Controller  extends Cornerstone_Plugin_Component {

	/**
	 * WP_Post object for what is being edited
	 * @var object
	 */
	protected $post;

	protected $orchestrator;

	public function setup() {
		$this->orchestrator = $this->plugin->loadComponent( 'Element_Orchestrator' );
	}

	/**
	 * Instantiate from a post ID or a WP_Post
	 * @param string $post_id
	 */
	public function set_post( $post ) {
		$this->post = ( is_a( $post, 'WP_Post' ) ) ? $post : get_post( $post );
	}

	/**
	 * Retrieve rows from the current post.
	 * @return array  current rows
	 */
	public function get() {

		$data = cs_get_serialized_post_meta( $this->post->ID, '_cornerstone_data', true );

		if ( !is_array( $data ) )
			return $data;

		return $this->migrate( $data );

	}

	public function migrate( $elements, $version = 0 ) {

		// Skip migrations if we are working with up to date elements.
		if ( version_compare( $this->plugin->version(), $version,'<' ) )
			return $elements;

		$this->orchestrator->load_elements();

		foreach ($elements as $key => $element) {
			$elements[$key] = $this->migrate_element( $element, $version );
		}

		return $elements;
	}

	public function migrate_element( $element, $version ) {

		$element = $this->common_migrations( $element, $version );

		$definition = $this->orchestrator->get( $element['_type'] );

		if ( isset( $element['elements'] ) ) {
			foreach ( $element['elements'] as $index => $child ) {
				$element['elements'][$index] = $this->migrate_element( $child , $version );
			}
		}

		return $definition->migrate( $element, $version );

	}

	public function common_migrations( $element, $version ) {

		// MK2 Upgrade
		if ( version_compare( $version, '1.1.1', '<' ) ) {

			// Ensure '_type' is set
			if ( isset( $element['elType'] ) ) {
				$element['_type'] = $element['elType'];
				unset($element['elType']);
			}

			if ( !isset( $element['_type'] ) ) {
				$element['_type'] = 'undefined';
			}

			// Assign '_type' per element for children, and remove parent 'childType'
			if ( isset( $element['childType'] ) ) {
				if ( $element['childType'] != 'any' && isset( $element['elements'] ) ) {
					foreach ( $element['elements'] as $index => $child ) {
						$element['elements'][$index]['_type'] = $element['childType'];
					}
				}
				unset( $element['childType'] );
			}

			// Some quick inline layout migrations instead of checking the version for every individual element
			if ( 'row' == $element['_type'] && isset( $element['columnLayout'] ) ) {
				$element['_column_layout'] = $element['columnLayout'];
				unset($element['columnLayout']);
			}

			if ( 'column' == $element['_type'] && isset( $element['active'] ) ) {
				$element['_active'] = $element['active'];
				unset($element['active']);
			}

			if ( isset( $element['custom_id'] ) ) {
				$element['id'] = $element['custom_id'];
				unset($element['custom_id']);
			}

			if ( isset( $element['border'] ) ) {
				if ( !isset( $element['border_width'] ) ) {
					$element['border_width'] = $element['border'];
				}
				unset( $element['border'] );
			}

		}

		// Remap old visibility
		if ( isset( $element['visibility'] ) && is_array( $element['visibility'] ) ) {
			foreach ( $element['visibility'] as $key => $value) {
				$element['visibility'][$key] = str_replace( 'x-hide-', '', $value );
			}
		}

		// Remap old text align
		if ( isset( $element['text_align'] ) ) {
			$ta_migrate = array( 'left-text' => 'l', 'center-text' => 'c', 'right-text' => 'r', 'justify-text' => 'j' );
			if ( isset( $ta_migrate[ $element['text_align'] ] ) ) {
				$element['text_align'] = $ta_migrate[ $element['text_align'] ];
			}
		}

		return $element;

	}

	public function get_elements( $post = '') {
		$this->set_post( CS()->common()->locatePost( $post ) );
		return $this->get();
	}

}