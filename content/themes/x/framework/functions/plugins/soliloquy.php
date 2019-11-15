<?php

// =============================================================================
// FUNCTIONS/GLOBAL/PLUGINS/SOLILOQUY.PHP
// -----------------------------------------------------------------------------
// Plugin setup for theme compatibility.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Remove License Functionality
// =============================================================================

// Remove License Functionality
// =============================================================================

if ( ! function_exists( 'x_soliloquy_remove_license_notice' ) ) :

  function x_soliloquy_remove_license_notice() {

    if ( is_admin() ) {

      //
      //  Remove license notices.
      //

      remove_action( 'admin_notices', array( Soliloquy_License::get_instance(), 'notices' ) );

    }

  }

  add_action( 'init', 'x_soliloquy_remove_license_notice', 9999 );

endif;

if ( ! function_exists( 'x_soliloquy_hide_key_box' ) ) :

  function x_soliloquy_hide_key_box() { ?>
    <style>
      #soliloquy-settings-key-box{
        display: none;
      }
      </style>
    <?php
  }

  add_action( 'soliloquy_settings_styles', 'x_soliloquy_hide_key_box' );

endif;

