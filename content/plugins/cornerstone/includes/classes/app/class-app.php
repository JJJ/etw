<?php

class Cornerstone_App extends Cornerstone_Plugin_Component {

  protected $show_admin_bar = false;

  public function setup() {
    add_action( 'cornerstone_boot_app', array( $this, 'load' ), 0, 1 );
  }

  public function load() {

    $settings = $this->plugin->settings();
    $preferences = $this->plugin->component('App_Preferences')->get_user_preferences();

    add_filter( 'template_include', '__return_empty_string', 999999 );

    remove_all_actions( 'wp_enqueue_scripts' );
    remove_all_actions( 'wp_print_styles' );
    remove_all_actions( 'wp_print_head_scripts' );

    do_action('cornerstone_before_boot_app');

    global $wp_styles;
    global $wp_scripts;

    $wp_styles = new WP_Styles();
    $wp_scripts = new WP_Scripts();

    if ( (bool) $preferences['show_wp_toolbar'] ) {
      add_action( 'add_admin_bar_menus', array( $this, 'update_admin_bar' ) );

      if ( !class_exists('WP_Admin_Bar') ) {
        _wp_admin_bar_init();
      }

      add_action('wp_enqueue_scripts_clean', array( $this, 'adminBarEnqueue' ));
      $this->show_admin_bar = true;
    } else {
      add_filter( 'show_admin_bar', '__return_false' );
    }

    Cornerstone_Huebert::instance(false)->register();
    $this->enqueue_styles( $settings );
    $this->enqueue_scripts( $settings );
    nocache_headers();

    $theme = isset($preferences['ui_theme']) ? $preferences['ui_theme'] : 'light';
    $this->view( 'app/boilerplate', true, array( 'theme' => $theme ) );
    exit;

  }

  public function enqueue_font_styles() {

    if ( ! apply_filters('cs_load_google_fonts', '__return_true' ) ) {
      return;
    }

    $subsets = 'latin,latin-ext';

    //
    // translators: To add an additional subset specific to your language,
    // translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
    //

    $subset = csi18n( 'common.cs-no-subset' );

    if ( 'cyrillic' === $subset ) {
      $subsets .= ',cyrillic,cyrillic-ext';
    } elseif ( 'greek' === $subset ) {
      $subsets .= ',greek,greek-ext';
    } elseif ( 'vietnamese' === $subset ) {
      $subsets .= ',vietnamese';
    }

    $google_fonts_uri = apply_filters('cs_google_fonts_uri', 'https://fonts.googleapis.com/css' );

    wp_enqueue_style( 'cs-open-sans', "$google_fonts_uri?family=Open+Sans:300italic,400italic,600italic,300,400,600&subset=$subsets" );
    wp_enqueue_style( 'cs-lato', "$google_fonts_uri?family=Lato:400,700&subset=$subsets" );
  }

  public function enqueue_styles( $settings ) {

    $this->enqueue_font_styles();

    wp_register_style( 'cs-dashicons', '/wp-includes/css/dashicons.min.css' );
    wp_register_style( 'cs-editor-buttons', '/wp-includes/css/editor.min.css' );

    $app_style_asset = $this->plugin->css( 'app/app' );
    wp_enqueue_style( 'cs-app-style', $app_style_asset['url'], array(
      'cs-dashicons',
      'cs-editor-buttons',
      'code-editor',
      'cs-huebert-style',
      'wp-auth-check'
    ), $app_style_asset['version'] );

  }

  public function register_app_scripts( $settings, $isPreview = false ) {


    $vendor_asset = $this->plugin->versioned_url( 'assets/dist-app/js/cs-vendor', 'js' );
    $app_asset = $this->plugin->versioned_url( 'assets/dist-app/js/cs', 'js' );
    wp_register_script( 'cs-app-vendor', $vendor_asset['url'], cs_polyfill_dependencies( array( 'jquery', 'lodash', 'moment', 'react', 'react-dom', 'wp-polyfill', 'wp-polyfill-fetch' ) ), $vendor_asset['version'], false );
    wp_register_script( 'cs-app', $app_asset['url'], array( 'cs-app-vendor' ), $app_asset['version'], false );

    $v = $this->plugin->version();

    $icon_maps = wp_parse_args( array(
      'elements' => add_query_arg( array( 'v' => $v ), $this->plugin->url('assets/dist-app/svg/elements.svg') ),
      'ui' => add_query_arg( array( 'v' => $v ), $this->plugin->url('assets/dist-app/svg/ui.svg') ),
    ), apply_filters( 'cornerstone_icon_map', array() ) );

    $router = $this->plugin->component( 'Router' );
    $boot = $this->plugin->component( 'App_Boot' );
    $options_manager = $this->plugin->component( 'Options_Manager' );
    $font_manager = $this->plugin->component( 'Font_Manager' );
    $permissions = $this->plugin->component('App_Permissions');
    $settings = $this->plugin->settings();

    $wpml = $this->plugin->component('Wpml');

    wp_localize_script( 'cs-app', 'csAppData', cs_booleanize( array(
      'rootURL'                   => '/' . trim( $this->plugin->common()->get_app_slug(), '/\\' ) . '/',
      'validPermalinks'           => $router->is_permalink_structure_valid(),
      'initialRoute'              => $boot->get_initial_route(),
      'ajaxUrl'                   => $router->get_ajax_url(),
      'fallbackAjaxUrl'           => $router->get_fallback_ajax_url(),
      'canGzip'                   => $router->gzip(),
      '_cs_nonce'                 => $router->create_nonce(),
      'useLegacyAjax'             => $router->use_legacy_ajax(),
      'dashboardUrl'              => admin_url(),
      'debug'                     => $this->plugin->common()->isDebug(),
      'date_format'               => get_option( 'date_format' ),
      'time_format'               => get_option( 'time_format' ),
      'isRTL'                     => is_rtl(),
      'common_i18n'               => $this->plugin->i18n_group( 'common' ),
      'app_i18n'                  => $this->plugin->i18n_group( 'app' ),
      'permissions'               => $permissions->get_user_permissions(),
      'countdownTBD'              => date( 'Y-m-d H:i:s', strtotime( current_time( 'mysql' ) ) + WEEK_IN_SECONDS),
      // 'fontAwesome'               => $this->plugin->common()->getFontIconsData(),
      // 'font_data'                 => $this->font_data(),

      'iconMaps'                  => $icon_maps,
      'isPreview'                 => $isPreview,
      'previewData'               => $this->plugin->component( 'Preview_Frame_Loader' )->data(),
      'customFontMimeTypes'       => $font_manager->mime_types(),
      'fallbackFont'              => $font_manager->get_fallback_font(),
      'keybindings'               => apply_filters('cornerstone_keybindings', $this->plugin->config_group( 'builder/keybindings' ) ),
      'home_url'                  => home_url(),
      'today'                     => date_i18n( get_option( 'date_format' ), time() ),
      'css_class_map'             => $this->plugin->config_group( 'common/class-map' ),
      'devTools'                  => defined('CS_APP_DEV_TOOLS') && CS_APP_DEV_TOOLS,
      // 'workerURL'                 => add_query_arg( array( 'v' => $v ), $this->url( "assets/dist/js/admin/worker.js" ) ),
      'wpmlLanguages'             => $wpml->get_languages(),
      'wpmlDefault'               => $wpml->get_default_language(),
      'wpmlTranslateableTypes'    => $wpml->get_translateable_post_types(),
      'coalescenceSelectorPrefix' => apply_filters('cs_coalescence_selector_prefix', '#cs-content '),
      'env'                       => $this->plugin->common()->get_env_data(),
      'featureFlags'              => apply_filters('cs_feature_flags', array() ),
      'designCloudApiUrl'         => 'https://theme.co/api/design-cloud',
      'designCloudSubmitUrl'      => 'https://theme.co/apex/api-v2/design-cloud/submit-beta',
      'validationUrl'             => apply_filters('_cs_validation_url', admin_url( 'admin.php?page=cornerstone-home' ) ),
      'siteUrl'                   => esc_attr( trailingslashit( network_home_url() ) ),
      'postStatuses'              => get_post_statuses(),
      'creatablePostTypes'        => $permissions->get_user_creatable_post_types(),
      'current_user'              => get_current_user_id(),
      'preferenceControls'        => $this->plugin->component( 'App_Preferences' )->get_preference_controls(),
      'load_google_fonts'         => apply_filters('cs_load_google_fonts', true ),
      'max_action_history_items'  => apply_filters('cs_max_action_history_items', 1000 ),
      'optionsCustomCSSKey'       => $options_manager->get_custom_css_key(),
      'optionsCustomCSSSelector'  => $options_manager->get_custom_css_selector(),
      'optionsCustomJSKey'        => $options_manager->get_custom_js_key(),
      'dynamicContentFields'      => $this->plugin->component( 'Dynamic_Content' )->get_dynamic_fields(),
      'renderDebounce'            => apply_filters( 'cornerstone_render_debounce', 200 ),
      'optionsTitle'              => apply_filters( 'cornerstone_options_theme_title', false ) ? 'theme' : 'styling',
      'socialShareOptions'        => $this->plugin->component( 'Social' )->get_social_share_options(),
      'pageTemplates'             => $this->get_page_templates(),
      'defaultPageTemplate'       => apply_filters( 'cs_default_page_template', 'default' ),
      'defaultImageWidth'         => apply_filters( 'cs_default_image_width', 48 ),
      'defaultImageHeight'        => apply_filters( 'cs_default_image_height', 48 ),
      'rowPresets'                => array(
        '100%',
        '50% 50%',
        '33.33% 33.33% 33.33%',
        '25% 25% 25% 25%',
        '33.33% 66.66%',
        '66.66% 33.33%',
        '25% 50% 25%',
        '25% 25% 50%',
        '50% 25% 25%'
      )
    ) ) );

  }

  public function get_page_templates() {

    $choices = array();
    $page_templates = wp_get_theme()->get_page_templates();
    ksort( $page_templates );

    $choices[] = array( 'value' => 'default', 'label' => apply_filters( 'default_page_template_title',  __( 'Default Template' ), 'cornerstone' ) );

    foreach ($page_templates as $value => $label) {
      $choices[] = array( 'value' => $value, 'label' => $label );
    }

    return $choices;

  }

  public function enqueue_scripts( $settings ) {

    $this->prime_editor();

    $this->register_app_scripts( $settings );
    wp_enqueue_script( 'cs-app' );

    // Dependencies
    wp_enqueue_script( 'cs-huebert' );
    wp_enqueue_script( 'code-editor' );
    wp_enqueue_script( 'heartbeat' );
    wp_enqueue_media();
  }

  public function update_admin_bar() {
    remove_action( 'admin_bar_menu', 'wp_admin_bar_customize_menu', 40 );
  }

  public function head() {
    wp_enqueue_scripts();
    wp_print_styles();
    wp_print_head_scripts();
  }

  public function footer() {

    wp_print_footer_scripts();
    wp_admin_bar_render();
    wp_auth_check_html();

    if ( function_exists( 'wp_underscore_playlist_templates' ) && function_exists( 'wp_print_media_templates' ) ) {
      wp_underscore_playlist_templates();
      wp_print_media_templates();
    }

  }

  public function body_classes() {

    $classes = array( 'no-customize-support' );

    if ( is_rtl() ) {
      $classes[] = 'rtl';
    }

    if ( $this->show_admin_bar ) {
      $classes[] = 'admin-bar';
    }

    if ( empty( $classes ) ) {
      return;
    }

    $classes = array_map( 'esc_attr', array_unique( $classes ) );
    $class = join( ' ', $classes );
    echo " class=\"$class\"";

  }

  /**
   * Prepare the WordPress Editor (wp_editor) for use as a control
   * This thing does NOT like to be used in multiple contexts where it's added and removed dynamically.
   * We're creating some initial settings here to be used later.
   * Callings this function also triggers all the required styles/scripts to be enqueued.
   * @return none
   */
  public function prime_editor() {

    // Remove all 3rd party integrations to prevent plugin conflicts.
    remove_all_actions('before_wp_tiny_mce');
    remove_all_filters('mce_external_plugins');
    remove_all_filters('mce_buttons');
    remove_all_filters('mce_buttons_2');
    remove_all_filters('mce_buttons_3');
    remove_all_filters('mce_buttons_4');
    remove_all_filters('tiny_mce_before_init');
    add_filter( 'tiny_mce_before_init', '_mce_set_direction' );

    // Cornerstone's editor is modified, so we will allow visual editing for all users.
    add_filter( 'user_can_richedit', '__return_true' );

    if( apply_filters( 'cornerstone_use_br_tags', false ) ) {
      add_filter('tiny_mce_before_init', array( $this, 'allow_br_tags' ) );
    }

    // Allow integrations to use hooks above before the editor is primed.
    do_action('cornerstone_before_wp_editor');

    add_filter('mce_buttons', array( $this, 'mce_buttons' ) );

    ob_start();
    wp_editor( '%%PLACEHOLDER%%','cswpeditor', array(
      'quicktags' => false,
      'tinymce'=> array(
        'toolbar1' => 'bold,italic,strikethrough,underline,bullist,numlist,forecolor,cs_media,wp_adv',
        'toolbar2' => 'link,unlink,alignleft,aligncenter,alignright,alignjustify,outdent,indent',
        'toolbar3' => 'formatselect,pastetext,removeformat,charmap,undo,redo'
      ),
      'editor_class' => 'cs-wp-editor',
      'drag_drop_upload' => true
    ) );
    ob_clean();
  }

  public function mce_buttons( $buttons ) {
    $end = array_pop($buttons);
    array_push($buttons,'cs_media', $end);
    return $buttons;
  }

  /**
   * Depending on workflow, users may wish to allow <br> tags.
   * This can be conditionally enabled with a filter.
   * add_filter( 'cornerstone_use_br_tags', '__return_true' );
   */
  public function allow_br_tags( $init ) {
    $init['forced_root_block'] = false;
    return $init;
  }

}
