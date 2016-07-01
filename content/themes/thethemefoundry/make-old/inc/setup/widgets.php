<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Setup_Widgets
 *
 * @since 1.7.0.
 */
final class MAKE_Setup_Widgets extends MAKE_Util_Modules implements MAKE_Setup_WidgetsInterface, MAKE_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'error'         => 'MAKE_Error_CollectorInterface',
		'compatibility' => 'MAKE_Compatibility_MethodsInterface',
		'view'          => 'MAKE_Layout_ViewInterface',
		'thememod'      => 'MAKE_Settings_ThemeModInterface',
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

		//
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );

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


	public function get_widget_display_defaults( $sidebar_id ) {
		$widget_defaults = array(
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		);

		/**
		 * Filter: Modify the wrapper markup settings for the widgets in a sidebar.
		 *
		 * @since 1.7.0.
		 *
		 * @param array     $widget_defaults    The default widget markup for sidebars.
		 * @param string    $sidebar_id         The ID of the sidebar that the widget markup will apply to.
		 */
		return apply_filters( 'make_widget_display_defaults', $widget_defaults, $sidebar_id );
	}


	public function register_sidebars() {
		// Only run this in the proper hook context.
		if ( 'widgets_init' !== current_action() ) {
			return;
		}

		//
		$sidebars = array(
			'sidebar-left'  => __( 'Left Sidebar', 'make' ),
			'sidebar-right' => __( 'Right Sidebar', 'make' ),
			'footer-1'      => __( 'Footer 1', 'make' ),
			'footer-2'      => __( 'Footer 2', 'make' ),
			'footer-3'      => __( 'Footer 3', 'make' ),
			'footer-4'      => __( 'Footer 4', 'make' ),
		);

		//
		foreach ( $sidebars as $sidebar_id => $sidebar_name ) {
			$args = array(
				'id' => $sidebar_id,
				'name' => $sidebar_name,
				'description' => esc_html( $this->get_sidebar_description( $sidebar_id ) ),
			);

			register_sidebar( $args + $this->get_widget_display_defaults( $sidebar_id ) );
		}
	}


	private function get_sidebar_description( $sidebar_id ) {
		$description = '';

		// Footer sidebars
		if ( false !== strpos( $sidebar_id, 'footer-' ) ) {
			$column = (int) str_replace( 'footer-', '', $sidebar_id );
			$column_count = $this->thememod()->get_value( 'footer-widget-areas' );

			if ( $column > $column_count ) {
				$description = __( 'This widget area is currently disabled. Enable it in the "Footer" section of the "Layout" panel in the Customizer.', 'make' );
			}
		}
		// Other sidebars
		else if ( false !== strpos( $sidebar_id, 'sidebar-' ) ) {
			$location = str_replace( 'sidebar-', '', $sidebar_id );

			$enabled_views = $this->get_enabled_view_labels( $location );

			// Not enabled anywhere
			if ( empty( $enabled_views ) ) {
				$description = __( 'This widget area is currently disabled. Enable it in the "Layout" panel of the Customizer.', 'make' );
			}
			// List enabled views
			else {
				$description = sprintf(
					__( 'This widget area is currently enabled for the following views: %s. Change this in the "Layout" panel of the Customizer.', 'make' ),
					implode( _x( ', ', 'list item separator', 'make' ), $enabled_views )
				);
			}
		}

		return $description;
	}


	private function get_enabled_view_labels( $location ) {
		$enabled_views = array();

		$views = array_keys( $this->view()->get_sorted_views() );

		foreach ( $views as $view_id ) {
			$setting_id = 'layout-' . $view_id . '-sidebar-' . $location;
			if ( true === $this->thememod()->get_value( $setting_id ) ) {
				$enabled_views[] = $this->view()->get_view_label( $view_id );
			}
		}

		// Check for deprecated filter.
		if ( has_filter( 'make_sidebar_list_enabled' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_sidebar_list_enabled',
				'1.7.0'
			);
		}

		return $enabled_views;
	}


	public function has_sidebar( $location ) {
		// Get the view
		$view = $this->view()->get_current_view();

		// Get the relevant theme mod
		$setting_id = 'layout-' . $view . '-sidebar-' . $location;
		$has_sidebar = $this->thememod()->get_value( $setting_id );

		// Builder template doesn't support sidebars
		if ( 'template-builder.php' === get_page_template_slug() ) {
			$has_sidebar = false;
		}

		/**
		 * Filter: Dynamically change the result of the "has sidebar" check.
		 *
		 * @since 1.2.3.
		 *
		 * @param bool      $has_sidebar    Whether or not to show the sidebar.
		 * @param string    $location       The location of the sidebar being evaluated.
		 * @param string    $view           The view name.
		 */
		return apply_filters( 'make_has_sidebar', $has_sidebar, $location, $view );
	}
}