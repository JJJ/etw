<?php
/**
 *
 */

/**
 * Class MAKEPLUS_Component_WidgetAreas_Setup
 *
 * Enable columns in the Columns section of the Builder to be converted into widget areas.
 *
 * @since 1.0.0.
 * @since 1.7.0. Changed class name from TTFMP_Widget_Area, merged in TTFMP_Sidebar_Management
 */
final class MAKEPLUS_Component_WidgetAreas_Setup extends MAKEPLUS_Util_Modules implements MAKEPLUS_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'mode' => 'MAKEPLUS_Setup_ModeInterface',
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
	 * MAKEPLUS_Component_WidgetAreas_Setup constructor.
	 *
	 * @since 1.7.4.
	 *
	 * @param MAKEPLUS_APIInterface|null $api
	 * @param array                      $modules
	 */
	public function __construct( MAKEPLUS_APIInterface $api = null, array $modules = array() ) {
		// Load dependencies.
		parent::__construct( $api, $modules );

		// Add the Make API if it's available
		if ( $this->mode()->has_make_api() ) {
			$this->add_module( 'theme', Make() );
		}
	}

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

		// Passive mode. Only enable the shortcode.
		if ( 'active' !== $this->mode()->get_mode() ) {
			// Set up the shortcode
			add_shortcode( 'ttfmp_widget_area', array( $this, 'widget_area' ) );
		}
		// Full functionality.
		else {
			// Add the JS/CSS
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ), 20 );

			// Add dynamic styles
			add_action( 'make_style_loaded', array( $this, 'add_style' ), 50 );

			// Add inputs before the text section
			add_action( 'make_section_text_before_column', array( $this, 'section_text_before_column' ), 10, 2 );

			// Add button for widget area in Make 1.4.0+
			add_filter( 'make_column_buttons', array( $this, 'make_column_buttons' ) );

			// Add content after the column
			add_action( 'make_section_text_after_column', array( $this, 'section_text_after_column' ), 10, 2 );

			// Add more data to the save data routine
			add_filter( 'make_prepare_data_section', array( $this, 'prepare_data_section' ), 10, 3 );

			// Replace content with shortcode when saving the post content
			add_filter( 'make_insert_post_data_sections', array( $this, 'insert_post_data_sections' ) );

			// Save widgets
			add_action( 'save_post', array( $this, 'save_widget_data' ), 10, 2 );

			// Set up the shortcode
			add_shortcode( 'ttfmp_widget_area', array( $this, 'widget_area' ) );

			// For each stored sidebar, register a WordPress sidebar
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );

			// Delete sidebars when a widget area is removed
			add_action( 'deleted_post_meta', array( $this, 'deleted_post_meta' ), 10, 4 );

			// Delete sidebars when a text column is updated
			add_action( 'updated_post_meta', array( $this, 'updated_post_meta' ), 10, 4 );

			// Delete sidebars when a post is deleted
			add_action( 'after_delete_post', array( $this, 'after_delete_post' ) );
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
	 * Test whether widgets are editable.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	private function can_edit_widgets() {
		return current_user_can( 'edit_theme_options' );
	}

	/**
	 * Add JS/CSS on page edit screen.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action admin_enqueue_scripts
	 *
	 * @param string $hook_suffix    The current page slug.
	 *
	 * @return void
	 */
	public function admin_enqueue( $hook_suffix ) {
		// Have to be careful with this test because this function was introduced in Make 1.2.0.
		$post_type_supports_builder = ( function_exists( 'ttfmake_post_type_supports_builder' ) ) ? ttfmake_post_type_supports_builder( get_post_type() ) : false;

		if (
			in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) )
			&&
			( $post_type_supports_builder || ( 'page' === get_post_type() ) )
		) {
			wp_enqueue_style(
				'makeplus-widgetareas-sections',
				makeplus_get_plugin_directory_uri() . 'css/widgetareas/sections.css',
				array(),
				MAKEPLUS_VERSION
			);

			wp_enqueue_script(
				'makeplus-widgetareas-admin',
				makeplus_get_plugin_directory_uri() . 'js/widgetareas/admin.js',
				array( 'jquery' ),
				MAKEPLUS_VERSION,
				true
			);

			wp_localize_script(
				'makeplus-widgetareas-admin',
				'ttfmpWidgetArea',
				array(
					'widgetAreaString' => __( 'Convert to widget area', 'make-plus' ),
					'textColumnString' => __( 'Revert to column', 'make-plus' ),
				)
			);
		}
	}

	/**
	 * Enqueue styles and scripts for Columns widget areas.
	 *
	 * @since 1.7.4.
	 *
	 * @hooked action wp_enqueue_scripts
	 *
	 * @return void
	 */
	public function frontend_enqueue() {
		$load = false;

		// Check for a Builder section
		if ( function_exists( 'ttfmake_is_builder_page' ) && ttfmake_is_builder_page() ) {
			$sections = ttfmake_get_section_data( get_the_ID() );
			if ( ! empty( $sections ) ) {
				// Parse the sections included on the page.
				$section_types = wp_list_pluck( $sections, 'section-type' );
				$matched_sections = array_keys( $section_types, 'text' );

				// Only enqueue if there is at least one Columns section.
				if ( ! empty( $matched_sections ) ) {
					$load = true;
				}
			}
		}

		// Check for passive mode
		if ( 'active' !== $this->mode()->get_mode() ) {
			$load = true;
		}

		// Enqueue the stylesheet
		if ( true === $load ) {
			wp_enqueue_style(
				'makeplus-widgetareas-frontend',
				makeplus_get_plugin_directory_uri() . 'css/widgetareas/frontend.css',
				array(),
				MAKEPLUS_VERSION,
				'all'
			);

			// If current theme is a child theme of Make, load the Posts List stylesheet
			// before the child theme stylesheet so styles can be customized.
			if ( $this->has_module( 'theme' ) && is_child_theme() ) {
				$this->theme()->scripts()->add_dependency( 'make-main', 'makeplus-widgetareas-frontend', 'style' );
			}
		}
	}

	/**
	 *
	 *
	 * @since 1.7.4.
	 *
	 * @hooked action make_style_loaded
	 *
	 * @param MAKE_Style_ManagerInterface $style
	 */
	public function add_style( MAKE_Style_ManagerInterface $style ) {
		$is_style_preview = isset( $_POST['make-preview'] );

		// Widget body
		$element = 'body';
		$selectors = array( '.builder-text-content .widget' );
		$declarations = $style->helper()->parse_font_properties( $element, $is_style_preview );
		if ( ! empty( $declarations ) ) {
			$style->css()->add( array( 'selectors' => $selectors, 'declarations' => $declarations, ) );
		}
		$link_rule = $style->helper()->parse_link_underline( $element, array( 'a' ), $is_style_preview );
		if ( ! empty( $link_rule ) ) {
			$style->css()->add( $link_rule );
		}
		// Links
		if ( $is_style_preview || ! $style->thememod()->is_default( 'font-weight-body-link' ) ) {
			$style->css()->add( array(
				'selectors'    => array( '.builder-text-content .widget a' ),
				'declarations' => array(
					'font-weight' => $style->thememod()->get_value( 'font-weight-body-link', 'style' ),
				)
			) );
		}

		// Widget title
		$element = 'h4';
		$selectors = array( '.builder-text-content .widget-title' );
		$declarations = $style->helper()->parse_font_properties( $element, $is_style_preview );
		if ( ! empty( $declarations ) ) {
			$style->css()->add( array( 'selectors' => $selectors, 'declarations' => $declarations, ) );
		}
		$link_rule = $style->helper()->parse_link_underline( $element, array( '.builder-text-content .widget-title a' ), $is_style_preview );
		if ( ! empty( $link_rule ) ) {
			$style->css()->add( $link_rule );
		}
	}

	/**
	 * Add button to turn column into widget area.
	 *
	 * Backcompat for versions of Make < 1.4
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action make_section_text_before_column
	 *
	 * @param array  $data             The section's data.
	 * @param string $column_number    The column number.
	 *
	 * @return void
	 */
	public function section_text_before_column( $data, $column_number ) {
		global $ttfmake_is_js_template;

		$section_name  = ttfmake_get_section_name( $data, $ttfmake_is_js_template );
		$section_name .= '[columns][' . $column_number . ']';
		$widget_area   = ( isset( $data['data']['columns'][ $column_number ]['widget-area'] ) ) ? $data['data']['columns'][ $column_number ]['widget-area'] : 0;
		$class         = ( 1 === (int) $widget_area ) ? 'active' : 'inactive';

		// Only show the button for Make versions less than 1.4.0.
		if ( true === $this->can_edit_widgets() && true === version_compare( $this->mode()->get_make_version(), '1.4.0', '<' ) ) : ?>
			<a href="#" class="ttfmp-create-widget-area button button-small widefat">
				<?php if ( 1 === (int) $widget_area ) : ?>
					<?php esc_html_e( 'Revert to regular column', 'make-plus' ); ?>
				<?php else : ?>
					<?php esc_html_e( 'Convert to widget area', 'make-plus' ); ?>
				<?php endif; ?>
			</a>
		<?php endif; ?>
		<div class="ttfmp-widget-area-overlay-region ttfmp-widget-area-overlay-region-<?php echo esc_attr( $class ); ?>">
		<input type="hidden" class="ttfmp-text-widget-area" name="<?php echo esc_attr( $section_name ); ?>[widget-area]" value="<?php echo absint( $widget_area ); ?>" />
		<?php
	}

	/**
	 * Add the convert to widget area button to the builder.
	 *
	 * @since 1.4.0.
	 *
	 * @hooked filter make_column_buttons
	 *
	 * @param array $column_buttons    The list of buttons for the column.
	 *
	 * @return array                   The modified list of buttons.
	 */
	public function make_column_buttons( $column_buttons ) {
		if ( true === $this->can_edit_widgets() ) {
			$column_buttons[300] = array(
				'label' => __( 'Convert text column to widget area', 'make-plus' ),
				'href'  => '#',
				'class' => 'convert-widget-area-link ttfmp-create-widget-area',
				'title' => __( 'Convert to widget area', 'make-plus' ),
			);
		}

		return $column_buttons;
	}

	/**
	 * Add content below text columns.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action make_section_text_after_column
	 *
	 * @param array  $data             The section data.
	 * @param string $column_number    The column number.
	 *
	 * @return void
	 */
	public function section_text_after_column( $data, $column_number ) {
		global $ttfmake_is_js_template;

		$section_name  = ttfmake_get_section_name( $data, $ttfmake_is_js_template );
		$section_name .= '[columns][' . $column_number . ']';
		$sidebar_label = ( isset( $data['data']['columns'][ $column_number ]['sidebar-label'] ) ) ? $data['data']['columns'][ $column_number ]['sidebar-label'] : '';
		$order         = array();

		// Get the sidebar widgets
		if ( true !== $ttfmake_is_js_template ) {
			// Get the sidebar ID
			$page_id    = ( get_post() ) ? get_the_ID() : 0;
			$section_id = $data['data']['id'];
			$sidebar_id = 'ttfmp-' . $page_id . '-' . $section_id . '-' . $column_number;

			// Get the data needed for display
			$widget_data = $this->get_widget_data_for_display( $sidebar_id );

			// Parse out the ordering data
			foreach ( $widget_data as $widget ) {
				$order[] = $widget['id'];
			}
		}

		// Get the Customizer url
		$customize_url = add_query_arg( 'return', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), admin_url( 'customize.php' ) );
		if ( false !== $permalink = get_permalink() ) {
			$customize_url = add_query_arg( 'url', urlencode( wp_unslash( $permalink ) ), $customize_url );
		}
		?>
		<div class="ttfmp-widget-area-overlay">
			<div class="ttfmp-widget-area-display">
				<div class="ttfmake-titlediv">
					<?php if ( true === $this->can_edit_widgets() ) : ?>
						<input placeholder="<?php esc_attr_e( 'Enter name here', 'make-plus' ); ?>" type="text" name="<?php echo $section_name; ?>[sidebar-label]" class="ttfmake-title" value="<?php echo sanitize_text_field( $sidebar_label ); ?>" autocomplete="off" />
						<a href="#" class="ttfmp-revert-widget-area ttfmp-create-widget-area" title="<?php esc_attr_e( 'Revert to column', 'make-plus' ); ?>">
							<span>
								<?php esc_html_e( 'Revert to column', 'make-plus' ); ?>
							</span>
						</a>
					<?php else : ?>
						<input disabled="disabled" type="text" class="ttfmake-title" value="<?php echo sanitize_text_field( $sidebar_label ); ?>" />
					<?php endif; ?>
				</div>

				<div class="ttfmp-widget-area-text">
					<?php if ( true === $ttfmake_is_js_template || ! isset( $widget_data ) || empty( $widget_data ) ) : ?>
						<p>
							<?php
							esc_html_e( 'No widgets added yet.', 'make-plus' );
							if ( true === $this->can_edit_widgets() ) :
								echo ' ';
								printf(
								// Translators: %s is a placeholder for a link to the Customizer
									esc_html__( 'To add widgets, save this page, then go to the %s.', 'make-plus' ),
									sprintf(
										'<a href="%1$s">%2$s</a>',
										esc_url( $customize_url ),
										esc_html__( 'Customizer', 'make-plus' )
									)
								);
							endif;
							?>
						</p>
					<?php elseif ( isset( $widget_data ) && ! empty( $widget_data ) ): ?>
						<p>
							<?php
							if ( true === $this->can_edit_widgets() ) :
								printf(
								// Translators: %s is a placeholder for a link to the Customizer
									esc_html__( 'To add new widgets, please go to the %s.', 'make-plus' ),
									sprintf(
										'<a href="%1$s">%2$s</a>',
										esc_url( $customize_url ),
										esc_html__( 'Customizer', 'make-plus' )
									)
								);
							endif;
							?>
						</p>
						<ul class="ttfmp-widget-list<?php if ( true === $this->can_edit_widgets() ) echo ' ttfmp-widget-list-sortable'; ?>">
							<?php foreach ( $widget_data as $widget ) : ?>
								<li data-id="<?php echo esc_attr( $widget['id'] ); ?>">
									<?php if ( true === $this->can_edit_widgets() ) : ?>
										<div title="<?php esc_attr_e( 'Drag-and-drop this widget into place', 'make-plus' ); ?>" class="ttfmake-sortable-handle">
											<div class="sortable-background"></div>
										</div>
									<?php endif; ?>
									<div class="ttfmp-widget-list-container">
										<span class="ttfmp-widget-list-type"><?php echo wp_strip_all_tags( $widget['type'] ); ?></span><?php if ( '' !== $widget['title'] ) : ?>: <span class="ttfmp-widget-list-title"><?php echo wp_strip_all_tags( $widget['title'] ); ?></span><?php endif; ?>
										<?php if ( true === $this->can_edit_widgets() ) : ?>
											<a href="#" class="edit-widget-link ttfmake-overlay-open" data-overlay="#ttfmake-overlay-<?php echo esc_attr( $widget['id'] ); ?>" title="<?php esc_attr_e( 'Configure widget', 'make-plus' ); ?>">
											<span>
												<?php esc_html_e( 'Configure widget', 'make-plus' ); ?>
											</span>
											</a>
											<a href="#" class="remove-widget-link ttfmake-widget-remove" title="<?php esc_attr_e( 'Delete widget', 'make-plus' ); ?>">
											<span>
												<?php esc_html_e( 'Delete widget', 'make-plus' ); ?>
											</span>
											</a>
										<?php endif; ?>
									</div>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
				<input class="widgets" type="hidden" name="<?php echo $section_name; ?>[widgets]" value="<?php echo implode( ',', $order ); ?>" />
			</div>
		</div>
		<?php if ( isset( $widget_data ) && ! empty( $widget_data ) ) : ?>
			<?php foreach ( $widget_data as $widget ) : ?>
				<?php echo $this->overlay_template( $widget['form'], $widget['id_base'], $widget['id'], $widget['type'] ); ?>
			<?php endforeach; ?>
		<?php endif; ?>
		</div>
	<?php
	}

	/**
	 * Get the template for displaying a widget form.
	 *
	 * @since 1.4.1
	 *
	 * @param string $form       The HTML for the widget form.
	 * @param string $id_base    The base ID for the widget.
	 * @param string $id
	 * @param string $title
	 *
	 * @return string            The overlay template for the widget form.
	 */
	private function overlay_template( $form, $id_base, $id, $title ) {
		ob_start();

		global $ttfmake_overlay_class, $ttfmake_section_data, $ttfmake_overlay_title, $ttfmake_overlay_id;

		$ttfmake_overlay_class = 'ttfmake-configuration-overlay ttfmake-widget-configuration-overlay';
		$ttfmake_overlay_title = esc_html__( 'Configure ', 'make-plus' ) . $title;
		$ttfmake_overlay_id    = 'ttfmake-overlay-' . $id;

		// Include the header
		get_template_part( '/inc/builder/core/templates/overlay', 'header' );

		// Sort the config in case 3rd party code added another input
		ksort( $ttfmake_section_data['section']['config'], SORT_NUMERIC );
		?>
		<div class="widget-form">
			<?php echo $form; ?>
			<input type="hidden" name="ttfmp-widgets[]" value="widget-<?php echo esc_attr( $id_base ); ?>" />
		</div>
		<?php

		// Include the footer
		get_template_part( '/inc/builder/core/templates/overlay', 'footer' );

		return ob_get_clean();
	}

	/**
	 * Get the data needed to display the list of widgets.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $sidebar_id    The ID of the sidebar.
	 *
	 * @return array                Array of widgets in the sidebar.
	 */
	private function get_widget_data_for_display( $sidebar_id ) {
		$widgets = $this->get_widgets_in_sidebar_instance( $sidebar_id );

		// Collector for the widget data
		$widgets_data = array();

		foreach ( $widgets as $id => $widget ) {
			$number = $widget['params'][0]['number'];

			ob_start();
			$widget['callback'][0]->form_callback( $number );
			$widget_form = ob_get_clean();

			$widgets_data[] = array(
				'type'    => $widget['name'],
				'title'   => $this->get_widget_title( $number, $widget['callback'][0]->option_name ),
				'id'      => $id,
				'number'  => $number,
				'id_base' => $widget['callback'][0]->id_base,
				'form'    => $widget_form,
			);
		}

		return $widgets_data;
	}

	/**
	 * Get information about all widgets in a sidebar.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $sidebar_id    Unique ID for the sidebar.
	 *
	 * @return array                Collection of widget IDs.
	 */
	private function get_widgets_in_sidebar_instance( $sidebar_id ) {
		global $wp_registered_widgets;

		// Collector for the widgets
		$widgets = array();

		// Attempt to find the associated widgets
		$all_sidebars = wp_get_sidebars_widgets();

		// Collect data for each registered widget
		if ( isset( $all_sidebars[ $sidebar_id ] ) ) {
			foreach ( $all_sidebars[ $sidebar_id ] as $widget_id ) {
				if ( isset( $wp_registered_widgets[ $widget_id ] ) ) {
					$widgets[ $widget_id ] = $wp_registered_widgets[ $widget_id ];
				}
			}
		}

		return $widgets;
	}

	/**
	 * Get the custom title for an individual widget instance.
	 *
	 * @since 1.0.0.
	 *
	 * @param int    $number         The widget number for a multi number widget.
	 * @param string $option_name    The option that the widget data is saved under.
	 *
	 * @return string                The title of the widget.
	 */
	private function get_widget_title( $number, $option_name ) {
		$widget_instance_data = get_option( $option_name );
		return ( isset( $widget_instance_data[ $number ]['title'] ) ) ? $widget_instance_data[ $number ]['title'] : '';
	}

	/**
	 * Append the widget area value to the data.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked filter make_prepare_data_section
	 *
	 * @param array  $clean_data       The cleaned up data.
	 * @param array  $original_data    The $_POST data for the section.
	 * @param string $section_type     The ID for the section.
	 *
	 * @return array                   The additional data.
	 */
	public function prepare_data_section( $clean_data, $original_data, $section_type ) {
		if ( 'text' === $section_type ) {
			if ( isset( $original_data['columns'] ) && is_array( $original_data['columns'] ) ) {
				foreach ( $original_data['columns'] as $id => $item ) {
					if ( isset( $item['widget-area'] ) ) {
						$clean_data['columns'][ $id ]['widget-area'] = absint( $item['widget-area'] );
					}

					if ( isset( $item['sidebar-label'] ) ) {
						$clean_data['columns'][ $id ]['sidebar-label'] = ( 0 === $clean_data['columns'][ $id ]['widget-area'] ) ? '' : esc_html( $item['sidebar-label'] );
					}

					/**
					 * Note that this value is being set merely as a method of convenience so that
					 * `insert_post_data_sections()` can access the widget data and set the proper widgets and order.
					 * DO NOT RELY ON THIS DATABASE VALUE FOR ANY OTHER PURPOSE. Since widgets can be administered in
					 * a number of places, this data will only be correct during a save routine and should otherwise be
					 * considered to be outdated. Use `wp_get_sidebars_widgets()` to get the correct values.
					 */
					if ( ! empty( $item['widgets'] ) ) {
						$clean_widgets = array();
						$widgets       = explode( ',', $item['widgets'] );

						foreach ( $widgets as $widget ) {
							$clean_widgets[] = sanitize_title( $widget );
						}

						$clean_data['columns'][ $id ]['widgets'] = $widgets;
					}
				}
			}
		}

		return $clean_data;
	}

	/**
	 * Replace the text column content if the widget area value is set.
	 *
	 * Note that this only resets the content saved to the "post_content" field in the database. It does not touch the
	 * meta data in an effort to ensure that the old values that may be reverted to are kept intact.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked filter make_insert_post_data_sections
	 *
	 * @param array $sections    The array of section data for the page.
	 *
	 * @return array             The modified section data.
	 */
	public function insert_post_data_sections( $sections ) {
		foreach ( $sections as $section_id => $section ) {
			if ( isset( $section['section-type'] ) && 'text' === $section['section-type'] ) {
				if ( isset( $section['columns'] ) ) {
					foreach ( $section['columns'] as $column_id => $column ) {
						if ( isset( $column['widget-area'] ) && 1 === (int) $column['widget-area'] ) {
							$new_contents = array(
								'title'       => '',
								'image-link'  => '',
								'image-id'    => '',
								'content'     => '[ttfmp_widget_area page_id="' . absint( get_the_ID() ) . '" section_id="' . ttfmake_get_builder_save()->clean_section_id( $section_id ) . '" column_id="' . absint( $column_id ) . '"]',
								'widget-area' => 1
							);

							$sections[ $section_id ]['columns'][ $column_id ] = array_merge( $column, $new_contents );

							// Grab the sidebar label if available
							$sidebar_label = ( isset( $sections[ $section_id ]['columns'][ $column_id ]['sidebar-label'] ) ) ? $sections[ $section_id ]['columns'][ $column_id ]['sidebar-label'] : '';

							// Register the sidebar
							// TODO
							$this->register_sidebar( get_the_ID(), $section_id, $column_id, $sidebar_label );

							// Save the current widgets in the correct order.
							$widget_area_id  = 'ttfmp-' . absint( get_the_ID() ) . '-' . ttfmake_get_builder_save()->clean_section_id( $section_id ) . '-' . absint( $column_id );
							$current_widgets = wp_get_sidebars_widgets();

							if ( isset( $column['widgets'] ) ) {
								// Set the current widgets
								$new_widgets = $column['widgets'];
							} else {
								// If there are no widgets in the column, make sure that the array is set as empty
								$new_widgets = array();
							}

							// Update the widgets array with the new widgets
							$current_widgets[ $widget_area_id ] = $new_widgets;

							// Update the widgets array
							wp_set_sidebars_widgets( $current_widgets );
						}
					}
				}
			}
		}

		return $sections;
	}

	/**
	 * Save the individual widget data
	 *
	 * @since 1.4.1.
	 *
	 * @hooked action save_post
	 *
	 * @param int     $post_id    The ID of the saved post.
	 * @param WP_Post $post       The post being saved.
	 *
	 * @return void
	 */
	public function save_widget_data( $post_id, $post ) {
		global $wp_registered_widgets;

		if ( ! isset( $_POST[ 'ttfmake-builder-nonce' ] ) || ! wp_verify_nonce( $_POST[ 'ttfmake-builder-nonce' ], 'save' ) ) {
			return;
		}

		// Don't do anything during autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Bail if user can't edit widgets
		if ( ! $this->can_edit_widgets() ) {
			return;
		}

		// Don't save data if we're not using the Builder template
		if ( ! ttfmake_will_be_builder_page() ) {
			return;
		}

		// Don't save widgets if there are none to save
		if ( ! isset( $_POST['ttfmp-widgets'] ) ) {
			return;
		}

		$widgets = array_unique( $_POST['ttfmp-widgets'] );

		foreach ( $widgets as $widget_name ) {
			if ( isset( $_POST[ $widget_name ] ) ) {
				$settings = $_POST[ $widget_name ];

				$all_instances = array();

				foreach ( $settings as $number => $new_instance ) {
					$new_instance = stripslashes_deep( $new_instance );

					if ( isset( $widget_class_instance ) ) {
						unset( $widget_class_instance );
					}

					// Get the widget instance
					$widget_id = str_replace( 'widget-', '', $widget_name . '-' . $number );

					if ( isset( $wp_registered_widgets[ $widget_id ] ) ) {
						$widget_class_instance = $wp_registered_widgets[ $widget_id ];
						$widget_class_instance = $widget_class_instance['callback'][0];

						if ( empty( $all_instances ) ) {
							$all_instances = $widget_class_instance->get_settings();
						}

						if ( $widget_class_instance->updated ) {
							break;
						}

						$widget_class_instance->_set( $number );

						$old_instance = isset( $all_instances[ $number ] ) ? $all_instances[ $number ] : array();

						$was_cache_addition_suspended = wp_suspend_cache_addition();
						if ( $widget_class_instance->is_preview() && ! $was_cache_addition_suspended ) {
							wp_suspend_cache_addition( true );
						}

						$instance = $widget_class_instance->update( $new_instance, $old_instance );

						if ( $widget_class_instance->is_preview() ) {
							wp_suspend_cache_addition( $was_cache_addition_suspended );
						}

						/**
						 * Filter a widget's settings before saving.
						 *
						 * Returning false will effectively short-circuit the widget's ability
						 * to update settings.
						 *
						 * @since 2.8.0
						 *
						 * @param array     $instance     The current widget instance's settings.
						 * @param array     $new_instance Array of new widget settings.
						 * @param array     $old_instance Array of old widget settings.
						 * @param WP_Widget $this         The current widget instance.
						 */
						$instance = apply_filters( 'widget_update_callback', $instance, $new_instance, $old_instance, $this );

						if ( false !== $instance ) {
							$all_instances[ $number ] = $instance;
						}
					}
				}
			}

			if ( isset( $widget_class_instance ) && isset( $all_instances ) ) {
				$widget_class_instance->save_settings( $all_instances );
				$widget_class_instance->updated = true;
			}
		}
	}

	/**
	 * Print the content for the widget area.
	 *
	 * @since 1.0.0.
	 *
	 * @param array $attrs    The list of attributes for the widget.
	 *
	 * @return string         The generated content for the shortcode.
	 */
	public function widget_area( $attrs ) {
		$id = 'ttfmp-' . esc_attr( $attrs['page_id'] ) . '-' . esc_attr( $attrs['section_id'] ) . '-' . esc_attr( $attrs['column_id'] );

		// Run output buffers so that the content is captured and returned
		ob_start();

		dynamic_sidebar( $id );

		return ob_get_clean();
	}

	/**
	 * For each stored sidebar, register a WordPress sidebar.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action widgets_init
	 *
	 * @return void
	 */
	public function widgets_init() {
		$sidebars = $this->get_registered_sidebars();

		if ( is_array( $sidebars ) ) {
			foreach ( $sidebars as $id => $sidebar ) {
				$pieces = $this->parse_sidebar_id( $sidebar['id'] );
				$page = get_post( $pieces['page_id'] );

				// Do not register the sidebar if the corresponding page doesn't exist or is in the trash.
				if ( $page instanceof WP_Post && 'trash' !== get_post_status( $page ) ) {
					$id = 'ttfmp-' . $sidebar['id'];

					register_sidebar( array(
						'id'            => $id,
						'name'          => stripslashes( $this->get_sidebar_title( $sidebar['id'] ) ),
						'description'   => stripslashes( $this->get_sidebar_description( $sidebar['id'] ) ),
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget'  => '</aside>',
						'before_title'  => '<h4 class="widget-title">',
						'after_title'   => '</h4>'
					) );
				}
			}
		}
	}

	/**
	 * Generate a title for the sidebar.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $id    The sidebar ID.
	 *
	 * @return string       The generated description.
	 */
	private function get_sidebar_title( $id ) {
		// Attempt to get the label from the array of registered sidebars
		$sidebar = $this->get_registered_sidebar( $id );

		if ( ! empty( $sidebar ) && isset( $sidebar['label'] ) && '' !== $sidebar['label'] ) {
			$label = esc_html( $sidebar['label'] );
		} else {
			$sidebar_information = $this->parse_sidebar_id( $id );
			$label               = esc_html__( 'Sidebar', 'make-plus' ) . ' ' . $sidebar_information['page_id'] . '-' . $sidebar_information['section_id'] . '-' . $sidebar_information['column_id'];
		}

		return $label;
	}

	/**
	 * Generate a description for the sidebar.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $id    The sidebar ID.
	 *
	 * @return string       The generated description.
	 */
	private function get_sidebar_description( $id ) {
		// Attempt to get the label from the array of registered sidebars
		$sidebar = $this->get_registered_sidebar( $id );

		if ( ! empty( $sidebar ) && isset( $sidebar['label'] ) && '' !== $sidebar['label'] ) {
			$label = esc_html( $sidebar['label'] );
		} else {
			$sidebar_information = $this->parse_sidebar_id( $id );
			$label               = $sidebar_information['page_id'] . '-' . $sidebar_information['section_id'] . '-' . $sidebar_information['column_id'];
		}

		return sprintf(
		// Translators: %s is a placeholder for the name of the sidebar.
			esc_html__( 'Add widgets to the "%s" widget area.', 'make-plus' ),
			$label
		);
	}

	/**
	 * Adds a sidebar via the component pieces.
	 *
	 * @since 1.0.0.
	 *
	 * @param int    $page_id       The ID of the page.
	 * @param string $section_id    The section ID. Value is numeric, but will be greater than the max int value.
	 * @param int    $column_id     The column number.
	 * @param string $label         The label for the sidebar.
	 *
	 * @return void
	 */
	private function register_sidebar( $page_id, $section_id, $column_id, $label ) {
		$id = absint( $page_id ) . '-' . $this->clean_section_id( $section_id ) . '-' . absint( $column_id );
		$this->add_sidebar_to_array( $id, $label );
	}

	/**
	 * Removes a sidebar via the component pieces.
	 *
	 * @since 1.0.0.
	 *
	 * @param int    $page_id       The ID of the page.
	 * @param string $section_id    The section ID. Value is numeric, but will be greater than the max int value.
	 * @param int    $column_id     The column number.
	 *
	 * @return void
	 */
	private function deregister_sidebar( $page_id, $section_id, $column_id ) {
		$id = absint( $page_id ) . '-' . $this->clean_section_id( $section_id ) . '-' . absint( $column_id );
		$this->remove_sidebar_from_array( $id );
	}

	/**
	 * Get all of the sidebars that are registered for the builder.
	 *
	 * @since 1.0.0.
	 *
	 * @return array    The list of sidebars registered for the builder.
	 */
	private function get_registered_sidebars() {
		$sidebars = get_option( 'ttfmp-builder-sidebars', false );

		if ( false === $sidebars ) {
			// Check for old theme mod
			$sidebars = get_theme_mod( 'builder-sidebars', array() );
			update_option( 'ttfmp-builder-sidebars', $sidebars );
		}

		return $sidebars;
	}

	/**
	 * Get a single sidebar from the list of registered sidebars.
	 *
	 * @since 1.0.0.
	 *
	 * @param string    $id    The sidebar ID.
	 *
	 * @return array            The sidebar.
	 */
	private function get_registered_sidebar( $id ) {
		$the_sidebar = array();
		$sidebars    = $this->get_registered_sidebars();

		if ( isset( $sidebars[ $id ] ) ) {
			$the_sidebar = $sidebars[ $id ];
		}

		return $the_sidebar;
	}

	/**
	 * Add another sidebar to the array of sidebars.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $id       The ID of the sidebar to add.
	 * @param string $label    The label for the sidebar.
	 *
	 * @return void
	 */
	private function add_sidebar_to_array( $id, $label ) {
		$sidebars = $this->get_registered_sidebars();
		$sidebars = ( is_array( $sidebars ) ) ? $sidebars : array();

		// Replace existing sidebar with new sidebar
		$sidebars[ $id ] = array(
			'id'    => $id,
			'label' => $label
		);

		$this->save_sidebars( $sidebars );
	}

	/**
	 * Remove a single sidebar by ID from the array of sidebars.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $id    The ID of the sidebar to remove.
	 *
	 * @return void
	 */
	private function remove_sidebar_from_array( $id ) {
		$sidebars = $this->get_registered_sidebars();

		if ( isset( $sidebars[ $id ] ) ) {
			unset( $sidebars[ $id ] );
			$this->save_sidebars( $sidebars );
		}
	}

	/**
	 * Save an array of sidebars to the theme mod.
	 *
	 * @since 1.0.0.
	 *
	 * @param array $sidebars    Array of sidebars to save.
	 *
	 * @return void
	 */
	private function save_sidebars( $sidebars ) {
		update_option( 'ttfmp-builder-sidebars', $sidebars );
	}

	/**
	 * Break a sidebar ID into component pieces.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $id    The sidebar ID (e.g., 4928-1251344524124-1)
	 *
	 * @return array        An array containing the page ID, section ID and column number.
	 */
	private function parse_sidebar_id( $id ) {
		$pieces = explode( '-', $id );

		if ( isset( $pieces[0] ) && isset( $pieces[1] ) && isset( $pieces[2] ) ) {
			return array(
				'page_id'    => absint( $pieces[0] ),
				'section_id' => $this->clean_section_id( $pieces[1] ),
				'column_id'  => absint( $pieces[2] ),
			);
		} else {
			return array_fill_keys( array(
				'page_id',
				'section_id',
				'column_id',
			), 0 );
		}
	}

	/**
	 * Sanitizes a string to only return numbers.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $id    The section ID.
	 *
	 * @return string       The sanitized ID.
	 */
	private function clean_section_id( $id ) {
		return preg_replace( '/[^0-9]/', '', $id );
	}

	/**
	 * When a widget area post meta value is deleted, delete the corresponding sidebar.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action deleted_post_meta
	 *
	 * @param array  $meta_ids       An array of deleted metadata entry IDs.
	 * @param int    $object_id      Object ID.
	 * @param string $meta_key       Meta key.
	 * @param mixed  $_meta_value    Meta value.
	 *
	 * @return void
	 */
	public function deleted_post_meta( $meta_ids, $object_id, $meta_key, $_meta_value ) {
		if ( $this->meta_key_is_widget_area( $meta_key ) ) {
			// Get the page ID, the section ID, and the column number, which will allow for deleting the sidebar
			$pieces     = explode( ':', $meta_key );
			$page_id    = $object_id;
			$section_id = ( isset( $pieces[1] ) ) ? $pieces[1] : 0;
			$column_id  = ( isset( $pieces[3] ) ) ? $pieces[3] : 0;

			// Remove the sidebar
			if ( $page_id > 0 && $section_id > 0 && $column_id > 0 ) {
				$this->deregister_sidebar( $page_id, $section_id, $column_id );
			}
		}
	}

	/**
	 * When a text column is updated, potentially remove a sidebar.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action updated_post_meta
	 *
	 * @param int    $meta_id        ID of updated metadata entry.
	 * @param int    $object_id      Object ID.
	 * @param string $meta_key       Meta key.
	 * @param mixed  $_meta_value    Meta value.
	 *
	 * @return void
	 */
	public function updated_post_meta( $meta_id, $object_id, $meta_key, $_meta_value ) {
		if ( $this->meta_key_is_widget_area( $meta_key ) ) {
			if ( 0 === (int) $_meta_value ) {
				// Get the page ID, the section ID, and the column number, which will allow for deleting the sidebar
				$pieces     = explode( ':', $meta_key );
				$page_id    = $object_id;
				$section_id = ( isset( $pieces[1] ) ) ? $pieces[1] : 0;
				$column_id  = ( isset( $pieces[3] ) ) ? $pieces[3] : 0;

				// Remove the sidebar
				if ( $page_id > 0 && $section_id > 0 && $column_id > 0 ) {
					$this->deregister_sidebar( $page_id, $section_id, $column_id );
				}
			}
		}
	}

	/**
	 * Removes sidebars used in a page when the page is deleted.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action after_delete_post
	 *
	 * @param int $post_id    The post ID of the post being deleted.
	 *
	 * @return void
	 */
	public function after_delete_post( $post_id ) {
		$sidebars = $this->get_registered_sidebars();

		// Iterate through sidebars, removing any with a page ID matching the deleted page's ID
		foreach ( $sidebars as $id => $sidebar ) {
			$pieces = $this->parse_sidebar_id( $sidebar['id'] );

			// Remove the sidebar if a match is found
			if ( (int) $post_id === (int) $pieces['page_id'] ) {
				$this->remove_sidebar_from_array( $id );
			}
		}
	}

	/**
	 * Determine if a meta key represents a widget area post meta value.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $key    The key to test.
	 *
	 * @return bool          True if the key is a widget area value. False if it is not.
	 */
	private function meta_key_is_widget_area( $key ) {
		$return = false;

		if ( 0 === strpos( $key, '_ttfmake:' ) ) {
			if ( false !== strpos( $key, ':widget-area' ) ) {
				$return = true;
			}
		}

		return $return;
	}
}