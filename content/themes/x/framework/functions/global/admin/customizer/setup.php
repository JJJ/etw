<?php

// =============================================================================
// FUNCTIONS/GLOBAL/ADMIN/CUSTOMIZER/SETUP.PHP
// -----------------------------------------------------------------------------
// Initializes and sets up the WordPress Live Preview feature by including
// sections, controls, and settings.
//
// - Sections: organize the controls.
// - Controls: receive input and pass it to the settings.
// - Settings: interface with the existing options in the theme.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Set Path
//   02. Require Files
//   03. Update Native Customizer Functionality
//   04. Overwrite Cached Options During Customizer Preview
// =============================================================================

// Set Path
// =============================================================================

$cstm_path = X_TEMPLATE_PATH . '/framework/functions/global/admin/customizer';



// Require Files
// =============================================================================

require_once( $cstm_path . '/controls.php' );
require_once( $cstm_path . '/fonts.php' );
require_once( $cstm_path . '/register.php' );
require_once( $cstm_path . '/output.php' );
require_once( $cstm_path . '/transients.php' );
require_once( $cstm_path . '/preloader.php' );



// Update Native Customizer Functionality
// =============================================================================

function x_update_native_customizer_functionality( $wp_customize ) {

  $wp_customize->remove_panel( 'themes' );

  $wp_customize->remove_section( 'nav' );
  $wp_customize->remove_section( 'colors' );
  $wp_customize->remove_section( 'title_tagline' );
  $wp_customize->remove_section( 'background_image' );
  $wp_customize->remove_section( 'static_front_page' );

  $wp_customize->remove_control( 'blogname' );
  $wp_customize->remove_control( 'blogdescription' );
  $wp_customize->remove_control( 'nav_menu_locations[primary]' );
  $wp_customize->remove_control( 'nav_menu_locations[footer]' );

  if ( $wp_customize->get_control( 'site_icon' ) ) {
    $wp_customize->get_control( 'site_icon' )->section     = 'x_customizer_section_social';
    $wp_customize->get_control( 'site_icon' )->priority    = '1000';
    $wp_customize->get_control( 'site_icon' )->description = '';
  }

}

add_action( 'customize_register', 'x_update_native_customizer_functionality' );

// Add Manage Theme Options Button

function x_customizer_manage_theme_options_button() {

  if ( ! function_exists( 'CS' ) ) {
    return;
  }

  $manage_options_url = CS()->common()->get_app_route_url('options');

  ?>

  <script type="text/template" id="x-manage-theme-options-panel">
    <li class="accordion-section">
    			<div class="accordion-section customize-info">
    	<div class="accordion-section-title">
    		<span class="preview-notice">
    			<a href="<?php echo $manage_options_url; ?>" class="button change-theme" aria-label="Manage Theme Options">Manage Theme Options</a>
    		</span>
    		<button type="button" class="customize-help-toggle dashicons dashicons-editor-help" aria-expanded="false"><span class="screen-reader-text">Help</span></button>

    	</div>
    	<div class="customize-panel-description"><?php echo x_i18n('dashboard', 'customizer-theme-options-description'); ?></div>
    </div>
    		</li>
  </script>

  <script>
    jQuery(function($){
      var $panel = $( $('#x-manage-theme-options-panel').html() );
      jQuery('#customize-theme-controls .customize-pane-parent').prepend( $panel );
    });
  </script> <?php

}

add_action( 'customize_controls_print_scripts', 'x_customizer_manage_theme_options_button' );


// Overwrite Cached Options During Customizer Preview
// =============================================================================

function x_inject_customizer_preview_options() {

  add_filter( 'pre_option_x_cache_customizer_css', 'x_customizer_get_css' );
  add_filter( 'pre_option_x_cache_google_fonts_request', 'x_get_google_fonts_request' );

}

add_action( 'customize_preview_init', 'x_inject_customizer_preview_options' );
