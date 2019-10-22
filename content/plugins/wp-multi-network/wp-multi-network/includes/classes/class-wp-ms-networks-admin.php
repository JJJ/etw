<?php
/**
 * WP_MS_Networks_Admin class
 *
 * @package WPMN
 * @since 1.3.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class used to implement the network admin functionality and UI.
 *
 * @since 1.3.0
 */
class WP_MS_Networks_Admin {

	/**
	 * Internal storage for feedback strings to avoid generating them multiple times.
	 *
	 * @since 2.0.0
	 * @var array
	 */
	private $feedback_strings = array();

	/**
	 * Constructor.
	 *
	 * Hooks in the necessary methods.
	 *
	 * @since 1.3.0
	 */
	public function __construct() {
		$this->set_feedback_strings();

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'network_admin_menu', array( $this, 'network_admin_menu' ) );
		add_action( 'network_admin_menu', array( $this, 'network_admin_menu_separator' ) );

		add_action( 'admin_init', array( $this, 'route_save_handlers' ) );

		add_action( 'network_admin_notices', array( $this, 'network_admin_notices' ) );

		add_filter( 'manage_sites_action_links', array( $this, 'add_move_blog_link' ), 10, 2 );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Add the Move action to the Sites page on WP >= 3.1.
	 *
	 * @since 1.3.0
	 *
	 * @param array $actions Array of action links.
	 * @param int   $blog_id Current site ID.
	 * @return array Adjusted action links.
	 */
	public function add_move_blog_link( $actions = array(), $blog_id = 0 ) {

		// Bail if main site for network.
		if ( (int) get_current_site()->blog_id === (int) $blog_id ) {
			return $actions;
		}

		$url = $this->admin_url( array(
			'action'  => 'move',
			'blog_id' => (int) $blog_id,
		) );

		if ( current_user_can( 'manage_networks' ) ) {
			$actions['move'] = '<a href="' . esc_url( $url ) . '" class="move">' . esc_html__( 'Move', 'wp-multi-network' ) . '</a>';
		}

		return $actions;
	}

	/**
	 * Adds the My Networks page to the site-level dashboard.
	 *
	 * If the user is super admin on another network, don't require elevated
	 * permissions on the current site.
	 *
	 * @since 1.3.0
	 */
	public function admin_menu() {

		// Bail if user has no networks.
		if ( ! user_has_networks() ) {
			return;
		}

		add_dashboard_page( esc_html__( 'My Networks', 'wp-multi-network' ), esc_html__( 'My Networks', 'wp-multi-network' ), 'read', 'my-networks', array( $this, 'page_my_networks' ) );
	}

	/**
	 * Add Networks menu and entries to the network-level dashboard
	 *
	 * This method puts the cart before the horse, and could maybe live in the
	 * WP_MS_Networks_List_Table class also.
	 *
	 * @since 1.3.0
	 */
	public function network_admin_menu() {
		$page = add_menu_page( esc_html__( 'Networks', 'wp-multi-network' ), esc_html__( 'Networks', 'wp-multi-network' ), 'manage_networks', 'networks', array( $this, 'route_pages' ), 'dashicons-networking', -1 );

		add_submenu_page( 'networks', esc_html__( 'All Networks', 'wp-multi-network' ), esc_html__( 'All Networks', 'wp-multi-network' ), 'list_networks', 'networks', array( $this, 'route_pages' ) );
		add_submenu_page( 'networks', esc_html__( 'Add New', 'wp-multi-network' ), esc_html__( 'Add New', 'wp-multi-network' ), 'create_networks', 'add-new-network', array( $this, 'page_edit_network' ) );

		add_action( "admin_head-{$page}", array( $this, 'fix_menu_highlight_for_move_page' ) );

		require_once wpmn()->plugin_dir . '/includes/classes/class-wp-ms-networks-list-table.php';
	}

	/**
	 * Adds a separator between the 'Networks' and 'Dashboard' menu items on the
	 * network dashboard.
	 *
	 * @since 1.5.2
	 */
	public function network_admin_menu_separator() {
		$GLOBALS['menu']['-2'] = array( '', 'read', 'separator', '', 'wp-menu-separator' ); // phpcs:ignore WordPress.Variables.GlobalVariables.OverrideProhibited
	}

	/**
	 * Fixes the menu highlight for the "Move" page, which is technically
	 * under the "Sites" menu.
	 *
	 * @since 2.2.0
	 *
	 * @global string $plugin_page
	 * @global string $submenu_file
	 */
	public function fix_menu_highlight_for_move_page() {
		global $plugin_page, $submenu_file;

		if ( 'networks' === $plugin_page ) {
			$action = filter_input( INPUT_GET, 'action' );
			if ( 'move' === $action ) {
				$submenu_file = 'sites.php'; // phpcs:ignore WordPress.Variables.GlobalVariables.OverrideProhibited
			}
		}
	}

	/**
	 * Registers and enqueues JavaScript on networks admin pages.
	 *
	 * @since 2.0.0
	 *
	 * @param string $page Optional. Current page hook. Default empty string.
	 */
	public function enqueue_scripts( $page = '' ) {

		// Bail if not a network page.
		if ( ! in_array( $page, array( 'toplevel_page_networks', 'networks_page_add-new-network' ), true ) ) {
			return;
		}

		wp_register_style( 'wp-multi-network', wpmn()->plugin_url . 'assets/css/wp-multi-network.css', array(), wpmn()->asset_version, false );
		wp_register_script( 'wp-multi-network', wpmn()->plugin_url . 'assets/js/wp-multi-network.js', array( 'jquery', 'post' ), wpmn()->asset_version, true );

		wp_enqueue_style( 'wp-multi-network' );
		wp_enqueue_script( 'wp-multi-network' );
	}

	/**
	 * Sets feedback strings for network admin actions.
	 *
	 * @since 2.1.0
	 */
	private function set_feedback_strings() {
		$this->feedback_strings = array(
			'network_updated' => array(
				'1' => esc_html__( 'Network updated.', 'wp-multi-network' ),
				'0' => esc_html__( 'Network not updated.', 'wp-multi-network' ),
			),
			'network_created' => array(
				'1' => esc_html__( 'Network created.', 'wp-multi-network' ),
				'0' => esc_html__( 'Network not created.', 'wp-multi-network' ),
			),
			'network_deleted' => array(
				'1' => esc_html__( 'Network deleted.', 'wp-multi-network' ),
				'0' => esc_html__( 'Network not deleted.', 'wp-multi-network' ),
			),
			'site_moved'      => array(
				'1' => esc_html__( 'Site moved.', 'wp-multi-network' ),
				'0' => esc_html__( 'Site not moved.', 'wp-multi-network' ),
			),
		);
	}

	/**
	 * Prints feedback notices for network admin actions as necessary.
	 *
	 * @since 1.3.0
	 */
	public function network_admin_notices() {
		$message = '';
		$type    = '';
		foreach ( $this->feedback_strings as $slug => $messages ) {
			$passed = filter_input( INPUT_GET, $slug );

			if ( is_string( $passed ) ) {
				if ( '1' === $passed ) {
					$message = $messages['1'];
					$type    = 'updated';
				} else {
					$message = $messages['0'];
					$type    = 'error';
				}

				break;
			}
		}

		if ( empty( $message ) || empty( $type ) ) {
			return;
		}
		?>

		<div id="message" class="<?php echo esc_attr( $type ); ?> notice is-dismissible">
			<p>
				<?php echo esc_html( $message ); ?>
				<a href="<?php echo esc_url( $this->admin_url() ); ?>"><?php esc_html_e( 'Back to Networks.', 'wp-multi-network' ); ?></a>
			</p>
			<button type="button" class="notice-dismiss">
				<span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice', 'wp-multi-network' ); ?></span>
			</button>
		</div>

		<?php
	}

	/**
	 * Routes the current request to the correct page.
	 *
	 * @since 2.0.0
	 */
	public function route_pages() {

		// Bail if lacking capabilities.
		if ( ! current_user_can( 'manage_networks' ) ) {
			wp_die( esc_html__( 'You do not have permission to access this page.', 'wp-multi-network' ) );
		}

		$action = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );
		$action = sanitize_key( $action );

		switch ( $action ) {

			// Move a site.
			case 'move':
				$this->page_move_site();
				break;

			// Delete a network.
			case 'delete_network':
				$this->page_delete_network();
				break;

			// Edit a network.
			case 'edit_network':
				$this->page_edit_network();
				break;

			// View the list of networks, with bulk action handling.
			case 'all_networks':
				$doaction = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );
				if ( empty( $doaction ) || '-1' === $doaction ) {
					$doaction = filter_input( INPUT_POST, 'action2', FILTER_SANITIZE_STRING );
				}
				$doaction = sanitize_key( $doaction );

				switch ( $doaction ) {
					case 'delete':
						$this->page_delete_networks();
						break;
					default:
						$this->page_all_networks();
						break;
				}
				break;

			// View the list of networks.
			default:
				$this->page_all_networks();
				break;
		}
	}

	/**
	 * Handles network management form submissions.
	 *
	 * @since 2.0.0
	 */
	public function route_save_handlers() {

		// Bail -- our fields aren't being edited
		// Otherwise we'll do an unnecessary nonce check
		if ( empty( $_POST['network_edit'] ) ) {
			return;
		}
		
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );
		if ( empty( $action ) ) {
			$alternative_actions = array( 'delete', 'delete_multiple', 'move' );
			foreach ( $alternative_actions as $alternative_action ) {
				if ( filter_input( INPUT_POST, $alternative_action ) ) {
					$action = $alternative_action;
					break;
				}
			}
		}

		switch ( $action ) {

			// Create network.
			case 'create':
				$this->check_nonce();
				$this->handle_add_network();
				break;

			// Update network.
			case 'update':
				$this->check_nonce();
				$this->handle_reassign_sites();
				$this->handle_update_network();
				break;

			// Delete network.
			case 'delete':
				$this->check_nonce();
				$this->handle_delete_network();
				break;

			// Delete multiple networks.
			case 'delete_multiple':
				$this->check_nonce();
				$this->handle_delete_networks();
				break;

			// Move site to different network.
			case 'move':
				$this->check_nonce();
				$this->handle_move_site();
				break;
		}
	}

	/**
	 * Renders the new network creation dashboard page.
	 *
	 * @since 2.0.0
	 */
	public function page_edit_network() {
		$network_id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT );
		$network    = $network_id ? get_network( $network_id ) : null;

		add_meta_box( 'wpmn-edit-network-details', esc_html__( 'Details', 'wp-multi-network' ), 'wpmn_edit_network_details_metabox', get_current_screen()->id, 'normal', 'high', array( $network ) );
		add_meta_box( 'wpmn-edit-network-publish', esc_html__( 'Network', 'wp-multi-network' ), 'wpmn_edit_network_publish_metabox', get_current_screen()->id, 'side', 'high', array( $network ) );

		// Differentiate between a new network and an existing network.
		if ( empty( $network ) ) {
			$network_title = '';

			add_meta_box( 'wpmn-edit-network-new-site', esc_html__( 'Root Site', 'wp-multi-network' ), 'wpmn_edit_network_new_site_metabox', get_current_screen()->id, 'advanced', 'high', array( $network ) );
		} else {
			$network_title = get_network_option( $network->id, 'site_name', '' );

			add_meta_box( 'wpmn-edit-network-assign-sites', esc_html__( 'Site Assignment', 'wp-multi-network' ), 'wpmn_edit_network_assign_sites_metabox', get_current_screen()->id, 'advanced', 'high', array( $network ) );
		}

		$add_network_url = $this->admin_url( array( 'page' => 'add-new-network' ) );
		?>

		<div class="wrap">
			<h1>
				<?php
				if ( ! empty( $network ) ) {
					esc_html_e( 'Edit Network', 'wp-multi-network' );

					if ( current_user_can( 'create_networks' ) ) {
						?>
						<a href="<?php echo esc_url( $add_network_url ); ?>" class="add-new-h2"><?php echo esc_html_x( 'Add New', 'network', 'wp-multi-network' ); ?></a>
						<?php
					}
				} else {
					esc_html_e( 'Add New Network', 'wp-multi-network' );
				}
				?>
			</h1>

			<form method="post" id="edit-network-form" action="">
				<div id="poststuff">
					<div id="post-body" class="metabox-holder columns-2">
						<div id="post-body-content" style="position: relative;">
							<div id="titlediv">
								<div id="titlewrap">
									<label class="screen-reader-text" id="title-prompt-text" for="title"><?php echo esc_html_e( 'Enter network title here', 'wp-multi-network' ); ?></label>
									<input type="text" name="title" size="30" id="title" spellcheck="true" autocomplete="off" value="<?php echo esc_attr( $network_title ); ?>">
								</div>
							</div>
						</div>

						<div id="postbox-container-1" class="postbox-container">
							<?php do_meta_boxes( get_current_screen()->id, 'side', $network ); ?>
						</div>

						<div id="postbox-container-2" class="postbox-container">
							<?php do_meta_boxes( get_current_screen()->id, 'normal', $network ); ?>
							<?php do_meta_boxes( get_current_screen()->id, 'advanced', $network ); ?>
						</div>
					</div>
				</div>
			</form>
		</div>

		<?php
	}

	/**
	 * Renders the network listing dashboard page.
	 *
	 * @since 2.0.0
	 *
	 * @uses WP_MS_Networks_List_Table List_Table iterator for networks
	 */
	private function page_all_networks() {
		$wp_list_table = new WP_MS_Networks_List_Table();
		$wp_list_table->prepare_items();

		$add_network_url  = $this->admin_url( array( 'page' => 'add-new-network' ) );
		$all_networks_url = $this->admin_url( array( 'action' => 'all_networks' ) );
		$search_url       = $this->admin_url( array( 'action' => 'domains' ) );

		$search_text = filter_input( INPUT_POST, 's', FILTER_SANITIZE_STRING );
		?>

		<div class="wrap">
			<h1>
				<?php
				esc_html_e( 'Networks', 'wp-multi-network' );

				if ( current_user_can( 'create_networks' ) ) {
					?>
					<a href="<?php echo esc_url( $add_network_url ); ?>" class="add-new-h2"><?php echo esc_html_x( 'Add New', 'network', 'wp-multi-network' ); ?></a>
					<?php
				}

				if ( ! empty( $search_text ) ) {
					/* translators: %s: search text */
					printf( '<span class="subtitle">' . esc_html__( 'Search results for &#8220;%s&#8221;', 'wp-multi-network' ) . '</span>', esc_html( $search_text ) );
				}
				?>
			</h1>

			<form method="post" action="<?php echo esc_url( $search_url ); ?>" id="domain-search">
				<?php $wp_list_table->search_box( esc_html__( 'Search Networks', 'wp-multi-network' ), 'networks' ); ?>
				<input type="hidden" name="action" value="domains">
			</form>

			<form method="post" id="form-domain-list" action="<?php echo esc_url( $all_networks_url ); ?>">
				<?php $wp_list_table->display(); ?>
			</form>
		</div>

		<?php
	}

	/**
	 * Renders the dashboard screen for moving sites -- accessed from the "Sites" screen.
	 *
	 * @since 2.0.0
	 */
	private function page_move_site() {
		$site_id = filter_input( INPUT_GET, 'blog_id', FILTER_SANITIZE_NUMBER_INT );
		$site    = $site_id ? get_site( $site_id ) : null;

		// Bail if invalid site ID.
		if ( empty( $site ) ) {
			wp_die( esc_html__( 'Invalid site id.', 'wp-multi-network' ) );
		}

		add_meta_box( 'wpmn-move-site-list', esc_html__( 'Assign Network', 'wp-multi-network' ), 'wpmn_move_site_list_metabox', get_current_screen()->id, 'normal', 'high', array( $site ) );
		add_meta_box( 'wpmn-move-site-publish', esc_html__( 'Site', 'wp-multi-network' ), 'wpmn_move_site_assign_metabox', get_current_screen()->id, 'side', 'high', array( $site ) );

		$add_network_url = $this->admin_url( array( 'page' => 'add-new-network' ) );
		?>

		<div class="wrap">
			<h1>
				<?php
				esc_html_e( 'Networks', 'wp-multi-network' );

				if ( current_user_can( 'create_networks' ) ) {
					?>
					<a href="<?php echo esc_url( $add_network_url ); ?>" class="add-new-h2"><?php echo esc_html_x( 'Add New', 'network', 'wp-multi-network' ); ?></a>
					<?php
				}
				?>
			</h1>

			<form method="post" action="<?php echo esc_attr( filter_input( INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING ) ); ?>">
				<div id="poststuff">
					<div id="post-body" class="metabox-holder columns-2">
						<div id="postbox-container-1" class="postbox-container">
							<?php do_meta_boxes( get_current_screen()->id, 'side', $site ); ?>
						</div>

						<div id="postbox-container-2" class="postbox-container">
							<?php do_meta_boxes( get_current_screen()->id, 'normal', $site ); ?>
							<?php do_meta_boxes( get_current_screen()->id, 'advanced', $site ); ?>
						</div>
					</div>
				</div>
			</form>
		</div>

		<?php
	}

	/**
	 * Renders the delete network page.
	 *
	 * @since 2.0.0
	 */
	private function page_delete_network() {
		$network_id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT );
		$network    = $network_id ? get_network( $network_id ) : null;

		// Bail if invalid network ID.
		if ( empty( $network ) ) {
			wp_die( esc_html__( 'Invalid network id.', 'wp-multi-network' ) );
		}

		$sites = get_sites( array( 'network_id' => $network->id ) );

		$add_network_url = $this->admin_url( array( 'page' => 'add-new-network' ) );
		?>

		<div class="wrap">
			<h1>
				<?php
				esc_html_e( 'Delete Network', 'wp-multi-network' );

				if ( current_user_can( 'create_networks' ) ) {
					?>
					<a href="<?php echo esc_url( $add_network_url ); ?>" class="add-new-h2"><?php echo esc_html_x( 'Add New', 'network', 'wp-multi-network' ); ?></a>
					<?php
				}
				?>
			</h1>

			<form method="post" action="<?php echo esc_attr( remove_query_arg( 'action' ) ); ?>">
				<?php

				if ( ! empty( $sites ) ) {
					?>

					<div id="message" class="network-delete">
						<p><?php esc_html_e( 'The following sites are associated with this network:', 'wp-multi-network' ); ?></p>
						<ul class="delete-sites">
							<?php

							foreach ( $sites as $site ) {
								?>
								<li><?php echo esc_html( $site->domain . $site->path ); ?></li>
								<?php
							}

							?>
						</ul>
						<p>
							<input type="checkbox" name="override" id="override">
							<label for="override">
							<?php
							if ( wp_should_rescue_orphaned_sites() ) {
								esc_html_e( 'Rescue these sites', 'wp-multi-network' );
							} else {
								esc_html_e( 'Delete these sites', 'wp-multi-network' );
							}
							?>
							</label>
						</p>
					</div>
					<p>
						<?php
						printf(
							/* translators: %s: network domain and path */
							esc_html__( 'Are you sure you want to delete the entire "%s" network?', 'wp-multi-network' ),
							esc_html( $network->domain . $network->path )
						);
						?>
					</p>

					<?php
				}

				wp_nonce_field( 'edit_network', 'network_edit' );

				submit_button( esc_html__( 'Delete Network', 'wp-multi-network' ), 'primary', 'delete', false );
				?>

				<a class="button" href="<?php echo esc_url( $this->admin_url() ); ?>"><?php esc_html_e( 'Cancel', 'wp-multi-network' ); ?></a>
			</form>
		</div>

		<?php
	}

	/**
	 * Renders the delete multiple networks page.
	 *
	 * @since 2.0.0
	 */
	private function page_delete_networks() {
		$network_id   = get_main_network_id();
		$all_networks = filter_input( INPUT_POST, 'all_networks', FILTER_FORCE_ARRAY );
		$all_networks = array_map( 'absint', $all_networks );
		$all_networks = array_diff( $all_networks, array( $network_id ) );

		$networks = get_networks( array(
			'network__in' => $all_networks,
		) );

		// Bail if no networks found.
		if ( empty( $networks ) ) {
			wp_die( esc_html__( 'You have selected an invalid network or networks for deletion', 'wp-multi-network' ) );
		}

		foreach ( $networks as $network ) {
			if ( ! get_network( $network ) ) {
				wp_die( esc_html__( 'You have selected an invalid network for deletion.', 'wp-multi-network' ) );
			}
		}

		$sites = get_sites( array(
			'network__in' => $all_networks,
		) );
		?>

		<div class="wrap">
			<h1><?php esc_html_e( 'Networks', 'wp-multi-network' ); ?></h1>
			<h3><?php esc_html_e( 'Delete Multiple Networks', 'wp-multi-network' ); ?></h3>
			<form method="post" action="<?php echo esc_url( $this->admin_url() ); ?>">
				<?php

				if ( ! empty( $sites ) ) {
					?>

					<div class="error inline">
						<h3><?php esc_html_e( 'You have selected the following networks for deletion', 'wp-multi-network' ); ?>:</h3>
						<ul>
							<?php

							foreach ( $networks as $deleted_network ) {
								?>
								<li><input type="hidden" name="deleted_networks[]" value="<?php echo esc_attr( $deleted_network->id ); ?>"><?php echo esc_html( $deleted_network->domain . $deleted_network->path ); ?></li>
								<?php
							}

							?>
						</ul>
						<p>
						<?php
						if ( wp_should_rescue_orphaned_sites() ) {
							esc_html_e( 'One or more of these networks have sites. Deleting these networks will orphan their sites.', 'wp-multi-network' );
						} else {
							esc_html_e( 'One or more of these networks have sites. Deleting these networks will permanently delete their sites.', 'wp-multi-network' );
						}
						?>
						</p>
						<p>
							<label for="override"><?php esc_html_e( 'Please confirm that you still want to delete these networks', 'wp-multi-network' ); ?>:</label>
							<input type="checkbox" name="override" id="override">
						</p>
					</div>

					<?php
				} else {
					?>

					<div id="message inline">
						<h3><?php esc_html_e( 'You have selected the following networks for deletion', 'wp-multi-network' ); ?>:</h3>
						<ul>
						<?php

						foreach ( $networks as $deleted_network ) :

							?>
								<li><input type="hidden" name="deleted_networks[]" value="<?php echo esc_attr( $deleted_network->id ); ?>"><?php echo esc_html( $deleted_network->domain . $deleted_network->path ); ?></li>
								<?php

							endforeach;

						?>
						</ul>
					</div>

					<?php
				}

				?>
				<p><?php esc_html_e( 'Are you sure you want to delete these networks?', 'wp-multi-network' ); ?></p>
				<?php

				wp_nonce_field( 'edit_network', 'network_edit' );

				submit_button( esc_html__( 'Delete Networks', 'wp-multi-network' ), 'primary', 'delete_multiple', false );
				?>

				<a class="button" href="<?php echo esc_url( $this->admin_url() ); ?>"><?php esc_html_e( 'Cancel', 'wp-multi-network' ); ?></a>
			</form>
		</div>

		<?php
	}

	/**
	 * Renders the my networks page.
	 *
	 * @since 2.0.0
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 */
	public function page_my_networks() {
		global $wpdb;
		?>

		<div class="wrap">
			<h1><?php esc_html_e( 'My Networks', 'wp-multi-network' ); ?></h1>

			<?php

			$my_networks = user_has_networks();
			foreach ( $my_networks as $key => $network_id ) {
				// phpcs:ignore WordPress.VIP.DirectDatabaseQuery.DirectQuery,WordPress.VIP.DirectDatabaseQuery.NoCaching
				$my_networks[ $key ] = $wpdb->get_row(
					$wpdb->prepare(
						'SELECT s.*, sm.meta_value as site_name, b.blog_id FROM ' . $wpdb->site . ' s LEFT JOIN ' . $wpdb->sitemeta . ' as sm ON sm.site_id = s.id AND sm.meta_key = %s LEFT JOIN ' . $wpdb->blogs . ' b ON s.id = b.site_id AND b.path = s.path WHERE s.id = %d',
						'site_name',
						$network_id
					)
				);
			}

			?>
			<table class="widefat fixed">
				<?php
				$num  = count( $my_networks );
				$cols = 1;
				if ( $num >= 20 ) {
					$cols = 4;
				} elseif ( $num >= 10 ) {
					$cols = 2;
				}
				$num_rows = ceil( $num / $cols );
				$split    = 0;
				for ( $i = 1; $i <= $num_rows; $i++ ) {
					$rows[] = array_slice( $my_networks, $split, $cols );
					$split  = $split + $cols;
				}

				$c = '';
				foreach ( $rows as $row ) {
					$c = ( 'alternate' === $c ) ? '' : 'alternate';
					echo "<tr class='" . esc_attr( $c ) . "'>";
					$i = 0;
					foreach ( $row as $network ) {
						$s = ( 3 === $i ) ? '' : 'border-right: 1px solid #ccc;';
						switch_to_network( $network->id );
						?>

						<td valign='top' style='<?php echo esc_attr( $s ); ?>'>
							<h3><?php echo esc_html( $network->site_name ); ?></h3>
							<p>
								<?php
								$network_actions = array(
									"<a href='" . network_home_url() . "'>" . esc_html__( 'Visit', 'wp-multi-network' ) . '</a>',
									"<a href='" . network_admin_url() . "'>" . esc_html__( 'Dashboard', 'wp-multi-network' ) . '</a>',
								);
								$network_actions = implode( ' | ', $network_actions );

								/**
								 * Filters the action links printed on the My Networks page.
								 *
								 * @since 2.0.0
								 *
								 * @param string     $network_actions Network action links, separated by pipe ( | ) characters.
								 * @param WP_Network $network         Current network object.
								 */
								echo apply_filters( 'mynetworks_network_actions', $network_actions, $network ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
								?>
							</p>
						</td>

						<?php
						restore_current_network();
						$i++;
					}
					echo '</tr>';
				}
				?>
			</table>
		</div>

		<?php
	}

	/**
	 * Handles the request to add a new network.
	 *
	 * @since 2.0.0
	 */
	private function handle_add_network() {
		$options_to_clone = filter_input( INPUT_POST, 'options_to_clone', FILTER_FORCE_ARRAY );
		if ( ! empty( $options_to_clone ) ) {
			$options_to_clone = array_keys( $options_to_clone );
		} else {
			$options_to_clone = array_keys( network_options_to_copy() );
		}

		$clone = filter_input( INPUT_POST, 'clone_network', FILTER_SANITIZE_NUMBER_INT );
		if ( empty( $clone ) ) {
			$clone = get_current_site()->id;
		}

		$network_title  = wp_unslash( filter_input( INPUT_POST, 'title', FILTER_SANITIZE_STRING ) );
		$network_domain = wp_unslash( filter_input( INPUT_POST, 'domain', FILTER_SANITIZE_STRING ) );
		$network_path   = wp_unslash( filter_input( INPUT_POST, 'path', FILTER_SANITIZE_STRING ) );
		$site_name      = wp_unslash( filter_input( INPUT_POST, 'new_site', FILTER_SANITIZE_STRING ) );

		$network_title  = strip_tags( $network_title );
		$network_domain = str_replace( ' ', '', strtolower( sanitize_text_field( $network_domain ) ) );
		$network_path   = str_replace( ' ', '', strtolower( sanitize_text_field( $network_path ) ) );
		$site_name      = ! empty( $site_name ) ? strip_tags( $site_name ) : $network_title;

		// Bail if missing fields.
		if ( empty( $network_title ) || empty( $network_domain ) || empty( $network_path ) ) {
			$this->handle_redirect( array(
				'page'            => 'add-new-network',
				'network_created' => '0',
			) );
		}

		$result  = add_network( array(
			'domain'           => $network_domain,
			'path'             => $network_path,
			'site_name'        => $site_name,
			'user_id'          => get_current_user_id(),
			'clone_network'    => $clone,
			'options_to_clone' => $options_to_clone,
		) );
		$success = '0';

		if ( ! empty( $result ) && ! is_wp_error( $result ) ) {
			if ( ! empty( $posted['title'] ) ) {
				update_network_option( $result, 'site_name', $posted['title'] );
			}

			update_network_option( $result, 'active_sitewide_plugins', array(
				'wp-multi-network/wpmn-loader.php' => time(),
			) );

			$success = '1';
		}

		$this->handle_redirect( array(
			'network_created' => $success,
		) );
	}

	/**
	 * Handles the request to update a network.
	 *
	 * @since 2.0.0
	 */
	private function handle_update_network() {
		$network_id = filter_input( INPUT_POST, 'network_id', FILTER_SANITIZE_NUMBER_INT );

		// Bail if invalid network.
		if ( ! get_network( $network_id ) ) {
			wp_die( esc_html__( 'Invalid network id.', 'wp-multi-network' ) );
		}

		$network_title  = wp_unslash( filter_input( INPUT_POST, 'title', FILTER_SANITIZE_STRING ) );
		$network_domain = wp_unslash( filter_input( INPUT_POST, 'domain', FILTER_SANITIZE_STRING ) );
		$network_path   = wp_unslash( filter_input( INPUT_POST, 'path', FILTER_SANITIZE_STRING ) );

		$network_title  = sanitize_text_field( $network_title );
		$network_domain = Requests_IDNAEncoder::encode( str_replace( ' ', '', strtolower( sanitize_text_field( $network_domain ) ) ) );
		$network_path   = str_replace( ' ', '', strtolower( sanitize_text_field( $network_path ) ) );

		// Bail if missing fields.
		if ( empty( $network_title ) || empty( $network_domain ) || empty( $network_path ) ) {
			$this->handle_redirect( array(
				'id'              => $network_id,
				'action'          => 'edit_network',
				'network_updated' => '0',
			) );
		}

		$updated = update_network( $network_id, $network_domain, $network_path );
		$success = '0';

		if ( ! is_wp_error( $updated ) ) {
			update_network_option( $network_id, 'site_name', $network_title );
			$success = '1';
		}

		$this->handle_redirect( array(
			'id'              => $network_id,
			'action'          => 'edit_network',
			'network_updated' => $success,
		) );
	}

	/**
	 * Handles the request to move a site to another network.
	 *
	 * @since 2.0.0
	 */
	private function handle_move_site() {
		$site_id     = filter_input( INPUT_GET, 'blog_id', FILTER_SANITIZE_NUMBER_INT );
		$new_network = filter_input( INPUT_POST, 'to', FILTER_SANITIZE_NUMBER_INT );

		if ( empty( $site_id ) ) {
			wp_safe_redirect( add_query_arg( array(
				'site_moved' => 0,
			), network_admin_url( 'sites.php' ) ) );
			exit;
		}

		$site = get_site( $site_id );

		// Bail if site cannot be found or new network is the same as existing.
		if ( empty( $site ) || ( $site->network_id === $new_network ) ) {
			wp_safe_redirect( add_query_arg( array(
				'site_moved' => 0,
			), network_admin_url( 'sites.php' ) ) );
			exit;
		}

		$moved   = move_site( $site_id, $new_network );
		$success = is_wp_error( $moved ) ? '0' : '1';

		wp_safe_redirect( add_query_arg( array(
			'site_moved' => $success,
		), network_admin_url( 'sites.php' ) ) );
		exit;
	}

	/**
	 * Handles the request to reassign sites to another network.
	 *
	 * @since 2.0.0
	 */
	private function handle_reassign_sites() {
		$to   = array_map( 'absint', (array) filter_input( INPUT_POST, 'to', FILTER_FORCE_ARRAY ) );
		$from = array_map( 'absint', (array) filter_input( INPUT_POST, 'from', FILTER_FORCE_ARRAY ) );

		// Bail early if no movement.
		if ( empty( $to ) && empty( $from ) ) {
			return;
		}

		$network_id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT );

		$moving_to   = array();
		$moving_from = array();

		$sites_list = get_sites( array(
			'network_id' => $network_id,
			'fields'     => 'ids',
		) );

		// Move sites out of current network.
		foreach ( $from as $site_id ) {
			if ( in_array( $site_id, $sites_list, true ) ) {
				$moving_from[] = $site_id;
			}
		}

		// Move sites into current network.
		foreach ( $to as $site_id ) {
			if ( ! in_array( $site_id, $sites_list, true ) ) {
				$moving_to[] = $site_id;
			}
		}

		$moving = array_filter( array_merge( $moving_to, $moving_from ) );

		// Loop through and move sites.
		foreach ( $moving as $site_id ) {
			$site = get_site( $site_id );

			// Skip if missing or main site.
			if ( empty( $site ) || is_main_site( $site->id, $site->network_id ) ) {
				continue;
			}

			if ( in_array( $site_id, $to, true ) && ! in_array( $site_id, $sites_list, true ) ) {
				move_site( $site_id, $network_id );
			} elseif ( in_array( $site_id, $from, true ) ) {
				move_site( $site_id, 0 );
			}
		}
	}

	/**
	 * Handles the request to delete a network.
	 *
	 * @since 2.0.0
	 */
	private function handle_delete_network() {
		$network_id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT );
		$override   = (bool) filter_input( INPUT_POST, 'override' );

		$result = delete_network( $network_id, $override );
		if ( is_wp_error( $result ) ) {
			wp_die( esc_html( $result->get_error_message() ) );
		}

		$this->handle_redirect( array(
			'network_deleted' => '1',
		) );
	}

	/**
	 * Handles the request to delete multiple networks.
	 *
	 * @since 2.0.0
	 */
	private function handle_delete_networks() {
		$deleted_networks = array_map( 'absint', filter_input( INPUT_POST, 'deleted_networks', FILTER_FORCE_ARRAY ) );
		$override         = (bool) filter_input( INPUT_POST, 'override' );

		foreach ( $deleted_networks as $deleted_network ) {
			$result = delete_network( $deleted_network, $override );
			if ( is_wp_error( $result ) ) {
				wp_die( esc_html( $result->get_error_message() ) );
			}
		}

		$this->handle_redirect( array(
			'networks_deleted' => '1',
		) );
	}

	/**
	 * Handles redirect after a page submit action.
	 *
	 * @since 2.0.0
	 *
	 * @param array $args Optional. URL query arguments. Default empty array.
	 */
	private function handle_redirect( $args = array() ) {
		wp_safe_redirect( $this->admin_url( $args ) );
		exit;
	}

	/**
	 * Gets the URL of the networks page.
	 *
	 * @since 1.3.0
	 *
	 * @param array $args Optional. URL query arguments. Default empty array.
	 * @return string Absolute URL to the networks page.
	 */
	private function admin_url( $args = array() ) {
		$r = wp_parse_args( $args, array(
			'page' => 'networks',
		) );

		$page = ! empty( $r['action'] ) && ( 'move' === $r['action'] ) ? 'sites.php' : 'admin.php';

		$result = add_query_arg( $r, network_admin_url( $page ) );

		/**
		 * Filters the URL to the networks admin screen.
		 *
		 * @since 2.0.0
		 *
		 * @param string $result URL including query arguments.
		 * @param array  $r      Parsed query arguments to include.
		 * @param array  $args   Original query arguments to include.
		 */
		return apply_filters( 'edit_networks_screen_url', $result, $r, $args );
	}

	/**
	 * Checks the nonce for a network management form submission.
	 *
	 * @since 2.1.0
	 */
	private function check_nonce() {
		check_admin_referer( 'edit_network', 'network_edit' );
	}
}
