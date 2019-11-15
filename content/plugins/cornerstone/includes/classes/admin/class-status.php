<?php

class Cornerstone_Status extends Cornerstone_Plugin_Component {

  protected $items = array();
  protected $groups = array();

  protected $app_name = 'status';

  public function setup() {
    if ( ! is_admin() || ! current_user_can('switch_themes') ) {
      return;
    }

    // Check whether the get_plugin_data function exists.
    // If not, include the file that contains it
    if ( is_admin() ) {
      if( !function_exists('get_plugin_data') ){
        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
      }
    }

    $this->register();

    add_filter( 'cs_admin_app_data', array( $this, 'maybe_enqueue' ), 10, 2 );
    add_action( 'admin_menu', array( $this, 'dashboard_menu' ) );

  }

  public function register() {

    // Groups
    $this->add_group( 'site' );
    $this->add_group( 'wp' );
    $this->add_group( 'server' );
    $this->add_group( 'php' );
    $this->add_group( 'theme' );
    $this->add_group( 'plugins' );
    $this->add_group( 'cdn' );

    // Add Items
    // Site Info
    $this->add_item( 'site-url', array(
      'group' => 'site',
      'value' => site_url()
    ));

    $this->add_item( 'home-url', array(
      'group' => 'site',
      'value' => home_url()
    ));

    // Wordpress Environment
    $this->add_item( 'version', array(
      'group' => 'wp',
      'value' => get_bloginfo( 'version' )
    ));

    $this->add_item( 'debug-on', array(
      'group' => 'wp',
      'value' => ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? 'Yes' : 'No'
    ));

    $this->add_item( 'language', array(
      'group' => 'wp',
      'value' => get_locale()
    ));

    $this->add_item( 'is-multisite', array(
      'group' => 'wp',
      'value' => ( is_multisite() ) ? 'Yes' : 'No'
    ));

    $this->add_item( 'memory-limit', array(
      'group' => 'wp',
      'value' => ( defined( 'WP_MEMORY_LIMIT' ) && WP_MEMORY_LIMIT ) ? WP_MEMORY_LIMIT : ''
    ));

    // Web Server Environment
    $this->add_item( 'server-software', array(
      'group' => 'server',
      'value' => isset( $_SERVER['SERVER_SOFTWARE'] ) ? $this->get_web_server_software() : '-'
    ));

    $this->add_item( 'php-version', array(
      'group' => 'server',
      'value' => phpversion()
    ));

    $this->add_item( 'mysql-version', array(
      'group' => 'server',
      'value' => $this->get_mysql_version()
    ));

    // PHP Information
    $this->add_item( 'post-max-size', array(
      'group' => 'php',
      'value' => ini_get( 'post_max_size' )
    ));

    $this->add_item( 'time-limit', array(
      'group' => 'php',
      'value' => ini_get( 'max_execution_time' ) . 's'
    ));

    $this->add_item( 'max-upload-size', array(
      'group' => 'php',
      'value' => ( wp_max_upload_size() / (1024*1024)) . 'M'
    ));

    // Active Theme
    $theme_data = $this->get_theme_data();

    $this->add_item( 'theme-name', array(
      'group' => 'theme',
      'value' => html_entity_decode( $theme_data['theme-name'] )
    ));

    $this->add_item( 'theme-version', array(
      'group' => 'theme',
      'value' => $theme_data['theme-version']
    ));

    $this->add_item( 'theme-folder', array(
      'group' => 'theme',
      'label' => 'Folder',
      'value' => '/' . $theme_data['theme-folder'] . '/'
    ));

    // if the theme is a child
    if( is_child_theme() ){

      $this->add_item( 'parent-theme-name', array(
        'group' => 'theme',
        'value' => html_entity_decode( $theme_data['theme-parent-name'] )
      ));

      $this->add_item( 'parent-theme-version', array(
        'group' => 'theme',
        'value' => $theme_data['theme-parent-version']
      ));

      $this->add_item( 'parent-theme-folder', array(
        'group' => 'theme',
        'value' => $theme_data['theme-parent-folder']
      ));
    }

    // check for cornerstone
    if( isset( $theme_data['theme-cs-enabled'] ) ){

      if( $theme_data['theme-cs-enabled'] ){

        $this->add_item( 'theme-cs-enabled', array(
          'group' => 'theme',
          'value' => 'Enabled'
        ));

        // show version
        $this->add_item( 'theme-cs-version', array(
          'group' => 'theme',
          'label' => 'Cornerstone Version',
          'value' => $theme_data['theme-cs-version']
        ));

      }else{

        // show an error message saying it must be enabled
        $this->add_item( 'theme-cs-enabled', array(
          'group' => 'theme',
          'value' => 'Disabled'
        ));

      }

    }

    // Get Must-use plugins
    $mu_plugins = $this->get_mu_plugins();
    if( $mu_plugins ){

      $the_mu_plugins = array();
      foreach( $mu_plugins as $plugin_path => $plugin ){
        $the_mu_plugins[] = array(
          'id'      =>  $plugin_path,
          'value'   =>  $plugin
        );
      }

      $this->add_item( 'mu-plugins', array(
        'group' => 'plugins',
        'value' => $the_mu_plugins
      ));
    }

    // Get list of active plugins
    $active_plugins = $this->get_active_plugins();

    // caching plugins
    $caching_plugins = $this->get_caching_plugins( $active_plugins );
    // check if there are active caching plugins
    if( $caching_plugins ){
      foreach( $caching_plugins as $plugin_path => $plugin ){
        $the_caching_plugins[] = array(
          'id'      =>  $plugin_path,
          'value'   =>  $plugin
        );

        // unset from the $active_plugins
        unset( $active_plugins[ $plugin_path ] );
      }

      // add the caching plugins
      $this->add_item( 'caching-plugins', array(
        'group' => 'plugins',
        'value' => $the_caching_plugins
      ));
    }

    // check if there are active plugins
    if( $active_plugins && count( $active_plugins ) > 0 ){

      $other_plugins = array();
      foreach( $active_plugins as $plugin_path => $plugin ){
        $other_plugins[] = array(
          'id'      =>  $plugin_path,
          'value'   =>  $plugin['complete_name']
        );
      }

      // Determine the label to use for "Other Plugins"
      if( $mu_plugins || $caching_plugins ){
        $other_plugins_subgroup = 'other-plugins';
      }else{ // don't use any label
        $other_plugins_subgroup = 'plugins';
      }

      $this->add_item( $other_plugins_subgroup, array(
        'group' => 'plugins',
        'value' => $other_plugins
      ));

    }

    //if there are none, unset the Active Plugins group
    if( !$active_plugins && !$mu_plugins && !$caching_plugins ){
      unset( $this->groups['plugins'] );
    }

    // CDN
    $this->add_item( 'check-cdn', array(
      'group' => 'cdn',
      'value' => site_url()
    ));

  }

  public function get_mu_plugins(){

    $the_mu_plugins = false;

    // get the list
    $mu_plugins = wp_get_mu_plugins();

    foreach( $mu_plugins as $plugin ){

      $plugin_data = get_plugin_data( $plugin, false );
      $the_mu_plugins[ $plugin ] = html_entity_decode( $plugin_data['Name'] . ' ' . $plugin_data['Version'] );

    }

    return $the_mu_plugins;

  }

  // Returns only the web server info
  public function get_web_server_software(){
    $software = explode( ' ', $_SERVER['SERVER_SOFTWARE'] );
    return $software[0];
  }

  public function get_theme_data(){

    $theme = wp_get_theme();

    $data['theme-name'] = $theme->get( 'Name' );
    $data['theme-folder'] = get_stylesheet_directory();

    // check if current theme is a child theme
    if( is_child_theme() ){

      // get details of parent theme
      $parent_theme = wp_get_theme( get_template() );

      $data['theme-is-child'] = true;
      $data['theme-parent-name'] = $parent_theme->get( 'Name' );
      $data['theme-parent-folder'] = get_template_directory();
      $data['theme-parent-version'] = $parent_theme->get('Version');
      $data['theme-version'] = $data['theme-parent-version'];

    }else{ // only include these if not using a child theme

      $data['theme-is-child'] = false;
      $data['theme-version'] = $theme->get('Version');

    }

    // Check if it's using X or Pro
    if( $data['theme-name'] == 'X' || ( isset( $data['theme-parent-name'] ) && $data['theme-parent-name'] == 'X' ) ){

      $data['theme-cs-enabled'] = false;
      $cs_plugin_path = 'cornerstone/cornerstone.php';
      //echo ABSPATH;

      // check if cornerstone is installed
      if( is_plugin_active( $cs_plugin_path ) ){
        $data['theme-cs-enabled'] = true;

        // cs info
        $cs_path = WP_PLUGIN_DIR . '/' . $cs_plugin_path;
        $cs_data = get_plugin_data( $cs_path, false );
        $data['theme-cs-version'] = $cs_data['Version'];

      }

    }

    return $data;

  }

  public function get_caching_plugins( $plugins = array() ){

    // if there are no active plugins, just return FALSE
    if( !$plugins ){
      return FALSE;
    }

    // list of caching plugins
    /*
      'WP Rocket',
      'WP Super Cache',
      'WP Fastest Cache',
      'W3 Total Cache',
      'LiteSpeed Cache',
      'WP Performance Score Booster',
      'Autoptimize',
      'SG Optimizer',
      'Cache Enabler – WordPress Cache',
      'Breeze – WordPress Cache Plugin',
      'Swift Performance Lite',
      'Asset CleanUp: Page Speed Booster',
      'Comet Cache',
      'Hyper Cache',
      'Hummingbird Page Speed Optimization',
      'WP Speed of Light'
    */

    $caching_plugins = array(
      'autoptimize/autoptimize.php',
      'breeze/breeze.php',
      'cache-enabler/cache-enabler.php',
      'comet-cache/.php',
      'hummingbird-performance/wp-hummingbird.php',
      'hyper-cache/plugin.php',
      'litespeed-cache/litespeed-cache.php',
      'sg-cachepress/sg-cachepress.php',
      'w3-total-cache/w3-total-cache.php',
      'wp-asset-clean-up/wpacu.php',
      'wp-fastest-cache/wpFastestCache.php',
      'wp-performance-score-booster/wp-performance-score-booster.php',
      'wp-speed-of-light/wp-speed-of-light.php',
      'wp-super-cache/wp-cache.php',
      'wp-rocket/wp-rocket.php',
      'swift-performance-lite/performance.php',
    );

    // default to FALSE
    $active_caching_plugins = false;

    foreach( $plugins as $plugin_path => $plugin ){
      // check if it is in the list of caching plugins
      if( in_array( $plugin_path, $caching_plugins ) ){
        $active_caching_plugins[ $plugin_path ] = $plugin['complete_name'];
      }
    }

    return $active_caching_plugins;

  }

  public function get_active_plugins(){

    $active_plugins = (array) get_option( 'active_plugins', array() );
    $the_active_plugins = FALSE;

    foreach( $active_plugins as $plugin ){

      $plugin_path = WP_PLUGIN_DIR . '/' . $plugin;
      $plugin_data = get_plugin_data( $plugin_path, false );

      $the_active_plugins[ $plugin ] = $plugin_data;
      $the_active_plugins[ $plugin ]['complete_name'] = html_entity_decode( $plugin_data['Name'] . ' ' . $plugin_data['Version'] );

    }

    return $the_active_plugins;

  }

  // get the mysql version
  public function get_mysql_version(){
    global $wpdb;

    if ( empty( $wpdb->is_mysql ) ) {
      return '';
    }

    if ( $wpdb->use_mysqli ) {
      $server_info = mysqli_get_server_info( $wpdb->dbh );
    } else {
      $server_info = mysql_get_server_info( $wpdb->dbh );
    }

    return $server_info;
  }

  public function dashboard_menu() {
    $title = csi18n('admin.dashboard-status-title');
    $path = csi18n('admin.dashboard-status-path');
    add_submenu_page( $path, $title, $title, 'manage_options', $path, array( $this, 'render_page' ) );
  }

  public function maybe_enqueue( $data, $hook ) {

    if ( false !== strpos( $hook, csi18n('admin.dashboard-status-path') ) ) {
      $data[$this->app_name] = array(
        'react'     => true,
        'groups'    => $this->groups,
        'items'     => $this->items,
        'ajax_url'  => admin_url( 'admin-ajax.php' ),
        'i18n'      => $this->i18n_group('admin', false, 'status'),
        '_cs_nonce' => wp_create_nonce( 'cornerstone_nonce' ),
      );
    }

    //x_dump( $data );
    return $data;
  }

  public function render_page() {
    ?>

    <div class="tco-reset tco-wrap tco-wrap-settings tco-alt-cs">
      <div class="tco-content">
        <div class="wrap">
          <h2>WordPress Wrap</h2>
        </div>
        <div class="tco-status" data-tco-admin-app="<?php echo $this->app_name;?>"></div>
      </div>
    </div>
    <?php
  }

  protected function add_group( $id, $label = 'i18n') {
    $this->groups[$id] = $label;
  }

  protected function add_item( $id, $data) {
    $this->items[] = array_merge( array( 'id' => $id, 'label' => 'i18n' ), $data );
  }


}
