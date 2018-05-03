<?php

class Cornerstone_CLI extends Cornerstone_Plugin_Component {

  public function setup() {

    if ( ! class_exists( 'WP_CLI' ) ) {
      return;
    }

    WP_CLI::add_command( 'cs headers', 'Cornerstone_CLI_Headers' );

  }
}
