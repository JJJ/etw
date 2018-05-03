<?php

class Cornerstone_App extends Cornerstone_Plugin_Component {

  protected $show_admin_bar = false;

  public function setup() {
    add_action( 'cornerstone_boot_app', array( $this, 'load' ), 0, 1 );
  }

  public function load() {

    $settings = $this->plugin->settings();

    add_filter( 'template_include', '__return_empty_string', 999999 );

    remove_all_actions( 'wp_enqueue_scripts' );
    remove_all_actions( 'wp_print_styles' );
    remove_all_actions( 'wp_print_head_scripts' );

    do_action('cornerstone_before_boot_app');

    global $wp_styles;
    global $wp_scripts;

    $wp_styles = new WP_Styles();
    $wp_scripts = new WP_Scripts();

    if ( (bool) $settings['show_wp_toolbar'] ) {
      add_action( 'add_admin_bar_menus', array( $this, 'update_admin_bar' ) );

      if ( !class_exists('WP_Admin_Bar') ) {
        _wp_admin_bar_init();
      }

      add_action('wp_enqueue_scripts_clean', array( $this, 'adminBarEnqueue' ));
      $this->show_admin_bar = true;
    } else {
      add_filter( 'show_admin_bar', '__return_false' );
    }

    Cornerstone_Code_Editor::instance(false)->register();
    Cornerstone_Huebert::instance(false)->register();
    $this->enqueue_styles( $settings );
    $this->enqueue_scripts( $settings );
    nocache_headers();
    $this->view( 'app/boilerplate', true );
    exit;

  }

  public function register_font_styles() {

    $subsets = 'latin,latin-ext';

    //
    // translators: To add an additional subset specific to your language,
    // translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
    //

    $subset = _x( 'cs-no-subset', 'Translate to: (greek, cyrillic, vietnamese) to add an additional font subset.' );

    if ( 'cyrillic' === $subset ) {
      $subsets .= ',cyrillic,cyrillic-ext';
    } elseif ( 'greek' === $subset ) {
      $subsets .= ',greek,greek-ext';
    } elseif ( 'vietnamese' === $subset ) {
      $subsets .= ',vietnamese';
    }

    wp_register_style( 'cs-open-sans', "https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,300,400,600&subset=$subsets" );
    wp_register_style( 'cs-lato', "https://fonts.googleapis.com/css?family=Lato:400,700&subset=$subsets" );
  }

  public function enqueue_styles( $settings ) {

    $this->register_font_styles();

    wp_register_style( 'cs-dashicons', '/wp-includes/css/dashicons.min.css' );
    wp_register_style( 'cs-editor-buttons', '/wp-includes/css/editor.min.css' );
    wp_enqueue_style( 'cs-app-style', $this->plugin->css( 'cs', true ), array( 'cs-open-sans', 'cs-lato', 'cs-dashicons', 'cs-editor-buttons' ), $this->plugin->version() );
    wp_enqueue_style( 'cs-huebert-style' );
    wp_enqueue_style( 'cs-code-editor-style' );
    wp_enqueue_style( 'wp-auth-check' );

  }

  public function register_app_scripts( $settings, $isPreview = false ) {

    $v = $this->plugin->version();

    wp_register_script( 'cs-app-vendor', $this->url( "assets/dist-app/js/cs-vendor.js" ), array( 'jquery' ), $v, false );
    wp_register_script( 'cs-app', $this->url( "assets/dist-app/js/cs.js" ), array( 'cs-app-vendor' ), $v, false );

    $icon_maps = wp_parse_args( array(
      'elements' => add_query_arg( array( 'v' => $v ), $this->plugin->url('assets/dist-app/svg/elements.svg') ),
      'interface' => add_query_arg( array( 'v' => $v ), $this->plugin->url('assets/dist-app/svg/interface.svg') ),
    ), apply_filters( 'cornerstone_icon_map', array() ) );

    $router = $this->plugin->component( 'Router' );
    $boot = $this->plugin->component( 'App_Boot' );

    $settings = $this->plugin->settings();

    $worker_queue_size = apply_filters('cs_worker_queue_size', 4 );

    if ( ! is_int( $worker_queue_size ) || $worker_queue_size < 2 ) {
      $worker_queue_size = 2;
    }

    $wpml = $this->plugin->loadComponent('Wpml');

    wp_localize_script( 'cs-app', 'csAppData', cs_booleanize( array(
      'rootURL'                => '/' . trim( $this->plugin->common()->get_app_slug(), '/\\' ) . '/',
      'validPermalinks'        => $router->is_permalink_structure_valid(),
      'initialRoute'           => $boot->get_initial_route(),
      'ajaxUrl'                => $router->get_ajax_url(),
      'fallbackAjaxUrl'        => $router->get_fallback_ajax_url(),
      'dashboardUrl'           => admin_url(),
      'useLegacyAjax'          => $router->use_legacy_ajax(),
      'debug'                  => ( $this->plugin->common()->isDebug() ),
      'date_format'            => get_option( 'date_format' ),
      'isRTL'                  => is_rtl(),
      'canGzip'                => function_exists('gzdecode'),
      'common_i18n'            => $this->plugin->i18n_group( 'common' ),
      'app_i18n'               => $this->plugin->i18n_group( 'app' ),
      '_cs_nonce'              => $router->create_nonce(),
      'permissions'            => $this->permissions(),
      'funMode'                => (bool) $settings['visual_enhancements'],
      'fontAwesome'            => $this->plugin->common()->getFontIcons(),
      'iconMaps'               => $icon_maps,
      'isPreview'              => $isPreview,
      'previewData'            => $this->plugin->component( 'Preview_Frame_Loader' )->data(),
      'font_data'              => $this->font_data(),
      'fallbackFont'           => $this->plugin->loadComponent( 'Font_Manager' )->get_fallback_font(),
      'keybindings'            => apply_filters('cornerstone_keybindings', $this->plugin->config_group( 'builder/keybindings' ) ),
      'home_url'               => home_url(),
      'helpTextEnabled'        => (bool) $settings['help_text'],
      'today'                  => date_i18n( get_option( 'date_format' ), time() ),
      'contentBuilderElements' => $settings['content_builder_elements'],
      'css_class_map'          => $this->plugin->config_group( 'common/class-map' ),
      'devTools'               => defined('CS_APP_DEV_TOOLS') && CS_APP_DEV_TOOLS,
      'workerURL'              => add_query_arg( array( 'v' => $v), $this->url( "assets/dist/js/admin/worker.js" ) ),
      'workerQueueSize'        => $worker_queue_size,
      'wpmlLanguages'          => $wpml->get_languages(),
      'wpmlDefault'            => $wpml->get_default_language(),
      'wpmlTranslateableTypes' => $wpml->get_translateable_post_types(),
      'env'                    => $this->get_env_data(),
      'featureFlags'           => apply_filters('cs_feature_flags', array() ),
      'designCloudApiUrl'      => 'https://theme.co/api/design-cloud',
      'designCloudSubmitUrl'   => 'https://theme.co/apex/api-v2/design-cloud/submit-beta',
      'validationUrl'          => apply_filters('_cs_validation_url', admin_url( 'admin.php?page=cornerstone-home' ) ),
      'siteUrl'                => esc_attr( trailingslashit( network_home_url() ) )
    ) ) );

  }

  public function enqueue_scripts( $settings ) {

    $this->prime_editor();

    $this->register_app_scripts( $settings );
    wp_enqueue_script( 'cs-app' );

    // Dependencies
    wp_enqueue_script( 'backbone' );
    wp_enqueue_script( 'cs-huebert' );
    wp_enqueue_script( 'cs-code-editor' );
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

  public function permissions() {

    $manage_options = current_user_can( 'manage_options' );
    $allowed_post_types = $this->plugin->common()->getAllowedPostTypes();

    return array(
      'canManageOptions' => $manage_options,
      'canUseRegions'    => $manage_options && current_theme_supports( 'cornerstone_regions' ),
      'canUseBuilder'    => ! empty( $allowed_post_types ),
      'allowedPostTypes' => $allowed_post_types,
      'useUnfilteredHTML' => current_user_can( 'unfiltered_html' )
    );

  }

  public function font_data() {
    $font_data = $this->plugin->config_group( 'common/font-data' );
    return apply_filters( 'cs_font_data', $font_data );
  }

  public function font_awesome() {
    return $this->plugin->common()->getFontIcons();
  }

  public function get_env_data() {
    return apply_filters('_cornerstone_app_env', array(
      'product' => 'cornerstone',
      'version' => CS()->version(),
      'productKey' => esc_attr( get_option( 'cs_product_validation_key', '' ) )
    ));
  }

}
