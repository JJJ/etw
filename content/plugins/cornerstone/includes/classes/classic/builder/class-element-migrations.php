<?php

/**
 * Access to Cornerstone data
 */
class Cornerstone_Element_Migrations  extends Cornerstone_Plugin_Component {

	protected $orchestrator;

	public function setup() {
		$this->orchestrator = $this->plugin->loadComponent( 'Element_Orchestrator' );
	}

	public function migrate_classic( $elements, $version = 0 ) {

		// Skip migrations if we are working with up to date elements.
		if ( ! is_array( $elements ) || version_compare( $this->plugin->version(), $version,'<' ) ) {
			return $elements;
		}

		$this->orchestrator->load_elements();

		foreach ($elements as $key => $element) {
			$elements[$key] = $this->migrate_classic_element( $element, $version );
		}

		return $elements;
	}

	public function migrate_classic_element( $element, $version ) {

		$element = $this->common_classic_migrations( $element, $version );

		$definition = $this->orchestrator->get( $element['_type'] );

		if ( isset( $element['elements'] ) ) {
      $element['_modules'] = array();
			foreach ( $element['elements'] as $index => $child ) {
				$element['_modules'][$index] = $this->migrate_classic_element( $child , $version );
			}
      unset($element['elements']);
		}

		return $definition->migrate( $element, $version );

	}

	public function common_classic_migrations( $element, $version ) {

		if ( version_compare( $version, '1.1.1', '<' ) ) {

			// Ensure '_type' is set
			if ( isset( $element['elType'] ) ) {
				$element['_type'] = $element['elType'];
				unset($element['elType']);
			}

			if ( 'section' === $element['_type'] && isset($element['section_base_font_size']) ) {
				return $element;
			}

			if ( !isset( $element['_type'] ) ) {
				$element['_type'] = 'classic:undefined';
			}

      if ( false === strpos($element['_type'], 'classic:' ) ) {
        $element['_type'] = 'classic:' . $element['_type'];
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
			if ( 'classic:row' == $element['_type'] && isset( $element['columnLayout'] ) ) {
				$element['_column_layout'] = $element['columnLayout'];
				unset($element['columnLayout']);
			}

			if ( 'classic:column' == $element['_type'] && isset( $element['active'] ) ) {
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

}
