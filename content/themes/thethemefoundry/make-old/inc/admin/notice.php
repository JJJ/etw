<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Admin_Notice
 *
 * @since 1.4.9.
 */
final class MAKE_Admin_Notice implements MAKE_Admin_NoticeInterface, MAKE_Util_HookInterface, MAKE_Util_LoadInterface {
	/**
	 * The array of registered notices.
	 *
	 * @since 1.4.9.
	 *
	 * @var array    The array of registered notices.
	 */
	private $notices = array();

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private static $hooked = false;

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private $loaded = false;

	/**
	 * Hook into WordPress.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		// Hook up notices
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );

		if ( is_admin() ) {
			// Register Ajax action
			add_action( 'wp_ajax_make_hide_notice', array( $this, 'handle_ajax' ) );
		}

		// Hooking has occurred.
		self::$hooked = true;
	}

	/**
	 * Check if the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function is_hooked() {
		return self::$hooked;
	}

	/**
	 * Load files.
	 *
	 * @since 1.4.9.
	 *
	 * @return void
	 */
	public function load() {
		if ( $this->is_loaded() ) {
			return;
		}

		// Load the current notices
		$file = dirname( __FILE__ ) . '/current-notices.php';
		if ( is_readable( $file ) ) {
			include_once $file;
		}

		// Loading has occurred.
		$this->loaded = true;

		/**
		 * Action: Fires at the end of the Admin Notice object's load method.
		 *
		 * This action gives a developer the opportunity to add additional admin notices
		 * and run additional load routines.
		 *
		 * @since 1.7.0.
		 *
		 * @param MAKE_Admin_Notice    $notice     The notice object that has just finished loading.
		 */
		do_action( 'make_notice_loaded', $this );
	}

	/**
	 * Check if the load routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function is_loaded() {
		return $this->loaded;
	}

	/**
	 * Register an admin notice.
	 *
	 * @since 1.4.9.
	 *
	 * @param string    $id         A unique ID string for the admin notice.
	 * @param string    $message    The content of the admin notice.
	 * @param array     $args       Array of configuration parameters for the admin notice.
	 *
	 * @return bool                 True if the admin notice was successfully registered.
	 */
	public function register_admin_notice( $id, $message, $args = array() ) {
		// Sanitize ID
		$id = sanitize_key( $id );

		// Prep args
		$defaults = array(
			'cap'     => 'switch_themes',      // User capability to see the notice
			'dismiss' => true,                 // Whether notice is dismissible
			'screen'  => array( 'dashboard' ), // IDs/filenames of screens to show the notice on
			'type'    => 'info',               // success, warning, error, info
		);
		$args = wp_parse_args( $args, $defaults );

		// Register the notice
		if ( $id && $message ) {
			$this->notices[ $id ] = array_merge( array( 'message' => $message ), $args );
			return true;
		}

		// If you get to here, the registration failed.
		return false;
	}

	/**
	 * Get the visible notices for a specified screen.
	 *
	 * @since 1.4.9.
	 *
	 * @param  string|object    $screen    The screen to display the notices on.
	 * @return array                       Array of notices to display on the specified screen.
	 */
	private function get_notices( $screen = '' ) {
		if ( ! $screen ) {
			return array();
		}

		// Get the array of notices that the current user has already dismissed
		$user_id = get_current_user_id();
		$dismissed = get_user_meta( $user_id, 'ttfmake-dismissed-notices', true );

		// Remove notices that don't meet requirements
		$notices = $this->notices;
		foreach( $notices as $id => $args ) {
			if (
				! $this->screen_is_enabled( $screen, $args['screen'] )
				||
				! current_user_can( $args['cap'] )
				||
				in_array( $id, (array) $dismissed )
			) {
				unset( $notices[ $id ] );
			}
		}

		return $notices;
	}

	/**
	 * Check if the given screen is in the array of allowed screens.
	 *
	 * @since 1.6.0.
	 *
	 * @param  WP_Screen    $current_screen     The WP_Screen object for the given screen.
	 * @param  array        $enabled_screens    Array of allowed screen IDs.
	 *
	 * @return bool                             True if the given screen is enabled for displaying the notice.
	 */
	private function screen_is_enabled( $current_screen, $enabled_screens ) {
		// Validate current screen variable
		if ( ! $current_screen instanceof WP_Screen ) {
			return false;
		}

		// Ensure correct casting
		$enabled_screens = (array) $enabled_screens;

		// Check screen ID first
		if ( in_array( $current_screen->id, $enabled_screens ) ) {
			return true;
		}

		// Check screen's parent file next
		return in_array( $current_screen->parent_file, $enabled_screens );
	}

	/**
	 * Wrapper function for admin_notices hook that sets everything up.
	 *
	 * @since 1.4.9.
	 *
	 * @return void
	 */
	public function admin_notices() {
		// Only run this in the proper hook context.
		if ( 'admin_notices' !== current_action() ) {
			return;
		}

		// Make sure files are loaded first.
		if ( ! $this->is_loaded() ) {
			$this->load();
		}

		$current_notices = $this->get_notices( get_current_screen() );

		if ( ! empty( $current_notices ) ) {
			$this->render_notices( $current_notices );
		}
	}

	/**
	 * Output the markup and styles for admin notices.
	 *
	 * @since 1.4.9.
	 *
	 * @param  array    $notices    The array of notices to render.
	 *
	 * @return void
	 */
	private function render_notices( $notices ) {
		// Add styles and script to page if necessary
		if ( in_array( true, wp_list_pluck( $notices, 'dismiss' ) ) ) {
			add_action( 'admin_print_footer_scripts', array( $this, 'print_admin_notices_js' ) );
		}

		// Prep and render each notice
		foreach ( $notices as $id => $args ) {
			// Notice config
			$id      = sanitize_key( $id );
			$message = $this->sanitize_message( $args['message'] );
			$dismiss = $args['dismiss'];
			$type    = sanitize_key( $args['type'] );
			$nonce   = wp_create_nonce( 'ttfmake_dismiss_' . $id );
			$classes = array( 'notice', 'notice-' . $type );

			// Add dismissible class
			if ( true === $dismiss ) {
				$classes[] = 'is-dismissible';
			}

			// Convert classes to string
			$classes = implode( ' ', $classes );

			// Render
			?>
			<div id="ttfmake-notice-<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $classes ); ?>" data-nonce="<?php echo esc_attr( $nonce ); ?>">
				<?php echo wpautop( $message ); ?>
			</div>
			<?php
		}
	}

	/**
	 * Output the JS to hide admin notices.
	 *
	 * @since 1.4.9.
	 *
	 * @return void
	 */
	public function print_admin_notices_js() {
		// Only run this in the proper hook context.
		if ( 'admin_print_footer_scripts' !== current_action() ) {
			return;
		}
		?>
		<script type="application/javascript">
			/* Make admin notices */
			/* <![CDATA[ */
			(function($) {
				$('.notice').on('click', '.notice-dismiss', function(evt) {
					evt.preventDefault();

					var $target = $(evt.target),
						$parent = $target.parents('.notice').first(),
						id      = $parent.attr('id').replace('ttfmake-notice-', ''),
						nonce   = $parent.data('nonce');

					$.post(
						ajaxurl,
						{
							action : 'make_hide_notice',
							nid    : id,
							nonce  : nonce
						}
					);
				});
			})(jQuery);
			/* ]]> */
		</script>
		<?php
	}

	/**
	 * Process the Ajax request to hide an admin notice.
	 *
	 * @since 1.4.9.
	 *
	 * @return void
	 */
	public function handle_ajax() {
		// Only run this in the proper hook context.
		if ( 'wp_ajax_make_hide_notice' !== current_action() ) {
			return;
		}

		// Get POST parameters
		$nid   = isset( $_POST['nid'] )   ? sanitize_key( $_POST['nid'] ) : false;
		$nonce = isset( $_POST['nonce'] ) ? $_POST['nonce']               : false;

		// Check requirements
		if (
			! defined( 'DOING_AJAX' ) ||
			true !== DOING_AJAX ||
			false === $nid ||
			false === $nonce ||
			! wp_verify_nonce( $nonce, 'ttfmake_dismiss_' . $nid )
		) {
			// Requirement check failed. Bail.
			wp_die();
		}

		// Get the user's array of dismissed notices
		$user_id = get_current_user_id();
		$dismissed = get_user_meta( $user_id, 'ttfmake-dismissed-notices', true );
		if ( ! $dismissed ) {
			$dismissed = array();
		}

		// Add a new notice to the array
		$dismissed[] = $nid;
		$success = update_user_meta( $user_id, 'ttfmake-dismissed-notices', $dismissed );

		// Return a success response.
		if ( $success ) {
			echo 1;
		}
		wp_die();
	}

	/**
	 * Sanitize an admin notice message.
	 *
	 * @since 1.6.5.
	 *
	 * @param  string    $message    The message string to sanitize.
	 * @return string                The sanitized message string.
	 */
	private function sanitize_message( $message ) {
		$allowedtags = wp_kses_allowed_html();
		$allowedtags['a']['target'] = true;
		return wp_kses( $message, $allowedtags );
	}
}