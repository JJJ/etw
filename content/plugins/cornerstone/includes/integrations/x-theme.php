<?php
/**
 * This houses all the code to integrate with X
 */

class Cornerstone_Integration_X_Theme {

  protected $pro = false;

  /**
   * Theme integrations should provide a stylesheet function returning the stylesheet name
   * This will be matched with get_stylesheet() to determine if the integration will load
   */
  public static function stylesheet() {
    return array( 'x', 'pro', 'xpro' );
  }

  /**
   * Theme integrations are loaded on the after_theme_setup hook
   */
  public function theme_setup( $theme ) {

    add_action( 'init', array( $this, 'init' ), 20 );
    add_action( 'admin_init', array( $this, 'admin_init' ) );

    add_action( 'cornerstone_load_preview', array( $this, 'load_preview' ) );
    add_filter( 'cornerstone_config_common_default-settings', array( $this, 'addDefaultSettings' ) );

    // Don't enqueue native styles
    add_filter( 'cornerstone_enqueue_styles', '__return_false' );
    add_filter( 'cornerstone_customizer_output',  '__return_false' );

    // Set the app slug
    add_filter( 'cornerstone_default_app_slug', array( $this, 'app_slug' ) );

    // Don't load the Customizer
    add_filter( 'cornerstone_options_use_native',  '__return_false' );

    // Tell the options screen to say "Theme Options"
    add_filter( 'cornerstone_options_theme_title',  '__return_true' );

    // Enable X specific settings pane items
    add_filter( 'x_settings_pane', '__return_true' );

    // Declare support for page builder features
    add_filter( 'cornerstone_looks_like_support', '__return_true' );

    // Alias legacy shortcode names.
    add_action( 'cornerstone_shortcodes_loaded', array( $this, 'aliasShortcodes' ) );

    add_filter( 'cornerstone_scrolltop_selector', array( $this, 'scrollTopSelector' ) );
    add_filter( 'cs_recent_posts_post_types', array( $this, 'recentPostTypes' ) );

    add_filter( 'cornerstone_menu_item_root', array( $this, 'relocateDashboardMenuCustomItems') );

    add_filter( '_cs_validation_url', 'x_addons_get_link_home' );
  }

  public function init() {

    // Remove empty p and br HTML elements for legacy pages not using Cornerstone sections
    add_filter( 'the_content', 'cs_noemptyp' );

    // Enqueue Legacy font classes
    $settings = CS()->settings();
    if ( isset( $settings['enable_legacy_font_classes'] ) && $settings['enable_legacy_font_classes'] ) {
      add_filter( 'cornerstone_legacy_font_classes', '__return_true' );
    }

    add_filter( 'pre_option_cs_product_validation_key', array( $this, 'validation_passthru' ) );

    $front_end = CS()->loadComponent('Front_End');
    remove_action( 'cs_the_content_late', array( $front_end, 'shim_x_before_site_end') );

  }

  public function app_slug() {
    $slug = csi18n('app.integration-mode');
    return ( $slug ) ? $slug :'x';
  }

  public function admin_init() {
    if ( ! has_action( '_cornerstone_home_not_validated' ) ) {
      add_action( '_cornerstone_home_not_validated', '__return_empty_string' );
    }
  }

  public function validation_passthru( $key ) {
    return get_option( 'x_product_validation_key', false );
  }

  public function aliasShortcodes() {

    //
    // Alias [social] to [icon] for backwards compatability.
    //

    cs_alias_shortcode( 'social', 'x_icon', false );

    //
    // Alias deprecated shortcode names.
    //

    // Mk2
    cs_alias_shortcode( array( 'alert', 'x_alert' ), 'cs_alert' );
    cs_alias_shortcode( array( 'x_text' ), 'cs_text' );
    cs_alias_shortcode( array( 'icon_list', 'x_icon_list' ), 'cs_icon_list' );
    cs_alias_shortcode( array( 'icon_list_item', 'x_icon_list_item' ), 'cs_icon_list_item' );

    // Mk1
    cs_alias_shortcode( 'accordion',            'x_accordion', false );
    cs_alias_shortcode( 'accordion_item',       'x_accordion_item', false );
    cs_alias_shortcode( 'author',               'x_author', false );
    cs_alias_shortcode( 'block_grid',           'x_block_grid', false );
    cs_alias_shortcode( 'block_grid_item',      'x_block_grid_item', false );
    cs_alias_shortcode( 'blockquote',           'x_blockquote', false );
    cs_alias_shortcode( 'button',               'x_button', false );
    cs_alias_shortcode( 'callout',              'x_callout', false );
    cs_alias_shortcode( 'clear',                'x_clear', false );
    cs_alias_shortcode( 'code',                 'x_code', false );
    cs_alias_shortcode( 'column',               'x_column', false );
    cs_alias_shortcode( 'columnize',            'x_columnize', false );
    cs_alias_shortcode( 'container',            'x_container', false );
    cs_alias_shortcode( 'content_band',         'x_content_band', false );
    cs_alias_shortcode( 'counter',              'x_counter', false );
    cs_alias_shortcode( 'custom_headline',      'x_custom_headline', false );
    cs_alias_shortcode( 'dropcap',              'x_dropcap', false );
    cs_alias_shortcode( 'extra',                'x_extra', false );
    cs_alias_shortcode( 'feature_headline',     'x_feature_headline', false );
    cs_alias_shortcode( 'gap',                  'x_gap', false );
    cs_alias_shortcode( 'google_map',           'x_google_map', false );
    cs_alias_shortcode( 'google_map_marker',    'x_google_map_marker', false );
    cs_alias_shortcode( 'highlight',            'x_highlight', false );
    cs_alias_shortcode( 'icon',                 'x_icon', false );
    cs_alias_shortcode( 'image',                'x_image', false );
    cs_alias_shortcode( 'lightbox',             'x_lightbox', false );
    cs_alias_shortcode( 'line',                 'x_line', false );
    cs_alias_shortcode( 'map',                  'x_map', false );
    cs_alias_shortcode( 'pricing_table',        'x_pricing_table', false );
    cs_alias_shortcode( 'pricing_table_column', 'x_pricing_table_column', false );
    cs_alias_shortcode( 'promo',                'x_promo', false );
    cs_alias_shortcode( 'prompt',               'x_prompt', false );
    cs_alias_shortcode( 'protect',              'x_protect', false );
    cs_alias_shortcode( 'pullquote',            'x_pullquote', false );
    cs_alias_shortcode( 'raw_output',           'x_raw_output', false );
    cs_alias_shortcode( 'recent_posts',         'x_recent_posts', false );
    cs_alias_shortcode( 'responsive_text',      'x_responsive_text', false );
    cs_alias_shortcode( 'search',               'x_search', false );
    cs_alias_shortcode( 'share',                'x_share', false );
    cs_alias_shortcode( 'skill_bar',            'x_skill_bar', false );
    cs_alias_shortcode( 'slider',               'x_slider', false );
    cs_alias_shortcode( 'slide',                'x_slide', false );
    cs_alias_shortcode( 'tab_nav',              'x_tab_nav', false );
    cs_alias_shortcode( 'tab_nav_item',         'x_tab_nav_item', false );
    cs_alias_shortcode( 'tabs',                 'x_tabs', false );
    cs_alias_shortcode( 'tab',                  'x_tab', false );
    cs_alias_shortcode( 'toc',                  'x_toc', false );
    cs_alias_shortcode( 'toc_item',             'x_toc_item', false );
    cs_alias_shortcode( 'visibility',           'x_visibility', false );

    Cornerstone_Shortcode_Preserver::preserve( 'code' );

  }


  public function recentPostTypes( $types ) {
    $types['portfolio'] = 'x-portfolio';
    return $types;
  }

  public function scrollTopSelector() {
    return '.x-navbar-fixed-top';
  }

  public function relocateDashboardMenuCustomItems() {
    return 'x-addons-home';
  }

  public function addDefaultSettings( $settings ) {
    $settings['enable_legacy_font_classes'] = get_option( 'x_pre_v4', false );
    return $settings;
  }

  public function load_preview() {

    if ( defined( 'X_VIDEO_LOCK_VERSION' ) ) {
      remove_action( 'wp_footer', 'x_video_lock_output' );
    }

  }

}
