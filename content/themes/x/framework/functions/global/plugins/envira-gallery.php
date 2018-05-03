<?php

// =============================================================================
// FUNCTIONS/GLOBAL/PLUGINS/ENVIRA-GALLERY.PHP
// -----------------------------------------------------------------------------
// Plugin setup for theme compatibility.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Hide License Functionality
// =============================================================================

// Hide License Functionality
// =============================================================================

function x_envira_gallery_hide_key_box() { ?>
  <style>
    #envira-settings-key-box {
      display: none;
    }
  </style>
  <?php
}

add_action( 'envira_gallery_admin_styles', 'x_envira_gallery_hide_key_box' );


function x_envira_gallery_hide_license_errors() { ?>
  <script>
    jQuery(function($){
      $('.error p:contains(Envira Gallery)').parent().remove();
    });
  </script>
  <?php
}

add_action( 'admin_print_scripts', 'x_envira_gallery_hide_license_errors', 20 );
