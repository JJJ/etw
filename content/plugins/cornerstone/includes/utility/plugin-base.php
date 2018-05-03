<?php
/**
 * Plugin boilerplate.
 * This bootstraps the plugin and activates the required components.
 */
abstract class Cornerstone_Plugin_Base {

  // Optionally override in a child class to adjust behavior
  protected $init_priority = 10;
  protected $admin_init_priority = 10;
  protected $includes_folder = 'includes';
  protected $config_folder = 'includes/config';
  protected $i18n_folder = 'includes/i18n';
  protected $templates_folder = 'templates';
  protected $views_folder = 'includes/views';
  protected $theme_template_folder = ''; // defaults to slug
  protected $register_activation_hooks = true;

  // These should never be overriden by the child class
  protected $registry;
  protected $components = array();
  protected $config_store = array();
  protected $i18n_strings = array();
  protected $file;
  protected $name;
  protected $slug;
  protected $version;
  protected $text_domain;
  protected $domain_path;
  protected $path;
  protected $url;
  protected $i18n_path;

  /**
   * Assign plugin variables
   */
  public function __construct( $file, $name, $slug, $version, $text_domain, $domain_path, $path = '', $url = '' ) {

    $this->file = $file;
    $this->name = $name;
    $this->slug = $slug;
    $this->version = $version;
    $this->text_domain = $text_domain;
    $this->domain_path = $domain_path;
    $this->path = ( $path ) ? $path : plugin_dir_path( $file );
    $this->url = ( $url ) ? $url : plugin_dir_url( $file );

  }


  /**
   * Run after plugin instantiation
   */
  public function superPreinit( $i18n_path = '' ) {


    $this->i18n_path = ( '' !== $i18n_path ) ? $i18n_path : $this->path($this->i18n_folder);

    $this->preinitBefore();

    // Register activation / deactivation hooks
    if ( $this->register_activation_hooks ) {
      register_activation_hook( $this->file, array( $this, 'onActivate' ) );
      register_deactivation_hook( $this->file, array( $this, 'onDeactivate' ) );
    }

    // Load WP-CLI commands
    if ( defined( 'WP_CLI' ) && WP_CLI ) {
      $this->loadFiles( 'wp-cli' );
      $this->loadComponents( 'wp-cli' );
    }

    $this->components = array();
    $this->registry = include $this->path( $this->includes_folder . '/registry.php' );

    // Load preinit files and components
    $this->loadFiles( 'preinit' );
    $this->loadComponents( 'preinit' );

    // Defer actions
    add_action( 'init', array( $this, 'init' ), $this->init_priority );
    add_action( 'after_theme_setup', array( $this, 'after_theme_setup' ) );
    add_action( 'admin_init', array( $this, 'adminInit' ), $this->admin_init_priority );

    $this->preinitAfter();
  }


  /**
   * Perform boilerplate init actions
   * @return none
   */
  public function init() {

    $this->initBefore();

    // Load init files and components
    $this->loadFiles( 'init' );
    $this->loadComponents( 'init' );
    $this->versionMigration();

    $this->initAfter();

    // Load user/admin classes
    if ( ! is_user_logged_in() ) {
      return;
    }

    $this->loggedinBefore();

    // Load logged-in files and components
    $this->loadFiles( 'loggedin' );
    $this->loadComponents( 'loggedin' );

    $this->loggedinAfter();

  }

  /**
   * Perform boilerplate init actions
   * @return none
   */
  public function after_theme_setup() {

    // Load after_theme_setup files and components
    $this->loadFiles( 'after_theme_setup' );
    $this->loadComponents( 'after_theme_setup' );

  }

  public function adminInit() {

    $this->adminBefore();

    // Load logged-in files and components
    $this->loadFiles( 'admin' );
    $this->loadComponents( 'admin' );

    $this->adminAfter();

  }

  /**
   * Require a set of registered files
   * @param  string  $group A group of files found in registry.php
   * @return bool whether or not the operation suceeded
   */
  public function loadFiles( $group ) {

    if ( ! isset( $this->registry['files'][ $group ] ) ) {
      return false;
    }

    $includes = $this->registry['files'][ $group ];

    if ( ! is_array( $includes ) ) {
      return false;
    }

    try {
      foreach ( $includes as $filename ) {
        require_once $this->path( "$this->includes_folder/$filename.php" );
      }
    } catch ( Exception $e ) {
      trigger_error( 'Exception: ' .  $e->getMessage() );
      return false;
    }

    return true;

  }

  /**
   * Instantiate a set of component classes
   * @param  string  $group A group of componenets found in registry.php
   * @return bool whether or not the operation suceeded
   */
  public function loadComponents( $group ) {

    if ( ! isset( $this->registry['components'][ $group ] ) ) {
      return false;
    }

    $components = $this->registry['components'][ $group ];

    if ( ! is_array( $components ) ) {
      return;
    }

    foreach ( $components as $component ) {
      $this->loadComponent( $component );
    }

  }

  public function get_registry() {
    $args = func_get_args();
    $registry = null;
    $args = array_reverse($args);
    $level = $this->registry;
    while(count($args)) {
      $key = array_pop( $args );
      if ( isset( $level[$key] ) ) {
        $level = $level[$key];
      } else {
        return null;
      }
    }

    return $level;
  }

  public function loadComponent( $name ) {

    try {

      $class = $this->name . '_' . $name;
      $exists = false;

      try {
        $exists = class_exists( $class );
      } catch ( Exception $e ) {
        trigger_error( 'Exception: ' . $e->getMessage() . "\n" );
      }

      if ( ! $exists ) {
        return false;
      }

      if ( ! isset( $this->components[ $name ] ) ) {

        $name = $this->componentConditions( $name );

        if ( false === $name ) {
          return false;
        }

        $instance = new $class( $this );
        $this->components[ $name ] = $instance;
        $instance->beforeDependencies();

        if ( is_array( $instance->dependencies ) ) {
          foreach ( $instance->dependencies as $component ) {
            $this->loadComponent( $component );
          }
        }

        $instance->setup();

      }

      return $this->components[ $name ];

    } catch ( Exception $e ) {
      trigger_error( 'Exception: ' .  $e->getMessage() . "\n" );
    }

    return false;

  }

  public function controller( $name ) {
    return $this->loadComponent( "Controller_$name" );
  }

  public function componentConditions( $name ) {

    $name = explode( ':', $name );

    if ( count( $name ) === 1 ) {
      return $name[0];
    }

    if ( $name[1] == 'theme-support' ) {

      if ( isset( $name[2] ) && current_theme_supports( $name[2] ) ) {
        return $name[0];
      }

    }

    return false;
  }

  /**
   * Returns a component instance via its name
   * @return object Component instance
   */
  public function component( $handle ) {
    return ( isset( $this->components[ $handle ] ) ) ? $this->components[ $handle ] : null;
  }

  /**
   * Gets the path to the Cornerstone plugin directory.
   * Should be used in combination with the instance wrapper funciton.
   * For example: $path = CS()->path();
   * This will include a trailing slash, so do not include one when using $to
   * @param  string  $to Path to desired location relative to the plugin path.
   * @return string filterable equivilent of plugin_dir_path( __FILE__ )
   */
  public function path( $to = '' ) {
    return apply_filters( $this->slug . '_path', $this->path ) . $to;
  }

  /**
   * Gets the url to the plugin directory.
   * Should be used in combination with the instance wrapper funciton.
   * This will include a trailing slash, so do not include one when using $to
   * @param  string  $to URL to desired location relative to the plugin URL.
   * @return string filterable equivilent of plugin_dir_url( __FILE__ )
   */
  public function url( $to = '' ) {
    return apply_filters( $this->slug . '_url', $this->url ) . $to;
  }

  /**
   * Returns the plugin version number
   * @return string Obtained from the file header and cached
   */
  public function version() {
    return $this->version;
  }

  /**
   * Returns the plugin name
   * @return string
   */
  public function name() {
    return $this->name;
  }

  /**
   * Returns the plugin slug
   * @return string
   */
  public function slug() {
    return $this->slug;
  }

  /**
   * Returns the plugin text domain
   * Call the helper method instead: 'cornerstone'
   * @return string Obtained from the file header and cached
   */
  public function td() {
    return $this->text_domain;
  }

  /**
   * Adds myplugin_activation hook on plugin activation
   * Tie into this from one of your preinit components
   * @return none
   */
  public function onActivate() {
    do_action( $this->slug . '_activation' );
  }

  /**
   * Adds myplugin_deactivation hook on plugin deactivation
   * Tie into this from one of your preinit components
   * @return none
   */
  public function onDeactivate() {
    do_action( $this->slug . '_deactivation' );
  }



  /**
   * Simple version migration system
   * Hook into `myplugin_updated` and test against the supplied
   * version number to conditionally run migration logic
   * @return none
   */
  public function versionMigration() {
    $prior = get_option( $this->slug . '_version', 0 );
    $current = $this->version();

    if ( version_compare( $prior, $current, '>=' ) ) {
      return;
    }

    do_action( $this->slug .'_updated', $prior );

    update_option( $this->slug . '_version', $current, true );

  }

  public function get_template_part( $slug, $name = null, $load = true ) {

    do_action( 'get_template_part_' . $slug, $slug, $name );

    $templates = array();
    if ( isset( $name ) ) {
      $templates[] = $slug . '-' . $name . '.php';
    }
    $templates[] = $slug . '.php';

    $templates = apply_filters( $this->slug . '_get_template_part', $templates, $slug, $name );

    return $this->locate_template( $templates, $load, false );

  }

  /**
   * Retrieve the name of the highest priority template file that exists.
   *
   * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
   * inherit from a parent theme can just overload one file. If the template is
   * not found in either of those, it looks in the theme-compat folder last.
   *
   * @param string|array $template_names Template file(s) to search for, in order.
   * @param bool $load If true the template file will be loaded if it is found.
   * @param bool $require_once Whether to require_once or require. Default true.
   *                            Has no effect if $load is false.
   * @return string The template filename if one is located.
   */
  public function locate_template( $template_names, $load = false, $require_once = true ) {

    $filename = false;

    foreach ( (array) $template_names as $template_name ) {

      if ( empty( $template_name ) ) {
        continue;
      }

      $template_name = untrailingslashit( $template_name );

      $theme_template_folder = trailingslashit( ( '' !== $this->theme_template_folder ) ?
      $this->theme_template_folder : $this->slug );

      // Check child theme first
      $child = get_stylesheet_directory() . '/' . $theme_template_folder . $template_name;
      if ( file_exists( $child ) ) {
        $filename = $child;
        break;
      }

      $parent = get_template_directory() . '/' . $theme_template_folder . $template_name;
      if ( file_exists( $parent ) ) {
        $filename = $parent;
        break;
      }

      $plugin = $this->path( "$this->templates_folder/$template_name" );
      if ( file_exists( $plugin ) ) {
        $filename = $plugin;
        break;
      }
    }

    if ( $load && ! empty( $filename ) ) {
      load_template( $filename, $require_once );
    }

    return $filename;

  }

  /**
   * Find a template so we can include it ourselves.
   * Doesn't run through `load_template` so some globals may need to be declared.
   * This can be used to load markup used in the dashboard.
   */
  public function template( $slug, $name = null, $echo = true ) {

    ob_start();

    $template = $this->get_template_part( $slug, $name, false );

    if ( $template ) {
      include( $template );
    }

    $contents = ob_get_clean();

    if ( $echo ) {
      echo $contents;
    }

    return $contents;

  }

  /**
   * Include a view file, optionally outputting its contents.
   */
  public function view( $name, $echo = true, $data = array(), $extract = false ) {

    ob_start();

    $view = $this->locate_view( $name );

    if ( $extract ) {
      extract( $data );
    }

    if ( $view ) {
      include( $view );
    }

    $contents = ob_get_clean();

    if ( $echo ) {
      echo $contents;
    }

    return $contents;

  }

  public function locate_view( $name ) {

    $file = $this->path( trailingslashit( $this->views_folder ) . $name . '.php' );

    if ( ! file_exists( $file ) ) {
      return false;
    }

    return $file;

  }

/**
   *
   * @param
   * @param  string path to config file
   * @return array
   */
  /**
   * Retrieve a particular configuration set and apply filters.
   * @param  string $name      string path to config file
   * @param  string $namespace namespace to prepend to key for caching
   * @param  string $path      alternate path
   * @return array            requested configuration values
   */
  public function config_group( $name = '', $namespace = '', $path = '', $abs_path = false ) {

    $key = ( $namespace ) ? "{$namespace}.{$name}" : $name;
    $path = ( $path ) ? $path : $this->config_folder;
    if ( ! isset( $this->config_store[ $key ] ) ) {

      $config_path = trailingslashit( $path ) . $name . '.php';
      if ( ! $abs_path ) {
        $config_path = $this->path( $config_path );
      }
      $value = include( $config_path );
      $data = is_array( $value ) ? $value : array();

      /**
       * Filter example: $name == 'folder/defaults-file'
       * 'plugin_config_folder_defaults-file'
       * 'plugin_config_folder_defaults-file'
       */
      $filter_name = sanitize_key( str_replace( '.', '_', str_replace( '/', '_', $key ) ) );
      $this->config_store[ $key ] = apply_filters( "{$this->slug}_config_{$filter_name}", $data );

    }

    return $this->config_store[ $key ];

  }

  public function config( $group_name, $item ) {
    $group = $this->config_group( $group_name );
    return ( isset( $group[$item] ) ) ? $group[$item] : null;
  }

  /**
   * Get a named set of localized strings from the i18n directory
   * @param  string  $group      Name of the strings file to load
   * @param  boolean $namespace Should we prepend a namespace to the keys?
   * @return array              Localized strings
   */
  public function i18n_group( $group, $namespace = true ) {

    $strings = $this->config_group( $group, 'i18n', $this->i18n_path, true );

    if ( !$namespace ) {
      return $strings;
    }

    $namespaced = array();

    foreach ( $strings as $key => $value ) {
      $namespaced["$group.$key"] = $value;
    }

    return $namespaced;
  }

  public function i18n( $key ) {

    if ( ! isset( $this->i18n_strings[ $key ] ) ) {
      $group = 'common';
      $group_index = strpos($key, '.');
      if ( -1 !== $group_index ) {
        $group = substr( $key, 0, $group_index );
      }
      $strings = $this->i18n_group( $group );
      foreach ($strings as $string => $value) {
        $this->i18n_strings[ $string ] = $value;
      }
    }

    return isset( $this->i18n_strings[ $key ] ) ? $this->i18n_strings[ $key ] : '';
  }

  /**
   * Plugin entry point.
   * @param  string $file This should be __FILE__ from the main plugin file
   * @return bool true if the instance was generated for the first time
   */
  public static function run( $file, $i18n_path = '', $path = '', $url = '', $name = '', $slug = '' ) {

    if ( ! defined( 'ABSPATH' ) ) {
      die();
    }

    $data = get_file_data( $file, array( 'Plugin Name', 'Version', 'Text Domain', 'Domain Path' ) );

    $plugin_name = array_shift( $data );
    $version = array_shift( $data );
    $text_domain = array_shift( $data );
    $domain_path = array_shift( $data );

    if ( '' === $name ) {
      $name = $plugin_name;
    }

    if ( '' === $slug ) {
      $slug = $text_domain;
    }

    $class = new ReflectionClass( $name . '_Plugin' );

    if ( ! is_null( $class->getStaticPropertyValue( 'instance', null ) ) ) {
      return false;
    }

    $instance = $class->newInstance( $file, $name, $slug, $version, $text_domain, $domain_path, $path, $url );

    // Setup as a singleton for global access
    if ( $class->hasProperty( 'instance' ) ) {
      $class->setStaticPropertyValue( 'instance', $instance );
    } else {
      // If the child doesn't have an instance property, we'll create a global variable.
      $GLOBALS[ $slug . '_plugin' ] = $instance;
    }

    $instance->superPreinit( $i18n_path );

    return true;

  }

  /**
   * Methods to optionally override in child class
   */
  protected function preinitBefore() {}
  protected function preinitAfter() {}
  protected function initBefore() {}
  protected function initAfter() {}
  protected function loggedinBefore() {}
  protected function loggedinAfter() {}
  protected function adminBefore() {}
  protected function adminAfter() {}

}


/**
 * Offers simple dependency injection
 * Automatically creates a reference to the main plugin
 * Having your components extend this class allows you to do things like:
 *
 * $this->plugin->td()
 * $this->plugin->version()
 * $this->plugin->url( 'path/to/file' )
 */
abstract class Cornerstone_Plugin_Component {

  protected $plugin;
  public $dependencies = false;
  protected $path = '';
  protected $url = '';

  public function __construct( $plugin ) {

    $this->plugin = $plugin;
    $this->td = $this->plugin->td();

  }

  public function setup() { }
  public function beforeDependencies() { }

  /**
   * Shortcut to plugin path method including component local path additions.
   * @param  $to (optional) Append to the current path
   * @return string
   */
  public function path( $to = '' ) {
    return trailingslashit( $this->plugin->path( $this->path ) ) . $to;
  }

  /**
   * Shortcut to plugin url method including component local path additions.
   * @param  $to (optional) Append to the current url
   * @return string
   */
  public function url( $to = '' ) {
    return trailingslashit( $this->plugin->url( $this->url ) ) . $to;
  }

  /**
   * Returns a component instance via its name
   * @return object Component instance
   */
  public function component( $handle ) {
    return ( isset( $this->components[ $handle ] ) ) ? $this->components[ $handle ] : null;
  }

  /**
   * Passthrough get_template_part
   * This runs through WordPress `load_template` when $load is true
   */
  public function get_template_part( $slug, $name = null, $load = true ) {
    return $this->plugin->get_template_part( $slug, $name, $load );
  }

  /**
   * Find a template so we can include it ourselves.
   * Doesn't run through `load_template` so some globals may need to be declared.
   * This can be used to load markup used in the dashboard.
   */
  public function template( $slug, $name = null, $echo = true ) {

    ob_start();

    $template = $this->plugin->get_template_part( $slug, $name, false );

    if ( $template ) {
      include( $template );
    }

    $contents = ob_get_clean();

    if ( $echo ) {
      echo $contents;
    }

    return $contents;

  }

  /**
   * Get the path to a view so it can be passed to "include", preserving scope.
   */
  public function locate_view( $name ) {
    return $this->plugin->locate_view( $name );
  }

  /**
   * Include a view file, optionally outputting its contents.
   */
  public function view( $name, $echo = true, $data = array(), $extract = false ) {

    ob_start();

    $view = $this->locate_view( $name );

    if ( $extract ) {
      extract( $data );
    }

    if ( $view ) {
      include( $view );
    }

    $contents = ob_get_clean();

    if ( $echo ) {
      echo $contents;
    }

    return $contents;

  }

  public function i18n_group( $group, $namespace = true ) {
    return $this->plugin->i18n_group( $group, $namespace );
  }

  public function config_group( $group, $namespace = true, $path = '' ) {
    return $this->plugin->config_group( $group, $namespace, $path );
  }

  public function config_item( $group, $key = null ) {
    return $this->plugin->config( $group, $key );
  }

}
