<?php

class Cornerstone_Controller_Element_Migration extends Cornerstone_Plugin_Component {

  public function migrate_elements( $data ) {

    if ( !isset( $data['elements'] ) ) {
      return new WP_Error( 'cornerstone', 'Elements missing.' );
    }

		$version = isset( $data['version'] ) ? $data['version'] : 0;

		$migrated = $this->plugin->loadComponent('Element_Migrations')->migrate_classic( $data['elements'], $version );

		if ( is_wp_error( $migrated ) ) {
      return $migrated;
    }

		return array( 'elements' => $migrated );

  }

}
