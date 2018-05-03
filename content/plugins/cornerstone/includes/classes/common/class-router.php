<?php
/**
 * This class manages AJAX responses for Cornerstone.
 * It uses routes.php to map actions to components and handler functions.
 * Cornerstone registers a custom endpoint that it will attempt to use first,
 * but it will failover to an Admin AJAX endpoint when needed.
 */

class Cornerstone_Router extends Cornerstone_Plugin_Component {

  protected $endpoint = 'cornerstone-endpoint';
  protected $response = array();
  protected $registered = array();
  protected $errors = array();
  protected $fatal_error = false;
  protected $routes = array();

  /**
   * Instantiate and register AJAX handlers
   */
  public function setup () {

    // Component routing
    $this->routes = include( $this->plugin->path( 'includes/routes.php' ) );
    $this->register_routes();

    // Custom Endpoint registration
    add_rewrite_endpoint( $this->endpoint, EP_ALL );
    add_action( 'template_redirect', array( $this, 'endpoint' ), -99999 );

    // Heartbeat
    add_filter( 'heartbeat_received', array( $this, 'heartbeat_received' ), 10, 2 );
    add_filter( 'wp_refresh_nonces', array( $this, 'refresh_nonces' ), 10,  3 );

  }

  /**
   * Attach hooks to both endpoints
   * @return none
   */
  public function register_routes() {

    // Add special controllers route
    $this->routes['controllers'] = array( 'Router', 'controllers' );

    foreach ( $this->routes as $action => $route ) {

      add_action( 'wp_ajax_cs_' . $action, array( $this, 'respond_admin_ajax' ) );

      if ( isset( $route[3] ) && false === $route[3] ) {
        continue;
      }

      $this->registered[] = $action;

    }


  }

  /**
   * Route an incoming admin ajax request to the respective handler
   * @return none
   */
  public function respond_admin_ajax() {

    $action = str_replace( 'wp_ajax_cs_', '', current_action() );
    $this->begin_response();

    do_action( 'cornerstone_before_ajax' );

    return call_user_func( $this->resolve_action_handler( $action ), $this->get_json() );

  }

  /**
   * Resolve a string action to a component function
   * @param  string $action Name of action to call
   * @return function       Callback to execute for the requested action
   */
  public function resolve_action_handler( $action ) {

    if ( ! isset( $this->routes[ $action ] ) ) {
      return cs_send_json_error( array( 'message' => "Registered Cornerstone route: `$action` could not be resolved." ) );
    }

    $component = $this->plugin->loadComponent( $this->routes[ $action ][0] );

    if ( false === $component ) {
      return cs_send_json_error( array( 'message' => "Registered Cornerstone route: `$action` does not have a valid component." ) );
    }

    $handler = array( $component, $this->routes[ $action ][1] );

    if ( ! is_callable( $handler ) ) {
      return cs_send_json_error( array( 'message' => "Registered Cornerstone route: `$action` does not have a valid response handler." ) );
    }

    return $handler;
  }


  /**
   * Handler for our custom endpoint. Faster than Admin AJAX, and more isolated,
   * this handler will be Cornerstone's first attempt at responding to AJAX
   * requests. When unavailable, the router will fallback to Admin AJAX.
   * @return none
   */
  public function endpoint() {

    global $wp_query;

    if ( ! isset( $wp_query->query_vars[ $this->endpoint ] ) ) {
      return;
    }

    if ( ! defined( 'DOING_AJAX' ) ) {
      define( 'DOING_AJAX', true );
    }

    do_action( 'cornerstone_before_custom_endpoint' );

    send_origin_headers();
    @header( 'X-Robots-Tag: noindex' );
    send_nosniff_header();
    nocache_headers();

    if ( ! defined( 'DONOTCACHEPAGE' ) ) {
      define( 'DONOTCACHEPAGE', true );
    }

    $this->begin_response();

    do_action( 'cornerstone_before_ajax' );
    $json = $this->get_json();

    // return cs_send_json_error( array( 'message' => json_encode( $json ) ) );

    if ( ! isset( $json['action'] ) ) {
      return cs_send_json_error( array( 'message' => 'Invalid action' ) );
    } else {
      $action = substr( $json['action'], 3 );
      if ( ! in_array( $action, $this->registered, true ) ) {
        return cs_send_json_error( array( 'message' => 'Unregistered action' ) );
      }
    }

    if ( ! is_user_logged_in() ) {
      return cs_send_json_error( array(
        'invalid_user' => true,
        'message' => 'No logged in user.'
      ) );
    }

    return call_user_func( $this->resolve_action_handler( $action ), $json );

    wp_die();

  }

  /**
   * Cornerstone provides filtered versions of the WordPress success/error JSON
   * response functions (see helpers.php). The filter is: _cornerstone_send_json_response
   *
   * We filter this here to attach debug information, and cache the response for
   * our wp_die handler in case the output was at all corrupted.
   *
   * @param  mixed $response Response data to filter
   * @return array         Response with debug data appended.
   */
  public function filter_response( $response ) {

    if ( CS()->common()->isDebug() && is_array( $response ) ) {

      // Some general debug information
      $response['debug'] = array(
        'peak_memory' => memory_get_peak_usage(),
      );

      // Pass-through PHP errors
      if ( ! empty( $this->errors ) ) {
        $response['debug']['php_errors'] = $this->errors;
      }

    }

    if ( $this->fatal_error ) {
      $response['fatal_error'] = true;
    }

    $this->response = $response;

    return $response;

  }

  /**
   * Mark the start of a response. Start output buffering so we can do error
   * detection later, and register the wp_die handler.
   * @return none
   */
  public function begin_response() {
    ob_start();
    set_error_handler( array( $this, 'php_error_handler' ) );
    ini_set( 'display_errors', false );
    add_action( 'shutdown', array( $this, 'shutdown_handler' ) );
    add_filter( 'wp_die_ajax_handler', array( $this, 'get_wp_die_handler' ) );
    add_filter( '_cornerstone_send_json_response', array( $this, 'filter_response' ) );
  }

  /**
   * Returns a callable reference to our wp_die handler
   * @return array Reference to Cornerstone_Ajax_Handler::wp_die_handler
   */
  public function get_wp_die_handler() {
    return array( $this, 'wp_die_handler' );
  }

  /**
   * Custom handler for wp_die
   * See WordPress filter: wp_die_ajax_handler
   *
   * This allows Cornerstone to detect extraneous output from 3rd party systems
   * that could potentially corrupt the response. We also close out our custom
   * error handler.
   *
   * @param  string $message Message to close response with.
   * @return none
   */
  function wp_die_handler( $message = '' ) {

    restore_error_handler();

    if ( $this->fatal_error ) {
      // Fatal errors will flush the output buffer, so we shouldn't continue.
      die();
    }

    $response = ob_get_clean();

    $begin = substr( $response, 0, 1 );
    $end = substr( $response, -1, 1 );

    // Crude (but fast) detection of non JSON before/after response
    if ( ! in_array( $begin, array( '{', '[' ), true ) || ! in_array( $end, array( '}', ']' ), true ) ) {

      if ( CS()->common()->isDebug() && is_array( $this->response['debug'] ) ) {
        $this->response['debug']['extraneous'] = $response;
      }

      echo wp_json_encode( $this->response );

    } else {
      echo $response; // Business as usual
    }

    // From WordPress function: _ajax_wp_die_handler
    if ( is_scalar( $message ) ) {
      die( (string) $message );
    }
    die( '0' );

  }


  public function php_error_handler( $errno, $errstr, $errfile, $errline ) {

    if ( ! ( error_reporting() & $errno ) ) {
      return;
    }

    $type = $this->lookup_error_type( $errno );
    $this->errors[] = "$type: $errstr in $errfile on line $errline.";

    // Don't execute PHP internal error handler
    return true;

  }

  public function lookup_error_type( $errno ) {

    switch ( $errno ) {
      case E_ERROR:
        return 'E_ERROR';
      case E_WARNING:
        return 'E_WARNING';
      case E_PARSE:
        return 'E_PARSE';
      case E_NOTICE:
        return 'E_NOTICE';
      case E_CORE_ERROR:
        return 'E_CORE_ERROR';
      case E_CORE_WARNING:
        return 'E_CORE_WARNING';
      case E_COMPILE_ERROR:
        return 'E_COMPILE_ERROR';
      case E_COMPILE_WARNING:
        return 'E_COMPILE_WARNING';
      case E_USER_ERROR:
        return 'E_USER_ERROR';
      case E_USER_WARNING:
        return 'E_USER_WARNING';
      case E_USER_NOTICE:
        return 'E_USER_NOTICE';
      case E_STRICT:
        return 'E_STRICT';
      case E_RECOVERABLE_ERROR:
        return 'E_RECOVERABLE_ERROR';
      case E_DEPRECATED:
        return 'E_DEPRECATED';
      case E_USER_DEPRECATED:
        return 'E_USER_DEPRECATED';
    }

    return '';

  }

  public function shutdown_handler() {

    $errno = error_get_last();

    if ( 1 === $errno['type'] ) {

      $type = $this->lookup_error_type( $errno['type'] );
      $this->errors[] = $type . ': ' . $errno['message'] . ' in ' . $errno['file'] . ' on line ' . $errno['line'] . '.';
      $this->fatal_error = true;

      return cs_send_json_error();

    }

  }

  /**
   * Get JSON input from the incoming request. We try to use php://input to grab
   * straight JSON, but it also supports base64encoded form data for less
   * permissive environments
   * @return array request data
   */
  public function get_json() {

    $data = array( 'request' => array() );
    $nonce_verification = false;

    if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {

      if ( isset( $_POST['request'] ) ) {

        $data['request'] = $_POST['request'];

        $thru_fields = array('_cs_nonce', 'action', 'gzip');

        foreach ($thru_fields as $field ) {
          if ( isset( $_POST[$field] ) ) {
            $data[$field] = $_POST[$field];
          }
        }

      } elseif ( isset( $_POST['data'] ) ) {
        $data = $_POST['data']; // Allow pass-through for things like backend options
      } else {

        $data = json_decode( file_get_contents( 'php://input' ), true );

        if ( is_null( $data ) ) {

          $data = array();
          add_filter( '_cornerstone_send_json_response', array( $this, 'failed_php_input' ) );

        }

      }

      if ( isset( $_POST['_cs_nonce'] ) ) {
        $nonce_verification = wp_verify_nonce( $_POST['_cs_nonce'], 'cornerstone_nonce' );
      }

      if ( isset( $data['_cs_nonce'] ) ) {
        $nonce_verification = wp_verify_nonce( $data['_cs_nonce'], 'cornerstone_nonce' );
      }

      if ( isset( $data['request'] ) && ! is_array( $data['request'] ) ) {

        $decoded = base64_decode( $data['request'] );

        if ( isset( $data['gzip'] ) && $data['gzip'] ) {
          $decoded = gzdecode( $decoded );
        }

        $data['request'] = json_decode($decoded, true);

      }

    }

    if ( ! $nonce_verification ) {
      return cs_send_json_error( array(
        'invalid_user' => true,
        'message' => 'nonce verification failed.'
      ) );
    }

    if ( isset( $data['request'] ) ) {
      $request = $data['request'];
      unset($data['request']);

      foreach ($request as $key => $value) {
        $data[$key] = $value;
      }
    }

    return $data;

  }

  public function failed_php_input( $response ) {
    $response['failed_php_input'] = true;
    return $response;
  }

  /**
   * Whether or not this install has been instructed to use the legacy endpoints
   * for Cornerstone. This means it will be looking for base64encoded form data
   * POSTed to admin AJAX rather than our custom endpoint.
   * @return boolean Whether or not legacy mode should be in effect.
   */
  public function use_legacy_ajax() {
    if ( is_multisite() || ! $this->is_permalink_structure_valid() ) {
      return true;
    }
    return defined( 'CS_LEGACY_AJAX' ) ? CS_LEGACY_AJAX : false;
  }

  /**
   * Get an URL that can be used on the front end to make requests. We try to
   * make use of the custom endpoint, but will use a fallback if rewrite rules
   * don't allow it.
   * @return string Cornerstone AJAX url.
   */
  public function get_ajax_url() {

    if ( ! isset( $this->ajax_url ) ) {
      $this->ajax_url = ( $this->endpoint_available() )
      ? home_url( $this->endpoint )
      : $this->get_fallback_ajax_url();
    }

    return $this->ajax_url;

  }

  /**
   * Returns a fallback AJAX url using Admin AJAX.
   * @return string  Relative Admin AJAX url
   */
  public function get_fallback_ajax_url() {
    return admin_url( 'admin-ajax.php', 'relative' );
  }

  /**
   * Find out if the custom endpoint is available. Run a series of checks to
   * see if Cornerstone rewrite rules exist, and if they don't, generate them
   * if conditions are favorable.
   * @return boolean Whether or not we can use the custom endpoint
   */
  public function endpoint_available() {

    if ( $this->use_legacy_ajax() ) {
      return false;
    }

    $rules = get_option( 'rewrite_rules' );

    // No rules generated (permalinks disabled)
    if ( ! $rules ) {
      return false;
    }

    // Check if our rules are present
    foreach ($rules as $rule) {
      if ( false === strpos( $rule, 'cornerstone-endpoint' ) ) {
        continue;
      }
      return true;
    }

    // If not present, and conditions are favorable, generate the rules.

    // flush_rewrite_rules is expensive, so only call under specific conditions:
    // * Permalinks are enabled
    // * Only if permalinks are enabled
    // * Confirm our rules don't already exist
    // * On init, or later
    if ( did_action( 'init' ) ) {
      flush_rewrite_rules();
    } else {
      add_action( 'init', 'flush_rewrite_rules', 9999 );
    }

    return false;

  }

  /**
   * Check if the WordPress permalink settings will meet our needs.
   * @return boolean
   */
  public function is_permalink_structure_valid() {

    $structure = get_option( 'permalink_structure' );

    // Permalinks disabled
    if ( ! $structure ) {
      return false;
    }

    // Don't support PATHINFO rules
    if ( false !== strpos( $structure, 'index.php' ) ) {
      return false;
    }

    return true;

  }

  public function controllers( $json ) {

    if ( !isset( $json['actions' ] ) ) {
      return cs_send_json_error( array( 'message' => 'No actions provided.' ) );
    }

    $response = array();

    foreach ( $json['actions' ] as $action ) {
      $params = ( isset($action['params']) && is_array( $action['params']) ) ? $action['params'] : array();

      $action_response = $this->get_aggregate_response( $action['name'], $params );

      $action_response_data = array( 'name' => $action['name'] );

      if ( is_wp_error( $action_response ) ) {
        $action_response_data['data'] = array( 'message' => $action_response->get_error_message() );
        $action_response_data['success'] = false;
      } else {
        $action_response_data['success'] = true;
        $action_response_data['data'] = $action_response;

        if ( function_exists('gzcompress') ) {
          $action_response_data['gzip'] = true;
          $action_response_data['data'] = base64_encode( gzcompress( json_encode( $action_response_data['data'] ), 9 ) );
        }

      }

      $response[] = $action_response_data;
    }

    return cs_send_json_success( $response );

  }

  public function get_aggregate_response( $action, $params ) {

    try {

      $controller_method = explode( '::', $action );
      if ( ! isset( $controller_method[0] ) && ! isset( $controller_method[1] ) ) {
        throw new Exception( 'Invalid controller request.' );
      }

      $component_name = 'Controller_' . cs_to_component_name( $controller_method[0] );
      $controller = $this->plugin->loadComponent( $component_name );

      if ( ! $controller ) {
        throw new Exception( "Requested controller '$component_name' is not registered." );
      }

      $method = array( $controller, strtolower( $controller_method[1] ) );
      if ( ! is_callable( $method ) ) {
        throw new Exception( "Requested method '$component_name::" . $controller_method[1] . "' is not registered." );
      }

      $result = call_user_func_array( $method, array( $params ) );

      if ( is_wp_error( $result ) ) {
        throw new Exception( $result->get_error_message() );
      }

      return $result;

    } catch ( Exception $e ) {
      return new WP_Error( 'cornerstone_router', $e->getMessage() );
    }

  }

  public function create_nonce() {
    return wp_create_nonce( 'cornerstone_nonce' );
  }

  public function heartbeat_received( $response, $data ) {
    if ( isset( $data['_cs_nonce'] ) ) {
      if ( wp_verify_nonce( $data['_cs_nonce'], 'cornerstone_nonce' ) ) {
        $response['_cs_nonce'] = $this->create_nonce();
      } else {
        if ( ! is_user_logged_in() ) {
          wp_clear_auth_cookie();
        }
      }
    }

    return $response;
  }

  public function refresh_nonces( $response, $data, $screen_id ) {

    if ( ! is_user_logged_in() ) {
			return $response;
		}

    $response['_cs_nonce'] = $this->create_nonce();
    $response['wp-refresh-post-nonces'] = array(
			'heartbeatNonce' => wp_create_nonce( 'heartbeat-nonce' ),
		);

    return $response;

  }
}
