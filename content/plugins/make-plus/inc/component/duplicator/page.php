<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_Duplicator_Page
 *
 * Enable one-click duplication of Builder pages.
 *
 * @since 1.1.0.
 * @since 1.7.0. Changed class name from TTFMP_Page_Duplicator.
 */
class MAKEPLUS_Component_Duplicator_Page extends MAKEPLUS_Util_Modules implements MAKEPLUS_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'notice' => 'MAKEPLUS_Admin_NoticeInterface',
	);

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private static $hooked = false;

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

		// Add duplicate link to list of page actions
		add_filter( 'page_row_actions', array( $this, 'page_row_actions' ), 10, 2 );

		// Look for URL to create page copy
		add_action( 'admin_init', array( $this, 'create_page_copy_router' ), 11 );

		// Add duplicator button in the page
		add_action( 'post_submitbox_misc_actions', array( $this, 'post_submitbox_misc_actions' ) );

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
	 * Add link to initiate duplication of page.
	 *
	 * @since 1.1.0.
	 *
	 * @hooked filter page_row_actions
	 *
	 * @param array   $actions    Array of page row actions.
	 * @param WP_Post $post       The current post object.
	 *
	 * @return array              Modified page row actions.
	 */
	public function page_row_actions( $actions, $post ) {
		if ( 'template-builder.php' === get_page_template_slug( $post ) ) {
			$url = add_query_arg(
				array(
					'ttfmp-duplicate-nonce' => wp_create_nonce( 'duplicate' ),
					'page-id'               => $post->ID,
				),
				admin_url( 'options.php' )
			);
			$actions['duplicate'] = '<a href="' . esc_url( $url ) . '" title="' . esc_attr__( 'Duplicate Page', 'make-plus' ) . '">' . esc_html__( 'Duplicate', 'make-plus' ) . '</a>';
		}

		return $actions;
	}

	/**
	 * Detect request to create a page copy and route the request.
	 *
	 * @since 1.1.0.
	 *
	 * @hooked action admin_init
	 *
	 * @return void
	 */
	public function create_page_copy_router() {
		if ( ! isset( $_GET['ttfmp-duplicate-nonce'] ) || ! wp_verify_nonce( $_GET['ttfmp-duplicate-nonce'], 'duplicate' ) ) {
			return;
		}

		if ( ! isset( $_GET['page-id'] ) ) {
			return;
		}

		// Attempt to get the page to copy
		$this_page = get_post( $_GET['page-id'] );

		if ( ! is_null( $this_page ) ) {
			$new_page_id = $this->create_page_copy( $this_page, $_GET['page-id'] );

			if ( 0 !== (int) $new_page_id && ! is_wp_error( $new_page_id ) ) {
				// Add success message
				$this->notice()->register_one_time_admin_notice(
					esc_html__( 'Your page was successfully copied.', 'make-plus' ),
					wp_get_current_user(),
					array(
						'type' => 'success'
					)
				);

				// Redirect to created page
				$redirect = add_query_arg(
					array(
						'post'   => $new_page_id,
						'action' => 'edit',
					),
					admin_url( 'post.php' )
				);
				wp_safe_redirect( $redirect );
			} else {
				// Set the error and redirect
				$this->notice()->register_one_time_admin_notice(
					esc_html__( 'Error occurred while trying to create a page copy. Please try again.', 'make-plus' ),
					wp_get_current_user(),
					array(
						'type' => 'error'
					)
				);

				wp_safe_redirect( wp_get_referer() );
			}
		} else {
			// Set the error and redirect
			$this->notice()->register_one_time_admin_notice(
				esc_html__( 'An unexpected error occurred while trying to create a page copy. Please try again.', 'make-plus' ),
				wp_get_current_user(),
				array(
					'type' => 'error'
				)
			);

			wp_safe_redirect( wp_get_referer() );
		}

		exit();
	}

	/**
	 * Create a new page.
	 *
	 * @since 1.1.0.
	 *
	 * @param WP_Post $page       The Post object for the page to be duplicated.
	 * @param int     $page_id    The ID for the page to be duplicated.
	 *
	 * @return int                The ID of the newly created page.
	 */
	private function create_page_copy( $page, $page_id ) {
		// Generate the new title
		// Translators: this string is appended to a page title to indicate that it is a copy of another page
		$copy_text = esc_html__( '(Copy)', 'make-plus' );
		$title     = trim( $page->post_title . ' ' . $copy_text );

		// Replace the page's title
		$page->post_title = $title;

		// Reset the ID so it does not update the existing post
		$page->ID = 0;

		// Save the post
		$new_page_id = wp_insert_post( $page );

		// Process metadata if post was added successfully
		if ( 0 !== (int) $new_page_id || ! is_wp_error( $new_page_id ) ) {
			// Get the target's post metadata
			$meta = get_post_custom( $page_id );

			// Save each metadata value to the new post
			foreach ( $meta as $key => $value_as_array ) {
				if ( isset( $value_as_array[0] ) ) {
					add_post_meta( $new_page_id, $key, maybe_unserialize( $value_as_array[0] ) );
				}
			}
		}

		return $new_page_id;
	}

	/**
	 * Display button for duplicating posts.
	 *
	 * @since 1.1.0.
	 *
	 * @hooked action post_submitbox_misc_actions
	 *
	 * @return void
	 */
	public function post_submitbox_misc_actions() {
		global $pagenow;

		if ( ( 'post.php' !== $pagenow && 'post-new.php' !== $pagenow ) || 'page' !== get_post_type() ) {
			return;
		}

		$url = add_query_arg(
			array(
				'ttfmp-duplicate-nonce' => wp_create_nonce( 'duplicate' ),
				'page-id'               => get_the_ID(),
			),
			admin_url( 'options.php' )
		);
		?>
		<div class="misc-pub-section ttfmake-duplicator">
			<a style="float:right;" class="ttfmp-duplicator-button button" href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( 'Duplicate Page', 'make-plus' ); ?></a>
			<div class="clear"></div>
		</div>
		<?php
	}
}