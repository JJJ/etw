<?php

class X_TGMPA_Integration {

  private static $instance;

  private $approved_plugins;
  private $extensions;

  public function __construct() {
    add_action( 'tgmpa_register', array( $this, 'tgm_register' ) );
    add_filter( 'tgmpa_load', array( $this, 'should_load_tgmpa' ) );
    add_action( 'admin_menu', array( $this, 'admin_menu' ), 100 );
  }

  function should_load_tgmpa() {
    return true;
  }

  public function get_extensions() {
    if (!isset($this->extensions) ) {
      $this->extensions = $this->normalize_slugs( get_site_option( 'x_extension_list', array() ) );
      usort( $this->extensions, array( $this, 'title_sort') );
    }
    return $this->extensions;
  }

  public function get_approved_plugins() {
    if (!isset($this->approved_plugins) ) {
      $this->approved_plugins = include X_TEMPLATE_PATH . '/framework/data/approved-plugins.php';
      usort( $this->approved_plugins, array( $this, 'title_sort') );
    }
    return $this->approved_plugins;
  }

  public function normalize_slugs( $extensions ) {
    $normalized = array();

    foreach ($extensions as $extension) {
      if (isset( $extension['plugin'] ) ) {
        $path = explode( '/', $extension['plugin'] );
        $extension['slug'] = $path[0];
      }
      $normalized[] = $extension;
    }
    return $normalized;
  }

  // Take a list (Extensions or Approved Plugins)
  // and return only plugins that are registered in TGM along with their install/active status
  public function with_plugin_status( $plugins ) {
    $tgmpa = TGM_Plugin_Activation::get_instance();

    $list = array();
    foreach ($plugins as $plugin) {

      if (!isset($tgmpa->plugins[ $plugin['slug'] ])) {
        continue;
      }

      $plugin['installed'] = $tgmpa->is_plugin_installed( $plugin['slug'] );
      $plugin['activated'] = $tgmpa->is_plugin_active( $plugin['slug'] );
      $list[] = $plugin;
    }

    return $list;
  }


  // Used to display the Extensions list on the Validation screen
  public function get_extension_list() {
    return $this->with_plugin_status( $this->get_extensions() );
  }

  // Used to display the Approved Plugin list on the Validation screen
  public function get_approved_plugin_list() {
    return $this->with_plugin_status( $this->get_approved_plugins() );
  }

  // Install a plugin registered with TGM
  // Used in AJAX requests from our custom install UI
  public function install_plugin( $plugin ) {

    if ( ! $plugin ) {
      return new WP_Error( 'x-tgmpa-integration', __( 'No plugin specified.', '__x__' ) );
    }

    if ( ! current_user_can( 'install_plugins' ) ) {
      return new WP_Error( 'x-tgmpa-integration', __( 'Your user account does not have permission to install plugins.', '__x__' ) );
    }

    $tgmpa = TGM_Plugin_Activation::get_instance();

    // In case somehow the plugin is no longer registered in TGM
    if ( ! isset( $tgmpa->plugins[ $plugin ] ) ) {
      return new WP_Error( 'x-tgmpa-integration', __( 'Plugin not registered.', '__x__' ) );
    }

    // Nothing to do if already installed
    if ( $tgmpa->is_plugin_installed( $plugin ) ) {
      return new WP_Error( 'x-tgmpa-integration', __( 'Plugin already installed.', '__x__' ) );
    }

    // Abort if file system not writable
    if ( ! $this->can_write_to_filesystem() ) {
      return new WP_Error( 'x-tgmpa-integration', __( 'Your WordPress file permissions do not allow plugins to be installed.', '__x__' ) );;
    }

    x_tgmpa_load_upgrader();

    $skin = new X_Plugin_Upgrader_Skin();
    $upgrader = new Plugin_Upgrader( $skin );
    $result = $upgrader->install( $tgmpa->get_download_url( $plugin ) );

    if ( is_wp_error( $result ) ) {
      return $result;
    }

    $skin_error = $skin->get_error();

    if ( is_wp_error( $skin_error ) ) {
      return $skin_error;
    }

    return true;

  }

  public function can_write_to_filesystem() {

    // Attempt to get credentials without output
    ob_start();
    $creds = request_filesystem_credentials( '', '', false, false, null );
    ob_end_clean();

    // Return true/false if file system is available
    return (bool) WP_Filesystem( $creds );

  }

  // public static function prepare_list( $items ) {

  //   $list = array();

  //   foreach ( $items as $key => $value) {
  //     $value['installed'] = ( isset( $value['plugin'] ) ) ? self::plugin_installed( $value['plugin'] ) : false;
  //     if ( $value['installed'] ) {
  //       $value['activated'] = is_plugin_active( $value['plugin'] );
  //     }
  //     $list[$value['slug']] = $value;
  //   }

  //   return $list;

  // }

  public function title_sort( $a, $b ) {
    if ( ! isset( $a['title'] ) || ! isset( $b['title'] ) ) {
      return false;
    }
    return strcmp( strtolower( $a['title'] ), strtolower( $b['title'] ) );
  }

  public function tgm_register() {

    $tgmpa = TGM_Plugin_Activation::get_instance();
    do_action( 'x_tgmpa_register', $tgmpa );

    $extensions = $this->get_extensions();

    foreach ($extensions as $plugin) {

      if ( ! isset( $plugin['package'] ) || ! $plugin['package'] ) {
        continue;
      }

      $tgmpa->register( array(
        'slug' => $plugin['slug'],
        'name' => $plugin['title'],
        'file_path' => $plugin['plugin'],
        'source' => $plugin['package'],
        'version' => $plugin['new_version']
      ) );

      // TGM file path detection doesn't always work so we need to set the known path here
      $tgmpa->plugins[ $plugin['slug'] ]['file_path'] = $plugin['plugin'];

    }

    $approved_plugins = $this->get_approved_plugins();

    foreach ($approved_plugins as $plugin) {

      $tgmpa->register( array(
        'name' => $plugin['title'],
        'slug' => $plugin['slug'],
        'is_callable' => $plugin['is_callable'],
      ) );
    }

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */

    $title = __( 'Bulk Extension Manager', '__x__' );
    $tgmpa->config( array(
      'id'           => '__x__',                 // Unique ID for hashing notices for multiple instances of TGMPA.
      'default_path' => '',                      // Default absolute path to bundled plugins.
      'menu'         => 'x-bulk-extension-manager', // Menu slug.
      'has_notices'  => false,                    // Show admin notices or not.
      'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
      'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
      'message'      => "<h1>$title</h1>" . __( '<p>This screen will allow you to manage all Extensions and Approved plugins.</p>', '__x__'),                      // Message to output right before the plugins table.

      'strings' => array(
        'page_title'                      => $title,
        'menu_title'                      => $title,

        'installing'                      => __( 'Installing Plugin: %s', '__x__' ),
        'updating'                        => __( 'Updating Plugin: %s', '__x__' ),
        'oops'                            => __( 'Something went wrong with the plugin API.', '__x__' ),
        'return'                          => __( 'Return to Bulk Extension Manager', '__x__' ),

      )
    ) );
  }

  public function admin_menu() {
    remove_submenu_page( 'themes.php', 'x-bulk-extension-manager' );
  }

  public function bulk_manager_url() {
    return TGM_Plugin_Activation::get_instance()->get_tgmpa_url();
  }

  public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
  }

}


if ( is_admin() || defined( 'WP_CLI' ) ) {
  X_TGMPA_Integration::instance();
}


function x_tgmpa_load_upgrader() {
  if ( ! class_exists( 'Plugin_Upgrader', false ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
  }

  if ( ! class_exists( 'X_Plugin_Upgrader_Skin' ) ) {
    class X_Plugin_Upgrader_Skin extends WP_Upgrader_Skin {

      public $error_messages = array();

      public function get_error() {
        return empty($this->error_messages) ? false : new WP_Error('x-tgmpa-integration', implode(' | ', $this->error_messages ) );
      }

      public function error( $errors ) {
        if ( is_string( $errors ) ) {
          $this->error_messages[] = $errors;
        } elseif ( is_wp_error( $errors ) && $errors->has_errors() ) {
          foreach ( $errors->get_error_messages() as $message ) {
            if ( $errors->get_error_data() && is_string( $errors->get_error_data() ) ) {
              $this->error_messages[] = $message . ' ' . esc_html( strip_tags( $errors->get_error_data() ) );
            } else {
              $this->error_messages[] = $message;
            }
          }
        }
      }

      public function after() { }
      public function header() { }
      public function footer() { }
      public function feedback($string) {}
    }
  }
}
