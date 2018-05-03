<?php

if ( ! function_exists('cornerstone_boot') ) {

  function cornerstone_boot( $root, $i18n_path = '', $url = '' ) {

    if ( class_exists('CS') ) {
      return;
    }

    $path = dirname($root);
    require_once "$path/includes/utility/plugin-base.php";
    require_once "$path/includes/cornerstone-plugin.php";

    Cornerstone_Plugin::run( $root, $i18n_path, trailingslashit($path), $url );

  }

}
