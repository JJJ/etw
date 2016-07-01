<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Integration_Jetpack
 *
 * @since 1.7.0.
 */
class MAKE_Integration_Jetpack extends MAKE_Util_Modules implements MAKE_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'thememod' => 'MAKE_Settings_ThemeModInterface',
		'view'     => 'MAKE_Layout_ViewInterface',
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

		// Theme support
		add_action( 'after_setup_theme', array( $this, 'theme_support' ) );

		// Infinite Scroll footer widgets
		add_filter( 'infinite_scroll_has_footer_widgets', array( $this, 'infinite_scroll_has_footer_widgets' ) );

		// Remove default sharing buttons location
		add_action( 'loop_start', array( $this, 'remove_sharing' ) );

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
	 * Add theme support for various Jetpack features.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function theme_support() {
		// Only run this in the proper hook context.
		if ( 'after_setup_theme' !== current_action() ) {
			return;
		}

		// Infinite Scroll
		add_theme_support( 'infinite-scroll', array(
			'container'       => 'site-main',
			'footer'          => 'site-footer',
			'footer_callback' => array( $this, 'infinite_scroll_footer_callback' ),
			'footer_widgets'  => array( 'footer-1', 'footer-2', 'footer-3', 'footer-4' ),
			'render'          => array( $this, 'infinite_scroll_render' )
		) );
	}

	/**
	 * Callback to render the special footer added by Infinite Scroll.
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	public function infinite_scroll_footer_callback() {
		$footer_layout = $this->thememod()->get_value( 'footer-layout' );
		?>
		<div id="infinite-footer">
			<footer class="site-footer footer-layout-<?php echo esc_attr( $footer_layout ); ?>" role="contentinfo">
				<div class="infinite-footer-container">
					<?php get_template_part( 'partials/footer', 'credit' ); ?>
				</div>
			</footer>
		</div>
		<?php
	}

	/**
	 * Determine whether any footer widgets are actually showing.
	 *
	 * @since  1.0.0.
	 *
	 * @return bool    Whether or not infinite scroll has footer widgets.
	 */
	public function infinite_scroll_has_footer_widgets() {
		// Only run this in the proper hook context.
		if ( 'infinite_scroll_has_footer_widgets' !== current_filter() ) {
			return false;
		}

		// Get the view
		$view = $this->view()->get_current_view();

		// Get the relevant options
		$hide_footer  = $this->thememod()->get_value( 'layout-' . $view . '-hide-footer' );
		$widget_areas = $this->thememod()->get_value( 'footer-widget-areas' );

		// No widget areas are visible
		if ( true === $hide_footer || $widget_areas < 1 ) {
			return false;
		}

		// Check for active widgets in visible widget areas
		$i = 1;
		while ( $i <= $widget_areas ) {
			if ( is_active_sidebar( 'footer-' . $i ) ) {
				return true;
			}
			$i++;
		}

		// Still here? No footer widgets.
		return false;
	}

	/**
	 * Render the additional posts added by Infinite Scroll
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	public function infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'partials/content', 'archive' );
		}
	}

	/**
	 * Remove the Jetpack Sharing output from the end of the post content so it can be output elsewhere.
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	public function remove_sharing() {
		remove_filter( 'the_content', 'sharing_display', 19 );
		remove_filter( 'the_excerpt', 'sharing_display', 19 );
		if ( class_exists( 'Jetpack_Likes' ) ) {
			remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
		}
	}
}