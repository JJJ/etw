<?php
/**
 * Plugin Name: WP Session Manager
 * Author: Drew Jaynes & John Blackbourn
 * Description: Adds controls to a user's profile screen for managing their logged-in sessions.
 * Version: 1000.0
 * License: GPLv2
 */

if ( defined( 'WP_CLI' ) && true === WP_CLI )
	require dirname( __FILE__ ) . '/includes/wp-cli.php';

/**
 * Class WP_Session_Manager
 *
 * @since 1000.0
 */
class WP_Session_Manager {

	/**
	 * Array of user session managers.
	 *
	 * @since 1000.0
	 * @access protected
	 * @var WP_Session_Tokens[]
	 */
	protected $session = array();

	/**
	 * The Browscap instance.
	 *
	 * @since 1000.0
	 * @access protected
	 * @var Browscap
	 */
	protected $bc = null;

	/**
	 * Array of cached Browscap browser data.
	 *
	 * @since 1000.0
	 * @access protected
	 * @var array
	 */
	protected $bc_cache = array();

	/**
	 * Constructor.
	 *
	 * @access private
	 */
	private function __construct() {
		// Textdomain.
		add_action( 'init',                            array( $this, 'action_init'                   ) );

		add_action( 'admin_init',                      array( $this, 'admin_init'                   ) );

		// save some recent activity
		add_action( 'heartbeat_received',              array( $this, 'heartbeat_received'            ) );

		// Profile options.
		add_action( 'admin_head-profile.php',          array( $this, 'enqueue_scripts_styles'        ) );
		add_action( 'admin_head-user-edit.php',        array( $this, 'enqueue_scripts_styles'        ) );
		add_action( 'personal_options',                array( $this, 'user_options_display'          ) );

		// Attach extra session information.
		add_filter( 'attach_session_information',      array( $this, 'filter_collected_session_info' ) );

		// AJAX actions for destroying sessions.
		add_action( 'wp_ajax_wpsm_destroy_sessions',   array( $this, 'ajax_destroy_multiple_sessions') );
	}

	/**
	 * Action fired on init. Loads the l10n files.
	 *
	 * @since 1000.0
	 * @access public
	 */
	public function action_init() {
		load_plugin_textdomain( 'wpsm', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Action fired on heartbeat recieved
	 *
	 * Update the last seen information once per hour
	 *
	 * @since 1000.0
	 * @access public
	 *
	 * @param array $response The response to the Heartbeat request.
	 * @return array The updated Heartbeat response.
	 */
	public function heartbeat_received( array $response ) {

		$update = $this->_maybe_update_last_seen();
		$response['last_seen_updated'] = $update;

		return $response;
	}

	/**
	 * Action fired on admin init
     *
	 * Update the last seen information once per hour
	 *
	 * @since 1000.0
	 * @access public
	 */
	public function admin_init() {
		$this->_maybe_update_last_seen();
	}

	/**
	 * Maybe update the last seen time in the current session
	 *
	 * If it has been an hour since this session was seen, update
	 * that information in the session
	 *
	 * @since 1000.0
	 * @access private
	 */
	private function _maybe_update_last_seen() {
		$token   = wp_get_session_token();
		$manager = $this->get_session_manager( wp_get_current_user() );
		$session = $manager->get( $token );

		$last_seen = isset($session['seen']) ? $session['seen'] : 0 ;

		if ( $last_seen < time() - ( HOUR_IN_SECONDS ) ) {
			$session['seen'] = time();
			$manager->update( $token, $session );
			return true;
		} else {
			return false;
		}

	}

	/**
	 * Enqueue scripts and styles for the profile.php screen.
	 *
	 * @since 1000.0
	 *
	 * @access public
	 */
	public function enqueue_scripts_styles() {

		global $profileuser;

		// Styles.
		wp_enqueue_style( 'wpsm-options', plugins_url( 'css/profile-options.css', __FILE__ ), array(), filemtime( plugin_dir_path( __FILE__ ) . 'css/profile-options.css' ) );

		// Script.
		wp_enqueue_script( 'wpsm-options', plugins_url( 'js/profile-options.js', __FILE__ ), array( 'jquery' ), filemtime( plugin_dir_path( __FILE__ ) . 'js/profile-options.js' ) );

		wp_localize_script(
			'wpsm-options',
			'wpsm',
			array(
				'user_id'        => $profileuser->ID,
				'nonce_multiple' => wp_create_nonce( sprintf( 'destroy_multiple_sessions_%d', $profileuser->ID ) ),
			)
		);

	}

	/**
	 * Handle outputting the session manager options to the user profile screen.
	 *
	 * @since 1000.0
	 *
	 * @access public
	 *
	 * @param WP_User $user WP_User object for the current user.
	 */
	public function user_options_display( WP_User $user ) {
		$sessions = $this->get_session_manager( $user );

		$all_sessions = $sessions->get_all();

		if ( $user->ID == get_current_user_id() ) {
			$token           = wp_get_session_token();
			$current_session = $sessions->get( $token );
			foreach ( $all_sessions as $key => $session ) {
				if ( $session === $current_session ) {
					unset( $all_sessions[$key] );
					break;
				}
			}
		}

		?>
		<table class="form-table">
			<tbody>
			<tr>
				<th scope="row"><?php _e( 'Login Activity', 'wpsm' ); ?></th>
				<td>
					<?php
					if ( $user->ID == get_current_user_id() ) {
						echo '<p>' . __( 'Current session:', 'wpsm' ) . '</p>';
						?>
						<table class="widefat sessions-table">
							<thead>
							<tr>
								<th scope="col" colspan="2"><?php _e( 'Access Type', 'wpsm' ); ?></th>
								<th scope="col"><?php _e( 'Location', 'wpsm' ); ?></th>
								<th scope="col"><?php _e( 'Logged In', 'wpsm' ); ?></th>
								<th scope="col"><?php _e( 'Last Seen', 'wpsm' ); ?></th>
							</tr>
							</thead>
							<tbody>
								<?php $this->user_session_row( $current_session ); ?>
							</tbody>
						</table>
						<?php
					}
					$count = count( $all_sessions );
					if ( $count > 0 ) :
						?>
						<div id="other-locations">
						<?php
						if ( $user->ID == get_current_user_id() ) {
							echo '<p>' . sprintf( _n( 'You&#8217;re logged in to %s other location:', 'You&#8217;re logged in to %s other locations:', $count, 'wpsm' ),
								number_format_i18n( $count )
							) . '</p>';
						} else {
							echo '<p>' . sprintf( _n( 'Logged in to %s location:', 'Logged in to %s locations:', $count, 'wpsm' ),
								number_format_i18n( $count )
							) . '</p>';
						}
						?>
						<table class="widefat sessions-table">
							<thead>
							<tr>
								<th scope="col" colspan="2"><?php _e( 'Access Type', 'wpsm' ); ?></th>
								<th scope="col"><?php _e( 'Location', 'wpsm' ); ?></th>
								<th scope="col"><?php _e( 'Logged In', 'wpsm' ); ?></th>
								<th scope="col"><?php _e( 'Last Seen', 'wpsm' ); ?></th>
							</tr>
							</thead>
							<tbody>
								<?php foreach ( $all_sessions as $session ) {
									$this->user_session_row( $session );
								} ?>
							</tbody>
						</table>
						<?php if ( $user->ID == get_current_user_id() ) { ?>
							<p><button class="button button-secondary hide-if-no-js session-destroy-other" data-token="<?php echo esc_attr( $token ); ?>"><?php _e( 'Log Out of All Other Sessions', 'wpsm' ); ?></button></p>
						<?php } else { ?>
							<p><button class="button button-secondary hide-if-no-js session-destroy-all"><?php _e( 'Log Out of All Sessions', 'wpsm' ); ?></button></p>
						<?php } ?>
						</div>
					<?php elseif ( $user->ID != get_current_user_id() ): ?>
						<?php _e( 'Not currently logged in', 'wpsm' ); ?>
					<?php endif; // $count > 1 ?>
				</td>
			</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Output a table row for a user session list table.
	 *
	 * @since 1000.0
	 * @access protected
	 *
	 * @param  array   $session       The session data.
	 */
	protected function user_session_row( array $session ) {
		$browser    = $this->get_browser( $session );
		$ip         = isset( $session['ip'] ) ? $session['ip'] : __( 'Unknown', 'wpsm' );

		if ( isset( $session['login'] ) ) {
			$login = sprintf( __( '%1$s<br><span class="description">%2$s</span>', 'wpsm' ),
				date_i18n( 'F j, Y', $session['login'] ), date_i18n( 'g:i A', $session['login'] )
			);
		} else {
			$login = __( 'Unknown', 'wpsm' );
		}

		$lastseen = isset( $session['seen'] ) ? self::human_time_diff( $session['seen'] ) : __( 'Unknown', 'wpsm' );

		?>
		<tr>
			<td class="col-device"><span class="<?php echo $this->device_class( $browser ); ?>"></span></td>
			<td class="col-browser"><?php
				if ( $browser ) {
					printf( __( '%1$s<br><span class="description">on %2$s</span>', 'wpsm' ), $browser['browser'], $browser['platform'] );
				} else {
					_e( 'Unknown', 'wpsm' );
				}
			?></td>
			<td class="col-ip"><?php echo $ip; ?></td>
			<td class="col-login"><?php echo $login; ?></td>
			<td class="col-lastseen"><?php echo $lastseen; ?></td>
		</tr>
		<?php
	}

	/**
	 * Return a class name for the current browser information. Used to display a dashicon on each table row.
	 *
	 * @since 1000.0
	 * @access public
	 *
	 * @param  array  $browser The browser information returned by `Browscap::getBrowser()`.
	 * @return string          The class name.
	 */
	public function device_class( array $browser ) {
		if ( !$browser ) {
			return null;
		}
		if ( $browser['ismobiledevice'] ) {
			$class = 'smartphone';
		} else if ( $browser['istablet'] ) {
			$class = 'tablet';
		} else {
			$class = 'desktop';
		}
		return 'dashicons dashicons-' . $class;
	}

	/**
	 * Return browser information for the given session.
	 *
	 * @see Browscap::getBrowser()
	 * @since 1000.0
	 * @access public
	 *
	 * @param  array  $session The session data.
	 * @return array           Browser information for the session.
	 */
	public function get_browser( array $session ) {

		if ( empty( $session['ua'] ) ) {
			return array();
		}

		if ( isset( $this->bc_cache[$session['ua']] ) ) {
			return $this->bc_cache[$session['ua']];
		}

		if ( !isset( $this->bc ) ) {
			$bc = dirname( __FILE__ ) . '/browscap';
			require_once $bc . '/Browscap.php';
			$this->bc = new Browscap( $bc );
			$this->bc->lowercase = true;
		}

		return $this->bc_cache[$session['ua']] = $this->bc->getBrowser( $session['ua'], true );

	}

	/**
	 * Collect and store additional session information.
	 *
	 * @since 1000.0
	 *
	 * @access public
	 *
	 * @param array $info Array of session information.
	 * @return array Filtered session information array.
	 */
	public function filter_collected_session_info( array $info ) {

		// IP address.
		if ( !empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$info['ip'] = $_SERVER['REMOTE_ADDR'];
		}

		// User-agent.
		if ( ! empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$info['ua'] = wp_unslash( $_SERVER['HTTP_USER_AGENT'] );
		}

		// Timestamp
		$info['login'] = time();

		return $info;
	}

	/**
	 * Get a session manager object for the given user.
	 *
	 * @since 1000.0
	 *
	 * @access protected
	 *
	 * @param  WP_User $user A WP_User object.
	 * @return WP_Session_Tokens The WP_Session_Tokens object for the user.
	 */
	protected function get_session_manager( WP_User $user ) {

		if ( isset( $this->session[$user->ID] ) ) {
			return $this->session[$user->ID];
		}

		return $this->session[$user->ID] = WP_Session_Tokens::get_instance( $user->ID );
	}

	/**
	 * AJAX handler for destroying multiple open sessions for the current user.
	 *
	 * @since 1000.0
	 *
	 * @access public
	 */
	public function ajax_destroy_multiple_sessions() {

		$user = self::check_ajax( 'destroy_multiple_sessions_%d' );

		if ( is_wp_error( $user ) ) {
			wp_send_json_error( array(
				'error'   => $user->get_error_code(),
				'message' => $user->get_error_message(),
			) );
		}

		if ( isset( $_POST['token'] ) ) {
			$keep = wp_unslash( $_POST['token'] );
		} else {
			$keep = null;
		}

		$this->destroy_multiple_sessions( $user, $keep );

		wp_send_json_success();

	}

	/**
	 * Destroy multiple sessions for a user.
	 *
	 * All of the user's session will be destroyed except the session matching `$token_to_keep`, if present.
	 *
	 * @since 1000.0
	 * @access public
	 *
	 * @param  WP_User $user          The user object.
	 * @param  string  $token_to_keep The token of the session which should be kept. Optional.
	 */
	public function destroy_multiple_sessions( WP_User $user, $token_to_keep = null ) {

		$sessions = $this->get_session_manager( $user );

		if ( is_string( $token_to_keep ) ) {
			$sessions->destroy_others( $token_to_keep );
		} else {
			$sessions->destroy_all();
		}

	}

	/**
	 * Check the AJAX request for validity and permissions, and return the corresponding user.
	 *
	 * @since 1000.0
	 * @access private
	 *
	 * @param  string $action   The nonce action.
	 * @return WP_User|WP_Error A WP_User object on success, a WP_Error object on failure.
	 */
	private static function check_ajax( $action ) {

		if ( empty( $_POST['user_id'] ) ) {
			return new WP_Error( 'no_user_id', __( 'No user ID specified', 'wpsm' ) );
		}

		$user = new WP_User( absint( $_POST['user_id'] ) );

		if ( !$user->exists() ) {
			return new WP_Error( 'invalid_user', __( 'The specified user does not exist', 'wpsm' ) );
		}

		if ( !current_user_can( 'edit_user', $user->ID ) ) {
			return new WP_Error( 'not_allowed', __( 'You do not have permission to edit this user', 'wpsm' ) );
		}

		if ( !check_ajax_referer( sprintf( $action, $user->ID ), false, false ) ) {
			return new WP_Error( 'invalid_nonce', __( 'Invalid nonce', 'wpsm' ) );
		}

		return $user;

	}

	/**
	 * Singleton getter.
	 *
	 * @since 1000.0
	 *
	 * @access public
	 *
	 * @return WP_Session_Manager Our WP_Session_Manager instance.
	 */
	public static function init() {
		static $instance = null;

		if ( ! $instance ) {
			$instance = new WP_Session_Manager;
		}

		return $instance;

	}

	/**
	 * Return a fuzzy human time diff.
	 *
	 * @since 1000.0
	 * @access public
	 *
	 * @param int    $from  Unix timestamp from which the difference begins.
	 * @return string       The difference in human readable text.
	 */
	protected static function human_time_diff( $from ) {

		$diff = absint( time() - $from );

		if ( $diff <= HOUR_IN_SECONDS ) {
			$since = __( 'This hour', 'wpsm' );
		} else {
			$since = sprintf( __( '%s ago', 'wpsm' ), human_time_diff( $from ) );
		}

		return $since;
	}

}

WP_Session_Manager::init();
