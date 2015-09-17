<?php
/**
 * @package Make Plus
 */

if ( ! class_exists( 'TTFMP_PerPage_Metabox' ) ) :
/**
 * Metabox-related functions.
 *
 * @since 1.0.0.
 */
class TTFMP_PerPage_Metabox {
	/**
	 * The one instance of TTFMP_PerPage_Metabox.
	 *
	 * @since 1.0.0.
	 *
	 * @var   TTFMP_PerPage_Metabox
	 */
	private static $instance;

	/**
	 * Instantiate or return the one TTFMP_PerPage_Metabox instance.
	 *
	 * @since  1.0.0.
	 *
	 * @return TTFMP_PerPage_Metabox
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Bootstrap the module
	 *
	 * @since  1.0.0.
	 *
	 * @return TTFMP_PerPage_Metabox
	 */
	public function __construct() {}

	/**
	 *
	 */
	public function init() {
		// Enqueue styles and scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Add the metabox
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );

		// Save metabox data
		add_action( 'save_post', array( $this, 'save_metabox' ), 10, 2 );
	}

	/**
	 * Enqueue Per Page scripts and styles if it is an edit screen.
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		global $typenow;
		if ( isset( $typenow ) ) {
			// Style
			wp_enqueue_style(
				ttfmp_get_perpage()->prefix . 'style',
				ttfmp_get_perpage()->url_base . '/css/per-page.css',
				array(),
				ttfmp_get_app()->version
			);
			// Script
			wp_enqueue_script(
				ttfmp_get_perpage()->prefix . 'script',
				ttfmp_get_perpage()->url_base . '/js/per-page.js',
				array( 'jquery' ),
				ttfmp_get_app()->version,
				true
			);
		}
	}

	/**
	 * Add the metabox to each qualified post type edit screen
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	public function add_metabox() {
		// Post types
		$post_types = get_post_types(
			array(
				'public' => true,
				'_builtin' => false
			)
		);
		$post_types[] = 'post';
		$post_types[] = 'page';
		$post_types = apply_filters( 'ttfmp_perpage_post_types', $post_types );

		// Add the metabox for each type
		foreach ( $post_types as $type ) {
			add_meta_box(
				ttfmp_get_perpage()->prefix . 'metabox',
				esc_html__( 'Layout Settings', 'make-plus' ),
				array( $this, 'metabox_callback' ),
				$type,
				'side',
				'default'
			);
		}
	}

	/**
	 * Wrapper for rendering the metabox.
	 *
	 * @since  1.0.0.
	 *
	 * @param  object    $post    The current post.
	 * @return void
	 */
	public function metabox_callback( $post ) {
		$view = ttfmp_get_perpage()->get_view( $post );

		// Nonce
		wp_nonce_field( basename( __FILE__ ), ttfmp_get_perpage()->prefix . 'nonce' );

		// Help blurb
		echo '<p class="howto">';
		printf(
			esc_html__( 'Check the box next to a global setting to override it.', 'make-plus' )
		);
		echo '</p>';

		// Determine appropriate render function
		if ( 'shop' === $view ) {
			$this->render_metabox_shop( $post );
		} else if ( 'product' === $view ) {
			$this->render_metabox_product( $post );
		} else if ( 'page' === $view ) {
			$this->render_metabox_page( $post );
		} else {
			$this->render_metabox_post( $post );
		}
	}

	/**
	 * Render the metabox for a post.
	 *
	 * @since  1.0.0.
	 *
	 * @param  object    $post    The current post.
	 * @return void
	 */
	private function render_metabox_post( $post ) {
		$shop_sidebar_views = get_theme_support( 'ttfmp-shop-sidebar' );
		?>
		<ul class="ttfmp-perpage-options">
			<?php
			$this->control_heading( __( 'Header, Footer, Sidebars', 'make-plus' ), 'first' );
			$this->control_item( $post, 'checkbox', 'layout-post-hide-header', __( 'Hide site header', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'layout-post-hide-footer', __( 'Hide site footer', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'layout-post-sidebar-left', __( 'Show left sidebar', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'layout-post-sidebar-right', __( 'Show right sidebar', 'make-plus' ) );

			if ( isset( $shop_sidebar_views[0] ) && in_array( 'post', (array) $shop_sidebar_views[0] ) ) :
				$this->control_heading( __( 'Shop Sidebar Location', 'make-plus' ) );
				$this->control_item( $post, 'select', 'layout-post-shop-sidebar' );
			endif;

			if ( ttfmp_get_perpage_options()->option_exists( 'header-hide-padding-bottom' ) && ttfmp_get_perpage_options()->option_exists( 'footer-hide-padding-top' ) ) :
				$this->control_heading( __( 'Padding', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'header-hide-padding-bottom', __( 'Remove padding beneath header', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'footer-hide-padding-top', __( 'Remove padding above footer', 'make-plus' ) );
			endif;

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

			if ( function_exists( 'yoast_breadcrumb' ) && function_exists( 'ttfmake_yoast_seo_breadcrumb' ) ) :
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
	 * @since  1.0.0.
	 *
	 * @param  object    $post    The current post.
	 * @return void
	 */
	private function render_metabox_page( $post ) {
		$shop_sidebar_views = get_theme_support( 'ttfmp-shop-sidebar' );
		?>
		<ul class="ttfmp-perpage-options">
			<?php
			$this->control_heading( __( 'Header, Footer, Sidebars', 'make-plus' ), 'default-only first' );
			$this->control_heading( __( 'Header, Footer', 'make-plus' ), 'builder-only first' );
			$this->control_item( $post, 'checkbox', 'layout-page-hide-header', __( 'Hide site header', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'layout-page-hide-footer', __( 'Hide site footer', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'layout-page-sidebar-left', __( 'Show left sidebar', 'make-plus' ), 'default-only' );
			$this->control_item( $post, 'checkbox', 'layout-page-sidebar-right', __( 'Show right sidebar', 'make-plus' ), 'default-only' );

			if ( isset( $shop_sidebar_views[0] ) && in_array( 'page', (array) $shop_sidebar_views[0] ) ) :
				$this->control_heading( __( 'Shop Sidebar Location', 'make-plus' ), 'default-only' );
				$this->control_item( $post, 'select', 'layout-page-shop-sidebar', '', 'default-only' );
			endif;

			if ( ttfmp_get_perpage_options()->option_exists( 'header-hide-padding-bottom' ) && ttfmp_get_perpage_options()->option_exists( 'footer-hide-padding-top' ) ) :
				$this->control_heading( __( 'Padding', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'header-hide-padding-bottom', __( 'Remove padding beneath header', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'footer-hide-padding-top', __( 'Remove padding above footer', 'make-plus' ) );
			endif;

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

			if ( function_exists( 'yoast_breadcrumb' ) && function_exists( 'ttfmake_yoast_seo_breadcrumb' ) ) :
				$this->control_heading( __( 'Breadcrumbs', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'layout-page-yoast-breadcrumb', __( 'Show breadcrumbs', 'make-plus' ) );
			endif;
			?>
		</ul>
	<?php
	}

	/**
	 * Render the metabox for a shop page.
	 *
	 * @since  1.5.1.
	 *
	 * @param  object    $post    The current post.
	 * @return void
	 */
	private function render_metabox_shop( $post ) {
		$shop_sidebar_views = get_theme_support( 'ttfmp-shop-sidebar' );
		?>
		<ul class="ttfmp-perpage-options">
			<?php
			$this->control_heading( __( 'Header, Footer, Sidebars', 'make-plus' ), 'first' );
			$this->control_item( $post, 'checkbox', 'layout-shop-hide-header', __( 'Hide site header', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'layout-shop-hide-footer', __( 'Hide site footer', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'layout-shop-sidebar-left', __( 'Show left sidebar', 'make-plus' ), 'default-only' );
			$this->control_item( $post, 'checkbox', 'layout-shop-sidebar-right', __( 'Show right sidebar', 'make-plus' ), 'default-only' );

			if ( isset( $shop_sidebar_views[0] ) && in_array( 'shop', (array) $shop_sidebar_views[0] ) ) :
				$this->control_heading( __( 'Shop Sidebar Location', 'make-plus' ) );
				$this->control_item( $post, 'select', 'layout-shop-shop-sidebar' );
			endif;

			if ( ttfmp_get_perpage_options()->option_exists( 'header-hide-padding-bottom' ) && ttfmp_get_perpage_options()->option_exists( 'footer-hide-padding-top' ) ) :
				$this->control_heading( __( 'Padding', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'header-hide-padding-bottom', __( 'Remove padding beneath header', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'footer-hide-padding-top', __( 'Remove padding above footer', 'make-plus' ) );
			endif;

			if ( function_exists( 'yoast_breadcrumb' ) && function_exists( 'ttfmake_yoast_seo_breadcrumb' ) ) :
				$this->control_heading( __( 'Breadcrumbs', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'layout-shop-yoast-breadcrumb', __( 'Show breadcrumbs', 'make-plus' ) );
			endif;
			?>
		</ul>
	<?php
	}

	/**
	 * Render the metabox for a product.
	 *
	 * @since  1.0.0.
	 *
	 * @param  object    $post    The current post.
	 * @return void
	 */
	private function render_metabox_product( $post ) {
		$shop_sidebar_views = get_theme_support( 'ttfmp-shop-sidebar' );
		?>
		<ul class="ttfmp-perpage-options">
			<?php
			$this->control_heading( __( 'Header, Footer, Sidebars', 'make-plus' ), 'first' );
			$this->control_item( $post, 'checkbox', 'layout-product-hide-header', __( 'Hide site header', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'layout-product-hide-footer', __( 'Hide site footer', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'layout-product-sidebar-left', __( 'Show left sidebar', 'make-plus' ) );
			$this->control_item( $post, 'checkbox', 'layout-product-sidebar-right', __( 'Show right sidebar', 'make-plus' ) );

			if ( isset( $shop_sidebar_views[0] ) && in_array( 'product', (array) $shop_sidebar_views[0] ) ) :
				$this->control_heading( __( 'Shop Sidebar Location', 'make-plus' ) );
				$this->control_item( $post, 'select', 'layout-product-shop-sidebar' );
			endif;

			if ( ttfmp_get_perpage_options()->option_exists( 'header-hide-padding-bottom' ) && ttfmp_get_perpage_options()->option_exists( 'footer-hide-padding-top' ) ) :
				$this->control_heading( __( 'Padding', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'header-hide-padding-bottom', __( 'Remove padding beneath header', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'footer-hide-padding-top', __( 'Remove padding above footer', 'make-plus' ) );
			endif;

			if ( function_exists( 'yoast_breadcrumb' ) && function_exists( 'ttfmake_yoast_seo_breadcrumb' ) ) :
				$this->control_heading( __( 'Breadcrumbs', 'make-plus' ) );
				$this->control_item( $post, 'checkbox', 'layout-product-yoast-breadcrumb', __( 'Show breadcrumbs', 'make-plus' ) );
			endif;
			?>
		</ul>
	<?php
	}

	/**
	 * Render a heading for a metabox control.
	 *
	 * @since 1.5.1.
	 *
	 * @param string    $label    The content of the heading.
	 * @param string    $class    Optional classes to add to the list item.
	 *
	 * @return void
	 */
	private function control_heading( $label, $class = '' ) { ?>
		<li class="ttfmp-perpage-header <?php echo esc_attr( $class ); ?>"><?php echo ttfmake_sanitize_text( $label ); ?></li>
	<?php }

	/**
	 * Render a metabox list item containing controls.
	 *
	 * @since 1.5.1.
	 *
	 * @param object    $post     The current post object.
	 * @param string    $type     The type of control to render.
	 * @param string    $key      The setting key.
	 * @param string    $label    The label for a checkbox control.
	 * @param string    $class    Optional classes to add to the list item.
	 *
	 * @return void
	 */
	private function control_item( $post, $type, $key, $label = '', $class = '' ) {
		$view = ttfmp_get_perpage()->get_view( $post );

		$overrides = ttfmp_get_perpage_options()->get_post_overrides( $post );
		$settings = ttfmp_get_perpage_options()->get_post_settings( $post );

		$override = absint( $overrides[ $key ] );
		$value    = ttfmp_get_perpage_options()->sanitize_post_meta( $key, $settings[ $key ], $view );
		?>
		<li<?php if ( '' !== $class ) echo ' class="' . esc_attr( $class ) . '"'; ?>>
			<?php $this->control_override( $key, $override ); ?>
			<?php if ( 'checkbox' === $type ) : ?>
				<?php $this->control_setting_checkbox( $key, $value, $label, $override ); ?>
			<?php elseif ( 'select' === $type ) : ?>
				<?php $this->control_setting_select( $key, $value, null, $override ); ?>
			<?php endif; ?>
		</li>
	<?php }

	/**
	 * Render the Override checkbox control.
	 *
	 * @since  1.0.0.
	 *
	 * @param  string    $key      The setting to be overridden
	 * @param  bool      $value    1 = checked
	 * @return void
	 */
	private function control_override( $key, $value ) {
		$id = ttfmp_get_perpage()->prefix . 'overrides[' . $key . ']';
		?>
		<label for="<?php echo esc_attr( $id ); ?>">
			<input class="<?php echo esc_attr( ttfmp_get_perpage()->prefix . 'override' ); ?>" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>" type="checkbox" value="1" <?php checked( $value ); ?> />
		</label>
	<?php
	}

	/**
	 * Render a checkbox control for a setting.
	 *
	 * @since  1.0.0.
	 *
	 * @param  string    $key         The setting
	 * @param  bool      $value       1 = checked
	 * @param  string    $label       The label for the checkbox
	 * @param  bool      $override    1 = true
	 * @return void
	 */
	private function control_setting_checkbox( $key, $value, $label, $override ) {
		$id = ttfmp_get_perpage()->prefix . 'settings[' . $key . ']';
		?>
		<label class="selectit" for="<?php echo esc_attr( $id ); ?>">
			<input class="<?php echo esc_attr( ttfmp_get_perpage()->prefix . 'setting' ); ?>" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>" type="checkbox" value="1" <?php checked( $value ); ?><?php if ( ! $override ) echo ' disabled="disabled"'; ?> />
			<?php echo esc_html( $label ); ?>
		</label>
	<?php
	}

	/**
	 * Render a select control for a setting.
	 *
	 * @since  1.0.0.
	 *
	 * @param  string    $key         The setting
	 * @param  bool      $value       The value of the selected option
	 * @param  string    $deprecated  Deprecated parameter
	 * @param  bool      $override    1 = true
	 * @return void
	 */
	private function control_setting_select( $key, $value, $deprecated, $override ) {
		$id = ttfmp_get_perpage()->prefix . 'settings[' . $key . ']';
		$choices = ttfmake_get_choices( $key );
		?>
		<select class="<?php echo esc_attr( ttfmp_get_perpage()->prefix . 'setting' ); ?>" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>"<?php if ( ! $override ) echo ' disabled="disabled"'; ?>>
			<?php foreach ( $choices as $opt_value => $opt_label ) : ?>
			<option value="<?php echo esc_attr( $opt_value ); ?>"<?php selected( $opt_value, $value ); ?>><?php echo esc_html( $opt_label ); ?></option>
			<?php endforeach; ?>
		</select>
	<?php
	}

	/**
	 * Sanitize and save the submitted Per Page post meta data
	 *
	 * @since 1.0.0
	 *
	 * @param int       $post_id    The post ID
	 * @param object    $post       The post object
	 * @return void
	 */
	public function save_metabox( $post_id, $post ) {
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$nonce_key = ttfmp_get_perpage()->prefix . 'nonce';
		$is_valid_nonce = ( isset( $_POST[ $nonce_key ] ) && wp_verify_nonce( $_POST[ $nonce_key ], basename( __FILE__ ) ) ) ? 'true' : 'false';

		// Exits script depending on save status
		if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
			return;
		}

		// Get $_POST arrays
		$new_overrides = ( isset( $_POST[ ttfmp_get_perpage()->prefix . 'overrides' ] ) ) ? $_POST[ ttfmp_get_perpage()->prefix . 'overrides' ] : false;
		$new_settings = ( isset( $_POST[ ttfmp_get_perpage()->prefix . 'settings' ] ) ) ? $_POST[ ttfmp_get_perpage()->prefix . 'settings' ] : false;

		if ( false === $new_overrides ) {
			// Nothing is overridden, so reset both post meta arrays
			delete_post_meta( $post_id, ttfmp_get_perpage()->prefix . 'overrides' );
			delete_post_meta( $post_id, ttfmp_get_perpage()->prefix . 'settings' );
		} else {
			$view = ttfmp_get_perpage()->get_view( $post );

			// Save overrides
			$clean_overrides = array_fill_keys( array_keys( array_map( 'absint', $new_overrides ), 1, true ), 1 );
			update_post_meta( $post_id, ttfmp_get_perpage()->prefix . 'overrides', $clean_overrides );

			// Save only settings with a corresponding active override
			$clean_settings = array();
			foreach ( $clean_overrides as $key => $value ) {
				if ( ! isset( $new_settings[$key] ) ) {
					$clean_settings[$key] = 0;
				} else {
					$clean_settings[$key] = ttfmp_get_perpage_options()->sanitize_post_meta( $key, $new_settings[$key], $view );
				}
			}
			update_post_meta( $post_id, ttfmp_get_perpage()->prefix . 'settings', $clean_settings );
		}
	}
}
endif;

if ( ! function_exists( 'ttfmp_get_perpage_metabox' ) ) :
/**
 * Instantiate or return the one TTFMP_PerPage_Metabox instance.
 *
 * @since  1.0.0.
 *
 * @return TTFMP_PerPage_Metabox
 */
function ttfmp_get_perpage_metabox() {
	return TTFMP_PerPage_Metabox::instance();
}
endif;

ttfmp_get_perpage_metabox()->init();
