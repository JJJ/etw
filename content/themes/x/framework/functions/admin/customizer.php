<?php

// =============================================================================
// FUNCTIONS/GLOBAL/ADMIN/CUSTOMIZER.PHP
// -----------------------------------------------------------------------------
// Customizer alterations.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Update Native Functionality
//   02. Manage Theme Options Button
// =============================================================================

// Update Native Functionality
// =============================================================================

function x_customizer_update_native_functionality( $wp_customize ) {
  $wp_customize->remove_panel( 'themes' );
}

add_action( 'customize_register', 'x_customizer_update_native_functionality' );



// Manage Theme Options Button
// =============================================================================

function x_customizer_manage_theme_options_button() {

  if ( ! function_exists( 'CS' ) ) {
    return;
  }

  $manage_options_url = CS()->common()->get_app_route_url( 'options' );

  ?>

  <script type="text/template" id="x-manage-theme-options-panel">
    <li class="accordion-section" style="border-top: 1px solid #ddd;">
      <div class="accordion-section customize-info">
        <div class="accordion-section-title">
          <span class="preview-notice">
            <a href="<?php echo $manage_options_url; ?>" class="button change-theme" aria-label="<?php echo x_i18n( 'dashboard', 'customizer-theme-options-button' ); ?>"><?php echo x_i18n( 'dashboard', 'customizer-theme-options-button' ); ?></a>
          </span>
          <button type="button" class="customize-help-toggle dashicons dashicons-editor-help" aria-expanded="false"><span class="screen-reader-text">Help</span></button>
        </div>
        <div class="customize-panel-description"><?php echo x_i18n( 'dashboard', 'customizer-theme-options-description' ); ?></div>
      </div>
    </li>
  </script>

  <script>
    jQuery(function($){
      var $panel = $($('#x-manage-theme-options-panel').html());
      jQuery('#customize-theme-controls .customize-pane-parent').prepend($panel);
    });
  </script>

  <?php

}

add_action( 'customize_controls_print_scripts', 'x_customizer_manage_theme_options_button' );
