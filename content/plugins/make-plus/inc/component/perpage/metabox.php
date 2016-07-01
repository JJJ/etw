<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_PerPage_Metabox
 *
 * Render the metaboxes for post/page layout settings.
 *
 * @since 1.0.0.
 * @since 1.7.0. Changed class name from TTFMP_PerPage_Metabox.
 */
class MAKEPLUS_Component_PerPage_Metabox extends MAKEPLUS_Util_Modules implements MAKEPLUS_Component_PerPage_MetaboxInterface, MAKEPLUS_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'compatibility' => 'MAKEPLUS_Compatibility_Methods',
		'sidebars'      => 'MAKEPLUS_Sidebars_ManagerInterface',
		'theme'         => 'MAKE_APIInterface',
		'settings'      => 'MAKEPLUS_Component_PerPage_SettingsInterface',
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

		// Enqueue styles and scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );

		// Add the metabox
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ), 10, 2 );

		// Save metabox data
		add_action( 'save_post', array( $this, 'save_metabox' ), 10, 2 );

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
	 * Enqueue Per Page scripts and styles if it is an edit screen.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action admin_enqueue_scripts
	 *
	 * @return void
	 */
	public function admin_enqueue() {
		$perpage_views = array_keys( $this->theme()->view()->get_views( 'is_perpage_view' ), true );
		$current_view = $this->settings()->get_view();

		if ( in_array( $current_view, $perpage_views ) ) {
			// Style
			wp_enqueue_style(
				'makeplus-perpage-admin',
				makeplus_get_plugin_directory_uri() . 'css/perpage/admin.css',
				array(),
				MAKEPLUS_VERSION
			);

			// Script
			wp_enqueue_script(
				'makeplus-perpage-admin',
				makeplus_get_plugin_directory_uri() . 'js/perpage/admin.js',
				array( 'jquery' ),
				MAKEPLUS_VERSION,
				true
			);
		}
	}

	/**
	 * Add the metabox to each qualified post type edit screen
	 *
	 * @since 1.0.0.
	 * @since 1.7.4. Added the $post_type and $post parameters.
	 *
	 * @hooked action add_meta_boxes
	 *
	 * @param string $post_type    The current post type.
	 * @param object $post         The post object.
	 *
	 * @return void
	 */
	public function add_metabox( $post_type, $post ) {
		// Bail if $post isn't actually an instance of WP_Post in the current context.
		if ( ! $post instanceof WP_Post ) {
			return;
		}

		$perpage_views = array_keys( $this->theme()->view()->get_views( 'is_perpage_view' ), true );
		$current_view = $this->settings()->get_view();

		if ( in_array( $current_view, $perpage_views ) ) {
			$view_label = $this->theme()->view()->get_view_label( $current_view );
			$metabox_label = sprintf(
				esc_html__( 'Layout settings for this %s', 'make-plus' ),
				esc_html( strtolower( $view_label ) )
			);

			add_meta_box(
				'makeplus-perpage-metabox',
				$metabox_label,
				array( $this, 'metabox_callback' ),
				$post_type,
				'side',
				'default'
			);
		}
	}

	/**
	 * Wrapper for rendering the metabox.
	 *
	 * @since 1.0.0.
	 *
	 * @param WP_Post $post    The current post.
	 *
	 * @return void
	 */
	public function metabox_callback( WP_Post $post ) {
		$current_view = $this->settings()->get_view();
		$view_label = $this->theme()->view()->get_view_label( $current_view );

		// Nonce
		wp_nonce_field( 'save_post', 'makeplus-perpage-nonce' );

		if ( has_action( "makeplus_perpage_render_metabox_{$current_view}" ) ) {
			/**
			 * Action: Fires before the default metabox callback for the current view is called.
			 *
			 * This allows for a custom metabox callback to be used in place of the default one. The provided $metabox
			 * object has methods for rendering the standard controls used for the layout settings.
			 *
			 * If this action has an action hooked to it, the default callback will not be used.
			 *
			 * @since 1.7.0.
			 *
			 * @param MAKEPLUS_Component_PerPage_Metabox $metabox
			 */
			do_action( "makeplus_perpage_render_metabox_{$current_view}", $this );

			// Do not proceed to the default callback.
			return;
		}

		// Help blurb
		echo '<p class="howto">';
		printf(
			esc_html__( '
				These controls allow you to override the global %1$s layout settings on this %1$s.
			', 'make-plus' ),
			esc_html( strtolower( $view_label ) )
		);
		echo '</p>';
		echo '<p class="howto">';
		esc_html_e( 'Clicking a link icon next to a setting will unlink it from the global value. Next, check the box to override.', 'make-plus' );
		echo '</p>';

		// Determine appropriate render function
		switch ( $current_view ) {
			case 'post' :
			default :
				$this->render_metabox_post( $post );
				break;
			case 'page' :
				$this->render_metabox_page( $post );
				break;
			case 'product' :
				$this->render_metabox_product( $post );
				break;
		}
	}

	/**
	 * Sanitize and save the submitted Per Page post meta data
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action save_post
	 *
	 * @param int     $post_id    The post ID
	 * @param WP_Post $post       The post object
	 *
	 * @return void
	 */
	public function save_metabox( $post_id, WP_Post $post ) {
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$nonce_key = 'makeplus-perpage-nonce';
		$is_valid_nonce = isset( $_POST[ $nonce_key ] ) && wp_verify_nonce( $_POST[ $nonce_key ], current_action() );

		// Exits script depending on save status
		if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
			return;
		}

		// Get $_POST arrays
		$new_overrides = ( isset( $_POST[ $this->settings()->get_prefix() . 'overrides' ] ) ) ? $_POST[ $this->settings()->get_prefix() . 'overrides' ] : false;
		$new_settings = ( isset( $_POST[ $this->settings()->get_prefix() . 'settings' ] ) ) ? $_POST[ $this->settings()->get_prefix() . 'settings' ] : false;

		if ( false === $new_overrides ) {
			// Nothing is overridden, so reset both post meta arrays
			delete_post_meta( $post_id, $this->settings()->get_prefix() . 'overrides' );
			delete_post_meta( $post_id, $this->settings()->get_prefix() . 'settings' );
		} else {
			// Save overrides
			$clean_overrides = array_map( 'wp_validate_boolean', $new_overrides );
			update_post_meta( $post_id, $this->settings()->get_prefix() . 'overrides', $clean_overrides );

			// Save only settings with a corresponding active override
			$clean_settings = array();
			foreach ( $clean_overrides as $setting_id => $value ) {
				if ( ! isset( $new_settings[ $setting_id ] ) ) {
					$clean_settings[ $setting_id ] = false;
				} else {
					$clean_settings[ $setting_id ] = $this->theme()->thememod()->sanitize_value( $new_settings[ $setting_id ], $setting_id, 'database' );
				}
			}
			update_post_meta( $post_id, $this->settings()->get_prefix() . 'settings', $clean_settings );
		}
	}

	/**
	 * Render a heading for a metabox control.
	 *
	 * @since 1.5.1.
	 *
	 * @param string $label    The content of the heading.
	 * @param string $class    Optional classes to add to the list item.
	 *
	 * @return void
	 */
	public function control_heading( $label, $class = '' ) {
		?>
		<li class="ttfmp-perpage-header <?php echo esc_attr( $class ); ?>"><?php echo esc_html( $label ); ?></li>
	<?php
	}

	/**
	 * Render a metabox list item containing controls.
	 *
	 * @since 1.5.1.
	 *
	 * @param WP_Post $post          The current post object.
	 * @param string  $type          The type of control to render.
	 * @param string  $setting_id    The setting key.
	 * @param string  $label         The label for a checkbox control.
	 * @param string  $class         Optional classes to add to the list item.
	 *
	 * @return void
	 */
	public function control_item( WP_Post $post, $type, $setting_id, $label = '', $class = '' ) {
		$overrides = $this->settings()->get_post_overrides( $post );
		$settings  = $this->settings()->get_post_settings( $post );

		$override = $overrides[ $setting_id ];
		$value    = $settings[ $setting_id ];
		?>
		<li<?php if ( '' !== $class ) echo ' class="' . esc_attr( $class ) . '"'; ?>>
			<?php $this->control_override( $setting_id, $override ); ?>
			<?php if ( 'checkbox' === $type ) : ?>
				<?php $this->control_setting_checkbox( $setting_id, $value, $label, $override ); ?>
			<?php elseif ( 'select' === $type ) : ?>
				<?php $this->control_setting_select( $setting_id, $value, null, $override ); ?>
			<?php endif; ?>
		</li>
	<?php }

	/**
	 * Render the Override checkbox control.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $setting_id      The setting to be overridden
	 * @param bool   $value
	 *
	 * @return void
	 */
	public function control_override( $setting_id, $value ) {
		$id = $this->settings()->get_prefix() . 'overrides[' . $setting_id . ']';
		?>
		<label for="<?php echo esc_attr( $id ); ?>" class="override-label <?php echo ( $value ) ? 'active' : 'inactive'; ?>">
			<input class="screen-reader-text <?php echo esc_attr( $this->settings()->get_prefix() . 'override' ); ?>" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>" type="checkbox" <?php checked( $value ); ?> />
		</label>
	<?php
	}

	/**
	 * Render a checkbox control for a setting.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $setting_id    The setting
	 * @param bool   $value         1 = checked
	 * @param string $label         The label for the checkbox
	 * @param bool   $override      1 = true
	 *
	 * @return void
	 */
	public function control_setting_checkbox( $setting_id, $value, $label, $override ) {
		$id = $this->settings()->get_prefix() . 'settings[' . $setting_id . ']';
		?>
		<label class="selectit" for="<?php echo esc_attr( $id ); ?>">
			<input class="<?php echo esc_attr( $this->settings()->get_prefix() . 'setting' ); ?>" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>" type="checkbox" <?php checked( $value ); ?><?php if ( ! $override ) echo ' disabled="disabled"'; ?> />
			<?php echo esc_html( $label ); ?>
		</label>
	<?php
	}

	/**
	 * Render a select control for a setting.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $setting_id    The setting
	 * @param bool   $value         The value of the selected option
	 * @param string $deprecated    Deprecated parameter
	 * @param bool   $override      1 = true
	 *
	 * @return void
	 */
	public function control_setting_select( $setting_id, $value, $deprecated, $override ) {
		$id = $this->settings()->get_prefix() . 'settings[' . $setting_id . ']';
		$choices = $this->theme()->thememod()->get_choice_set( $setting_id );
		?>
		<select class="<?php echo esc_attr( $this->settings()->get_prefix() . 'setting' ); ?>" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>"<?php if ( ! $override ) echo ' disabled="disabled"'; ?>>
			<?php foreach ( $choices as $opt_value => $opt_label ) : ?>
				<option value="<?php echo esc_attr( $opt_value ); ?>"<?php selected( $opt_value, $value ); ?>><?php echo esc_html( $opt_label ); ?></option>
			<?php endforeach; ?>
		</select>
	<?php
	}

	/**
	 * Render the metabox for a post.
	 *
	 * @since 1.0.0.
	 *
	 * @param WP_Post $post    The current post.
	 *
	 * @return void
	 */
	private function render_metabox_post( WP_Post $post ) {
		?>
		<ul class="ttfmp-perpage-options">
			<?php
			$this->control_heading( __( 'Header', 'make-plus' ), 'first' );
			$this->control_item( $post, 'checkbox', 'layout-post-hide-header', __( 'Hide site header', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'header-hide-padding-bottom', __( 'Remove padding below header', 'make-plus' ) );

			$this->control_heading( __( 'Footer', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'layout-post-hide-footer', __( 'Hide site footer', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'footer-hide-padding-top', __( 'Remove padding above footer', 'make-plus' ) );

			$sidebars = $this->sidebars()->get_sidebars();
			if ( empty( $sidebars ) ) {
				$this->control_heading( __( 'Sidebars', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'layout-post-sidebar-left', __( 'Show left sidebar', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'layout-post-sidebar-right', __( 'Show right sidebar', 'make-plus' ) );
			} else {
				$this->control_heading( __( 'Left sidebar', 'make-plus' ) );
				$this->control_item( $post, 'select', 'layout-post-sidebar-left' );
				$this->control_heading( __( 'Right sidebar', 'make-plus' ) );
				$this->control_item( $post, 'select', 'layout-post-sidebar-right' );
			}

			$this->control_heading( __( 'Featured Images', 'make-plus' ) );
			$this->control_item( $post, 'select', 'layout-post-featured-images' );
			$this->control_heading( __( 'Featured Images Alignment', 'make-plus' ), 'featured-images-dependent' );
			$this->control_item( $post, 'select', 'layout-post-featured-images-alignment', '', 'featured-images-dependent' );

			$this->control_heading( __( 'Post Date', 'make-plus' ) );
			$this->control_item( $post, 'select', 'layout-post-post-date' );
			$this->control_heading( __( 'Post Date Location', 'make-plus' ), 'post-date-dependent' );
			$this->control_item( $post, 'select', 'layout-post-post-date-location', '', 'post-date-dependent' );

			$this->control_heading( __( 'Post Author', 'make-plus' ) );
			$this->control_item( $post, 'select', 'layout-post-post-author' );
			$this->control_heading( __( 'Post Author Location', 'make-plus' ), 'post-author-dependent' );
			$this->control_item( $post, 'select', 'layout-post-post-author-location', '', 'post-author-dependent' );

			$this->control_heading( __( 'Post Meta', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'layout-post-show-categories', __( 'Show categories', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'layout-post-show-tags', __( 'Show tags', 'make-plus' ) );

			$this->control_heading( __( 'Comment Count', 'make-plus' ) );
			$this->control_item( $post, 'select', 'layout-post-comment-count' );
			$this->control_heading( __( 'Comment Count Location', 'make-plus' ), 'comment-count-dependent' );
			$this->control_item( $post, 'select', 'layout-post-comment-count-location', '', 'comment-count-dependent' );

			if ( $this->theme()->integration()->has_integration( 'yoastseo' ) ) :
				$this->control_heading( __( 'Breadcrumbs', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'layout-post-yoast-breadcrumb', __( 'Show breadcrumbs', 'make-plus' ) );
			endif;
			?>
		</ul>
	<?php
	}

	/**
	 * Render the metabox for a page.
	 *
	 * @since 1.0.0.
	 *
	 * @param WP_Post $post    The current post.
	 *
	 * @return void
	 */
	private function render_metabox_page( WP_Post $post ) {
		?>
		<ul class="ttfmp-perpage-options">
			<?php
			$this->control_heading( __( 'Header', 'make-plus' ), 'first' );
			$this->control_item( $post, 'checkbox', 'layout-page-hide-header', __( 'Hide site header', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'header-hide-padding-bottom', __( 'Remove padding below header', 'make-plus' ) );

			$this->control_heading( __( 'Footer', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'layout-page-hide-footer', __( 'Hide site footer', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'footer-hide-padding-top', __( 'Remove padding above footer', 'make-plus' ) );

			$sidebars = $this->sidebars()->get_sidebars();
			if ( empty( $sidebars ) ) {
				$this->control_heading( __( 'Sidebars', 'make-plus' ), 'default-only' );
				$this->control_item( $post, 'checkbox', 'layout-page-sidebar-left', __( 'Show left sidebar', 'make-plus' ), 'default-only' );
				$this->control_item( $post, 'checkbox', 'layout-page-sidebar-right', __( 'Show right sidebar', 'make-plus' ), 'default-only' );
			} else {
				$this->control_heading( __( 'Left sidebar', 'make-plus' ), 'default-only' );
				$this->control_item( $post, 'select', 'layout-page-sidebar-left', '', 'default-only' );
				$this->control_heading( __( 'Right sidebar', 'make-plus' ), 'default-only' );
				$this->control_item( $post, 'select', 'layout-page-sidebar-right', '', 'default-only' );
			}

			$this->control_heading( __( 'Page Title', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'layout-page-hide-title', __( 'Hide title', 'make-plus' ) );

			$this->control_heading( __( 'Featured Images', 'make-plus' ), 'default-only' );
			$this->control_item( $post, 'select', 'layout-page-featured-images', '', 'default-only' );
			$this->control_heading( __( 'Featured Images Alignment', 'make-plus' ), 'featured-images-dependent default-only' );
			$this->control_item( $post, 'select', 'layout-page-featured-images-alignment', '', 'featured-images-dependent default-only' );

			$this->control_heading( __( 'Post Date', 'make-plus' ) );
			$this->control_item( $post, 'select', 'layout-page-post-date' );
			$this->control_heading( __( 'Post Date Location', 'make-plus' ), 'post-date-dependent' );
			$this->control_item( $post, 'select', 'layout-page-post-date-location', '', 'post-date-dependent' );

			$this->control_heading( __( 'Post Author', 'make-plus' ) );
			$this->control_item( $post, 'select', 'layout-page-post-author' );
			$this->control_heading( __( 'Post Author Location', 'make-plus' ), 'post-author-dependent' );
			$this->control_item( $post, 'select', 'layout-page-post-author-location', '', 'post-author-dependent' );

			$this->control_heading( __( 'Comment Count', 'make-plus' ) );
			$this->control_item( $post, 'select', 'layout-page-comment-count' );
			$this->control_heading( __( 'Comment Count Location', 'make-plus' ), 'comment-count-dependent' );
			$this->control_item( $post, 'select', 'layout-page-comment-count-location', '', 'comment-count-dependent' );

			if ( $this->theme()->integration()->has_integration( 'yoastseo' ) ) :
				$this->control_heading( __( 'Breadcrumbs', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'layout-page-yoast-breadcrumb', __( 'Show breadcrumbs', 'make-plus' ) );
			endif;
			?>
		</ul>
	<?php
	}

	/**
	 * Render the metabox for a product.
	 *
	 * @since 1.0.0.
	 *
	 * @param WP_Post $post    The current post.
	 *
	 * @return void
	 */
	private function render_metabox_product( WP_Post $post ) {
		?>
		<ul class="ttfmp-perpage-options">
			<?php
			$this->control_heading( __( 'Header', 'make-plus' ), 'first' );
			$this->control_item( $post, 'checkbox', 'layout-product-hide-header', __( 'Hide site header', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'header-hide-padding-bottom', __( 'Remove padding below header', 'make-plus' ) );

			$this->control_heading( __( 'Footer', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'layout-product-hide-footer', __( 'Hide site footer', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'footer-hide-padding-top', __( 'Remove padding above footer', 'make-plus' ) );

			$sidebars = $this->sidebars()->get_sidebars();
			if ( empty( $sidebars ) ) {
				$this->control_heading( __( 'Sidebars', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'layout-product-sidebar-left', __( 'Show left sidebar', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'layout-product-sidebar-right', __( 'Show right sidebar', 'make-plus' ) );
			} else {
				$this->control_heading( __( 'Left sidebar', 'make-plus' ) );
				$this->control_item( $post, 'select', 'layout-product-sidebar-left' );
				$this->control_heading( __( 'Right sidebar', 'make-plus' ) );
				$this->control_item( $post, 'select', 'layout-product-sidebar-right' );
			}

			if ( $this->theme()->integration()->has_integration( 'yoastseo' ) ) :
				$this->control_heading( __( 'Breadcrumbs', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'layout-product-yoast-breadcrumb', __( 'Show breadcrumbs', 'make-plus' ) );
			endif;
			?>
		</ul>
	<?php
	}
}