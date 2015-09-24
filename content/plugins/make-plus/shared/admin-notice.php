<?php
/**
 * @package Make Plus
 */

if ( ! class_exists( 'TTFMP_Admin_Notice' ) ) :
/**
 * Class TTFMP_Admin_Notice
 *
 * Display notices in the WP Admin
 *
 * @since 1.6.0.
 */
class TTFMP_Admin_Notice {
	/**
	 * The array of registered notices.
	 *
	 * @since 1.6.0.
	 *
	 * @var    array    The array of registered notices.
	 */
	private $notices = array();

	/**
	 * Stores results of tests for support of various admin notice features.
	 *
	 * @since 1.6.5.
	 *
	 * @var array    The array of support test results.
	 */
	private $support = array();

	/**
	 * The single instance of the class.
	 *
	 * @since 1.6.0.
	 *
	 * @var    object    The single instance of the class.
	 */
	private static $instance;

	/**
	 * Instantiate or return the one TTFMP_Admin_Notice instance.
	 *
	 * @since  1.6.0.
	 *
	 * @return TTFMP_Admin_Notice
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Construct the object.
	 *
	 * @since 1.6.0.
	 * @since 1.6.5. Populate the $support array.
	 *
	 * @return TTFMP_Admin_Notice
	 */
	public function __construct() {
		global $wp_version;

		// Test for support of admin notice features
		$this->support = array(
			'dismissible' => version_compare( $wp_version, '4.2', '>=' ),
			'types'       => version_compare( $wp_version, '4.2', '>=' ),
		);
	}

	/**
	 * Initialize and hook into WordPress.
	 *
	 * @since 1.6.0.
	 *
	 * @return void
	 */
	public function init() {
		// Hook up notices
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );

		if ( is_admin() ) {
			// Register Ajax action
			add_action( 'wp_ajax_ttfmp_hide_notice', array( $this, 'handle_ajax' ) );
		}
	}

	/**
	 * Register an admin notice.
	 *
	 * @since 1.6.0.
	 *
	 * @param string    $id         A unique ID string for the admin notice.
	 * @param string    $message    The content of the admin notice.
	 * @param array     $args       Array of configuration parameters for the admin notice.
	 * @return void
	 */
	public function register_admin_notice( $id, $message, $args = array() ) {
		// Sanitize ID
		$id = sanitize_key( $id );

		// Prep args
		$defaults = array(
			'cap'     => 'update_plugins',      // User capability to see the notice
			'dismiss' => true,                 // Whether notice is dismissible
			'screen'  => array( 'dashboard' ), // IDs/filenames of screens to show the notice on
			'type'    => 'info',               // success, warning, error, info
		);
		$args = wp_parse_args( $args, $defaults );

		// Register the notice
		if ( $id && $message ) {
			$this->notices[ $id ] = array_merge( array( 'message' => $message ), $args );
		}
	}

	/**
	 * Get the visible notices for a specified screen.
	 *
	 * @since 1.6.0.
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
		$dismissed = get_user_meta( $user_id, 'ttfmp-dismissed-notices', true );

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
	 * @since 1.6.0.
	 *
	 * @return void
	 */
	public function admin_notices() {
		$current_notices = $this->get_notices( get_current_screen() );

		if ( ! empty( $current_notices ) ) {
			$this->render_notices( $current_notices );
		}
	}

	/**
	 * Output the markup and styles for admin notices.
	 *
	 * @since 1.6.0.
	 *
	 * @param  array    $notices    The array of notices to render.
	 * @return void
	 */
	private function render_notices( $notices ) {
		// Add styles and script to page if necessary
		if ( in_array( true, wp_list_pluck( $notices, 'dismiss' ) ) ) {
			add_action( 'admin_print_footer_scripts', array( $this, 'print_admin_notices_js' ) );

			// Styles for pre-4.2 dismiss button
			if ( false === $this->support['dismissible'] ) : ?>
				<style type="text/css">
					.ttfmp-dismiss {
						display: block;
						float: right;
						margin: 0.5em 0;
						padding: 2px;
					}
					.rtl .ttfmp-dismiss {
						float: left;
					}
				</style>
			<?php endif;
		}

		// Prep and render each notice
		foreach ( $notices as $id => $args ) {
			// Notice config
			$id      = sanitize_key( $id );
			$message = $this->sanitize_message( $args['message'] );
			$dismiss = $args['dismiss'];
			$type    = sanitize_key( $args['type'] );
			$nonce   = wp_create_nonce( 'ttfmp_dismiss_' . $id );
			$classes = array( 'notice', 'notice-' . $type );

			// Add dismissible class
			if ( true === $dismiss ) {
				$classes[] = 'is-dismissible';
			}

			// CSS and JS in pre-4.2 rely on the error and updated classes
			if ( false === $this->support['types'] ) {
				if ( in_array( $type, array( 'warning', 'error' ) ) ) {
					$classes[] = 'error';
				} else if ( in_array( $type, array( 'success', 'info' ) ) ) {
					$classes[] = 'updated';
				}
			}

			// Convert classes to string
			$classes = implode( ' ', $classes );

			// Render
			?>
			<div id="ttfmp-notice-<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $classes ); ?>" data-nonce="<?php echo esc_attr( $nonce ); ?>">
				<?php if ( true === $dismiss && false === $this->support['dismissible'] ) : ?>
					<a class="ttfmp-dismiss" href="#"><?php esc_html_e( 'Hide', 'make' ); ?></a>
				<?php endif; ?>
				<?php echo wpautop( $message ); ?>
			</div>
			<?php
		}
	}

	/**
	 * Output the JS to hide admin notices.
	 *
	 * @since 1.6.0.
	 *
	 * @return void
	 */
	public function print_admin_notices_js() {
		?>
		<script type="application/javascript">
			/* Make Plus admin notices */
			/* <![CDATA[ */
			(function($) {
				$('.notice').on('click', '.ttfmp-dismiss, .notice-dismiss', function(evt) {
					evt.preventDefault();

					var $target = $(evt.target),
						$parent = $target.parents('.notice').first(),
						id      = $parent.attr('id').replace('ttfmp-notice-', ''),
						nonce   = $parent.data('nonce');

					$.post(
						ajaxurl,
						{
							action : 'ttfmp_hide_notice',
							nid    : id,
							nonce  : nonce
						}
					).done(function(data) {
						if (1 === parseInt(data, 10) && $target.hasClass('ttfmp-dismiss')) {
							$parent.fadeOut('slow', function() {
								$(this).remove();
							});
						}
					});
				});
			})(jQuery);
			/* ]]> */
		</script>
		<?php
	}

	/**
	 * Process the Ajax request to hide an admin notice.
	 *
	 * @since 1.6.0.
	 *
	 * @return void
	 */
	public function handle_ajax() {
		// Get POST parameters
		$nid   = isset( $_POST['nid'] )   ? sanitize_key( $_POST['nid'] ) : false;
		$nonce = isset( $_POST['nonce'] ) ? $_POST['nonce']               : false;

		// Check requirements
		if (
			! defined( 'DOING_AJAX' ) ||
			true !== DOING_AJAX ||
			false === $nid ||
			false === $nonce ||
			! wp_verify_nonce( $nonce, 'ttfmp_dismiss_' . $nid )
		) {
			// Requirement check failed. Bail.
			wp_die();
		}

		// Get the user's array of dismissed notices
		$user_id = get_current_user_id();
		$dismissed = get_user_meta( $user_id, 'ttfmp-dismissed-notices', true );
		if ( ! $dismissed ) {
			$dismissed = array();
		}

		// Add a new notice to the array
		$dismissed[] = $nid;
		$success = update_user_meta( $user_id, 'ttfmp-dismissed-notices', $dismissed );

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
	public function sanitize_message( $message ) {
		$allowedtags = wp_kses_allowed_html();
		$allowedtags['a']['target'] = true;
		return wp_kses( $message, $allowedtags );
	}
}

/**
 * Instantiate or return the one TTFMP_Admin_Notice instance.
 *
 * @since  1.6.0.
 *
 * @return TTFMP_Admin_Notice
 */
function ttfmp_admin_notice() {
	return TTFMP_Admin_Notice::instance();
}

/**
 * Fire the init function immediately.
 */
ttfmp_admin_notice()->init();

/**
 * Wrapper function to register an admin notice.
 *
 * @since 1.6.0.
 *
 * @param string    $id         A unique ID string for the admin notice.
 * @param string    $message    The content of the admin notice.
 * @param array     $args       Array of configuration parameters for the admin notice.
 * @return void
 */
function ttfmp_register_admin_notice( $id, $message, $args ) {
	ttfmp_admin_notice()->register_admin_notice( $id, $message, $args );
}
endif;